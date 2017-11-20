<?php

class State {

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
		
		//GET PARAMATER
		$country_id = $_POST['country_id'];
		
		//SET DEFAULT VARIABLES
		$success = true;
		$result = array();
		$error_message = array();
		
		/*
		$validator = new Zend_Validate_Int();
		if (!$validator->isValid($country_id)){
			$error_message = $validator->getMessages();
			$success = false;
		}
		*/
		
		//STATE SQL
		$states_sql = $db->select()
						->from('library_state')
						->where('library_country_id=?',$country_id);
		
		//FETCH ALL STATE
		$states = $db->fetchAll($states_sql);
		
		//NEW STATE STORAGE VARIABLE
		$new_states = array();
		
		//RECONSTRUCT STATE
		foreach($states as $state){
			$new_states[$state['id']] = $state['name'];
		}
		
		//SEND RESPONSE
		echo json_encode(array('success'=>$success,'result'=>$new_states,'error_message'=>$error_message));
		exit;
		
    }

}
