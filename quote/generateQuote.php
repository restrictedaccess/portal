<?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

$ran = get_rand_id();
$ran = CheckRan($ran);
//Check random character if existing in the table quote 
function CheckRan($ran){
	$query = "SELECT * FROM quote WHERE ran = '$ran';";
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





$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

//echo $_SESSION['agent_no']."<br>";

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	$agent_id = 2; // BP Id of Chris
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
	$agent_id = $agent_no;
	
	$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
	$result=mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
		$row = mysql_fetch_array ($result); 
		$name = $row['fname']." ".$row['lname'];
		$agent_code = $row['agent_code'];
		$length=strlen($agent_code);
		$tracking_no =$agent_code."OUTBOUNDCALL";
	}

}


$mode = $_REQUEST['mode'];



if($mode=="")
{
	die("Mode is missing..!");
}

/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip
*/


if($mode == "manual")
{
	$leads_fname = $_REQUEST['leads_fname'];
	$leads_lname = $_REQUEST['leads_lname'];
	$leads_email = $_REQUEST['leads_email'];
	$leads_company = $_REQUEST['leads_company'];
	$leads_address = $_REQUEST['leads_address'];
	
	// Save first the new leads to the system

	// create a personal id 
	$y =date('Y');
	$m =date('m');
	$d= date('d');
	$date =$y."-".$m."-".$d; 
	$sql="SELECT * FROM leads  WHERE DATE_FORMAT(timestamp,'%Y-%m-%d') = '$date';";
	//echo $sql."<br>";
	$res=mysql_query($sql);
	$ctr=@mysql_num_rows($res);
	if ($ctr >0 )
	{
		$row = mysql_fetch_array ($res); 
		$ctr=$ctr+1;
		$personal_id="L".$y.$d.$m."-".$ctr;	
	}
	else
	{	$ctr=1;
		$personal_id="L".$y.$d.$m."-".$ctr;	
	}

	$query = "INSERT INTO leads SET tracking_no = '$tracking_no', agent_id = $agent_id, , business_partner_id = $agent_no , timestamp = '$ATZ', status = 'New Leads', lname = '$leads_lname', fname = '$leads_fname', email = '$leads_email' , personal_id = '$personal_id' , company_name = '$leads_company' , company_address = '$leads_address' ;";
	$result=mysql_query($query);
	if(!$result){
		die("ERROR IN SCRIPT.<BR>".$query);
	}
	$leads_id = mysql_insert_id();
	
	
	// INSERT INTO quote
	$sql="SELECT COUNT(id) FROM quote;";
	$result = mysql_query($sql);
	list($counter)=mysql_fetch_array($result);
	$counter++;
	$quote_no = $counter.date("Y").date("m");

	
	
	// id, created_by, created_by_type, leads_id, date_quoted, quote_no, status, date_posted, ran
	$query = "INSERT INTO quote SET created_by = $created_by, created_by_type = '$created_by_type', leads_id = $leads_id, date_quoted = '$ATZ', quote_no = $quote_no , ran = '$ran';";
	//echo $leads_id;
	//echo $query;
	$result = mysql_query($query);
	$id = mysql_insert_id();
	if(!$result){
		die("ERROR IN SCRIPT.<BR>".$query);
	}
	//echo $id;
			
}

if($mode == "leads"){
	// INSERT INTO quote
	$sql="SELECT COUNT(id) FROM quote;";
	$result = mysql_query($sql);
	list($counter)=mysql_fetch_array($result);
	$counter++;
	$quote_no = $counter.date("Y").date("m");

	$leads_id =$_REQUEST['leads_id'];
	
	// id, agent_no, leads_id, date_quoted, quote_no, status
	$query = "INSERT INTO quote SET created_by = $created_by, created_by_type = '$created_by_type', leads_id = $leads_id, date_quoted = '$ATZ', quote_no = $quote_no, ran = '$ran' ;";
	//echo $leads_id;
	//echo $query;
	$result = mysql_query($query);
	$id = mysql_insert_id();
	if(!$result){
		die("ERROR IN SCRIPT.<BR>".$query);
	}
	//echo $id;
}

