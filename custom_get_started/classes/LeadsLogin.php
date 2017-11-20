<?php

class LeadsLogin {

	//MAKE DB INSTACE GLOBAL INSIDE CLASS
    private $db;
    
    //CONSTRUCT
    public function __construct($db){
		$this->db = $db;
    }

	//PROCESS
    public function process(){
    
		//GET DB INSTANCE
		$db = $this->db;
		
		//GET PARAMATERS
		$email = $_POST['leads_email'];
		$password = $_POST['leads_password'];
		
		//SET DEFAULT VARIABLES
		$success = true;
		$result = array();
		$error_message = array();
		
		//CREATE VALIDATOR INSTANCE
		$validator = new Zend_Validate_EmailAddress();
		if (!$validator->isValid($email)){
			$error_message = $validator->getMessages();
			$success = false;
		}
		
		//CONSTRUCT LEADS SQL
		$lead_sql = $db->select()
					   ->from('leads')
					   ->where('email=?',$email)
					   ->where('password=?',SHA1($password))
					   ->where("status NOT IN ('deleted', 'REMOVED', 'transferred')");
		
		//GET LEAD DATA
		$lead = $db->fetchRow($lead_sql);
		
		//IF LEAD EXISTS
		if ($lead){
		
			//PASS LEAD INFO IN RESULT
			$result['lead'] = $lead;
			
			//CREATE SESSION
			$_SESSION['client_id'] = $lead['id'];
			$_SESSION['emailaddr'] = $email;
			$_SESSION['logintype'] = 'client';
			$_SESSION['clienttype'] = 'main_client';
			
			//SET SUCCESS TO TRUE
			$success = true;
			
			//LOG LEAD LOGIN DATA
			$logs = array(
				'leads_id' => $_SESSION['client_id'],
				'log_date' => date("Y-m-d H:i:s"), 
				'browser' => $_SERVER['HTTP_USER_AGENT'], 
				'ip' => $_SERVER['REMOTE_ADDR'], 
				'page' => $_SERVER['SCRIPT_FILENAME']
			);
			
			$db->insert('client_logs', $logs);
			
		} else {
		
			//SET SUCCESS TO FALSE
			$success = false;
			$error_message = array('Account doesn\'t exists!');
			
		}
		
		//SEND RESPONSE
		echo json_encode(array("success"=>$success,'result'=>$result,'error_message'=>$error_message));
		exit;

    }

}
