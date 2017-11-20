<input type="hidden" name="leave_request_id" id="leave_request_id" value="{$leave_request.id}" />
<div align="left">
    <div id="lr_details">
    	<p><label>Leave Request No.</label> : <strong>{$leave_request.id}</strong></p>
    	<p><label>Staff</label> : <strong>{$personal.fname|capitalize} {$personal.lname|capitalize}</strong></p>
        <p><label>Job Designation</label> : {$subcon.job_designation}</p>
        <p><label>Client</label> : {$lead.fname|capitalize} {$lead.lname|capitalize}</p>
        <p><label>Leave Type</label> : {$leave_request.leave_type}</p>
        <p><label>Leave Duration</label> : {$leave_request.leave_duration}</p>
        <p><label>Reason</label> : {$leave_request.reason_for_leave}</p>
    </div>
    <hr />
    {foreach from=$dates item=d name=d}
        <time datetime="{$d.date_of_leave}" class="icon">           	
          <em>{$d.date_of_leave|date_format:"%A"}<br /><small>{$d.status}</small></em>
          <strong class="{if $d.status eq 'pending'}status_pending{/if}{if $d.status eq 'approved'}status_approved{/if}{if $d.status eq 'absent'}status_absent{/if}{if $d.status eq 'denied'}status_denied{/if}{if $d.status eq 'cancelled'}status_cancelled{/if}">{$d.date_of_leave|date_format:"%b. %Y"}{if $d.status eq 'pending'}<input  type="checkbox" name="dates" value="{$d.id}" />{/if}</strong>
          <span>{$d.date_of_leave|date_format:"%e"}</span>
        </time>
    {/foreach}
    <br clear="all" />
    <hr />
    <div>
    	{if $d.status eq 'pending'}<textarea name="notes" id="notes" style=" width:50%; height:100px;" placeHolder="Type your comment here"></textarea><br />{/if}
    	<button class="btn action_btn" status="approved">Approve</button>
        <button class="btn action_btn" status="denied">Deny</button>
        <button class="btn action_btn" status="cancelled">Cancel</button>
        <button id="close_btn" class="btn">Close</button>
    </div>
    
    {if $histories}
    	<div id="comments_box">
    	<p><strong>Comments</strong></p>
        {foreach from=$histories item=h name=h}
            <div>Comment By : {$h.comment_by}</div>
            <div>Date : {$h.date_comment}</div>
            <div class="comment">{$h.comment}</div>
            <hr />
        {/foreach}
        </div>
	{/if}
    
</div>