<input type="hidden" name="view_anni_staff_mode" id="view_anni_staff_mode" value="{$view_anni_staff_mode}" />
<p><strong>SUBCONS QUICK VIEW</strong></p>
		<table width="100%">
		<tr>
		  <td valign="top" width="50%">
		  
		  <strong>Hired </strong>
		  <p style="color:#FF0000; font-weight:bold;">Result for {$year}-{$month_str}</p>
<ul>
			<li>New : <a href="javascript: popup_win('./system_wide_reporting/ViewStaff.php?year={$year}&month={$month}&active=yes' ,800 , 500)">{$active_staff_monthly_result_count}</a></li>
			<!--
			<li>Test Sub Con: </li>
			<li>Replacement : </li>
			-->
			<li>Non Active Staff : <strong><a href="javascript: popup_win('./system_wide_reporting/ViewStaff.php?year={$year}&month={$month}&active=no' ,800 , 500)">{$non_active_staff_monthly_result_count}</a></strong></li>
			<!--
			<li>Cancelled : </li>
			-->
</ul>
		  
		  <strong>Hired 6 months ago</strong> 
		  <ul>
		  <li>This month : <a href="javascript:ViewAnniStaff(6,'month')" >{$six_months_count}</a> </li>
  <li>Today : <a href="javascript:ViewAnniStaff(6,'today')" >{$six_months_anni}</a></li>
  </ul>
		  
		  <strong>Yearly Anniversary</strong>
  <ul>
  <li>This month : <a href="javascript:ViewAnniStaff(1,'month')" >{$year_anni_count}</a> </li>
  <li>Today : <a href="javascript:ViewAnniStaff(1,'today')" >{$year_anni}</a></li>
  </ul>
		  
		  
		
		  
		  </td><td valign="top" width="50%">
				<strong>Applicants</strong>
				<ul>
				{section name=j loop=$years}
				<li>{$years[j].year} : <a href="javascript: popup_win('./system_wide_reporting/ApplicantsSheet.php?year={$years[j].year}&year_search=yes' ,700 , 500)">{$years[j].count}</a></li>
				{/section}
				</ul>
				<p>Total no. of Applicants : <a href="javascript: popup_win('./system_wide_reporting/ApplicantsList.php' ,800 , 500)">{$total_applicant_count}</a><br />
                Total no. of Resume from Admin : <a href="javascript: popup_win('./system_wide_reporting/total_no_of_resume_from_admin.php' ,800 , 500)">{$total_no_of_resume_from_admin}</a></p>
                
				<p>Current date total applicants : <a href="javascript: popup_win('./system_wide_reporting/ApplicantsSheet.php?from={$from}&date_search=yes' ,700 , 500)">{$current_count}</a><br />
                Current date resume from admin : <a href="javascript: popup_win('./system_wide_reporting/current_date_resume_from_admin.php?from={$from}&date_search=yes' ,700 , 500)">{$current_date_resume_from_admin}</a>
</p>
				<p>Current month total applicants :  <a href="javascript: popup_win('./system_wide_reporting/ApplicantsSheet.php?month={$month}&year={$year}&month_search=yes' ,700 , 500)">{$current_month_count}</a><br />
                Current month resume from admin :  <a href="javascript: popup_win('./system_wide_reporting/current_date_resume_from_admin.php?month={$month}&year={$year}&month_search=yes' ,700 , 500)">{$current_month_resume_from_admin}</a>
</p>
			</td>
		  </tr>
		</table>	

<p><strong>JOB ORDERS</strong></p>
		<table width="100%">
		<tr>
		  <td valign="top" width="50%">
		  
		  <strong>Open Job Orders</strong>
		<ul>
			<li>ASL : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=2&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$asl_open_counts}</a></strong></li>
			<li>CUSTOM : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=1&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$custom_open_counts}</a></strong></li>
			<li>BACK ORDER :<strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=3&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$backorder_open_counts}</a></strong></li>
			<li>REPLACEMENT : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=4&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$replacement_open_counts}</a></strong></li>
			<li>INHOUSE : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=5&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$inhouse_open_counts}</a></strong></li>
		</ul>
	  </td>
	  <td valign="top" width="50%">
		<strong>Job Orders Over 15 days</strong>
		<ul>
			<li>ASL : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&date_from={$date_from_jo}&date_to={$date_to_jo}&service_type=2&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$asl_15_counts}</a></strong></li>
			<li>CUSTOM : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&date_from={$date_from_jo}&date_to={$date_to_jo}&service_type=1&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$custom_15_counts}</a></strong></li>
			<li>BACK ORDER :<strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&date_from={$date_from_jo}&date_to={$date_to_jo}&service_type=3&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$backorder_15_counts}</a></strong></li>
			<li>REPLACEMENT : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&date_from={$date_from_jo}&date_to={$date_to_jo}&service_type=4&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$replacement_15_counts}</a></strong></li>
			<li>INHOUSE : <strong><a href="javascript: popup_win('/portal/recruiter/load_job_posting_details.php?filter_type=3&date_from={$date_from_jo}&date_to={$date_to_jo}&service_type=5&hiring_coordinator=&order_status=0' ,800 , 500)" class="launcher">{$inhouse_15_counts}</a></strong></li>
		</ul>		
	</td>
	</tr>
</table>	
			
		

		
