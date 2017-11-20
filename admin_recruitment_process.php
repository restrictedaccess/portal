<?
include 'config.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	header("location:index.php");
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
		$name="&nbsp;";
	}
	return $name;
}

$leads_id = $_REQUEST['leads_id'];
$job_order_id = $_REQUEST['job_order_id'];
$job_order_form_id = $_REQUEST['job_order_form_id'];
$job_order_list_id = $_REQUEST['job_order_list_id'];


/*
recruitment_details_id, job_order_id, job_order_form_id, leads_id, job_order_list_id, recruitment_start_date, set_up_fee_payment, budget, jd_link, created_by_id, created_by_type, date_created, last_update_date, updated_by_id, updated_by_type
*/
$sql = "SELECT r.recruitment_details_id , r.recruitment_start_date, r.set_up_fee_payment, r.budget, r.jd_link ,created_by_id, created_by_type, DATE_FORMAT(date_created, '%D %b %Y'), DATE_FORMAT(last_update_date,'%D %b %Y'), updated_by_id, updated_by_type
				FROM recruitment_details r 
				WHERE job_order_id = $job_order_id 
				AND job_order_form_id = $job_order_form_id 
				AND job_order_list_id = $job_order_list_id;";
$resulta = mysql_query($sql);		
$ctr=@mysql_num_rows($resulta);
if($ctr > 0) {
	list($recruitment_details_id , $recruitment_start_date, $set_up_fee_payment, $budget, $jd_link ,$created_by_id, $created_by_type, $date_created, $last_update_date, $updated_by_id, $updated_by_type)=mysql_fetch_array($resulta);
}else{

	//$recruitment_details_id = $_REQUEST['recruitment_details_id'];
	$query = "INSERT INTO recruitment_details SET 
				job_order_id = $job_order_id, 
				job_order_form_id = $job_order_form_id, 
				leads_id = $leads_id, 
				job_order_list_id = $job_order_list_id, 
				created_by_id = $admin_id, 
				created_by_type = 'admin' , 
				date_created = '$ATZ';";
	$result = mysql_query($query);
	//echo $query;
	if(!$result) die("Error in Script!");
	$recruitment_details_id = mysql_insert_id();
	
	/////
	$QUERY = "SELECT r.recruitment_details_id , r.recruitment_start_date, r.set_up_fee_payment, r.budget, r.jd_link ,created_by_id, created_by_type, DATE_FORMAT(date_created, '%D %b %Y'), DATE_FORMAT(last_update_date,'%D %b %Y'), updated_by_id, updated_by_type
				FROM recruitment_details r 
				WHERE recruitment_details_id = $recruitment_details_id;"; 
	$resulta = mysql_query($QUERY);	
	list($recruitment_details_id , $recruitment_start_date, $set_up_fee_payment, $budget, $jd_link ,$created_by_id, $created_by_type, $date_created, $last_update_date, $updated_by_id, $updated_by_type)=mysql_fetch_array($resulta);		
	
}



//job_order_form_id, job_order_form_title, job_order_form_desc
$query = "SELECT job_order_form_title FROM job_order_form j WHERE job_order_form_id = $job_order_form_id;";
$data = mysql_query($query);
list($job_order_form_title) = mysql_fetch_array($data);


if($leads_id!=NULL){
	$sql = "SELECT CONCAT(fname,' ',lname) , company_name , agent_id FROM leads WHERE id = $leads_id;";
	$data = mysql_query($sql);
	list($leads_name , $company_name, $agent_id) = mysql_fetch_array($data);
}




$sql ="SELECT * FROM admin WHERE admin_id = $admin_id;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$admin_name = "Welcome Admin :".$row['admin_fname']." ".$row['admin_lname'];
}



$set_up_fee_paymentArray=array("HOLD","PAID","BARTER","CANCEL","REPLACEMENT");
for($i=0; $i<count($set_up_fee_paymentArray);$i++){
	if($set_up_fee_payment == $set_up_fee_paymentArray[$i]){
		$set_up_fee_payment_Options.="<option value=".$set_up_fee_paymentArray[$i]." selected>".$set_up_fee_paymentArray[$i]."</option>";
	}else{
		$set_up_fee_payment_Options.="<option value=".$set_up_fee_paymentArray[$i].">".$set_up_fee_paymentArray[$i]."</option>";
	}
}


?>   
<html>
<head>
<title>Admin Recruitment Process for <?=$leads_name;?> Job Order #<?=$job_order_id;?> </title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="job_order/job_order.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="job_order/admin_job_order.js"></script>
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />


<script type="text/javascript">
<!--
function goto(job_order_id,job_order_form_id) 
{
	//location.href = "apply_action.php?id="+id;
	//alert(job_order_id+" "+job_order_form_id);
}
-->
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form name="form">
<input type="hidden" id="leads_id" name="leads_id" value="<?=$leads_id;?>">
<input type="hidden" id="job_order_id" name="job_order_id" value="<?=$job_order_id;?>">
<input type="hidden" id="job_order_form_id" name="job_order_form_id" value="<?=$job_order_form_id;?>">
<input type="hidden" id="job_order_list_id" name="job_order_list_id" value="<?=$job_order_list_id;?>">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="text" id="recruitment_details_id" name="recruitment_details_id" value="<?=$recruitment_details_id;?>">


