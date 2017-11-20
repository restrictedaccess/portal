<?php
class ActivityLogsHistory extends Zend_Db_Table {
	protected $_name = "activity_logs_history";
	
	public function pause_count($aid) {
		$select = $this->select()
		->from($this->_name, "COUNT( IF(status='paused',1,null) )" )
		->where('aid=?', $aid);
		return $this->getDefaultAdapter()->fetchOne($select);
	}
	
	public function last_started($aid) {
		$select = $this->select()
		->from($this->_name, 'date_added' )
		->where('aid=?', $aid)
		->where('status=?', 'ongoing')
		->order('id DESC')
		->limit('1');
		return $this->getDefaultAdapter()->fetchOne($select);
	}
	
	public function last_status($aid) {
		$select = $this->select()
		->from($this->_name, 'status' )
		->where('aid=?', $aid)
		->order('id DESC')
		->limit('1');
		return $this->getDefaultAdapter()->fetchOne($select);
	}
}