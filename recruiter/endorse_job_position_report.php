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
$id = $_REQUEST["id"];
//ENDED: get posts


//START: generate list of position
$job_position_list="
<table width=100% cellspacing=1 cellpadding=2>
<tr>
	<td width='5%' class='td_info td_la'>#</td>
	<td width='17%' class='td_info td_la'>Job Position</td>
	<td width='12%' class='td_info td_la'>Client</td>
	<td width='12%' class='td_info td_la'>Date</td>
</tr>";

$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y') as date,p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id
FROM posting p, leads l WHERE l.id=p.lead_id AND p.status='ACTIVE' AND p.lead_id='$id' ORDER BY p.date_created DESC;";
$result = $db->fetchAll($query);
$counter = 0;
foreach($result as $r)
{
	$counter++;
	$job_position_list.="
	<tr>
		<td width='5%' class='td_info td_la'>
			<table><tr><td><font size='1'>".$counter.")</font></td><td><input type='radio' id='pos' name='pos' value='".$r['id']."' onclick=\"javascript: document.getElementById('position').value = '".$r['id']."'; document.getElementById('job_category').value = ''; \" /></td></tr></table>
		</td>
		<td width='17%' class='td_info'><font size='1'>".$r['jobposition']."</font></td>
		<td width='12%' class='td_info'><b><font size='1'><a href=\"javascript:lead(".$r['lead_id']."); \">".$r['fname']."&nbsp;".$r['lname']."</font></td>
		<td width='12%' class='td_info'><font size='1'>".$r['date']."</font></td>
	</tr>";
}
if($counter == 0)
{
	$job_position_list = "<table width=100% cellspacing=1 cellpadding=2><tr><td colspan=7><font color='#FF0000'>This client has no Active or Current Job Advertisement.</font></td></tr>";
}
$job_position_list .= "</table>";
//ENDED: generate list of position

echo $job_position_list;
?>
