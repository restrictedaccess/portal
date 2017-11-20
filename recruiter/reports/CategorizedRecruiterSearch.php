<?php
require_once dirname(__FILE__)."/AbstractCategorized.php";
class CategorizedRecruiterSearch extends AbstractCategorized{
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$recruiters = $this->getRecruiters();
		$categories = $this->getCategories();
		
		foreach($categories as $key=>$category){
			$categories[$key]["subcategories"] = $this->getSubCategories($category["category"]["id"]);
		}
		$smarty->assign("start", date("Y-m")."-01");
		$smarty->assign("today", date("Y-m-d"));
		$smarty->assign("recruiters", $recruiters);
		$smarty->assign("categories", $categories);
		//display categorized tab
		$smarty->display("recruiter_categorized.tpl");
	}

}
