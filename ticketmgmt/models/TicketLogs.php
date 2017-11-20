<?php

/* ticketLogs.php 2012-04-13 $ */
//include '../portal/lib/validEmail.php';

class TicketLogs {
    private $db;
	private $table = 'ticket_logs';

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
	
	public function log_insert($data_array = array()) {
	  $this->db->insert($this->table, $data_array);
	  return $this->db->lastInsertId($this->table);	
	}
		
	public function fetchAll($where = '') {
		//$date_qstr = $this->utils->format_date('date_uploaded', '%Y-%m-%d %H:%i');
		$query = "SELECT l.ticket_id, l.field_update, a.admin_fname admin FROM ".$this->table." l
			LEFT JOIN admin a ON a.admin_id=l.admin_id
			LEFT JOIN tickets_info i ON i.id=l.ticket_id
			WHERE l.id = (select max(sub.id) from ticket_logs sub 
			where sub.ticket_id=l.ticket_id)";
		if( $where ) $query .= " and $where";
		
		$result = $this->db->fetchAll($query);
		
		$total_array = array();
        foreach( $result as $res ) {
			$total_array[ $res['ticket_id'] ] = array('field_update' => $res['field_update'], 'admin' => $res['admin_fname']);
        }
		return $total_array;
	}
	
	public function resolved_date($id) {
		$query = "SELECT field_update FROM ".$this->table." where
		ticket_id=$id AND (field_update LIKE '%\"Resolved\"%' OR field_update LIKE '%\"Closed\"%') LIMIT 1";
		$result = $this->db->fetchOne($query);
		return unserialize($result);
	}
	
	public function case_created_by($id) {
		$query = "SELECT a.admin_fname FROM ".$this->table." l
		LEFT JOIN admin a ON a.admin_id=l.admin_id where
		ticket_id=$id AND (field_update LIKE '%\"Case created\"%' OR field_update LIKE '%\"Case\"%')";
		return $this->db->fetchOne($query);
	}
	
	public function fetchHistory($id, $fldname = NULL, $order = 'DESC') {
		$query = "SELECT l.id, l.field_update, a.admin_fname FROM ".$this->table." l
			LEFT JOIN admin a ON a.admin_id=l.admin_id
			WHERE l.ticket_id=$id ";
			
		if( $fldname !== NULL ) $query .= "AND field_update LIKE '%\"$fldname\"%' ";
		
		$query .= "ORDER BY l.id $order";
		$history = $this->db->fetchAll($query);
		
		$total_array = array();
		for($i = 0; $i < count($history); $i++) {
			$logs = unserialize($history[$i]['field_update']);
			$updates_array = array();
			foreach( $logs as $k => $v ) {
				if( $fldname !== NULL && $k != 'date_updated' && $fldname != $k) continue;
				
				if( $k != 'date_updated') {
					$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $v);
					$str = preg_replace('/\\\/', '', $str);
					$str = str_replace("/\s+/", '&nbsp;', $str);
					array_push($updates_array, ($fldname === NULL) ? ucfirst($k). ' => '.$str : $str);
				}
			}
			
			$history[$i]['date_updated'] =  date("m/d/Y H:i:s", $logs['date_updated']);
			$history[$i]['field_update'] = implode('<br/>', $updates_array);
        }

		return $history;
	}
}