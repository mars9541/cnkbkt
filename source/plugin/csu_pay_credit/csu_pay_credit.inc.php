<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (!$_G['uid']) {
    showmessage('not_loggedin', NULL, array(), array('login' => 1));
}
$var = $_G['cache']['plugin']['csu_pay_credit'];
if (submitcheck('creditsubmit')) {
    //获取充值金额
    $amount = dintval($_GET['amount']);
    if ($amount <= 0) {
        showmessage(lang('plugin/csu_pay_credit', 'amount_zero'));
    }
    if ($amount < $var['min'] && $var['min'] > 0) {
        showmessage(lang('plugin/csu_pay_credit', 'amount_min') . $var['min'] . lang('plugin/csu_pay_credit', 'yuan'));
    }
    if ($amount > $var['max'] && $var['max'] > 0) {
        showmessage(lang('plugin/csu_pay_credit', 'amount_max') . $var['max'] . lang('plugin/csu_pay_credit', 'yuan'));
    }
    $nums = $amount * $var['fee']; //可获得积分
    C::m('#payment#payment'); //初始化引入payment类
    try {
        $order_id = C::m('#payment#payment')->build(
            lang('plugin/csu_pay_credit', 'plugin_name') . ' - ' . $nums . $_G['setting']['extcredits'][$var['credit']]['title'],
            $_G['uid'],
            $amount * 100,
            'pay_credit',
            ['credit' => $var['credit'], 'amount' => $nums]
        );
        dheader('location:' . C::m('#payment#payment')->makeurl());
    } catch (PaymentException $e) {
        showmessage(lang('plugin/csu_pay_credit', 'recharge_fail') . $e->getMessage()); //捕获异常
    }
}
if (defined('IN_MOBILE') && CURSCRIPT == 'home') {
    dheader('location:plugin.php?id=csu_pay_credit');
} elseif (!defined('IN_MOBILE') && CURSCRIPT == 'plugin') {
    dheader('location:home.php?mod=spacecp&ac=plugin&op=credit&id=csu_pay_credit:csu_pay_credit');
}
if (defined('IN_MOBILE')) {
    include template('common/header');
    include template('csu_pay_credit:csu_pay_credit');
    include template('common/footer');
}
?>