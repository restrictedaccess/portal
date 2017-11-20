<?php 
abstract class EditProcess extends AbstractProcess{
	protected function setActive($name){
		$this->smarty->assign($name, "active");
	}
	protected function syncUserInfo(){
		
		$user = $this->db->fetchRow($this->db->select()->from(array("p"=>"personal"), array("p.*", new Zend_Db_Expr("DATE_FORMAT(dateupdated,'%D %b %Y') AS date_updated"), new Zend_Db_Expr("DATE_FORMAT(datecreated,'%D %b %Y') AS date_created")))->where("userid = ?", $_SESSION["userid"]));
		$this->smarty->assign("user", $user);
	}
	
	protected function getUser(){
		$user = $this->db->fetchRow($this->db->select()->from(array("p"=>"personal"), array("p.*", new Zend_Db_Expr("DATE_FORMAT(dateupdated,'%D %b %Y') AS date_updated"), new Zend_Db_Expr("DATE_FORMAT(datecreated,'%D %b %Y') AS date_created")))->where("userid = ?", $_SESSION["userid"]));
		return $user;
	}
}
