<?php
// CHANGES HISTORY

//START: construct
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
$userid=$_REQUEST['userid'];
//ENDED: construct


//START: communications report
$communications_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0>
	<tr>
		<td colspan=5><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Communications</strong></font></td><td align="right"><a href="javascript: load_communications('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="15%">Recruiter</td>
		<td class="td_info td_la" width="20%">Subject</td>
		<td class="td_info td_la" width="50%">Comments</td>
		<td class="td_info td_la" width="15%">Date</td>
	</tr>';

$sql = "SELECT e.id, e.history, DATE_FORMAT(e.date_created,'%D %b %y'), a.admin_fname, a.admin_lname, e.subject FROM applicant_history e LEFT OUTER JOIN admin a ON a.admin_id = e.admin_id WHERE e.userid = $userid ORDER BY e.date_created DESC;";
$result = mysql_query($sql);
$counter = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;					
while(list($id, $history, $date_created, $admin_fname, $admin_lname, $subject)=mysql_fetch_array($result))
{
	$counter++;
	$history = str_replace("\n","<br>",$history);
	$communications_report .= '
	<tr>
		<td class="td_info td_la">'.$counter.'</font></td>
		<td class="td_info">'.$admin_fname.' '.$admin_lname.'</td>
		<td class="td_info">'.$subject.'</td>
		<td class="td_info">'.$history.'</td>
		<td class="td_info">'.$date_created.'</td>
	</tr>';					
} 
$communications_report .= '</table>';
if($counter == 0) $communications_report = "";
echo $communications_report;
//ENDED: communications report		
?>