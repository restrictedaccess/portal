<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$keyword=$_REQUEST['keyword'];

if($keyword!=""){
    $search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
    # create a MySQL REGEXP for the search: 
    $regexp = "REGEXP '^.*($search).*\$'"; 
    $keyword_search = " WHERE (
		q.quote_no $regexp
		OR UPPER(q.status) $regexp 
		OR UPPER(l.id) $regexp
	    OR UPPER(l.lname) $regexp 
	    OR UPPER(l.fname) $regexp 
		OR UPPER(l.email) $regexp 
	) ";
}				
				
				

$sql = "SELECT q.id , CONCAT(l.fname,' ',l.lname)AS leads_name ,created_by,created_by_type,q.status , q.quote_no FROM quote q LEFT JOIN leads l ON l.id = q.leads_id  $keyword_search   ORDER BY date_quoted DESC;";
$quotes = $db->fetchAll($sql);

$quote_list_new = array();
$quote_list_posted = array();
foreach($quotes as $q){
    $q['creator'] = getCreator($q['created_by'], $q['created_by_type']);
	if($q['status'] == 'new'){
	    array_push($quote_list_new, $q);
	}
	if($q['status'] == 'posted'){
	    array_push($quote_list_posted, $q);
	}	
}

//echo "<pre>";
//print_r($quote_list);
//echo "</pre>";

$smarty->assign('quote_list_new', $quote_list_new);
$smarty->assign('quote_list_posted', $quote_list_posted);
$smarty->display('show_all_quotes.tpl');
?>