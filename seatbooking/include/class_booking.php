<?php
/* $Id: class_booking.php 2012-02-21 $ */

//  THIS CLASS CONTAINS SEAT BOOKING METHODS.

class seat_booking {
    private $db;

    private $leads_id;
	
	public $booking_info;
	public $booking_exists;
	public $_error;
	private $_salt;
    
    function __construct($db, $unique = array(0, ''), $where = "") {		
        $this->db = $db;

		$select_fields = '*'; //'userid, fname, lname, image, email, pass, handphone_no,skype_id';
		
		$this->booking_exists = 0;
		$this->booking_info['userid'] = 0;
				
		//if($unique[0] != 0 || $unique[1] != "" ) {
		//}

    }
	
	public function format_date($fieldname = 'booking_starttime', $format = '%Y-%m-%d') {
		$offset = $this->get_tzOffset();
		return "date_format(date_add(from_unixtime($fieldname), interval $offset HOUR), '$format')";
	}
	
	public function get_tzOffset($tz = '+08:00') {
		$currdate = strtotime( date("Y-m-d H:i:s") );
		//if( isset($_SESSION['timezone']) ) $tz = $_SESSION['timezone'];
		$db_date = strtotime( $this->db->fetchOne("SELECT NOW()") );
		
		// SET TIMEZONE AND HOURS OFFSET
		$this->db->query("SET time_zone = '$tz'");
		$newdate = strtotime( $this->db->fetchOne("SELECT NOW()") );
		
		$tzOffset = ($newdate - $db_date) / 3600;
		return $tzOffset;
	}
	
	public function getLocalTime ( $tzOffset ) {
		$offset = (int)$tzOffset;
		/*if( $offset != 0 )	$offset = $tzOffset*60*60; //converting offset to seconds.
		else $offset = 60*60;*/
		//$dateFormat="Y-m-d\TH:i:s\Z a";//"d-m-Y H:i e P O";
		//$timeNdate=gmdate($dateFormat, time()+$offset);
		$dow = gmdate('D', time()+$offset);
		$hour = gmdate ('g' , time()+$offset ) ;
		$minute	= gmdate ('i' , time()+$offset ) ;
		$second	= gmdate ('s' , time()+$offset ) ;
		$am = gmdate ('a' , time()+$offset ) ;

		return implode(',', array($hour, $minute,$second, "'".$dow."','".$am."'") );
	}
	
	public function logout() {
		
		$this->error = '';
		$this->booking_exists = 0;
		$this->booking_info = array();

		$_SESSION['userid']="";
		$_SESSION['emailaddr']="";

		session_destroy();
		//2012-12-06 redirected to portal
		header("location:/portal/");
		//header("location:/adhoc/php/as_login.php");
		exit;
	}
	
}



?>