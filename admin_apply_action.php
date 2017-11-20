<?php
/*
2010 -05-19 Normaneil Macutay <normaneil.macutay@gmail.com>
	- added leads information changes history

2010-06-22 Normaneil Macutay <normaneil.macutay@gmail.com>
	- add stripslashes
	- change php short tag to Long tag
*/

include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';
include 'steps_taken.php';



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$query="SELECT * FROM admin a WHERE admin_id = $admin_id;";
$result=mysql_query($query);
$row = mysql_fetch_array ($result); 
$name = $row['admin_fname']." ".$row['admin_lname'];
$subject="Message from ".$_SERVER['HTTP_HOST']." c/o  ".$name;



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
$code = $_REQUEST['code'];
if($code!=""){
	if($code == 1){
		$code_desc = "<tr><td align='center'><b>Email Sent</b></td></tr>";
	}
	if($code == 2){
		$code_desc = "<tr><td align='center'><b>Message Sending Failed</b></td></tr>";
	}
	
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$mode =$_REQUEST['mode'];

$page = $_REQUEST['page'];
if($page == "newleads"){
	$title_page = "New Leads";
}
if($page == "followup"){
	$title_page = "Follow-Up";
}
if($page == "keeptouch"){
	$title_page = "Keep In-Touch";
}
if($page == "pending"){
	$title_page = "Pending";
}
if($page == "client"){
	$title_page = "Client";
}
if($page == "custom recruitment"){
	$title_page = "custom recruitment";
}


$leads_id = $_REQUEST['id'];
//all leads
$queryAllLeads = "SELECT id, CONCAT(fname,' ',lname), company_name , DATE(timestamp),CONCAT(MONTH(timestamp),'-',YEAR(timestamp))
	FROM leads l
	WHERE l.status = '$title_page'
	ORDER BY l.fname ASC;";
//echo $queryAllLeads;
$result = mysql_query($queryAllLeads);
if(!result) die("Error in sql script ".$queryAllLeads);
while(list($id, $leads , $company_name,$registered_date,$month_year)=mysql_fetch_array($result))
{
	if($leads_id == $id ) {
		$leads_Options.="<option value=".$id." selected>".$leads."</option>";
	}else{
		$leads_Options.="<option value=".$id.">".$leads."</option>";
	}	
	
	if($AusDate == $registered_date){
		if($leads_id == $id ) {
			$leads_Options2.="<option value=".$id." selected>".$leads."</option>";
		}else{
			$leads_Options2.="<option value=".$id.">".$leads."</option>";
		}	
	}
	
	/*if(date("n")."-".date("Y") == $month_year){
		if($leads_id == $id ) {
			$leads_Options3.="<option value=".$id." selected>".$leads."</option>";
		}else{
			$leads_Options3.="<option value=".$id.">".$leads."</option>";
		}	
	}
	*/
	
}
$queryAllLeads2 = "SELECT id, CONCAT(fname,' ',lname), company_name , DATE_FORMAT(timestamp,'%D %b %y')
	FROM leads l
	WHERE l.status = '$title_page'
	ORDER BY timestamp DESC;";
	
$result = mysql_query($queryAllLeads2);
if(!result) die("Error in sql script ".$queryAllLeads2);
while(list($id, $leads , $company_name,$timestamp)=mysql_fetch_array($result))
{
	if($leads_id == $id ) {
		$leads_Options3.="<option value=".$id." selected>".$leads." - ".$timestamp."</option>";
	}else{
		$leads_Options3.="<option value=".$id.">".$leads." - ".$timestamp."</option>";
	}
}


//id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip, contact_person, logo_image, company_owner, contact, others, accounts, acct_dept_name1, acct_dept_name2, acct_dept_contact1, acct_dept_contact2, acct_dept_email1, acct_dept_email2, supervisor_staff_name, supervisor_job_title, supervisor_skype, supervisor_email, supervisor_contact, business_owners, business_partners

$query ="SELECT tracking_no, agent_id, timestamp, l.status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, l.lname, l.fname, company_position, company_name, company_address, l.email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip, contact_person, logo_image , company_owner , contact , others , accounts ,acct_dept_name1, acct_dept_name2, acct_dept_contact1, acct_dept_contact2, acct_dept_email1, acct_dept_email2, supervisor_staff_name, supervisor_job_title, supervisor_skype, supervisor_email, supervisor_contact, business_owners, business_partners FROM leads l LEFT JOIN agent a ON agent_no = agent_id WHERE l.id = $leads_id ;";

$result=mysql_query($query);
if(!$result) die ("Error in Script<br>".$query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	list($tracking_no, $agent_id, $timestamp, $status, $call_time_preference, $remote_staff_competences, $remote_staff_needed, $remote_staff_needed_when, $remote_staff_one_home, $remote_staff_one_office, $your_questions, $lname, $fname, $company_position, $company_name, $company_address, $email, $password, $website, $officenumber, $mobile, $company_description, $company_industry, $company_size, $outsourcing_experience, $outsourcing_experience_description, $company_turnover, $referal_program, $contacted_since, $client_since, $inactive_since, $rate, $personal_id, $date_move, $agent_from, $authenticate, $opt, $show_to_affiliate, $leads_country, $leads_ip, $contact_person, $logo_image, $company_owner , $contact , $others , $accounts , $acct_dept_name1, $acct_dept_name2, $acct_dept_contact1, $acct_dept_contact2, $acct_dept_email1, $acct_dept_email2, $supervisor_staff_name, $supervisor_job_title, $supervisor_skype, $supervisor_email, $supervisor_contact, $business_owners, $business_partners)=mysql_fetch_array($result);
	
	//Check if the $agent_id is an Affiliate or a Business Partner
	function checkAgentId($agent_id){
		$sql = "SELECT CONCAT(fname,' ',lname), email, work_status FROM agent a WHERE agent_no = $agent_id;";
		$result=mysql_query($sql);
		if(!$result) die ("Error in Script<br>".$sql);
		list($agent_name,$email, $work_status)=mysql_fetch_array($result);
		if($work_status == "AFF"){
			//return strtoupper($work_status)." ".$agent_name." ".$email; 
			// Check to whose Business Partner is this Affiate is?
			$sqlBP="SELECT CONCAT(a.fname,' ',a.lname),a.email FROM agent_affiliates f 
					JOIN agent a ON a.agent_no = f.business_partner_id 
					WHERE f.affiliate_id = $agent_id;";
			//echo $sqlBP;
			$data = mysql_query($sqlBP);
			list($bp_name,$bp_email) = mysql_fetch_array($data);
			$aff_name="<b>Business Partner </b> ".$bp_name." ~ ".$bp_email."<br>";
			$aff_name .= "<b> Affiliate </b>".$agent_name." ~  ".$email;
			return $aff_name;
			
		}else{
			return "<b>Business Partner </b>".$agent_name." ~  ".$email; 
		}
	}
	
	
	if($rate=="1")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	
	
}

?>

<html>
<head>
<title>Admin Manage <?php echo $title_page;?></title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">

<link rel=stylesheet type=text/css href="adminmenu.css">
<script language=javascript src="js/functions.js"></script>

<link rel=stylesheet type=text/css href="product_need/product_needs.css">
<script language=javascript src="product_need/product_need.js"></script>

<script type="text/javascript">
<!--
function leadsNavigation(direction){
	var selObj = document.getElementById("leads");
	current_index = selObj.selectedIndex;
	if(direction!="direct"){
		if(direction == "back"){
			if(current_index >0){
				current_index = current_index-1;
			}else{
				current_index =0 ;
			}	
		}
		if(direction == "forward"){
			current_index = current_index+1;
		}
		value = selObj.options[current_index].value;
	}else{
		value = selObj.value;
	}
	location.href = "<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>?id="+value+"&page=<?php echo $page;?>";
}
function selectLeads(value){
	location.href = "<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>?id="+value+"&page=<?php echo $page;?>";
}

function getValue(element_name){

	//element_name : quote_id , service_agreement_id , setup_fee_id setup_fee
	//alert(element_name);
	if(element_name == "quote_id") {
		var ins = document.getElementsByName(element_name);
		var i;
		var j=0;
		var vals = new Array();
		for(i=0;i<ins.length;i++)
		{
			if(ins[i].checked==true) {
				vals[j]=ins[i].value;
				j++;
				//vals="with";
			}
		}
			document.form.quote.value=(vals);
	}
	if(element_name == "service_agreement_id") {
		var ins = document.getElementsByName(element_name);
		var i;
		var j=0;
		var vals= new Array();
		for(i=0;i<ins.length;i++)
		{
			if(ins[i].checked==true) {
				vals[j]=ins[i].value;
				j++;
				//vals="with";
			}
		}
			document.form.service_agreement.value=(vals);
	}
	if(element_name == "setup_fee_id") {
		var ins = document.getElementsByName(element_name);
		var i;
		var j=0;
		var vals= new Array();
		for(i=0;i<ins.length;i++)
		{
			if(ins[i].checked==true) {
				vals[j]=ins[i].value;
				j++;
				//vals="with";
			}
		}
			document.form.setup_fee.value=(vals);
	}
	
}
function check_val()
{
	var ins = document.getElementsByName('recruitment_job_order_form')
	var i;
	var j=0;
	var vals="without"; //= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			//vals[j]=ins[i].value;
			//j++;
			vals="with";
		}
	}
	document.form.job_order.value=(vals);
}
function checkFields()
{
	if(document.form.star.selectedIndex==0)
	{
		missinginfo = "";
		if(document.form.txt.value=="")
		{
			missinginfo += "\n     -  There is no message or details to be save or send \t \n Please enter details.";
		}
		if (document.form.mode.value =="")
		{
			if (document.form.fill.value=="" )
			{
				missinginfo += "\n     -  Please choose actions.";
			}
			if (document.form.fill.value=="EMAIL" )
			{
				if (document.form.subject.value=="" )
				{
					missinginfo += "\n     -  Please enter a subject in your Email.";
				}
				if (document.form.templates[0].checked==false && document.form.templates[1].checked==false && document.form.templates[2].checked==false)
				{
					missinginfo += "\n     -  Please choose email templates.";
				}
			}
		}	
		if (missinginfo != "")
		{
			missinginfo =" " + "You failed to correctly fill in the required information:\n" +
			missinginfo + "\n\n";
			alert(missinginfo);
			return false;
		}
		else return true;
	}
}
function user_prompt(uid) {
	if (confirm('Are you sure you want to continue this process?\n This will send an email to the agent and client\'s email addresses.')) {
		window.location='admin_makeClient.php?id='+uid;
	}
}
-->
</script>	









