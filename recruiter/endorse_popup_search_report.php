<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");


//START: validate user session
if(!$_SESSION['admin_id'])
{
	exit;
}
if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL")
{ 
	exit;
}
//ENDED: validate user session


//START: get posts
$keyword = $_REQUEST["keyword"];
//ENDED: get posts


//START: generate content list
$sql = "SELECT id, fname, lname, timestamp as date_created, email FROM leads 
WHERE (email='$keyword' OR id='$keyword' OR CONCAT(fname, ' ', lname) LIKE '%$keyword%') AND status <> 'REMOVED' ";
$result = $db->fetchAll($sql);	

$counter = 0;
foreach($result as $rows)
{
			$counter++;
			$date = date('F j, Y',strtotime($rows['date_created']));
			//if($date <> "" && $date <> "0000-00-00") { $date = new Zend_Date($date, 'YYYY-MM-dd');	}
			
			//start: get client name
			$name = "<a href=\"javascript: lead('".$rows['id']."'); \">".$rows['fname']." ".$rows['lname']."</a>";
			//ended: get client name	

			$report_result .= '
			<tr>
				<td align="left" valign="top" class="td_info td_la">'.$counter.'</td>                            
				<td align="left" valign="top" class="td_info"><input type="radio" name="lead_id" onchange="javascript: document.getElementById(\'search_lead_id\').value='.$rows['id'].'; hide_popup_report(); show_job_position_report(); " />'.$name.'&nbsp;<font size=1><em>('.$rows['email'].')</em></font></td>
				<td align="center" valign="top" class="td_info"><font size=1>'.$date.'</font></td>
			</tr>
			';
}
//ENDED: generate content list


//START: generate report header
$header = '
<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#FFFFCC>
	<tr>
		<td valign=top>
			<table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
				<tr bgcolor="#FFFFFF">
					<td width="100%" align="left" valign="top">
						<div class="hiresteps">
						<table width="100%">
							<tr>
								<td><font color="#003366"><strong>Search</strong></font><input type="text" id="keyword" placeholder="Enter name, email or id of lead" style="width:200px"><input type="button" value="Search" onClick="javascript: show_search_popup_report(); "></td>
								<td align="right"><a href=\'javascript: hide_popup_report(); \'><img src="../../portal/images/closelabel.gif" border="0" /></a></td>
							</tr>
						</table>
						</div>
					</td>
				</tr>
				<tr>
					<td valign="top">  
						<div align="center" style=\'overflow-y:scroll; height:260px; width: 720px; overflow-x:hidden \'>	
						<table width="100%" height="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
							<tr>
								<td width="5%" align="left" valign="top" class="td_info td_la">#</td>
								<td width="45%" align="left" valign="top" class="td_info td_la">Client</td>
								<td width="50%" align="center" valign="top" class="td_info td_la">Date Added</td>
							</tr>
';	
//ENDED: generate report header


//START: generate report footer
$footer = '
							<tr>
								<td colspan=3 height=100%></td>
							</tr>
						</table>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table> 
';
//ENDED: generate report footer


//return report result
echo $header.$report_result.$footer;
?>
