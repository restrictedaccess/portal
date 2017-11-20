<?php
// CHANGES HISTORY

//START: construct
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
$userid=$_REQUEST['userid'];
//ENDED: construct


//START: truncate evaluation & communications notes
function truncate_comment($string) 
{
	if(strlen($string) > 50)
	{
		return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[20].$string[21].$string[22].$string[23].$string[24].$string[25].$string[26].$string[27].$string[28].$string[29].$string[30].$string[31].$string[32].$string[33].$string[34].$string[35].$string[36].$string[37].$string[38].$string[39].$string[40].$string[41].$string[42].$string[43].$string[44].$string[45].$string[46].$string[47].$string[48].$string[49].$string[50].'...';
	}
	else
	{
		return $string;
	}
}
//ENDED: truncate evaluation & communications notes


//START: admin report
$admin_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0>
	<tr>
		<td colspan=7><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Admin</strong></font></td><td align="right"><a href="javascript: load_admin('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="15%">User</td>
		<td class="td_info td_la" width="15%">Date/Time</td>
		<td class="td_info td_la" width="15%">Type</td>
		<td class="td_info td_la" width="20%">Subject</td>
		<td class="td_info td_la" width="35%">Content</td>
		<td class="td_info td_la" width="0"></td>
	</tr>';

$sql = "SELECT e.id, e.history, DATE_FORMAT(e.date_created,'%D %b %y'), e.date_created, a.admin_fname, a.admin_lname, e.subject, e.actions FROM applicant_history e LEFT OUTER JOIN admin a ON a.admin_id = e.admin_id WHERE a.status='FULL-CONTROL' AND e.userid = $userid ORDER BY e.date_created DESC;";
$result = mysql_query($sql);
$counter = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;					
while(list($id, $history, $date_created, $time_created, $admin_fname, $admin_lname, $subject, $actions)=mysql_fetch_array($result))
{
	$counter++;
	$history = str_replace("\n","<br>",$history);
	$time_created = date("g:i a", strtotime($time_created));
	
	if($actions == "EMAIL")
	{
		$edit_link = '<td class="td_info"></td>';
	}
	else
	{
		$edit_link = '<td class="td_info"><font size=1><a href="javascript: delete_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Delete</a>&nbsp;&nbsp;&nbsp;<a href="javascript: edit_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Edit</a></font></td>';		
	}
	if($actions == "CSR")
	{
		$view_notes_link = "Click to view notes";
	}
	else
	{
		$view_notes_link = truncate_comment($history);
	}	
	$admin_report .= '
	<tr>
		<td class="td_info td_la">'.$counter.'</font></td>
		<td class="td_info">'.$admin_fname.' '.$admin_lname.'</td>
		<td class="td_info">'.$date_created.'&nbsp;&nbsp;<font size=1>'.$time_created.'</font></td>
		<td class="td_info">'.$actions.'</td>
		<td class="td_info">'.$subject.'</td>
		<td class="td_info"><a href="javascript: view_notes_show_report('.$userid.', '.$id.',\'communications\'); ">'.$view_notes_link.'</a></td>
		'.$edit_link.'
	</tr>';					
} 
$admin_report .= '</table>';
if($counter == 0) $admin_report = "";
echo $admin_report;
//ENDED: admin report		
?>