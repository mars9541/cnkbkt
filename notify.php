<?php

include 'config.php';

//创建notify表
mysql_query("
  create table notify(
    id int key auto_increment,
    paymoney text,
    device text,
    paytime text,
    dingdan text,
    ordername text,
    paytype text,
    state text
  )
");

//接收信息
$price = $_POST["paymoney"];       //商品金额
$orderName = $_POST["ordername"];   //商品名称
$payType = $_POST["paytype"];       //支付方式
$orderNumber = $_POST["dingdan"]; //订单号
$device = $_POST["device"]; //设备号

//入数据库
if(!empty($price)){
 mysql_query("INSERT INTO notify (id,paymoney,device,paytime,dingdan,ordername,paytype,state) VALUES (null,'$price','$device', now(),'$orderNumber', '$orderName', '$payType', '0')");
};  

?>