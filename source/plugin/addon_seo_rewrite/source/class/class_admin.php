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
 * $Id: class_admin.php 1575 2023-01-12 19:00:21
 * 应用售后问题：http://www.1314study.com/services.php?mod=issue（备用 http://t.cn/RU4FEnD）
 * 应用售前咨询：QQ 153.26.940
 * 应用定制开发：QQ 64.330.67.97
 * 本插件为 1314学习网（www.1314study.com） 独立开发的原创插件, 依法拥有版权。
 * 未经允许不得公开出售、发布、使用、修改，如需购买请联系我们获得授权。
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
exit('http://cnkbtk.com/');
}
class addon_seo_rewrite_admin{
	public static function template($file, $templateid = 0, $tpldir = '', $gettplfile = 0, $primaltpl = '') {
	    $file = 'addon_seo_rewrite:admin/' . $file;
	    return template($file, $templateid, $tpldir, $gettplfile, $primaltpl);
	}
	
	public static function subtitle($menus, $type = '', $op = ''){
		if(is_array($menus)) {
			if(!$op){
					$actives[$type] = ' class="active"';
					showtableheader('','study_tb', 'style="background-color: transparent;display: table;"');
					$s .='<div class="study_tab study_tab_min">';
					foreach($menus as $k => $menu){
							$s .= '<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$menu[1].'" '.$actives[$menu[1]].'><i></i><ins></ins>'.$menu[0].'</a>';
					}                                           
					$s .= '</div>';
					showtablerow('', array(''), array($s));
					showtablefooter();
			}else{
					$actives[$op] = ' class="current" ';
					showtableheader('', 'study_tb');
					$s = '<div class="study_tab_mid"><ul class="tab1">';
					foreach($menus as $k => $menu){
							$s .= '
							<li '.$actives[$menu[1]].'>
							<a href="'.ADMINSCRIPT.'?action='.STUDY_MANAGE_URL.'&type1314='.$type.'&op='.$menu[1].'">
							<span>'.$menu[0].'</span>
							</a>
							</li>';
					}
					$s .= '</ul></div>';
					//echo "\n".'<tr><th style="height:5px; padding:5px 0 0;"></th></tr>';
					showtitle($s);
					showtablefooter();
			}
		}
	}
}

//Copyright 2001-2099 .1314.学习网.
//This is NOT a freeware, use is subject to license terms
//$Id: class_admin.php 2038 2023-01-12 11:00:21
//应用售后问题：http://www.1314study.com/services.php?mod=issue （备用 http://t.cn/EUPqQW1）
//应用售前咨询：QQ 15.3269.40
//应用定制开发：QQ 643.306.797
//本插件为 131.4学习网（www.1314Study.com） 独立开发的原创插件, 依法拥有版权。
//未经允许不得公开出售、发布、使用、修改，如需购买请联系我们获得授权。