<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}
$leads_id = $_SESSION['client_id'];
//echo $leads_id;

$query="SELECT s.commission_staff_id,c.commission_id,s.userid , CONCAT(p.fname,' ',p.lname),s.commission_staff_status,c.commission_title,c.commission_amount FROM commission_staff s LEFT JOIN commission c ON c.commission_id = s.commission_id LEFT JOIN personal p ON p.userid = s.userid WHERE c.leads_id = $leads_id;";
//echo $query;
$result = mysql_query($query);
if(!$result) die("Error in SQL Script.<br>".$query);
while(list($commission_staff_id,$commission_id,$userid , $staff_name,$commission_staff_status,$commission_title,$commission_amount)=mysql_fetch_array($result))
{
	
	if($commission_staff_status == 'new'){
		$new++;
		
	$commission_staff_status_new.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showComm($commission_id) title='$commission_desc'  >
		<div class='comm_number'>".$new."</div>
		<div class='comm_name'>".$staff_name."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		<div style='clear:both;'></div>		
		</div>";
		
		//$commission_staff_status_new.="<li><a href='javascript:showCommission($commission_id)' title='$commission_desc'>".$commission_title."</a></li>";
	}
	if($commission_staff_status == 'claiming'){
		$claiming++;
$commission_staff_status_claiming.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' title='$commission_desc'  >
		<div class='comm_number'>".$claiming."</div>
		<div class='comm_name' onclick=showComm($commission_id)>".$staff_name."</div>
		<div class='comm_title' title='$commission_title' onclick=showComm($commission_id)>".$commission_title."</div>
		<div class='comm_controls'>
			<input type='button' class='comm_btn' value='Approved' onclick=updateCommissionStaff($commission_staff_id,'approved') />
			<input type='button' class='comm_btn' value='Cancel' onclick=updateCommissionStaff($commission_staff_id,'cancel') />
		</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	if($commission_staff_status == 'approved'){
		$approved++;
$commission_staff_status_approved.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' title='$commission_desc'  >
		<div class='comm_number'>".$approved."</div>
		<div class='comm_name' onclick=showComm($commission_id)>".$staff_name."</div>
		<div class='comm_title' title='$commission_title' onclick=showComm($commission_id)>".$commission_title."</div>
		<div class='comm_controls'>
			<input type='button' class='comm_btn' value='Cancel' onclick=updateCommissionStaff($commission_staff_id,'cancel') />
		</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	if($commission_staff_status == 'paid'){
		$paid++;
	$commission_staff_status_paid.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' onclick=showCommission($commission_id,'$commission_staff_status') title='$commission_desc'  >
		<div class='comm_number'>".$paid."</div>
		<div class='comm_title' title='$commission_title'>".$commission_title."</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	if($commission_staff_status == 'cancel'){
		$cancel++;
$commission_staff_status_cancel.="<div class='comm_list_wrapper' onmouseover='highlight2(this)' onmouseout='unhighlight2(this)' title='$commission_desc'  >
		<div class='comm_number'>".$cancel."</div>
		<div class='comm_name' onclick=showComm($commission_id)>".$staff_name."</div>
		<div class='comm_title' title='$commission_title' onclick=showComm($commission_id)>".$commission_title."</div>
		<div class='comm_controls'>
			<input type='button' class='comm_btn' value='Approved' onclick=updateCommissionStaff($commission_staff_id,'approved') />
		</div>
		<div style='clear:both;'></div>		
		</div>";
	}
	

}
//echo $commission_staff_status_new;
?>

<h2> Staff Commission</h2>
<div id="dropin">here</div>
<div class="comm_holder">
	<div class="comm_section_hdr"><span class="comm_colon">::</span> New</div>
	<? if ($new >0) {?>
	<div class='comm_list_wrapper'>
		<div class='comm_number'><b class="bold">#</b></div>
		<div class='comm_name'><b class="bold">Staff Name</b></div>
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
		<div class='comm_name'><b class="bold">Staff Name</b></div>
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
		<div class='comm_name'><b class="bold">Staff Name</b></div>
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
		<div class='comm_name'><b class="bold">Staff name</b></div>
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
		<div class='comm_name'><b class="bold">Staff Name</b></div>
		<div class='comm_title'><b class="bold">Title</b></div>
		<div style='clear:both;'></div>	
	</div>
	<? } ?>
	<div id="cancel_comm_section" class='comm_section_content'>
	<? echo $commission_staff_status_cancel; ?>

	</div>
</div>

