<?php

/* ReportNotes.php 2012-11-15 $ -mike*/

class ReportNotes {
    private $db;
	private $table = 'bugreport_notes';

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
	
	public function note_update($report_id, $notes_id = array()) {
		foreach( $notes_id as $idx => $id ) {
			$this->db->update($this->table, array('report_id' => $report_id ), 'id='.$id);	
		}
	}
		
	public function fetchAll($where = NULL) {
		//$date_qstr = $this->utils->format_date('note_submit_date', '%Y-%m-%d');
		//$time_qstr = $this->utils->format_date('note_submit_date', '%H:%i:%s');
		//$query = "SELECT id, note_content, substring_index(note_submit_date,':',2) date, ref, userid FROM ". $this->table;
		$query = $this->db->select()
			->from(array('n' => $this->table), array('id', 'note_content', "substring_index(note_submit_date,':',2) date", 'ref', 'userid') );
			
		if( $where !== NULL )
			$query->where($where);
		//$query .= " WHERE $where";
		$result = $this->db->fetchAll($query);
		
		for($i = 0; $i < count($result); $i++) {
			$ref = explode('.', $result[$i]['ref']);
			$select = $ref[0]=='admin' ? 'admin_fname fname, admin_lname lname, admin_email email' : 'fname, lname, email';
			$qry = "SELECT ".$ref[1]. " id, $select FROM ".$ref[0]." WHERE ".$result[$i]['ref']."=".$result[$i]['userid'];
			$user_result = $this->db->fetchRow($qry);
			
			//$stripped_content = nl2br(stripslashes($result[$i]['content']));
			//$stripped_content = stripslashes($result[$i]['note_content']);
			$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $result[$i]['note_content']);
			$str = preg_replace('/\\\/', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);
			$result[$i]['note_content'] = $str;
			$result[$i]['user_info'] = $user_result;
		}
		return $result;
	}
	
}



?>