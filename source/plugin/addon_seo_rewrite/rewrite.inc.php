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
 * $Id: rewrite.inc.php 4379 2023-01-12 19:00:21
 * Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue������ http://t.cn/RU4FEnD��
 * Ӧ����ǰ��ѯ��QQ 153.26.940
 * Ӧ�ö��ƿ�����QQ 64.330.67.97
 * �����Ϊ 1314ѧϰ����www.1314study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
 * δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/discuz_version.php';
define('STUDY_MANAGE_URL', 'plugins&operation=config&do='.$pluginid.'&identifier='.dhtmlspecialchars($_GET['identifier']).'&pmod=rewrite');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   $_statInfo = array();$_statInfo['pluginName'] = $plugin['identifier'];$_statInfo['pluginVersion'] = $plugin['version'];$_statInfo['bbsVersion'] = DISCUZ_VERSION;$_statInfo['bbsRelease'] = DISCUZ_RELEASE;$_statInfo['timestamp'] = TIMESTAMP;$_statInfo['bbsUrl'] = $_G['siteurl'];$_statInfo['SiteUrl'] = 'http://cnkbtk.com/';$_statInfo['ClientUrl'] = 'https://www.cnkbtk.com/';$_statInfo['SiteID'] = '6353148D-8D77-FCB9-CDE2-AB6CC40BE601';$_statInfo['bbsAdminEMail'] = $_G['setting']['adminemail'];/*1_3.1.4.ѧ.ϰ.��*/
loadcache('plugin');
$splugin_setting = $_G['cache']['plugin']['addon_seo_rewrite'];
$splugin_lang = lang('plugin/addon_seo_rewrite');
(empty($splugin_lang) || !is_array($splugin_lang)) && $splugin_lang = array();
$type1314 = in_array($_GET['type1314'], array('config', 'icon', 'category', 'slide', 'rewrite', 'seo')) ? $_GET['type1314'] : 'config';/*1.3.14.ѧ.ϰ.��*/
$splugin_setting['0'] = array('0' => '2022042908SzLykL3p4f', '1' => '62812','2' => '1673521625', '3' => 'http://cnkbtk.com/', '4' => 'https://www.cnkbtk.com/', '5' => '6353148D-8D77-FCB9-CDE2-AB6CC40BE601', '6' => 'EF653FEB-52A1-06FB-F699-0D70AB36FC9A', '7' => '90d7882916130d17a8a53207356a383f');
require_once libfile('include/rewrite2', 'plugin/addon_seo_rewrite/source');

//Copyright 2001-2099 .1314.ѧϰ��.
//This is NOT a freeware, use is subject to license terms
//$Id: rewrite.inc.php 4842 2023-01-12 11:00:21
//Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue ������ http://t.cn/EUPqQW1��
//Ӧ����ǰ��ѯ��QQ 15.3269.40
//Ӧ�ö��ƿ�����QQ 643.306.797
//�����Ϊ 131.4ѧϰ����www.1314Study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
//δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��