<table align="center" width='650' border='1' cellpadding='0' cellspacing='0' bordercolor="#a8a8a8" bgcolor="#646464" style="margin-top:20px;" >
<tr>
<td ><table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor="666666">
  <tr><td valign='top' align='center'><br>
  <table width="620" height="100" border="0" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" bgcolor="#FFFFFF">
 
  <tr>
    <td style="padding:5px;"><table width="625" border="0" align="center" cellpadding="0" cellspacing="0">
      
        <tr><td ><img src="http://remotestaff.com.ph/images/remote-staff-logo.jpg" alt="www.remotestaff.com.ph" width="590" height="75" ></td>
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
<td align="left" width="61%" valign="top">
{if $applicant_used eq False}
<div>{$lead.fname} {$lead.lname}</div>
<div>Status : {$ad.status}</div>
<div>Show : {$ad.show_status}</div>
{else}
&nbsp;
{/if}
</td>
<td width="39%" align="right" valign="top">Date Created : <b>{$date_created}</b></td>
</tr>
</table>

{if $category_results.cat_name }
<div style="color:#999999; font-size:16px; font-weight:bold;">{$category_results.cat_name} <img src="../images/arrow_next.gif" align="absmiddle" /> {$category_results.category_name}</div>
{/if}
<h2 align="center" style="color:#990000; margin-bottom:1px; padding-bottom:0px;">{$ad.jobposition|escape}</h2>
<div align="center">({$ad.outsourcing_model} {$ad.jobvacancy_no} staff needed) </div>

<div id="heading">{$ad.heading}</div>

{if $requirements_count neq 0}
<div class="res-req">
<div><strong>Skill(s) / Requirements</strong></div>
<ul>
{section name=j loop=$requirements}
<li>{$requirements[j].requirement}</li>
{/section}
</ul>
</div>
{/if}


{if $responsibility_count neq 0}
<div class="res-req">
<div><strong>Responsibilities</strong></div>
<ul>
{section name=j loop=$responsibilities}
<li>{$responsibilities[j].responsibility}</li>
{/section}
</ul>
</div>
{/if}

<div><input class="lsb" type="button" value="Edit" onClick="javascript:location.href='./?id={$ad.id}&mode=edit';"> <input class="lsb" type="button" value="Close" onClick="javascript:window.location.href='/portal/custom_get_started/job_spec.php?gs_job_titles_details={$gs_job_titles_details_id}"></div>
</td>
</tr>


 
<tr bgcolor="#666666"><td>&nbsp;</td></tr>
 
</table>
        </td>
</tr></table></td>
</tr>

</table>

