<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$notip = true;
require_once DISCUZ_ROOT . './source/plugin/payment/admin.common.php';
$step = max(1, intval($_GET['step']));

if ($step != 4 && !DB::result_first('SELECT * FROM information_schema.tables WHERE table_name=%s', [DB::table('payment_pay')])) {
    cpmsg_error(lang('plugin/payment', 'upgrade_noneed'));
}
if ($step == 1) {
    showtips(lang('plugin/payment', 'upgrade_tips'));
    formtableheader(['step' => 2]);
    showsubmit('submit', lang('plugin/payment', 'upgrade'));
    formtablefooter();
} elseif ($step == 2) {
    $count   = sql('payment_pay')->count();
    $page    = max(1, intval($_GET['page']));
    $num     = 50;
    $pageall = ceil($count / $num);
    //读取待处理数据
    $list = sql('payment_pay')->page($page, $num)->order('create_time', 'asc')->select();
    foreach ($list as $value) {
        if (sql('payment_order')->where('order_id', $value['out_trade_no'])->exist()) {
            continue; //订单已存在则跳过
        }
        $order = [
            'order_id'    => $value['out_trade_no'],
            'subject'     => $value['subject'],
            'body'        => $value['body'],
            'url'         => $value['url'],
            'uid'         => $value['uid'],
            'amount'      => $value['amount'],
            'api_id'      => $value['api_id'],
            'params'      => $value['params'],
            'create_time' => $value['create_time'],
            'create_ip'   => $value['create_ip'],
            'expire_time' => $value['expire_time'],
            'method_list' => $value['payment_limit'],
            'status'      => $value['status'],
        ];
        if ($order['status'] == 2 || $order['status'] == 5) {
            //已支付订单
            $order['method_id']     = $value['payment_id'];
            $order['plugin_status'] = 1;
            $order['finish_time']   = $value['pay_time'];
            $order['finish_id']     = $value['transcation_id'];
            $order['finish_user']   = $value['buyer_id'];
            if ($order['status'] == 5) {
                $order['status'] = 2;
                //生成退款订单
                $refund_order = [
                    'order_id'      => $value['out_refund_id'],
                    'subject'       => $value['out_trade_no'] . lang('plugin/payment', 'refund'),
                    'uid'           => $value['uid'],
                    'amount'        => $value['amount'],
                    'is_refund'     => 1,
                    'api_id'        => $value['api_id'],
                    'status'        => 5,
                    'plugin_status' => 1,
                    'create_time'   => $value['refund_time'],
                    'create_ip'     => $value['create_ip'],
                    'method_id'     => $value['payment_id'],
                    'finish_time'   => $value['refund_time'],
                    'finish_user'   => $order['finish_user'],
                    'expire_time'   => 0,
                    'finish_id'     => $value['refund_id'],
                ];
                sql('payment_order')->insert($refund_order);
            }
        } elseif ($order['status'] == 4) {
            //取消订单
            $order['cancel_time'] = $value['cancel_time'];
        }
        sql('payment_order')->insert($order);
    }
    cpmsg(lang('plugin/payment', 'upgrade_1', ['count' => $count, 'page' => $page, 'pageall' => $pageall]), CP_URL . ($pageall > $page ? 'step=2&page=' . ($page + 1) : 'step=3'), 'loading', '', FALSE);
} elseif ($step == 3) {
    DB::query('DROP TABLE IF EXISTS %t', ['payment_pay']);
    cpmsg(lang('plugin/payment', 'upgrade_2'), CP_URL . 'step=4', 'loading', '', FALSE);
} elseif ($step == 4) {
    cpmsg(lang('plugin/payment', 'upgrade_success'), '', 'succeed', '', FALSE);
}
?>