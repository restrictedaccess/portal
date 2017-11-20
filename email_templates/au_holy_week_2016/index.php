<?php
include ('../../conf/zend_smarty_conf.php');
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_holy_week_2016/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_holy_week_2016/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_holy_week_2016/";
}
?>
<div style="text-align: center;">
<div style="margin:auto;text-align:left;width:800px;overflow: hidden;background-color:#f2f2f2;">
<div style="background-color:#FFFFFF;margin:auto;text-align:left;color:#000000;padding: 40px 0px 0px 20px;">
	<table border="0" style="width:800px">
		<img src="<?php echo $base; ?>images/rs-logo-email.png" height="65" width="250" style="margin:auto;text-align:left;color:#FFFFFF;">
		<div style="margin:25px 0px 0px 50px;">
			<table border="0">
				<tr>
					<td>
						<div>
							<p style="margin-top:0;margin-bottom:18px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#000000;text-align:left;">Dear <?php echo $lead["fname"]?>,
							<p style="margin-top:0;margin-bottom:18px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#000000;text-align:left;">Holy Week and Easter Holidays one of the holidays to look forward this 2016.</p>
							<p style="margin-top:0;margin-bottom:3px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#000000;text-align:left;">Please be informed that Remote Staff will be closed on Good Friday and Easter Monday. Although</p>
							<p style="margin-top:0;margin-bottom:3px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#000000;text-align:left;">Holy Thursday is a holiday here in the Philippines your staff/s are still required to work just expect</p>
							<p style="margin-top:0;margin-bottom:3px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#000000;text-align:left;">some will be requesting for leave approvals. Same applies with Easter Monday, staffs can still be </p>
							<p style="margin-top:0;margin-bottom:18px;font-family:Arial,Helvetica,sans-serif;font-size:13pt;letter-spacing:0;color:#000000;text-align:left;">required to work since it is a regular work day here in the Philippines.</p>
						</div>
					</td>
				</tr>
				</table>
				
				<table border="1" style="text-align:left;font-weight:bold;">
					<tr>
						<td style="background-color:#FFFF00;padding:5px 0px 5px 5px;">DATES/DAYS</td>
						<td style="background-color:#FFFF00;padding:5px 10px 5px 5px;">AUSTRALIAN HOLIDAYS</td>
						<td style="background-color:#FFFF00;padding:5px 10px 5px 5px;">PHILIPPINE HOLIDAYS</td>
					</tr>
					<tr>
						<td style="padding:5px 0px 5px 5px;">March 24 - Thursday</td>
						<td style="color:#0000FF;padding:5px 0px 5px 5px;">Regular Work Day</td>
						<td style="padding:5px 0px 5px 5px;">Holy Thursday</td>
					</tr>
					<tr>
						<td style="padding:5px 0px 5px 5px;">March 25 - Friday</td>
						<td style="padding:5px 0px 5px 5px;">Good Friday</td>
						<td style="padding:5px 0px 5px 5px;">Good Friday</td>
					</tr>
					<tr>
						<td style="padding:5px 10px 5px 5px;">March 28 - Easter Sunday</td>
						<td style="padding:5px 0px 5px 5px;">Easter Monday</td>
						<td style="color:#0000FF;padding:5px 0px 5px 5px;">Regular Work Day</td>
					</tr>
				</table>
		
				<table border="0">
					<tr>
						<td>
							<div>
							<p style="text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13pt;margin:25px 0px 3px 0px;">
								<b>Please note that ALL leave requests are subject to your approval.</b> However, should you require
							</p>
							<p style="text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13pt;margin:0px 0px 3px 0px;">
								your staff member to work on the said dates, you will not be charged extra fees. The rate for this
							</p>
							<p style="text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13pt;margin:0px 0px 3px 0px;">
								day is equal to the regular day rate. Please get back to me of when you want your staff to take
							</p>
							<p style="text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13pt;margin:0px 0px 3px 0px;">
								day(s) off and when you need them working.
							</p>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<div>
							<p style="color:#818181;text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13pt;margin:20px 0px 0px 0px;">
								*If we don't receive any feedback from you on or before Monday, March 21, we will assume that
							</p>
							<p style="color:#818181;text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13pt;margin:3px 0px 0px 0px;">
								 you require your staff to work on the days mentioned above.
							</p>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
						</td>
					</tr>
			</table>
		<img src="<?php echo $base; ?>images/holy-week-bg.png" width="1000" height="250">
</div>
</table>
</div>
</div>
</div>

<div style="padding-left:80px;padding-top:30px;">
	<?php if ($hc){ ?>
		<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:11pt;line-height:90%;text-align:left">Kind Regards,<br/><br/>
		<?php echo $hc["admin_fname"]." ".$hc["admin_lname"]?></strong><br/>
		<?php echo $hc["signature_company"]?><br/>
		<?php echo $hc["signature_contact_nos"]?></p>
	<?php } ?>	
</div>