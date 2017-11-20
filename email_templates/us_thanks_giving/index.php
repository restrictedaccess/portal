<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/us_thanks_giving/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/us_thanks_giving/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/us_thanks_giving/";
}
?>

<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/thanks_giving_day.png" height="818" width="800" style="margin:auto;text-align:left;color:#FFFFFF">
		<tr>
			<td valign="top">
				<div style="padding-left:163px;padding-top:264px;padding-right:257px">
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">Thanksgiving Day in the United States is a holiday on the fourth Thursday of November.</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#faf257;text-align:left"><strong>This year it falls on November 26th.</strong></p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">We would like to know and check if it's going to be a work day for your remote staff or team.</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">Should you wish your staff NOT to work on that day, please respond to this email telling us so.</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">If we don't receive any notice or reply from you until November 25th, we will assume that your staff will be working as usual.</p>
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