<style type="text/css">
<!--
	div.scroll {
		height: 200px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
	}
	.spanner
	{
		float: right;
		text-align: right;
		padding:5px 0 5px 10px;
	
	
	}
	.spannel
	{
		float: left;
		text-align:left;
		padding:5px 0 5px 10px;
		border:#f2cb40 solid 1px;
		
	}	
.l {
	float: left;
	text-align:left;
	padding:5px 0 5px 10px;
	
	}	

.r{
	float: right;
	text-align: right;
	padding:5px 0 5px 10px;
	
	}
.btn{
	font:11px Tahoma;
}	
-->
</style>	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="admin_apply_actionphp.php" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="id" id="leads_id" value="<?php echo $leads_id;?>">
<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
<input type="hidden" name="mode" value="<?php echo $mode;?>">
<input type="hidden" name="email" id="email" value="<?php echo $email;?>">
<input type="hidden" name="fill" value="">
<input type="hidden" name="fullname" value="<?php echo $fname." ".$lname;?>">
<input type="hidden" name="job_order" id="job_order" >
<input type="hidden" name="quote" id="quote" value="">
<input type="hidden" name="service_agreement" id="service_agreement" value="">
<input type="hidden" name="setup_fee" id="setup_fee" value="">



<!-- HEADER -->

