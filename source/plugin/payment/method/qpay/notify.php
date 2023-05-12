<?php
define('CURSCRIPT', 'api');
define('METHOD_ID', 'qpay');
define('DISABLEDEFENSE', true);
define('DISABLEXSSCHECK', true);
//加载框架
require '../../../../class/class_core.php';
$discuz = C::app();
$discuz->init();
loadcache('plugin');

require_once './core.php'; //引入支付接口类

try {
    $xml    = file_get_contents('php://input');
    $method = new payment_qpay();
    $result = $method->toArray($xml);
    if (!$method->check($result)) {
        throw new PaymentMethodException(lang('plugin/payment', 'check_sign_fail'), 11001);
    }
    $res = daddslashes(csubase::iconv($result, 'UTF-8', CHARSET)); //编码转换
    if ($res['trade_state'] != 'SUCCESS') {
        throw new PaymentMethodException(lang('plugin/payment', 'plugin_status_2'), 31000);
    }

    $order_id = $res['out_trade_no'];
    if (!$order_id) {
        throw new PaymentMethodException(lang('plugin/payment', 'lost_order_id'), 11000);
    }

    $method->order($order_id)->success(
        $res['openid'],
        mktime(substr($res['time_end'], 8, 2), substr($res['time_end'], 10, 2), substr($res['time_end'], 12, 2), substr($res['time_end'], 4, 2), substr($res['time_end'], 6, 2), substr($res['time_end'], 0, 4)),
        $res['transaction_id']
    );
    C::m('#payment#payment')->log($order_id, 1, METHOD_ID, 'notify', 1, $res); //记录log
    exit($method->result());

} catch (PaymentException $e) {
    C::m('#payment#payment')->log($order_id, 1, METHOD_ID, 'notify', 0, $res, $e->getError(), $e->getMessage()); //记录log
    exit($method->result('notifyFail:' . $e->getMessage()));
}
?>