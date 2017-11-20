<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_australia_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_australia_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_australia_day/";
}
?>
<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base?>images/australia_bg.jpg" height="680" width="800" style="margin:auto;text-align:left;color:#FFFFFF">
		<tr>
			<td valign="top">
				<div style="padding-left:57px;padding-top:171px;padding-right:80px">
					<p style="margin-top:0;margin-bottom:16px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#fff;text-align:left">Dear <?php echo $lead["fname"]?>,</p>
					<p style="margin-top:0;margin-bottom:16px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#fff;text-align:left">Australia Day will be celebrated on Thursday, January 26, 2017.</p>
					<p style="margin-top:0;margin-bottom:16px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#fff;text-align:left">We would like to know if your remote staff/team will be working on this day. Should you wish your staff/team <b>NOT</b> to work on this day, please let us know by replying to this e-mail or informing your Staffing Consultant.</p>
					<p style="margin-top:0;margin-bottom:16px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#fff;text-align:left">If we do not receive any notice from you by end of business day on Tuesday, January 24, 2017, we will assume that your staff/team will be working as usual.</p>
			
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