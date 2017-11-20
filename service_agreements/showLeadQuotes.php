<?php
include '../config.php';
include '../conf.php';


$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

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
$query = "SELECT q.id , CONCAT(l.fname,' ',l.lname) ,created_by,created_by_type,quote_no,q.status FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status = 'new'   $leadsCondition   ORDER BY date_quoted DESC;";

//echo $query;

$query2 = "SELECT q.id , CONCAT(l.fname,' ',l.lname),DATE_FORMAT(q.date_posted,'%D %b %y'),created_by,created_by_type,quote_no,q.status FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status = 'posted'  $leadsCondition   ORDER BY date_quoted DESC;";

//echo $query;
function getCreator($by , $by_type)
{
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$data = mysqli_query($link2, $query);
		$row = mysqli_fetch_array($data);
		$name = $row['work_status']." ".$row['fname'] ." ".$row['lname'];
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$data = mysqli_query($link2, $query);
		$row = mysqli_fetch_array($data);
		$name = "ADMIN ".$row['admin_fname'] ." ".$row['admin_lname'];
	}
	else{
		$name="";
	}
	return $name;
	
}



$result = mysqli_query($link2, $query);
if(!$result) die("Error in sql script ".$query);
$counter=0;
echo '<div style="background:#333333; color:#FFFFFF;"><b>QUOTES LIST</b></div>';
echo "<div class ='scroll'>";
while(list($id,$leads,$by, $by_type,$quote_no,$status)=mysqli_fetch_array($result))
{
	$counter++;
?>
	<div style="padding:5px; border-bottom:#CCCCCC solid 1px;" onmouseover="highlight(this);" onmouseout="unhighlight(this);" onclick="showQuote(<?php echo $id;?>);">
		<div style="float:left; display:block; width:20px;"><b><?php echo $counter;?>)</b></div>
		<div style="float:left; display:block; "><?php echo "Quote # ".$quote_no." ".$leads;?></div>
		<div style="clear:both;"></div>
			<div>
				<div style="float:left;">
					<small style="color:#999999;">- <?php echo getCreator($by , $by_type);?></small>
				</div>
				<div style="float:right;">
					<small style="color:#999999;"><?php echo strtoupper($status);?></small>
				</div>
				<div style="clear:both;"></div>
			</div>
	</div>
<?php	
}
//echo "&nbsp;</div>";
//echo '<div style="background:#333333; color:#FFFFFF;"><b>POSTED</b></div>';
//echo "<div class ='scroll'>";
$data = mysqli_query($link2, $query2);
if(!$data) die("Error in sql script ".$query2);
//$counter=0;
while(list($id,$leads,$posted_date,$by, $by_type,$quote_no,$status)=mysqli_fetch_array($data))
{
	$counter++;
?>
	<div style="padding:5px; border-bottom:#CCCCCC solid 1px;" onmouseover="highlight(this);" onmouseout="unhighlight(this);" onclick="showQuote(<?php echo $id;?>);">
		<div style="float:left; display:block; width:20px;"><b><?php echo $counter;?>)</b></div>
		<div style="float:left; display:block; "><?php echo "Quote # ".$quote_no." ".$leads;?></div>
		<div style="float:right; display:block; color:#999999;"><small><?php echo $posted_date;?></small></div>
		<div style="clear:both;"></div>
			<div>
				<div style="float:left;">
					<small style="color:#999999;">- <?php echo getCreator($by , $by_type);?></small>
				</div>
				<div style="float:right;">
					<small style="color:#999999;"><?php echo strtoupper($status);?></small>
				</div>
				<div style="clear:both;"></div>
			</div>
	</div>
<?php	
}

echo "&nbsp;</div>";
echo '<div style="background:#333333; color:#FFFFFF;"><b>SERVICE AGREEMENT</b></div>';
echo "<div class ='scroll'>";
//Fetch all service agreement
// SELECT * FROM service_agreement s 
/*
$sqlServiceAgreement="SELECT service_agreement_id, created_by, created_by_type, s.status,CONCAT(l.fname,' ',l.lname) 
					   FROM service_agreement s JOIN leads l ON l.id = s.leads_id
					   $leadsCondition2
					   ORDER BY s.status";
*/
$sqlServiceAgreement="SELECT service_agreement_id, s.created_by, s.created_by_type, s.status,CONCAT(l.fname,' ',l.lname),q.quote_no
						FROM service_agreement s
						JOIN leads l ON l.id = s.leads_id
						LEFT JOIN quote q ON q.id = s.quote_id
						 $leadsCondition2
						ORDER BY s.status";
//echo $sqlServiceAgreement;
$result=mysqli_query($link2, $sqlServiceAgreement);
$counter = 0;
while(list($service_agreement_id, $by, $by_type, $status,$leads,$quote_no)=mysqli_fetch_array($result))
{
	$counter++;
?>
	<div style="padding:5px; border-bottom:#CCCCCC solid 1px;" onmouseover="highlight(this);" onmouseout="unhighlight(this);" onclick="showServiceAgreement(<?php echo $service_agreement_id;?>);">
		<div style="float:left; display:block; width:20px;"><b><?php echo $counter;?>)</b></div>
		<div style="float:left; display:block; "><b><?php echo "Service Agreement # ".$service_agreement_id;?></b></div>
		<div style="float:right; display:block; color:#999999;">Quote Ref # <?php echo $quote_no;?></div>
		<div style="clear:both;"></div>
		<div><?php echo $leads;?></div>
			<div>
				<div style="float:left;">
					<small style="color:#999999;">- <?php echo getCreator($by , $by_type);?></small>
				</div>
				<div style="float:right;">
					<small style="color:#999999;"><?php echo strtoupper($status);?></small>
				</div>
				<div style="clear:both;"></div>
			</div>
	</div>  
<?php
}
echo "&nbsp;</div>";
?>
