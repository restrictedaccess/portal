<?php
$menutab = basename($_SERVER['SCRIPT_FILENAME']);
switch ($menutab)
{
	case "subconlist.php":
		$class1 = 'class="selected"';
	break;
	case "adminaddsubcon.php":
		$class2 = 'class="selected"';
	break;
	case "admin_staff_contract.php":
		$class3 = 'class="selected"';
	break;
	case "inactive_subconlist.php":
		$class4 = 'class="selected"';
	break;
	
	case "scheduled_staff_contract_termination.php":
	    $class5 = 'class="selected"';
	break;
	
	case "suspended_subconlist.php":
	    $class6 = 'class="selected"';
	break;
	
	case "cancellation_dashboard.php":
	    $class7 = 'class="selected"';
	break;
	
	case "new_hires_reporting.php":
	    $class8 = 'class="selected"';
	break;	
}
?>

<div id="path_links">
	<ul>
		<li <?php echo $class1;?>><a href="subconlist.php" title="Active SubContractors List">Active Subcontractors</a></li>
		<li <?php echo $class3;?>><a href="admin_staff_contract.php" title="Sub-Contractors List" target="_blank">Staff Contract Management</a></li>
		<li <?php echo $class4;?>><a href="inactive_subconlist.php" title="Inactive SubContractors List">Inactive Subcontractors</a></li>
		<li <?php echo $class5;?>><a href="scheduled_staff_contract_termination.php" >Scheduled Staff Contract Termination</a></li>
		<li <?php echo $class6;?>><a href="suspended_subconlist.php" >Suspended Staff Contracts</a></li>
        <li <?php echo $class7;?>><a href="cancellation_dashboard.php" >Cancellation Dashboard</a></li>
        <li <?php echo $class8;?>><a href="new_hires_reporting.php" >New Hires Reporting</a></li>
        <li><a href="/portal/django/subcontractors/subconlist_reporting/" target="_blank" >Subconlist Reporting</a></li>
        <li><a href="./subcontractors_updates.php" target="_blank" >Staff Contract Updates Report</a></li>
		<li><a href="/portal/revenue_monitor/" target="_blank" >Revenue Monitoring</a></li>
        <br clear="all" />
	</ul>
</div>