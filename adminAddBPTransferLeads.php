<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];
$agent_no = $_POST['agent_no'];
//echo $agent_no;
//id, agent_no, admin_id, date_created
$sql = "SELECT * FROM agent_transfer_leads a WHERE agent_no = $agent_no;";
$data = mysql_query($sql);
$ctr = mysql_num_rows($data);
if($ctr > 0){
	die("Chosen Business Partner Already Exist ! Please try different Business Partner");
}



$query = "INSERT INTO agent_transfer_leads SET agent_no = $agent_no, admin_id = $admin_id, date_created = '$ATZ';";
$result = mysql_query($query);


$query = "SELECT t.id, DATE_FORMAT(t.date_created, '%D %b %Y'),a.fname,a.lname,a.email,a.agent_code FROM agent_transfer_leads t LEFT JOIN agent a ON a.agent_no = t.agent_no;";
	//echo $query;
$result = mysql_query($query);
$counter=0;
while(list($id,$date,$fname,$lname,$email,$agent_code)=mysql_fetch_array($result))
{
$counter++;
?>
<div style="border:#E9E9E9 solid 1px;">
	<div style="float:left; display:block; width:40px;padding-left:5px;"><?=$counter;?></div>
	<div style="float:left; display:block; width:400px; border-right:#cccccc solid 1px;border-left:#cccccc solid 1px; padding-left:5px;">
	<?=$fname." ".$lname;?></div>
	<div style="float:left; display:block; width:100px;padding-left:5px;"><?=$agent_code;?></div>
	<div style="float:left; display:block; width:300px;border-left:#cccccc solid 1px;padding-left:5px;"><?=$email;?></div>
	<div style="float:left; display:block; border-left:#cccccc solid 1px;padding-left:5px; cursor:pointer; color:#FF0000;" onClick="deleteBP(<?=$id;?>);">delete</div>
	<div style="clear:both;"></div>
</div>
<?	
}

?>
