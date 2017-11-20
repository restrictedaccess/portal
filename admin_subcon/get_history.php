<?php
include '../conf/zend_smarty_conf.php';

if($_SESSION['admin_id']==""){
	echo json_encode(array("success"=>false, "histories"=> NULL, "msg"=>"Session expires. Please re-login" ));
	exit;
}
$data = json_decode(file_get_contents('php://input'), true);
$subcon_id = $data["Query"]["subcon_id"];


$sql = $db->select()
    ->from('admin', 'view_inhouse_confidential')
	->where('admin_id =?', $_SESSION['admin_id']);
$view_inhouse_confidential = $db->fetchOne($sql);

$sql=$db->select()
    ->from('subcontractors', 'leads_id')
	->where('id =?', $subcon_id);
$leads_id = $db->fetchOne($sql);	

//id, subcontractors_id, date_change, changes, change_by_type, change_by_id, changes_status, note
$sql = "SELECT s.id, DATE_FORMAT(s.date_change, '%D %b %Y %r')AS date_changes , s.changes , s.changes_status ,s.note, s.change_by_type, s.change_by_id FROM subcontractors_history s WHERE subcontractors_id = $subcon_id;";
$resulta = $db->fetchAll($sql);
$histories = array();
foreach($resulta as $result){
	//echo sprintf('%s<hr>', $result['changes']);
	$changes = explode('<br>', $result['changes']);
	$str = array();
	foreach($changes as $change){
		if($change != ""){
			//word salary
			if(stristr($change, 'salary')) {
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
			}else if(stristr($change, 'php_monthly')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
			}else if(stristr($change, 'php_hourly')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
				
			}else if(stristr($change, 'CLIENT QUOTED PRICE')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
				
			}else if(stristr($change, 'CLIENT HOURLY RATE')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;	
            }else if(stristr($change, 'Staff Hourly Rate')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
                        }else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;	
				
			}else{
			    $str[] = $change;
			}
			
			
		}
	}
	//echo "<pre>";
	//print_r($changes);
	//echo "</pre>";
	

	if($result['change_by_type'] == 'client'){
		$sql = $db->select()
			->from('leads', Array('fname', 'lname', 'email') )
			->where('id =?', $result['change_by_id']);
		$created_by = $db->fetchRow($sql);
		
	}else if($result['change_by_type'] == 'staff'){
		$sql = $db->select()
			->from('personal', Array('fname', 'lname', 'email') )
			->where('userid =?', $result['change_by_id']);
		$created_by = $db->fetchRow($sql);
		
	}else{
		$sql = $db->select()
			->from('admin', Array('fname' => 'admin_fname', 'lname' => 'admin_lname', 'email' => 'admin_email') )
			->where('admin_id =?', $result['change_by_id']);
		$created_by = $db->fetchRow($sql);
	}
	
	
	$data =array(
	    'id' => $result['id'],		 
		'date_changes' => $result['date_changes'],
		'changes_status' => $result['changes_status'],
		'note' => $result['note'],
		'change_by' => sprintf('%s %s %s', ucfirst($result['change_by_type']), $created_by['fname'], $created_by['lname']),
		'changes' => $str
	);
	
	array_push($histories, $data);
}	
echo json_encode(array("success"=>true, "view_inhouse_confidential"=>$view_inhouse_confidential, "leads_id"=>$leads_id, "histories" => $histories));
?>