<?php
if($_SERVER['HTTP_HOST']== "www.remotestaff.co.uk" or $_SERVER['HTTP_HOST']== "remotestaff.co.uk"){
	putenv("TZ=Europe/London");
}else if($_SERVER['HTTP_HOST']== "www.remotestaff.biz" or $_SERVER['HTTP_HOST']== "remotestaff.biz"){
	putenv("TZ=America/New_York");
}else{
	putenv("TZ=Australia/Sydney");
}	
?>
