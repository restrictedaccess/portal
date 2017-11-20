{include file="header.tpl"}
<div id="job-spec">
<div><strong>Technical and Non technical Requirements</strong></div>
<div class="skills-box">
	<div class="skills-box-hdr">
		<div class="{$class}">Requirements and Skills</div>
		<div class="skill_rating">Ratings</div>
		<div style="clear:both;"></div>
	</div>
	<div class="list_box">
		{section name=j loop=$result}
					{strip}
						{if $result[j].box eq 'requirement'}
							<div class="skill_list" >
								<div class="{$class}">{$result[j].description}</div>
								<div class="skill_rating">
									{$result[j].rating}
								</div>
								<div style="clear:both;"></div>
							</div>
						{/if}
					{/strip}
				{/section}
	</div>


</div>


{if $writer_type_flag eq 'true'}
<div class="skills-box">
	<div class="skills-box-hdr">Writer Type</div>
	<div style="padding:5px; line-height:30px;">{$writer_type_options}</div>
</div>	
{/if}

{if $call_type_flag eq 'true'}
<div>Type of Campaign ? <b><u>{$campaign_type_options}</u></b></div><br />
<div>Call Type : <b><u>{$call_type_options}</u></b></div>
{/if}

{if $marketing_asst_flag eq 'true'}
<div style="padding:5px; line-height:30px;"><b>Do you need your staff to be on the phone</b> ? {$staff_phone_options}</div>
{/if}



<div class="skills-box">
	<div class="skills-box-hdr">Duties and Responsibilities</div>
	<div style="padding:5px; line-height:25px;">
	{section name=j loop=$result}
		{strip}
			{if $result[j].box eq 'responsibility'}
				{if $result[j].description eq ''}
					{else}	
					<div class="skill-list">
							<img src='./media/images/applycheck.png'>
							<div class="skill-details">{$result[j].description|escape}</div>
							<div style="clear:both;"></div>
					</div>
				{/if}	
			{/if}
		{/strip}
	{/section}
	</div>
	
</div>		
	
	
<div class="skills-box">
	<div class="skills-box-hdr">Other desirable/preferred skills, personal attributes and knowledge</div>
	<div style="padding:5px; line-height:25px;">
	<div class="skill-list">
			<img src='./media/images/applycheck.png'>
			<div class="skill-details">{$other_skills}</div>
			<div style="clear:both;"></div>
	</div>

	</div>
</div>	
	

<div class="skills-box">
	<div class="skills-box-hdr">Comments / Special Instructions</div>
	<div style="padding:5px; line-height:25px;">
	<div class="skill-list">
			<img src='./media/images/applycheck.png'>
			<div class="skill-details">{$comments}</div>
			<div style="clear:both;"></div>
	</div>
	</div>
</div>	



{if $call_type_flag eq 'true'}
<div class="skills-box">
	<div class="skills-box-hdr">ADDITIONAL INFORMATION</div>
	<div style="padding:5px; line-height:30px; margin-left:20px;">
	<ol>
	<li>Is this an existing campaign ? <b><u>{$Q1_options}</u></b> <br />
Do you have someone onshore or offshore calling out for you? <b><u>{$Q2_options}</u></b>  </li>
	<li>Will you provide the lead or do you expect your telemarketer to do lead generation as well? <b><u>{$lead_generation}</u></b></li>
	<li>Is the telemarketer going to call your client data base?   <b><u>{$Q3_options}</u></b></li>
	<li>What is the goal at the end of each call ?  <b><u>{$Q4_options}</u></b></li>
	<li>How many contacts do you expect your telemarketer to make in 4 hours (part time) ? in 8 hours (full time) ?  <b><u>{$telemarketer_hrs}</u></b> </li>
	</ol>
	</div>

</div>
{/if}







</div>



{include file="footer.tpl"}
