<?php
#ROY PEPITO: Asl request interview reporting - 2010-11-25
include('conf/zend_smarty_conf.php');
include ('./leads_information/GetAdminBPNotes.php');
include ('./leads_information/GetPhoneOrders.php');


$leads_id=$_REQUEST['id'];
$merge_order_flag = False;
if(TEST){
	$path='http://test.remotestaff.com.au/portal/recruiter/';
	$resume_path='http://test.remotestaff.com.au/portal/recruiter/';
	//http://test.remotestaff.com.au/portal/recruiter/staff_information.php?userid=28906&page_type=popup
}else{
	//SELECT * FROM leads_location_lookup
	$sql = $db->select()
		->from('leads_location_lookup' ,'location')
		->where('id =?' , LOCATION_ID);
	$location_url = $db->fetchOne($sql);	
	$path="/portal/recruiter/";
	$resume_path="/portal/recruiter/";
}

include("lead_activity_request_interview.php");
	




$sql = "SELECT l.id , l.description , l.status , DATE_FORMAT(l.invoice_date , '%d %b %Y')AS invoice_date , DATE_FORMAT(p.date , '%d %b %Y')AS date , p.amount , p.currency_id , p.payment_mode_id FROM leads_invoice l LEFT JOIN leads_invoice_payment p ON p.leads_invoice_id = l.id WHERE l.leads_id = $leads_id;";	
//echo $sql;	
$orders = $db->fetchAll($sql);	
if(count($orders) > 0){

		$interview_result ="";
		$description = "";
		
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
					//gs_job_titles_details_id, gs_job_role_selection_id, jr_list_id, jr_cat_id, selected_job_title, level, no_of_staff_needed, job_role_no, status, work_status, working_timezone, start_work, finish_work, form_filled_up, date_filled_up, work_weekend, comments, comment_by_id, comment_by_type
					$query = $db->select()
						->from('gs_job_titles_details')
						->where('gs_job_role_selection_id =? ' ,$gs_job_role_selection_id);
					$items = $db->fetchAll($query);
					
						
		
					$item_desc ="";
					foreach($items as $item){
						//$item_desc .= sprintf("<div>(%s) %s %s level</div>",$item['no_of_staff_needed'] , $item['selected_job_title'] , $item['level']);
						//check if the gs_job_role_selection_id is existing in the posting table parse the status of the advertisement
						$sql = $db->select()
							->from('posting')
							->where('job_order_id =?' , $item['gs_job_titles_details_id'] )
							->where('job_order_source =?' , 'rs');
						$ad = $db->fetchRow($sql);
					    //echo $sql;
						if($item['form_filled_up']=='yes'){
							$img = "<img src='get_started/media/images/check-icon.png' title='Job Specification Form Filled Up'>";
						}else{
							$img ="";
						}
						
						if($ad['status']){
						    if($ad['status'] == 'NEW'){
							    $position_status = 'Ad is Up';
							}else{
							    $position_status = $ad['status'];
							}	
						}else{
							$position_status = 'No Ad Up Yet';
						}
						//echo 'comments => '.$item['comments'];
						if($item['comments']){
						    $comments = $item['comments'];
							
						}else{
						    //$item['gs_job_titles_details_id']
						    $comments = "<span class='jo_comments' onclick='SetJoComment(this)' gs_job_titles_details_id='".$item['gs_job_titles_details_id']."' comment='actioned'  >Action</span> | <span class='jo_comments' onclick='SetJoComment(this)' gs_job_titles_details_id='".$item['gs_job_titles_details_id']."' comment='for asl'  >For ASL</span>";
						}
						
						
						$item_desc.="<tr bgcolor='#FFFFFF'>";
						$item_desc.="<td width='45%' >".sprintf("(%s) %s %s level",$item['no_of_staff_needed'] , $item['selected_job_title'] , $item['level']).$img."</td>";
						$item_desc.="<td width='20%' align='center' width='36%' >".$position_status."</td>";
						$item_desc .="<td width='25%' align='center' style='text-transform:capitalize' >".$comments."</td>";
						$item_desc.="</tr>";
						
					}
				}
				
	
				$query = $db->select()
						->from('leads_transactions' , 'id')
						->where('reference_table =?' , 'leads_invoice')	
						->where('reference_no =?' , $invoice_id );
				$id_check = $db->fetchOne($query);
				
				if($id_check){
					$recruitment_result2.="<tr bgcolor='#FFFFFF'>";
					$recruitment_result2 .="<td align='center' ><span style='float:left;'><a href='javascript:MergePerOrder(".$id_check.")';><img src='images/icon-merge.gif' border='0' title='merge' /></a></span> ".$date."</td>";
					$recruitment_result2 .="<td align='center' ><a href=\"javascript:popup_win('leads_invoice.php?id=".$invoice_id."' , 680 , 480)\">".$invoice_id."</a></td>";
					$recruitment_result2 .="<td align='center'>".$status."</td>";
					$recruitment_result2 .="<td colspan='2' ><table width='100%' cellspacing='1' bgcolor='#CCCCCC'>".$item_desc."</table><a href=\"javascript:popup_win('ShowRecruitmentServiceOrder.php?order_id=".$invoice_id."' , 800 , 800)\">View Job Order Form</a></td>";
					$recruitment_result2.="</tr>";

				}/*else{
				
					//check on the leads_merged_info if this order belongs to the current leads_id
					//TODO
					
					
					$recruitment_result.="<tr bgcolor='#FFFFFF'>";
					$recruitment_result .="<td align='center' >".$date."</td>";
					//$recruitment_result .="<td align='center' ><a href=\"javascript:popup_win('leads_invoice.php?id=".$invoice_id."' , 680 , 480)\">".$invoice_id."</a></td>";
					//$recruitment_result .="<td align='center'>".$status."</td>";
					$recruitment_result .="<td ><table width='100%' cellspacing='1' bgcolor='#CCCCCC'>".$item_desc."</table><a href=\"javascript:popup_win('ShowRecruitmentServiceOrder.php?order_id=".$invoice_id."' , 800 , 800)\">View Job Order Form</a></td>";
					$recruitment_result.="</tr>";
				
				}*/	

			}
			
		}

}

