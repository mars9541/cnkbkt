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
 * 普通页面嵌入类
 * @author CHEN
 *
 */
class plugin_ukasky_payforum {

	/**
	 *
	 * 全局嵌入点
	 */
	function common(){
		global $_G;
		loadcache('plugin');
		$pluginvar = $_G['cache']['plugin']['ukasky_payforum'];
		$pluginvar['payforums'] = (array) unserialize($pluginvar['payforums']);
		if($pluginvar[isopen] && !empty($pluginvar['payforums'][0]) && in_array($_G['fid'], $pluginvar['payforums'])){
			if(!($pluginvar[isSEO] && $this->isSpider())){
				// 获取允许访问的用户组
				$pluginvar['allowgroups'] = (array) unserialize($pluginvar['allowgroups']);
				if(!in_array($_G['groupid'], $pluginvar['allowgroups'])){
					include_once (DISCUZ_ROOT.'/source/plugin/ukasky_payforum/class/payforum.class.php');
					$ukasky_payforum = new ukasky_payforum_payforum();
					$userPay = $ukasky_payforum->isPayUser($_G['uid'],$_G['fid']);
					if(is_array($userPay)){
						showmessage($userPay['info'], $userPay['url']);
					}
				}
			}
		}
	}

	/**
	 *
	 * 判断是否为搜索引擎蜘蛛
	 */
	function isSpider(){
		// 获取用户代理
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if(!empty($useragent)){
			// 定义蜘蛛名称
			$regex = "(Baiduspider|Googlebot|bingbot|Yahoo|msnbot|Sogou|Sosospider|YodaoBot|YodaoBot|360Spider|EasouSpider|JikeSpider|EtaoSpider)";
			if(preg_match("/$regex/i",$useragent)){
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

}
?>