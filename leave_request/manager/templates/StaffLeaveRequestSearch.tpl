<div class="leave_request_status_box">
    <div class="leave_request_status_box_hdr">Pending</div>
    	<div class="leave_request_status_list">
            <ol>
                {foreach from=$leaves.pending item=l name=l}
                    <li class="lr_id" id="{$l.id}_lr_id_{$l.status}_{$l.date_id}" leave_request_id="{$l.id}" status="{$l.status}">{$l.id} {$l.fname} {$l.lname}</li>
                {/foreach}
            </ol>
        </div>        
</div>      



<div class="leave_request_status_box">
    <div class="leave_request_status_box_hdr">Absent</div>
    	<div class="leave_request_status_list">
            <ol>
                {foreach from=$leaves.absent item=l name=l}
                     <li class="lr_id" id="{$l.id}_lr_id_{$l.status}_{$l.date_id}" leave_request_id="{$l.id}" status="{$l.status}">{$l.id} {$l.fname} {$l.lname}</li>
                {/foreach}
            </ol>        
        </div>
</div> 


<div class="leave_request_status_box">
    <div class="leave_request_status_box_hdr">Approved</div>
    	<div class="leave_request_status_list">
            <ol>
                {foreach from=$leaves.approved item=l name=l}
                     <li class="lr_id" id="{$l.id}_lr_id_{$l.status}_{$l.date_id}" leave_request_id="{$l.id}" status="{$l.status}">{$l.id} {$l.fname} {$l.lname}</li>
                {/foreach}
            </ol>
        </div>        
</div> 


<div class="leave_request_status_box">
    <div class="leave_request_status_box_hdr">Denied</div>
    	<div class="leave_request_status_list">
            <ol>
                {foreach from=$leaves.denied item=l name=l}
                     <li class="lr_id" id="{$l.id}_lr_id_{$l.status}_{$l.date_id}" leave_request_id="{$l.id}" status="{$l.status}">{$l.id} {$l.fname} {$l.lname}</li>
                {/foreach}
            </ol>
        </div>        
</div>


<div class="leave_request_status_box">
    <div class="leave_request_status_box_hdr">Cancelled</div>
    	<div class="leave_request_status_list">
            <ol>
                {foreach from=$leaves.cancelled item=l name=l}
                     <li class="lr_id" id="{$l.id}_lr_id_{$l.status}_{$l.date_id}" leave_request_id="{$l.id}" status="{$l.status}">{$l.id} {$l.fname} {$l.lname}</li>
                {/foreach}
            </ol> 
        </div>       
</div>