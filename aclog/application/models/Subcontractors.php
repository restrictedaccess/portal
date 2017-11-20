<?php
class Subcontractors extends Zend_Db_Table {
	protected $_name = "subcontractors";
	public $order_by = 's.id';
	
	public function fetch_staff($userid = 0) {

		$select = $this->select()
		->setIntegrityCheck(false)
		->distinct('userid')
		->from( array('s'=>$this->_name), array('contract_id'=>'id', 'leads_id') )
		->joinLeft( array('p'=>'personal'), 's.userid=p.userid', array('userid','fname','lname','email'))
		->where('s.status=?', 'active')
		->where('s.userid = ?', $userid)
		->order($this->order_by);
		
		return $this->fetchRow($select)->toArray();
	}
}
?>