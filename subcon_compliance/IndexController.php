<?php
/****
 this script is used for sending sms notices
 to ensure the auto sending of sms, each notices was scheduled using cron software utility
 
1,31 * * * * /usr/bin/curl --request GET http://test.remotestaff.com.au/portal/subcon_compliance/?/sms_workshift/notlogin
7,37 * * * * /usr/bin/curl --request GET http://test.remotestaff.com.au/portal/subcon_compliance/?/sms_workshift/runninglate
0,30 * * * * /usr/bin/curl --request GET http://test.remotestaff.com.au/portal/subcon_compliance/?/sms_workshift/absent
* * * * * /usr/bin/curl --request GET http://test.remotestaff.com.au/portal/subcon_compliance/?/sms_overbreaks/lunch_breaks
* * * * * /usr/bin/curl --request GET http://test.remotestaff.com.au/portal/subcon_compliance/?/sms_overbreaks/quick_breaks
* * * * * /usr/bin/curl --request GET http://test.remotestaff.com.au/portal/subcon_compliance/?/sms_disconnected/disconnected
*/
class IndexController {
	private static $instance = NULL;
	private $db;
	private $smarty;
	private $template;
	private $rs_site;
	public static $couch_dsn;
	private $check_rssc_user;
	
	private $work_days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat');
	private $sms_msgs = array(
		'notlogin' => "Hi __FNAME__, you're still not logged in for your client.Please reply to this message if you're running late or can't log in today or pls send a message through text to 09175337949 with ur name and concern/issue.",
		//you are still not logged in for your client. Please reply to this message if you are running late or cannot log in today or call +63947-995-9825 dial 3.',	
		'runninglate' => "Hi __FNAME__, you're still not logged in and now considered late for work. We're now updating your client of your possible absence, if you're unable to log in today pls respond to this message or call 09175651676.",
		//you are still not logged in and now considered late for work. We are now updating your client of your possible absence, if you are unable to log in today please respond to this message or call +63947-995-9825 dial 3.',
		'absent' => 'Hi __FNAME__, we have informed the client of your absence today without notice. Please connect with  __CSRONAME__  as soon as possible.',
		"lunch_breaks" => "Hi __FNAME__, you're now lunch over break. Your lunch time should only be max 60 minutes. Please log back in to RSSC or reply to this message if you're unable to log back in so we can update your client.",
		'quick_breaks' => "Hi __FNAME__, Your 10 minutes short break limit is now reached. We have logged you out of the system. Please logged back in or reply to this message if you're unable to log back inso we can update your client.",
		'disconnected' => "HI __FNAME__, you're disconnected from RSSC. FYI.Please logged back in or reply to this message if you're unable to log back in so we can update your client.",
		//'notlogin' => 'Hi __FNAME__, you are still not logged in for your client. Please reply to this message if you are running late or cannot log in today... pls ignore this is a test :-)',	
		//'runninglate' => 'Hi __FNAME__, you are still not logged in and now considered late for work. We are now updating your client of your possible absence... pls ignore this is a test :-)',
		//'absent' => 'Hi __FNAME__, we have informed the client of your absence today without notice. Please connect with  __CSRONAME__  as soon as possible. ... pls ignore this is a test :-)'
		);
	private $rssc_reports_views = array('notlogin', 'runninglate', 'absent');
	private $break_minutes = array('absent' => 120, 'lunch_breaks' => 60, 'quick_breaks' => 10, 'disconnected' => 15);

	public static function get_instance($db) {
		if( self::$instance === NULL) self::$instance = new self($db);
		return self::$instance;
	}
	
	function __construct($db) {
		$this->db = $db;
		$this->smarty = new Smarty();
		// set the templates dir.
		$this->smarty->template_dir = "./templates";
		$this->smarty->compile_dir = "./templates_c";
		$this->check_rssc_user = new checkRsscUser(self::$couch_dsn);
		
		$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
					? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
	}
	
	public function index() {
		echo 'index method';
	}
	
