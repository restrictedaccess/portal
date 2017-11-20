<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$userid = $_REQUEST['userid'];

$query="SELECT CONCAT(fname,' ',lname),image FROM personal WHERE userid = $userid;";
$result = mysql_query($query);
list($staff_name,$image)=mysql_fetch_array($result);
?>

<div style="background:#FFFFFF; border:#999999 solid 1px; padding:5px;">
<div style="font:bold 7pt verdana; color:#CCCCCC; margin-bottom:5px;"><?=$staff_name;?></div>
<? //=$image;?>
<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>"  />
</div>