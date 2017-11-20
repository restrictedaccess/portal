<?php

/* $ seat_booking_status.php 2012-02-20 mike $ */

$page = "seat_booking_status";
include "seat_header.php";


$task = getVar('task');

$sortorder = getVar('sortorder');
$orderby = getVar('orderby');


$timeNum = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);

$booking_status = getVar('booking_status', 'All');

$booking_info = array();

$ipp = getVar("ipp", 0);

$pages = new Paginator();
	
$pages->mid_range = 7;
$pages->items_per_page = 50;


$query = "select count(*) total_count FROM leads l LEFT JOIN seat_bookings b ON l.id=b.leads_id WHERE b.leads_id is not NULL"; 

if( $booking_status && $booking_status != 'All' ) $query .= " AND b.booking_status='$booking_status'";

$pages->items_total = $db->fetchOne($query);

$pages->paginate();

$query = "SELECT l.id, l.fname cfname, l.lname clname, b.booking_status,
    date_format(from_unixtime(b.booking_starttime), '%m/%d/%Y') book_date
    FROM leads l LEFT JOIN seat_bookings b ON l.id=b.leads_id
    WHERE b.leads_id is not NULL";
    /*AND b.id = (SELECT MAX(sub.id) FROM seat_bookings sub
    WHERE sub.booking_status=b.booking_status  AND sub.leads_id=b.leads_id)";*/
    
if( $booking_status && $booking_status != 'All' ) $query .= " AND b.booking_status='$booking_status'";

$query .= " ORDER BY l.fname, l.lname ASC, b.booking_starttime DESC ".$pages->limit;

$booking_info = $db->fetchAll($query);

$smarty->assign('booking_info', $booking_info);

$smarty->assign('status', $booking_status);
$smarty->assign('filter_date' , $booking_date);

$smarty->assign('ipp', $pages->low);
$smarty->assign('items_total', $pages->items_total);
$smarty->assign('pages', $pages->display_pages());
$smarty->assign('jump_menu', $pages->display_jump_menu());
$smarty->assign('items_pp', $pages->display_items_per_page());

include "seat_footer.php";

?>
