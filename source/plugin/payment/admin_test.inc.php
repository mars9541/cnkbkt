<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/payment/admin.common.php';
if (submitcheck('submit')) {
    $amount = dintval($_GET['amount']);
    $expire = dintval($_GET['expire']);
    try {
        $order_id  = C::m('#payment#payment')->build(lang('plugin/payment', 'test_payment'), $_G['uid'], $amount, 'payment_test', [], $expire);
        $order_url = C::m('#payment#payment')->makeurl($order_id);
        showtips('<a href="' . $order_url . '" target="_blank">' . lang('plugin/payment', 'topay') . '</a><br><img src="plugin.php?id=payment:pay&qrcode=true&formhash' . FORMHASH . '&url=' . urlencode($_G['siteurl'] . $order_url) . '">', 'tips', true, lang('plugin/payment', 'order_no') . $order_id);
    } catch (PaymentException $e) {
        cpmsg_error($e->getMessage()); //捕获异常
    }

}
showtableheader(lang('plugin/payment', 'test_make'));
showformheader(FORM_URL);
showsetting(lang('plugin/payment', 'amount'), 'amount', max($_GET['amount'], 1), 'number', '', 0, lang('plugin/payment', 'unit_amount'));
showsetting(lang('plugin/payment', 'expire'), 'expire', '3600', 'number', '', 0, lang('plugin/payment', 'unit_expire'));
showsubmit('submit');
showformfooter();
showtablefooter();
?>