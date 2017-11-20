<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['userid']=="")
{
	die("Session Expires Please Re-Login!");
}
$userid = $_SESSION['userid'];
$query="SELECT c.commission_id, commission_title, commission_amount, commission_desc , CONCAT(l.fname,' ',l.lname), s.commission_staff_status
FROM commission c
LEFT JOIN commission_staff s ON s.commission_id = c.commission_id
LEFT JOIN leads l ON l.id = c.leads_id
WHERE s.userid = $userid ORDER BY c.date_created DESC;";
//echo $query;
$result = mysql_query($query);
if(!$result) die("Error in SQL Script.<br>".$query);
while(list($commission_id, $commission_title, $commission_amount, $commission_desc , $leads_name, $commission_staff_status)=mysql_fetch_array($result))
{
	
	if($commission_staff_status == 'new'){
		$new++;
		
	$commission_staff_status_new.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showCommission($commission_id,'$commission_staff_status') title='$commission_desc'  >
		<div class='comm_number'>".$new."</div>
		<div class='comm_name'>".$leads_name."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		<div style='clear:both;'></div>		
		</div>";
		
		//$commission_staff_status_new.="<li><a href='javascript:showCommission($commission_id)' title='$commission_desc'>".$commission_title."</a></li>";
	}
	if($commission_staff_status == 'claiming'){
		$claiming++;
$commission_staff_status_claiming.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showCommission($commission_id,'$commission_staff_status') title='$commission_desc'  >
		<div class='comm_number'>".$claiming."</div>
		<div class='comm_name'>".$leads_name."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		
		<div style='clear:both;'></div>		
		</div>";
	}
	if($commission_staff_status == 'approved'){
		$approved++;
$commission_staff_status_approved.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showCommission($commission_id,'$commission_staff_status') title='$commission_desc'  >
		<div class='comm_number'>".$approved."</div>
		<div class='comm_name'>".$leads_name."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	if($commission_staff_status == 'paid'){
		$paid++;
	$commission_staff_status_paid.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showCommission($commission_id,'$commission_staff_status') title='$commission_desc'  >
		<div class='comm_number'>".$paid."</div>
		<div class='comm_name'>".$leads_name."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	if($commission_staff_status == 'cancel'){
		$cancel++;
$commission_staff_status_cancel.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showCommission($commission_id,'$commission_staff_status') title='$commission_desc'  >
		<div class='comm_number'>".$cancel."</div>
		<div class='comm_name'>".$leads_name."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	

}
//echo $commission_staff_status_new;
?>
<h2> Available Commission</h2>
<div id="dropin">Loading...</div>
<div class="comm_holder">
	<div class="comm_section_hdr"><span class="comm_colon">::</span> New</div>
	<? if ($new >0) {?>
	<div class='comm_list_wrapper'>
		<div class='comm_number'><b class="bold">#</b></div>
		<div class='comm_name'><b class="bold">Client</b></div>
		<div class='comm_title'><b class="bold">Title</b></div>
		<div style='clear:both;'></div>	
	</div>
	<? } ?>
	<div id="new_comm_section" class='comm_section_content'>
	
	<? echo $commission_staff_status_new; ?>
	
	</div>
	
</div>
<div class="comm_holder">
	<div class="comm_section_hdr"><span class="comm_colon">::</span> Pending Claims</div>
	<? if ($claiming >0) {?>
	<div class='comm_list_wrapper'>
		<div class='comm_number'><b class="bold">#</b></div>
		<div class='comm_name'><b class="bold">Client</b></div>
		<div class='comm_title'><b class="bold">Title</b></div>
		<div style='clear:both;'></div>	
	</div>
	<? } ?>
	<div id="pending_comm_section" class='comm_section_content'>
	<? echo $commission_staff_status_claiming; ?>
	</div>
</div>
<div class="comm_holder">
	<div class="comm_section_hdr"><span class="comm_colon">::</span> Approved Claims</div>
	<? if ($approved >0) {?>
	<div class='comm_list_wrapper'>
		<div class='comm_number'><b class="bold">#</b></div>
		<div class='comm_name'><b class="bold">Client</b></div>
		<div class='comm_title'><b class="bold">Title</b></div>
		<div style='clear:both;'></div>	
	</div>
	<? } ?>
	<div id="approved_comm_section" class='comm_section_content'>
	<? echo $commission_staff_status_approved; ?>
	</div>
</div>
<div class="comm_holder">
	<div class="comm_section_hdr"><span class="comm_colon">::</span> Paid Claims</div>
	<? if ($paid >0) {?>
	<div class='comm_list_wrapper'>
		<div class='comm_number'><b class="bold">#</b></div>
		<div class='comm_name'><b class="bold">Client</b></div>
		<div class='comm_title'><b class="bold">Title</b></div>
		<div style='clear:both;'></div>	
	</div>
	<? } ?>
	<div id="paid_comm_section" class='comm_section_content'>
	<? echo $commission_staff_status_paid; ?>
	</div>
</div>
<div class="comm_holder">
	<div class="comm_section_hdr"><span class="comm_colon">::</span> Cancelled Claims</div>
	<? if ($cancel >0) {?>
	<div class='comm_list_wrapper'>
		<div class='comm_number'><b class="bold">#</b></div>
		<div class='comm_name'><b class="bold">Client</b></div>
		<div class='comm_title'><b class="bold">Title</b></div>
		<div style='clear:both;'></div>	
	</div>
	<? } ?>
	<div id="cancel_comm_section" class='comm_section_content'>
	<? echo $commission_staff_status_cancel; ?>

	</div>
</div>

