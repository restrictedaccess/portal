<?
//echo basename($_SERVER['SCRIPT_FILENAME']);
$menu = basename($_SERVER['SCRIPT_FILENAME']);
switch ($menu)
{
	case "affHome.php":
		$class1 = "class='current'";
	break;
	case "affnewleads.php":
		$class2 = "class='current'";
	break;
	case "affcontactedleads.php":
		$class3 = "class='current'";
	break;
	case "affkeep_in_touch_leads.php":
		$class4 = "class='current'";
	break;
	case "affclients.php":
			$class5 = "class='current'";
	break;
	case "affprofile.php":
		$class6 = "class='current'";
	break;
	
	case "affpending_leads.php":
		$class7 = "class='current'";
	break;
	
	
}



?>

<ul class="glossymenu">
 <li <?=$class1;?> ><a href="affHome.php"><b>Home</b></a></li>
  <li <?=$class2;?> ><a href="affnewleads.php"><b>New Leads</b></a></li>
  <li <?=$class3;?> ><a href="affcontactedleads.php"><b>Follow-Up Leads</b></a></li>
  <li <?=$class4;?> ><a href="affkeep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li <?=$class7;?> ><a href="affpending_leads.php"><b>Pending</b></a></li>
  <li <?=$class5;?> ><a href="affclients.php"><b>Clients</b></a></li>
  <li <?=$class6;?> ><a href="affprofile.php"><b>Profile</b></a></li>
</ul>
