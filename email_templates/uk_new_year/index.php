<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/uk_new_year/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/uk_new_year/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/uk_new_year/";
}
?>


<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/new_year_uk_background.jpg" height="818" width="800" style="margin:auto;text-align:left;color:#FFFFFF">
		<tr>
			<td valign="top">
				<div style="padding-left:93px;padding-top:41px;padding-right:68px">
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">New Year's Eve, December 31st, is the last day of the year in the United Kingdom. It is a major social observance and many parties are held, particularly in the evening.</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">We would like to know and check if it's going to be a work day for your remote staff or team. Should you wish your staff NOT to work on that day, please respond to this email telling us so.</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">If we don't receive any notice or reply from you by Thursday, December 26th, we will assume that your staff will be working as usual.</p>
				</div>
			</td>
		</tr>
	</table>
</div>

<div style="padding-left:80px;padding-top:30px;">
	<?php if ($hc){ ?>
		<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:11pt;line-height:90%;text-align:left">Kind Regards,<br/><br/>
		<?php echo $hc["admin_fname"]." ".$hc["admin_lname"]?></strong><br/>
		<?php echo $hc["signature_company"]?><br/>
		<?php echo $hc["signature_contact_nos"]?></p>
	<?php } ?>	
</div>