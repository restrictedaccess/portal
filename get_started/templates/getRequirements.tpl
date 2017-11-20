{section name=j loop=$result}
	{strip}
			<div class="skill_list" >
				<div class="{$class}">{$result[j].description|escape:'htmlall'}</div>
				<div class="skill_rating">{$result[j].rating}</div>
				<div class="del" ><a href="javascript:deleteCredentials({$result[j].gs_job_titles_credentials_id} ,{$result[j].gs_job_titles_details_id}, '{$result[j].box}', '{$result[j].div}')" title="delete">x</a></div>	
				<div style="clear:both;"></div>
			</div>
	{/strip}
{/section}






