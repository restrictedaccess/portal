<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/uk_christmas_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/uk_christmas_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/uk_christmas_day/";
}
?>

<div style="text-align:center;margin:0">
	<table border="0" background="<?php echo $base; ?>images/christmas_uk_background.jpg" height="818" width="800" style="margin:auto;text-align:left;color:#FFFFFF">
		<td valign="top">
			<div style="padding-left:43px;padding-top:264px;padding-right:291px">
				<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">Many people in the United Kingdom celebrate Christmas Day on December 25.The day celebrates Jesus Christ's birth.</p>
				<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">It is often combined with customs from pre-Christian winter celebrations. Many people erect Christmas trees, decorate their homes, visit family or friends and exchange gifts.</p>
				<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">We would like to know and check if it's going to be a work day for your remote staff or team.</p>
				<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left">Should you wish to grant PAID Christmas holidays off to your staff member(s), kindly advise us on or before Wednesday, November 27, so we can arrange and adjust your December Invoice accordingly.</p>
				<p style="margin-top:0;margin-bottom:21px;font-family:Arial,Helvetica,sans-serif;font-size:12pt;letter-spacing:0;color:#fff;text-align:left"><strong>If we don't receive any notice or reply from you by then, we will assume that your staff will be working as usual.</strong></p>
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