<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}

//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = $_REQUEST['rowsPerPage'];
//echo $rowsPerPage;

if($rowsPerPage == ""){
	$rowsPerPage = 50;
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


$sql="SELECT r.userid, p.fname, p.lname, p.email, r.date_created FROM resume_creation_history r JOIN personal p ON p.userid=r.userid ORDER BY p.fname ASC $limit;";
$applicants = $db_query_only->fetchAll($sql);

$ctr = $offset;
foreach($applicants as $applicant){
	$ctr=$ctr + 1;
	$data[]=array(
		'counter' => $ctr,
		'userid' => $applicant['userid'],
		'fname' => $applicant['fname'],
		'lname' => $applicant['lname'],
		'email' => $applicant['email'],
		'date_created' => $applicant['date_created']
	);
}




//use in paging
$sql="SELECT count(id)AS numrows FROM `resume_creation_history`;";
$numrows = $db->fetchOne($sql);
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./".basename($_SERVER['SCRIPT_FILENAME']);
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
	if ($page == $pageNum){
		$nav .= " <li><a class='currentpage' href=\"$self?page=$page\">$page</a></li> ";	
	}else{
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
//echo "<pre>";
//print_r($applicants);
//echo "</pre>";
$smarty->assign('row_results',$numrows);
$smarty->assign('paging',$paging);
$smarty->assign('applicants' , $data);
$smarty->display('total_no_of_resume_from_admin.tpl');
?>