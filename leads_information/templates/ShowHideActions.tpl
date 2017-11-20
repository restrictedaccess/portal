<hr />
<table width="100%">
{if $actions eq 'EMAIL'}
	<tr>
		<td><b>Return Email To :</b></td>
		<td valign="top">
        {if $bd}
        	<input type="radio" name="email_sender"  value="{$current_user}" checked="checked" /> Me
        {/if}
        
        { if $hm}
            <input type="radio" name="email_sender" value="{$hm.admin_id}" /> Hiring Manager {$hm.admin_fname} {$hm.admin_lname}
        {/if}

        { if $csro}
            <input type="radio" name="email_sender" value="{$csro.admin_id}" /> Csro {$csro.admin_fname} {$csro.admin_lname}
        {/if}

        
        </td>	
	</tr>
	<tr>
		<td><b>Template:</b></td>
		<td valign="top">
			<select name="template" id="template_selector">
				<option value="blank">Blank</option>
				
				<option value="dst_start">Australia Daylight Saving Time</option>
				<option value="dst_end">Australia End of Daylight Saving Time</option>
				<option value="anzac">Anzac Day Staff Attendance</option>
				<option value="queens">Queen's Birthday Staff Attendance</option>
				<option value="au_labour_day">Australia Labour Day Staff Attendance</option>
				<option value="au_melbourne_cup_day">Australia Melbourne Cup Day Staff Attendance</option>
				<option value="au_australia_day">Australia Day Staff Attendance</option>
				<option value="christmas_day_2014">AU Remote Staff Service Agreement Update 2014</option>
				<option value="au_christmas_day">Australia Happy Holidays</option>
				<option value="au_holy_week_2016">Australia Holy Week Staff Attendance</option>
				
				<option value="us_labor_day">US Labor Day Staff Attendance</option>
				<option value="columbus_day">US Columbus Day Staff Attendance</option>
				<option value="us_veterans_day">US Veterans Day Staff Attendance</option>
				<option value="us_thanks_giving">US Thanks Giving Staff Attendance</option>
				<option value="us_christmas_day">US Christmas Day Staff Attendance</option>
				<option value="us_new_year">US New Year's Eve</option>
				<option value="us_veterans_day_2014">US Veterans Day 2014</option>
				
				<option value="uk_christmas_day">UK Christmas Day</option>
				<option value="uk_new_year">UK New Year's Eve</option>
				<option value="ukus_christmas_day_2014">UK/US Remote Staff Service Agreement Update 2014</option>
	
				
				
				

				
				
			</select>
		</td>
	</tr>
	<tr>
		<td><b>Name :</b></td>
		<td valign="top">{$name}</td>
		
	</tr>
	
	<tr>
		<td width="10%"><b>Email To :</b></td>
		<td width="90%" valign="top"><input type="text" name="email" id="email" value="{$email}" size="40" /></td>
	</tr>
	
	<tr>
		<td ><b>Subject :</b></td>
		<td valign="top"><input type="text" name="subject" id="subject" size="40" value="{$subject}" /></td>
	</tr>
	<tr>
		<td colspan="2" valign="top">Insert email address separated by commas ","</td>
	</tr>

	<tr>
		<td ><b>CC :</b></td>
		<td valign="top">
        	<table width="100%">
            	<tr>
                	<td width="20%"><input type="text" name="cc" id="cc" size="40" /></td>
                    <td width="80%" valign="top">
                    { if $hm}
                        <input type="checkbox" name="cc_hm" value="{$hm.admin_email}" /> Hiring Manager {$hm.admin_fname} {$hm.admin_lname}
                    {/if}
                    <br />
                    { if $csro}
                        <input type="checkbox" name="cc_csro" value="{$csro.admin_email}" /> Csro {$csro.admin_fname} {$csro.admin_lname}
                    {/if}
                    <br />
                    <input type="checkbox" name="cc_accounts" value="accounts@remotstaff.com.au" /> Accounts accounts@remotstaff.com.au
                    {if $bd}
                    <br />
                    <input type="checkbox" name="cc_bd" value="{$bd.email}" /> Business Developer {$bd.fname} {$bd.lname}
                    {/if}
                    </td>
                </tr>
            </table>
        
        
        </td>
	</tr>
	
	<tr>
		<td ><b>BCC :</b></td>
		<td valign="top">
            <table width="100%">
                <tr>
                    <td width="20%"><input type="text" name="bcc" id="bcc" size="40" /></td>
                    <td width="80%" valign="top">
                    	{ if $hm}
                            <input type="checkbox" name="bcc_hm" value="{$hm.admin_email}" /> Hiring Manager {$hm.admin_fname} {$hm.admin_lname}
                        {/if}
                        <br />
                        { if $csro}
                            <input type="checkbox" name="bcc_csro" value="{$csro.admin_email}" /> Csro {$csro.admin_fname} {$csro.admin_lname}
                        {/if}
                        <br />
                        <br />
                        <input type="checkbox" name="bcc_accounts" value="accounts@remotstaff.com.au" /> Accounts accounts@remotstaff.com.au
                        {if $bd}
                        <br />
                        <input type="checkbox" name="bcc_bd" value="{$bd.email}" /> Business Developer {$bd.fname} {$bd.lname}
                        {/if}
                    </td>
                </tr>
            </table>
        </td>
	</tr>
	
	<tr>
		<td ><b>Message :</b></td>
		<td valign="top">
		
  <textarea name="message" id="message" cols="70" rows="7" ></textarea>

		
		</td>
	</tr>
	
	<tr>
		<td ><b>Attach File 1:</b></td>
		<td valign="top"><input type="file" name="image" id="image" /></td>
	</tr>

	<tr>
		<td ><b>Attach File 2:</b></td>
		<td valign="top"><input type="file" name="image2" id="image2" /></td>
	</tr>

	<tr>
		<td ><b>Attach File 3:</b></td>
		<td valign="top"><input type="file" name="image3" id="image3" /></td>
	</tr>


	<tr>
		<td ><b>Attach File 4:</b></td>
		<td valign="top"><input type="file" name="image4" id="image4" /></td>
	</tr>

	<tr>
		<td ><b>Attach File 5:</b></td>
		<td valign="top"><input type="file" name="image5" id="image5" /></td>
	</tr>
	
	<tr>
		<td >&nbsp;</td>
		<td valign="top"><input type="radio" name="templates" value="signature"  /> Signature <input type="radio" name="templates" value="plain" checked="checked"  /> Plain  </td>
	</tr>
	
	<tr>
		<td >&nbsp;</td>
		<td valign="top"><input type="hidden" name="send_save" id="send_save" /><input type="button" class="lsb" name="send" value="Send & Save" onclick="return checkEmailMessage()" /></td>
	</tr>
{elseif $actions eq 'CSR'}	
	
