<?php
//  2014-03-06 Normaneil Macutay <normanm@remotestaff.com.au>
//  -   Initial Hack
require('../conf/zend_smarty_conf.php');


DEFINE('GUI_VERSION', '2011-09-02 17:04:00');
class StaffPortal {
    function __construct() {
        global $db;
		global $nodejs_api;
        $userid = $_SESSION['userid'];
        if (($userid == "") || ($userid == Null)) {
            throw new Exception('Please Login');
        }
        $this->userid = $userid;

        //get clients timezone
        $sql = $db->select()
                ->from(Array('t' => 'timezone_lookup'), 'timezone')
                ->join(Array('p' => 'personal'), 'p.timezone_id = t.id')
                ->where('p.userid = ?', $userid);
        $tz = $db->fetchOne($sql);
        if ($tz == Null) {
            $this->staff_tz = 'Asia/Manila';
        }
        else {
            $this->staff_tz = $tz;
        }

        //get staff email
        $sql = $db->select()
                ->from('personal', 'email')
                ->where('userid = ?', $userid);
        $this->personal_email = $db->fetchOne($sql);
    }


    public function get_days() {
        $available_days = Array();

        $tz = new DateTimeZone($this->client_tz);
        $now = new DateTime();
        $now->setTimezone($tz);
        $available_days['Today'] = $now->format('Y-m-d');

        $now->modify("-1 days");
        $available_days['Yesterday'] = $now->format('Y-m-d');

        for ($i = 0; $i < 5; $i++) {
            $now->modify("-1 days");
            $available_days[$now->format('l')] = $now->format('Y-m-d');
        }

        return $available_days;
    }


    public function get_timesheets() {
        global $db, $logger;
        $date_today = new Zend_Date();
        $current_month_date = new Zend_Date($date_today->toString('yyyy-MM-01 00:00:00'), Zend_Date::ISO_8601);
        $start_date = clone $current_month_date;
        $start_date->add(-1, Zend_Date::YEAR);
        $sql = $db->select()
                ->from(Array('t' => 'timesheet'), Array('t.id', 't.month_year', 't.userid'))
                ->join(Array('s' => 'subcontractors'), 't.subcontractors_id = s.id', Array('s.job_designation'))
                ->where('t.userid = ?', $this->userid)
                ->where('t.status IN ("open", "locked")')
                ->where('t.month_year >= ?', $start_date->toString('yyyy-MM-01 00:00:00'))
                ->where('t.month_year <= ?', $current_month_date->toString('yyyy-MM-01 00:00:00'))
                ->order('t.month_year');
        $timesheet = $db->fetchAll($sql);

        $timesheet_data = Array();
        foreach($timesheet as $t) {
            $month = new Zend_Date($t['month_year'], Zend_Date::ISO_8601);
            if ($month->toString('yyyy-MM') == $date_today->toString('yyyy-MM')) {
                $t['item'] = sprintf('%s :: %s', 'Current Month', $t['job_designation']);
            }
            else {
                $t['item'] = sprintf('%s :: %s', $month->toString('MMMM yyyy'), $t['job_designation']);
            }
            $t['year'] = $month->toString('yyyy');
            $timesheet_data[] = $t;
        }
        return $timesheet_data;
    }
	
