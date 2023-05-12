<?php

define('CURSCRIPT', 'api');
define('METHOD_ID', 'dzcsu');
define('DISABLEDEFENSE', true);
define('DISABLEXSSCHECK', true);
//加载框架
require '../../../../class/class_core.php';
$discuz = C::app();
$discuz->init();
loadcache('plugin');
C::m('#payment#payment');

require_once './core.php'; //引入支付接口类

try {
	$method = new payment_dzcsu();

	//业务流程部分
	if (!$method->client->check_sign($_GET['sign'], $_GET)) {
		throw new PaymentMethodException(lang('plugin/payment', 'check_sign_fail'), 11001);
	}

	$order_id = daddslashes($_GET['extra']);
	if (!$order_id) {
		throw new PaymentMethodException(lang('plugin/payment', 'lost_order_id'), 11000);
	}

	$method->order($order_id)->success(
		'',
		$_GET['finish_time'],
		daddslashes($_GET['order_id'])
	);
	C::m('#payment#payment')->log($order_id, 1, METHOD_ID, 'return', 1, daddslashes($_GET)); //记录log
	dheader('location:../../../../../home.php?mod=spacecp&ac=plugin&id=payment:payment&order_id='.$order_id);
} catch (PaymentException $e) {
	C::m('#payment#payment')->log($order_id, 1, METHOD_ID, 0, 'return', daddslashes($_GET), $e->getError(), $e->getMessage()); //记录log

	exit($e->getMessage());
}
