<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('pay');?><?php include template('common/header'); ?><style>
.floatwraps{
    overflow: auto;
    overflow-x: hidden;
}
.lists{
    margin: 0 auto 10px;
    width: 480px;
    border-top: 2px solid #CDCDCD;
}
.titles{
    padding: 10px;
    margin-bottom: 10px;
border-bottom: 1px solid #e5e5e5;
}
.titles em{
color:#FF5722;
font-weight:700;
}
.titles p{
    line-height: 26px;
    height: 26px;
    color: #666;
    font-size: 15px;
}
.pay_type{
    position:relative;
    overflow: auto;
    overflow-x: hidden;
    padding: 10px 0px;
    width: 100%;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-box-pack: center;
    -webkit-box-align: center;
    text-align: center;
}
.pay_type li{
    display: inline-flex;
    font-size: 15px;
    color: #666;
    line-height: 28px;
margin: 0px 15px;
}
.ck8-radios {
    line-height: 25px;
    display: inline-block;
    position: relative;
    top: -3px;
}
label {
    cursor: pointer;
}
.ck8-radios input {
    display: inline-block;
    width: 26px;
    height: 26px;
    position: relative;
    overflow: visible;
    border: 0;
    background: none;
    -webkit-appearance: none;
    outline: none;
    margin-right: 8px;
    vertical-align: middle;
}
.ck8-radios input:before {
    content: '';
    display: block;
    width: 24px;
    height: 24px;
    border: 1px solid #dfe0e1;
    border-radius: 13px;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    position: absolute;
    left: 0px;
    top: 0;
}
.ck8-radios input:checked:after {
    content: '';
    display: block;
    width: 14px;
    height: 14px;
    background: #18b4ed;
    border-radius: 7px;
    position: absolute;
    left: 6px;
    top: 6px;
}
.titles p.tss{
    line-height: 45px;
    height: 45px;
    padding-left: 10px;
    padding-right: 10px;
    max-width: 100%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    color: #FF9800;
    background-color: rgba(205, 242, 255, 0.95);
    border-radius: 20px;
    margin: 10px 0px;
}
.ck8-btns{
    height: 25px;
    line-height: 25px;
    padding: 0 12px;
    min-width: 55px;
    font-size: 15px;
    background-color: #FF9800;
    color: #f7fafd !important;
    border-radius: 15px;
    float: right;
    position: relative;
    top: 10px;
}
.pay_select{
    display: inline-block;
    font-size: 15px;
    color: #666;
    position: relative;
    top: -5px;
}
</style>
<?php if(empty($_GET['infloat'])) { ?>
<div id="pt" class="bm cl">
<div class="z"><a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>购买隐藏内容</div>
</div>
<div id="ct" class="wp cl">
<div class="mn">
<div class="bm bw0">
<?php } ?>
<form id="paydisposeform" method="post" autocomplete="off" action="plugin.php?id=ck8_view:ck8_pay&amp;action=payview&amp;paydisposesubmit=yes&amp;infloat=yes" <?php if(!empty($_GET['infloat'])) { ?> onsubmit="ajaxpost('paydisposeform', 'return_<?php echo $_GET['handlekey'];?>', 'return_<?php echo $_GET['handlekey'];?>', 'onerror');return false;"<?php } ?> style="width: 500px;">
<div class="f_c">
<h3 class="flb">
<em id="return_<?php echo $_GET['handlekey'];?>">购买隐藏内容</em>
<span>
<?php if(!empty($_GET['infloat'])) { ?><a href="javascript:;" class="flbc" onclick="hideWindow('<?php echo $_GET['handlekey'];?>')" title="关闭">关闭</a><?php } ?>
</span>
</h3>
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="tid" value="<?php echo $tid;?>" />
<input type="hidden" name="pid" value="<?php echo $pid;?>" />
<input type="hidden" name="token" value="<?php echo $token;?>" />
<!--<input type="hidden" name="token" value="<?php echo $uid;?>" />-->
<?php if(!empty($_GET['infloat'])) { ?><input type="hidden" name="handlekey" value="<?php echo $_GET['handlekey'];?>" /><?php } ?>
<div class="c floatwraps">
<div class="lists">
<div class="titles">
<p>当前积分账户余额：<em><?php echo $credits;?></em>&nbsp;<?php echo $creditstitle;?></p>
<?php if(in_array(1,$pay_type)) { ?>
    <p>隐藏内容积分方式购买需支付：<em><?php echo $money;?></em>&nbsp;<?php echo $creditstitle;?></p>
<?php if($credits < $money) { ?>
    <p class="tss">你当前积分不足，请先充值<a onclick="wxcz001()" href="javascript:;" class="ck8-btns">充值积分</a></p>
<?php } } if(in_array(2,$pay_type) || in_array(3,$pay_type)) { ?>
<p>隐藏内容人民币方式购买需支付：<em><?php echo round(($money / $config['credits_percentage']),2);?></em>&nbsp;元</p>
<?php } ?>
</div>
<?php if(isset($pay_type)) { ?>
<span class="pay_select">选择支付方式：</span>
<div class="pay_type">
<ul>
<?php if(in_array(1,$pay_type)) { ?>
<li><label class="ck8-radios" for="zffs"><input type="radio" name="zffs" id="jfzf" value="jfzf" checked="checked"></label>积分支付</li>
<?php } if(in_array(2,$pay_type)) { ?>
<li><label class="ck8-radios" for="zffs"><input type="radio" name="zffs" id="wxzf" value="wxzf"></label>微信支付</li>
<?php } if(in_array(3,$pay_type)) { ?>
<li><label class="ck8-radios" for="zffs"><input type="radio" name="zffs" id="zfbzf" value="zfbzf"></label>支付宝支付</li>
<?php } ?>
<li onclick="wxzf001()"><label class="ck8-radios" for="zffs"><input type="radio" name="zffs" id="wx001" value="wx"></label>
  微信支付
</li>
</ul>
</div>
<?php } ?>
</div>
</div>
</div>
<div class="o pns">
<button class="pn pnc y" type="submit" value="true" name="paydisposesubmit"><span>确定支付</span></button>
</div>
</form>
<?php if(!empty($_GET['infloat'])) { ?>

<!--发起支付-->
<form method='post' action='https://www.cnkbtk.com/pay.php' id='submit' style="display: none;">
    <!--商品名称-->
    <input class="spname" id="orderName" type="text" name="orderName" value="">
    <!--金额-->
    <input id="total_amount" type="text" name="price" value="<?php echo $money;?>">
    <!-- 订单号 -->
    <input type="hidden" id="orderNumber" name="orderNumber" value="<?php echo $pid;?>">
    <!--支付方式-->
    <input type="radio" name="payType" checked value="wx" class="checkedval">
    <div id="submits">立即支付</div>
</form>
<script type="text/javascript">

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
var dingdan=year+''+month+''+date+''+h+''+s+''+Math.floor(Math.random()*90000);

function wxzf001(){
    var orderNumber = document.getElementById("orderNumber").value;
    document.getElementById("orderNumber").value=dingdan+'u'+discuz_uid+'i'+orderNumber+'d';
    document.getElementById('submit').submit();
};
function wxcz001(){
    var orderNumber = document.getElementById("orderNumber").value;
    document.getElementById("orderNumber").value=dingdan+'u'+discuz_uid+'i';
    
    document.getElementById("orderName").value='积分充值';    
    document.getElementById("total_amount").value='100';
    
    document.getElementById('submit').submit();
};
</script>
<script type="text/javascript" reload="1">


function succeedhandle_<?php echo $_GET['handlekey'];?>(url,msg,arr){
if (url && arr.p_id && arr.pay_type == 'wxzf'){
    console.log(arr.pay_type)
    console.log(arr.p_id)
    console.log(url)
showWindow('superaddition',url +'&formhash=<?php echo FORMHASH;?>');
}else if(url && arr.p_id){
window.location = url;

console.log(arr.pay_type)
    console.log(arr.p_id)
    console.log(url)

}else if(url){
    
    console.log(arr.pay_type)
    console.log(arr.p_id)
    console.log(url)
window.setTimeout("window.location='"+url+"'",3000);
}
hideWindow('<?php echo $_GET['handlekey'];?>');
}
function errorhandle_<?php echo $_GET['handlekey'];?>(msg,arr){
hideWindow('<?php echo $_GET['handlekey'];?>');
};

</script>
<?php } if(empty($_GET['infloat'])) { ?>
</div>
</div>
</div>
<?php } include template('common/footer'); ?>