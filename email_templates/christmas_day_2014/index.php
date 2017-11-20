<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/christmas_day_2014/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/christmas_day_2014/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/christmas_day_2014/";
}
?>

<div style="text-align:center;margin:0">
	<table border="0" height="1035" width="800" style="margin:auto;text-align:left;color:#000000">
		<tr>
			<td valign="top">
				<div><img src="<?php echo $base?>images/header_top.png"/></div>
				<div style="margin-top:-35px;padding-left:45px;padding-right:52px">
					<p style="margin:0;margin-bottom:15px;font-family:Arial,Helvetica,sans-serif;font-size:31px;color:#016d87;text-align:left">Dear <?php echo $lead["fname"]?>,</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#597200;text-align:left">Important Updates with the Remote Staff Service Agreement You need to know about.</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">We've made a few important updates to the Remote Staff service agreement that will affect all our clients that hire Remote Staff contractors via Remote Staff. These changes will be applied across all working relationships with Remote Staff from 1st Oct 2014 and will affect your billing in particular for the month of December.</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#597200;text-align:left">1st Update on Schedule 2 point 4:</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">It is no longer allowed to ask your staff member to be on forced work leave during weekdays except when staff member is not able to work due to sickness, Australian/Philippine holiday or work leave. You will still only be billed for the hours worked of your staff member. If authorized by the client the remote staff service provider could make up for unworked hours outside of normal work schedules set on this contract.</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#597200;text-align:left">Reasons why this update has been applied:</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">We had a growing number of clients randomly asking contracted staff to stop working for a day or for a whole week. Over time we have noticed staff retention issues created from this type of requests. In an overall effort to retain consistent incomes for staff wages and to avoid retention issues, this new condition has been applied for everyone's best interest. </p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#597200;text-align:left">2nd Update: Schedule 2 point 5</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">In relation to December and January Month Payments</p>
					<p style="margin:0;margin-left:58px;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">December 24, Day before Christmas<br/>December 25, Christmas Day<br/>December 26, Australia Boxing Day<br/>December 30, Rizal Day<br/>December 31, Last day of the year<br/>January 1, New Year's Day</p>
					<table style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">
						<tr>
							<td valign="top"><img src="<?php echo $base?>images/bullet.png"/></td>
							<td valign="top">
								<p style="margin-top:4px;margin-bottom:0">The Client will provide the Remote Staff Service Provider with mandatory paid leave at regular hourly rate for the 6 days indicated above.</p>
							</td>
						</tr>
						<tr>
							<td valign="top"><img src="<?php echo $base?>images/bullet.png"/></td>
							<td valign="top">
								<p style="margin-top:4px;margin-bottom:0">The Remote Staff Service provider's hourly rate is at 200% in event where Remote Staff Service Provider is required to work during December 24, 25, 26,30, 31 and January 1.</p>
							</td>
						</tr>
					</table>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#597200;text-align:left">Reasons why this update has been applied:</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">Remote Staff Inc. and most of our clients recognise the importance of the December month to the Filipino culture. Normally employees in the Philippines receive a 13th month pay in December, but Remote Staff contractors do not. It's been optional for Clients to contribute towards paid leaves since the company started, but last year Dec 2013 we had made efforts to add paid leaves with every client December invoice.</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">We noticed a growing trend where 73% of clients are ok in making this contribution over Christmas. As a result Remote Staff Management has decided to apply "mandatory paid leaves" for the 6 days indicated on schedule 2 point 5 to all working relationships, to be charged at regular hourly rates.</p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">After almost 7 years in operations we have decided it's the fair thing to do so no staff would miss out on paid leaves. If you choose to pay Christmas bonuses on top of the mandatory paid leaves, you're welcome to do so as an added payment on top of mandatory paid leaves. </p>
					<p style="margin:0;margin-bottom:19px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#000;text-align:left">We have made these changes in the best interest of everybody involved in the remote working relationships, if you feel we have overlooked anything or if your operations could get effected by these changes, please give me a call. You could also view the updated service agreement on <a href="http://www.remotestaff.com.au/agreement2.php" style="color:#004271;text-decoration:none">http://www.remotestaff.com.au/agreement2.php</a></p>
				</div>
				<div>
					<img src="<?php echo $base?>images/footer_bottom.png"/>
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