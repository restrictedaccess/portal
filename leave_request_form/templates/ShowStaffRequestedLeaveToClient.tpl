<input  type="hidden" id="a_selected"  />
<div class="status_hdr" >PENDING</div>
<div class="status_list">
<ol>
{section name=j loop=$pending_leave_requests}
     {if $manager}
        {if $manager.view_staff eq 'specific'}
            {if in_array($pending_leave_requests[j].subcon_id, $subcons) }
                <li><a id="a_{$pending_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$pending_leave_requests[j].id})"><strong>[{$pending_leave_requests[j].id}]</strong> {$pending_leave_requests[j].fname} {$pending_leave_requests[j].lname}</a></li>
            {/if}   
        {/if}
        
        {if $manager.view_staff eq 'all'}
            <li><a id="a_{$pending_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$pending_leave_requests[j].id})"><strong>[{$pending_leave_requests[j].id}]</strong> {$pending_leave_requests[j].fname} {$pending_leave_requests[j].lname}</a></li>
        {/if}
        
        {if $manager.view_staff eq 'none'}
            <li>&nbsp;</li>
        {/if}
         
    {else}
		<li><a id="a_{$pending_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$pending_leave_requests[j].id})"><strong>[{$pending_leave_requests[j].id}]</strong> {$pending_leave_requests[j].fname} {$pending_leave_requests[j].lname}</a></li>
    {/if}
{/section}
</ol>
</div>
<div class="status_hdr" >ABSENT</div>
<div class="status_list">
<ol>
{section name=j loop=$absent_leave_requests}
    {if $manager}
        {if $manager.view_staff eq 'specific'}
            {if in_array($absent_leave_requests[j].subcon_id, $subcons) }
        <li><a id="a_{$absent_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$absent_leave_requests[j].id})"><strong>[{$absent_leave_requests[j].id}]</strong> {$absent_leave_requests[j].fname} {$absent_leave_requests[j].lname}</a></li>
            {/if}   
        {/if}
        
        {if $manager.view_staff eq 'all'}
            <li><a id="a_{$absent_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$absent_leave_requests[j].id})"><strong>[{$absent_leave_requests[j].id}]</strong> {$absent_leave_requests[j].fname} {$absent_leave_requests[j].lname}</a></li>
        {/if}
        
        {if $manager.view_staff eq 'none'}
            <li>&nbsp;</li>
        {/if}
         
    {else}
		<li><a id="a_{$absent_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$absent_leave_requests[j].id})"><strong>[{$absent_leave_requests[j].id}]</strong> {$absent_leave_requests[j].fname} {$absent_leave_requests[j].lname}</a></li>
    {/if}
{/section}
</ol>

</div>
<div class="status_hdr" >APPROVED</div>
<div class="status_list">
<ol>
{section name=j loop=$approved_leave_requests}
    {if $manager}
        {if $manager.view_staff eq 'specific'}
            {if in_array($approved_leave_requests[j].subcon_id, $subcons) }
                <li><a id="a_{$approved_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$approved_leave_requests[j].id})"><strong>[{$approved_leave_requests[j].id}]</strong> {$approved_leave_requests[j].fname} {$approved_leave_requests[j].lname}</a></li>
            {/if}   
        {/if}
        
        {if $manager.view_staff eq 'all'}
            <li><a id="a_{$approved_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$approved_leave_requests[j].id})"><strong>[{$approved_leave_requests[j].id}]</strong> {$approved_leave_requests[j].fname} {$approved_leave_requests[j].lname}</a></li>
        {/if}
        
        {if $manager.view_staff eq 'none'}
            <li>&nbsp;</li>
        {/if}
         
    {else}
		<li><a id="a_{$approved_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$approved_leave_requests[j].id})"><strong>[{$approved_leave_requests[j].id}]</strong> {$approved_leave_requests[j].fname} {$approved_leave_requests[j].lname}</a></li>
    {/if}        
        
{/section}
</ol>

</div>
<div class="status_hdr" >DENIED</div>
<div class="status_list">
<ol>
{section name=j loop=$denied_leave_requests}
    {if $manager}
        {if $manager.view_staff eq 'specific'}
            {if in_array($denied_leave_requests[j].subcon_id, $subcons) }
                <li><a id="a_{$denied_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$denied_leave_requests[j].id})"><strong>[{$denied_leave_requests[j].id}]</strong> {$denied_leave_requests[j].fname} {$denied_leave_requests[j].lname}</a></li>
            {/if}   
        {/if}
        
        {if $manager.view_staff eq 'all'}
            <li><a id="a_{$denied_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$denied_leave_requests[j].id})"><strong>[{$denied_leave_requests[j].id}]</strong> {$denied_leave_requests[j].fname} {$denied_leave_requests[j].lname}</a></li>
        {/if}
        
        {if $manager.view_staff eq 'none'}
            <li>&nbsp;</li>
        {/if}
         
    {else}
		<li><a id="a_{$denied_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$denied_leave_requests[j].id})"><strong>[{$denied_leave_requests[j].id}]</strong> {$denied_leave_requests[j].fname} {$denied_leave_requests[j].lname}</a></li>
    {/if}        
{/section}
</ol>

</div>

<div class="status_hdr" >CANCELLED</div>
<div class="status_list">
<ol>
{section name=j loop=$cancelled_leave_requests}
    {if $manager}
        {if $manager.view_staff eq 'specific'}
            {if in_array($cancelled_leave_requests[j].subcon_id, $subcons) }
                <li><a id="a_{$cancelled_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$cancelled_leave_requests[j].id})"><strong>[{$cancelled_leave_requests[j].id}]</strong> {$cancelled_leave_requests[j].fname} {$cancelled_leave_requests[j].lname}</a></li>
            {/if}   
        {/if}
        
        {if $manager.view_staff eq 'all'}
            <li><a id="a_{$cancelled_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$cancelled_leave_requests[j].id})"><strong>[{$cancelled_leave_requests[j].id}]</strong> {$cancelled_leave_requests[j].fname} {$cancelled_leave_requests[j].lname}</a></li>
        {/if}
        
        {if $manager.view_staff eq 'none'}
            <li>&nbsp;</li>
        {/if}
         
    {else}
		<li><a id="a_{$cancelled_leave_requests[j].id}" href="javascript:ShowStaffCalendar({$cancelled_leave_requests[j].id})"><strong>[{$cancelled_leave_requests[j].id}]</strong> {$cancelled_leave_requests[j].fname} {$cancelled_leave_requests[j].lname}</a></li>
    {/if}        
{/section}
</ol>

</div>

