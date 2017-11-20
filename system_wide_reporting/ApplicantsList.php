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
$search_flag = False;


$keyword = $_REQUEST['keyword'];
if($keyword!=""){
	$search_text = $keyword;
	$search_text=ltrim($search_text);
	$search_text=rtrim($search_text);
	
	$kt=explode(" ",$search_text);//Breaking the string to array of words
	// Now let us generate the sql 
	while(list($key,$val)=each($kt)){
		if($val<>" " and strlen($val) > 0){
			
			$queries .= " p.userid like '%$val%' or p.fname like '%$val%' or p.lname like '%$val%' or p.email like '%$val%' or p.alt_email like '%$val%' or p.registered_email like '%$val%' or p.skype_id like '%$val%' or p.address1 like '%$val%' or p.city like '%$val%' or";
		}
	}// end of while
	
	$queries=substr($queries,0,(strlen($queries)-3));
	// this will remove the last or from the string. 
	$keyword_search =  " AND ( ".$queries." ) ";
	
	//$limit = "";
	//$offset =0;
}	






$sql="SELECT * FROM personal p WHERE datecreated IS NOT NULL $keyword_search ORDER BY LTRIM(fname) ASC $limit;";
$staffs = $db->fetchAll($sql);
//echo $sql;exit;
$ctr = $offset;
$counters = array();
foreach($staffs as $staff){
	$ctr++;
	if($bgcolor=="#EEEEEE"){
		$bgcolor="#CCFFCC";
	}else{
		$bgcolor="#EEEEEE";
	}
	
	$date = new DateTime($staff['datecreated']);
	$datecreated = $date->format("F j, Y");
	//<span class="leads_list" page="../application_apply_action.php?userid={$staff.userid}&page_type=popup" >{$staff.staff_fname} {$staff.staff_lname}</span>		
	$staff_list .="<tr bgcolor='$bgcolor'>";
	$staff_list .="<td class='ctr'>".$ctr."</td>";
	$staff_list .="<td>".$staff['userid']."</td>";
	$staff_list .="<td>
	<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id=".$staff['userid']."' style='float:left; margin-right:10px;' />
	<span class='leads_list' page='../application_apply_action.php?userid=".$staff['userid']."&page_type=popup' >".strtolower($staff['fname'])." ". strtolower($staff['lname'])."</span></td>";
	$staff_list .="<td>";
		$staff_list .= $staff['email'];
		if($staff['registered_email']){
			if($staff['registered_email'] != $staff['email']){
				$staff_list .= sprintf('<div>%s</div>' ,$staff['registered_email']);
			}
		}
		if($staff['alt_email']){
			if($staff['alt_email'] != $staff['email']){
				$staff_list .= sprintf('<div>%s</div>' ,$staff['alt_email']);
			}
		}
	$staff_list .="</td>";
	$staff_list .="<td>";
	if($staff['skype_id']){
		$staff_list .= sprintf('<div>%s</div>' ,$staff['skype_id']);
	}
		if($staff['tel_area_code']){
			$staff_list .=sprintf('(%s)' , $staff['tel_area_code']);
		}
		$staff_list .=sprintf('%s' , $staff['tel_no']);
		if($staff['handphone_no']){
			$staff_list .=sprintf('<div>%s</div>' , $staff['handphone_no']);
		}
	$staff_list .="</td>";
	$staff_list .="<td>".$datecreated."</td>";
	$staff_list .="</tr>";
}




//use in paging
$sql="SELECT COUNT(userid)AS count FROM personal p WHERE datecreated IS NOT NULL $keyword_search";
$numrows = $db->fetchOne($sql);
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./".basename($_SERVER['SCRIPT_FILENAME']);
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
	if ($page == $pageNum){
	//	$nav .= " <li><a class='currentpage' href=\"$self?page=$page\">$page</a></li> ";
		if($keyword){
			$nav .="<option selected value='./ApplicantsList.php?page=$page&keyword=$keyword'>$page</option>";
		}else{
			$nav .="<option selected value='./ApplicantsList.php?page=$page'>$page</option>";
		}
	}
	else{
	//	$nav .= " <li><a href=\"$self?page=$page\">$page</a></li> ";
		if($keyword){
			$nav .="<option value='./ApplicantsList.php?page=$page&keyword=$keyword'>$page</option>";
		}else{
			$nav .="<option value='./ApplicantsList.php?page=$page'>$page</option>";
		}
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

$smarty->assign('keyword',$keyword);
$smarty->assign('nav',$nav);
$smarty->assign('row_results',$numrows);
$smarty->assign('paging',$paging);
$smarty->assign('staff_list',$staff_list);
$smarty->display('ApplicantsList.tpl');
?>