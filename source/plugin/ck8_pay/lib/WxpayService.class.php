<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class WxpayService{

    protected $mchid;
    protected $appid;
    protected $apiKey;
    protected $appKey;
    public $data = null;
    protected $totalFee;
    protected $outTradeNo;
    protected $orderName;
    protected $notifyUrl;
    protected $wapUrl;
    protected $wapName;

    public function __construct($mchid, $appid, $key ,$appKey=''){

        $this->mchid = $mchid;
        $this->appid = $appid;
        $this->apiKey = $key;
		$this->appKey = $appKey;
    }

    public function setTotalFee($totalFee){
        $this->totalFee = $totalFee;
    }
    public function setOutTradeNo($outTradeNo){
        $this->outTradeNo = $outTradeNo;
    }
    public function setOrderName($orderName){
        $this->orderName = $orderName;
    }
    public function setWapUrl($wapUrl){
        $this->wapUrl = $wapUrl;
    }
    public function setWapName($wapName){
        $this->wapName = $wapName;
    }
    public function setNotifyUrl($notifyUrl){
        $this->notifyUrl = $notifyUrl;
    }

    public function GetOpenid($codeurl='',$authority=''){

        if (!isset($_GET['code'])){

			if($codeurl){
				$baseUrl = urlencode($codeurl);
			}else{
				$scheme = $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
				$baseUrl = urlencode($scheme.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
			}
			
			if($authority){

			    $url = $authority.'?appid='.$this->appid.'&redirect_uri='.$baseUrl.'&scope=snsapi_base&state='.md5(FORMHASH);
				header("Location: $url");
				exit();
			}else{

				$url = $this->__CreateOauthUrlForCode($baseUrl);
				header("Location: $url");
				exit();
			}

        } else {
            $code = $_GET['code'];
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }	
    }

    public function GetOpenidFromMp($code){
        $url = $this->__CreateOauthUrlForOpenid($code);
        $res = self::curlGet($url);
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;
    }

    private function __CreateOauthUrlForOpenid($code){
        $urlObj["appid"] = $this->appid;
        $urlObj["secret"] = $this->appKey;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }

    private function __CreateOauthUrlForCode($redirectUrl){
        $urlObj["appid"] = $this->appid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    private function ToUrlParams($urlObj){
        $buff = "";
        foreach ($urlObj as $k => $v){
            if($k != "sign") $buff .= $k . "=" . $v . "&";
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    public function createJsBizPackageTransfer($openid, $totalFee, $outTradeNo,$trueName,$desc,$apiclient_cert,$apiclient_key){
		global $_G;
        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->appid,
            'key' => $this->apiKey,
        );
        $unified = array(
            'mch_appid' => $config['appid'],
            'mchid' => $config['mch_id'],
            'nonce_str' => self::createNonceStr(),
            'openid' => $openid,
            'check_name'=> 'FORCE_CHECK',
            're_user_name'=> $trueName,
            'partner_trade_no' => $outTradeNo,
            'spbill_create_ip' => $_G['clientip'],
            'amount' => intval($totalFee * 100),
            'desc'=> $desc,
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
	    $responseXml = $this->certCurlPost('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', self::arrayToXml($unified), $apiclient_cert, $apiclient_key);
		$unifiedOrder = self::xmlToArray($responseXml);
	    if($unifiedOrder === false){
			return false;
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
			self::logResult('SUCCESS-return_msg==>>'.self::diconv_to_utf8($unifiedOrder->return_msg));
			return false;
        }
        if ($unifiedOrder->result_code != 'SUCCESS') {
			self::logResult('SUCCESS-result_code==>>'.self::diconv_to_utf8($unifiedOrder->result_code));
			return false;
        }
        return $unifiedOrder;
    }

    public function createJsBizPackageJSAPI($openid,$timestamp){
		global $_G;
        $config = array(
            'mch_id' => $this->mchid,
            'appid'  => $this->appid,
            'key'    => $this->apiKey,
        );
        $unified = array(
            'appid'           => $config['appid'],
            'attach'          => 'pay',
            'body'            => $this->orderName,
            'mch_id'          => $config['mch_id'],
            'nonce_str'       => self::createNonceStr(),
            'notify_url'      => $this->notifyUrl,
            'openid'          => $openid,
            'out_trade_no'    => $this->outTradeNo,
            'spbill_create_ip'=> $_G['clientip'],
            'total_fee'       => intval($this->totalFee * 100),
            'trade_type'      => 'JSAPI',
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = self::curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', self::arrayToXml($unified));
		$unifiedOrder = self::xmlToArray($responseXml);
        if ($unifiedOrder === false) {
            die('parse xml error');
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
			self::logResult('SUCCESS-return_code==>>'.self::diconv_to_utf8($unifiedOrder->return_code));
			return false;
        }
        if ($unifiedOrder->result_code != 'SUCCESS') {
			self::logResult('SUCCESS-result_code==>>'.self::diconv_to_utf8($unifiedOrder->result_code));
			return false;
        }
        $arr = array(
            "appId" => $config['appid'],
            "timeStamp" => "$timestamp",
            "nonceStr" => self::createNonceStr(),
            "package" => "prepay_id=" . $unifiedOrder->prepay_id,
            "signType" => 'MD5',
        );
        $arr['paySign'] = self::getSign($arr, $config['key']);
        return $arr;
    }

    public function createJsBizPackagePC($timestamp){
		global $_G;
        $config = array(
            'mch_id' => $this->mchid,
            'appid'  => $this->appid,
            'key'    => $this->apiKey,
        );
        $unified = array(
            'appid'            => $config['appid'],
            'attach'           => 'pay',
            'body'             => $this->orderName,
            'mch_id'           => $config['mch_id'],
            'nonce_str'        => self::createNonceStr(),
            'notify_url'       => $this->notifyUrl,
            'out_trade_no'     => $this->outTradeNo,
            'spbill_create_ip' => $_G['clientip'],
            'total_fee'        => intval($this->totalFee * 100),
            'trade_type'       => 'NATIVE',
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = self::curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', self::arrayToXml($unified));
        $unifiedOrder = self::xmlToArray($responseXml);
		if ($unifiedOrder === false) {
            die('parse xml error');
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
			self::logResult('SUCCESS-return_msg==>>'.self::diconv_to_utf8($unifiedOrder->return_msg));
			return false;
        }
        if ($unifiedOrder->result_code != 'SUCCESS') {
			self::logResult('SUCCESS-result_code==>>'.self::diconv_to_utf8($unifiedOrder->result_code));
			return false;
        }
        $codeUrl = (array)($unifiedOrder->code_url);
        if(!$codeUrl[0]) exit('get code_url error');
        $arr = array(
            "appId"     => $config['appid'],
            "timeStamp" => $timestamp,
            "nonceStr"  => self::createNonceStr(),
            "package"   => "prepay_id=" . $unifiedOrder->prepay_id,
            "signType"  => 'MD5',
            "code_url"  => $codeUrl[0],
        );
        $arr['paySign'] = self::getSign($arr, $config['key']);
        return $arr;
    }

    public function createJsBizPackageH5(){
		global $_G;
        $config = array(
            'mch_id' => $this->mchid,
            'appid'  => $this->appid,
            'key'    => $this->apiKey,
        );
        $scene_info = array(
                'h5_info' => array(
                'type'    => 'Wap',
                'wap_url' => $this->wapUrl,
                'wap_name'=> $this->wapName,
            )
        );
        $unified = array(
            'appid'            => $config['appid'],
            'attach'           => 'pay',
            'body'             => $this->orderName,
            'mch_id'           => $config['mch_id'],
            'nonce_str'        => self::createNonceStr(),
            'notify_url'       => $this->notifyUrl,
            'out_trade_no'     => $this->outTradeNo,
            'spbill_create_ip' => $_G['clientip'],
            'total_fee'        => intval($this->totalFee * 100),
            'trade_type'       => 'MWEB',
            'scene_info'       => json_encode($scene_info)
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = self::curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', self::arrayToXml($unified));
        $unifiedOrder = self::xmlToArray($responseXml);
        if ($unifiedOrder->return_code != 'SUCCESS') {
			self::logResult('SUCCESS-return_code==>>'.self::diconv_to_utf8($unifiedOrder->return_code));
			return false;
        }
        if($unifiedOrder->mweb_url){
            return $unifiedOrder->mweb_url;
        }
        return false;
    }

    public function notify(){
        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->appid,
            'key' => $this->apiKey,
        );
		if(function_exists('file_get_contents')){
			$postStr = file_get_contents("php://input");
		}else{
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		}
        if (!$postStr) {
			self::logResult('HTTP_RAW_POST_DATA error');
		    return false;
        }
		$postObj = self::xmlToArray($postStr);
        if ($postObj === false) {
			self::logResult('parse xml error');
		    return false;
        }
        if ($postObj->return_code != 'SUCCESS') {
			self::logResult('SUCCESS-return_code==>>'.self::diconv_to_utf8($postObj->return_code));
			return false;
        }
        if ($postObj->result_code != 'SUCCESS') {
			self::logResult('SUCCESS-result_code==>>'.self::diconv_to_utf8($postObj->result_code));
			return false;
        }
        $arr = (array)$postObj;
        unset($arr['sign']);
        if (self::getSign($arr, $config['key']) == $postObj->sign) {
			return $arr;
        }else{
			return false;
		}
    }

	public static function xmlToArray($xml){
		libxml_disable_entity_loader(true);
		$xmltmp = simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);
		return $xmltmp;
	}

    public static function curlGet($url = '', $options = array()){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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

    public static function curlPost($url = '', $postData = '', $options = array()){
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

    public function certCurlPost($url = '', $postData = '',$apiclient_cert = '', $apiclient_key = '', $options=array()){
        if(is_array($postData)) {
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

        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,getcwd().$apiclient_cert);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,getcwd().$apiclient_key);
        //第二种方式，两个文件合成一个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
        $data = curl_exec($ch);
        if($data === false){
           echo 'Curl error: '. curl_error($ch);exit();
        }        
        curl_close($ch);
        return $data;
    }
	
    public static function createNonceStr($length = 16){
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    public static function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }

    public static function getSign($params, $key){
        ksort($params, SORT_STRING);
        $unSignParaString = self::formatQueryParaMap($params, false);
        $signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
        return $signStr;
    }

    protected static function formatQueryParaMap($paraMap, $urlEncode = false){
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if (null != $v && "null" != $v) {
                if ($urlEncode) {
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }
	public static function diconv_to_utf8($str){
		if(strtolower(CHARSET) == 'gbk'){
			$str = iconv('utf-8', 'gbk',$str);
		}
		return $str;
	}

    public static function logResult($word='') {
		$fp = fopen("ck8_pay_wxlog.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"\n>>>LOGDATA：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\r\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}
}