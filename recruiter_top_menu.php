<?php
$menu = basename($_SERVER['SCRIPT_FILENAME']);
$staff_status = $_REQUEST["staff_status"];
switch ($menu)
{
	case "RecruiterHome.php":
		$class1 = "id='homenav'";
		break;
	case "subconlist.php":
		$class10 = "id='homenav'";
		break;
	case "adminaddsubcon.php":
		$class10 = "id='homenav'";
		break;
	case "inactive_subconlist.php":
		$class10 = "id='homenav'";
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
			case "ASL":
				$class8 = "id='homenav'";
				break;
			case "ALL":
				$class11 = "id='homenav'";
				break;				
			default:
				$class2 = "id='homenav'";
				break;
		}
}	
?>

<div style="float:right; padding-right:10px;"><a href="recruiter/admin_profile.php" class="link10">Administrator Profile</a></div>
<div style="clear:both;"></div>
<div style="background:url(images/remote-staff-nav-bg2.jpg); height:40px;">
<div id="glossymenu">
<ul>

  <li><a href="recruiter/RecruiterHome.php" <?php echo $class1;?> >Home</a></li>
  <?php 
  if($_SESSION['status'] == "FULL-CONTROL")
  {
		echo '<li><a href="../adminHome.php" '.$class9.' >Admin</a></li>';
  } 
  ?>
  <li><a href="recruiter/staff.php?staff_status=ALL" <?php echo $class11;?> >View All</a></li>  
  <li><a href="recruiter/staff.php?staff_status=UNPROCESSED" <?php echo $class3;?> >Unprocessed</a></li>
  <li><a href="recruiter/staff.php?staff_status=PRESCREENED" <?php echo $class4;?> >Pre-Screened</a></li>
  <li><a href="recruiter/staff.php?staff_status=INACTIVE" <?php echo $class5;?> >Inactive</a></li>  
  <li><a href="recruiter/staff.php?staff_status=SHORTLISTED" <?php echo $class6;?> >Shortlisted</a></li>
  <li><a href="recruiter/staff.php?staff_status=ENDORSED" <?php echo $class7;?> >Endorsed</a></li>
  <li><a href="recruiter/recruiter_staff_manager.php?staff_status=ASL" <?php echo $class8;?> >ASL</a></li>
  <li><a href="#" <?php echo $class9;?> >Trial</a></li>
  <li><a href="subconlist.php" <?php echo $class10;?> >List of Subcon</a></li>

</ul>
</div>
</div>




