<?
//from reserve_staff.php

include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

//userid , admin_subcon_note_txt

$userid=$_REQUEST['userid'];
$admin_subcon_note_txt=$_REQUEST['admin_subcon_note_txt'];
$admin_subcon_note_txt=filterfield($admin_subcon_note_txt);

if(isset($_POST['add_note']))
{
	
	//echo $userid."<br><br>".$admin_subcon_note_txt;
	//SELECT * FROM admin_subcon_notes a;
	// id, userid, admin_subcon_note_txt, date_created, admin_id
	$sqlInsert="INSERT INTO admin_subcon_notes SET userid = $userid, 
				admin_subcon_note_txt = '$admin_subcon_note_txt',
				date_created = '$ATZ',
				admin_id = $admin_id;";
	//echo $sqlInsert;
	$result = mysql_query($sqlInsert);
	if(!$result){
		echo ("Query: $sqlInsert\n<br />MySQL Error: " . mysql_error());				
	}
	else
	{
		header("location:reserve_staff.php");
	}	
}


if(isset($_POST['add_note2']))
{
	
	//echo $userid."<br><br>".$admin_subcon_note_txt;
	//SELECT * FROM admin_subcon_notes a;
	// id, userid, admin_subcon_note_txt, date_created, admin_id
	$sqlInsert="INSERT INTO admin_subcon_notes SET userid = $userid, 
				admin_subcon_note_txt = '$admin_subcon_note_txt',
				date_created = '$ATZ',
				admin_id = $admin_id;";
	//echo $sqlInsert;
	$result = mysql_query($sqlInsert);
	if(!$result){
		echo ("Query: $sqlInsert\n<br />MySQL Error: " . mysql_error());				
	}
	else
	{
		header("location:inactive_subconlist.php");
	}	
}



?>