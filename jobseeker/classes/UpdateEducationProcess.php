<?php
/**
 * Class responsible for updating education
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../forms/UpdateEducationForm.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";

class UpdateEducationProcess extends EditProcess{
	public function update(){
		$form = new UpdateEducationForm();
		$db = $this->db;
		if ($form->isValid($_POST)){
			$data =  $form->getValues();
			$userid = $_SESSION["userid"];
			//before
			$old = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $_SESSION["userid"]));
			
			$data["userid"] = $_SESSION["userid"];
			if ($old){
				$db->update("education", $data, $db->quoteInto("userid = ?", $userid));
				$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			}else{
				$old = array();
				$db->insert("education", $data);
			}
			
			$new = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $_SESSION["userid"]));
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
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			
			global $base_api_url;
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
			
			$this->success = true;
			
			
			file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
			
			return array("success"=>true);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}
	}
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION["userid"];
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
					$userid_hidden_element = $form->getElement($key);
					if(in_array("setValue", get_class_methods($userid_hidden_element))){
						$userid_hidden_element->setValue($value);
					}
						
					
				}catch(Exception $e){
					echo $key;
				}
				
			}
		}
		$form->getElement("userid")->setValue($_SESSION["userid"]);
		$smarty->assign_by_ref("form", $form);
		$this->setActive("educational_active");
		$this->syncUserInfo();
		$this->setActive("resume_active");
		
		$smarty->display("educational_details.tpl");
	}
}
