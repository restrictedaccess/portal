<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
class CategoryManager extends Portal {

	public function render(){
		$smarty = $this->smarty;
		$this->setAdmin();
		$db = $this->db;
		
		$categories = $db->fetchAll($db->select()->from(array("c"=>"job_category"))->where("status = ?", "posted")->order("category_name"));
		foreach($categories as $key=>$category){
			$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"))->where("category_id = ?", $category["category_id"]));
			$categories[$key]["subcategories"] = $subcategories;
		}
		$smarty->assign("categories", $categories);
		$smarty->display("index.tpl");
	}
	
	public function getCategorized($id){
		$db = $this->db;
		if ($id){
			$categorized = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"))
								->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
								->joinLeft(array("jc"=>"job_category"), "jc.category_id = jsca.category_id", array("jc.category_name"))
								->joinLeft(array("p"=>"personal"), "p.userid = jsca.userid", array("p.fname", "p.lname"))
								->where("jsca.id = ?", $id));
			if ($categorized){
				return array("success"=>true, "categorized"=>$categorized);
			}else{
				return array("success"=>false);
				
			}
		}else{
			return array("success"=>false);
		}
		
	}
	
	public function updateCategoryDescription(){
		$db = $this->db;
		
		
	}
	
	public function updateCategorized(){
		$db = $this->db;
		if ($_REQUEST["id"]){
			//get the job category
			$sub_category_id = $_REQUEST["sub_category_id"];
			$id = $_REQUEST["id"];
			
			
			$jsca = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"))
								->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
								->joinLeft(array("jc"=>"job_category"), "jc.category_id = jsca.category_id", array("jc.category_name"))
								->where("jsca.id = ?", $id));
								
			
			
			
			//select other category
			$jscas = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"))
						->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
						->joinLeft(array("jc"=>"job_category"), "jc.category_id = jsca.category_id", array("jc.category_name"))
						->where("jsca.userid = ?", $jsca["userid"])
						->where("jsca.id <> ?", $jsca["id"])
						->where("jsca.sub_category_id = ?", $sub_category_id));
								
			$subcategory = $db->fetchRow($db->select()->from(array("jsc"=>"job_sub_category"))->where("sub_category_id = ?", $sub_category_id));
					
			if ($jscas){
				return array("success"=>false, "error"=>"Candidate is already assigned to ".$subcategory["sub_category_name"].".\nPlease transfer it to other subcategory");
			}					
			
				
			if ($subcategory&&$jsca){
				
				
				$db->update("job_sub_category_applicants", array("sub_category_id"=>$subcategory["sub_category_id"], "category_id"=>$subcategory["category_id"]), $db->quoteInto("id = ?", $id));		
				
				if ($jsca["sub_category_name"]!=$subcategory["sub_category_name"]){
					$changeByType = "admin";
					$history_changes = "changed categorized entry from <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span> to <span style='color:#ff0000'>".$subcategory["sub_category_name"]."</span>";
					$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$jsca["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
					
					
				}
				$new_jsca = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"))
								->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
								->joinLeft(array("jc"=>"job_category"), "jc.category_id = jsca.category_id", array("jc.category_name"))
								->where("jsca.id = ?", $id));
				return array("success"=>true, "categorized"=>$jsca);
			}else{
				return array("success"=>false);
			}
			
		}else{
			return array("success"=>false);
		}
	}
}
