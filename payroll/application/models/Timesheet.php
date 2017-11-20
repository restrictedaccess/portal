<?php
class Timesheet extends Zend_Db_Table {
	protected $_name = "timesheet";
	
	public $month_year;
	public $day_start;
	public $day_end;
	
	public function staff_timesheet_details() {

		$select = $this->select()
		->setIntegrityCheck(false)
		//->distinct('userid')
		->from( array('s'=>$this->_name), array('id') )
		->join( array('p'=>'personal'), 's.userid=p.userid', array('userid','fname','lname','email'))
		->where('leads_id=?', 11)
		->where('s.status=?', 'active');
		return $this->fetchAll($select)->toArray();
	}
}
?>