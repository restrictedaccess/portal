<?php
class ReferralSheet{
	
	private $smarty;
	private $db;
	
	public function __construct($db){
		$this->smarty = new Smarty();
		$this->db = $db;
		$this->authCheck();
	}
	
	
	private function authCheck(){
	
		//$_SESSION['status'] = "FULL-CONTROL";
		//$_SESSION['admin_id'] = 31;
		if (!isset($_SESSION["status"])){
			header("location:/portal/index.php");
		}
		
	
		if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
			echo "This page is for HR usage only.";
			exit;
		}
		
	}
	
	
	public function render(){
		$smarty = $this->smarty;
		$smarty->display("referral_sheet.tpl");
	}
	
	public function render_new(){
		$smarty = $this->smarty;
		$smarty->display("referral_list.tpl");
	}
	
	
	
}