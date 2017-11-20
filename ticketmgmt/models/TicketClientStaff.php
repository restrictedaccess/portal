<?php

/* class_users.php 2012-03-12 $ */
//include '../portal/lib/validEmail.php';

class TicketClientStaff {
    private $db;
	private $table = 'ticket_clientstaff';

    private $userid;
	
	public $user_info;
	public $user_exists;
	public $is_error;
	private static $instance = NULL;
	
	public $log;
	
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }
    
    function __construct($db) {
        $this->db = $db;

    }
	
	public function user_create($ticket_id, $admin_id, $data = array(), $tblfld = 'leads.id') {
		$cnt = count($data);
		//$cnt2 = count($staff);
		$user_type = ($tblfld == 'leads.id') ? 'Client' : 'Staff';
		for( $i = 0; $i < $cnt; $i++ ) {
			if( empty($data[$i]) || !is_numeric($data[$i])) continue;
			
			$date_created = time();
				
			$user_id = $data[$i];
			//$staff_id = $staff[$i];
			if( $this->db->fetchOne("SELECT userid FROM ".$this->table
				." WHERE userid=$user_id AND ticket_id=$ticket_id") != "" ) continue;
			
			// insert data
			$insert_data = array('ticket_id' => $ticket_id, 'date_created' => $date_created,
				'userid' => $user_id, 'ref_table' => $tblfld);
			
			if(	$this->db->insert($this->table, $insert_data) ) {
                $this->log->log_insert( array('ticket_id' => $ticket_id, 'admin_id' => $admin_id,
						'field_update' => serialize(array($user_type.' added' => $user_id, 'date_updated' => $date_created)) ) );
			}
			
			
			
			//insert staff
			/*$insert_data = array('ticket_id' => $ticket_id, 'date_created' => $date_created,
				'userid' => $staff_id, 'ref_table' => 'personal.userid');
			$this->db->insert($this->table, $insert_data);*/
			
		}
		return $this->db->lastInsertId($this->table);	
	}
	
	public function user_update($ticket_id, $clients = array(), $staff = array()) {
		$cnt1 = count($clients);
		$cnt2 = count($staff);
		$cnt = ($cnt1 > $cnt2) ? $cnt1 : $cnt2;
		for( $i = 0; $i < $cnt; $i++ ) {
			if( empty($clients[$i]) && empty($staff[$i]) ) continue;
			
			$date_created = time();
				
			$client_id = $clients[$i];
			$staff_id = $staff[$i];
			
			// insert client
			$insert_data = array('ticket_id' => $ticket_id, 'date_created' => $date_created,
				'userid' => $client_id, 'ref_table' => 'leads.id');
			$this->db->insert($this->table, $insert_data);
			
			//insert staff
			$insert_data = array('ticket_id' => $ticket_id, 'date_created' => $date_created,
				'userid' => $staff_id, 'ref_table' => 'personal.userid');
			$this->db->insert($this->table, $insert_data);
			
		}
		return $this->db->lastInsertId($this->table);	
	}
		
	public function fetch_users($where = NULL) {
		$query = "SELECT id, userid, ref_table FROM " .$this->table;
		if( $where !== NULL ) $query .= " WHERE $where";
		
		$users = $this->db->fetchAll($query);
		
		$user_array = array();
		foreach($users as $a => $v) {
			$ref_table = explode('.', $v['ref_table']);
			$qry = 'SELECT '.$v['id'].' uid, '.$ref_table[1].', fname, lname, email FROM '.$ref_table[0].' WHERE '.$v['ref_table'].'='.$v['userid'];
			//	->from($ref_table[0] , array($ref_table[1], 'fname', 'lname'))
			//	->where($v['ref_table'].'='.$v['userid']);
			array_push($user_array, $this->db->fetchRow($qry));
		}
		return $user_array;
	}
	
	public function fetch_users_add($id, $fld, $table) {
		$query = "SELECT $fld, fname, lname, email FROM $table WHERE $fld=$id";	
		return $this->db->fetchAll($query);
	}
	
}



?>