<div id="cat-form" >
<table width='100%' cellpadding="0" >

<!-- skill and requirements -->
<tr>
<td valign='top' colspan="2">
	<table id="it" width='100%' cellpadding="0" cellspacing="5">
		<tr>
			<td width="25%" valign='top' >
			<div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">System</div>
					<div class="skill_rate">Rating </div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_system_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				    <input type="text" class="select" name="system_manual{$gs_job_titles_details_id}" id="system_manual{$gs_job_titles_details_id}" />
				    <select id='rating_system_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4'>4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
					
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'system_manual' , 'rating_system_manual' , 'system' , 'system_div' , 'add_system_div' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_system_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='system_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$system_array_options}</select>
				<select id='rating_system_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'system_select' , 'rating_system_select' , 'system' , 'system_div' , 'false' );" />
				
				
				<a class="add_more" href="javascript:toggle('add_system_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				<!--<input type="button" value="Add More" class="bttn" onclick="toggle('add_system_div{$gs_job_titles_details_id}')" />-->
				
				</div>
				<div id="system_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'system'}
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
				{/section}			</div></div></td>
			<td width="25%" valign='top' >
			<div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">Databases</div>
				<div class="skill_rate">Rating<!--<input type="button" value="add more" class="bttn" onclick="toggle('add_database_div{$gs_job_titles_details_id}')" />--></div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_database_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				<input type="text" class="select" name="database_manual{$gs_job_titles_details_id}" id="database_manual{$gs_job_titles_details_id}" />
				<select id='rating_database_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'database_manual' , 'rating_database_manual' , 'database' , 'database_div' , 'false' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_database_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='database_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$database_array_options}</select>
				<select id='rating_database_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'database_select' , 'rating_database_select' , 'database' , 'database_div' , 'false' );" />
				<a class="add_more" href="javascript:toggle('add_database_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				
				</div>
				<div id="database_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'database'}
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
				{/section}			</div></div>			</td>
		</tr>
		
		<tr>
			<td valign='top' >
			<div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">PC & Desktop Products</div>
					<div class="skill_rate">Rating </div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_pc_products_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				<input type="text" class="select" name="pc_products_manual{$gs_job_titles_details_id}" id="pc_products_manual{$gs_job_titles_details_id}" />
				<select id='rating_pc_products_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'pc_products_manual' , 'rating_pc_products_manual' , 'pc_products' , 'pc_products_div' , 'false' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_pc_products_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='pc_products_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$pc_products_array_options}</select>
				<select id='rating_pc_products_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'pc_products_select' , 'rating_pc_products_select' , 'pc_products' , 'pc_products_div' , 'false' );" />
				<a class="add_more" href="javascript:toggle('add_pc_products_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				
				</div>
				<div id="pc_products_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'pc_products'}
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
				{/section}			</div></div>			</td>
			<td valign='top' >
			<div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">Platforms/Environments</div>
					<div class="skill_rate">Rating </div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_platforms_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				<input type="text" class="select" name="platforms_manual{$gs_job_titles_details_id}" id="platforms_manual{$gs_job_titles_details_id}" />
				<select id='rating_platforms_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'platforms_manual' , 'rating_platforms_manual' , 'platforms' , 'platforms_div' , 'add_platforms_div' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_platforms_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='platforms_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$platforms_array_options}</select>
				<select id='rating_platforms_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'platforms_select' , 'rating_platforms_select' , 'platforms' , 'platforms_div' , 'false' );" />
				<a class="add_more" href="javascript:toggle('add_platforms_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				</div>
				<div id="platforms_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'platforms'}
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
				{/section}			</div></div>			</td>
		</tr>
		<tr><td valign="top">
		<div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">App Programming Languages</div>
		<div class="skill_rate">Rating </div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_app_programming_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				<input type="text" class="select" name="app_programming_manual{$gs_job_titles_details_id}" id="app_programming_manual{$gs_job_titles_details_id}" />
				<select id='rating_app_programming_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'app_programming_manual' , 'rating_app_programming_manual' , 'app_programming' , 'app_programming_div' , 'add_app_programming_div' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_app_programming_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='app_programming_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$app_programming_array_options}</select>
				<select id='rating_app_programming_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'app_programming_select' , 'rating_app_programming_select' , 'app_programming' , 'app_programming_div' , 'false' );" />
				<a class="add_more" href="javascript:toggle('add_app_programming_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				</div>
				<div id="app_programming_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'app_programming'}
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
				{/section}			</div></div>
		</td>
			<td valign="top"><div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">Multimedia</div>
					<div class="skill_rate">Rating </div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_multimedia_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				<input type="text" class="select" name="multimedia_manual{$gs_job_titles_details_id}" id="multimedia_manual{$gs_job_titles_details_id}" />
				<select id='rating_multimedia_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'multimedia_manual' , 'rating_multimedia_manual' , 'multimedia' , 'multimedia_div' , 'add_multimedia_div' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_multimedia_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='multimedia_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$multimedia_array_options}</select>
				<select id='rating_multimedia_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'multimedia_select' , 'rating_multimedia_select' , 'multimedia' , 'multimedia_div' , 'false' );" />
				<a class="add_more" href="javascript:toggle('add_multimedia_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				</div>
				<div id="multimedia_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'multimedia'}
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
				{/section}			</div></div></td>
			</tr>
			<tr>
			<td valign="top">
			<div class="big_req_box">
				<div class="bg_skill_hdr">
					<div class="skill_name">Open Source Software</div>
	<div class="skill_rate">Rating </div>
					<div style="clear:both;"></div>
				</div>
				<div id="add_open_source_div{$gs_job_titles_details_id}" class="add_skill_box_small">
				<input type="text" class="select" name="open_source_manual{$gs_job_titles_details_id}" id="open_source_manual{$gs_job_titles_details_id}" />
				<select id='rating_open_source_manual{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'open_source_manual' , 'rating_open_source_manual' , 'open_source' , 'open_source_div' , 'add_open_source_div' );" />
				<input type="button" value="cancel" class="bttn" onclick="toggle('add_open_source_div{$gs_job_titles_details_id}')" />
				</div>
				<div class="select_box_skills">
				<select  class="select_box" id='open_source_select{$gs_job_titles_details_id}' ><option value="">Select from List</option>{$open_source_array_options}</select>
				<select id='rating_open_source_select{$gs_job_titles_details_id}' class="select_box" style="width:40px;">
					<option value='0'>0</option>
					<option value='5'>5</option>
					<option value='4' >4</option>
					<option value='3'>3</option>
					<option value='2'>2</option>
					<option value='1'>1</option>
					</select>
				<input type="button" class="bttn" value="add" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'open_source_select' , 'rating_open_source_select' , 'open_source' , 'open_source_div' , 'false' );" />
				<a class="add_more" href="javascript:toggle('add_open_source_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
				</div>
				<div id="open_source_div{$gs_job_titles_details_id}" class="list_box">
				{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'open_source'}
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
				{/section}			</div></div>			</td>
			<td valign="top">&nbsp;</td>
			</tr>
	</table>
