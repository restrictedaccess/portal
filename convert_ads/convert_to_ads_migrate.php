<?php

//MIGRATION SCRIPT FOR SUBCATEGORY TO POSTING DATA

include ("../conf/zend_smarty_conf.php");

//SELECT ALL ACTIVE ADS FROM POSTING TABLE
$active_ads_sql = $db->select()
					 ->from(array('p'=>'posting'),array('id','job_order_id'))
					 ->joinLeft(array('gjtd'=>'gs_job_titles_details'),'p.job_order_id=gjtd.gs_job_titles_details_id',array('sub_category_id'))
					 ->where('p.status="ACTIVE" and date_created < DATE("2015-06-26")'); //DATE CREATED IS SET TO 2015-06-25 - DEPLOYMENT OF CONVERT TO ADS
$active_ads = $db->fetchAll($active_ads_sql);

foreach($active_ads as $active_ad){
	//FILL UP SUB CATEGORY ID AND CHANGE FLAG TO IS_CONVERTED
	$db->update('posting',array('sub_category_id'=>$active_ad['sub_category_id'],'is_converted'=>1),$db->quoteInto('id=?',$active_ad['id']));
	//GS CREDENTIAL FLAG TO IS_UPDATED
	$db->update('gs_job_titles_credentials',array('is_updated'=>1),$db->quoteInto('gs_job_titles_details_id=?',$active_ad['job_order_id']));
	//POSTING REQUIREMENT
	$db->update('posting_requirement',array('is_converted'=>1),$db->quoteInto('posting_id=?',$active_ad['id']));
	//POSTING RESPONSIBILITY
	$db->update('posting_responsibility',array('is_converted'=>1),$db->quoteInto('posting_id=?',$active_ad['id']));
}

/*
//UPDATE POSTING STATUS TO ARCHIVE FROM GS_JOB_TITLE_DETAILS WITH STATUS OF FINISH ONHOLD CANCEL
$regsheet_items_sql = $db->select()
						->from(array('gs_job_titles_details' => 'gjtd'),array('gjtd.gs_job_titles_details_id AS gs_id', 'gjtd.status AS gs_status'))
						->joinLeft(array('posting'=>'p'),'p.job_order_id = gjtd.gs_job_titles_details_id',array('p.id as p_id', 'p.status AS p_status', 'p.job_order_id as p_jo_id'))
						->where("p.id !=  '' AND p.status =  'active' = p.show_status =  'yes' AND gjtd.status IN('finish','cancel','onhold')");
$regsheet_items = $db->fetchAll($regsheet_items_sql);

//UPDATE ALL POSTING STATUS TO ARCHIVE THAT IS POINTED IN GS_JOB_TITLE DETAILS HAVING STATUS WHERE IN('finish','onhold','cancel')
foreach($regsheet_items as $regsheet_item){
	$db->update('posting',array('status'=>'ARCHIVE'),$db->quoteInto('id=?',$regsheet_item['p_id']));
}
*/
