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
 
/*
 * By 众器良匠 
 * 应用中心主页：https://addon.dismall.com/?@72763.developer
 * 插件定制 联系QQ281688302
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(!$_G['uid']){//未登陆处理
	showmessage(lang('plugin/zqlj_repassword','nouid'), '', array(), array('login' => true));
}
loadcache('plugin');
$vars=$_G['cache']['plugin']['zqlj_repassword'];
$uids=explode(',',$vars['uids']);
if(!in_array($_G['uid'],$uids)) showmessage(lang('plugin/zqlj_repassword','noright'));
$title=trim($vars['title']);
$color=trim($vars['color']);
$groups=unserialize($vars['groups']);
$adminuid=intval($vars['adminuid']);
$uid=intval($_GET['uid']);
$user=DB::fetch_first("select * from ".DB::table('common_member')." where uid=%d",array($uid));
if(!$user) showmessage(lang('plugin/zqlj_repassword','nouser'));
if(in_array($user['groupid'],$groups)) showmessage(lang('plugin/zqlj_repassword','banadmin'));
if(submitcheck('submit')){
	$newpw=addslashes(trim($_GET['newpw']));
	if($newpw){
		loaducenter();
		$ucresult = uc_user_edit(addslashes($user['username']),$newpw,$newpw,addslashes(strtolower(trim($user['email']))), 1,'');
		if($ucresult<0){
			showmessage(lang('plugin/zqlj_repassword','fail'));
		}
		if($adminuid){
			$message=lang('plugin/zqlj_repassword','message',array(
				'time'=>dgmdate(TIMESTAMP,'Y-m-d H:i:s'),
				'username'=>dhtmlspecialchars($_G['username']),
				'uid'=>$uid,
			));
			notification_add($adminuid,'system',$message);
		}		
		showmessage(lang('plugin/zqlj_repassword','ok'),"home.php?mod=space&uid=$uid&do=profile", array(), array('locationtime'=>true,'refreshtime'=>3, 'showdialog'=>1, 'showmsg' => true));
	}else{
		showmessage(lang('plugin/zqlj_repassword','nopw'));
	}
}else{
	include template("zqlj_repassword:change");
}