<?
include "../../config.php";
include "../../conf.php";
include "../../time.php";
include "../../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];

$leads_id = $_REQUEST['leads_id'];
$userid = $_REQUEST['userid'];
$id = $_REQUEST['id'];


$display_name = filterfield($_REQUEST['display_name']);
$display_company_name = filterfield($_REQUEST['display_company_name']);



/*
SELECT * FROM testimonials_display_info t;
id, created_by_id, created_by_type, recipient_id, recipient_type, display_name, display_desc
*/
$sql = "SELECT * FROM testimonials_display_info WHERE id = $id ;";

$data = mysql_query($sql);		
if(!$data) die ("Error in Script.\n".$sql);	
if(mysql_num_rows($data) > 0){

	$query = "UPDATE testimonials_display_info SET 
			display_name = '$display_name', 
			display_desc = '$display_company_name' 
			WHERE id = $id ;";
	$result=mysql_query($query);
	if(!$result) die ("Error in Script.\n".$query);			
	echo "Display Information Updated!";
	
}else {

	$query = "INSERT INTO testimonials_display_info SET 
				created_by_id = $admin_id, 
				created_by_type = 'admin', 
				recipient_id = $userid, 
				recipient_type = 'subcon', 
				display_name = '$display_name', 
				display_desc = '$display_company_name',
				for_id = $leads_id, 
				for_by_type = 'leads';";
	$result=mysql_query($query);
	if(!$result) die ("Error in Script.\n".$query);			
	echo "Display Information Saved!";

}

?>
