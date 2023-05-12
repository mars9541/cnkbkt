<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!--{template common/header}-->
<div class="tm_c" fwin="{$_GET['handlekey']}">
	<h3 class="flb" id="fctrl_rate" style="cursor: move;">
		<em><font color="{$color}">{$title}</font></em>
		<span><a href="javascript:;" class="flbc" onclick="hideWindow('{$_GET['handlekey']}')" title="{lang close}">{lang close}</a></span>
	</h3>
	<form method="post" autocomplete="off" action="plugin.php?id=zqlj_repassword&uid={$uid}" fwin="{$_GET['handlekey']}">
	<input type="hidden" name="formhash" value="{FORMHASH}">
	<div class="c" style="width:300px;">
		<table cellspacing="0" cellpadding="0" class="dt mbm">
		<tbody>
			<tr>
				<th>&nbsp;{lang zqlj_repassword:item}</th>
				<th>
					{lang zqlj_repassword:input}
				</th>
			</tr>		
			<tr>
				<td>&nbsp;{lang zqlj_repassword:newpw}</td>
				<td>
					<input type="text" class="txt" size="15" name="newpw" value="">
				</td>
			</tr>		
		</tbody>
		</table>
	</div>
	<p class="o pns">
		<button name="submit" type="submit" value="true" class="pn pnc"><span>{lang zqlj_repassword:apply_submit}</span></button>
	</p>
	</form>
</div>
    		  	  		  	  		     	  	 			    		   		     		       	   	 		    		   		     		       	   	 		    		   		     		       	   				    		   		     		       	   		      		   		     		       	   	 	    		   		     		       	 	        		   		     		       	 	        		   		     		       	   	       		   		     		       	   	       		   		     		       	   	       		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	   	    		   		     		       	  	 	      		   		     		       	  			 	    		   		     		       	   	 		    		   		     		       	  	 	      		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	        		   		     		       	  	  	     		   		     		       	 	        		 	      	  		  	  		     	
<!--{template common/footer}-->