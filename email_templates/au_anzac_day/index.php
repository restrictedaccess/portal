<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_anzac_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_anzac_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_anzac_day/";
}
?>
<div style="text-align:center">
	<table border="0" background="<?php echo $base; ?>images/anzac-bg.jpg" style="height: 979px;width:800px;margin:auto;text-align:left;color:#FFFFFF;">
		<tr>
			<td valign="top">
				<div style="padding:153px 106px 0 106px">
					<p style="font-size:19px;line-height:24px;margin-bottom: 24px;margin-top:0;font-family: Arial, Helvetica, sans-serif">Dear <?php echo $lead["fname"]?>,</p> 
					<p style="font-size:19px;line-height:24px;margin-bottom: 24px;margin-top:0;font-family: Arial, Helvetica, sans-serif">It will be ANZAC Day this April 25. We understand that this<br/> is an important national occasion celebrated around Australia.</p>
					<p style="font-size:19px;line-height:24px;margin-bottom: 24px;margin-top:0;font-family: Arial, Helvetica, sans-serif">We would like to know and check if it's going to be a work day<br/> for you remote staff or team.</p>	
					<p style="font-size:19px;line-height:24px;margin-bottom: 24px;margin-top:0;font-family: Arial, Helvetica, sans-serif">Should you wish your staff NOT to work on that day, please<br/> respond to this email telling us so. </p>
					<p style="font-size:19px;line-height:24px;margin-bottom: 24px;margin-top:0;font-family: Arial, Helvetica, sans-serif">If we don't receive any notice or reply from you  by Wednesday,<br/> April 20,  we will assume that your staff will be working as usual.</p>  
				</div>
										
			</td>
		</tr>
	</table>
	<table background="<?php echo $base; ?>images/anzac-footer.png" style="height: 56px;width:800px;margin:auto">
		<tr>
			<td>
				<div style="text-align: right;padding-right: 24px;margin-top: 20px;">
					<a href="http://www.remotestaff.com.au" style="font-size:9px;color:#fff;text-decoration: none;font-family: Arial, Helvetica, sans-serif">www.remotestaff.com.au</a>
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