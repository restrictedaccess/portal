<?php

/* ticketCommunications.php 2012-04-09 $ */
//include '../portal/lib/validEmail.php';

class TicketCommunications {
    private $db;
	private $table = 'ticket_communications';

    private $userid;
	
	public $user_info;
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
	
	public function note_create($data_array = array()) {
		try {
			$this->db->insert($this->table, $data_array);
		} catch (Exception $e){
			return $e->getMessage();
		}
	  
		return $this->db->lastInsertId($this->table);	
	}
	
	public function email_create($data_array = array()) {
		try {
			$this->db->insert($this->table, $data_array);
		} catch (Exception $e){
			return $e->getMessage();
		}
	  return $this->db->lastInsertId($this->table);	
	}
	
	public function email_compose() {
	  $this->db->insert($this->table, $data_array);
	  return $this->db->lastInsertId($this->table);
	}
	
	public function noteticket_update($ticket_id, $notes_id = array()) {
		foreach( $notes_id as $idx => $id ) {
			$this->db->update($this->table, array('ticket_id' => $ticket_id ), 'id='.$id);	
		}
	}
		
	public function fetchAll($where = NULL) {
		$date_qstr = $this->utils->format_date('date_created', '%Y-%m-%d');
		$time_qstr = $this->utils->format_date('date_created', '%H:%i:%s');
		$query = "SELECT id, content, $date_qstr date, $time_qstr time, a.admin_fname sender FROM "
		.$this->table . " c LEFT JOIN admin a ON a.admin_id=c.sender";
		if( $where !== NULL ) $query .= " WHERE $where";
		$result = $this->db->fetchAll($query);
		
		for($i = 0; $i < count($result); $i++) {
			//$result[$i]['content'] = nl2br(stripslashes($result[$i]['content']));
			$stripped_content = stripslashes($result[$i]['content']);
			$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $stripped_content);
			$str = preg_replace('/\\\/', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);
			$result[$i]['content'] = $str;
		}
		return $result;
	}
	
}



?>