<?php

class TicketTypes
{
	private $table = 'ticket_types';
	private $db;
	
	public static $instance = NULL;
	
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }
	
    // dispatch request to the appropriate controller/method
    function __construct($db) {
		$this->db = $db;
    }	
	public function fetch_all() {
		$sql = $this->db->select()->from($this->table)->order('type_name');
        return $this->db->fetchAll($sql);
	}
	
	public function create() {
	}
	
	public function edit() {
	}
}// End ticketTypes class