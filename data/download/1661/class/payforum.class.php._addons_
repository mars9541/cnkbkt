<?php
/**
 * 
 * Ukasky BBS [http://bbs.ukasky.com]
 * @author Mr. Chen
 * My Blog: http://chen.disyo.com
 * 
 */
include_once (DISCUZ_ROOT.'/source/function/function_core.php');
/**
 * 
 * 付费版块类库
 * @author CHEN
 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class ukasky_payforum_payforum {
	
	var $pluginvar;
	
	function ukasky_payforum_payforum(){
		global $_G;
		loadcache('plugin');
		$this->pluginvar = $_G['cache']['plugin']['ukasky_payforum'];
		$this->pluginvar['payforums'] = (array) unserialize($this->pluginvar['payforums']);
		if($this->pluginvar['setforum']){
			$this->pluginvar['setforum'] = str_replace(array("\r\n", "\n", "\r"), '/ukasky_payforum/', $this->pluginvar['setforum']);
			$this->pluginvar['setforum'] = explode('/ukasky_payforum/',$this->pluginvar['setforum']);
			foreach ($this->pluginvar['setforum'] as $key=>$val){
				$arr = explode('|',$val);
				list($setforum[$arr[0]][fid],$setforum[$arr[0]][paycredit],$setforum[$arr[0]][paynum],$setforum[$arr[0]][paydays]) = $arr;
			}
			$this->pluginvar['setforum'] = $setforum;
		}
	}
	
	/**
	 * 
	 * 获取板块的付款积分信息
	 * @param int $fid
	 * @return array
	 */
	function getpayforum($fid){
		// 判断当前板块是否为付费版块
		if(in_array($fid, $this->pluginvar['payforums'])){
			// 判断当前板块是否为特殊付费版块
			if(is_array($this->pluginvar['setforum'][$fid])){
				// 返回特殊设置的积分
				return array(
				'fid' => $fid,
				'paycredit' => $this->pluginvar['setforum'][$fid]['paycredit'],
				'paynum' => $this->pluginvar['setforum'][$fid]['paynum'],
				'paydays' => $this->pluginvar['setforum'][$fid]['paydays'],
				);
			}else {
				// 返回通用的付费积分
				return array(
				'fid' => $fid,
				'paycredit' => $this->pluginvar['paycredit'],
				'paynum' => $this->pluginvar['paynum'],
				'paydays' => $this->pluginvar['paydays'],
				);
			}
		}else{
			return false;
		}
	}
	
	/**
	 * 
	 * 判断该板块是否设置付费
	 * @param int $fid
	 */
	function ispayforum($fid){
		if(in_array($fid, $this->pluginvar['payforums'])){
			return true;
		}else {
			return false;
		}
	}
	
	/**
	 *
	 * 判断当前用户是否为付费用户
	 */
	function isPayUser($uid,$fid){
		$payinfo = DB::fetch_first("SELECT * FROM `".DB::table(ukasky_payforum)."` WHERE `fid`='$fid' AND `uid`='$uid' ORDER BY `dateend` DESC ");
		if($payinfo['dateend']){
			if($payinfo['dateend'] >= TIMESTAMP){
				return true;
			}else {
				return array(
						'status' => 0,
						'info' => lang('plugin/ukasky_payforum','overtime'),
						'url' => 'home.php?mod=spacecp&ac=plugin&id=ukasky_payforum:payforum&fid='.$fid,
				);
			}
		}else {
			return array(
					'status' => 0,
					'info' => lang('plugin/ukasky_payforum','noprivilege'),
					'url' => 'home.php?mod=spacecp&ac=plugin&id=ukasky_payforum:payforum&fid='.$fid,
			);
		}
	}
	
}
?>