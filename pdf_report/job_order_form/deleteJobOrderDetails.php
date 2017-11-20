<?
include '../../config.php';
include '../../conf.php';
include '../../function.php';


$job_order_id =$_REQUEST['job_order_id'];  
$job_order_form_id = $_REQUEST['job_order_form_id'];
$job_order_details_id = $_REQUEST['job_order_details_id'];

$groupings = $_REQUEST['groupings'];
$width = $_REQUEST['width'];
$width2 = 94;


// job_order_details_id, job_order_id, job_order_form_id, job_requirement, rating, groupings
$query = "DELETE FROM job_order_details WHERE job_order_details_id = $job_order_details_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script . : $query ");


$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = '$groupings';";
$result = mysql_query($query);
if(!$result) die("Error In Script . : $query ");
$num_rows = mysql_num_rows($result);
if($num_rows > 0) {
	while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
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
<?
	 }
 }else{
	echo '<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
			<div style="float:left; width:$widthpx; ">&nbsp;</div>
			<div style="float:left; width:$width2px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
			<div style="clear:both;"></div>
		</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
			<div style="float:left; width:$widthpx; ">&nbsp;</div>
			<div style="float:left; width:$width2px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
			<div style="clear:both;"></div>
		</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
			<div style="float:left; width:$widthpx; ">&nbsp;</div>
			<div style="float:left; width:$width2px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
			<div style="clear:both;"></div>
		</div>';			 	
 }	 

 ?>