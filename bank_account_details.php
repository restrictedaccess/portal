<?php
//2010-01-25    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fixed slashes 
include './conf/zend_smarty_conf_root.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$userid = $_SESSION['userid'];
if($_SESSION['userid']=="")
{
	header("location:index.php");
}
$query="SELECT * FROM personal WHERE userid=$userid";
$personal = $db->fetchRow($query);


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	//echo "<pre>";
	//print_r($_POST);
	
	$str="";
	
	//Sterling
	$data = array(
            'card_number' => $_POST['card_number'],
            'account_holders_name' => $_POST['account_holders_name'],
    );
		
	$sql = $db->select()
			->from('subcon_bank_sterling_bank_of_asia')
			->where('userid = ?', $userid);
	$sterling = $db->fetchRow($sql);
	if($sterling){
		//update
		$difference = array_diff_assoc($data,$sterling);
		if($difference > 0){
			foreach(array_keys($difference) as $array_key){
				$str .= sprintf("modified %s from %s to %s<br>", $array_key, $sterling[$array_key] , $difference[$array_key]);
			}
			//update
			$db->update('subcon_bank_sterling_bank_of_asia', $data, "userid = $userid");
		}
		
	}else{
		 if($_POST['card_number']){
			 foreach(array_keys($data) as $array_key){
				$str .= sprintf("added sterling %s => %s<br>", $array_key, $data[$array_key]);
			 }
			 $data['userid'] = $userid; 
			 $db->insert('subcon_bank_sterling_bank_of_asia', $data);
		 }
	}
	
	//Bank
	$data = array(
		'bank_name' => $_POST['bank_name'],
		'bank_branch' => $_POST['bank_branch'],
		'swift_address' => $_POST['swift_address'],
		'bank_account_number' => $_POST['bank_account_number'],
		'account_holders_name' => $_POST['bank_account_holders_name']
    );
	
	$sql = $db->select()
                ->from('subcon_bank_others')
                ->where('userid = ?', $userid);
    $bank = $db->fetchRow($sql);
	//print_r($bank);
	if($bank){
		//update
		$difference = array_diff_assoc($data,$bank);
		//print_r($difference);
		if($difference > 0){
			foreach(array_keys($difference) as $array_key){
				$str .= sprintf("modified %s from %s to %s<br>", $array_key, $bank[$array_key] , $difference[$array_key]);
			}
			//update
		    $db->update('subcon_bank_others', $data, "userid = $userid");
		}
		
		 
	}else{
		 if($_POST['bank_account_number']){
			 foreach(array_keys($data) as $array_key){
				$str .= sprintf("added %s => %s<br>", $array_key, $data[$array_key]);
			 }
			 $data['userid'] = $userid; 
			 $db->insert('subcon_bank_others', $data);
		 }
	}
	
	//Add History
	if($str){
		$str = sprintf('changes made.<br>%s', $str);
		$data=array(
			'userid' => $_SESSION['userid'], 
			'change_by_id' => $_SESSION['userid'], 
			'change_by_type' => 'staff', 
			'changes' => $str, 
			'date_created' => date('Y-m-d H:i:s')			
		);
		$db->insert('subcon_payment_details_history', $data);
	}
	//echo "</pre>";
	
	echo '<script language="javascript"> alert("Changes has been applied."); </script>';
}


$sql = $db->select()
			->from('subcon_bank_sterling_bank_of_asia')
			->where('userid = ?', $userid);
$sterling = $db->fetchRow($sql);


$sql = $db->select()
			->from('subcon_bank_others')
			->where('userid = ?', $userid);
$bank = $db->fetchRow($sql);


$smarty->assign('personal', $personal);
$smarty->assign('sterling', $sterling);
$smarty->assign('bank', $bank);
$smarty->display('bank_account_details.tpl');
?>