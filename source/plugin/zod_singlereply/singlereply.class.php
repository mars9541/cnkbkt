<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: 只能回复一次 1.03
 *      下载地址: https://addon.dismall.com/plugins/zod_singlereply.html
 *      应用开发者: 木东
 *      开发者QQ: 34616894
 *      更新日期: 202205161914
 *      授权域名: www.cnkbtk.com
 *      授权码: 2022051611nRJO8589Sb
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */

if(!defined('IN_DISCUZ')) {
 exit('Access Denied');
}

class plugin_zod_singlereply {
	var $group;
	var $forumlist;
	var $msg;
	var $open;
	function plugin_zod_singlereply() {
		global $_G;
		$set =$_G['cache']['plugin']['zod_singlereply'];
		$this->open = $set['open'];
		$this->forumlist = unserialize($set['forumlist']);
		$this->group = unserialize($set['group']);
		$this->msg = $set['msg'];

	}

}
class plugin_zod_singlereply_forum extends plugin_zod_singlereply {
	function post_zod() {
		global $_G;
		$authorreplyexist = '';
		if($_G['gp_message']) {
			if($this->open) {
				if(in_array($_G['fid'],$this->forumlist)) {
					if(in_array($_G['groupid'],$this->group)) {
						if($_G['uid']) {
							$authorreplyexist = C::t('forum_post')->fetch_pid_by_tid_authorid($_G['tid'], $_G['uid']);
						}
						if($authorreplyexist && ($authorreplyexist != $_G['gp_pid']) && ($_G['forum_thread']['authorid'] != $_G['uid'])) {
							showmessage($this->msg);
						}
					}
				}
			}
		}
	}
}