<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('pay_view');?><?php include template('common/header'); ?><style>
.floatwraps {
    overflow: auto;
    overflow-x: hidden;
    margin-bottom: 10px;
    max-height:380px;
}
.list th{
    -webkit-box-orient: vertical;
    -webkit-box-pack: center;
    -webkit-box-align: center;
    text-align: center;
}
.lists th{
    border-bottom: 1px solid #e5e5e5 !important;
}
.ck8-loading-wrap,#ck8-load-more,ck8-page{
    padding: 10px;
    font-size: 15px;
    text-align: center;
color:#888;
}
.ck8-loading-wrap a{
    border-radius: 15px;
    padding: 5px 0px;
    background: #e2f3f9;
    color: #00a5e0;
    background-color: rgba(205, 242, 255, 0.95);
    width: 95%;
    display: inline-block;
text-decoration: none !important;
}
</style>
<?php if(empty($_GET['infloat'])) { ?>
<div id="pt" class="bm cl">
<div class="z"><a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>购买记录</div>
</div>
<div id="ct" class="wp cl">
<div class="mn">
<div class="bm bw0">
<?php } ?>
<div class="f_c">
<h3 class="flb">
<em id="return_<?php echo $_GET['handlekey'];?>">购买记录</em>
<span>
<?php if(!empty($_GET['infloat'])) { ?><a href="javascript:;" class="flbc" onclick="hideWindow('<?php echo $_GET['handlekey'];?>')" title="关闭">关闭</a><?php } ?>
</span>
</h3>
<div class="c floatwraps">
<table class="list" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
<thead class="lists">
<tr>
<th>购买人</th><th>积分数量</th><th>人民币金额</th><th>支付方式</th><th>我的收获</th><th>购买日期</th>
</tr>
</thead>
<tbody id="listpage"><?php if(is_array($g_lists)) foreach($g_lists as $k => $v) { ?><tr id="lists">
                       <th><?php echo $v['log_uid'];?></th>
   <?php if($v['pay_type'] == 1) { ?>
   <th><?php echo $v['log_money'];?></th>
   <?php } else { ?>
   <th>--</th>
   <?php } ?>
   <th><?php echo $v['log_money2'];?></th><th><?php echo $v['log_pay_type'];?></th><th><?php echo $v['log_authorid_reap'];?></th><th><?php echo $v['log_date'];?></th>
</tr>
                <?php } ?>
                </tbody>
</table>
<div id="end"><div class="ck8-loading-wrap"><a href="javascript:;" onclick="ajax_page()" id="pages">点击加载更多</a></div></div>
</div>
</div>
<?php if(empty($_GET['infloat'])) { ?>
</div>
</div>
</div>
<?php } ?>
<script type="text/javascript">
var page = 2;
function ajax_page(){
var xmlHttp = null;
if(window.ActiveXObject){
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}else if(window.XMLHttpRequest){
xmlHttp = new XMLHttpRequest()
}
if(xmlHttp != null){
xmlHttp.open('GET','plugin.php?id=ck8_view:ck8_pay&action=viewpayments&tid=<?php echo $_GET['tid'];?>&token=<?php echo $_GET['token'];?>&pid=<?php echo $_GET['pid'];?>&page='+page,true);
xmlHttp.send(null);
xmlHttp.onreadystatechange=function(){
if(xmlHttp.readyState == 4){
if(xmlHttp.status == 200){
    var s = xmlHttp.responseText;
var html_ = appendHtml(s);
if (html_.indexOf('<tr id="lists">') == -1){
document.getElementById("pages").innerHTML = '已全部加载';
return false;
}
document.getElementById("listpage").innerHTML += html_;
}else{
alert('ajax_error'+ xmlHttp.status)
}
}
}
}
page++;
}
function appendHtml(h){  
h = h.replace(/\\n|\\r/g, "");
h = h.substring(h.indexOf('<tbody id=\"listpage\">'), h.indexOf('<div id=\"end\">'));
ht = h.substring(h.indexOf('<tr id=\"lists\">'), h.indexOf('</tbody>'));
return ht;
};
</script><?php include template('common/footer'); ?>