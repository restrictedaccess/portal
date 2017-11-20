<?php
// from : languages.php
include 'config.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf.php') ;

if(!$_SESSION['admin_id'])
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:/portal/");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

//$userid=$_SESSION['userid'];
$userid = @$_GET["userid"];

//$userid=$_REQUEST['userid'];
$language=$_REQUEST['language'];
$spoken=$_REQUEST['spoken'];
$written=$_REQUEST['written'];

if(isset($_POST['Add']))
{	
	// language
	// id, userid, language, spoken, written
	//$query="INSERT INTO language (userid, language, spoken, written) VALUES ($userid, '$language', $spoken, $written)";
	//$result=mysql_query($query);
	$result = $db->insert("language",array("userid"=>$userid,
					"language"=>$language,
					"spoken"=>$spoken,
					"written"=>$written));
	if (!$result)
	{
		$mess="Error";
		header("location:updatelanguages.php?mess=$mess");
	}
	else
	{	
		//$queryUpdate ="UPDATE personal SET dateupdated='$ATZ ' WHERE userid = $userid;";
		//mysql_query($queryUpdate);
		$queryUpdate = $db->update("personal", array("dateupdated"=>$ATZ),
		$db ->quoteInto("userid =?",$userid));
		//START: insert staff history
		include('lib/staff_history.php');
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'LANGUAGES', 'INSERT', '');
		//ENDED: insert staff history		
?>
	<script language="javascript">
		alert("Form Saved.");
		var userid = "<?php echo $userid; ?>";
		window.location.href="/portal/admin_updatelanguages.php?userid="+ userid;
	</script>
<?php		
		header("location:/portal/admin_updatelanguages.php?userid=$userid");
	}
}

?>