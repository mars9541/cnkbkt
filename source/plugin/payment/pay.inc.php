<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (!class_exists('csubase')) {
    include_once DISCUZ_ROOT . './source/plugin/csu_base/csubase.class.php';
}
if (submitcheck('qrcode', true)) {
    //生成二维码
    if (!class_exists('QRcode')) {
        include_once DISCUZ_ROOT . './source/plugin/csu_base/qrcode.class.php';
    }
    QRcode::png($_GET['url'], false, QR_ECLEVEL_L, 5, 0);
    exit;
}
C::m('#payment#payment')->check_expire();

$var      = $_G['cache']['plugin']['payment'];
$order_id = daddslashes($_GET['order_id']);
$order    = C::t('#payment#payment_order')->fetch($order_id);
//校验订单是否存在
if (!$order) {
    payment_message(lang('plugin/payment', 'order_not_exist'));
}
//校验登录
if ($order['uid']) {
    if (!$_G['uid']) {
        showmessage('not_loggedin', NULL, array(), array('login' => 1));
    }
    if ($order['uid'] != $_G['uid']) {
        payment_message(lang('plugin/payment', 'order_not_exist'));
    }
} else {
    //未登录下订单超过12小时无法访问
    $check_time = TIMESTAMP - 3600 * 12;
    if ($order['expire_time'] && $order['expire_time'] < $check_time && (!$order['pay_time'] || ($order['pay_time'] && $order['pay_time'] < $check_time))) {
        payment_message(lang('plugin/payment', 'order_not_exist'));
    }
}
if ($order['status'] == 2) {
    payment_success($order);
}
try {
    if ($order['status'] != 1) {
        //不是待支付的状态
        throw new PaymentException(lang('plugin/payment', 'order_cant_visit'), 801);
    }
    //校验支付状态
    if (submitcheck('checksubmit')) {

        if ($_GET['force'] === true || $_GET['force'] === 'true') {
            //强制校验
            if (payment::checkpay($order_id, csubase::getMod($_GET['method_id']))) {
                payment_success($order);
            } else {
                throw new PaymentException(lang('plugin/payment', 'unpaied'), 802);
            }

        }
        //未支付
        throw new PaymentException(lang('plugin/payment', 'unpaied'), 802);
    }

    if ($order['status'] != 1) {
        //不是待支付的状态
        throw new PaymentException(lang('plugin/payment', 'order_cant_visit'));
    }
    $navtitle = lang('plugin/payment', 'navtitle') . ' - ' . $order_id;

    if ($order['amount'] > 0) {
        //获取支付方式
        $methods = payment::load_methods($order);
        if ($_GET['method_id']) {
            //选中的支付方式
            if (defined('IN_MOBILE') || submitcheck('pagesubmit')) {
                //手机支付或提交支付
                $method_id = csubase::getMod($_GET['method_id']);
                if (!$methods[$method_id]) {
                    //支付方式不存在或不可用
                    throw new PaymentException(lang('plugin/payment', 'method_limit'));
                }
                $method = payment::load_method($method_id, $order); //加载支付方式

                if (defined('IN_MOBILE')) {
                    $wap = $method->wap(); //手机支付
                } else {
                    $page = $method->page(); //PC支付
                    csubase::showmessage(array_merge(['code' => 200], $page));
                }

            }
        }
        if (defined('IN_MOBILE')) {
            //移动端，user_agent校验
            $banned = []; //禁用
            $cnt    = 0;
            foreach ($methods as $key => $value) {
                if ($value['user_agent']) {
                    $cnt++;
                    if (!stripos($_SERVER['HTTP_USER_AGENT'], $value['user_agent'])) {
                        $banned[] = $key;
                    }
                }
            }
            //全部不支持则显示全部
            if ($banned && count($banned) != $cnt) {
                foreach ($banned as $value) {
                    unset($methods[$value]);
                }
                $methods = array_values($methods);
            }
        }
    } else {
        //金额为0的订单
        if (submitcheck('freesubmit')) {
            if (payment::success($order['order_id'], $_G['uid'], '', TIMESTAMP, '')) {
                payment_success($order);
            }
        }
    }
} catch (PaymentException $e) {
    $error = $e->getError();
    payment_message($error['msg'], $error['code'], $error['extra']);
}
include template('common/header');
include template('payment:pay');
include template('common/footer');
function payment_success($order_id) {
    $order    = C::m('#payment#payment')->load_order($order_id);
    $order_id = $order['order_id'];
    global $_G;
    $url = $order['return_url'];
    if (!$url && $_G['uid'] && $_G['uid'] == $order['uid']) {
        $url = 'home.php?mod=spacecp&ac=plugin&id=payment:payment&order_id=' . $order_id;
    }
    if (csubase::isAjax()) {
        $return = [
            'msg'  => lang('plugin/payment', 'pay_success' . ($url ? '_to' : '')),
            'code' => 200,
        ];
        if ($url) {
            $return['url'] = $url;
        }
        csubase::showmessage($return);
    } else {
        csubase::showsuccess(lang('plugin/payment', 'pay_success'), $url);
    }
}
function payment_message($msg = '', $code = 800, $extra = []) {
    if (csubase::isAjax()) {
        csubase::showmessage(array_merge([
            'msg'  => $msg,
            'code' => $code,
        ], (array) $extra));
    } else {
        showmessage($msg);
    }
}
?>