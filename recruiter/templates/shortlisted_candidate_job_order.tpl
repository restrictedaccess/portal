<h3 id="shortlisted_header_popup" style="color:#333;margin-bottom:5px">Shortlisted Candidates for {$jobposition} ad</h3>
<div class="filter-form" style="margin-left:10px;margin-right:10px;padding:7px;overflow:hidden">
	<form class="search_shortlisted">
		<input type="hidden" name="posting_id" value="{$posting_id}"/>
		<div style="float:left">
			<label style="font-weight: bold">Date Shortlisted: </label> <input type="text" name="date_from" class="date_picker" placeholder="From"/>&nbsp;<input type="text" name="date_to" class="date_picker" placeholder="To"/>	
		</div>
		<div style="float:left;margin-left:5px;">
			<label style="font-weight: bold">Recruiter: </label>
			<select name="recruiter">
				{$recruiter_options}
			</select>	
		</div>
		<div style="float: left;margin-left:5px;"><button class="search_shortlist">Search</button></div>	
	</form>
	
</div>
<table border="1" style="border-collapse: collapse;border: 1px solid #333;width:100%;margin-top:5px;" id="shortlist_table">
	<thead>
		<tr>
			<th style="border: 1px solid #333">#</th>
			<th style="border: 1px solid #333">Candidate</th>
			<th style="border: 1px solid #333">Assigned Recruiter</th>
			<th style="border: 1px solid #333">Date Shortlisted</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$shortlisted_candidates item=candidate name=sh_candidate}
			<tr>
				<td style="border: 1px solid #333;">{$smarty.foreach.sh_candidate.iteration}</td>
				<td style="border: 1px solid #333;"><a href="/portal/recruiter/staff_information.php?userid={$candidate.userid}" target="_blank">{$candidate.fullname}</a></td>
				<td style="border: 1px solid #333;">{$candidate.admin_fname} {$candidate.admin_lname}</td>
				<td style="border: 1px solid #333;">{$candidate.date}</td>
			</tr>
		{/foreach}
	</tbody>
</table>
{literal}
<script type="text/javascript">
	jQuery("#ui-datepicker-div").css("display", "none");
	jQuery(".date_picker").datepicker("destroy");
	jQuery(".date_picker").removeClass("hasDatepicker").removeAttr('id');

	jQuery(".date_picker").datepicker();
	jQuery(".date_picker").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#ui-dialog-title-details-dialog").text(jQuery("#shortlisted_header_popup").text());
</script>
{/literal}
