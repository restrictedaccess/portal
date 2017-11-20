<?php
include './conf/zend_smarty_conf.php';
require('./tools/CouchDBMailbox.php');


if($_SESSION['admin_id']=="")
{
	header("location:index.php");
	exit;
}

$temp_id = $_REQUEST['temp_id'];
if($temp_id == ""){
	die("Temp ID is Missing");
}


//header("location:/portal/django/subcontractors/subcon/$subcontractors_id");
//exit;

$sql = $db->select()
    ->from('subcontractors_temp', Array('userid', 'leads_id', 'temp_status'))
	->where('id=?', $temp_id);
$subcontractor = $db->fetchRow($sql);
if(!$subcontractor){
	die("Contract does not exist");
}


//Check the temp_status
//echo $subcontractor['temp_status'];
if($subcontractor['temp_status'] == 'deleted'){
	die("Temp Contract is either not existing or deleted.");
}

$userid= $subcontractor['userid'];
$leads_id = $subcontractor['leads_id'];


$query="SELECT fname, lname FROM personal p WHERE p.userid= $userid;";
$personal = $db->fetchRow($query);
$staff_name = $personal['fname']." ".$personal['lname'];


$query = "SELECT fname, lname FROM leads WHERE id = $leads_id;";
$lead = $db->fetchRow($query);
$client_name = $lead['fname']." ".$lead['lname'];

//Check if the admin can access staff contracts
$sql = $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin =$db->fetchRow($sql);
$view_staff_contract =  $admin['view_staff_contract'];
if ($view_staff_contract == 'N') {
	
	$attachments_array =NULL;
	$bcc_array=NULL;
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Staff Temp Contract Access Denied";
    $text = sprintf('Admin #%s%s %s is trying to view Staff Temp Contract #%s %s.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'], $temp_id, $staff_name);
    $to_array = array('devs@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Staff Contract Access Denied.");
}	


$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
//$date->modify("+2 day");
$date_advanced = $date->format("Y-m-d");
$min_date = $date->format("Ymd");


$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
$date->modify("+2 day");
//$max_date = $date->format("Ymt");
$date_advanced = $date->format("Ymd");
?>
<html>
<head>
<title>Temporary Staff Contract</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="admin_subcon/admin_subcon.css">

<script type="text/javascript" src="js/jscal2.js"></script> 
<script type="text/javascript" src="js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="css/gold/gold.css" />
<link rel="stylesheet" type="text/css" href="admin_subcon/overlay.css"  />


<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' src='admin_subcon/admin_subcon.js'></script>


</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form name='form' method='post' >
<input type="hidden" name="min_date" id="min_date" value="<?php echo $date_advanced;?>" >
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
</tr>
<tr>
<td width=100% valign='top' style='border: #006699 2px solid; background:#F3F3F3'   >
<?php include 'admin_subcon/contract_management_menu.php'; ?>
<div align="center">

<h2 class="h2"><?php echo strtoupper($staff_name);?> CONTRACT DETAILS</h2>
<h3 class="h3">TO CLIENT <?php echo strtoupper($client_name);?></h3>
<h4>(Temporary Contract)</h4>
</div>
<div style="background:#EEEEEE; padding:10px;">
<div id="staff_contract_handler">
<div class="drag-handle" ><span id="drag_handle">Staff Contract</span></div>
<div id="applicant_info">Loading....</div>
</div>
</div>
</td>
</tr>
</table>
<script type="text/javascript">
<!--
showContractDetails(<?php echo $temp_id;?> ,'<?php echo $subcontractor["temp_status"]?>');
-->
</script>
<?php include 'footer.php';?>
</form>

</body>
</html>