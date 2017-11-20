<?php
class TicketInfo extends Zend_Db_Table {
	protected $_name = "tickets_info";
	
	public function fetch_tickets($csro = 0) {
		$select = $this->select()
		->from($this->_name, array('id', 'ticket_title'))
		->where('ticket_status != ?', 'deleted');
		if( $csro ) $select->where('csro = ?', $csro);
		return $this->fetchAll($select)->toArray();
	}
}