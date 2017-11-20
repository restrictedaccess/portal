<?
include '../config.php';
include '../conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	$query = "SELECT * FROM admin a WHERE admin_id = $admin_id;";
	$data = mysql_query($query);
	$row = mysql_fetch_array($data);
	$from = $row['admin_email'];
	$posted_by = "ADMIN ".$row['admin_fname'] ." ".$row['admin_lname'];
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
	$query = "SELECT * FROM agent a WHERE agent_no = $agent_no;";
	$data = mysql_query($query);
	$row = mysql_fetch_array($data);
	$from = $row['email'];
	$posted_by = "Business Partner ".$row['fname'] ." ".$row['lname'];
}

$id = $_REQUEST['quote_id'];

$query = "UPDATE quote SET status = 'posted' , date_posted = '$ATZ'  WHERE id = $id;";
//echo $query;
$result =mysql_query($query);
if(!$result) die ("Error in sql script .". $query);

// Send it to the Client
$query = "SELECT q.quote_no, DATE_FORMAT(date_quoted,'%D %b %Y'),CONCAT(l.fname,' ',l.lname) , l.email,l.company_name
		,q.created_by, q.created_by_type , DATE_FORMAT(q.date_posted,'%D %b %Y') , l.company_address , q.status
		FROM quote q
		LEFT JOIN leads l ON l.id = q.leads_id
		WHERE q.id =  $id;";
$result = mysql_query($query);
//echo $query;
list($quote_no,$date,$leads_name,$email,$company_name,$by, $by_type , $date_posted , $company_address , $status  )=mysql_fetch_array($result);

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
function getCreatorEmail($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$email = $row['email'];
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$email = $row['admin_email'];
	}
	else{
		$email="";
	}
	return $email;
	
}


$name = getCreator($by , $by_type);
$company_name ? $company_name : '&nbsp;';
$company_address ? $company_address : '&nbsp;';
$date_posted ? $date_posted : '&nbsp;';


//Quote Details
$sql = "SELECT id , work_position ,client_timezone ,working_hours, days, quoted_price, work_status, currency, work_description, lunch_hour, currency_fee, gst , quoted_quote_range  FROM quote_details q WHERE quote_id = $id;";
$data = mysql_query($sql);
$counter=0;
while(list($quote_details_id , $work_position ,$client_timezone ,$working_hours, $days, $quoted_price, $work_status, $currency, $work_description , $lunch_hour ,
$currency_fee, $gst , $quoted_quote_range )=mysql_fetch_array($data))
{
	$counter++;
	if($currency == "AUD"){
	$currency_txt = "Sub-Contractor Salary in Australian Dollar (AUD)";
	$currency_symbol = "\$ ";
	}
	
	if($currency == "USD"){
		$currency_txt = "Sub-Contractor Salary in United States Dollar (USD)";
		$currency_symbol = "\$ ";
	}
	
	if($currency == "POUND"){
		$currency_txt = "Sub-Contractor Salary in United Kingdom Pounds (POUNDs)";
		$currency_symbol = "&pound; ";
	}
	$yearly = $quoted_price * 12;
	$weekly = $yearly / 52;
	$daily = $weekly / $days;
	$hourly = $daily / $working_hours;
	
	if ($gst > 0) {
		$gstSTR = "	<p ><label style='width:122px; text-align:right; padding-right:10px; '><b>+ GST </b></label>
					<span style='float:left; text-align:right; width:100px;'>".$currency_symbol.number_format($gst,2,'.',',')."</span>
					<div style='clear:both;'></div>
					</p>";
	}else{
		$gstSTR="";
	}
	
	//if($quoted_quote_range!=""){
	//}
	
	if ($work_description!="") {
		$work_description ="<div style='color:#999999; margin-top:5px;'><b>Descriptions :</b> <i>".$work_description."</i></div>";
	} 
	$details.="
	<div style=' border:#333333 solid 1px; padding:5px; margin-bottom:15px;'>
	<div style='color:#FF0000;'><b>Sub-Contractor ".$counter."</b></div>
	<div style='padding:5px;'>
		<div style='float:left; color:#000066;'><b>Job Title : ".$work_position."</b></div>
		<div style='float:right;'>".$currency_txt."</div>
		<div style='clear:both;'></div>
		".$work_description."
	</div>
	<hr />
	<div>
		<div style='float:left; display:block; width:350px;'>
			<p style='margin-bottom:5px; margin-top:5px;'>".$work_status."</p>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:100px;'>Client Timezone : </label>".$client_timezone."</p>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:100px;'>Working Hours : </label>".$working_hours."</p>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:100px;'>Days Per Week :</label>".$days."</p>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:100px;'>Lunch Hour :</label>".$lunch_hour."</p>
			
		</div>
		<div style='float:left; display:block;width:300px; '>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'>Yearly :</label> ".$currency_symbol.number_format($yearly,2,'.',',')."</p>
			<p style='margin-bottom:5px; margin-top:5px;background:#FFFFCC;'><b><label style='float:left; display:block; width:70px;'>Monthly : </label>".$currency_symbol.number_format($quoted_price,2,'.',',')."</b></p>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'>Weekly : </label>".$currency_symbol.number_format($weekly,2,'.',',')."</p>
			<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'>Daily : </label>".$currency_symbol.number_format($daily,2,'.',',')."</p>
			<p style='margin-bottom:5px; margin-top:5px;background:#FFFFCC;'><b><label style='float:left; display:block; width:70px;'>Hourly :</label> ".$currency_symbol.number_format($hourly,2,'.',',')."</b></p>
		</div>
		
		
	<div style='clear:both;'></div>
	</div>
	<div style='padding:7px; text-align:center;'><u>
		<b>Monthly Quoted Price  ".$currency_symbol.number_format($quoted_price,2,'.',',')." 
		+ GST  ".$currency_symbol.number_format($gst,2,'.',',')."
		=  ".$currency_symbol.number_format(($quoted_price+$gst),2,'.',',')."
		</b>
		</u>
	</div>";
	
	
	
	$details.="<div style='margin-top:10px;padding:5px; '><b>Notes</b></div>";
	$sqlNotes = "SELECT id, notes , created_by, created_by_type FROM quote_notes WHERE quote_id = $id AND quote_details_id = $quote_details_id ORDER BY id DESC;";
	$dataNotes = mysql_query($sqlNotes);
	while(list($note_id, $notes , $created_by, $created_by_type)=mysql_fetch_array($dataNotes))
	{
		$creatorNotes = getCreator($created_by , $created_by_type);
		$details.="<div style='margin-top:10px; border-bottom:#E9E9E9 solid 1px;'><div><i>".$notes."</i></div><small style='color:#999999 ; font:10px Tahoma;'>- ".$creatorNotes."</small></div>";
	}
	$details.="</div>";
	
}


