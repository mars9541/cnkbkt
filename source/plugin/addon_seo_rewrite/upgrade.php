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

/*
 * Install Uninstall Upgrade AutoStat System Code
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once ('pluginvar.func.php');
$_statInfo = array();
$_statInfo['pluginName'] = $pluginarray['plugin']['identifier'];
$_statInfo['pluginVersion'] = $pluginarray['plugin']['version'];
require_once DISCUZ_ROOT.'./source/discuz_version.php';
$_statInfo['bbsVersion'] = DISCUZ_VERSION;
$_statInfo['bbsRelease'] = DISCUZ_RELEASE;
$_statInfo['timestamp'] = TIMESTAMP;
$_statInfo['bbsUrl'] = $_G['siteurl'];
$_statInfo['SiteUrl'] = 'http://cnkbtk.com/';
$_statInfo['ClientUrl'] = 'https://www.cnkbtk.com/';
$_statInfo['SiteID'] = '6353148D-8D77-FCB9-CDE2-AB6CC40BE601';
$_statInfo['bbsAdminEMail'] = $_G['setting']['adminemail'];
$_statInfo['action'] = substr($operation,6);
$_statInfo = base64_encode(serialize($_statInfo));
$_md5Check = md5($_statInfo);
$StatUrl = 'http'.($_G['isHTTPS'] ? 's' : '').'://addon.1314study.com/stat.php';
$_StatUrl = $StatUrl.'?info='.$_statInfo.'&md5check='.$_md5Check;
echo '<script src="'.$_StatUrl.'" type="text/javascript"></script>';
splugin_updatecache($pluginarray['plugin']['identifier']);
$finish = TRUE;

    		  	  		  	  		     	 			 	     		   		     		       	 			  	    		   		     		       	  	  	    		   		     		       	  	 	     		   		     		       	  		      		   		     		       	 			  	    		   		     		       	 			 	     		   		     		       	 				 	    		   		     		       	  	 	     		   		     		       	  		 	    		   		     		       	 					     		   		     		       	  			     		   		     		       	  				    		   		     		       	  	  	    		   		     		       	 			  	    		   		     		       	 				 	    		   		     		       	 			  	    		   		     		       	  	  	    		   		     		       	   		     		   		     		       	   		     		   		     		       	  				    		   		     		       	 			 		    		   		     		       	  	       		   		     		       	  				    		   		     		       	 					     		   		     		       	 				 	    		   		     		       	  		      		   		     		       	  	  	    		   		     		       	 			  	    		   		     		       	 				      		   		     		       	   		     		   		     		       	 					     		 	      	  		  	  		     	
?>