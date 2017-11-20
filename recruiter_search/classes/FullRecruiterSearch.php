<?php
/**
 * Full Text Search Class
 *
 * @author Marlon Peralta
 * @copyright Remote Staff Inc.
 *
 * @version 0.0.1
 * 
 * @method string render()
 */
require_once dirname(__FILE__) . "/../../lib/Portal.php";

class RecruiterSearch extends Portal {

	public function render() {
		$this->setAdmin();
		$db = $this -> db;
		$smarty = $this -> smarty;

		if (isset($_GET["q"])){
			$q = $_GET["q"];
			$smarty -> assign("q", $q);			
		}else{
			$smarty -> assign("q","");
		}
		global $base_api_url;
		$smarty -> assign("base_url_api",$base_api_url);

		
		$smarty -> display("recruiter_search.tpl");
		
	}

}
