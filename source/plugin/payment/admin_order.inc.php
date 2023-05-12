<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/payment/admin.common.php';

$methods = sql('payment_method')->order('displayorder', 'desc')->column('method_id', 'title');
echo '<script src="static/js/calendar.js"></script>';

if ($_GET['order_id']) {
    $order_id = daddslashes($_GET['order_id']);
    $order    = C::t('#payment#payment_order')->fetch($order_id);
    if (!$order) {
        cpmsg_error(lang('plugin/payment', 'order_not_exist'));
    }
    if (submitcheck('renotify_submit')) {
        //重新通知
        try {
            payment::plugin_notify($order);
            cpsuccess(lang('plugin/payment', 'plugin_status_1'), ['order_id' => $order_id]);
        } catch (PaymentException $e) {
            cpmsg_error($e->getError());
        }
    }
    if (submitcheck('info_submit')) {
        //修改订单信息
        $update = [
            'amount'   => dintval($_GET['amount'] * 100), //订单金额
            'addition' => daddslashes($_GET['addition']), //
        ];
        if ($_GET['status']) {
            $update['status'] = dintval($_GET['status']);
        }
        C::t('#payment#payment_order')->update($order_id, $update);
        cpsuccess(lang('plugin/payment', 'save'), ['order_id' => $order_id]);
    }
    if (submitcheck('refund_notify_submit') && $order['method_id'] && $order['status'] == 6 && $order['plugin_status'] == 1) {
        //调用支付接口重新退款
        try {
            //查询主订单
            $main_order = C::t('#payment#payment_order')->fetch(substr($order['subject'], 0, 20)); //主订单
            $method     = payment::load_method($order['method_id'], $main_order); //加载支付方式
            $res        = $method->refund($order['order_id'], $order['amount']); //调用支付方式退款
            $update     = ['finish_time' => TIMESTAMP, 'status' => 5];
            if ($res['refund_time']) {
                $update['finish_time'] = $res['refund_time'];
            }

            $update['finish_id'] = $res['refund_id'];
            if ($res['refund_user']) {
                $update['finish_user'] = $res['refund_user'];
            } else {
                $update['finish_user'] = $main_order['finish_user'];
            }
            C::t('#payment#payment_order')->update($order['order_id'], $update);
            cpsuccess(lang('plugin/payment', 'refund_success'), ['order_id' => $order_id]);
        } catch (PaymentMethodException $e) {
            //将错误信息记录至payment_error里面
            $error = $e->getError();
            C::t('#payment#payment_order')->update($order['order_id'], [
                'method_error' => serialize($error),
            ]);
            cpmsg_error(lang('plugin/payment', 'method_refund_fail') . $error['msg']);
        }
    }

    //订单信息
    formtableheader(['order_id' => $order_id], lang('plugin/payment', 'order_info'));
    //第一行
    showsubtitle([
        lang('plugin/payment', 'order_id'),
        cplang('subject'),
        cplang('type'),
        lang('plugin/payment', 'create_time'),
        'IP',
    ]);
    showtablerow('', ['style="width:20%"', 'style="width:20%"', 'style="width:20%"', 'style="width:20%"', 'style="width:20%"'], [
        $order['order_id'],
        $order['subject'],
        lang('plugin/payment', 'type_' . $order['is_refund']),
        empty_time($order['create_time']),
        $order['create_ip'],
    ]);
    //第二行
    showsubtitle([
        lang('plugin/payment', 'user'),
        lang('plugin/payment', 'api'),
        lang('plugin/payment', 'status'),
        lang('plugin/payment', 'expire_time'),
        lang('plugin/payment', 'cancel_time'),
    ]);
    showtablerow('', [], [
        empty_value(sql('common_member')->where('uid', $order['uid'])->value('username') . '(' . $order['uid'] . ')', lang('plugin/payment', 'guest')),
        $order['api_id'],
        payment::status($order['status']) . '&nbsp;' . showselect('status', payment::status($order['is_refund'] ? 'refund' : 'pay'), '', lang('plugin/payment', 'not_motify')),
        empty_time($order['expire_time']),
        empty_time($order['cancel_time']),
    ]);
    //第三行
    showsubtitle([
        lang('plugin/payment', 'amount'),
        lang('plugin/payment', 'addition'),
        lang('plugin/payment', 'description'),
        lang('plugin/payment', 'plugin_status'),
        lang('plugin/payment', 'method_error'),
    ]);
    showtablerow('', [], [
        '<input type="text" class="txt" name="amount" value="' . payment::amount($order['amount']) . '">',
        '<textarea class="tarea" name="addition" style="width:100%;height:60px">' . dhtmlspecialchars(dstripslashes($order['addition'])) . '</textarea>',
        empty_value($order['body']),
        lang('plugin/payment', 'plugin_status_' . $order['plugin_status']) . '&nbsp;<input class="btn" type="submit" name="renotify_submit" value="' . lang('plugin/payment', 'renotify') . '"><br>' . lang('plugin/payment', 'renotify_tips'), //插件接口通知状态
        ($order['status'] == 6 && $order['method_id'] && $order['plugin_status'] == 1 ? '<input class="btn" type="submit" name="refund_notify_submit" value="' . lang('plugin/payment', 'refund_notify_submit') . '"><br>' : '') . ($order['method_error'] ? csubase::json_encode(dunserialize($order['method_error'])) : '-'), //支付接口错误信息
    ]);
    showsubmit('info_submit', 'submit', '', '', '', false);
    formtablefooter();
    //支付详情

    formtableheader(['order_id' => $order_id], lang('plugin/payment', 'type_' . $order['is_refund']) . cplang('detail'));
    showsubtitle([
        lang('plugin/payment', 'method_id'),
        lang('plugin/payment', 'finish_time'),
        lang('plugin/payment', 'finish_id'),
        lang('plugin/payment', 'finish_user'),
    ]);
    showtablerow('', ['style="width:20%"', 'style="width:20%"', 'style="width:20%"', 'style="width:20%"', 'style="width:20%"'], [
        empty_value($methods[$order['method_id']]),
        empty_time($order['finish_time']),
        empty_value($order['finish_id']),
        empty_value($order['finish_user']),
    ]);
    formtablefooter();

    //查找关联的订单

    if ($order['is_refund']) {
        //退款订单
        $main_order = C::t('#payment#payment_order')->fetch(substr($order['subject'], 0, 20)); //主订单
        showtableheader(lang('plugin/payment', 'order_pay_info'));
        showsubtitle([
            lang('plugin/payment', 'order_id'),
            lang('plugin/payment', 'amount'),
            lang('plugin/payment', 'status'),
            lang('plugin/payment', 'plugin_status'),
            lang('plugin/payment', 'create_time'),
            lang('plugin/payment', 'addition'),
        ]);
        showtablerow('', ['style="width:20"', 'style="width:10%"', 'style="width:10%"', 'style="width:10%"', 'style="width:15%"', 'style="width:35%"'], [
            aurl($main_order['order_id'], ['order_id' => $main_order['order_id']]),
            payment::amount($main_order['amount']) . lang('plugin/payment', 'yuan'),
            payment::status_color($main_order['status']),
            lang('plugin/payment', 'plugin_status_' . $main_order['plugin_status']),
            dgmdate($main_order['create_time'], 'Y-m-d H:i:s'),
            empty_value($main_order['addition']),
        ]);
        showtablefooter();
    } else {
        //支付订单
        $refund_orders = sql('payment_order')->field('order_id,amount,create_time,status,plugin_status,addition')
            ->where('subject', $order_id . lang('plugin/payment', 'refund'))
            ->select();
        if ($refund_orders) {
            //关联的退款订单
            showtableheader(lang('plugin/payment', 'type_1'));
            showsubtitle([
                lang('plugin/payment', 'order_id'),
                lang('plugin/payment', 'amount'),
                lang('plugin/payment', 'status'),
                lang('plugin/payment', 'plugin_status'),
                lang('plugin/payment', 'create_time'),
                lang('plugin/payment', 'addition'),
            ]);
            foreach ($refund_orders as $item) {
                showtablerow('', ['style="width:20"', 'style="width:10%"', 'style="width:10%"', 'style="width:10%"', 'style="width:15%"', 'style="width:35%"'], [
                    aurl($item['order_id'], ['order_id' => $item['order_id']]),
                    payment::amount($item['amount']) . lang('plugin/payment', 'yuan'),
                    payment::status_color($item['status']),
                    lang('plugin/payment', 'plugin_status_' . $item['plugin_status']),
                    dgmdate($item['create_time'], 'Y-m-d H:i:s'),
                    empty_value($item['addition']),
                ]);
            }
            showtablefooter();
        }
        if ($order['status'] == 2) {
            //支付成功，可进行退款操作
            if (submitcheck('refund_submit')) {
                try {
                    payment::refund(
                        $order_id,
                        dintval($_GET['reback']),
                        dintval($_GET['amount'] * 100),
                        strip_tags(daddslashes($_GET['body'])),
                        daddslashes($_GET['finish_id']),
                        csubase::mktime($_GET['finish_time']),
                        daddslashes($_GET['finish_user']),
                        dintval($_GET['notify_plugin'])
                    );
                    cpsuccess(lang('plugin/payment', 'refund_success'), ['order_id' => $order_id]);
                } catch (PaymentException $e) {
                    $error = $e->getError();
                    cpmsg_error($error['msg'], $error['order_id'] ? CP_URL . http_build_query(['order_id' => $error['order_id']]) : '');
                }
            }
            formtableheader(['order_id' => $order_id], lang('plugin/payment', 'refund'));
            showsubtitle([
                lang('plugin/payment', 'refund_body'),
                lang('plugin/payment', 'refund_amount'),
                lang('plugin/payment', 'refund_finish_id'),
                lang('plugin/payment', 'refund_time'),
                lang('plugin/payment', 'refund_user'),
            ]);
            showtablerow('', ['style="width:20%"', 'style="width:20%"', 'style="width:20%"', 'style="width:20%"', 'style="width:20%"'], [
                '<input type="text" class="txt" name="body" placeholder="' . lang('plugin/payment', 'allow_empty') . '" style="width:90%">',
                '<input type="text" class="txt" name="amount" placeholder="' . lang('plugin/payment', 'refund_amount_placeholder') . '" style="width:90%">',
                '<input type="text" class="txt" name="finish_id" placeholder="' . lang('plugin/payment', 'auto_placeholder') . '" style="width:90%">',
                '<input type="text" class="txt" name="finish_time" placeholder="' . lang('plugin/payment', 'auto_placeholder') . '" style="width:90%" onclick="showcalendar(event, this,true)">',
                '<input type="text" class="txt" name="finish_user" placeholder="' . lang('plugin/payment', 'auto_placeholder') . '" style="width:90%">',

            ]);
            showsubmit('refund_submit', lang('plugin/payment', 'refund'), '', '<label><input type="checkbox" name="reback" value="1" class="checkbox" checked="">' . lang('plugin/payment', 'refund_reback') . '</label>&nbsp;<label><input type="checkbox" name="notify_plugin" value="1" class="checkbox" checked="">' . lang('plugin/payment', 'notify_plugin') . '</label>', '', false);
            formtablefooter();
        } else {
            if (submitcheck('checkpay_submit')) {
                try {
                    payment::checkpay($order_id, csubase::getMod($_GET['method_id']), true);
                    cpsuccess(lang('plugin/payment', 'order_paied'), ['order_id' => $order_id]);
                } catch (PaymentException $e) {
                    cpmsg_error($e->getMessage() . $e->getCode());
                }
            }
            if (submitcheck('supply_submit')) {
                try {
                    payment::success(
                        $order_id,
                        daddslashes($_GET['finish_user']),
                        '',
                        csubase::mktime($_GET['finish_time']),
                        daddslashes($_GET['finish_id']),
                        dintval($_GET['notify_plugin']) ? 1 : -1
                    );
                    cpsuccess(lang('plugin/payment', 'order_paied'), ['order_id' => $order_id]);
                } catch (PaymentException $e) {
                    cpmsg_error($e->getMessage() . $e->getCode());
                }
            }
            //未支付，可进行补单操作
            formtableheader(['order_id' => $order_id], lang('plugin/payment', 'method_checkpay'));
            $method_options = [];
            foreach ($methods as $key => $value) {
                $method_options[] = [$key, $value];
            }
            showsetting(lang('plugin/payment', 'method_id'), [
                'method_id', $method_options,
            ], '', 'select');
            showsubmit('checkpay_submit', 'submit', '', '', '', false);
            formtablefooter();
            formtableheader(['order_id' => $order_id], lang('plugin/payment', 'supply_title'));
            showsubtitle([
                lang('plugin/payment', 'transcation_id'),
                lang('plugin/payment', 'finish_time'),
                lang('plugin/payment', 'finish_user'),
            ]);
            showtablerow('', [], [
                '<input type="text" class="txt" name="finish_id" placeholder="' . lang('plugin/payment', 'auto_placeholder') . '" style="width:90%">',
                '<input type="text" class="txt" name="finish_time" placeholder="' . lang('plugin/payment', 'auto_placeholder') . '" style="width:90%" onclick="showcalendar(event, this,true)">',
                '<input type="text" class="txt" name="finish_user" placeholder="' . lang('plugin/payment', 'auto_placeholder') . '" style="width:90%">',
            ]);
            showsubmit('supply_submit', lang('plugin/payment', 'supply'), '', '<input type="checkbox" name="notify_plugin" value="1" class="checkbox" checked="">' . lang('plugin/payment', 'notify_plugin') . '</label>', '', false);
            formtablefooter();
        }
    }

} else {
    $urlparams = ['param', 'uid', 'method_id', 'api_id', 'status', 'begin_time', 'end_time', 'is_refund'];
    $url       = [];
    foreach ($urlparams as $key) {
        if ($_GET[$key]) {
            $url[$key] = urlencode($_GET[$key]);
        }
    }
    if (submitcheck('submit')) {
        //删除
        if ($_GET['delete']) {
            foreach ($_GET['delete'] as $key => $value) {
                C::t('#payment#payment_order')->delete(daddslashes($value));
            }
        }
        cpsuccess(lang('plugin/payment', 'delete_success'), $url);
    }
    //获取数据
    $apis    = sql('payment_api')->column('api_id', 'identifier');
    $plugins = sql('common_plugin')->whereIn('identifier', array_values($apis))->column('identifier', 'name');
    //生成select
    $method_options = [];
    foreach ($methods as $key => $value) {
        $method_options[$key] = $value . '(' . $key . ')';
    }
    $api_options = [];
    foreach ($apis as $key => $value) {
        $api_options[$key] = $plugins[$value] . '(' . $key . ')';
    }

    //生成搜索表单
    formheader(['search' => true]);
    showtableheader(lang('plugin/payment', 'search'));
    showtablerow('', [], [
        lang('plugin/payment', 'params'), '<input type="text" class="txt" name="param" value="' . $_GET['param'] . '" placeholder="' . lang('plugin/payment', 'like') . '" style="width:150px;">',
        lang('plugin/payment', 'type'), showselect('is_refund', [1 => lang('plugin/payment', 'type_0'), 2 => lang('plugin/payment', 'type_1')], $_GET['is_refund'], lang('plugin/payment', 'all')),
        'UID', '<input type="text" class="txt" name="uid" value="' . $_GET['uid'] . '" style="width:50px">',
        lang('plugin/payment', 'method_id'), showselect('method_id', $method_options, $_GET['method_id'], lang('plugin/payment', 'all')),
        lang('plugin/payment', 'api'), showselect('api_id', $api_options, $_GET['api_id'], lang('plugin/payment', 'all')),
        lang('plugin/payment', 'status'), showselect('status', payment::status(), $_GET['status'], lang('plugin/payment', 'all')),
        lang('plugin/payment', 'create_time'), '<input type="text" class="txt" name="begin_time" value="' . $_GET['begin_time'] . '" style="width:80px;margin-right: 5px;" onclick="showcalendar(event, this,true)" placeholder="' . lang('plugin/payment', 'begin_time') . '">--<input type="text" class="txt" name="end_time" value="' . $_GET['end_time'] . '" style="width:80px;margin-left: 5px;" onclick="showcalendar(event, this,true)" placeholder="' . lang('plugin/payment', 'end_time') . '">',
        '<button type="submit" class="btn">' . lang('plugin/payment', 'schbtn') . '</button>',
    ]);
    showtablefooter();
    showformfooter();
    //搜索
    $sql = sql('payment_order');

    if ($_GET['param']) {
        $sql->whereRaw("(concat_ws(',',order_id,subject,finish_id,finish_user) LIKE '%" . daddslashes($_GET['param']) . "%')");
    }
    if ($_GET['uid']) {
        $sql->where('uid', dintval($_GET['uid']));
    }
    if ($_GET['is_refund']) {
        $sql->where('is_refund', dintval($_GET['is_refund'] - 1));
    }
    if ($_GET['method_id']) {
        $sql->where('method_id', daddslashes($_GET['method_id']));
    }
    if ($_GET['api_id']) {
        $sql->where('api_id', daddslashes($_GET['api_id']));
    }
    if ($_GET['status']) {
        $sql->where('status', dintval($_GET['status']));
    }
    if ($_GET['begin_time']) {
        $sql->where('create_time', '>=', csubase::mktime($_GET['begin_time']));
    }
    if ($_GET['end_time']) {
        $sql->where('create_time', '<=', csubase::mktime($_GET['end_time']) + 59);
    }
    $page = max(1, dintval($_GET['page']));
    $num  = 20;

    $count = $sql->count();
    $list  = $sql->order('create_time', 'DESC')->page($page, $num)->select();
    $sum   = $sql->group('is_refund')->column('is_refund', 'SUM(amount)');
    formheader($url);
    showtableheader(lang('plugin/payment', 'list_cnt', ['cnt' => $count, 'pay' => $sum[0] / 100, 'refund' => $sum[1] / 100]));
    showsubtitle([
        '',
        lang('plugin/payment', 'order_id'),
        lang('plugin/payment', 'amount'),
        lang('plugin/payment', 'type'),
        lang('plugin/payment', 'subject'),
        lang('plugin/payment', 'user'),
        lang('plugin/payment', 'status'),
        lang('plugin/payment', 'create_time') . '/IP',
        lang('plugin/payment', 'api'),
        lang('plugin/payment', 'method_id'),
        lang('plugin/payment', 'finish_time_id'),
        lang('plugin/payment', 'addition'),
    ]);
    if ($list) {
        $users = sql('common_member')->whereIn('uid', array_column($list, 'uid'))->column('uid', 'username');
    }

    foreach ($list as $item) {
        showtablerow('', [], [
            '<input type="checkbox" name="delete[]" value="' . $item['order_id'] . '">',
            '<a href="' . A_URL . 'order_id=' . $item['order_id'] . '">' . $item['order_id'] . '</a>',
            payment::amount($item['amount']) . lang('plugin/payment', 'yuan'),
            lang('plugin/payment', 'type_' . $item['is_refund']),

            ($item['url'] ? '<a href="' . $item['url'] . '" target="_blank">' . $item['subject'] . '</a>' : $item['subject']),
            ($item['uid'] ? '<a href="home.php?mod=space&uid=' . $item['uid'] . '" target="_blank">' . $users[$item['uid']] . '(' . $item['uid'] . ')</a>' : lang('plugin/payment', 'guest')),
            payment::status_color($item['status']) . '<br>' . lang('plugin/payment', 'plugin_status_' . $item['plugin_status']),
            dgmdate($item['create_time'], 'Y-m-d H:i:s') . '<br>' . $item['create_ip'],
            $plugins[$apis[$item['api_id']]] . '<br>' . $item['api_id'],
            $methods[$item['method_id']] . '<br>' . $item['method_id'],
            ($item['finish_time'] ? dgmdate($item['finish_time'], 'Y-m-d H:i:s') : '') . '<br>' . $item['finish_id'],
            dhtmlspecialchars(dstripslashes($item['addition'])),
        ]);
    }
    showsubmit('submit', 'submit', 'del', '', multi($count, $num, $page, A_URL . http_build_query($url)), false);
    showtablefooter();
    showformfooter();
}

?>