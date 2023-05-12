<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (!class_exists('payment_plugin')) {
    include_once DISCUZ_ROOT . './source/plugin/payment/payment_plugin.class.php';
}
class pay_credit extends payment_plugin {
    public function __construct($order_id = '') {
        parent::__construct($order_id);
    }

    public function success() {
        //支付后的回调
        updatemembercount($this->order['uid'], array('extcredits' . $this->order['params']['credit'] => $this->order['params']['amount']), true, '', 0, '', lang('plugin/csu_pay_credit', 'plugin_name'), lang('plugin/csu_pay_credit', 'order_id') . $this->order['order_id']);
        return true;
    }
    public function refund() {
        $this->disable_multi_refund();
        //支付后的回调
        updatemembercount($this->order['uid'], array('extcredits' . $this->main_order['params']['credit'] => -$this->main_order['params']['amount']), true, '', 0, '', lang('plugin/csu_pay_credit', 'recharge_refund'), lang('plugin/csu_pay_credit', 'order_id') . $this->order['order_id']);
        return true;
    }
}
?>