//START: get endorsed to client reporting (roy)
$_SESSION['endorsed_arr'] = "";
$query = $db->select()
	->from('tb_endorsement_history')
	->where('client_name =?', $leads_id )
	->order('date_endoesed DESC');
$endorse_candidates = $db->fetchAll($query);
/**
 * Injected By Josef Balisalisa START
 */
while(true){
    try{
        if (TEST){
            $mongo = new MongoClient(MONGODB_TEST);
            $database = $mongo->selectDB('prod');
        }else{
            $mongo = new MongoClient(MONGODB_SERVER);
            $database = $mongo->selectDB('prod');
        }
        $job_orders_collection = $database->selectCollection("job_orders");
        break;
    } catch(Exception $e){
        ++$retries;

        if($retries >= 100){
            break;
        }
    }
}
/**
 * Injected By Josef Balisalisa END
 */

foreach($endorse_candidates as $r)
{

	if ($r["rejected"]==1){
		$style = "style='background-color:#ff0000;color:#fff;'";
		$name = "unreject-endorsement";
		$label = "Unreject";
	}else{
		$style = "style='background-color:#fff;'";
		$name = "reject-endorsement";
		$label = "Reject";
	}
	$temp_counter++;
	$candidate_name = "";
	$job_position_name = "";

	$job_position_name = "";
	$sql=$db->select()
		->from('personal')
		->where('userid = ?', $r["userid"]);
	$n = $db->fetchRow($sql);
	$candidate_name = $n['fname']." ".$n['lname'];;

	$job_position_name = "";
	$sql=$db->select()
		->from('posting')
		->where('id = ?', $r["position"]);
	$pos = $db->fetchRow($sql);
	$job_position_name = $pos['jobposition'];
    /**
     * Injected By Josef Balisalisa
     */
    $current_jo = $job_orders_collection->findOne(
        array(
            "posting_id" => intval($pos["id"])
        ),
        array(
            "tracking_code" => true
        )
    );

	if($job_position_name == "")
	{
		$sql=$db->select()
			->from('job_sub_category')
			->where('sub_category_id = ?', $r["job_category"]);
		$pos = $db->fetchRow($sql);
		$job_position_name = $pos['sub_category_name'];
	}

	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?', $r["admin_id"]);
	$ad = $db->fetchRow($sql);
	$admin_name = $ad['admin_fname']." ".$ad['admin_lname'];

	$endorse_candidates_result .="<tr $style>";
	$endorse_candidates_result .="<td align='center'>".$job_position_name."</td>";
	$endorse_candidates_result .="<td align='center'>".date('F j, Y',strtotime($r["date_endoesed"]))."</td>";
	if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL)
	{
		$endorse_candidates_result .="<td align='center'><a href=\"javascript:popup_win('../../admin-staff-resume.php?userid=".$r["userid"]."' , 700 , 800)\">".$candidate_name."</a></td>";
	}
	else
	{
		$update_path = str_replace('www.','',$path);
		$endorse_candidates_result .="<td align='center'><a href=\"javascript:popup_win('".$update_path."staff_information.php?userid=".$r["userid"]."&page_type=popup' , 700 , 800)\">".$candidate_name."</a></td>";
	}
	$endorse_candidates_result .="<td>".$admin_name."</td>";
	if(strpos(",".$_SESSION['endorsed_arr'],$r["userid"]))
	{
		$endorse_candidates_result .="<td>&nbsp;</td>";
	}
	else
	{
	    $current_tracking_code = "";
	    if(!empty($current_jo)){
	        $current_tracking_code = $current_jo["tracking_code"];
        }
		$endorse_candidates_result .="<td align=center>";
		$endorse_candidates_result .="<input name=\"app_name".$r["userid"]."\" id=\"app_id".$r["userid"]."\" type=\"checkbox\" value=\"\" onchange=\"javascript: order(".$r["userid"].",'" . $current_tracking_code . "');\" ";
		if(strpos(",".$_SESSION['allstaff_request_selected'],$r["userid"])) { $endorse_candidates_result .= "checked"; }
		$endorse_candidates_result .= "/>";
		$endorse_candidates_result .="</td>";
	}
	$endorse_candidates_result .="<td align=center><button class='jo_comments $name' data-id='{$r["id"]}'>$label</button></td>";
	
	$endorse_candidates_result .="</tr>";
	$_SESSION['endorsed_arr'] = $r["userid"].",".$_SESSION['endorsed_arr'];
}



