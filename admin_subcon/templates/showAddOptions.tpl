{if $mode eq 1}
	<table width="100%">
		<tbody>
			<tr><td><b>Create New</b></td><td></td><td></td></tr>
			<tr><td width="11%">First Name</td><td width="1%">:</td><td width="88%"><input type="text" size="40" class="text" id="fname" name="fname"></td></tr>
			<tr><td width="11%">Last Name</td><td width="1%">:</td><td width="88%"><input type="text" size="40" class="text" id="lname" name="lname"></td></tr>
			<tr><td width="11%">Email</td><td width="1%">:</td><td width="88%"><input type="text" size="40" class="text" id="email" name="email" onblur="checkEmail(this.value , 'new')"> <span class="gray">The email you type will be automatically checked</span></td>
			</tr>
			<tr><td width="11%">Skype</td><td width="1%">:</td><td width="88%"><input type="text" size="40" class="text" id="skype" name="skype"></td></tr>
			<tr><td width="11%">Contact No/s.</td><td width="1%">:</td><td width="88%"><input type="text" size="40" id="phone" class="text" name="phone"></td></tr>
			<tr><td><input type="button" value="Create" id="create_btn" onclick="createNewApplicant();" /></td><td colspan="2">You must create and add new applicant first before subcontracting </td></tr>
		</tbody>
	</table>
{/if}

{if $mode eq 2 }
	<p><b>All Registered Applicants</b></p>
	<div><select class="select_box"  name="userid" onchange="showApplicantDetails(this.value)">
	<option value="0">Please Select</option>
	{$usernameOptions}
	</select></div>	
{/if}	


{if $mode eq 3 }
	<p><b>All Marked Registered Applicants</b></p>
	<div><select class="select_box" name="userid" onchange="showApplicantDetails(this.value)">
	<option value="0">Please Select</option>
	{$usernameOptions}</select></div>	
{/if}	

{if $mode eq 4 }
	<p><b>List of Active Remotestaff Subcontractors</b></p>
	<div><select class="select_box" name="userid" onchange="showApplicantDetails(this.value)">
	<option value="0">Please Select</option>
	{$usernameOptions}</select></div>	
{/if}	

{if $mode eq 'keyword' }
<table cellpadding=1 cellspacing=0 border=0 width=100%>
<tr class="tb_hdr" >
<td width="3%" class="tb_td_hdr">#</td>
<td width="10%" class="tb_td_hdr">USERID</td>
<td width="28%" class="tb_td_hdr">FULLNAME</td>
<td width="39%" class="tb_td_hdr">EMAIL</td>
</tr>
{section name=j loop=$result}
    <tr bgcolor="{cycle values='#EEEEEE,#CCFFCC'}">
       <td>{$smarty.section.j.iteration} )</td>
	   <td><input type="radio" name="userid" value="{$result[j].userid}" onclick="showApplicantDetails({$result[j].userid})" /><span class="gray">{$result[j].userid}</span></td>
	   <td>{$result[j].fname} {$result[j].lname}</td>
	   <td>{$result[j].email}</td>
    </tr>
{sectionelse}
<tr><td colspan="4" align="center"><br><b>No Applicants to be shown </b> <br> </td></tr>
{/section}
    
</table> 
{/if}