	public function get_staff_leave_request($year){
		global $db, $logger;
		$pending_ids=array();
		$absent_ids=array();
		$cancelled_ids=array();
		$approved_ids=array();
		$denied_ids=array();
		
		$sql="SELECT l.id, (d.id)AS date_id, d.date_of_leave, d.status, l.userid, p.fname, p.lname, l.leave_type FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id JOIN personal p ON p.userid = l.userid WHERE l.leads_id IS NOT NULL AND YEAR(d.date_of_leave)='".$year."' AND l.userid=".$this->userid." ORDER BY d.date_of_leave DESC;";
		$leaves = $db->fetchAll($sql);
		foreach($leaves as $leave){
			if($leave['status'] == 'pending'){
				if(in_array($leave['id'], $pending_ids)==false){
					$pending[] = $leave;
					$pending_ids[] = $leave['id'];
				}
				
			}
			
			if($leave['status'] == 'absent'){
				if(in_array($leave['id'], $absent_ids)==false){
					$absent[] = $leave;
					$absent_ids[] = $leave['id'];
				}
			}
			
			if($leave['status'] == 'cancelled'){
				if(in_array($leave['id'], $cancelled_ids)==false){
					$cancelled[] = $leave;;
					$cancelled_ids[] = $leave['id'];
				}
			}
			
			if($leave['status'] == 'approved'){
				if(in_array($leave['id'], $approved_ids)==false){
					$approved[] = $leave;
					$approved_ids[] = $leave['id'];
				}
			}
			
			if($leave['status'] == 'denied'){
				if(in_array($leave['id'], $denied_ids)==false){
					$denied[] = $leave;
					$denied_ids[] = $leave['id'];
				}
			}
		}
		$data=array(
			'pending' => $pending,
			'absent' => $absent,
			'approved' => $approved,
			'denied' => $denied,
			'cancelled' => $cancelled
		);
		return $data;
	}

	public function get_leave_request_calendar($year){
		global $db, $logger;
		require_once("activecalendar-staff.php");
		$yearID=false; // init false to display current year
		$monthID=false; // init false to display current month
		$dayID=false; // init false to display current day
		
		extract($_GET); // get the new values (if any) of $yearID,$monthID,$dayID
		$arrowBack="<img src=\"images/back.png\" border=\"0\" alt=\"&lt;&lt;\" />"; // use png arrow back
		$arrowForw="<img src=\"images/forward.png\" border=\"0\" alt=\"&gt;&gt;\" />"; // use png arrow forward
		
		if($year){
			$yearID = $year;
		}
		
		$cal = new activeCalendar($yearID,$monthID,$dayID);
		$cal->enableDayLinks($myurl); // enables day links
		$cal->setFirstWeekDay(0);; // '0' -> Sunday , '1' -> Monday
		
		
		$search_str = " AND l.userid=".$this->userid;
		$sql="SELECT DISTINCT(d.date_of_leave) FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE YEAR(d.date_of_leave)='".$yearID."' ".$search_str.";";
		$leave_request_dates = $db->fetchAll($sql);
		
		foreach($leave_request_dates as $leave_request_date){
		
			$sql="SELECT COUNT(d.id)AS pending_num FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status='pending' ".$search_str." GROUP BY d.status;";
			//echo $sql;exit;
			$pending_num = $db->fetchOne($sql);
			$sql="SELECT COUNT(d.id)AS approved_num FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status='approved' ".$search_str." GROUP BY d.status;";
			$approved_num = $db->fetchOne($sql);
		
			if($pending_num == 0 and $approved_num==0){
			
				
			$sql="SELECT * FROM leave_request_dates d JOIN leave_request l ON l.id = d.leave_request_id WHERE d.date_of_leave='".$leave_request_date['date_of_leave']."' AND d.status not in ('pending', 'approved') ".$search_str.";";
			$dates = $db->fetchAll($sql);
			
			
				foreach($dates as $date){
			
					$year = date('Y', strtotime($date['date_of_leave']));
					$month = date('m', strtotime($date['date_of_leave']));
					$day = date('d', strtotime($date['date_of_leave']));
					$bgcolor = ''; // default
					if($date['status'] == 'pending'){
						$bgcolor = '#FFFF00'; //yellow
					}else if($date['status'] == 'approved'){
						$bgcolor = '#009900'; // green
					}else if($date['status'] == 'denied'){
						$bgcolor = '#FF0000'; // red
					}else if($date['status'] == 'cancelled'){
						$bgcolor = '#999999'; // gray
					}else if($date['status'] == 'absent'){	
						$bgcolor = '#0000FF'; // blue	
					}else{
						$bgcolor = ''; // default
					}
					$cal->setEventContent("$year","$month","$day","$bgcolor" , $date['leave_request_id']);
				
				}
				
			}else{
				
				
				if($approved_num > 0 and  $pending_num == 0){
					$year = date('Y', strtotime($leave_request_date['date_of_leave']));
					$month = date('m', strtotime($leave_request_date['date_of_leave']));
					$day = date('d', strtotime($leave_request_date['date_of_leave']));
					$cal->setEventContent("$year","$month","$day","#00FF00");
				}else{
					$year = date('Y', strtotime($leave_request_date['date_of_leave']));
					$month = date('m', strtotime($leave_request_date['date_of_leave']));
					$day = date('d', strtotime($leave_request_date['date_of_leave']));
					$cal->setEventContent("$year","$month","$day","#FFFF00" , $date['leave_request_id']);
				}
			}
					
		}
		$calendar = $cal->showYear(3);
		return $calendar;
	}

