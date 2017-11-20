<?php
$site = $_SERVER['HTTP_HOST'];
if($site== "www.remotestaff.co.uk" or $site== "remotestaff.co.uk"){
	putenv("TZ=Europe/London");
	$country = "United Kingdom";
}else if($site== "www.remotestaff.biz" or $site== "remotestaff.biz"){
	putenv("TZ=America/New_York");
	$country = "United States";
}else{
	putenv("TZ=Australia/Sydney");
	$country = "Australia";
}	
?>
