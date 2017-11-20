<?php
class Workflow extends Zend_Db_Table {
	protected $_name = "workflow";
	
	public function fetch_tasks($owner_id = 0, $owner_type = 'none') {

		$select = $this->select()
		->setIntegrityCheck(false)
		->from( array('w'=>$this->_name), array( 'id', 'work_details'))
		->joinLeft( array('o'=>'workflow_owner'), 'w.id=o.workflow_id', array() )
		->where('o.owner_id = ?', $owner_id)
		->where('w.status = ?', 'new')
		->order('w.id DESC');
		//->where('o.owner_type = ?', $owner_type);
		//echo $select->__toString();
		return $this->fetchAll($select)->toArray();
	}
	
	
	public function client_tasks($id) {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from( array('w'=>$this->_name), array( 'id', 'work_details'))
		->joinLeft( array('o'=>'workflow_owner'), 'w.id=o.workflow_id', array() )
		->where('w.client_id = ?', $id)
		->where("w.id NOT in (select workflow_id from workflow_owner)")
		->where('w.status = ?', 'new')
		->order('w.id DESC');
		return $this->fetchAll($select)->toArray();
	}
}
?>