<?php
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


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sub-contractor Home</title>
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
<h2 style="margin:2px;">Legal Holidays</h2>
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:0px;">

<tr bgcolor="#FF6600">
<td width="31%" style="border:#CCCCCC outset 1px; font-weight:bold;">Philippines Legal Holidays</td>
<td colspan="2"  style="border:#CCCCCC outset 1px; font-weight:bold;">DATE</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>New Year's Day</strong></td>
<td colspan="2"  >1-Jan</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>People Power Day</strong></td>
<td colspan="2" >22-Feb</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Good Friday	</strong></td>
<td colspan="2" >Apr 2, 2010 / Apr 22, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Easter Sunday</strong></td>
<td colspan="2" >Apr 4 , 2010 / Apr 24 , 2011</td>
</tr>


<tr bgcolor="#FFFFFF">
<td ><strong>Valour Day</strong></td>
<td colspan="2" >9-Apr</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Labour Day</strong></td>
<td colspan="2" >1-Mayr</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>National Flag Day</strong></td>
<td colspan="2" >28-May</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Independence Day</strong></td>
<td colspan="2"  >12-Jun</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Manila Day</strong></td>
<td  colspan="2" >24-Jun</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Hero's Day</strong></td>
<td colspan="2" >31-Aug</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>All Saints' Day</strong></td>
<td colspan="2" >1-Nov</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Bonifacio Day</strong></td>
<td colspan="2" >30-Nov</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>Christmas Day</strong></td>
<td colspan="2" >25-Dec</td>
</tr>
<tr bgcolor="#FFFFFF">
<td ><strong>Rizal Day</strong></td>
<td colspan="2" >30-Dec</td>
</tr>

<tr bgcolor="#FFFFFF">
<td ><strong>New Year's Eve</strong></td>
<td colspan="2" >31-Dec</td>
</tr>

<tr bgcolor="#FF6600">
<td  style="border:#CCCCCC outset 1px; font-weight:bold;">Australia Legal Holidays</td>
<td width="26%"  style="border:#CCCCCC outset 1px; font-weight:bold;">DATE</td>
<td width="43%"><strong>State/Territory</strong></td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>New Year's Day</strong></td>
<td>1 Jan</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Australia Day</strong> {National Day}</td>
<td>26 Jan</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Royal Hobart Regatta</strong> </td>
<td>2nd Monday in February </td>
<td>TAS</td>
</tr>
<tr bgcolor="#FFFFFF">
<td><strong>Labour Day </strong></td>
<td>1st Monday in March </td>
<td>WA</td>
</tr>
<tr bgcolor="#FFFFFF">
<td><strong>Adelaide Cup </strong></td>
<td>2nd Monday in March </td>
<td>WA</td>
</tr>
<tr bgcolor="#FFFFFF">
<td><strong>Canberra Day </strong></td>
<td>2nd Monday in March </td>
<td>ACT</td>
</tr>
<tr bgcolor="#FFFFFF">
<td><strong>Eight Hours Day </strong></td>
<td>2nd Monday in March </td>
<td>TAS</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Good Friday</strong> <br>
    (Catholic or Protestant the friday before Easter Sunday)</td>
<td>2 Apr 2010 , 22 Apr 2011 , 6 Apr 2012</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Easter Saturday</strong><br>
    (day before Easter)</td>
<td>3 Apr 2010, 23 Apr 2011 , 7 Apr 2012</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Easter Sunday </strong></td>
<td>4 Apr 2010 , 24 Apr 2011 , 8 Apr 2012 </td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Easter Monday</strong><br>
    (Catholic or Protestant) the day after easter sunday</td>
<td>5 Apr 2010, 25 Apr 2011 , 9 Apr 2012</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Anzac Day</strong></td>
<td>25 Apr 2010 , 26 Apr 2011 , 25 Apr 2012</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Labour Day</strong></td>
<td>1st Monday of May  </td>
<td>QLD</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>May Day</strong></td>
<td>1st Monday of May</td>
<td>NT</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Foundation Day</strong></td>
<td>1st Monday of June</td>
<td>WA</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Queen's Birthday * </strong><br>
    (2nd monday of June)</td>
<td>14 Jun 2010 , 13 Jun 2011, 11 Jun 2012</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Picnic Day</strong></td>
<td>1st Monday of August</td>
<td>NT</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Family &amp; Community Day</strong></td>
<td>1st Monday of 3rd Term shool days (Sept/Oct)</td>
<td>ACT</td>
</tr>




