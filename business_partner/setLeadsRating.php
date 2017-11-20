<?
include '../config.php';
include '../conf.php';
include '../function.php';
include '../time.php';
include('../AgentCurlMailSender.php');

$agent_no = $_SESSION['agent_no'];
$rating = $_REQUEST['rating'];
$leads_id=$_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}
//echo $rating;
$query="UPDATE leads SET rating='$rating' WHERE id=$leads_id;";
mysql_query ($query) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());


$query2 ="SELECT rating FROM leads WHERE id = $leads_id;";

$result2=mysql_query($query2);
list($rate) = mysql_fetch_array($result2);
if($rate=="1")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}

echo $rate ? $rate : '&nbsp;';		


?>