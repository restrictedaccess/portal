<?php
include './conf/zend_smarty_conf.php';
//echo  $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];


$menu = basename($_SERVER['SCRIPT_FILENAME']);
switch ($menu)
{
	case "adminHome.php":
		$class1 = "id='homenav'";
	break;
	case "adminadvertise_category.php":
		$class2 =  "id='homenav'";
	break;
	case "admin_advertise_list.php":
		$class2 =  "id='homenav'";
	break;
		
	case "admin_pending_advertise_list.php":
		$class2 =  "id='homenav'";
	break;
	
	case "admin_archive_advertise_list.php":
		$class2 =  "id='homenav'";
	break;
	
	case "admin_addadvertisement.php":
		$class2 =  "id='homenav'";
	break;
	
	case "admin_search_advertisement.php":
		$class2 =  "id='homenav'";
	break;
	
	case "admineditads.php":
		$class2 =  "id='homenav'";
	break;
	
	
	
	
	case "adminnewleads.php":
		$class4 =  "id='homenav'";
	break;
	case "admin_apply_action.php":
		if($page == "newleads"){
			$class4 =  "id='homenav'";
		}
		if($page == "followup"){
			$class5 =  "id='homenav'";
		}
		if($page == "keeptouch"){
			$class6 =  "id='homenav'";
		}
		if($page == "client"){
			$class7 =  "id='homenav'";
		}
		if($page == "pending"){
			$class10 =  "id='homenav'";
		}
		if($page == "custom recruitment"){
			$class11 =  "id='homenav'";
		}
		if($page == "Interview Bookings"){
			$class12 =  "id='homenav'";
		}
		
		
	break;
	case "admin_follow_up_leads.php":
		$class5 =  "id='homenav'";
	break;
	case "admin_keep_in_touch_leads.php":
		$class6 =  "id='homenav'";
	break;
	case "adminclient_listings.php":
		$class7 =  "id='homenav'";
	break;
	case "adminscm.php":
		$class8 =  "id='homenav'";
	break;
	case "subconlist.php":
		$class9 =  "id='homenav'";
	break;
	case "adminaddsubcon.php":
		$class9 =  "id='homenav'";
	break;
	case "admin_staff_contract.php":
		$class9 =  "id='homenav'";
	break;
	case "contractForm.php":
		$class9 =  "id='homenav'";
	break;
	case "cancellation_dashboard.php":
		$class9 =  "id='homenav'";
	break;
	//
	
	case "admin_pending_leads.php":
		$class10 =  "id='homenav'";
	break;
	case "admin_hirestaff_leads.php":
		$class11 =  "id='homenav'";
	break;
	
	case "admin_availablestaff_leads.php":
		$class12 =  "id='homenav'";
	break;
	
	
}

// new
if($_REQUEST['lead_status'] == "New Leads"){
	$class4 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "Follow-Up"){
	$class5 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "Keep In-Touch"){
	$class6 = "id='homenav'";
	
}
if($_REQUEST['lead_status'] == "pending"){
	$class10 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "custom recruitment"){
	$class11 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "asl"){
	$class12 = "id='homenav'";
}

if($_REQUEST['lead_status'] == "Client"){
	$class7 = "id='homenav'";
}

include 'header_menu_asl_order_checker.php';

?>

<?php if($admin_status!="HR"){ ?>
	<!--<div style="float:right; padding-right:10px;"><a href="admin_profile.php" class="link10" target="_blank" >Administrator Profile</a></div>-->
	<div style = "float:right; padding-right:10px">
    	
		<!--<form action="/portal/recruiter_search/recruiter_search.php" method="GET" class="navbar-form navbar-left">-->
			<input type="text" class="form-control" id="full-text-search" placeholder="Search Candidate, Job Order, Leads" name="q" style="border: 1px solid #c4c4c4; height: 30px; width: 15px; 
				margin-top: 10px;
				width: 275px; 
				font-size: 13px;  
				border-radius: 4px; 
				-moz-border-radius: 4px; 
				-webkit-border-radius: 4px; 
				box-shadow: 0px 0px 8px #d9d9d9; 
				-moz-box-shadow: 0px 0px 8px #d9d9d9; 
				-webkit-box-shadow: 0px 0px 8px #d9d9d9;">	
			<button class="btn btn-primary" type="button" id="full-text-search-button" style="margin-top:-5px;height:30px;">Search</button>
		<!--</form>-->
        
	</div>

<?php } ?>
<?php 
$api_url = ""; 
if(TEST){
	$api_url = "http://devs.remotestaff.com.au/portal/recruiter_search/recruiter_search.php";
}else{
	$api_url = "/portal/recruiter_search/recruiter_search.php";	
    
} 
?>
<input type="hidden" id="api_url" value="<?php echo $api_url ?>"/>

