<?php

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);
require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();

include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/lib/WxpayService.class.php';
include_once DISCUZ_ROOT.'./source/plugin/ck8_view/function.php';
if(empty($_G['cache']['plugin'])){
	loadcache('plugin');
}
$config = $_G['cache']['plugin']['ck8_pay'];
$wxPay = new WxpayService(trim($config['wxzf_mchid']),trim($config['wxzf_appid']),trim($config['wxzf_apiKey']));
$result = $wxPay->notify();
if($result !== false){
	if($result['result_code'] == 'SUCCESS'){
		upBuyState($result['out_trade_no']);
		if(!function_exists('upPayState')){
			include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/function.php';
			upPayState($result['out_trade_no'],$result['transaction_id']);
		}
		$return = array();
		$return['return_code'] = 'SUCCESS';
		$return['return_msg'] = 'ok';
	}else{
		$return = array();
		$return['return_code'] = 'FAIL';
		$return['return_msg'] = 'ERROR';
	}
	echo $wxPay->arrayToXml($return);
}else{
	$wxPay->logResult('pay_error_sign');
	exit;
}
?>