$body = "<div style='display:block; width:700px; font:12px Arial; border:#999999 solid 1px;'>
<div style='padding:10px;'>
	<div style='float:left; display:block; width:300px;'>
		<div><img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='267' height='91' /></div>
		<div style='margin-top:10px; padding:5px;'>
		PO Box 1211 Double Bay NSW Australia 1360<br />
		PH: 02 9016 4461<br />
		Fax: +61 2 8088 7247<br />
		Email: ".getCreatorEmail($by , $by_type)."</div>
	</div>	
	
	<div style='float:right; display:block; width:300px; margin-left:0px;'>
		<div><img src='http://remotestaff.com.au/portal/images/think_innovation.jpg' width='267' height='91' /></div>
		<div style='margin-top:10px; padding:5px;'>
		Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
		Website: www.remotestaff.com.au</div>	
	</div>
	<div style='clear:both;'></div>
</div>
<div style='margin-top:10px; text-align:center; font:bold 14px Arial;'>QUOTE NO. ".$quote_no."</div>
<div style='background:#E9E9E9; border:#E9E9E9 outset 1px; padding:5px; margin-top:10px;'><B>Client</B></div>
<div style='padding:5px;'>
	<div style='float:left; width:400px;'>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'><b>Leads :</b></label>".strtoupper($leads_name)."</p>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'><b>Email : </b></label>".$email."</p>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'><b>Company :</b></label>".$company_name."</p>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:70px;'><b>Address :</b></label>".$company_address."</p>
	</div>
	<div style='float:left;'>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:80px;'><b>Quoted By: </b></label><b style='color:#990000;'>".getCreator($by , $by_type)."</b></p>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:80px;'><b>Quote Date :</b></label> ".$date."</p>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:80px;'><b>Quote No.</b></label>".$quote_no."</p>
		<p style='margin-bottom:5px; margin-top:5px;'><label style='float:left; display:block; width:80px;'><b>Date Posted</b></label><span id='date_posted'>".$date_posted."</span></p>		</div>	
	<div style='clear:both;'></div>	
	</div>
	
	
	
	
<div style='background:#D2FFD2 ;border:#D2FFD2 outset 1px; padding:5px; margin-top:10px;'><B>QUOTE DETAILS</B></div>
<div>".$details."</div>
<p style='color:#999999; text-align:center; margin-top:50px;'>Quotes are best guess indication and may vary depending on the offshore labour market conditions in any given month.</p>
</div>";

$subject = "RemoteStaff.Com.Au Quote # ".$quote_no;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";	
$headers .= 'Bcc: chrisj@remotestaff.com.au,ricag@remotestaff.com.au,normanm@remotestaff.com.au' . "\r\n";

$to =$email;
mail($to,$subject, $body, $headers);
//echo $body;
echo $id;

?>
