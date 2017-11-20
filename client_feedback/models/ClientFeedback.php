<?php
class ClientFeedback extends Zend_Db_Table {
	protected $_name = 'client_feedback';
	public $from_date;
	
	public function fetch_feedback($hash = '', $where = array()) {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('f'=>$this->_name), array('id', 'leads_id', 'hash', 'status'=>"IF(f.status='0','Not Filled', 'Filled')",
											   'form_created'=>"date_format(f.date_created, '%b %d, %Y')") )
		->joinLeft(array('l'=>'leads'), 'f.leads_id=l.id', array('fname', 'lname', 'email') )
		->joinLeft(array('t'=>'tickets_info'), 'f.ticket_id=t.id', array('ticket_id'=>'id','ticket_title', 'date_created'=>"date_format(from_unixtime(date_updated), '%b %d, %Y')") )
		->joinLeft(array('a'=>'admin'), 't.csro=a.admin_id', array('admin_id', 'admin_fname', 'admin_lname', 'signature_notes', 'signature_contact_nos', 'signature_websites') )
		->joinLeft(array('fa'=>'client_feedback_answers'), 'f.id=fa.feedback_id', array('answers', 'comments', 'reply') )
		->group('f.ticket_id');
		if( $hash ) $select->where('f.hash = ?', $hash);
		
		if( count($where)) {
			foreach( $where as $item )
			$select->where($item);
		}
		//if( $group ) $select->group($group);
		//echo $select->__toString();
		return $this->fetchAll($select)->toArray();
	}
	
	public function get_hash($leads_id = 0, $ticket_id = 0) {
		$select = $this->select()
		->from($this->_name, array('hash'))
		->where('leads_id = ?', $leads_id)
		->where('ticket_id = ?', $ticket_id);
		$ret = $this->getDefaultAdapter()->fetchOne($select);
		return  $ret ? $ret : false;
	}
	
	public function fetch_admin($hash = '') {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('f'=>$this->_name), array('id', 'leads_id') )
		->joinLeft(array('t'=>'tickets_info'), 'f.ticket_id=t.id', array() )
		->joinLeft(array('a'=>'admin'), 't.csro=a.admin_id',
				   array('admin_id','admin_fname', 'admin_lname', 'admin_email', 'signature_notes', 'signature_contact_nos', 'signature_websites') )
		->group('a.admin_id');
		if( $hash) $select->where('f.hash = ?', $hash);
		
		return $this->fetchAll($select)->toArray();
	}
	
	public function clients($hash = '') {
		$select = $this->select()
		->setIntegrityCheck(false)
		->from(array('f'=>$this->_name), array() )
		->joinLeft(array('l'=>'leads'), 'f.leads_id=l.id', array('id', 'fname', 'lname') )
		->group('l.id');
		//->where('f.hash = ?', $hash);
		//->where('f.id = ?', $id);
		return $this->fetchAll($select)->toArray();
	}
}