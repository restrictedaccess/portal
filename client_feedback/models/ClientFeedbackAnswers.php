<?php
class ClientFeedbackAnswers extends Zend_Db_Table {
	protected $_name = "client_feedback_answers";
	
	public function fetch($fid = 0) {
		
		$select = $this->select()
		->from($this->_name, array('answers', 'comments', 'reply'))
		->where('feedback_id = ?', $fid);
		return $this->fetchRow($select)->toArray();
	}
	
	public function check_id($fid = 0) {
		$select = $this->select()
		->from($this->_name, array('id'))
		->where('feedback_id = ?', $fid);
		return $this->fetchRow($select) ? 1 : 0;
	}
}