</td>
</tr>
<!-- -->

<tr>
<td valign='top' colspan="2">Duties and Responsibilities:</td>
</tr>
<tr>
<td colspan="2" valign='top' align="center">
<div id="readroot{$gs_job_titles_details_id}" style="display:none;margin-bottom:5px;"><img src="media/images/box.gif"> <textarea name="requirement{$gs_job_titles_details_id}" class="select" style="width:90%;" /></textarea></div>
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
<input type="button"  value="Add More" onclick="moreFields({$gs_job_titles_details_id})" class="button" />
</td>
</tr>


<tr>
<td colspan="2" valign='top'>Other desirable/preferred skills, personal attributes and knowledge <br /><small>(preferred but not required)</small> :  </td>
</tr>
<tr>
<td colspan="2" valign='top' align="center"><textarea id='others{$gs_job_titles_details_id}' class='select' style='width: 92%;' rows='3' name='others{$gs_job_titles_details_id}'/>{$other_skills}</textarea></td>
</tr>

<tr>
<td colspan="2" valign='top'>Comments / Special Instructions : </td></tr>
<tr>
<td colspan="2" valign='top' align="center"><textarea id='notes{$gs_job_titles_details_id}' class='select' style='width: 92%;' rows='3' name='notes{$gs_job_titles_details_id}'/>{$comments}</textarea></td>
</tr>
<tr>
<td valign="top" colspan="2">
<b>Additional Information</b>
<p>1. Is the staff going to be working with your inhouse IT team? <select style="font:10px tahoma;" id="onshore{$gs_job_titles_details_id}"><option value="">-</option>{$onshore_options}</select> </p>

{if $web_des_flag eq 'true'}

<p>2. Will you require your designer to do some graphic design as well ?  <select style="font:10px tahoma;" id="require_graphic{$gs_job_titles_details_id}"><option value="">-</option>{$onshore_options}</select> </p>
{/if}


</td>
</tr>

<tr>
<td colspan='2' align="center">
<input type='button' value='Save' class='jobutton' onClick='onclickUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id})'>     
<input type='button' value='Close' class='jobutton' onClick='onclickCloseUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id});'>    
</td>
</tr>


</table>
</div>