	public function set_subcon_schedule() {
		$subcon = new Subcontractors();
		$schedule = new SubconSchedules();

		foreach( $this->work_days as $dow ) {
			$result = $subcon->work_schedule($dow);
			foreach( $result as $row) {
				$dow_start = $schedule->record_exist($row['id'], $dow); //, $row['start_work']);
				if( !$dow_start ) {
					$data = array('contract_id' => $row['id'], 'userid' => $row['userid'], 'dayofweek' => $dow,
							  'dow_start' => $row['start_work'], 'dow_finish' => $row['finish_work'],
							  'dow_lunch_hrs' => $row[$dow.'_lunch_number_hrs'], 'leads_id' => $row['leads_id']);
					$schedule->insert($data);
				} else {
					if( $dow_start != $row['start_work']) {
						$schedule->update( array('dow_start' => $row['start_work'], 'dow_finish' => $row['finish_work'],
										 'dow_lunch_hrs' => $row[$dow.'_lunch_number_hrs']),
										 "contract_id={$row['id']} AND dayofweek='{$dow}'");
					}
				}
			}
			
		}
		
	}
	
	public function sms_workshift($msg_type) {
		$current_date = $this->get_current_date($msg_type);
		//$current_date = "2014:06:13:08:00";
		$date_of_week = strtolower(date("D"));
		$split_date = explode(':', $current_date);
				
		$min_start = array_pop($split_date);
		$hr_start = array_pop($split_date);
		
		if( $msg_type == 'absent' ) {
			$now = $this->get_current_date('notlogin');
			$aNow = explode(':', $now);
			$date_value = array('start' => $split_date, 'end' => $split_date, 'hour' => $aNow[3],
							'minute' => $aNow[4]);
		} else {
			$date_value = array('start' => $split_date, 'end' => $split_date, 'hour' => $hr_start,
							'minute' => $min_start);
		}
		
		//$date_start = array();
		// related to staff shift
		$min_rem = $min_start % 30; // divisible by 30 minutes
		$min_start -= $min_rem;
		//$min_start = 0;

		//$date_value = array('start' => $split_date, 'end' => $split_date, 'hour' => $hr_start,
		//					'minute' => $min_start, 'min_add' => $min_rem);
		
		$has_csro_fld = $msg_type == 'absent' ? true : false;
		$schedule = new SubconSchedules();
		//$daily_sched = $schedule->fetch_schedule($date_of_week, implode(':', array($hr_start, $min_start) ) );
		$daily_sched = $schedule->fetch_schedule($date_of_week, implode(':', array($hr_start, sprintf('%02d',$min_start)) ), $has_csro_fld );
		
		$aURL = array();
		foreach( $daily_sched as $sched ) {
			
			//if( isset($this->rssc_reports_views[$msg_type] ) )
			$result = $this->check_rssc_user->RSSC_userTimeIn($sched['userid'], $date_value);
			//elseif( isset($this->sub_mgmt_views[$msg_type] ))
			//	$this->RSSC_lunchbreaks();
			
			//if( $sched['leads_id'] != 11) continue;
			// this is to monitor staff login
			if( !count($result->rows)) {
				$mobileno = $this->set_mobileno($sched['handphone_no'], $sched['handphone_country_code']);
				/*$mobileno = $sched['handphone_no'];
				$mobccode = $sched['handphone_country_code'];
				$moblen = strlen($sched['handphone_no']);
				if( $moblen == 7) $mobileno = $mobccode . $mobileno;
				if( '9' == $mobileno[0] && strlen($mobileno) == 10) $mobileno = '0'.$mobileno;*/
				
				if( $mobileno) {
					if( empty($sched['admin_fname']) )
						$msg_body = $this->set_smsbody($msg_type, $sched['fname']);
					else $msg_body = $this->set_smsbody($msg_type, $sched['fname'], $sched['admin_fname']);
					
					$sms_notices = new ComplianceSmsNotices();
					
					$d = date("Y-m-d H:i:s");
					/*$date_sent = new DateTime();
					$date_sent->sub(new DateInterval('PT1H'));*/
		
					$sentMessage = array("userid"=>$sched['userid'], "date_created"=>$d, "date_reported"=>$d,
										 "mobileno"=>$mobileno, "notice"=>$msg_type);
					$id = $sms_notices->insert($sentMessage);

			        $sms_msgs = array("userid"=>$sched['userid'], "date_created"=>$d, "admin_id"=>6, "mobile_number"=>$mobileno, "message"=>$msg_body);
			        $this->db->insert("staff_admin_sms_out_messages", $sms_msgs );
					
					$sms_data = array('userid' => $sched['userid'], 'cp_num' => $mobileno, 'sms_id' => $id, 'mode' => 'sms',
									  'sender_type' => 'compliance', 'message' => $msg_body, 'date_sent' => $d);
					
					$url_data = $this->queryString($sms_data);
					$aURL[] = $this->rs_site."/portal/subcon_compliance/?/sms_publish/&".$url_data;
				}
			}
		}
		
		if( count($aURL)) {
			$multireq = new ParallelRequest($aURL);
			$sms_result = $multireq->run();
		}
		
		// for testing
		/*$aURL = array();
		$sms_data = array('userid' => 5490, 'cp_num' => '09061642427', 'sms_id' => 3053, 'mode' => 'sms',
									  'sender_type' => 'compliance', 'message' => $this->set_smsbody($msg_type, 'Mike'));
		$url_data = $this->queryString($sms_data);
		$aURL[] = $this->rs_site."/portal/subcon_compliance/?/sms_publish/&".$url_data;*/
		
		/*$sms_data = array('userid' => 5671, 'cp_num' => '09999049214', 'sms_id' => 3049, 'mode' => 'sms',
									  'sender_type' => 'compliance', 'message' => $this->set_smsbody($msg_type, 'Charise'));
		$url_data = $this->queryString($sms_data);
		$aURL[] = $this->rs_site."/portal/subcon_compliance/?/sms_publish/&".$url_data;
		
		$sms_data = array('userid' => 74, 'cp_num' => '09216147348', 'sms_id' => 3046, 'mode' => 'sms',
									  'sender_type' => 'compliance', 'message' => $this->set_smsbody($msg_type, 'Norman'));
		$url_data = $this->queryString($sms_data);
		$aURL[] = $this->rs_site."/portal/subcon_compliance/?/sms_publish/&".$url_data;
		
		$sms_data = array('userid' => 37555, 'cp_num' => '09175985916', 'sms_id' => 3054, 'mode' => 'sms',
									  'sender_type' => 'compliance', 'message' => $this->set_smsbody($msg_type, 'Allanaire'));
		$url_data = $this->queryString($sms_data);
		$aURL[] = $this->rs_site."/portal/subcon_compliance/?/sms_publish/&".$url_data;*/
		
	}
	
