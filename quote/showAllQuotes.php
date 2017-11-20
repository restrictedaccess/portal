<?
include '../config.php';
include '../conf.php';


$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

//if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
//	die("ID is Missing.");
//}

$quote_no = $_REQUEST['quote_no'];
$agent_id = $_REQUEST['agent_id'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$leads = $_REQUEST['leads'];

//echo $leads."<br>";

// sql condition search by quote_no
if($quote_no!=NULL){
	$quoteCondition =" AND quote_no = $quote_no "; 
}else{
	$quoteCondition =""; 
}

// sql condition search by agent_id
if($agent_id=="0"){
	$agentCondition =" AND created_by_type = 'admin' "; 
}
else if($agent_id >0){
	$agentCondition =" AND created_by = $agent_id AND created_by_type = 'agent' "; 
}
else if($agent_id=="ALL"){
	$agentCondition =""; 
}
else{
	$agentCondition="";
}

// sql condition search by month created
if($month!=NULL){
	$monthCondition="AND MONTH(date_quoted) = '$month' AND YEAR(date_quoted)= '$year' ";
}else{
	$monthCondition="";
}

// sql condition search by leads
if($leads!=NULL){
	$leadsCondition=" AND leads_id = $leads ";
	$leadsCondition2=" WHERE s.leads_id = $leads ";
}else{
	$leadsCondition="";
}






// Setting the Quotes to be seen by Admin and Business Partner
$query = "SELECT q.id , CONCAT(l.fname,' ',l.lname) ,created_by,created_by_type FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status = 'new' $quoteCondition  $agentCondition  $monthCondition  $leadsCondition   ORDER BY date_quoted DESC;";

$query2 = "SELECT q.id , CONCAT(l.fname,' ',l.lname),DATE_FORMAT(q.date_posted,'%D %b %y'),created_by,created_by_type FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status = 'posted' $quoteCondition  $agentCondition  $monthCondition  $leadsCondition   ORDER BY date_quoted DESC;";

//echo $query;
/*
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	$query = "SELECT q.id , CONCAT(l.fname,' ',l.lname) FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status = 'new' ORDER BY date_quoted DESC;";
	$query2 = "SELECT q.id , CONCAT(l.fname,' ',l.lname),DATE_FORMAT(q.date_posted,'%D %b %y') FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status = 'posted' ORDER BY date_quoted DESC;";
	//echo $query2;
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
	$query = "SELECT q.id , CONCAT(l.fname,' ',l.lname) FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.created_by = $created_by AND q.created_by_type = '$created_by_type' AND q.status = 'new';";
	$query2 = "SELECT q.id , CONCAT(l.fname,' ',l.lname),DATE_FORMAT(q.date_posted,'%D %b %y') FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.created_by = $created_by AND q.created_by_type = '$created_by_type' AND q.status = 'posted';";
}
*/
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

echo $query;

$result = mysql_query($query);
if(!$result) die("Error in sql script ".$query);
$counter=0;
echo '<div style="background:#333333; color:#FFFFFF;"><b>DRAFT</b></div>';
echo "<div class ='scroll'>";
while(list($id,$leads,$by, $by_type)=mysql_fetch_array($result))
{
	$counter++;
?>
	<div style="padding:5px; border-bottom:#CCCCCC solid 1px;" onmouseover="highlight(this);" onmouseout="unhighlight(this);" onclick="showTemplate(<?=$id;?>);">
		<div style="float:left; display:block; width:20px;"><b><?=$counter;?>)</b></div>
		<div style="float:left; display:block; width:180px;"><?=$leads;?></div>
		<div style="clear:both;"></div>
		<small style="color:#999999;">- <?=getCreator($by , $by_type);?></small>
	</div>
<?	
}
echo "&nbsp;</div>";
echo '<div style="background:#333333; color:#FFFFFF;"><b>POSTED</b></div>';
echo "<div class ='scroll'>";
$data = mysql_query($query2);
if(!$data) die("Error in sql script ".$query2);
$counter=0;
while(list($id,$leads,$posted_date,$by, $by_type)=mysql_fetch_array($data))
{
	$counter++;
?>
	<div style="padding:5px; border-bottom:#CCCCCC solid 1px;" onmouseover="highlight(this);" onmouseout="unhighlight(this);" onclick="showTemplate(<?=$id;?>);">
		<div style="float:left; display:block; width:20px;"><b><?=$counter;?>)</b></div>
		<div style="float:left; display:block; width:170px; "><?=$leads;?></div>
		<div style="float:left; display:block; color:#999999;"><small><?=$posted_date;?></small></div>
		<div style="clear:both;"></div>
		<small style="color:#999999;">- <?=getCreator($by , $by_type);?></small>
	</div>
<?	
}

echo "&nbsp;</div>";
?>
