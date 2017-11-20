<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}

$list = $_REQUEST['list'];
//echo $list;exit;
if(!$list){
		
		$year = $_REQUEST['year'];
		$month = $_REQUEST['month'];
		$active = $_REQUEST['active'];
		
		$from = $_REQUEST['from'];
		$to = $_REQUEST['to'];
		
		$monthFullName=array(
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December' 
		);
		
		if($month and $year){
			if($month == 'A'){
				$start_date_str = $year."-01-01 00:00:00";
				$end_date_str = $year."-06-30 23:59:59";
				$date_str = " starting_date BETWEEN '".$start_date_str."' AND '".$end_date_str."' ";
			}else if($month == 'B'){
				$start_date_str = $year."-07-01 00:00:00";
				$end_date_str = $year."-12-31 23:59:59";
				$date_str = " starting_date BETWEEN '".$start_date_str."' AND '".$end_date_str."' ";
			}else if($month == 'C'){
				$date_str = " YEAR(starting_date) = '".$year."' ";
				$date_hdr = $year;
			}else{
				$date_str = " YEAR(starting_date) = '".$year."' AND MONTH(starting_date)= '".$month."' ";
				$date_hdr = $year." ".$monthFullName[$month];
			}
		}else{
			$start_date_str = $from." 00:00:00";
			$end_date_str = $to." 23:59:59";
			$date_str = " starting_date BETWEEN  '".$from."' AND '".$to."' ";
			
		}
		
		
		if($active == 'yes'){
			$status_option = " s.status IN ('ACTIVE', 'suspended') AND ";
			$status_str = "ACTIVE STAFF";
		}else{
			$status_option = " s.status IN('terminated', 'resigned') AND ";
			$status_str = "CANCELLED STAFF";
		}
		
		$sql = "SELECT s.id, s.userid , fname , lname , email  FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE ".$status_option.$date_str."   ORDER BY p.fname;";
		//echo $sql;exit;
		$staffs = $db->fetchAll($sql);
		foreach($staffs as $staff){
			//#eeeeee,#d0d0d0
			$ctr++;
			if($bgcolor == '#eeeeee'){
				$bgcolor = '#d0d0d0';
			}else{
				$bgcolor = '#eeeeee';
			}
			$staff_list.="<tr bgcolor='".$bgcolor."'>
			<td width='5%'>".$ctr."</td>
			<td width='35%'><img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id=".$staff['userid']."' style='float:left; margin-right:10px;' />
			<strong>".$staff['userid']." ".$staff['fname']." ".$staff['lname']."</strong><br />
			<small>".$staff['email']."</small></td>";
			
			$staff_list.="<td width='60%' valign='top' style='font-size:10px;'>";
				//if($month and $year){
					$sql="SELECT `s`.`id`,`s`.`leads_id`, `s`.`starting_date`, `s`.`date_terminated` , `s`.`resignation_date` , `s`.`status` ,  `l`.`fname`, `l`.`lname`, `l`.`email` FROM `subcontractors` AS `s` INNER JOIN `leads` AS `l` ON l.id = s.leads_id WHERE ".$status_option." (s.userid ='".$staff['userid']."') AND ".$date_str." ORDER BY `s`.`starting_date` ASC";
				//}else{
					
				//}
				//$staff_list.=$sql;
				$leads = $db->fetchAll($sql);
				foreach($leads as $lead){
					$det = new DateTime($lead['starting_date']);
					$timestamp = $det->format("F j, Y");
					
					
					
					if($active != "yes"){
						if($lead['status'] == 'terminated'){
							if($lead['date_terminated']){
								$det = new DateTime($lead['date_terminated']);
								$date_terminated = $det->format("F j, Y");
								$staff_list.="<span style='float:right;color:red;'>Contract Date Terminated : ".$date_terminated."</span>";
							}
						}else if($lead['status'] == 'resigned'){
							if($lead['resignation_date']){
								$det = new DateTime($lead['resignation_date']);
								$resignation_date = $det->format("F j, Y");
								$staff_list.="<span style='float:right;color:red;'>Resignation Date : ".$resignation_date."</span>";
							}
						}
					}
					
					$staff_list.="<div>".$lead['fname']." ".$lead['lname']." [ ".$lead['email']." ] ".$timestamp."</div>";
				}		
			$staff_list.="</td>";
			$staff_list.="</tr>";
			
		}

}
else{
		
		
		if(!$from){
			$from = date("Y-m-d");
		}
		
		if(!$to){
			$to = $from;
		}
		//echo $from;
		$start_date_of_leave = explode('-',$to);
		$year = $start_date_of_leave[0];
		$month = $start_date_of_leave[1];
		$day = $start_date_of_leave[2];
		
		$date = new DateTime();
		$date->setDate($year, $month, $day);
		$date->modify("+1 day");
		$date_end_str = $date->format("Y-m-d");
		
		if($list != 'not working'){
			$sql = $db->select()
				->from(array('a' => 'activity_tracker') , Array('userid' , 'status', 'subcontractors_id', 'leads_id' , 'leads_name'))
				->join(array('p' => 'personal') , 'p.userid = a.userid' , Array('fname' , 'lname', 'email'))
				->join(array('l' => 'leads') , 'l.id = a.leads_id' , array('leads_email' => 'email'))
				->where('a.status =?' , $list)
				->order('p.fname');
			$staffs = $db->fetchAll($sql);
			foreach($staffs as $staff){
				//#eeeeee,#d0d0d0
				$ctr++;
				if($bgcolor == '#eeeeee'){
					$bgcolor = '#d0d0d0';
				}else{
					$bgcolor = '#eeeeee';
				}
				
				//get timerecord
				$query="SELECT *  FROM timerecord t WHERE subcontractors_id =  ".$staff['subcontractors_id']." AND time_in BETWEEN '".$from." 00:00:00' AND '".$date_end_str." 23:59:59' ;";
				//echo $query;	
				$staff_timerecords = $db->fetchAll($query);
				$staff_timerecord_str="";
				$staff_timerecord_time_in ="";
				$staff_timerecord_time_out ="";
				foreach($staff_timerecords as $staff_timerecord){
					
					$det = new DateTime($staff_timerecord['time_in']);
					$staff_timerecord_time_in = $det->format('F j, Y h:i a');
					
					//time_out
					if($staff_timerecord['time_out']){
						$det = new DateTime($staff_timerecord['time_out']);
						$staff_timerecord_time_out = $det->format('F j, Y h:i a');
					}
				
					$staff_timerecord_str .= sprintf('<small>%s  %s - %s</small> <br>' , $staff_timerecord['mode'] , $staff_timerecord_time_in , $staff_timerecord_time_out );
				}
				
				
				$staff_list.="<tr bgcolor='".$bgcolor."'>
				<td width='5%'>".$ctr."</td>
				<td width='35%'><img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id=".$staff['userid']."' style='float:left; margin-right:10px;' />
				<strong>".$staff['userid']." ".$staff['fname']." ".$staff['lname']."</strong><br />
				<small>".$staff['email']."</small></td>";
				
				$staff_list.="<td width='60%' valign='top' >";
				$staff_list.=sprintf("<div><b>%s [%s]</b></div><div>%s</div>",$staff['leads_name'],$staff['leads_email'],$staff_timerecord_str);
				
						
				$staff_list.="</td>";
				$staff_list.="</tr>";
				
			}	
		}else{
			$sql = "SELECT userid  FROM activity_tracker a WHERE (status = 'working' OR status = 'lunch break' OR status = 'quick break' );";
			$working_staffs = $db->fetchAll($sql);
			
			//$sql = "SELECT DISTINCT(userid) FROM subcontractors s WHERE status = 'ACTIVE';";
			$sql = "SELECT DISTINCT(s.userid) FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status IN ('ACTIVE', 'suspended') ORDER BY p.fname";
			$active_staffs = $db->fetchAll($sql);
			
			$staff_working = array();
			foreach($working_staffs as $working_staff){
				array_push($staff_working , $working_staff['userid']);
			}
			
			$staff_active=array();
			foreach($active_staffs as $active_staff){
				array_push($staff_active , $active_staff['userid']);
			}
			//$array1 = array('red', 'blue', 'green', 'octarine');
			//$array2 = array('red', 'yellow', 'green');
			$diff = array_diff($staff_active, $staff_working);
			//print_r($diff);
			//ksort($diff);
			foreach(array_keys($diff) as $array_key){
				//$history_changes .= sprintf("%s from %s to %s <br>", getFullColumnName($array_key), $result[$array_key] , $diff[$array_key]);
				$userid = $staff_active[$array_key];
				$sql = $db->select()
					->from('personal')
					->where('userid =?' , $userid);
				
				$staff = $db->fetchRow($sql);
			
				
				$ctr++;
				if($bgcolor == '#eeeeee'){
					$bgcolor = '#d0d0d0';
				}else{
					$bgcolor = '#eeeeee';
				}
				
				$staff_list.="<tr bgcolor='".$bgcolor."'>
				<td width='5%'>".$ctr."</td>
				<td width='95%' colspan='2'><img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id=".$staff['userid']."' style='float:left; margin-right:10px;' />
				<strong>".$staff['userid']." ".$staff['fname']." ".$staff['lname']."</strong><br />
				<small>".$staff['email']."</small></td>";
				$staff_list.="</tr>";
				
					
			}
		}
		
}	

	

$smarty->assign('list',$list);
$smarty->assign('date_today',date("F j, Y"));
$smarty->assign('date_hdr',$date_hdr);
$smarty->assign('staff_list',$staff_list);
$smarty->assign('status_str',$status_str);
$smarty->assign('start_date_str',$start_date_str);
$smarty->assign('end_date_str',$end_date_str);

$smarty->assign('staffs',$staffs);
$smarty->display('ViewStaff.tpl');
?>