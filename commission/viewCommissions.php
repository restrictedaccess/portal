<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$leads_id = $_SESSION['client_id'];
$commission_id = $_REQUEST['commission_id'];
//echo $commission_id;

/*
commission_id, leads_id, created_by, created_by_type, commission_title, commission_amount, commission_desc, commission_status, date_created, date_approved, date_cancelled, date_paid, response_by_id, response_by_type
*/
$query = "SELECT commission_title, commission_amount, commission_desc,DATE_FORMAT(date_created,'%D %b %Y') FROM commission WHERE commission_id = $commission_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
list($commission_title, $commission_amount, $commission_desc,  $date_created)=mysql_fetch_array($result);




$queryStaff="SELECT DISTINCT(u.userid), CONCAT(u.fname,' ',u.lname),u.image
FROM personal u
JOIN subcontractors s ON s.userid = u.userid
WHERE s.leads_id = $leads_id AND s.status='ACTIVE' ORDER BY u.fname ASC;";
$result=mysql_query($queryStaff);
if(!$result) die ("Error in Script.<br>".$queryStaff);
$counter = 0;
while(list($userid, $staff_name, $image  )=mysql_fetch_array($result))
{
	$counter++;
	// check if the staff is already  in the commission_staff
	$querySelectedStaff="SELECT * FROM commission_staff WHERE commission_id = $commission_id AND userid = $userid;";
	$data = mysql_query($querySelectedStaff);
	if(mysql_num_rows($data)>0){
	$row=mysql_fetch_array($data);
	if($row['commission_staff_status'] == "claiming"){
		$style=" style='background:#FFFF00;' ";
		$cursor=" onmouseover='highlight3(this)' onmouseout='unhighlight3(this)' ";
		$selected_staff_list .= "<div class='dragableBox' ".$style.$cursor." id='box$counter' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";

	}else if($row['commission_staff_status'] == "approved"){
		$style=" style='background:#00FF00;' ";
		$cursor=" ";
		$approved_staff_list .= "<div class='dragableBox' style='display:none;' ".$style.$cursor." id='box$counter' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";
		$approved_list .= "<div class='dragableBox' ".$style.$cursor." title='Drag and Drop $staff_name' >".$staff_name."</div>";
	}else if($row['commission_staff_status'] == "cancel"){
		$style=" style='background:#FF0000;' ";
		$cursor=" onmouseover='highlight3(this)' onmouseout='unhighlight3(this)' ";
		$selected_staff_list .= "<div class='dragableBox' ".$style.$cursor." id='box$counter' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";

	}else{
		$style="";
		$cursor=" onmouseover='highlight3(this)' onmouseout='unhighlight3(this)' ";
		$selected_staff_list .= "<div class='dragableBox' ".$style.$cursor." id='box$counter' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";

	}
//		$selected_staff_list .= "<div class='dragableBox' ".$style.$cursor." id='box$counter' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";
	}else{
		$staff_list .= "<div class='dragableBox' id='box$counter' onmouseover='highlight(this)' onmouseout='unhighlight(this)' title='Drag and Drop $staff_name' >".$staff_name."<input type='hidden' id='staffbox$counter' value='$userid' /></div>";
	
	}

}


?>
<div style="width:640px;">
<input type="hidden" id="total_no_of_staff" value="<?=$counter;?>" />
<input type="hidden" id="commission_id" value="<?=$commission_id;?>" />
<div style="text-align:right; cursor:pointer; font:bold 7pt verdana; color:#666666;" onClick="show_hide('edit_div')">[ Edit ]</div>
<div id="commission_view_description" >
	<div style="background:#F4F4F4; border:#999999 solid 1px; padding:5px;">
		<table width="100%">
			<tr>
				<td width="15%" valign="top"><b>Title : </b></td>
				<td width="85%" valign="top"><?=$commission_title;?></td>
			</tr>
			<tr>
				<td valign="top"><b>Amount : </b></td>
				<td valign="top"><?=$commission_amount;?></td>
			</tr>
			<tr>
				<td valign="top"><b>Description : </b></td>
				<td valign="top"><?=$commission_desc;?></td>
			</tr>
		
		</table>
		
		<div id="edit_div" style="display:none; background:#E4E4E4; padding:5px; border:#000000 ridge 1px;">
		
		<table width="100%">
			<tr>
				<td width="15%" valign="top"><b>Title : </b></td>
				<td width="85%" valign="top"><input type="text" id="commission_title" name="commission_title" class="select" value="<?=$commission_title;?>" /></td>
			</tr>
			<tr>
				<td valign="top"><b>Amount : </b></td>
				<td valign="top"><input type="text" id="commission_amount" name="commission_amount" class="select" value=<?=$commission_amount;?> style="width:100px;" onKeyUp="doCheck(this.value)" /><span style="color:#666666; margin-left:10px;">Valid Numbers Only</span></td>
			</tr>
			<tr>
				<td valign="top"><b>Description : </b></td>
				<td valign="top"><textarea id="commission_desc" name="commission_desc" class="select" rows="5" style="width:400px;"><?=$commission_desc;?></textarea></td>
			</tr>
		
		</table>
				
			<p>
			<input type="button" value="Update" onClick="javascript:updateCommission(<?=$commission_id?>);" />
			<input type="button" value="Cancel" onClick="show_hide('edit_div')" />
			</p>
		</div>	
	</div>
</div>
<div style="clear:both;"></div>
<div style="color:#999999; margin-bottom:10px; border-bottom:#000000 solid 1px; width:650px;">
<p><span>Date Created :</span><?=$date_created;?></p>
Legend
<div class="legend_wrapper">
	<div class="legend_white">&nbsp;</div>
	<div class="legend_name">New</div>
	<div class="legend_desc">Waiting for the Staff to make a claim</div>
	<div style="clear:both;"></div>
</div>
<div class="legend_wrapper">
	<div class="legend_yellow">&nbsp;</div>
	<div class="legend_name">Pending</div>
	<div class="legend_desc">Waiting for Approval</div>
	<div style="clear:both;"></div>
</div>
<div class="legend_wrapper">
	<div class="legend_green">&nbsp;</div>
	<div class="legend_name">Approved</div>
	<div class="legend_desc">Staff Commission will be included in next Subcon Invoice</div>
	<div style="clear:both;"></div>
</div>

<div class="legend_wrapper">
	<div class="legend_blue">&nbsp;</div>
	<div class="legend_name">Paid</div>
	<div class="legend_desc">The Staff is paid and a commission was given</div>
	<div style="clear:both;"></div>
</div>
<div class="legend_wrapper">
	<div class="legend_red">&nbsp;</div>
	<div class="legend_name">Cancel</div>
	<div class="legend_desc">Commission is either cancelled or disapproved.</div>
	<div style="clear:both;"></div>
</div>
</div>
<div style="clear:both;"></div>
<!-- drag and drop -->
</div>
<div style="width:650px; padding-left:10px:">
<div class="left">
	<div class="hdr">Staff List</div>
	<div id="leftColumn">
		<div id="dropContent"><? echo $staff_list;?></div>	
	</div>
	</div>
	<div id="add_delete_result">Move and Drop Staff to right panel</div>
	<div class="right">
		<div class="hdr">Selected Staff</div>
		<div id="rightColumn">
			<div id="dropBox" >
				<?=$approved_list;?>
				<div id="dropContent2" ><? echo $selected_staff_list.$approved_staff_list;?></div>
			</div>
		
		</div>
	</div>
	<div style="clear:both;"></div>

</div>