<tr>
		<td ><b> What was the call about ?</b><input type="hidden" name="question[0]"  value="What was the call about ?" /></td>
		<td valign="top" align="left"><textarea name="answer[0]"   style="width:430px; height:50px;" ></textarea></td>
	</tr>

<tr>
		<td ><b> What did you do to resolve the issue ?</b><input type="hidden" name="question[1]"  value="What did you do to resolve the issue ?" /></td>
		<td valign="top" align="left"><textarea name="answer[1]"   style="width:430px; height:50px;" ></textarea></td>
	</tr>
	
	<tr>
		<td ><b> Where is everything at right now ?</b><input type="hidden" name="question[2]"  value="Where is everything at right now ?" /></td>
		<td valign="top" align="left"><textarea name="answer[2]"   style="width:430px; height:50px;" ></textarea></td>
	</tr>
	
<tr>
		<td >&nbsp;</td>
		<td valign="top"><input type="submit" class="lsb" name="save_csr" value="Save"  /></td>
	</tr>		
{elseif $actions eq 'Feedback'}
	
<tr>
		<td ><input type="radio" name="genfback" value="link" style="vertical-align:sub"/> <b>Generate Feedback Form Link</b>
		<div id="linkdiv" style="padding:8px 20px"><a href="/portal/client_feedback/?/ticket_ids/linkdiv" id="attach1">attach ticket id</a> <span id='linkdivtid'></span></div>
		<!--<div id='linkattachticket' class='attach_ticket'>Please wait...</div>-->
		</td>
		<td valign="top" align="left"></td>
	</tr>

<tr>
		<td ><input type="radio" name="genfback"  value="email" style="vertical-align:sub"/> <b>Attach to an Email</b>
		<div id="emaildiv" style="padding:8px 20px"><a href="/portal/client_feedback/?/ticket_ids/emaildiv" id="attach2">attach ticket id</a> <span id='emaildivtid'></span></div>
		<!--<div id='emailattachticket' class='attach_ticket'>Please wait...</div>-->
		</td>
		<td valign="top" align="left"></td>
	</tr>
	

	
<tr>
		<td >&nbsp;</td>
		<td valign="top"><button id="confirmfeedback" class="lsb">Continue</button></td>
	</tr>
	
{else}
<tr>
		<td ><b>Message :</b></td>
		<td valign="top"><textarea name="message" id="message" cols="70" rows="7" ></textarea></td>
	</tr>
<tr>
		<td >&nbsp;</td>
		<td valign="top"><input type="submit" class="lsb" name="save" value="Save" onclick="return checkMessage()" /></td>
	</tr>
{/if}
</table>