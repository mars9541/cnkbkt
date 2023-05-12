<?php

class Dzpay
{
	private $config = [
		'appid' => '',
		'secret' => '',
		'host' => '',
	];
	private $request;

	/**
	 * 构造函数.
	 *
	 * @param mixed $config
	 */
	public function __construct($config)
	{
		$this->config = $config;
	}

	/**
	 * 创建订单.
	 *
	 * @param string $out_trade_no 商户自己系统的订单号
	 * @param string $subject      订单标题
	 * @param int    $amount       订单金额，单位：分
	 * @param string $extra        附加参数，可留空。会在回调时原样返回，在sdk中传入array会被转为json
	 * @param string $notify_url   异步回调通知地址，留空则采用商户配置中的异步地址
	 * @param string $return_url   同步回调通知地址，留空则采用商户配置中的同步地址
	 * @param int    $expire_time  订单有效期，单位：秒。建议设置不要超过300秒，留空则采用商户配置中的设置
	 */
	public function create($out_trade_no, $subject, $amount, $extra = '', $notify_url = '', $return_url = '', $expire_time = 0)
	{
		$params = [
			'out_trade_no' => $out_trade_no,
			'subject' => $subject,
			'amount' => $amount,
			'extra' => is_array($extra) ? json_encode($extra, JSON_UNESCAPED_UNICODE) : $extra,
			'notify_url' => $notify_url,
			'return_url' => $return_url,
			'expire_time' => $expire_time,
		];

		return $this->request(__FUNCTION__, $params);
	}

	/**
	 * 查询订单.
	 *
	 * @param string $out_trade_no 商户订单号，与平台订单号二选一即可
	 * @param string $order_id     平台订单号，与商户订单号二选一即可
	 */
	public function query($out_trade_no = '', $order_id = '')
	{
		$params = [
			'out_trade_no' => $out_trade_no,
			'order_id' => $order_id,
		];

		return $this->request(__FUNCTION__, $params);
	}

	/**
	 * 关闭订单.
	 *
	 * @param string $out_trade_no 商户订单号，与平台订单号二选一即可
	 * @param string $order_id     平台订单号，与商户订单号二选一即可
	 */
	public function close($out_trade_no = '', $order_id = '')
	{
		$params = [
			'out_trade_no' => $out_trade_no,
			'order_id' => $order_id,
		];

		return $this->request(__FUNCTION__, $params);
	}

	/**
	 * 补单.
	 *
	 * @param string $out_trade_no 商户订单号，与平台订单号二选一即可
	 * @param string $order_id     平台订单号，与商户订单号二选一即可
	 * @param string $method       支付方式，目前支持alipay和wepay
	 * @param int    $pay_time     支付时间，留空或0则为当前时间
	 */
	public function supply($out_trade_no = '', $order_id = '', $method = '', $pay_time = 0)
	{
		$params = [
			'out_trade_no' => $out_trade_no,
			'order_id' => $order_id,
			'method' => $method,
			'pay_time' => $pay_time,
		];

		return $this->request(__FUNCTION__, $params);
	}

	/**
	 * 获取客户端状态
	 */
	public function client()
	{
		return $this->request(__FUNCTION__);
	}

	/**
	 * 校验签名.
	 *
	 * @param string $sign   签名值
	 * @param array  $params 待校验参数
	 *
	 * @return bool
	 */
	public function check_sign($sign, $params)
	{
		return $sign == $this->make_sign($params);
	}

	/**
	 * 生成签名.
	 *
	 * @param array $params 待校验参数
	 *
	 * @return string
	 */
	public function make_sign($params = [])
	{
		unset($params['sign']); //sign参数不进行校验
		ksort($params); //按照key升序排序

		return md5(md5(http_build_query($params)).$this->config['secret']);
	}

	/**
	 * 请求参数预处理，添加公共参数.
	 *
	 * @param array $params 请求参数
	 *
	 * @return array
	 */
	public function pre_request($params = [])
	{
		$params['timestamp'] = time();
		$params['appid'] = $this->config['appid'];
		$params['sign'] = $this->make_sign($params);

		return $params;
	}

	/**
	 * 发送请求
	 *
	 * @param string $api         接口名
	 * @param array  $params      参数
	 * @param bool   $json_decode 是否对结果进行解码
	 *
	 * @return string/array
	 */
	public function request($api, $params = [], $json_decode = true)
	{
		$params = $this->pre_request($params);
		$ch = curl_init($this->config['host'].$api);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不校验ssl证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$res = curl_exec($ch);
		$error = curl_error($ch);
		//记录request
		$this->request = [
			'target' => $this->host.$api,
			'params' => $params,
			'result' => $res,
			'error' => $error,
		];
		if (!$res) {
			throw new Exception('request fail', 1);
		}
		$jsonres = json_decode($res, true);
		if (!$jsonres) {
			throw new Exception('json parse fail', 2);
		}
		//校验签名
		if (!$this->check_sign($jsonres['sign'], $jsonres['data'])) {
			throw new Exception('sign error', 3);
		}
		if (200 != $jsonres['code']) {
			throw new Exception($jsonres['msg'], $jsonres['code']);
		}
		if ($json_decode) {
			return $jsonres;
		}

		return $res;
	}

	/**
	 * 获取请求结果.
	 *
	 * @param string $name
	 */
	public function get_request($name = '')
	{
		if (!$name) {
			return $this->request;
		}

		return $this->request[$name];
	}
}
