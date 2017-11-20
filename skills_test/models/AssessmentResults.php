<?php
require_once dirname(__FILE__) . "/BaseAssessment_Model.php";
/* AssessmentResults.php 2013-06-06 $ -msl */

class AssessmentResults extends BaseAssessment_Model {
    private $db;
	private $table = 'assessment_results';

	private static $instance = NULL;
	
	public static function getInstance($db) {
		if (self::$instance === NULL) {
			self::$instance = new self($db);
		}
        return self::$instance;
    }
    
    function __construct($db) {
        $this->db = $db;
    }
	
	public function result_save($data_array = array()) {
		try {
			$this->db->insert($this->table, $data_array);
		} catch (Exception $e){
			return $e->getMessage();
		}
		
		
		$result_uid = $data_array["result_uid"];
		global $base_api_url;
		global $curl;
		
		$candidate_details = $this->db->fetchRow(
			$this->db->select()
			->from("personal", array("userid"))
			->orWhere("email = ?", $result_uid)
			->orWhere("userid = ?", $result_uid)
			->orWhere("registered_email = ?", $result_uid)
		);
		
		$candidate_id = "";
		
		if(!empty($candidate_details)){
			$candidate_id = $candidate_details["userid"];
		}
		
		$curl->get($base_api_url . "/solr-index/sync-all-candidates/", array("userid" => $candidate_id));
		$curl->get($base_api_url . "/mongo-index/sync-all-candidates/", array("userid" => $candidate_id));
	  
		return $this->db->lastInsertId($this->table);	
	}
	
	public function assessment_update($report_id, $notes_id = array()) {
	}
	
	public function results_testname() {
		$select = $this->db->select()
		->from( array('r' => $this->table), array('result_aid') )
		->joinLeft( array('l' => 'assessment_lists'), 'r.result_aid=l.assessment_id', array('assessment_title') )
            ->where("l.status = 'active'")
		->group('r.result_aid')
		->order('l.assessment_title');
		return $this->db->fetchAll($select);
	}
		
	public function fetchAll($where = '1') {
		try {
			$qry1 = $this->db->select()
			->from(array('r' => $this->table), array('result_id', 'result_type', 'result_score', 'result_pct',
									   'result_url', 'result_aid', 'result_uid', 'result_selected', 'test_date'=>'date_format(result_date,"%b %d, %Y")'))
			->joinLeft( array('p' => 'personal'), 'r.result_uid=p.userid', array('userid', 'fname', 'lname') )
			->joinLeft( array('l' => 'assessment_lists'), 'r.result_aid=l.assessment_id', array('assessment_title', 'assessment_category') )
                ->where("l.status = 'active'")
			->where('p.userid > ?', 0);
			//if( $where ) $qry->where($where);
			//$qry->group('r.result_id');
			
			$qry2 = $this->db->select()
			->from(array('r' => $this->table), array('result_id', 'result_type', 'result_score', 'result_pct',
									   'result_url', 'result_aid', 'result_uid', 'result_selected', 'test_date'=>'date_format(result_date,"%b %d, %Y")'))
			->joinLeft( array('p' => 'personal'), 'r.result_uid=p.email', array('userid', 'fname', 'lname') )
			->joinLeft( array('l' => 'assessment_lists'), 'r.result_aid=l.assessment_id', array('assessment_title', 'assessment_category') )
			->where('p.email IS NOT NULL')
                ->where("l.status = 'active'")
			->where('p.userid > ?', 0);
			
			// additional query to search result based on personal.registered_email (2013/12/18)
			$qry3 = $this->db->select()
			->from(array('r' => $this->table), array('result_id', 'result_type', 'result_score', 'result_pct',
									   'result_url', 'result_aid', 'result_uid', 'result_selected', 'test_date'=>'date_format(result_date,"%b %d, %Y")'))
			->joinLeft( array('p' => 'personal'), 'r.result_uid=p.registered_email', array('userid', 'fname', 'lname') )
			->joinLeft( array('l' => 'assessment_lists'), 'r.result_aid=l.assessment_id', array('assessment_title', 'assessment_category') )
			->where('p.email IS NOT NULL')
                ->where("l.status = 'active'")
			->where('p.userid > ?', 0);
			
			if( $where ) {
				$qry1->where($where);
				$qry2->where($where);
				$qry3->where($where);
			}
			
			//$qry1->group('r.result_id');
			//$qry2->group('r.result_id');
			//$qry3->group('r.result_id');
			
			$union = $this->db->select()
			->union(array($qry1, $qry2, $qry3));
			
			$result = $this->db->fetchAll($union);
			foreach( $result as $idx => $row ) {
				if( preg_match('/staging/', $row['result_url'], $match) ) {
					$test_staging = $this->db->fetchRow( $this->db->select()
					->from('assessment_lists_staging', array('assessment_title','assessment_category'))
					->where('assessment_id = ?', $row['result_aid']) );
					
					$result[$idx]['assessment_title'] = $test_staging['assessment_title'];
					$result[$idx]['assessment_category'] = $test_staging['assessment_category'];
				}
			}
			return $result;
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	
	public function fetchStaging() {
		try {
			$qry = $this->db->select()
			->from(array('r' => $this->table), array('result_id','result_url'))
			->where("r.result_url LIKE '%staging%'");
			return $this->db->fetchAll($qry);
		} catch (Exception $e) {
			die($e->getMessage);
		}
	}
	
	public function fetch_categories() {
		$qry = $this->db->select()
		->from($this->table, 'assessment_category')
		->group('assessment_category');
		return $this->db->fetchAll($qry);
	}
	
}



?>