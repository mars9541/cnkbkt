<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//加载类
if (!class_exists('payment_method')) {
	include_once DISCUZ_ROOT.'./source/plugin/payment/payment_method.class.php';
}

require_once DISCUZ_ROOT.'./source/plugin/payment/method/dzcsu/Dzpay.class.php';
/**
 * 请勿修改类名.
 */
class payment_dzcsu extends payment_method
{
	public $client;

	public function __construct($order_id = '')
	{
		$this->method_id = 'dzcsu';
		$this->order_id = $order_id;

		parent::__construct();
		$this->client = new Dzpay($this->setting);
	}

	public function page()
	{
		global $_G;
		if ($_GET['tosubmit']) {
			$this->geturl();
		}

		return [
			'paycheck' => true,
			'msg' => '<form action="plugin.php?id=payment:pay&order_id='.$this->order_id.'" method="post" target="_blank">
				<input type="hidden" name="formhash" value="'.FORMHASH.'">
				<input type="hidden" name="pagesubmit" value="true">
				<input type="hidden" name="tosubmit" value="true">
				<input type="hidden" name="method_id" value="dzcsu">
				<button class="dqzhiyu-btn dqzhiyu-btn-sm dqzhiyu-btn-blue" href="'.$this->order['method_extends']['dzcsu']['url'].'" type="submit">'.$this->lang('topay').'</button>
			</form>',
		];
	}

	/**
	 * 手机支付.
	 *
	 * @return [type] [description]
	 */
	public function wap()
	{
		$this->geturl();
	}

	public function checkpay()
	{
		try {
			$query = $this->client->query('', (string) $this->order['method_extends']['dzcsu']['order_id']);
			$request = $this->client->get_request();

			$this->log('query', 1, $request['params'], $query);
			if ('success' == $query['data']['trade_state']) {
				//已支付
				return [
					'finish_user' => '',
					'finish_time' => $query['data']['pay_time'],
					'finish_id' => $query['data']['order_id'],
				];
			}
		} catch (Exception $e) {
			$request = $this->client->get_request();

			$this->log('query', 1, $request['params'], $request['error']);
		}
		parent::checkpay_error();
	}

	private function geturl()
	{
		global $_G;
		if (!$this->order['method_extends']['dzcsu'] || $this->order['method_extends']['dzcsu']['expire_time'] <= TIMESTAMP) {
			try {
				$res = $this->client->create(
					$this->order_id.random(4, 1),
					diconv($this->order['subject'], CHARSET, 'utf-8'),
					$this->order['amount'],
					$this->order_id,
					$_G['siteurl'].'source/plugin/payment/method/dzcsu/notify.php',
					$_G['siteurl'].'source/plugin/payment/method/dzcsu/return.php'
				);
				$this->order['method_extends']['dzcsu'] = [
					'order_id' => $res['data']['order_id'],
					'expire_time' => $res['data']['expire_time'],
					'url' => $res['data']['url'],
				];
				$request = $this->client->get_request();
				$this->log('create', 1, $request['params'], $res);
				C::t('#payment#payment_order')->update($this->order_id, [
					'method_extends' => serialize($this->order['method_extends']),
				]);
			} catch (Exception $e) {
				$request = $this->client->get_request();
				$this->log('create', 1, $request['params'], $res['error']);
				showmessage(diconv($e->getMessage(), 'utf-8'));
				//throw new PaymentMethodException(diconv($e->getMessage(), 'utf-8'), $e->getCode());
			}
		}
		dheader('location:'.$this->order['method_extends']['dzcsu']['url']);
	}
}
