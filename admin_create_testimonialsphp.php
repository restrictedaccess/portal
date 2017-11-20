<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_REQUEST['leads_id'];
$userid = $_REQUEST['userid'];
$recipient_type =$_REQUEST['recipient_type'];
$testimony_status = $_REQUEST['testimony_status'];
$testimony_id = $_REQUEST['testimony_id'];

$title = filterfield($_REQUEST['title']);
$testimony = filterfield($_REQUEST['testimony']);

if($recipient_type == "subcon"){
	$recipient_id = $userid;
}
if($recipient_type == "leads"){
	$recipient_id = $leads_id;
}

if(isset($_POST['save']))
{
	$query = "INSERT INTO testimonials SET 
					created_by_id = $admin_id, 
					created_by_type = 'admin', 
					recipient_id = $recipient_id, 
					recipient_type = '$recipient_type', 
					date_created = '$ATZ',
					title = '$title',
					testimony_status = '$testimony_status',
					testimony = '$testimony';";
	//echo $query;
	$result = mysql_query($query);		
	if(!$result) die ("Error in Script : <br>".$query);
	header("location:admin_create_testimonials.php?code=1");
}

if(isset($_POST['update']))
{
	// testimony_id, created_by_id, created_by_type, recipient_id, recipient_type, testimony_status, date_created, date_updated, date_posted, title, testimony
	$query = "UPDATE testimonials SET 
					recipient_id = $recipient_id, 
					recipient_type = '$recipient_type', 
					date_updated = '$ATZ',
					title = '$title',
					testimony_status = '$testimony_status',
					testimony = '$testimony'
					WHERE testimony_id = $testimony_id;";
	//echo $query; 
	$result = mysql_query($query);		
	if(!$result) die ("Error in Script : <br>".$query);
	header("location:admin_create_testimonials.php?code=2");
}
	
?>

