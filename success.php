<?php
include 'config.php';
include 'manage.php';


if (!empty($_GET['shh'])) {  
  $jsonp=$_GET['callback'];
  //商户号
  $shh=$_GET['shh']; 
  //状态
  $searchresult=mysql_query("select * from zongpay where dingdan='$shh' and state='1'");
  $arr=mysql_fetch_array($searchresult);
  if($arr){
  	
  	 //改变订单状态
      include("shop.php");
  	
  	  //返回支付页数据
      $arraydata=array(succ=>'1', url=>$download);  
      echo $jsonp . '(' . json_encode($arraydata) . ')';
  	
  	  //发POST
    //   send_post($notify_url, $arr);
      
  }
};


?>

