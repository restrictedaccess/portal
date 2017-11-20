<?php

/* BugReports.php 2012-11-02 $ */

class BugReports {
    private $db;
	private $table = 'bug_reports';

    private $userid;
	
	public $report_info;
	public $report_exists;
	public $is_error;
	private static $instance = NULL;
	public static $log;
	public $update = false;
	
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }
    
    function __construct($db, $id = 0) {
        $this->db = $db;
		
		$select_fields = '*';

		$this->report_exists = 0;
		$this->report_info['id'] = 0;
		$this->is_error = '';
		$this->utils = Utils::getInstance();
		$this->utils->db = $db;
		//$this->_salt = "$1$"."remote123"."$";

		
		if( $id ) {
			
			//$query = "SELECT {$select_fields} FROM ". $this->table. " WHERE id={$id} AND status!='deleted' LIMIT 1";
			$this->report_info = $this->fetchAll(NULL, array('i.id' => $id) ); //$this->db->fetchRow($query);
			
			$this->report_info = $this->report_info[0];

			if( $this->report_info['id'] > 0 ) {
				$this->report_exists = 1;
				
				$this->report_info['files'] = $this->get_attachment_path($this->report_info['id']);
			}
		}

    }
	
	public function report_create($data_array = array(), $reporter_email = '') {
		try {
			$id_exist =
			$this->db->fetchOne("SELECT id FROM ".$this->table." WHERE report_title='".$data_array['report_title']."'
				AND report_link='". $data_array['report_link'] ."'");
			if( $id_exist ) {
				$first = $this::$log->lastUpdate('min', $id_exist);
				if( count($first[ $id_exist ]) > 0 && $reporter_email == $first[ $id_exist ]['user_info']['email']) {
					$this->is_error = 'Duplicate report found! Unable to continue.';
				}
			}
			
			if( !$this->is_error ) {
				$this->db->insert($this->table, $data_array);
				return $this->db->lastInsertId($this->table);
			}
		} catch (Exception $e){
			$this->is_error = $e->getMessage();
		}
		return 0;
	} // END report_create() METHOD
	
	public function report_update($id, $data_array = array()) {
		try {
			//if( array_key_exists('ticket_details', $data_array) ) unset($data_array['ticket_details']);
			//if( array_key_exists('ticket_solution', $data_array) ) unset($data_array['ticket_solution']);
			$this->db->update($this->table, $data_array, 'id='.$id);
			return 1;
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
		return 0;
	  //return $this->db->lastInsertId($this->table);	
	} // END report_update() METHOD
	
	
	function report_check($info_array) {//, $client_id, $staff_id) {
		// CHECK FOR EMPTY FIELDS
		$title = $info_array['report_title'];
		$link = $info_array['report_link'];
		$steps = $info_array['steps_reproduce'];
		$actual = $info_array['actual_result'];

		if(!$this->is_error && (trim($title) == "" || (trim($link) == "" && !$this->update) || trim($steps) == "" || trim($actual) == "" ) ) {
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
	
	public function fetchAll($where = NULL, $args = array(), $orderby = "i.severity DESC" ) {
		$where_array = array();
		if( $where !== NULL) array_push($where_array, $where);
		if( !empty($args['keyword']) ) {
			$k = $args['keyword'];
			$sql = "(locate('$k', i.report_title)>0 OR locate('$k', i.report_link)>0 OR locate('$k', i.actual_result)>0
				OR i.id='$k')";
			array_push($where_array, $sql);
			unset($args['keyword']);
		}
		
		foreach( $args as $k => $v ) {
			//if($k != 'keyword') array_push($where_array, "$k='".trim($v)."'");
			if($k == 'l.field_update') array_push($where_array, "$k LIKE '".trim($v)."'");
			else array_push($where_array, "$k='".trim($v)."'");
		}
		
		$where_clause = '';
		if( count($where_array) > 0 ) {
			$where_clause = 'WHERE '.implode(' AND ', $where_array);
		}
		
		//$create_date = "date_format(date_add(creation_date, interval $offset HOUR), '%b %e, %Y %r')";
		$create_date = "date_format(convert_tz(creation_date, 'UTC','+00:00'), '%b %e, %Y %r')";
		//$update_date = "date_format(date_add(update_date, interval $offset HOUR), '%b %e, %Y %r')";
		$update_date = "date_format(convert_tz(update_date, 'UTC','+00:00'), '%b %e, %Y %r')";

		//$select = "i.id ticket_id, t.type_name, c.id, l.cfname, l.clname, p.fname, p.lname, $date_qstr,
		$select = "i.id, report_title, report_link, $create_date creation_date,
			$update_date update_date, i.assignto_ref,	i.resolution, i.status, i.steps_reproduce, i.actual_result, i.expected_result,
			i.other_info, i.severity, i.assignto, count(f.id) filecnt,
			case i.severity when 'low' then 'low_priority_low_1' when 'medium' then 'normal_priority_normal'
			when 'high' then 'high_priority_1' when 'critical' then 'critical_priority_2' end priority,
			l.field_update, l.userid, l.ref";
		
		//LEFT JOIN personal p ON p.userid=i.assignto
		$query = "SELECT $select FROM " .$this->table. " i 
			LEFT JOIN bugreport_files f ON f.report_id=i.id
			LEFT JOIN bugreport_logs l ON i.id=l.report_id 
			$where_clause GROUP BY i.id ORDER BY $orderby";
			
		$data = $this->db->fetchAll($query);
		
		$new_result = array();
		//foreach( $data as $result => $row ) {
		for( $i=0, $len=count($data); $i < $len; $i++) {
			if( empty($data[$i]['ref']) || empty($data[$i]['userid']) ) continue;
			
			$data[$i]['report_title'] = stripslashes($data[$i]['report_title']);
			$data[$i]['report_link'] = stripslashes($data[$i]['report_link']);
			$data[$i]['other_info'] = stripslashes($data[$i]['other_info']);
			
			$last = $this::$log->lastUpdate('max', $data[$i]['id']);
            //$first = $this::$log->lastUpdate('min', $data[$i]['id']);

			
			$ref = explode('.', $data[$i]['ref']);
			if( $ref[0] == 'personal' ) $logintype = 'staff';
			else $logintype = $ref[0];

			$select = $ref[0]=='admin' ? 'admin_fname fname, admin_lname lname, admin_email email' : 'fname, lname, email';
			$qry = "SELECT ".$ref[1]. " id, $select FROM ".$ref[0]." WHERE ".$data[$i]['ref']."=".$data[$i]['userid'];
			
			$reporter_result = $this->db->fetchRow($qry);
			
			array('field_update' => $result[$i]['field_update'],'user_info' => $user_result, 'logintype' => $logintype);
			
			
			//if( count($first[ $data[$i]['id'] ]) > 0 ) {
			if( count($reporter_result) > 0 ) {
				$reporter = $reporter_result;
				$data[$i]['reporter'] = $reporter_result['fname'].' '.$reporter_result['lname'].' ('.$logintype.')';
				$data[$i]['reporter_email'] = $reporter_result['email'];
			}
			
			if( count($last[ $data[$i]['id'] ]) > 0 ) {

				$updated_by = $last[ $data[$i]['id'] ]['user_info'];
				$data[$i]['updated_by'] = $updated_by['fname'].' '.$updated_by['lname'];//$updated_by['email'];
				
				
				$last_updates = $last[ $data[$i]['id'] ];
				$logs = unserialize($last_updates['field_update']);
				
				/*$date_updated = 'null';
				foreach( $logs as $k => $v ) {
					if( $k == 'update_date') {
						$date_updated = $v;//substr($v, 0, -3);
					} else {
						continue;
						//$entry = $k;
					}
				}
				//echo $date_updated;
				if( $date_updated ) {
					//echo $date_updated.'<br/>';
					$d = strtotime($date_updated);
					//date_create_from_format("m/d/Y", $date_updated);
					//echo date('M d, Y', $d).'<br/>';
					//$d = new DateTime(strtotime($date_updated));
					$data[$i]['update_date'] = date('M d, Y H:i a', $d);
				}*/
			}
			
			if( !$data[$i]['assignto'] ) $data[$i]['assigned'] = '[any]';
			else {
				$assignto_ref = $data[$i]['assignto_ref'];
				$ref = explode('.', $assignto_ref);
	
				$select = $ref[0]=='admin' ? 'admin_fname fname, admin_lname lname, admin_email email' : 'fname, lname, email';
				$qry = "SELECT ".$ref[1]. " id, $select FROM ".$ref[0]." WHERE ".$assignto_ref."=".$data[$i]['assignto'];
					
				$user_result = $this->db->fetchRow($qry);
				
				$assigned = $user_result['fname']. ' '.$user_result['lname'];
				if( $ref[0]=='admin' ) $assigned .= '(admin)';
				elseif( $ref[0]=='agent' ) $assigned .= '(bp)';
				
				$data[$i]['assigned'] = $assigned;
			}
		}
		return $data;
	}
	
	public function next_id() {
		$qry = $this->db->select()->from($this->table, 'max(id)');
		return $this->db->fetchOne($qry) + 1;
	}
	
	public function csro_list() {
		$sql = $this->db->select()
            ->from('admin', array('admin_id', 'admin_fname', 'admin_lname'))
			->where("csro = 'Y'")
			->order('admin_fname');
        return $this->db->fetchAll($sql);
	}
	
	public function ticket_delete($tick = array()) {
		try {
			foreach( $tick as $k => $v ) {
				//echo 'ticket_status=>'.$v.'<br/>';
				$this->db->update($this->table, array('status' => 'deleted'), 'id='.$v);	
			}
			
			return 1;
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
		return 0;
	}
	
	public function save_attachment_path($data_array = array()) {
		$sql = $this->db->insert('bugreport_files', $data_array);
		return $this->db->lastInsertId('bugreport_files');
	}
	
	public function get_attachment_path($report_id) {
		$sql = $this->db->select()
            ->from('bugreport_files', array('id', 'file_name'))
			->where('report_id = ?', $report_id);
        return $this->db->fetchAll($sql);
	}
	
	public function report_assignto($id, $userid, $ref) {
		try {
			$this->db->update( $this->table, array('assignto' => $userid, 'assignto_ref' => $ref), 'id='.$id );
			return 1;
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
		return 0;
	}
	
	public function report_set_status($id, $status) {
		try {
			$this->db->update( $this->table, array('status' => $status), 'id='.$id );
			if( $status == 'resolved' && $this->db->fetchOne('select resolution from '.$this->table.' where id='.$id)=='open' ) {
				$this->db->update( $this->table, array('resolution' => 'fixed'), 'id='.$id );	
			}
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
	}
	
	public function report_delete($id) {
		try {
			//$this->db->delete( $this->table, 'id='.$id );
			$this->db->update( $this->table, array('status' => 'deleted'), 'id='.$id );
			return 1;
		} catch (Exception $e) {
			$this->is_error = $e->getMessage();
		}
		return 0;
	}
	
	public function send_autoresponder($id) {
		$to_emails = array();
		$query = "SELECT report_title, report_link, i.assignto_ref,	i.resolution, i.status,
		i.steps_reproduce, i.severity, i.assignto, IF(creation_date = update_date,'new', 'old') ticket FROM " .$this->table. " i WHERE i.id=$id";
		$data = $this->db->fetchRow($query);
				
		$first = $this::$log->lastUpdate('min', $id);
		$reporter = '';
		if( count($first[$id]) > 0 ) {
			$author = $first[ $id ]['user_info'];
			$reporter = $author['fname'].' '.$author['lname'].' ('.$first[ $id ]['logintype'].')';
			// allow also the reporter to receive auto-responder (2014/08/15)
			array_push($to_emails, $author['email']);
		}
		
		$qausers = new QAusers();
		$users = $qausers->fetchAll();
        foreach( $users as $k => $v ) array_push($to_emails, $v['email']);
		
		if( $data['assignto'] ) {
			$assignto_ref = $data['assignto_ref'];
			$ref = explode('.', $assignto_ref);
			
			$select = $ref[0]=='admin' ? 'admin_email email, admin_fname fname' : 'email, fname';
			$qry = "SELECT $select FROM ".$ref[0]." WHERE ".$assignto_ref."=".$data['assignto'];
					
			$assigned = $this->db->fetchRow($qry);
			array_push($to_emails, $assigned['email']);
			$assigned_to = $assigned['fname'];
		}
		
		$severity = $data['severity'];
		$title = stripslashes($data['report_title']);
		$status = $data['status'];
		//$reporter = $reporter;
		$link = $data['report_link'];
		$steps = nl2br(htmlspecialchars($data['steps_reproduce']));
		$steps = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $steps);
		$steps = stripslashes($steps);
		
		// EMAIL BODY
		$emailtpl =	"<p>#$id: $title</p>
        <table border='0' cellspacing='3' cellpadding='0'>
        <tr><td style='font-weight:bold'>Reporter </td><td>$reporter</td></tr>
        <tr><td style='font-weight:bold'>Priority </td><td>$severity</td></tr>
        <tr><td  style='font-weight:bold'>Status </td><td>$status</td></tr>";
		if( $status == "assigned" ) $emailtpl .= "<tr><td  style='font-weight:bold'>Assigned_to </td><td>$assigned_to</td></tr>";
        $emailtpl .= "<tr><td  style='font-weight:bold'>Link </td><td>$link</td></tr>
        </table><br/><strong>Steps to reproduce:</strong><br/>
        $steps<br/>";
		
		if( $data['ticket'] != "new") {
			$changes = array();
			$report_id = $data_array['report_id'];
			$last = $this::$log->lastUpdate('max', $id);
			$updated_by = $last[ $id ]['user_info'];
			$updated_by_name = $updated_by['fname'].' '.$updated_by['lname'];
			$logs = unserialize($last[ $id ]['field_update']);
			
			$emailtpl .= "<p><strong>Changes made by:</strong> &nbsp;$updated_by_name<br/><ul>";
			foreach( $logs as $k => $v ) {
				if( $k != 'update_date' ) {
					if( $k == 'assignto' ) $v = $assigned_to;
					elseif( $k == 'attachment' && strrpos($v, '/') !== false) $v = substr($v, strrpos($v, '/')+1);
					$str = nl2br(htmlspecialchars($v));
					$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
					$str = stripslashes($str);
					$emailtpl .= "<li><strong> $k: </strong>  ".$str."</li>";
				}
			}
			
			$emailtpl .= "</ul></p>";
		}
		$emailtpl .="<p>Click <a href='http://".$_SERVER['HTTP_HOST']."/portal/bugreport/?/view_details/$id'>here</a> for more information,
        or you may login to admin <a href='www.remotestaff.com.au/portal/'>portal</a> and select Bug Report link.<br/>
        </p><br/>".
        "This is auto-generated email.";
		
		
        $subject = "[RS Bug Report] #$id: $title";
            
        $utils = Utils::getInstance();
        $utils->send_email($subject, $emailtpl, $to_emails, 'Bug Report Notification', false);
	}
}



?>