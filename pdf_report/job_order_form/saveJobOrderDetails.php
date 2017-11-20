<?php
include '../../config.php';
include '../../conf.php';
include '../../function.php';


$job_order_id =$_REQUEST['job_order_id'];  
$job_order_form_id = $_REQUEST['job_order_form_id'];
$job_requirement = $_REQUEST['job_requirement'];
$rating = $_REQUEST['rating'];
$groupings = $_REQUEST['groupings'];
$width = $_REQUEST['width'];

$job_requirement = filterfield($job_requirement);

//echo $job_requirement;exit;

// job_order_details_id, job_order_id, job_order_form_id, job_requirement, rating, groupings
$query = "INSERT INTO job_order_details SET job_order_id = $job_order_id, job_order_form_id = $job_order_form_id, job_requirement = '$job_requirement', rating = $rating, groupings = '$groupings';";
//echo $query;exit;
$result = mysql_query($query);
if(!$result) die("Error In Script . : $query ");
$width2 =94;

$query = "SELECT job_order_details_id, job_requirement, rating , groupings FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = '$groupings';";
$result = mysql_query($query);
if(!$result) die("Error In Script . : $query ");

while(list($job_order_details_id, $job_requirement, $rating ,$groupings)=mysql_fetch_array($result))
{
	if($groupings=="time_sched"){
		$rating ="&nbsp;";
		$width2 = 50;
	}
?>
<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
	<div style="float:left; width:<?=$width;?>px; ">&nbsp;<?=$job_requirement;?></div>
	<div style="float:left; width:<?=$width2;?>px; border-left:#999999 solid 1px; text-align:center;">
		<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
		<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'<?=$groupings;?>',<?=$width;?>,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
	</div>
	<div style="clear:both;"></div>
</div>
<? } ?>