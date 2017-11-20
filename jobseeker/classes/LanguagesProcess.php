<?php 
/**
 * Class responsible for updating personal information
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../forms/AddLanguageForm.php";
require_once dirname(__FILE__)."/../forms/UpdateLanguageForm.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";
class LanguagesProcess extends EditProcess{
	
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$userid = $_SESSION["userid"];
		
		//load list of languages
		$languages = $db->fetchAll($db->select()->from(array("l"=>"language"))->where("userid = ?", $userid));
		
		$smarty->assign("languages", $languages);
		$form = new UpdateLanguageForm();
		$form->getElement("userid")->setValue($userid);
		$smarty->assign_by_ref("form", $form);
		$this->setActive("language_active");
		$this->setActive("resume_active");
		$this->syncUserInfo();
		$smarty->display("updatelanguages.tpl");
	}
	
	
	public function renderUpdate(){
		$db = $this->db;
		$smarty = $this->smarty;
		$id = $_REQUEST["id"];
		if (!isset($id)){
			die("Missing language id");
		}
		$language = $db->fetchRow($db->select()->from(array("l"=>"language"))->where("l.id = ?", $id));
		if ($language){
			$form = new UpdateLanguageForm();
			foreach($language as $key=>$val){
				try{
					$form->getElement($key)->setValue($val);
				}catch(Exception $e){
					
				}
			}
			
			$this->syncUserInfo();
			$this->setActive("language_active");
			$this->setActive("resume_active");
			$smarty->assign_by_ref("form", $form);
			$smarty->display("updatelanguageinfo.tpl");
		}else{
			die("Invalid language id");
		}
	}
	
	public function updateLanguage(){
		$form = new UpdateLanguageForm();
		$db = $this->db;
		if ($form->isValid($_POST)){
			$userid = $_SESSION["userid"];
			$languages = $db->fetchAll($db->select()->from("language")->where("userid = ?", $userid));
			foreach($languages as $language){
				if ((strtolower($language["language"])==strtolower($_POST["language"]))&&($language["id"]!=$_POST["id"])){
						
					echo json_encode(array("success"=>false, "error"=>"You already listed this language. Please try again.", "language"=>$language));
					
					exit;
				}	
			}
			$data = $form->getValues();
			$old = $db->fetchRow($db->select()->from(array("l"=>"language"))->where("id = ?",$data["id"]));
			
			$db->update("language", $data, $db->quoteInto("id = ?", $data["id"]));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?", $userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			
			$new = $db->fetchRow($db->select()->from(array("l"=>"language"))->where("id = ?",$data["id"]));
			
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			
			}
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			
			global $base_api_url;
			
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
		
			
			file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
			return array("success"=>true, "language"=>$new);
		}else{
			return array("success"=>false, "errors"=>$form->getErrors());
		}
	}
	
	public function addLanguage(){
		$form = new AddLanguageForm();
		$db = $this->db;
		if ($form->isValid($_POST)){
			$userid = $_SESSION["userid"];
			$languages = $db->fetchAll($db->select()->from("language", array("language"))->where("userid = ?", $userid));
			foreach($languages as $language){
				if (strtolower($language["language"])==strtolower($_POST["language"])){
					echo json_encode(array("success"=>false, "error"=>"You already listed this language. Please try again."));
					exit;
				}	
			}
			$data = $form->getValues();
			$data["userid"] = $userid;
			$db->insert("language", $data);
			$id = $db->lastInsertId("language");
			$language = $db->fetchRow($db->select()->from("language")->where("id = ?",$id));
			$history_changes = "Added new language <span style='color:red;'>".$language["language"]."</span>";
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			
			global $base_api_url;
			
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
			
			file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
			return array("success"=>true, "language"=>$language);
			
		}else{
			return array("success"=>false, "errors"=>$form->getErrors());
		}
	}


	public function deleteLanguage(){
		$db = $this->db;
		$language_id = $_GET["id"];
		$language = $db->fetchRow($db->select()->from("language")->where("id = ?", $language_id));
		if ($language["userid"]!=$_SESSION["userid"]){
			return array("success"=>false);
		}
		$db->delete("language", $db->quoteInto("id = ?", $language_id));
		$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $_SESSION["userid"]));
		$db -> delete("solr_candidates", $db -> quoteInto("userid=?", $_SESSION["userid"]));
		
		global $base_api_url;
		
		file_get_contents($base_api_url . "/solr-index/sync-candidates/");
							
		
		
		file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
		return array("success"=>true);
		
	}


}
