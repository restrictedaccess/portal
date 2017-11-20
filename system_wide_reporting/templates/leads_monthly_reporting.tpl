<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff</title>
<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel=stylesheet type=text/css href="../css/font.css">
</head>
<body style="margin-top:0; margin-left:0">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /><br />
<form name="form" method="post" enctype="multipart/form-data" action="{$script_filename}" accept-charset = "utf-8">
 
<fieldset style=" width:50%; margin:auto;">
    <legend>Leads Registration</legend>
    <select name="year" id="year">
                {foreach from=$YEARS name=Y item=Y}
                    <option value="{$Y}" {if $year eq $Y} selected="selected" {/if}>{$Y}</option>
                {/foreach}
            </select>
            <input type="submit" name="search" value="search" />
            <input type="button" onclick="location.href='leads_monthly_reporting_exporting.php?year={$year}'" value="export to csv" />
            <table width="100%" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
                {foreach from=$MONTLY_RESULTS name=monthly item=monthly}
                    <tr bgcolor="#FFFFFF">
                         <td width="50%">{$monthly.month_name}</td>
                         <td width="50%">{$monthly.month_num_count}</td>
                    </tr>
                {/foreach}
                 <tr bgcolor="#FFFFFF">
                     <td width="50%" align="right">Total</td>
                     <td width="50%">{$total_count}</td>
                 </tr>  
            </table>
</fieldset> 

</form>
</body>
</html>