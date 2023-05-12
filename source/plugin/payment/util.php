<?php
if (!defined('IN_DISCUZ')) {
    exit('Access denid');
}
define('PAYMENT_METHOD_ROOT', DISCUZ_ROOT . './source/plugin/payment/method/');

$methodlang = [];
/**
 * 支付接口语言包
 * @DateTime 2021-02-14
 * @param    string     $method_id 支付接口id
 * @param    string     $text       语言包标识
 * @return   string                 语言包文本
 */
function method_lang($method_id, $text) {
    global $methodlang;
    if (!isset($methodlang[$method_id])) {
        if (is_file(PAYMENT_METHOD_ROOT . $method_id . '/lang.' . currentlang() . '.php')) {
            include PAYMENT_METHOD_ROOT . $method_id . '/lang.' . currentlang() . '.php';
            $methodlang[$method_id] = $plang;
        } elseif (is_file(PAYMENT_METHOD_ROOT . $method_id . '/lang.php')) {
            include PAYMENT_METHOD_ROOT . $method_id . '/lang.php';
            $methodlang[$method_id] = $plang;
        }
    }
    return $methodlang[$method_id][$text];
}
class PaymentException extends Exception {
    public function __construct($message, $code = 0, $extra = []) {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->code    = $code;
        $this->extra   = $extra;
    }

    public function getError() {
        $return = [
            'msg'  => $this->message,
            'code' => $this->code,
        ];
        if ($this->extra) {
            $return = array_merge($return, $this->extra);
        }
        return $return;
    }
    public function __set($name, $value) {
        $this->$name = $value;
    }
}
/**
 * 支付接口异常类
 */
class PaymentMethodException extends PaymentException {
    public function __construct($message, $code = 0, $extra = []) {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->code    = $code;
        $this->extra   = $extra;
    }

    public function doParent() {
        throw new PaymentException($this->message, $this->code, $this->extra);
    }
}
/**
 * 插件接口异常类
 */
class PaymentPluginException extends PaymentException {
    public function __construct($message, $code = 0, $extra = []) {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->code    = $code;
        $this->extra   = $extra;
    }

    public function doParent() {
        throw new PaymentException($this->message, $this->code, $this->extra);
    }
}
?>