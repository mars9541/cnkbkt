<?php
define('CURSCRIPT', 'api');
define('METHOD_ID', 'alipay');
define('DISABLEDEFENSE', true);
define('DISABLEXSSCHECK', true);
//加载框架
require '../../../../class/class_core.php';
$discuz = C::app();
$discuz->init();
loadcache('plugin');
require_once './core.php'; //引入支付接口类
try {
    $method = new payment_alipay();
    //签名校验
    $sign = $_POST['sign'];
    unset($_POST['sign']);
    unset($_POST['sign_type']);

    $str   = $method->make_str($_POST);
    $check = $method->verify($str, $sign);
    //业务流程部分
    if (!$check) {
        throw new PaymentMethodException(lang('plugin/payment', 'check_sign_fail'), 11001);
    }

    $order_id = daddslashes($_POST['out_trade_no']);
    if (!$order_id) {
        throw new PaymentMethodException(lang('plugin/payment', 'lost_order_id'), 11000);
    }

    if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
        $method->order($order_id)->success(
            daddslashes($_POST['buyer_id']),
            csubase::mktime($_POST['gmt_payment']),
            daddslashes($_POST['trade_no'])
        );
        C::m('#payment#payment')->log($order_id, 1, METHOD_ID, 'notify', 1, daddslashes($_POST)); //记录log
        exit('success');
    }
} catch (PaymentException $e) {
    C::m('#payment#payment')->log($order_id, 1, METHOD_ID, 'notify', 0, daddslashes($_POST), $e->getError(), $e->getMessage()); //记录log
    exit($e->getMessage());
}
?>