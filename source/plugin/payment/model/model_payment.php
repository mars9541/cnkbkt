<?php

if (!defined('IN_DISCUZ')) {
	exit('Access denid');
}
if (!class_exists('sql')) {
	include_once DISCUZ_ROOT.'./source/plugin/csu_base/sql.class.php';
}
if (!class_exists('csubase')) {
	include_once DISCUZ_ROOT.'./source/plugin/csu_base/csubase.class.php';
}
if (!defined('PAYMENT_METHOD_ROOT')) {
	include_once DISCUZ_ROOT.'./source/plugin/payment/util.php';
}
/**
 * 可以通过该类静态调用model_payment方法.
 */
class payment
{
	public static function __callStatic($name, $args)
	{
		return call_user_func_array([C::m('#payment#payment'), $name], $args);
	}
}
class model_payment
{
	private $order_id;

	/**
	 * 创建订单.
	 *
	 * @DateTime 2021-03-10
	 *
	 * @param string $subject     订单标题
	 * @param int    $uid         订单所属人UID
	 * @param int    $amount      金额，单位：分
	 * @param string $api_id      支付接口标识
	 * @param array  $params      额外参数，可存入商品id、数量等信息
	 * @param int    $expire_time 自订单生成开始的订单有效期
	 * @param string $body        订单内容描述，可传入商品名称、数量等信息
	 * @param string $url         订单详情页关联的链接，留空则不跳转
	 * @param string $return_url  支付成功后跳转的链接，留空则不跳转
	 * @param int    $method_rule 限制支付方式，0为黑名单模式，1为白名单模式，留空则采用后台设置
	 * @param string $method_list 限制支付方式的method_id，用多个,隔开，留空则采用后台设置
	 * @param string $create_ip   订单创建环境IP，留空则为当前IP
	 *
	 * @return string 订单号
	 */
	public function build($subject, $uid = 0, $amount = 0, $api_id = '', $params = [], $expire_time = 3600, $body = '', $url = '', $return_url = '', $method_rule = null, $method_list = null, $create_ip = '')
	{
		global $_G;
		if (is_array($subject)) {
			extract($subject); //可以直接传入array作为参数
		}
		//先判断插件是否已经注册了
		$api = sql('payment_api')
			->where('api_id', $api_id)
			->field('method_list,method_rule')
			->find()
		;
		if (!$api) {
			throw new PaymentException(lang('plugin/payment', 'error_1'), 1);
		}
		if ($amount < 0) {
			//==0的情况在支付界面是直接成功的
			throw new PaymentException(lang('plugin/payment', 'error_2'), 2);
		}
		if ($expire_time <= 0) {
			throw new PaymentException(lang('plugin/payment', 'error_3'), 3);
		}
		do {
			$order_id = dgmdate(TIMESTAMP, 'YmdHis').random(6, 1);
		} while (sql('payment_order')->where('order_id', $order_id)->exist());

		C::t('#payment#payment_order')->insert([
			'order_id' => $order_id,
			'subject' => $subject,
			'body' => $body,
			'url' => $url,
			'return_url' => $return_url,
			'uid' => $uid,
			'amount' => $amount,
			'api_id' => $api_id,
			'params' => serialize($params),
			'status' => 1,
			'create_time' => TIMESTAMP,
			'create_ip' => $create_ip ? $create_ip : $_G['clientip'],
			'expire_time' => TIMESTAMP + $expire_time,
			'method_list' => is_null($method_list) ? $api['method_list'] : $method_list,
			'method_rule' => is_null($method_rule) ? $api['method_rule'] : $method_rule,
		]);
		$this->order_id = $order_id;

		return $this->order_id;
	}

	/**
	 * 获取支付链接.
	 *
	 * @DateTime 2021-03-10
	 *
	 * @param string $order_id 订单号
	 *
	 * @return string 支付链接
	 */
	public function makeurl($order_id = '')
	{
		if (!$order_id) {
			$order_id = $this->order_id;
		}

		return 'plugin.php?id=payment:pay&order_id='.$order_id;
	}

