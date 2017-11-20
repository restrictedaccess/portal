<?
if (TEST == False) {
    $domain = 'http://www.remotestaff.com.ph';
}
else{
	$domain = 'http://test.remotestaff.com.ph';
}	
?>

<div id="nav" class="container">
<ul>
<li class="spacer">&nbsp;</li>
<li><a href="<?=$domain?>/index.php" id="homenav">Home</a></li>
<li><a href="<?=$domain?>/jobopenings.php" id="jobopennav">Job Openings</a></li>
<li><a href="registernow-step1-personal-details.php" id="registernownav">Register Now</a></li>
<li><a href="<?=$domain?>/howwework.php" id="hownav">How We Work</a></li>
<li><a href="<?=$domain?>/qanda-jobseeker.php" id="qnanav">Q &amp; A</a></li>
<li><a href="<?=$domain?>/qualities.php" id="qualitiesnav">Qualities Needed From You</a></li>
<li><a href="<?=$domain?>/showcasing-staff.php" id="showcasenav">Existing Staff</a></li>
<li><a href="<?=$domain?>/aboutus.php" id="aboutnav">About Us</a></li>
<li><a href="/portal/" id="loginnav">Login</a></li>
</ul>

</div>