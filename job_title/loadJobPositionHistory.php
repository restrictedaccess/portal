<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();


$jr_name = $_REQUEST['jr_name'];
$change_by_type = 'admin';
if($jr_name == 'False') {
	
	
	//parse all histories
	$history_result="<div style='padding:5px;'><b>All</b></div>";
	$sql = "SELECT DATE(date_change)AS date_change  FROM job_role_cat_list_history GROUP BY DATE(date_change) ORDER BY date_change DESC;";
	$dates = $db->fetchAll($sql);			
	if(count($dates)>0) {
		foreach($dates as $date){
			$det = new DateTime($date['date_change']);
			$timestamp = $det->format("F j, Y");
			
			$history_result.=sprintf("<ol><b>%s</b>" ,$timestamp);
			
			$query = $db->select()
				->from(array('j' => 'job_role_cat_list_history'), array('id' , 'history' , 'date_change'))
				->joinleft(array('a' => 'admin') , 'a.admin_id = j.change_by_id' , array('admin_fname' ,'admin_lname'))
				->where('change_by_type = ?' , $change_by_type)
				->where('DATE(date_change) = ? ' , $date['date_change']);
			
			
			$histories = $db->fetchAll($query);
			foreach($histories as $history){
				$history_result.=sprintf("<li>%s<span>- %s %s</span>" , $history['history'] , $history['admin_fname'] , $history['date_change']);
			}
			
			$history_result.="</ol>";
		}
		//echo $history_result;
	}	
}else{

	$sql = $db->select()
		->from('job_role_cat_list')
		->where('jr_name = ?' , $jr_name);
	//echo $sql;	
	$jr_names = $db->fetchAll($sql);
	$history_result.="<ol>";
	foreach($jr_names as $position){
		$jr_list_id = $position['jr_list_id']; 
		//echo $jr_list_id."<br>";
		$sql2 = $db->select()
			->from(array('j' => 'job_role_cat_list_history'), array('id' , 'history' , 'date_change'))
			->joinleft(array('a' => 'admin') , 'a.admin_id = j.change_by_id' , array('admin_fname' ,'admin_lname'))
			->where('change_by_type = ?' , $change_by_type)
			->where('jr_list_id = ?', $jr_list_id);
		//echo $sql2."<br>";	
		$histories = $db->fetchAll($sql2);
		if(count($histories)>0) {
			foreach($histories as $history){
					//echo $history['id']."<br>";
					$history_result.=sprintf("<li>%s<span>- %s %s</span>" , $history['history'] , $history['admin_fname'] , $history['date_change']);
			}
			//echo count($histories)."<br>";
			 //$history_result.="<hr>";
		} 
	}
	//echo $history_result;
	$history_result.="</ol>";
	
			
}		

$smarty->assign('history_result',$history_result);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('loadJobPositionHistory.tpl');

?>
