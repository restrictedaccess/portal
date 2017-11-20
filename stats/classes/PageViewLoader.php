<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
class PageViewLoader extends Portal{
	public function render(){
		$this->setAdmin();
		$smarty = $this->smarty;
		$smarty->assign("date_from", date("Y-m-")."01");
		$smarty->assign("date_to", date("Y-m-d"));
		$smarty->display("page_view.tpl");
	}
}
