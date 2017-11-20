<?php
//  2010-02-28  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed tracking when invoice is deleted
//  2009-12-28  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Just set the status of the invoice to deleted
//  -   Add history

include '../../conf.php';
include '../../config.php';
include '../../time.php';

$admin_id = $_SESSION['admin_id'];

if($admin_id=="")   //session check
{
    die("Session not found!\nPlease relogin");
}


$client_invoice_id = $_REQUEST['client_invoice_id'];

if($client_invoice_id==""){
	die("Invoice ID is Missing..");
}

$query="UPDATE client_invoice set status = 'deleted', updated_by = $admin_id WHERE id = $client_invoice_id;";
$result = mysql_query($query);
if(!$result)
{
	die("Error in script<br>".$query);
}

//insert history
$query = "INSERT into client_invoice_history (client_invoice_id, changes, changed_by_id, date_changed) VALUES ($client_invoice_id, 'DELETED', $admin_id, NOW())";
$result = mysql_query($query);
if(!$result)
{
	die("Error in adding history<br>".$query);
}

//remove from tracking
$query = "DELETE from timesheet_client_invoice_tracking where client_invoice_id = $client_invoice_id"; 
$result = mysql_query($query);
if(!$result) {
	die("Error in deleting from invoice tracker<br>".$query);
}

?>
<p><b>Invoice Deleted !</b></p>
