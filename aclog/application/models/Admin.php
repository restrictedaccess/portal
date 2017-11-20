<?php
class Admin extends Zend_Db_Table {
	protected $_name = "admin";
	public $order_by = 'a.id';
	
	public function fetch_staff($userid = 0) {

		$select = $this->select()
		->distinct('admin_id')
		->from( $this->_name, array( 'admin_id', 'userid', 'fname'=>'admin_fname', 'lname'=>'admin_lname', 'email'=>'admin_email', 'status',
									new Zend_Db_Expr('"11" as leads_id')))
		->where('status NOT IN (?)', array('REMOVED', 'PENDING'))
		->where('admin_id = ?', $userid);
		
		return $this->fetchRow($select)->toArray();
	}
}
?>