<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_melbourne_cup_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_melbourne_cup_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_melbourne_cup_day/";
}
?>
<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/melbourne_cup_bg.png" height="776" width="800" style="margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
			<td valign="top">
				<div style="padding-left:41px;padding-top:40px;padding-right:52px">
					<p style="font-family:Arial,Helvetica, sans-serif;font-size:40px;font-weight:bold;letter-spacing:-1pt;line-height:120%;color:#434363;text-align:left;margin-top:0;margin-bottom:16px">Melbourne Cup Day</p>
					<p style="margin-left:60px;margin-top:0;margin-bottom:16px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#353535;text-align:left;">Melbourne Cup Day is on 1st of November. It Australia's best known horse racing event held on the first Tuesday of November every year. </p>
					<p style="margin-left:60px;margin-top:0;margin-bottom:16px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#353535;text-align:left;">It is an annual public holiday in the state of Victoria. This event is popularly dubbed as "the race that stops the nation".</p>
					<p style="margin-left:60px;margin-top:0;margin-bottom:16px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#353535;text-align:left;">We would like to know and check if it's going to be a work day for your remote staff or team.</p>
					<p style="margin-left:60px;margin-top:0;margin-bottom:16px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#353535;text-align:left;">Should you wish your staff NOT to work on that day, please respond to this email.</p>
					<p style="margin-left:60px;margin-top:0;margin-bottom:210px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#353535;text-align:left;">If we don't receive any notice or reply from you on 27th  of October 2016, we will assume that your staff will be working as usual.</p>										
					<p style="margin-right:-26px;text-align:right;margin-top:0;margin-bottom:210px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#616161">*VIC only</p>										
					
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
		<strong><?php echo $hc["admin_fname"]." ".$hc["admin_lname"]?></strong><br/>
		<?php echo $hc["signature_company"]?><br/>
		<?php echo $hc["signature_contact_nos"]?></p>
	<?php } ?>	
</div>