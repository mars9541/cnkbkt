<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$return = <<<EOF

<script type="text/javascript">
EXTRAFUNC['showEditorMenu']['view']='e_viewfn';
function e_viewfn(e,v){
if(e != 'view' && v != 1){return false;}
var text = $('e_view_param_1').value;
var credits = parseInt($('e_view_param_2').value);
if (!text){
    showPrompt(null, null, '<div id="picUploadpromptdiv"><i style="font-size:15px;">请输入隐藏内容</i></div>', 3000,"popuptext");
doane();
    return false;
}else if(!credits || credits == 0){
    showPrompt(null, null, '<div id="picUploadpromptdiv"><i style="font-size:15px;">请设置积分数量必须大于0</i></div>', 3000,"popuptext");
doane();
    return false;
}
var txt = '[ck8_view='+ credits +']' + text + '[/ck8_view]';
insertText(txt, strlen(txt), 0);
$('e_view_param_1').value='';
$('e_view_param_2').value='';
doane();
}
</script>
<div class="p_pof" id="e_view_menu" style="width:380px;display:none">
<div class="p_opt cl"><span class="y" style="margin:-10px -15px 0px 0px;">
<a onclick="hideMenu();return false;" class="flbc" href="javascript:;">关闭</a></span>
<div>
<p>填写你要隐藏的收费内容:</p>
<p style="margin:5px 0px;"><textarea id="e_view_param_1" name="e_view_param_1" style="width:99%" cols="50" rows="5" class="txtarea" placeholder="请输入隐藏内容" ></textarea></p>
<p style="margin:10px 0px;">
<span>设置查看需支付积分数量:&nbsp;&nbsp;</span><input type="text" size="10" name="e_view_param_2" id="e_view_param_2" class="px"/>&nbsp;&nbsp;<label>{$credits}</label>
</p>

EOF;
 if($config['announce_charge']) { 
$return .= <<<EOF

<p class="mt" style="border-top:1px solid #eaeaea;"><span style="color:#FF0000;">说明：</span><span style="font-size:15px;">{$config['announce_charge']}</span></p>

EOF;
 } 
$return .= <<<EOF

</div>
<div class="pns mtn y"><button type="submit" id="e_view_submit" class="pn pnc"><strong>插入</strong></button></div>
</div>
</div>

EOF;
?>