<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link href='css/admincontactdetails.css' rel="stylesheet" type="text/css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

{php} include("header.php"){/php}
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  {$name}</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   {php} include("subconleftnav.php"){/php}</td>
<td width="1081" valign="top" >
  <h3 align="center">CONTACT US	</h3>

<div style="width:99%; margin:auto;">
<fieldset>
    <legend style="font-weight:bold; font-size:16px;">CUSTOMER SUPPORT DEPARTMENT</legend>
    <table width="100%" cellpadding="5" cellspacing="1" bgcolor="#666666">
        <tr bgcolor="#333333">
            <td width="18%" style="color:#FFF; font-weight:bold;">NAME</td>
            <td width="19%" align="center" style="color:#FFF; font-weight:bold;">CONTACT NO.</td>
            <td width="23%" align="center" style="color:#FFF; font-weight:bold;">EMAIL ADDRESS</td>
            <td width="17%" align="center"  style="color:#FFF; font-weight:bold;">SKYPE ID</td>
            <td width="23%" align="center" style="color:#FFF; font-weight:bold;">SCHEDULE</td>
        </tr>
        
        
       {foreach from=$csros name=csro item=csro}
        <tr bgcolor="#FFF">
            <td>
            {$csro.admin_fname}
            {if $csro.admin_id|in_array:$client_csros}
            	<div><img src="./images/arrow.gif" ><small>(<strong>Your Client-Staff Relations Officer</strong>)</small></div>
            {/if}
            </td>
            <td align="center">{$csro.local_number}</td>
            <td align="center">{$csro.admin_email}</td>
            <td align="center">{$csro.skype_id}</td>
            <td align="center">{$csro.work_schedule}</td>
        </tr>
        {/foreach}
        
    </table>    
</fieldset>

</div>	
<br>
<br>
	

</td>
</tr>
</table>
{php} include("footer.php"){/php}
</body>
</html>