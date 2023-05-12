<?php
    if (!defined('IN_DISCUZ')) {
        exit('Access Denied');
    }
    $Sandbox = "https://api-m.paypal.com/";
    function getAccessToken($clientId,$clientSecret){
        global $Sandbox;
        $url = $Sandbox."v1/oauth2/token";
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_HEADER, false );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept-Language: en_US"
        ));
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_USERPWD, $clientId . ":" . $clientSecret );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials" );
        $result = curl_exec($ch);
        curl_close($ch);
        $result = (array)json_decode($result);
        $access_token = $result['access_token'];
        return $access_token;
    }
    function createOrder($orderinfo){
        global $Sandbox;
        $access_token = getAccessToken($orderinfo['clientId'],$orderinfo['clientSecret']);
        if(!$access_token){
            return "";
        }
        $url = $Sandbox."v2/checkout/orders";
        $Token = $access_token;
        $postfilds ='{"intent":"CAPTURE","purchase_units":[{"amount":{"currency_code":"'.$orderinfo['code'].'","value":"'.$orderinfo['price'].'"}}],"application_context":{"cancel_url":"'.$orderinfo['cancel_url'].'","return_url":"'.$orderinfo['return_url'].'","notify_url":"'.$orderinfo['notify_url'].'"}}';
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_HEADER, false );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $Token,
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postfilds );
        $result = curl_exec($ch);
        curl_close($ch);
        $result = (array)json_decode($result);
        $links = $result['links'];
        foreach ($links as $value){
            $linktmp = (array)$value;
            if($linktmp['rel'] == 'approve'){
                $approve_url = $linktmp['href'];
                break;
            }
        }

        $returndata['r_token'] = $result['id'];
        $returndata['approve'] = $approve_url;
        $returndata['access_token'] = $access_token;
        return  $returndata;
    }

    function capture_order($r_token,$clientId,$clientSecret){
        global $Sandbox;
        $access_token = getAccessToken($clientId,$clientSecret);
        if(!$access_token){
            return "";
        }
        $url = $Sandbox."v2/checkout/orders/{$r_token}/capture";
        $Token = $access_token;
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_HEADER, false );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $Token,
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = (array)json_decode($result);
        $returndata['id'] = $result['id'];
        $returndata['status'] = $result['status'];;
        return  $returndata;
    }
?>