<tr bgcolor="#FFFFFF">
<td><strong>Melbourne Cup Day</strong></td>
<td>2 Nov 2010 , 1 Nov 2011 , 6 Nov 2012</td>.
<td>VIC</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Labour Day</strong></td>
<td>1st Monday in October</td>
<td>ACT, NSW, SA </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Recreation Day</strong></td>
<td>1st Monday of November</td>
<td>TAS</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Christmas Day </strong><br>(Catholic or Protestant)</td>
<td>25 Dec</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Boxing Day</strong><br>(Christmas day will be observed)</td>
<td>26 Dec</td>
<td>ACT, NSW , NT , QLD, SA , TAS , VIC, WA </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Proclamation Day</strong></td>
<td>26 Dec</td>
<td>SA</td>
</tr>

<tr bgcolor="#FF6600">
<td  style="border:#CCCCCC outset 1px; font-weight:bold;">UK Legal Holidays</td>
<td   style="border:#CCCCCC outset 1px; font-weight:bold;">DATE</td>
<td>&nbsp;</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>New Years Day </strong></td>
<td>1 Jan </td>
<td>National Holiday </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>2nd January </strong></td>
<td>2 Jan </td>
<td>Scotland</td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Saint Patrick's Day </strong></td>
<td>17 Mar </td>
<td>Northern Ireland </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Good Friday </strong></td>
<td>22 Apr 2011 </td>
<td>National Holiday </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Easter Monday </strong></td>
<td>25 Apr 2011 </td>
<td>England, Northern Ireland , Wales </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Easter Tuesday </strong></td>
<td>26 Apr 2011 </td>
<td>Northern Ireland </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>May Day Holiday </strong></td>
<td>1st Monday in May </td>
<td>National Holiday </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Victoria Day </strong></td>
<td>4th Monday in May </td>
<td>Scotland</td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Spring Bank Holiday </strong></td>
<td>Last Monday in May </td>
<td>National Holiday </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Orangeman's Day </strong></td>
<td>12-13 Jul 2011 </td>
<td>Northern Ireland </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Summer Bank Holiday</strong></td>
<td>1st Monday in August </td>
<td>Scotland</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Summer Bank Holiday</strong></td>
<td>Last Monday in August </td>
<td>England, Northern Ireland , Wales </td>
</tr>


<tr bgcolor="#FFFFFF">
<td><strong>Christmas Day</strong></td>
<td>25 Dec </td>
<td>National Holiday </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Boxing Day </strong></td>
<td>26 Dec </td>
<td>National Holiday </td>
</tr>

<tr bgcolor="#FF6600">
<td  style="border:#CCCCCC outset 1px; font-weight:bold;">US Legal Holidays</td>
<td colspan="2"  style="border:#CCCCCC outset 1px; font-weight:bold;">DATE</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>New year's Day </strong></td>
<td colspan="2">Jan 1 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Martin Luther King Day </strong></td>
<td colspan="2">Jan 18 , 2010 / Jan 17, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>President's Day </strong></td>
<td colspan="2">Feb 15 , 2010 / Feb 21, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Easter</strong></td>
<td colspan="2">Apr 4, 2010 / Apr 24, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Mother's Day </strong></td>
<td colspan="2">May 9, 2010 / May 8, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Memorial Day </strong></td>
<td colspan="2">May 31, 2010 / May 30, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Father's Day </strong></td>
<td colspan="2">Jun 20, 2010 / Jun 19, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Independence Day </strong></td>
<td colspan="2">July 4</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Labor Day </strong></td>
<td colspan="2">Sep 6, 2010 / Sep 5, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Columbus Day </strong></td>
<td colspan="2">Oct 11, 2010 / Oct 10, 2011 </td>
</tr>
<tr bgcolor="#FFFFFF">
<td><strong>Holloween </strong></td>
<td colspan="2">Oct 31 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Veteran's Day </strong></td>
<td colspan="2">Nov 11 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Thanksgiving</strong></td>
<td colspan="2">Nov 25, 2010 / Nov 24, 2011 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Christmas</strong></td>
<td colspan="2">Dec 25 </td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>New Year's Eve </strong></td>
<td colspan="2">Dec 31 </td>
</tr>


</table>
</td>
</tr>
</table>
<?php include 'footer.php';?>
</body>
</html>
