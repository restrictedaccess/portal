<?
// from : skillStrengths.php
include 'config.php';
include 'function.php';
include 'conf.php';
$userid=$_SESSION['userid'];

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
		header("location:skillsStrengths.php?mess=$mess");
	}
	else
	{
		header("location:skillsStrengths.php");
	}

}

if(isset($_POST['Next']))
{
	//echo "Next";
	if($skill!="")
	{
		$query="INSERT INTO skills (userid, skill, experience, proficiency) VALUE ($userid, '$skill', $experience, $proficiency);";
		//echo $query;
		$result=mysql_query($query);
		if (!$result)
		{
			$mess="Error";
			header("location:skillsStrengths.php?mess=$mess");
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
// to : --> languages.php
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
<form action="languages.php" name="form" method="POST">
<input type="hidden" name="userid" value="<? echo $userid;?>" />
<input type="hidden" name="mess" value="<? echo $mess;?>" />
</form>	 
 <!-- -->
</body>
</html>