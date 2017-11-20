<?php

/* ticketLogs.php 2012-04-13 $ */
//include '../portal/lib/validEmail.php';

class ReportLogs {
    private $db;
	private $table = 'bugreport_logs';

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
		$last_id = 0;
		// record bug report update_date
		if( $this->db->update('bug_reports', array('update_date' => date("Y-m-d H:i:s")), 'id='.$data_array['report_id']) ) {
			$last_id = $this->db->lastInsertId($this->table);
		}
		// 2013-07-04 always send auto responder
		$report = new BugReports($this->db, $data_array['report_id']);
		$report->send_autoresponder($data_array['report_id']);
		
		return $last_id;
	}
		
	public function lastUpdate($val = 'max', $id = 0, $limit = 'LIMIT 1') {
		//$date_qstr = $this->utils->format_date('date_uploaded', '%Y-%m-%d %H:%i');
		$query = "SELECT l.id, l.report_id, l.field_update, l.userid, l.ref FROM ".$this->table." l
			where l.id = (select $val(sub.id) from ".$this->table." sub where sub.report_id=l.report_id)";
		if( $id > 0 ) $query .= " and l.report_id=$id";
		
		$query .= " $limit";
		
		$result = $this->db->fetchAll($query);

		$total_array = array();
        for( $i=0, $len=count($result); $i<$len; $i++ ) {
			
			$ref = explode('.', $result[$i]['ref']);
			if( $ref[0] == 'personal' ) $logintype = 'staff';
			else $logintype = $ref[0];

			$select = $ref[0]=='admin' ? 'admin_fname fname, admin_lname lname, admin_email email' : 'fname, lname, email';
			$qry = "SELECT ".$ref[1]. " id, $select FROM ".$ref[0]." WHERE ".$result[$i]['ref']."=".$result[$i]['userid'];
			
			$user_result = $this->db->fetchRow($qry);
			
			$total_array[ $result[$i]['report_id'] ] = array('field_update' => $result[$i]['field_update'],
													  'user_info' => $user_result, 'logintype' => $logintype);
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
		ticket_id=$id AND (field_update LIKE '%\"Bug report created\"%' OR field_update LIKE '%\"Case\"%')";
		return $this->db->fetchOne($query);
	}
	
	public function fetchHistory($id, $fldname = NULL, $order = 'DESC', $cnt = 0) {
		$query = "SELECT l.id, l.field_update, l.ref, l.userid FROM ".$this->table." l WHERE l.report_id=$id ";
			
		if( $fldname !== NULL ) $query .= "AND field_update LIKE '%\"$fldname\"%' ";
		
		$query .= "ORDER BY l.id $order";
		if( $cnt ) $query .= " LIMIT $cnt";

		$history = $this->db->fetchAll($query);
		
		$total_array = array();
		for($i = 0; $i < count($history); $i++) {
			
			$ref = explode('.', $history[$i]['ref']);

			$select = $ref[0]=='admin' ? 'admin_fname fname, admin_lname lname, admin_email email' : 'fname, lname, email';
			$qry = "SELECT ".$ref[1]. " id, $select FROM ".$ref[0]." WHERE ".$history[$i]['ref']."=".$history[$i]['userid'];
				
			$user_result = $this->db->fetchRow($qry);
			
			$logs = unserialize($history[$i]['field_update']);
			$updates_array = array();
			foreach( $logs as $k => $v ) {
				if( $fldname !== NULL && $k != 'update_date' && $fldname != $k) continue;
				
				if( $k != 'update_date') {
					$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $v);
					$str = preg_replace('/\\\/', '', $str);
					$str = str_replace("/\s+/", '&nbsp;', $str);
					
					if($k == 'assignto') {
						$assignto = explode(' ', $str);
						if( count($assignto) == 2 ) {
						
							$ref = explode('.', $assignto[1]);
				
							$select = $ref[0]=='admin' ? 'admin_fname fname, admin_lname lname, admin_email email' : 'fname, lname, email';
							$qry = "SELECT ".$ref[1]. " id, $select FROM ".$ref[0]." WHERE ".$assignto[1]."=".$assignto[0];
								
							$assignto_result = $this->db->fetchRow($qry);
							
							$str = $assignto_result['fname']. ' '.$assignto_result['lname'];
							if( $ref[0]=='admin' ) $str .= ' (admin)';
						}
					}
					array_push($updates_array, ($fldname === NULL) ? ucfirst($k). ' => '.$str : $str);
				}
			}
			
			$history[$i]['date_updated'] =  $logs['update_date'];
			$history[$i]['field_update'] = implode('<br/>', $updates_array);
			$history[$i]['user_info'] = $user_result;
        }
		return $history;
	}
}