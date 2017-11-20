<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_christmas_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_christmas_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_christmas_day/";
}
?>

<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/happy_holidays.png" height="1224" width="800" style="margin:auto;text-align:left;color:#FFFFFF">
		<tr>
			<td valign="top">
				<div style="padding-left:48px;padding-top:160px;padding-right:44px;width:700px">
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left"><strong>To Our Valued Clients,<br/>Good day!</strong></p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">Christmas season is fast approaching and we have a number of holidays to look forward to in the coming weeks. 93% of the total Philippine population are Christians so the Christmas season is widely celebrated and given importance in the country.</p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">In line with the upcoming holidays , we have listed Philippine and Australian holidays from December 24, 2012 to January 1, 2013. We have highlighted and italicized the dates when the Remote Staff office will be <strong>CLOSED</strong>.</p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">Please note that queries and concerns can be emailed to <a href="mailto:clientsupport@remotestaff.com.au">clientsupport@remotestaff.com.au</a> and will be addressed on the NEXT WORKING DAY.</p>
					<table border="0" style="width:100%;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;margin-bottom:80px">
						<tr style="font-weight:bold">
							<td width="25%" align="left">DATES / DAYS</td>
							<td width="25%" align="left">PHILIPPINE <br/>HOLIDAYS</td>
							<td width="25%" align="left">AUSTRALIAN <br/>HOLIDAYS</td>
							<td width="25%" align="center">OFFICE HOURS</td>
						</tr>
						<tr>
							<td colspan="4" align="center">
							<img src="<?php echo $base; ?>images/divider.png"/>
							</td>
						</tr>
						<tr valign="top">
							<td width="25%" align="left">December 24, 2013<br/>- Tuesday<br/><br/></td>
							<td width="25%" align="left">Special non-working<br/>holiday </td>
							<td width="25%" align="left">N/A</td>
							<td width="25%" align="center" style="font-weight:bold">OFFICE CLOSED</td>
						</tr>
						<tr>
							<td width="25%" align="left">December 25, 2013<br/>- Wednesday<br/><br/></td>
							<td width="25%" align="left">Christmas Day </td>
							<td width="25%" align="left">Christmas Day</td>
							<td width="25%" align="center" style="font-weight:bold">OFFICE CLOSED</td>
						</tr>
						<tr>
							<td width="25%" align="left">December 26, 2013<br/>- Thursday<br/><br/></td>
							<td width="25%" align="left">Regular non-working<br/>holiday </td>
							<td width="25%" align="left">Boxing Day/<br/>Proclamation Day</td>
							<td width="25%" align="center" style="font-weight:bold">OFFICE CLOSED</td>
						</tr>
						<tr>
							<td width="25%" align="left">December 31, 2013<br/>- Tuesday<br/><br/></td>
							<td width="25%" align="left">Last Day of the Year</td>
							<td width="25%" align="left">New Year's Eve</td>
							<td width="25%" align="center" style="font-weight:bold">OFFICE CLOSED</td>
						</tr>
						<tr>
							<td width="25%" align="left">January 1, 2014<br/>- Wednesday</td>
							<td width="25%" align="left">New Year's day</td>
							<td width="25%" align="left">New Year's day</td>
							<td width="25%" align="center" style="font-weight:bold">OFFICE CLOSED</td>
						</tr>
					</table>
					<p style="margin-top:42px;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">
					For Filipinos, Christmas is primarily a family affair. Please expect your staff member(s) filling leave requests for dates listed above or more.
					</p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">
					All leave request outside the dates as listed above are subject to your approval. Please get back to me of when you want your staff to take a Christmas off and when you need them working.
					</p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">
					Should you wish to grant PAID Christmas holidays off to your staff member(s), kindly advise us on or before Wednesday, November 27 , so we can arrange and adjust your December Invoice accordingly.
					</p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">
					*If we don't receive any feedback from you on November 27th, we will assume that you are good to be invoiced 17 working days of your staff members for the month of December 2013 and for your staff to work on all weekdays of December except for the 4 days as mentioned above.
					</p>
					<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:16px;letter-spacing:0;color:#535353;text-align:left">
					Let us know if you have any question or clarifications.
					</p>
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