<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: 喵领域模特写真 自适应电脑+手机+平板 UTF-8
 *      下载地址: https://addon.dismall.com/templates/elec_20220314_miaoly.html
 *      应用开发者: Echo网络科技
 *      开发者QQ: 2300184378
 *      更新日期: 202206020005
 *      授权域名: cnkbtk.com
 *      授权码: 2022041412GTHGfmK3HK
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */


if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$page=$_G['page'];
$pagenum='12';
$length='200';
$begin=($page-1)*$pagenum;
$threadlist=array();

require_once(DISCUZ_ROOT."source/function/function_post.php");
$rs=DB::query("select t.*,p.message from ".DB::table("forum_thread")." t left join ".DB::table("forum_post")." p on  t.tid=p.tid and p.first=1 where t.authorid='{$space['uid']}' and t.displayorder>=0 and t.attachment>0 order by t.dateline desc limit $begin, $pagenum");
while ($rw=DB::fetch($rs)){
	$rw['message']=messagecutstr($rw['message'],$length,'');
	$rw['message']=dhtmlspecialchars($rw['message']);		
	$tableid=substr($rw['tid'],-1,1);
	$rw['aid']=DB::result_first("SELECT aid FROM ".DB::table("forum_attachment_{$tableid}")." WHERE `tid` ='{$rw['tid']}'AND isimage =1 ORDER BY aid ASC LIMIT 0 , 1");
	$threadlist[]=$rw;
}

$allnum=DB::result_first("select count(*) from ".DB::table("forum_thread")." t where t.authorid='{$space['uid']}' and t.displayorder>=0 and t.attachment=2");
$pagenav=multi($allnum,$pagenum,$page,"home.php?mod=follow&uid={$space['uid']}&do=view&from=space");
if(!isset($_G['cache']['forums'])){
	loadcache('forums');
}

    		  	  		  	  		     	  	 			    		   		     		       	   	 		    		   		     		       	   	 		    		   		     		       	   				    		   		     		       	   		      		   		     		       	   	 	    		   		     		       	 	        		   		     		       	 	        		   		     		       	   	       		   		     		       	   	       		   		     		       	   	       		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	   	    		   		     		       	  	 	      		   		     		       	  			 	    		   		     		       	   	 		    		   		     		       	  	 	      		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	        		   		     		       	  	  	     		   		     		       	 	        		 	      	  		  	  		     	
?>