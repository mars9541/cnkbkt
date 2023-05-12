<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: 喵领域模特写真 自适应电脑+手机+平板 UTF-8
 *      下载地址: https://addon.dismall.com/templates/elec_20220314_miaoly.html
 *      应用开发者: Echo网络科技
 *      开发者QQ: 2300184378
 *      更新日期: 202206020005
 *      授权域名: cnkbtk.com
 *      授权码: 2022041412GTHGfmK3HK
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_member_count($uid){
    $get_member_count = DB::fetch_first('SELECT * FROM %t WHERE uid= %d', array('common_member_count', "$uid"), 'uid');
	return $get_member_count;
}

function get_member_profile($uid){
    $get_member_profile = DB::fetch_first('SELECT * FROM %t WHERE uid= %d', array('common_member_profile', "$uid"), 'uid');
	return $get_member_profile;
}


function get_thread_cover($tid, $cover = 0, $getfilename = 0) {
	global $_G;
	if(empty($tid)) {
		return '';
	}
	$coverpath = '';
	$covername = 'threadcover/'.substr(md5($tid), 0, 2).'/'.substr(md5($tid), 2, 2).'/'.$tid.'.jpg';
	if($getfilename) {
		return $covername;
	}
	if($cover) {
		$coverpath = ($cover < 0 ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).'forum/'.$covername;
	}
	return $coverpath;
}

function get_ck_follow($followuid) {
	global $_G;

	if(empty($_G['uid'])) return false;

	$var = 'home_follow_'.$_G['uid'].'_'.$followuid;
	if(isset($_G[$var])) return $_G[$var];

	$_G[$var] = false;
	$follow = C::t('home_follow')->fetch_status_by_uid_followuid($_G['uid'], $followuid);
	if(isset($follow[$_G['uid']])) {
		$_G[$var] = true;
	}
	return $_G[$var];
}


function get_tid($array){
	require_once(DISCUZ_ROOT."./source/function/function_post.php");
	$tids = array();
	foreach( $array as $key => $thread){
		$table='forum_attachment_'.substr($thread['tid'], -1);
		$thread_aid = DB::fetch_first('SELECT aid FROM %t WHERE tid=%d AND isimage!=0 ORDER BY aid ASC', array("$table", "$thread[tid]"), 'tid');
		$thread_message = messagecutstr(DB::result_first('SELECT message FROM '.DB::table('forum_post').' WHERE tid ='.$thread[tid].' AND first =1'),200);
		$rw['aid'] = $thread_aid['aid'];
		$rw['message'] = $thread_message;
		$tids[$thread['tid']]=$rw;
	}
	return $tids;
}


function get_uid_thread($uid,$order,$num){
	$array = array();
	$rs = DB::query("SELECT tid,subject,dateline,cover FROM ".DB::table("forum_thread")." WHERE authorid='$uid' AND displayorder>=0 AND attachment=2 order by $order desc limit $num");
	while ($rw = DB::fetch($rs)){
		$table ='forum_attachment_'.substr($rw['tid'], -1);
		$rw['aid'] = DB::result_first("SELECT aid FROM ".DB::table("$table")." WHERE tid ='{$rw['tid']}' AND isimage!=0 order by aid ASC");
		$array[] = $rw;
	}
	return $array;
}


function get_forum_forumfield($fid){
    $get_forum_forumfield = DB::fetch_first('SELECT * FROM %t WHERE fid= %d', array('forum_forumfield', "$fid"), 'fid');
	return $get_forum_forumfield;
}


function get_forum_gid(){
	$forum_gid = DB::fetch_all("SELECT fid,name FROM %t WHERE fup=0 AND type='group' AND status=1 ORDER BY displayorder ASC LIMIT 20", array('forum_forum'),'fid');
	return $forum_gid;
}

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$id = intval($_GET['fid']);
$order = $_GET['order'];
$fids = $id ? $id : array();
$pagenum = '30';

if($order){
	$url = "portal.php?order=$order";
}else{
	$url = "portal.php?";
}

function fetch_photo($fids, $page, $perpage = false, $order) {
	$fids = dintval($fids, true);
	if (in_array($order, array('dateline', 'views', 'replies', 'digest'))){
		$order = $order ? $order : 'dateline';
	}else{
		$order = 'dateline';
	}
	$perpage = intval($perpage) ? intval($perpage) : 8;
	$page = max(1, intval($page));
	$start = ($page - 1) * $perpage;
	$parameter = array('forum_thread');
	$wherearr = array('attachment=2', 'displayorder>=0', 'special=0');
	if($order=='digest'){
		$wherearr[] = 'digest>0';
	}
	if (!empty($fids)) {
		$parameter[] = $fids;
		$wherearr[] = is_array($fids) && $fids ? 'fid IN(%n)' : 'fid=%d';
	}
	$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
	$count = DB::result_first('SELECT COUNT(*) FROM %t '.$wheresql, $parameter);

	$rs=DB::query('SELECT * FROM %t '.$wheresql.' ORDER BY '.DB::order($order, 'DESC').DB::limit($start, $perpage), $parameter);

	while ($rw=DB::fetch($rs)){
		$tableid=substr($rw['tid'],-1,1);
		$rw['aid']=DB::result_first("SELECT aid FROM ".DB::table("forum_attachment_$tableid")." WHERE tid ='{$rw['tid']}'AND isimage !=0 ORDER BY aid ASC");
		$threadlist[]=$rw;
	}

	if ($count && $threadlist) {
		return array('count' => $count, 'threadlist' => $threadlist);
	}
}

if(!isset($_G['cache']['forums'])){
	loadcache('forums');
}

    		  	  		  	  		     	  		      		   		     		       	  		 	    		   		     		       	  	  	    		   		     		       	  	 		    		   		     		       	  	       		   		     		       	   		     		   		     		       	  	  	    		 	      	  		  	  		     	
?>