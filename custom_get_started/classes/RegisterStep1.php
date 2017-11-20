<?php
require_once dirname(__FILE__) . "/../../lib/CheckLeadsFullName.php";
require_once dirname(__FILE__) . "/../../tools/CouchDBMailbox.php";
include_once dirname(__FILE__)."/location_constants.php";
require_once dirname(__FILE__). "/../../lib/Contact.php";

class RegisterStep1 {
	
    private $db;
    private $smarty;
    
    public function __construct($db) {
        $this->db = $db;
        $this->smarty = new Smarty();
        $rs_contact_nos = new Contact();
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
        $this->smarty->assign('contact_numbers',$contact_numbers);
        $this->smarty->assign('script','index.js');
    }

    public function render() {
		
		//echo "<pre>";
		//print_r($_SESSION);
		//die;
		
		//GET DB INSTANCE
	    $db = $this->db;
	    
	    //GET SMARTY INSTANCE
	    $smarty = $this->smarty;
		
        //STEP 1 IS FINISHED
        if (isset($_SESSION['leads_id'])||isset($_SESSION['client_id'])){
			
			//CREATE LEAD SESSION IF CLIENT ID IS ISSET
			if (!isset($_SESSION["leads_id"])&&$_SESSION["client_id"]){
				$_SESSION["leads_id"] = $_SESSION["client_id"];
			}
			
			//CREATE CLIENT SESSION IF LEADS ID IS ISSET
			if (!isset($_SESSION["client_id"])&&$_SESSION["leads_id"]){
				$_SESSION["client_id"] = $_SESSION["leads_id"];
			}
			
			//PROCEED TO STEP 2
            header("Location:/portal/custom_get_started/step2.php");
			die;
			
        }

        //PULL COUNTRIES BY IP ADDRESS
        $ip_address = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : $_SERVER['REMOTE_ADDR']);

        //LOCALHOST LXC ROUTER IP ADDRESS
		//$ip_address = ($ip_address == '192.168.122.1' ? '103.225.38.20' : $ip_address);
		
		$ip_address = ($ip_address && $ip_address != '192.168.122.1' ? $ip_address : '103.225.38.20');
		
        //GET SHORTNAME OF COUNTRY
        $leads_country = $this->_getCCfromIP($ip_address);
		
		if(empty($leads_country)){
			$leads_country = 'PH';
		}
        
        //PULL COUNTRY AND STATES
        $country = $this->_getCountry($leads_country);
        $countries = $this->_getCountry();
        $states = $this->_getState($country['id']);
        
