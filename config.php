<?php	
header('Access-Control-Allow-Origin:*');


// 连接数据库  
@mysql_connect("localhost","root","");  
mysql_select_db('cnkbtk'); 
mysql_query('set names utf8');

//填写你的域名  格式： http://baidu.com/uppayimg/
$hppt='https://www.cnkbtk.com/uppayimg/'; 

//回调通知地址  格式： http://baidu.com/notify.php
$notify_url = "https://www.cnkbtk.com/notify.php";


//文件下载路径（压缩包）
$download="https://www.cnkbtk.com"; 




//创建表
mysql_query("
  create table apppay(
    id int key auto_increment,
    paymoney text,
    device text,
    type text,
    paytime text,
    title text,
    content text
  )
");

//创建收款总表
mysql_query("
  create table zongpay(
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

//建收款码表
mysql_query("
  create table pay_img(
    id int key auto_increment,
    payname text,
    money text,
    device text,
    img_url text,
    beizhu text,
    time text
  )
");

//建记录使用过的金额
mysql_query("
  create table jilu_money(
    id int key auto_increment,
    money text,
    time text
   )
");

//建浏览记录表
mysql_query("
  create table money(
    id int key auto_increment,
    paymoney text,
    paytime text
  )
");

//建登录表
mysql_query("
  create table login(
    id int key auto_increment,
    name text,
    pass text
  )
");

mysql_query("INSERT INTO login (id,name,pass) VALUES(1, 'login', '123456')");




?>