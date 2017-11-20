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


//START: generate list of position
$job_position_list="
<table width=100% cellspacing=1 cellpadding=2>
<tr>
	<td width='5%' class='td_info td_la'>&nbsp;</td>
	<td width='17%' class='td_info td_la'>Category</td>
</tr>";

$query="SELECT * FROM job_sub_category ORDER BY sub_category_date_created DESC;";
$result = $db->fetchAll($query);
$counter = 0;
foreach($result as $r)
{
	$counter++;
	$job_position_list.="
	<tr>
		<td width='5%' class='td_info td_la'>
			<table><tr><td><font size='1'>".$counter.")</font></td><td><input type='radio' id='pos' name='pos' value='".$r['sub_category_id']."' onclick=\"javascript: document.getElementById('job_category').value = '".$r['sub_category_id']."'; document.getElementById('position').value = ''; \" /></td></tr></table>
		</td>
		<td width='17%' class='td_info'><font size='1'>".$r['sub_category_name']."</font></td>
		<td width='21%' class='td_info'><font size='1'>".$d."</font></td>
	</tr>";
}
if($counter == 0)
{
	$job_position_list = "<table width=100% cellspacing=1 cellpadding=2><tr><td colspan=7><font color='#FF0000'>No Active or Current Job Category.</font></td></tr>";
}
$job_position_list .= "</table>";
//ENDED: generate list of position

echo $job_position_list;
?>
