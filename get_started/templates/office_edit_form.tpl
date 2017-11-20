<table width='100%' cellpadding="0" >
<!-- skill and requirements -->
<tr>
<td valign='top' colspan="2"><table width='100%' cellpadding="0" cellspacing="5">
  <tr>
    <td width="25%" valign='top' ><div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">General</div>
        <div class="skill_rate">Rating</div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_general_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="general_manual{$gs_job_titles_details_id}" id="general_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_general_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'general_manual' , 'rating_general_manual' , 'general' , 'general_div' , 'add_general_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_general_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select" class="select_box" id="general_select{$gs_job_titles_details_id}" >
          <option value="">Select from List</option>
          
          
          
          
				{$general_array_options}
				
        
        
        
        </select>
        <select name="select" class="select_box" id='rating_general_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'general_select' , 'rating_general_select' , 'general' , 'general_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_general_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>		 </div>
      <div id="general_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'general'}
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
        {/section} </div>
    </div></td>
    <td width="25%" valign='top' ><div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">Accounts/Clerk</div>
        <div class="skill_rate">Rating</div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_accounts_clerk_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="accounts_clerk_manual{$gs_job_titles_details_id}" id="accounts_clerk_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_accounts_clerk_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounts_clerk_manual' , 'rating_accounts_clerk_manual' , 'accounts_clerk' , 'accounts_clerk_div' , 'add_accounts_clerk_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_accounts_clerk_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select"  class="select_box" id='accounts_clerk_select{$gs_job_titles_details_id}' >
          <option value="">Select from List</option>
          
          
          
          {$accounts_clerk_array_options}
        
        
        
        </select>
        <select name="select" class="select_box" id='rating_accounts_clerk_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounts_clerk_select' , 'rating_accounts_clerk_select' , 'accounts_clerk' , 'accounts_clerk_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_accounts_clerk_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>      </div>
      <div id="accounts_clerk_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'accounts_clerk'}
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
        {/section} </div>
    </div></td>
  </tr>
  <tr>
    <td valign='top' ><div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">Accounts Payable</div>
        <div class="skill_rate">Rating </div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_accounts_payable_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="accounts_payable_manual{$gs_job_titles_details_id}" id="accounts_payable_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_accounts_payable_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
       <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounts_payable_manual' , 'rating_accounts_payable_manual' , 'accounts_payable' , 'accounts_payable_div' , 'add_accounts_payable_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_accounts_payable_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select"  class="select_box" id='accounts_payable_select{$gs_job_titles_details_id}' >
          <option value="">Select from List</option>
          
          
          {$accounts_payable_array_options}
        
        
        </select>
        <select name="select" class="select_box" id='rating_accounts_payable_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounts_payable_select' , 'rating_accounts_payable_select' , 'accounts_payable' , 'accounts_payable_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_accounts_payable_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>      </div>
      <div id="accounts_payable_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'accounts_payable'}
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
        {/section} </div>
    </div></td>
    <td valign='top' >
	<div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">Bookkeeper</div>
        <div class="skill_rate">Rating</div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_bookkeeper_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="bookkeeper_manual{$gs_job_titles_details_id}" id="bookkeeper_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_bookkeeper_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button2" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'bookkeeper_manual' , 'rating_bookkeeper_manual' , 'bookkeeper' , 'bookkeeper_div' , 'add_bookkeeper_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_bookkeeper_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select"  class="select_box" id='bookkeeper_select{$gs_job_titles_details_id}' >
          <option value="">Select from List</option>
          
          
          
          {$bookkeeper_array_options}
        
        
        
        </select>
        <select name="select" class="select_box" id='rating_bookkeeper_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'bookkeeper_select' , 'rating_bookkeeper_select' , 'bookkeeper' , 'bookkeeper_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_bookkeeper_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
		
      </div>
      <div id="bookkeeper_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'bookkeeper'}
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
        {/section} </div>
    </div>	</td>
  </tr>
  <tr>
    <td valign="top"><div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">Accounts Receivable</div>
        <div class="skill_rate">Rating</div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_accounts_receivable_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="accounts_receivable_manual{$gs_job_titles_details_id}" id="accounts_receivable_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_accounts_receivable_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
      
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounts_receivable_manual' , 'rating_accounts_receivable_manual' , 'accounts_receivable' , 'accounts_receivable_div' , 'add_accounts_receivable_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_accounts_receivable_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select"  class="select_box" id='accounts_receivable_select{$gs_job_titles_details_id}' >
          <option value="">Select from List</option>
          
          
          
          {$accounts_receivable_array_options}
        
        
        
        </select>
        <select name="select" class="select_box" id='rating_accounts_receivable_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounts_receivable_select' , 'rating_accounts_receivable_select' , 'accounts_receivable' , 'accounts_receivable_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_accounts_receivable_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
      </div>
      <div id="accounts_receivable_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'accounts_receivable'}
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
        {/section} </div>
    </div></td>
    <td valign="top"><div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">Accounting Package</div>
        <div class="skill_rate">Rating        </div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_accounting_package_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="accounting_package_manual{$gs_job_titles_details_id}" id="accounting_package_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_accounting_package_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounting_package_manual' , 'rating_accounting_package_manual' , 'accounting_package' , 'accounting_package_div' , 'add_accounting_package_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_accounting_package_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select"  class="select_box" id='accounting_package_select{$gs_job_titles_details_id}' >
          <option value="">Select from List</option>
          
          
          
          {$accounting_package_array_options}
        
        
        
        </select>
        <select name="select" class="select_box" id='rating_accounting_package_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'accounting_package_select' , 'rating_accounting_package_select' , 'accounting_package' , 'accounting_package_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_accounting_package_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
		
      </div>
      <div id="accounting_package_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'accounting_package'}
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
        {/section} </div>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div class="big_req_box">
      <div class="bg_skill_hdr">
        <div class="skill_name">Payroll</div>
        <div class="skill_rate">Rating        </div>
        <div style="clear:both;"></div>
      </div>
      <div id="add_payroll_div{$gs_job_titles_details_id}" class="add_skill_box_small">
        <input type="text" class="select" name="payroll_manual{$gs_job_titles_details_id}" id="payroll_manual{$gs_job_titles_details_id}" />
        <select name="select" class="select_box" id='rating_payroll_manual{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
       
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'payroll_manual' , 'rating_payroll_manual' , 'payroll' , 'payroll_div' , 'add_payroll_div' );" value="add" />
        <input name="button" type="button" class="bttn" onclick="toggle('add_payroll_div{$gs_job_titles_details_id}')" value="cancel" />
      </div>
      <div class="select_box_skills">
        <select name="select"  class="select_box" id='payroll_select{$gs_job_titles_details_id}' >
          <option value="">Select from List</option>
          
          
          
          {$payroll_array_options}
        
        
        
        </select>
        <select name="select" class="select_box" id='rating_payroll_select{$gs_job_titles_details_id}' style="width:40px;">
          <option value='0'>0</option>
          <option value='5'>5</option>
          <option value='4' >4</option>
          <option value='3'>3</option>
          <option value='2'>2</option>
          <option value='1'>1</option>
        </select>
        <input name="button" type="button" class="bttn" onclick="onClickSaveRequirements({$gs_job_titles_details_id} , {$gs_job_role_selection_id},'payroll_select' , 'rating_payroll_select' , 'payroll' , 'payroll_div' , 'false' );" value="add" />
		<a class="add_more" href="javascript:toggle('add_payroll_div{$gs_job_titles_details_id}')">Not on the List?Add it</a>
		
      </div>
      <div id="payroll_div{$gs_job_titles_details_id}" class="list_box"> {section name=j loop=$result}
        {strip}
        {if $result[j].box eq 'payroll'}
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
        {/section} </div>
    </div></td>
    <td valign="top">&nbsp;</td>
  </tr>
