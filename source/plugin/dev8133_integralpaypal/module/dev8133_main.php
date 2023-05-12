<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if($submodac == "submityes"){
    
    if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
        showmessage('Access Denied');
    }
    if(!$uid) {
        showmessage('not_loggedin', NULL, array(), array('login' => 1));
    }
    $jfid = daddslashes($_GET['jfid']);

    if($jfid != "zdy"){
        $jfid = intval($jfid);
        if($jfid){
            $ws = " where id=".$jfid;
            $jdata = C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->fetch_first_field_data("*",$ws);
            
      }
        if(!$jdata){
            showmessage('data error');
        }
        $intetype =  $jdata['intetype'];
        $intcount =  $jdata['intcount'];
        $price =  $jdata['price'];
    }else{
        $zdynums = intval($_GET['zdynum']);
        if($zdynums< $config['minje']){
            showmessage(lang('plugin/dev8133_integralpaypal', 'adminpaystr_8').$config['minje']);
        }
        $sumje = $zdynums*$config['zdybl'];
        $intetype =  $config['zdyjf'];
        $intcount =  $zdynums;
        $price = $sumje;
    }
    $orderid = dgmdate($_G['timestamp'], 'YmdHis').random(13);
    $orderdata = array(
        'orderid'=>$orderid,
        'uid'=>    $uid,
        'username'=> $username,
        'intetype'  =>  $intetype,
        'intcount'  =>   $intcount,
        'price'  =>   $price,
        'zsintetype'  =>   $jdata['zsintetype'],
        'zsintcount'  =>   $jdata['zsintcount'],
        'payname'=>"paypal",
        'ostatus'=>1,
        'payno'=>$payno,
        'dateline'=> TIMESTAMP,
    );
    include_once DISCUZ_ROOT."source/plugin/dev8133_integralpaypal/lib/paypal.php";
    $return_url = $_G['siteurl'].'plugin.php?id=dev8133_integralpaypal:returnpaypal';
    $notify_url = $_G['siteurl'].'plugin.php?id=dev8133_integralpaypal:returnpaypal';
    $orderinfo  = array(
        'clientId'=>$config['clientId'],
        'clientSecret'=>$config['clientSecret'],
        'code'=>$config['payCode'],
        'price'=>number_format($price,2),
        'cancel_url'=>$_G['siteurl'].'plugin.php?id=dev8133_integralpaypal',
        'return_url'=>$return_url,
        'notify_url'=>$notify_url,
    );

    $payinfo = createOrder($orderinfo);
    if($payinfo['approve']){
        $orderdata['return_token'] = $payinfo['r_token'];
        $orderdata['payCode'] = $config['payCode'];
        C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->insert($orderdata);
        dheader("Location: ".$payinfo['approve']);
        exit;
    }else{
        showmessage(lang('plugin/dev8133_integralpaypal', 'mainstr_15986'));
    }

}else{
    //获取充值积分
    $czjfdata = C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->fetch_all_byall();
    $deaultjf = $czjfdata[0];
    $myext = intval(getuserprofile('extcredits'.$deaultjf['intetype']));
    include template('dev8133_integralpaypal:main');
}
?>