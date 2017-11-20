<?php
include './conf/zend_smarty_conf.php';
include './admin_subcon/subcon_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;



if($_SESSION['admin_id']==""){
	header("location:index.php");
	exit;
}



if($admin_status == 'HR'){
	$resume_page = "recruiter/staff_information.php";
}else{
	$resume_page = "application_apply_action.php";
}


$search_str ="";
if(isset($_POST['search'])){
    if($_POST['month'] > 0 and $_POST['year'] != ""){
        $search_str = " AND MONTH(s.scheduled_date) = '".$_POST['month']."' AND YEAR(s.scheduled_date) = '".$_POST['year']."' ";
	}else if($_POST['month'] > 0 and $_POST['year'] == ""){
	    $search_str = " AND MONTH(s.scheduled_date) = '".$_POST['month']."' ";
	}else if($_POST['month'] == 0 and $_POST['year'] != ""){
	    $search_str = " AND YEAR(s.scheduled_date) = '".$_POST['year']."' ";
	}else{
	    $search_str ="";
	}
}

if(isset($_POST['export'])){
    if($_POST['month'] > 0 and $_POST['year'] != ""){
        $search_str = " AND MONTH(s.scheduled_date) = '".$_POST['month']."' AND YEAR(s.scheduled_date) = '".$_POST['year']."' ";
	}else if($_POST['month'] > 0 and $_POST['year'] == ""){
	    $search_str = " AND MONTH(s.scheduled_date) = '".$_POST['month']."' ";
	}else if($_POST['month'] == 0 and $_POST['year'] != ""){
	    $search_str = " AND YEAR(s.scheduled_date) = '".$_POST['year']."' ";
	}else{
	    $search_str ="";
	}
}


//day of the week and determines the staff working hours based on the day of the week per column field of subcontractors table.
$weekday_str = strtolower(date('D'))."_start";
$weekday_str_finish = strtolower(date('D'))."_finish";

// parse all records who are scheduled today
$sql = "SELECT s.id, s.subcontractors_status, s.scheduled_date, s.subcontractors_id , s.reason, s.date_created, (c.id)AS sid ,c.userid, c.leads_id, (p.fname)AS staff_fname, (p.lname)AS staff_lname, (p.email)AS staff_email, l.fname, l.lname , l.email, (l.status)AS leads_status, c.status, p.registered_email, p.skype_id, p.tel_area_code, p.tel_no, c.work_status, c.starting_date, c.job_designation , c.staff_working_timezone, ($weekday_str)AS work_hour, ($weekday_str_finish)AS work_hour_finish, c.flexi, a.admin_fname, s.reason_type, s.replacement_request, s.service_type

FROM subcontractors_scheduled_close_cotract s
JOIN subcontractors c ON c.id = s.subcontractors_id
JOIN personal p ON p.userid = c.userid
JOIN leads l ON l.id = c.leads_id
JOIN admin a ON a.admin_id = s.added_by_id
WHERE s.status = 'waiting' ".$search_str." ORDER BY s.scheduled_date ASC;";
//echo $sql;
$schedules = $db->fetchAll($sql);



