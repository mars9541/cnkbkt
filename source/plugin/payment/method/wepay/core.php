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
class payment_wepay extends payment_method {
    public function __construct($order_id = '') {
        $this->method_id = 'wepay';
        $this->order_id  = $order_id;
        parent::__construct();
    }
    /**
     * PC支付
     * @return   [type]        [description]
     */
    public function page() {
        $res = $this->unifiedorder('NATIVE');
        return [
            'paycheck' => true,
            'msg'      => '<img src="plugin.php?id=payment:pay&qrcode=true&formhash=' . FORMHASH . '&url=' . urlencode($res['code_url']) . '" title="' . $this->lang('scan') . '" alt="' . $this->lang('scan') . '"><br>' . $this->lang('scan'),
        ];
    }
    public function wap() {
        global $_G;

        //判断是否在微信浏览器内部
        if (stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            //判断是否有openid
            if (!getcookie('payment_wepay_openid')) {
                if ($_GET['state']) {
                    $res = dfsockopen('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->setting['appid'] . '&secret=' . $this->setting['appsecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
                    $res = json_decode($res, true);
                    if (!$res['openid']) {
                        //微信openid获取失败
                        showmessage($this->lang('openid_failed'));
                    }
                    $openid = $res['payment_wepay_openid'];
                    dsetcookie('payment_wepay_openid', $res['openid'], 86400 * 30);
                } else {
                    dheader('location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->setting['appid'] . '&redirect_uri=' . urlencode($_G['siteurl'] . substr($_SERVER['REQUEST_URI'], 1)) . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect');

                }
            } else {
                $openid = getcookie('payment_wepay_openid');
            }
            $res = $this->unifiedorder('JSAPI', $openid);

            //print_r($res);
            $wcpay = [
                'appId'     => $this->setting['appid'],
                'timeStamp' => (string) TIMESTAMP,
                'nonceStr'  => md5(uniqid(microtime(true), true)),
                'package'   => 'prepay_id=' . $res['prepay_id'],
                'signType'  => 'MD5',
            ];
            $wcpay['paySign'] = $this->makeSign($wcpay);
            //支付成功
            return "<script>
function onBridgeReady(){
    WeixinJSBridge.invoke(
      'getBrandWCPayRequest', " . json_encode($wcpay) . " ,
      function(res){
      if(res.err_msg == 'get_brand_wcpay_request:ok'){
        alert('" . $this->lang('pay_success') . "');
        window.location.href='plugin.php?id=payment&order_id=" . $this->order_id . "';
      }
   });
}
if (typeof WeixinJSBridge == 'undefined'){
   if( document.addEventListener ){
       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
   }else if (document.attachEvent){
       document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
   }
}else{
   onBridgeReady();
};
</script>";
        } else {
            $res = $this->unifiedorder('MWEB', '', csubase::json_encode([
                'h5_info' => [
                    'type'     => "Wap",
                    "wap_url"  => $_G['setting']['siteurl'],
                    "wap_name" => $_G['setting']['sitename'],
                ],
            ]));

            dheader('location:' . $res['mweb_url']);
        }
    }
    public function refund($out_refund_id) {
        $params = [
            'appid'         => $this->setting['appid'],
            'mch_id'        => $this->setting['mch_id'],
            'nonce_str'     => md5(uniqid(microtime(true), true)),
            'sign_type'     => 'MD5',
            'out_trade_no'  => $this->order_id,
            'out_refund_no' => $out_refund_id,
            'total_fee'     => $this->order['amount'],
            'refund_fee'    => $this->order['amount'],
        ];
        $res = $this->request('secapi/pay/refund', $params, true);

        return ['refund_time' => TIMESTAMP, 'refund_id' => $res['refund_id']];
    }
    private function unifiedorder($trade_type, $openid = '', $scene = '') {
        global $_G;
        if (!$this->order['method_extends']['wepay_' . $trade_type]) {
            $params = [
                'appid'            => $this->setting['appid'],
                'mch_id'           => $this->setting['mch_id'],
                'nonce_str'        => md5(uniqid(microtime(true), true)),
                'sign_type'        => 'MD5',
                'body'             => $this->order['subject'],
                'out_trade_no'     => $this->order_id,
                'total_fee'        => $this->order['amount'],
                'spbill_create_ip' => $_G['clientip'],
                'time_expire'      => dgmdate($this->order['expire_time'], 'YmdHis'),
                'notify_url'       => $_G['siteurl'] . 'source/plugin/payment/method/wepay/notify.php',
                'trade_type'       => $trade_type,
            ];
            if ($openid) {
                $params['openid'] = $openid;
            }
            if ($scene) {
                $params['scene_info'] = $scene;
            }
            $res                                                   = $this->request('pay/unifiedorder', $params);
            $this->order['method_extends']['wepay_' . $trade_type] = $res;
            C::t('#payment#payment_order')->update($this->order_id, [
                'method_extends' => serialize($this->order['method_extends']),
            ]);
        }
        return $this->order['method_extends']['wepay_' . $trade_type];
    }
    public function checkpay() {
        $params = [
            'appid'        => $this->setting['appid'],
            'mch_id'       => $this->setting['mch_id'],
            'nonce_str'    => md5(uniqid(microtime(true), true)),
            'out_trade_no' => $this->order_id,
        ];
        $res = $this->request('pay/orderquery', $params);
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
    private function makeSign($params) {
        if (!$this->setting['mch_key']) {
            throw new PaymentMethodException($this->lang('lost_mch_key'), 40001);
        }
        ksort($params);
        $stringA = '';
        foreach ($params as $key => $value) {
            if ($key == 'sign') {
                continue;
            }

            $stringA .= $key . '=' . $value . '&';
        }
        $stringSignTemp = csubase::iconv($stringA . 'key=' . $this->setting['mch_key'], CHARSET, 'utf-8');
        $sign           = strtoupper(md5($stringSignTemp));
        return $sign;
    }
    private function toXml($params) {
        $code = '<xml>';
        foreach ($params as $key => $value) {
            $code .= "\n<{$key}>{$value}</{$key}>";
        }
        $code .= "\n</xml>";
        return $code;
    }
    public function result($return_msg = 'OK') {
        $return_code = $return_msg == 'OK' ? 'SUCCESS' : 'FAIL';
        return '<xml><return_code><![CDATA[' . $return_code . ']]></return_code><return_msg><![CDATA[' . $return_msg . ']]></return_msg></xml>';

    }
    public function check($data) {
        return $this->makeSign($data) == $data['sign'];
    }
    public function toArray($xml) {
        libxml_disable_entity_loader(true);
        $res = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $res;
    }
    private function request($url, $data, $needCert = false) {
        if ($data['scene_info']) {
            $scene_info = $data['scene_info'];
            unset($data['scene_info']);
        }
        $data = csubase::iconv($data, CHARSET, 'utf-8');
        if ($scene_info) {
            $data['scene_info'] = $scene_info;
        }
        $data['sign'] = $this->makeSign($data);
        $xml          = $this->toXml($data);

        $ch = curl_init($this->setting['gateway'] . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CAINFO, PAYMENT_METHOD_ROOT . 'wepay/rootca.pem');

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        if ($needCert) {
            if (!$this->setting['apiclient_cert']) {
                throw new PaymentMethodException($this->lang('lost_apiclient_cert'), 40002);
            }
            if (!$this->setting['apiclient_key']) {
                throw new PaymentMethodException($this->lang('lost_apiclient_key'), 40003);
            }
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, DISCUZ_ROOT . './' . $this->setting['apiclient_cert']);
            //默认格式为PEM，可以注释
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, DISCUZ_ROOT . './' . $this->setting['apiclient_key']);
        }
        $res = curl_exec($ch);
        if ($res === false) {
            $error = curl_error($ch);
            curl_close($ch);
            $this->log($method, 0, $data, ['curl_error' => $error], $data['sign']);
            throw new PaymentMethodException('curl_error' . $error, 40004);
        }
        curl_close($ch);
        $result = $this->toArray($res);
        if (!$result) {
            $this->log($method, 0, $data, ['result' => csubase::iconv($res, 'UTF-8', CHARSET)], $data['sign']);
            throw new PaymentMethodException('page_error', 40005);
        }
        $res = csubase::iconv($result, 'UTF-8', CHARSET);
        if ($res['return_code'] != 'SUCCESS') {
            //原始错误
            $this->log($method, 0, $data, $res, $data['sign']);
            throw new PaymentMethodException($res['return_msg'], 40006, $res);
        }
        if ($res['result_code'] != 'SUCCESS') {
            //接口业务规则错误
            $this->log($method, 0, $data, $res, $data['sign']);
            throw new PaymentMethodException($res['err_code_des'], 40007, $res);
        }
        $this->log($method, 1, $data, $res, $data['sign']);
        return $res;
    }
}
?>