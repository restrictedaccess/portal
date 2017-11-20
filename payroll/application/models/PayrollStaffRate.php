<?php
class PayrollStaffRate extends Zend_Db_Table {
	protected $_name = "payroll_hourlyrate";
	
	public function is_exists($uid) {
		$select = $this->select()
		->from($this->_name, array('cnt'=>'COUNT(*)'))
		->where('uid=?', $uid);
		return $this->getAdapter()->fetchOne($select) > 0 ? true : false;
	}
}
?>