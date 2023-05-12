<?php

define('IN_API', true);
define('CURSCRIPT', 'api');
define('DISABLEXSSCHECK', true);
require_once '../../../../source/class/class_core.php';
$discuz = C::app();
$discuz->init();

include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/lib/AlipayService.class.php';
if(empty($_G['cache']['plugin'])){
	loadcache('plugin');
}
$config = $_G['cache']['plugin']['ck8_pay'];
$aliPay = new AlipayService();
$aliPay->alipayPublicKey(trim($config['zfb_alipayPublicKey']));
$result = $aliPay->rsaCheck($_GET);
if($result == 1){
	$out_trade_no = $_GET['out_trade_no'];
	$order = C::t('#ck8_pay#ck8_pay_log')->get_pay_log_first(array('p_number'=> $out_trade_no));
	$url = $order['p_jmurl'];
    header("Location:$url");
	exit();
}
?>