//ENDED: get endorsed to client reporting (roy)


//check if this lead has merged orders from other leads
$sql = $db->select()
	->from('leads_merged_info' , Array('leads_id'))
	->where('merged_to_leads_id =?',$leads_id)
	->group('leads_id');
$merged_leads = $db->fetchAll($sql);
$merge_order_flag = True;
foreach($merged_leads as $merged_lead){
	
	$leads_id = $merged_lead['leads_id'];
	
	include 'leads_merged_recruitment_orders.php';
	include("lead_activity_request_interview.php");
	
}//end for


//START: email sent to lead by admin
$sql = $db->select()
	->from('staff_resume_leads_sent')
	->where('lead_id =?' ,$leads_id);
	
$sents = $db->fetchAll($sql);
if(count($sents) > 0){
	
	foreach($sents as $sent)
	{
		
		//START: get staff name
		$staff_full_name = "";
		$sql=$db->select()
			->from('personal')
			->where('userid = ?', $sent['userid']);
		$ad = $db->fetchRow($sql);
		$staff_full_name = $ad['fname']." ".$ad['lname'];			
		//ENDED: get staff name
		
		//START: get admin name
		$admin_full_name = "";
		if($sent['admin_id'] <> 0 && $sent['admin_id'] <> '')
		{
			$sql=$db->select()
				->from('admin')
				->where('admin_id = ?', $sent['admin_id']);
			$ad = $db->fetchRow($sql);
			$admin_full_name = $ad['admin_fname']." ".$ad['admin_lname'];
		}
		//ENDED: get admin name
		
		//START: get bp name
		$agent_full_name = "";
		if($sent['agent_id'] <> 0 && $sent['agent_id'] <> '')
		{
			$sql=$db->select()
				->from('agent')
				->where('agent_no = ?', $sent['agent_id']);
			$ad = $db->fetchRow($sql);
			$agent_full_name = $ad['fname']." ".$ad['lname'];
		}
		//ENDED: get bp name		
		
		$notes = GetAdminBPNotes2($id);

		if($_SESSION['admin_id']){
			$update_path = str_replace('www.','',$path);
		    $staff_name_link = sprintf("<a href=\"javascript:popup_win('".$update_path."staff_information.php?userid=".$sent['userid']."&page_type=popup' , 700 , 800)\">%s</a>",$staff_full_name );
	    }else{
		    $staff_name_link = sprintf("<a href=\"javascript:popup_win('../admin-staff-resume.php?userid=".$sent['userid']."' , 700 , 800)\">%s</a>",$staff_full_name );
		}
		
		if($admin_full_name <> "")
		{
			$sender = $admin_full_name;
		}
		else
		{
			$sender = $agent_full_name;
		}
		
		$det = new DateTime($sent['date']);
		$date_sent = $det->format("M j, Y");
			
		$admin_agent_sent_result.="<tr bgcolor='#FFFFFF'>";
		$admin_agent_sent_result .="<td width='25%' align='center'>".$sender."</td>";
		$admin_agent_sent_result .="<td width='25%' align='center'>".$staff_name_link."</td>";
		$admin_agent_sent_result .="<td width='25%' align='center'>".$sent['date_added']."</td>";
		$admin_agent_sent_result.="</tr>";	
	}
	
}else{
	$admin_agent_sent_result ="<tr bgcolor='#FFFFFF'><td colspan='4'>No records to be shown</td></tr>";
}
//ENDED: email sent to lead by admin


