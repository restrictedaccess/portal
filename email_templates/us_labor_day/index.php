<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/us_labor_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/us_labor_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/us_labor_day/";
}
?>
<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/background_us_holiday.png" height="776" width="800" style="height:776px;width:800px;margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
			<td valign="top">
				<div style="padding-left:228px;padding-top:125px;padding-right:93px;">
					<p style="font-family:'Helvetica Neue', Arial, Helvetica, sans-serif;font-size:52px;font-weight:900;letter-spacing:-1pt;line-height:120%;color:rgb(255,255,255);text-align:left;margin-top:0;margin-bottom:31px">
						Labor Day
					</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;line-height:1.2em">
						is annually held on the first Monday of September. It was originally organized to celebrate various labor associations' strengths of and contributions to the United States economy.
					</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;line-height:1.2em">
						<strong>This year it falls on September 02.</strong>
					</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;line-height:1.2em">
						We would like to know and check if it's going to be a work day for your remote staff or team.
					</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;line-height:1.2em">
						Should you wish your staff NOT to work on that day, please respond to this email telling us so.
					</p>
					<p style="margin-top:0;margin-bottom:26px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(255,255,255);text-align:left;line-height:1.2em">
						If we don't receive any notice or reply from you by Wednesday, August 28th, we will assume that your staff will be working as usual.
					</p>
			</div></td>
		</tr>
	</table>
	<div style="background-color:#B2D233;width:800px;height:7px;margin:auto;display:block!important"></div>
	<div style="background-color:#00B1DA;width:800px;height:35px;margin:auto;display:block!important"></div>

</div>

<div style="padding-left:80px;padding-top:30px;">
	<?php if ($hc){ ?>
		<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:11pt;line-height:90%;text-align:left">Kind Regards,<br/><br/>
		<?php echo $hc["admin_fname"]." ".$hc["admin_lname"]?></strong><br/>
		<?php echo $hc["signature_company"]?><br/>
		<?php echo $hc["signature_contact_nos"]?></p>
	<?php } ?>	
</div>