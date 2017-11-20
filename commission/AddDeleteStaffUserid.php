<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$leads_id = $_SESSION['client_id'];
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$commission_id = $_REQUEST['commission_id'];
$userid = $_REQUEST['userid'];
$method = $_REQUEST['method'];


$queryStaff="SELECT CONCAT(fname,' ',lname)	FROM personal WHERE userid = $userid;";
$data = mysql_query($queryStaff);
list($staff_name)=mysql_fetch_array($data);
//echo "Commission ID = ".$commission_id." userid = ".$userid." method = ".$method;

/*
SELECT * FROM commission_staff c
commission_staff_id, commission_id, userid, include_by, include_by_type, date_included, commission_staff_status
*/

//add
if($method == "add"){
	$sql="INSERT INTO commission_staff SET 
			commission_id = $commission_id, 
			userid = $userid, 
			include_by = $leads_id, 
			include_by_type = 'leads', 
			date_included = '$ATZ';";
	$result = mysql_query($sql);		
	if(!$result) die("Error in Script.<br>".$query);
	echo $staff_name. " successfully added in the list";
}

//delete
if($method == "delete"){
	$sql="DELETE FROM commission_staff WHERE commission_id = $commission_id AND userid = $userid;";
	$result = mysql_query($sql);		
	if(!$result) die("Error in Script.<br>".$query);
	if(mysql_num_rows($result)>0){
		echo $staff_name. " has been removed from the list";
	}else{
		echo "Move and Drop Staff to right panel";
	}
}


?>