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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Important Letter about Payroll from Admin</title>




</head>

<body>
<form name="form" method="post" action="acknowledgeAdmin.php">
<table width="60%" border="1" cellspacing="0" cellpadding="5" align="center" style="font:12px Arial;">
<tr>
<td colspan="2" valign="top">
<h3 align="center">Important Letter about Payroll from Admin</h3>
<p class="h_name">Dear <?php echo $name;?>, </p>
<p><strong>HSBC Philippines </strong>have just informed us that there is a change in the process of applying for payroll account for RemoteStaff contractors. They now require all of us to actually apply for an account to their nearest bank branch because of the anti money laundering law. </p>
<p>We therefore request everyone to go to their nearest HSBC back with filled out and signed <strong class="h">HSBC application form  (download <a href="http://www.mediafire.com/?yjzlzgzgnqy" target="_blank">HERE</a>)</strong>, 2 Valid IDs (Passport, NBI Clearance, Postal ID, driver&acute;s license, professional license, voting ID etc.)  and  150 pesos application fee. ( <em>this will be reimbursed to you upon receipt of your HSBC account number</em>) </p>
<p>We need everyone to have their HSBC card by the end of March 2010. We therefore advice everyone to apply 2nd week of March at the latest as it takes 2 weeks for the issuance of the card from the application day. </p>
<p>By May 2010, anyone who&acute;s not with HSBC will be charged money transfer transaction fee amounting to $10 per pay. Aside from this,  we cannot be held liable for any delay with pay transfer  to  non HSBC bank account holder. We can assure 100% seamless and timely pay for all HSBC account holders. </p>
<p>This complete transition to HSBC payroll is also done in preparation for the plan to have bi-monthly payroll middle of this year. </p>
<p>Branches around your area are listed below. We have consolidated this information to make things easier for you. </p>
<p align="center"><em><strong>** For contractors who are not residing in this area, we will get in touch with you how to process your payroll account. </strong></em></p>
<p align="center">&nbsp;</p>


</td>

</tr>
  <tr>
    <td width="308" valign="top"><p align="center"><strong>City</strong></p></td>
    <td width="308" valign="top"><p align="center"><strong>Nearest HSBC Branch</strong></p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>ANGELES</p></td>
    <td width="308" valign="top"><p>G/F Odette Grace Building,    Barangay Dolores, MacArthur      Highway, San Fernando,    Pampanga, 2000, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>ANTIPOLO CITY </p></td>
    <td width="308" valign="top"><p>Commonwealth      Ave, Barangay Holy    Spirit, Quezon City, Metro Manila,    1121, Philippines</p>
        <p>OR </p>
      <p>299      Katipunan Road, Loyola Heights,    Quezon City, Metro Manila,    1108, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>BULACAN</p></td>
    <td width="308" valign="top"><p>359      Rizal Avenue Extension,    Grace Park, Caloocan City, Metro Manila,    1400, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>CALOOCAN CITY </p></td>
    <td width="308" valign="top"><p>359      Rizal Avenue Extension,    Grace Park, Caloocan City, Metro Manila,    1400, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>CAVITE </p></td>
    <td width="308" valign="top"><p>G/F One E-Com Center, Harbor Drive, Mall of Asia    Complex, Pasay City, Metro Manila, 1308, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>CEBU </p></td>
    <td width="308" valign="top"><p>HSBC Banilad Branch, A.S. Fortuna Street, Banilad, Cebu City,    6000, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>DAVAO </p></td>
    <td width="308" valign="top"><p>G/F      Luisa Avenue Square, E.    Jacinto Extension, Davao City, 8000, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>LAGUNA</p></td>
    <td width="308" valign="top"><p>G/F BC Group Center, Filinvest Avenue, Filinvest    Corporate City, Alabang, Muntinlupa City, Metro Manila, 1770, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>LAS PINAS</p></td>
    <td width="308" valign="top"><p>Unit 1, The Commercial Complex, Madrigal Avenue,    Ayala Alabang Village, Muntinlupa City, Metro Manila, 1770, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>MANILA </p></td>
    <td width="308" valign="top"><p>G/F Uy Su Bin    Building, 535 Quintin Paredes Street, Binondo, Manila, 1006, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>MARIKINA </p></td>
    <td width="308" valign="top"><p>299      Katipunan Road, Loyola Heights,    Quezon City, Metro Manila,    1108, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>MAKATI </p></td>
    <td width="308" valign="top"><p>G/F The Enterprise Centre, Tower I, 6766 Ayala    Avenue cor. Paseo de Roxas, Makati City, Metro Manila, 1200, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>MALABON</p></td>
    <td width="308" valign="top"><p>359      Rizal Avenue Extension,    Grace Park, Caloocan City, Metro Manila,    1400, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>MANDALUYONG</p></td>
    <td width="308" valign="top"><p>R1 Level, Space 142, Lopez Drive, Power Plant Mall,    Rockwell Center, Makati City, Metro Manila, 1200, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>NUEVA ECIJA</p></td>
    <td width="308" valign="top"><p>G/F Odette Grace Building,    Barangay Dolores, MacArthur      Highway, San Fernando,    Pampanga, 2000, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>MARIKINA </p></td>
    <td width="308" valign="top"><p>299      Katipunan Road, Loyola Heights,    Quezon City, Metro Manila,    1108, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>PAMPANGA</p></td>
    <td width="308" valign="top"><p>G/F Odette Grace Building,    Barangay Dolores, MacArthur      Highway, San Fernando,    Pampanga, 2000, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>PARANAQUE </p></td>
    <td width="308" valign="top"><p>G/F Gonzy Building, Lot 14 Block 22, President's Avenue, Para&ntilde;aque City,    Metro Manila, 1700, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>PASIG </p></td>
    <td width="308" valign="top"><p>G/F Silver City Automall, Frontera Verde Drive,    Julia Vargas Ave., Pasig City, Metro Manila, 1600, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>QUEZON CITY </p></td>
    <td width="308" valign="top"><p>Commonwealth      Ave, Barangay Holy    Spirit, Quezon City, Metro Manila,    1121, Philippines</p>
        <p>OR </p>
      <p>G/F Nexor Building, 1677      Quezon Avenue, Quezon City,    Metro Manila, 1100, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>RIZAL</p></td>
    <td width="308" valign="top"><p>G/F Silver City Automall, Frontera Verde Drive,    Julia Vargas Ave., Pasig City, Metro Manila, 1600, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>TAGAYTAY</p></td>
    <td width="308" valign="top"><p>G/F BC Group Center, Filinvest Avenue, Filinvest    Corporate City, Alabang, Muntinlupa City, Metro Manila, 1770, Philippines</p></td>
  </tr>
  <tr>
    <td width="308" valign="top"><p>TARLAC</p></td>
    <td width="308" valign="top"><p>G/F Odette Grace Building,    Barangay Dolores, MacArthur      Highway, San Fernando,    Pampanga, 2000, Philippines</p></td>
  </tr>
</table>
<p align="center">For any questions and comments, please email admin@remotestaff.com.au</p>
<p><input type="submit" value="Acknowledge" ></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
</body>
</html>