	/**
	 * 通知订单的插件接口，仅为success或refund方法.
	 *
	 * @DateTime 2021-03-10
	 *
	 * @param mixed $order 订单
	 *
	 * @return bool 通知结果
	 */
	public function plugin_notify($order)
	{
		try {
			$result = $this->plugin_callback($order, $order['is_refund'] ? 'refund' : 'success', false);
			C::t('#payment#payment_order')->update($order['order_id'], ['plugin_status' => 1]); //更新订单信息

			return true;
		} catch (PaymentPluginException $e) {
			C::t('#payment#payment_order')->update($order['order_id'], ['plugin_status' => 2]); //更新订单信息
			$e->doParent();
		}
	}

	/**
	 * 通知插件接口.
	 *
	 * @DateTime 2021-03-10
	 *
	 * @param mixed  $order        订单
	 * @param string $method       插件接口方法
	 * @param bool   $ignore_exist 是否允许方法不存在
	 *
	 * @return bool 通知结果
	 */
	public function plugin_callback($order, $method, $ignore_exist = true)
	{
		try {
			$api_id = $order['api_id'];
			$api = C::t('#payment#payment_api')->fetch($api_id);
			if (!$api) {
				throw new PaymentException(lang('plugin/payment', 'api_not_register'), 1013);
			}
			if (!class_exists($api_id, false)) {
				include_once DISCUZ_ROOT.'./'.$api['filename'];
			}
			$api_class = new $api_id($order);
			if (!method_exists($api_class, $method)) {
				if ($ignore_exist) {
					$this->log($order['order_id'], 2, $order['api_id'], $method, 1, [], ['exist' => false]);

					return true; //不存在此方法直接成功
				}

				throw new PaymentPluginException(lang('plugin/payment', 'plugin_callback_not_exist'), 1011); //抛出插件接口不存在的异常
			}
			if ($api_class->{$method}()) {
				$this->log($order['order_id'], 2, $order['api_id'], $method, 1, [], ['exist' => true]);

				return true;
			}

			throw new PaymentPluginException(lang('plugin/payment', 'notify_plugin_fail'), 1012);
		} catch (PaymentPluginException $e) {
			$this->log($order['order_id'], 2, $order['api_id'], $method, 0, [], $e->getError(), $e->getMessage());

			throw $e;
		}
	}

	/**
	 * 支付成功回调.
	 *
	 * @DateTime 2021-03-10
	 *
	 * @param mixed  $order_id    订单号或订单
	 * @param string $finish_user 完成人id
	 * @param string $method_id   支付接口
	 * @param int    $finish_time 完成时间
	 * @param string $finish_id   完成订单号
	 * @param int    $forcenotify 强制通知插件接口，若为0，则根据目前的通知情况来判断是否需要通知插件接口
	 *
	 * @return bool 回调结果
	 */
	public function success($order_id, $finish_user = '', $method_id = '', $finish_time = 0, $finish_id = '', $forcenotify = 0)
	{
		$this->load_order($order_id, $order); //加载订单
		//若订单已支付，后台需要重复通知插件接口，则调用notify方法
		if (2 == $order['status']) {
			return true;
		}

		$update = [
			'status' => 2,
			'method_id' => $method_id,
			'finish_user' => $finish_user,
			'finish_time' => $finish_time,
			'finish_id' => $finish_id,
		];
		if (!$finish_time) {
			$update['finish_time'] = TIMESTAMP;
		}

		C::t('#payment#payment_order')->update($order_id, $update); //更新订单信息

		if ((0 == $forcenotify && 0 == $order['plugin_status']) || 1 == $forcenotify) {
			$this->plugin_notify(array_merge($order, $update)); //调用通知接口
		}

		return true;
	}

	/**
	 * 取消订单.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param mixed $order_id 订单号或订单
	 *
	 * @return bool 结果
	 */
	public function cancel($order_id)
	{
		$this->load_order($order_id, $order);
		if (1 != $order['status']) {
			throw new PaymentException(lang('plugin/payment', 'order_cant_cancel'), 1031);
		}

		$this->plugin_callback($order, 'cancel');
		C::t('#payment#payment_order')->update($order_id, ['cancel_time' => TIMESTAMP, 'status' => 4]);

		return true;
	}

