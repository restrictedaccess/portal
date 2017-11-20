<div id="cat-form" >
<table width='900' cellpadding="0" cellspacing="5">
<tr>
<td colspan="2" valign="top" >Technical and Non technical Requirements :</td></tr>
<tr>
<td colspan="2" valign="top" class='diff_skills_box'>
			<div class="big_req_box">
				<div class="bg_skill_hdr">
				<div class="skill_desc">Please list as many requirements you need below and rate the level of skill needed per requirment from 1 to 5.</div>
				<div class="skill_rating">Rating </div>
				<div style="clear:both;"></div>
				</div>
				<div id="add_requirements_others_div{$gs_job_titles_details_id}" class="add_skill_box">
				<textarea id='add_requirements_others{$gs_job_titles_details_id}' class='select' style='width: 670px;' rows='3' name='add_requirements_others{$gs_job_titles_details_id}'/></textarea><br />

				<select id='rating_others{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>-</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'add_requirements_others' , 'rating_others' , 'requirement_others' , 'requirements_others_div' , 'false'  );" />
				
				</div>
				<div id="requirements_others_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'requirement_others'}
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
			
			<!--
			<div class="big_req_box">
				<div class="bg_skill_hdr">
				<div class="bg_skill_name">Time Schedule</div>
				<div class="skill_rating"> <input type="button" value="add" class="bttn" onclick="toggle('add_time_sched_div{$gs_job_titles_details_id}')" /></div>
				<div style="clear:both;"></div>
				</div>
				<div id="add_time_sched_div{$gs_job_titles_details_id}" class="add_skill_box">
				<textarea id='add_time_sched{$gs_job_titles_details_id}' class='select' style='width: 930px;' rows='3' name='add_requirements_{$gs_job_titles_details_id}'/></textarea><br />

				<input type="button" class="bttn" value="save" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'add_time_sched' , '' , 'time_sched' , 'time_sched_div' , 'add_time_sched_div' );" />
				<input type="button" class="bttn" value="can" onclick="toggle('add_time_sched_div{$gs_job_titles_details_id}')" />
				</div>
				<div id="time_sched_div{$gs_job_titles_details_id}" class="list_box">
				{section name=k loop=$result}
					{strip}
						{if $result[k].box eq 'time_sched'}
							<div class="skill_list" >
								<div class="skill_desc">{$result[k].description}</div>
								<div class="skill_rating">{$result[k].rating}</div>
								<div style="clear:both;"></div>
							</div>
						{/if}
					{/strip}
				{/section}
				
				</div>
			</div>
			-->
			</td>
</tr>



<tr>
<td colspan="2" valign='top'>Duties and Responsibilities:</td></tr>
<tr>
<td colspan="2" valign='top' align="center">
<div id="readroot{$gs_job_titles_details_id}" style="display:none;margin-bottom:5px;"><img src="media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" /></textarea></div>
{if $count_responsibilty eq '0'} 
	<div style="display:block;margin-bottom:5px;"><img src="http://localhost/new_home_pages/get_started/media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" /></textarea></div>
{else}	
	{section name=j loop=$result}
		{strip}
			{if $result[j].box eq 'responsibility'}
				{if $result[j].description eq ''}
					{else}	
					<div style="display:block;margin-bottom:5px;"><img src="http://localhost/new_home_pages/get_started/media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" />{$result[j].description}</textarea></div>
				{/if}	
			{/if}
		{/strip}
	{/section}
{/if}
<span id="writeroot{$gs_job_titles_details_id}"></span>
<input type="button"  class="button" value="Add More" onclick="moreFields({$gs_job_titles_details_id})" />
</td>
</tr>
<tr>
<td colspan="2" valign='top'>Other desirable/preferred skills, personal attributes and knowledge <small>(preferred but not required)</small> :  </td></tr>
<tr>
<td colspan="2" valign='top' align="center"><textarea id='others{$gs_job_titles_details_id}' class='select' style='width: 92%;' rows='3' name='others{$gs_job_titles_details_id}'/>{$other_skills}</textarea></td>
</tr>

<tr>
<td colspan="2" valign='top'>Comments / Special Instructions : </td></tr>
<tr>
<td colspan="2" valign='top' align="center"><textarea id='notes{$gs_job_titles_details_id}' class='select' style='width: 92%;' rows='3' name='notes{$gs_job_titles_details_id}'/>{$comments}</textarea></td>
</tr>


<tr>
<td colspan='2' align="center">
<input type='button' value='Save' class='jobutton' onClick='onclickUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id})'>     
<input type='button' value='Close' class='jobutton' onClick='onclickCloseUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id});'>
</td>
</tr>


</table>
</div>