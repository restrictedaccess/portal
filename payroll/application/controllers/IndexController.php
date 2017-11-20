<?php

class IndexController extends Zend_Controller_Action {
	private $config = array();
	private $couch_dsn;
	private $rs_site;
		
    public function init() {
        $response = $this->getResponse();
		//print_r($this->getRequest()->getRequestUri());
        // insert other templates
		if( !$this->_getParam('item') || $this->_getParam('item') == 'tssummary') {
			if( empty($_SESSION['admin_id']) ) {
				header("Location: /portal/index.php");
				exit;
			} else {
				if( !empty($_SESSION['admin_id']) && !in_array($_SESSION['admin_id'], array(43, 6, 193, 214) ) ) {
					$this->send_denied_email();
					die('You are not allowed to acces this page');
				}
				
			}
		//$response->insert('sidebar', $this->view->render('layouts/sidebar.phtml'));
		$response->insert('topnav', $this->view->render('layouts/topnav.phtml'));
		$this->view->month_year = '2013-07';
		$this->view->viewname = "<script type='text/javascript'>var view_name='processtime';</script>";
		}
		
		$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
				? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
		$this->config = Zend_Registry::get('config');
		$this->couch_dsn = Zend_Registry::get('couch_dsn');
		
		$this->createLoggedinView();
		/*echo "<script type='text/javascript'>";
		echo "window.parent.payroll_cutoff=".json_encode($this->get_payroll_range());
        echo "</script>";*/
		//$date = new DateTime('2013-09-05 22:00:00');
		//echo $date->getTimestamp();
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
		$this->render('cutoff');
	}
	
	public function indexAction() {
        $this->view->pageTitle = "RS Payroll Computation";
		//$this->_redirect('index');
		$this->view->subtitle = 'Cut Off';
		$this->view->view = 'processtime';
		$item = $this->_getParam('item');
		//if( $item == 'tssummary' ) //$this->_redirect('/timesheet/timesheet.php?item='.$item);
		//$this->_forward('index', 'timesheet', null, array('baz' => 'bogus'));
		if( $item && $item != 'index' ) {
			return $this->_doAction($item);
			//$this->_forward('index', 'timesheet', null, array('baz' => 'bogus'));
		}
		
		$direction = $this->_getParam('dir', null);
		$range_cnt = $this->_getParam('cnt', 0);
		
		if( $this->_getParam('cutoff') )
			$cutoff = explode('_', $this->_getParam('cutoff'));
		else $cutoff = $this->get_timesheet_range(true);
		
		$_SESSION['ts_daterange'] = $cutoff;
		
		$prev_cutoff = implode('_', $this->get_timesheet_range(true, 'left', $cutoff));
		$next_cutoff = implode('_', $this->get_timesheet_range(true, 'right', $cutoff));

		$this->view->daterange = date("M j", strtotime($cutoff[0]) ) .' - ' . date("M j, Y", strtotime($cutoff[1]));
		
		
		$this->view->prev = $prev_cutoff;
		$this->view->next = $next_cutoff;
		
    }
	
	public function tssummaryAction() {
		$direction = $this->_getParam('dir', null);
		$range_cnt = $this->_getParam('cnt', 0);
		
		if( $direction == null ) unset($_SESSION['ts_daterange']);
		
		//Zend_Debug::dump($ts_daterange->tsparam);

		//Zend_Registry::set('ts_daterange', array($direction, $range_cnt));
		
		$cutoff = $this->get_timesheet_range(true, $direction, 1); //$this->get_payroll_range();
		$this->view->subtitle = 'Time Sheet';
		
		$this->view->view = 'tssummary';
		$this->view->left_cnt = $left;
		$this->view->right_cnt = $right;
		
		
		$this->view->daterange = date("M j", strtotime($cutoff[0]) ) .' - ' . date("M j, Y", strtotime($cutoff[0]));
		$this->view->viewname = "<script type='text/javascript'>var view_name='tssummary';</script>";
		$this->renderScript("index/index.phtml");
	}
	
