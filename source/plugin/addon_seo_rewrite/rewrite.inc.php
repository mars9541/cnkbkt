<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: SEO智能伪静态 Discuz伪静态高级版
 *      下载地址: https://addon.dismall.com/plugins/addon_seo_rewrite.html
 *      应用开发者: 1314学习网 - 文章采集、SEO优化
 *      开发者QQ: 15326940
 *      更新日期: 202301312236
 *      授权域名: www.cnkbtk.com
 *      授权码: 2022042908SzLykL3p4f
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */


/**
 * Copyright 2001-2099 1314 学习.网.
 * This is NOT a freeware, use is subject to license terms
 * $Id: rewrite.inc.php 4379 2023-01-12 19:00:21
 * 应用售后问题：http://www.1314study.com/services.php?mod=issue（备用 http://t.cn/RU4FEnD）
 * 应用售前咨询：QQ 153.26.940
 * 应用定制开发：QQ 64.330.67.97
 * 本插件为 1314学习网（www.1314study.com） 独立开发的原创插件, 依法拥有版权。
 * 未经允许不得公开出售、发布、使用、修改，如需购买请联系我们获得授权。
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/discuz_version.php';
define('STUDY_MANAGE_URL', 'plugins&operation=config&do='.$pluginid.'&identifier='.dhtmlspecialchars($_GET['identifier']).'&pmod=rewrite');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   $_statInfo = array();$_statInfo['pluginName'] = $plugin['identifier'];$_statInfo['pluginVersion'] = $plugin['version'];$_statInfo['bbsVersion'] = DISCUZ_VERSION;$_statInfo['bbsRelease'] = DISCUZ_RELEASE;$_statInfo['timestamp'] = TIMESTAMP;$_statInfo['bbsUrl'] = $_G['siteurl'];$_statInfo['SiteUrl'] = 'http://cnkbtk.com/';$_statInfo['ClientUrl'] = 'https://www.cnkbtk.com/';$_statInfo['SiteID'] = '6353148D-8D77-FCB9-CDE2-AB6CC40BE601';$_statInfo['bbsAdminEMail'] = $_G['setting']['adminemail'];/*1_3.1.4.学.习.网*/
loadcache('plugin');
$splugin_setting = $_G['cache']['plugin']['addon_seo_rewrite'];
$splugin_lang = lang('plugin/addon_seo_rewrite');
(empty($splugin_lang) || !is_array($splugin_lang)) && $splugin_lang = array();
$type1314 = in_array($_GET['type1314'], array('config', 'icon', 'category', 'slide', 'rewrite', 'seo')) ? $_GET['type1314'] : 'config';/*1.3.14.学.习.网*/
$splugin_setting['0'] = array('0' => '2022042908SzLykL3p4f', '1' => '62812','2' => '1673521625', '3' => 'http://cnkbtk.com/', '4' => 'https://www.cnkbtk.com/', '5' => '6353148D-8D77-FCB9-CDE2-AB6CC40BE601', '6' => 'EF653FEB-52A1-06FB-F699-0D70AB36FC9A', '7' => '90d7882916130d17a8a53207356a383f');
require_once libfile('include/rewrite2', 'plugin/addon_seo_rewrite/source');

//Copyright 2001-2099 .1314.学习网.
//This is NOT a freeware, use is subject to license terms
//$Id: rewrite.inc.php 4842 2023-01-12 11:00:21
//应用售后问题：http://www.1314study.com/services.php?mod=issue （备用 http://t.cn/EUPqQW1）
//应用售前咨询：QQ 15.3269.40
//应用定制开发：QQ 643.306.797
//本插件为 131.4学习网（www.1314Study.com） 独立开发的原创插件, 依法拥有版权。
//未经允许不得公开出售、发布、使用、修改，如需购买请联系我们获得授权。