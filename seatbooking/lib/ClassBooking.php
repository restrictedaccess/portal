<?php
/* $Id: class_booking.php 2012-02-21 $ */

//  THIS CLASS CONTAINS SEAT BOOKING METHODS.
// This would be the model file
include_once('activecalendar.php');
include_once('../lib/paginator.class.php');

class ClassBooking {
    private $db;

    private $leads_id;
	
	public $booking_info;
	public $booking_exists;
	public $is_error;
	private $_salt;
	
	public $booking_tstamp;
	public $book_endtstamp;
	public $seat_id;
	public $book_id;
	
	private static $instance = NULL;
	
	// return Singleton instance of MySQL class
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }

    public function __construct($db, $unique = array(0, ''), $where = "") {		
        $this->db = $db;

		$select_fields = '*'; //'userid, fname, lname, image, email, pass, handphone_no,skype_id';
		
		$this->booking_exists = 0;
		$this->booking_info['userid'] = 0;
		$this->is_error = 0;
    }
	
	// get booking schedule for specific date
	public function getSeats($seat_id = NULL) {
        $bstart_qstr = $this->format_date('b.booking_starttime', '%l%p');
        $bfinish_qstr = $this->format_date('b.booking_endtime', '%l%p');
		
		//$bstartnum_qstr = $this->format_date('b.booking_starttime', '%k');
        //$bfinishnum_qstr = $this->format_date('b.booking_endtime', '%k');
		
		$datestart_qstr = $this->format_date('min(b.booking_starttime)', '%m/%d/%Y');
		$datefinish_qstr = $this->format_date('max(b.booking_endtime)', '%m/%d/%Y');
		
		$bdate1_qstr = $this->format_date('min(b.booking_starttime)', '%b %e');
		$bdate2_qstr = $this->format_date('max(b.booking_endtime)', '%e');
                
        $query = "SELECT $bstart_qstr book_start, $bfinish_qstr book_end, $datestart_qstr date_start,
		$datefinish_qstr date_end, seat_id, b.staff_id, b.leads_id, b.booking_type,
		$bdate1_qstr book_date1, $bdate2_qstr book_date2,
        b.id, p.fname, p.lname, l.fname cfname, l.lname clname, b.booking_status, b.noise_level,
		if(b.booking_payment='TBP', 'To Be Paid', b.booking_payment) booking_payment,
		((b.booking_endtime-b.booking_starttime)div 60 div 60) hrs, count(b.id) cnt,
		if(b.timezone='AU','au.png', if(b.timezone='UK', 'england.png', 'us.png') ) flag,
		if(b.booking_status='Pending','#f8cbcb', '#CCFF99') bgcolor
		FROM seat_bookings b LEFT JOIN personal p ON p.userid=b.staff_id
        LEFT JOIN leads l ON l.id=b.leads_id WHERE b.booking_status<>'Cancelled'";
		
		if( $this->booking_tstamp && $this->book_endtstamp ) {
			$query .= " AND b.booking_starttime>=".$this->booking_tstamp." AND b.booking_endtime<=".$this->book_endtstamp;
		} else {
			$query .= " AND b.booking_starttime>=".strtotime(date("Y-m-d"));
		}
		
		if( $seat_id !== NULL ) {
			if( $seat_id < 1 ) $seat_id = 1;
			$query .= " AND seat_id>=".$seat_id ." AND seat_id<".(int)($seat_id+4);
		}
		
		$query .= " GROUP BY b.booking_updated, b.booking_status ORDER BY b.id DESC, b.booking_updated";
//echo $query;
        $book_result = $this->db->fetchAll($query);
		
		$cnt = count($book_result);
		
        $seats_array = array();
        for( $i = 0; $i < $cnt; $i++ ) {
			$seats_array[ $book_result[$i]['seat_id'] ][] = $book_result[$i];
        }
		//print_r($seats_array);

		return $seats_array;
	}
	
	// get seat id of existing bookings
	public function getSeatBooked($starttime = -1, $endtime = -1, $booking_date) {
		$seat_booked = array();
		if( $endtime > -1 && $starttime > -1) {        
			$booking_start = strtotime($booking_date.' '.$starttime.':00:00');
			$booking_finish = strtotime($booking_date.' '.$endtime.':00:00');
        
			$query = "SELECT seat_id FROM seat_bookings WHERE (booking_starttime<=$booking_start AND 
			booking_endtime>=$booking_start) OR (booking_starttime<=$booking_finish AND booking_endtime>=$booking_finish)
			OR (booking_starttime>=$booking_start AND booking_endtime<=$booking_finish)";
	
			$booking_list = $this->db->fetchAll($query);
			
			foreach( $booking_list as $key => $val ) {
				array_push($seat_booked, $val['seat_id']);
			}
		}
		return $seat_booked;
	}
	
	
	public function booking_month_cal($yearID, $monthID, $seat) {
		// get calendar booking
		// get booking for this month
		$book_startdate = strtotime($yearID.'-'.$monthID.'-1');
		$book_enddate = strtotime('+1 month', $book_startdate);
		
		$bdate_qstr = $this->format_date();
		$bstart_qstr = $this->format_date('b.booking_starttime', '%l%p');
		$bfinish_qstr = $this->format_date('b.booking_endtime', '%l%p');
		
		$query = "SELECT $bdate_qstr book_date,	$bstart_qstr book_start, b.seat_id, $bfinish_qstr book_end,
		b.id, b.staff_id, p.fname, p.lname, l.fname cfname, l.lname clname, b.booking_status
		FROM seat_bookings b LEFT JOIN personal p ON p.userid=b.staff_id
		LEFT JOIN leads l ON l.id=b.leads_id WHERE b.seat_id=".$this->seat_id." AND b.booking_status<>'Cancelled'
		AND	b.booking_starttime>=$book_startdate AND b.booking_endtime<$book_enddate";

		$book_result = $this->db->fetchAll($query);
		
		$array_data = array();
		
		
		foreach ($book_result as $entry) {
			$date = explode('-', $entry['book_date']);
			$entry['year'] = $date[0];
			$entry['month'] = $date[1];
			$entry['day'] = $date[2];
			
			$idx = $date[1].$date[2];
			$array_data[$idx][] = $entry;
			
		}
		
		$cal = new activeCalendar($yearID,$monthID,$dayID);
		$myurl = $_SERVER['PHP_SELF'].'?/reserve_seat/';
		$cal->seat_id = $seat;
		//$cal->enableMonthNav($myurl); // this enables the month's navigation controls
		$cal->enableDatePicker(2010,$yearID,$myurl); // this enables the date picker controls

		foreach ($array_data as $data) {
		   //echo $data['book_start'].'-'.$data['book_end'].'<br>';
			$cal->setEventContent($data[0]['year'], $data[0]['month'],$data[0]['day'], $data,"#");
		}
		
		return $cal->showMonth();
	}
	
	public function get_client($userid = 0) {
		if( $userid )
			$query = "
			SELECT * FROM (
				SELECT l.fname, l.lname, l.id, s.userid, s.status FROM leads l
				LEFT JOIN  `subcontractors` s ON s.leads_id = l.id WHERE s.userid=$userid AND s.status='ACTIVE'
			UNION ALL 
				SELECT l.fname, l.lname, l.id, i.applicant_id userid, 'ACTIVE' FROM member m
				LEFT JOIN leads l ON m.leads_id = l.id
				LEFT JOIN tb_request_for_interview i ON i.leads_id = m.leads_id	WHERE i.applicant_id=$userid) clients
				GROUP BY clients.id
				ORDER BY clients.fname, clients.lname ASC";
		else {
			$query = "SELECT l.fname, l.lname, l.id FROM seat_bookings b
			LEFT JOIN leads l ON l.id=b.leads_id GROUP BY l.id";
		}	
        return $this->db->fetchAll($query);
	}
	
	public function create_booking($booktime, $data) {
		$err_msg = '';
		
		$this->is_error = 1;
		
		$booking_start = $this->booking_tstamp;
		$booking_finish = $this->book_endtstamp;
			
		if( empty($data['staff_id']) )
			$err_msg = '<span>Error:</span> Staff id could not found!';
		elseif( empty($booktime['date_from']) || empty($booktime['date_to']) )
			$err_msg = '<span>Error:</span> Booking date is empty.';
		elseif( $booking_start > $booking_finish )
			$err_msg = '<span>Error:</span> Invalid Booking Date!';
		elseif( empty($booktime['start_time']) || empty($booktime['finish_time']) )
			$err_msg = '<span>Error:</span> Invalid Booking Hour!';
		
		else {
			$this->is_error = 0;
				
			$time_interval = $booking_finish - $booking_start;
			if( $time_interval > 0 ) {
				$day_num = $time_interval / 60 / 60 / 24;
			} else $day_num = 0;
			
			$result_array = array();
			$result_str = '';
			
			$current_date = strtotime(date("Y-m-d H:i:s"));
			
			for( $i = 0; $i <= $day_num; $i++ ) {
				$oneday = $i * 86400;
				
				if( (int)$booktime['start_time']  >= (int)$booktime['finish_time'] )
					$nextday = ($i+1) * 86400;
				else $nextday = $i * 86400;
				
				$booking_start = strtotime($booktime['date_from'].' '.$booktime['start_time'].':00:00') + $oneday;
				$booking_finish = strtotime($booktime['date_from'].' '.$booktime['finish_time'].':00:00') + $nextday;
				
				$total_hrs = ($booking_finish - $booking_start) / 60 / 60;
				
				//$result_array[$booking_start] = array('finish' => $booking_finish);
				$result_str = " &#187; ". date("d M Y, ga", $booking_start) ." to " . date("ga", $booking_finish)." ($total_hrs) - ";
				
				// test if the booking time still available
				$query = "SELECT count(id) FROM seat_bookings WHERE seat_id=".$data['seat_id']." AND booking_status<>'Cancelled'
				AND ( (booking_starttime<=$booking_start AND booking_endtime>$booking_start) OR
				(booking_starttime<$booking_finish AND booking_endtime>=$booking_finish) OR
				(booking_starttime>=$booking_start AND booking_endtime<=$booking_finish) )";
				$book_exists = $this->db->fetchOne($query);
				
				if( $booking_start <= $current_date ) {
					$result_str .= "<span style='color:#ff0000;font-weight:bold;'>Failed (time expired)</span>";
				} elseif( !$book_exists ) {
					$data['booking_starttime'] = $booking_start;
					$data['booking_endtime'] = $booking_finish;
					
					if( $this->db->insert('seat_bookings', $data) )					
						$result_str .= "<span style='color:#696;font-weight:bold;'>Success</span>";
					else $result_str .= "<span style='color:#ff0000;font-weight:bold;'>Failed (database error)</span>";
				} else {
					$result_str .= "<span style='color:#ff0000;font-weight:bold;'>Failed (time unavailable)</span>";
				}
				
				array_push($result_array, $result_str);
			}
			//$result_msg = 'Booking Result!';
		}

		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
		if( $err_msg ) {
			// RUN JAVASCRIPT TO ALERT ERROR
			echo 'window.parent.createResult("'.$err_msg.'");';
		} else {
			echo "window.parent.document.getElementById('box-result').style.display='block';";
			echo "window.parent.document.getElementById('result-data').innerHTML=\"".implode('<br/>', $result_array)."\";";
			
		}
		echo "</script></head><body></body></html>";
		exit();
	}
	
	public function get_bookings($where = array()) {
		$cond_q = '';
		if( count($where) > 0 ) {
			$cond_q = implode(' AND ', $where). ' AND ';
		}
		
		// setup date field format query string
		$bdate_qstr = $this->format_date('b.booking_starttime', '%b %d');
		$bdymd_qstr = $this->format_date('b.booking_starttime');			
		$bstart_qstr = $this->format_date('b.booking_starttime', '%l %p');
		$bfinish_qstr = $this->format_date('b.booking_endtime', '%l %p');
		$bstarthr_qstr = $this->format_date('b.booking_starttime', '%k');
		$bfinishhr_qstr = $this->format_date('b.booking_endtime', '%k');
		$bmade_qstr = $this->format_date('b.booking_created', '%m/%d/%Y');
		
		$query = "SELECT b.id, b.seat_id, l.id leads_id, p.userid, l.fname cfname,
		l.lname clname, p.fname, p.lname, a.admin_fname, a.admin_lname,
		$bdate_qstr book_date, $bdymd_qstr date_ymd, $bstart_qstr book_start, $bfinish_qstr book_end,
		$bstarthr_qstr start_hr, $bfinishhr_qstr end_hr, $bmade_qstr book_made,
		((b.booking_endtime-b.booking_starttime)div 60 div 60) hrs,
		b.booking_type, b.booking_by, b.booking_status, booking_payment, timezone, booking_schedule,
		if(b.booking_status='Pending','#f8cbcb', if(b.booking_status='Confirmed','#CCFF99', '#e9edf4') ) bgcolor
		FROM seat_bookings b LEFT JOIN leads l ON l.id=b.leads_id
		LEFT JOIN personal p ON p.userid=b.staff_id LEFT JOIN admin a ON a.admin_id=b.booking_by
		WHERE ". $cond_q ."b.booking_status<>'Cancelled' ORDER BY b.id DESC";

		return $this->db->fetchAll($query);
	}
	
	public function cancel_booking($book_id) {
		if( $this->db->update('seat_bookings', array('booking_status' => 'Cancelled'), 'id='.$book_id) ) {
			$is_error = 0;
			echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.alert("Cancelled successfully.");';
            echo "</script></head><body></body></html>";
		} else {
			$err_msg .= "<span>Failed (database error)</span>";
		}
		
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
		echo 'window.parent.createResult("'.$err_msg.'",'.$is_error.');';
		echo "</script></head><body></body></html>";
		exit();
	}
	
	public function update_booking($booktime, $data_array) {
		$err_msg = '';
		
		$booking_start = strtotime($date_from);

		//if( !$staff_id ) $err_msg = 'Staff id could not found';
		//else
		if( empty($booktime['date_from']) ) { //|| !$date_to ) {
			$err_msg = '<span>Error:</span> Booking date is empty';
		}
		/*elseif( (int)$booktime['start_time']  >= (int)$booktime['finish_time'] ) {
			$err_msg = '<span>Error:</span> Invalid Booking Hour!';
		}*/
		else {
			
			$result_array = array();
			//$result_str = '';
			$nextday = 0;
			if( (int)$booktime['start_time']  >= (int)$booktime['finish_time'] )
				$nextday = 86400;
				
			//for( $i = 0; $i <= $day_num; $i++ ) {
				//$oneday = $i * 86400;
			$booking_start = strtotime($booktime['date_from'].' '.$booktime['start_time'].':00:00');
			$booking_finish = strtotime($booktime['date_from'].' '.$booktime['finish_time'].':00:00') + $nextday;
					
			$total_hrs = ($booking_finish - $booking_start) / 60 / 60;
					
				//$result_array[$booking_start] = array('finish' => $booking_finish);
			$result_str = " &#187; ". date("d M Y, ga", $booking_start) ." to " . date("ga", $booking_finish)." ($total_hrs) - ";
					
			// test if the booking time still available
			$query = "SELECT count(id) FROM seat_bookings WHERE seat_id=".$this->seat_id." AND booking_status<>'Cancelled'
			AND ( (booking_starttime<=$booking_start AND booking_endtime>$booking_start) OR
			(booking_starttime<$booking_finish AND booking_endtime>=$booking_finish) OR
			(booking_starttime>=$booking_start AND booking_endtime<=$booking_finish) ) AND id<>".$this->book_id;
			echo $query;
			
			$book_exists = $this->db->fetchOne($query);
	
			if( !$book_exists ) {
				$data_array['booking_starttime'] = $booking_start;
				$data_array['booking_endtime'] = $booking_finish;
				
				if( $this->db->update('seat_bookings', $data_array, 'id='.$this->book_id) ) {
					$is_error = 0;
					echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
					echo 'window.parent.alert("Updated successfully.");';
					echo "</script></head><body></body></html>";
				}
				else $err_msg .= "<span>Failed (database error)</span>";
			} else {
				$err_msg .= "<span>Error:</span> time already taken";
			}
		}

		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
		echo 'window.parent.createResult("'.$err_msg.'",'.$is_error.');';
		echo "</script></head><body></body></html>";
		exit();
	}
	
	public function booking_reports($where, $args = array()) {//$seat_id = NULL, $date = NULL, $date2 = NULL) {
		$pages = new Paginator();		
		
        $pages->mid_range = 7;
        $pages->items_per_page = 50;
		
		$where_clause = 'b.leads_id is not NULL';

		//$query = "select count(*) total_count FROM leads l LEFT JOIN seat_bookings b ON l.id=b.leads_id WHERE b.leads_id is not NULL";

		//if( $booking_status && $booking_status != 'All' ) $where = "booking_status='$booking_status'";
		
		$where_array = array();
		
		//if( $where ) array_push($where_array, $where);
		$time_start = 0;
		$ctr = 0;
		//$cancelled_param = FALSE;
		//print_r($args);
		foreach($args as $k => $v) {
			//echo '<br/>'.$k .'=>'. $v;
			
			//if($k == 'b.booking_status' && $v == 'Cancelled') $cancelled_param = TRUE;
			if( $k == 'date' && $v ) {
				$time_start = strtotime($v);
				array_push($where_array, "b.booking_starttime>=$time_start");
				$ctr = count($where_array);
			}
			elseif( $k == 'date2' && $time_start ) {
				if( $v > 0 ) $time_end = strtotime($v) + 86400;
				else $time_end = strtotime('+1 day', $time_start);

				$where_array[$ctr - 1] .= " AND b.booking_endtime<=$time_end";
				
			} else {
				if($v && $k != 'filter' && !in_array($k, $where_array)) array_push($where_array, "$k='$v'");
			}
		}
		//print_r($where_array);
		/*if( !empty($args['seat_id']) ) array_push($where_array, 'b.seat_id='.$args['seat_id']);
		if( !empty($args['date']) ) {
			$time_start = strtotime($args['date']);
			if( !empty($args['date2']) && $args['date2'] > 0) $time_end = strtotime($args['date2']) + 86400;
			else $time_end = strtotime('+1 day', $time_start);

			array_push($where_array, "b.booking_starttime>=$time_start AND b.booking_endtime<=$time_end");
		}
		if( !empty($args['timezone']) ) array_push($where_array, "b.timezone='".$args['timezone']."'");
		
		if( !empty($args['leads_id']) ) array_push($where_array, "l.id=".$args['leads_id']);*/
		
		if( count($where_array) > 0 ) $where_clause .=  ' AND ' . implode(' AND ', $where_array);
		
		/*if( !in_array("b.booking_status='Cancelled'", $where_array) &&
		   !in_array("booking_status='Cancelled'", $where_array) &&
		   isset($args['filter']) && $args['filter'] != 'status') $where_clause .= " AND booking_status!='Cancelled'";
		*/
		if( isset($args['filter']) && $args['filter'] == 'date' ) $where_clause .= " AND booking_status!='Cancelled'";
		//if( empty($args['filter']) || $args['filter'] != 'status' ) $where_clause .= " AND booking_status!='Cancelled'";
		
		$pages->items_total = $this->get_total_bookings($where_clause); //$this->db->fetchOne($query);
		//echo $where_clause;
		$pages->paginate();
		
		$bstart_qstr = $this->format_date('b.booking_starttime', '%l%p');
		$bfinish_qstr = $this->format_date('b.booking_endtime', '%l%p');
		
		$query = "SELECT l.id, l.fname cfname, l.lname clname, p.fname, p.lname, b.seat_id, b.staff_id,
			b.booking_status, date_format(from_unixtime(b.booking_starttime), '%m/%d/%Y') book_date,
			((b.booking_endtime-b.booking_starttime)div 60 div 60) hrs, $bstart_qstr book_start, $bfinish_qstr book_end,
			if(b.booking_payment='TBP', 'To Be Paid', b.booking_payment) booking_payment,
			if(b.booking_status='Pending','#f8cbcb', if(b.booking_status='Confirmed','#CCFF99', '#e9edf4') ) bgcolor
			FROM leads l LEFT JOIN seat_bookings b ON l.id=b.leads_id
			LEFT JOIN personal p ON p.userid=b.staff_id
			WHERE $where_clause";
			/*AND b.id = (SELECT MAX(sub.id) FROM seat_bookings sub
			WHERE sub.booking_status=b.booking_status  AND sub.leads_id=b.leads_id)";*/
			
		
		
		
		/*if( $seat_id !== NULL && $seat_id ) $query .= " AND b.seat_id=$seat_id";
		if( $date !== NULL && $date ) {
			$time_start = strtotime($date);
			$time_end = strtotime('+1 day', $time_start);
			$query .= " AND b.booking_starttime>=$time_start AND b.booking_endtime<=$time_end";
		}*/
		
		
		$query .= " ORDER BY l.fname, l.lname ASC, b.booking_starttime DESC ".$pages->limit;
		$booking_info = $this->db->fetchAll($query);
		//print_r(array('booking_info' => $booking_info, 'pages' => $pages));
		return array('booking_info' => $booking_info, 'pages' => $pages);
	}
	
	public function get_total_bookings($where = NULL) {
		$query = "select count(*) total_count FROM seat_bookings b
		LEFT JOIN leads l ON l.id=b.leads_id WHERE b.leads_id is not NULL";
		
		if( $where ) $query .= " AND $where";

		return $this->db->fetchOne($query);
	}
	
	public function get_unpaid($leads_id, $type = '', $schedule = '') {
		
		// setup date field format query string
		$bdate1_qstr = $this->format_date('min(b.booking_starttime)', '%b %d, %Y');
		$bdate2_qstr = $this->format_date('max(b.booking_endtime)', '%b %d, %Y');
		$bstart_qstr = $this->format_date('b.booking_starttime', '%l %p');
		$bfinish_qstr = $this->format_date('b.booking_endtime', '%l %p');
		
		$query = "SELECT b.id, l.id leads_id, p.userid, l.fname cfname, l.lname clname,	p.fname, p.lname,
		$bdate1_qstr book_date1, $bdate2_qstr book_date2,$bstart_qstr book_start,$bfinish_qstr book_end,
		sum( ((b.booking_endtime-b.booking_starttime)div 60 div 60) ) hrs,	b.booking_type, count(b.id) cnt,
		b.booking_schedule FROM seat_bookings b LEFT JOIN leads l ON l.id=b.leads_id
		LEFT JOIN personal p ON p.userid=b.staff_id
		WHERE leads_id=$leads_id AND booking_payment='TBP' AND booking_status!='Cancelled' ";
		
		if( $type ) $query .= "AND booking_type='$type' ";
		if( $schedule ) $query .= "AND booking_schedule='$schedule' ";
		
		$query .= "GROUP by b.booking_updated ORDER BY b.id DESC, b.booking_updated";

		return $this->db->fetchAll($query);
	}
	
	public function booking_payment_count($month = NULL, $tz = 'AU', $payment = 'Paid') {
		$bdate_qstr = $this->format_date('b.booking_starttime', '%M');

		$query = "SELECT sum(if(cnt.hrs>0, cnt.hrs, 0)) total_hrs
			FROM( select sum( ((booking_endtime-booking_starttime)div 60 div 60) ) hrs 
				FROM seat_bookings b WHERE booking_payment='$payment' AND booking_status!='Cancelled' AND
			$bdate_qstr = '$month' AND timezone='$tz') cnt";
		
		return $this->db->fetchOne($query);
		
	}
	
	public function get_average_monthly($month = NULL, $tz = 'AU', $format = '%M') {
		$bdate_qstr = $this->format_date('booking_starttime', $format);

		
		$query = "SELECT sum(if(cnt.hrs>0, cnt.hrs, 0)) total_hrs
			FROM( select sum( ((booking_endtime-booking_starttime)div 60 div 60) ) hrs
			FROM seat_bookings WHERE booking_status!='Cancelled' AND
			$bdate_qstr = '$month' AND timezone='$tz' ) cnt";
			
		return $this->db->fetchOne($query);
		
	}
	
	public function format_date($fieldname = 'booking_starttime', $format = '%Y-%m-%d') {
		$offset = $this->get_tzOffset();
		return "date_format(date_add(from_unixtime($fieldname), interval $offset HOUR), '$format')";
	}
	
	private function get_tzOffset($tz = '+08:00') {
		$currdate = strtotime( date("Y-m-d H:i:s") );
		if( isset($_SESSION['timezone']) ) $tz = $_SESSION['timezone'];
		// SET TIMEZONE AND HOURS OFFSET
		$this->db->query("SET time_zone = '{$tz}'");
		$newdate = strtotime( $this->db->fetchOne("SELECT NOW()") );
		$tzOffset = ($newdate - $currdate) / 3600;
		return $tzOffset;
	}
	
	/*public function get_tzOffset($tz = '+08:00') {
		$currdate = strtotime( date("Y-m-d H:i:s") );
		//if( isset($_SESSION['timezone']) ) $tz = $_SESSION['timezone'];
		$db_date = strtotime( $this->db->fetchOne("SELECT NOW()") );
		
		// SET TIMEZONE AND HOURS OFFSET
		$this->db->query("SET time_zone = '$tz'");
		$newdate = strtotime( $this->db->fetchOne("SELECT NOW()") );
		
		$tzOffset = ($newdate - $db_date) / 3600;
		return $tzOffset;
	}*/
	
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
	
	public function check_admin_session() {
		$admin = array('admin_id'=>33, 'admin_fname'=>'Remote', 'admin_lname'=>'Testing');
		
		if( $_SESSION['admin_id'] ) {
			//$admin_id = $_SESSION['admin_id'];
			$sql = $this->db->select()->from('admin', array('admin_id', 'admin_fname', 'admin_lname'))
			->where('admin_id = ?' ,$_SESSION['admin_id']);
			$admin = $this->db->fetchRow($sql);
		} else {
			//header("location:/portal/");
			//exit();
		}
		return $admin;
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