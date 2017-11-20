<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/us_veterans_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/us_veterans_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/us_veterans_day/";
}
?>

<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/veterans_day_bg.png" height="776" width="800" style="margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
			<td valign="top">
				<div style="padding-left:323px;padding-top:304px;padding-right:18px">
					<p style="font-family:'Helvetica',Arial,Helvetica, sans-serif;font-size:40px;font-weight:900;letter-spacing:-1pt;line-height:120%;color:#0C0C0C;text-align:left;margin-top:0;margin-bottom:23px">VETERANS DAY</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(0,0,0);text-align:left;">In the USA, Veterans Day annually falls on November 11. On this day veterans are thanked for their services to the United States.</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(0,0,0);text-align:left;">We would like to know and check if it's going to be a work day for your remote staff or team.</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(0,0,0);text-align:left;">Should you wish your staff NOT to work on that day, please respond to this email telling us so.</p>
					<p style="margin-top:0;margin-bottom:23px;font-family:Arial, Helvetica, sans-serif;font-size:13pt;letter-spacing:0pt;color:rgb(0,0,0);text-align:left;">If we don't receive any notice or reply from you by Wednesday, November 9th,  we will assume that your staff will be working as usual.</p>										
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