<div style="clear:both;"></div>
<div style="background:url(images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">
<ul>
<?php if ($admin_status=="FULL-CONTROL") {?>

  <li><a href="adminHome.php" <?php echo $class1;?> >Home</a></li>
  <li><a href="/portal/recruiter/recruiter_home.php" <?php echo $class2;?> >Recruitment</a></li>
  <li><a href="leads.php?lead_status=New Leads" <?php echo $class4;?> >New Leads <?php echo $new_lead_marked_flag;?></a></li>
  <li><a href="leads.php?lead_status=Follow-Up" <?php echo $class5;?> >Follow Up <?php echo $follow_up_marked_flag;?></a></li>
  <li><a href="leads.php?lead_status=asl" <?php echo $class12;?> >ASL <?php echo $asl_up_marked_flag;?></a></li>
  <li><a href="leads.php?lead_status=custom recruitment" <?php echo $class11;?> >Custom Recruitment <?php echo $custom_recruitment_marked_flag;?></a></li>
  <li><a href="leads.php?lead_status=Keep In-Touch" <?php echo $class6;?> >Keep in Touch <?php echo $keep_in_touch_marked_flag;?></a></li>
  <li><a href="leads.php?lead_status=pending" <?php echo $class10;?> >Pending <?php echo $pending_marked_flag;?></a></li>
  <li><a href="leads-active.php?lead_status=Client&filter=ACTIVE" <?php echo $class7;?> >Clients <?php echo $client_marked_flag;?></a></li>
  <li><a href="/portal/subcon_management/rssc_reports.html" <?php echo $class8;?> >Sub Contractor Management</a></li>
  <li><a href='subconlist.php' <?php echo $class9;?>>List of Sub Contractors</a></li>
  <li><a href='/portal/ticketmgmt/' <?php echo $class10;?>>Tickets</a></li>


<?php } ?>

<?php if($admin_status=="COMPLIANCE"){ ?>
	<li><a href='adminHome.php' <?php echo $class1;?> >Home</a></li>
	<li><a href='/portal/recruiter/recruiter_home.php' <?php echo $class2;?>>Recruitment</a></li>
	<li><a href="leads-active.php?lead_status=Client&filter=ACTIVE" <?php echo $class7;?> >Clients </a></li>
	<li><a href='/portal/subcon_management/rssc_reports.html' <?php echo $class8;?> >Sub Contractor Management</a></li>
	<li><a href='subconlist.php' <?php echo $class9;?> >List of Sub Contractors</a></li>
<?php } ?>

<?php if($admin_status=="HR"){ ?>
	<li><a>&nbsp;</a></li>
<?php } ?>


<?php if($admin_status=="FINANCE-ACCT"){ ?>
	<li><a href='adminHome.php' <?php echo $class1;?> >Home</a></li>
	<li><a href="leads-active.php?lead_status=Client&filter=ACTIVE" <?php echo $class7;?> >Clients</a></li>
	<li><a href='/portal/subcon_management/rssc_reports.html' <?php echo $class8;?> >Sub-Contractor Management</a></li>
	<li><a href='subconlist.php' <?php echo $class9;?> >List of Sub-Contractors</a></li>
<?php } ?>

<script>
	
	
</script>


</ul>
</div>
</div>


<script type="text/javascript" src="/portal/js/full-text-search-function.js"></script>