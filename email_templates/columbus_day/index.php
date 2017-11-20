<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/columbus_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/columbus_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/columbus_day/";
}
?>
<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/columbus_day_bg.jpg" height="776" width="800" style="margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
		<td valign="top">
			<div style="padding-left:57px;padding-top:86px;padding-right:69px;">
				<p style="font-family:'Helvetica Neue',Arial,Helvetica,sans-serif;font-size:64px;font-weight:900;letter-spacing:-1pt;line-height:120%;color:#2B3545;text-align:left;margin-top:0;margin-bottom:8px">Columbus Day</p>
				<p style="margin-top:0;margin-bottom:19px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#002157;text-align:left;">Columbus Day, which is annually on the second Monday of October, remembers <br/>Christopher Columbus' arrival to the Americas on October 12, 1492.</p>
				<p style="margin-top:0;margin-bottom:19px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#002157;text-align:left;"><strong>This year it falls on October 14th.</strong></p>
				<p style="margin-top:0;margin-bottom:19px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#002157;text-align:left;">We would like to know and check if it's going to be a work day for your remote staff or team. Should you wish your staff NOT to work on that day, please respond to this email telling us<br/> so. If we don't receive any notice or reply from you by Wednesday, October 9th, we will<br/> assume that yourstaff will be working as usual.</p>					
			</div>
									
		</td>
	</tr>
</table>
<div style="background-color:#B2D233;width:800px;height:7px;margin:auto"></div>
<div style="background-color:#00B1DA;width:800px;height:35px;margin:auto"></div>
</div>
<div style="padding-left:80px;padding-top:30px;">
	<?php if ($hc){ ?>
		<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:11pt;line-height:90%;text-align:left">Kind Regards,<br/><br/>
		<?php echo $hc["admin_fname"]." ".$hc["admin_lname"]?></strong><br/>
		<?php echo $hc["signature_company"]?><br/>
		<?php echo $hc["signature_contact_nos"]?></p>
	<?php } ?>	
</div>