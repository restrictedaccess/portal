<?php
class AssessmentLists extends Zend_Db_Table {
	protected $_name = "assessment_lists";
	
	public function get_categories() {
		$qry = $this->select()
		->from($this->_name, 'assessment_category')
		->where('status = ?', 'active')
		->group('assessment_category');
		return $this->fetchAll($qry)->toArray();
	}
}
?>