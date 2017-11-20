<?php
// 2010-07-01 Normaneil Macutay <normanm@remotestaff.com.au>
// - add July - Dec cut off dates
//  2010-02-23 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  changed 12 weeks to 52 weeks
include './conf/zend_smarty_conf_root.php';
$userid = $_SESSION['userid'];
//echo $userid;
if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$query="SELECT * FROM personal WHERE userid=$userid";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];
$payment_details=$result['payment_details'];
$image = $result['image'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Monthly Cut Off Period and FAQs about pay</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script type="text/javascript" src="js/MochiKit.js"></script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <?php echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <?php include 'subconleftnav.php';?></td>
<td width="1081" valign="top" style="padding:10px;">
  <h3 id="h3" style="text-align:center; color:#FF0000; ">PAY CUT OFF PERIOD</h3>
  <H4 align="center" style=" padding:10px;">
  As a result of the feedback received from you / clients, starting January 2011, our cut off schedule is fixed to every 20th of the month. Note that payout will still happen at the end of each month with guaranteed clearing on the 1st or 2nd business day of the following month.</h4>
  <!--
  <table width="50%" align="center" cellpadding="5" cellspacing="0" style="border:#0033FF solid 1px;">
  <tr>
	  <td width="27%" style="border-bottom:#0033FF solid 1px;">January 2010</td>
	  <td width="3%" style="border-bottom:#0033FF solid 1px;">:</td>
	  <td width="70%" style="border-bottom:#0033FF solid 1px;">January 26, 2010, Pay to clear by February 1 or 2 </td>
  </tr>
  
  <tr>
	  <td style="border-bottom:#0033FF solid 1px;">February 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;"> February 23, 2010, Pay to clear by March 1 or 2 </td>
  </tr>
  
  <tr>
	  <td style="border-bottom:#0033FF solid 1px;">March 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">March 26, 2010, Pay to clear by April 1 or 2 </td>
  </tr>
  
  <tr>
	  <td style="border-bottom:#0033FF solid 1px;">April 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">April 23, 2010, Pay to clear by April 29 or 30 </td>
  </tr>
  
  <tr>
	  <td style="border-bottom:#0033FF solid 1px;">May 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;"> May 25, 2010 , Pay to clear by June 1 or 2</td>
  </tr>
  
  <tr>
	  <td style="border-bottom:#0033FF solid 1px;">June 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">June 25, 2010, Pay to clear by July 1 or 2</td>
  </tr>
  
  
   <tr>
	  <td style="border-bottom:#0033FF solid 1px;">July 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">July 26, 2010 and pay to clear on August 1 or 2</td>
  </tr>
  
   <tr>
	  <td style="border-bottom:#0033FF solid 1px;">August 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">August 26, 2010  and pay to clear on Sept 1 or 2</td>
  </tr>
  
   <tr>
	  <td style="border-bottom:#0033FF solid 1px;">September 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">September 24, 2010  and pay to clear Oct 1or 2</td>
  </tr>
  
   <tr>
	  <td style="border-bottom:#0033FF solid 1px;">October 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">October 26, 2010  and pay to clear October 28 or 29</td>
  </tr>
  
   <tr>
	  <td style="border-bottom:#0033FF solid 1px;">November  2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">November 25, 2010  and pay to clear on Dec 1 or 2</td>
  </tr>
  
   <tr>
	  <td style="border-bottom:#0033FF solid 1px;">December 2010</td>
	  <td style="border-bottom:#0033FF solid 1px;">:</td>
	  <td style="border-bottom:#0033FF solid 1px;">December 17, 2010  and pay to clear on BEFORE Dec 24</td>
  </tr>
  
 
  
  </table>
-->

<h3 style="text-align:center; color:#FF0000;">Payroll FAQs: </h3>
<ul>
<li><b>I don’t understand my total pay. How did you came up with the hourly rate ? </b></li>
<p>We pay for all the hours you worked including approved over time up to the cut off date (see above) </p>
 <p>Hourly Rate is computed as below. </p>
  <p>Monthly Rate * 12 Months = Annual Rate<br>
Annual Rate / 52 Weeks = Weekly Rate <br>
Weekly Rate / 5 Days = Daily Rate <br>
Daily Rate / 8 Working Days (or 4 depending on our agreement) = Hourly Rate 
</p>
<p><strong>Total Pay is computed by : </strong></p>
<P><em>Hourly Rate * Number of hours worked (including approved OTs)   = Total Pay for the month 
+ Commissions if applicable 
+ Reimbursements if applicable  
</em></P>
<li><strong>Why am I not being paid for my OT ?</strong></li>
<p> It is likely that you don’t have any approval for this OT. When you work over and above the agreed hours for whatever reason, it should be something requested of approved by your client. <br>
Proof of request or approval should be sent to attendance@remotestaff.com.au for this to be applied and paid for. 
</p>
<li><strong>I needed to be reimbursed for  something as per my client, why is not applied on my pay ? </strong></li>
<p>It is likely that a notice has not been received by accounts. Please email your OR to reimbursements@remotestaff.com.au. We’ll call your client to confirm and add the total amount on your next pay. 
</p>
<li><strong>I am supposed to get a commission. Why is this not on my pay yet ? </strong></li>
<P>Get your client to contact us regarding the commissions or bonuses they want to give you by either emailing commissions@remotestaff.com.au or using the commission function on their portal. If they choose the later, you can claim commission and approve it by using the Commission Claims tab on your portal. </P>
<p>Note that any commission and bonuses lodge for the current month will be added to your next month’s pay. So a commission advised received Feb 2010 will be credited to you March 2010. 
</p>
<li><b>I have a question not listed on this FAQ. </b></li>
<P>Go to the Invoice Sub Tab and add a comment / note on the specific invoice. (Latest Invoice) </P>
<p>Queries sent via Skype or email will not be entertained. </P>
</ul>

  

  
  </td>
</tr>
</table>
<script>
appear('h3');
roundClass("h3", null);
</script>
</body>
</html>
