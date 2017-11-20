<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

if($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==NULL){

		//'open','past-due','paid','cancelled'
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status' , 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'open');
		$open_orders = $db->fetchAll($sql);	
		
		
		
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'paid');
		$paid_orders = $db->fetchAll($sql);	
		
		
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'past-due');
		$past_due_orders = $db->fetchAll($sql);	
		
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'cancelled');
		$cancelled_orders = $db->fetchAll($sql);	
		
		//incomplete orders
		//gs_job_role_selection_id, leads_id, ran, date_created, status, no_of_job_role, payment_options_selected, total_price, tax, payment_options_selected_details, payment_status, payment_status_date, currency, proposed_start_date, duration_status, name_on_card, various_card
		$sql = $db->select()
			->from(array('g' => 'gs_job_role_selection'), array('gs_job_role_selection_id','leads_id' ,'date_created'))
			->join(array('l' => 'leads'), 'l.id = g.leads_id', array('fname' ,'lname','email'));
		$result = $db->fetchAll($sql);
		$incomplete_orders = array();
		foreach($result as $jo){
			//id, leads_invoice_id, gs_job_role_selection_id, status, date_created
			$query = $db->select()
				->from('gs_payment_track')
				->where('gs_job_role_selection_id =?',$jo['gs_job_role_selection_id']);
			$checks = $db->fetchAll($query);	
			if(count($checks) >0){
				//gs_job_role_selection_id is existing and reach to the checkout system
			}else{
				$data = array('gs_job_role_selection_id' => $jo['gs_job_role_selection_id'] , 'leads_id' => $jo['leads_id'] , 'date_created' => $jo['date_created'] , 'fname' => $jo['fname'], 'lname' => $jo['lname'] , 'email' => $jo['email']);
				array_push($incomplete_orders, $data);
			}
				
		}	
		
		

}else{
	
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'open')
			->where('l.business_partner_id = ?' , $_SESSION['agent_no']);
		$open_orders = $db->fetchAll($sql);	
		
		
		
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'paid')
			->where('l.business_partner_id = ?' , $_SESSION['agent_no']);
		$paid_orders = $db->fetchAll($sql);	
		
		
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'past-due')
			->where('l.business_partner_id = ?' , $_SESSION['agent_no']);
		$past_due_orders = $db->fetchAll($sql);	
		
		
		$sql = $db->select()
			->from(array('i'=>'leads_invoice') , array('id', 'date_created', 'currency', 'description', 'status', 'leads_id'))
			->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('leads_invoice_id'))
			->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname'))
			->where('i.status = ?', 'cancelled')
			->where('l.business_partner_id = ?' , $_SESSION['agent_no']);
		$cancelled_orders = $db->fetchAll($sql);
		
		//incomplete orders
		//gs_job_role_selection_id, leads_id, ran, date_created, status, no_of_job_role, payment_options_selected, total_price, tax, payment_options_selected_details, payment_status, payment_status_date, currency, proposed_start_date, duration_status, name_on_card, various_card
		$sql = $db->select()
			->from(array('g' => 'gs_job_role_selection'), array('gs_job_role_selection_id','leads_id' ,'date_created'))
			->join(array('l' => 'leads'), 'l.id = g.leads_id', array('fname' ,'lname','email'))
			->where('l.business_partner_id = ?' , $_SESSION['agent_no']);
		$result = $db->fetchAll($sql);
		$incomplete_orders = array();
		foreach($result as $jo){
			//id, leads_invoice_id, gs_job_role_selection_id, status, date_created
			$query = $db->select()
				->from('gs_payment_track')
				->where('gs_job_role_selection_id =?',$jo['gs_job_role_selection_id']);
			$checks = $db->fetchAll($query);	
			if(count($checks) >0){
				//gs_job_role_selection_id is existing and reach to the checkout system
			}else{
				$data = array('gs_job_role_selection_id' => $jo['gs_job_role_selection_id'] , 'leads_id' => $jo['leads_id'] , 'date_created' => $jo['date_created'] , 'fname' => $jo['fname'], 'lname' => $jo['lname'] , 'email' => $jo['email']);
				array_push($incomplete_orders, $data);
			}
				
		}		

}


$smarty->assign('incomplete_orders',$incomplete_orders);
$smarty->assign('open_orders',$open_orders);
$smarty->assign('paid_orders',$paid_orders);
$smarty->assign('past_due_orders',$past_due_orders);
$smarty->assign('cancelled_orders',$cancelled_orders);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//header('Content-type: text/plain');
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('left_pane.tpl');

?>