	public function sms_overbreaks($msg_type) {
		$current_date = $this->get_current_date($msg_type);
		//$current_date = "2013:10:22:8:31";
		$split_date = explode(':', $current_date);
		
		$min_start = array_pop($split_date);
		$hr_start = array_pop($split_date);
		
		$date_value = array('start' => $split_date, 'end' => $split_date, 'hour' => $hr_start,
							'minute' => $min_start); //, 'min_end' => date('i'));
		
		$rssc_results = $this->check_rssc_user->RSSC_overBreaks($date_value, $msg_type);
		
		
		if( count($rssc_results->rows)) {
			$dt = new DateTime();
			$dt->setTimezone(new DateTimeZone('Asia/Manila'));
			$time_now = $dt->getTimestamp();
			
			$aURL = array();
			foreach( $rssc_results->rows as $row) {
				$start = $row->key;
				$end = $row->value[1];
				
				// get unfinished break
				if( !$end) {
					//var_dump($row);
					
					$start_time = new DateTime("{$start[0]}-{$start[1]}-{$start[2]}");
					$start_time->setTime($start[3], $start[4], $start[5]);
					$userid = $row->value[0];
					
					$minute_cnt = ($time_now - $start_time->getTimestamp())/60;
					
					//test the minutes
					if( $minute_cnt > $this->break_minutes[ $msg_type ] ) {
						$url_data = $this->queryString( array('userid'=>$userid, 'break' => $msg_type, 'date'=>$start_time->format('Y-m-d H:i:s')) );
						//local call for testing
						//$this->subs_management(array('userid'=>$userid, 'break' => $msg_type, 'date'=>$start_time->format('Y-m-d H:i:s')));
						//break;
					
						$aURL[] = $this->rs_site."/portal/subcon_compliance/?/subs_management/&".$url_data;
					}
				}
			}
			
			if( count($aURL)) {
				$multireq = new ParallelRequest($aURL);
				$sms_result = $multireq->run();
			}
		}
		
	}
	