</table></td>
</tr>
<!-- -->
{if $staff_phone_flag eq 'true'}
<tr>
<td width="50%" valign='top' align="right" >Do you need your staff to be on the phone ? </td>
<td width="50%" valign="top"><select style="font:10px tahoma;" id="staff_phone{$gs_job_titles_details_id}"><option value="">-</option>{$staff_phone_options}</select></td></tr>


{/if}
<tr>
<td colspan="2" valign='top'><br />
<br />
 Duties and Responsibilities:</td></tr>
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
<input type="button"  class="button" value="Add More" onclick="moreFields({$gs_job_titles_details_id})" /></td>
</tr>

<tr>
<td colspan="2" valign='top'>Other desirable/preferred skills, personal attributes and knowledge <small>(preferred but not required)</small> :  </td></tr>
<tr>
<td colspan="2" valign='top' align="center"><textarea id='others{$gs_job_titles_details_id}' class='select' style='width: 92%;'  rows='3' name='others{$gs_job_titles_details_id}'/>{$other_skills}</textarea></td>
</tr>

<tr>
<td colspan="2" valign='top'>Comments / Special Instructions : </td></tr>
<tr>
<td colspan="2" valign='top' align="center"><textarea id='notes{$gs_job_titles_details_id}' class='select' style='width: 92%;'  rows='3' name='notes{$gs_job_titles_details_id}'/>{$comments}</textarea></td>
</tr>


<tr>
<td colspan='2' align="center">
<input type='button' value='Save' class='jobutton' onClick='onclickUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id})'>     
<input type='button' value='Close' class='jobutton' onClick='onclickCloseUpdateJobSpecOtherDetails({$gs_job_titles_details_id} , {$jr_list_id} , {$gs_job_role_selection_id}, {$jr_cat_id});'>    
</td>
</tr>
</table>