	public function update_leave_request($obj){
		global $db;
		global $nodejs_api;
		
		require('../tools/CouchDBMailbox.php');
		include '../leave_request_form/leave_request_function.php';
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header('Content-type: text/html; charset=utf-8');
		$smarty = new Smarty;


		//default timezone is Asia/Manila
		date_default_timezone_set("Asia/Manila");

		
		$comment_by_id = $this->userid;
		$comment_by_type = 'personal';

		$leave_request_id = $obj["leave_request_id"];
		$dates = $obj["dates"];
		$status = $obj["status"];
		$notes = $obj["notes"];
		
		$sql =$db->select()
			->from('leave_request_dates' )
			->where('leave_request_id =?' , $leave_request_id);
		$leave_request_dates = $db->fetchAll($sql);	
		
		
		//get the subcon userid of this leave_request
		$sql = $db->select()
			->from('leave_request')
			->where('id =?' ,$leave_request_id);
		$leave_request = $db->fetchRow($sql);
		
		$sql = "SELECT fname , lname , email FROM personal WHERE userid = ".$leave_request['userid'];
		$staff = $db->fetchRow($sql);
		
		$sql = "SELECT fname , lname , email, csro_id FROM leads WHERE id = ".$leave_request['leads_id'];
		$leads = $db->fetchRow($sql);
		
		//Get the subcontractors.staff_email
		$sql="SELECT staff_email FROM subcontractors s where userid=".$leave_request['userid']." and leads_id=".$leave_request['leads_id'].";";
		$staff_email = $db->fetchOne($sql);
		
		foreach($dates as $d){
			$data = array('status' => $status);
			$where = "id=".$d;
			$db->update('leave_request_dates', $data, $where);	
			
			$sql="SELECT date_of_leave FROM leave_request_dates l where id=".$d;
			$date_of_leave = $db->fetchOne($sql);
		
			$date_of_leave_str .= " ".date('F j, Y => l', strtotime($date_of_leave))."<br>";
			$date_of_leave_str2 .= "<li>".date('F j, Y => l', strtotime($date_of_leave))."</li>";
		}
		
		$history_changes = strtoupper($status)." DATES : <br>".$date_of_leave_str."<br><em>".$notes."</em>";
		$data = array(
			'leave_request_id' => $leave_request_id, 
			'notes' => $history_changes, 
			'response_by_id' => $comment_by_id, 
			'response_by_type' => $comment_by_type,
			'response_date' => date("Y-m-d H:i:s")
		);
		$db->insert('leave_request_history' , $data);
		
		//send email notification the subcon
		$smarty->assign('staff', $staff);
		$smarty->assign('leads', $leads);
		$smarty->assign('mode', $status);
		$smarty->assign('date_of_leave_str2', $date_of_leave_str2);
		$smarty->assign('comment_by', ShowName($comment_by_id , $comment_by_type));
		$smarty->assign('ATZ', $ATZ);
		$body = $smarty->fetch('leave_request_autoresponder.tpl');
		
		$csro=array();
		if($leads['csro_id'] !=""){
			$sql = $db->select()
				->from('admin')
				->where('admin_id =?', $leads['csro_id']);
			$csro = $db->fetchRow($sql);
		}
		
		
		//get all client's managers email
		$managers_emails=array();
		$managers_emails = get_client_managers_emails($leave_request['leads_id'], $leave_request['userid']);
		
		//send email
		$to_array = array();
		if($leads['email']){
			$to_array[] = $leads['email'];
		}
		
		if($staff_email){
			$to_array[] = $staff_email;
		}
		
		
		$cc_array = array('attendance@remotestaff.com.au');
		if($csro){
			$cc_array[]= $csro['admin_email'];
		}
		if(count($managers_emails) >0){
			foreach($managers_emails as $manager_email){
				$cc_array[]=$manager_email;
			}
		}
		
		if($manager['email'] !=""){
			$cc_array[]=$manager['email'];
		}
		
		$attachments_array =NULL;
		$bcc_array=NULL;
		$from = 'Leave Request Management<attendance@remotestaff.com.au>';
		$html = $body;
		$subject=sprintf("Remotestaff Leave Request Staff %s %s to Client %s %s.", $staff['fname'], $staff['lname'], $leads['fname'], $leads['lname']);
		$text = NULL;
		
		SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
		file_get_contents($nodejs_api."/sync/leave-request/?id={$leave_request_id}");
		return sprintf('Leave request has been %s', $status);
	}

