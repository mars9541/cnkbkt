<?php
include 'config.php';


//从网页传入信息
//$price = $_POST["price"];       //商品金额
$price = 100.00;
$orderName = $_POST["orderName"];   //商品名称
$payType = $_POST["payType"];       //支付方式
$orderNumber = $_POST["orderNumber"]; //订单号


//删除超时记录
$jilu_money_time=mysql_query("select * from jilu_money");  
//循环
while($time_array=mysql_fetch_array($jilu_money_time)){
  $startdate=$time_array['time'];
  //天
  $date=floor((strtotime(now)-strtotime($startdate))/86400);
  //时
  $hour=floor((strtotime(now)-strtotime($startdate))%86400/3600);
  //分
  $minute=floor((strtotime(now)-strtotime($startdate))%86400/60);
  //秒
  $second=floor((strtotime(now)-strtotime($startdate))%86400%60);
  if($minute>=3){  //3分钟超时
     $idx=$time_array['id'];
     mysql_query("delete from jilu_money where id='$idx'");  
  };  
};


//改变状态
$zongpay_time=mysql_query("select * from zongpay");  
//循环
while($zongpay_time_array=mysql_fetch_array($zongpay_time)){
  $startdate_=$zongpay_time_array['paytime'];
  //天
  $date_=floor((strtotime(now)-strtotime($startdate_))/86400);
  //时
  $hour_=floor((strtotime(now)-strtotime($startdate_))%86400/3600);
  //分
  $minute_=floor((strtotime(now)-strtotime($startdate_))%86400/60);
  //秒
  $second_=floor((strtotime(now)-strtotime($startdate_))%86400%60);
  if($minute_>=3){  //3分钟超时
    if($zongpay_time_array['state']=='0'){
         $ids=$zongpay_time_array['id'];
         mysql_query("update zongpay set state='-1' where id='$ids'");  
    };
  };  
};



session_start();
if($_SESSION['orderNumber']==$orderNumber){
  $windowname='0';
  $price=$_SESSION['price'];

}else{
$_SESSION['orderNumber']=$orderNumber; //存储订单号  
 

//浮动金额 
$jilu_money=mysql_query("select * from jilu_money where money");
$jilu_money_arr=mysql_fetch_array($jilu_money);
if($jilu_money_arr){
//查询金额
$cx=mysql_query("select * from jilu_money");  
while($xs=mysql_fetch_array($cx)){
  if($xs['money']==$price){
      $price=$price+0.01;
      $jilu_money=mysql_query("select * from jilu_money where money='$price'");
      $jilu_money_arr=mysql_fetch_array($jilu_money);
      if($jilu_money_arr){
          $select=mysql_query("select * from jilu_money"); 
          $array=array(); 
          $i=0;
          while($array_=mysql_fetch_array($select)){
                 $array[$i]=$array_['money'];
                 $i++;
          };
      }
  }; 
};

// 获取指定金额最大数加0.01
if ($array) {

    class StrStartWith {
       var $array;
       function __construct($array) {$this->str = $array;}
       function startWith($v) {return strpos($v,$this->str)===0;}
    };

    $PostMoney=explode(".",$_POST["price"]);		
    $arr=array_filter($array, array(new StrStartWith($PostMoney[0]."."), 'startWith'));
    if(count($arr)>0){
      rsort($arr);
      $price=$arr[0]+0.01;//最大值加0.01
      $PriceMix=$price;//最大
      $max = $arr[count($arr)-1];//最小值
    }
};

$price=sprintf("%.2f",$price);//保留两位小数
$num=explode(".",$price);
if($num[1]=='99'){ 

    $RangeArray=array();
    for ($i=$num[0].'.01'; $i <= $num[0].'.99'; $i+=0.01) { //循环获取指定数的*.01到*.99
        $val=sprintf("%.2f",$i);
        $RangeArray[]=$val;
    };
    $result = array_diff($RangeArray, $array);//数组对比返回差集
    $result=array_merge($result);
    $num=explode(".",$price);
    $price=$result[0]==$PriceMix?exit('系统繁忙请稍后重试'):$result[0];
    
    
};
mysql_query("insert into jilu_money (id,money,time) VALUES (null,'$price',now())");

}else{
  $price=sprintf("%.2f",$price);//保留两位小数  
  mysql_query("insert into jilu_money (id,money,time) VALUES (null,'$price',now())");
};
$_SESSION['price']=$price; //存储金额数据 



//返回前端收款码
if (!empty($payType) && !empty($price)) { 
    //查询收款码
    $cx=mysql_query("select * from pay_img");
    //循环
    while($xs=mysql_fetch_array($cx)){
      if ($payType==$xs['payname']) {
         $img_url=$xs['img_url']; 
         $device=$xs['device']; 
         $img_url_id=$xs['id']; 
      };
    };  
    echo '<script>sessionStorage.setItem("s_img_url","'.$img_url.'");</script>';
    //记录到数据库
    if(!empty($device)){
      mysql_query("INSERT INTO zongpay (id,paymoney,device,paytime,dingdan,ordername,paytype,state) VALUES (null,'$price','$device', now(),'$orderNumber', '$orderName', '$payType', '0')");
    };
    
    $windowname='1';

};
  
};



switch ($_POST["payType"]) { 
case "wx": 
    $paytitle_='微信';
    $pay_login='./imgs/logo_weixin.jpg';
    $open='weixin://scanqrcode';
    $bg='#3ec742';
    break; 
case "zfb": 
    $paytitle_='支付宝';
    $pay_login='./imgs/logo_alipay.jpg';
    $open='alipayqr://platformapi/startapp?saId=10000007';
    $bg='#01a9f4';
    break; 
case "zsm": 
    $paytitle_='微信';
    $pay_login='./imgs/logo_weixin.jpg';
    $open='weixin://scanqrcode';
    $bg='#3ec742';
    break; 
default: 

};   
  
  

  

?>








