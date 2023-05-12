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
 * 个人设置模块
 * @author CHEN
 *
 */

global $_G;
//$_G['gp_do']过滤
if (!get_magic_quotes_gpc()) {
	$_G['gp_do'] = addslashes($_G['gp_do']);
}
$_G['gp_do'] = strip_tags($_G['gp_do']);
//$_G['gp_fid']过滤
$_G['gp_fid'] = (int)intval($_G['gp_fid']);

$fid = $_G['gp_fid']; // 版块ID
$action = $_G['gp_do']; // 操作类型
loadcache('forums');
$forumlist = $_G['cache']['forums'];

if(!empty($fid)){
	include_once (DISCUZ_ROOT.'/source/plugin/ukasky_payforum/class/payforum.class.php');
	$ukasky_payforum = new ukasky_payforum_payforum();
	$payforum = $ukasky_payforum->getpayforum($fid);
	if(!$payforum){
		showmessage(lang('plugin/ukasky_payforum','noneedpay'),'forum.php?mod=forumdisplay&fid='.$fid);
	}
	if(!empty($action)){
		if($action == 'payforum'){
			//判断当前用户是否有足够的积分
			if($payforum[paynum] > getuserprofile('extcredits'.$payforum[paycredit])){
				showmessage(lang('plugin/ukasky_payforum','lackextcredits').$_G['setting']['extcredits'][$payforum[paycredit]]['title']);
			}
			//判断当前是否已经付费
			$userpay = DB::fetch_first("SELECT * FROM `".DB::table(ukasky_payforum)."` WHERE `fid`='$fid' AND `uid`='$_G[uid]' ORDER BY `dateline` DESC ");
			if(is_array($userpay) && ($userpay[validdays] === 0 || $userpay[dateend] >= TIMESTAMP)){
				showmessage(lang('plugin/ukasky_payforum','haspay'),"forum.php?mod=forumdisplay&fid=$fid");
			}
			doPay($_G[uid],$payforum);
			// 处理积分
			updatemembercount($_G[uid],array($payforum[paycredit] => -$payforum[paynum]));
			showmessage(lang('plugin/ukasky_payforum','paysuccess'),"forum.php?mod=forumdisplay&fid=$fid");
		}
	}
}else {
	// 付费记录
	$query = DB::query("SELECT * FROM `".DB::table('ukasky_payforum')."` WHERE `uid`='".$_G[uid]."' ORDER BY `dateline` DESC LIMIT 0, 50;");
	while ($db = DB::fetch($query)){
		$list[] = $db;
	}
	loadcache('forums');
	$forumlist = $_G['cache']['forums'];
}

/**
 *
 * 处理支付
 */
function doPay($uid,$payforum){
	// 写入支付数据
	$dateline = TIMESTAMP;
	$dateend = $dateline+$payforum[paydays]*24*3600;
	DB::insert('ukasky_payforum',array(
		'uid' => $uid,
		'username' => $_G[username],
		'fid' => $payforum[fid],
		'paynum' => $payforum[paynum],
		'paycredit' => $payforum[paycredit],
		'validdays' => $payforum[paydays],
		'dateline' => $dateline,
		'dateend' => $dateend
	));
}
?>