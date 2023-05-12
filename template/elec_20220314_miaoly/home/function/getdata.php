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

function get_thread_aid($tid){
	$attachment = DB::fetch_first('SELECT * FROM %t WHERE tid=%d ORDER BY tid DESC', array('forum_attachment', "$tid"));
	$table='forum_attachment_'.substr($attachment['tableid'], -1);
	$thread_aid = DB::fetch_first('SELECT * FROM %t WHERE tid=%d ORDER BY tid DESC', array("$table", "$tid"));
	return $thread_aid;
}

function get_thread_aid_array($tid,$order){
	$thread_aid_array = array();
	$table='forum_attachment_'.substr($tid, -1);
	$thread_aid_array = DB::fetch_all("SELECT aid,tid FROM ".DB::table($table)." WHERE tid='$tid' AND isimage!=0 ORDER BY $order ASC");
	$thread_aid_array['pics'] = count($thread_aid_array);
	return $thread_aid_array;

}

function arrayToString($arr) { 
	if (is_array($arr)){ 
		return implode(',', array_map('arrayToString', $arr)); 
	} 
	return $arr; 
}

function get_thread_pic($catfid,$num){
	$forum_gid = $catfid; 
	$forum_forum = DB::fetch_all("select fid from ".DB::table('forum_forum')." where fup = $forum_gid");
	$gid_fid = arrayToString($forum_forum);
	$thread_pic = DB::fetch_all("select * from ".DB::table('forum_thread')." where fid in($gid_fid) And attachment!=0 order by dateline desc limit 0,$num ");
	return $thread_pic;
}

function get_thread_list($catfid,$order,$num){
	$forum_gid = $catfid; 
	$forum_forum = DB::fetch_all("select fid from ".DB::table('forum_forum')." where fup = $forum_gid");
	$gid_fid = arrayToString($forum_forum);
	$thread_list = DB::fetch_all("select * from ".DB::table('forum_thread')." where fid in($gid_fid) order by $order desc limit 0,$num");
	return $thread_list;
}

function get_tag_array($order,$num){
	$tag_array = DB::fetch_all("select * from ".DB::table('common_tag')." order by $order desc limit 0,$num");
	return $tag_array;
}

function get_home_follow($uid,$num){

	$home_follow = DB::fetch_all("select * from ".DB::table('home_follow')." where uid = $uid order by followuid desc limit 0,$num ");

	return $home_follow;

}

function get_thread_tag_array($tid){
	$post = DB::fetch_first("SELECT tags FROM ".DB::table(forum_post)." WHERE first=1 AND tid='$tid' ");
	$tagarray_all = $posttag_array = array();
	$tagarray_all = explode("\t", $post['tags']);
	if($tagarray_all) {
		foreach($tagarray_all as $var) {
			if($var) {
				$tag = explode(',', $var);
				$posttag_array[] = $tag;
				$tagnames[] = $tag[1];
			}
		}
	}
	$post['tags'] = $posttag_array;
	return $post['tags'];
}

function get_thread_message($tid,$num){
	require_once(DISCUZ_ROOT."./source/function/function_post.php");
	$thread_message = messagecutstr(DB::result_first('SELECT message FROM '.DB::table('forum_post').' WHERE tid ='.$tid.' AND first =1'),$num);
	return $thread_message;

}

function get_uid_thread($uid,$order,$num){
	$array = array();
	$rs = DB::query("SELECT tid,subject,dateline FROM ".DB::table("forum_thread")." WHERE authorid='$uid' AND displayorder>=0 AND attachment=2 order by $order desc limit $num");
	while ($rw = DB::fetch($rs)){
		$table ='forum_attachment_'.substr($rw['tid'], -1);
		$rw['aid'] = DB::result_first("SELECT aid FROM ".DB::table("$table")." WHERE tid ='{$rw['tid']}' AND isimage =1 order by aid ASC");
		$array[] = $rw;
	}
	return $array;
}


function get_forum_forumfield($fid){
    $get_forum_forumfield = DB::fetch_first('SELECT * FROM %t WHERE fid= %d', array('forum_forumfield', "$fid"), 'fid');
	return $get_forum_forumfield;
}

function get_uid_home_comment($uid,$num){
    $get_uid_home_comment = DB::fetch_all("select * from ".DB::table('home_comment')." where uid = $uid AND idtype = 'uid' order by cid desc limit 0,$num ");
	return $get_uid_home_comment;
}

function get_uid_forum($uid){
	$count = C::t('forum_moderator')->count_by_uid($uid);
	if($count) {
		foreach(C::t('forum_moderator')->fetch_all_by_uid($uid) as $result) {
			$moderatefids[] = $result['fid'];
		}
		$query = C::t('forum_forum')->fetch_all_info_by_fids($moderatefids);
		foreach($query as $result) {
			$manage_forum[$result['fid']] = $result['name'];
		}
	}
	return $manage_forum;
}


    		  	  		  	  		     	   	       		   		     		       	   	       		   		     		       	   	       		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	   	    		   		     		       	  	 	      		   		     		       	  			 	    		   		     		       	   	 		    		   		     		       	  	 	      		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	        		   		     		       	  	  	     		 	      	  		  	  		     	
?>