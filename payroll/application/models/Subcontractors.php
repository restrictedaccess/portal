<?php
class Subcontractors extends Zend_Db_Table {
	protected $_name = "subcontractors";
	public $order_by = 's.id';
	
	public function get_inhouse_staff($userid = 0) {

		$select = $this->select()
		->setIntegrityCheck(false)
		->distinct('userid')
		->from( array('s'=>$this->_name), array('contract_id'=>'id') )
		->joinLeft( array('p'=>'personal'), 's.userid=p.userid', array('userid','fname','lname','email'))
		->joinLeft( array('pay'=>'payroll_hourlyrate'), 's.userid=pay.uid',
				   array('hourly_rate'=>'IF(hourly_rate IS NULL, "00.0000", hourly_rate)'))
		->where('leads_id=?', 11)
		->where('s.status=?', 'active')
		->order($this->order_by);
		if( $userid ) $select->where('s.userid=?', $userid);
		return $this->fetchAll($select)->toArray();
	}
}
?>