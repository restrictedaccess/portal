<?php

/**
 * 
 * Class responsible for updating education background
 *
 * @version 0.1 - Initial commit on Staff Information
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
class UpdateEducationProcess{
	private $db;
	private $smarty;
	private $errors;
	private $success = false;
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->errors = array();
		$this->authCheck();
	}
	
	
	private function authCheck(){
	
		session_start();
		if (!isset($_SESSION["admin_id"])){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				die;
			}else{
				header("location:/portal/index.php");
			}
		}
	}	
		
		
	public function update(){
		$form = new UpdateEducationForm();
		$db = $this->db;
		if ($form->isValid($_POST)){
			$data =  $form->getValues();
			$userid = $_REQUEST["userid"];
			//before
			$old = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $_REQUEST["userid"]));
			
			$data["userid"] = $_REQUEST["userid"];
			if ($old){
				$db->update("education", $data, $db->quoteInto("userid = ?", $userid));
				$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			}else{
				$old = array();
				$db->insert("education", $data);
			}
			
			$new = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $_REQUEST["userid"]));
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				$changeByType = $_SESSION["status"];
				if ($changeByType=="FULL-CONTROL"){
					$changeByType = "ADMIN";
				}
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
				
			
			
			}
			
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			$this->success = true;
			return array("success"=>true);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}
	}
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_REQUEST["userid"];
		$form = new UpdateEducationForm();
		$education = array();
		$education = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $userid));
		if ($education){
			
			foreach($education as $key=>$value){
				//echo $key;	
				if ($key=="id"){
					continue;
				}
				if ($key=="college_country"){
					$sql = $db->select()
						->from('country'); 
					$countries = $db->fetchAll($sql) or die (mysql_error());
					foreach($countries as $country){
						if ($country["iso"]==$value){
							$value = $country["printable_name"];
						}
					}	
				}
				try{
					if(!empty($value)){
						$form->getElement($key)->setValue($value);
					}
				}catch(Exception $e){
					echo $key;
					
				}
				
			}
		}
		$form->getElement("userid")->setValue($_REQUEST["userid"]);
		$smarty->assign_by_ref("form", $form);
		$smarty->display("updateeducation.tpl");
	}
}
