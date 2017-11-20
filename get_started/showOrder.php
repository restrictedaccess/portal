<?php
include '../conf/zend_smarty_conf.php';
include 'lib/get_started_function.php';
$smarty = new Smarty();


$order_id =$_REQUEST['order_id'];

//gs_job_role_selection_id, leads_id, ran, date_created, status, no_of_job_role, payment_options_selected, total_price, tax, payment_options_selected_details, payment_status, payment_status_date, currency, proposed_start_date, duration_status, name_on_card, various_card

$sql = $db->select()
	->from(array('i'=>'leads_invoice') , array('id', 'leads_id' ,'date_created', 'currency', 'description', 'status'))
	->joinRight(array('g' => 'gs_payment_track') , 'g.leads_invoice_id = i.id' , array('gs_job_role_selection_id'))
	->joinLeft(array('l' => 'leads') , 'l.id = i.leads_id',array('fname','lname','email'))
	->joinLeft(array('o' => 'gs_job_role_selection') , 'o.gs_job_role_selection_id = g.gs_job_role_selection_id' , array('no_of_job_role' , 'proposed_start_date', 'duration_status'))
	->joinLeft(array('c' => 'currency_lookup') , 'c.id = i.currency' , array('code','sign'))
	->where('i.id = ?', $order_id);
$order = $db->fetchRow($sql);

$invoice_id = $order['id'];
$leads_id = $order['leads_id'];
$date_created = $order['date_created'];
$currency_id = $order['currency'];
$description = $order['description'];
$status = $order['status'];
$gs_job_role_selection_id = $order['gs_job_role_selection_id'];
$fname = $order['fname'];
$lname = $order['lname'];
$email = $order['email'];
$no_of_job_role = $order['no_of_job_role'];
$proposed_start_date = $order['proposed_start_date'];
$duration_status = $order['duration_status'];
$code = $order['code'];
$sign = $order['sign'];


//get selected job titles
$selected_job_titles =  array();
if ($gs_job_role_selection_id!=""){

	//gs_job_titles_details_id, gs_job_role_selection_id, jr_list_id, jr_cat_id, selected_job_title, level, no_of_staff_needed, job_role_no, status, work_status, working_timezone, start_work, finish_work, form_filled_up
	$sql = $db->select()
		 ->from('gs_job_titles_details')
		 ->where('gs_job_role_selection_id = ?', $gs_job_role_selection_id);
	$results = $db->fetchAll($sql);
	foreach($results as $line){
		
			$gs_job_titles_details_id = $line['gs_job_titles_details_id'];
			$jr_cat_id = $line['jr_cat_id'];
			$jr_list_id = $line['jr_list_id'];
			$level = $line['level'];
			$form_filled_up = $line['form_filled_up'];
			$selected_job_title = $line['selected_job_title'];
			$no_of_staff_needed = $line['no_of_staff_needed'];
			$work_status =$line['work_status'];
			$working_timezone = $line['working_timezone'];
			$start_work = $line['start_work'];
			$finish_work = $line['finish_work'];
			
			
			//get the price
			$query = "SELECT * FROM job_role_cat_list WHERE jr_list_id = $jr_list_id;";
			$result = $db->fetchRow($query);
			$selected_job_title_price = "";
			$jr_status = $result['jr_status'];
			
			if($jr_status == "system"){
				if($level == "entry"){
					
					if($work_status == "Full-Time"){
					
						$monthly_price = $result['jr_entry_price'];
						$hourly_price = (((($monthly_price*12)/52)/5)/8);
						
					}else{
					
						$monthly_price = ($result['jr_entry_price']*.55);
						$hourly_price = (((($monthly_price*12)/52)/5)/4);
						
					}
				}
				
				if($level == "mid"){
					if($work_status == "Full-Time"){
					
						$monthly_price = $result['jr_mid_price'];
						$hourly_price = (((($monthly_price*12)/52)/5)/8);
						
					}else{
					
						$monthly_price = ($result['jr_mid_price']*.55);
						$hourly_price = (((($monthly_price*12)/52)/5)/4);
						
					}
				}
				if($level == "expert"){
					if($work_status == "Full-Time"){
					
						$monthly_price = $result['jr_expert_price'];
						$hourly_price = (((($monthly_price*12)/52)/5)/8);
						
					}else{
					
						$monthly_price = ($result['jr_expert_price']*.55);
						$hourly_price = (((($monthly_price*12)/52)/5)/4);
						
					}
				}
				
				$prices = sprintf("<b>%s%s %s Hourly</b> / %s%s Monthly",$code,$sign,formatPrice($hourly_price),$sign,formatPrice($monthly_price));
			}
		
			//display code here
			if($working_timezone!= "localtime"){
				$working_time = setConvertTimezones($working_timezone, $working_timezone , $start_work, $finish_work);
			}
			$data = array(
							'gs_job_titles_details_id' => $gs_job_titles_details_id , 
							'jr_cat_id'=> $jr_cat_id,
							'jr_list_id' => $jr_list_id,
							'level' => $level ,
							'form_filled_up' => $form_filled_up,
							'selected_job_title' => $selected_job_title,
							'no_of_staff_needed' => $no_of_staff_needed,
							'work_status' => $work_status ,
							'working_timezone' => $working_timezone,
							'start_work' => $start_work,
							'finish_work' => $finish_work,
							'prices' => $prices,
							'working_time' => $working_time
						 );
			array_push($selected_job_titles, $data);
			

	}
	

	//grab the leads_invoice
	$sql = $db->select()
			->from('leads_invoice')
			->join('leads', 'leads_invoice.leads_id = leads.id', Array('leads_id'=> 'id', 'fname', 'lname', 'email'))
			->join('currency_lookup', 'leads_invoice.currency = currency_lookup.id', Array('code', 'sign'))
			->where('leads_invoice.id = ?', $invoice_id);
	$leads_invoice = $db->fetchRow($sql);
	
	//grab the invoice items
	$sql = $db->select()
			->from('leads_invoice_item')
			->join('products', 'leads_invoice_item.product_id = products.id', Array('code', 'name'))
			->where('leads_invoice_item.leads_invoice_id = ?', $invoice_id);
	$leads_invoice_items = $db->fetchAll($sql);
	
	//get subtotal
	$subtotal = 0;
	$sum_qty = 0;
	foreach ($leads_invoice_items as $item) {
		$subtotal += $item['qty'] * $item['unit_price'];
		$sum_qty += $item['qty'];
	}
	
	//get other charges
	$sql = $db->select()
			->from('leads_invoice_other_charges')
			->where('leads_invoice_id = ?', $invoice_id);
	$other_charges = $db->fetchAll($sql);
	
	$other_charges_2 = Array();
	$total = $subtotal;
	foreach($other_charges as $charge) {
		if ($charge['type'] == 'variable') {
			$charge['amount'] = $charge['rate'] * 0.01 * $subtotal;
		}
		$other_charges_2[] = $charge;
		$total += $charge['amount'];
	}
	
	
	
}


