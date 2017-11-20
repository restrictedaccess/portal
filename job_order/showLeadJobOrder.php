<?
include "../config.php";
include "../conf.php";
include "../function.php";

//Check random character if existing in the table quote 
function CheckRan($ran,$table){
	$query = "SELECT * FROM $table WHERE ran = '$ran';";
	$result =  mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
		// The random character is existing in the table
		$ran = get_rand_id();
		return $ran;
	}else{
		return $ran;
	}
}
function getCreator($id,$type){
	if($type == 'agent')
	{
		$query = "SELECT fname,work_status,lname FROM agent a WHERE agent_no = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row[1]." :".$row[0]." ".$row[2];
	}
	else if($type == 'admin')
	{
		$query = "SELECT admin_fname , admin_lname FROM admin a WHERE admin_id = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".$row[0]." ".$row[1];
	}
	else{
		$name="";
	}
	return $name;
}



$leads_id = $_REQUEST['leads_id'];
$sql = "SELECT CONCAT(l.fname,' ',l.lname) ,l.email FROM leads l WHERE id = $leads_id;";
//echo $sql;
$data = mysql_query($sql);
list($client_name,$email) = mysql_fetch_array($data);
echo "<div style='background:#333333; color:#FFFFFF; font:bold 12px Arial; padding:5px; '>
	<div style='float:left;'>JOB ORDER REQUEST OF ".strtoupper($client_name)."</div>
	<div style='float:right; margin-right:10px;'>".$email."</div>
	<div style=' clear:both;'></div>
</div>";



//job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type
$query = "SELECT job_order_id, created_by_id, created_by_type, status,DATE_FORMAT(j.date_posted,'%D %b %y') , response_by_id, response_by_type , form_filled_up, DATE_FORMAT(j.date_filled_up,'%D %b %y') ,j.ran FROM job_order j WHERE leads_id = $leads_id;";
//echo $query;
$result = mysql_query($query);



while(list($job_order_id, $created_by_id, $created_by_type, $status, $date_posted, $response_by_id, $response_by_type , $form_filled_up, $date_filled_up ,$ran)=mysql_fetch_array($result))
{

	if($ran==""  or $ran==NULL){
		$ran = get_rand_id();
		$ran = CheckRan($ran,'job_order');
		$sql = "UPDATE job_order SET ran = '$ran' WHERE job_order_id = $job_order_id;";
		mysql_query($sql);
	}
	
	
	
	$queryJobForms = "SELECT j.job_order_form_id,f.job_order_form_title 
					FROM job_order_list j LEFT JOIN  job_order_form f ON f.job_order_form_id = j.job_order_form_id 
					WHERE job_order_id = $job_order_id AND j.job_order_form_status = 'finished';";
	$data = mysql_query($queryJobForms);
	$details="";
		while(list($job_order_form_id,$job_order_form_title)=mysql_fetch_array($data))
		{
			$details.="<li>".$job_order_form_title."</li>";
				
		}
	
	if($form_filled_up == "yes")
	{
		$status = "<img src='./images/hot.gif' align = 'absmiddle' />&nbsp;&nbsp;$date_filled_up";
		$disabled = " ";
	}
	else
	{
		$status = "Date Given : &nbsp;$date_posted";
		$disabled = 'disabled="disabled"';
	}	
		
	?>
		
		<div style="border-bottom:#999999 solid 1px;">
			<div style="padding:5px;">
				<div style="float:left;"><b>Job Order # <?=$job_order_id;?></b></div>
				<div style="float:left; margin-left:10px; FONT: bold 7.5pt verdana; COLOR: #676767;"><?=$status;?></div>
				<div style="float:right"><input type="button" value="view" class="bttn" onclick="javascript:popup_win('./pdf_report/job_order_form/?ran=<?=$ran;?>',1280,500)"  />
				<input type="button" <?=$disabled;?> value="process" class="bttn" onClick="self.location='admin_recruitment_summary.php?leads_id=<? echo $leads_id;?>'"  /></div>
				<div style="clear:both;"></div>
			</div>
			<div style="padding:5px; color:#666666;">Created By : <?=getCreator($created_by_id, $created_by_type);?></div>
			
			<div style="padding:5px;">
			<? 
			if(mysql_num_rows($data) > 0){
				echo "<ol><b>Details</b>";
				echo $details;	
				echo "</ol>";
			}else{
				echo "<i style='color:#999999;'>Waiting for the Lead / Client to fill up one of the Job Forms</i>..";
			}
			?>
			</div>
		</div>
	<?
	
}
?>


