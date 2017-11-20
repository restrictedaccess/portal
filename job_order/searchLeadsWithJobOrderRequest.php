<?
include "../config.php";
include "../conf.php";

$keyword = $_REQUEST['keyword'];
//echo $keyword;

# convert to upper case, trim it, and replace spaces with "|": 
$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
# create a MySQL REGEXP for the search: 
$regexp = "REGEXP '^.*($search).*\$'"; 

$keyword_search = " WHERE 
				 UPPER(l.lname) $regexp 
				OR UPPER(l.fname) $regexp 
				OR UPPER(company_position) $regexp 
				OR UPPER(company_name) $regexp 
				OR UPPER(company_address) $regexp 
				OR UPPER(l.email) $regexp 
				";
//DATE_FORMAT(j.date_posted,'%D %b %y') ,
$query = "SELECT  DISTINCT(j.leads_id),CONCAT(l.fname,' ',l.lname), form_filled_up , DATE_FORMAT(j.date_filled_up,'%D %b %y')
FROM job_order j  LEFT JOIN leads l ON l.id = j.leads_id  $keyword_search ";	

//echo $query;
$result = mysql_query($query);
$counter = 0;
$counter2 =0;
$details="";
$without_details="";
while(list($leads_id,$leads_name, $form_filled_up, $date_filled_up)=mysql_fetch_array($result))
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

