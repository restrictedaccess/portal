<?php

class EndorsementProcess{
	
	private $db;
	private $transport;
	private $search_lead_id, $cc, $subject, $position, $job_category, $body_message, $admin_email, $admin_fullname;
	public function __construct($db){
		global $transport;
		$this->db = $db;
	    
	    $this->transport = $transport;
		$this->authCheck();
		
	}
	
	private function authCheck(){
		if (!isset($_SESSION["admin_id"])){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				die;
			}else{
				header("location:/portal/index.php");
			}
		}
	}
	
	public function process(){
		$db = $this->db;
		$this->gatherInputs();
		$endorsedStaffs = $_SESSION["TO_BE_ENDORSED"];
		if (!empty($endorsedStaffs)){
			//non-shortlisted check
			$allShortlisted = true;
			foreach($endorsedStaffs as $userid){
				if ($this->position){
					$shortlist = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"))->where("sh.userid = ?", $userid)->where("sh.position = ?", $this->position));
					if (!$shortlist){
						$allShortlisted = false;
					}	
				}
			}
			
			if ($allShortlisted){
				foreach($endorsedStaffs as $userid){
					$this->processPerStaff($userid);
				}		
				$this->emailClient();
				//clean up variables
				$_SESSION["TO_BE_ENDORSED"] = array();
                
                
                //force update job orders of the lead
                $db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $this->search_lead_id));
                try{
                	$retries = 0;
					while(true){
						try{
							if (TEST){
			                   $mongo = new MongoClient(MONGODB_TEST);
			                    $database = $mongo->selectDB('prod');
			                }else{
			                    $mongo = new Mongo(MONGODB_SERVER);
			                    $database = $mongo->selectDB('prod');
			                }
							break;
						} catch(Exception $e){
							++$retries;
							
							if($retries >= 100){
								break;
							}
						}
					}
                
                $job_orders_collection = $database->selectCollection('job_orders');
                $job_orders_collection->remove(array("leads_id"=>intval($this->search_lead_id)), array("justOne"=>false));  
                }catch(Exception $e){
                    
                }
                if (TEST){
                    file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
                    file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
                    file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
                    file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
                    file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
                    file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
                    
                }else{
                    file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
                    file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
                    file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
                    file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
                    file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
                    file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
                    
                }
                
                
                
				return array("result"=>true);	
			}else{
				return array("result"=>false, "message"=>"One of the candidate is not shortlisted to the job ad selected. Please shortlist him/her first to the job ad.");
			}
			
		}else{
			return array("result"=>false, "message"=>"Error!!! No candidate to endorse is selected.");
		}
	}
	
	
	private function gatherInputs(){
		$this->search_lead_id = $_REQUEST["search_lead_id"];
		$this->cc = $_REQUEST["cc"];
		$this->subject = $_REQUEST["subject"];
		$this->position = $_REQUEST["position"];
		$this->job_category = $_REQUEST["job_category"];
		$body_message = $_REQUEST["body_message"];
		$this->body_message = str_replace("\n","<br>",$body_message);
	}
	
	private function emailClient(){
		//start: email body
		//start: setup resume
		//start: generate body header
		$db = $this->db;
		
		//start: get lead info

		$search_lead_id = $_REQUEST["search_lead_id"];
		$sql=$db->select()
			->from('leads')
			->where('id = ?' ,$search_lead_id);
		$l = $db->fetchRow($sql);
		$lead_name = $l['fname']." ".$l['lname'];
		$lead_email = $l['email'];
		//ended: get lead info	
		
		
		$transport = $this->transport;
		$admin_id = $_SESSION['admin_id'];
		$sql=$db->select()
			->from('admin')
			->where('admin_id = ?' ,$admin_id);
			$admin = $db->fetchRow($sql);
		$this->admin_name = $admin['admin_fname']." ".$admin['admin_lname'];
		$this->admin_email = $admin['admin_email'];
		$body_header = "
				<p align=left'>
				<table>
					<tr>
						<td>
							".$this->body_message."<br />
						</td>
					</tr>
					<tr>
						<td>
				";
		//ended: generate body header
		//start: generate body
		header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		header("Content-Type: text/html; charset=utf-8");
		$smarty = new Smarty;
		$endorsedStaffs = $_SESSION["TO_BE_ENDORSED"];
		$smarty->assign('PERMALINK', $_SERVER["HTTP_HOST"]);
		$body="<ul>";
		if (!empty($endorsedStaffs)){
			foreach($endorsedStaffs as $userid){
				$sql = $db->select()
		        ->from('personal')
		        ->where('userid = ?', $userid);
				$personal = $db->fetchRow($sql);
				if (!$personal) {
					continue; 
				}else{
					if (TEST){
						$fullname = $personal['fname'];
						$body.="<li>".$fullname." :: <a href='http://test.remotestaff.com.au/available-staff-resume/{$userid}?mode=endorsement&position_id={$this->position}'>".$userid."</a></li>";							
					}else{
						$fullname = $personal['fname'];
						$body.="<li>".$fullname." :: <a href='http://www.remotestaff.com.au/available-staff-resume/{$userid}?mode=endorsement&position_id={$this->position}'>".$userid."</a></li>";							
					}

				}
			}	
		}
		$body.="</ul>";
		
		//ended: generate body

		//start: generate footer
		$signature_template = $this->createSignatureTemplate();
		$body_footer = '
						</td>
					</tr>
					<tr>
						<td>'.$signature_template.'</td>
					</tr>
				</table>
				</p>
				';
		//ended: genearte footer
		//ended: setup resume
		//ended: email body
		
		
		//start: send email resume to client
		
		
		$from_email=$this->admin_email;
		if (TEST)
		{
			$client_email = 'devs@remotestaff.com.au';
		}
		$cc = $_REQUEST["cc"];
		
		$body = $body_header.$body.$body_footer;

		//start: send email
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom($from_email, "Remotestaff");
		if(!TEST)
		{
			//echo $lead_email;
			$mail->addTo($lead_email, $lead_email);
			if($cc != "" || $cc != NULL){
				$ccs = explode(",", $cc);
				if (count($ccs)==1){
					$cc = trim($cc);
					$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header
				}else{
					foreach($ccs as $cc){
						$cc = trim($cc);
						$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header
					}
				}
			}
		}
		else
		{
			$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
			if($cc <> "" || $cc <> NULL)
			{
				$mail->addCc('devs@remotestaff.com.au', 'devs@remotestaff.com.au');// Adds a recipient to the mail with a "Cc" header
			}
		}
		
		$mail->setSubject($this->subject);
		$mail->send($transport);
		//ended: send email
			
		//ended: send email resume to client
	}
	
	private function emailStaff($userid){
		$transport = $this->transport;
		$db = $this->db;
		$sql = $db->select()
	        ->from('personal')
	        ->where('userid = ?', $userid);
		$personal = $db->fetchRow($sql);
		if (!$personal) {
			return; 
		}else{
			$fullname = $personal['fname']." ".$personal['lname'];
			$subcontructor_email = $personal['email'];	
			$subject_value = "Remotestaff: (".$fullname.")";	
		}
		
		//start: send email to subcontractor
		$body="
		Dear ".$fullname.",
		<p> <br>
		
		</p>
		<p>We are happy to inform you that we have just recommended you ".$pos." </p>
		<p>The client will either hire you on the spot based on your resume, voice recording an initial interview summary or request a final interview.<br>
		</p>
		<p>We will get back to you with a feedback within 5 business days with regards to the client&rsquo;s decision.</p>
		<p>&nbsp;</p>
		<p>Should you happen to find/accept a lucrative offer/job from another company within these 2 days, please inform us so we could pull your application out.<br>
		</p><br />
		<p>
		Remote Staff Recruitment Team<br />
		recruitment@remotestaff.com.au
		</p>
		";    
		$subject = "Remotestaff: Application Update";
		//$body .= $signature_template;
			
		//start: send email
		$mail = new Zend_Mail();
		$mail->setBodyHtml($body);
		$mail->setFrom('recruitment@remotestaff.com.au', 'recruitment@remotestaff.com.au');
		if(! TEST)
		{
			$mail->addTo($subcontructor_email, $subcontructor_email);
		}
		else
		{
			$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
		}
		$mail->setSubject($subject);
		$mail->send($transport);
		//ended: send email
		
		
	}
	
	
	private function createSignatureTemplate(){
		//start: email signature
		
		$db = $this->db;
		$admin_id = $_SESSION['admin_id'];
		$admin_status=$_SESSION['status'];
		$site = $_SERVER['HTTP_HOST'];

		$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
		$a = $db->fetchRow($sql);
		$admin_email = $a['admin_email'];
		$name = $a['admin_fname']." ".$a['admin_lname'];
		$admin_email = $a['admin_email'];
		$signature_company = $a['signature_company'];
		$signature_notes = $a['signature_notes'];
		$signature_contact_nos = $a['signature_contact_nos'];
		$signature_websites = $a['signature_websites'];
		if($signature_notes <> ""){
			$signature_notes = "<p><i>$signature_notes</i></p>";
		}else{
			$signature_notes = "";
		}
			
		if($signature_company!=""){
			$signature_company="<br>$signature_company";
		}else{
			$signature_company="<br>RemoteStaff";
		}
		if($signature_contact_nos!=""){
			$signature_contact_nos = "<br>$signature_contact_nos";
		}else{
			$signature_contact_nos = "";
		}
		if($signature_websites!=""){
			$signature_websites = "<br>Websites : $signature_websites";
		}else{
			$signature_websites = "";
		}
		$signature_template = $signature_notes;
		$signature_template .="<a href='http://$site/'>
		<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
		$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
		//ended: email signature
		return $signature_template;
	}
	private function processPerStaff($userid){
		//START: process endorsement
		$db = $this->db;
		$position = $this->position;
		if(isset($_GET["send"]))
		{
		        
            //record selected evaluation notes
	    $db->delete("selected_evaluation_notes", "userid = '".$userid."' AND position_id = '".$this->position."'");
            $date = date("Y-m-d H:i:s");
            $evaluation_comments = $_SESSION["selected_evaluation_notes"][$userid];
            foreach($evaluation_comments as $eval_id){
                $selected_eval = array();
                $selected_eval["evaluation_comment_id"] = $eval_id;
                $selected_eval["userid"] = $userid;
                $selected_eval["position_id"] = $this->position;
                $selected_eval["date_created"] = $date;
                $db->insert("selected_evaluation_notes", $selected_eval);
            }
            
			$date=date('l jS \of F Y h:i:s A');
			$date_endorsed = date("Y-m-d")." ".date("H:i:s");
			$admin_id = $_SESSION['admin_id'];
			

			//start: get lead info
			$sql=$db->select()
			->from('leads')
			->where('id = ?' ,$this->search_lead_id);
			$l = $db->fetchRow($sql);
			$lead_name = $l['fname']." ".$l['lname'];
			$lead_email = $l['email'];
			//ended: get lead info
				
			//start: get admin info
			$sql=$db->select()
			->from('admin')
			->where('admin_id = ?' ,$admin_id);
			$admin = $db->fetchRow($sql);
			$this->admin_name = $admin['admin_fname']." ".$admin['admin_lname'];
			$this->admin_email = $admin['admin_email'];
			//ended: get admin info

	
			//ended: check lead if exist
			if($lead_email <> ""){
				//start: get job position
				$ads = "";
				if($position <> ""){
					$sql=$db->select()
					->from('posting')
					->where('id = ?' ,$position);
					$jp = $db->fetchRow($sql);
					$ads = $jp['jobposition'];
				}
				if ($ads==""){
					//$position = 0;
					$pos = "to one of our clients.";
				}else{
					$pos = "for the ".$ads." position to one of our clients.";
				}
				//ended: get job position

				if (!$this->job_category){
					$this->job_category = 0;	
				}
				
				//start: get job category
				if($position == ""){
					$sql=$db->select()
					->from('job_sub_category')
					->where('sub_category_id = ?' ,$this->job_category);
					$jp = $db->fetchRow($sql);
					$ads = $jp['sub_category_name'];
				}
				if ($ads==""){
					//$job_category = 0;
					$pos = "to one of our clients.";
				}else{
					$pos = "for the ".$ads." position to one of our clients.";
				}
				//ended: get job category
				
				
				
				//start: save endorsement
				$data= array(
				'userid' => $userid,
				'client_name' => $this->search_lead_id,
				'admin_id' => $admin_id,
				'position' => $this->position,
				'job_category' => $this->job_category,
				'date_endoesed' => $date_endorsed 
				); 
				
				//if has ad, get the job order
				if ($this->position){
					$job_order_id = $db->fetchOne($db->select()->from("posting", "job_order_id")->where("id = ?", $this->position));
					if ($job_order_id){
						$retries = 0;
						while(true){
							try{
								if (TEST){
									$mongo = new MongoClient(MONGODB_TEST);
									$database = $mongo->selectDB('prod');
								}else{
									$mongo = new Mongo(MONGODB_SERVER);
									$database = $mongo->selectDB('prod');
								}
								break;
							} catch(Exception $e){
								++$retries;
								
								if($retries >= 100){
									break;
								}
							}
						}
						
						
						$job_order_collection = $database->selectCollection("job_orders");	
						
						$cursor = $job_order_collection->find(array("gs_job_titles_details_id"=>intval($job_order_id)));
						
						$tracking_code = "";
						while($cursor->hasNext()){
							$jo = $cursor->getNext();
							$tracking_code = $jo["tracking_code"];
							if ($tracking_code){
								break;
							}
						}
						if ($tracking_code){
							$activity = $db->fetchRow($db->select()->from("mongo_job_orders_sc_review_activities")->where("tracking_code = ?", $tracking_code)->where("userid = ?", $userid));
							if ($activity){
								$db->update("mongo_job_orders_sc_review_activities", array("hiring_step"=>"ENDORSED_CANDI"), $db->quoteInto("id = ?", $activity["id"]));
								$manager = new JobOrderManager($db);
								$manager->hiringStatus($tracking_code, JobOrderManager::POST_ENDORSEMENT);		
							}
										
						}
						
						
					}	
					
					
				}
				
				$db->insert('tb_endorsement_history', $data);
				$endorsementId = $db->lastInsertId();
				//ended: save endorsement
					
				//start: add status lookup or history
				$status_to_use = "ENDORSED";
				$data2 = array(
				'personal_id' => $userid,
				'admin_id' => $admin_id,
				'status' => $status_to_use,
				'date' => date("Y-m-d")." ".date("H:i:s"),
				"link_id"=>$endorsementId
				);
				$db->insert('applicant_status', $data2);
			
				//ended: add status lookup or history

				//NOTE: this section here is 100% working, it's temporary removed on the staff history because it has it's own history on the staff status reporting
				//start: insert staff history
				//include('portal/lib/staff_history.php');
				//staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', 'ENDORSED');
				//ended: insert staff history

				//start: staff status
				//include_once('/portal/lib/staff_status.php') ;
				$this->staff_status($db, $_SESSION['admin_id'], $userid, 'ENDORSED');
				//ended: staff status
					
				$this->emailStaff($userid);
				//ended: send email to subcontractor
				
				//START: Update date updated
				$AusTime = date("h:i:s"); 
				$AusDate = date("Y")."-".date("m")."-".date("d");
				$ATZ = $AusDate." ".$AusTime;
				$date = $ATZ;
				//mysql_query("UPDATE personal SET dateupdated = '".$date."' WHERE userid = ".$userid);
				$db->update("personal", array("dateupdated"=>$date), array("userid = $userid"));
				
				
				
			}
			else
			{
				echo '
				<script language="javascript">
				  alert("Error!!! Lead not found.");
				</script>
				';		
			}
			//ended: check lead if exist
		}
		//ENDED: process endorsement
	}
	
	function staff_status($db, $admin_id, $userid, $status) {
		$db = $this->db;
		$datetime = date("Y-m-d")." ".date("H:i:s");
		switch($status)
		{
			case "UNPROCESSED":
				//start: remove from inactive_staff
				$where = "userid = ".$userid;	
				$this->db->delete('inactive_staff', $where);			
				//ended: remove from inactive_staff		
				
				//start: remove from pre-screened
				$where = "userid = ".$userid;	
				$this->db->delete('pre_screened_staff', $where);			
				//ended: remove from pre-screened
				
				//start: remove from shortlisted
				$where = "userid = ".$userid;	
				$this->db->delete('tb_shortlist_history', $where);			
				//ended: remove from shortlisted
				
				//start: remove from endorsed
				$where = "userid = ".$userid;
				$this->db->delete('tb_endorsement_history', $where);			
				//ended: remove from endorsed
				
				//start: remove from asl
				$where = "userid = ".$userid;
				$this->db->delete('job_sub_category_applicants', $where);			
				//ended: remove from asl	
				break;
				
				
			case "PRE-SCREENED":
				//start: remove from unprocessed
				$where = "userid = ".$userid;	
				$this->db->delete('unprocessed_staff', $where);			
				//ended: remove from unprocessed
				
				//start: remove from inactive_staff
				$where = "userid = ".$userid;	
				$this->db->delete('inactive_staff', $where);			
				//ended: remove from inactive_staff				
				break;
				
				
			case "INACTIVE":
				//start: remove from pre-screened
				$where = "userid = ".$userid;	
				$this->db->delete('pre_screened_staff', $where);			
				//ended: remove from pre-screened
				
				//start: remove from shortlisted
				$where = "userid = ".$userid;	
				$this->db->delete('tb_shortlist_history', $where);			
				//ended: remove from shortlisted
				
				//start: remove from endorsed
				$where = "userid = ".$userid;
				$this->db->delete('tb_endorsement_history', $where);			
				//ended: remove from endorsed
				
				//start: remove from asl
				$where = "userid = ".$userid;
				$this->db->delete('job_sub_category_applicants', $where);			
				//ended: remove from asl		
				break;
				
				
			case "SHORTLISTED":
				//start: remove from unprocessed
				$where = "userid = ".$userid;	
				$this->db->delete('unprocessed_staff', $where);			
				//ended: remove from unprocessed
				
				//start: remove from prescreen
				$where = "userid = ".$userid;	
				$this->db->delete('pre_screened_staff', $where);			
				//ended: remove from prescreen
				
				//start: remove from inactive_staff
				$where = "userid = ".$userid;	
				$this->db->delete('inactive_staff', $where);			
				//ended: remove from inactive_staff				
				break;
				
				
			case "ENDORSED":
				//start: remove from unprocessed
				$where = "userid = ".$userid;	
				$this->db->delete('unprocessed_staff', $where);			
				//ended: remove from unprocessed
				
				//start: remove from prescreen
				$where = "userid = ".$userid;	
				$this->db->delete('pre_screened_staff', $where);			
				//ended: remove from prescreen	
				
				//start: remove from inactive_staff
				$where = "userid = ".$userid;	
				$this->db->delete('inactive_staff', $where);			
				//ended: remove from inactive_staff				
				break;
				
				
			case "ASL":
				//start: remove from unprocessed
				$where = "userid = ".$userid;	
				$this->db->delete('unprocessed_staff', $where);			
				//ended: remove from unprocessed
				
				//start: remove from prescreen
				$where = "userid = ".$userid;	
				$this->db->delete('pre_screened_staff', $where);			
				//ended: remove from prescreen			
				
				//start: remove from inactive_staff
				$where = "userid = ".$userid;	
				$this->db->delete('inactive_staff', $where);			
				//ended: remove from inactive_staff				
				break;
				
				
			case "TRIAL":
				break;
				
				
			case "HIRED":
				//start: remove from pre-screened
				$where = "userid = ".$userid;	
				$this->db->delete('pre_screened_staff', $where);			
				//ended: remove from pre-screened
				
				//start: remove from shortlisted
				$where = "userid = ".$userid;	
				$this->db->delete('tb_shortlist_history', $where);			
				//ended: remove from shortlisted
				
				//start: remove from inactive_staff
				$where = "userid = ".$userid;	
				$this->db->delete('inactive_staff', $where);			
				//ended: remove from inactive_staff	
				
				//start: remove from endorsed
				$where = "userid = ".$userid;
				$this->db->delete('tb_endorsement_history', $where);			
				//ended: remove from endorsed
				
				//start: remove from asl
				$where = "userid = ".$userid;
				$this->db->delete('job_sub_category_applicants', $where);			
				//ended: remove from asl			
				break;
		}	
	}
}