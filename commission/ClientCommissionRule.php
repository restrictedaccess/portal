<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['userid']=="")
{
	die("Session Expires Please Re-Login!");
}
$userid = $_SESSION['userid'];
$query="SELECT c.commission_id, commission_title, commission_amount, commission_desc , CONCAT(l.fname,' ',l.lname), c.commission_status
FROM commission c
LEFT JOIN commission_staff s ON s.commission_id = c.commission_id
LEFT JOIN leads l ON l.id = c.leads_id
WHERE s.userid = $userid;";

$result = mysql_query($query);
if(!$result) die("Error in SQL Script.<br>".$query);
while(list($commission_id, $commission_title, $commission_amount, $commission_desc , $leads_name, $commission_status)=mysql_fetch_array($result))
{
	
	if($commission_status == 'new'){
		$counter++;
		$commission_status_new.="<div onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick='showCommission($commission_id)'  >
				<div title='$commission_title'>".$commission_title."</div>
		</div>";
	}
	if($commission_status == 'paid'){
		$counter++;
		$commission_status_paid.="<div class='list_box' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick='showCommission($commission_id)'  >
		<div class='list_number'>".$counter."</div>
		<div class='list_title' title='$commission_title'>".substr($commission_title,0,25)."</div>
		<div style='clear:both;'></div></div>";
	}
	if($commission_status == 'cancel'){
		$counter++;
		$commission_status_cancel.="<div class='list_box' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick='showCommission($commission_id)'  >
		<div class='list_number'>".$counter."</div>
		<div class='list_title' title='$commission_title'>".substr($commission_title,0,25)."</div>
		<div style='clear:both;'></div></div>";
	}

}
//echo $commission_status_new;
?>
<h2> Available Reports</h2>
