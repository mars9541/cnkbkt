<?php

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);
require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();

include_once DISCUZ_ROOT.'./source/plugin/ck8_view/function.php';
include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/lib/AlipayService.class.php';
if(empty($_G['cache']['plugin'])){
	loadcache('plugin');
}
$config = $_G['cache']['plugin']['ck8_pay'];
$aliPay = new AlipayService();
$aliPay->alipayPublicKey(trim($config['zfb_alipayPublicKey']));
$result = $aliPay->rsaCheck($_POST);
if($result == 1){
	$out_trade_no = $_POST['out_trade_no'];
    $trade_no = $_POST['trade_no'];
	if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
		upBuyState($out_trade_no);
		if(!function_exists('upPayState')){
			include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/function.php';
			upPayState($out_trade_no,$trade_no);
		}
	}
    echo 'success';exit();
}
echo "fail";
$aliPay->logResult('fail'.$_POST['sign']);
exit();
?>