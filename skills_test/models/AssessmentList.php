<?php
require_once dirname(__FILE__) . "/BaseAssessment_Model.php";
/* AssessmentList.php 2013-05-30 $ -msl */

class AssessmentList extends BaseAssessment_Model {
    private $db;
	private $table = 'assessment_lists';

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
	
	public function assessment_save($data_array = array()) {
		try {
			$this->db->insert($this->table, $data_array);
			
			$this->syncTestToMongo();
		} catch (Exception $e){
			return $e->getMessage();
		}
	  
		return $this->db->lastInsertId($this->table);	
	}
	
	public function deactivate_assesslist() {
		try {
			$this->db->update($this->table, array('status'=>'inactive') );
			
			
			$this->syncTestToMongo();
			
		} catch (Exception $e){
			return $e->getMessage();
		}
	}
	
	public function assessment_check($data) {
		$cnt = 0;
		$cnt = $this->db->fetchOne($this->db->select()
			->from($this->table, array('cnt'=>'COUNT(id)'))
			->where('assessment_id=?', $data['assessment_id'])
			->where('assessment_title=?', $data['assessment_title'])
			->where('assessment_category=?', $data['assessment_category'])
			->where('assessment_type=?', $data['assessment_type'])
			);
			
			$this->syncTestToMongo();
		if( $cnt > 0 )
			return 1;
			//$this->db->delete($this->table, 'assessment_id='.$id);
		else return 0;
	}
	
	public function set_assessment_active($data = array()) {
		$where = array(
			"assessment_id={$data['assessment_id']}",
			"assessment_title='{$data['assessment_title']}'",
			"assessment_category='{$data['assessment_category']}'",
			"assessment_type='{$data['assessment_type']}'"
		);
		
		try {
			$this->db->update($this->table, array('status'=>'active'), $where);
			
			$this->syncTestToMongo();
		} catch (Exception $e){
			return $e->getMessage();
		}
		return 'status';
	}
	
	public function assessment_update($data_array = array()) {
		try {
			$this->db->update($this->table, $data_array, "assessment_id='".$data_array['assessment_id']."'");
			
			$this->syncTestToMongo();
		} catch (Exception $e){
			return $e->getMessage();
		}
		return $data_array['assessment_title'];
	}
		
	public function fetchAll($where = '1') {
		$qry = $this->db->select()
		->from($this->table, array('id', 'assessment_id', 'assessment_title', 'assessment_type', 'assessment_category'))
		->where($where);
		
		
		return $this->db->fetchAll($qry);
	}
	
	public function fetch_categories() {
		$qry = $this->db->select()
		->from($this->table, 'assessment_category')
		->where('status = ?', 'active')
		->group('assessment_category');
		return $this->db->fetchAll($qry);
	}
	
	public function getAPIURL(){
		$base_api_url = $base_api_url = "http://test.api.remotestaff.com.au";
		
		if (!TEST){
			$base_api_url = "https://api.remotestaff.com.au";
		}
		
		return $base_api_url;
	}
	
	
	public function syncTestToMongo(){
		
		$curl->get($this->getAPIURL() . "/mongo-index/sync-all-candidates?userid=" . $_SESSION["userid"]);
		
	}
	
}



?>