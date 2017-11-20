<?php
class ActivityLogs extends Zend_Db_Table {
	protected $_name = "activity_logs";
	
	public function is_exists($uid) {
		$select = $this->select()
		->from($this->_name, array('cnt'=>'COUNT(*)'))
		->where('userid=?', $uid);
		return $this->getAdapter()->fetchOne($select) > 0 ? true : false;
	}
	
	public function fetch_logs($userid, $from=null, $to=null) {
		$now = date('Y-m-d H:i:s');
		$select1 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid', 'time_started'=>"DATE_FORMAT(activity_started, '%H:%i:%s')", 'time_ended'=>"DATE_FORMAT(activity_ended, '%H:%i:%s')",
								   "activity_date"=>"DATE_FORMAT(activity_started, '%b %d, %Y')", 'activity_status', 'category', 'activity_details',
								   "time_diff"=>"IF(activity_ended, timediff(activity_ended, activity_started), timediff('{$now}', activity_started) )") )
		->joinLeft( array('p'=>'personal'), 'p.userid=l.userid', array('fname', 'lname', 'email') )
		->where('l.userid = ?', $userid)
		->where('l.reference = ?', 'personal');
		
		$select2 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid', 'time_started'=>"DATE_FORMAT(activity_started, '%H:%i:%s')", 'time_ended'=>"DATE_FORMAT(activity_ended, '%H:%i:%s')",
								   "activity_date"=>"DATE_FORMAT(activity_started, '%b %d, %Y')", 'activity_status', 'category', 'activity_details',
								   "time_diff"=>"IF(activity_ended, timediff(activity_ended, activity_started), timediff('{$now}', activity_started) )") )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.userid', array('fname'=>'admin_fname', 'lname'=>'admin_lname', 'email'=>'admin_email') )
		->where('l.userid = ?', $userid)
		->where('l.reference = ?', 'admin');
		
		if( $from == null && $to == null) {
			$select1->where("date(activity_started) = date('{$now}')");
			$select2->where("date(activity_started) = date('{$now}')");
		}
		
		
		$union = $this->getDefaultAdapter()->select()
		->union( array( $select1, $select2) );
		//->order('id DESC');

		//echo '<br/>'.$union->__toString();
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$stmt = $db->query($union);
		//$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		$result = $stmt->fetchAll();
		return $result; //$this->fetchAll($union)->toArray();
	}
	
	public function elapsed_time($id) {
		$select = $this->select()
		->from($this->_name, array('time_ended'=>"DATE_FORMAT(activity_ended, '%H:%i:%s')", "elapsed_time"=>"timediff(activity_ended, activity_started)") )
		->where('id=?', $id);
		return $this->fetchRow($select)->toArray();
	}
}
?>