<?php
class StaffLister{
	private $db;
	
	private $order;
	
	const ENDORSED = "endorsed";
	const INTERVIEWED = "interviewed";
	const REJECTED = "rejected";
	const SHORTLISTED = "shortlisted";
	const HIRED = "hired";
	const ONTRIAL = "ontrial";
	const CANCELLED = "cancelled";
	
	
	private $tracking_code;
	public function __construct($db){
		$this->db = $db;
	}
	
	public function setTrackingCode($tracking_code){
		$this->tracking_code = $tracking_code;
	}
	
	public function getEndorsedStaffs($leads_id, $position_id, $gs_job_role_selection="", $jsca_id="", $date_added="", $limit=true, $render=true){
	$db = $this->db;
		$sqls = array();
		if ($position_id){
				
			//check if posting is converted from ASL
			$job_order = $db->fetchRow($db->select()->from(array("p"=>"posting"), array("p.job_order_id"))
										->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_titles_details_id = p.job_order_id", array())
										->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id", "gs_jrs.jsca_id"))
										->where("p.id = ?", $position_id)
										//->where("gs_jtd.created_reason = ?", "Converted-From-ASL")
										);		
										
			
			
			
			if ($job_order){
				$leads_id = $job_order["leads_id"];
				$jsca_id = $job_order["jsca_id"];
				$reference_job_order = $job_order["job_order_id"];
			}
			
			$positions = array($position_id);
			
			
			$postings = $db->fetchAll($db->select()->from(array("p"=>"posting"), array("p.id"))->where("job_order_id = ?", $reference_job_order));
			
			foreach($postings as $post){
				$positions[] = $post["id"];
			}
			
				
			$sqls[] =$db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid", "end.date_endoesed AS date", "CONCAT('endorsement') AS type", "end.rejected"))
					->joinLeft(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("pers"=>"personal"), "pers.userid = end.userid", array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("end.client_name = ?", $leads_id)
					->where("end.position IN (".implode(",", $positions).")")
					->group("pers.userid");
					
			
		}
		if ($leads_id&&$jsca_id!=""){
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date",  "CONCAT('request') AS type", "CONCAT('0') AS rejected"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
							->where("tbr.leads_id = ?", $leads_id)
							->where("jsca.sub_category_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.service_type = 'ASL'")
							->group(array("tbr.applicant_id"));
							
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date",  "CONCAT('request') AS type", "CONCAT('0') AS rejected"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("tbr.job_sub_category_applicants_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
				
		}		
		try{
			
			$staffs = $db->fetchAll($db->select()->union($sqls)->order(array("date DESC")));//;
			usort($staffs, 'cmp');
			$staffs = uniqueStaff($staffs);
			if (!empty($staffs)){
				if ($render){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));	
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if ($staff["rejected"]==1){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{									
									$output.="<li style='background-color:#ff0000;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}
							}elseif ($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";							
							}	
							
							
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}else{
					if (!($leads_id&&$date_added)){
						if ($render){
							return "";
						}else{
							return array();
						}
					}
					
					$sql = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'NEW'")
							->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
							
					$staffs = $db->fetchAll($sql->order(array("date DESC")));
					if ($render&&!empty($staffs)){
						$count = count($staffs);
						$link = "";
						if ($limit){
							if ($count>10){
								$count = 10;
								$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
							}
						}
						$i = 0;
						$output = "<ul>";
						foreach($staffs as $staff){
							if ($i==$count){
								break;
							}
							$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
							$dateFormat = date("Y-m-d", strtotime($staff["date"]));
							if ($staff["type"]=="endorsement"){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";									
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
							}else{
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
							}
							$i++;
						}
						$output.="</ul>";
						$details = $this->createSummaryDiv($staffs, true);
						
						return $details.$output.$link;
					}else{
						return $staffs;
					}
			}
		}catch(Exception $e){
			if (!($leads_id&&$date_added)){
				if ($render){
					return "";
				}else{
					return array();
				}
			}
			
			$sql = $db->select()
					->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
					->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("tbr.leads_id = ?", $leads_id)
					->where("DATE(tbr.date_added) = ?", $date_added)
					->where("tbr.status = 'NEW'")
					->where("tbr.service_type = 'ASL'")
					->group(array("pers.userid"));
					
			$staffs = $db->fetchAll($sql->order(array("date DESC")));
			if ($render&&!empty($staffs)){
				$count = count($staffs);
				$link = "";
				if ($limit){
					if ($count>10){
						$count = 10;
						$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
					}
				}
				$i = 0;
				$output = "<ul>";
				foreach($staffs as $staff){
					if ($i==$count){
						break;
					}
					$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
					$dateFormat = date("Y-m-d", strtotime($staff["date"]));
					if ($staff["type"]=="endorsement"){
							if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
					}else{
						if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'>{$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}
					$i++;
				}
				$output.="</ul>";
				$details = $this->createSummaryDiv($staffs, true);
				
				return $details.$output.$link;
			}else{
				return $staffs;
			}
		}
		
		
		
		
	}
	
	public function getInterviewedStaffs($position_id, $leads_id, $gs_job_role_selection_id, $jsca_id="", $date_added="",  $limit=true, $render=true){
		$db = $this->db;
		$sqls = array();
		if ($position_id){
			
			//check if posting is converted from ASL
			$job_order = $db->fetchRow($db->select()->from(array("p"=>"posting"), array())
										->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_titles_details_id = p.job_order_id", array())
										->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id", "gs_jrs.jsca_id"))
										->where("p.id = ?", $position_id)
										//->where("gs_jtd.created_reason = ?", "Converted-From-ASL")
										);			
			if ($job_order){
				$leads_id = $job_order["leads_id"];
				$jsca_id = $job_order["jsca_id"];
			}
				
			
			$sqls[] = $db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date", "CONCAT('endorsement') AS type"))
					->joinInner(array("pers"=>"personal"), "end.userid = pers.userid", array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("end.client_name = ?", $leads_id)
					->where("end.position = ?", $position_id)
					->where("tbr.status NOT IN ('NEW', 'CANCELLED')")
					->where("tbr.service_type = 'CUSTOM'")->group("pers.userid");
					
			
		}
		$allAsl = false;
		if ($leads_id&&$jsca_id!=""){
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
							->where("tbr.leads_id = ?", $leads_id)
							->where("jsca.sub_category_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status NOT IN ('NEW', 'CANCELLED')")
							->where("tbr.service_type = 'ASL'")
							->group(array("tbr.applicant_id"));
							
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("tbr.job_sub_category_applicants_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status NOT IN ('NEW', 'CANCELLED')")
							->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
							
			$allAsl = true;				
		}		
		try{
			$staffs = $db->fetchAll($db->select()->union($sqls)->order(array("date DESC")));//->order(array("date DESC")));
            /**
             * Injected by josef Balisalisa START
             */
            $retries = 0;
            while(true){
                try{
                    if (TEST){
                        $mongo = new MongoClient(MONGODB_TEST);
                        $database = $mongo->selectDB('prod');
                    }else{
                        $mongo = new MongoClient(MONGODB_SERVER);
                        $database = $mongo->selectDB('prod');
                    }

                    //Joan Ellorda (#125136) 2016-11-15
                    $candidates_job_order = $database->selectCollection("candidates_job_order");

                    $candidate_job_orders_cursor = $candidates_job_order->find(
                        array(
                            "tracking_code" => $this->tracking_code
                        )
                    );

                    while($candidate_job_orders_cursor->hasNext()){
                        $staffs[] = $candidate_job_orders_cursor->getNext();
                    }

                    break;
                } catch(Exception $e){
                    ++$retries;

                    if($retries >= 100){
                        break;
                    }
                }
            }


            /**
             * Injected by josef Balisalisa END
             */
			usort($staffs, 'cmp');
			$staffs = uniqueStaff($staffs);
			if (!empty($staffs)){
				if ($render){
						$count = count($staffs);
						$link = "";
						if ($limit){
							if ($count>10){
								$count = 10;
								$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
							}
						}
						$i = 0;
						$output = "<ul>";
						foreach($staffs as $staff){
							if ($i==$count){
								break;
							}
							$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
							$dateFormat = date("Y-m-d", strtotime($staff["date"]));
							if ($staff["type"]=="endorsement"){
									if($inactive){
										$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}else{
										$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
										}
							}else{
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
							}
							$i++;
						}
						$output.="</ul>";
						$details = $this->createSummaryDiv($staffs, true);
						
						return $details.$output.$link;
					}else{
						return $staffs;
					}
				}else{
					$sql = $db->select()
						->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
						->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
						->where("tbr.leads_id = ?", $leads_id)
						->where("DATE(tbr.date_added) = ?", $date_added)
						->where("tbr.status NOT IN ('NEW', 'CANCELLED')")
						->where("tbr.service_type = 'ASL'")
						->group(array("pers.userid"));
						
				$staffs = $db->fetchAll($sql->order(array("date DESC")));

                
				if ($render&&!empty($staffs)){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if($inactive){
							$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else{
							$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}
		}catch(Exception $e){
			
			if (!($leads_id&&$date_added)){
				if ($render){
					return "";
				}else{
					return array();
				}
			}
			
			$sql = $db->select()
					->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
					->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("tbr.leads_id = ?", $leads_id)
					->where("DATE(tbr.date_added) = ?", $date_added)
					->where("tbr.status NOT IN ('NEW', 'CANCELLED')")
					->where("tbr.service_type = 'ASL'")
					->group(array("pers.userid"));
					
			$staffs = $db->fetchAll($sql->order(array("date DESC")));


			if ($render&&!empty($staffs)){
				$count = count($staffs);
				$link = "";
				if ($limit){
					if ($count>10){
						$count = 10;
						$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
					}
				}
				$i = 0;
				$output = "<ul>";
				foreach($staffs as $staff){
					if ($i==$count){
						break;
					}
					$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
					$dateFormat = date("Y-m-d", strtotime($staff["date"]));
					if ($staff["type"]=="endorsement"){
						if($inactive){
							$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
						}else{
							$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}else{
						if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}
					$i++;
				}
				$output.="</ul>";
				$details = $this->createSummaryDiv($staffs, true);
				
				return $details.$output.$link;
			}else{
				return $staffs;
			}
		}
	}
	
	public function getRejectedStaffs($position_id, $leads_id, $gs_job_role_selection_id, $jsca_id="", $date_added="", $limit=true, $render=true){
		$db = $this->db;
		$sqls = array();
		if ($position_id){
				
			//check if posting is converted from ASL
			$job_order = $db->fetchRow($db->select()->from(array("p"=>"posting"), array())
										->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_titles_details_id = p.job_order_id", array())
										->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id", "gs_jrs.jsca_id"))
										->where("p.id = ?", $position_id)
										//->where("gs_jtd.created_reason = ?", "Converted-From-ASL")
										);			
			if ($job_order){
				$leads_id = $job_order["leads_id"];
				$jsca_id = $job_order["jsca_id"];
			}
				
			$sqls[] = $db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date", "CONCAT('endorsement') AS type"))
					->joinInner(array("pers"=>"personal"), "end.userid = pers.userid", array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("end.client_name = ?", $leads_id)
					->where("end.position = ?", $position_id)
					->where("tbr.status = 'REJECTED'")
					->where("tbr.service_type = 'CUSTOM'")->group("pers.userid");
		}
		if ($leads_id&&$jsca_id!=""){
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
							->where("tbr.leads_id = ?", $leads_id)
							->where("jsca.sub_category_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'REJECTED'")
							->where("tbr.service_type = 'ASL'")
							->group(array("tbr.applicant_id"));
							
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("tbr.job_sub_category_applicants_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'REJECTED'")
							->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
				
		}		
		try{
			$staffs = $db->fetchAll($db->select()->union($sqls)->order(array("date DESC")));//);
			usort($staffs, 'cmp');
			$staffs = uniqueStaff($staffs);
			if (!empty($staffs)){
				if ($render){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}else{
				if (!($leads_id&&$date_added)){
					if ($render){
						return "";
					}else{
						return array();
					}
				}
				
				$sql = $db->select()
						->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
						->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
						->where("tbr.leads_id = ?", $leads_id)
						->where("DATE(tbr.date_added) = ?", $date_added)
						->where("tbr.status = 'REJECTED'")
						->where("tbr.service_type = 'ASL'")
						->group(array("pers.userid"));
						
				$staffs = $db->fetchAll($sql->order(array("date DESC")));
				if ($render&&!empty($staffs)){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
							$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}
		}catch(Exception $e){
			if (!($leads_id&&$date_added)){
				if ($render){
					return "";
				}else{
					return array();
				}
			}
			
			$sql = $db->select()
					->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
					->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("tbr.leads_id = ?", $leads_id)
					->where("DATE(tbr.date_added) = ?", $date_added)
					->where("tbr.status = 'REJECTED'")
					->where("tbr.service_type = 'ASL'")
					->group(array("pers.userid"));
					
			$staffs = $db->fetchAll($sql->order(array("date DESC")));
			if ($render&&!empty($staffs)){
				$count = count($staffs);
				$link = "";
				if ($limit){
					if ($count>10){
						$count = 10;
						$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
					}
				}
				$i = 0;
				$output = "<ul>";
				foreach($staffs as $staff){
					if ($i==$count){
						break;
					}
					$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
					$dateFormat = date("Y-m-d", strtotime($staff["date"]));
					if ($staff["type"]=="endorsement"){
						if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
						$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
					}else{
						if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}
					$i++;
				}
				$output.="</ul>";
				$details = $this->createSummaryDiv($staffs, true);
				
				return $details.$output.$link;
			}else{
				return $staffs;
			}
		}
		
	}
	
	
	public function getCancelledStaffs($position_id, $leads_id, $gs_job_role_selection_id, $jsca_id="", $date_added="", $limit=true, $render=true){
	$db = $this->db;
		$sqls = array();
		if ($position_id){
			
			//check if posting is converted from ASL
			$job_order = $db->fetchRow($db->select()->from(array("p"=>"posting"), array())
										->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_titles_details_id = p.job_order_id", array())
										->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id", "gs_jrs.jsca_id"))
										->where("p.id = ?", $position_id)
										//->where("gs_jtd.created_reason = ?", "Converted-From-ASL")
										);	
										
					
			if ($job_order){
				$leads_id = $job_order["leads_id"];
				$jsca_id = $job_order["jsca_id"];
			}
				
			
			$sqls[] = $db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date", "CONCAT('endorsement') AS type"))
					->joinLeft(array("rqic"=>"request_for_interview_cancellations"), "rqic.request_for_interview_id = tbr.id", array("rqic.reason AS reason"))
					->joinInner(array("pers"=>"personal"), "end.userid = pers.userid", array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("end.client_name = ?", $leads_id)
					->where("end.position = ?", $position_id)
					->where("tbr.status = 'CANCELLED'")
					->where("tbr.service_type = 'CUSTOM'")->group("pers.userid");
		}
		if ($leads_id&&$jsca_id!=""){
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("rqic"=>"request_for_interview_cancellations"), "rqic.request_for_interview_id = tbr.id", array("rqic.reason AS reason"))
							->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
							->where("tbr.leads_id = ?", $leads_id)
							->where("jsca.sub_category_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'CANCELLED'")
							->where("tbr.service_type = 'ASL'")
							->group(array("tbr.applicant_id"));
							
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("rqic"=>"request_for_interview_cancellations"), "rqic.request_for_interview_id = tbr.id", array("rqic.reason AS reason"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("tbr.job_sub_category_applicants_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'CANCELLED'")
							->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
				
		}		
		try{
			$staffs = $db->fetchAll($db->select()->union($sqls)->order(array("date DESC")));//->order(array("date DESC")));
			usort($staffs, 'cmp');
			$staffs = uniqueStaff($staffs);
			if (!empty($staffs)){
				if ($render){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if ($staff["reason"]){
									if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat} - <span style='color:#ff0000'>{$staff["reason"]}</i></span></span></li>";	
									}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat} - <span style='color:#ff0000'>{$staff["reason"]}</i></span></span></li>";
									}
							}else{
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}
							}
						}else{
							if ($staff["reason"]){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat} - <span style='color:#ff0000'>{$staff["reason"]}</i></span></span></li>";		
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat} - <span style='color:#ff0000'>{$staff["reason"]}</i></span></span></li>";									
								}
								
							}else{
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}else{
				if (!($leads_id&&$date_added)){
					if ($render){
						return "";
					}else{
						return array();
					}
				}
				
				$sql = $db->select()
						->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
						->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
						->where("tbr.leads_id = ?", $leads_id)
						->where("DATE(tbr.date_added) = ?", $date_added)
						->where("tbr.status = 'CANCELLED'")
						->where("tbr.service_type = 'ASL'")
						->group(array("pers.userid"));
						
				$staffs = $db->fetchAll($sql->order(array("date DESC")));
				if ($render&&!empty($staffs)){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff!important'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}
		}catch(Exception $e){
			if (!($leads_id&&$date_added)){
				if ($render){
					return "";
				}else{
					return array();
				}
			}
			
			$sql = $db->select()
					->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
					->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("tbr.leads_id = ?", $leads_id)
					->where("DATE(tbr.date_added) = ?", $date_added)
					->where("tbr.status = 'CANCELLED'")
					->where("tbr.service_type = 'ASL'")
					->group(array("pers.userid"));
					
			$staffs = $db->fetchAll($sql->order(array("date DESC")));
			if ($render&&!empty($staffs)){
				$count = count($staffs);
				$link = "";
				if ($limit){
					if ($count>10){
						$count = 10;
						$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
					}
				}
				$i = 0;
				$output = "<ul>";
				foreach($staffs as $staff){
					if ($i==$count){
						break;
					}
					$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
					$dateFormat = date("Y-m-d", strtotime($staff["date"]));
					if ($staff["type"]=="endorsement"){
						if($inactive){
							$output.="<li style='background-color:#FF9900;'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
						}else{
							$output.="<li><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}else{
						if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}
					$i++;
				}
				$output.="</ul>";
				$details = $this->createSummaryDiv($staffs, true);
				
				return $details.$output.$link;
			}else{
				return $staffs;
			}
		}
	}
	
	
	public function getOnTrialStaffs($position_id,$leads_id,  $gs_job_role_selection="", $jsca_id="", $date_added="", $limit=true, $render=true){
		$db = $this->db;
		$sqls = array();
		if ($position_id){
			
			//check if posting is converted from ASL
			$job_order = $db->fetchRow($db->select()->from(array("p"=>"posting"), array())
										->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_titles_details_id = p.job_order_id", array())
										->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id", "gs_jrs.jsca_id"))
										->where("p.id = ?", $position_id)
										//->where("gs_jtd.created_reason = ?", "Converted-From-ASL")
										);			
			if ($job_order){
				$leads_id = $job_order["leads_id"];
				$jsca_id = $job_order["jsca_id"];
			}
				
			
			$sqls[] = $db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date", "CONCAT('endorsement') AS type"))
					->joinInner(array("pers"=>"personal"), "end.userid = pers.userid", array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("end.client_name = ?", $leads_id)
					->where("end.position = ?", $position_id)
					->where("tbr.status = 'ON TRIAL'")
					->where("tbr.service_type = 'CUSTOM'")->group("pers.userid");
		}
		if ($leads_id&&$jsca_id!=""){
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
							->where("tbr.leads_id = ?", $leads_id)
							->where("jsca.sub_category_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'ON TRIAL'")
							->where("tbr.service_type = 'ASL'")
							->group(array("tbr.applicant_id"));
							
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("tbr.job_sub_category_applicants_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'ON TRIAL'")
							->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
				
		}		
		try{
			$staffs = $db->fetchAll($db->select()->union($sqls)->order(array("date DESC")));//->order(array("date DESC")));
			usort($staffs, 'cmp');
			$staffs = uniqueStaff($staffs);
			if (!empty($staffs)){
				if ($render){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}else{
				if (!($leads_id&&$date_added)){
					if ($render){
						return "";
					}else{
						return array();
					}
				}
				
				$sql = $db->select()
						->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
						->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
						->where("tbr.leads_id = ?", $leads_id)
						->where("DATE(tbr.date_added) = ?", $date_added)
						->where("tbr.status = 'ON TRIAL'")
						->where("tbr.service_type = 'ASL'")
						->group(array("pers.userid"));
						
				$staffs = $db->fetchAll($sql->order(array("date DESC")));
				if ($render&&!empty($staffs)){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}
		}catch(Exception $e){
			if (!($leads_id&&$date_added)){
					if ($render){
						return "";
					}else{
						return array();
					}
				}
				
				$sql = $db->select()
						->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
						->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
						->where("tbr.leads_id = ?", $leads_id)
						->where("DATE(tbr.date_added) = ?", $date_added)
						->where("tbr.status = 'ON TRIAL'")
						->where("tbr.service_type = 'ASL'")
						->group(array("pers.userid"));
						
				$staffs = $db->fetchAll($sql->order(array("date DESC")));
				if ($render&&!empty($staffs)){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
		}
	}
	
	public function getHiredStaffs($position_id,$leads_id,  $gs_job_role_selection="", $jsca_id="", $date_added="", $limit=true, $render=true){
		$db = $this->db;
		$sqls = array();
		if ($position_id){
				
			//check if posting is converted from ASL
			$job_order = $db->fetchRow($db->select()->from(array("p"=>"posting"), array())
										->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), "gs_jtd.gs_job_titles_details_id = p.job_order_id", array())
										->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id", "gs_jrs.jsca_id"))
										->where("p.id = ?", $position_id)
										//->where("gs_jtd.created_reason = ?", "Converted-From-ASL")
										);			
			if ($job_order){
				$leads_id = $job_order["leads_id"];
				$jsca_id = $job_order["jsca_id"];
			}
					
			
			$sqls[] = $db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date", "CONCAT('endorsement') AS type"))
					->joinInner(array("pers"=>"personal"), "end.userid = pers.userid", array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("end.client_name = ?", $leads_id)
					->where("end.position = ?", $position_id)
					->where("tbr.status = 'HIRED'")
					->where("tbr.service_type = 'CUSTOM'")->group("pers.userid");
		}
		if ($leads_id&&$jsca_id!=""){
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
							->where("tbr.leads_id = ?", $leads_id)
							->where("jsca.sub_category_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'HIRED'")
							//->where("tbr.service_type = 'ASL'")
							->group(array("tbr.applicant_id"));
							
				$sqls[] = $db->select()
							->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
							->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
							->where("tbr.leads_id = ?", $leads_id)
							->where("tbr.job_sub_category_applicants_id = ?", $jsca_id)
							->where("DATE(tbr.date_added) = ?", $date_added)
							->where("tbr.status = 'HIRED'")
							//->where("tbr.service_type = 'ASL'")
							->group(array("pers.userid"));
				
		}		
		try{
			$staffs = $db->fetchAll($db->select()->union($sqls)->order(array("date DESC")));//->order(array("date DESC")));
			usort($staffs, 'cmp');
			$staffs = uniqueStaff($staffs);
			if (!empty($staffs)){
				if ($render){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
							if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
							$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}else{
				if (!($leads_id&&$date_added)){
					if ($render){
						return "";
					}else{
						return array();
					}
				}
				
				$sql = $db->select()
						->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
						->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
						->where("tbr.leads_id = ?", $leads_id)
						->where("DATE(tbr.date_added) = ?", $date_added)
						->where("tbr.status = 'HIRED'")
						->where("tbr.service_type = 'ASL'")
						->group(array("pers.userid"));
						
				$staffs = $db->fetchAll($sql->order(array("date DESC")));
				if ($render&&!empty($staffs)){
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
						}
					}
					$i = 0;
					$output = "<ul>";
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["type"]=="endorsement"){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";		
								}else{
									$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}
						}else{
							if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs, true);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}
		}catch(Exception $e){
			if (!($leads_id&&$date_added)){
				if ($render){
					return "";
				}else{
					return array();
				}
			}
			
			$sql = $db->select()
					->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id", "tbr.date_interview AS date", "CONCAT('request') AS type"))
					->joinLeft(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("CONCAT('') AS posting_id", "CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					->where("tbr.leads_id = ?", $leads_id)
					->where("DATE(tbr.date_added) = ?", $date_added)
					->where("tbr.status = 'HIRED'")
					->where("tbr.service_type = 'ASL'")
					->group(array("pers.userid"));
					
			$staffs = $db->fetchAll($sql->order(array("date DESC")));
			if ($render&&!empty($staffs)){
				$count = count($staffs);
				$link = "";
				if ($limit){
					if ($count>10){
						$count = 10;
						$link = "<a href='/portal/leads_information.php?id={$leads_id}#lead_activity' target='_blank' class='popup' data-list-type='interviewed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
					}
				}
				$i = 0;
				$output = "<ul>";
				foreach($staffs as $staff){
					if ($i==$count){
						break;
					}
					$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
					$dateFormat = date("Y-m-d", strtotime($staff["date"]));
					if ($staff["type"]=="endorsement"){
							if($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}else{
						if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{	
									$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							}
					}
					$i++;
				}
				$output.="</ul>";
				$details = $this->createSummaryDiv($staffs, true);
				
				return $details.$output.$link;
			}else{
				return $staffs;
			}
		}
	}
	
	public function getShortlistedStaffs($posting_id, $limit=true, $render=true){
		$db = $this->db;
		if ($posting_id){
			//get all posting with the same job order
			$job_order_id = $db->fetchOne($db->select()->from("posting", array("job_order_id"))->where("id = ?", $posting_id));	
			if ($job_order_id){
				$postings = $db->fetchAll($db->select()->from("posting", array("id"))->where("job_order_id = ?", $job_order_id));
				$posting_ids = array();
				foreach($postings as $posting){
					$posting_ids[] = $posting["id"];
				}
				if (!empty($posting_ids)){
					$sql = $db->select()
					   ->from(array("sh"=>"tb_shortlist_history"),
					   		array("sh.userid AS userid", "sh.date_listed AS date", "sh.rejected"))
					   ->joinInner(array("pers"=>"personal"),
					   		  "pers.userid = sh.userid",
					   		  array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					     ->where("sh.position IN (".implode(",", $posting_ids).")")
					     ->order("sh.date_listed DESC")
					     ->group("sh.id");
				}
			}else{
				$sql = $db->select()
					   ->from(array("sh"=>"tb_shortlist_history"),
					   		array("sh.userid AS userid", "sh.date_listed AS date", "sh.rejected"))
					   ->joinInner(array("pers"=>"personal"),
					   		  "pers.userid = sh.userid",
					   		  array("CONCAT(pers.fname, ' ', pers.lname) AS fullname", "pers.userid AS userid"))
					     ->where("sh.position = ?", $posting_id)
					     ->order("sh.date_listed DESC")
					     ->group("sh.id");
			}  
			
			try{
				$staffs = $db->fetchAll($sql);
			}catch(Exception $e){
				return "";
			}
			if (!empty($staffs)){
				if ($render){
					$output = "<ul>";
					$count = count($staffs);
					$link = "";
					if ($limit){
						if ($count>10){
							$count = 10;
							$link = "<a href='#seemore' class='popup shortlist_popup' data-list-type='shortlisted' data-position-id='{$posting_id}'>See more</a>";
						}
					}
					$i = 0;
					//$statement = $sql->__toString();
					foreach($staffs as $staff){
						if ($i==$count){
							break;
						}
						$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
						$dateFormat = date("Y-m-d", strtotime($staff["date"]));
						if ($staff["rejected"]){
								if($inactive){
									$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
								}else{
									$output.="<li style='background-color:#ff0000;color:#fff'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
									}					
						}elseif($inactive){
								$output.="<li style='background-color:#FF9900;color:#fff;'><a style='color:#fff' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
						}else{
							$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";
							
						}
						$i++;
					}
					$output.="</ul>";
					$details = $this->createSummaryDiv($staffs);
					
					return $details.$output.$link;
				}else{
					return $staffs;
				}
			}else{
				return "";
			}		
		}else{
			return "";
		}
	}
	
	private function isSessionCreated($session_id){
		$db = $this->db;
		$count = $db->fetchRow($db->select()->from(array("rfo"=>"request_for_interview_job_order"), array("COUNT(*) AS count"))->where("session_id = ?", $session_id));
		return $count["count"]>=1;
	}
	
	private function createSummaryDiv($staffs, $detailed=false){
		$count = count($staffs);
		
		$out = "<div class='summary'>";
		
		if ($detailed){
		    $out.="<strong>Count: </strong>{$count}<br/>";
		}else{
			$out.="<strong>Count: </strong>{$count}<br/>";
		}
		$out.="</div>";
		return $out;		
	}
	
	private function dateDiff($startDate, $endDate){
		$startArry = date_parse($startDate);
		$endArry = date_parse($endDate);
		$start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
		$end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);
		return round(($end_date - $start_date), 0);
	}
	
	public function getAverageOnEndorsed($leads_id, $position_id, $gs_job_role_selection="", $jsca_id="", $date_added=""){
		$staffs = $this->getEndorsedStaffs($leads_id, $position_id, $gs_job_role_selection, $jsca_id, $date_added, false, false);
		$gap = $this->getAverageGap($staffs);
		if (!$gap){
			return 0;
		}else{
			if ($gap<0){
				return abs(intval($gap));
			}else{		
				return $gap;	
			}
		}
	}
	
	public function getAverageOnInterviewed($leads_id, $position_id, $gs_job_role_selection="", $jsca_id="", $date_added=""){
		$staffs = $this->getInterviewedStaffs($leads_id, $position_id, $gs_job_role_selection, $jsca_id, $date_added, false, false);
		$gap = $this->getAverageGap($staffs);
		if (!$gap){
			return 0;
		}else{
			if ($gap<0){
				return abs(intval($gap));
			}else{		
				return $gap;	
			}
		}
	}
	
	public function getAverageOnMergedOrders($merge_order_id, $posting, $type){
		$staffs = $this->getMergedStaff($merge_order_id, $posting, $type, false);
		$gap = $this->getAverageGap($staffs);
		if (!$gap){
			return 0;
		}else{
			if ($gap<0){
				return abs(intval($gap));
			}else{		
				return $gap;	
			}
		}
	}
	
	private function getAverageGap($staffs){
		$count = count($staffs);
		if ($count==1){
			$gap = 0;
		}else{
			$gap = $this->dateDiff($staffs[1]["date"], $staffs[0]["date"]);
		}
		return $gap;		
	}
	
	
	public function setOrder($order){
		$this->order = $order;
	}
	
	
	public function getMergedStaff($merge_order_id, $posting, $type, $render=true){
		$db = $this->db;
		$items = $db->fetchAll($db->select()->from("merged_order_items")->where("merged_order_id = ?",$merge_order_id));
		$staffs = array();
		
		foreach($items as $item){
			$list = $posting->getMoreDetailsForMerge($item);
			if ($type==self::ENDORSED){
				$foundStaff = $this->getEndorsedStaffs($list["leads_id"], $list["posting_id"], $list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);
			}else if ($type==self::INTERVIEWED){
				$foundStaff = $this->getInterviewedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);
			}else if ($type==self::HIRED){
				$foundStaff = $this->getHiredStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);
			}else if ($type==self::SHORTLISTED){
				$foundStaff = $this->getShortlistedStaffs($list["posting_id"], false, false);
			}else if ($type==self::ONTRIAL){
				$foundStaff = $this->getOnTrialStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);					
			}else if ($type==self::REJECTED){
				$foundStaff = $this->getRejectedStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);					
			}else if ($type==self::CANCELLED){
				$foundStaff = $this->getCancelledStaffs($list["posting_id"], $list["leads_id"],$list["gs_job_role_selection_id"],  $list["jsca_id"], $list["date_filled_up"], false, false);
			}else{
				$foundStaff = array();
			}
			if ($foundStaff&&!empty($foundStaff)){
				
				foreach($foundStaff as $staff){
					$staff["timestamp"] = strtotime($staff["date"]);
					$staffs[] = $staff;	
				}			
			}
		}
		
		
		usort($staffs, 'cmp');
		
		$staffs= uniqueStaff($staffs);
		
		if (!empty($staffs)){
			if ($render){
				$count = count($staffs);
				$link = "";
				if ($count>10){
					$count = 10;
					$link = "<a href='/portal/leads_information.php?id={$list["leads_id"]}#lead_activity' target='_blank' class='popup' data-list-type='endorsed' data-leads-id='{$leads_id}' data-position-id='{$position_id}' data-gs-job-role-selection-id='{$gs_job_role_selection}'>See more</a>";
				}
				$i = 0;
				$output = "<ul>";
				foreach($staffs as $staff){;
					if ($i==$count){
						break;
					}
					$inactive = $db->fetchRow($db->select()
							  ->from("inactive_staff",
							  array("userid"))
							  ->where("userid=?",$staff["userid"]));
					$dateFormat = date("Y-m-d", strtotime($staff["date"]));
					if ($staff["rejected"]==1){
						if ($staff["reason"]&&$type==self::CANCELLED){
							$output.="<li style='background-color:#ff0000;color:#fff'><i><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";						
						}else{
							if ($staff["type"]=="endorsement"){
								$output.="<li style='background-color:#ff0000;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else if ($staff["type"]=="request"){
								$output.="<li style='background-color:#ff0000;color:#fff'><i><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else{
								$output.="<li style='background-color:#ff0000;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";		
							}	
						}
					}elseif($inactive){
						if ($staff["reason"]&&$type==self::CANCELLED){
							$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";						
						}else{
							if ($staff["type"]=="endorsement"){
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else if ($staff["type"]=="request"){
								$output.="<li style='background-color:#FF9900;color:#fff'><i><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else{
								$output.="<li style='background-color:#FF9900;color:#fff'><a style='color:#fff;' href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank' style='color:#fff'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";		
							}
							
						}
					}else{
						if ($staff["reason"]&&$type==self::CANCELLED){
							$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";						
						}else{
							if ($staff["type"]=="endorsement"){
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else if ($staff["type"]=="request"){
								$output.="<li><i><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a></i>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";	
							}else{
								$output.="<li><a href='/portal/recruiter/staff_information.php?userid={$staff["userid"]}&tracking_code={$this->tracking_code}' target='_blank'> {$staff["fullname"]} (#{$staff["userid"]})</a>&nbsp;<span class='date'><i>{$dateFormat}</i></span></li>";		
							}
							
						}		
					}
					
					$i++;
				}
				$output.="</ul>";
				if ($type==self::ENDORSED||$type==self::INTERVIEWED){
					$details = $this->createSummaryDiv($staffs, true);
					
				}else{
					$details = $this->createSummaryDiv($staffs, false);
					
				}
			
				return $details.$output.$link;
			}else{
				return $staffs;
			}
		}else{
			return "";
		}		
	}
}


function uniqueStaff($staffs){
	$uniqueStaffs = array();
	foreach($staffs as $staff){
		if (empty($uniqueStaffs)){
			$uniqueStaffs[] = $staff;
		}else{
			$same = false;
			foreach($uniqueStaffs as $uniqueStaff){
				if ($uniqueStaff["userid"]==$staff["userid"]){
					$same = true;
					break;
				}
			}
			if (!$same){
				$uniqueStaffs[] = $staff;
			}
		}
	}
	return $uniqueStaffs;
}

function cmp($a, $b){
    if ($a['timestamp'] == $b['timestamp']) {
        return 0;
    }
    return ($a['timestamp'] > $b['timestamp']) ? -1 : 1;
}