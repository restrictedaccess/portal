<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
abstract class AbstractCategorized extends Portal{
	public function __construct($db){
		parent::__construct($db);
	}
	
	protected function getCategories($category = null){  

		$db = $this->db;
		
		$category_filter = '';
		if($category != null){
			$category_filter = 'and  category_id = '.$category;
		}
		
		$select="SELECT category_id, category_name FROM job_category 
			WHERE 1 ".$category_filter." AND (status = 'posted' OR category_id=60)  
			ORDER BY category_name";
	    $rows = $db->fetchAll($select);  
	
		$categories = array();
		foreach($rows as $row){
			$category = array();
			$category['category']['id'] = $row['category_id'];
			$category['category']['name'] = $row['category_name'];
			$categories[] = $category;
		}
		return $categories;
	}
	
	protected function getSubCategories($category_id){  
	
		$db = $this->db;
		if ($_REQUEST["sub_category_id"]){
			$select = $db->select()->from("job_sub_category", array("sub_category_id", "sub_category_name"))
					->where("sub_category_id = ?", $_REQUEST["sub_category_id"])
					->where("category_id = ?", $category_id);
		}else{
			if ($category_id=="60"){
				$select = "SELECT sub_category_id, sub_category_name 
				FROM job_sub_category 
				WHERE category_id='".$category_id."' AND status = 'posted' 
				ORDER BY sub_category_name";
			}else{
				$select = "SELECT sub_category_id, sub_category_name 
						FROM job_sub_category 
						WHERE category_id='".$category_id."' 
						ORDER BY sub_category_name";		
			}
			
		}
	
	    $rows = $db->fetchAll($select);  
		return $rows;
	}
	
}
