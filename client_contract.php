<?php
include './conf/zend_smarty_conf.php';


$leads_id = $_SESSION['client_id'];
//echo $userid;
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
header("location:/portal/django/client_portal/service_agreement/");
exit;

$query="SELECT lname, fname,DATE_FORMAT(timestamp,'%D %b %Y'),email,mobile,officenumber FROM leads WHERE id = $leads_id";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RemoteStaff-Client <?php echo $name;?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>
</head>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php if ($_REQUEST["page_type"]!="iframe"){
	?>
		<?php include 'header.php';?>
		<?php include 'client_top_menu.php';?>	
	<?php
}?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="margin-top:10px;">
<tr>
<?php if ($_REQUEST["page_type"]!="iframe"){?>
<td width="14%" height="176" bgcolor="#ffffff"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<?php include 'clientleftnav.php';?></td>
<?php }?>
<td valign="top" style="padding:10px;">
<h2>Service Agreement Before March 28, 2012</h2>
<ul>
<li>Australian Client : Click to <a href="http://www.remotestaff.com.au/agreement.php" target="_blank"><b>view</b></a> </li>
<li>UK Client : Click to <a href="http://www.remotestaff.co.uk/agreement.php" target="_blank"><b>view</b></a> </li>
<li>US Client : Click to <a href="http://www.remotestaff.biz/agreement.php" target="_blank"><b>view</b></a></li>
</ul>

<h2>Service Agreement for Clients from March 28, 2012</h2>

<p>New Service Agreement for Clients availing any Remote Staff Service from March 28, 2012 onwards VIEW <a href="./service-agreements/Service_Agreement.pdf" target="_blank">HERE</a>.</p>

<p>Addendum on the new contract available from March 28, 2012.    If you want to be in the new contract please email <a href="mailto:csr@remotestaff.com.au">CSR@remotestaff.com.au</a>  </p> 
The whole agreement is revised and shortened but content is essentially the same as previous versions except for the points below: 
<ul>

<li>	Clauses on Trialing Staff is added. </li>
<li>	Minimum 1 Month contract requirement is removed. </li>
<li>	Prepaid Payment Structure is added.</li> 
<li>	Revisions on prices for optional office use. </li>
<li>	Clause on suspension of Agreement when invoices are not paid on time is added. </li>

</ul>

<p><strong>VIEW ADDENDUM TO REMOTE STAFF SERVICE AGREEMENT  <a href="javascript:popup_win('History-of-Contract-Ammendments.php', 750 , 500);">HERE</a></strong></p></td>
</tr>
</table><?php if ($_REQUEST["page_type"]!="iframe"){?>
<?php include 'footer.php';?>
<?php }?>
</body>
</html>
