<?php

class checkRsscUser {
	private $couch_dsn;
	
	function __construct($couch_dsn) {
		$this->couch_dsn = $couch_dsn;
		
	}
	
	public function RSSC_userTimeIn($userid, $date = array() ) {
		
		$date_start = $date['start'];
		$date_end = $date['end'];
		$hr = $date['hour'];
		$minute = $date['minute'];
		$min_add = $date['min_add'];
		try {
			$couch_rssc = new couchClient($this->couch_dsn, 'rssc_time_records');
		}catch(Exception $e) {
			die($e->getMessage());
		}
		
		$startValue = array( (int)$userid, array( (int)$date_start[0], (int)$date_start[1], (int)$date_start[2], 0,0,0 ) );
		$endValue = array( (int)$userid, array( (int)$date_end[0], (int)$date_end[1], (int)$date_end[2], (int)$hr, (int)$minute,59 ) );
		
		//$startValue = array( 84190, array( 2013,10,22,6,0,0) );
		//$endValue = array( 84190, array( 2013,10,22,6,7,0 ) );
		//print_r($startValue);
		//print_r($endValue);
		//$doc = couchDocument::getInstance($couch_rssc, 'fff2955e2c3088eb2053416233fa4b4d');
		//var_dump($this->couch_dsn);

		$view = $couch_rssc
		->startkey( $startValue )
		->endkey( $endValue )
		->getView('rssc_reports', 'userid_timein');
		return $view;
    }
	
	public function RSSC_overBreaks($date = array(), $notify_type ) {
		$date_start = $date['start'];
		$date_end = $date['end'];
		$hr = $date['hour'];
		$minute = $date['minute'];
		$min_end = $date['min_end'];
		try {
			$couch_rssc = new couchClient($this->couch_dsn, 'rssc_time_records');
		}catch(Exception $e) {
			die($e->getMessage());
		}
		
		$startValue = array( (int)$date_start[0], (int)$date_start[1], (int)$date_start[2], (int)$hr, (int)$minute,0 ) ;
		$endValue = array( (int)$date_end[0], (int)$date_end[1], (int)$date_end[2], (int)$hr, 59,59 );
		
		//print_r($startValue);
		//print_r($endValue);
		
		$view = $couch_rssc
		->startkey( $startValue )
		->endkey( $endValue )
		->getView('subcon_management', $notify_type);
		return $view;
    }
	
	public function RSSC_disconnected($date = array()) {
		
		$date_start = $date['start'];
		$date_end = $date['end'];
		$hr = $date['hour'];
		$minute = $date['minute'];
		$min_end = $date['min_end'];
		try {
			$couch_rssc = new couchClient($this->couch_dsn, 'rssc_reports');
		}catch(Exception $e) {
			die($e->getMessage());
		}
		
		$startValue = array( (int)$date_start[0], (int)$date_start[1], (int)$date_start[2], (int)$hr, (int)$minute,0 ) ;
		$endValue = array( (int)$date_end[0], (int)$date_end[1], (int)$date_end[2], (int)$hr, 59,59 );
		//$startValue = array( 84190, array( 2013,10,22,6,0,0) );
		//$endValue = array( 84190, array( 2013,10,22,6,7,0 ) );

		$view = $couch_rssc
		->startkey( $startValue )
		->endkey( $endValue )
		->getView('subcon_management', 'finish_work_violators');
		return $view;
    }
	
	
}
