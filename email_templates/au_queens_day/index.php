<?php
include('../../conf/zend_smarty_conf.php') ;
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
if (TEST) { 
	$base = "http://devs.remotestaff.com.au/portal/email_templates/au_queens_day/";
} else if (STAGING) {
	$base = "http://staging.remotestaff.com.au/portal/email_templates/au_queens_day/";
} else {
	$base = "http://remotestaff.com.au/portal/email_templates/au_queens_day/";
}
?>
<div style="text-align:center">
	<table border="0" style="height: 752px;width:800px;margin:auto;text-align:left;"> 
		<tr>
			<td valign="top">
				<div style="padding-left:10px">
					<img src="<?php echo $base; ?>images/queens_crown.png" alt="Queen's Bday Remote Staff Update"/>
				</div>
					<p style="margin-top:34px;margin-bottom:10px;font-size:12pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;text-align: center;word-spacing:3px">The Queen's Birthday is a public holiday celebrated in most states and</p>
					<p style="margin-top:0px;margin-bottom:10px;font-size:12pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;text-align: center;word-spacing:3px">territories (except for WA) on the second Monday in June, making for a</p>
					<p style="margin-top:0px;margin-bottom:30px;font-size:12pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;text-align: center;word-spacing:3px">much-looked-forward-to June long weekend.</p>
					<p style="margin-bottom:30px;margin-top:0;font-size:25pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;text-align: center;color:#7B277C;font-weight: bold;word-spacing:3px">This year it falls on June 10th.</p>
					<p style="margin-bottom:24px;margin-top:0;font-size:12pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;word-spacing:3px">We would like to know and check if it's going to be a work day for your remote staff or team.</p>
					<p style="margin-bottom:24px;margin-top:0;font-size:12pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;word-spacing:3px">Should you wish your staff NOT to work on that day, please respond to this email telling us so.</p>
					<p style="margin-bottom:0px;margin-top:0;font-size:12pt;font-family:Arial, Helvetica, sans-serif;line-height:1.5em;word-spacing:3px">If we don't receive any notice or reply from you by Thursday, June 5th, we will assume that your<br/> staff will be working as usual.</p>
					<p style="text-align: right;margin-top:0;margin-bottom:15px"><img src="<?php echo $base; ?>images/rs_logo_queens.png"></p>
					<div style="background-color:#B2D233;height:15px;width:100%"></div>
					<div style="background-color:#006991;height:4px;width:100%"></div>
					<div style="background-color:#00B1DA;height:35px;width:100%;text-align: right;"><a href="http://www.remotestaff.com.au" style="letter-spacing:-1pt;line-height:92%;color:rgb(245,247,248);text-align:left;font-family: Arial,Helvetica,sans-serif;text-rendering: optimizeLegibility;text-decoration: none;margin-right: 19px;display:inline-block;margin-top:12px">www.remotestaff.com.au</a></div>
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