	function add_leave_request($obj){
		global $db;
		global $nodejs_api;
				
		require('../tools/CouchDBMailbox.php');
		include '../leave_request_form/leave_request_function.php';
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header('Content-type: text/html; charset=utf-8');
		$smarty = new Smarty;


		//default timezone is Asia/Manila
		date_default_timezone_set("Asia/Manila");
		
		$query="SELECT userid, fname, lname FROM personal WHERE userid=".$this->userid;
		$staff = $db->fetchRow($query);

		$comment_by_id = $this->userid;
		$comment_by_type = 'personal';
		
		$leave_type = $obj['leave_type'];
		$leave_duration = $obj['leave_duration'];
		$start_date_of_leave = $obj['start_date_of_leave'];
		$end_date_of_leave = $obj['end_date_of_leave'];
		$reason_for_leave = trim($obj['reason_for_leave']);
		$clients = $obj['clients'];
		
		$DATE_SEARCH=array();
		$random_string_exists = True;
		$start_date_str = date('Y-m-d', strtotime($start_date_of_leave));
		$date_end_str = date('Y-m-d', strtotime($end_date_of_leave));
		while ($random_string_exists) {
			if($start_date_str <= $date_end_str){
				$DATE_SEARCH[] = $start_date_str;
				$start_date_str = date("Y-m-d", strtotime("+1 day", strtotime($start_date_str)));
				$random_string_exists = True;
			}else{
				$random_string_exists = False;
			}
		}
		
		foreach($clients as $lead){
			//get staff rs email
			$sql = "SELECT id, staff_email, job_designation FROM subcontractors WHERE leads_id=".$lead." AND userid=".$this->userid." AND status IN('ACTIVE', 'suspended') LIMIT 1;";
			$subcon = $db->fetchRow($sql);
			
			//get client info
			$sql = $db->select()
				->from('leads', Array('id', 'fname', 'lname', 'email', 'csro_id'))
				->where('id =?' , $lead);
			$leads_info = $db->fetchRow($sql);
			
			//get client csro
			if($leads_info['csro_id'] != ""){
				$sql = $db->select()
					->from('admin', Array('admin_id', 'admin_fname', 'admin_lname', 'admin_email'))
					->where('admin_id =?', $leads_info['csro_id']);
				$csro = $db->fetchRow($sql);	
			}
			
			//get the staff timezone in timesheet
			$sql = $db->select()
				->from('timesheet' , 'timezone_id')
				->where('userid =?' , $this->userid)
				->where('leads_id =?' ,$lead);
			$timezone_id = $db->fetchOne($sql);
			
			if(!$timezone_id){
				$timezone_id = 1;
			}
			
			$data = array(
				'userid' => $this->userid, 
				'leads_id' => $lead, 
				'leave_type' => $leave_type, 
				'reason_for_leave' => $reason_for_leave, 
				'date_requested' => date("Y-m-d H:i:s"),
				'leave_duration' => $leave_duration,
				'timezone_id' => $timezone_id
			);
			
			$db->insert('leave_request' , $data);
			$leave_request_id = $db->lastInsertId();	
			
			
			foreach($DATE_SEARCH as $date){
				$data = array(
					'leave_request_id' => $leave_request_id, 
					'date_of_leave' => $date,
					'status' => 'pending'
				);
				$db->insert('leave_request_dates' , $data);
			}
			
			
			
			//Send Email
			//get all client's managers email
			// $managers_emails=array();
			// $managers_emails = get_client_managers_emails($lead, $this->userid);
// 				
			// $smarty->assign('leads_info',$leads_info);
			// $smarty->assign('staff', $staff);
			// $smarty->assign('subcon', $subcon);
			// $smarty->assign('DATE_SEARCH',$DATE_SEARCH);
			// $smarty->assign('leave_type',$leave_type);
			// $smarty->assign('leave_duration',$leave_duration);
			// $smarty->assign('reason_for_leave',$reason_for_leave);
			// $smarty->assign('response_note',$response_note);
			// $smarty->assign('leave_request_id', $leave_request_id);
			// $smarty->assign('date_requested', date("Y-m-d H:i:s"));
			// $body = $smarty->fetch('add_leave_request_autoresponder.tpl');
// 			
			// $attachments_array =NULL;
			// $text = NULL;
			// $html = $body;
			// $subject=sprintf("Remotestaff Leave Request Staff %s %s to Client %s %s.", $staff['fname'], $staff['lname'], $leads_info['fname'], $leads_info['lname']);
// 			
			// $from = 'Leave Request Management<attendance@remotestaff.com.au>';
			// $to_array = array($leads_info['email'], $subcon['staff_email']);
// 			
			// $bcc_array=NULL;
			// $cc_array = array('attendance@remotestaff.com.au');
			// if($managers_emails){
				// foreach($managers_emails as $manager_email){
					// $cc_array[]=$manager_email;
				// }
			// }
			// if($csro){
				// $cc_array[] = $csro['admin_email'];
			// }
// 			
			// SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
			
			//echo "<pre>";
			//print_r($body);
			//echo "</pre>";
			//exit;	
			
		}
		
		
		file_get_contents($nodejs_api."/sync/leave-request/?id={$leave_request_id}");
		//return $clients;
		return array('success' => true, 'msg' => 'Leave request created. An email notification has been sent to clients.', 'leave_request_id' => $leave_request_id);
		
	}



    /*
    returns a random string for django consumption
    */
    public function check_php_session($gui_version) {
        global $db;
        if ($gui_version != GUI_VERSION) {
            throw new Exception('gui version mismatch');
        }

        $now = new Zend_Date();

        $random_string_exists = True;
        while ($random_string_exists) {
            $random_string = $this->rand_str();
            $data = array(
                'random_string' => $random_string,
                'date_created' => $now->toString("yyyy-MM-dd HH:mm:ss"),
                'session_data' => sprintf('userid=%s', $this->userid),
                'redirect' => 'from /portal/staff_api_service/staff_api_service.php django redirect',
            );

            try {
                $db->insert('django_session_transfer', $data);
                $random_string_exists = False;
            }
            catch (Exception $e) {
                $random_string_exists = True;
            }
        }

        return $random_string;

    }

    private function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
        // Length of character list
        $chars_length = strlen($chars);

        // Start our string
        $string = $chars{rand(0, $chars_length)};
       
        // Generate random string
        for ($i = 1; $i < $length; $i++) {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};
            $string = $string . $r;
        }
       
        // Return the string
        return $string;
    }


    
}

$server = new Zend_Json_Server();
$server->setClass('StaffPortal');
$server->handle();
?>
