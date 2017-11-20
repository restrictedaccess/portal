<?
include "../config.php";
include "../conf.php";

$leads_id = $_REQUEST['leads_id'];
$keyword = $_REQUEST['keyword'];
echo $keyword;

if($leads_id==0){
	$leads_Search = " ";
}else{
	$leads_Search = " WHERE j.leads_id = $leads_id ";
}	

/*
job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type, form_filled_up, date_filled_up

$query = "SELECT DISTINCT(j.leads_id),CONCAT(l.fname,' ',l.lname),DATE_FORMAT(l.timestamp,'%D %b %Y')
				FROM job_order j  LEFT JOIN leads l ON l.id = j.leads_id  $leads_Search;";	
*/
//DATE_FORMAT(j.date_posted,'%D %b %y') ,
$query = "SELECT  DISTINCT(j.leads_id),CONCAT(l.fname,' ',l.lname), form_filled_up , DATE_FORMAT(j.date_filled_up,'%D %b %y')
FROM job_order j  LEFT JOIN leads l ON l.id = j.leads_id  $leads_Search ";					
//echo $query;			
$result = mysql_query($query);
$counter = 0;
$counter2 =0;
$details="";
$without_details="";
while(list($leads_id,$leads_name,$form_filled_up, $date_filled_up)=mysql_fetch_array($result))
{
	
	if($form_filled_up == "yes")
	{
		$counter++;
		$details.="<div style=' border-bottom:#CCCCCC solid 1px;'>
			<div style='float:left; display:block; line-height:20px; width:35px;'>".$counter." )</div>
			<div style='float:left; display:block; '>
			<a href='javascript:showLeadJobOrder($leads_id);' style='display:block; text-decoration:none; width:210px; line-height:20px; '>
				".$leads_name."
			</a>	
			<div style='FONT: bold 7.5pt verdana; COLOR: #676767;'>Date Filled Up : ".$date_filled_up."</div>
			</div>
			
			<div style='clear:both;'></div>
		</div>";
	}else{
		$counter2++;
		$without_details.="<div style=' border-bottom:#CCCCCC solid 1px;'>
			<div style='float:left; display:block; line-height:20px; width:35px;'>".$counter2." )</div>
			<div style='float:left; display:block;  '>
			<a href='javascript:showLeadJobOrder($leads_id);' style='display:block; text-decoration:none; width:210px; line-height:20px; '>
				".$leads_name."
			</a>	
			</div>
			
			<div style='clear:both;'></div>
		</div>";
	}
	
}


?>
<div style="background:#333333; color:#FFFFFF; padding:5px;"><b>Job Form/s Filled Up</b></div>
<div style="height:250px; overflow:auto; display:block;">
<?=$details;?>
</div>
<div style="background:#333333; color:#FFFFFF; padding:5px;"><b>Job Form/s Blank</b></div>
<div style="height:250px; overflow:auto; display:block;">
<?=$without_details;?>
</div>