foreach($schedules as $staff){
	$ctr++;
	
	if($bgcolor=="#FFFFFF"){
		$bgcolor="#CCFFCC";
	}else{
		$bgcolor="#FFFFFF";
	}
	
	
	//if($staff['image']!=""){
		$image = "<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id=".$staff['userid']."' border='0' align='texttop'  />";
	//}else{
	//	$image = "<img src='images/ava002.jpg' border='0' align='texttop' width='48'  />";
	//}
	
	$working_status = $staff['status'];
		
	
    $resultOptions .="<tr bgcolor='$bgcolor' class='staff_name'>";	
	$resultOptions .="<td valign='top'>".$ctr."</td>";
	$resultOptions .="<td valign='top'><a href=".$resume_page."?userid=".$staff['userid']." target='_blank'>".$image."</a><div style='float:left; display:block;'><small>USERID : ".$staff['userid']."</small><br> <a href=".$resume_page."?userid=".$staff['userid']." target='_blank'><b>".$staff['staff_fname']." ".$staff['staff_lname']."</b></a><br>Staff Email : ".$staff['staff_email']."<br>Personal Email : ".$staff['registered_email']."<br>".$staff['skype_id']."<br>".$staff['tel_area_code'].$staff['tel_no']."</div></td>";
	$resultOptions .="<td valign='top'>";
	
	    $det = new DateTime($staff['starting_date']);
	    $starting_date = $det->format("F j, Y");
		if($staff['work_hour']){
	        $date = new DateTime($staff['work_hour']);
	        $staff_start_work_hour = $date->format('H:i');
	        $staff_start_work_hour_str = $date->format('h:i a');
	    }
			
		if($staff['work_hour_finish']){
	        $date = new DateTime($staff['work_hour_finish']);
	        $staff_finish_work_hour = $date->format('H:i');
	        $staff_finish_work_hour_str = $date->format('h:i a');
	    }
		if($staff['flexi'] == 'no'){
		    $work_schedule = sprintf('%s to %s %s', $staff_start_work_hour_str, $staff_finish_work_hour_str, $staff['staff_working_timezone']);
		}else{
		    $work_schedule = 'Flexi';
		}	
		
		$service_type_str="";
		if($staff['service_type']){
			$service_type_str=sprintf('<br>Service Type : %s', $staff['service_type']);
		}
			
			$date = new DateTime($staff['scheduled_date']);
			$end_date_str = $date->format("Y-m-d");
			if($staff['subcontractors_status'] == 'terminated'){
				$subcontractors_status = 'termination';
			}else{
				$subcontractors_status = 'resignation';
			}
			//$label ="<p>This staff contract is already scheduled for ".$subcontractors_status." on ".$date->format("M d, Y"). "<br>Replace it with a new date ?</p>";
			$scheduled_label ="<div><b>Staff contract scheduled for ".$subcontractors_status."</b></div>
			Scheduled By : ".$staff['admin_fname']."<br />
			Scheduled Date : ".$date->format("F d, Y")."<br />
			Reason Type : ".$staff['reason_type']."<br>
			Reason : <em>".$staff['reason']."</em><br>
			Replacement Request : ".$staff['replacement_request'];
	
	
			$resultOptions.= "<div style='float:right; background:yellow; border:#333 dashed 1px; padding:3px; width: 300px; display:block; margin-top:5px;'>".$scheduled_label."</div>";
		
		
		    $contract_link = "contractForm.php?sid=".$staff['sid'];
			$resultOptions.= "<div><input type='radio' align='absmiddle' name='userid' onclick=javascript:location.href='$contract_link' /> <a href='leads_information.php?id=".$staff['leads_id']."&lead_status=".$staff['leads_status']."' target='_blank'><b>".$staff['fname']." ".$staff['lname']."</b></a></div><div style='margin-left:25px;'>Work Status : <span style='color:red;font-weight:bold;'>".$staff['work_status']."</span><br>Starting Date : ".$starting_date."<br>Job Designation : <b>".$staff['job_designation']."</b><br />Work Schedule : ".$work_schedule.$service_type_str."</div>";
			
		
		
		
	$resultOptions .="</td>";	
	$resultOptions .="</tr>";
		
	
		
	//array_push($counters,$ctr);
	
}

if(isset($_POST['export'])){

    //Validate if the admin can export this report.
    $sql=$db->select()
        ->from('admin')
	    ->where('admin_id =?',$_SESSION['admin_id']);
    $admin = $db->fetchRow($sql);

	if($admin['export_subconlist_reporting'] == 'N'){
		
		$body = sprintf('Admin #%s %s %s is trying to export Scheduled Staff Contract Termination.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
		$body .= sprintf('<p><em>%s</em></p>', $_SERVER['SCRIPT_FILENAME']);
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyHtml($body);
		$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
		
		if(!TEST){
			$mail->addTo('admin@remotestaff.com.au', 'Admin');
			$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
			$mail->setSubject("ALERT Scheduled Staff Contract Termination Exporting Permission Denied.");
		}else{
			$mail->addTo('devs@remotestaff.com.au', 'DEVS');
			$mail->setSubject("TEST ALERT Scheduled Staff Contract Termination Exporting Permission Denied.");
		}	
		
		$mail->send($transport);
		die("Scheduled Staff Contract Termination Permission Denied");
	}


    $tmpfname = tempnam(null, null);
    $handle = fopen($tmpfname, "w");
	
	
	//put csv header
	fputcsv($handle, array(
		'Userid', 
		'Staff First Name', 
		'Staff Last Name',
		'Staff Email', 
		'Client',
		'Work Status',
		'Starting Date',
		'Job Designation',
		'Scheduled Date',
		'Reason',
		'Reason Type',
		'Replacement Request'
		));
	
	foreach ($schedules as $line) {
		$det = new DateTime($line['starting_date']);
	    $starting_date = $det->format("F j, Y");
		
		$det = new DateTime($line['scheduled_date']);
	    $scheduled_date = $det->format("F j, Y");
				
		$record = array($line['userid'], 
			$line['staff_fname'],
			$line['staff_lname'],
			$line['staff_email'],
			$line['fname']." ".$line['lname'],
			$line['work_status'],
			$starting_date,
			$line['job_designation'],
			$scheduled_date,
			$line['reason'],
			$line['reason_type'],
			$line['replacement_request']
		);
		fputcsv($handle, $record);
	}

    $filename = "scheduled_staff_contract_termination_".basename($tmpfname . ".csv");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    //header('Content-Disposition: attachment; filename=STAFF_SHIFT_DETAILS'.$tmpfname . ".csv");
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($tmpfname));
	
	ob_clean();
    flush();
    readfile($tmpfname);
    unlink($tmpfname);
}




$years = array();
for($i=2011; $i<=date("Y"); $i++ ){
    array_push($years, $i);
}

$months = array("-", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


$smarty->assign('num_reccords', count($schedules));
$smarty->assign('year', $_POST['year']);
$smarty->assign('month', $_POST['month']);
$smarty->assign('years', $years);
$smarty->assign('months', $months);
$smarty->assign('resultOptions',$resultOptions);
$smarty->display('scheduled_staff_contract_termination.tpl');
?>