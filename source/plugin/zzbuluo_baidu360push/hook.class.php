<?php

/**
 * Copyright 2001-2099 1314ѧϰ��.
 * This is NOT a freeware, use is subject to license terms
 * $Id: hook.class.php 521 2020-06-26 21:04:04Z zhuge $
 * Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue
 * Ӧ����ǰ��ѯ��QQ 15326940
 * Ӧ�ö��ƿ�����QQ 643306797
 * �����Ϊ 1314ѧϰ����www.1314study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
 * δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��
 */
if (!defined('IN_DISCUZ')) {
exit('Access Denied');
}
class plugin_zzbuluo_baidu360push
{
    public function __construct()
    {
        require_once libfile('function/core', 'plugin/zzbuluo_baidu360push/source');
    }
    public function global_footer()
    {
        global $_G;
        $splugin_setting = $_G['cache']['plugin']['zzbuluo_baidu360push'];
        if (!$splugin_setting['zzbuluo_pcradio']) {
            return '';
        }
        return zzbuluo_baidu360push_js();
    }

}


//Copyright 2001-2099 1314ѧϰ��.
//This is NOT a freeware, use is subject to license terms
//$Id: hook.class.php 966 2020-06-26 13:04:04Z zhuge $
//Ӧ���ۺ����⣺http://www.1314study.com/services.php?mod=issue
//Ӧ����ǰ��ѯ��QQ 15326940
//Ӧ�ö��ƿ�����QQ 643306797
//�����Ϊ 1314ѧϰ����www.1314study.com�� ����������ԭ�����, ����ӵ�а�Ȩ��
//δ�������ù������ۡ�������ʹ�á��޸ģ����蹺������ϵ���ǻ����Ȩ��