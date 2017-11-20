<?php
//start: search asl interview
function search_items($db,$status,$p,$maxp,$max) 
{
	$set = ($p-1)*$maxp ;
	
	$from = "FROM personal";
	$order_by = "ORDER BY mass_emailing_date_executed DESC LIMIT $set, $maxp";	
	$fields = "
	fname,
	lname,
	mass_emailing_status,
	email,
	mass_emailing_date_executed
	";
	$where = "WHERE mass_emailing_status='".$status."'";

	$result =  mysql_query($query);
	if(!isset($max))
	{
		$m =  mysql_query("SELECT userid $from $where");
		$max = mysql_num_rows($m);
	}
	
	$x = 0 ;	
	$q = "SELECT $fields $from $where $order_by";
	$result = $db->fetchAll($q);
	foreach($result as $result)
	{
		$temp[$x]['max'] = $max;
		$temp[$x]['fname'] = $result['fname'];
		$temp[$x]['lname'] = $result['lname'];
		$temp[$x]['email'] = $result['email'];
		$temp[$x]['mass_emailing_status'] = $result['mass_emailing_status'];
		$temp[$x]['mass_emailing_date_executed'] = $result['mass_emailing_date_executed'];
		$x++ ;		
	} 
	return $temp ;
}
//ended: search asl interview


//start: asl interview pages
function search_items_linkpage($status,$p,$size,$d) 
{
	if($status == "WAITING") { $javascript_function = "search_waiting_items"; } else { $javascript_function = "search_sent_items"; }
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="javascript: '.$javascript_function.'(\'status='.$status.'&max='.$max.'&p='.($p-1).'\'); "><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="javascript: '.$javascript_function.'(\'status='.$status.'&max='.$max.'&p='.($p + 1).'\'); "><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ended: asl interview pages
?>