<?php
include ('../../conf/zend_smarty_conf.php');
$lead = $db -> fetchRow($db -> select() -> from("leads") -> where("id = ?", $_REQUEST["id"]));
$hc = $db -> fetchRow($db -> select() -> from("admin") -> where("admin_id = ?", $lead["hiring_coordinator_id"]));
?>
<div style="text-align:center;margin:0">
<table cellpadding="0" cellspacing="0" bgcolor="#FFB9D4" border="0" height="1213" width="800" style="margin:auto;text-align:left;color:#000000">
<tr>
<td valign="top">
<div>
<?php
					if (TEST){
						?>
<img src="http://test.remotestaff.com.au/portal/email_templates/au_dst_start_update_2014/images/aest_header.png"/>
<?php }else{ ?>
<img src="https://remotestaff.com.au/portal/email_templates/au_dst_start_update_2014/images/aest_header.png"/>
<?php } ?>
</div>
<div style="padding-left:88px;padding-top:46px;padding-right:58px">
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:16pt;line-height:90%;text-align:left">
Hi <?php echo $lead["fname"]?>,
</p>
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:16pt;line-height:90%;text-align:left">
Australia DST (Daylight Saving Time) begins on the 4th of October 2015,S unday.
</p>
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:16pt;line-height:90%;text-align:left">
Local daylight time on Sunday, 4th of October 2015, 2:00am clocks are turned forward 1 hour to Sunday, 4th of October 2015, 3:00am  local standard time.
</p>
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-weight:bold;font-size:16pt;line-height:90%;text-align:left">
This affects the following states and territories:<br/>ACT<br/>Victoria<br/>Tasmania<br/>New South Wales<br/>South Australia
</p>
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:16pt;line-height:90%;text-align:left">
This email is to let you know that your Remote Staff members in the Philippines will adjust their work hours to conicide with the DST change in your location. Should you wish for this not to happen, Please let me know before the 1st of October 2015.
</p>
<?php
					if ($hc){?>
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:16pt;line-height:90%;text-align:left"><?php echo strip_tags($hc["signature_notes"])?></p>
<p style="margin-bottom:27px;margin-top:0;font-family:Arial,Helvetica,sans-serif;font-size:13pt;line-height:90%;text-align:left"><?php echo $hc["admin_fname"]." ".$hc["admin_lname"]?><br/><?php echo $hc["signature_company"]?><?php echo $hc["signature_contact_nos"]?><?php echo $hc["signature_websites"]?></p>
<?php
					}
					?>
</div>
</td>
</tr>
</table>
</div>