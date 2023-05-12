<?php
include 'config.php';

date_default_timezone_set('PRC');

// 定义接收JOSN数据
header("Content-Type:application/json");
 
// 接收从APP端POST过来的数据
$json = $GLOBALS['HTTP_RAW_POST_DATA'];
 
// 将JSON数据转换为PHP对象
$obj = json_decode($json);
 
// 解析对象返回字符串
$money = $obj->money; //  返回支付金额
$device = $obj->deviceid; //  返回设备号
$title = $obj->title; //返回支付标题
$time = $obj->time; // 返回支付时间
$content = $obj->content; // 返回支付内容
$type = $obj->type; // 返回支付类型       
 
if($money=='null'){
  preg_match("/([0-9]{1,}\.[0-9]{2})/",$content, $m);
  $r = $m[1];
  $money=$r; 
}; 

//支付类型
if ($type=='wechat') {
  $type='wx';
} elseif ($type=='alipay') {
  $type='zfb';
} elseif ($type=='wechat-sponsor') {
  $type='zsm';
} else {
  $type;
};


if(!empty($money)){
  
  //插入数据
  mysql_query("INSERT INTO apppay (id,paymoney,device,type,paytime,title,content) VALUES (null,'$money','$device', '$type','$time', '$title', '$content')");
  
  //修改订单状态
  $cx=mysql_query("select * from zongpay order by id desc"); 
  while($xs=mysql_fetch_array($cx)){
    if($xs['state']=='0' && $xs['device']==$device && $xs['paymoney']==$money && $xs['paytype']==$type){
      $idx=$xs['id'];
      $sqlstr="update zongpay set state='1' where id='$idx'"; 
      mysql_query($sqlstr);
    };
  };
  
};






                              
                                  
?>