	/**
	 * 主动校验订单是否支付成功，若支付成功同时会调用success.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param mixed  $order_id  订单号或订单
	 * @param string $method_id 支付接口标识
	 * @param bool   $force     强制校验，为true时，即使订单已失效也可调用checkpay接口
	 *
	 * @return bool 校验结果
	 */
	public function checkpay($order_id, $method_id, $force = false)
	{
		$this->load_order($order_id, $order); //加载订单
		if (2 == $order['status']) {
			return true;
		}
		if (1 != $order['status'] && !$force) {
			throw new PaymentException(lang('plugin/payment', 'order_cant_visit'), 1002);
		}

		try {
			$method = $this->load_method($method_id, $order);
			if (!method_exists($method, 'checkpay')) {
				throw new PaymentException(lang('plugin/payment', 'not_support_checkpay'), 1006);
			}
			$res = $method->checkpay();

			return $this->success($order_id, $res['finish_user'], $method_id, $res['finish_time'], $res['finish_id']);
		} catch (PaymentMethodException $e) {
			$e->doParent();
		}
	}

	/**
	 * 退款.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param mixed  $order_id      订单号或订单
	 * @param int    $reback        需要调用支付接口
	 * @param int    $amount        金额，单位分，0为全额退款
	 * @param string $body          订单内容
	 * @param string $finish_id     退款完成交易号，留空则根据支付接口获取
	 * @param int    $finish_time   退款完成时间，留空则根据支付接口获取
	 * @param string $finish_user   退款完成交易用户id，留空则根据支付接口获取
	 * @param bool   $notify_plugin 是否通知插件接口
	 *
	 * @return string 退款订单号
	 */
	public function refund($order_id, $reback = 1, $amount = 0, $body = '', $finish_id = '', $finish_time = 0, $finish_user = '', $notify_plugin = true)
	{
		$this->load_order($order_id, $order); //加载订单
		global $_G;
		if (2 != $order['status']) {
			throw new PaymentException(lang('plugin/payment', 'order_not_pay'), 1021);
		}

		$sql = sql('payment_order')
			->where('plugin_status', 1)
			->where('subject', $order_id.lang('plugin/payment', 'refund'))
			->where('is_refund', 1)
		;

		if (0 == $order['amount']) {
			//0元订单只能退一次
			if ($sql->exist()) {
				throw new PaymentException(lang('plugin/payment', 'order_has_refunded'), 1022);
			}
		} else {
			$amount = max(0, $amount);
			if (!$amount) {
				$amount = $order['amount'];
			}
			if ($sql->sum('amount') >= $order['amount']) {
				//已退款的金额
				throw new PaymentException(lang('plugin/payment', 'order_has_refunded'), 1023);
			}
			if ($sql->sum('amount') + $amount > $order['amount']) {
				//总金额
				throw new PaymentException(lang('plugin/payment', 'order_refund_overflow'), 1024);
			}
		}

		do {
			$out_refund_id = dgmdate(TIMESTAMP, 'YmdHis').random(6, 1);
		} while ($sql->where('order_id', $out_refund_id)->exist());
		$data = [
			'order_id' => $out_refund_id,
			'subject' => $order_id.lang('plugin/payment', 'refund'),
			'body' => $body,
			'url' => 'home.php?mod=spacecp&ac=plugin&id=payment:payment&order_id='.$order_id,
			'uid' => $order['uid'],
			'amount' => $amount,
			'api_id' => $order['api_id'],
			'status' => 6,
			'create_time' => TIMESTAMP,
			'create_ip' => $_G['clientip'],
			'finish_user' => $order['buyer_id'],
			'expire_time' => 0,
			'is_refund' => 1,
		];
		if (!$notify_plugin) {
			$data['plugin_status'] = 3;
		}
		C::t('#payment#payment_order')->insert($data);

		if ($notify_plugin) {
			//如果通知失败，则status=6，plugin_status=2
			$this->plugin_notify($data);
		}
		//调用插件接口
		$update = ['finish_time' => TIMESTAMP, 'status' => 5];
		if (1 == $reback && $order['method_id']) {
			//调用支付接口
			try {
				$update['method_id'] = $order['method_id'];
				$method = $this->load_method($order['method_id'], $order);
				if (!method_exists($method, 'refund')) {
					throw new PaymentException(lang('plugin/payment', 'method_not_refund'), 1026);
				}
				$res = $method->refund($out_refund_id, $amount);
				if ($res['refund_time']) {
					$update['finish_time'] = $res['refund_time'];
				}

				$update['finish_id'] = $res['refund_id'];
				if ($res['refund_user']) {
					$update['finish_user'] = $res['refund_user'];
				}
			} catch (PaymentMethodException $e) {
				//将错误信息记录至payment_error里面
				$error = $e->getError();
				C::t('#payment#payment_order')->update($out_refund_id, [
					'method_error' => serialize($error),
					'method_id' => $order['method_id'],
				]);
				$e->extra = ['order_id' => $out_refund_id];
				$e->message = lang('plugin/payment', 'method_refund_fail').$error['msg'];
				$e->doParent(); //抛异常
			}
		}
		//手动退款
		if ($finish_time) {
			$update['finish_time'] = $finish_time;
		}

		if ($finish_user) {
			$update['finish_user'] = $finish_user;
		}
		if ($finish_id) {
			$update['finish_id'] = $finish_id;
		}

		C::t('#payment#payment_order')->update($out_refund_id, $update);

		return $out_refund_id;
	}

