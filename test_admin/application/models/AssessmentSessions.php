<?php
class AssessmentSessions extends Zend_Db_Table {
	protected $_name = "assessment_sessions";
	
	public function if_exists($uid, $url) {
		$select = $this->select()
			->from( $this->_name, 'id' )
			->where('kas_url=?', $url)
			->where('uid=?', $uid);
			
		$session = $this->fetchRow($select);
		//if( $session !== NULL ) $session = $res->toArray();
		return $session !== NULL ? 1 : 0;
	}
}
?>