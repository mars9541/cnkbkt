<?php
/**
 *
 * Ukasky BBS [http://bbs.ukasky.com]
 * @author Mr. Chen
 * My Blog: http://chen.disyo.com
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 *
 * 手机页面嵌入
 * @author CHEN
 *
 */
class mobileplugin_ukasky_payforum {

	function common(){
		global $_G;
		loadcache('plugin');
		$pluginvar = $_G['cache']['plugin']['ukasky_payforum'];
		$pluginvar['payforums'] = (array) unserialize($pluginvar['payforums']);
		if($pluginvar['isopen'] && !empty($pluginvar['payforums'][0]) && in_array($_G['fid'], $pluginvar['payforums'])){
			$pluginvar['allowgroups'] = (array) unserialize($pluginvar['allowgroups']);
			if(!in_array($_G['groupid'], $pluginvar['allowgroups'])){
				include_once (DISCUZ_ROOT.'/source/plugin/ukasky_payforum/class/payforum.class.php');
				$ukasky_payforum = new ukasky_payforum_payforum();
				$userPay = $ukasky_payforum->isPayUser($_G['uid'],$_G['fid']);
				if(is_array($userPay)){
					showmessage($userPay['info'],$userPay['url']);
				}
			}
		}
	}
}

?>