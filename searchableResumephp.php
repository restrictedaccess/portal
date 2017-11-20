<?
//from :searchableResume.php
include 'config.php';
include 'function.php';

$userid=$_REQUEST['userid'];
$resume_title=$_REQUEST['resume_title'];
$activate=$_REQUEST['activate'];
$description=$_REQUEST['description'];

$resume_title=filterfield($resume_title);
$description=filterfield($description);

//echo $userid."<br>";
//echo $resume_title."<br>";
//echo $activate."<br>";
//echo $description."<br>";

/* $activate 
0 = "Hide MyResume From Search" 
1 = "Open MyResume For Search - Without Name & Contact Details"
3 = "Open MyResume For Search - With Name & Contact Details"
*/

/*
searchableresume
id, userid, resume_title, activate, description
*/
$query="INSERT INTO searchableresume (userid, resume_title, activate, description) VALUES ($userid, '$resume_title', $activate, '$description');";

//echo $query;

$result=mysql_query($query);
if (!$result)
{
	$mess="Error";
	//echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	header("location:searchableResume.php?mess=$mess&userid=$userid");
}
else
{
	//echo "Data Inserted";
	//header("location:education");
	$mess="";
}



// to: -->  skillsStrengths.php
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
<form action="skillsStrengths.php" name="form" method="POST">
<input type="hidden" name="userid" value="<? echo $userid;?>" />
<input type="hidden" name="mess" value="<? echo $mess;?>" />
</form>	 
 <!-- -->
</body>
</html>
