<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      Ӧ������: SEO����α��̬ Discuzα��̬�߼���
 *      ���ص�ַ: https://addon.dismall.com/plugins/addon_seo_rewrite.html
 *      Ӧ�ÿ�����: 1314ѧϰ�� - ���²ɼ���SEO�Ż�
 *      ������QQ: 15326940
 *      ��������: 202301312236
 *      ��Ȩ����: www.cnkbtk.com
 *      ��Ȩ��: 2022042908SzLykL3p4f
 *      δ��Ӧ�ó��򿪷���/�����ߵ�������ɣ����ý��з��򹤳̡������ࡢ�������ȣ��������Ը��ơ��޸ġ����ӡ�ת�ء���ࡢ�������桢��չ��֮�йص�������Ʒ����Ʒ��
 */


/**
 * Copyright 2001-2099 1314 ѧϰ.��.
 * This is NOT a freeware, use is subject to license terms
 * $Id: hook.class.php 1248 2023-01-12 19:00:21
 * Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue������ http://t.cn/RU4FEnD��
 * Ӧ����ǰ��ѯ��QQ 153.26.940
 * Ӧ�ö��ƿ�����QQ 64.330.67.97
 * �����Ϊ 1314ѧϰ����www.1314study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
 * δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��
 */

if (!defined('IN_DISCUZ')) {
exit('Access Denied');
}
class plugin_addon_seo_rewrite {

	function __construct(){
		global $_G;
		if (defined('IN_BULUO') || ($_G['inajax'] && $_GET['mod'] == 'post')) {
			$_G['cache']['plugin']['addon_seo_rewrite']['study_radio'] = 0;
		}
		if ($_G['cache']['plugin']['addon_seo_rewrite']['study_radio']) {
			include_once libfile('function/core', 'plugin/addon_seo_rewrite/source');
		}
	}

	function common() {}
	
	function global_usernav_extra1() {
		global $_G;
		if ($_G['cache']['plugin']['addon_seo_rewrite']['study_radio']) {
			if (CURSCRIPT == 'home' && CURMODULE == 'space' && $_GET['do'] == 'thread') {
				addon_seo_rewrite_multipage();
			}
		}
		return '';
	}
}

class plugin_addon_seo_rewrite_forum extends plugin_addon_seo_rewrite {

	function forumdisplay_thread_output() {
		global $_G;
		if ($_G['cache']['plugin']['addon_seo_rewrite']['study_radio']) {
			addon_seo_rewrite_dispose($_G['forum_threadlist']);
		}
		return array();
	}

	function guide_top_output() {
		global $_G, $data, $view;
		if ($_G['cache']['plugin']['addon_seo_rewrite']['study_radio']) {
			addon_seo_rewrite_dispose($data[$view]['threadlist']);
		}
		return '';
	}
}

//Copyright 2001-2099 .1314.ѧϰ��.
//This is NOT a freeware, use is subject to license terms
//$Id: hook.class.php 1710 2023-01-12 11:00:21
//Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue ������ http://t.cn/EUPqQW1��
//Ӧ����ǰ��ѯ��QQ 15.3269.40
//Ӧ�ö��ƿ�����QQ 643.306.797
//�����Ϊ 131.4ѧϰ����www.1314Study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
//δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��