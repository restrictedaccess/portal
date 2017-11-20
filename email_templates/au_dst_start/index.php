<?php
include ('../../conf/zend_smarty_conf.php');
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_dst_start/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_dst_start/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_dst_start/";
}
?>
<div style="text-align: center;">
	<div style="margin:auto;text-align:left;width:800px;overflow: hidden;background-color:#f2f2f2;">
		<table border="0" style="width:800px">
			<tr>
				<td align="right">
					<div style="padding-right:32px;padding-top:42px;">
						<img src="<?php echo $base; ?>images/leads_dst_start.png"/>	
					</div>
					
				</td>
			</tr>
			<tr>
				<td>
					<div style="padding-left:56px;padding-right:126px ">
						<p style="font-family:Arial, Helvetica, sans-serif;font-size:17px;margin-bottom:19px;">Hi <?php echo $lead["fname"]?>,</p>
						<p style="font-family:Arial, Helvetica, sans-serif;font-size:17px;margin-bottom:19px;">Australia DST (Daylight Saving Time) begins on the 4th of October 2015, Sunday.</p>
						<p style="font-family:Arial, Helvetica, sans-serif;font-size:17px;margin-bottom:19px;">Local daylight time on Sunday, 4th of October 2015, 2:00am clocks are turned forward 1 hour to Sunday, 4th of October 2015, 3:00am  local standard time.</p>
						<p style="font-family:Arial, Helvetica, sans-serif;font-size:17px;margin-bottom:0px;">This affects the following states and territories:</p>
						
						<ul style="font-family:Arial, Helvetica, sans-serif;font-size:17px;list-style-type: none;padding:0;margin:0;">
							<li style="font-weight:bold">ACT</li>
							<li style="font-weight:bold">Victoria</li>
							<li style="font-weight:bold">Tasmania</li>
							<li style="font-weight:bold">New South Wales</li>
							<li style="font-weight:bold">South Australia</li>
						</ul>
						<p style="font-family:Arial, Helvetica, sans-serif;font-size:17px;margin-bottom:62px;margin-top:1em">This email is to let you know that your Remote Staff members in the Philippines will adjust their work hours to coincide with the DST change in your location. Should you wish for this not to happen, Please let me know before the 1st of October 2015.</p>
					
					</div>
					
				</td>
			</tr>
			<tr>
				<td>
					<img src="<?php echo $base; ?>images/leads_template_footer.png"/>
				</td>
			</tr>
		</table>
	</div>
</div>