	public function daterangeAction() {
		$pay_cutoff = explode(',', $this->config->payroll->cutoff);
		
		echo "<script type='text/javascript'>";
		echo "window.parent.payroll_cutoff=".json_encode($this->get_payroll_range());
		echo "</script>";
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function cutoffAction() {
		$pay_cutoff = explode(',', $this->config->payroll->cutoff);
		/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-Type: application/json");*/
		//echo "window.parent.payroll_cutoff = ".json_encode( $pay_cutoff ).";";
		$this->view->dates = $pay_cutoff;
		$this->_helper->layout->disableLayout();
		//$this->_helper->viewRenderer->setNoRender();
	}
	
	public function holidaysAction() {
		$pay_cutoff = explode(',', $this->config->payroll->cutoff);
		$this->view->holidays = $pay_cutoff;
		$this->_helper->layout->disableLayout();
		//$this->_helper->viewRenderer->setNoRender();
	}
	
	public function startprocessAction() {
		echo 'test';
		$this->_helper->layout->disableLayout();
		//$this->_helper->viewRenderer->setNoRender();
	}
	
	// start processing timerecords
	public function processtimeAction() {
		echo '.'; // for some reason, we have to output char at the start of function to properly output the page.
		//$this->view->addScriptPath('views/scripts/index');
		$view = $this->_getParam('view');
		
		$cutoff = $_SESSION['ts_daterange']; //$this->get_timesheet_range(true);
		
		$staff_names = array();
		//$cutoff = $this->get_payroll_range();
		$subcon = new Subcontractors();
		$subcon->order_by = 'p.fname';
		$aStaff = $subcon->get_inhouse_staff();
		//$this->render('timerecords');
		//$this->view->daterange = date("M j", strtotime($cutoff['date_start']) ) .' - ' . date("M j, Y", strtotime($cutoff['date_end']));
		$aURL = array();
		foreach( $aStaff as $staff ) {
			$userid = $staff['userid'];
			$contractid = $staff['contract_id'];
			$staff_names[$userid] = array('fname'=>$staff['fname'], 'lname'=>$staff['lname'], 'contractid'=>$contractid, 'hourly_rate'=>$staff['hourly_rate']);
			//echo '<br/>'.$this->rs_site."/portal/payroll/index.php?item=timerecords&userid={$userid}&contractid={$contractid}&date_start={$cutoff['date_start']}&date_end={$cutoff['date_end']}";
			array_push($aURL, $this->rs_site."/portal/payroll/index.php?item=timerecords&userid={$userid}&contractid={$contractid}&date_start={$cutoff[0]}&date_end={$cutoff[1]}");
			//array_push($aURL, $this->rs_site."/portal/payroll/index.php?item=timerecords&userid={$userid}&contractid={$contractid}&date_start={$cutoff['date_start']}&date_end={$cutoff['date_end']}");
		}
		
		$multireq = new ParallelRequest($aURL);
		$staff_timedetails = $multireq->run();
		
		$this->view->staff_names = $staff_names;
		$this->view->staff_timedetails = $staff_timedetails;
		
		echo "<script type='text/javascript'>";
		echo "window.ptime.hide_loading();";
		echo "</script>";
		//ob_clean();
		$this->_helper->layout->disableLayout();
		//$this->_helper->viewRenderer->setNoRender();
		$this->renderScript("index/{$view}.phtml");
	}
	
	public function timesheetAction() {
		$userid = $this->_getParam('uid');
		$contractid = $this->_getParam('cid');
		
		$ts = (boolean)$this->_getParam('ts');
		
		$cutoff = $_SESSION['ts_daterange']; //$cutoff = $this->get_timesheet_range(true);
		
		$this->view->daterange = date("M j", strtotime($cutoff[0]) ) .' - ' . date("M j, Y", strtotime($cutoff[1]));
		$aURL = array($this->rs_site."/portal/payroll/index.php?item=timerecords&userid={$userid}&contractid={$contractid}&date_start={$cutoff[0]}&date_end={$cutoff[1]}");
		
		$subcon = new Subcontractors();
		$aStaff = $subcon->get_inhouse_staff($userid);
		
		$staff_name = array('fname'=>$aStaff[0]['fname'], 'lname'=>$aStaff[0]['lname'], 'contractid'=>$contractid, 'hourly_rate'=>$aStaff[0]['hourly_rate']);

		$multireq = new ParallelRequest($aURL);
		$staff_timedetails = $multireq->run();
		
		$this->view->staff_name = $staff_name;
		$this->view->staff_timedetails = $staff_timedetails;
		$this->_helper->layout->disableLayout();
	}
	
	
	public function staffrateAction() {		
		$subcon = new Subcontractors();
		$subcon->order_by = 'p.fname';
		$aStaff = $subcon->get_inhouse_staff();
		
		$this->view->staff_lists = $aStaff;
		//$this->view->staff_timedetails = $staff_timedetails;
		$this->_helper->layout->disableLayout();
	}
	
	public function saverateAction() {
		$staffrate = new PayrollStaffRate();
		
		foreach( $this->_getAllParams() as $key => $value ) {
			if( preg_match('/^rate(\d+)/', $key, $match) ) {
				$uid = $match[1];
				$edit = $this->_getParam('edit'.$uid);
				if( (float)$value && $edit == 'true') {
					if( $staffrate->is_exists($uid) )
						$staffrate->update( array('hourly_rate' => $value), 'uid='.$uid );
					else
						$staffrate->insert( array('uid' => $uid, 'hourly_rate' => $value) );
				}
			}			
		}
		echo "<script type='text/javascript'>";
		echo "window.misc.show_status('Staff hourly rate has been updated');";
		echo "window.misc.enable_button('button#update')";
        echo "</script>";
		//$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function timerecordsAction() {
		$date_start = explode('-', $this->_getParam('date_start'));
		$date_end = explode('-',$this->_getParam('date_end'));
		
		$userid = (int)$this->_getParam('userid');
		//$leadsid = (int)$this->_getParam('leadsid');
		$contractid = (int)$this->_getParam('contractid');
		
		
		$regular_time = $this->timerecordDocs( $userid, $contractid, 'time', $date_start, $date_end);
		$lunch_time = $this->timerecordDocs( $userid, $contractid, 'lunch', $date_start, $date_end);
		
		//print_r($regular_time);
		//print_r($lunch_time);
		
		$timerecords = array();
		$lunchrecords = array();
		
		foreach( $regular_time->rows as $row ) {
			$aTimein = $row->key[3];
			$aTimeout = $row->value;
			
			$date = new DateTime( "{$aTimein[0]}-{$aTimein[1]}-{$aTimein[2]} {$aTimein[3]}:{$aTimein[4]}:{$aTimein[5]}" );
			$tstamp_in = $date->getTimestamp();
			
			$date = new DateTime( "{$aTimeout[0]}-{$aTimeout[1]}-{$aTimeout[2]} {$aTimeout[3]}:{$aTimeout[4]}:{$aTimeout[5]}" );
			$tstamp_out = $date->getTimestamp();
			
			
			$time_diff = round( ($tstamp_out - $tstamp_in)/3600, 2);
			
			$idx = "{$aTimein[0]}-".sprintf('%02d',$aTimein[1])."-{$aTimein[2]}";
			//echo '<br/>IDX:'.$idx.' - '.$time_diff.' timein=>'.$aTimein.' timeout=>'.$aTimeout;
			
			if( !empty($timerecords[$idx]) ) {
				$timerecords[$idx]['timeout'] = $tstamp_out;
				$timerecords[$idx]['timediff'] += $time_diff;
			} else
				$timerecords[$idx] = array('timein'=>$tstamp_in, 'timeout'=>$tstamp_out, 'timediff'=>$time_diff);
		}
		
		foreach( $lunch_time->rows as $row ) {
			$aTimein = $row->key[3];
			$aTimeout = $row->value;
			
			$date = new DateTime( "{$aTimein[0]}-{$aTimein[1]}-{$aTimein[2]} {$aTimein[3]}:{$aTimein[4]}:{$aTimein[5]}" );
			$tstamp_in = $date->getTimestamp();
			
			$date = new DateTime( "{$aTimeout[0]}-{$aTimeout[1]}-{$aTimeout[2]} {$aTimeout[3]}:{$aTimeout[4]}:{$aTimeout[5]}" );
			$tstamp_out = $date->getTimestamp();
			
			$time_diff = round( ($tstamp_out - $tstamp_in)/3600, 2);
			
			$idx = "{$aTimein[0]}-".sprintf('%02d',$aTimein[1])."-{$aTimein[2]}";
			//echo '<br/>IDX:'.$idx.' - '.$time_diff;
			
			if( !empty($lunchrecords[$idx]) )
				$lunchrecords[$idx] += $time_diff;
			else
				$lunchrecords[$idx] = $time_diff;
		}
		
		//print_r($lunchrecords);
		$ts_details = new TimesheetDetails();
		$ts_details->day_start = sprintf('%02d', $date_start[2]);
		$ts_details->day_end = sprintf('%02d', $date_end[2]);
		$ts_details->month_year1 = $date_start[0].'-'.$date_start[1];
		$ts_details->month_year2 = $date_end[0].'-'.$date_end[1];
		
		$results = $ts_details->staff_timesheet_details(array('userid'=>$userid, 'contractid'=>$contractid));
		
		$total_adj_hrs = 0;
		$total_reg_hrs = 0;
		$total_ot = 0;
		$total_ut = 0;
		//print_r($results);
		foreach( $results as $idx => $row ) {
			
			$date_pos = "{$row['monthyear']}-{$row['day']}";
			
			$reg_timelimit = new DateTime("{$date_pos} 22:00:00");
			
			//$ndiff_mn1 = ($ndiff_mn1 = new DateTime("{$date_pos} 23:59:59")) ? $ndiff_mn1->getTimestamp() : false;
			//$ndiff_mn2 = ($ndiff_mn2 = new DateTime("{$date_pos} 00:00:00")) ? $ndiff_mn2->getTimestamp() : false;
			
			$nightdiff_end = new DateTime("{$date_pos} 6:00:00");
			//---->2014/03/31 $nightdiff_end->add(new DateInterval('P1D'));
			
			// 2014/03/31
			$ndiff_start = $reg_timelimit->getTimestamp();
			$ndiff_end = $nightdiff_end->getTimestamp();
			
			$results[$idx]['regtime_limit'] = $ndiff_start; //$reg_timelimit->getTimestamp();
			$results[$idx]['nightdiff_end'] = $ndiff_end; //$nightdiff_end->getTimestamp();
			
			$dayweek = date("N", $reg_timelimit->getTimestamp());
			
			$reg_hrs = $adj_hrs = $ut_hrs = $ot_hrs = $ndiff = $ndiff_ot = 
			$rest_hrs = $rest_ot_hrs = $logged_hrs = $time_logged = 0;
			//$results[$idx]['timerecords'] = $timerecords[$date_pos];
			//echo '<br/>date_pos:'.$date_pos;
			
			if( !empty($timerecords[$date_pos])) {
				//print_r($timerecords[$date_pos]);
				$timerecord = $timerecords[$date_pos];
				$lunchrecord = $lunchrecords[$date_pos];
				
				// hours logged by user
				$time_logged = $timerecord['timediff'] - $lunchrecord;
				$logged_hrs = ((float)$row['adj_hrs']) > 0 ? $row['adj_hrs'] : $time_logged;
				
				//echo '<br/>'.$row['adj_hrs'].':'.$logged_hrs;
				//if(empty($row['adj_hrs']))
				//echo '<br/>'.$date_pos.': '.$timerecord['timediff'].' - '.$lunchrecord;
				
				$tstamp_in = $timerecord['timein'];
				// timestamp of timeout
				$tstamp_out = $timerecord['timeout'];
				
				// $adj_hrs = empty($row['adj_hrs']) ? $logged_hrs : $row['adj_hrs'];
				$rostered_hrs = $row['regular_rostered'] > 0 ? $row['regular_rostered'] : ($dayweek < 6 ? 8.00 : 0); // contract hours
				
				$reg_hrs = $rostered_hrs > $logged_hrs ? $logged_hrs : $rostered_hrs;
				
				//$reg_span = round( ($reg_timelimit->getTimestamp() - $tstamp_out)/3600, 2 );
				$reg_span = round( ($ndiff_start - $tstamp_out)/3600, 2 );
				
				$timein_span = round( ($tstamp_in - $ndiff_end )/3600, 2 );
				//$reg_loggedin = $reg_timelimit->getTimestamp() - $tstamp_out;
				
				
				//$timein_bet_ndiff = ( ($ndiff_start <= $tstamp_in && $tstamp_in <= $ndiff_mn1) || ($ndiff_mn2 <= $tstamp_in && $tstamp_in <= $ndiff_end) );
				//$timeout_bet_ndiff = ( ($ndiff_start <= $tstamp_out && $tstamp_out <= $ndiff_mn1) || ($ndiff_mn2 <= $tstamp_out && $tstamp_out <= $ndiff_end) );

				
				// check if timein and timeout is in between of night diff time range
				if( $reg_span > -1 && $timein_span > -1 ) {
				//if( $reg_span > -1 || (!$timein_bet_ndiff && !$timeout_bet_ndiff) ) {
					
					//$ot_hrs = round( $reg_loggedin / 3600, 2 );
					
					$ot_hrs = $logged_hrs - $reg_hrs;
					
					//$reg_hrs = $rostered_hrs > $reg_hrs ? $reg_hrs : $rostered_hrs;
					
					//if( $ot_hrs < 0 ) {
					if( $reg_hrs < $rostered_hrs ) {
						$ut_hrs = $rostered_hrs - $reg_hrs;
						$ot_hrs = 0;
					}

				} else {
					$less_ndiff = 0;
					if( $reg_span < 0) $less_ndiff += $reg_span;
					if( $timein_span < 0) $less_ndiff += $timein_span;
						
					//if( $reg_timelimit->getTimestamp() > $timerecord['timein'])
					if( $ndiff_start > $tstamp_in && $tstamp_out > $ndiff_end ) {
						$reg_hrs = $logged_hrs + $less_ndiff;
					}
					
					
					//echo '<br/>'.$date_pos.': '.$logged_hrs.' - '.$reg_hrs.' > '.$reg_span;
					
					// test if the users logged more than the rostered hours
					if( $reg_hrs > $rostered_hrs ) {
						$ot_hrs = $reg_hrs - $rostered_hrs;
						$reg_hrs -= $ot_hrs;// $rostered_hrs; // regular hrs should not exceed to contract hrs
						$ndiff = round(-1 * $less_ndiff, 2);
						
					} else {
						//$reg_hrs = $logged_hrs + $less_ndiff;
						
						// check if staff has overtime during night diff
						if( $logged_hrs >= $rostered_hrs ) {							
							$ndiff_ot = round($logged_hrs - $rostered_hrs, 2);
							
							if( $dayweek < 6) $ndiff = round( (-1 * $less_ndiff) - $ndiff_ot, 2);
							
						} else {
							$ut_hrs = $rostered_hrs - $reg_hrs;
							
							$ndiff = $reg_hrs;
							$reg_hrs = 0;
						}
						
					}
					
					
					
					//$reg_hrs -= $ndiff;
					//$nightdiff += $ndiff;
				}
				
				$ot_hrs += ($ndiff + $ndiff_ot);
				
				
				if( $dayweek > 5 ) {
					$rest_hrs = $reg_hrs;
					$rest_ot_hrs = $ot_hrs;
					$reg_hrs = 0;
					$ot_hrs = 0;
					$ut_hrs = 0;
				}
				
				$results[$idx]['timein'] = $tstamp_in; //$timerecord['timein'];
				$results[$idx]['timeout'] = $tstamp_out;

			
			}
			
			if( !$reg_hrs ) $ut_hrs = $results[$idx]['regular_rostered'];
			
			$results[$idx]['logged_hrs'] = $logged_hrs;
			$results[$idx]['reg_hrs'] = $reg_hrs;
			$results[$idx]['ot_hrs'] = $ot_hrs;
			$results[$idx]['ut_hrs'] = $ut_hrs;
			$results[$idx]['ndiff'] = $ndiff;
			$results[$idx]['ndiff_ot'] = $ndiff_ot;
			
			$results[$idx]['rest_hrs'] = $rest_hrs;
			$results[$idx]['rest_ot_hrs'] = $rest_ot_hrs;
			
			$results[$idx]['dayweek'] = $dayweek;
			$results[$idx]['time_logged'] = $time_logged;
		}
		
		echo json_encode($results);
		
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function timedetailsAction() {	
		
		$date_start = explode('-', $this->_getParam('date_start'));
		$date_end = explode('-',$this->_getParam('date_end'));
		
		$userid = $this->_getParam('userid');
		$leadsid = $this->_getParam('leads');
		$contractid = $this->_getParam('contract_id');
		
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	
		
	private function timerecordDocs($userid, $contractid, $type, $date_start, $date_end) {
		
		try {
			$couch_rssc = new couchClient($this->couch_dsn, 'rssc_time_records');
		}catch(Exception $e) {
			die($e->getMessage());
		}
		
		$startValue = array( $userid, $contractid, $type, array( (int)$date_start[0], (int)$date_start[1], (int)$date_start[2], 0,0,0 ) );
		$endValue = array( $userid, $contractid, $type, array( (int)$date_end[0], (int)$date_end[1], ((int)$date_end[2])+1, 0,0,0 ) );
		//$doc = couchDocument::getInstance($couch_rssc, 'fff2955e2c3088eb2053416233fa4b4d');
		
		$view = $couch_rssc
		->startkey( $startValue )
		->endkey( $endValue )
		//->descending(true)
		//->include_docs(true)
		//->limit(30)
		//->getView('prepaid', 'timerecords');
		->getView('logged_in', 'time_summary');
		
		return $view;
    }
	
	private function createLoggedinView() {
		try {
			$couch_rssc = new couchClient($this->couch_dsn, 'rssc_time_records');
		}catch(Exception $e) {
			die($e->getMessage());
		}
		
		$doc = new couchDocument($couch_rssc);
		
		try {
			//preparing the views object
			$doc->_id = "_design/logged_in";
			
			$views = new stdClass();
			$views->{"time_summary"} = array (
"map" => "function (doc) {
if(doc.type == 'timerecord' && doc.time_out != false) {
emit([doc.userid, doc.subcontractors_id, 'time', doc.time_in], doc.time_out);
}
if(doc.type == 'lunchrecord' && doc.end != false) {
emit([doc.userid, doc.subcontract_id, 'lunch', doc.start], doc.end);
}
}"
		);
		
			$doc->views = $views;
		} catch(Exception $e) {
			// do nothing
			return;
		}
	}
	
	private function get_payroll_range($ts = false, $dir = null, $cnt = 0) {
		$cal = $this->config->cal;
		$pay_cutoff = explode(',', $this->config->payroll->cutoff);
		
		$pay_start = $pay_cutoff[0];
		$pay_end = $pay_cutoff[1];
		
		$dow = date("d");
		// 10, 25
		if( $dow > $pay_end ) {
			$pay_start++;
			$date_start = date("Y-m-d", mktime(0, 0, 0, date("m"), date($pay_start), date("Y")) );
			$date_end = date("Y-m-d", mktime(0, 0, 0, date("m"), date($pay_end), date("Y")) );
			
		} elseif( $dow > $pay_start ) {
			$pay_end++;
			$date_start = date("Y-m-d", mktime(0, 0, 0, date("m")-1, date($pay_end), date("Y")) );
			$date_end = date("Y-m-d", mktime(0, 0, 0, date("m"), date($pay_start), date("Y")) );

		} else {
			$pay_start++;
			$date_start = date("Y-m-d", mktime(0, 0, 0, date("m")-1, date($pay_start), date("Y")) );
			$date_end = date("Y-m-d", mktime(0, 0, 0, date("m")-1, date($pay_end), date("Y")) );
		}
		
		return array('date_start'=>$date_start, 'date_end'=>$date_end);
		//return array('date_start'=>'2013-09-6', 'date_end'=>'2013-09-20');
		
	}
	
	private function get_timesheet_range($ts = false, $dir = null, $ts_daterange = array()) {
		$cal = $this->config->cal;
		$pay_cutoff = explode(',', $this->config->payroll->cutoff);

		$dow = date("d");
		
		
		$pay_start = $pay_cutoff[0];
		$pay_end = $pay_cutoff[1];//$dow < $pay_cutoff[1] ? $dow : $pay_cutoff[1];
		
		if( count($ts_daterange) == 0 ) {
			$start_day = $dow > $pay_end ? $pay_end: $pay_start;
			$start_month = $dow>$pay_start?0:1;
			$date_start = date("Y-m-d", mktime(0, 0, 0, date("m")- ( $dow>$pay_start?0:1 ), date($start_day)+1, date("Y")) );
			$date_end = date("Y-m-d", mktime(0, 0, 0, date("m") + ( $start_day==$pay_start?0:1 ), date( $start_day==$pay_start?$pay_end:$pay_start ), date("Y")) );
		}
		else {
			$start = new DateTime($ts_daterange[0]);
			$end = new DateTime($ts_daterange[1]);
			
			switch( $dir ) {
				case 'left':
					$d1 = $start->format('d') == $dow ? $pay_end : ($start->format('d'))-1;
					
					$d2 = ($d1 == $pay_start) ? $pay_end : $pay_start;
					
					if( $d1 == $pay_cutoff[0] ) {
						$d = new DateTime( date("Y-m-d", mktime(0, 0, 0, $start->format('m'), date($d2+1), $start->format("Y")) ) );
						$d->sub(new DateInterval('P1M'));
						$date_start = $d->format("Y-m-d");
					} else {
						$date_start = date("Y-m-d", mktime(0, 0, 0, $start->format('m'), date($d2+1), $start->format("Y")) );
					}
					
					
					//if( $d2 < $pay_start ) {
					if( $d2 == $pay_cutoff[0] ) {
						$date_end = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime( $date_start )), date($d1), $start->format("Y")) );
					} else {
						$date_end = date("Y-m-d", mktime(0, 0, 0, $end->format('m'), date($d1), $start->format("Y")) );
					}
					break;
				case 'right':
					
					$d1 = $end->format('d') == $dow ? $pay_end : $end->format('d');
					
					//$d2 = $dow > $pay_start ? $dow : ($d1 == $pay_start ? $pay_end : $pay_start);
					$d2 = $d1 == $pay_start ? $pay_end : $pay_start;
					
					$date_start = date("Y-m-d", mktime(0, 0, 0, $end->format('m'), date($d1+1), $end->format("Y")) );
					
					if( $d2 < $d1 ) {
						$d = new DateTime(date("Y-m-d", mktime(0, 0, 0, $end->format('m'), date($d2), $end->format("Y")) ));
						$d->add(new DateInterval('P1M'));
						$date_end = $d->format("Y-m-d");
					} else {
						$date_end = date("Y-m-d", mktime(0, 0, 0, $end->format('m'), date($d2), $end->format("Y")) );
					}
					break;
				default:
					$date_start = $start->format('Y-m-d');
					$date_end = $end->format('Y-m-d');
					break;
			}
		}
		
		return array($date_start, $date_end);
	}
	
	private function send_denied_email() {
		$admin = new Admin();
		$utils = Utils::getInstance();
				
		$admin_user = $admin->fetchRow( $admin->select()->where('admin_id=?', $_SESSION['admin_id']) )->toArray();
			
		$subject = "Access Denied on Inhouse Payroll (Admin #{$admin_user['admin_id']})";
		$email_body = "<p><strong>Date: </strong>".date("M j, Y H:i a")."</p>"
		."<p><strong>Admin: </strong>{$admin_user['admin_fname']} {$admin_user['admin_lname']} #{$admin_user['admin_id']}</p>";
		
		$utils->send_email($subject, $email_body, '', 'Remotestaff Notification', false);
	}
}