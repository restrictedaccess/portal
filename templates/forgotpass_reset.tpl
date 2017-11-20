{* $Id: forgotpass_reset.tpl 8 2010-01-13 mike $ *}


<html>
<head>
<title>RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>
<body bgcolor="#ffffff" topmargin="1" leftmargin="10" marginheight="10" marginwidth="10">
<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><a href="#"><img src="images/remotestafflogo.jpg" border="0" ></a></td>
	</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>RESET PASSWORD</font> <span style='font: bold 8pt verdana;'>({$user_email})</span></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td>
		
	<div class="text" style="height:406px;width:100%;">
    <div id="message-box"></div>
	<div style="margin-left:20px;">
		
        {if $valid == 1 && $submitted == 1}
          
		<div style='padding:8px;background:#FFFFCC; font-weight:bold;color:#0000FF'>
			You have successfully reset your password.</div>
        
        {else}
		
		   {if $valid == 1 && $submitted == 0}
        
			<div style='padding:8px;background:#FFFFCC; font-weight:bold;color:#0000FF'>
			  Fill up the form below to reset your password.</div>
		  
		   {else}
               {if $is_error != ''}<div style='padding:8px;background:#FFFFCC; font-weight:bold;color:#FF0000'>{$is_error}</div>{/if}
		   {/if}
		  
		  
           <form method="post" action="forgotpass_reset.php" id="passreset">
	
			<div style='font-size:11px;text-align:left;line-height:15px;margin:12px 5px 0px 12px;'>Enter new password:</div>
			<div style='margin:0 5px 0px 12px;'><input type='password' name='user_password' class='inputbox' size="47" onkeypress="return handleEnter(this, event)"></div>
			
			<div style='font-size:11px;text-align:left;line-height:15px;margin:8px 5px 0px 12px;'>Confirm new password:</div>
			<div style='margin:0 5px 0px 12px;'><input type='password' name='user_password2' class='inputbox' size="47" onkeypress="return handleEnter(this, event)"></div>
			
			<input type='hidden' name='task' value='reset'>
			<input type='hidden' name='k' value='{$k}'>
			<input type='hidden' name='user' value=''>
    
			<div style='margin:6px 2px 4px 12px;'>
			<input name="reset" type="submit" value="Reset Password"> &nbsp; &nbsp;
			<input name="cancel" type="button" value="Cancel" onclick="location.href='index.php'">
		   </div>
		</form>
		                  
        {/if}
        
    
      </div>
	</div>
          
		  
		  
		  
		</td></tr>
		</table>
	</td></tr>
	</table>

	</body>
	</html>
