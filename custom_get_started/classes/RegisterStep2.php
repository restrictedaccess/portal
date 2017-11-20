<?php
require_once dirname(__FILE__)."/../../lib/CheckLeadsFullName.php";
require_once dirname(__FILE__)."/../../tools/CouchDBMailbox.php";
include_once dirname(__FILE__)."/location_constants.php";
require_once dirname(__FILE__). "/../../lib/Contact.php";
require_once dirname(__FILE__). "/ShowPrice.php";

class RegisterStep2{
	
	private $db;
	private $smarty;
	
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
        $rs_contact_nos = new Contact();
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
        $ip_address = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : $_SERVER['REMOTE_ADDR']);
		$ip_address = ($ip_address && $ip_address != '192.168.122.1' ? $ip_address : '103.225.38.20');
        $leads_country = $this->_getCCfromIP($ip_address);
		if(empty($leads_country)){
			$leads_country = 'PH';
		}
        $this->smarty->assign("leads_country", $leads_country);
        $this->smarty->assign('contact_numbers',$contact_numbers);
		$this->smarty->assign('script','step2.js');
	}
	
	public function render($show_leads_info = false){
		
		//echo "<pre>";
		//print_r($_SESSION);
		//die;
		
		//GET DB INSTANCE
	    $db = $this->db;
	    
	    //GET SMARTY INSTANCE
	    $smarty = $this->smarty;
	    
		//NOTE : SEND URL TO CLIENT WITH RAN PARAMATER
		if(isset($_REQUEST['ran'])&&!empty($_REQUEST['ran'])){
			$gs_job_role_selection_sql = $db->select()
										    ->from('gs_job_role_selection',array('gs_job_role_selection_id','leads_id'))
										    ->where('ran = ?',$_REQUEST['ran']);
			$gs_job_role_selection = $db->fetchRow($gs_job_role_selection_sql);
			if($gs_job_role_selection['leads_id']){
				$_SESSION['gs_job_role_selection_id'] = $gs_job_role_selection['gs_job_role_selection_id'];
				$_SESSION['leads_id'] = $gs_job_role_selection['leads_id'];
				$_SESSION['client_id'] = $gs_job_role_selection['leads_id'];
				$_SESSION['filled_up_by_id'] = $gs_job_role_selection['leads_id'];
				$_SESSION['filled_up_by_type'] = 'leads';
				$_SESSION['from'] = 'email';
			}
		}
		
		//CHECK IF FROM IS ISSET
	    if(isset($_REQUEST["from"])){
	    	$_SESSION["from"] = $_REQUEST["from"];
	    }
		
		//STEP 1 IS NOT FINISHED
		if(!isset($_SESSION['client_id'])&&!isset($_SESSION['leads_id'])){
			header("Location:/portal/custom_get_started/");
			die;
		}
		
		//STEP 2 IS FINISH
		if(isset($_SESSION['job_order_ids'])){
			header("Location:/portal/custom_get_started/step3.php");
			die;
		}
		
		//CREATE LEAD SESSION IF CLIENT ID IS ISSET
        if (!isset($_SESSION["leads_id"])&&$_SESSION["client_id"]){
			$_SESSION["leads_id"] = $_SESSION["client_id"];
        }
        
        //CREATE CLIENT SESSION IF LEADS ID IS ISSET
        if (!isset($_SESSION["client_id"])&&$_SESSION["leads_id"]){
			$_SESSION["client_id"] = $_SESSION["leads_id"];
        }
        
		//GET CLIENT ID
		$client_id = (isset($_SESSION['leads_id']) ? $_SESSION['leads_id'] : $_SESSION['client_id']);
		
		//ASSIGN CLIENT ID
        $smarty->assign("client_id",$client_id);

        //CHECK IF WE NEED TO SHOW LEADS INFO
        if ($show_leads_info){
			$lead_sql = $db->select()
						   ->from("leads", array("fname","lname", "id"))
						   ->where("id = ?", $client_id);
            $lead = $db->fetchRow($lead_sql);    
            $smarty->assign("lead", $lead);
        }
        
        //CHECK IF SESSION "FROM" IS ISSET AND COMING FROM RECRUITEMENT SHEET
        if(isset($_SESSION['from'])&&$_SESSION["from"]=="recruitment_sheet"){
            $smarty->assign("disable_add", true);
        }else{
            $smarty->assign("disable_add", false);
        }
        
		$smarty->assign("categories",$this->getCategories());
		$smarty->clear_cache('step2.tpl'); 
		$smarty->display("step2.tpl");
		
	}
	
	public function process(){

	    if (!isset($_SESSION["leads_id"])&&$_SESSION["client_id"]){
             $_SESSION["leads_id"] = $_SESSION["client_id"];
        }
        if (!isset($_SESSION["client_id"])&&$_SESSION["leads_id"]){
             $_SESSION["client_id"] = $_SESSION["leads_id"];
        }
		$db =  $this->db;
		$currency = "AUD";
		if (isset($_POST["currency"])&&$_POST["currency"]){
			$currency = $_POST["currency"];
		}else{
			$currency = "AUD";
		}
		$result = array();
		$total_no_of_staff = 0;
		
		if (empty($_POST["job_orders"])){
			return array("success"=>false, "error"=>"Please select a job position.");
		}
		
		/*
		//JOB ORDER IDS SESSION HAS BEEN GENERATED - THERE FOR CONCLUDE THIS IS EDIT
		if(isset($_SESSION['job_order_ids'])){
			//DESTROY EVERYTHING
			foreach($_SESSION['job_order_ids'] as $key=>$job_order_id){
				if($key == 0){
					//EXTRACT JOB ORDER DETAILS
					$job_order_details_sql = $db->select()
												->from('gs_job_titles_details')
												->where('gs_job_titles_details_id=?',$job_order_id);
					$job_order_details = $db->fetchRow($job_order_details_sql);
					$gs_job_role_selection_id = $job_order_details['gs_job_role_selection_id'];
					//DELETE GS JOB ROLE SELECTION ENTRY
					$db->delete('gs_job_role_selection',$db->quoteInto('gs_job_role_selection_id=?',$gs_job_role_selection_id));
				}
				//DELETE GS JOB TITLE DETAILS
				$db->delete('gs_job_titles_details',$db->quoteInto('gs_job_titles_details_id=?',$job_order_id));
			}
		}
		*/
		
		//JOB ORDERS
		foreach($_POST["job_orders"] as $job_order){
			
			if (!$job_order["no_of_staff"]){
				$job_order["no_of_staff"]  = "1";
			}
			
			//FETCH JOB ORDER SUB CATEGORIES NEW PRICES
			$jo = $db->fetchRow($db->select()->
					from(array("jscnp"=>"job_sub_categories_new_prices"))
					->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jscnp.sub_category_id", array("singular_name AS sub_category_name"))
					->where("level = ?", $job_order["level"])
					->where("currency = ?", $currency)
					->where("jscnp.sub_category_id = ?", $job_order["subcategory"])
					->where("active = ?", 1));
					
			//CHECK JOB ORDER SUB CATEGORIES NEW PRICES IF NOT EXIST
			if (!$jo){
				//IF EXIST GET SUB CATEGORY NAME
				$jo = array("sub_category_id"=>$job_order["subcategory"], "currency"=>$currency, "level"=>$job_order["level"], "active"=>1, "value"=>0);
				$jo["sub_category_name"] = $db->fetchOne($db->select()->from("job_sub_category", array("singular_name AS sub_category_name"))->where("sub_category_id = ?", $job_order["subcategory"]));
			}
			
			//CHECK JOB ORDER SUB CATEGORIES NEW PRICES IF EXIST
			if ($jo){
				$jo["category_name"] = $db->fetchOne($db->select()->from("job_category", array("category_name"))->where("category_id = ?", $job_order["category"]));
				$jo["no_of_staff"] = $job_order["no_of_staff"];
				$jo["work_status"] = $job_order["work_status"];
				$total_no_of_staff += intval($job_order["no_of_staff"]);
				if ($jo["level"]=="mid"){
					$jo["level"] = "mid";
				}else if ($jo["level"]=="entry"){
					$jo["level"] = "entry";
				}else{
					$jo["level"] = "expert";
				}
				if ($job_order["work_status"]=="Part-Time"){
					$jo["value"] = number_format($jo["value"]*.6, 2);
				}else{
					$jo["value"] = number_format($jo["value"], 2);
					
				}
				$jo["currency"] = $currency;
				$result[] = $jo;
			}
		}

        if (!isset($_SESSION["gs_job_role_selection_id"])){
            $ran = get_rand_id();
            $data = array(
                "leads_id"=>$_SESSION["leads_id"],
                "ran"=>$ran,
                "date_created"=>date("Y-m-d H:i:s"),
                "status"=>"new",
                "no_of_job_role"=>count($result),
                "indian_applicant"=>"no",
                "currency"=>$currency,
                "created_by_id"=>$_SESSION["leads_id"],
                "created_by_type"=>"leads",
                "filled_up_by_id"=>$_SESSION["leads_id"],
                "filled_up_by_type"=>"leads",
                "filled_up_date"=>date("Y-m-d H:i:s"),
                "filled_up_visible"=>(isset($_SESSION['filled_up_visible'])&&$_SESSION['filled_up_visible']==0 ? 0 : 1)
            );
            
            $db->insert("gs_job_role_selection", $data);
            $gs_job_role_selection_id = $db->lastInsertId("gs_job_role_selection");
            
            $_SESSION['filled_up_by_id'] = $_SESSION["leads_id"];
            $_SESSION['filled_up_by_type'] = "leads";

        }else{
            $gs_job_role_selection_id = $_SESSION["gs_job_role_selection_id"];
            $db->update("gs_job_role_selection", array(
                "no_of_job_role"=>count($result),
                "indian_applicant"=>"no",
                "currency"=>$currency,
            ), $db->quoteInto("gs_job_role_selection_id = ?", $gs_job_role_selection_id));
            
        }

		
		
		$job_order_ids = array();
		foreach($result as $job_order){
				
			$pricing = array("jr_cat_id"=>4, "jr_name"=>$job_order["sub_category_name"], "jr_status"=>"manual", "jr_currency"=>$currency);	
			
			if ($job_order["level"]=="entry"){
				$pricing["jr_entry_price"] = $job_order["value"];
				$pricing["jr_mid_price"] = 0;
				$pricing["jr_expert_price"] = 0;
			}else if ($job_order["level"]=="mid"){
				$pricing["jr_entry_price"] = 0;
				$pricing["jr_mid_price"] = $job_order["value"];
				$pricing["jr_expert_price"] = 0;
			}else{
				$pricing["jr_entry_price"] = 0;
				$pricing["jr_mid_price"] = 0;
				$pricing["jr_expert_price"] = $job_order["value"];
			}
			
			$db->insert("job_role_cat_list",$pricing);	
			
			$jr_list_id = $db->lastInsertId("job_role_cat_list");
			
			/*
			//CHECK SERVICE TYPE SESSION - NOTE SERVICE TYPE SESSION IS SET WHEN JOB ROLE COMES FROM ASL - IT ONLY HAPPENS ONCE
			if(isset($_SESSION['service_type'])&&$_SESSION['service_type']=='ASL'){
				$service_type = 'ASL';
				unset($_SESSION['service_type']); //REMOVE SERVICE TYPE SESSION
			}else{
				$service_type = 'CUSTOM';
			}
			*/
			
			
			/* GET JOB SUB CATEGORY DETAILS */
			$job_sub_category_sql = $db->select()
									   ->from('job_sub_category')
									   ->where('sub_category_id=?',$job_order['sub_category_id']);
			$job_sub_category = $db->fetchRow($job_sub_category_sql);
			
			$item = array( 
			"gs_job_role_selection_id"=>$gs_job_role_selection_id, 
			"jr_list_id"=>$jr_list_id,
			"jr_cat_id"=>4,
			'selected_job_title'=>( isset($job_sub_category['singular_name'])&&!empty($job_sub_category['singular_name']) ? $job_sub_category['singular_name'] : $job_sub_category['sub_category_name'] ),
			"level"=>$job_order["level"],
			"no_of_staff_needed"=>$job_order["no_of_staff"],
			"job_role_no"=>1,
			"status"=>"new",
			"form_filled_up"=>"yes",
			"date_filled_up"=>date("Y-m-d H:i:s"),
			"service_type"=>'CUSTOM',
			"sub_category_id"=>$job_order["sub_category_id"], 
			"created_reason"=>"New JS Form Client",
			"work_status"=>$job_order["work_status"]
			);
			
			if(isset($_SESSION["from"])&&$_SESSION["from"]=="recruitment_sheet"){
				$item["created_reason"] = "Converted-From-ASL";
				$item["service_type"] = "ASL";
			}
			
			$db->insert("gs_job_titles_details", $item);
			$gs_job_titles_details_id = $db->lastInsertId("gs_job_titles_details");
			
			
			
			//load gs_job_titles details to write mongo exact copy
			$job_spec = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			$job_role_selection = $db->fetchRow($db->select()->from("gs_job_role_selection")->where("gs_job_role_selection_id = ?", $job_spec["gs_job_role_selection_id"]));
			$job_spec["job_role_selection"] = $job_role_selection;
			$job_spec["price"] = $job_order["value"];
			
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
				$job_spec_collections->insert($job_spec);
			}catch(Exception $e){
				
			}
			
			
			$job_order_ids[] = $gs_job_titles_details_id;
		}
		
		$_SESSION["job_order_ids"] = $job_order_ids;
		return array("success"=>true);
		
	}
	
	
	/**
	 * Get All Categories
	 */
	public function getCategories($category = null){

		$db = $this->db;

		$category_filter = '';
		if($category != null){
			$category_filter = 'and  category_id = '.$category;
		}

		$select="SELECT category_id, category_name FROM job_category
			WHERE status='posted' ".$category_filter." 
			ORDER BY category_name";
		$rows = $db->fetchAll($select);

		$categories = array();
		foreach($rows as $row){
			$sub_categories_sql = $db->select()
									 ->from('job_sub_category')
									 ->where('category_id=? AND status="posted"',$row['category_id']);
			$sub_categories = $db->fetchAll($sub_categories_sql);
			if(count($sub_categories)){
				$category = array();
				$category['category']['id'] = $row['category_id'];
				$category['category']['name'] = $row['category_name'];
				$categories[] = $category;
			}
		}
		return $categories;
	}
	/**
	 * Get All subcategory under the given category
	 */
	public function getSubCategories($category_id){

		$db = $this->db;
		$select = "SELECT sub_category_id, sub_category_name
				FROM job_sub_category 
				WHERE category_id='".$category_id."' AND 
				status = 'posted' 
				ORDER BY sub_category_name";
		$rows = $db->fetchAll($select);
		return $rows;
	}
	

	private function getStep2(){
		
		//GET DB INSTANCE
		$db = $this->db;
		
		//GET SMARTY INSTANCE
		$smarty = $this->smarty;
		
		//PASS JOB ORDER IDS
		$job_order_ids = $_SESSION['job_order_ids'];
		
		//GS JOB ROLE SELECTION ID
		$gs_job_role_selection_id = 0;

		//GS JOB ORDER DETAILS
		$new_job_order_details = array();
		
		//CURRENY DETAILS
		$new_job_order_currency_details = array();
		
		//SUB CATEGORY
		$subcategories = array();
		
		//LOOP EACH JOB ORDER
		foreach($job_order_ids as $key=>$job_order_id){ 
			
			//EXTRACT JOB ORDER DETAILS
			$job_order_details_sql = $db->select()
										->from('gs_job_titles_details')
										->where('gs_job_titles_details_id=?',$job_order_id);
			$job_order_details = $db->fetchRow($job_order_details_sql);
			
			//EXTRACT CATEGORY ID
			$category_id_sql = $db->select()
							   ->from('job_sub_category',array('category_id'))
							   ->where('sub_category_id=?',$job_order_details['sub_category_id']);
			$job_order_details['category_id'] = $db->fetchOne($category_id_sql);
			
			//STORE NEW JOB ORDER DETAILS
			$new_job_order_details[] = $job_order_details;
			

			//EXTRACT SUBCATEGORY SELECTION
			$subcategories[] = $this->getSubCategories($job_order_details['category_id']);

			//JOB ORDER RATE
			$job_order_rate = $this->get_job_order_rate($job_order_id);
			
			//EXTRACT CURRENCY DETAILS
			$new_job_order_currency_details[] = $this->get_rates($job_order_rate);
			
			//IF KEY == 0 FIRST LOOP -> GET JOB ROLE SELECTION
			if($key == 0){

				//PULL GS JOB ROLE SELECTION ID
				$gs_job_role_selection_id = $job_order_details['gs_job_role_selection_id'];

			}

		}
		
		//GS JOB ROLE SELECTION
		$job_role_details_sql = $db->select()
								   ->from('gs_job_role_selection')
								   ->where('gs_job_role_selection_id=?',$gs_job_role_selection_id);
		$job_role_details = $db->fetchRow($job_role_details_sql);
		
		//SEND JOB ORDER AND JOB ROLE DETAILS DETAIL
		$smarty->assign('job_order_details',$new_job_order_details);
		$smarty->assign('job_order_currency_details',$new_job_order_currency_details);
		$smarty->assign('job_role_details',$job_role_details);
		$smarty->assign('subcategories',$subcategories);
		
	}
	
	
	private function get_rates($job_order = array()){
		$db = $this->db;
        $jo = $db->fetchRow($db->select()->
                from(array("jscnp"=>"job_sub_categories_new_prices"))
                ->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jscnp.sub_category_id", array("sub_category_name"))
                ->where("level = ?", $job_order["level"])
                ->where("currency = ?", $job_order['currency'])
                ->where("jscnp.sub_category_id = ?", $job_order["sub_category_id"])
                ->where("active = ?", 1));
        if (!$jo){
            $jo = array("sub_category_id"=>$job_order["sub_category_id"], "currency"=>$job_order['currency'], "level"=>$job_order["level"],"active"=>1,"value"=>0);
            $jo["sub_category_name"] = $db->fetchOne($db->select()->from("job_sub_category", array("singular_name AS sub_category_name"))->where("sub_category_id=?", $job_order["sub_category_id"]));
        }       
        if ($jo){
            $jo["category_name"] = $db->fetchOne($db->select()->from("job_category", array("category_name"))->where("category_id = ?", $job_order["category_id"]));
            $jo["no_of_staff"] = $job_order["no_of_staff_needed"];
            if ($jo["level"]=="mid"){
                $jo["level"] = "Mid Level";
            }else if ($jo["level"]=="entry"){
                $jo["level"] = "Entry";
            }else{
                $jo["level"] = "Expert";
            }
            if ($jo["value"]>0){
                if ($job_order["work_status"]=="Part-Time"){
                    $jo["value"] = number_format($jo["value"]*.6, 2);
                    $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/4, 2);
                }else{
                    $jo["hourly_value"] = number_format(((($jo["value"]*12)/52)/5)/8, 2);
                    $jo["value"] = number_format($jo["value"], 2);  
                }
            }else{
                $jo["value"] = false;
                $jo["hourly_value"] = false;
            }
            $jo["currency_symbol"] = $db->fetchOne($db->select()->from("currency_lookup", array("sign"))->where("code=?", $job_order["currency"]));
            $jo["currency"] = $job_order["currency"];
            return $jo;
        }
	}
	
	private function get_job_order_rate($job_order_id=0){
		$db = $this->db;
		$job_order_rate_sql = $db->select()
						 ->from(array('gjtd'=>'gs_job_titles_details'),array('level','no_of_staff_needed','sub_category_id','work_status'))
						 ->joinLeft(array('jsc'=>'job_sub_category'),'jsc.sub_category_id=gjtd.sub_category_id',array('category_id'))
						 ->joinLeft(array('gjrs'=>'gs_job_role_selection'),'gjrs.gs_job_role_selection_id=gjtd.gs_job_role_selection_id',array('currency'))
						 ->where('gs_job_titles_details_id=?',$job_order_id);
		$job_order_rate = $db->fetchRow($job_order_rate_sql);
		return $job_order_rate;
	}
	
    private function _getALLfromIP($addr) {
        // this sprintf() wrapper is needed, because the PHP long is signed by default
        $db = $this->db;
        $ipnum = sprintf("%u", ip2long($addr));
        $query = "SELECT cc, cn FROM ip NATURAL JOIN cc WHERE ${ipnum} BETWEEN start AND end";
        $result = $db->fetchRow($query);
        
        return $result;
    }
    
    private function _getCCfromIP($addr) { 
        $data = $this->_getALLfromIP($addr);
        if($data) return $data['cc'];
        return false;
    }
	
}