<?php include 'header.php';?>

<?php include 'admin_header_menu.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'adminleftnav.php';?>
</td>
<td valign=top align=left>
<div id="navigation_form" style="padding:5px; font:12px Arial;">
<div style="margin-bottom:10px;">
	<div style="float:left; color:#FF0000;"><b>
	Search <?php echo $title_page;?> Options
	</b>
	</div>
	<div style="float:right;">Current Lead : <?php echo "<b>".$fname." ".$lname."</b>";?></div>
	<div style="clear:both;"></div>
</div>
	<div style="float:left; display:block; width:270px; ">
	<div><b>All</b></div>
	<!--
	<a href="javascript:leadsNavigation('back');">
	<img src="images/back.png" border="0">
	</a>
	-->
	<select class="select" name="leads" id="leads" size="10" style="width:260px;"  onChange="javascript:leadsNavigation('direct')" >
	 <option value="0">-Select-</option>
		 <?php echo $leads_Options;?>
	</select>
	<!--
	<a href="javascript:leadsNavigation('forward');">
	<img src="images/forward.png" border="0">
	</a>
	-->
	</div>
	<div style="float:left; margin-left:10px; width:270px;">
	<div><b><?php echo format_date($AusDate);?></b></div>
	<select name="select" size="10" class="select" style="width:260px;" onChange="javascript:selectLeads(this.value);" >
      <?php echo $leads_Options2;?>
    </select>
	</div>
	<div style="float:left; margin-left:10px; width:350px;">
	<div><b>Sort By Date Registered Descending [Current to Previous] </b></div>
	<select class="select" size="10" style="width:260px;" onChange="javascript:selectLeads(this.value);" >
	<?php echo $leads_Options3;?>
	</select></div>
<div style="clear:both;"></div>
</div>
<table width=98% cellspacing=8 cellpadding=2 border=0 align=left >
<?php echo $code_desc;?>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Manage <?php echo $title_page;?> Lead</b></td></tr>
<tr><td colspan=2 >
<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr><td valign="top" colspan="3" align="right"><a href="admin_updateinquiry.php?leads_id=<?php echo $leads_id;?>&page=<?php echo $page;?>">Edit</a></td></tr>

