<?php
include('../conf/zend_smarty_conf.php');
function GetPhoneOrders($leads_id){
		global $db;
	
	if($leads_id != ""){
		//quote
		$query = "SELECT id, created_by, created_by_type, quote_no, status, DATE_FORMAT(date_posted,'%D %b %Y')AS date_posted, ran  FROM quote q WHERE status='posted' AND  leads_id = $leads_id;";
		//echo $query;
		$posted_quotes = $db->fetchAll($query);
		if(count($posted_quotes) > 0){
				$phone_result .="<ol><b>Quotes</b><br>";	
				foreach($posted_quotes as $quote){
					$phone_result .="<li><a href='./pdf_report/quote/?ran=".$quote['ran']."' target='_blank'>Quote #".$quote['quote_no']." Date Sent: ".$quote['date_posted']."</a> -> ".getCreator($quote['created_by'] , $quote['created_by_type'])."</li>";		
				}	
				$phone_result .="</ol><hr>";	
		}
		
		//service_agreement
		$query = "SELECT service_agreement_id, status, DATE_FORMAT(date_posted,'%D %b %Y')AS date_posted , ran , created_by, created_by_type FROM service_agreement WHERE status='posted' AND  leads_id = $leads_id;";
		$posted_service_agreements = $db->fetchAll($query);
		if(count($posted_service_agreements)>0){
			$phone_result .="<ol><b>Service Agreements</b><br>";
				foreach($posted_service_agreements as $service_agreement){
					$phone_result .="<li><a href='./pdf_report/service_agreement/?ran=".$service_agreement['ran']."' target='_blank'>Service Agreement #".$service_agreement['service_agreement_id']." Date Sent: ".$service_agreement['date_posted']." </a> -> ".getCreator($quote['created_by'] , $quote['created_by_type'])."</li>";	
				}
			$phone_result .="</ol><hr>";
		}
		
		//set_up_fee_invoice
		$query="SELECT id,invoice_number,DATE_FORMAT(post_date,'%D %b %Y')AS post_date, ran , drafted_by, drafted_by_type FROM set_up_fee_invoice WHERE status='posted' AND  leads_id = $leads_id;";
		//echo $query;
		$posted_set_up_fee_invoices = $db->fetchAll($query);
		if(count($posted_set_up_fee_invoices)>0){
			$phone_result .="<ol><b>Setup Fee Invoices</b><br>";
			
				foreach($posted_set_up_fee_invoices as $set_up_fee_invoice){
					$phone_result .="<li><a href='./pdf_report/spf/?ran=".$set_up_fee_invoice['ran']."' target='_blank' >Invoice # ".$set_up_fee_invoice['invoice_number']." Date Sent: ".$set_up_fee_invoice['post_date']."</a> -> ".getCreator($set_up_fee_invoice['drafted_by'] , $set_up_fee_invoice['drafted_by_type'])."</li>";	
				}
				
			$phone_result .="</ol><hr>";
		}
		
		
		
		/*
		$query="SELECT job_order_id , DATE_FORMAT(date_created,'%D %b %Y')AS date_posted , ran , created_by_id, created_by_type , form_filled_up , DATE_FORMAT(date_filled_up,'%D %b %Y')AS date_filled_up FROM job_order WHERE  leads_id = $leads_id;";
		
		$posted_job_orders = $db->fetchAll($query);
		if(count($posted_job_orders) > 0){
			$phone_result .="<ol><b>Job Order <em>(old)</em></b><br><br>";
			
				foreach($posted_job_orders as $job_order){
				
					if($job_order['form_filled_up'] == "yes"){
						$check_filled_up = "<img src='images/action_check.gif' align='absmiddle' /> Date filled up: ".$job_order['date_filled_up'];
					}
					
					$phone_result .="<li><a href='./pdf_report/job_order_form/?ran=".$job_order['ran']."' target='_blank' class=''>#".$job_order['job_order_id']." Job Specification Form </a> -> ".getCreator($job_order['created_by_id'] , $job_order['created_by_type'])."<br>Date sent : ".$job_order['date_posted']." ".$check_filled_up."</li>";
					
				}
				
			$phone_result .="</ol>";
		}
		*/
		
		
		
		
		
		
		
		
	}	
	
	return $phone_result;	

}

