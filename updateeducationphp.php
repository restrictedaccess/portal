<?
// from: updateeducation.php
include 'conf.php';
include 'config.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$userid = $_SESSION['userid'];


if($_SESSION['userid']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}



$educationallevel=$_REQUEST['educationallevel'];
$fieldstudy=$_REQUEST['fieldstudy'];
$major=$_REQUEST['major'];
$grade=$_REQUEST['grade'];
$gpascore=$_REQUEST['gpascore'];
$college_name=$_REQUEST['college_name'];
$college_country=$_REQUEST['college_country'];
$graduate_month=$_REQUEST['graduate_month'];
$graduate_year=$_REQUEST['graduate_year'];

$major=filterfield($major);
$gpascore=filterfield($gpascore);
$college_name=filterfield($college_name);


/*
id, userid, educationallevel, fieldstudy, major, grade, gpascore, college_name, college_country, graduate_month, graduate_year
*/
$queryCheck="SELECT * FROM education WHERE userid=$userid;";
$res=mysql_query($queryCheck);
$ctr=@mysql_num_rows($res);
if ($ctr >0 )
{
$query="UPDATE education SET educationallevel = '$educationallevel', fieldstudy ='$fieldstudy', major ='$major', grade ='$grade', gpascore =$gpascore, college_name ='$college_name', college_country ='$college_country', graduate_month ='$graduate_month', graduate_year='$graduate_year' WHERE userid = $userid;";
}
else
{
$query="INSERT INTO education SET educationallevel = '$educationallevel', fieldstudy ='$fieldstudy', major ='$major', grade ='$grade', gpascore =$gpascore, college_name ='$college_name', college_country ='$college_country', graduate_month ='$graduate_month', graduate_year='$graduate_year' , userid = $userid;";
	
}

	
//echo $query;

$result=mysql_query($query);
if (!$result)
{
	$mess="Error";
	//echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	header("location:updateeducation.php?mess=$mess");
}
else
{
	//echo "Data Inserted";
	//header("location:education");
	$queryUpdate ="UPDATE personal SET dateupdated='$ATZ ' WHERE userid = $userid;";
	mysql_query($queryUpdate);
	$mess="";
	header("location:myresume.php");
}

//to: -> updatecurrentJob.php
?>