	/**
	 * 加载订单，在本类外调用引用调用会失效.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param string &$order_id    订单号
	 * @param string &$order       订单
	 * @param bool   $allow_refund 是否允许退款订单，若不允许则之前抛异常
	 *
	 * @return array 订单信息
	 */
	public function load_order(&$order_id, &$order = '', $allow_refund = false)
	{
		if (is_string($order_id)) {
			$order = C::t('#payment#payment_order')->fetch($order_id);
		} else {
			$order = $order_id;
			$order_id = $order['order_id'];
		}
		if (!$order) {
			throw new PaymentException(lang('plugin/payment', 'order_not_exist'), 1003);
		}
		if ($order['is_refund'] && !$allow_refund) {
			throw new PaymentException(lang('plugin/payment', 'order_is_refund'), 1004);
		}

		return $order;
	}

	/**
	 * 加载支付方式类.
	 *
	 * @DateTime 2021-02-11
	 *
	 * @param string $method_id 支付方式
	 * @param string $order     订单
	 *
	 * @return method_class 支付接口类
	 */
	public function load_method($method_id, $order = '')
	{
		$classname = 'payment_'.$method_id;
		if (!class_exists($classname)) {
			include_once DISCUZ_ROOT.'./source/plugin/payment/method/'.$method_id.'/core.php';
		}
		$method = new $classname($order);

		return $method;
	}

	/**
	 * 查询支持的支付方式.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param string $order_id 订单号
	 * @param string $field    同时需要支付接口的字段
	 *
	 * @return array 支付接口数组集
	 */
	public function load_methods($order_id = '', $field = 'method_id,title,user_agent')
	{
		$methods = sql('payment_method')
			->field($field)
			->where('available', 1)
			->order('displayorder', 'DESC')
		;
		if ($order_id) {
			$this->load_order($order_id, $order);
			if ($order['method_list']) {
				if (0 == $order['method_rule']) {
					$methods->whereNotFindInSet($order['method_list'], 'method_id');
				} else {
					$methods->whereFindInSet($order['method_list'], 'method_id');
				}
			}
		}

		return $methods->select('method_id');
	}

	/**
	 * 获取支付借接口的名称.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param string $method_id 支付接口标识
	 *
	 * @return string 支付接口名称
	 */
	public function method_title($method_id)
	{
		return $method_id ? sql('payment_method')->where('method_id', $method_id)->value('title') : '-';
	}

	/**
	 * 查询状态值对应的文字.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param mixed $status 传空返回所有状态；传pay返回支付订单的状态；传refund返回退款订单的状态，传数字返回对应的状态
	 *
	 * @return string/array
	 */
	public function status($status = '')
	{
		$statusTitle = [
			1 => lang('plugin/payment', 'status_1'), //待支付
			2 => lang('plugin/payment', 'status_2'), //已支付
			3 => lang('plugin/payment', 'status_3'), //已超时
			4 => lang('plugin/payment', 'status_4'), //已取消
			5 => lang('plugin/payment', 'status_5'), //已退款
			6 => lang('plugin/payment', 'status_6'), //退款失败
		];
		if ('pay' == $status) {
			return [
				1 => $statusTitle[1],
				2 => $statusTitle[2],
				3 => $statusTitle[3],
				4 => $statusTitle[4],
			];
		}
		if ('refund' == $status) {
			return [
				5 => $statusTitle[5],
				6 => $statusTitle[6],
			];
		}
		if ($status) {
			return $statusTitle[$status];
		}

		return $statusTitle;
	}

