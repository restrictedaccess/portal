<?php
//id, subcontractors_id, subcontractors_status, scheduled_date, date_created, status, added_by_id, reason
$sql = $db->select()
    ->from('subcontractors_scheduled_close_cotract')
	->where('subcontractors_id =?', $subcontractors_id)
	->where('status =?', 'waiting');
$schedule_close_contract = $db->fetchRow($sql);	
if($schedule_close_contract['id']){
    $date = new DateTime($schedule_close_contract['scheduled_date']);
    $end_date_str = $date->format("Y-m-d");
	if($schedule['subcontractors_status'] == 'terminated'){
	    $subcontractors_status = 'termination';
	}else{
	    $subcontractors_status = 'resignation';
	}
	$label =sprintf("<p align='center'>This staff contract is already scheduled for <br>%s on %s.<br>Replace it with a new date ?</p>", $subcontractors_status, $date->format("M d, Y")); 
}else{
    $label ="<p align='center'>Enter staff contract finish date</p>";
}


$sql = "SELECT reason_type FROM reason_type;";
$REASON_TYPE = $db->fetchAll($sql);	
foreach($REASON_TYPE as $type){
	if($schedule_close_contract['reason_type'] == $type['reason_type']){
		$type_Options .="<option value='".$type['reason_type']."' selected>".$type['reason_type']."</option>";
	}else{
		$type_Options .="<option value='".$type['reason_type']."'>".$type['reason_type']."</option>";
	}
}


$sql = "SELECT service_type FROM service_type;";
$SERVICE_TYPE = $db->fetchAll($sql);
foreach($SERVICE_TYPE as $type){
	if($schedule_close_contract['service_type'] == $type['service_type']){
		$service_type_Options .="<option value='".$type['service_type']."' selected>".$type['service_type']."</option>";
	}else{
		$service_type_Options .="<option value='".$type['service_type']."'>".$type['service_type']."</option>";
	}
}


$yesNoArray= array("no","yes");
for($i=0;$i<count($yesNoArray);$i++){
	
	if($schedule_close_contract['replacement_request'] == $yesNoArray[$i]){
		
		$replacement_Options .="<option value='".$yesNoArray[$i]."' selected>".$yesNoArray[$i]."</option>";
	}else{
		$replacement_Options .="<option value='".$yesNoArray[$i]."'>".$yesNoArray[$i]."</option>";
	}
}

$sql = $db->select()
    ->from('subcontractors', 'status')
	->where('id =?', $subcontractors_id);
$status	= $db->fetchOne($sql);
?>
<div id="overlay">
<?php 
if($status == 'ACTIVE' or $status == 'suspended'){
?>
<div id="add_form" style="width:500px;">
<input type="hidden" name="close_contract_status" id="close_contract_status">
<input type="hidden" name="scheduled_close_contract_id" id="scheduled_close_contract_id" value="<?php echo $schedule_close_contract['id'];?>">
<h3>Staff Contract Finish Date</h3>
<?php echo $label;?>
<p><label>Date :</label><input type="text" name="end_date_str" id="end_date_str" value="<?php echo $end_date_str;?>" readonly ></p>
<p><label>Request for Replacement :</label><select id="replacement_request" name="replacement_request"><?php echo $replacement_Options; ?></select></p>
<p><label>Reason Type :</label><select id="reason_type" name="reason_type"><?php echo $type_Options; ?></select></p>
<p><label>&nbsp;</label><input name="button" type="button" id="close_contract_btn" onClick="CloseContract()" value="Close Contract" /><input type="button" onClick="fade('overlay')" value="Close" /></p>		
</div>
  <script>
   Calendar.setup({
            inputField : "end_date_str",
            trigger    : "end_date_str",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(<?php echo $min_date;?>),
            max: parseInt(<?php echo $max_date;?>)

        });
</script>
<?php 
}
?>
</div>