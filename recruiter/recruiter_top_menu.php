<?php
include('../conf/zend_smarty_conf.php') ;


/**
 * Injected by Josef balisalisa
 */
$will_redirect_to_new_jobseeker_v2 = 0;
try{

	global $base_api_url;

	global $curl;


	$to_redirect = $curl->get($base_api_url . '/candidates/get-default-resume-settings-value?settings_for=redirect_to_new_jobseeker_v2');
	$to_redirect = json_decode($to_redirect, true);
	$will_redirect = $to_redirect["value"];

	if($will_redirect){
		$will_redirect_to_new_jobseeker_v2 = $will_redirect;
	}
} catch(Exception $e){

}


$menu = basename($_SERVER['SCRIPT_FILENAME']);
$staff_status = $_REQUEST["staff_status"];
switch ($menu)
{
	case "RecruiterHome.php":
		$class1 = "id='homenav'";
		break;
	case "staff_information.php":
		$class10 = "id='homenav'";
		break;
	case "recruiter_staff_manager.php":
		$class8 = "id='homenav'";
		break;
	case "recruiter_test_reports.php":
		$class12 = "id='homenav'";
		break;
	default: 
		switch ($staff_status)
		{
			case "UNPROCESSED":
				$class3 = "id='homenav'";
				break;
			case "PRESCREENED":
				$class4 = "id='homenav'";
				break;
			case "INACTIVE":
				$class5 = "id='homenav'";
				break;				
			case "SHORTLISTED":
				$class6 = "id='homenav'";
				break;
			case "ENDORSED":
				$class7 = "id='homenav'";
				break;
			case "REMOTEREADY":
				$class11 = "id='homenav'";		
				break;
			default:
				$class2 = "id='homenav'";
				break;
		}
}	
?>



<!--<div style="float:right; padding-right:10px;"><a href="admin_profile.php" class="link10" target="_blank" >Administrator Profile</a></div>-->
	<div style = "float:right; padding-right:15px; margin-bottom: 1px; margin-top: 5px;">
		<form action="/portal/recruiter_search/recruiter_search.php" method="GET">
			<input type="text" class="form-control" id="full-text-search" placeholder="Search Candidate, Job Order, Leads" name="q" style="border: 1px solid #c4c4c4; height: 30px; width: 15px; 
				margin-top: 4px;
				width: 275px; 
				font-size: 13px;  
				border-radius: 4px; 
				-moz-border-radius: 4px; 
				-webkit-border-radius: 4px;
				box-shadow: 0px 0px 8px #d9d9d9; 
				-moz-box-shadow: 0px 0px 8px #d9d9d9; 
				-webkit-box-shadow: 0px 0px 8px #d9d9d9;">	
				<button type="submit" id="full-text-search-button" style="margin-top:-5px;height:30px;">Search</button>
		</form>
	</div>
<?php 
$api_url = "";
if(TEST){
	$api_url = "http://test.remotestaff.com.au/portal/recruiter_search/recruiter_search.php";
}else{
	$api_url = "http://remotestaff.com.au/portal/recruiter_search/recruiter_search.php";	
}

?>
<input type="hidden" id="api_url" value="<?php echo $api_url ?>"/>


<script type="text/javascript" src="/portal/js/full-text-search-function.js"></script>
<div style="clear:both;"></div>
<div style="background:url(../images/remote-staff-nav-bg2.jpg); height:40px;">

<div id="glossymenu">
	<ul>
		<li><a href="/portal/recruiter/recruiter_home.php" <?php echo $class1;?> >Home</a></li>
		<?php 
			if($_SESSION['status'] == "FULL-CONTROL")
			{
				echo '<li><a href="../adminHome.php" '.$class9.' >Admin</a></li>';
			} 
		?>
		<!--<li><a href="#" <?php echo $class9;?> >Trial</a></li>-->
		<!--<li><a href="/portal/django/subcontractors/subcons/active" <?php echo $class10;?> >List of Subcon</a></li>-->
		<?php if($will_redirect_to_new_jobseeker_v2): ?>
			<li><a href="/portal/recruiter_v2/#/recruiter/candidates" <?php echo $class5;?> >Candidates</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED" <?php echo $class6;?> >Shortlisted</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=ENDORSED" <?php echo $class7;?> >Endorsed</a></li>
		<?php else: ?>
			<li><a href="/portal/recruiter/recruiter_search.php" <?php echo $class2?>>View All</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=UNPROCESSED" <?php echo $class3;?> >Unprocessed</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=REMOTEREADY" <?php echo $class11;?> >Remote Ready</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=PRESCREENED" <?php echo $class4;?> >Pre-Screened</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=INACTIVE" <?php echo $class5;?> >Inactive</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED" <?php echo $class6;?> >Shortlisted</a></li>
			<li><a href="/portal/recruiter/recruiter_search.php?staff_status=ENDORSED" <?php echo $class7;?> >Endorsed</a></li>
			<li><a href="/portal/recruiter/recruiter_staff_manager.php?on_asl=0" <?php echo $class8;?> >Categorized</a></li>
		<?php endif; ?>


	</ul>
</div>
</div>
<div style="text-align: right;width:100%;margin-bottom:-30px">
	<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:red;text-decoration:none;font-weight:bold;display:inline-block;margin-top:10px;">Guide to Pay Rates</a>
</div>


