<?php
// CHANGES HISTORY

//START: construct
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
$userid=$_REQUEST['userid'];
require_once "util/HTMLUtil.php";
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


$util = new HTMLUtil();
//START: evaluation report
$evaulation_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0>
	<tr>
		<td colspan=5><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Evaluation Notes</strong></font></td><td align="right"><a href="javascript: load_evaulation('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="20%">Recruiter</td>
		<td class="td_info td_la" width="70%">Comments</td>
		<td class="td_info td_la" width="10%">Date</td>
		<td class="td_info td_la" width="0"></td>
	</tr>';

	$sql = "SELECT e.id, e.comments, DATE_FORMAT(e.comment_date,'%D %b %y'), a.admin_fname, a.admin_lname FROM evaluation_comments e LEFT OUTER JOIN admin a ON a.admin_id = e.comment_by WHERE e.userid = $userid";
	$result = mysql_query($sql);
	$counter = 0;
	while(list($id, $comments, $date, $admin_fname, $admin_lname)=mysql_fetch_array($result))
	{
		$counter++;
		$comments = nl2br($comments);
		$comments = $util->extractText($comments);
	//	$comments = str_replace("\n","<br>",$comments);
						
		$evaulation_report .= '
		<tr>
			<td class="td_info td_la">'.$counter.'</td>
			<td class="td_info">'.$admin_fname.' '.$admin_lname.'</td>
			<td class="td_info"><a href="javascript: view_notes_show_report('.$userid.', '.$id.',\'evaluation\'); ">'.$comments.'</a></td>
			<td class="td_info">'.$date.'</td>
			<td class="td_info"><a href="javascript: edit_notes_show_report('.$userid.', '.$id.',\'evaluation\'); ">Edit</a></font></td>
		</tr>';
	} 
$evaulation_report .= '</table>';
if($counter == 0) $evaulation_report = "";
echo $evaulation_report;
//ENDED: evaluation report	
?>