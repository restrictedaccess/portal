<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$ad.jobposition}</title>
<link rel=stylesheet type=text/css href="./category-management/media/css/Ad.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
</head>

<body bgcolor='#FFFFFF' background="images/sample4abg.jpg" style="font-size:14px; font-family:Arial, Helvetica, sans-serif;">
<table align="center" width='650' border='1' cellpadding='0' cellspacing='0' bordercolor="#a8a8a8" bgcolor="#646464" >
<tr>
<td ><table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor="666666">
  <tr><td valign='top' align='center'><br>
  <table width="620" height="100" border="0" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" bgcolor="#FFFFFF">
 
  <tr>
    <td style="padding:5px;"><table width="625" border="0" align="center" cellpadding="0" cellspacing="0">
      
        <tr><td ><img src="images/remote-staff-logo2.jpg" alt="think" width="590" height="75" ></td>
      </tr>
    </table></td>
  </tr>
 
<tr bgcolor="#666666"><td>&nbsp;</td></tr>

<tr>
<td align="left" style="padding:20px;">
{if $apply_msg}
<div style="background:#FFFF00; padding:5px; font-weight:bold; text-align:center;">{$apply_msg}</div>
{/if}
<table width="100%">
<tr>
<td align="left" width="50%" valign="top">
{if $applicant_used eq False}
<div>{$lead.fname} {$lead.lname}</div>
<div>Status : {$ad.status}</div>
<div>Show : {$ad.show_status}</div>
{else}
&nbsp;
{/if}
</td>
<td width="50%" align="right" valign="top">Date Created : <b>{$date_created}</b></td>
</tr>
</table>

{if $category_results.cat_name }
<div style="color:#999999; font-size:16px; font-weight:bold;">{$category_results.cat_name} <img src="./images/arrow_next.gif" align="absmiddle" /> {$category_results.category_name}</div>
{/if}
<h2 align="center" style="color:#990000; margin-bottom:1px; padding-bottom:0px;">{$ad.jobposition|escape}</h2>
<div align="center">({$ad.outsourcing_model} {$ad.jobvacancy_no} staff needed) </div>

<div id="heading">{$heading}</div>

{if $requirements_count neq 0}
<div class="res-req">
<div><strong>Skill(s) / Requirements</strong></div>
<ul>
{$requirement_str}
<!--
{section name=j loop=$requirements}
<li>{$requirements[j].requirement}</li>
{/section}
-->
</ul>
</div>
{/if}


{if $responsibility_count neq 0}
<div class="res-req">
<div><strong>Responsibilities</strong></div>
<ul>
{$responsibility_str}
<!--
{section name=j loop=$responsibilities}
<li>{$responsibilities[j].responsibility}</li>
{/section}
-->
</ul>
</div>
{/if}


{if $applicant_used eq True}
<div align="center">
<form method="post" name="form" action='Ad.php?id={$id}' onSubmit="return checkFields();">
<input type='submit' name="apply" value='Apply to this position'>
</form>
</div>
{else}
{if $history_changes  neq ''}
	<div align="right"><a href="javascript:toggle('history_box');" style=" text-decoration:none; color:#999999; font:9px tahoma;">[ CHANGES ]</a></div>
	<div id="history_box" style="font-size:12px; border:#333333 solid 1px; font-size:10px; background:#FFFF00;">
	<div style="padding:3px; background:#333333; color:#FFFFFF; font-weight:bold; font-size:11px;">ADVERTISEMENT CHANGES</div>
	  {$history_changes}
	</div>
{/if}
{/if}
</td>
</tr>
 
<tr bgcolor="#666666"><td>&nbsp;</td></tr>
 
</table>
        </td>
</tr></table></td>
</tr>

</table>
</body>
</html>
