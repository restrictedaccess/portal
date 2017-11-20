<?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$leads_id=$_REQUEST['leads_id'];
$created_by_id=$_REQUEST['created_by_id'];
$remark_created_by=$_REQUEST['remark_created_by'];
$url=$_REQUEST['url'];
$remarks =$_REQUEST['remarks'];
$remarks=filterfield($remarks);

// Get the name of the creator or remark
if($remark_created_by=="BP" or $remark_created_by=="AFF")
{
	$sql ="SELECT * FROM agent WHERE agent_no = $created_by_id;";
	$res=mysql_query($sql);
	$row = mysql_fetch_array ($res); 
	$name =$remark_created_by." : ".$row['fname'];
}
if($remark_created_by=="ADMIN")
{
	$sql ="SELECT * FROM admin WHERE admin_id = $created_by_id;";
	$res=mysql_query($sql);
	$row = mysql_fetch_array ($res); 
	$name =$remark_created_by." : ".$row['admin_fname'];
}

$remark_created_by =$name;

$query="INSERT INTO leads_remarks SET leads_id = $leads_id, remark_creted_by ='$remark_created_by', created_by_id = $created_by_id, remark_created_on = '$ATZ',
 remarks = '$remarks'";
 
//echo $query; 
$result =mysql_query($query);
if(!$result)
{
	echo "Query: $query<br /><br />MySQL Error:<br /><br /> " . mysql_error();
}
else
{
	header("location:$url");
}
?>