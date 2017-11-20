<?
// from : skillStrengths.php
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf.php') ;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}


//$userid=$_SESSION['userid'];
$userid = @$_GET["userid"];

//$userid=$_REQUEST['userid'];
$skill=$_REQUEST['skill'];
$experience=$_REQUEST['experience'];
$proficiency=$_REQUEST['proficiency'];

if(isset($_POST['Add']))
{
	//echo "Add";
	/* skills
	id, userid, skill, experience, proficiency
	*/
	$query="INSERT INTO skills (userid, skill, experience, proficiency) VALUE ($userid, '$skill', $experience, $proficiency);";
	//echo $query;
	$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:admin_updateskillsStrengths.php?mess=$mess");
	}
	else
	{
		$queryUpdate ="UPDATE personal SET dateupdated='$ATZ ' WHERE userid = $userid;";
		mysql_query($queryUpdate);
		
		//START: insert staff history
		include('lib/staff_history.php');
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'SKILLS', 'INSERT', '');
		//ENDED: insert staff history		
?>
	<script language="javascript">
		opener.location.reload();
		alert("Form Saved.");
		location.href="admin_updateskillsStrengths.php?userid=<?php echo $userid?>";
	</script>
<?php		
		//header("location:admin_updateskillsStrengths.php?userid=$userid");
	}

}

?>