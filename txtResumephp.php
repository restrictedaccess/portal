<?
// from : ---> txtResume.php
include 'config.php';
include 'function.php';
$userid=$_REQUEST['userid'];
//echo $userid;
$txt=$_REQUEST['txt'];
$txt = filterfield($txt);

$query="INSERT INTO txtresume (userid, txt) VALUES ($userid, '$txt')";
$result=mysql_query($query);
if (!$result)
{
	$mess="Error";
	header("location:txtResume.php?mess=$mess&userid=$userid");
}
else
{
	$mess="";
}

// to : ---> resume.php
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
<form action="resume.php" name="form" method="POST">
<input type="hidden" name="userid" value="<? echo $userid;?>" />
<input type="hidden" name="mess" value="<? echo $mess;?>" />
</form>	 
 <!-- -->
</body>
</html>