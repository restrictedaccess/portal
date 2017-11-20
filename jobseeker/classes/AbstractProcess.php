<?php
/**
 * Abstract Process to be extend by any Jobseeker process
 * @version 0.1 - Initial commit on New jobseeker portal
 */
abstract class AbstractProcess{
	/**
	 * The database
	 */	
	protected $db;	
	
	/**
	 * The smarty engine
	 */
	protected $smarty;
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
		$emailaddr = $_SESSION["emailaddr"];
		$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ), 2, 17 );
		$this->smarty->assign("hash", $hash_code);
		$this->authCheck();
		$this->checkAndConvertMp3();
		$this->recordLastLogin();

        //check to see if will redirect to new jobseeker v2

        try{

            global $base_api_url;

            global $curl;


            $to_redirect = $curl->get($base_api_url . '/candidates/get-default-resume-settings-value?settings_for=redirect_to_new_jobseeker_v2');
            $to_redirect = json_decode($to_redirect, true);
            $will_redirect = $to_redirect["value"];

            if($will_redirect){
                $this->smarty->assign("will_redirect_to_new_jobseeker_v2", $will_redirect);
                $this->smarty->assign("userid", $_SESSION["userid"]);
            }
        } catch(Exception $e){

        }



    }
	private function recordLastLogin(){
		$db = $this->db;
		$userid = $_SESSION["userid"];
		$login = $db->fetchRow($db->select()->from("personal_user_logins")->where("userid = ?", $userid));
		if ($login){
			$db->update("personal_user_logins", array("last_login"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));			
		}else{
			$db->insert("personal_user_logins", array("last_login"=>date("Y-m-d H:i:s"), "userid"=>$userid));			
			
		}
	}
	
	private function checkAndConvertMp3(){
		
		
		$db = $this->db;
		$userid = $_SESSION["userid"];
		
		
		$sql = $db->select()->from(array("p"=>"personal"), array("voice_path"))->where("p.userid = ?", $userid);
		$staff = $db->fetchRow($sql);
		$voice_parts = pathinfo($staff["voice_path"]);
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		if (strtolower($voice_parts["extension"])=="flv"){
			$voice_file_type = finfo_file($finfo, $staff["voice_path"]);
		}else{
			if (file_exists(getcwd()."/../".$staff["voice_path"])){
				$voice_file_type = finfo_file($finfo, getcwd()."/../".$staff["voice_path"]);				
			}else{
				$voice_file_type = "";
			}

		}
		
		if ((strtolower($voice_parts["extension"])=="flv"||$voice_file_type=="video/3gpp")&&!isset($_SESSION["converting"])&&!$_SESSION["converting"]){
			$exists = true;	
			if (strtolower($voice_parts["extension"])=="flv"){
				$file_headers = @get_headers($staff["voice_path"]);
				if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
				    $exists = false;
				}
				else {
				    $exists = true;
				}	
									
			}	

			if ($exists){
				$_SESSION["converting"] = true;
					
				$exchange = '/';
				$queue = 'mp3_conversion';
				$consumer_tag = 'consumer';
				
				$conn = new AMQPConnection(MP3_AMQP_HOST, MP3_AMQP_PORT,MP3_AMQP_USERNAME, MP3_AMQP_PASSWORD, MP3_AMQP_VHOST);
				$ch = $conn->channel();
				$ch->queue_declare($queue, false, true, false, false);
				$ch->exchange_declare($exchange, 'direct', false, true, false);
				$ch->queue_bind($queue, $exchange);
				
				$msg_body =json_encode(array("published_by"=>"/portal/jobseeker/AbstractProcess.php", "userid"=>$userid, "scale"=>1));
				
				$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
				$ch->basic_publish($msg, $exchange);
				$ch->close();
				$conn->close();	
			}
			
		}else{
			unset($_SESSION["converting"]);
		}
	}
	
	
	private function authCheck(){
		session_start();
		if(!isset($_SESSION['userid']))
		{
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				die;
			}else{
				header("location:/portal/index.php");
				die;
			}
		}
	}
	
	
	public function getInterviewStatus($userid){
		$db = $this->db;
		$pres = $db->fetchRow($db->select()->from(array("pres"=>"pre_screened_staff"), array("userid"))->where("userid = ?", $userid));
		$status = "Unprocessed";
		if ($pres){
			$status = "Pre-screened";
		}		
		$shortlisted = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("userid"))->joinInner(array("p"=>"posting"), "p.id = sh.position", array())->where("sh.userid = ?", $userid));
		if ($shortlisted){
			$status = "Shortlisted";
		}
		$endorsed = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array("userid"))->where("end.userid = ?", $userid));
		if ($endorsed){
			$status = "Endorsed";
		}
		
		$new = $db->fetchRow($db->select()
				->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
				->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
				->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
				->where("end.userid = ?", $userid)
				->where("tbr.status = 'NEW'")
				->where("tbr.service_type = 'CUSTOM'"));
		if ($new){
			$status = "Interview Set";
		}

		
				
		$hired = $db->fetchRow($db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
					->where("end.userid = ?", $userid)
					->where("tbr.status = 'HIRED'")
					->where("tbr.service_type = 'CUSTOM'"));
		if ($hired){
			$status = "Hired";
		}
		$rejected = $db->fetchRow($db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
					->where("end.userid = ?", $userid)
					->where("tbr.status = 'REJECTED'")
					->where("tbr.service_type = 'CUSTOM'"));
		if ($rejected){
			$status = "Rejected";
		}
		
		if ($status=="Unprocessed"){
			//last attempt to find status
			$request = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), "tbr.status")->where("tbr.applicant_id = ?", $userid));
			if ($request){
				$stat = "";
				switch ($request["status"]) 
				{
					case "ACTIVE":
						$stat = "Interview Set";
						break;
					case "NEW":
						$stat = "Interview Set";
						break;
					case "ARCHIVED":
						$stat = "Cancelled";
						break;
					case "ON-HOLD":
						$stat = "Interview Set";
						break;															
					case "HIRED":
						$stat = "Hired";
						break;															
					case "REJECTED":
						$stat = "Rejected";
						break;		
					case "CONFIRMED":
						$stat = "Interview Set";	
						break;		
					case "YET TO CONFIRM":
						$stat = "Yet to Confirm";
						break;		
					case "DONE":
						$stat = "Interviewed";
						break;
					case "RE-SCHEDULED":
						$stat = "Interview Set";
						break;	
					case "CANCELLED":
						$stat = "Cancelled";
						break;	
					case "CHATNOW INTERVIEWED":
						$stat = "Interview Set";
						break;	
					case "ON TRIAL":
						$stat = "On Trial";
						break;																
					default: 
						$stat = $request["status"];
						break;																																														
				}
				$status = $stat;
			}
		
		}
		return $status;
	}
	
	protected function subtractRemoteReadyScore($userid, $criteria){
		//subtract score
//		$db = $this->db;
//		$entries = $db->fetchAll($db->select()->from(array("rrce"=>"remote_ready_criteria_entries"), array("rrce.id AS rrce_id"))->joinLeft(array("rrc"=>"remote_ready_criteria"), "rrce.remote_ready_criteria_id = rrc.id", array("rrc.points AS points"))->where("rrce.userid = ?", $userid)->where("rrce.remote_ready_criteria_id = ?", $criteria));
//		$sum = 0;
//		foreach($entries as $entry){
//			$sum+=intval($entry["points"]);
//		}
//		//find summation entry
//		$summation = $db->fetchRow($db->select()->from(array("rrcesp"=>"remote_ready_criteria_entry_sum_points"))->where("rrcesp.userid = ?", $userid));
//		if ($summation){
//			$db->update("remote_ready_criteria_entry_sum_points", array("points"=>$summation["points"]-$sum), $db->quoteInto("userid = ?", $userid));
//		}
	}
	
	/**
	 * Render function for every page
	 */
	public abstract function render();
}
