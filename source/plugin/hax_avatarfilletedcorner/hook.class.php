<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_hax_avatarfilletedcorner {
  function global_header(){
		
		global $_G;
		$config = $_G['cache']['plugin']['hax_avatarfilletedcorner'];
		$afc_radius = intval($config['afc_radius'])?'border-radius: '.intval($config['afc_radius']).'0% !important;':'border-radius:0 !important;';
		$afc_border = is_numeric($config['afc_border'])&&$config['afc_border']!=0?'border:'.$config['afc_border'].'px solid !important;':'';
		$padandbg = $afc_border?'padding: 0 !important; background: 0 !important;':'';
		if($afc_border){
    		$acf_bdcolor = $config['acf_bdcolor']?'border-color:'.$config['acf_bdcolor'].' !important;':'border-color: transparent !important;';
		}
		$acf_classarr=explode("\n",$config['acf_classname']);
		$acf_classname='';
		foreach ($acf_classarr as $k =>$v){
		    if($v){
		        $acf_classname.=','.$v;
		    }
		}
		$return='
		    <style type="text/css">
		    .avt img,.avtm img,#avatarform img,.ui-widget-content'.$acf_classname.'{
		        '.$afc_radius.'
		        '.$afc_border.'
		        '.$acf_bdcolor.'
		        '.$padandbg.'
		    }
		    '.$config['acf_css'].'
		    </style>
		';
		return $return;
		
	}
}

?>