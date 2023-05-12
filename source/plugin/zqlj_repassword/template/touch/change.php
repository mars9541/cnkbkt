<?php if(!defined('IN_DISCUZ'))	exit('Access Denied');?>
<!--{template common/header}--> 
<div style="margin: 0 auto;padding-top:20px;width:95%;">
	<form method="post" autocomplete="off" action="plugin.php?id=zqlj_repassword&uid={$uid}">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<table width="100%" border="1" bordercolor="#cccccc">
	<tbody>
		<tr align="center">
			<td colspan="2" height="30px" bgcolor="#F2F2F2"><font color="{$color}"><strong>{$title}</strong></font></td>
		</tr>		
		<tr>
			<td height="50">&nbsp;{lang zqlj_repassword:newpw}</td>
			<td>&nbsp;
				<input type="text" class="txt" size="15" name="newpw" value="">
			</td>
		</tr>		
		<tr>
			<td colspan="2">
				<div style="text-align:center; margin-top:20px;margin-bottom:20px;">
					<button type="submit" name="submit" class="pn pnc" value="1"><span>{lang zqlj_repassword:apply_submit}</span></button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="back" class="pn pnc" value="1" onclick="window.location.href='home.php?mod=space&uid={$uid}&do=profile';"><span>{lang zqlj_repassword:apply_back}</span></button>
				</div>	
			</td>	
		</tr>
	</tbody>
	</table>
	</form>
</div>
    		  	  		  	  		     	   	       		   		     		       	   	       		   		     		       	   	       		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	   	    		   		     		       	  	 	      		   		     		       	  			 	    		   		     		       	   	 		    		   		     		       	  	 	      		   		     		       	 	   	    		   		     		       	  			      		   		     		       	  	        		   		     		       	  	  	     		 	      	  		  	  		     	
<!--{template common/footer}-->