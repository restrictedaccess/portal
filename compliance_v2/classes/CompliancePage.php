<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
/**
 * Admin Page
 * 
 * @author Allanaire Tapion
 * 
 */
class CompliancePage extends Portal{
	
	public function render(){
		global $nodejs_api;	
		$smarty = $this->smarty;
		
		$smarty->assign("ADMIN_ID", $_SESSION["admin_id"]);
		$smarty->assign("BASE_API_URL", $this->getAPIURL());
		if (TEST){
			$smarty->assign("WS_URL", "ws://test.api.remotestaff.com.au");	
		}else if (STAGING){
			$smarty->assign("WS_URL", "ws://staging.api.remotestaff.com.au");
		}else{
			$smarty->assign("WS_URL", "wss://api.remotestaff.com.au");
		}
		$smarty->assign("NJS_API_URL", $nodejs_api);
		$smarty->display("index.tpl");
		
	}
}
