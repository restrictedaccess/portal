<?
include '../config.php';
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

////
$query="DELETE FROM leads WHERE id=$leads_id;";
$result=mysql_query($query);
if (!$result)
{
	die("Query: $query\n<br />MySQL Error: " . mysql_error());
}
echo "<p><label>Lead ID :</label>".$leads_id."</p><p><label>Lead Name :</label>".$fname." ".$lname."</p><p><label>Status : </label>Deleted from the List</p>";
?>
