<?php
//start: search asl interview
function search_items($db,$status,$p,$maxp,$max) 
{
	
	$AusDate = date("Y")."-".date("m")."-".date("d");
	$AusTime = date("h:i:s");
	
	$admin_id = $_SESSION['admin_id'];
	$max = $db->fetchRow($db->select()->from(array("sm"=>"staff_mass_mail_logs"), array(new Zend_Db_Expr("MAX(batch) AS batch")))->where("admin_id = ?", $admin_id));
	if ($max){
		$sql = $db->select()->from(array("sm"=>"staff_mass_mail_logs"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS sm.userid"), "sm.date_created", "sm.waiting AS waiting", "sm.finish AS finish", "sm.date_updated AS mass_emailing_date_executed"))
		->joinInner(array("pers"=>"personal"), "pers.userid = sm.userid", array("pers.fname", "pers.lname", "pers.email"))
		->where("sm.batch = ?", $max["batch"])
		->where("sm.admin_id = ?", $admin_id)
		->order("sm.date_updated DESC")
		->limitPage($p, $maxp);
		if ($status=="WAITING"){
			$sql = $sql->where("sm.waiting = 1")->where("sm.finish = 0")->where("DATE(sm.date_updated) = ?", $AusDate);
		}else if ($status=="SENT"){
			$sql = $sql->where("sm.waiting = 1")->where("sm.finish = 1")->where("DATE(sm.date_updated) = ?", $AusDate);
		}
		//echo $sql->__toString();
		
		$results = $db->fetchAll($sql);
		$max = $db->fetchOne('SELECT FOUND_ROWS()');	
		
		foreach($results as $key=>$result){
			$results[$key]['max'] = $max;
			$results[$key]["mass_emailing_status"] = $status;	
		} 
		return $results ;
	}else{
		return array();
	}

}
//ended: search asl interview


//start: asl interview pages
function search_items_linkpage($status,$p,$size,$d) 
{
	if($status == "WAITING") { $javascript_function = "search_waiting_items"; } else { $javascript_function = "search_sent_items"; }
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="javascript: '.$javascript_function.'(\'status='.$status.'&max='.$max.'&p='.($p-1).'\'); "><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="javascript: '.$javascript_function.'(\'status='.$status.'&max='.$max.'&p='.($p + 1).'\'); "><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ended: asl interview pages