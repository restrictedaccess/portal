<?php

    /* $ seat_home.php 2012-02-08 mike $ */
    
    $page = "seat_home";
    include "seat_header.php";
    
    $task = getVar('task');
    
    $booking_date = getVar('date', date("Y-m-d"));
    $starttime = getVar('starttime', -1);
    $endtime = getVar('endtime', -1);
    
    $booking_tstamp = strtotime($booking_date);
    
    if( $booking_date == date("Y-m-d") ) $dow_str = 'Today';
    else $dow_str = date("l", $booking_tstamp);
    
    $home_date = date("m/d/Y", $booking_tstamp);
    
    $seat_booked = array();
    
    $num_of_seat = 77;
    
    $timeNum = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);
    
    if( $endtime > -1 && $starttime > -1) {        
        $booking_start = strtotime($booking_date.' '.$starttime.':00:00');
        $booking_finish = strtotime($booking_date.' '.$endtime.':00:00');
        
        // test if the booking time still available
        $query = "SELECT seat_id FROM seat_bookings WHERE (booking_starttime<=$booking_start AND 
        booking_endtime>=$booking_start) OR (booking_starttime<=$booking_finish AND booking_endtime>=$booking_finish)
        OR (booking_starttime>=$booking_start AND booking_endtime<=$booking_finish)";

        $booking_list = $db->fetchAll($query);
        
        foreach( $booking_list as $key => $val ) {
            array_push($seat_booked, $val['seat_id']);
        }
    }
    
    // GET BOOKINGS FOR EACH SEAT AND DATE INPUT
    //$book_startdate = strtotime($booking_date);
    $book_endtstamp = strtotime('+1 day', $booking_tstamp);
    
    //echo '-->'.$booking_tstamp.' '.$book_endtstamp;
        
    //$bdate_qstr = $seat_obj->format_date();
    $bstart_qstr = $seat_obj->format_date('b.booking_starttime', '%l%p');
    $bfinish_qstr = $seat_obj->format_date('b.booking_endtime', '%l%p');
        
    $query = "SELECT $bstart_qstr book_start, $bfinish_qstr book_end, seat_id,
    b.id, p.fname, p.lname, l.fname cfname, l.lname clname, b.booking_status
    FROM seat_bookings b LEFT JOIN personal p ON p.userid=b.staff_id
    LEFT JOIN leads l ON l.id=b.leads_id WHERE b.booking_status<>'Cancelled'
    AND b.booking_starttime>=$booking_tstamp AND b.booking_endtime<$book_endtstamp";

    $book_result = $db->fetchAll($query);
    
    $cnt = count($book_result);
    
    $seats_array = array();
    for( $i = 0; $i < $cnt; $i++ ) {
        $seats_array[ $book_result[$i]['seat_id'] ][] = $book_result[$i];
    }
        
    
    //print_r(array_values($booking_list));
    //Get the no.of staff working today
    $smarty->assign('seat_booked', $seat_booked);
    $smarty->assign('seat_schedule', $seats_array);
    
    $smarty->assign('home_date', $home_date);
    $smarty->assign('dow_str', $dow_str);
    
    $smarty->assign('time_sel_value', $timeNum);
    $smarty->assign('filter_date' , $booking_date);
    $smarty->assign('filter_start' , $starttime);
    $smarty->assign('filter_end' , $endtime);
    //include 'system_wide_reporting/StaffWorking.php';
    
    
    include "seat_footer.php";

?>
