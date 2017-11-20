<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_labour_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_labour_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_labour_day/";
}
?>

<div style="text-align:center">
	<table border="0" background="<?php echo $base; ?>images/labor_au_day_top.png" height="333" width="800" style="margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
			
	<table border="0" height="443" width="800" style="margin:auto;text-align:left;color:#FFFFFF;background-color:#D10F33">
		<tr>
			<td valign="top">
				<div style="padding-left:57px;padding-top:20px;padding-right:30px;">
					<div style="padding-left:0;padding-top:0px;padding-right:66px;">
						<p style="font-family:'Helvetica Neue',Arial,Helvetica,sans-serif;font-size:78pt;font-weight:900;letter-spacing:-1pt;line-height:120%;color:#fff;text-align:left;margin-top:0;margin-bottom:1px">Labour Day</p>
						<p style="margin-top:0;margin-bottom:28px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#fff;text-align:left;line-height:1.3em">October 3rd is Labour Day. It commemorates the granting of the eight-hour working day for Australians. It also recognises workers' contributions towards the nation's economy. It is an annual public holiday.</p>
						<p style="margin-top:0;margin-bottom:28px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#fff;text-align:left;line-height:1.3em">We would like to know if it's going to be a work day for your remote staff or team.</p>
						<p style="margin-top:0;margin-bottom:28px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#fff;text-align:left;line-height:1.3em">Should you wish for your staff NOT to work on that day, please respond to this email.</p>	
						<p style="margin-top:0;margin-bottom:28px;font-family:Arial, Helvetica, sans-serif;font-size:12pt;letter-spacing:0pt;color:#fff;text-align:left;line-height:1.3em">If we don't receive any notice or reply from you on 28th of September 2016, we will assume that your staff will be working as usual.</p>				
					</div>
					<p style="text-align: right;color:#fff;font-family:Arial, Helvetica, sans-serif;font-size:11pt;">QLD, SA, ACT, NSW only</p>
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