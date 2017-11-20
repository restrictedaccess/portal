<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
/**
 * ManagePayment Advise Page
 * 
 * @author Allanaire Tapion
 * 
 */
class AccountsPage extends Portal{
	
	public function render(){
		global $nodejs_api;
		$smarty = $this->smarty;
		if (isset($_REQUEST["page"])){
			$smarty->assign("DEFAULT_PAGE", $_REQUEST["page"]);
		}
		$smarty->assign("ADMIN_ID", $_SESSION["admin_id"]);
		$smarty->assign("NJS_API_URL", $nodejs_api);
		$smarty->assign("BASE_API_URL", $this->getAPIURL());
		$smarty->display("index.tpl");
		
	}
}
