<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      Ӧ������: ����޸����� v1.0.2 ��ҵ��
 *      ���ص�ַ: https://addon.dismall.com/plugins/zqlj_repassword.html
 *      Ӧ�ÿ�����: ��������
 *      ������QQ: 281688302
 *      ��������: 202302070011
 *      ��Ȩ����: www.cnkbtk.com
 *      ��Ȩ��: 2023020700EPgazgm35U
 *      δ��Ӧ�ó��򿪷���/�����ߵ�������ɣ����ý��з��򹤳̡������ࡢ�������ȣ��������Ը��ơ��޸ġ����ӡ�ת�ء���ࡢ�������桢��չ��֮�йص�������Ʒ����Ʒ��
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