	public function sms_disconnected($msg_type) {
		$current_date = $this->get_current_date($msg_type);
		//$current_date = "2012:4:9:15:8";
		$split_date = explode(':', $current_date);
				
		$min_start = array_pop($split_date);
		$hr_start = array_pop($split_date);
		
		$date_value = array('start' => $split_date, 'end' => $split_date, 'hour' => $hr_start,
							'minute' => $min_start); //, 'min_end' => date('i'));
		
		$rssc_disconnected = $this->check_rssc_user->RSSC_disconnected($date_value);
		
		if( count($rssc_disconnected->rows)) {
			$aURL = array();
			foreach( $rssc_disconnected->rows as $row) {
				$d = $row->key;
				$userid = $row->value[0];
				
				$dt = new DateTime("{$d[0]}-{$d[1]}-{$d[2]}");
				$dt->setTime($d[3], $d[4], $d[5]);
				
				$url_data = $this->queryString( array('userid'=>$userid, 'break' => $msg_type, 'date'=>$dt->format('Y-m-d H:i:s')) );
						
				//local call for testing
				//$this->subs_management(array('userid'=>$userid, 'break' => $msg_type, 'date'=>$dt->format('Y-m-d H:i:s')));
				//break;
					
				$aURL[] = $this->rs_site."/portal/subcon_compliance/?/subs_management/&".$url_data;
			}
			
			if( count($aURL)) {
				$multireq = new ParallelRequest($aURL);
				$sms_result = $multireq->run();
			}
		}
	}
	
