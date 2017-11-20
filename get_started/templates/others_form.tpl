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
						{if $result[j].box eq 'requirement_others'}
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
















</div>
{include file="footer.tpl"}