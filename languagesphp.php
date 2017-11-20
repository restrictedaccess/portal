<?
// from : languages.php
include 'config.php';
include 'conf.php';
$userid=$_SESSION['userid'];

//$userid=$_REQUEST['userid'];
$language=$_REQUEST['language'];
$spoken=$_REQUEST['spoken'];
$written=$_REQUEST['written'];

if(isset($_POST['Add']))
{	
	// language
	// id, userid, language, spoken, written
	$query="INSERT INTO language (userid, language, spoken, written) VALUES ($userid, '$language', $spoken, $written)";
	$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:languages.php?mess=$mess");
	}
	else
	{
		header("location:languages.php");
	}
}

if(isset($_POST['Next']))
{
	if($language!=""){
	$query="INSERT INTO language (userid, language, spoken, written) VALUES ($userid, '$language', $spoken, $written)";
	$result=mysql_query($query);
	if (!$result)
	{
		$mess="Error";
		header("location:languages.php?mess=$mess");
	}
	else
	{
		$mess="";
	}
	}
	else
	{
		$mess="";
	}
}


// to : ---> uploadPhoto.php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript1.2">
function subLogin()
{
	if (document.form.mess.value=="")
	{
		document.form.submit();
	}	
}
</script>
</head>
<body onload=subLogin()><!-- onload=subLogin()-->
<!-- -->
<form action="uploadPhoto.php" name="form" method="POST">
<input type="hidden" name="userid" value="<? echo $userid;?>" />
<input type="hidden" name="mess" value="<? echo $mess;?>" />
</form>	 
 <!-- -->
</body>
</html>