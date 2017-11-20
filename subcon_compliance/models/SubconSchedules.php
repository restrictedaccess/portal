<?php
class SubconSchedules extends Zend_Db_Table {
	protected $_name = 'subcon_schedules';
	public $from_date;
	
	public function fetch_schedule($dow, $time, $csro_fld = false, $userid = 0) {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('ss'=>$this->_name), array('contract_id', 'leads_id','userid', 'dayofweek', 'dow_start') )
		->joinLeft( array('p'=>'personal'), 'ss.userid=p.userid', array('fname', 'handphone_country_code', 'handphone_no'))
		->joinLeft( array('lr'=>'leave_request'), 'ss.userid=lr.userid',
				   array("leave_status"=>"(select ld.status from leave_request lr2 LEFT JOIN leave_request_dates ld ON lr2.id=ld.leave_request_id
							where lr2.userid=lr.userid and ld.date_of_leave=date(now()) order by lr2.id DESC limit 1)"))
		->joinLeft(array('s'=>'subcontractors'), 'ss.contract_id=s.id', array())
		->where('ss.dayofweek = ?', $dow)
		->where('ss.dow_start = ?', $time.':00')
		->where('s.status = ?', 'ACTIVE')
		->group('ss.userid');
		if( $userid) $select->where('ss.userid=?', $userid);
		
		if( $csro_fld ) {
			$select->joinLeft(array('l'=>'leads'), 'ss.leads_id=l.id', array() )
			->joinLeft(array('a'=>'admin'), 'l.csro_id=a.admin_id', array('admin_fname') );
		}
		$select->having('leave_status != ?', 'approved')
		->orHaving('leave_status is NULL');
		
		//echo $select->__toString();
		return $this->fetchAll($select)->toArray();
	}
	
	public function record_exist($cid, $dow, $start_time = '') {
		$select = $this->select()
		->from($this->_name, array('dow_start'))
		->where('contract_id = ?', $cid)
		->where('dayofweek = ?', $dow);
		//->where('dow_start = ?', $start_time);
		
		return $this->getAdapter()->fetchOne($select);
	}
	
	public function subs_name_mobile($userid = 5490) {
		$aData = array();
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('s'=>$this->_name), array('leads_id') )
		->joinLeft( array('p'=>'personal'), 's.userid=p.userid', array('fname', 'handphone_country_code', 'handphone_no'))
		->where('s.userid = ?', $userid)
		->group('s.userid');
		//echo $select->__toString();
		$data = $this->fetchRow($select);
		if( is_object($data))
			$aData = $data->toArray();
			
		return $aData;
	}
	
}