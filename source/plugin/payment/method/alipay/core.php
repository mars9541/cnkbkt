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
class payment_alipay extends payment_method {

    public function __construct($order_id = '') {
        $this->method_id = 'alipay';
        $this->order_id  = $order_id;
        parent::__construct();
    }
    /**
     * PC支付
     */
    public function page() {
        global $_G;
        $api  = 'alipay.trade.precreate';
        $_api = str_replace('.', '_', $api);
        if (!$this->order['method_extends'][$_api]) {
            $res = $this->get_api($api, [
                'notify_url'  => $_G['siteurl'] . 'source/plugin/payment/method/alipay/notify.php',
                'biz_content' => [
                    'out_trade_no'            => $this->order_id,
                    'total_amount'            => $this->order['amount'] / 100,
                    'subject'                 => $this->order['subject'],
                    'qr_code_timeout_express' => intval(($this->order['expire_time'] - TIMESTAMP) / 60) . 'm',
                ],
            ]);
            $this->order['method_extends'][$_api] = $res['qr_code'];
            C::t('#payment#payment_order')->update($this->order_id, [
                'method_extends' => serialize($this->order['method_extends']),
            ]);
        }
        return [
            'paycheck' => true,
            'msg'      => '<img src="plugin.php?id=payment:pay&qrcode=true&formhash=' . FORMHASH . '&url=' . urlencode($this->order['method_extends'][$_api]) . '" title="' . $this->lang('scan') . '" alt="' . $this->lang('scan') . '"><br>' . $this->lang('scan'),
        ];
    }
    /**
     * 手机支付
     */
    public function wap() {
        global $_G;
        $url = $this->get_api('alipay.trade.wap.pay', [
            'return_url'  => $_G['siteurl'] . 'source/plugin/payment/method/alipay/return.php',
            'notify_url'  => $_G['siteurl'] . 'source/plugin/payment/method/alipay/notify.php',
            'biz_content' => [
                'out_trade_no' => $this->order_id, //debug 随机加上字符串
                'total_amount' => number_format($this->order['amount'] / 100, 2),
                'subject'      => $this->order['subject'],
                'time_expire'  => dgmdate($this->order['expire_time'], 'Y-m-d H:i:s'),
            ],
            'mobile'      => $_GET['mobile'],
        ], true);

        dheader('location:' . $url);
    }
    /**
     * 校验支付结果
     */
    public function checkpay() {
        $query = $this->query();
        if ($query['trade_status'] == 'TRADE_SUCCESS') {
            //已支付
            return [
                'finish_user' => daddslashes($query['buyer_user_id']),
                'finish_time' => csubase::mktime($query['send_pay_date']),
                'finish_id'   => daddslashes($_POST['trade_no']),
            ];
        }
        parent::checkpay_error();
    }
    /**
     * 退款
     */
    public function refund($out_refund_id, $amount = 0) {
        $res = $this->get_api('alipay.trade.refund', [
            'biz_content' => [
                'out_trade_no'   => $this->order_id,
                'out_request_no' => $out_refund_id,
                'refund_amount'  => $amount / 100,
            ],
        ]);

        if ($res['code'] != 10000) {
            throw new PaymentMethodException($res['sub_msg'], 20101, ['method_code' => $res['sub_code']]);

        }
        return [
            'refund_id'   => $res['refund_settlement_id'],
            'refund_time' => $res['gmt_refund_pay'] ? csubase::mktime($res['gmt_refund_pay']) : TIMESTAMP,
        ];
    }
    /**
     * 查询订单
     */
    public function query() {
        $res = $this->get_api('alipay.trade.query', [
            'biz_content' => [
                'out_trade_no' => $this->order_id,
            ],
        ]);
        return $res;
    }
    /**
     * 生成待校验参数
     */
    public function make_str($data) {
        ksort($data);
        $content = array();
        foreach ($data as $key => $value) {
            $content[] = $key . '=' . (is_array($value) ? csubase::json_encode($value) : $value);
        }
        $content = implode('&', $content);
        return $content;
    }
    /**
     * 生成签名
     */
    private function make_sign($data) {
        if (!$this->setting['app_private_key']) {
            throw new PaymentMethodException($this->lang('lose_app_private_key'), 20001, ['method_code' => 'lose_app_private_key']);
        }

        $private_key = $this->setting['app_private_key'];
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" .
        wordwrap($private_key, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        openssl_sign($data, $sign, $private_key, OPENSSL_ALGO_SHA256);
        if (!$sign) {
            throw new PaymentMethodException($this->lang('fail_app_private_key'), 20002, ['method_code' => 'fail_app_private_key']);
        }
        return base64_encode($sign);
    }
    /**
     * 验证签名
     */
    public function verify($data, $sign) {
        if (!$this->setting['alipay_public_key']) {
            throw new PaymentMethodException($this->lang('lose_alipay_public_key'), 20004, ['method_code' => 'lose_alipay_public_key']);
        }
        $res = "-----BEGIN PUBLIC KEY-----\n" .
        wordwrap($this->setting['alipay_public_key'], 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        $result = (openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1);
        openssl_free_key($res);
        return $result;
    }
    /**
     * 调用API
     */
    private function get_api($api, $params, $no_curl = false) {
        $data = array_merge([
            'app_id'    => $this->setting['appid'],
            'method'    => $api,
            'format'    => 'JSON',
            'charset'   => 'utf-8',
            'sign_type' => 'RSA2',
            'timestamp' => dgmdate(TIMESTAMP, 'Y-m-d H:i:s'),
            'version'   => '1.0',
        ], $params);
        $data['sign']        = $this->make_sign($this->make_str($data));
        $data['biz_content'] = csubase::json_encode($data['biz_content']);
        $url                 = $this->setting['gateway'] . '?' . http_build_query($data);

        if ($no_curl) {
            //直接返回url
            $this->log($api, 1, $data, ['url' => $url]);
            return $url;
        }

        $res = dfsockopen($url);
        if (!$res) {
            $this->log($api, 0, $data, [], 'http error');
            throw new PaymentMethodException($this->lang('gateway_error'), 20003, ['method_code' => str_replace('.', '_', $api) . '_fail']);
        }
        $result = csubase::json_decode($res);
        $res    = $result[str_replace('.', '_', $api) . '_response'];
        if ($res['code'] != '10000') {
            $this->log($api, 0, $data, $result, $res['sub_msg']);
            throw new PaymentMethodException($this->lang('gateway_error') . $res['sub_msg'], 20004, ['method_code' => $res['sub_code']]);
        }
        $this->log($api, 1, $data, $result);
        return $res;
    }
}
?>