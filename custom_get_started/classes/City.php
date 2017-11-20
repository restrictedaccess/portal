<?php

class City {

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
		$state_id = $_POST['state_id'];
		
		//SET DEFAULT VARIABLES
		$success = true;
		$result = array();
		$error_message = array();
		
		/*
		$validator = new Zend_Validate_Int();
		if (!$validator->isValid($state_id)){
			$error_message = $validator->getMessages();
			$success = false;
		}
		*/
		
		//CITY SQL
		$cities_sql = $db->select()
						->from('library_city')
						->where('library_state_id=?',$state_id);
		
		//FETCH ALL CITY
		$cities = $db->fetchAll($cities_sql);
		
		//NEW CITY STORAGE VARIABLE
		$new_cities = array();
		
		//RECONSTRUCT CITY
		foreach($cities as $city){
			$new_cities[$city['id']] = $city['name'];
		}
		
		//SEND RESPONSE
		echo json_encode(array('success'=>$success,'result'=>$new_cities,'error_message'=>$error_message));
		exit;
		
    }

}
