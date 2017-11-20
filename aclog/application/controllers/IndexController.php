<?php
/*2013-11-5 - 
- new: workflow tasks pulldown
- paused status
- play
-
2013-11-21
- task percentage
2013-11-25
- allow multiple users in report
- flag red if elapsed time > 3hrs
2014-01-21
- editable task types (client and admin)
*/

class IndexController extends Zend_Controller_Action {
	private $config = array();
	private $couch_dsn;
	private $rs_site;
	private $userid;
	private $table;
	private $stream;
	private $leads_id;
	private $typeslist;
		
    public function init() {
        $response = $this->getResponse();
        // insert other templates
		if( !$this->_getParam('item') || in_array($this->_getParam('item'), array('report', 'myactivity', 'oldreport')) ) {
			//$response->insert('sidebar', $this->view->render('layouts/sidebar.phtml'));
			$response->insert('topnav', $this->view->render('layouts/topnav.phtml'));
		}
		
		$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
				? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
		//$this->config = Zend_Registry::get('config');
		//$this->couch_dsn = Zend_Registry::get('couch_dsn');
		
		$this->userid = Zend_Registry::get('userid');
		$this->table = Zend_Registry::get('table');
		
		$this->leads_id = Zend_Registry::get('leads_id');
		
		$tasktypes = new ActivityLogsTypes();
		$this->typeslist = $tasktypes->fetch_types($this->leads_id);
		if( !count($this->typeslist))
			$this->typeslist = $tasktypes->fetch_types();
    }
	
	

	protected function _doAction($action) {
		try {
			$method = $action.'Action';
			$this->_helper->viewRenderer($action);
			return $this->$method();
		} catch( Exception $e) {
			die($e->getMessage());
		}
	}
    
