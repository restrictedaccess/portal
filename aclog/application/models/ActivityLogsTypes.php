<?php
class ActivityLogsTypes extends Zend_Db_Table {
	protected $_name = "activity_logs_types";
	
	public function fetch_types($leads_id = 11) {
		$select = $this->select()
		->from( array('t'=>$this->_name), array( 'id', 'type_value',
									'cnt'=>"(select COUNT(category) FROM activity_logs l where l.category=t.type_value )"))
		->where('client_id = ?', $leads_id);
		return $this->fetchAll($select)->toArray();
	}
}
?>