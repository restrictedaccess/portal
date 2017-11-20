<?php
include '../conf/zend_smarty_conf.php';
$queryString = trim($_REQUEST['inputString']);

//echo $_SESSION['manager_id'];exit;
if($_SESSION['client_id']){
	
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$_SESSION['client_id']);
	$lead = $db->fetchRow($sql);
	$search_str = " AND leads_id = ".$_SESSION['client_id'];
	
	
}else if($_SESSION['admin_id']){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	$search_str ="";
}else if($_SESSION['manager_id'] != ""){
	
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);
	
	$subcons=array();
	if($manager['view_staff'] == 'specific'){
		$sql = $db->select()
		    ->from('client_managers_specific_staffs')
			->where('client_manager_id=?', $_SESSION['manager_id']);
		//echo $sql;	
		$subcontractors=$db->fetchAll($sql);
		foreach($subcontractors as $subcon){
			array_push($subcons, $subcon['subcontractor_id']);
		}
	}
	$leads_id = $manager['leads_id'];
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$leads_id);
	$lead = $db->fetchRow($sql);
	$search_str = " AND leads_id = ".$leads_id;
	
}else{
	die("Session timeout. Please re-login");
}


if(strlen($queryString) >0) {

	$search_text = $queryString;
	$search_text=ltrim($search_text);
	$search_text=rtrim($search_text);
	
	$kt=explode(" ",$search_text);//Breaking the string to array of words
	// Now let us generate the sql 
	while(list($key,$val)=each($kt)){
		if($val<>" " and strlen($val) > 0){
			
			$queries .= " p.userid like '%$val%' or p.fname like '%$val%' or p.lname like '%$val%' or p.email like '%$val%' or";
		}
	}// end of while
	
	// this will remove the last or from the string. 
	$queries=substr($queries,0,(strlen($queries)-3));
	
	$keyword_search =  " AND ( ".$queries." ) ORDER BY p.fname ASC ";

	
}else{
	$keyword_search =  " ORDER BY p.fname ASC ";
}

$sql = "SELECT DISTINCT(p.userid) , p.fname , p.lname, s.id FROM personal p JOIN subcontractors s ON s.userid = p.userid WHERE s.status = 'ACTIVE' " .$search_str.$keyword_search;
//echo $sql;exit;
$results = $db->fetchAll($sql);
//print_r($results);exit;

if(count($results)) {
	echo '<ul>';
		foreach($results as $result) {
			if($_SESSION['manager_id'] != ""){
			    if($manager['view_staff'] == 'specific'){
					if(in_array($result['id'], $subcons)){
						 echo '<li onClick="fill(\''.addslashes($result['fname']).' '.addslashes($result['lname']).'\'); FillID('.$result['userid'].')"><img src="http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id='.$result['userid'].'" border="0" align="texttop"  /> '.$result['fname'].' '.$result['lname'].'</li>';
					}
				}else if($manager['view_staff'] == 'all'){
					echo '<li onClick="fill(\''.addslashes($result['fname']).' '.addslashes($result['lname']).'\'); FillID('.$result['userid'].')"><img src="http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id='.$result['userid'].'" border="0" align="texttop"  /> '.$result['fname'].' '.$result['lname'].'</li>';
				}else{
					//show nothing
					//echo '<li onClick="fill(\''.addslashes($result['fname']).' '.addslashes($result['lname']).'\'); FillID('.$result['userid'].')"><img src="http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id='.$result['userid'].'" border="0" align="texttop"  /> '.$result['fname'].' '.$result['lname'].'</li>';
				}
				
			}else{
			    echo '<li onClick="fill(\''.addslashes($result['fname']).' '.addslashes($result['lname']).'\'); FillID('.$result['userid'].')"><img src="http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id='.$result['userid'].'" border="0" align="texttop"  /> '.$result['fname'].' '.$result['lname'].'</li>';
			}
		}
	echo '</ul>';
}
?>
