<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class AlipayService{

    protected $appId;
    protected $returnUrl;
    protected $notifyUrl;
    protected $charset;
    protected $alipayPublicKey;
    protected $rsaPrivateKey;
    protected $totalFee;
    protected $outTradeNo;
    protected $orderName;
    protected $signType;

    public function __construct(){
        $this->charset = CHARSET;
    }

    public function setAppid($appid){
        $this->appId = $appid;
    }

    public function setReturnUrl($returnUrl){
        $this->returnUrl = $returnUrl;
    }

    public function setNotifyUrl($notifyUrl){
        $this->notifyUrl = $notifyUrl;
    }

    public function setRsaPrivateKey($saPrivateKey){
        $this->rsaPrivateKey = $saPrivateKey;
    }

    public function alipayPublicKey($alipayPublicKey){
        $this->alipayPublicKey=$alipayPublicKey;
    }
	
    public function setTotalFee($payAmount){
        $this->totalFee = $payAmount;
    }

    public function setOutTradeNo($outTradeNo){
        $this->outTradeNo = $outTradeNo;
    }

    public function setOrderName($orderName){
        $this->orderName = $orderName;
    }
    public function signType($signType){
        $this->signType = $signType;
    }

    public function doPayWap(){
        $requestConfigs = array(
            'out_trade_no' => $this->outTradeNo,
            'product_code' => 'QUICK_WAP_WAY',
            'total_amount' => $this->totalFee,
            'subject'      => $this->orderName,
        );
        $commonConfigs = array(
            'app_id'      => $this->appId,
            'method'      => 'alipay.trade.wap.pay',
            'format'      => 'JSON',
            'return_url'  => $this->returnUrl,
            'charset'     => $this->charset,
            'sign_type'   => $this->signType,
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'     => '1.0',
            'notify_url'  => $this->notifyUrl,
            'biz_content' => json_encode($requestConfigs),
        );
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
	    return $this->buildRequestForm($commonConfigs);
    }

    public function doPayPc(){
        $requestConfigs = array(
            'out_trade_no' => $this->outTradeNo,
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
            'total_amount' => $this->totalFee,
            'subject'      => $this->orderName,
        );
        $commonConfigs = array(
            'app_id'     => $this->appId,
            'method'     => 'alipay.trade.page.pay',
            'format'     => 'JSON',
            'return_url' => $this->returnUrl,
            'charset'    => $this->charset,
            'sign_type'  => $this->signType,
            'timestamp'  => date('Y-m-d H:i:s'),
            'version'    => '1.0',
            'notify_url' => $this->notifyUrl,
            'biz_content'=> json_encode($requestConfigs),
        );
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
		return $this->buildRequestForm($commonConfigs);
    }

    public function doPayTransfer($totalFee, $outTradeNo, $account,$realName,$remark=''){
        $requestConfigs = array(
            'out_biz_no'      => $outTradeNo,
            'payee_type'      => 'ALIPAY_LOGONID',
            'payee_account'   => $account,
            'payee_real_name' => $realName,
            'amount'          => $totalFee,
            'remark'          => $remark,
        );
        $commonConfigs = array(
            'app_id'      => $this->appId,
            'method'      => 'alipay.fund.trans.toaccount.transfer',
            'format'      => 'JSON',
            'charset'     => $this->charset,
            'sign_type'   => $this->signType,
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'     => '1.0',
            'biz_content' => json_encode($requestConfigs),
        );
	    $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        $result = $this->curlPost('https://openapi.alipay.com/gateway.do',$commonConfigs);
        $resultArr = json_decode($result,true);
        if(empty($resultArr)){
            $result = iconv('GBK','UTF-8//IGNORE',$result);
            return json_decode($result,true);
        }
        return $resultArr;
    }

    protected function buildRequestForm($para_temp) {
        $sHtml = "&#27491;&#22312;&#36339;&#36716;&#33267;&#25903;&#20184;&#39029;&#38754;&#46;&#46;&#46;<form id='alipaysubmit' name='alipaysubmit' action='https://openapi.alipay.com/gateway.do?charset=".$this->charset."' method='POST'>";
        while (list ($key, $val) = each ($para_temp)) {
            if (false === $this->checkEmpty($val)) {
                $val = str_replace("'","&apos;",$val);
                $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
            }
        }
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
        return $sHtml;
    }

    public function generateSign($params, $signType = "RSA") {
        return $this->sign($this->getSignContent($params), $signType);
    }

    protected function sign($data, $signType = "RSA") {
        $priKey = $this->rsaPrivateKey;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('&#24744;&#20351;&#29992;&#30340;&#31169;&#38053;&#26684;&#24335;&#38169;&#35823;&#65292;&#35831;&#26816;&#26597;&#82;&#83;&#65;&#31169;&#38053;&#37197;&#32622;');
        $sign = '';
		if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256); 
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }

    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                $v = $this->characet($v, $this->charset);
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    public function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
	
    public function curlPost($url = '', $postData = '', $options = array()){
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function rsaCheck($params) {
        $sign = $params['sign'];
        $signType = $params['sign_type'];
        unset($params['sign_type']);
        unset($params['sign']);
        return $this->verify($this->getSignContent($params), $sign, $signType);
    }

    public function verify($data, $sign, $signType = 'RSA') {
        $pubKey = $this->alipayPublicKey;
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        ($res) or die('&#25903;&#20184;&#23453;&#82;&#83;&#65;&#20844;&#38053;&#38169;&#35823;&#12290;&#35831;&#26816;&#26597;&#20844;&#38053;&#25991;&#20214;&#26684;&#24335;&#26159;&#21542;&#27491;&#30830;');
		if ("RSA2" == $signType) {
            $result = openssl_verify($data, base64_decode($sign), $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256);
	    } else {
            $result = openssl_verify($data, base64_decode($sign), $res);
        }
		return $result;
    }

    public static function logResult($word='') {
		$fp = fopen("ck8_pay_wxlog.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"\n>>>LOGDATA：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\r\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}
}