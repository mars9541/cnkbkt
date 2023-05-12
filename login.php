<?php
include 'config.php';


//登录
if(!empty($_POST['uname'])){
    $name=$_POST['uname'];
    $pass=$_POST['pass'];
    $searchresult=mysql_query("select * from login where name='$name' and pass='$pass'");
    $arr=mysql_fetch_array($searchresult);
    if($arr){
       echo "true";
    };
   
};

//查询zongpay订单表
$cx=mysql_query("select * from zongpay order by id desc"); 
$zongdd=mysql_num_rows($cx);  //总订单
$zongmny=0;
$jinrimny=0;
$jinri_sucessdd_arr=array();
$jinridd_array=array();
//循环
while($xs=mysql_fetch_array($cx)){
  if($xs['state']==1){
    $zongmny+=floatval($xs['paymoney']); //成交总金额
  };
  //今日成交金额
  $substr=substr($xs['paytime'],0,10);  
  if($substr==date('Y-m-d')){ 
    array_push($jinridd_array,$xsmoney['paytime']);   
    if($xs['state']==1){ //成功状态
      $jinrimny+=floatval($xs['paymoney']); 
      array_push($jinri_sucessdd_arr,$xs['paytime']);   
    };
  }; 
};
$jinri_sucessdd_leng=count($jinri_sucessdd_arr);
$jinridd=count($jinridd_array);
$jinridd=count($jinridd_array);


if(!empty($_POST['true_'])){
   $arrys=array($zongmny,$zongdd,$jinrimny,$jinridd,$jinri_sucessdd_leng);
   echo json_encode($arrys,JSON_UNESCAPED_UNICODE);
};



  //创建目录
  $dir = iconv("UTF-8", "GBK", "./uppayimg");
  if (!file_exists($dir)){
          mkdir ($dir,0777,true);
  };

  $fileinfo = $_FILES['file'];//将文件信息赋给变量$fileinfo
  if($fileinfo){
    //判断是什么格式图片
    $img_name=strrchr($fileinfo['name'],'.');
    switch ($img_name) 
    { 
    case ".png": 
        $imgname=date('YmdHis').'_img_'.'.png';
        break; 
    case ".jpg": 
        $imgname=date('YmdHis').'_img_'.'.jpg';
        break; 
    default: 
        break;
    }; 
    move_uploaded_file($fileinfo['tmp_name'],"./uppayimg/".$imgname);  //上传到文件夹 
    echo $imgname;

  };

// 接收收款码信息
$datas=$_POST['datas'];
if (!empty($datas['payimg'])) {
    $img_=$hppt.$datas['payimg'];//图片url
    $wximg_=$datas['leixing'];//二维码类型
    $money=$datas['money'];//金额
    $device=$datas['device'];//设备号
    $beizhu=$datas['beizhu'];//备注信息
    mysql_query("INSERT INTO pay_img (id,payname,money,device,img_url,beizhu,time) VALUES (null,'$wximg_','$money','$device','$img_','$beizhu',now())");
};


//收款码
if (!empty($_POST['payimg'])) { 
  //查询
  $cx=mysql_query("select * from pay_img order by id desc");  
  $users=array(); 
  $i=0; 
  //循环
  while($xs=mysql_fetch_array($cx)){
    $users[$i]=$xs; 
    $i++; 
  };
  echo json_encode($users,JSON_UNESCAPED_UNICODE);  
};



//删除收款图片
if (!empty($_POST['delimg'])) {   
     
  $idx=$_POST['delimg'];
  $cximg=mysql_query("select * from pay_img where id='$idx'");  
  //循环
  while($xs=mysql_fetch_array($cximg)){
    $str=$xs[img_url];  
    $arr=str_replace($hppt, '', $str);
    unlink('./uppayimg/'.$arr);
  };

  mysql_query("
    delete from pay_img where id='$idx';
  ");  
  
  //查询
  $cx=mysql_query("select * from pay_img order by id desc");  
  $users=array(); 
  $i=0; 

  //循环
  while($xs=mysql_fetch_array($cx)){
   $users[$i]=$xs; 
   $i++; 
  };
  echo json_encode($users,JSON_UNESCAPED_UNICODE);  
  
};


// 接收编辑后备注信息
if (!empty($_POST['id'])) { 
   $id=$_POST['id'];
   $beizhu=$_POST['beizhu'];
   //更新数据库 
   $sqlstr="update pay_img set beizhu='$beizhu' where id='$id'"; 
   mysql_query($sqlstr);
   echo "0";
};


// 获取zongpay订单
if (!empty($_POST['successpay'])) {
  //查询
  $cx=mysql_query("select * from zongpay order by id desc");  
  $users=array(); 
  $i=0; 

  //循环
  while($xs=mysql_fetch_array($cx)){
   $users[$i]=$xs; 
   $i++; 
  };
  echo json_encode($users,JSON_UNESCAPED_UNICODE); 
};


//删除订单
if (!empty($_POST['del_successpay'])) {  
  $idx=$_POST['del_successpay'];
  mysql_query("
    delete from zongpay where id='$idx';
  ");  

  //查询
  $cx=mysql_query("select * from zongpay order by id desc");  
  $users=array(); 
  $i=0; 

  //循环
  while($xs=mysql_fetch_array($cx)){
   $users[$i]=$xs; 
   $i++; 
  };
  echo json_encode($users,JSON_UNESCAPED_UNICODE);  
  
};


//后台点击回调
if (!empty($_POST['hd_successpay'])) {  
  $upid=$_POST['hd_successpay'];
  $hd_myaql=mysql_query("select * from zongpay where id='$upid'");
  $arr=mysql_fetch_array($hd_myaql);
  if($arr){
      $upsql="update zongpay set state='1' where id='$upid'"; 
      mysql_query($upsql);
      //查询
      $cx=mysql_query("select * from zongpay order by id desc");  
      $users=array(); 
      $i=0; 
      //循环
      while($xs=mysql_fetch_array($cx)){
       $users[$i]=$xs; 
       $i++; 
      };
      echo json_encode($users,JSON_UNESCAPED_UNICODE);  
  };
};











?>
