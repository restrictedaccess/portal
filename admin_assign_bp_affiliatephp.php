<?
include 'config.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$id=$_REQUEST['id'];
$affiliate_chosen=$_REQUEST['affiliate_chosen'];
$aff_id=$_REQUEST['aff_id'];

if(isset($_POST['assign']))
{
	$affiliate_id= explode(",",$affiliate_chosen);
	$business_partner_id=mysql_insert_id();
	for($i=0;$i<count($affiliate_id);$i++)
	{
		//echo "Aff ID : ".$affiliate_id[$i]."<br>";
		$sql="INSERT INTO agent_affiliates SET business_partner_id = $id,date_assign='$ATZ', affiliate_id =".$affiliate_id[$i].";";
		mysql_query($sql);
	}
}

if($aff_id!="")
{
	$sql="DELETE FROM agent_affiliates WHERE id=$aff_id";
	mysql_query($sql);
}


	
	header("Location:admin_assign_bp_affiliate.php?id=$id");



?>