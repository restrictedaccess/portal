<?php

	/* $ seat_client_manage.php 2012-02-20 mike $ */

	$page = "seat_client_manage";
	include "seat_header.php";
	
	//if(isset($_POST['sortorder'])) { $sortorder = $_POST['sortorder']; } elseif(isset($_GET['sortorder'])) { $sortorder = $_GET['sortorder']; } else { $sortorder = ""; }
	//if(isset($_POST['orderby'])) { $orderby = $_POST['orderby']; } elseif(isset($_GET['orderby'])) { $orderby = $_GET['orderby']; } else { $orderby = ""; }
	
	$task = getVar('task');
	$seat_id = getVar('seat_id');
	$staff_id = getVar('client_id');
	
	$book_id = getVar('book_id');
	
	$booking_info = array();
	$is_error = 1;
	$err_msg = '';
	$one_seat = 0;
	$admin_id = $admin['admin_id'];
	
	$timeNum = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);
	
	if( $task == 'client_booking' ) {
		$client_id = getVar('client_id');
		
		$bdate_qstr = $seat_obj->format_date('b.booking_starttime', '%b %d');
		$bdymd_qstr = $seat_obj->format_date('b.booking_starttime');
		
		$bstart_qstr = $seat_obj->format_date('b.booking_starttime', '%l %p');
		$bfinish_qstr = $seat_obj->format_date('b.booking_endtime', '%l %p');
		
		$bstarthr_qstr = $seat_obj->format_date('b.booking_starttime', '%k');
		$bfinishhr_qstr = $seat_obj->format_date('b.booking_endtime', '%k');
		$bmade_qstr = $seat_obj->format_date('b.booking_created', '%m/%d/%Y');
		
		$query = "SELECT b.id, b.seat_id, p.userid, p.fname, p.lname,
		l.fname cfname, l.lname clname, a.admin_fname, a.admin_lname,
		$bdate_qstr book_date, $bdymd_qstr date_ymd, $bstart_qstr book_start, $bfinish_qstr book_end,
		$bstarthr_qstr start_hr, $bfinishhr_qstr end_hr, $bmade_qstr book_made,
		((b.booking_endtime-b.booking_starttime)div 60 div 60) hrs,
		b.booking_type, b.booking_by, b.booking_status, b.booking_payment
		FROM seat_bookings b LEFT JOIN leads l ON l.id=b.leads_id
		LEFT JOIN personal p ON p.userid=b.staff_id LEFT JOIN admin a ON a.admin_id=b.booking_by
		WHERE leads_id=$client_id AND b.booking_status<>'Cancelled' ORDER BY b.id DESC";
		
		$booking_info = $db->fetchAll($query);
	
	
	} elseif( $task == 'cancel_book' ) {
	
		if( $db->update('seat_bookings',  array('booking_status' => 'Cancelled'), 'id='.$book_id) ) $is_error = 0;
		else $err_msg .= "<span>Failed (database error)</span>";
		
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
		echo 'window.parent.createResult("'.$err_msg.'",'.$is_error.');';
		echo "</script></head><body></body></html>";
		exit();
		
	} elseif( $task == 'update' ) {
		$client_id = $_POST['client'];
		$date_from = $_POST['date_from'];
		//$date_to = $_POST['date_to'];
			
		$start_time = $_POST['start_time'];
		$finish_time = $_POST['finish_time'];
			
		$type = $_POST['type'];
		$payment = $_POST['payment'];
		$booking_status = $_POST['status'];
			
		//$booking_created = time();
		$booking_updated = time();; //$booking_created;
			
		$booking_start = strtotime($date_from); //.' '.$start_time.':00:00') + $oneday;
		//$booking_finish = strtotime($date_to); //.' '.$finish_time.':00:00') + $oneday;
			
		//$book_status = ($payment == 'Free') ? 'Confirmed' : 'Pending';
		
		
			
		if( !$client_id ) $err_msg = 'Client id could not found';
		elseif( !$date_from ) { //|| !$date_to ) {
			$err_msg = '<span>Error:</span> Booking date is empty';
		}
		/*elseif( $booking_start > $booking_finish ) {
			$result_str = 'Invalid Booking Date!';
		}*/
		elseif( (int)$start_time  >= (int)$finish_time ) {
			$err_msg = '<span>Error:</span> Invalid Booking Hour!';
		}
			
		else {
			// setup values for update query
			$data_array = array('booking_type' => $type, 'booking_payment' => $payment, 'booking_by' => $admin_id,
			'booking_updated' => $booking_updated, 'booking_status' => $booking_status);
			
			/*$time_interval = $booking_finish - $booking_start;
			if( $time_interval > 0 ) {
				$day_num = $time_interval / 60 / 60 / 24;
			} else $day_num = 0;
			*/	
			$result_array = array();
			//$result_str = '';
				
			//for( $i = 0; $i <= $day_num; $i++ ) {
				//$oneday = $i * 86400;
			$booking_start = strtotime($date_from.' '.$start_time.':00:00');// + $oneday;
			$booking_finish = strtotime($date_from.' '.$finish_time.':00:00');// + $oneday;
					
			$total_hrs = ($booking_finish - $booking_start) / 60 / 60;
					
				//$result_array[$booking_start] = array('finish' => $booking_finish);
			$result_str = " &#187; ". date("d M Y, ga", $booking_start) ." to " . date("ga", $booking_finish)." ($total_hrs) - ";
					
			// test if the booking time still available
			$query = "SELECT count(id) FROM seat_bookings WHERE seat_id=$seat_id AND booking_status<>'Cancelled'
			AND ( (booking_starttime<=$booking_start AND booking_endtime>=$booking_start) OR
			(booking_starttime<=$booking_finish AND booking_endtime>=$booking_finish) ) AND id<>$book_id";
			$book_exists = $db->fetchOne($query);
	
			if( !$book_exists ) {
				$data_array['booking_starttime'] = $booking_start;
				$data_array['booking_endtime'] = $booking_finish;
						
				if( $db->update('seat_bookings', $data_array, 'id='.$book_id) )					
					//$result_str .= "<span style='color:#696;font-weight:bold;'>Success</span>";
					$is_error = 0;
				else $err_msg .= "<span>Failed (database error)</span>";
			} else {
				$err_msg .= "<span>Error:</span> time already taken";
			}
					
				//array_push($result_array, $result_str);
			//}
				//$result_msg = 'Booking Result!';
		}
	
			
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
		//if( $err_msg ) {
			// RUN JAVASCRIPT TO ALERT ERROR
		echo 'window.parent.createResult("'.$err_msg.'",'.$is_error.');';
		echo "</script></head><body></body></html>";
		exit();
	}
	
	
	//print_r($booking_info);
	//print_r(array_values($booking_list));
	//Get the no.of staff working today
	$smarty->assign('booking_info', $booking_info);
	
	$smarty->assign('time_sel_value', $timeNum);
	$smarty->assign('seat_id', $seat_id);
	$smarty->assign('client_id', $client_id);
	$smarty->assign('task', $task);
	
	/*$smarty->assign('time_sel_value', $timeNum);
	$smarty->assign('filter_date' , $booking_date);
	$smarty->assign('filter_start' , $starttime);
	$smarty->assign('filter_end' , $endtime);*/
	
	include "seat_footer.php";

?>
