<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: 快捷修改密码 v1.0.2 商业版
 *      下载地址: https://addon.dismall.com/plugins/zqlj_repassword.html
 *      应用开发者: 众器良匠
 *      开发者QQ: 281688302
 *      更新日期: 202302070011
 *      授权域名: www.cnkbtk.com
 *      授权码: 2023020700EPgazgm35U
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */



if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_zqlj_repassword_core {
	function __construct(){
		global $_G;	
		loadcache('plugin');
		$vars=$_G['cache']['plugin']['zqlj_repassword'];
		$this->uids=explode(',',$vars['uids']);
		$this->title=trim($vars['title']);
		$this->color=trim($vars['color']);
	}
}

//PC
class plugin_zqlj_repassword extends plugin_zqlj_repassword_core{

}

class plugin_zqlj_repassword_home extends plugin_zqlj_repassword{
	function space_profile_baseinfo_top_output(){
		global $_G,$space;
		$uid=$space['uid'];
		$action='';
		if($_G['uid']&&in_array($_G['uid'],$this->uids)){
			$action.='<a onclick="showWindow(this.id, this.href, \'get\', 0);" href="plugin.php?id=zqlj_repassword&uid='.$uid.'" id="zqlj_repassword" target="_blank" style="padding-right: 16px;color:'.$this->color.';"><strong>'.$this->title.'</strong></a>';
			return '<p style="padding-bottom:0.5em;">'.$action.'</p>';
		}
		return '';
	}
}

//Mobile
class mobileplugin_zqlj_repassword extends plugin_zqlj_repassword_core{
	function global_footer_mobile(){
		global $_G,$space;
		if($_G['uid']&&CURSCRIPT=='home'&&$_GET['mod']=='space'&&$_GET['uid']){
			$uid=intval($_GET['uid']);
			return '<center><a href="plugin.php?id=zqlj_repassword&uid='.$uid.'"><font color="'.$this->color.'">'.$this->title.'</font></a></center>';
		}
		return '';
	}
}