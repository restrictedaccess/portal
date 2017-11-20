<?
/*
2009-10-01 Normaneil Macutay
	- Removed hosting field  .Let the RS-Inhouse Developers add it manually in the database in the agents profle "agent" table
	
*/

include 'config.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$email = $_REQUEST['email'];
$email2 = $_REQUEST['email2'];
$password = $_REQUEST['password'];
if($password != "" or $password != NULL){
	$password = sha1($password);
	//echo $password;
}


$fname = $_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$address=$_REQUEST['address'];
$phone=$_REQUEST['phone'];
$status=$_REQUEST['status'];
$id=$_REQUEST['id'];
//$hosting =$_REQUEST['hosting'];
$access=$_REQUEST['access'];
if($access=="0")
{
	$access="NO";
}




if(isset($_POST['save']))
{
$sql="SELECT * FROM agent WHERE email='$email';";
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
//echo $sql."<br>";
//echo $ctr;
if($ctr > 0)
{
	    $mess="1";
		header("Location:adminnaddagent.php?mess=$mess");
}
else
{
	$sql2="SELECT MAX(agent_code) FROM agent;";
	//echo $sql2."<br>";
	$res=mysql_query($sql2);
	$ctr=@mysql_num_rows($res);
	//echo "ctr : ".$ctr."<br>";
	if ($ctr >0 || $ctr=="" )
	{
	    //$row = mysql_fetch_array ($res, MYSQL_NUM); 
	    //$row = mysql_fetch_array($res);
		//$agent_code = $row[''];
		list($agent_code) = mysql_fetch_array($res);
		$agent_code=$agent_code+001;
		//echo "Agent Code :".$agent_code."<br>";
	}
	else
	{
		$agent_code=100;
	}
	
	
	$query= "INSERT INTO agent (lname, fname, email, agent_password, date_registered,agent_code,agent_address, agent_contact,work_status,access_aff_leads) VALUES ('$lname', '$fname', '$email', '$password','$ATZ','$agent_code','$address','$phone','BP','$access');";
	//echo $query;
	mysql_query($query);
	//$_SESSION['agent_no'] = mysql_insert_id(); 
	
	// SET BP ACCESS TO AFFILIATES....
	if($access=="YES")
	{
		$affiliate_chosen=$_REQUEST['affiliate_chosen'];
		$affiliate_id= explode(",",$affiliate_chosen);
		$business_partner_id=mysql_insert_id();
		for($i=0;$i<count($affiliate_id);$i++)
		{
			//echo "Aff ID : ".$affiliate_id[$i]."<br>";
			$sql="INSERT INTO agent_affiliates SET business_partner_id = $business_partner_id,date_assign='$ATZ', affiliate_id =".$affiliate_id[$i].";";
			//echo $sql."<br>"; 
			mysql_query($sql);
		}
	
	}
	
	header("Location:adminnaddagent.php");
}

}

if(isset($_POST['update']))
{
	if($password!=""){
		$query= "UPDATE agent SET lname = '$lname', fname = '$fname', email = '$email' , agent_password = '$password', agent_address = '$address',
				agent_contact = '$phone', status = '$status', email2 = '$email2',access_aff_leads ='$access' WHERE agent_no =$id;";
	}else{
		$query= "UPDATE agent SET lname = '$lname', fname = '$fname', email = '$email' , agent_address = '$address',
				agent_contact = '$phone', status = '$status', email2 = '$email2',access_aff_leads ='$access' WHERE agent_no =$id;";
	}		
	$result=mysql_query($query);
	header("Location:adminnaddagent.php");
}

?>