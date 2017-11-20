<?php



	$sql = "SELECT l.id , l.description , l.status , DATE_FORMAT(l.invoice_date , '%d %b %Y')AS invoice_date , DATE_FORMAT(p.date , '%d %b %Y')AS date , p.amount , p.currency_id , p.payment_mode_id FROM leads_invoice l LEFT JOIN leads_invoice_payment p ON p.leads_invoice_id = l.id WHERE l.leads_id = $leads_id;";	
	//echo $sql;	
	$orders = $db->fetchAll($sql);	
	if(count($orders) > 0){
			foreach($orders as $order){
					$staff_name_link ="";
					$invoice_id = $order['id'];
					$status = $order['status'];
					$notes = GetAdminBPNotes($invoice_id);
					
					if($status == "paid"){
						$date = $order['date'];//$date_paid;
					}else{
						$date = $order['invoice_date'];
					}
					
					if($status == "cancelled") {
						$status = "didn't clear";
					}
					
					if((strpos($order['description'], 'Recruitment Setup Fee')) !== false) {
			
						if($order['description'] == "Recruitment Setup Fee Payment"){
							$desc = "[ FP ]";
						}
						if($order['description'] == "Recruitment Setup Fee Downpayment"){
							$desc = "[ DP ]";
						}
						
						//id, leads_invoice_id, gs_job_role_selection_id, status, date_created
						$query = $db->select()
								->from('gs_payment_track' , 'gs_job_role_selection_id')
								->where('leads_invoice_id =? ' ,$invoice_id);
						$gs_job_role_selection_id = $db->fetchOne($query);
						
						if($gs_job_role_selection_id !=""){
							//gs_job_titles_details_id, gs_job_role_selection_id, jr_list_id, jr_cat_id, selected_job_title, level, no_of_staff_needed, job_role_no, status, work_status, working_timezone, start_work, finish_work, form_filled_up, date_filled_up
							$query = $db->select()
								->from('gs_job_titles_details')
								->where('gs_job_role_selection_id =? ' ,$gs_job_role_selection_id);
							$items = $db->fetchAll($query);
							
								
				
							$item_desc ="";
							foreach($items as $item){
									//check if the gs_job_role_selection_id is existing in the posting table parse the status of the advertisement
									$sql = $db->select()
										->from('posting')
										->where('job_order_id =?' , $item['gs_job_titles_details_id'] )
										->where('job_order_source =?' , 'rs');
									$ad = $db->fetchRow($sql);
								
									if($item['form_filled_up']=='yes'){
										$img = "<img src='get_started/media/images/check-icon.png' title='Job Specification Form Filled Up'>";
									}else{
										$img ="";
									}
									
									if($ad['status']){
										$position_status = $ad['status'];
									}else{
										$position_status = '-';
									}
									
									$item_desc.="<tr bgcolor='#FFFFFF'>";
									$item_desc.="<td width='64%'>".sprintf("(%s) %s %s level",$item['no_of_staff_needed'] , $item['selected_job_title'] , $item['level']).$img."</td>";
									$item_desc.="<td align='center' width='36%' >".$position_status."</td>";
									$item_desc.="</tr>";
									
								}
							}
						
		
							
							$recruitment_result.="<tr bgcolor='#FFFFFF'>";
							$recruitment_result .="<td align='center' >".$date."<small style='color:#999999;display:block;'>merged order</small></td>";
							$recruitment_result .="<td align='center' ><a href=\"javascript:popup_win('leads_invoice.php?id=".$invoice_id."' , 680 , 480)\">".$invoice_id."</a></td>";
							$recruitment_result .="<td align='center'>".$status."</td>";
							$recruitment_result .="<td colspan='2' ><table width='100%' cellspacing='1' bgcolor='#CCCCCC'>".$item_desc."</table><a href=\"javascript:popup_win('ShowRecruitmentServiceOrder.php?order_id=".$invoice_id."' , 800 , 800)\">View Job Order Form</a></td>";
							$recruitment_result.="</tr>";
						
						
		
		
		
					}//end if
					
			}//end for	
	}//end if



?>