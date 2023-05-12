<?php
include("config.php");

$time_ = time();

$number = $shh;
function get_between($input, $start, $end) {
    $substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
    return $substr;
};
$uid=get_between($number, 'u', 'i');   
$pid=get_between($number, 'i', 'd');   
$zongpay_time=mysql_query("select * from pre_ck8_view_buy_log");  
while($zongpay_time_array=mysql_fetch_array($zongpay_time)){
    if($zongpay_time_array['log_pid']==$pid && $zongpay_time_array['log_uid']==$uid && $zongpay_time_array['log_pay_state']=='1'){
         $ids=$zongpay_time_array['log_id'];
    };
};




$searchresult=mysql_query("select * from zongpay where dingdan='$number'");
$arr=mysql_fetch_array($searchresult);
if($arr){
    $idx=$arr['id'];
    $dingdan=$arr['dingdan'].'y';
    mysql_query("update zongpay set dingdan='$dingdan' where id='$idx'");  
    if($arr['ordername'] !='' && $arr['state']=='1'){
       $jifen1 = $arr['paymoney'];
       $jifen = floatval($jifen1*10);
       if($pid==''){
           $zongpay_time=mysql_query("select * from pre_common_member_count");  
            while($zongpay_time_array=mysql_fetch_array($zongpay_time)){
                if($zongpay_time_array['uid']==$uid){
                     $ids=$zongpay_time_array['uid'];
                     $extcredits=floatval($zongpay_time_array['extcredits4']) + $jifen;
                     mysql_query("update pre_common_member_count set extcredits4='$extcredits' where uid='$ids'");  
                };
            };
       }
    };
};





?>