<tr><td><b>Lead ID</b></td><td>:</td><td><?php echo $personal_id;?></td></tr>
<tr><td valign="top"><b>Lead Ratings</b></td><td>:</td><td valign="top">
<div>
<div style=" float:left;width:100px; display:block;"><?php echo $rate;?></div><div style=" float:left; display:block; margin-left:10px; color:#999999;font:10px tahoma; "> 
<select name="star" style="font:10px tahoma;" >
<option value="0">-</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>&nbsp;
<input type="submit" name="rate" style="font:10px tahoma;"  value="Rate">&nbsp;<i>(Ratings : 1 <img src="images/star.png" align="texttop"> = Low potential  ----  5 <img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top"><img src="images/star.png" align="top">=Highest potential)</i></div>
</div>
</td></tr>

<tr><td width="27%" valign="top" ><b>Date Registered</b></td>
<td width="2%" valign="top">:</td>
<td width="71%" valign="top"><?php echo format_date($timestamp);?></td>
</tr>
<tr bgcolor="#FFFF00"><td valign="top"><strong>Fullname</strong></td>
<td valign="top">:</td><td valign="top" style="font:13px Arial;"><?php echo "<b>".stripslashes($fname." ".$lname)."</b>"; $_SESSION['l_id'] = @$_GET["id"];  $_SESSION['s_name'] = stripslashes($fname." ".$lname); ?></td></tr>
<tr><td valign="top"><strong>Login Email</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $email;?></td></tr>
<tr><td valign="top"><strong>Affiliate</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $email;?></td></tr>
<tr bgcolor="#CAFFE4"><td valign="top" ><strong>Leads of</strong></td>
<td valign="top">:</td><td valign="top" style="font:12px Arial;"><?php echo checkAgentAffiliates($leads_id);?></td></tr>

<tr><td valign="top"><strong>IP Address</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $leads_ip;?></td></tr>





<tr><td valign="top"><strong>Company name</strong></td>
<td valign="top">:</td><td valign="top"><?php echo stripslashes($company_name);?></td></tr>
<tr><td valign="top"><strong>Job Position</strong></td>
<td valign="top">:</td><td valign="top"><?php echo stripslashes($company_position);?></td></tr>
<tr><td valign="top"><strong>Company Address</strong></td>
<td valign="top">:</td><td valign="top"><?php echo stripslashes($company_address);?></td></tr>
<tr><td valign="top"><strong>Website</strong></td>
<td valign="top">:</td><td valign="top"><?php echo stripslashes($website);?></td></tr>
<tr><td valign="top"><strong>Company No.</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $officenumber;?></td></tr>
<tr><td valign="top"><strong>Moblie No</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $mobile;?></td></tr>
<tr><td valign="top"><strong>Company Industry</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $company_industry;?></td></tr>
<tr><td valign="top"><strong>No. of Employees</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $company_size;?></td></tr>
<tr><td valign="top"><strong>Company Turnover in a Year</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $company_turnover;?></td></tr>
<tr><td valign="top"><strong>Company Profile</strong></td>
<td valign="top">:</td><td valign="top"><ul style="margin-top:0px; margin-left:2px;"><?php echo stripslashes($company_description);?></ul></td></tr>

<tr><td colspan="3"><hr></td></tr>
<tr><td valign="top"><strong>Call time availability</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $call_time_preference;?></td></tr>

<tr><td valign="top"><strong>No. of Remote Staff neeeded</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $remote_staff_needed;?></td></tr>
<tr><td valign="top"><strong>Remote Staff needed</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $remote_staff_needed_when;?></td></tr>

<tr><td valign="top"><strong>Remote Staff needed in Home Office</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $remote_staff_one_home;?></td></tr>
<tr><td valign="top"><strong>Remote Staff needed in Office</strong></td>
<td valign="top">:</td><td valign="top"><?php echo $remote_staff_one_office;?></td></tr>
<tr><td valign="top"><strong>Remote Staff responsibilities</strong></td>
<td valign="top">:</td><td valign="top"><?php echo stripslashes($remote_staff_competences);?></td></tr>
<tr><td colspan="3"><hr></td></tr>
<tr><td valign="top"><strong>Questions / Concern</strong></td>
<td valign="top">:</td><td valign="top"><ul style="margin-top:0px; margin-left:2px;"><?php echo stripslashes($your_questions);?></ul></td></tr>
<?php if($outsourcing_experience =="Yes")
echo "<tr><td valign=top><b>Outsourcing Experience / Details</b></td><td valign=top>:</td><td valign=top><ul style='margin-top:0px; margin-left:2px;'>".$outsourcing_experience_description."</ul></td></tr>";
?>

<tr><td colspan="3"><hr></td></tr>
<tr><td colspan="3"><hr></td></tr>
<tr><td colspan="3"><b style="color:#FF0000;">Contact Details</b></td></tr>
<tr><td colspan="3"><b style="color:#0000FF;">Accounts Department</b></td></tr>
<tr><td valign="top">Accounts Department Staff Name 1</td>
<td valign="top">:</td><td valign="top"><?php echo $acct_dept_name1;?></td></tr>
<tr><td valign="top">Accounts Department Email 1</td>
<td valign="top">:</td><td valign="top"><?php echo $acct_dept_email1;?></td></tr>
<tr><td valign="top">Accounts Department Contact nos. 1</td>
<td valign="top">:</td><td valign="top"><?php echo $acct_dept_contact1;?></td></tr>


<tr><td valign="top">Accounts Department Staff Name 2</td>
<td valign="top">:</td><td valign="top"><?php echo $acct_dept_name2;?></td></tr>
<tr><td valign="top">Accounts Department Email 2</td>
<td valign="top">:</td><td valign="top"><?php echo $acct_dept_email2;?></td></tr>
<tr><td valign="top">Accounts Department Contact nos. 2</td>
<td valign="top">:</td><td valign="top"><?php echo $acct_dept_contact2;?></td></tr>
<tr><td colspan="3"><b style="color:#0000FF;">Person directly working with sub-contractor in client organization</b></td></tr>
<tr><td valign="top">Name</td>
<td valign="top">:</td><td valign="top"><?php echo $supervisor_staff_name;?></td></tr>
<tr><td valign="top">Job Title</td>
<td valign="top">:</td><td valign="top"><?php echo $supervisor_job_title;?></td></tr>
<tr><td valign="top">Skype</td>
<td valign="top">:</td><td valign="top"><?php echo $supervisor_skype;?></td></tr>
<tr><td valign="top">Email</td>
<td valign="top">:</td><td valign="top"><?php echo $supervisor_email;?></td></tr>
<tr><td valign="top">Contact</td>
<td valign="top">:</td><td valign="top"><?php echo $supervisor_contact;?></td></tr>
<tr><td valign="top">Business Owner/Director/CEO</td>
<td valign="top">:</td><td valign="top"><?php echo $business_owners;?></td></tr>
<tr><td valign="top">Business Partners</td>
<td valign="top">:</td><td valign="top"><?php echo $business_partners;?></td></tr>


		</table>

</td></tr>
<tr><td colspan="2">
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<input type="button" class="btn" value="Move to New Leads" onClick="self.location='admin_moveLead.php?id=<?php echo $leads_id;?>&status=New Leads'"/>
<input type="button" class="btn" value="Move to Follow-Up" onClick="self.location='admin_moveLead.php?id=<?php echo $leads_id;?>&status=Follow-Up'"/>
<input type="button" class="btn" value="Move to Keep In-Touch" onClick="self.location='admin_moveLead.php?id=<?php echo $leads_id;?>&status=Keep In-Touch'"/>
<input type="button" class="btn" value="Move to Pending" onClick="self.location='admin_moveLead.php?id=<?php echo $leads_id;?>&status=pending'"/>
<input name="button" type="button" class="btn" onClick="user_prompt(<?php echo $leads_id;?>);" value="Become a Client"/>
<input name="button2" type="button" class="btn" onClick="self.location='admin_deleteProspect.php?id=<?php echo $leads_id;?>&page=<?php echo $page;?>'" value="Delete"/>
<input type="button" class="btn"  value="No Longer a Prospect" onClick="self.location='admin_notProspect.php?id=<?php echo $leads_id;?>'"/>
<input type="button" class="btn" value="Create Set-Up Fee" onClick="self.location='admin_set_up_fee_invoice.php?leads_id=<?php echo $leads_id;?>'"/>
<input type="button" class="btn" value="Quote" onClick="self.location='admin_create_quote.php?leads_id=<?php echo $leads_id;?>'"/>

</td>
</tr></table>

</td></tr>



















<tr><td width=100% colspan=2>
<?php showLeadsInfoHistory($leads_id , 'no' , 0);?>
<div id="product_needs">
	<div class="product_box_title"><b>Steps Taken</b></div>
	<div style="background:#FFFFFF; padding:2px; border:#DEE5EB solid 1px;">
		<div id="product_form" style="padding:10px;">
		<?php getStepsTaken($leads_id);
		getClientStaff($leads_id);
		?>
		</div>
	</div>
</div>
<div>
<div style="font:12px Arial; margin-top:10px;margin-bottom:10px; ">
	<div style="float:left; display:block; width:325px;">
		<div style=" padding:5px;background:#DEE5EB; border:#DEE5EB outset 1px;">
			<div style="float:left;"><b>Quote</b></div>
			<div style="float:right;"><input type="button" class="btn" value="Create" onClick="self.location='admin_create_quote.php?leads_id=<?php echo $leads_id;?>&url=<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>'"/></div>
			<div style='clear:both;'></div>
		</div>
		<div style="border:#DEE5EB solid 1px; padding:5px; overflow:auto; height:100px;">
		<?php //Check if the leads is given by quote
		//Quote 
		//
		$sqlQuote="SELECT id,DATE_FORMAT(date_quoted,'%D %b %y'), quote_no , ran FROM quote q WHERE leads_id = $leads_id;";
		$data = mysql_query($sqlQuote);
		$counter=0;
		while(list($quote_id,$date_quoted,$quote_no,$ran)=mysql_fetch_array($data))
		{
			if($ran==""  or $ran==NULL){
				$ran = get_rand_id();
				$ran = CheckRan($ran,'quote');
				$sql = "UPDATE quote SET ran = '$ran' WHERE id = $quote_id;";
				mysql_query($sql);
			}
				
			$counter++;
			echo "<div style = 'margin-bottom:5px;'>
					<div style='float:left; display:block; '>".$counter.") 
					<input type='checkbox' name='quote_id' value='$quote_id' onclick=getValue('quote_id') >
					<a href='./pdf_report/quote/?ran=$ran' target='_blank'>Quote # ".$quote_no."</a> </div>
					<div style='float:right;'><span style='color:#999999;font:11px Tahoma;'>".getAttachment($quote_id,'Quote','details')."</span></div>
					<div style='clear:both;'></div>
				 </div>";
		}
		?>
		
		</div>
	</div>
	<div style="float:left; display:block; width:325px;">
		<div style=" padding:5px;background:#DEE5EB; border:#DEE5EB outset 1px;">
			<div style="float:left;"><b>Service Agreement</b></div>
			<div style="float:right;"><input type="button" class="btn" value="Create"  onClick="self.location='admin_service_agreement.php?leads_id=<?php echo $leads_id;?>&url=<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>'"/></div>
			<div style='clear:both;'></div>
			
		</div>
		<div style="border:#DEE5EB solid 1px; padding:5px; overflow:auto; height:100px;">
		<?php $sqlServiceAgreement = "SELECT DATE_FORMAT(date_created,'%D %b %y'), service_agreement_id,q.quote_no , s.ran
									FROM service_agreement s
									LEFT JOIN quote q ON q.id = s.quote_id
									WHERE s.leads_id = $leads_id;";
			$data = mysql_query($sqlServiceAgreement);
			$counter=0;
			while(list($date_created,$service_agreement_id ,$quote_no, $ran)=mysql_fetch_array($data))
			{
				if($ran==""  or $ran==NULL){
					$ran = get_rand_id();
					$ran = CheckRan($ran,'service_agreement');
					$sql = "UPDATE service_agreement SET ran = '$ran' WHERE service_agreement_id = $service_agreement_id;";
					mysql_query($sql);
				}
				$counter++;
				echo "<div style = 'margin-bottom:5px;'>
						<div style='float:left; display:block;'>".$counter.") 
						<input type='checkbox' name='service_agreement_id' value='$service_agreement_id' onclick=getValue('service_agreement_id') > 
						<a href='./pdf_report/service_agreement/?ran=$ran' target='_blank'>Service Agreement # ".$service_agreement_id."</a> </div>
						<div style='float:right;'><span style='color:#999999;font:11px Tahoma;'>".getAttachment($service_agreement_id,'Service Agreement','details')."</span></div>
						<div style='clear:both;'></div>
					<div style='color:#999999;'><small>Reference Quote #".$quote_no."</small></div></div>";
			}
			
		?>
		</div>
	</div>
	<div style="float:left; display:block; width:325px;">
		<div style=" padding:5px;background:#DEE5EB; border:#DEE5EB outset 1px;">
				<div style="float:left;"><b>Recruitment Set-Up Fee Tax Invoice</b></div>
				<div style="float:right;"><input type="button" class="btn" value="Create" onClick="self.location='admin_set_up_fee_invoice.php?leads_id=<?php echo $leads_id;?>&url=<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>'"/></div>
				<div style='clear:both;'></div>
		</div>
		<div style="border:#DEE5EB solid 1px; padding:5px; overflow:auto; height:100px;">
		<?php //Check if the leads is given by quote
		//Set-Up Fee Tax Invoice
		//
		$sqlSetUpFeeInvoice ="SELECT id,DATE_FORMAT(invoice_date,'%D %b %y'), invoice_number , ran  FROM set_up_fee_invoice s WHERE leads_id = $leads_id;";
		$data = mysql_query($sqlSetUpFeeInvoice);
		$counter=0;
		while(list($setup_fee_id,$invoice_date,$invoice_number,$ran)=mysql_fetch_array($data))
		{
			if($ran==""  or $ran==NULL){
					$ran = get_rand_id();
					$ran = CheckRan($ran,'set_up_fee_invoice');
					$sql = "UPDATE set_up_fee_invoice SET ran = '$ran' WHERE id = $set_up_fee_id;";
					mysql_query($sql);
			}
				
			$counter++;
			echo "<div style = 'margin-bottom:5px;'>
				<div style='float:left; display:block; '>".$counter.") 
				<input type='checkbox' name='setup_fee_id' value='$setup_fee_id' onclick=getValue('setup_fee_id') > 
				<a href='./pdf_report/spf/?ran=$ran' target='_blank'>Set-Up Fee # ".$invoice_number."</a> </div>
				<div style='float:right;'><span style='color:#999999;font:11px Tahoma;'>".getAttachment($setup_fee_id,'Set-Up Fee Invoice','details')."</span></div>
				<div style='clear:both;'></div>
				</div>";
		}
		?>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<div style="font:12px Arial; margin-top:10px;margin-bottom:10px; ">
	<div style="float:left; display:block; width:325px;">
		<div style=" padding:5px;background:#DEE5EB; border:#DEE5EB outset 1px;">
			<b>Credit Card / Direct Debit</b>
			
		</div>
		<div style="border:#DEE5EB solid 1px; padding:5px; overflow:auto; height:100px;">
		<input type="checkbox" id='credit_debit_card' name='credit_debit_card' value='<?php echo $leads_id;?>' > 
			Credit Card / Direct Debit
		
		</div>
	</div>
	<div style="float:left; display:block; width:325px;">
		<div style=" padding:5px;background:#DEE5EB; border:#DEE5EB outset 1px;">
			<b>Job Specification Form</b>
		</div>
		<div style="border:#DEE5EB solid 1px; padding:5px; overflow:auto; height:100px; overflow:scroll;">
		
			<input type="checkbox" id='recruitment_job_order_form' name='recruitment_job_order_form' onClick="check_val()" value="" > 
			Job Specification Form
		
		</div>
	</div>
	<div style="float:left; display:block; width:325px;">
		<div style=" padding:5px;background:#DEE5EB; border:#DEE5EB outset 1px;">
				<b>History</b>
		</div>
		<div style="border:#DEE5EB solid 1px; padding:5px; overflow:auto; height:100px;">
		
		<?php //SELECT * FROM `quote` q;
		//id, created_by, created_by_type, leads_id, date_quoted, quote_no, status, date_posted
		$query = "SELECT id, created_by, created_by_type, quote_no, status, DATE_FORMAT(date_posted,'%D %b %y'), ran  FROM quote q WHERE status='posted' AND leads_id = $leads_id;";
		$result = mysql_query($query);
		$num_rows_quote = mysql_num_rows($result);
		if($num_rows_quote > 0) {
			echo "<div style='color:red;'><b>Quote</b></div>";
			while(list($quote_id, $created_by, $created_by_type, $quote_no, $quote_status,$quote_posted , $ran)=mysql_fetch_array($result))
			{
				// 
				if($ran==""  or $ran==NULL){
					$ran = get_rand_id();
					$ran = CheckRan($ran,'quote');
					$sql = "UPDATE quote SET ran = '$ran' WHERE id = $quote_id;";
					mysql_query($sql);
				}
				
				
				
				echo "<div>--<a href='./pdf_report/quote/?ran=$ran' target='_blank' class=link10>Quote # ".$quote_no." Date Sent: ".$quote_posted."</a></div>";
			}
		}
	
		//service_agreement_id, quote_id, leads_id, created_by, created_by_type, date_created, status, date_posted, posted_by, posted_by_type
		$query2 = "SELECT service_agreement_id, status, DATE_FORMAT(date_posted,'%D %b %y') , ran  FROM service_agreement WHERE status='posted' AND leads_id = $leads_id;";
		//echo $query2;
		$result2 = mysql_query($query2);
		$num_rows_service_agreement = mysql_num_rows($result2);
		if($num_rows_service_agreement > 0){
			echo "<div style='color:red;'><b>Service Agreement</b></div>";
			while(list($service_agreement_id, $service_agreement_status,$service_agreement_posted ,$ran)=mysql_fetch_array($result2))
			{
				if($ran==""  or $ran==NULL){
					$ran = get_rand_id();
					$ran = CheckRan($ran,'service_agreement');
					$sql = "UPDATE service_agreement SET ran = '$ran' WHERE service_agreement_id = $service_agreement_id;";
					mysql_query($sql);
				}
				
				echo "<div>--<a href='./pdf_report/service_agreement/?ran=$ran' target='_blank' class='link10'>Service Agreement # ".$service_agreement_id." Date Sent: ".$service_agreement_posted."</a></div>";
			}
		}
		//id, leads_id, leads_name, leads_email, leads_company, leads_address, description, drafted_by, drafted_by_type, status, invoice_date, draft_date, post_date, paid_date, sub_total, gst, total_amount, invoice_number, currency, gst_flag
		$query3="SELECT id,invoice_number,DATE_FORMAT(post_date,'%D %b %y'), ran FROM set_up_fee_invoice WHERE status='posted' AND leads_id = $leads_id;";
		$result3 = mysql_query($query3);
		$num_rows_set_up_fee_invoice = mysql_num_rows($result3);
		if($num_rows_set_up_fee_invoice > 0){
			echo "<div style='color:red;'><b>Set Up Fee Tax Invoice</b></div>";
			while(list($set_up_fee_id, $set_up_fee_invoice_num,$set_up_fee_posted ,$ran)=mysql_fetch_array($result3))
			{
				if($ran==""  or $ran==NULL){
					$ran = get_rand_id();
					$ran = CheckRan($ran,'set_up_fee_invoice');
					$sql = "UPDATE set_up_fee_invoice SET ran = '$ran' WHERE id = $set_up_fee_id;";
					mysql_query($sql);
				}
				
				echo "<div>--<a href='./pdf_report/spf/?ran=$ran' target='_blank' class='link10'>Invoice # ".$set_up_fee_invoice_num." Date Sent: ".$set_up_fee_posted."</a></div>";
			}
		}
		//job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type
		$query4="SELECT job_order_id , DATE_FORMAT(date_posted,'%D %b %y') , ran FROM job_order WHERE status='posted' AND leads_id = $leads_id;";
		$result4 = mysql_query($query4);
		$num_rows_job_order = mysql_num_rows($result4);
		if($num_rows_job_order > 0){
			echo "<div style='color:red;'><b>Job Order</b></div>";
			while(list($job_order_id,$job_order_posted , $ran )=mysql_fetch_array($result4))
			{
				if($ran==""  or $ran==NULL){
					$ran = get_rand_id();
					$ran = CheckRan($ran,'job_order');
					$sql = "UPDATE job_order SET ran = '$ran' WHERE job_order_id = $job_order_id;";
					mysql_query($sql);
				}
				
				echo "<div>--<a href='./pdf_report/job_order_form/?ran=$ran' target='_blank' class='link10'>Job Specification Form # ".$job_order_id." Date Sent: ".$job_order_posted."</a></div>";
			}
		}
		?>
		</div>
	</div>
	
	<div style="clear:both;"></div>