<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?=$admin_name;?></div>


<div style="background:#006699; border:#006699 solid 1px; color:#FFFFFF;font:bold 14px Arial; padding:2px;">
<div style=" float:left; line-height:20px;">JOB RECRUITMENT PROCESS FOR <?=strtoupper($leads_name);?></div>
<div style="float:right;"><input type="button" value="back" class="bttn" onClick="self.location='admin_recruitment_summary.php?leads_id=<? echo $leads_id;?>'"  /></div>
<div style="clear:both;"></div>
</div>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right:#006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'adminleftnav.php';?>
</td>
<td width=100% valign='top' style=" font:12px Arial;">
<div style="height:50px;">
	<div style="float:left; display:block; width:500px;">
		<div style="padding:5px;"><b>Job Order #<?=$job_order_id;?></b></div>
		<div style="padding:5px;"><b>Job Requested Form [ <?=$job_order_form_title;?> ]</b></div>
	</div>
	<div id="date_history" style="float:left; display:block; width:500px; padding:5px;">
		<p><label>Date Created : </label><?=$date_created;?></p>
		<p><label>Created By : </label><?=getCreator($created_by_id, $created_by_type);?></p>
	 	<p><label>Last Update : </label><?=$last_update_date ? $last_update_date : '&nbsp;';?></p>
		<p><label>Created By : </label><?=getCreator($updated_by_id, $updated_by_type);?></p>
	</div>
	<div style=" clear:both;"></div>
</div>
<table id="manage" width="100%"  >
	<tr>
		<td width="16%" valign="top"><strong>Recruitment Start Date</strong></td>
		<td width="26%" valign="top"> <input type="text" name="recruitment_start_date" id="recruitment_start_date" class="select" value="<?=$recruitment_start_date;?>"  >
  <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" 
  onMouseOut=""   />
  <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "recruitment_start_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td>
		<td width="14%"><strong>Set-Up Fee Payment</strong></td>		  
		<td width="44%"><select id="set_up_fee_payment" name="set_up_fee_payment" class="select">
		<option value="">--Please Choose--</option>
		<?=$set_up_fee_payment_Options;?>
		</select></td>		  
	</tr>
	<tr>
		<td><b>Budget</b></td>
		<td><input type="text" class="select" id="budget" name="budget" value="<?=$budget;?>"></td>
		<td><b>JD Link</b></td>
		<td><input type="text" class="select" id="jd_link" name="jd_link" value="<?=$jd_link;?>" style="width:400px;"></td>
	</tr>
	
	<tr>
	<td colspan="4" valign="top">
	<div style="padding:5px;"><strong>Notes / Comments</strong></div>
	<div id="recruitment_notes" style="display:block; overflow:auto; height:150px; border:#0000FF ridge 2px;">
	<?
		$query = "SELECT recruitment_details_notes_id, added_by_id, added_by_type, DATE_FORMAT(date_added,'%a %b %e %Y %r'), comments 
		FROM recruitment_details_notes r WHERE recruitment_details_id = $recruitment_details_id ORDER BY date_added DESC;";
		$data = mysql_query($query);		
		while(list($recruitment_details_notes_id, $added_by_id, $added_by_type, $date_added, $comments)=mysql_fetch_array($data))
		{
			?>
			<div style="border-bottom:#CCCCCC solid 1px; padding:2px;">
				<div style="text-align:right; color:#666666;font:11px tahoma;"><?=$date_added;?></div>
				<div><?=$comments;?></div>
				<div style="color:#999999; font:11px tahoma;"><?=getCreator($added_by_id, $added_by_type);?></div>
			</div>	
			<?
		}
	?>
	</div>
	<div style="padding:5px; background:#666666;">
	<div style="float:left; width:810px;">
		<textarea id="comments" name="comments" class="select"  style="height:50px; width:800px;" ></textarea>
	</div>
	<div style="float:left;">	
	  	<input align="absmiddle" type="button" value="Save Details" class="bttn" style=" height:40px; " onClick="saveRecruitmentDetails();">
	</div>	
	<div style="clear:both;"></div>
	 </div> 
	  </td>
	</tr>
	<tr>
	<td colspan="4" valign="top">
	<div >
	<div style="padding:5px; border-bottom: #CCCCCC solid 1px;">
		<div style="float:left;"><b style="color:#FF0000;">Applicants</b></div>
		<div style="float:right;"><input type="button" class="bttn" value="Add Candidates" onClick="javascript:showCandidatesAddForm(0);"></div>
		<div style="clear:both;"></div>
	</div>
	<div id="candidates_add_form" style="display:none;"></div>
	<div id="notes_add_form" style="display:none; position:absolute; background:#CCCCCC; left: 537px; top: 462px;"></div>
	<div id="rating_form" style="display:; position:absolute; background:#CCCCCC; left: 800px; top: 474px;"></div>
	<div id="applicant_list" style=" background:#F4F4F4;"></div>
	</div>
	</td></tr>
	
</table>
</td>
</tr>
</table>
<script type="text/javascript">
<!--
showCandidates();
-->
</script>
<? include 'footer.php';?>	
</form>	
</body>
</html>
