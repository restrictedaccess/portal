<?
// from apply.php
include 'config.php';
include 'conf.php';

$posting_id=$_REQUEST['postingid'];
$userid=$_REQUEST['userid'];

///// CHECK THE USER IF HE ALREADY APPLIED THE JOB POSTING //////
$query="SELECT * FROM applicants WHERE posting_id=$posting_id AND userid=$userid;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$mess= "YOUVE ALREADY APPLIED FOR THIS JOB";
	//$mess=str_replace(" ","%20",$mess);
	header("location:jobs.php?code=1&job=$posting_id");
}
else
{
	// id, posting_id, userid, status, date_apply
	$query="INSERT INTO applicants (posting_id, userid, status, date_apply) VALUES ( $posting_id, $userid,'Unprocessed',NOW());";
	//echo $query;
	$result=mysql_query($query);
	if (!$result)
	{
		echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	}
	else
	{
		//header("location:thankyou2.php");
		//$mess= "THANK YOU FOR APPLYING PLEASE WAIT FOR FURTHER NOTICE FROM US !";
		//$mess=str_replace(" ","%20",$mess);
		header("location:jobs.php?code=2&job=$posting_id");
		
	}
	
} 


?>