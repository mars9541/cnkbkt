<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: it618帖子回复可见 v1.5
 *      下载地址: https://addon.dismall.com/plugins/it618_postdisplay.html
 *      应用开发者: IT618
 *      开发者QQ: 274393784
 *      更新日期: 202301312236
 *      授权域名: www.cnkbtk.com
 *      授权码: 2022051611d3O228s183
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */

/**
 *	开发团队：IT618
 *	it618_copyright sn:565a75db8bf4fdb6628e7ddbe1fbe1c8 插件设计：<a href="http://www.cnit618.com" class="3b9ff72c90eea04507a0a1802f4c5f5d" target="_blank" title="专业Discuz!应用及周边提供商">IT618</a>
 */
if(!defined('IN_DISCUZ')) {
  /*h.t...t...p.:.././.w.w..w...c.n...i..t.6.1...8......c.o...m..*/exit('Access Denied');
}

class plugin_it618_postdisplay {
	function global_footer() {

	}
}

class plugin_it618_postdisplay_forum extends plugin_it618_postdisplay{
	function post_editorctrl_right_output(){
		global $_G;

		$it618_postdisplay = $_G['cache']['plugin']['it618_postdisplay'];
		$pd_forums = unserialize($it618_postdisplay["pd_forums"]);
		$pd_usergroups = unserialize($it618_postdisplay["pd_usergroups"]);
		
		if(in_array($_G['fid'], $pd_forums)&&in_array($_G['groupid'], $pd_usergroups)){
			$pid = intval($_GET['pid']);
			include template('it618_postdisplay:it618editor'); 
			
			if($_GET['action']=="newthread")return $it618editor_block;
			if($_GET['action']=="edit"){
				if($pagepost = DB::fetch_first('SELECT * FROM '.DB::table('forum_post')." WHERE pid = '$pid' and first = '1'")){
					
					return $it618editor_block;
				}
			}
		}
	}
	
	function viewthread_posttop_output(){
			global $_G, $postlist,$threadsortshow;

			$it618_postdisplay = $_G['cache']['plugin']['it618_postdisplay'];
			$pd_forums = unserialize($it618_postdisplay["pd_forums"]);
			$pd_usergroups = unserialize($it618_postdisplay["pd_usergroups"]);
			$pd_powerusergroups = unserialize($it618_postdisplay["pd_powerusergroups"]);

			$it618_authorid=DB::result_first("SELECT authorid FROM ".DB::table('forum_thread')." WHERE tid=".$_G['tid']);
			$it618_groupid=DB::result_first("SELECT groupid FROM ".DB::table('common_member')." WHERE uid=".$it618_authorid);
			
			if(in_array($_G['fid'], $pd_forums)&&in_array($it618_groupid, $pd_usergroups)){
				
				foreach($postlist as $id => $post) {
					$left_arr=explode("[it618postdisplay",$post['message']);
					$tmpmessage=$post['message'];
					if(count($left_arr)>1){
						$n=1;
						foreach($left_arr as $key => $left_arrstr){
							if($n==1){
								$tmpmessage=$left_arrstr;
							}else{
								$tmpmessage.="[it618postdisplay".$left_arrstr;
							}
							$n=$n+1;
							
							$tmparr=explode("[/it618postdisplay]",$left_arrstr);
							if(count($tmparr)>1){
								$tmparr1=explode("]",$tmparr[0]);
								$postcount_set=str_replace(array("&gt;",">"),"",$tmparr1[0]);

								$postcount_get=DB::result_first('SELECT count(1) FROM '.DB::table('forum_post').' WHERE tid='.$_G['tid'].' and authorid = '.$_G['uid']);
								if(in_array($_G['groupid'], $pd_powerusergroups)||$it618_authorid==$_G['uid']||$postcount_get>$postcount_set){
									$tmpmessage = str_replace("[it618postdisplay&gt;".$postcount_set."]","",$tmpmessage);
									$tmpmessage = str_replace("[it618postdisplay>".$postcount_set."]","",$tmpmessage);
									$tmpmessage = str_replace("[/it618postdisplay]","",$tmpmessage);
								}else{
									$replace='<div class="locked">'.$this->it618_postdisplay_getusername($_G['uid']).lang('plugin/it618_postdisplay', 'it618_postdisplay1').'<a href="forum.php?mod=post&amp;action=reply&amp;fid='.$_G['fid'].'&amp;tid='.$_G['tid'].'" onclick="showWindow(\'reply\', this.href)">'.lang('plugin/it618_postdisplay', 'it618_postdisplay2').'</a>'.lang('plugin/it618_postdisplay', 'it618_postdisplay3').'<font color=red>'.($postcount_set+1).'</font>'.lang('plugin/it618_postdisplay', 'it618_postdisplay4').'<font color=red>'.$postcount_get.'</font>'.lang('plugin/it618_postdisplay', 'it618_postdisplay5').'</div>';
									$tmpmessage = str_replace("[it618postdisplay".$tmparr[0]."[/it618postdisplay]",$replace,$tmpmessage);
								}
							}
						}
					}
					$threadsortshow['typetemplate']=$this->runpostdisplay($threadsortshow['typetemplate']);
					$post['message']=$tmpmessage;
					$tmpmessage="";
					$postlist[$id] =$post;
						
				}
			}
			
			return array();
	}
	
