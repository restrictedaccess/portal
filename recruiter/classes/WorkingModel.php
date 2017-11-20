<?php
class WorkingModel{
	
	private $db;
	
	public function __construct($db){
		$this->db = $db;
	}
	
	public function render(){
		return $this->update_working_process();
	}

	private function update_working_process(){
		
		$db = $this->db;
		
		//CONSTRUCT WORKING MODEL
		$working_model = array(
			'userid' => $_POST['userid'],
			'working_model' => $_POST['working_model'],
			'date_created' => new Zend_Db_Expr('NOW()')
		);
		
		//PULL WORKING MODEL OLD
		$personal_working_model_sql = $db->select()
									->from('personal_working_model')
									->where('userid=?',$_POST['userid']);
		$personal_working_model = $db->fetchRow($personal_working_model_sql);
		
		//CHECK IF THERE'S ALREADY RECORD
		if($personal_working_model){
			$db->update('personal_working_model',$working_model,$db->quoteInto('userid=?',$_POST['userid'])); 
		}else{
			$db->insert('personal_working_model',$working_model);
		}
		
		//ADD HISTORY
		$this->update_history($personal_working_model['working_model']);
		
		//ECHO JSON
		return array('success'=>true);
		
	}
	
	private function update_history($old_working_model = 'home_based'){ 
		
		$db = $this->db;
		
		//PULL WORKING MODEL
		$working_model_sql = $db->select()
							->from('personal_working_model','working_model')
							->where('userid=?',$_POST['userid']);
		$working_model = $db->fetchOne($working_model_sql);
		
		//CHECK IF OLD WORKING MODEL IS EMPTY
		if($old_working_model == ''){
			$changes = 'Home Based to ' . ucwords(str_replace('_',' ',$working_model));
		}else{
			$changes = ucwords(str_replace('_',' ',$old_working_model)) . ' to ' . ucwords(str_replace('_',' ',$working_model));
		}

		//CONTRUCT HISTORY DATA
		$data= array(
			'userid' => $_POST['userid'],
			'change_by_id' => $_SESSION['admin_id'],
			'change_by_type' => 'ADMIN',
			'changes' => 'Change working model from ' . $changes,
			'date_change' => date("Y-m-d")." ".date("H:i:s")
		);
		
		//INSERT INTO STAFF HISTORY
		$db->insert('staff_history', $data);
	}
}
