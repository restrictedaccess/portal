<?php

switch (basename($_SERVER['SCRIPT_FILENAME']))
{
	
	case "adminadvertise_category.php":
		$subtab1 = "class='selected'";
	break;
	
	case "admin_advertise_list.php":
		$subtab2 = "class='selected'";
	break;
	
	case "admin_pending_advertise_list.php":
		$subtab2 = "class='selected'";
	break;
	
	case "admin_archive_advertise_list.php":
		$subtab2= "class='selected'";
	break;
	
	case "admin_addadvertisement.php":
		$subtab2 = "class='selected'";
	break;
	
	case "admin_search_advertisement.php":
		$subtab2 = "class='selected'";
	break;
	
	case "admineditads.php":
		$subtab2 = "class='selected'";
	break;
	
	case "category-management.php":
		$subtab3 = "class='selected'";
	break;
	
	
}	

?>

<div class="subtab">
<ul>
<li <?php echo $subtab1;?> ><a href="adminadvertise_category.php"><span>Recruitment</span></a></li>
<li <?php echo $subtab2;?> ><a href="admin_advertise_list.php"><span>Advertisement Management</span></a></li>
<li <?php echo $subtab3;?> ><a href="category-management.php"><span>Category Management</span></a></li>

</ul>
</div>

