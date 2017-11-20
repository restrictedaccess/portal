<?php
require_once dirname(__FILE__)."/../../lib/CheckLeadsFullName.php";
require_once dirname(__FILE__)."/../../tools/CouchDBMailbox.php";
require_once dirname(__FILE__). "/../../lib/Contact.php";

class RegisterOptionalStep4{
	private $db;
	private $smarty;
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
        $rs_contact_nos = new Contact();
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
        
        $this->smarty->assign('contact_numbers',$contact_numbers);
		$this->smarty->assign('script','step4.js');
	}
	public function render(){
		$db = $this -> db;
		$smarty = $this->smarty;
		if (!isset($_SESSION["step"])){
			header("Location:/portal/custom_get_started/step3.php");
		}
		if (isset($_SESSION["job_order_ids"]) && !empty($_SESSION["job_order_ids"])){
			$job_order_ids = $_SESSION["job_order_ids"];
		} else {
			//header("Location:/portal/custom_get_started/");
			//die;
		}
		$job_orders = array();
		foreach ($job_order_ids as $key => $job_order_id) {
			$job_order = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $job_order_id));
			if ($key == 0) {
				$job_order["selected"] = true;
			} else {
				$job_order["selected"] = false;
			}
			if ($job_order) {
				$job_orders[] = $job_order;
			}
		}
		$timezones = $db -> fetchAll($db -> select() -> from("timezone_lookup") -> order("timezone"));
        
        $ip_address = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : $_SERVER['REMOTE_ADDR']);
        $ip_address = ($ip_address == '192.168.122.1' ? '103.225.38.20' : $ip_address);
        $leads_country = $this->_getCCfromIP($ip_address);
        $smarty->assign("leads_country", $leads_country);
		$smarty->assign("job_orders", $job_orders);
		$smarty->clear_cache('step4.tpl'); 
		$smarty->display("step4.tpl");
	}
	
	public function process(){
		$db = $this -> db;
		$this->update_checkbox("increase_demand");
		$this->update_checkbox("replacement_post");
		$this->update_checkbox("support_current");
		$this->update_checkbox("experiment_role");
		$this->update_checkbox("meet_new");
		return array("success"=>true);
		
	}
    private function _getALLfromIP($addr) {
        //GET DB INSTANCE
        $db = $this->db;
        $ipnum = sprintf("%u", ip2long($addr));
        $query = "SELECT cc, cn FROM ip NATURAL JOIN cc WHERE ${ipnum} BETWEEN start AND end";
        $result = $db->fetchRow($query);
        return $result;
    }
    
    private function _getCCfromIP($addr){
        $data = $this->_getALLfromIP($addr);
        if($data){
            return $data['cc']; //SHORTNAME
        }
        return false;
    }
	
	private function update_checkbox($key_list){
		$db = $this->db;

		if (!empty($_REQUEST[$key_list])){
				
			foreach($_REQUEST[$key_list] as $key=>$val){
				
				$gs_job_role_selection_id = $_REQUEST["gs_job_role_selection_id"][$key];
				$gs_job_titles_details_id = $_REQUEST["gs_job_titles_details_id"][$key];
				$db->delete("gs_job_titles_credentials", "gs_job_titles_details_id = '".$gs_job_titles_details_id."' AND gs_job_role_selection_id = '".$gs_job_role_selection_id."' AND box = '".$key_list."'");
			
				if ($val=="on"){
					$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", $key_list));
					if (!$cred) {
						$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" =>"checked", "box" => $key_list));
					} else {
						$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" =>"checked", "box" => $key_list), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
					}
				}else{
					$db->delete("gs_job_titles_credentials", "gs_job_titles_details_id = '".$gs_job_titles_details_id."' AND gs_job_role_selection_id = '".$gs_job_role_selection_id."' AND box = '".$key_list."'");
				}
				
				try{
					$retries = 0;
					while(true){
						try{
							if (TEST){
								$mongo = new MongoClient(MONGODB_TEST);
								$database = $mongo->selectDB('prod');
							}else{
								$mongo = new MongoClient(MONGODB_SERVER);
								$database = $mongo->selectDB('prod');
							}
							break;
						} catch(Exception $e){
							++$retries;
							
							if($retries >= 100){
								break;
							}
						}
					}
					
					$job_spec_collections = $database->selectCollection("job_specifications");
					$cursor = $job_spec_collections->find(array("gs_job_titles_details_id"=>$gs_job_titles_details_id));
					
					while($cursor->hasNext()){
						$job_spec = $cursor->getNext();
						
						if (!isset($job_spec["other_details"])){
							$other_details = array();
						}else{
							$other_details = $job_spec["other_details"];
						}
						if ($val=="on"){
							$other_details[$key_list] = "Yes";						
						}else{
							$other_details[$key_list] = "No";
						}
						
						
						$job_spec_collections->update(array("gs_job_titles_details_id"=>$gs_job_titles_details_id), array('$set'=>array("other_details"=>$other_details)));						
					}
					
				}catch(Exception $e){
					
				}
			}
		}
	}
}