	/**
	 * 返回带color的状态
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param int $status 状态值
	 *
	 * @return string 包裹span的状态
	 */
	public function status_color($status)
	{
		$colors = [
			1 => '',
			2 => '#0000FF',
			3 => '#C0C0C0',
			4 => '#808A87',
			5 => '#87CEEB',
			6 => '#FF0000',
		];

		return '<span style="color:'.$colors[$status].'">'.$this->status($status).'</span>';
	}

	/**
	 * 根据订单号获取可操作的按钮.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param mixed $order_id 订单或者订单号
	 *
	 * @return string 可操作按钮
	 */
	public function status_ops($order_id)
	{
		$ops = [];

		try {
			$this->load_order($order_id, $order, true);
			if (1 == $order['status']) {
				$ops[] = [
					'href' => 'plugin.php?id=payment:pay&order_id='.$order_id,
					'class' => 'dqzhiyu-btn-blue',
					'text' => lang('plugin/payment', 'pay'),
				];
				$ops[] = [
					'href' => 'javascript:cancel_order(\''.$order_id.'\')',
					'class' => 'dqzhiyu-btn-red',
					'text' => lang('plugin/payment', 'cancel'),
				];
			}
		} catch (PaymentException $e) {
			return '';
		}

		$ops = array_map(function ($n) {
			return '<a href="'.$n['href'].'" class="dqzhiyu-btn dqzhiyu-btn-sm '.$n['class'].'">'.$n['text'].'</a>';
		}, $ops);

		return implode('&nbsp;', $ops);
	}

	/**
	 * 保留2位有效数字.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param float $amount 金额
	 *
	 * @return string 2位有效数字
	 */
	public function amount($amount)
	{
		return sprintf('%.2f', $amount / 100);
	}

	/**
	 * 处理过期订单.
	 *
	 * @DateTime 2021-03-09
	 *
	 * @return array 校验结果数组
	 */
	public function check_expire()
	{
		$orders = sql('payment_order')
			->arr('params')
			->where('expire_time', '<', TIMESTAMP)
			->where('status', 1)
			->select()
		;
		$result = ['success' => [], 'fail' => []];
		foreach ($orders as $order) {
			try {
				$order_id = $order['order_id'];
				$this->plugin_callback($order, 'expire'); //调用expire方法
				C::t('#payment#payment_order')->update($order_id, ['status' => 3]);
				$result['success'][] = $order_id; //执行成功
			} catch (PaymentPluginException $e) {
				$result['fail'][] = $order_id; //执行失败
			}
		}
		if (count($result['success']) > 0 || count($result['fail']) > 0) {
			$this->log(lang('plugin/payment', 'cron_title'), 3, '', 'crontab', 1, [], $result, lang('plugin/payment', 'cron_content', ['success' => count($result['success']), 'fail' => count($result['fail'])]));
		}

		return $result;
	}

	/**
	 * 记录日志.
	 *
	 * @DateTime 2021-03-11
	 *
	 * @param string $order_id    订单号
	 * @param int    $type        1=支付接口2=插件接口3=计划任务
	 * @param string $type_id     调用的接口标识，支付接口或插件接口
	 * @param string $type_method 具体调用的接口名
	 * @param int    $status      状态0=失败1=成功
	 * @param array  $params      调用接口参数
	 * @param array  $result      调用接口结果
	 * @param string $comment     附加信息
	 *
	 * @return int log_id
	 */
	public function log($order_id, $type, $type_id = '', $type_method = '', $status = 0, $params = [], $result = [], $comment = '')
	{
		global $_G;

		return sql('payment_log')->arr('params,result')->insert([
			'order_id' => $order_id,
			'type' => $type,
			'type_id' => $type_id,
			'type_method' => $type_method,
			'status' => $status,
			'params' => $params,
			'result' => $result,
			'comment' => $comment,
			'create_time' => TIMESTAMP,
			'create_ip' => $_G['clientip'],
		]);
	}
}
