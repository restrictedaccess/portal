<?
// from : support.php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'class.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if(isset($_POST['send']))
{


$subject=$_REQUEST['subject'];
$message=$_REQUEST['message'];
$pass        = $_REQUEST['pass'];
$passGen = new passGen(5);

$rv = $_POST['rv'];
$pass = $_POST['pass'];

if($passGen->verify($pass, $rv)){
		$status = 1;  //image validator is correct!
	}
	else 
	{
		$status = 2;
		header("location:support.php?mess=2"); // image validator is not correct!
	}

//echo $status;

if($status == 1)
{

	//$body ="SUBJECT : ".$subject ."<br>".
	//  "MESSAGE : ".$message."<br>";
	//	echo $body;
	//id, subject, message, status, date
	$query="INSERT INTO questions SET subject = '$subject', message = '$message', status = 'NEW', date = '$ATZ';";
	$result=mysql_query($query);
	$id = mysql_insert_id();
	if(!$result)
	{
		echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	}
	else
	{
	/////SEND EMAIL TO THE ADMIN /////////////////////////////////////
		$from="normanm@remotestaff.com.au";
		$to = "normaneil007@yahoo.com";
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";	
		$body="<html>
<head>
<title>RemoteStaff.Com.Au</title>
<style>
body{font-family:Tahoma; font-size:14px;}
.message{margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;}

</style>
</head>

<body>
<table style=' border:#FFFFFF solid 1px;' width='100%'>
		<tr><td><img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'></td></tr>
		<tr><td width='100%' valign='top'><hr style='border:#99CC66 solid 1px;'></td></tr>
		<tr><td height='105' width='100%' valign='top'>
<form method='POST' name='form' action='http://www.remotestaff.com.au/portal/replyphp.php'>
<input type='hidden' name='id' value='$id'>
		<p class='message' align='justify'>
		<b>Question/Concern:</b><ul>".$message."</ul>
		</p>
		<p class='message' align='justify'>
		<b>Message :</b> <font color='#999999'>(Type Your Reply Here)</font>
<p align='center' style='margin-bottom:3px; margin-top:3px;'>
<textarea name='message' cols='50' rows='5' wrap='physical' class='text'  style='width:90%'></textarea>
</p>
		</p>
<p align='center'>
<input type='submit' name='answer' value='Post Reply'>&nbsp;<input type='submit' name='delete' value='Delete'>
</p>
</form>
		</td></tr>
		<tr><td height='28' background='http://www.remotestaff.com.au/portal/images/banner/remote.jpg'>&nbsp;</td></tr>
		</table>
</body>
</html>";
		
		mail($to,'MESSAGE FROM IT-SUPPORT HELP DESK',$body,$header);
	////////////////////////////////////////////////////////////////////
	//echo $body;
	header("location:support.php?mess=3"); // image validator is not correct!
	}
	
	
}

}
?>
