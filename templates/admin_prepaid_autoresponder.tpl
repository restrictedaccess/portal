{*
2011-12-16  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<p>Admin #{$admin.admin_id} {$admin.admin_fname} {$admin.lname} convert Client #{$lead.id} {$lead.fname} {$lead.lname} from regular client to prepaid client</p>
{if $prepaid_staffs}
    Staff contracts involved were the following:
    <ol>
    {foreach from=$prepaid_staffs name=staff item=staff}
	     <li>#{$staff.userid} {$staff.fname} {$staff.lname}</li>
	{/foreach}
	</ol>
	
{else}
    No staff involved
{/if}