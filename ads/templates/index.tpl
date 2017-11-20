{include file="header.tpl"}

{if $mode eq 'create'}
	{include file="create.tpl"}
{/if}


{if $mode eq 'view'}
	{include file="view.tpl"}
{/if}


{if $mode eq 'edit' }
	{if $edit_by_js}
		{include file="edit_from_js.tpl"}
	{else}
		{include file="edit.tpl"}
	{/if}
{/if}

{include file="footer.tpl"}	