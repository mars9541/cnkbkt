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
class payment_qpay extends payment_method {
    public function __construct($order_id = '') {
        $this->method_id = 'qpay';
        $this->order_id  = $order_id;
        parent::__construct();
    }
    /**
     * 扫码支付
     */
    public function page() {
        $res = $this->unifiedorder();
        return [
            'paycheck' => true,
            'msg'      => '<img src="plugin.php?id=payment:pay&qrcode=true&formhash=' . FORMHASH . '&url=' . urlencode($res) . '" title="' . $this->lang('scan') . '" alt="' . $this->lang('scan') . '"><br>' . $this->lang('scan'),
        ];
    }
    /**
     * 手机支付
     */
    public function wap() {
        $res = $this->unifiedorder();
        dheader('location:' . $res);
    }
    /**
     * 下单
     */
    private function unifiedorder() {
        global $_G;
        if (!$this->order['method_extends']['qpay_unified_order']) {
            $params = [
                'mch_id'           => $this->setting['mch_id'],
                'nonce_str'        => md5(uniqid(microtime(true), true)),
                'body'             => $this->order['subject'],
                'out_trade_no'     => $this->order_id,
                'total_fee'        => $this->order['amount'],
                'spbill_create_ip' => $_G['clientip'],
                'time_expire'      => dgmdate($this->order['expire_time'], 'YmdHis'),
                'notify_url'       => $_G['siteurl'] . 'source/plugin/payment/method/qpay/notify.php',
                'trade_type'       => 'NATIVE',
            ];
            $res                                                 = $this->request('https://qpay.qq.com/cgi-bin/pay/qpay_unified_order.cgi', $params);
            $this->order['method_extends']['qpay_unified_order'] = $res['code_url'];
            C::t('#payment#payment_order')->update($this->order_id, [
                'method_extends' => serialize($this->order['method_extends']),
            ]);
        }

        return $this->order['method_extends']['qpay_unified_order'];
    }
    /**
     * 退款
     */
    public function refund($out_refund_id, $amount = 0) {
        if (!$this->setting['op_user_passwd']) {
            throw new PaymentMethodException($this->lang('lost_op_user_passwd'), 30101, ['method_code' => 'lost_op_user_passwd']);
        }
        $params = [
            'mch_id'         => $this->setting['mch_id'],
            'nonce_str'      => md5(uniqid(microtime(true), true)),
            'out_trade_no'   => $this->order_id,
            'out_refund_no'  => $out_refund_id,
            'refund_fee'     => $amount,
            'op_user_id'     => $this->setting['op_user_id'] ? $this->setting['op_user_id'] : $this->setting['mch_id'],
            'op_user_passwd' => $this->setting['op_user_passwd'],
        ];
        $res = $this->request('https://api.qpay.qq.com/cgi-bin/pay/qpay_refund.cgi', $params, true);

        return [
            'refund_time' => TIMESTAMP,
            'refund_id'   => $res['refund_id'],
        ];
    }

    /**
     * 校验支付结果
     */
    public function checkpay() {
        $params = [
            'mch_id'       => $this->setting['mch_id'],
            'nonce_str'    => md5(uniqid(microtime(true), true)),
            'out_trade_no' => $this->order_id,
        ];
        $res = $this->request('https://qpay.qq.com/cgi-bin/pay/qpay_order_query.cgi', $params);
        if ($res['trade_state'] == 'SUCCESS') {
            //已支付
            return [
                'finish_user' => daddslashes($res['openid']),
                'finish_time' => mktime(substr($res['time_end'], 8, 2), substr($res['time_end'], 10, 2), substr($res['time_end'], 12, 2), substr($res['time_end'], 4, 2), substr($res['time_end'], 6, 2), substr($res['time_end'], 0, 4)),
                'finish_id'   => daddslashes($res['transaction_id']),
            ];
        }
        parent::checkpay_error();
    }
    /**
     * 生成签名
     */
    private function makeSign($params) {
        if (!$this->setting['mch_key']) {
            throw new PaymentMethodException($this->lang('lose_mch_key'), 30001, ['method_code' => 'lose_mch_key']);
        }
        ksort($params);
        $stringA = '';
        foreach ($params as $key => $value) {
            if ($key == 'sign') {
                continue;
            }

            $stringA .= $key . '=' . $value . '&';
        }
        $stringSignTemp = $stringA . 'key=' . $this->setting['mch_key'];
        $sign           = strtoupper(md5($stringSignTemp));
        return $sign;
    }
    /**
     * 生成xml
     */
    private function toXml($params) {
        $code = '<xml>';
        foreach ($params as $key => $value) {
            $code .= "\n<{$key}>{$value}</{$key}>";
        }
        $code .= "\n</xml>";
        return $code;
    }
    /**
     * 结果
     */
    public function result($return_msg = '') {
        $return_code = !$return_msg ? 'SUCCESS' : 'FAIL';
        return '<xml><return_code><![CDATA[' . $return_code . ']]></return_code><return_msg><![CDATA[' . $return_msg . ']]></return_msg></xml>';
    }
    /**
     * 校验sign
     */
    public function check($data) {
        return $this->makeSign($data) == $data['sign'];
    }
    /**
     * xml转换为array
     */
    public function toArray($xml) {
        libxml_disable_entity_loader(true);
        $res = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $res;
    }
    /**
     * 调用接口请求
     */
    private function request($url, $params, $needCert = false) {
        $data         = csubase::iconv($params, CHARSET, 'utf-8');
        $data['sign'] = $this->makeSign($data); //生成sign
        $xml          = $this->toXml($data); //生成xml
        $method       = end(explode('/', $url));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CAINFO, PAYMENT_METHOD_ROOT . 'qpay/rootca.pem');

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        if ($needCert) {
            //需要证书
            if (!$this->setting['apiclient_cert']) {
                throw new PaymentMethodException($this->lang('lost_apiclient_cert'), 30002, ['method_code' => 'lost_apiclient_cert']);
            }
            if (!$this->setting['apiclient_key']) {
                throw new PaymentMethodException($this->lang('lost_apiclient_key'), 30003, ['method_code' => 'lost_apiclient_key']);
            }
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, DISCUZ_ROOT . './' . $this->setting['apiclient_cert']);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, DISCUZ_ROOT . './' . $this->setting['apiclient_key']);
        }
        $res = curl_exec($ch);
        if ($res === false) {
            $error = curl_error($ch);
            curl_close($ch);
            $this->log($method, 0, $params, ['curl_error' => $error], $data['sign']);
            throw new PaymentMethodException('curl_error' . $error, 30004);
        }
        curl_close($ch);

        $result = $this->toArray($res);
        if (!$result) {
            $this->log($method, 0, $params, ['result' => csubase::iconv($res, 'UTF-8', CHARSET)], $data['sign']);
            throw new PaymentMethodException('page_error', 30005);
        }
        $res = csubase::iconv($result, 'UTF-8', CHARSET);
        if ($res['return_code'] != 'SUCCESS') {
            //原始错误
            $this->log($method, 0, $params, $res, $data['sign']);
            throw new PaymentMethodException($res['retmsg'], 30006, $res);
        }
        if ($res['result_code'] != 'SUCCESS') {
            //接口业务规则错误
            $this->log($method, 0, $params, $res, $data['sign']);
            throw new PaymentMethodException($res['err_code_des'], 30007, $res);
        }
        $this->log($method, 1, $params, $res, $data['sign']);
        return $res;
    }
}
?>