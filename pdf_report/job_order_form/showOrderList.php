<?
include '../../config.php';
include '../../conf.php';
include '../../function.php';


$job_order_id =$_REQUEST['job_order_id'];  



// job_order_form_id, job_order_form_title, job_order_form_desc
$query = "SELECT f.job_order_form_id, f.job_order_form_title
			FROM job_order_form f
			LEFT JOIN job_order_list l ON l.job_order_form_id = f.job_order_form_id
			WHERE l.job_order_id = $job_order_id
			AND l.job_order_form_status = 'finished'";
$result	= mysql_query($query);	
$counter = mysql_num_rows($result);
//echo "<i><b>Job Request list</b>";
if($counter > 0){
	//echo "<ol>";
	while(list($job_order_form_id, $job_order_form_title)=mysql_fetch_array($result))
	{
		$tab .=$job_order_form_id." ";
		//echo "<li>".$job_order_form_title;
	}	
	//echo "</ol>";
		
}
else{
	$tab = 0;
}
//echo "</i>";
?>
<div style="color:#999999;">
	<div style="float:left; width:100px; display:block;"><b>Legend : </b></div>
	<div style="float:left; width:20px; display:block; background:#FFFF00">&nbsp;</div>
	<div style="float:left;  display:block; margin-left:10px;">Yellow - Requested Job Forms</div>
	
</div>
<input type="hidden" id="tab" name="tab" value="<?=$tab;?>" /> 