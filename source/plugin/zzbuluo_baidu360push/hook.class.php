<?php

/**
 * Copyright 2001-2099 1314学习网.
 * This is NOT a freeware, use is subject to license terms
 * $Id: hook.class.php 521 2020-06-26 21:04:04Z zhuge $
 * 应用售后问题：http://www.1314study.com/services.php?mod=issue
 * 应用售前咨询：QQ 15326940
 * 应用定制开发：QQ 643306797
 * 本插件为 1314学习网（www.1314study.com） 独立开发的原创插件, 依法拥有版权。
 * 未经允许不得公开出售、发布、使用、修改，如需购买请联系我们获得授权。
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


//Copyright 2001-2099 1314学习网.
//This is NOT a freeware, use is subject to license terms
//$Id: hook.class.php 966 2020-06-26 13:04:04Z zhuge $
//应用售后问题：http://www.1314study.com/services.php?mod=issue
//应用售前咨询：QQ 15326940
//应用定制开发：QQ 643306797
//本插件为 1314学习网（www.1314study.com） 独立开发的原创插件, 依法拥有版权。
//未经允许不得公开出售、发布、使用、修改，如需购买请联系我们获得授权。