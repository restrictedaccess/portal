<?php
class CategorizedLoader{
	private $db;	
	private $sub_category_id = "";
	private $category_id = "";
	private $keyword = "";
	private $keyword_type = "";
	private $page = 1;
	private $rows = 100;	
	private $ratings = "";
	
	public function __construct($db){
		$this->db = $db;
		$this->gatherInput();
	}
	
	private function gatherInput(){
		if ($_REQUEST["category_id"]){
			$this->category_id = $_REQUEST["category_id"];
		}
		if ($_REQUEST["sub_category_id"]){
			$this->sub_category_id = $_REQUEST["sub_category_id"];
		}
		if ($_REQUEST["page"]){
			$this->page = $_REQUEST["page"];
		}
		if ($_REQUEST["rows"]){
			$this->rows = $_REQUEST["rows"];
		}
		if ($_REQUEST["keyword"]){
			$this->keyword = $_REQUEST["keyword"];
		}
		if ($_REQUEST["keyword_type"]){
			$this->keyword_type = $_REQUEST["keyword_type"];
		}
		
			$this->ratings = $_REQUEST["ratings"];
		
	}
	
	public function getList(){
		global $db_query_only;
		if (TEST){
			$db = $this->db;
		}else{
			$db = $db_query_only;
		}
		
		$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS jsca.id"), "jsca.category_id", "jsca.sub_category_id", "jsca.ratings"))
				->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
				->joinLeft(array("jc"=>"job_category"), "jc.category_id = jsca.category_id", array("jc.category_name"))
				->joinInner(array("p"=>"personal"), "p.userid = jsca.userid", array("p.fname", "p.lname", "p.userid"));
		
		if ($this->category_id){
			$sql->where("jc.category_id = ?", $this->category_id);
		}
		if ($this->sub_category_id){
			$sql->where("jsca.sub_category_id = ?", $this->sub_category_id);
		}
		if ($this->ratings=="0"||$this->ratings=="1"){
			$sql->where("jsca.ratings = ?", $this->ratings);
		}
		if ($this->keyword&&$this->keyword_type){
			if ($this->keyword_type=="userid"){
				$sql->where("p.userid = ?", $this->keyword);
			}else if ($this->keyword_type=="name"){
				$sql->where("CONCAT(p.fname, ' ', p.lname) LIKE '%".addslashes($this->keyword)."%'");
			}else if ($this->keyword_type=="skills"){
				$sql->joinRight(array("s"=>"skills_myisam"), "s.userid = p.userid", array())
				->where("MATCH(s.skill) AGAINST (? IN BOOLEAN MODE)", $this->keyword);
			}
			
		}
		$sql->order("p.dateupdated DESC");
		$sql->limitPage($this->page, $this->rows);
		
		
		$categorized = $db->fetchAll($sql);
		$total_candidates = $db->fetchOne("SELECT FOUND_ROWS() AS count");
		$totalPages = ceil($total_candidates/$this->rows);
		
		
		if ($_REQUEST["category_id"]){
			$category = $db->fetchRow($db->select()->from(array("jc"=>"job_category"))->where("category_id = ?", $_REQUEST["category_id"]));
			return array("success"=>true, "categorized"=>$categorized, "category"=>$category, "total_candidates"=>$total_candidates, "total_pages"=>$totalPages, "page"=>$this->page);
		}else if ($_REQUEST["sub_category_id"]){
			$subcategory = $db->fetchRow($db->select()->from(array("jsc"=>"job_sub_category"))->where("sub_category_id = ?", $_REQUEST["sub_category_id"]));
			return array("success"=>true, "categorized"=>$categorized, "subcategory"=>$subcategory, "total_candidates"=>$total_candidates, "total_pages"=>$totalPages, "page"=>$this->page);
		}else{
			return array("success"=>true, "categorized"=>$categorized, "total_candidates"=>$total_candidates, "total_pages"=>$totalPages, "page"=>$this->page);
			
		}
	}
}