//START: email sent to lead from home pages
$sql = $db->select()
	->from(array('s' => 'staff_resume_email_sent') , Array('id','applicant_id', 'email', 'date'))
	->joinLeft(array('p' => 'personal') , 'p.userid = s.applicant_id' , Array('fname'))
	->where('leads_id =?' ,$leads_id)
	->where("s.status = 'ACTIVE'");
	
$sents = $db->fetchAll($sql);
if(count($sents) > 0){
	
	foreach($sents as $sent){
	
		$id = $sent['id'];
		$notes = GetAdminBPNotes2($id);

		if($_SESSION['admin_id']){
			$update_path = str_replace('www.','',$path);
		    $staff_name_link = sprintf("<a href=\"javascript:popup_win('".$update_path."staff_information.php?userid=".$sent['applicant_id']."&page_type=popup' , 700 , 800)\">%s</a>",$sent['fname'] );
	    }else{
		    $staff_name_link = sprintf("<a href=\"javascript:popup_win('../admin-staff-resume.php?userid=".$sent['applicant_id']."' , 700 , 800)\">%s</a>",$sent['fname'] );
		}
		$message_link = sprintf("<a href=\"javascript:popup_win('./leads_information/ShowSendResumeMessage.php?id=".$id."' , 550 , 400)\">%s</a>",$sent['email'] );

		
		$det = new DateTime($sent['date']);
		$date_sent = $det->format("M j, Y");
			
		
		$sent_result.="<tr bgcolor='#FFFFFF'>";
		$sent_result .="<td width='25%' align='center'>".$message_link."</td>";
		$sent_result .="<td width='25%' align='center'>".$staff_name_link."</td>";
		$sent_result .="<td width='25%' align='center'>".$date_sent."</td>";
		$sent_result .="<td width='25%' ><div id='sent_note_$id' class='td_note' onclick=\"ShowAddComments2(".$id.")\">".$notes."</div></td>";	
		$sent_result.="</tr>";	
	}
	
}else{
	$sent_result ="<tr bgcolor='#FFFFFF'><td colspan='4'>No records to be shown</td></tr>";
}
//ENDED: email sent to lead from home pages


//PHONE ORDERS
$phone_orders = GetPhoneOrders($_REQUEST['id']);
$jo_filled_forms = GetJOFilledForms($_REQUEST['id']);


//Request to Screen List
$sql="SELECT r.id, r.date_created, i.userid, p.fname, p.lname,  i.sub_category_id, j.sub_category_name FROM remote_ready_orders r
JOIN remote_ready_order_items i ON i.remote_ready_order_id = r.id
JOIN personal p ON p.userid = i.userid
JOIN job_sub_category j ON j.sub_category_id = i.sub_category_id
WHERE remote_ready_lead_id=".$_REQUEST['id']." AND leads_new_info_id IS NULL;";
$request_screen_list = $db->fetchAll($sql);

$smarty->assign('request_screen_list', $request_screen_list);

//added filtering of info 2
//Request to Screen List
$sql="SELECT r.id, r.date_created, i.userid, p.fname, p.lname,  i.sub_category_id, j.sub_category_name FROM remote_ready_orders r
JOIN remote_ready_order_items i ON i.remote_ready_order_id = r.id
JOIN personal p ON p.userid = i.userid
JOIN job_sub_category j ON j.sub_category_id = i.sub_category_id
WHERE remote_ready_lead_id=".$_REQUEST['id']." AND leads_new_info_id IS NOT NULL;";
$request_screen_list2 = $db->fetchAll($sql);

$smarty->assign('request_screen_list2', $request_screen_list2);

$smarty->assign('admin_agent_sent_result',$admin_agent_sent_result);
$smarty->assign('endorse_candidates_result',$endorse_candidates_result);
$smarty->assign('jo_filled_forms',$jo_filled_forms);
//$smarty->assign('recruitment_result',$recruitment_result);
$smarty->assign('recruitment_result2',$recruitment_result2);
$smarty->assign('interview_request',$interview_request);
$smarty->assign('interview_result2',$interview_result2);
$smarty->assign('sent_result',$sent_result);
$smarty->assign('phone_orders',$phone_orders);
?>