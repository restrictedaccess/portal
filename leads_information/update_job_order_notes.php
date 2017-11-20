<?php

include('../conf/zend_smarty_conf.php');

$smarty = new Smarty;

$leads_id = $_GET['leads_id'];

//JOB ORDERS
$retries = 0;
while(true){
	try{
		if (TEST){
			$mongo = new MongoClient(MONGODB_TEST);
		}else{
			$mongo = new MongoClient(MONGODB_SERVER);
		}

		$database = $mongo->selectDB('prod');
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}
$job_orders = $database->selectCollection('job_orders');
$leads_job_orders = $job_orders->find(array('leads_id'=>intval($leads_id)));


//RECONSTRUCT LEADS JOB ORDERS
$new_leads_job_orders = array();
foreach($leads_job_orders as $key=>$leads_job_order){
	$new_leads_job_orders[]=$leads_job_order['tracking_code'];
}

//JOB ORDER NOTES
$job_order_notes_sql = $db -> select()
						   -> from(array('joc'=>'job_order_comments'), array('id','tracking_code','subject','comment','date_created'))
						   -> joinLeft(array('a'=>'admin'),'joc.admin_id=a.admin_id',array('admin_fname','admin_lname'))
						   -> where('tracking_code IN(?)',$new_leads_job_orders)
						   -> where('deleted=?',0)
						   -> order(array('date_created DESC'));
$job_order_notes = $db->fetchAll($job_order_notes_sql); 

$smarty->assign('job_order_notes',$job_order_notes);
$smarty->assign('leads_job_orders',$new_leads_job_orders);
$job_order_notes_template = $smarty->fetch('job_order_notes.tpl');
echo $job_order_notes_template;
?>