	public function testAction() {
		$logs = new ActivityLogs();
		$logs->act_users();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function indexAction() {
        $this->view->pageTitle = "Ac-Lo";

		$item = $this->_getParam('item');
		
		if( $item == 'activitylogs' ) {
			$_SESSION['fin_act'] = array();
			$_SESSION['stream'] = true;
		}

		if( $item && $item != 'index' ) {
			return $this->_doAction($item);
		}
	
		$this->view->daterange = date("M j", strtotime($cutoff['date_start']) ) .' - ' . date("M j, Y", strtotime($cutoff['date_end']));
		$this->view->js_userid = "<script type='text/javascript'>var view_name=".$uid."</script>";
		
		if( $this->table != 'admin' ) $userid = $this->userid;
		else {
			// get userid of the admin login
			$admin = new Admin();
			$admin_user = $admin->fetch_staff($this->userid);
			$userid = $admin_user['userid'];
		}
		
		$workflow = new Workflow();
		$this->view->workflows = ($this->table != 'leads') ? $workflow->fetch_tasks($userid) : $workflow->client_tasks($userid);
					
		$this->view->task_types = $this->typeslist;
		//$this->view->activitylog = true;
    }
	
	public function activitylogsAction() {
		echo '.'; // for some reason, we have to output char at the start of function to properly output the page.
		//$this->view->addScriptPath('views/scripts/index');
		
		echo "<script type='text/javascript'>";
		echo "window.logger.hide_loading();";
		echo "</script>";
		//ob_clean();
		$this->_helper->layout->disableLayout();
		//$this->_helper->viewRenderer->setNoRender();
	}
	
	
	// start processing timerecords
	public function fetchactivityAction() {
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		//echo '.'; // for some reason, we have to output char at the start of function to properly output the page.
		//$this->view->addScriptPath('views/scripts/index');
		//$userid = Zend_Registry::get('userid'); //$this->_getParam('uid');
		
		if( ob_get_level() == 0 ) {
			ob_start ();
		}
		
		echo 'retry: 10000' . PHP_EOL;
		
		$logs = new ActivityLogs();
		$logs->today_activity = true;
		
		$nStarted = time ();
		
		$date_now = date('Y-m-d H:i:s');
		//while (1) {
		/** edit: no connections should exceed 60 seconds **/
		if ((time() - $nStarted) > 60) die();
		$logs->to_date = $date_now;
		$logs->today = $date_now;
		$results = $logs->fetch_logs( array($this->userid) );
		//print_r($results);
		if( !count($results) ) {
			if( $_SESSION['stream'] ) {
				$_SESSION['stream'] = false;
				$this->disconnect('disconnect client');
			}
		} else {
			if( !$_SESSION['stream'] ) $_SESSION['stream'] = true;
			//else {
			foreach( $results as $result ) $this->transmitTimedEvent(mt_rand (60, 3000), $result);
			//}
		}
		sleep(1);
			
		//}
		
		ob_end_flush ();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function createAction() {
		$logs = new ActivityLogs();
		$logs_hist = new ActivityLogsHistory();
		
		$details = $this->_getParam('activity_details');
		if( !$details ) $details = $this->_getParam('wfdetails');
		$category = $this->_getParam('category');
		
		// check the activity details if not empty (2014/01/08)
		if( $details ) {
			$act_id = $logs->insert( array('userid'=>$this->userid, 'activity_details'=>$details, 'category'=>$category, 'reference'=>$this->table) );
			
			$log_hist = new ActivityLogsHistory();
			$data = array('aid' => $act_id, 'status' => 'ongoing', 'date_added' => date("Y-m-d H:i:s"));
			$log_hist->insert($data);
		}
		
		echo "<script type='text/javascript'>";
		echo "window.parent.index.clear_entry()";
        echo "</script>";
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
		
	public function setstateAction() {
		$act_id = $this->_getParam('aid');
		$act_status = $this->_getParam('status');
		$last = $this->_getParam('last');
		
		$aStatus = array('ongoing', 'finished', 'paused');
		if( !in_array($act_status, $aStatus) ) return;
		
		$datenow = date("Y-m-d H:i:s");
		
		$time_diff = 0;
		
		$log_hist = new ActivityLogsHistory();
		
		$last_started = $log_hist->last_started($act_id);
		
		
		if( $act_status == 'paused' || $log_hist->last_status($act_id) == 'ongoing') {
			//$last_tstamp = strtotime( );
			$time_diff = (int) strtotime($datenow) - strtotime($last_started);
		}// else {
		//	$last_started = strtotime( date('Y-m-d'). " {$last}");
		//}
		
		
			
		$elapsed_time = date('H:i:s', $time_diff);
		
		try {
			//$logs->update( array('activity_ended' => $datenow, 'activity_status' => $act_status ), 'id='.$act_id );
			//insert history
			
			$data = array('aid' => $act_id, 'status' => $act_status, 'date_added' => $datenow, 'time_diff' => $time_diff);
			$hist_id = $log_hist->insert($data);
			
			$logs = new ActivityLogs();
			$logs->to_date = $datenow;
			
			$logs->update(array('current_hid' => $hist_id), 'id='.$act_id);
			
			$status_result = $logs->elapsed_time($act_id);
			$status_result['time_ended'] = ($date = new DateTime($datenow)) ? $date->format('h:i:s A') : '';
			
			echo json_encode($status_result);
			
			//echo json_encode( array('pausecnt'=>$log_hist->pause_count($act_id), 'time_ended'=>$datenow, 'elapsed_time'=>$elapsed_time ) );	
		} catch(Exception $e) {
			echo json_encode(array('Error'=>$e->getMessage()));
		}
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function myactivityAction() {
		
		/*$table = Zend_Registry::get('table');
		$userid = Zend_Registry::get('userid');*/
		
		if( !$this->userid ) die('Invalid access.');
		//$users = $this->userid;
		$from_date = $this->_getParam('from_date');
		$to_date = $this->_getParam('to_date');
		
		$category = $this->_getParam('category');
		$status = $this->_getParam('status');
		
		$staffpausedact = $this->_getParam('staff') ? $this->_getParam('staff') : false;
		
		if( $from_date) $from_date = $from_date .' '. date('H:i:s');
		else $from_date = date('Y-m-d H:i:s', strtotime("-5 days"));
		
		if( $to_date) $to_date = $to_date .' '. date('H:i:s');
		else $to_date = date('Y-m-d H:i:s');
		
		$logs = new ActivityLogs();
		
		$logs->order_desc = true;

		$logs->from_date = $from_date;
		$logs->to_date = $to_date;
		$logs->today = date('Y-m-d H:i:s');

		
		if( $category) $logs->category = $category;
		$pageName = "My Activities";
		
		if( $status == 'paused' && $this->table == 'leads' && $staffpausedact ) {
			$act_users = $logs->act_users($this->userid, $this->table);
			$aUsers = array_map( function($a){return $a['userid'];}, $act_users);
			$pageName = "Staff Paused Activities";
			$owner = false;
			//$pageName = $this->table == 'leads' ? "Staff Paused Activities" : "My Activities";
		} else {
			$act_users = array(
						   array('userid'=>$this->userid, 'fname'=>'Me', 'lname'=>'')
						  );
			$aUsers = array($this->userid);
			if( $status == 'paused') $pageName = "My Paused Activities";
			$owner = true;
		}
		//$act_users = $logs->act_users($this->userid, $this->table);
		$aUsers = array_map( function($a){return $a['userid'];}, $act_users);
		
		$elapsed_time_day = $logs->elapsed_time_day( $aUsers );
		$elapsed_daily = array();
		foreach( $elapsed_time_day as $idx => $elapsed_time) {
			$elapsed_daily[ $elapsed_time['userid'] . $elapsed_time['activity_date'] ] = $elapsed_time['time_diff'];
		}
		
		
		
		$results = $logs->fetch_logs(  $aUsers, $status ? "last_status='$status'":null );
		
		$data_array = array();
		foreach( $act_users as $idx => $user) {
			if( !in_array($user['userid'], $aUsers)) continue;
			$data_array[$idx] = $user;
			foreach( $results as $result) {
				if( $user['userid'] == $result['userid']) $data_array[ $idx ]['logs'][] = $result;
			}
		}
		
		//$this->view->users = $logs->act_users();
		$this->view->elapsed_daily = $elapsed_daily;
		
		$this->view->status = $status;
		$this->view->results = $data_array;
		
		$this->view->from_date = date('Y-m-d', strtotime($from_date));
		$this->view->to_date = date('Y-m-d', strtotime($to_date));
		$this->view->task_types = $this->typeslist;
		$this->view->type = $category ? $category : 'ALL';
		$this->view->pageName = $pageName;
		$this->view->status = $status;
		$this->view->owner = $owner;
		$this->view->staffpausedact = $staffpausedact;
	}
	
	public function restartAction() {
		
		if( !$this->userid ) die('Invalid access.');
		//$users = $this->userid;
		
		$act_id = $this->_getParam('aid');
		
		$datenow = date('Y-m-d H:i:s');
		
		$log_hist = new ActivityLogsHistory();
		
		try {
		
			$data = array('aid' => $act_id, 'status' => 'finished', 'date_added' => $datenow, 'time_diff' => 0);
			$hist_id = $log_hist->insert($data);
				
			$logs = new ActivityLogs();
			$logs->to_date = $datenow;
				
			$logs->update(array('current_hid' => $hist_id), 'id='.$act_id);
			
			$activity = $logs->activity_get($act_id);
			
			// restart
			$new_aid = $logs->insert( array('userid' => $this->userid, 'activity_details' => $activity['activity_details'],
										   'category' => $activity['category'], 'reference' => $activity['reference']) );
			
			$data = array('aid' => $new_aid, 'status' => 'ongoing', 'date_added' => $datenow, 'admin' => $act_id);
			$log_hist->insert($data);
		
		} catch(Exception $e) {
			echo json_encode(array('Error'=>$e->getMessage()));
		}
			
		//$status_result = $logs->elapsed_time($act_id);
		//$status_result['time_ended'] = date('H:i:s A', $datenow);
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function oldreportAction() {
		if( empty($_SESSION['admin_id']) ) die('Invalid access.');
		
		$userid = $this->_getParam('users', $this->userid);
		$from_date = $this->_getParam('from_date', date("Y-m-d", strtotime("-7 days")) );
		$to_date = $this->_getParam('to_date', date('Y-m-d H:i:s'));
		
		$logs = new ActivityLogs();
		
		$logs->order_desc = true;
		if( $from_date && $to_date ) {
			$logs->from_date = $from_date;
			$logs->to_date = $to_date;
		}
		
		/*$elapsed_time_day = $logs->elapsed_time_day(array($userid));
		$elapsed_daily = array();
		foreach( $elapsed_time_day as $idx => $elapsed_time) {
			$elapsed_daily[ $elapsed_time['activity_date'] ] = $elapsed_time['time_diff'];
		}*/
		
		$this->view->users = $logs->act_users();
		$this->view->elapsed_daily = $elapsed_daily;
		
		//$subcon = new Subcontractors();
		//$staff = $subcon->fetch_staff($userid);
		
		//if( !$staff ) {
		//	$admin = new Admin();
		//	$staff = $admin->fetch_staff($userid);
		//}
		//$results = $logs->fetchAll( $logs->select()->where('userid=?', $userid) )->toArray();
		$results = $logs->fetch_logs_old( array($userid) );
		
		$this->view->userid = $userid;
		$this->view->results = $results;
		
		$this->view->from_date = $from_date;
		$this->view->to_date = date('Y-m-d', strtotime($to_date));
	}
	
	public function reportAction() {
		$table = Zend_Registry::get('table');
		$userid = Zend_Registry::get('userid');
		if( !in_array($table, array('admin', 'leads', 'client_managers')) ) die('Invalid access.');
		
		$userid = $this->_getParam('users', $this->userid);
		$from_date = $this->_getParam('from_date', date("Y-m-d", strtotime("-5 days")) );
		$to_date = $this->_getParam('to_date', date('Y-m-d H:i:s'));
		
		$logs = new ActivityLogs();
		
		/*$logs->order_desc = true;
		if( $from_date && $to_date ) {
			$logs->from_date = $from_date;
			$logs->to_date = $to_date;
		}*/
		
		/*$elapsed_time_day = $logs->elapsed_time_day(array($userid));
		$elapsed_daily = array();
		foreach( $elapsed_time_day as $idx => $elapsed_time) {
			$elapsed_daily[ $elapsed_time['activity_date'] ] = $elapsed_time['time_diff'];
		}*/
		
		$this->view->users = $logs->act_users($userid, $table);
		//$this->view->elapsed_daily = $elapsed_daily;
		
		//$subcon = new Subcontractors();
		//$staff = $subcon->fetch_staff($userid);
		
		//if( !$staff ) {
		//	$admin = new Admin();
		//	$staff = $admin->fetch_staff($userid);
		//}
		//$results = $logs->fetchAll( $logs->select()->where('userid=?', $userid) )->toArray();
		/*$results = $logs->fetch_logs( array($userid) );*/
		
		$this->view->userid = $userid;
		//$this->view->results = $results;
		
		$this->view->from_date = $from_date;
		$this->view->to_date = date('Y-m-d', strtotime($to_date));
		$this->view->task_types = $this->typeslist;
	}
	
	public function createreportAction() {
		/*$table = Zend_Registry::get('table');
		$userid = Zend_Registry::get('userid');*/
		if( !in_array($this->table, array('admin', 'leads', 'client_managers')) ) die('Invalid access.');
		
		$users = $this->_getParam('users', $this->userid);
		$from_date = $this->_getParam('datefrom');
		$to_date = $this->_getParam('dateto');
		
		$category = $this->_getParam('category');
		
		$summary = $this->_getParam('summary');
		
		if( $from_date) $from_date = $from_date .' '. date('H:i:s');
		else $from_date = date('Y-m-d H:i:s', strtotime("-5 days"));
		
		if( $to_date) $to_date = $to_date .' '. date('H:i:s');
		else $to_date = date('Y-m-d H:i:s');
		
		echo '.';
		
		// put users id to array
		$aUsers = explode(',', $users);		
		
		// start here fetching the activity logs
		
		$logs = new ActivityLogs();
		
		$logs->order_desc = true;
		//if( $from_date && $to_date ) {
		$logs->from_date = $from_date;
		$logs->to_date = $to_date;
		$logs->today = date('Y-m-d H:i:s');
		//}
		
		if( $category) $logs->category = $category;
		
		$users = $logs->act_users($this->userid, $this->table);
		
		$elapsed_time_day = $logs->elapsed_time_day($aUsers);
		
		//$aWithDataUsers = array_map( function($a){return $a['userid'];}, $elapsed_time_day);
		
		$elapsed_daily = array();
		foreach( $elapsed_time_day as $idx => $elapsed_time) {
			$elapsed_daily[ $elapsed_time['userid'] . $elapsed_time['activity_date'] ] = $elapsed_time['time_diff'];
		}

		$results = $logs->fetch_logs( $aUsers );
		
		$data_array = array();
		
		if( $summary ) {
			
			
			//$task_type = array('main task', 'reports', 'admin task', 'others');
			$ctr = 0;
			foreach( $users as $idx => $user) {
				if( !in_array($user['userid'], $aUsers)) continue;
				//if( !in_array($user['userid'], $aWithDataUsers)) continue;
				
				$data_array[$ctr] = $user;
				
				// loop task type
				foreach( $this->typeslist as $type ) {
					$type_value = strtolower($type['type_value']);
					$aTotalSec = array();
					
					$datefr = new DateTime($from_date);
					$dateto = new DateTime($to_date);
					
					$date_current = $datefr->format('Ymd');
					$date_end = $dateto->format('Ymd');
				
					while( $date_current <= $date_end) {
						//echo '<br/>date: '.$date_current;
						//$total_sec = 0;
						if( $datefr->format('N') < 6 ) {
						
						$aTotalSec[$datefr->format('Y-m-d')] = 0;
							foreach( $results as $result) {
								
								if( $user['userid'] == $result['userid']) {
									$tstamp = strtotime($result['activity_date']);
									if( $date_current == date('Ymd', $tstamp ) && $type_value == $result['category']) {
										$date = date('Y-m-d', $tstamp);
										
										//$total_sec += $result['time_sec'];
										sscanf($result['time_diff'], "%d:%d:%d", $hrs, $min, $sec);
										$time_sec = isset($sec) ? $hrs * 3600 + $min * 60 + $sec : $hrs * 60 + $min;
										
										$aTotalSec[$date] += $time_sec;
										//$total_sec += $time_sec;
										//$data_array[ $idx ][$type][ date('d', $tstamp ) ] = $result;
										
									}
								}
							}
						}
						
						
						
						
						$date_current = $datefr->add(new DateInterval('P1D'))->format('Ymd');
					}
					
					foreach($aTotalSec as $date => $total_sec) {
						$elapsed_daily_user_date = $elapsed_daily[ $user['userid'] . $date ];
						if( $total_sec > 0 && $elapsed_daily_user_date > 0)
							$aTotalSec[$date] = ($aTotalSec[$date] / $elapsed_daily_user_date) * 100;
						else $aTotalSec[$date] = 0;
					}
					$data_array[ $ctr ][$type_value] = $aTotalSec;
				}
				
				$ctr++;
			}
		
		} else {
		
			foreach( $users as $idx => $user) {
				if( !in_array($user['userid'], $aUsers)) continue;

				$data_array[$idx] = $user;
				foreach( $results as $result) {
					$dt = new DateTime($result['activity_date']);
					$date = $dt->format('Y-m-d');
					if( $user['userid'] == $result['userid'] && $elapsed_daily[ $user['userid'].$date ] )
						$data_array[ $idx ]['logs'][] = $result;
				}
			}
			
			$this->view->elapsed_daily = $elapsed_daily;
		}
		
		/*$reports = array();
		foreach( $results as $idx => $result) {
			$reports[ $result['userid'] ][] = $result;
		}*/
		$this->view->users = $users;
		
		$this->view->task_types = $this->typeslist;
		$this->view->userid = $userid;
		$this->view->results = $data_array;
		$this->view->from_date = date('Y-m-d', strtotime($from_date));
		$this->view->to_date = date('Y-m-d', strtotime($to_date));
		$this->view->rundate = $to_date;
		$this->_helper->layout->disableLayout();
		if( $summary ) $this->renderScript("index/summary.phtml");
		
		echo "<script type='text/javascript'>";
		echo "window.parent.index.show_status()";
		echo "</script>";
	}
	
	public function myactAction() {
		if( empty($_SESSION['admin_id']) ) die('Invalid access.');
		
		$userid = $this->_getParam('users', $this->userid);
		$from_date = $this->_getParam('from_date', date("Y-m-d", strtotime("-7 days")) );
		$to_date = $this->_getParam('to_date', date('Y-m-d H:i:s'));
		
		$logs = new ActivityLogs();
		
		$logs->order_desc = true;
		if( $from_date && $to_date ) {
			$logs->from_date = $from_date;
			$logs->to_date = $to_date;
		}
		$this->view->users = $logs->act_users();
		
		
		
		//$subcon = new Subcontractors();
		//$staff = $subcon->fetch_staff($userid);
		
		//if( !$staff ) {
		//	$admin = new Admin();
		//	$staff = $admin->fetch_staff($userid);
		//}
		//$results = $logs->fetchAll( $logs->select()->where('userid=?', $userid) )->toArray();
		$results = $logs->fetch_logs( array($userid) );
		
		$this->view->userid = $userid;
		$this->view->results = $results;
		
		$this->view->from_date = $from_date;
		$this->view->to_date = date('Y-m-d', strtotime($to_date));
		
		$this->_helper->layout->enableLayout();
		$this->renderScript("index/report.phtml");
	}
	
	public function timeeditAction() {
		$act_id = $this->_getParam('aid');
		$time = $this->_getParam('time');
		//$date_started = $this->_getParam('date');
				
		$datenow = date("Y-m-d H:i:s");
		
		$log_hist = new ActivityLogsHistory();
		
		$logs = new ActivityLogs();
		$logs->to_date = $datenow;
		
		$elapsed_result = $logs->elapsed_time($act_id);
		
		if( $time != $elapsed_result['time_diff']) {
		
			// convert time input to seconds
			sscanf($time, "%d:%d:%d", $hrs, $min, $sec);
			$time_sec = isset($sec) ? $hrs * 3600 + $min * 60 + $sec : $hrs * 60 + $min;
			
			// update time_diff from table
			$log_hist->update( array('time_diff' => 0), 'aid='.$act_id);
			
			// insert new entry
			$data = array('aid' => $act_id, 'status' => 'finished', 'date_added' => $datenow, 'time_diff' => $time_sec, 'admin' => $this->userid);
			$hist_id = $log_hist->insert($data);
				
			$logs->update(array('current_hid' => $hist_id), 'id='.$act_id);
			
			$aResult = array('time_ended' => ($d = new DateTime($datenow)) ? $d->format('h:i:s A') : '' );
		} else $aResult = array('time_ended' => '');
		
		//$task_owner = $logs->task_owner($act_id);
		//print_r($task_owner);
		
		echo json_encode( $aResult);
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function portalAction() {
		if( !empty($_SESSION['logintype'])) {
			switch( $_SESSION['logintype']) {
				case 'admin':
					header("location: /portal/adminHome.php");
					exit;
				case 'staff':
					header("location: /portal/subconHome.php");
					exit;
				case 'client':
					header("location: /portal/clientHome.php");
					exit;
			}
		} else {
			header("location: /portal/");
			exit;
		}
	}
	
	public function createwfAction() {
		$redirect = sprintf("%s/tools/workflow_django_session_transfer.php?redirect1=%s/workflow/session_transfer/&redirect2=%s/workflow/newtask/", $this->rs_site.'/portal', $this->rs_site.'/portal/django', $this->rs_site.'/portal/django');
		header("location: $redirect");
		exit;
	}
	
	public function tasktypesAction() {
		//$leads_id = Zend_Registry::get('leads_id');
		
		/*$tasktypes = new ActivityLogsTypes();
		$types = $tasktypes->fetch_types($this->leads_id);
		if( !count($types))
			$types = $tasktypes->fetch_types();*/
			
		$this->view->task_types = $this->typeslist;
		$this->_helper->layout->disableLayout();
	}
	
	public function savetypeAction() {
		
		$types_inp = $this->_getParam('ttypes');
		$newtype = $this->_getParam('newtype');
		
		$deltypes = $this->_getParam('deltypes');
		
		$tasktypes = new ActivityLogsTypes();
		
		$date_now = date('Y-m-d H:i:s');
		
		if( count($deltypes)) {
			foreach( $deltypes as $id ) {
				$tasktypes->delete("id=$id AND client_id=".$this->leads_id);
			}
		}
		
		foreach( $types_inp as $idx => $type) {
			$select = $tasktypes->select()
			->where('id=?',$idx);
			//->where('client_id=?', $leads_id)
			//->where('type_value=?', $type);
		
		
			if( ($res = $tasktypes->fetchRow( $select )->toArray()) !== NULL ) {
				if( $res['client_id'] == $this->leads_id && $res['type_value'] != $type)
					$tasktypes->update( array('type_value'=>$type), 'id='.$idx );
				else {
					if( $res['client_id'] != $this->leads_id )
						$tasktypes->insert( array('type_value'=>$type, 'client_id'=>$this->leads_id, 'date_added'=>$date_now, 'added_by'=>$this->userid));
				}
			}
		}
		
		if( count($newtype)) {
			foreach( $newtype as $idx => $type) {
				echo "\n".$idx."-".$type;
				if(trim($type) != "") {
					$tasktypes->insert( array('type_value'=>$type, 'client_id'=>$this->leads_id,
										'date_added'=>$date_now, 'added_by'=>$this->userid));
				}
			}
		}
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		echo "<script type='text/javascript'>";
		echo "window.parent.index.reload_page()";
		echo "</script>";
	}
	
	private function transmitTimedEvent($delay, $result) {
		if ($delay > 0) usleep ($nDelay * 1000);
			
		echo ': <br>' . PHP_EOL; /**/
		//echo 'id: '.$data['id'] . PHP_EOL;
		
		
		//foreach( $data as $result ) {
		if( $result['activity_status'] == 'finished' &&
		   !in_array($result['id'], $_SESSION['fin_act']) ) {
			// remember the finished activity id
			$_SESSION['fin_act'][] = $result['id'];
		}
		//$result['fin'] = $_SESSION['fin_act'];
		
		echo 'data: ' . json_encode($result) . PHP_EOL ;
		//}
		echo PHP_EOL;
		ob_flush();
		flush();
	}
	private function disconnect($data) {		
		//echo ': <br>' . PHP_EOL; /**/
		echo 'event: clientdisconnect' . PHP_EOL;
		
		echo 'data: '.$data . PHP_EOL;
		
		echo PHP_EOL;
		
		ob_flush();
		flush();
	}

}