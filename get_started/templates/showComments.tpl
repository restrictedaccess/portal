<ol>
{section name=j loop=$messages}
{strip}
	<li>{$messages[j].name} => {$messages[j].notes|escape} <span>{$messages[j].date_created}</span></li>
{/strip}
{/section}
</ol>


