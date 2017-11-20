<?php

class TicketInfo {
    private $db;
	private $table = 'tickets_info';

    private $userid;
	
	public $ticket_info;
	public $ticket_exists;
	public $is_error;
	private static $instance = NULL;
	public $log;
	public $update = false;
	
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }
    
    function __construct($db, $id = 0) {

        $this->db = $db;
		
		$select_fields = '*'; //'userid, fname, lname, image, email, pass, handphone_no,skype_id';
		
		$this->ticket_exists = 0;
		$this->ticket_info['id'] = 0;
		$this->is_error = '';
		
		$this->utils = Utils::getInstance();
		$this->utils->db = $db;
		//$this->_salt = "$1$"."remote123"."$";
		
		if( $id ) {
			$query = $this->db->select()
			->from( array('t'=>$this->table), array($select_fields))
			->where('t.id=?', $id)
			->where('t.ticket_status!=?', 'deleted')
			->limit(1);
			
			$this->ticket_info = $this->db->fetchRow($query);

			if( $this->ticket_info['id'] > 0 ) {
				$this->ticket_exists = 1;
			}
		}

    }
	
	public function ticket_create($data_array = array()) {
		try {
			$this->db->insert($this->table, $data_array);
			return $this->db->lastInsertId($this->table);
		} catch (Exception $e){
			$this->is_error = $e->getMessage();
		}
		return 0;
	} // END ticket_create() METHOD
	
	public function ticket_update($id, $data_array = array()) {
		try {
			if( array_key_exists('ticket_details', $data_array) ) unset($data_array['ticket_details']);
			if( array_key_exists('ticket_solution', $data_array) ) unset($data_array['ticket_solution']);
			$this->db->update($this->table, $data_array, 'id='.$id);
			return 1;
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
		return 0;
	  //return $this->db->lastInsertId($this->table);	
	} // END ticket_update() METHOD
	
	public function user_displayname() {
		if( $this->user_info['fname'] ) $display = $this->user_info['fname'];
		else $display = $this->user_info['email'];
		return $display;
	}
	
	
	function ticket_check($info_array) {//, $client_id, $staff_id) {
		// CHECK FOR EMPTY FIELDS
		$title = $info_array['ticket_title'];
		$details = $info_array['ticket_details'];
		$type = $info_array['ticket_type'];
		//$csro = $info_array['csro'];

		if(!$this->is_error && (trim($title) == "" || (trim($details) == "" && !$this->update) || trim($type) == "") ) {
			//|| $client_id == "Search id..." || $staff_id == "Search id...") ) {
			$this->is_error = 'Required fields must not be empty';
		}

		// CHECK FOR DUPLICATE EMAIL
		/*$lowercase_email = strtolower($email);
		if(!$this->_error &&
		   strtolower($this->user_info['email']) != $lowercase_email &&
		   $this->db->fetchOne("SELECT email FROM ".$this->table." WHERE email='$email'") != "") {
			$this->_error = 'Email already in used';
		}*/
		
	}
	
	public function fetchAll($where = NULL, $args = array() ) {
		$where_array = array();
		
		$date_qstr = $this->utils->format_date('i.date_created', '%Y-%m-%d');
		
		$select = $this->db->select()
		->from( array('i'=>$this->table), array('id','ticket_title', 'ticket_date'=>$date_qstr, 'date_created', 'day_priority', 'ticket_status') )
		->joinLeft( array('t'=>'ticket_types'), 't.id=i.ticket_type', array('type_name'))
		->joinLeft( array('a1'=>'admin'), 'a1.admin_id=i.csro', array('a_csro'=>'admin_fname', 'csro') )
		->joinLeft( array('a2'=>'admin'), 'a2.admin_id=i.accounts', array('a_accnt'=>'admin_fname') )
		->joinLeft( array('u'=>'ticket_clientstaff'), 'u.ticket_id=i.id', array() )
		->joinLeft( array('p'=>'personal'), 'p.userid=u.userid', array() )
		->joinLeft( array('l'=>'leads'), 'l.id=u.userid', array() );
		
		if( $where !== NULL) array_push($where_array, $where);
		if( !empty($args['keyword']) ) {
			$k = $this->db->quote($args['keyword']);
			
			$sql = "(locate($k, i.ticket_title)>0 OR locate($k, i.ticket_details)>0 OR locate($k, i.ticket_solution)>0
				OR locate($k, concat(p.fname,' ',p.lname))>0 OR locate($k, concat(a1.admin_fname,' ',a1.admin_lname))>0
				OR locate($k, concat(a2.admin_fname,' ',a2.admin_lname))>0 OR locate($k, concat(l.fname,' ',l.lname))>0 OR i.id=$k)";
			array_push($where_array, $sql);			
		}
		
				
		if( !empty($args['ticket_date1']) ) {
			$time_start = strtotime($args['ticket_date1']);
			
			if( !empty($args['ticket_date2']) )
				$time_end = strtotime($args['ticket_date2']) + 86400;
			else $time_end = strtotime('+1 day', $time_start);
			
			array_push($where_array, "i.date_created>=$time_start AND i.date_created<=$time_end");
		}
		
		$filter_flds = array('ticket_type'=>'i.ticket_type', 'leads_id'=>'l.id', 'userid'=>'p.userid',
							'ticket_csro'=>'i.csro', 'ticket_accounts'=>'i.accounts', 'day_priority'=>'i.day_priority');
		
		foreach( $args as $key => $val ) {
			$val = trim($val);
			if( isset($filter_flds[$key]) && $val != '' ) {
				$sql = '';
				if( in_array($key, array('ticket_csro', 'ticket_accounts') ) )
					$sql = $val=='all' ? $filter_flds[$key].'> 0' : $filter_flds[$key].'='.$val;
				else {
					if( $val > 0 ) $sql = $filter_flds[$key].'='.$val;
				}
				if( $sql ) array_push($where_array, $sql);
			}
		}
		
		//$select->where('ticket_status != ?', 'deleted')
		$select->where( implode(' AND ', $where_array) )->group('i.id');
		
		$data = $this->db->fetchAll($select);
		
		$clientstaff = new ticketClientStaff($this->db);
		
		$date_from = strtotime(date("Y-m-d H:i:s"));
		
		$new_result = array();
		//foreach( $data as $result => $row ) {
		for( $i=0, $len=count($data); $i < $len; $i++) {
			//$data[$i]['admin_fname'] = $data[$i]['a_csro'] !== NULL ? $data[$i]['a_csro'] : $data[$i]['a_accnt'];
			$data[$i]['admin_fname'] = array($data[$i]['a_csro']);
			if( $data[$i]['a_accnt'] !== NULL ) $data[$i]['admin_fname'][] = $data[$i]['a_accnt'];
			
			// process client list
			$client = $clientstaff->fetch_users("ticket_id=".$data[$i]['id'] ." AND ref_table='leads.id'");
			
			$created_by = $this->log->case_created_by($data[$i]['id']);
			
			//$age_date = $this->get_age($date_from, (int)$data[$i]['date_created']);
			
			$resolved_log = $this->log->resolved_date($data[$i]['id']);
			if( $resolved_log ) {
				$age_date = $this->utils->get_age((int)$resolved_log['date_updated'], (int)$data[$i]['date_created']);
				$age = explode(' ', $age_date);
				$data[$i]['resolved_age'] = date("Y-m-d", $resolved_log['date_updated']) . ' ('.round($age[0]).' '.$age[1].')';
			} else {
				$age_date = $this->utils->get_age($date_from, (int)$data[$i]['date_created']);
			}
			
			$age_var = explode(' ', $age_date);
			
			$age_day = round((float)$age_var[0]);
			
			// edit: we just ignoring the row that is not included in the ticket age filter
			if( !empty($args['ticket_age']) && is_numeric($args['ticket_age']) ) {
				/*$age_var = explode(' ', $age_date);
				$inp_age = (int)$args['ticket_age'];
				$age_day = round((float)$age_var[0]);*/
				$inp_age = (int)$args['ticket_age'];
				if( ( (($age_day > $inp_age || $age_day < $inp_age) && $inp_age < 31) &&
				   in_array($age_var[1], array('days', 'day') )) ||
				   ($inp_age > -1 && in_array($age_var[1], array('h', 'min', 'sec') )) ) {
					continue;
				} elseif($inp_age == -1) {
					if( in_array($age_var[1], array('days', 'day') ) ) continue;
				} elseif($inp_age == '31') {
					if( $age_day < $inp_age && in_array($age_var[1], array('days', 'day', 'h', 'min', 'sec') ) ) continue;
				}
			// in between days age filter
			} elseif( !empty($args['from_age']) || !empty($args['to_age']) ) {
				$from_age = $args['from_age'] ? $args['from_age'] : $args['to_age'];
				$to_age = $args['to_age'] ? $args['to_age'] : $args['from_age'];

				if( ( ($age_day < $from_age || $age_day > $to_age) &&
				   in_array($age_var[1], array('days', 'day') )) ||  in_array($age_var[1], array('h', 'min', 'sec') ) ) {
					continue;
				}
			}
			
			/*$age_sec = $created / 60;
			$age_min = $created / 3600;
			$age_hrs = $created / 86400;*/
			//$data[$i]['sec'] = $created;
			$data[$i]['age'] = $age_date;
			//$data[$i]['min'] = $age_min;
			//$data[$i]['hrs'] = $age_hrs;
			
			/*$user_array = array();
			foreach($users as $a => $v) {
				$ref_table = explode('.', $v['ref_table']);
				$qry = $this->db->select()
					->from($ref_table[0] , array('fname', 'lname'))
					->where($v['ref_table'].'='.$v['userid']);
				
				array_push($user_array, $this->db->fetchRow($qry));
			}*/
			
			$data[$i]['client'] = $client;
			$data[$i]['created_by'] = !$created_by ? 'null' : $created_by;
			
			
			// process staff list
			$staff = $clientstaff->fetch_users("ticket_id=".$data[$i]['id'] ." AND ref_table='personal.userid'");
			
			/*$user_array = array();
			foreach($users as $a => $v) {
				$ref_table = explode('.', $v['ref_table']);
				$qry = $this->db->select()
					->from($ref_table[0] , array('fname', 'lname'))
					->where($v['ref_table'].'='.$v['userid']);
				
				array_push($user_array, $this->db->fetchRow($qry));
			}*/
			
			$data[$i]['staff'] = $staff;
			$data[$i]['ticket_title'] = stripslashes($data[$i]['ticket_title']);
			
			$new_result[] = $data[$i];
		}
		return $new_result;
	}
	
	public function reports_count($args) {
		$where_array = array();
		
		$select = $this->db->select()
		->from( array('i'=>$this->table), array('csro_id'=>'csro',
										"open_ticket"=>"COUNT(IF(ticket_status='Open',1,null))",
										"closed_ticket"=>"COUNT(IF(ticket_status='Resolved',1,null))",
										"escal_ticket"=>"COUNT(IF(ticket_status='Escalated',1,null))"
										) )
		->joinLeft( array('t'=>'ticket_types'), 't.id=i.ticket_type', array('type_name'))
		->joinLeft( array('a1'=>'admin'), 'a1.admin_id=i.csro', array('a_csro'=>'admin_fname', 'csro') )
		->joinLeft( array('a2'=>'admin'), 'a2.admin_id=i.accounts', array('a_accnt'=>'admin_fname') )
		->joinLeft( array('u'=>'ticket_clientstaff'), 'u.ticket_id=i.id', array() )
		->joinLeft( array('p'=>'personal'), 'p.userid=u.userid', array() )
		->joinLeft( array('l'=>'leads'), 'l.id=u.userid', array() )
		->where('ticket_status != ?', 'deleted');
		
		if( !empty($args['keyword']) ) {
			$k = $this->db->quote($args['keyword']);
			
			$sql = "(locate($k, i.ticket_title)>0 OR locate($k, i.ticket_details)>0 OR locate($k, i.ticket_solution)>0
				OR locate($k, concat(p.fname,' ',p.lname))>0 OR locate($k, concat(a1.admin_fname,' ',a1.admin_lname))>0
				OR locate($k, concat(a2.admin_fname,' ',a2.admin_lname))>0 OR locate($k, concat(l.fname,' ',l.lname))>0 OR i.id=$k)";
			array_push($where_array, $sql);			
		}
		
		if( !empty($args['ticket_date1']) ) {
			$time_start = strtotime($args['ticket_date1']);
			
			if( !empty($args['ticket_date2']) )
				$time_end = strtotime($args['ticket_date2']) + 86400;
			else $time_end = strtotime('+1 day', $time_start);
			
			array_push($where_array, "i.date_created>=$time_start AND i.date_created<=$time_end");
		}
		
		$filter_flds = array('ticket_type'=>'i.ticket_type', 'leads_id'=>'l.id', 'userid'=>'p.userid',
							'ticket_csro'=>'i.csro', 'ticket_accounts'=>'i.accounts', 'day_priority'=>'i.day_priority');
		
		foreach( $args as $key => $val ) {
			$val = trim($val);
			if( isset($filter_flds[$key]) && $val != '' ) {
				$sql = '';
				if( in_array($key, array('ticket_csro', 'ticket_accounts') ) )
					$sql = $val=='all' ? $filter_flds[$key].'> 0' : $filter_flds[$key].'='.$val;
				else {
					if( $val > 0 ) $sql = $filter_flds[$key].'='.$val;
				}
				if( $sql ) array_push($where_array, $sql);
			}
		}
		
		if( count($where_array) ) $select->where( implode(' AND ', $where_array) );
		
		$select->group('i.id');
		
		$outer_sel = $this->db->select()
		->from( array('cnt'=>$select), array('a_csro', 'a_accnt',
							"open"=>"count(if(cnt.open_ticket>0,1,null))",
							"closed"=>"count(if(cnt.closed_ticket>0,1,null))",
							"escal"=>"count(if(cnt.escal_ticket>0,1,null))") )
		->group('cnt.csro_id');
		
		return $this->db->fetchAll($outer_sel);
	}
	
	public function next_id() {
		$qry = $this->db->select()->from($this->table, 'max(id)');
		return $this->db->fetchOne($qry) + 1;
	}
	
	//public function csro_list($where='') {
	public function admin_get($where='') {
		$sql = $this->db->select()
            ->from('admin', array('admin_id', 'admin_fname', 'admin_lname', 'admin_email'))
			->where("status <> 'REMOVED'");
		if( $where ) $sql->where($where);
		$sql->order('admin_fname');
        return $this->db->fetchAll($sql);
	}
	
	private function csro_get($id) {
		$query = $this->db->select()
			->from( array('t'=>$this->table), array())
			->joinLeft( array('a'=>'admin'), '(if(t.csro>0, a.admin_id=t.csro, a.admin_id=t.accounts))',
					   array('admin_email', 'admin_fname') )
			->where('t.id=?', $id)
			->where('t.ticket_status!=?', 'deleted');
		return $this->db->fetchAll($query);
	}
	
	/*public function accounts_list($ids = array()) {
		$sql = $this->db->select()
            ->from('admin', array('admin_id', 'admin_fname', 'admin_lname'))
			->where("status <> 'REMOVED'")
			->order('admin_fname');
		if( count($ids) > 0 ) $sql->where('admin_id IN ('.implode(',', $ids).')');
        return $this->db->fetchAll($sql);
	}*/
	
	public function auto_responder($data = array(), $new_ticket = false) {
		if( $new_ticket )
			$responder_body = "Hi __RECIPIENT_NAME__,<p>You have new case created by __ADMIN_NAME__</p>";
		else
			$responder_body = "Hi __RECIPIENT_NAME__,<p>Your case #__CASENO__ has been updated by __ADMIN_NAME__</p>";
		
		$csro_accts = $this->csro_get($data['ticket_id']);
		
		foreach($csro_accts as $row => $entry) {
			$admin_name = ($data['admin_fname'] == $entry['admin_fname']) ? 'you' : 'Admin '.$data['admin_fname'];
			$responder_body = str_replace('__RECIPIENT_NAME__', $entry['admin_fname'], $responder_body);
			$responder_body = str_replace('__CASENO__', $data['ticket_id'], $responder_body);
			$responder_body = str_replace('__ADMIN_NAME__', $admin_name, $responder_body);
			
			$responder_body .= "<p>Date updated: ".date('Y-m-d H:i:s',$data['date_updated']);
			/*foreach($data['last_updates'] as $fld => $value) {
				if( $value ) {
					if( $fld == 'date_updated' ) $responder_body .= "$fld =>". date('Y-m-d H:i:s',$value)."<br/>";
					else $responder_body .= "$fld => $value<br/>";
				}
			}*/
			$responder_body .= "</p>Case URL: http://".$_SERVER['HTTP_HOST']."/portal/ticketmgmt/ticket.php?/ticketinfo/".$data['ticket_id'];
			
			$this->utils->send_email('Remotestaff Case #'.$data['ticket_id']. ': '.$data['title'], $responder_body, $entry['admin_email'], 'Remotestaff Cases Notification');
		}
	}
	
	public function ticket_delete($tick = array()) {
		try {
			foreach( $tick as $k => $v ) {
				//echo 'ticket_status=>'.$v.'<br/>';
				$this->db->update($this->table, array('ticket_status' => 'deleted'), 'id='.$v);	
			}
			
			return 1;
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
		return 0;
	}
}



?>