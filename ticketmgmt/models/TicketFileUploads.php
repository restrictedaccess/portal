<?php

/* ticketCommunications.php 2012-04-09 $ */
//include '../portal/lib/validEmail.php';

class TicketFileUploads {
    private $db;
	private $table = 'ticket_fileuploads';

	public $files;
	public $user_exists;
	public $is_error;
	private static $instance = NULL;
	
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }
    
    function __construct($db) {
        $this->db = $db;
		$this->utils = Utils::getInstance();
		$this->utils->db = $db;
    }
	
	public function file_insert($data_array = array()) {
	  $this->db->insert($this->table, $data_array);
	  return $this->db->lastInsertId($this->table);	
	}
		
	public function fetchAll($where = NULL) {
		$date_qstr = $this->utils->format_date('date_uploaded', '%Y-%m-%d %H:%i');
		$query = "SELECT filepath, $date_qstr date FROM " .$this->table;
		if( $where !== NULL ) $query .= " WHERE $where";
		$result = $this->db->fetchAll($query);
		
		for($i = 0; $i < count($result); $i++) {
			$result[$i]['fname'] = str_replace("/", "", strrchr($result[$i]['filepath'], "/"));
		}
		return $result;
	}
	
}