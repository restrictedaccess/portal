<?php
class Subcontractors extends Zend_Db_Table {
	protected $_name = "subcontractors";
	
	public function work_schedule($date_of_week) {
		//$date_of_week = strtolower(date("D"));
		$select = $this->select()
		->from( array('s'=>$this->_name), array('id', 'leads_id', 'userid', $date_of_week.'_start', 'staff_working_timezone', $date_of_week.'_lunch_number_hrs',
								   'start_work' => "time(convert_tz( concat(date(now()),' ',{$date_of_week}_start), staff_working_timezone, 'Asia/Manila' ))",
								   'finish_work' => "time(convert_tz( concat(date(now()),' ',{$date_of_week}_finish), staff_working_timezone, 'Asia/Manila' ))"))
		->where($date_of_week.'_start is not NULL')
		->where($date_of_week.'_start != ?', '00:00:00')
		->where('status = ?', 'ACTIVE');
		echo $select->__toString();
		return $this->fetchAll($select)->toArray();
	}
}