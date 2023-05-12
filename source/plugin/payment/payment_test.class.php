<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (!class_exists('payment_plugin')) {
    include_once DISCUZ_ROOT . './source/plugin/payment/payment_plugin.class.php';
}
/**
 * 由于插件接口类是被动被调用的，所以在此处可以直接使用csu_base插件的sql类与csubase类，以及本插件的payment类
 * 插件接口必须包含success与refund方法，可包含cancel方法（订单取消回调）与expire方法（订单超时回调），可在此做释放订单之类操作
 * 插件接口方法调用失败请勿返回false，请throw new PaymentPluginException(string $msg,int $code,array $extra=[])
 * 插件接口方法调用成功请返回true
 */
class payment_test extends payment_plugin {
    public function __construct($order_id = '') {
        parent::__construct($order_id);
    }

    public function success() {
        //将false设置为true可演示调用success失败
        if (false) {
            throw new PaymentPluginException('payment_success_fail_demo', 233333, ['url' => 'abc']);
            /**
             * 返回的error数组格式如下
             * [
             *     'msg'=>'payment_success_fail_demo',
             *     'code'=>'233333',
             *     'url'=>'abc'
             * ]
             **/
        }
        //支付后的回调
        $content = [
            $this->order['subject'],
            lang('plugin/payment', 'order_id') . ':' . $this->order['order_id'],
            lang('plugin/payment', 'amount') . ':' . payment::amount($this->order['amount']),
            lang('plugin/payment', 'method_id') . ':' . payment::method_title($this->order['method_id']),
            lang('plugin/payment', 'status') . ':' . payment::status_color($this->order['status']),
            lang('plugin/payment', 'plugin_status') . ':' . lang('plugin/payment', 'plugin_status_' . $this->order['plugin_status']),
        ];
        csubase::system_notice($this->order['uid'], lang('plugin/payment', 'pay_success'), implode('<br>', $content));
        return true;
    }
    public function refund() {
        ///将false设置为true可演示调用refund失败，此时传入的order为主订单的退款订单，要获取主订单号可查看payment_plugin类，可通过调用disable_multi_refund禁止单笔订单多次退款
        //$this->disable_multi_refund();
        if (false) {
            throw new PaymentPluginException('method_refund_fail_demo', 233333, ['url' => 'abc']);
            /**
             * 返回的error数组格式如下
             * [
             *     'msg'=>'method_refund_fail_demo',
             *     'code'=>'233333',
             *     'url'=>'abc'
             * ]
             **/
            //退款后的回调
        }
        $content = [
            $this->order['subject'],
            lang('plugin/payment', 'out_refund_id') . ':' . $this->order['order_id'],
            lang('plugin/payment', 'refund_amount') . ':' . payment::amount($this->order['amount']),
            lang('plugin/payment', 'status') . ':' . payment::status_color($this->order['status']),
            lang('plugin/payment', 'plugin_status') . ':' . lang('plugin/payment', 'plugin_status_' . $this->order['plugin_status']),
        ];
        csubase::system_notice($this->order['uid'], lang('plugin/payment', 'refund_success'), implode('<br>', $content));
        return true;
    }

    public function cancel() {
        //将false设置为true可演示调用success失败
        if (false) {
            throw new PaymentPluginException('payment_cancel_fail_demo', 233333, ['url' => 'abc']);
            /**
             * 返回的error数组格式如下
             * [
             *     'msg'=>'payment_cancel_fail_demo',
             *     'code'=>'233333',
             *     'url'=>'abc'
             * ]
             **/
        }
        //取消订单后的回调
        $content = [
            $this->order['subject'],
            lang('plugin/payment', 'order_id') . ':' . $this->order['order_id'],
            lang('plugin/payment', 'amount') . ':' . payment::amount($this->order['amount']),
            lang('plugin/payment', 'method_id') . ':' . payment::method_title($this->order['method_id']),
            lang('plugin/payment', 'status') . ':' . payment::status_color($this->order['status']),
            lang('plugin/payment', 'plugin_status') . ':' . lang('plugin/payment', 'plugin_status_' . $this->order['plugin_status']),
        ];
        csubase::system_notice($this->order['uid'], lang('plugin/payment', 'cancel_success'), implode('<br>', $content));
        return true;
    }
    public function expire() {
        //将false设置为true可演示调用success失败
        if (false) {
            throw new PaymentPluginException('payment_expire_fail_demo', 233333, ['url' => 'abc']);
            /**
             * 返回的error数组格式如下
             * [
             *     'msg'=>'payment_expire_fail_demo',
             *     'code'=>'233333',
             *     'url'=>'abc'
             * ]
             **/
        }
        //取消订单后的回调
        $content = [
            $this->order['subject'],
            lang('plugin/payment', 'order_id') . ':' . $this->order['order_id'],
            lang('plugin/payment', 'amount') . ':' . payment::amount($this->order['amount']),
            lang('plugin/payment', 'method_id') . ':' . payment::method_title($this->order['method_id']),
            lang('plugin/payment', 'status') . ':' . payment::status_color($this->order['status']),
            lang('plugin/payment', 'plugin_status') . ':' . lang('plugin/payment', 'plugin_status_' . $this->order['plugin_status']),
        ];
        csubase::system_notice($this->order['uid'], lang('plugin/payment', 'expire_success'), implode('<br>', $content));
        return true;
    }
}
?>