function MadeBy($id , $table){
    global $db;
    if($table == 'admin'){
	    $sql = $db->select()
		    ->from('admin')
			->where('admin_id =?' , $id);
	    $result = $db->fetchRow($sql);
		return sprintf('Admin %s' , $result['admin_fname']);
	} elseif($table == 'leads') {
	    $sql = $db->select()
		    ->from('leads')
			->where('id =?' , $id);
	    $result = $db->fetchRow($sql);
		return sprintf('Lead %s' , $result['fname']);
	}else{
	    $sql = $db->select()
		    ->from('agent')
			->where('agent_no =?' , $id);
	    $result = $db->fetchRow($sql);
		return sprintf('BP %s' , $result['fname']);
	}
}
function GetJOFilledForms($leads_id){
	global $db;
		
	//Custom Recruitment
	$sql = $db->select()
	    ->from('gs_job_role_selection')
		//->where('created_by_type !=?', 'leads')
		->where('filled_up_visible = 1')
	    ->where('leads_id =?', $leads_id);
	//echo $sql;
	$c_recruitment_orders = $db->fetchAll($sql);
	foreach ($c_recruitment_orders as $c_order){
	    $det = new DateTime($c_order['date_created']);
		$date_sent = $det->format("M. j, Y");
	    //$jo .=sprintf('<div>Custom Recruitment Form <strong># %s</strong> sent by %s on %s</div>' ,$c_order['gs_job_role_selection_id']  ,  MadeBy($c_order['created_by_id'] , $c_order['created_by_type']), $date_sent); 
		$sql = $db->select()
		    ->from('gs_job_titles_details')
			->where('gs_job_role_selection_id =?', $c_order['gs_job_role_selection_id'] );
		$c_recruitment_job_positions = $db->fetchAll($sql);
		$steps_taken.= sprintf("<div>Custom Recruitment Order <strong>#%s</strong>  sent by %s on %s</div>",$c_order['gs_job_role_selection_id'],  MadeBy( ($c_order['created_by_type'] == 'leads' ? $c_order['leads_id'] : $c_order['created_by_id']) , $c_order['created_by_type']), $date_sent);
		if(count($c_recruitment_job_positions) > 0){
		    $steps_taken.= "<div>";
		    $steps_taken.="<ol>";
		    foreach($c_recruitment_job_positions as $position){
		        $steps_taken.=sprintf("<li><a href=javascript:popup_win('get_started/job_spec.php?gs_job_titles_details_id=".$position['gs_job_titles_details_id']."&jr_cat_id=".$position['jr_cat_id']."&jr_list_id=".$position['jr_list_id']."&gs_job_role_selection_id=".$c_order['gs_job_role_selection_id']."',950,600)>%s</a></li>", $position['selected_job_title']);
		    }
		    $steps_taken.="</ol>";
		    $steps_taken.= "</div>";
		}

	}
	//return $steps_taken;
	//return $jo;
	//return $sql;
	
		$query="SELECT job_order_id , DATE_FORMAT(date_created,'%D %b %Y')AS date_posted , ran , created_by_id, created_by_type , form_filled_up , DATE_FORMAT(date_filled_up,'%D %b %Y')AS date_filled_up , response_by_id , response_by_type  FROM job_order WHERE  leads_id = $leads_id;";
		//return $query;
		
		$posted_job_orders = $db->fetchAll($query);
		//return count($posted_job_orders);
		
		if(count($posted_job_orders) > 0){
			//$phone_result .="<ol><b>Job Order <em>(old)</em></b><br><br>";
			$filled_up_by="";
				foreach($posted_job_orders as $job_order){
				
					if($job_order['form_filled_up'] == "yes"){
						$check_filled_up = "<img src='images/action_check.gif' align='absmiddle' />";
						$filled_up_by = "Filled up by: ".getCreator($job_order['response_by_id'] , $job_order['response_by_type'])." ".$job_order['date_filled_up'];
					
					}else{
						$check_filled_up = "";
						$filled_up_by = "";
					}
					$created_by = getCreator($job_order['created_by_id'] , $job_order['created_by_type']);
					//$phone_result .="<li style='font:11px tahoma;'><a href='./pdf_report/job_order_form/?ran=".$job_order['ran']."' target='_blank' class=''>#".$job_order['job_order_id']." Job Specification Form </a>".$check_filled_up." <br>Created by ".getCreator($job_order['created_by_id'] , $job_order['created_by_type'])." Date sent : ".$job_order['date_posted']."<br> ".$filled_up_by."</li>";
					$phone_result = sprintf("<a href='./pdf_report/job_order_form/?ran=%s' target='_blank' >(OLD) Job Specifcation Form #%s</a>%s created by %s sent %s %s",$job_order['ran'],$job_order['job_order_id'], $check_filled_up, $created_by ,$job_order['date_posted'], $filled_up_by);
					
				}
				
			//$phone_result .="</ol>";
		}
		return $steps_taken.$phone_result;
		
}		
?>
