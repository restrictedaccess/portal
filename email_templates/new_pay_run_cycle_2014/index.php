<?php
include('../../conf/zend_smarty_conf.php') ;
if (TEST){
	$base = "http://test.remotestaff.com.au/portal/email_templates/new_pay_run_cycle_2014/";
}else{
	$base = "http://remotestaff.com.au/portal/email_templates/new_pay_run_cycle_2014/";
}
?>
<div style="text-align:center;margin:0">
<table border="0" background="<?php echo $base?>images/pay_run_header.png" height="93" width="800" style="margin:auto;text-align:left;color:#FFFFFF">
<tr>
<td>&nbsp;</td>
</tr>
</table>
<table border="0" width="800" style="margin:auto;text-align:left;color:#454545">
<tr>
<td valign="top">
<div style="padding-left:60px;padding-right:37px">
<p style="color:#1f63a5;font-weight:bold;font-size:11.9pt;font-family:Arial,Helvetica,sans-serif;margin-top:0;margin-bottom:7px">Happy New Year!</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-top:0;margin-bottom:23px">Every year Remote Staff reviews current processes and endeavours to improve for the benefit of our<br/> staff members and clients. </p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-top:0;margin-bottom:22px">This year, we will have New Pay Run Cycle and New Work Notices Policy to improve on our payment processes and crediting. </p>
</div>
<div style="padding-left:60px;padding-right:0;padding-bottom:15px">
<table border="0">
<tr>
<td valign="top"><p style="margin:0;color:#1f63a5;font-weight:bold;font-size:11.9pt;font-family:Arial,Helvetica,sans-serif">New Pay Run Cycle</p></td>
<td valign="top"><img src="<?php echo $base?>images/pay_run_cycle_line.png" style="margin-top:-3px"/></td>
</tr>
</table>
</div>
<div style="padding-left:0px;padding-right:43px">
<table border="0" style="color:#454545">
<tr>
<td valign="top"><div style="padding-top:8px"><img src="<?php echo $base?>images/pay_run_hand.png" style="margin-left:-2px"/></div></td>
<td valign="top">
<p style="font-size:11pt;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:#ec1b23;margin-bottom:11px">Effective January, 2014</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:19px">All payments credited to you will now cover the whole month instead of the<br/>20th monthly cut off.</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:19px">The payments will be deposited and will clear into your nominated bank<br/>account within the first 3 weekdays of the month following the coverage month. </p>
</td>
</tr>
</table>
</div>
</td>
</tr>
</table>
<table border="0" background="<?php echo $base?>images/pay_run_table.png" height="347" width="800" style="margin:auto;text-align:left">
<tr>
<td valign="top">
<div style="padding-left:159px">
<p style="font-weight:bold;color:#21214f;font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-top:2px;margin-bottom:8px">Payment Schedule for 2014</p>
</div>
<div style="padding-left:157px">
<?php
if (!isset($_GET["sending"])){
	?>
<table border="0" style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;color:#464646;border-spacing:0;border-collapse:collapse">
<thead>
<tr>
<th align="left" width="120"><strong>Month</strong></th>
<th align="left" width="248"><strong>Coverage</strong></th>
<th align="left"><strong>Payment Date</strong></th>
</tr>
</thead>
<tbody>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">January</p></td>
<td>January 1 - 31, 2014</td>
<td>February 3 - 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">February</p></td>
<td>February 1 - 28, 2014</td>
<td>March 3 - 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">March</p></td>
<td>March 1 - 31, 2014</td>
<td>April 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">April</p></td>
<td>April 1 - 30, 2014</td>
<td>May 1- 2, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">May</p></td>
<td>May 1 - 31, 2014</td>
<td>June 2 - 4, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">June</p></td>
<td>June 1 - 30, 2014</td>
<td>July 1 - 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">June</p></td>
<td>June 1 - 30, 2014</td>
<td>July 1 - 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">July</p></td>
<td>July 1 - 31, 2014</td>
<td>August 1- 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">August</p></td>
<td>August 1- 31, 2014</td>
<td>September 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">September</p></td>
<td>September 1 - 30, 2014</td>
<td>October 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">October</p></td>
<td>October 1- 31, 2014</td>
<td>November 3 - 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">November</p></td>
<td>November 1 - 30, 2014</td>
<td>December 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:3px;margin-top:0;margin-left:0">December</p></td>
<td>Merry Christmas! TBA</td>
<td>Merry Christmas! TBA</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</table>	
	<?php
}else{
	?>
<table border="0" style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;color:#464646;border-spacing:0;border-collapse:collapse">
<thead>
<tr>
<th align="left" width="120"><strong>Month</strong></th>
<th align="left" width="248"><strong>Coverage</strong></th>
<th align="left"><strong>Payment Date</strong></th>
</tr>
</thead>
<tbody>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">January</p></td>
<td>January 1 - 31, 2014</td>
<td>February 3 - 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">February</p></td>
<td>February 1 - 28, 2014</td>
<td>March 3 - 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">March</p></td>
<td>March 1 - 31, 2014</td>
<td>April 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">April</p></td>
<td>April 1 - 30, 2014</td>
<td>May 1- 2, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">May</p></td>
<td>May 1 - 31, 2014</td>
<td>June 2 - 4, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">June</p></td>
<td>June 1 - 30, 2014</td>
<td>July 1 - 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">June</p></td>
<td>June 1 - 30, 2014</td>
<td>July 1 - 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">July</p></td>
<td>July 1 - 31, 2014</td>
<td>August 1- 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">August</p></td>
<td>August 1- 31, 2014</td>
<td>September 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">September</p></td>
<td>September 1 - 30, 2014</td>
<td>October 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">October</p></td>
<td>October 1- 31, 2014</td>
<td>November 3 - 5, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">November</p></td>
<td>November 1 - 30, 2014</td>
<td>December 1- 3, 2014</td>
</tr>
<tr>
<td><p style="margin-bottom:5px;margin-top:0;margin-left:0">December</p></td>
<td>Merry Christmas! TBA</td>
<td>Merry Christmas! TBA</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</table>	
	
	<?php
}
?>
<div style="width:800px;text-align:left;margin:auto">
<p style="font-weight:bold;color:#21214f;font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-top:12px;margin-bottom:36px;padding-left:61px">To ensure seamless and timely payment, we will implement a new work notices policy.</p>
</div>
<table border="0" width="800" style="margin:auto;text-align:left;color:#454545">
<tr>
<td valign="top">
<div style="padding-left:60px;padding-right:0;padding-bottom:15px">
<table border="0">
<tr>
<td valign="top"><p style="margin:0;color:#1f63a5;font-weight:bold;font-size:12pt;font-family:Arial,Helvetica,sans-serif">New Work Notices Policy</p></td>
<td valign="top"><img src="<?php echo $base?>images/pay_run_work_notice_line.png" style="margin-top:-3px"/></td>
</tr>
</table>
</div>
<div style="padding-left:0px;padding-right:43px">
<table border="0" style="color:#454545">
<tr>
<td valign="top"><div style="padding-top:8px"><img src="<?php echo $base?>images/pay_run_ot.png" style="margin-left:-2px;margin-right:16px"/></div></td>
<td valign="top">
<p style="font-size:11pt;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:#ec1b23;margin-bottom:11px">Effective January, 2014</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:19px">Overtime is when you work above your contract hours of 40 hours a week (full time), 20 hours a week (part time) or your weekly contract hours as agreed.</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:19px">Any overtime needs to be approved by the client and approval must be<br/>forwarded to your respective CSRO before the following Wednesday of the week when overtime occurred. This gives you 3 days to get the client approval on any Overtime hours. </p>
</td>
</tr>
</table>
</div>
<div style="padding-left:67px;padding-right:38px;color:#454545">
<p style="font-size:11pt;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:#ec1b23;margin-bottom:11px">WHY THE NEW POLICY?</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:20px;margin-top:0">To further protect you from Client none payment, our accounting and payment system is on a <br/>Pre-Paid set up . We collect the money from the client in Advance; think of prepaid cell phone load.</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:23px;margin-top:0">The payment collected from the client is measured in "Credit" consumable by your hourly rate.<br/>Your hourly work hours are deducted off their Credit real time (every time you log out of RSSC).<br/>The client is only charged your contract work hours as initially agreed. </p>
</div>
<div style="padding-left:159px;padding-right:38px;color:#454545">
<p style="font-size:11pt;font-weight:bold;color:#464646;margin-top:0;margin-bottom:9px;font-family:Arial,Helvetica,sans-serif">Therefore:</p>
<table border="0" style="color:#454545">
<tr>
<td valign="top"><img src="<?php echo $base?>images/pay_run_check.png" style="margin-right:13px"/></td>
<td valign="top">
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:23px;margin-top:0">
When you work overtime, ANY Un-Approved overtime work is REFUNDED back to the client at the end of each week. When this is done, this money cannot be paid to you as we no longer hold this money.
</p>
</td>
</tr>
<tr>
<td valign="top"><img src="<?php echo $base?>images/pay_run_check.png" style="margin-right:13px"/></td>
<td valign="top">
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:23px;margin-top:0">
When you work OFFLINE ( not logged in on RSSC) NO credit is deducted off the Client's account as the system cannot read your worked hours. We will not know if the client has enough credit to pay for your working hours if you are not logged<br/>in on RSSC. We cannot guarantee payments if you work offline without initial<br/>approval of the client sent to your CSRO.
</p>
</td>
</tr>
<tr>
<td valign="top"><img src="<?php echo $base?>images/pay_run_check.png" style="margin-right:13px"/></td>
<td valign="top">
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:23px;margin-top:0">
The number of hours we charge the client is EQUAL to the hours we pay you at the end of each month. Failing to notify your CSRO on Overtime Work and Offline Work within the deadline will cause none payment.
</p>
</td>
</tr>
</table>
</div>
<div style="padding-left:67px;padding-right:38px;color:#454545">
<p style="font-size:11pt;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:#ec1b23;margin-bottom:11px">FAILING TO NOTIFY WITHIN DEADLINE</p>
</div>
<div style="padding-left:0px;padding-right:33px">
<table border="0" style="color:#454545">
<tr>
<td valign="top"><div><img src="<?php echo $base?>images/pay_run_waste.png" style="margin-right:22px"/></div></td>
<td valign="top">
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:22px">If notice is not forwarded to your respective CSRO within deadline, payment will NOT be credited to you and will be returned to the Client. Not notifying your CSRO in a timely manner is like flushing your money in the toilet. </p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:22px">This is for strict compliance to avoid payment problems.</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:22px">Transparency, consistency and trust is what we aim for at Remote Staff.<br/>Please help us uphold these values by complying to this new policy.</p>
<p style="font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-bottom:19px;color:#ec1b23;font-weight:bold">For any questions, please do not hesitate to contact your CSRO.</p>
</td>
</tr>
</table>
</div>
</td>
</tr>
</table>
<div style="width:800px;text-align:left;margin:auto">
<p style="font-weight:bold;color:#21214f;font-size:11pt;font-family:Arial,Helvetica,sans-serif;margin-top:12px;margin-bottom:36px;padding-left:61px">Please confirm receipt of this email.</p>
</div>
</div>