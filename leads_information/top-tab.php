<?php

switch (basename($_SERVER['SCRIPT_FILENAME']))
{
	case "leads_information.php":
		$tab1 = "class='selected'";
	break;
	
	case "leads_information2.php":
		$tab1 = "class='selected'";
	break;
	
	case "lead_activity.php":
		$tab2 = "class='selected'";
	break;
	
	case "client_account.php":
		$tab3 = "class='selected'";
	break;
	
	case "jobpostings.php":
		$tab4 = "class='selected'";
	break;
	
	case "recruitment_1.php":
		$tab5 = "class='selected'";
	break;
	
	case "leads_invoice_setting.php":
	    $tab6 = "class='selected'";
		break;
	case "leads_cases.php":
	    $tab7 = "class='selected'";
		break;
}	

?>


<div class="animatedtabs">
<ul>
<li <?php echo $tab1;?>><a href="leads_information.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>Lead</span></a></li>
<li <?php echo $tab3;?>><a href="client_account.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>Contracted Staff Member</span></a></li>
<li <?php echo $tab4;?>><a href="jobpostings.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>Post Job Ad on Website</span></a></li>
<li <?php echo $tab5;?>><a href="recruitment_1.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>Recruitment Progress</span></a></li>
<li <?php echo $tab5;?>><a href="leads_csro_report.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>CSRO Report</span></a></li>
<li <?php echo $tab6;?>><a href="leads_invoice_setting.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>Invoice/ASL Email Recipient Settings</span></a></li>
<li <?php echo $tab7;?>><a href="leads_cases.php?id=<?php echo $_GET['id'];?>&lead_status=<?php echo $_GET['lead_status'];?>&page_type=<?php echo $_REQUEST['page_type'];?>"><span>Cases</span></a></li>
</ul>
</div>
