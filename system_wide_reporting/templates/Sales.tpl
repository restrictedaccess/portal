<strong>Date Selection</strong>
<div>
<span style="float:right"><a href="system_wide_reporting/leads_monthly_reporting.php" target="_blank">Leads Monthly Reporting</a></span>
<img src="images/resultset_previous.png" title="previous date" onclick="ShowBDSummaryReport('previous')" style="cursor:pointer;" align="texttop" /> Previous 
<img src="images/date.png" title="current date" onclick="ShowBDSummaryReport('current')" style="cursor:pointer;" align="texttop" />  Next
<img src="images/resultset_next.png" title="next date" onclick="ShowBDSummaryReport('next')" style="cursor:pointer;" align="texttop" /> 

<input type="text" name="event_date" id="event_date" class="text" style=" width:72px;" readonly onchange="ShowBDSummaryReport('event_date')" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd_event_date" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
</div>

<div id="summary" style="padding:10px;"><input type="hidden" name="current_date" id="current_date" value="{$current_date}"></div>