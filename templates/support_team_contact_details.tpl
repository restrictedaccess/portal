{*
2013-05-15  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>
<link href='css/admincontactdetails.css' rel="stylesheet" type="text/css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
{php} include("header.php"){/php}
{php} include("client_top_menu.php"){/php}


<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td colspan="2"><img src='images/space.gif' width=1 height=10></td>
</tr>
<tr>
<td width="14%" height="176" bgcolor="#ffffff"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<img src='images/space.gif' width=1 height=10>
<br clear=all>
{php} include("clientleftnav.php"){/php}
<br>
</td>
<td width="100%" valign="top">
<h3 align="center">CONTACT US</h3>
<div style="width:99%; margin:auto;">
<fieldset>
    <legend style="font-weight:bold; font-size:16px;">CUSTOMER SUPPORT DEPARTMENT</legend><br>
	<!--<legend style="font-size:14px;">Dial 02 8090 3458 and use extension of the CSRO you wish to speak with</legend>-->	
	<br>
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
            {if $csro.admin_id eq $csro_id}
            	<div><img src="./images/arrow.gif" ><small>(<strong>Your Client-Staff Relations Officer</strong>)</small></div>
            {/if}
            </td>
            <td align="center">{$csro.extension_number}</td>
            <td align="center">{$csro.admin_email}</td>
            <td align="center">{$csro.skype_id}</td>
            <td align="center">{$csro.work_schedule}</td>
        </tr>
        {/foreach}
    </table>    
</fieldset>
{if $hiring_coordinator}
<br>
<fieldset>
    <legend style="font-weight:bold; font-size:16px;">HIRING COORDINATOR</legend><br>
	<br>
    <table width="100%" cellpadding="5" cellspacing="1" bgcolor="#666666">
        <tr bgcolor="#333333">
            <td width="18%" style="color:#FFF; font-weight:bold;">NAME</td>
            <td width="19%" align="center" style="color:#FFF; font-weight:bold;">CONTACT NO.</td>
            <td width="23%" align="center" style="color:#FFF; font-weight:bold;">EMAIL ADDRESS</td>
            <td width="17%" align="center"  style="color:#FFF; font-weight:bold;">SKYPE ID</td>
            <td width="23%" align="center" style="color:#FFF; font-weight:bold;">SCHEDULE</td>
        </tr>
        
        <tr bgcolor="#FFF">
            <td>{$hiring_coordinator.admin_fname}</td>
            <td align="center">{$hiring_coordinator.extension_number}</td>
            <td align="center">{$hiring_coordinator.admin_email}</td>
            <td align="center">{$hiring_coordinator.skype_id}</td>
            <td align="center">{$hiring_coordinator.work_schedule}</td>
        </tr>
    </table>    
</fieldset>
{/if}
<br>
<fieldset>
    <legend style="font-weight:bold; font-size:16px;">ACCOUNTS DEPARTMENT</legend>
    <table width="100%" cellpadding="5" cellspacing="1" bgcolor="#666666">
        <tr bgcolor="#333333">
            <td width="18%" style="color:#FFF; font-weight:bold;">NAME</td>
            <td width="19%" align="center" style="color:#FFF; font-weight:bold;">CONTACT NO.</td>
            <td width="23%" align="center" style="color:#FFF; font-weight:bold;">EMAIL ADDRESS</td>
            <td width="17%" align="center"  style="color:#FFF; font-weight:bold;">SKYPE ID</td>
            <td width="23%" align="center" style="color:#FFF; font-weight:bold;">SCHEDULE</td>
        </tr>
        
        
        <tr bgcolor="#FFF">
            <td>Sandra</td>
            <td align="center">1300 733 430</td>
            <td align="center">sandra@remotestaff.com.au</td>
            <td align="center">remotestaff.sandra</td>
            <td align="center">10:00am - 7:00pm Sydney AUS timezone</td>
        </tr>
        
        <tr bgcolor="#FFF">
            <td>Irizlle</td>
            <td align="center">1300 733 430</td>
            <td align="center">irizlle@remotestaff.com.au</td>
            <td align="center">rs.irizlle</td>
            <td align="center">9:00am - 6:00pm Sydney AUS timezone</td>
        </tr>
                      
    </table>    
</fieldset>


</div>


</td>
</table>
{php} include("footer.php"){/php}
</body>
</html>