        $smarty->assign('leads_country',$leads_country);
		$smarty->assign('country',$country); 
        $smarty->assign('countries',$countries);
        $smarty->assign('states',$states);
		$smarty->clear_cache('index.tpl');
        $smarty->display("index.tpl");
        
    }

    public function process() {
		
        $db = $this -> db;
        $data = array();
        $errors = array();
        
        if ($_REQUEST["first_name"] == "") {
            $errors[] = "First Name is required";
        }
        if ($_REQUEST["last_name"] == "") {
            $errors[] = "Last Name is required";
        }
        if ($_REQUEST["company_name"] == "") {
            $errors[] = "Company Name is required";
        }
        if ($_REQUEST["company_position"] == "") {
            $errors[] = "Company Position is required";
        }
        if ($_REQUEST["company_phone"] == "" && $_REQUEST["mobile_phone"] == "") {
            $errors[] = "Either Company Phone or Mobile Phone is required";
        }
        if ($_REQUEST["email_address"] == "") {
            $errors[] = "Email Address is required";
        }
        /*
        if ($_REQUEST["business_address"] == "") {
            $errors[] = "Business Address is required";
        }
        */

        $validator = new Zend_Validate_EmailAddress();
        if (!$validator -> isValid($_REQUEST["email_address"])) {
            $errors[] = "Email Address is not a valid email address";
        }
        if (trim($_REQUEST["hpot"]) != "") {
            $errors[] = "You are a bot!";
        }

        if (!empty($errors)) {
            return array("success" => false, "errors" => $errors);
        }
        
		$ip = $_SERVER['REMOTE_ADDR'];
		$password = $this -> generatePassword();
		$rand_pw = $password;
		$data = array(
			"timestamp" => date("Y-m-d H:i:s"),
			"fname" => $_REQUEST["first_name"], 
			"lname" => $_REQUEST["last_name"], 
			"mobile" => $_REQUEST["mobile_phone"], 
			"email" => $_REQUEST["email_address"], 
			"sec_email" => $_REQUEST["alt_email"], 
			"password" => sha1($password),
			"officenumber" => $_REQUEST["company_phone"], 
			"registered_domain" => LOCATION_ID, 
			"location_id" => LOCATION_ID, 
			"leads_country" => $this->getCCfromIP($ip), 
			"leads_ip" => trim($ip, "::ffff:"), 
			"outsourcing_experience" => $_REQUEST["tried_staffing"], 
			"company_name" => $_REQUEST["company_name"], 
			"company_position" => $_REQUEST["company_position"], 
			'company_address' => $_REQUEST[ 'leads_address' ],
			"company_size" => $_REQUEST["existing_team_size"], 
			//"company_turnover" => $_REQUEST["company_revenue"],
			"company_description"=> $_REQUEST['company_description'],
			"status" => "New Leads"
		 );
		 
		 //echo "<pre>";
		 //print_r($data);
		 //die;
		 
		//CHECK IF COUNTRY IS ISSET
		if( isset( $_REQUEST[ 'leads_country' ] ) && ! empty( $_REQUEST[ 'leads_country' ] ) ) {
			
			$leads_country_sql = $db -> select() 
			
									 -> from( 'library_country', 'name' )
								 
									 -> where( 'id = ?', $_REQUEST[ 'leads_country' ] );
									 
			$leads_country = $db -> fetchOne( $leads_country_sql );
									 
			$data[ 'leads_country' ] = $leads_country;
			
		}
		
		//CHECK IF STATE IS ISSET
		if( isset( $_REQUEST[ 'leads_state' ] ) && ! empty( $_REQUEST[ 'leads_state' ] ) ) {
			
			$leads_state_sql = $db -> select() 
			
									 -> from( 'library_state', 'name' )
								 
									 -> where( 'id = ?', $_REQUEST[ 'leads_state' ] );
									 
			$leads_state = $db -> fetchOne( $leads_state_sql );
									 
			$data[ 'state' ] = $leads_state;
			
		}

		//CHECK IF CITY IS ISSET
		if( isset( $_REQUEST[ 'leads_city' ] ) && ! empty( $_REQUEST[ 'leads_city' ] ) ) {
			
			$leads_city_sql = $db -> select() 
			
									 -> from( 'library_city', 'name' )
								 
									 -> where( 'id = ?', $_REQUEST[ 'leads_city' ] );
									 
			$leads_city = $db -> fetchOne( $leads_city_sql );
									 
			$data[ 'city' ] = $leads_city;
			
		}
		 
		 //LEADS ADDRESS
		 $leads_address_data = array(
			"leads_address"=>$_REQUEST['leads_address'],
			"leads_country"=>$_REQUEST['leads_country'],
			"leads_state"=>$_REQUEST['leads_state'],
			"leads_city"=>$_REQUEST['leads_city'],
			"leads_zip_code"=>$_REQUEST['leads_zip_code']
		 );
        
        //CHECK LEADS ID
		/*
        if(isset($_REQUEST['leads_id'])&&!empty($_REQUEST['leads_id'])){
			
			$db->update('leads',$data,$db->quoteInto('id=?',$_REQUEST['leads_id']));
		
		}else{
		*/

			if (isset($_REQUEST["booking_code"]) && trim($_REQUEST["booking_code"]) != "") {
				$booking_code = $_REQUEST["booking_code"];
			} else {
				$booking_code = "";
			}

			if ($booking_code == "") {
				$booking_code = '101HOMEPAGEINQUIRY';
				//Default to Chris J.
				$sql = "SELECT agent_no, lname, fname, email, status, work_status FROM agent a WHERE agent_no=2;";
				$agent = $db -> fetchRow($sql);
				$data['business_partner_id'] = $agent['agent_no'];
				$data['agent_id'] = $agent['agent_no'];
			} else {

				//There's a promotional code used/detected.
				$agent = array();
				//Check the promocodes then add 1 (one) point to its current point
				$sql = "SELECT id, points FROM tracking t WHERE tracking_no = '" . $booking_code . "';";
				$tracking = $db -> fetchRow($sql);
				if ($tracking) {
					$points = $tracking['points'];
					$points = $points + 1;
					$where = "id = " . $tracking['id'];
					$db -> update('tracking', array('points' => $points), $where);
				}

				//check the owner of the promotional code
				$sql = "SELECT agent_no, lname, fname, email, status, work_status, agent_code FROM agent a WHERE status='ACTIVE';";
				$agents = $db -> fetchAll($sql);
				foreach ($agents as $a) {

					$length = strlen($a['agent_code']);
					//compare
					if (substr($booking_code, 0, $length) == $a['agent_code']) {
						$agent[] = $a;
						break;
					}
				}

				//print_r($agent);

				if ($agent[0]['work_status'] == 'AFF') {
					//the owner of the promotional code is an affiliate
					//we should get the fname , lname and email of the business partner
					$sql = "SELECT b.agent_no, fname , lname , email, b.status, b.work_status, b.agent_code FROM agent_affiliates a LEFT JOIN agent b ON b.agent_no = a.business_partner_id WHERE a.affiliate_id=" . $agent[0]['agent_no'] . " AND b.status = 'ACTIVE';";
					//echo $sql;
					$bp = $db -> fetchRow($sql);
					$agent[] = $bp;
					$data['business_partner_id'] = $bp['agent_no'];
					$data['agent_id'] = $agent[0]['agent_no'];

				} else if ($agent[0]['work_status'] == "BP") {
					$data['business_partner_id'] = $agent[0]['agent_no'];
					$data['agent_id'] = $agent[0]['agent_no'];
				} else {
					$data['business_partner_id'] = 2;
					$data['agent_id'] = 2;
				}

				//End promotional code
				foreach ($agent as $a) {
					$cc_array[] = $a['email'];
				}
			}

			$data['tracking_no'] = $booking_code;

			$EXISTING_LEAD = false;

			//check the email if existing
			$sql = $db -> select() -> from('leads') -> where('email =?', $_REQUEST['email_address']);
			$EXISTING_LEAD = $db -> fetchOne($sql);
		   

			if ($EXISTING_LEAD) {
				
				//Existing lead
				//echo "insert new record in the leads_new_info table";
				$sql = $db -> select() -> from('leads_new_info') -> where('leads_id =?', $EXISTING_LEAD);
				$leads_new_info = $db -> fetchRow($sql);
				$leads_new_info_id = $leads_new_info['id'];

				//REMOVE STATE
				if(isset($data['state'])){
					unset($data['state']);
				}
				
				//REMOVE CITY
				if(isset($data['city'])){
					unset($data['city']);
				}
				
				if ($leads_new_info) {
					//update existing

					$where = "id = " . $leads_new_info_id;
					$db -> update('leads_new_info', $data, $where);
					
				} else {
					//insert new

					$data['leads_id'] = $EXISTING_LEAD;
					$db -> insert('leads_new_info', $data);
					$leads_new_info_id = $db -> lastInsertId();
				}

				//Create session
				$_SESSION['leads_new_info_id'] = $leads_new_info_id;
				$_SESSION['leads_id'] = $EXISTING_LEAD;
				
				$db -> update('leads', array('last_updated_date' => date('Y-m-d H:i:s')), 'id=' . $EXISTING_LEAD);
				
				
				//add lead history
				$db -> insert('leads_info_history', array('leads_id' => $EXISTING_LEAD, 'date_change' => $ATZ, 'changes' => 'Registered AGAIN in Recruitment Service Page', 'change_by_id' => $EXISTING_LEAD, 'change_by_type' => 'client'));

				$where = "id = " . $EXISTING_LEAD;
				$db -> update('leads', array('password' => sha1($rand_pw), 'marked' => 'yes', 'marked_date' => $ATZ), $where);
				
				$this->sync_login_credentials($EXISTING_LEAD);

				if ($_POST['question']) {
					$db -> insert('leads_message', array('leads_id' => $EXISTING_LEAD, 'leads_type' => 'temp', 'date_created' => $ATZ, 'message' => $_POST['question']));
				}
				
				//UPDATE LEADS ADDRESS DETAIL
				$db->update('leads_address',$leads_address_data,$db->quoteInto('id=?',$EXISTING_LEAD));

				//End Existing lead
			} else {
				
				//New Lead
				//echo "LEAD DOES NOT EXIST ".$fname." ".$lname." ".$email;
				$data['password'] = sha1($rand_pw);
				
				
				//CHECK IF STATUS IS CUSTOM RECRUITEMENT - JOB ROLE COMES FROM ASL
				if(isset($data['status'])&&$data['status']=='custom recruitment'){
					//$_SESSION['service_type'] = 'ASL';
					$_SESSION['filled_up_visible'] = 0; //MAKE FILLED UP VISIBLE SET TO 0
				}
				
				//INSERT LEADS DETAIL
				$db -> insert('leads', $data);
				$leads_id = $db -> lastInsertId( 'leads' );
				$_SESSION['leads_id'] = $leads_id;
				
				
				// SYNC to login_credentials
				$base_api_url = "";
				
				if (TEST){
					$base_api_url = "http://test.api.remotestaff.com.au";
				}else{
					$base_api_url = "https://api.remotestaff.com.au";
				}
				
				// SYNC to login_credentials
				file_get_contents($base_api_url . "/mongo-index/sync-login-credentials?email=" . $data["email"] . "&tracking_code=leads_" . $data["email"]);
				
				
				
				
				//CHECK IF THERES ALREADY LEADS ADDRESS
				$leads_address_sql = $db -> select()
				
										 -> from( 'leads_address' )
										 
										 -> where( 'leads_id = ?', $leads_id );
										 
				$leads_address = $db -> fetchRow( $leads_address_sql );
				
				//CHECK IF LEADS ADDRESS ALREADY EXISTS
				if( $leads_address ) {
				
					//UPDATE LEADS ADDRESS
					$db -> update( 'leads_address', $leads_address_data, $db -> quoteInto( 'leads_id = ?', $leads_id ) );
					$leads_address_id = $leads_address['id'];
				
				} else {
					
					//INSERT LEADS ADDRESS
					$leads_address_data['leads_id'] = $leads_id;
					$db -> insert('leads_address', $leads_address_data);
					$leads_address_id = $db->lastInsertId( 'leads_address' );
					
				}
				
				
				
				
				//add lead history
				$db -> insert('leads_info_history', array('leads_id' => $leads_id, 'date_change' => $ATZ, 'changes' => 'Registered in Recruitment Service', 'change_by_id' => $leads_id, 'change_by_type' => 'client'));

				if ($_POST['question']) {
					$db -> insert('leads_message', array('leads_id' => $leads_id, 'leads_type' => 'regular', 'date_created' => $ATZ, 'message' => $_POST['question']));
				}

				$smarty = new Smarty();
				$rs_contact_nos = new Contact();
				$contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
				//Send Message to CouchDB Mailbox
				$smarty -> assign('leads_id', $leads_id);
				$smarty -> assign('data', $data);
				$smarty -> assign('question', $_POST['question']);
				$body = $smarty -> fetch('quote_and_callback_request.tpl');

				$attachments_array = NULL;
				$bcc_array = array('devs@remotestaff.com.au');
				// $cc_array[] = 'hiringmanagers@remotestaff.com.au';
				// $cc_array[] = 'walterf@remotestaff.com.au';
				$cc_array = array('hiringmanagers@remotestaff.com.au','walterf@remotestaff.com.au','fritzie@realestate.ph','louise@remotestaff.com.au');

				$from = 'Remotestaff<new_leads@remotestaff.com.au>';
				$html = $body;
				$subject = sprintf("%s %s Recruitment Service Job Specification Form Request", $_POST['fname'], $_POST['lname']);
				$text = NULL;
				$to_array = array('chrisj@remotestaff.com.au', );
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);

				//check the fullname if existing in the leads table. If existing make a note of it. "Might be identical to leads <leads id> <name> <email>";
				//CheckLeadsFullName($_SESSION['leads_id'], $data['first_name'], $data['last_name']);
				//End New Lead

				$smarty -> assign('rand_pw', $rand_pw);
				$smarty -> assign('admin_email', 'admin@remotestaff.com.au');
				$smarty -> assign('site', $_SERVER['HTTP_HOST']);
				$smarty -> assign('data', $data);
				$smarty->assign('contact_numbers', $contact_numbers);
				$body = $smarty -> fetch('quote_and_callback_request_autoresponder_for_leads.tpl');

				$attachments_array = NULL;
				$bcc_array = NULL;
				$cc_array = NULL;

				$from = 'Remotestaff<new_leads@remotestaff.com.au>';
				$html = $body;
				$subject = 'Thanks for Getting in touch with us';
				$text = NULL;
				if (TEST) {
					$to_array = array("devs@remotestaff.com.au");
				} else {
					$to_array = array($_REQUEST["email_address"]);

				}
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
				$this->CheckLeadsFullName($_SESSION["leads_id"], $data["fname"], $data["lname"]);
			}
		
		/*	
		}
		*/
		
        if (empty($errors)) {
            return array("success" => true);
        } else {
            return array("success" => false, "errors" => $errors);
        }

    }

    private function getALLfromIP($addr) {
        // this sprintf() wrapper is needed, because the PHP long is signed by default
        global $db;
        $ipnum = sprintf("%u", ip2long($addr));
        $query = "SELECT cc, cn FROM ip NATURAL JOIN cc WHERE ${ipnum} BETWEEN start AND end";
        $result = $db -> fetchRow($query);

        return $result;
    }

    private function getCCfromIP($addr) {
        $data = $this -> getALLfromIP($addr);
        if ($data)
            return $data['cn'];
        return false;
    }

    private function generatePassword() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $rand_pw = '';
        for ($p = 0; $p < 10; $p++) {
            $rand_pw .= $characters[mt_rand(0, strlen($characters))];
        }
        return $rand_pw;
    }

    private function CheckLeadsFullName($leads_id, $fname, $lname) {
        $_SESSION['leads_thesame_name_id'] = '';
        $AusTime = date("H:i:s");
        $AusDate = date("Y") . "-" . date("m") . "-" . date("d");
        $ATZ = $AusDate . " " . $AusTime;

        global $db;
        unset($_SESSION['leads_new_info_id']);
        unset($_SESSION['leads_thesame_name_id']);
        //global $fname;
        //global $lname;
        //if($_SESSION['leads_id']){
        //  $leads_id = $_SESSION['leads_id'];
        //}else{
        //  global $leads_id;
        //}

        $marked_counter = 0;
        $sql = "select id  from leads where fname like '" . $fname . "' and lname like '" . $lname . "' and status not in('REMOVED', 'Inactive') and id not in(" . $leads_id . ")";
        $existing_leads = $db -> fetchAll($sql);
        //echo "<pre>";
        //print_r($existing_leads);
        //echo "</pre>";

        if ($existing_leads) {
            foreach ($existing_leads as $existing_lead) {
                $data = array('leads_id' => $leads_id, 'existing_leads_id' => $existing_lead['id']);
                if ($leads_id != $existing_lead['id']) {
                    $marked_counter++;
                    $db -> insert('leads_indentical', $data);
                }
            }

        }

        if ($marked_counter > 0) {
            $_SESSION['leads_new_info_id'] = $leads_id;
            $data = array('marked' => 'yes', 'marked_date' => $ATZ);
            $where = "id = " . $leads_id;
            $db -> update('leads', $data, $where);
			
			$this->sync_login_credentials($leads_id);
			
            $_SESSION['leads_thesame_name_id'] = $leads_id;
        }

    }
    
    private function sync_login_credentials($leads_id){
    	$leads_info = $db->fetchRow(
			 	$db->select()
				->from("leads", array("email"))
				->where("id = ?", $leads_id)
			);
			
			if(!empty($leads_info)){
				
				// SYNC to login_credentials
				$base_api_url = "";
				
				if (TEST){
					$base_api_url = "http://test.api.remotestaff.com.au";
				}else{
					$base_api_url = "https://api.remotestaff.com.au";
				}
				
				// SYNC to login_credentials
				file_get_contents($base_api_url . "/mongo-index/sync-login-credentials?email=" . $leads_info["email"] . "&tracking_code=leads_" . $leads_info["email"]);
				
			}
    }

	private function getStep1(){
		
		//GET DB INSTANCE
		$db = $this->db;
		
		//PASS LEADS SESSIONS
		$leads_id = $_SESSION['leads_id'];

		//PULL LEADS DETAIL
		$leads_details_sql = $db->select()
							->from('leads')
							->where('id=?',$leads_id);
		$leads_details = $db->fetchRow($leads_details_sql);
		
		//SEND LEADS DETAIL
		$this->smarty->assign('leads_details',$leads_details);
		
	}
	
    private function _getALLfromIP($addr) {
		//GET DB INSTANCE
		$db = $this->db;
        $ipnum = sprintf("%u", ip2long($addr));
        $query = "SELECT cc, cn FROM ip NATURAL JOIN cc WHERE ${ipnum} BETWEEN start AND end";
        $result = $db->fetchRow($query);
        return $result;
    }
    
    private function _getCCfromIP($addr){
        $data = $this->_getALLfromIP($addr);
        if($data){
			return $data['cc']; //SHORTNAME
		}
        return false;
    }
    
    private function _getCountry($leads_country=''){
		
		//GET DB INSTANCE
		$db = $this->db;
		
		//CONSTRUCT COUNTRIES SQL
		$countries_sql = $db->select()
							->from('library_country');
		
		if(!empty($leads_country)){
			
			//CONSTRUCT COUNTRIES SQL
			$countries_sql = $countries_sql->where('sortname=?',$leads_country);

			//GET COUNTRY
			$country = $db->fetchRow($countries_sql);
			
			//RETURN COUNTRY
			return array('id'=>$country['id'],'name'=>$country['name']);
		
		} else {
			
			//GET COUNTRIES
			$countries = $db->fetchAll($countries_sql);
			
			//NEW COUNTRIES STORAGE VARIABLE
			$new_countries = array();
			
			//RECONSTRUCT COUNTRIES
			foreach($countries as $country){
				$new_countries[$country['id']] = $country['name'];
			}
			
			return $new_countries;
			
		}
		
	}
	
    private function _getState($country_id=0){
		
		//GET DB INSTANCE
		$db = $this->db;
		
		//CONSTRUCT STATES SQL
		$states_sql = $db->select()
							->from('library_state')
							->where('library_country_id=?',$country_id);
		//GET STATES
		$states = $db->fetchAll($states_sql);

		//NEW STATE STORAGE VARIABLE
		$new_states = array();
		
		//RECONSTRUCT STATE
		foreach($states as $state){
			$new_states[$state['id']] = $state['name'];
		}
		
		return $new_states;
		
	}

}
