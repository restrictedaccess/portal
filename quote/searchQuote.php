<?php

include '../config.php';
include '../conf.php';


$keyword=$_REQUEST['keyword'];

if($keyword!=""){
$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
# create a MySQL REGEXP for the search: 
$regexp = "REGEXP '^.*($search).*\$'"; 
$keyword_search = " WHERE (
				q.quote_no $regexp
				OR UPPER(q.status) $regexp 
				OR UPPER(l.lname) $regexp 
				OR UPPER(l.fname) $regexp 
				OR UPPER(l.email) $regexp 
				) ";
}				
				
				

$query = "SELECT q.id , CONCAT(l.fname,' ',l.lname) ,created_by,created_by_type,q.status , q.quote_no FROM quote q LEFT JOIN leads l ON l.id = q.leads_id  $keyword_search   ORDER BY date_quoted DESC;";


function getCreator($by , $by_type)
{
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row['work_status']." ".$row['fname'] ." ".$row['lname'];
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "ADMIN ".$row['admin_fname'] ." ".$row['admin_lname'];
	}
	else{
		$name="";
	}
	return $name;
	
}

//echo $query;
$result = mysql_query($query);
if(!$result) die("Error in sql script ".$query);
$counter1=0;
$counter2=0;
$draft="";
$posted="";
while(list($id,$leads,$by, $by_type , $status , $quote_no)=mysql_fetch_array($result))
{
	
	//'new' , 'posted'
	if($status == 'new'){
		$counter1++;
		$draft.="<div style='padding:5px; border-bottom:#CCCCCC solid 1px;' onmouseover='highlight(this);' onmouseout='unhighlight(this);' onclick=showTemplate(".$id.");>
		<div style='float:left; display:block; width:30px;'><b>".$counter1."</b></div>
		<div style='float:left; display:block; width:180px;'>#".$quote_no." ".$leads."</div>
		<div style='clear:both;'></div>
		<small style='color:#999999;'>- ".getCreator($by , $by_type)."</small>
	</div>";
	}
	
	if($status == 'posted'){
		$counter2++;
		$posted.="<div style='padding:5px; border-bottom:#CCCCCC solid 1px;' onmouseover='highlight(this);' onmouseout='unhighlight(this);' onclick=showTemplate(".$id.");>
		<div style='float:left; display:block; width:30px;'><b>".$counter2."</b></div>
		<div style='float:left; display:block; width:180px;'>#".$quote_no." ".$leads."</div>
		<div style='clear:both;'></div>
		<small style='color:#999999;'>- ".getCreator($by , $by_type)."</small>
	</div>";
	}
	
}
?>
<div style="background:#333333; color:#FFFFFF;"><b>DRAFT</b></div>
<div class ='scroll'><?php echo $draft;?></div>
<div style="background:#333333; color:#FFFFFF;"><b>POSTED</b></div>
<div class ='scroll'><?php echo $posted;?></div>


