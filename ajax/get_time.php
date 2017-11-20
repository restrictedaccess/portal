<?php
	putenv("TZ=Australia/Sydney");
	$time_offset ="0";
	$time_a = ($time_offset * 120);
	$time = date("h:i:s",time() + $time_a);
	echo '<font color="#ffffff" size="1">Current date/time: '.date("l, F d, Y" ,time()).' / '.$time.'</font>';		
	//echo $time." ".$_GET["c"];		
?>