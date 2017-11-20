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

$params = "";
if (isset($_GET["show_letter"])){
	$show_letter = $_GET["show_letter"];
	$params.="&show_letter=".$show_letter;
}else{
	$show_letter = "";
}
if (isset($_GET["keyword"])){
	$keyword = $_GET["keyword"];
	$params.="&keyword=".$keyword;
}else{
	$keyword = "";
}

$rows = 50;
$sql = $db->select()->from("defined_skills", array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS id"), "skill_name", "url"))->order("skill_name")->limitPage($page, $rows);
if ($keyword!=""){
	$sql->where("MATCH(skill_name) AGAINST ('{$keyword}*' IN BOOLEAN MODE)");
}
if ($show_letter!=""){
	$filters = array();
	$filters[] = ".";
	for($i=0;$i<=9;$i++){
		$filters[] = "".$i;
	}
	
	
	if (in_array($show_letter, range("A", "Z"))){
		$sql->where("skill_name LIKE '$show_letter%'");		
	}else if ($show_letter=="*"){
		$items = array();
		foreach($filters as $filter){
			$items[] = "skill_name LIKE '{$filter}%'";
		}
		$sql->where("(".implode(" OR ", $items).")");		
	}
	
}
$definedSkills = $db->fetchAll($sql);
$count = $db->fetchOne("SELECT FOUND_ROWS() AS count");
$max_page = ceil($count/$rows);
$smarty = new Smarty();
$pages = array();
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

//render list of letters
$d = range("A", "Z");
$letters = array();
$letters[] = "All";
$letters[] = "*";
foreach($d as $item){
	$letters[] = $item;
}

$smarty->assign("letters", $letters);
$smarty->assign("defined_skills", $definedSkills);
$smarty->assign("prev_page_disabled", $prev_page_disabled);
$smarty->assign("next_page_disabled", $next_page_disabled);
$smarty->assign("next_page_item", $next_page_item);
$smarty->assign("prev_page_item", $next_page_item);

$smarty->assign("params", $params);
$smarty->assign("keyword", $keyword);
$smarty->assign("show_letter", $show_letter);

$smarty->assign("page", $page);
$smarty->assign("pages", $pages);
$smarty->assign("count", $count);
$smarty->assign("max_page", $max_page);
$smarty->display("seo_skills.tpl");