{include file="header.tpl"}
<div id="job-spec">
<div><strong>Technical and Non technical Requirements</strong></div>
<table id="it" width='100%' cellpadding="0" cellspacing="5">
		<tr>
			<td width="25%" valign='top' >
			<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">System</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'system'}
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
			</td>
			<td width="25%" valign='top' >
					<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">Databases</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'database'}
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
			</td>
		</tr>
		
		<tr>
			<td valign='top' >
					<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">PC & Desktop Products</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'pc_products'}
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
			
			</td>
			<td valign='top' >
			<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">Platforms/Environments</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'platforms'}
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
			</td>
		</tr>
		<tr><td valign="top">
		<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">App Programming Languages</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'app_programming'}
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
		</td>
			<td valign="top">
			<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">Multimedia</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'multimedia'}
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
			</td>
			</tr>
			<tr>
			<td valign="top">
			<div class="skills-box">
				<div class="skills-box-hdr">
					<div class="{$class}">Open Source Software</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'open_source'}
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
			
			</td>
			<td valign="top">&nbsp;</td>
			</tr>
	</table>


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
	
	
<div class="skills-box">
	<div class="skills-box-hdr">ADDITIONAL INFORMATION</div>
	<div style="padding:5px; line-height:30px; margin-left:20px;">
	<ol>
	<li>Is the staff going to be working with a your onshore IT team? <b><u>{$onshore_options}</u></b>  </li>
	{if $web_des_flag eq 'true'}
	<li>Will you require your designer to do some graphic design as well ? <b><u>{$onshore_options}</u></b></li>
	{/if}
	</ol>
	</div>

</div>
	
	
	
	
	
	
	
</div>	
{include file="footer.tpl"}	