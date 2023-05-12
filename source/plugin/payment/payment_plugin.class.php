<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class payment_plugin {
    public function __construct($order_id = '') {
        //获取订单
        $this->order    = C::m('#payment#payment')->load_order($order_id, $order, true);
        $this->order_id = $this->order['order_id'];
        if ($this->order['is_refund']) {
            //退款订单获取主订单
            $this->main_order_id = substr($this->order['subject'], 0, 20);
            $this->main_order    = C::m('#payment#payment')->load_order($this->main_order_id);
        }
    }
    /**
     * 退款时调用此方法可禁止单笔订单多次退款
     */
    public function disable_multi_refund() {
        if ($this->main_order['amount'] != $this->order['amount']) {
            throw new PaymentPluginException(lang('plugin/payment', 'order_refund_mustall'), 800);
        }
    }
}
?>