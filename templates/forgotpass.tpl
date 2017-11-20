
{* $Id: forgotpass.tpl 1 2010-01-12 mike  $ *}

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
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>RETRIEVE PASSWORD</font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td>
  <table width="99%" height="147" border="0" cellpadding="0" cellspacing="0" class="text">
                <!--DWLayoutTable-->
                
				{* SHOW SUCCESS MESSAGE IF NO ERROR *}
				{if $submitted == 1 AND $is_error == ''}
				
				  <table cellpadding='0' cellspacing='0'>
				  <tr><td class='result'>
					<div style='padding:8px;background:#FFFFCC; font-weight:bold;color:#0000FF'>A confirmation code has been sent to {$user_email}, you should receive an email
					 explaining on how to reset your password.</div>
				  </td></tr></table>
		  
				{else}
				  {if $is_error != ''}<div style='padding:4px;background:#FFFFCC; text-align:center; font-weight:bold;color:#FF0000'>{$is_error}</div>{/if}
				  
                 <form action="forgotpass.php" name="form" method="post">
				  <input type="hidden"  name="user" value="{$user}">
				  <input type='hidden' name='task' value='send_email'>
                  <tr> 
                    <td height="108">&nbsp;</td>
                    <td valign="top"> 
                     Enter your email address to reset your password. <span class="tip">(System Generated)</span> <br> 
                      <br>
					 E-mail Address: &nbsp; <input type="text" name="email" class="text" style="width:40%" value="{$user_email}"> 
                      <br> <br> <input name="send" type="submit" value="Send Request"></td>
                  </tr>
                 
                </form>
				 {/if}
            </table>
		</td></tr>
		</table>
	</td></tr>
	</table>

	</body>
	</html>

