<?php
/**
 * Class responsible for listing job ads
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";

class JobLoader extends EditProcess{
	
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		
		$page = $_GET["page"];
		$q = $_GET["q"];
		$limit = 20;
		
		$sql = $db->select()
						->from(array("p"=>"posting"), 
								array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS id"), "outsourcing_model", 
										"companyname", "jobposition","job_order_id","ads_title","sub_category_id", 
										new Zend_Db_Expr("DATE_FORMAT(date_created,'%D %M %Y') AS date_created")))
						->where("p.status = 'ACTIVE'")
						->where("p.show_status = 'YES'")
						->order('p.date_created DESC');
		if (isset($_GET["page"])){
			$sql->limitPage($page, $limit);
		}else{
			$sql->limitPage(1, 20);
			$page = 1;
		}
		if (isset($_GET["q"])){
			$sql->where("jobposition LIKE '%".addslashes($q)."%'");
		}
		$jobs = $db->fetchAll($sql);
		$count = $db->fetchOne("SELECT FOUND_ROWS() AS count");
		$pages = ceil($count/$limit);
		$pagination = array();
		if ($page<$pages){
			$next_page = "/portal/jobseeker/jobs.php?page=".($page+1);
			
		}else{
			$next_page = "";
			
		}
		if ($page>1){
			$prev_page = "/portal/jobseeker/jobs.php?page=".($page-1);
			
		}else{
			$prev_page = "";
		}
		
		
		for($i=1;$i<=$pages;$i++){
			$pagination[] = array("label"=>$i, "url"=>"/portal/jobseeker/jobs.php?page=".$i."&q=".$q);	
			
		}
		$smarty->assign("next_page", $next_page);
		$smarty->assign("prev_page", $prev_page);
		$smarty->assign("currentpage", $page);
		$smarty->assign("count", $count);
		$smarty->assign("pagination", $pagination);
		$smarty->assign("jobs", $jobs);
		$smarty->assign("q", $q);
		$this->setActive("jobs_active");
		$this->syncUserInfo();
		$smarty->display("jobs.tpl");
	}
}
