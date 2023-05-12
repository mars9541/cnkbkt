<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
global $_G;
$config = $_G['cache']['plugin']['dev8133_integralpaypal'];
include_once DISCUZ_ROOT."source/plugin/dev8133_integralpaypal/lib/paypal.php";
$r_token = daddslashes($_GET['token']);
$PayerID = daddslashes($_GET['PayerID']);
$ws = " where return_token='".$r_token."'";
$orderdata = C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->fetch_first_field_data("*",$ws);
if(!$orderdata){
    showmessage(lang('plugin/dev8133_integralpaypal', 'mainstr_paypal01'));
}
$payres = capture_order($r_token,$config['clientId'],$config['clientSecret']);
if($payres['status'] == "COMPLETED"){
    if($orderdata && $orderdata['ostatus'] == 1){
        $updata = array(
            'ostatus'=>2,
            'payno'=>$PayerID,
            'shdateline'=>TIMESTAMP,
        );
        C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->update($orderdata['orderid'],$updata);
        //加积分
        updatemembercount($orderdata['uid'], array('extcredits'.$orderdata['intetype']=>$orderdata['intcount']),true,'',0,'',lang('plugin/dev8133_integralpaypal', 'shstr01'),lang('plugin/dev8133_integralpaypal', 'shstr02'));
        updatemembercount($orderdata['uid'], array('extcredits'.$orderdata['zsintetype']=>$orderdata['zsintcount']),true,'',0,'',lang('plugin/dev8133_integralpaypal', 'shstr03'),lang('plugin/dev8133_integralpaypal', 'shstr04'));
        showmessage(lang('plugin/dev8133_integralpaypal', 'mainstr_15983'), 'plugin.php?id=dev8133_integralpaypal:dev8133_integralpaypal','',array('alert=>right'));
    }else{
        showmessage(lang('plugin/dev8133_integralpaypal', 'mainstr_paypal02'));
    }
}else{
    showmessage(lang('plugin/dev8133_integralpaypal', 'mainstr_paypal03'));
}