</div>
</div>
</td></tr>
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Action Records </b></td></tr>
<tr>
  <td  colspan="2" width=30% >
  <p><?php echo $fname." ".$lname;?></p>
  <table width=100% border=0 cellspacing=1 cellpadding=2>
  <tr>
  <td width="22%">
  <input type="radio" name="action" value="EMAIL" onclick ="showHide('EMAIL');"> Email
  
  <img border="0" src="images/email.gif" alt="Email" width="16" height="10">    </td>
  <td width="21%">
  <input type="radio" name="action" value="CALL" onclick ="showHide('CALL');"> Call 
  <img src="images/icon-telephone.jpg" alt="Call">  </td>
  <td width="21%">
  <input type="radio" name="action" value="MAIL" onclick ="showHide('MAIL');"> Notes
  <img src="images/textfile16.png" alt="Notes" >  </td>
  <td width="36%">
  <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHide('MEETING FACE TO FACE');"> Meeting face to face
  <img src="images/icon-person.jpg" alt="Meet personally">  </td>
  </tr>
  </table>
  <script language=javascript>
<!--
	function go(id) 
	{
		document.form.fill.value=id;			
	}
	function showHide(actions)
	{
		if(actions=="EMAIL")
		{
		
		newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";
		newitem+="<tr><td>";
		//newitem+="<p><b>Subject :</b>&nbsp;&nbsp;<input type=\"text\"  name=\"subject\"></p>";
		newitem+="<p style=\"margin-bottom:7px;margin-top:7px;\"><label style=\"width:80px;display:block;float:left;\"><b>Email :</b></label><?php echo $email;?></p>";
		newitem+="<p style=\"margin-bottom:7px;margin-top:7px;\"><label style=\"width:80px;display:block;float:left;\"><b>Subject :</b></label><input type=\"text\"  name=\"subject\" class=\"select\" style=\"width:400px;\" value=\"<?php echo $subject;?>\"></p>";
		newitem+="<p style=\"margin-bottom:7px;margin-top:7px;color:#666666;\"><b>Insert addresses (separated by commas &quot;,&quot;)</b></p>";
		newitem+="<p style=\"margin-bottom:7px;margin-top:7px;\"><label style=\"width:80px;display:block;float:left;\"><b>CC :</b></label><input type=\"text\"  name=\"cc\" class=\"select\" style=\"width:400px;\"></p>";
		newitem+="<p style=\"margin-bottom:7px;margin-top:7px;\"><label style=\"width:80px;display:block;float:left;\"><b>BCC :</b></label><input type=\"text\"  name=\"bcc\" class=\"select\" style=\"width:400px;\"></p>";
		
		newitem+="<B>Message :</B>";
		newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";
		newitem+="</td></tr>";
		newitem+="<tr><td><b>Send Message as :</b><br>";
		newitem+="<input type=\"radio\" name=\"templates\" value=\"signature\"> Signature Template";
		newitem+="&nbsp;&nbsp;&nbsp;";
		newitem+="<input type=\"radio\" name=\"templates\" value=\"plain\"> Plain Text";
		newitem+="&nbsp;&nbsp;&nbsp;";
		newitem+="<input type=\"radio\" name=\"templates\" value=\"promotional\"> Promotional Template";
		newitem+="<br>";
		newitem+="<b>1) Attach File :</b> <input name=\"image\" type=\"file\" id=\"image\" class=text >";
		newitem+="<br>";
		newitem+="<b>2) Attach File :</b> <input name=\"image2\" type=\"file\" id=\"image2\" class=text >";
		newitem+="<br>";
		newitem+="<b>3) Attach File :</b> <input name=\"image3\" type=\"file\" id=\"image3\" class=text >";
		newitem+="<br>";
		newitem+="<b>4) Attach File :</b> <input name=\"image4\" type=\"file\" id=\"image4\" class=text >";
		newitem+="<br>";
		newitem+="<b>5) Attach File :</b> <input name=\"image5\" type=\"file\" id=\"image5\" class=text >";
		newitem+="</td></tr>";
		newitem+="<tr><td align=center>";
		newitem+="<INPUT type=\"submit\" value=\"Send / Save\" name=\"Add\" class=\"button\" style=\"width:120px\">";
		newitem+="&nbsp;&nbsp;";
		newitem+="<INPUT type=\"reset\" value=\"Cancel\" name=\"Cancel\" class=\"button\" style=\"width:120px\">";
		newitem+="</td></tr></table>";
		document.getElementById("message").innerHTML=newitem;
		document.form.fill.value=actions;

		}
		else
		{
		newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";
		newitem+="<tr><td>";
		newitem+="<B>Add Record :</B>";
		newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";
		newitem+="</td></tr>";
		newitem+="<tr><td align=center>";
		newitem+="<INPUT type=\"submit\" value=\"Save\" name=\"Add\" class=\"button\" style=\"width:120px\">";
		newitem+="&nbsp;&nbsp;";
		newitem+="<INPUT type=\"reset\" value=\"Cancel\" name=\"Cancel\" class=\"button\" style=\"width:120px\">";
		newitem+="</td></tr></table>";
		document.getElementById("message").innerHTML=newitem;
		document.form.fill.value=actions;
		}
		
	}
