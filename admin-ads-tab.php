<?php

switch (basename($_SERVER['SCRIPT_FILENAME']))
{
	
	case "admin_advertise_list.php":
		$adtab1 = "class='selected'";
	break;
	
		
	case "admin_pending_advertise_list.php":
		$adtab2 = "class='selected'";
	break;
	
	case "admin_archive_advertise_list.php":
		$adtab3= "class='selected'";
	break;
	
	case "admin_addadvertisement.php":
		$adtab4 = "class='selected'";
	break;
	
	case "admin_search_advertisement.php":
		$adtab5 = "class='selected'";
	break;
	
	
	
	
}	

?>
<div class="animatedtabs">
<ul>
<li <?php echo $adtab1;?>><a href="admin_advertise_list.php" ><span>Active Job Advetisements</span></a></li>
<li <?php echo $adtab2;?>><a href="admin_pending_advertise_list.php" ><span>New Job Advetisements</span></a></li>
<li <?php echo $adtab3;?>><a href="admin_archive_advertise_list.php" ><span>Archive Job Advetisements</span></a></li>
<li <?php echo $adtab4;?>><a href="admin_addadvertisement.php" ><span>Add Job Advetisements</span></a></li>
<li <?php echo $adtab5;?>><a href="admin_search_advertisement.php" ><span>Search Advetisements</span></a></li>
</ul>
</div>
