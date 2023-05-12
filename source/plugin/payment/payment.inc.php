<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (!$_G['uid']) {
    showmessage('not_loggedin', NULL, array(), array('login' => 1));
}
C::m('#payment#payment');
$var = $_G['cache']['plugin']['payment'];
if (CURSCRIPT != 'home') {
    //插件页
    $navtitle = lang('plugin/payment', 'paylogs');
    $baseurl  = 'plugin.php?id=payment:payment';
} else {
    //home页
    if (defined('IN_MOBILE')) {
        //手机访问跳转到插件页
        dheader('location:plugin.php?id=payment' . ($_GET['order_id'] ? '&order_id' . $_GET['order_id'] : ''));
    }
    $baseurl = 'home.php?mod=spacecp&ac=plugin&id=payment:payment';
}

if ($_GET['order_id']) {
    //订单详情
    try {
        $order_id = daddslashes($_GET['order_id']);
        $order    = C::m('#payment#payment')->load_order($order_id, [], true);
        if ($order['uid'] != $_G['uid']) {
            showmessage(lang('plugin/payment', 'order_not_exist'));
        }
        if (submitcheck('cancel_submit')) {
            //取消订单

            try {
                if (payment::cancel($order)) {
                    exit('200');
                } else {
                    exit(lang('plugin/payment', 'status_6'));
                }
            } catch (PaymentException $e) {
                exit($e->getMessage());
            }
        }
        $ops = payment::status_ops($order);
        if ($order['method_id']) {
            $method = payment::method_title($order['method_id']);
        }

    } catch (PaymentException $e) {
        showmessage($e->getMessage());
    }
} else {
    $page = max(1, dintval($_GET['page']));
    $num  = 15;

    $sql = sql('payment_order')->where('uid', $_G['uid'])->order('create_time', 'desc');

    if ($var['unpay_time']) {
        $sql->whereRaw('(status!=3 OR expire_time<' . (TIMESTAMP - $var['unpay_time']) . ')'); //超时隐藏
    }
    $urlparams = [];
    if ($_GET['params']) {
        $sql->whereRaw("(concat_ws(',',order_id,finish_id) LIKE '%" . daddslashes($_GET['params']) . "%')");
        $urlparams['params'] = $_GET['params'];
    }
    if ($_GET['status']) {
        $sql->where('status', dintval($_GET['status']));
        $urlparams['status'] = $_GET['status'];
    }
    if ($_GET['is_refund']) {
        $sql->where('is_refund', dintval($_GET['is_refund'] - 1));
        $urlparams['is_refund'] = $_GET['is_refund'];
    }
    if ($_GET['begin_time']) {
        $sql->where('create_time', '>=', csubase::mktime($_GET['begin_time']));
        $urlparams['begin_time'] = $_GET['begin_time'];
    }
    if ($_GET['end_time']) {
        $sql->where('create_time', '<=', csubase::mktime($_GET['end_time']) + 59);
        $urlparams['end_time'] = $_GET['end_time'];
    }
    $count = $sql->count();
    $list  = $sql->page($page, $num)
        ->field('order_id,subject,amount,method_id,status,plugin_status,create_time,finish_time,is_refund')
        ->select();

    $multi = multi($count, $num, $page, trim($baseurl . '&' . http_build_query($urlparams), '&'));
}
if (CURSCRIPT != 'home') {
    $navtitle = lang('plugin/payment', 'paylogs');

    include template('common/header');
    include template('payment:payment');
    include template('common/footer');
}
?>