-->
</script>  </td>
 </tr>
 <tr>
   <td colspan="2">
<!-- -->
<div id="message">
<table width=100% border=0 cellspacing=1 cellpadding=2 style="border:#CCCCCC solid 1px;">
<tr><td>
<B>Add Record :</B>
<textarea name="txt" cols="48" rows="7" wrap="physical" class="text"  style="width:100%" ><?php echo $desc;?></textarea>
</td></tr>

<tr><td align=center>
<INPUT type="submit" value="save" name="Add" class="button" style="width:120px">
&nbsp;&nbsp;
<INPUT type="reset" value="Cancel" name="Cancel" class="button" style="width:120px">
</td></tr></table>
</div> 
<!-- --></td>
</tr>

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Communication History :</b></td></tr>
<tr>
<td  colspan="2" width=30%  >
<?php function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT fname FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Agent ".$row[0];
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT admin_fname FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".$row[0];
	}
	else{
		$name="";
	}
	return $name;
}

function getAttachment($id,$type,$mode){
	if($mode == "history"){
		if($type=="Quote"){
			$sql = "SELECT * FROM quote WHERE id = $id;";
			$data = mysql_query($sql);
			$row = mysql_fetch_array($data);
			$str = " <a href='./pdf_report/quote/?ran=".$row['ran']."' target='_blank' class='link10'>Quote #".$row['quote_no']."</a>";
		}
		if($type=="Set-Up Fee Invoice"){
			$sql = "SELECT * FROM set_up_fee_invoice WHERE id = $id;";
			$data = mysql_query($sql);
			$row = mysql_fetch_array($data);
			$str = " <a href=./pdf_report/spf/?ran=".$row['ran']."$id target='_blank' class='link10'>Invoice #".$row['invoice_number']."</a>";
		}
		if($type=="Service Agreement"){
			$sql = "SELECT * FROM service_agreement WHERE service_agreement_id = $id;";
			$data = mysql_query($sql);
			$row = mysql_fetch_array($data);
			$str = " <a href='./pdf_report/service_agreement/?ran=".$row['ran']."' target='_blank' class='link10'>Service Agreement #".$id."</a>";
		}
		return $str;
	}
	if($mode == "details"){
		$sql = "SELECT DATE_FORMAT(date_attach,'%D %b %y') FROM history_attachments WHERE attachment = $id AND attachment_type = '$type';";
		$data = mysql_query($sql);
		list($date_sent) = mysql_fetch_array($data);
		if($date_sent!=NULL){
			$str = "Date Sent  ".$date_sent;
		}else{
			$str ="&nbsp;";
		}
		return $str;
	}
}
//Communication history
$sql="SELECT id, history,DATE_FORMAT(date_created,'%D %M %Y %h:%i %p '),agent_no,created_by_type , actions FROM history WHERE leads_id = $leads_id ORDER BY date_created DESC;";
$result=mysql_query($sql);
$email_count = 0;
$call_count = 0;
$notes_count = 0;
$meeting_count = 0;
while(list($id,$history,$date ,$created_by , $created_by_type , $actions) = mysql_fetch_array($result))
{
	$creator = getCreator($created_by , $created_by_type);
	$hist=$history;
	//$history=substr($history,0,200);

	if($actions == 'EMAIL'){
		$email_count++;
		$sqlAttachments = "SELECT attachment,attachment_type FROM history_attachments WHERE history_id = $id;";
		$data=mysql_query($sqlAttachments);
		$att="";
		while(list($attachment,$attachment_type)=mysql_fetch_array($data))
		{
			$att.= getAttachment($attachment,$attachment_type,'history');
		}
		$txt.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
				<div style='float:left;'><b>".$counter.")  ".$date."</b><span style='margin-left:100px; FONT: bold 7.5pt verdana;
    COLOR: #676767;'>Sent the FF :".$att."</span></div>
				<div style='float:right;'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		<div style='clear:both;'></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
.</div>
		<div style='color:#999999;'>-- ".$creator."</div>
</div>";

	}
	
	if($actions == 'CALL'){
		$call_count++;
		$txt2.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
		<div style='float:left;'><b>".$counter.")  ".$date."</b></div>
		<div style='float:right;'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |
		<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		<div style='clear:both;'></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
		.</div>
		<div style='color:#999999;'>-- ".$creator."</div>
		</div>";
	}
	
	if($actions == 'MAIL'){
		$notes_count++;
		$txt3.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
		<div style='float:left;'><b>".$counter.")  ".$date."</b></div>
		<div style='float:right;'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |
		<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		<div style='clear:both;'></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
		.</div>
		<div style='color:#999999;'>-- ".$creator."</div>
		</div>";
	}
	
	if($actions == 'MEETING FACE TO FACE'){
		$meeting_count++;
		$txt4.="<div style='margin-bottom:10px; border-bottom:#FFFFFF solid 1px; padding:5px;'>
		<div style='float:left;'><b>".$counter.")  ".$date."</b></div>
		<div style='float:right;'><a href='apply_action.php?hid=$id&mode=update&id=$leads_id' class='link12b' >Edit</a> |
		<a href='apply_action.php?hid=$id&hmode=delete&id=$leads_id' class='link12b' > Delete</a></div>
		<div style='clear:both;'></div>
		<div style='margin-top:2px; padding:10px;'>"."<a href=javascript:popup_win('./viewHistory.php?id=$id',500,400); title='$hist'>".stripslashes($history)."</a>
		.</div>
		<div style='color:#999999;'>-- ".$creator."</div>
		</div>";
	}

	
}
if($email_count > 0) {
	echo "<p>Email <img src='images/email.gif' alt='Email' width='16' height='10'>";
	echo "<div class='scroll'>".$txt."</div></p>";
}

if($call_count > 0) {
	echo "<p>Call <img src='images/icon-telephone.jpg' alt='Call'>";
	echo "<div class='scroll'>".$txt2."</div></p>";
}

if($notes_count > 0) {
	echo "<p>Notes  <img src='images/textfile16.png' alt='Mail' >";
	echo "<div class='scroll'>".$txt3."</div></p>";
}

if($meeting_count > 0) {
	echo "<p>Meeting face to face <img src='images/icon-person.jpg' alt='Meet personally'>";
	echo "<div class='scroll'>".$txt4."</div></p>";
}








?></td>
</tr>



</table>
</td>
</tr></table>
<script type="text/javascript">
<!--
//showProductForm();
--> 
</script>
<?php include 'footer.php';?>
</form>
</body>
</html>