	public function subs_management($data = array()) {
		if( isset($_GET['userid']) ) {
			$userid = Input::get('userid');
			$break = Input::get('break');
			$date_created = Input::get('date');
		} else {
			$userid = $data['userid'];
			$break = $data['break'];
			$date_created = $data['date'];
		}
		$subcon = new SubconSchedules();
		$subs = $subcon->subs_name_mobile($userid);
		//$subs = $subcon->subs_name_mobile();
		
		if( !count($subs) ) exit;
		
		//if( $subs['leads_id'] != 11) exit;
		
		$mobileno = $this->set_mobileno($subs['handphone_no'], $subs['handphone_country_code']);
		/*$mobileno = $subs['handphone_no'];
		$mobccode = $subs['handphone_country_code'];
		$moblen = strlen($subs['handphone_no']);
		if( $moblen == 7) $mobileno = $mobccode . $mobileno;
		if( '9' == $mobileno[0] && strlen($mobileno) == 10) $mobileno = '0'.$mobileno;*/
		
		if( $mobileno) {
			// check if record exists';
			$sms_notices = new ComplianceSmsNotices();
			
			if( $sms_notices->is_exists($mobileno, $break, $date_created) ) {
				exit;
			}
			/*if( $this->db->fetchOne( $sms_notices->select()
									->from('sms_messages', 'id')
									->where('mobile_number=?', $mobileno)
									->where('message=?',$break)
									->where('date_created=?',$date_created)) ) {
				exit;
			}*/
			
			$msg_body = $this->set_smsbody($break, $subs['fname']);
			
			$d = date("Y-m-d H:i:s");
			$sentMessage = array("userid"=>$userid, "date_reported"=>$date_created, "date_created"=>$d,
								 "mobileno"=>$mobileno, "notice"=>$break);
			$id = $sms_notices->insert($sentMessage);

            $sms_msgs = array("userid"=>$userid, "date_created"=>$d, "admin_id"=>6, "mobile_number"=>$mobileno, "message"=>$msg_body);
            $this->db->insert("staff_admin_sms_out_messages", $sms_msgs );

			try {
			    $sms_data = array('userid' => $userid, 'cp_num' => $mobileno, 'sms_id' => $id, 'mode' => 'sms',
							'sender_type' => 'compliance', 'message' => $msg_body, 'date_sent' => $d);
				$this->sms_publish($sms_data);
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			
		}
	}
	
	private function set_smsbody($type, $fname, $admin_fname='') {
		$msg_body = $this->sms_msgs[ $type ];
		$msg_body = str_replace('__CSRONAME__', $admin_fname, $msg_body);
		return str_replace('__FNAME__', $fname, $msg_body) . ' - RemoteStaff';
	}
	
	private function get_current_date($msg_type = '') {
		$date = new DateTime();
		//$date->setTimezone(new DateTimeZone('UTC'));
		//$date->setTimezone(new DateTimeZone('Australia/Sydney'));
		$date->setTimezone(new DateTimeZone('Asia/Manila'));
		if( isset($this->break_minutes[$msg_type]) ) {
			$format = sprintf('PT%dM', $this->break_minutes[$msg_type] + ($msg_type!='absent'?5:0));
			$date->sub(new DateInterval($format));
		}
		//if( $msg_type == 'absent') $date->sub(new DateInterval('PT2H'));
		return $date->format('Y:m:d:H:i');
	}
	
	public function sms_publish($data=array()) {
		if( isset($_GET['cp_num']) ) {
			$cp_num = Input::get('cp_num');
			$sms_id = Input::get('sms_id');
			$mode = Input::get('mode');
			$sender_type = Input::get('sender_type');
			$message = Input::get('message');
			
			$data = array('cp_num' => $cp_num, 'sms_id' => $sms_id, 'mode' => $mode,
						  'sender_type' => $sender_type, 'message' => $message, 'date_sent' => date('Y-m-d H:i:s') );
		}
		
		// excerpted from sms_send.php
		$host = "127.0.0.1";
		$queue = "sms";
		$exchange = 'portal';
		
		/*$d = date("Y-m-d H:i:s");
		$sentMessage = array("mode"=>"send", "date_created"=>$d, "date_sent"=>$d,
							"sent_by"=>0, "mobile_number"=>$data['cp_num'], "message"=>$data['message']);
		$id = $this->db->insert("sms_messages", $sentMessage);
			
		$data['sms_id'] = $id;*/
			
		$conn = new AMQPConnection($host,5672,"sms","sms","portal" );
		$ch = $conn->channel();
		
		$ch->queue_declare($queue, true, true, true, true);
		$ch->exchange_declare($exchange, 'direct', false, true, false);
		$ch->queue_bind($queue, $exchange);
		
		$msg_body =json_encode($data);
			
		$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
		$ch->basic_publish($msg, $exchange);
		$ch->close();
		$conn->close();
			
		echo $msg_body;
		
	}
	
	public function reports() {
		$this->template = 'reports.tpl';
		$sms_notices = new ComplianceSmsNotices();
		
		//if( empty($_SESSION['admin_id']) ) exit('No session found!');
		
		$where = array();
		
		$from_date = Input::get('from_date');
		$to_date = Input::get('to_date');
		
		$notice = Input::get('notice');
		$subcon = Input::get('subcon');
		
		if( $subcon) $where[] = "s.userid = ".$subcon;
		if( $notice != "") $where[] = "notice = '$notice'";
		
		if( !$from_date) $from_date = date('Y-m-1');
		//else $from_date = date('Y-m-d H:i:s', strtotime("-5 days"));
		
		if( !$to_date) $to_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('t'), date('Y') ));

		
		$where[] = "date(date_created) >= '$from_date'";
		$where[] = "date(date_created) <= '$to_date'";
		
		//$select = $sms_notices->select();
		//->where();
		//$results = $sms_notices->fetchAll($select)->toArray();
		$results = $sms_notices->fetch_records($where);
		//print_r($results);
		$this->smarty->assign('results', $results);
		$this->smarty->assign('subcons', $sms_notices->fetch_subcons());
		
		$this->smarty->assign('from_date', $from_date);
		$this->smarty->assign('to_date', $to_date);
		$this->smarty->assign('notice', $notice);
		$this->smarty->assign('userid', $subcon);
		
		$this->render();
	}
	
	private function set_mobileno($mobileno, $mobccode) {
		$moblen = strlen($mobileno);
		if( $moblen == 7) $mobileno = $mobccode . $mobileno;
		if( '9' == $mobileno[0] && strlen($mobileno) == 10) $mobileno = '0'.$mobileno;
		
		if( '0' == $mobileno[0] && (int)$mobileno ) return $mobileno;
		else return false;
	}
	
	private function queryString($param) {
		$qstr = array();
		foreach( $param as $key => $val) $qstr[] = $key.'='.urlencode($val);
		return implode('&', $qstr);
	}
	
	private function render() {
		$this->smarty->display($this->template);
	}
	
	
}