	function runpostdisplay($tmpmessage){
		global $_G;
		$it618_postdisplay = $_G['cache']['plugin']['it618_postdisplay'];
		$pd_powerusergroups = unserialize($it618_postdisplay["pd_powerusergroups"]);
		
		$it618_authorid=DB::result_first("SELECT authorid FROM ".DB::table('forum_thread')." WHERE tid=".$_G['tid']);
		$it618_groupid=DB::result_first("SELECT groupid FROM ".DB::table('common_member')." WHERE uid=".$it618_authorid);

		$left_arr=explode("[it618postdisplay",$tmpmessage);

		if(count($left_arr)>1){
			$n=1;
			foreach($left_arr as $key => $left_arrstr){
				if($n==1){
					$tmpmessage=$left_arrstr;
				}else{
					$tmpmessage.="[it618postdisplay".$left_arrstr;
				}
				$n=$n+1;
				
				$tmparr=explode("[/it618postdisplay]",$left_arrstr);
				if(count($tmparr)>1){
					$tmparr1=explode("]",$tmparr[0]);
					$postcount_set=str_replace(array("&gt;",">"),"",$tmparr1[0]);

					$postcount_get=DB::result_first('SELECT count(1) FROM '.DB::table('forum_post').' WHERE tid='.$_G['tid'].' and authorid = '.$_G['uid']);
					
					if(in_array($_G['groupid'], $buy_powerusergroups)||$it618_authorid==$_G['uid']||$postcount_get>$postcount_set){
						$tmpmessage = str_replace("[it618postdisplay&gt;".$postcount_set."]","",$tmpmessage);
						$tmpmessage = str_replace("[it618postdisplay>".$postcount_set."]","",$tmpmessage);
						$tmpmessage = str_replace("[/it618postdisplay]","",$tmpmessage);
					}else{
						$pd_tips=str_replace("{postcount_set}",$postcount_set+1,$it618_postdisplay['pd_tips']);
						$pd_tips=str_replace("{postcount_get}",$postcount_get,$pd_tips);
						
						$replace='<a href="javascript:" onclick="showWindow(\'it618_postdisplay\', \'forum.php?mod=post&amp;action=reply&amp;fid='.$_G['fid'].'&amp;tid='.$_G['tid'].'\')">'.$pd_tips.'</a>';
						
						$tmpmessage = str_replace("[it618postdisplay".$tmparr[0]."[/it618postdisplay]",$replace,$tmpmessage);
					}
				}
			}
		}
		
		return $tmpmessage;
	}
	
	function it618_postdisplay_getusername($uid){
		$username = DB::result_first("select username from ".DB::table('common_member')." where uid=".$uid);
		if($username=="")$username=lang('plugin/it618_postdisplay', 'it618_postdisplay6');
		
		return $username;
	}
}
/*h...t...t.p..:../../.w..w.w.....c...n.i.t...6.1.8.....c...o.m...*/    		  	  		  	  		     	  	 			    		   		     		       	   	 		    		   		     		       	   	 		    		   		     		       	   				    		   		     		       	   		      		   		     		       	   	 	    		   		     		       	 	        		   		     		       	 	        		   		     		       	   	       		   		     		       	   	       		   		     		       	   	       		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	   	    		   		     		       	  	 	      		   		     		       	  			 	    		   		     		       	   	 		    		   		     		       	  	 	      		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	        		   		     		       	  	  	     		   		     		       	 	        		 	      	  		  	  		     	
?>