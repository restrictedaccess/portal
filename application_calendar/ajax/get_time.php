<?php
	$time_offset ="0";
	$time_a = ($time_offset * 120);
	$t = date("h:i:s",time() + $time_a);

	//convert to manila time
    $phl_tz = new DateTimeZone('Asia/Manila');
    $date_time_asia_manila = new DateTime($t);
	$date_time_asia_manila->setTimezone($phl_tz);
    $send_time = $date_time_asia_manila->format('H:i:s');	
	
	echo '<font color="#ffffff" size="1">Current date/time: '.date("l, F d, Y" ,time()).' / '.$send_time.'</font>';
	echo "<br /><br /";
	echo $type = date("a",time() + $time_a);
?>