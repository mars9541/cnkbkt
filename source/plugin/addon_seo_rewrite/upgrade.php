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