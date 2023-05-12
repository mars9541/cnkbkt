<?php

//cronname:通用支付标记订单过期
//minute:1,6,11,16,21,26,31,36,41,46,51,56

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
C::m('#payment#payment')->check_expire();
if (!isset($_G['cache']['plugin'])) {
    loadcache('plugin');
}

$var = $_G['cache']['plugin']['payment'];

//删除超时订单
if ($var['unpay_delete']) {
    sql('payment_order')->where('expire_time', '<', TIMESTAMP - $var['unpay_delete']);
}
//删除日志
if ($var['log_delete']) {
    sql('payment_log')->where('create_time', '<', TIMESTAMP - $var['log_delete']);
}
?>