<?php
require './source/class/class_core.php'; 
$discuz = C::app();
$cachelist = array('grouptype', 'groupindex', 'diytemplatenamegroup');
$discuz->cachelist = $cachelist;
$discuz->init();
$uid=$_G['uid'];
if(!$uid){
  echo '
     请登录后操作 <a href="https://www.cnkbtk.com/">点击回到首页登录</a>
  ';
  exit('');   
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>自助充值</title>
        <link href="./imgs/demo/Reset.css" rel="stylesheet" type="text/css">
        <script src="./imgs/demo/jquery-1.11.3.min.js"></script>
        <link href="./imgs/demo/main12.css" rel="stylesheet" type="text/css">
        <style>
            .pay_li input{
                display: none;
            }
            .immediate_pay{
                border:none;
            }
            .PayMethod12
            {
                min-height: 150px;
            }
            @media screen and (max-width: 700px) {
                .PayMethod12{
                    padding-top:0;
                }
                .order-amount12{
                    margin-bottom: 0;
                }
                .order-amount12,.PayMethod12{
                    padding-left: 15px;padding-right: 15px;
                }
            }
            .order-amount12-right input,.spname{
                border:1px solid #efefef;
                width:6em;
                padding:5px 20px;
                font-size: 15px;
                text-indent: 0.5em;
                line-height: 1.8em;
            }
            .spname{
                padding:0px 20px;
            }
        </style>
    </head>
    <body style="background-color:#f9f9f9">
    <body>
        <form method='post' action='./pay.php' id='submit'>
            <input type="hidden" id="orderName" type="text" name="orderName" class="form-control" value="充值1000积分" placeholder="积分充值">
            <div class="w1080 order-amount12" style="border-radius: 1em;">
                <ul class="order-amount12-left">
                    <li>
                        <span>商品名称：</span>
                        <span class="spname" id="orderName" type="text" name="orderName" value="1000">1000积分</span>
                    </li>
                    <li>
                        <span>订单编号：</span>
                        <span id="dingdanname"></span>
                    </li>
                </ul>
                <div class="order-amount12-right">
                    <span>订单金额：</span>
                      <span id="total_amount" type="text" name="price" class="form-control" value="100">100</span>
                    <span>元</span>
                </div>
            </div>
            <!--支付方式-->
            
            <!-- 订单号 -->
            <input type="hidden" id="orderNumber" name="orderNumber">
               
            <div class="w1080 PayMethod12" style="border-radius: 1em;">
                <div class="row">
                    <h2>支付方式</h2>
                    <ul>
                        <label>
                        <li class="pay_li active">
                            <input type="radio" name="payType" checked value="wx">
                            <i class="i2"></i>
                            <span>微信扫码</span>
                        </li>  
                        </label>
                        <label>
            			<li class="pay_li">
                        <input type="radio" name="payType" value="zfb">
                            <i class="i1"></i>
                            <span>支付宝扫码</span>
                        </li>
                        </label>
          
                    </ul>
                </div>
            </div>
            <!--立即支付-->
            <div class="w1080 immediate-pay12" style="border-radius: 1em; padding-top:1em; padding-bottom: 1em;padding-right: 1em;">
                <div class="immediate-pay12-right">
                    <span>需支付：100元</span>
                    <div id="submits" class="immediate_pay">立即支付</div>
                </div>
            </div>
            </form>
    </body>
    <script type="text/javascript">
        $(function () {
        
        // 监听输入金额
            $("#total_amount").bind("input propertychange",function(event){
                   var money=$("#total_amount").val();
                   $("#inputmoney").html(money);
            });
        
            $(".pay_li").click(function () {
                $(".pay_li").removeClass("active");
                $(this).addClass("active");
            });
          
        // 创建 Date 对象
        var myDate = new Date();
        //获取当前年
        var year=myDate.getFullYear();
        //获取当前月
        var month=myDate.getMonth()+1;
        //获取当前日
        var date=myDate.getDate(); 
        //获取当前小时数
        var h=myDate.getHours();    
        //获取当前分钟数 
        var m=myDate.getMinutes();  
        //获取当前秒数   
        var s=myDate.getSeconds();
        var dingdan=year+''+month+''+date+''+h+''+s+''+Math.floor(Math.random()*90000)+'u'+<?php echo $uid?>+'i'; 
            $("#dingdanname").html(dingdan); 
            function subdingdan(){
                $("#orderNumber").val(dingdan); 
                document.getElementById('submit').submit();
            };
            $("#submits").click(function(){
                        subdingdan();
            });
        });
    </script>
</html>