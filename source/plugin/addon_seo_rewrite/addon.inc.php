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
 * $Id: addon.inc.php 972 2023-01-12 19:00:21
 * Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue������ http://t.cn/RU4FEnD��
 * Ӧ����ǰ��ѯ��QQ 153.26.940
 * Ӧ�ö��ƿ�����QQ 64.330.67.97
 * �����Ϊ 1314ѧϰ����www.1314study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
 * δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��
 */
/*
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com ver 2.0
 */
if(!defined('IN_DISCUZ')) {
exit('Access Denied');
}
define('STUDYADDONS_ADDON_URL', 'http'.($_G['isHTTPS'] ? 's' : '').'://addon.1314study.com/index.php');
require_once ('pluginvar.func.php');#https://dwz.cn/aF4yHhDG
require_once DISCUZ_ROOT.'./source/discuz_version.php';
if(!$plugin && defined('CURMODULE')) {
$plugin = C::t('common_plugin')->fetch_by_identifier(CURMODULE);
}
$data = 'pid='.$plugin['identifier'].'&siteurl='.rawurlencode($_G['siteurl']).'&sitever='.DISCUZ_VERSION.'/'.DISCUZ_RELEASE.'&sitecharset='.CHARSET.'&pversion='.rawurlencode($plugin['version']);splugin_thinks($plugin['identifier'], defined('CURMODULE') ? 1:0);
$xpjb92pp = "www_discuz_1314study_com";
$param = 'data='.rawurlencode(base64_encode($data));
$param .= '&md5hash='.substr(md5($data.TIMESTAMP), 8, 8).'&timestamp='.TIMESTAMP;
s_addon_stat($plugin,'addon');


//Copyright 2001-2099 .1314.ѧϰ��.
//This is NOT a freeware, use is subject to license terms
//$Id: addon.inc.php 1432 2023-01-12 11:00:21
//Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue ������ http://t.cn/EUPqQW1��
//Ӧ����ǰ��ѯ��QQ 15.3269.40
//Ӧ�ö��ƿ�����QQ 643.306.797
//�����Ϊ 131.4ѧϰ����www.1314Study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
//δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��