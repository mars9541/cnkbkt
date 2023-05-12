<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
C::m('#payment#payment');
class payment_method {
    protected $order; //订单
    protected $order_id; //订单号order_id
    protected $method_id; //支付接口id
    protected $setting; //支付接口设置
    public $method; //数据库中支付接口

    public function __construct() {
        if ($this->method_id) {
            $this->method = C::t('#payment#payment_method')->fetch($this->method_id);
            if (!$this->method['available']) {
                throw new PaymentMethodException(lang('plugin/payment', 'paymethod_unavailable'), 900); //支付方式不可用
            }
            $this->setting = $this->method['setting'];
        }
        if ($this->order_id) {
            $this->order($this->order_id);
        }
    }
    /**
     * 加载订单
     * @DateTime 2021-02-14
     * @param    [type]     $order [description]
     * @return   [type]            [description]
     */
    public function order($order) {
        if (is_array($order)) {
            $this->order    = $order;
            $this->order_id = $order['order_id'];
        } else {
            $this->order = C::t('#payment#payment_order')->fetch($order);
            if (!$this->order) {
                return false;
            }
        }

        return $this;
    }
    /**
     * 校验订单支付状态
     * @DateTime 2021-02-14
     * @return   [type]     [description]
     */
    public function checkpay_error() {
        throw new PaymentMethodException(lang('plugin/payment', 'unpaied'), 901); //默认未支付
    }

    /**
     * 支付成功
     * @DateTime 2021-02-14
     * @return   [type]     [description]
     */
    public function success($finish_user = '', $finish_time = 0, $finish_id = '', $forcenotify = 0) {
        return payment::success($this->order, $finish_user, $this->method_id, $finish_time, $finish_id, $forcenotify);
    }
    /**
     * 获取语言包
     * @DateTime 2021-03-14
     * @param    [type]     $key [description]
     * @return   [type]          [description]
     */
    public function lang($key) {
        return method_lang($this->method_id, $key);
    }
    /**
     * 日志
     * @DateTime 2021-03-14
     * @param    string     $type_method [description]
     * @param    integer    $status      [description]
     * @param    array      $params      [description]
     * @param    array      $result      [description]
     * @param    string     $comment     [description]
     * @return   [type]                  [description]
     */
    public function log($type_method = '', $status = 0, $params = [], $result = [], $comment = '') {
        return C::m('#payment#payment')->log($this->order['order_id'], 1, $this->method_id, $type_method, $status, $params, $result, $comment);
    }
}
?>