//get the notes/comments
function getName($created_by_id, $created_by_type){
	global $db;
	
	if($created_by_id != ""){
			if($created_by_type == 'admin'){
				$sql = $db->select()
					->from('admin' , 'admin_fname')
					->where('admin_id = ?' , $created_by_id);
				$name = $db->fetchOne($sql);	
				return 'Admin '.$name;
			}
			
			else if($created_by_type == 'bp'){
				$sql = $db->select()
					->from('agent' , 'fname')
					->where('agent_no = ?' , $created_by_id);
				$name = $db->fetchOne($sql);	
				return 'BP '.$name;
			}
			
			else if($created_by_type == 'leads'){
				$sql = $db->select()
					->from('leads' , 'fname')
					->where('id = ?' , $created_by_id);
				$name = $db->fetchOne($sql);	
				return 'Lead '.$name;
			}
			
			else{
				return 'Anonymous';
			}
	}
}

$sql = $db->select()
	->from('gs_admin_notes')
	->where('invoice_id = ?' , $invoice_id)
	->where('gs_job_role_selection_id = ?' , $gs_job_role_selection_id);
//echo $sql;	
$notes = $db->fetchAll($sql);
$messages = array();
foreach($notes as $note){
	$data = array('name' => getName($note['created_by_id'] , $note['created_by_type']) , 'notes' => $note['notes'] , 'date_created' => $note['date_created']);
	array_push($messages ,$data);
}

$smarty->assign("messages", $messages);
$smarty->assign("leads_invoice", $leads_invoice);
$smarty->assign("leads_invoice_items", $leads_invoice_items);
$smarty->assign("sum_qty", $sum_qty);
$smarty->assign("subtotal", $subtotal);
$smarty->assign("other_charges", $other_charges_2);
$smarty->assign("total", $total);

$smarty->assign('recruitment_result', $recruitment_result);	
$smarty->assign('invoice_id',$invoice_id);
$smarty->assign('leads_id',$leads_id);
$smarty->assign('gs_job_role_selection_id',$gs_job_role_selection_id);
$smarty->assign('selected_job_titles',$selected_job_titles);
$smarty->assign('date_created',$date_created);
$smarty->assign('description',$description);
$smarty->assign('status',$status);
$smarty->assign('fname',$fname);
$smarty->assign('lname',$lname);
$smarty->assign('email',$email);

$smarty->assign('no_of_job_role',$no_of_job_role);
$smarty->assign('proposed_start_date',$proposed_start_date);
$smarty->assign('duration_status',$duration_status);


$smarty->assign('code',$code);
$smarty->assign('sign',$sign);

$smarty->assign('order_id',$order_id);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");

$smarty->display('showOrder.tpl');


?>