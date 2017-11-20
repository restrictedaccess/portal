<?php
die("This page is no longer in used.");
include '../../conf/zend_smarty_conf.php';
include '../../leads_information/AdminBPActionHistoryToLeads.php';

include '../../config.php';
include '../../conf.php';

$ran = $_REQUEST['ran'];
$queryCheckRan = "SELECT * FROM job_order j WHERE ran = '$ran';";
//echo $queryCheckRan;
$result =  mysql_query($queryCheckRan);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array($result);
	$job_order_id = $row['job_order_id'];
	$leads_id = $row['leads_id'];
}
else{
	die("Invalid Code");
}

//$job_order_id = $_REQUEST['job_order_id'];
//$leads_id = $_REQUEST['leads_id'];

if($job_order_id==NULL){
	die("Page Cannot be Displayed!");
}

if($leads_id==NULL){
	die("Page Cannot be Displayed!");
}

//echo "Job Order ID ".$job_order_id."<br>";
//echo "Leads ID ".$leads_id."<br>";
//echo "<div style='color:#CCCCCC;text-align:right;font:10px tahoma;'>Job Order ID ".$job_order_id."<br>Leads ID ".$leads_id."</div>";

// Get the Leads Info :
// Needed in the first page
/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip, contact_person
*/
$query = "SELECT l.fname,l.lname,l.company_industry, l.company_description,l.outsourcing_experience,email,company_position, company_name, officenumber, mobile , contact_person
			FROM leads l LEFT JOIN job_order j ON j.leads_id = l.id
			WHERE j.leads_id = $leads_id;";
$result = mysql_query($query);
list($fname,$lname,$company_industry,$company_description,$outsourcing_experience,$email,$company_position, $company_name, $officenumber, $mobile , $contact_person)=mysql_fetch_array($result);


$indutryArray=array("Accounting","Administration","Advert./Media/Entertain.","Banking & Fin. Services","Call Centre/Cust. Service","Community & Sport","Construction","Consulting & Corp. Strategy","Education & Training","Engineering","Government/Defence","Healthcare & Medical","Hospitality & Tourism","HR & Recruitment","Insurance & Superannuation","I.T. & T","Legal","Manufacturing/Operations","Mining, Oil & Gas","Primary Industry","Real Estate & Property","Retail & Consumer Prods.","Sales & Marketing","Science & Technology","Self-Employment","Trades & Services","Transport & Logistics");  
for ($i = 0; $i < count($indutryArray); $i++)
{
  if($company_industry == $indutryArray[$i])
  {
 $industryoptions .= "<option selected value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
  }
  else
  {
 $industryoptions .= "<option value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
  }
}	
$answer_array = array("Yes","No");
for($i=0;$i<count($answer_array);$i++){
	if($outsourcing_experience == $answer_array[$i]){
		$answer_options.= "<option selected value=\"$answer_array[$i]\">$answer_array[$i]</option>\n";
	}else{
		$answer_options.= "<option value=\"$answer_array[$i]\">$answer_array[$i]</option>\n";
	}
}


//job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type, form_filled_up, date_filled_up, ran, job_order_notes
$sql = $db->select()
	->from('job_order')
	->where('job_order_id =?' , $job_order_id);
$job_order = $db->fetchRow($sql);	
//print_r($job_order);

//if($job_order['created_by_type'] == 'agent') {
//	$created_by_type = 'bp';
//}


//if($job_order['response_by_type'] == 'agent') {
//	$response_by_type = 'bp';
//}

if($job_order['response_by_type'] == 'lead') {
	$response_by_type = 'leads';
}else{
	$response_by_type = $job_order['response_by_type'];
}


$created_by = getCreator($job_order['created_by_id'] , $job_order['created_by_type'] );
$filled_up_by = getCreator($job_order['response_by_id'] , $response_by_type );


$det = new DateTime($job_order['date_created']);
$date_created = $det->format("F j, Y");

