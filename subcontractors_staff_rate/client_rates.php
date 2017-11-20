<?php
include('../conf/zend_smarty_conf.php');
include './show_subcon_staff_rates.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);


//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = $_REQUEST['rowsPerPage'];
//echo $rowsPerPage;

if($rowsPerPage == ""){
	$rowsPerPage = 100;
}
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset
//echo $pageNum ;

$offset = 0;
if($pageNum!=NULL){
	$offset = ($pageNum - 1) * $rowsPerPage;
	//echo "offset2 ( ".$offset2." )<br>";
}


$limit = " LIMIT $offset, $rowsPerPage ";
$conditions = "";
if($_REQUEST['sid']){
	$conditions .=" AND s.id=".$_REQUEST['sid']." ";
}


if($conditions != ""){
	$limit="";
}
//use in paging
//get all active subcon
$sql = "SELECT COUNT(id)AS numrows FROM subcontractors s  WHERE s.status IN ('ACTIVE', 'suspended', 'terminated', 'resigned') $conditions;";
$numrows = $db->fetchOne($sql);
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./".basename($_SERVER['SCRIPT_FILENAME']);
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
	if ($page == $pageNum)
	{
		$nav .= " <li><a class='currentpage' href=\"$self?page=$page\">$page</a></li> ";
	}
	else
	{
		$nav .= " <li><a href=\"$self?page=$page\">$page</a></li> ";
	}
}

if ($pageNum > 1){

	$page = $pageNum - 1;
	$prev = " <li><a href=\"$self?page=$page\">Prev</a></li> ";
	$first = "<li><a href=\"$self?page=1\">First Page</a></li>";
	
}
else{

	$prev  = '&nbsp;'; // we're on page one, don't print previous link
	$first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage){

	$page = $pageNum + 1;
	$next = " <li><a href=\"$self?page=$page\">Next</a></li>";
	$last = " <li><a href=\"$self?page=$maxPage\">Last Page</a></li> ";
}else{

	$next = '&nbsp;'; // we're on the last page, don't print next link
	$last = '&nbsp;'; // nor the last page link
}
//echo $first . $prev . $nav. $next . $last;
$paging =  $first . $prev . $next . $last;

$SUBCON_IDS=array();


if(isset($_POST['submit'])){
	echo "<ol>";
	for ($i = 0; $i < count($_POST['subconid']); ++$i){
	    
		$db->delete('subcontractors_client_rate', 'subcontractors_id='.$_POST['subconid'][$i]);
		$rates = show_subcon_client_rates($_POST['subconid'][$i]);
		//echo "<pre>";
		//print_r($rates);
		//echo "</pre><hr>";
			
		for ($j = 0; $j < count($rates); $j++){
			$data=array(
				'subcontractors_id' => $_POST['subconid'][$i],
				'start_date' => $rates[$j]['start_date'],
				'end_date' => $rates[($j+1)]['start_date'],
				'rate' => $rates[$j]['rate'],
				'work_status' => $rates[$j]['work_status'] 
			);
			$db->insert('subcontractors_client_rate', $data);
			//echo "<pre>";
		    //print_r($data);
		    //echo "</pre>";
		}
		
		$SUBCON_IDS[] = $_POST['subconid'][$i];
		echo sprintf('<li>%s => updated</li>', $_POST['subconid'][$i]);
    }
	echo "<ol>";
	
}
				





//echo "<pre>";
//print_r($SUBCON_IDS);
//echo "</pre>";
$sql = "SELECT * FROM subcontractors s WHERE s.status IN ('ACTIVE', 'suspended', 'terminated', 'resigned') $conditions $limit;";
//echo $query;
$subcons = $db->fetchAll($sql);
$counter = $offset;
$SUBCONS=array();
foreach($subcons as $subcon){
	
	$sql = $db->select()
	    ->from('personal', Array('fname', 'lname'))
	    ->where('userid =?', $subcon['userid']);
	$personal = $db->fetchRow($sql);
	
	$sql = $db->select()
	    ->from('leads', Array('fname', 'lname'))
	    ->where('id =?', $subcon['leads_id']);
	$lead = $db->fetchRow($sql);
	
	
	$data=array(
		'subcon' => $subcon,		
		'personal' => $personal,
		'lead' => $lead,
	);
	
	
	
	$data['client_rates'] = show_subcon_client_rates($subcon['id']);
	
	if(in_array($subcon['id'], $SUBCON_IDS)){
	    $data['executed'] = true;	
	}
	$SUBCONS[]=$data;
}

//echo "<pre>";
//print_r($SUBCONS);
//echo "</pre>";
$smarty->assign('rowsPerPage',$rowsPerPage);
$smarty->assign('pageNum', $pageNum);
$smarty->assign('maxPage', $maxPage);
$smarty->assign('offset', $offset + 1);
$smarty->assign('numrows',$numrows);
$smarty->assign('paging',$paging);
$smarty->assign('SUBCONS', $SUBCONS);
$smarty->assign('title', 'Subcontractors Client Rate History');
$smarty->display('subcontractors_client_rate.tpl');
?>