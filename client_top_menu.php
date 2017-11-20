<?php
//  2011-09-08  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updated subcon management screenshot viewer
//  2011-01-03  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   client subcon management integration
include('conf/zend_smarty_conf.php');
if($_SESSION['client_id'] == "" or $_SESSION['client_id'] == NULL){
	die("Session expires. Plese re-login.");
}
$menu = basename($_SERVER['SCRIPT_FILENAME']);
switch ($menu)
{
	case "clientHome.php":
		$class1 = "id='homenav'";
	break;
	case "myscm.php":
		$class2 = "id='homenav'";
	break;
	case "work_with_remotestaff.php":
		$class3 = "id='homenav'";
	break;
	case "comments_suggestion.php":
		$class4 = "id='homenav'";
	break;
	case "support_team_contact_details.php":
		$class5 = "id='homenav'";
	break;
	case "client_contract.php":
		$class6 = "id='homenav'";
	break;
	case "client_commissions.php";
		$class7 = "id='homenav'";
	break;
	
}
//echo $db;
$sql = $db->select()
	->from('leads')
	->where('id =?' , $_SESSION['client_id']);
$row = $db->fetchRow($sql);	
$name = $row['fname']." ".$row['lname'];
?>

<div style="background:url(images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">
<ul>
  <li><a href="clientHome.php" <?php echo $class1;?>><b>Home</b></a></li>
   <li><a target="_blank" href="/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html" <?php echo $class2;?>><b>Screenshots, Timesheets and Activity Tracker </b></a></li>
    <!--
	 <li><a href="work_with_remotestaff.php" <?php echo $class3;?>><b>How To Work With RemoteStaff </b></a></li>
	 <li><a href="comments_suggestion.php" <?php //echo $class4;?>><b>Comments &amp; Suggestions</b></a></li>
	-->
	<li><a href="support_team_contact_details.php" <?php echo $class5;?>><b>Support Team Contact Details</b></a></li>
	<li><a href="client_contract.php" <?php echo $class6;?> ><b>Service Agreement</b></a></li>
	<li><a href="client_commissions.php" <?php echo $class7;?> target="_blank" ><b>Commissions</b></a></li>
	<li><a href="/adhoc/php/client/as_client.php?task=portal_redirect&service_type=trial_based" target="_blank"><b>Trial Staff List</b></a></li>
	
</ul>
</div>
</div>
<div style="background:#c0e0f5;font:bold 12px Arial; padding:5px; ">
Welcome Client <?php echo $name;?>
<span style="float:right;">CLIENT ID #<?php echo $_SESSION['client_id'];?></span>
</div>