$det = new DateTime($job_order['date_filled_up']);
$date_filled_up = $det->format("F j, Y");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>RemoteStaff Recruitment / Job Order Form</title>
<link rel=stylesheet type=text/css href="../../css/font.css">
<link rel="stylesheet" href="example.css" TYPE="text/css" MEDIA="screen">
<script type="text/javascript" src="../../js/MochiKit.js"></script>
<script language=javascript src="job_order.js"></script>
<script language=javascript src="job_order2.js"></script>
</head>

<body style="background:#ffffff; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" accept-charset = "utf-8">
<input type="hidden" id="job_order_id" name="job_order_id" value="<?php echo $job_order_id;?>" />
<input type="hidden" id="leads_id" name="leads_id" value="<?php echo $leads_id;?>" />

<div style="float:right; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; border:#FF0000 dashed 2px;">
Created By : <?php echo $created_by;?><br /><?php echo $date_created;?><br /><br />
Filled Up By : <?php echo $filled_up_by;?><br /><?php echo $date_filled_up;?><br />
</ul>
</div>
<img src='../../images/remote-staff-logo2.jpg'  />
<div style="font:12px Arial; padding:10px; ">
	<div style="text-align:center">
	<h2 style="margin-bottom:2px; margin-top:5px;">Job Specification Form</h2>
	<i>(For filing and reference of recruitment team)</i>
	</div>
	<div style=" margin-top:20px; border:#666666 solid 1px;">
		
			<div id="leads_info" >
			<b>Contact Information</b>
				<div style="float:left; display:block; width:350px;">
					<p><label>First Name :</label><input type="text" id="fname" name="fname" class="select" value="<?php echo $fname;?>" /></p>
					<p><label>Last Name :</label><input type="text" id="lname" name="lname" class="select" value="<?php echo $lname;?>" /></p>
					<p><label>Email :</label><input type="text" readonly id="email" name="email" class="select" value="<?php echo $email;?>" /></p>
					<p><label>Mobile :</label><input type="text" id="mobile" name="mobile" class="select" value="<?php echo $mobile;?>" /></p> 
					<p><label>Office No. :</label><input type="text" id="officenumber" name="officenumber" class="select" value="<?php echo $officenumber;?>" /></p>
					
				</div>
				<div style="float:left; display:block; width:350px; margin-left:10px;">
					<p><label>Company Name :</label><input type="text" id="company_name" name="company_name" class="select" value="<?php echo $company_name;?>" /></p>
					<p><label>Company Position :</label><input type="text" id="company_position" name="company_position" class="select" value="<?php echo $company_position;?>" /></p>
					<p><label>Contact Person :</label><input type="text" class="select" id="contact_person" name="contact_person" value="<?php echo $contact_person;?>"  /></p>
					<p><label>Do you have an existing staff member from RemoteStaff ? :</label><select id="used_rs" name="used_rs"  class="select" style="width:50px;"  >
															<option value="">--</option>
															<? echo $answer_options;?>
														</select></p>
				</div>
			  <div style="float:left; display:block; width:450px; margin-left:10px;">
			  <p><label>Industry :</label><select id="company_industry" name="company_industry"  class="select"   >
															<option value="">--</option>
															<? echo $industryoptions;?>
														</select></p>
					Quick Company Profile :  <span style="margin-left:5px; color:#666666; font:10px tahoma;">(Update our recruitment team with your company profile: This will help us better match the right staff for you.)</span><br />
				    <textarea id="company_description" name="company_description" class="select" rows="4" style="width:400px;" ><?php echo $company_description;?></textarea>
			  </div>
				<div style=" clear:both;"></div>
			</div>
			
			
			
			<div style="border:#999999 solid 1px; padding:5px;">
			<div>
				<div style="float:left;"><b>Rating Scale</b></div>
				<div style="float:right;"></div>
				<div style="clear:both;"></div>
			</div>	
				<div style="float:left; display:block; width:200px; padding:5px;">
					 <strong>0 </strong>No experience	<br />
					 <strong>1</strong> Trained, low level experience<br />
				</div>
				<div style="float:left; display:block; width:270px;  padding:5px;">
					<strong>2 </strong>Sound knowledge, some practical experience<br />
					<strong>3</strong>	Strong working knowledge and understanding <br />
	
				</div>
				<div style="float:left; display:block; width:680px; margin-left:0px; padding:5px;">
					<strong>4 </strong>Comprehensive understanding, knowledge and proficiency<br />
					<b>5</b> In depth expert knowledge and a high level of proficiency  able to provide specialist advice, insight or technical expertise <br />
				</div>
				<div style="clear:both;"></div>
			</div>
			<div id="inf" style="border:#CA0000 solid 1px; position: absolute; display:none;font-size:14px; width:400px; height:100px; background:#FFFFFF; z-index:1;">
				<div style="background:#CA0000; color:white; font-weight:bold;">Information</div>
				<div style="padding:10px; background:#FFFFFF; font-family:Arial, Helvetica, sans-serif; text-align:center; font-weight:bold; margin:10px; ">
					Processing plese wait.....				
				</div>
			</div>
			<div id="tab_wrapper" >
			<div style="padding:5px; ">
				<div id="order_list" style="float:left; width:300px;  padding:5px; background:#FFFFFF;"></div>
				<div style="clear:both;"></div>
			</div>
			<div style="padding:5px;"><b>Job Titles (Click on the job title that is relavent for your staffing needs )</b></div>
				<div >
			
					<div id="1" class="tab">
						<a href="javascript:showJobOrderForms(1);">Accounts Bookkeeper</a>				
					</div>
					<div id="2" class="tab">
						<a href="javascript:showJobOrderForms(2);">Applications Developer</a>
					</div>
					<div id="3" class="tab">
						<a href="javascript:showJobOrderForms(3);">Content Writer</a>
					</div>
					<div id="4" class="tab">
						<a href="javascript:showJobOrderForms(4);">Customer Support</a>
					</div>
					<div id="5" class="tab">
						<a href="javascript:showJobOrderForms(5);">Designer</a>
					</div>
					<div id="6" class="tab">
						<a href="javascript:showJobOrderForms(6);">Web / Developer</a>
					</div>
					<div id="7" class="tab">
						<a href="javascript:showJobOrderForms(7);">IT Staff</a>
					</div>
					<div id="8" class="tab">
						<a href="javascript:showJobOrderForms(8);">SEO - SEM Specialist</a>
					</div>
					<div id="9" class="tab">
						<a href="javascript:showJobOrderForms(9);">Tech Support</a>
					</div>
					<div id="10" class="tab">
						<a href="javascript:showJobOrderForms(10);">Telemarketer</a>
					</div>
					<div id="11" class="tab">
						<a href="javascript:showJobOrderForms(11);">Virtual Assistant</a>
					</div>
					
					<div id="12" class="tab" style=" background:#999999;">
						<a href="javascript:showJobOrderForms(12);">Others</a>
					</div>
					
					<div style=" clear:both;"></div>
					
				</div>
				<div id="showForm" style="border:#333333 ridge 1px; padding:1px; font:11px tahoma; padding-top:5px; ">
				Loading...
				</div>
			</div>
			
	</div>
	<div style="padding:5px; text-align:center;">
	By Completing Our Job Specification Form(s) You Acknowlege &amp; Agree To Our Service Agreement &amp; Terms &amp; Conditions Found On the Website 
	<a href="http://www.remotestaff.com.au" target="_blank">www.remotestaff.com.au</a> Or <a href="http://www.remotestaff.co.uk" target="_blank">www.remotestaff.co.uk</a> Or <a href="http://www.remotestaff.biz" target="_blank">www.remotestaff.biz</a>
	</div>
</div>
<script type="text/javascript">
<!--
showJobOrderForms(1);
-->
</script>
</form>
</body>
</html>