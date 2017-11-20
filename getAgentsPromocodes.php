<?php
include './conf/zend_smarty_conf_root.php';
$agent_no = $_REQUEST['agent_no'];
$promocode = $_REQUEST['promocode'];
if($agent_no!=""){
	$sql="SELECT * FROM agent WHERE agent_no = $agent_no;";
	$result = $db->fetchRow($sql);
	$agent_code = $result['agent_code'];
	
	
	//insert the business partner default promo codes  , outboundcall , inboundcall
	$promocodes_Array =  array($agent_code , $agent_code.'OUTBOUNDCALL' , $agent_code.'INBOUNDCALL');
	for($i=0;$i<count($promocodes_Array);$i++){
		$sql = "SELECT * FROM tracking t WHERE tracking_no = '".$promocodes_Array[$i]."' AND tracking_createdby = $agent_no;";
		$result =  $db->fetchAll($sql);
		if(count($result) == 0){
			$data = array(
				'tracking_no' => $promocodes_Array[$i], 
				'tracking_desc' => $promocodes_Array[$i], 
				'tracking_created' => $ATZ, 
				'tracking_createdby' => $agent_no, 
				'status' => 'NEW'
					);
			$db->insert('tracking', $data);	
		}
	}

	
	
	
	
	$query = "SELECT * FROM tracking t WHERE tracking_createdby = $agent_no AND status!='ARCHIVE';";
	$result = $db->fetchAll($query);
	if(count($result) > 0) {
		foreach($result as $row){
			if($promocode == $row['tracking_no']){
				$promocodesOptions.="<option selected value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
			}
			else{
				$promocodesOptions.="<option value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
			}
		}
		//$promocodesOptions.="<option selected value=".$promocode.">".$promocode."</option>";
		if($promocode!=""){
			$promocodesOptions.="<option selected value=".$promocode.">".$promocode."</option>";
		}
	}else{
		if($promocode!=""){
			$promocodesOptions  = "<option value=\"$agent_code\">$agent_code -- Default</option>";
			$promocodesOptions.="<option selected value=".$promocode.">".$promocode."</option>";
		}else{
			$promocodesOptions  = "<option value=\"$agent_code\">$agent_code -- Default</option>";
			$promocodesOptions.="<option value=".$promocode.">".$promocode."</option>";
		}
	}
}
?>

<select name="tracking_no" id="tracking_no" class="select">
<?php echo $promocodesOptions;?>
</select>