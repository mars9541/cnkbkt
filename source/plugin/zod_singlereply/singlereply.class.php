<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      Ӧ������: ֻ�ܻظ�һ�� 1.03
 *      ���ص�ַ: https://addon.dismall.com/plugins/zod_singlereply.html
 *      Ӧ�ÿ�����: ľ��
 *      ������QQ: 34616894
 *      ��������: 202205161914
 *      ��Ȩ����: www.cnkbtk.com
 *      ��Ȩ��: 2022051611nRJO8589Sb
 *      δ��Ӧ�ó��򿪷���/�����ߵ�������ɣ����ý��з��򹤳̡������ࡢ�������ȣ��������Ը��ơ��޸ġ����ӡ�ת�ء���ࡢ�������桢��չ��֮�йص�������Ʒ����Ʒ��
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