<?php
	
	$page = 'seat_booking';
	
	if(isset($_POST['task'])) $task = $_POST['task']; elseif(isset($_GET['task'])) $task = $_GET['task']; else $task = '';
	if(isset($_POST['$service_type'])) $service_type = $_POST['$service_type'];
	elseif(isset($_GET['$service_type'])) $service_type = $_GET['$service_type']; else $service_type = 'trial_based';
	
	include "seat_header.php";
	
	$seat = getVar('seat_id');

	//if( !isset($_SESSION['servicetype']) ) $_SESSION['servicetype'] = $service_type;
	//if ($task == 'logout' ) {
	//	$client->logout();
	$timeNum = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);
	
	$admin_id = $admin['admin_id'];
	
	/*$date_from = '2012-02-20';
	$date_to = '2012-02-20';
	$start_time = 7;
	$finish_time = 16;
	$booking_start = strtotime($date_from);//.' '.$start_time.':00:00');
	$booking_finish = strtotime($date_to);//.' '.$finish_time.':00:00');*/
	//echo ($booking_finish-$booking_start);
	//}
	
	
	//$tzOffset = $seat_obj->get_tzOffset();

	
	if( $task == "get_client") {
		$userid = getVar('userid', 0);
		$query = "
		SELECT * FROM (
			SELECT l.fname, l.lname, l.id, s.userid, s.status FROM leads l
			LEFT JOIN  `subcontractors` s ON s.leads_id = l.id WHERE s.userid={$userid}	AND s.status =  'ACTIVE'
			UNION ALL 
			SELECT l.fname, l.lname, l.id, i.applicant_id userid, 'ACTIVE' FROM member m
			LEFT JOIN leads l ON m.leads_id = l.id
			LEFT JOIN tb_request_for_interview i ON i.leads_id = m.leads_id	WHERE i.applicant_id={$userid}) clients
			GROUP BY clients.id
			ORDER BY clients.fname, clients.lname ASC";
		$staff_info = $db->fetchAll($query);
		echo json_encode($staff_info);
		exit();
	} elseif( $task == 'check_time' ) {
		$seat_id = getVar('seat_id', 0);
		$seat_id = getVar('start');
		$seat_id = getVar('finish', 0);
		
		$booking_start = strtotime($date_from.' '.$start_time.':00:00');
		$booking_finish = strtotime($date_from.' '.$finish_time.':00:00');
		
		$query = "SELECT seat_id, id FROM seat_bookings WHERE seat_id=$seat AND
		booking_starttime>=$book_startdate AND booking_endtime<$book_enddate";
		$book_result = $db->fetchAll($query);
		
	} elseif( $task == 'create' ) {
		// GET POST VARIABLES
		$seat_id = $_POST['seat_id'];
		$staff_id = $_POST['staff_id'];
		$client_id = $_POST['client'];
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];
		
		$start_time = $_POST['start_time'];
		$finish_time = $_POST['finish_time'];
		
		$type = $_POST['type'];
		$payment = $_POST['payment'];
		
		$booking_created = time();
		$booking_updated = $booking_created;
		
		$err_msg = '';
		
		$booking_start = strtotime($date_from); //.' '.$start_time.':00:00') + $oneday;
		$booking_finish = strtotime($date_to); //.' '.$finish_time.':00:00') + $oneday;
		
		$book_status = ($payment == 'Free') ? 'Confirmed' : 'Pending';

		// setup values for insert query
		$data_array = array('staff_id' => $staff_id, 'leads_id' => $client_id, 'seat_id' => $seat_id, 'booking_type' => $type, 'booking_by' => $admin_id,
		'booking_payment' => $payment, 'booking_created' => $booking_created, 'booking_updated' => $booking_updated, 'booking_status' => $book_status);
		
		if( !$staff_id ) $err_msg = '<span>Error:</span> Staff id could not found!';
		elseif( !$date_from || !$date_to ) {
			$err_msg = '<span>Error:</span> Booking date is empty.';
		}elseif( $booking_start > $booking_finish ) {
			$err_msg = '<span>Error:</span> Invalid Booking Date!';
		}elseif( (int)$start_time  >= (int)$finish_time ) {
			$err_msg = '<span>Error:</span> Invalid Booking Hour!';
		}
		
		else {
			
			$time_interval = $booking_finish - $booking_start;
			if( $time_interval > 0 ) {
				$day_num = $time_interval / 60 / 60 / 24;
			} else $day_num = 0;
			
			$result_array = array();
			$result_str = '';
			
			for( $i = 0; $i <= $day_num; $i++ ) {
				$oneday = $i * 86400;
				$booking_start = strtotime($date_from.' '.$start_time.':00:00') + $oneday;
				$booking_finish = strtotime($date_from.' '.$finish_time.':00:00') + $oneday;
				
				$total_hrs = ($booking_finish - $booking_start) / 60 / 60;
				
				//$result_array[$booking_start] = array('finish' => $booking_finish);
				$result_str = " &#187; ". date("d M Y, ga", $booking_start) ." to " . date("ga", $booking_finish)." ($total_hrs) - ";
				
				// test if the booking time still available
				$query = "SELECT count(id) FROM seat_bookings WHERE seat_id=$seat_id AND booking_status<>'Cancelled'
				AND ( (booking_starttime<=$booking_start AND booking_endtime>=$booking_start) OR (booking_starttime<=$booking_finish
				AND booking_endtime>=$booking_finish) OR (booking_starttime>=$booking_start AND booking_endtime<=$booking_finish) )";
				$book_exists = $db->fetchOne($query);

				if( !$book_exists ) {
					$data_array['booking_starttime'] = $booking_start;
					$data_array['booking_endtime'] = $booking_finish;
					
					if( $db->insert('seat_bookings', $data_array) )					
						$result_str .= "<span style='color:#696;font-weight:bold;'>Success</span>";
					else $result_str .= "<span style='color:#ff0000;font-weight:bold;'>Failed (database error)</span>";
				} else {
					$result_str .= "<span style='color:#ff0000;font-weight:bold;'>Failed (time unavailable)</span>";
				}
				
				array_push($result_array, $result_str);
			}
			//$result_msg = 'Booking Result!';
		}
		//print_r($result_array);
	
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
	
	$myurl = $_SERVER['PHP_SELF'];
	//$myurl="\"javascript:void(0);\" onclick=\"get_timeblock(".$userid.",".$current_uid;
	//onclick="goto('{$homedir}/client/as_client_calendar.php');"

    //$userid = $_SESSION['userid'];
	
	$yearID = getVar('yearID', date('Y') );
	$monthID = getVar('monthID', date('n') );
	$dayID = getVar('dayID', date('d') );
	
	// get booking for this month
	$book_startdate = strtotime($yearID.'-'.$monthID.'-1');
	$book_enddate = strtotime('+1 month', $book_startdate);
	
	$bdate_qstr = $seat_obj->format_date();
	$bstart_qstr = $seat_obj->format_date('b.booking_starttime', '%l%p');
	$bfinish_qstr = $seat_obj->format_date('b.booking_endtime', '%l%p');
	
	$query = "SELECT $bdate_qstr book_date,	$bstart_qstr book_start, b.seat_id, $bfinish_qstr book_end,
	b.id, b.staff_id, p.fname, p.lname, l.fname cfname, l.lname clname, b.booking_status
	FROM seat_bookings b LEFT JOIN personal p ON p.userid=b.staff_id
    LEFT JOIN leads l ON l.id=b.leads_id WHERE b.seat_id=$seat AND b.booking_status<>'Cancelled'
	AND	b.booking_starttime>=$book_startdate AND b.booking_endtime<$book_enddate";

	$book_result = $db->fetchAll($query);

	//print_r($book_result);
	//echo "$yearID - $monthID - $dayID ". $booking_date;
	$array_data = array();
	
    
    foreach ($book_result as $entry) {
		$date = explode('-', $entry['book_date']);
		$entry['year'] = $date[0];
		$entry['month'] = $date[1];
		$entry['day'] = $date[2];
		
        $idx = $date[1].$date[2];
        $array_data[$idx][] = $entry;
        
       
        //$cal->setEventContent($entry['year'],$entry['month'],$entry['mday'],
         //                     $entry['hrs'].'hrs',"index.php");
    }
	//print_r($array_data);
	//exit;
	
	$cal = new activeCalendar($yearID,$monthID,$dayID);
	
	$cal->seat_id = $seat;
	//$cal->enableMonthNav($myurl); // this enables the month's navigation controls
    $cal->enableDatePicker(2010,$yearID,$myurl); // this enables the date picker controls
    //$cal->enableDayLinks($myurl); // this enables the day links
	
	//$cal->onclick = "goto('as_client_calendar.php?cid=".USERID."&date=";
	
	
	
	foreach ($array_data as $data) {
       //echo $data['book_start'].'-'.$data['book_end'].'<br>';
        $cal->setEventContent($data[0]['year'], $data[0]['month'],$data[0]['day'], $data,"#");
    }
	
	
	$smarty->assign('userid', $userid);
	
	$smarty->assign('seat', $seat);
	$smarty->assign('tz_default', $tz_default);

	$smarty->assign('calendar', $cal->showMonth());
	$smarty->assign('time_sel_value', $timeNum);
	//$smarty->assign('time_sel_desc', $timeArray);

	include 'seat_footer.php';
?>