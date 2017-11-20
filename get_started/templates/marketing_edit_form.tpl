<table width='100%' cellpadding="0" cellspacing="5">
<tr>
<td colspan="2" valign="top" >Technical and Non technical Requirements :</td></tr>
<tr>
<td colspan="2" valign="top" class='diff_skills_box'>
			<div class="big_req_box">
				<div class="bg_skill_hdr" style=" line-height:25px;">
				<div class="skill_desc">Please list as many requirements you need below and rate the level of skill needed per requirment from 1 to 5.</div>
				<div class="skill_rating">Rating </div>
				<div style="clear:both;"></div>
				</div>
				
		{if $graphic_des_flag eq 'true'}
		<div id="add_requirements_div{$gs_job_titles_details_id}" class="add_skill_box" style="height:30px; line-height:30px; display:none; position:absolute; ">
				<input type="text" id="add_requirements{$gs_job_titles_details_id}" class="select" style="width:60%"  />
				Rating <select id='rating{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='1'>1</option>
					<option value='2'>2</option>
					<option value='3'>3</option>
					<option value='4'>4</option>
					<option value='5'>5</option>
					</select>
				
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'add_requirements' , 'rating' , 'requirement' , 'requirements_div' , 'false'  );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_requirements_div{$gs_job_titles_details_id}')" />

		</div>
		{else}
		<div id="add_requirements_div{$gs_job_titles_details_id}" class="add_skill_box" style="height:30px; line-height:30px; ">
				<input type="text" id="add_requirements{$gs_job_titles_details_id}" class="select" style="width:60%"  />
				Rating <select id='rating{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='1'>1</option>
					<option value='2'>2</option>
					<option value='3'>3</option>
					<option value='4'>4</option>
					<option value='5'>5</option>
					</select>
				
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'add_requirements' , 'rating' , 'requirement' , 'requirements_div' , 'false'  );" />
			

		</div>
		{/if}		
				{if $graphic_des_flag eq 'true'}
				<div class="select_box_skills">
				<select  class="select_box" id='requirement_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$graphic_des_options}</select>
				Rating 
				<select id='rating_requirement_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'requirement_select' , 'rating_requirement_select' , 'requirement' , 'requirements_div' , 'false' );" />
				
				<a class="add_more" href="javascript:toggle('add_requirements_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				
				</div>
				{/if}
				
				<div id="requirements_div{$gs_job_titles_details_id}" class="list_box">
				
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'requirement'}
							<div class="skill_list" >
								<div class="{$class}">{$result[j].description}</div>
								<div class="skill_rating">
									{$result[j].rating}
								</div>
								<div class="del"><a href="javascript:deleteCredentials({$result[j].gs_job_titles_credentials_id} ,{$gs_job_titles_details_id}, '{$result[j].box}', '{$result[j].div}')" title="delete">x</a></div>
								<div style="clear:both;"></div>
							</div>
						{/if}
					{/strip}
				{/section}
				
				</div>
			</div>

			
			</td>
</tr>



{if $writer_type_flag eq 'true'}
<tr>
<td width="45%" align="right" valign='top'>Writer Type : </td>
<td width="55%" valign='top'>{$writer_type_options}</td>
</tr>
{/if}

{if $call_type_flag eq 'true'}
<tr>
<td valign='top' align="right">Type of Campaign : </td>
<td valign='top'><select class='select' id='campaign_type{$gs_job_titles_details_id}'><option value="">Please Select</option>{$campaign_type_options}</select></td>
</tr>
<tr>
<td valign='top' align="right">Call Type : </td>
<td valign='top'><select class='select' id='call_type{$gs_job_titles_details_id}'><option value="">Please Select</option>{$call_type_options}</select></td>
</tr>
{/if}

{if $marketing_asst_flag eq 'true'}
<tr>
<td valign='top' align="right" >Do you need your staff to be on the phone ?</td>
<td valign="top"><select style="font:10px tahoma;" id="staff_phone{$gs_job_titles_details_id}"><option value="">-</option>{$staff_phone_options}</select> </td>
</tr>

{/if}


<tr>
<td colspan="2" valign='top'>Duties and Responsibilities:</td></tr>
<tr>
<td align="center" colspan="2" valign='top'>
<div id="readroot{$gs_job_titles_details_id}" style="display:none;margin-bottom:5px;"><img src="media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" /></textarea>    </div>
{if $count_responsibilty eq '0'} 
	<div style="display:block;margin-bottom:5px;"><img src="media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" /></textarea></div>
{else}	
	{section name=j loop=$result}
		{strip}
			{if $result[j].box eq 'responsibility'}
				{if $result[j].description eq ''}
					{else}	
					<div style="display:block;margin-bottom:5px;"><img src="media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" />{$result[j].description}</textarea></div>
				{/if}	
			{/if}
		{/strip}
	{/section}
{/if}
<span id="writeroot{$gs_job_titles_details_id}"></span>
<input type="button"  value="Add More" class="button" onclick="moreFields({$gs_job_titles_details_id})" />
</td>
</tr>

<tr>
<td colspan="2" valign='top'>Other desirable/preferred skills, personal attributes and knowledge <small>(preferred but not required)</small> : </td></tr>
<tr>
<td align="center" colspan="2" valign='top'><textarea id='others{$gs_job_titles_details_id}' class='select'  style='width: 92%;' rows='3' name='others{$gs_job_titles_details_id}'/>{$other_skills}</textarea></td>
</tr>

<tr>
<td colspan="2" valign='top'>Comments / Special Instructions : </td></tr>
<tr>
<td align="center" colspan="2" valign='top'><textarea id='notes{$gs_job_titles_details_id}' class='select'  style='width: 92%;' rows='3' name='notes{$gs_job_titles_details_id}'/>{$comments}</textarea></td>
</tr>


{if $call_type_flag eq 'true'}
<tr>
<td colspan='2'>
ADDITIONAL INFORMATION NEEDED : 
<div style="margin-left:50px;">
<ol>
<li>Is this an existing campaign ? <select style="font:10px tahoma;" id="q1{$gs_job_titles_details_id}"><option value="">-</option>{$Q1_options}</select> Do you have someone onshore or offshore calling out for you? <select style="font:10px tahoma;" id="q2{$gs_job_titles_details_id}"><option value="">-</option>{$Q2_options}</select> </li>
<li>Will you provide the lead or do you expect your telemarketer to do lead generation as well? <input type="text" class="select" id="lead_generation{$gs_job_titles_details_id}" value="{$lead_generation}" /></li>
<li>Is the telemarketer going to call your client data base?  <select style="font:10px tahoma;" id="q3{$gs_job_titles_details_id}"><option value="">-</option>{$Q3_options}</select></li>
<li>What is the goal at the end of each call ? <select style="font:10px tahoma;" id="q4{$gs_job_titles_details_id}"><option value="">-</option>{$Q4_options}</select></li>
<li>How many contacts do you expect your telemarketer to make in 4 hours (part time) ? in 8 hours (full time) ? <input type="text" class="select" id="telemarketer_hrs{$gs_job_titles_details_id}" value="{$telemarketer_hrs}" /> </li>
</ol>
</div>
</td>
</tr>
{/if}

<tr>
<td colspan='2' align="center">
<input type='button' value='Save' class='jobutton' onClick='onclickUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id})'>     
<input type='button' value='Close' class='jobutton' onClick='onclickCloseUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id});'>    
</td>
</tr>
</table>