<?
include 'config.php';
include 'conf.php';
include 'time.php';


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	header("location:index.php");
}


$leads_id = $_REQUEST['leads_id'];
if($leads_id!=NULL){
	$sql = "SELECT CONCAT(fname,' ',lname) , company_name , agent_id FROM leads WHERE id = $leads_id;";
	$data = mysql_query($sql);
	list($leads_name , $company_name, $agent_id) = mysql_fetch_array($data);
}

//$job_order_id = $_REQUEST['job_order_id'];


$sql ="SELECT * FROM admin WHERE admin_id = $admin_id;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$admin_name = "Welcome Admin :".$row['admin_fname']." ".$row['admin_lname'];
}


$queryAllLeads = "SELECT id, lname, fname  FROM leads l
					WHERE l.status != 'Inactive' ORDER BY l.fname ASC;";
$result = mysql_query($queryAllLeads);
while(list($id, $lname, $fname)=mysql_fetch_array($result))
{
	$company_name ?  "( ".$company_name." )" : '&nbsp;';
	if($leads_id == $id ) {
		$leads_Options.="<option value=".$id." selected>".$fname." ".$lname."</option>";
	}else{
		$leads_Options.="<option value=".$id.">".$fname." ".$lname."</option>";
	}	
}




?>   
<html>
<head>
<title>Admin Recruitment Summary for <?=$leads_name;?> </title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="job_order/job_order.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="job_order/admin_job_order.js"></script>


<script type="text/javascript">
<!--
function goto(job_order_id,job_order_form_id,job_order_list_id) 
{
	var url="admin_recruitment_process.php";
	url=url+"?job_order_id="+job_order_id;
	url=url+"&job_order_form_id="+job_order_form_id;
	url=url+"&leads_id="+<?=$leads_id;?>;
	url=url+"&job_order_list_id="+job_order_list_id;
	//url=url+"&recruitment_details_id="+recruitment_details_id;
	//url=url+"&ran="+Math.random();
	location.href = url;
	
}
-->
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form name="form">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?=$admin_name;?></div>
<div>
<div style=" float:left; font:bold 14px Arial; padding:5px; color:#990000;">JOB RECRUITMENT SUMMARY FOR <?=strtoupper($leads_name);?></div>
<div style="float:right;">
<input type="button" value="back" class="bttn" onClick="self.location='admin_job_order.php'"  />
</div>
</div>
<table width='100%' cellpadding='0' cellspacing='0' border='0' align='center' style="border:#666666 solid 1px;">
<tr style="background:#333333; border:#CCCCCC outset 1px;">
	<td width="3%" valign="top" class="hdr">#</td>
	<td width="23%" valign="top" class="hdr">Job Title</td>
	<td width="12%" valign="top" class="hdr">Recruitment Start Date</td>
	<td width="11%" valign="top" class="hdr">Set-Up Fee Payment</td>
	<td width="28%" valign="top" class="hdr">Comments</td>
	<td width="9%" valign="top" class="hdr">Budget</td>
	<td width="14%" valign="top" class="hdr">Candidates</td>
</tr>

<?
$query = "SELECT job_order_id, created_by_id, created_by_type, status,DATE_FORMAT(j.date_posted,'%D %b %y') , response_by_id, response_by_type ,  			DATE_FORMAT(j.date_filled_up,'%D %b %y') FROM job_order j WHERE leads_id = $leads_id AND form_filled_up ='yes';";
$result = mysql_query($query);
while(list($job_order_id, $created_by_id, $created_by_type, $status, $date_posted, $response_by_id, $response_by_type , $date_filled_up)=mysql_fetch_array($result))
{
	echo "<tr bgcolor='#CCCCCC'><td valign='top' colspan='7' class='list'><b>&nbsp;Job Order / Request #".$job_order_id."</b></td></tr>";

	/*
	$queryJobForms = "SELECT j.job_order_form_id,f.job_order_form_title 
					FROM job_order_list j LEFT JOIN  job_order_form f ON f.job_order_form_id = j.job_order_form_id 
					WHERE job_order_id = $job_order_id AND j.job_order_form_status = 'finished';";
	*/				
	$queryJobForms = "SELECT j.job_order_list_id,j.job_order_form_id,f.job_order_form_title
						FROM job_order_list j LEFT JOIN job_order_form f ON f.job_order_form_id = j.job_order_form_id
						WHERE job_order_id = $job_order_id AND j.job_order_form_status = 'finished';";
	//echo $queryJobForms;					
	$data = mysql_query($queryJobForms);
	$counter = 0;
	
	while(list($job_order_list_id,$job_order_form_id,$job_order_form_title)=mysql_fetch_array($data))
	{
		$counter++;
		$recruitment_start_date="";
		$set_up_fee_payment="";
		$budget="";
		$jd_link="";
		$recruitment_details_id="";
		$comments="";
		$no_candidates="";
				
		$sql = "SELECT r.recruitment_details_id , DATE_FORMAT(r.recruitment_start_date,'%D %b %Y'), r.set_up_fee_payment, r.budget, r.jd_link 
				FROM recruitment_details r 
				WHERE job_order_id = $job_order_id 
				AND job_order_form_id = $job_order_form_id 
				AND job_order_list_id = $job_order_list_id;";
		$resulta = mysql_query($sql);		
		$ctr=@mysql_num_rows($resulta);
		if($ctr > 0) {
			list($recruitment_details_id , $recruitment_start_date, $set_up_fee_payment, $budget, $jd_link)=mysql_fetch_array($resulta);
		}
		
		
		?>
		<tr>
			<td valign="top" class="list"><?=$counter?></td>
			<td valign="top" class="list"><input type="radio" name="process" onClick ="goto(<?=$job_order_id;?>,<?=$job_order_form_id;?>,<?=$job_order_list_id;?>); return false;" >&nbsp;<?=$job_order_form_title;?></td>
			<td valign="top" class="list">&nbsp;<?=$recruitment_start_date;?></td>
			<td valign="top" class="list">&nbsp;<?=$set_up_fee_payment;?></td>
			<td valign="top" class="list">&nbsp;
			<?
			$queryComments = "SELECT comments FROM recruitment_details_notes r WHERE recruitment_details_id = $recruitment_details_id ORDER BY date_added DESC;";
			$resultComments = mysql_query($queryComments);
			list($comments) = mysql_fetch_array($resultComments);
			echo substr($comments,0,100);
			
			?>
			
			</td>
			<td valign="top" class="list">&nbsp;<?=$budget;?></td>
			<td valign="top" class="list">&nbsp;
			<?
			$queryCandidates="SELECT COUNT(r.recruitment_candidates_id) FROM recruitment_candidates r 
				WHERE job_order_id = $job_order_id 
				AND job_order_form_id = $job_order_form_id 
				AND job_order_list_id = $job_order_list_id;";
			$resultCandidates = mysql_query($queryCandidates);	
			list($no_candidates) = mysql_fetch_array($resultCandidates);
			if($no_candidates > 0){
				echo $no_candidates ." candidates;";
			}
			
			?></td>
		</tr>
		<?
	
	}


}
?>
</table>






<? include 'footer.php';?>	
<script type="text/javascript">
<!--
//showLeadsJobOrderList(<?=$leads_id;?>);
-->
</script>
</form>	
</body>
</html>
