<?

include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];


if($_SESSION['admin_id']==NULL)
{
	die("Session Expired. Please Logout then try to re-login again.");
}


$recruitment_candidates_id = $_REQUEST['recruitment_candidates_id'];
$ratings = $_REQUEST['ratings'];

$query = "UPDATE recruitment_candidates SET ratings = '$ratings' WHERE recruitment_candidates_id = $recruitment_candidates_id;";
mysql_query($query);


$query="SELECT ratings FROM recruitment_candidates WHERE recruitment_candidates_id = $recruitment_candidates_id;";
$result = mysql_query($query);
list($ratings)=mysql_fetch_array($result);
if($ratings > 0){
	for($i=0;$i<$ratings;$i++){
		$str.="<img src=\"images/star.png\">";
	}
	echo $str;
}

?>