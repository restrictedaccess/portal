<?php
include('../conf/zend_smarty_conf.php') ;
if(!isset($_SESSION['admin_id'])){
	header("location:/portal/index.php");
}
if (isset($_GET["page"])){
	$page = $_GET["page"];
}else{
	$page = 1;
}

$rows = 50;
$sql = $db->select()->from("url_redirects", array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS id"), "category_url", "sub_category_url", "redirects"))->limitPage($page, $rows);
$redirects = $db->fetchAll($sql);
$count = $db->fetchOne("SELECT FOUND_ROWS()");
$max_page = ceil($count/$rows);

if ($page<=1){
	$prev_page_disabled = "disabled";
	$prev_page_item = "";
}else{
	$prev_page_disabled = "";
	$prev_page_item = $page-1;
}
if ($page==$max_page){
	$next_page_disabled = "disabled";
	$next_page_item = "";
}else{
	$next_page_disabled = "";
	$next_page_item = $page+1;	
}

for($i=1;$i<=$max_page;$i++){
	$pages[] = $i;
}

$smarty = new Smarty();
$smarty->assign("redirects", $redirects);
$smarty->assign("pages", $pages);
$smarty->assign("prev_page_disabled", $prev_page_disabled);
$smarty->assign("next_page_disabled", $next_page_disabled);
$smarty->assign("next_page_item", $next_page_item);
$smarty->assign("prev_page_item", $next_page_item);

$smarty->display("url_manager.tpl");
