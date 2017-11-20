<?php
require_once dirname(__FILE__)."/GetJobPosting.php";
require_once dirname(__FILE__)."/MergeOrderProcessor.php";
require_once dirname(__FILE__)."/StaffLister.php";

class JobOrderUtility{
	
	private $db;
	
	private $staffLister;
	public function __construct($db){
		$this->db = $db;
		$this->staffLister = new StaffLister($db);
	}
	
	
	public function getPosting($gs_job_titles_id){
		$db = $this->db;
		$row = $db->fetchRow($db->select()->from(array("p"=>"posting"), array("p.id"))->where("job_order_id = ?", $gs_job_titles_id));
		if ($row){
			return $row["id"];
		}else{
			return null;
		}
	}
	
	private function getStatus($status){
		if (($status=="new")||($status=="active")){
			return "Open";
		}else if ($status=="cancel"){
			return "Did not push through";
		}else if ($status=="finish"){
			return "Closed";
		}else if ($status=="Cancel"){
			return "Did not push through";
		}else if ($status=="onhold"){
			return "On Hold";
		}else if ($status=="ontrial"){
			return "On Trial";
		}else{
			return $status;
		}
	}
	private function getSessionIdForASL($job_sub_cat_id, $date_added, $lead_id){
		$db = $this->db;
		if ($date_added&&$lead_id){
			$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("session_id", "order_id"))
			->where("tbr.job_sub_category_applicants_id = ?", $job_sub_cat_id)
			->where("tbr.leads_id = ?", $lead_id)
			->where("DATE(tbr.date_added) = DATE(?)", $date_added);
				
			$result = $db->fetchAll($sql);
			if (count($result)!=0){
				foreach($result as $session_id){
					if ($session_id["session_id"]!=0){
						return $session_id["session_id"];
					}
					$order =$db->fetchRow($db->select()->from(array("tbro"=>"tb_request_for_interview_orders"), array("session_id"))->where("id = ?", $session_id["order_id"]));
					if ($order["session_id"]!=0){
						return $order["session_id"];
					}
				}

			}else{
				$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("session_id", "order_id"))
				->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
				->where("jsca.sub_category_id = ?",$job_sub_cat_id)
				->where("tbr.leads_id = ?", $lead_id)
				->where("DATE(tbr.date_added) = ?", $date_added);
				$result = $db->fetchRow($sql);
				if ($result){
					return $result["session_id"];
				}else{
					return "";
				}
			}
			return "";
		}else{
			return "";
		}
	}

	private function getSessionIdForCustom($gs_jrs_id){
		$db = $this->db;
		if ($gs_jrs_id){
			try{
				$sql = $db->select()
				->from(array("gs_jrs"=>"gs_job_role_selection"), array("gs_jrs.session_id AS session_id"))
				->where("gs_jrs.gs_job_role_selection_id = ?", $gs_jrs_id);
				$result = $db->fetchRow($sql);
			}catch(Exception $e){
				return "";
			}
			
			return $result["session_id"];
		}else{
			return "";
		}
	}
	
	private function getBudget($jr_list_id, $work_status, $level){
		$db = $this->db;
		if ($jr_list_id){
			$query = $db->select()
			->from('job_role_cat_list')
			->where('jr_list_id = ?' ,$jr_list_id);



			$resulta = $db->fetchRow($query);
			$currency = $resulta['jr_currency'];

			$sql2 = $db->select()
			->from('currency_lookup')
			->where("code = '{$currency}'");
			$money = $db->fetchRow($sql2);
			$currency_lookup_id = $money['id'];
			$currency = $money['code'];
			$currency_symbol = $money['sign'];


			$jr_status = $resulta['jr_status'];
			$jr_list_id = $resulta['jr_list_id'];
			$jr_cat_id = $resulta['jr_cat_id'];

			$jr_entry_price = $resulta['jr_entry_price'];
			$jr_mid_price = $resulta['jr_mid_price'];
			$jr_expert_price = $resulta['jr_expert_price'];

			if($jr_status == "system"){
				if($work_status== "Part-Time"){
					//55% of the original price
					$jr_entry_price = number_format(($jr_entry_price * .55),2,'.',',');
					$jr_mid_price = number_format(($jr_mid_price * .55),2,'.',',');
					$jr_expert_price = number_format(($jr_expert_price * .55),2,'.',',');

					$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/4),2,".",",");
					$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/4),2,".",",");
					$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/4),2,".",",");


					$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
					$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
					$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );

				}else{

					$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/8),2,".",",");
					$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/8),2,".",",");
					$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/8),2,".",",");

					$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
					$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
					$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );


				}
			}else{
				$entry_price_str = "-";
				$mid_price_str = "-";
				$expert_price_str = "-";
			}



			if($level == "entry"){
				$amount_str = $entry_price_str;
			}else if($level == "mid"){
				$amount_str = $mid_price_str;
			}else{
				$amount_str = $expert_price_str;
			}

			return $amount_str;
		}else{
			return "";
		}
	}

	public function getNotes($gs_job_role_selection_id, $minimized=true){
		$db = $this->db;
		if ($gs_job_role_selection_id){
			$sql = $db->select()->from(array("gs_notes"=>"gs_admin_notes"), array("gs_notes.notes AS notes"))
			->where("gs_notes.gs_job_role_selection_id = ?", $gs_job_role_selection_id);
			$notes = $db->fetchAll($sql);
			return $notes;
		}else{
			return array();
		}
	}
	
	public function getNotesForMergeOrder($merge_order_id, $minimized=true){
		$db = $this->db;
		//load all merge order which are custom based orders
		$orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"))->where("moi.merged_order_id = ?", $merge_order_id));
		//load all notes recursively
		$multiNotes = array();
		$count = 0;
		if (!empty($orders)){
			foreach($orders as $order){
				if (!is_null($order["gs_job_title_details_id"])){
					//get job role selection id
					$role = $db->fetchRow($db->select()->from("gs_job_titles_details", array("gs_job_role_selection_id"))->where("gs_job_titles_details_id = ?", $order["gs_job_title_details_id"]));
					if ($role){
						$sql = $db->select()->from(array("gs_notes"=>"gs_admin_notes"), array("gs_notes.notes AS notes"))
						->where("gs_notes.gs_job_role_selection_id = ?", $role["gs_job_role_selection_id"]);
						$notes = $db->fetchAll($sql);
						$item = "";
						if (!empty($notes)){
							foreach($notes as $note){
								$multiNotes[] = $note;
								$count++;
							}
						}
					}			
				}

			}
		}
		return $multiNotes;
	}
	
	public function getLastContact($lead_id, $hiring_coordinator_id){
		if ($lead_id&&$hiring_coordinator_id){
			$db = $this->db;
			$history = $db->fetchRow($db->select()->from("history", array(new Zend_Db_Expr("DATE(date_created) AS last_contact")))->where("agent_no = ?", $hiring_coordinator_id)->where("leads_id = ?", $lead_id)->order("date_created DESC"));
			if ($history){
				return $history["last_contact"];
			}else{
				return "No Last Contact";
			}			
		}else{
			return "No Last Contact";
		}

	}

	public function getCategory($posting_id){
		$db = $this->db;
		if ($posting_id){
			$ad = $db->fetchRow($db->select()->from(array("p"=>"posting"))->where("id = ?", $posting_id));
			
			/*
			$sql = $db->select()
			->from(array('s' => 'job_category') , Array('category_name'))
			->join(array('c' => 'job_role_category') , 's.job_role_category_id = c.jr_cat_id' , Array('cat_name'))
			->where('category_id =?' , $ad['category_id']);
			
			$category = $db->fetchRow($sql);
			return $category["category_name"];
			*/
			$sub_category_name_sql = $db->select()
										->from('job_sub_category','sub_category_name')
										->where('sub_category_id',$ad['sub_category_id']);
			$sub_category_name = $db->fetchOne($sub_category_name_sql);
			return $sub_category_name;
		}else{
			return "";
		}	
		
	}
	
	public function getJobOrderCommentsCount($tracking_code){
		$db = $this->db;
		return $db->fetchOne("SELECT COUNT(*) AS count FROM job_order_comments WHERE tracking_code = '".$tracking_code."' AND deleted = 0");
	}
	
	private function getFormattedDateRequired($dateStart, $interval){
		if ($interval=="1-Week"){
			return date("Y-m-d", strtotime("+1 week", strtotime($dateStart)));
		}else if ($interval=="2-Weeks"){
			return date("Y-m-d", strtotime("+2 week", strtotime($dateStart)));
		}else if ($interval=="3-Weeks"){
			return date("Y-m-d", strtotime("+3 week", strtotime($dateStart)));
		}else if ($interval=="1-Month"){
			return date("Y-m-d", strtotime("+1 month", strtotime($dateStart)));
		}else if ($interval=="2-Months"){
			return date("Y-m-d", strtotime("+2 month", strtotime($dateStart)));
		}else if ($interval=="3-Months"){
			return date("Y-m-d", strtotime("+3 month", strtotime($dateStart)));
		}else{
			return "Over ".date("Y-m-d", strtotime("+4 month", strtotime($dateStart)));
		}
	}
	
	public function getTransformedOrder($list){
		$db = $this->db;
		$posting = new GetJobPosting($db);
		//$this->staffLister->setOrder($list);
		$jr_list_id = $list["jr_list_id"];
		$jr_cat_id = $list["jr_cat_id"];
		$gs_job_titles_details_id = $list["gs_job_titles_details_id"];
		$gs_job_role_selection_id = $list["gs_job_role_selection_id"];
		$list["job_title_export"]  = $list["job_title"];
		if ($list["gs_job_titles_details_id"]!=""){
			if ($list["job_title"]!="TBA When JS is Filled"){
				$list["posting_id"] = $this->getPosting($list["gs_job_titles_details_id"]);				
			}else{
				$list["posting_id"] = null;
			}
		}else{
			$list["posting_id"] = null;
		}
		$jsca_id = $list["jsca_id"];
		if (!$gs_job_role_selection_id){
			$list["session_id"] = $this->getSessionIdForASL($list["jsca_id"], $list["date_filled_up"], $list["leads_id"]);
		}else{
			$list["session_id"] = $this->getSessionIdForCustom($gs_job_role_selection_id);
		}
		$sessionId = $list["session_id"];
		if ($list["service_type"]=="REPLACEMENT"){
			if ($list["job_title"]!="TBA When JS is Filled"){
				$id = $list["gs_job_titles_details_id"];
				while(true){
					try{
						$item = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $id));
						if ($item){
							if (isset($item["link_order_id"])){
								$list["posting_id"] = $this->getPosting($item["link_order_id"]);	
							}
						}
						if (is_null($list["posting_id"])){
							if (is_null($item["link_order_id"])){
								break;
							}else{
								$id = $item["link_order_id"];
							}
						}else{
							break;
						}
					}catch(Exception $e){
						break;
					}
											
				}	
			
			}
		}
		
		
		
		
		$list["client_export"] = $list["client"];
		
		if ($list["budget_monthly"]&&$list["budget_hourly"]){
			$list["budget"] = $this->getBudget($jr_list_id, $list["work_status"], $list["level"]);
		}else{
			$list["budget"] = "TBA When JS is Filled";
		}
		if ($list["gs_job_role_selection_id"]!=""){
			if ($list["job_title"]!="TBA When JS is Filled"){
				if ($list["merge_status"]=="MERGE"){
					$list["job_specification_link"] = "/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}&type=MERGE";	
					}
					
				}else{
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";	
					}
					
					$list["job_specification_link"] = "/portal/get_started/job_spec.php?gs_job_titles_details_id={$gs_job_titles_details_id}&gs_job_role_selection_id={$gs_job_role_selection_id}&jr_list_id={$jr_list_id}&jr_cat_id={$jr_cat_id}";	
				}
			}else{
				$filled = date("Y-m-d", strtotime($list["date_filled_up"]));
				if ($list["merge_status"]=="MERGE"){
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}";	
					}				
					$list["job_specification_link"] = "/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE&gs_job_titles_details_id={$gs_job_titles_details_id}";		
				}else{
					if (TEST){
						$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}";
					}else{
						$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}";	
					}	
					$list["job_specification_link"] = "/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}&gs_job_titles_details_id={$gs_job_titles_details_id}";	
				}
			}
		}else{
			$filled = date("Y-m-d", strtotime($list["date_filled_up"]));
			if ($list["merge_status"]=="MERGE"){
				if (TEST){
					$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE";
				}else{
					$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE";	
				}	
				$list["job_specification_link"] = "/portal/recruiter/create_and_fill_custom_recruitment_order.php?merge_order_id={$list["merged_order_id"]}&type=MERGE";		
			}else{
				if (TEST){
					$list["job_specification_link_export"] = "http://test.remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}";
				}else{
					$list["job_specification_link_export"] = "http://remotestaff.com.au/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}";	
				}	
				
				$list["job_specification_link"] = "/portal/recruiter/create_and_fill_custom_recruitment_order.php?session_id={$sessionId}&jsca_id={$list["jsca_id"]}&date_added={$filled}&lead_id={$list["leads_id"]}";	
			}
			
		}
		$list["order_status"] = $this->getStatus($list["status"]);


	

		if ($list["merge_status"]=="MERGE"){
			$list["notes"] = $this->getNotesForMergeOrder($list["merged_order_id"]);
		}else{
			$list["notes"] = $this->getNotes($gs_job_role_selection_id);
		}
		


		if ($list["date_filled_up"]!="TBA When JS is Filled"&&$list["proposed_start_date"]!="TBA When JS is Filled"){
			$list["proposed_start_date"] = $this->getFormattedDateRequired($list["date_filled_up"], $list["proposed_start_date"]);
		}
		if ($list["service_type"]=="REPLACEMENT"){
			$list["date_filled_up"] = date("Y-m-d", strtotime($list["date_filled_up"])).", ASAP";
		}else{
			$list["date_filled_up"] = date("Y-m-d", strtotime($list["date_filled_up"]));
		}
		
		$list["service_type"] = $list["service_type"];
		$list["order_status"] = $this->getStatus($list["status"]);

		if (intval($list["age"])<0){
			$list["age"] = 0;
		}
		$list["last_contact"] = $this->getLastContact($list["leads_id"], $list["assigned_hiring_coordinator_id"]);
		$list["action"] = $this->display;
		$list["viewHistory"] = true;
		$list["viewNotes"] = true;
		$list["job_order_comments_count"] = $this->getJobOrderCommentsCount($list["tracking_code"]);
		
		if ($list["merge_status"]=="MERGE"){
			$list["endorsed"] = $this->staffLister->getMergedStaff($list["merged_order_id"],$posting, StaffLister::ENDORSED, false);
			$list["interviewed"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $posting, StaffLister::INTERVIEWED, false);
			$list["hired"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $posting, StaffLister::HIRED, false);
			$list["ontrial"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $posting, StaffLister::ONTRIAL, false);
			$list["rejected"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $posting, StaffLister::REJECTED, false);
			$list["shortlisted"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $posting, StaffLister::SHORTLISTED, false);	
			$list["average_endorsed"] = $this->staffLister->getAverageOnMergedOrders($list["merged_order_id"],$posting, StaffLister::ENDORSED, false);
			$list["average_interviewed"] = $this->staffLister->getAverageOnMergedOrders($list["merged_order_id"],$posting, StaffLister::INTERVIEWED, false);
			$list["cancelled"] = $this->staffLister->getMergedStaff($list["merged_order_id"], $posting, StaffLister::CANCELLED, false);
		}else{
			if ($list["service_type"]=="REPLACEMENT"&&$list["created_reason"]=="Closed-To-Replacement"){
				$list["endorsed"] = $this->staffLister->getEndorsedStaffs($list["leads_id"], $list["posting_id"],null, null, null, false, false);
				$list["interviewed"] = $this->staffLister->getInterviewedStaffs($list["posting_id"], $list["leads_id"],null, null, null, false, false);
				$list["hired"] = $this->staffLister->getHiredStaffs($list["posting_id"], $list["leads_id"],null, null, null, false, false);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],null, null, null, false, false);
				$list["shortlisted"] = $this->staffLister->getShortlistedStaffs($list["posting_id"], false, false);
				$list["ontrial"] = $this->staffLister->getOnTrialStaffs($list["posting_id"], $list["leads_id"],null, null, null, false, false);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],null, null, null, false, false);	
				$list["average_endorsed"] = $this->staffLister->getAverageOnEndorsed($list["leads_id"], $list["posting_id"],null, null, null, false, false);
				$list["average_interviewed"] =  $this->staffLister->getAverageOnInterviewed($list["leads_id"], $list["posting_id"],null, null, null, false, false);
				$list["cancelled"] = $this->staffLister->getCancelledStaffs($list["posting_id"], $list["leads_id"],null, null, null, false, false);
			}else{
				$list["endorsed"] = $this->staffLister->getEndorsedStaffs($list["leads_id"], $list["posting_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["interviewed"] = $this->staffLister->getInterviewedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["hired"] = $this->staffLister->getHiredStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["shortlisted"] = $this->staffLister->getShortlistedStaffs($list["posting_id"], false, false);
				$list["ontrial"] = $this->staffLister->getOnTrialStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["rejected"] = $this->staffLister->getRejectedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);	
				$list["average_endorsed"] = $this->staffLister->getAverageOnEndorsed($list["leads_id"], $list["posting_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["average_interviewed"] =  $this->staffLister->getAverageOnInterviewed($list["leads_id"], $list["posting_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);
				$list["cancelled"] = $this->staffLister->getCancelledStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"], $list["jsca_id"], $list["date_filled_up"], false, false);	
			}
			
		}
		
		return $list;
	}
}
