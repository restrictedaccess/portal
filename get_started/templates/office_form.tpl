{include file="header.tpl"}
<div id="job-spec">
<div><strong>Technical and Non technical Requirements</strong></div>
<table width='100%' cellpadding="0" cellspacing="5">
  <tr>
    <td width="25%" valign='top' >
	<div class="skills-box">
		<div class="skills-box-hdr">
			<div class="{$class}">General</div>
			<div class="skill_rating">Ratings</div>
			<div style="clear:both;"></div>
		</div>
		<div class="list_box">
			{section name=j loop=$result}
						{strip}
							{if $result[j].box eq 'general'}
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
					<div class="{$class}">Accounts/Clerk</div>
					<div class="skill_rating">Ratings</div>
					<div style="clear:both;"></div>
				</div>
				<div class="list_box">
					{section name=j loop=$result}
								{strip}
									{if $result[j].box eq 'accounts_clerk'}
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
			<div class="{$class}">Accounts Payable</div>
			<div class="skill_rating">Ratings</div>
			<div style="clear:both;"></div>
		</div>
		<div class="list_box">
			{section name=j loop=$result}
						{strip}
							{if $result[j].box eq 'accounts_payable'}
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
			<div class="{$class}">Bookkeeper</div>
			<div class="skill_rating">Ratings</div>
			<div style="clear:both;"></div>
		</div>
		<div class="list_box">
			{section name=j loop=$result}
						{strip}
							{if $result[j].box eq 'bookkeeper'}
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
			<div class="{$class}">Accounts Receivable</div>
			<div class="skill_rating">Ratings</div>
			<div style="clear:both;"></div>
		</div>
		<div class="list_box">
			{section name=j loop=$result}
						{strip}
							{if $result[j].box eq 'accounts_receivable'}
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
			<div class="{$class}">Accounting Package</div>
			<div class="skill_rating">Ratings</div>
			<div style="clear:both;"></div>
		</div>
		<div class="list_box">
			{section name=j loop=$result}
						{strip}
							{if $result[j].box eq 'accounting_package'}
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
			<div class="{$class}">Payroll</div>
			<div class="skill_rating">Ratings</div>
			<div style="clear:both;"></div>
		</div>
		<div class="list_box">
			{section name=j loop=$result}
						{strip}
							{if $result[j].box eq 'payroll'}
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
    <td valign="top" style="padding:10px;">
	{if $staff_phone_flag eq 'true'}
		Do you need your staff to be on the phone ? <b><u>{$staff_phone_options}</u></b>
	{/if}
	</td>
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
	
	
	
	
</div>	
{include file="footer.tpl"}	