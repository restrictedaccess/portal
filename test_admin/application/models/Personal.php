<?php
class Personal extends Zend_Db_Table {
	protected $_name = "personal";
	
	
	public function get_user($emailaddr){
		$result = $this->fetchRow(
			$this->select()
			->from($this->_name, array("userid"))
			->where("email = ?", $emailaddr)
		);
		
		$candidate_id = 0;
		$result = $result->toArray();
		if(!empty($result)){
			$candidate_id = $result["userid"];
		}
		
		return $candidate_id;
		
	}
}
?>