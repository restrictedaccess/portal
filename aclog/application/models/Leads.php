<?php
class Leads extends Zend_Db_Table {
	protected $_name = "leads";
	
	public function fetch_staff($userid = 0) {

		$select = $this->select()
		->distinct('id')
		->from( $this->_name, array( 'leads_id'=>'id', 'fname', 'lname', 'email', 'status'))
		->where('status = ?', 'Client')
		->where('id = ?', $userid);
		
		return $this->fetchRow($select)->toArray();
	}
}
?>