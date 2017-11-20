{section name=i loop=$result}
	{strip}
		<div class="date_hdr">{$result[i].date_created}</div>
		{section name=j loop=$result2}
			{strip}
				{if $result[i].date_option eq $result2[j].date_option2}
					<div class="notes_content" >
			<input type="radio" name="list" align="absmiddle" onclick="confimedStickyNotes({$result2[j].id})" title="click to confirm and remove this in the list" /> {$result2[j].message}
			
					</div>
				{/if}				
			{/strip}
		{/section}
		
	{/strip}
{/section}