<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      Ӧ������: ������ģ��д�� ����Ӧ����+�ֻ�+ƽ�� UTF-8
 *      ���ص�ַ: https://addon.dismall.com/templates/elec_20220314_miaoly.html
 *      Ӧ�ÿ�����: Echo����Ƽ�
 *      ������QQ: 2300184378
 *      ��������: 202206020005
 *      ��Ȩ����: cnkbtk.com
 *      ��Ȩ��: 2022041412GTHGfmK3HK
 *      δ��Ӧ�ó��򿪷���/�����ߵ�������ɣ����ý��з��򹤳̡������ࡢ�������ȣ��������Ը��ơ��޸ġ����ӡ�ת�ء���ࡢ�������桢��չ��֮�йص�������Ʒ����Ʒ��
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