<!-- update job specification form -->
<div class="modal fade" id="update_job_spec_form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Update Job Specification Form</h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" role="form" id="update_js_form">
      		<input type="hidden" name="gs_job_titles_details_id" value="{$gs_jtd.gs_job_titles_details_id}"/>
		  <div class="form-group">
		    <label for="inputJobPosition" class="col-sm-3 control-label">Job Position</label>
		    <div class="col-sm-6">
		   		<input type="text" class="form-control" name="selected_job_title" value="{$gs_jtd.selected_job_title}" placeholder="Enter Job Title"/></strong>
		   		<input type="hidden" value="{$gs_jtd.jr_list_id}" name="jr_list_id"/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputQty" class="col-sm-3 control-label">Qty</label>
		    <div class="col-sm-3">
		   <input type="text" name="no_of_staff_needed" class="form-control" value="{$gs_jtd.no_of_staff_needed}"/>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputLevel" class="col-sm-3 control-label">Level</label>
		    <div class="col-sm-3">
		   <select id="level" name="level" class="form-control">
		   	{foreach from=$levels item=level}
		   		{if $level.value eq $gs_jtd.level_o}
		   			<option value="{$level.value}" selected>{$level.label}</option>
		   		{else}
		   			<option value="{$level.value}">{$level.label}</option>
		   		{/if}
		   	{/foreach}
		   </select>
		   	</div>
		  </div>
		   <div class="form-group">
		    <label for="inputLevel" class="col-sm-3 control-label">Working Status</label>
		    <div class="col-sm-6">
			   <select id="work_status1" name="work_status" class="form-control">
			   	{foreach from=$working_statuses item=work_status}
			   		{if $work_status.value eq $gs_jtd.work_status}
			   			<option value="{$work_status.value}" selected="selected">{$work_status.label}</option>
			   		{else}
			   			<option value="{$work_status.value}">{$work_status.label}</option>
			   		{/if}
			   	{/foreach}
				</select>   	
			 </div>
		  </div>
		   <div class="form-group">
		    <label for="inputLevel" class="col-sm-3 control-label">Working Timezone</label>
		    <div class="col-sm-6">
		   		<select id="timezone1" name="working_timezone" class="form-control">
		   			{foreach from=$timezones item=timezone}
		   				{if $timezone.timezone eq $gs_jtd.working_timezone}
		   					<option value="{$timezone.timezone}" selected="selected">{$timezone.timezone}</option>
		   				{else}
		   					<option value="{$timezone.timezone}">{$timezone.timezone}</option>
		   				{/if}
		   			{/foreach}
		   		</select>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputLevel" class="col-sm-3 control-label">Working Start Time</label>
		    <div class="col-sm-3">
		   	{if $gs_jtd.created_reason eq 'New JS Form Client'}
				<select name="start_work" class="form-control" id="client_start_work_hour1">
					{foreach from=$shift_times item=shift_time}
						<option value="{$shift_time.value}">{$shift_time.label}</option>
					{/foreach}
				</select>
			{else}
				<select name="start_work" class="form-control" id="client_start_work_hour1"><option value="06">6:00 am</option><option value="06:30">6:30 am</option><option value="07">7:00 am</option><option value="07:30">7:30 am</option><option value="08">8:00 am</option><option value="08:30">8:30 am</option><option value="09">9:00 am</option><option value="09:30">9:30 am</option><option value="10">10:00 am</option><option value="10:30">10:30 am</option><option value="11">11:00 am</option><option value="11:30">11:30 am</option><option value="12">12:00 noon</option><option value="12:30">12:30 noon</option><option value="13">1:00 pm</option><option value="13:30">1:30 pm</option><option value="14">2:00 pm</option><option value="14:30">2:30 pm</option><option value="15">3:00 pm</option><option value="15:30">3:30 pm</option><option value="16">4:00 pm</option><option value="16:30">4:30 pm</option><option value="17">5:00 pm</option><option value="17:30">5:30 pm</option><option value="18">6:00 pm</option><option value="18:30">6:30 pm</option><option value="19">7:00 pm</option><option value="19:30">7:30 pm</option><option selected="" value="20">8:00 pm</option><option value="20:30">8:30 pm</option><option value="21">9:00 pm</option><option value="21:30">9:30 pm</option><option value="22">10:00 pm</option><option value="22:30">10:30 pm</option><option value="23">11:00 pm</option><option value="23:30">11:30 pm</option><option value="00">12:00 am</option><option value="00:30">12:30 am</option><option value="01">1:00 am</option><option value="01:30">1:30 am</option><option value="02">2:00 am</option><option value="02:30">2:30 am</option><option value="03">3:00 am</option><option value="03:30">3:30 am</option><option value="04">4:00 am</option><option value="04:30">4:30 am</option><option value="05">5:00 am</option><option value="05:30">5:30 am</option></select>
		   
			{/if}
		   	
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputLevel" class="col-sm-3 control-label">Working End Time</label>
		    <div class="col-sm-3">
		    	
		    {if $gs_jtd.created_reason eq 'New JS Form Client'}
			    <select name="finish_work" class="form-control" id="client_finish_work_hour1">
			    	{foreach from=$shift_times item=shift_time}
						<option value="{$shift_time.value}">{$shift_time.label}</option>
					{/foreach}
			    </select>
		    
		    {else}
		   		<select name="finish_work" class="form-control" id="client_finish_work_hour1"><option value="06">6:00 am</option><option value="06:30">6:30 am</option><option value="07">7:00 am</option><option value="07:30">7:30 am</option><option value="08">8:00 am</option><option value="08:30">8:30 am</option><option value="09">9:00 am</option><option value="09:30">9:30 am</option><option value="10">10:00 am</option><option value="10:30">10:30 am</option><option value="11">11:00 am</option><option value="11:30">11:30 am</option><option value="12">12:00 noon</option><option value="12:30">12:30 noon</option><option value="13">1:00 pm</option><option value="13:30">1:30 pm</option><option value="14">2:00 pm</option><option value="14:30">2:30 pm</option><option value="15">3:00 pm</option><option value="15:30">3:30 pm</option><option value="16">4:00 pm</option><option value="16:30">4:30 pm</option><option value="17">5:00 pm</option><option value="17:30">5:30 pm</option><option value="18">6:00 pm</option><option value="18:30">6:30 pm</option><option value="19">7:00 pm</option><option value="19:30">7:30 pm</option><option selected="" value="20">8:00 pm</option><option value="20:30">8:30 pm</option><option value="21">9:00 pm</option><option value="21:30">9:30 pm</option><option value="22">10:00 pm</option><option value="22:30">10:30 pm</option><option value="23">11:00 pm</option><option value="23:30">11:30 pm</option><option value="00">12:00 am</option><option value="00:30">12:30 am</option><option value="01">1:00 am</option><option value="01:30">1:30 am</option><option value="02">2:00 am</option><option value="02:30">2:30 am</option><option value="03">3:00 am</option><option value="03:30">3:30 am</option><option value="04">4:00 am</option><option value="04:30">4:30 am</option><option value="05">5:00 am</option><option value="05:30">5:30 am</option></select>
		    
		    {/if}	
		   
		    
		    <script type="text/javascript">
		    	var working_start_time = '{$gs_jtd.start_work_val}';
		    	var working_end_time = '{$gs_jtd.finish_work_val}';
		    </script>
		    
		    </div>
		  </div>
		  
		  
		  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_changes">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{literal}
<script type="text/javascript">
	jQuery("#client_start_work_hour1").val(working_start_time);
	jQuery("#client_finish_work_hour1").val(working_end_time);
</script>
{/literal}
