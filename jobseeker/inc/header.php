<?php 
$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_GET['jr_cat_id'] ), 2, 17 );
?>
<div id="header">
	<div id="headerleft"><img src="http://remotestaff.com.ph/images/remote-staff-logo.jpg" width="700px" height="89px"/></div>

	<div id="headerright">
		<?php include 'home_pages_link.php';?>
		<a href="http://remotestaff.com.ph/contactus.php"><img src="http://remotestaff.com.ph/images/icon-contact3.png" border="0" /></a><br />
		Phone: +632 846 4249<br>
        For Instant Interview Call Us Now:<br>+63947-995-9825<br />
        Text us at : +63947-768-1675<br />
        <a href="http://remotestaff.com.ph/webchat.php?hash=<?php echo $hash_code; ?>" target="_blank">Click Here to Live Chat Now</a>
	</div>

</div>
<br clear="all" />