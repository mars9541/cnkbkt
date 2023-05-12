<?php
include 'post.php';
if (empty($price) && $price!='null' || $price=='0.00') {
    echo "金额不能为空";
    return;
};
if (empty($orderNumber)) {
    echo "订单号不能为空";
    return;
}; 
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <?php $price == 100; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- <link rel="shortcut icon" href="./imgs/code.png" type="image/png"> -->
    <link rel="stylesheet" href="./imgs/stylepay.css">
    <script type="text/javascript" src="./imgs/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.staticfile.org/jquery/1.11.1/jquery.min.js"></script> -->
    <title><?php echo $paytitle_; ?>支付</title>
</head>

<body>
<div class="body">
    <h1 class="mod-title">
        <img src="<?php echo $pay_login; ?>" class="ico_log ico-3">
    </h1>

    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount" id="money"><?php echo $price?'￥'.$price:'null'; ?></div>
        <div class="qrcode-img-wrapper">
            <div class="qrcode-img-area" style="font-size: 25px;">
                <div style="position: relative;display: inline-block;">
                    <img id="show_qrcode" src="<?php echo $img_url; ?>" width="210" height="210" style="display: block; width: 210px; height: 210px;">

                 <!--   <img onclick="$('#use').hide()" id="use" src="./imgs/logo_weixin.png" style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -16px;margin-top: -16px">   -->

                </div>
            </div>

        </div>

        <div class="iospayweixinbtn" style="padding-top: 15px;display:none">1.长按上面二维码然后"保存图片"</div>
        <div class="iospayweixinbtn" style="padding-top: 15px;display:none"><a href="<?php echo $open; ?>" class="btn btn-primary">2.打开<?php echo $paytitle_; ?>，扫一扫本地图片</a></div>

        <div class="time-item" style="padding-top: 10px">
            <div class="time-item" id="msg">
                <h1 class="dingdan" style="color: red">  
                   请支付<?php echo $price?'￥'.$price:'null'; ?>元，否则订单支付失败
                   <p class="ordername_" style="margin-top: 7px;">
                      商品：<span><?php echo $orderName; ?></span>
                   </p>
                   <p class="" style="margin-top: 7px;">
                      订单号：<?php echo $orderNumber; ?>
                   </p>
                  <!--   <p class="donloal">支付成功此处显示下载链接</p>  -->
                </h1>
            </div>
            <strong id="hour_show" style="<?php echo "background:".$bg; ?>"><s id="h"></s>0时</strong>
            <strong id="fen_show" style="<?php echo "background:".$bg; ?>"><s></s>0分</strong>
            <strong id="miao_show" style="<?php echo "background:".$bg; ?>"><s></s>0秒</strong>
        </div>

        <div class="tip">
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p id="showtext_m" style="display:none;font-weight:bold;">请保存二维码到手机<br><?php echo $paytitle_; ?>扫一扫点右上角-从相册选取</p>
                
                <p id="showtext_pc" style="font-weight:bold;">
                  打开<?php echo $paytitle_; ?> [扫一扫]
                </p>
            </div>
        </div>

    </div>
</div>
<div class="copyRight">
        <p>Powered by <?php echo $paytitle_; ?>支付</p>
</div>
<script type="text/javascript">
$(function(){ 

if($('#show_qrcode').attr('src')==''){
   var sessionimg=sessionStorage.getItem("s_img_url");
   $('#show_qrcode').attr('src',sessionimg);
   if(sessionimg==''){
   	  $('#show_qrcode').attr('src','./imgs/wuma.jpg');
   };
};

if($(".ordername_ span").html()==''){
	$(".ordername_").css('display','none');
};



//倒计时
if(<?php echo $windowname?$windowname:'null';?>==1){
     sessionStorage.setItem("fen", "2");
     sessionStorage.setItem("miao", "59");
};
var fen = sessionStorage.getItem("fen");
var miao = sessionStorage.getItem("miao");
var times = setInterval(function() {
    miao--;
    sessionStorage.setItem("miao", miao);
    if(miao == 0 && fen == 0) {//当分钟和秒钟都为0时,停止计时
        chaoshi();
    }else{
      if(miao == 0) { //当秒钟为0时，秒数重新给值
            miao = 59;
            fen--;
            sessionStorage.setItem("fen", fen);
      };
    };
    if(miao==-1){
      miao=0;
      sessionStorage.setItem("miao", '0');
      chaoshi();
    };
    $("#fen_show").html(fen+'分');
    $("#miao_show").html(miao+'秒');
}, 1000);



// 支付超时
function chaoshi(){
    if(sessionStorage.getItem("s_img_url")=='./imgs/wuma.jpg'){
    	sessionStorage.setItem("miao", '0');
    	sessionStorage.setItem("fen", '0');
    }else{
      clearInterval(times);
      $(".qrcode-img-area").html('支付已超时,请重新下单!');
      $(".iospayweixinbtn").css('opacity','0');
      $(".amount").css('opacity','0');
      $(".dingdan").css('opacity','0');
      sessionStorage.setItem("s_img_url", './imgs/wuma.png');
    };
};



var time_success = setInterval(function() {
  $.ajax({
      url:'./success.php',
      type:'get',
      dataType:'jsonp',
      jsonp:'callback',
      data:{shh:'<?php echo $orderNumber;?>'},
      success:function(data){
          var succ=data.succ;
          var url=data.url;
          if(succ=='1'){
            //  $(".mod-ct").html('支付成功').css({'font-size':'33px','padding': '50px 0px 50px'});
             $(".mod-ct").html('支付成功'+'<br>'+'<a style="font-size: 15px;" href="https://www.cnkbtk.com">点击回到首页</a>').css({'font-size':'33px','padding': '50px 0px 50px'});
             window.location.href = url;
             clearInterval(time_success);
          }
      }
  });
},50);

});
</script>
</body>
</html>