<?
include '../config.php';
include '../conf.php';
$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}

$queryLeads ="SELECT * FROM leads WHERE id = $leads_id;";
$resultLeads=mysql_query($queryLeads);
$rows = mysql_fetch_array($resultLeads);
$lname =$rows['lname'];
$fname =$rows['fname'];


$status=$_REQUEST['status'];
$query="UPDATE leads SET status='$status' WHERE id=$leads_id;";
$result=mysql_query($query);
if (!$result)
{
	die("Query: $query\n<br />MySQL Error: " . mysql_error());
}



?>
<input type="hidden" id="result_message" value="updated" />

