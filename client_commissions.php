<?php
// July 23 , 2009 remove the Testimonial Module for Client
include './conf/zend_smarty_conf.php';
$leads_id = $_SESSION['client_id'];
//echo $userid;
if($_SESSION['client_id']=="")
{
	header("location:index.php");
	exit;
}

header("location:/portal/django/staff_commissions/");
exit;

$query="SELECT lname, fname,DATE_FORMAT(timestamp,'%D %b %Y'),email,mobile,officenumber FROM leads WHERE id = $leads_id";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];


?>

<html>
<head>
<title>Client Home</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="commission/commission.css">
<script language=javascript src="js/functions.js"></script>
<script language=javascript src="commission/commission.js"></script>
<script language=javascript src="commission/drag-drop-custom.js"></script>



</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post">
<input type="hidden" value="<?php echo $client_id?>" id="leads_id" name="leads_id">

<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="margin-top:10px;">
<tr>
<td width="20%" height="108" valign="top">
<?php include 'clientleftnav.php';?></td>
<td width="80%" height="108" valign="top">
<div style="font:12px Arial;">
<div class="header" >
			<div id="1" class="tab1"><a href="javascript:showForm(1);" >Commission Claims</a></div>
			<div id="2" class="tab2"><a href="javascript:showForm(2);" >Commission List</a></div>
			<div id="3" class="tab3"><a href="javascript:showForm(3);" >Create Commission</a></div>
			<div style="clear:both;"></div>
	<div id="result" >Loading...</div>		
	</div>
</div></td>
</tr></table>

<script type="text/javascript">
<!--
// by default show the Commission Claims Form # 1
showForm(1);

-->
</script>






<?php include 'footer.php';?>
</form>
</body>
</html>