// id, created_by, created_by_type, leads_id, date_quoted, quote_no, status
$query = "SELECT q.quote_no, DATE_FORMAT(date_quoted,'%D %b %Y'),CONCAT(l.fname,' ',l.lname) , l.email,l.company_name, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price,d.id , d.currency , q.created_by, q.created_by_type , DATE_FORMAT(q.date_posted,'%D %b %Y') , l.company_address , q.status , d.work_status 
		   FROM quote q 
		   LEFT JOIN leads l ON l.id = q.leads_id 
		   LEFT JOIN quote_details d ON d.quote_id = q.id
		   WHERE q.id = $id;";
$result = mysql_query($query);
list($quote_no,$date,$leads_name,$email,$company_name, $salary, $client_timezone, $client_start_work_hour, $client_finish_work_hour, $lunch_start, $lunch_out, $lunch_hour, $work_start, $work_finish, $working_hours, $days, $quoted_price ,$quote_details_id ,$currency_rate,$by, $by_type , $date_posted , $company_address , $status ,$work_status )=mysql_fetch_array($result);
//echo $query;
 if ($status == "new") $status = "draft";
 
function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT fname,work_status FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row[1]." :".$row[0];
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

?>
<input type="hidden" id="id" value="<?=$id;?>">
<div id="template" style="font:12px Arial; padding:10px;  border:#CCCCCC solid 1px;">
<div>
	<div style="float:left; display:block; width:300px;">
		<div><img src='images/remote_staff_logo.png' width='267' height='91' /></div>
		<div style="margin-top:10px; padding:5px;">
		PO Box 1211 Double Bay NSW Australia 1360<br />
		PH: 02 9016 4461<br />
		Fax: 02 8088 7242<br />
		Email: admin@remotestaff.com.au
		
		</div>
	</div>
	<div style="float:right; display:block; width:300px; margin-left:0px;">
		<div><img src='images/think_innovations_logo.png' width='267' height='102' /></div>
		<div style="margin-top:10px; padding:5px;">
		Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
		Website: www.remotestaff.com.au<br />

		</div>	
	</div>
	
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px; text-align:center; font:bold 16px Arial;">QUOTE NO. <?=$quote_no;?></div>
<div style="background:#E9E9E9; border:#E9E9E9 outset 1px; padding:5px; margin-top:10px;"><B>Client</B></div>
<div style="border:#E9E9E9 solid 1px; padding:5px;">
	<div>
		<div style="float:left; width:500px;">
			<p><label><b>Leads :</b></label><?=strtoupper($leads_name);?></p>
			<p><label><b>Email : </b></label><?=$email;?></p>
			<p><label><b>Company :</b></label><?=$company_name ? $company_name : '&nbsp;';?></p>
			<p><label><b>Address :</b></label><?=$company_address ? $company_address : '&nbsp;';?></p>
		</div>	
		<div style="float:left;">
			<p><label><b>Quoted By: </b></label><b style="color:#990000;"><?=getCreator($by , $by_type);?></b></p>
			<p><label><b>Quote Date :</b></label> <?=$date;?></p>
			<p><label><b>Quote No.</b></label><?=$quote_no;?></p>
			<p><label><b>Status </b></label><?=strtoupper($status);?></p>
			<p><label><b>Date Posted</b></label><span id="date_posted"><?=$date_posted ? $date_posted : '&nbsp;';?></span></p>		</div>	
		<div style="clear:both;"></div>	
	</div>
</div>
<div style="padding:5px;">
<input type="button" value="Add Quote Details" onClick="showQuoteForm(<?=$id;?>);" />
<!--<input type="button" value="Post" onClick="postQuote();">-->
<input type="button" value="Export to PDF" onClick="self.location='pdf_report/quote/?id=<? echo $id;?>'">
<input type="button" value="Delete" onClick="deleteQuote();">
<input type="button" value="Cancel" onClick="hide('template');">
</div>

<div style="background:#D2FFD2 ;border:#D2FFD2 outset 1px; padding:5px; margin-top:10px;"><B>QUOTE DETAILS</B></div>
<div id="quote_details" style="border:#D2FFD2 solid 1px; padding:5px;">&nbsp;</div>

</div>