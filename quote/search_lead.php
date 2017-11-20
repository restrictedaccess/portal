<?php
include '../conf/zend_smarty_conf.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$keyword = $_REQUEST['str'];
$field = $_REQUEST['search_by'];

//echo sprintf('%s => %s<br>', $keyword, $field);

if($field == 'keyword'){
    $search_text = $keyword;
	$search_text=ltrim($search_text);
	$search_text=rtrim($search_text);
	
	$kt=explode(" ",$search_text);//Breaking the string to array of words
	// Now let us generate the sql 
	while(list($key,$val)=each($kt)){
		if($val<>" " and strlen($val) > 0){
			
			$queries .= " l.id like '%$val%' or l.fname like '%$val%' or l.lname like '%$val%' or l.email like '%$val%' or l.company_position like '%$val%' or l.company_name like '%$val%' or l.company_address like '%$val%' or l.officenumber like '%$val%' or l.mobile like '%$val%' or l.sec_fname like '%$val%' or l.sec_lname like '%$val%' or l.sec_email like '%$val%' or l.sec_phone like '%$val%' or l.sec_position like '%$val%' or l.acct_dept_name1 like '%$val%' or l.acct_dept_email1 like '%$val%' or l.acct_dept_name2 like '%$val%' or l.acct_dept_email2 like '%$val%' or l.supervisor_staff_name like '%$val%' or l.supervisor_email like '%$val%' or";
		}
	}// end of while
	
	
	
	
	
	
	$queries=substr($queries,0,(strlen($queries)-3));
	// this will remove the last or from the string. 
	$keyword_search =  " ( ".$queries." ) ";
	
}else{
    
	$keyword_search =  $field." = '".$keyword."';";
}

$sql = "SELECT * FROM leads l WHERE $keyword_search";
$leads = $db->fetchAll($sql);
$smarty->assign('leads', $leads);
$smarty->display('search_lead.tpl');
exit;
?>