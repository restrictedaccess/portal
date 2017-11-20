<?php
class ComplianceSmsNotices extends Zend_Db_Table {
	protected $_name = "compliance_sms_notices";
	
	public function is_exists($mobileno, $notice, $date_reported) {
		$select = $this->select()
		->from($this->_name, 'id')
		->where('mobileno=?', $mobileno)
		->where('notice=?',$notice)
		->where('date_reported=?',$date_reported);
									
		return $this->getDefaultAdapter()->fetchOne($select);
	}
	
	public function fetch_records($where = array()) {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('s'=>$this->_name), array('userid', 'mobileno', 'notice', 'date_created', 'date_reported'))
		->joinLeft( array('p'=>'personal'), 's.userid=p.userid', array('fname','lname'));
		
		if( count($where)) {
			foreach( $where as $item )
			$select->where($item);
		}
		return $this->fetchAll($select)->toArray();
	}
	
	public function fetch_subcons() {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('s'=>$this->_name), array('userid'))
		->joinLeft( array('p'=>'personal'), 's.userid=p.userid', array('fname','lname'))
		->group('s.userid');
		return $this->fetchAll($select)->toArray();
	}
}