<?php
include('../conf/zend_smarty_conf.php');
if(!$_SESSION['admin_id']){
	header("location:/portal/index.php");
}
//load all job role category
$job_role_categories = $db->fetchAll($db->select()->from(array("jrc"=>"job_role_category")));
foreach($job_role_categories as $key=>$job_role_category){
	$job_role_categories[$key]["job_categories"] = $db->fetchAll($db->select()
						->from(array("jc"=>"job_category"), array("jc.category_name AS category_name", "jc.category_id AS category_id"))
						->joinLeft(array("acc"=>"ad_category_contents"), "acc.category_id = jc.category_id", 
									array("acc.id AS ad_category_id", "acc.url AS ad_category_url",
										  "acc.meta_description AS ad_category_meta_description", "acc.meta_title AS ad_category_meta_title",
										  "acc.meta_keyword AS ad_category_meta_keyword"))
							->where("jc.job_role_category_id = ?", $job_role_category["jr_cat_id"]));	
}


/*									  
foreach($job_categories as $key=>$job_category){
	$job_categories[$key]["job_sub_categories"] = $db->fetchAll($db->select()
																->from(array("jsc"=>"job_sub_category"), array("jsc.sub_category_name", "jsc.sub_category_id"))
																->joinLeft(array("asc"=>"ad_sub_category_contents"), "asc.sub_category_id = jsc.sub_category_id",
																array("asc.id AS ad_sub_category_id", "asc.url AS ad_sub_category_url",
																	  "asc.meta_description AS ad_sub_category_meta_description", "asc.meta_title AS ad_sub_category_meta_title",
																	  "asc.meta_keywords AS ad_sub_category_meta_keyword"))
																->where("jsc.category_id = ?", $job_category["category_id"]));
}
 * 
 */
$smarty = new Smarty();
$smarty->assign("job_categories", $job_role_categories);
$smarty->display("seo.tpl");
									  