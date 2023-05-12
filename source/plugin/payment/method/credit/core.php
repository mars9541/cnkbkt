<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
//加载类
if (!class_exists('payment_method')) {
    include_once DISCUZ_ROOT . './source/plugin/payment/payment_method.class.php';
}

/**
 * 请勿修改类名
 */
class payment_credit extends payment_method {

    public function __construct($order_id = '') {
        $this->method_id = 'credit';
        $this->order_id  = $order_id;
        parent::__construct();
    }

    private function pay() {
        global $_G;
        try {
            sql::transaction();
            $credit = getuserprofile('extcredits' . $this->setting['credit']); //余额
            $amount = ceil($this->order['amount'] / 100 * $this->setting['fee']); //订单金额
            if ($credit < $amount) {
                throw new PaymentMethodException($this->lang('amount_not_enough'), 30001, [
                    'sub_code' => 'amount_not_enough',
                    'url'      => $this->setting['payurl'],
                ]);
            }
            //扣除积分
            updatemembercount($_G['uid'], ['extcredits' . $this->setting['credit'] => -$amount], true, '', 0, '', lang('plugin/payment', 'navtitle'), lang('plugin/payment', 'order_no') . $this->order_id);
            //记录扣除的积分数量
            $params                  = $this->order['params'];
            $params['credit_id']     = $this->setting['credit'];
            $params['credit_amount'] = $amount;
            sql('payment_order')->where('order_id', $this->order_id)->update([
                'params' => serialize($params),
            ]);
            parent::success($_G['uid'], TIMESTAMP);
            sql::commit();
            return ['msg' => $this->lang('pay_success')];
        } catch (PaymentMethodException $e) {
            sql::rollback();
            throw $e; //抛异常给上级
        }
    }

    public function page() {
        global $_G;
        if (!$_G['uid']) {
            //未登录请选择其他支付方式
            throw new PaymentMethodException('<a href="member.php?mod=logging&action=login" onclick="showWindow(\'login\', this.href);return false;" class="xi2">' . $this->lang('login') . '</a>', 30101);
        }
        if (submitcheck('creditsubmit')) {
            return $this->pay();
        }
        $amount = sprintf("%.2f", floor(getuserprofile('extcredits' . $this->setting['credit']) / $this->setting['fee'])); //余额
        return [
            'msg'  => $this->lang('amounts') . '<span class="xi1">' . $amount . lang('plugin/payment', 'yuan') . '</span>' . ($this->setting['payurl'] ? '&nbsp;<a class="xi2" href="' . $this->setting['payurl'] . '">' . lang('plugin/payment', 'recharge') . '</a>' : '') . '<br><button type="button" id="creditsubmit" class="dqzhiyu-btn dqzhiyu-btn-blue dqzhiyu-btn-sm">' . lang('plugin/payment', 'pay') . '</button>',
            'eval' => '
jQuery("#creditsubmit").click(function(){
    jQuery("#creditsubmit").attr("disabled",true).addClass("dqzhiyu-btn-disabled");
    jQuery.post(window.location.href,{
        method_id:"credit",
        formhash:"' . FORMHASH . '",
        pagesubmit:true,
        creditsubmit:true
    },function(res){
        if(res.code!=200){
            showDialog(res.msg,"alert","' . $this->lang('pay_fail') . '",function(){
                if(res.url)
                    window.location.href = res.url;
                else
                    jQuery("#creditsubmit").attr("disabled",false).removeClass("dqzhiyu-btn-disabled");
            });
        }else{
            checkPay();
        }
    });
})',
        ];
    }
    /**
     * 手机支付
     * @return   [type]                  [description]
     */
    public function wap() {
        $res = $this->pay();
        //支付成功
        showmessage(lang('plugin/payment', 'pay_success'), 'plugin.php?id=payment&order_id=' . $this->order_id);
    }

    public function refund($out_refund_id, $amount = 0) {

        if ($amount == $this->order['amount']) {
            //退款全部积分
            $credit = $this->order['params']['credit_amount'];
        } else {
            $credit = ceil($amount / $this->order['amount'] * $this->order['params']['credit_amount']);
            //查询该订单下所有退款订单，兼容因为小数点带来的误差
            $refunds = sql('payment_order')->where('is_refund', 1)
                ->where('subject', $this->order_id . lang('plugin/payment', 'refund'))
                ->where('plugin_status', 1)
                ->column('params');
            $refund_credit = 0;
            foreach ($refunds as $value) {
                $value = dunserialize($value);
                $refund_credit += $value['credit'];
            }
            if ($refund_credit >= $this->order['params']['credit_amount']) {
                $credit = 0; //积分已退款完
            } elseif ($refund_credit + $credit >= $this->order['params']['credit_amount']) {
                $credit = $this->order['params']['credit_amount'] - $refund_credit; //退款积分超过总积分
            }
            $credit = max(0, $credit);
        }
        if ($credit) {
            $refund_order     = C::t('#payment#payment_order')->fetch($out_refund_id);
            $params           = $refund_order['params'];
            $params['credit'] = $credit;
            C::t('#payment#payment_order')->update($out_refund_id, ['params' => serialize($params)]);
        }

        if ($credit > 0) {
            updatemembercount($this->order['uid'], ['extcredits' . $this->order['params']['credit_id'] => $credit], true, '', 0, '', lang('plugin/payment', 'order_refund'), lang('plugin/payment', 'order_id') . ':' . $this->order_id . '<br>' . lang('plugin/payment', 'out_refund_id') . ':' . $out_refund_id);
        }

        return ['refund_time' => TIMESTAMP];
    }

}
?>