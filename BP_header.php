<?php

//2010-07-03 Normaneil Macutay <normanm@remotestaff.com.au>
// - disabled sticky_notes 'sticky_notes/index.php';


//include 'sticky_notes/index.php';

include('conf/zend_smarty_conf.php');

$menu = basename($_SERVER['SCRIPT_FILENAME']);
switch ($menu)
{
	case "agentHome.php":
		$class1 = "id='homenav'";
	break;
	case "newleads.php":
		$class2 = "id='homenav'";
	break;
	case "follow_up_leads.php":
		$class3 = "id='homenav'";
	break;
	case "keep_in_touch_leads.php":
		$class4 = "id='homenav'";
	break;
	case "client_listings.php":
			$class5 = "id='homenav'";
	break;
	case "bp_affiliates.php":
			$class6 = "id='homenav'";
	break;
	//other pages
	case "apply_action.php":
			$class2 = "id='homenav'";
	break;
	case "client_workflow.php":
			$class5 = "id='homenav'";
	break;
	//case "client_account.php":
	//		$class5 = "id='homenav'";
	//break;
	//case "jobpostings.php":
	//		$class5 = "id='homenav'";
	//break;
	
	//case "recruitment_1.php":
	//		$class5 = "id='homenav'";
	//break;
	case "apply_action_affiliates.php":
			$class6 = "id='homenav'";
	break;
	
	case "pending.php":
		$class7 = "id='homenav'";
	break;
	
	case "hirestaff_leads.php":
		$class8 = "id='homenav'";
	break;	
	
	case "availablestaff_leads.php":
		$class9 = "id='homenav'";
	break;
	
	case "order-report.php":
		$class10 = "id='homenav'";
	break;
	
	case "recruitment-service.php":
		$class10 = "id='homenav'";
	break;
	
	case "secure-pay-payments.php":
		$class10 = "id='homenav'";
	break;
	
	case "interview-request.php":
		$class10 = "id='homenav'";
	break;
	
	case "voucher-manager.php":
		$class10 = "id='homenav'";
	break;
	
	case "send-email-resume.php":
		$class10 = "id='homenav'";
	break;
	
	
}
if($_REQUEST['tab'] == "follow_up"){
	$class3 = "id='homenav'";
}
if($_REQUEST['tab'] == "keep_in_touch"){
	$class4 = "id='homenav'";
	
}
if($_REQUEST['tab'] == "pending"){
	$class7 = "id='homenav'";
}

if($_REQUEST['tab'] == "custom recruitment"){
	$class8 = "id='homenav'";
}

if($_REQUEST['tab'] == "asl"){
	$class9 = "id='homenav'";
}


// new
if($_REQUEST['lead_status'] == "New Leads"){
	$class2 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "Follow-Up"){
	$class3 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "Keep In-Touch"){
	$class4 = "id='homenav'";
	
}
if($_REQUEST['lead_status'] == "pending"){
	$class7 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "custom recruitment"){
	$class8 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "asl"){
	$class9 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "Client"){
	$class5 = "id='homenav'";
}


$new_lead_marked_flag ="";
$follow_up_marked_flag ="";
$keep_in_touch_marked_flag = "";
$pending_marked_flag = "";
$client_marked_flag = "";


//$_SESSION['agent_no'];
$queryAgentFullName="SELECT * FROM agent  WHERE agent_no =".$_SESSION['agent_no'];
$row = $db->fetchRow($queryAgentFullName);


include 'header_menu_asl_order_checker.php';

?>
<div style="FONT: bold 7.5pt verdana; COLOR: #676767;text-align:right; margin-bottom:0px; padding-right:10px; padding-top:5px;  ">Welcome Business Developer <?php echo $row['fname']." ".$row['lname'];?></div>

<div style="background:url(images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">

<ul>
  <li><a href="/portal/agentHome.php" <?php echo $class1;?> >Home</a></li>
 
  <li><a href="/portal/leads.php?lead_status=New Leads" <?php echo $class2;?> >New Leads <?php echo $new_lead_marked_flag;?></a></li>
  <li><a href="/portal/leads.php?lead_status=Follow-Up" <?php echo $class3;?> >Follow Up <?php echo $follow_up_marked_flag;?></a></li>
  <li><a href="/portal/leads.php?lead_status=asl" <?php echo $class9;?> >ASL <?php echo $asl_up_marked_flag;?></a></li>
  <li><a href="/portal/leads.php?lead_status=custom recruitment" <?php echo $class8;?> >Custom Recruitment <?php echo $custom_recruitment_marked_flag;?></a></li>
  <li><a href="/portal/leads.php?lead_status=Keep In-Touch" <?php echo $class4;?> >Keep in Touch <?php echo $keep_in_touch_marked_flag;?></a></li>
  <li><a href="/portal/leads.php?lead_status=pending" <?php echo $class7;?> >Pending  <?php echo $pending_marked_flag;?></a></li>
  <li><a href="/portal/leads-active.php?lead_status=Client&filter=ACTIVE" <?php echo $class5;?> >Clients <?php echo $client_marked_flag;?></a></li>

  <li><a href="/portal/bp_affiliates.php" <?php echo $class6;?> >Affiliates</a></li>
</ul>

</div>
</div>
