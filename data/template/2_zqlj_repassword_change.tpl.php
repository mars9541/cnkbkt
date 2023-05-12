<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('change');?><?php include template('common/header'); ?><div class="tm_c" fwin="<?php echo $_GET['handlekey'];?>">
<h3 class="flb" id="fctrl_rate" style="cursor: move;">
<em><font color="<?php echo $color;?>"><?php echo $title;?></font></em>
<span><a href="javascript:;" class="flbc" onclick="hideWindow('<?php echo $_GET['handlekey'];?>')" title="关闭">关闭</a></span>
</h3>
<form method="post" autocomplete="off" action="plugin.php?id=zqlj_repassword&amp;uid=<?php echo $uid;?>" fwin="<?php echo $_GET['handlekey'];?>">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<div class="c" style="width:300px;">
<table cellspacing="0" cellpadding="0" class="dt mbm">
<tbody>
<tr>
<th>&nbsp;项目</th>
<th>
输入
</th>
</tr>		
<tr>
<td>&nbsp;新密码：</td>
<td>
<input type="text" class="txt" size="15" name="newpw" value="">
</td>
</tr>		
</tbody>
</table>
</div>
<p class="o pns">
<button name="submit" type="submit" value="true" class="pn pnc"><span>提交</span></button>
</p>
</form>
</div>
    		  	  		  	  		     	  	 			    		   		     		       	   	 		    		   		     		       	   	 		    		   		     		       	   				    		   		     		       	   		      		   		     		       	   	 	    		   		     		       	 	        		   		     		       	 	        		   		     		       	   	       		   		     		       	   	       		   		     		       	   	       		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	   	    		   		     		       	  	 	      		   		     		       	  			 	    		   		     		       	   	 		    		   		     		       	  	 	      		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	        		   		     		       	  	  	     		   		     		       	 	        		 	      	  		  	  		     <?php include template('common/footer'); ?>