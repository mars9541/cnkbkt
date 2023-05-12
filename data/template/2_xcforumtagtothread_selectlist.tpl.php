<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$return = <<<EOF

<style>
<!--
.slectlist{
height:35px;
}
.slectlist select{
width:100px;
}
-->
</style>
<script type="text/javascript">
<!--
function mbars(id){
 var seles=document.getElementById("subject");
 var tag=document.getElementById("tags");
 var ids="id_"+id;
 var tabname="";
 var textvalue=seles.value;
 var tagvalue=tag.value;
 if(document.getElementById(ids).value!=0){
 
 		var idvalue=document.getElementById(ids).value;
  tabname="{$leftsign}"+ idvalue+"{$righsign}";
  if(("aa"+textvalue).indexOf(tabname)>0){
 		 textvalue=textvalue.replace(tabname,'');
 		 if({$positions}==1){
 seles.value=textvalue;
 }else{
 seles.value=textvalue;
 }
 		}else{
  		if({$positions}==1){
 seles.value=tabname+textvalue;
 }else{
 seles.value=textvalue+tabname;
 }
 		}
  
  if(('aa'+tagvalue).indexOf(idvalue)>0){
  tag.value=tagvalue.replace(idvalue+',','');
  }else{
  tag.value=tagvalue+idvalue+',';
  }
 }
}
//-->
</script>

EOF;
 if($pagekwlist) { 
$return .= <<<EOF

<div class="slectlist" >
EOF;
 if(is_array($pagekwlist)) foreach($pagekwlist as $key => $items) { 
$return .= <<<EOF
<select onchange="mbars({$items['ordernum']})" id="id_{$items['ordernum']}">
<option value=0>{$items['title']}</option>
EOF;
 if(is_array($items['kw'])) foreach($items['kw'] as $i => $item) { 
$return .= <<<EOF
<option value={$item}>{$item}</option>

EOF;
 } 
$return .= <<<EOF

</select>

EOF;
 } 
$return .= <<<EOF

</div>

EOF;
 } 
$return .= <<<EOF


EOF;
?>