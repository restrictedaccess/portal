<?php

require_once dirname(__FILE__)."/../../lib/Portal.php";

class ConvertAds extends Portal {
	
	public function render(){
	    
            
            
	    //GET BASE API URL
        $base_api_url = $this -> getAPIURL();
        
        //GET ALL ALLOWED TO CONVERT TO ADS
        $allowed_to_convert = $this -> curl -> get($base_api_url."/admin/get-all-allowed-to-convert-to-ads",array());
        $allowed_to_convert = json_decode($allowed_to_convert,true);
        
        //CHECK IF THE USER CAN CONVERT TO ADS
        $allow_convert_to_ads = false;
        foreach($allowed_to_convert['allowed_to_convert'] as $allowed){
			if($_SESSION['admin_id'] == $allowed['admin_id']){
				$allow_convert_to_ads = true;
				break;
			}
		}
        
        //CATEGORORY DETAILS RESULT
        $categories_detail = $this -> curl -> get($base_api_url."/category/get-categories-default-for-ad/",array());
        $categories_detail = json_decode($categories_detail,true);
        
		//ADS DETAILS RESULT
        $ads_detail = $this -> curl -> get($base_api_url."/ads/get-job-order-details/",array("gs_job_titles_details_id"=>$_GET["gs_job_titles_details_id"]));
        $ads_detail = json_decode($ads_detail,true);
        
        //CHECK IF POSTING DATA EXISTS
        if(isset($ads_detail['posting'])&&!empty($ads_detail['posting'])){
			//POSTING HISTORIES
			$history = $this -> curl -> get($base_api_url."/ads/get-convert-to-ads-history/",array('posting_id'=>$ads_detail['posting']['id']));
			$history = json_decode($history,true);
		}
        
        //CHECK IF JOB SPEC ALREADY EXISTS
        if(empty($ads_detail['job_spec'])){
			header("Location:/portal/recruiter/recruitment_sheet.php");
		}
        
        //LEAD DETAILS RESULT
        $lead = $this -> curl ->get($base_api_url."/leads/get-leads-profile-by-id/",array("id"=>$ads_detail["job_role"]["leads_id"]));
        $lead = json_decode($lead,true);
        
        //DROPDOWN OUTSOURCE MODEL
		$outsourcing_model = array();
        $outsourcing_model [] = "Home Office";
        $outsourcing_model [] = "Office Location";
        $outsourcing_model [] = "Project Base";
        
        //DROPDOWN STATUS
        $status = array();
        $status [] = "NEW";
        $status [] = "ARCHIVE";
        $status [] = "ACTIVE";
        
        //DROPDOWN SHOW STATUS
        $show_status = array();
        $show_status [] = "YES";
        $show_status [] ="NO";
        
        //DROPDOWN COMPANY
        $company = array();
        $company [] = "RemoteStaff Inc.";
        $company [] = "RemoteStaff client";
        $company [] = "Realestate.ph";
        
        //DROPDOWN RATINGS
        $ratings = array();
        $ratings [1] = 'Beginner';
        $ratings [2] = 'Intermediate';
        $ratings [3] = 'Advanced';
		
		//ASSIGN VARIABLES TO SMARTY TEMPLATE
        $this -> smarty -> assign("BASE_API_URL", $base_api_url);
        $this -> smarty -> assign("change_by_id",$_SESSION['admin_id']);
        $this -> smarty -> assign("change_by_type",$_SESSION['logintype']);
		$this -> smarty -> assign("outsourcing_model",$outsourcing_model);
		$this -> smarty -> assign("categories",$categories_detail['categories']);
		$this -> smarty -> assign("posting",$ads_detail["posting"]);
        $this -> smarty -> assign("requirements",$ads_detail["requirements"]);
        $this -> smarty -> assign("requirements_must_to_have",$ads_detail["requirements_must_to_have"]);
        $this -> smarty -> assign("requirements_good_to_have",$ads_detail["requirements_good_to_have"]);
		$this -> smarty -> assign("responsibilities",$ads_detail["responsibilities"]);
		//$this -> smarty -> assign("special_instruction",$ads_detail['special_instruction']);
		$this -> smarty -> assign("job_role",$ads_detail['job_role']);
		$this -> smarty -> assign("job_spec",$ads_detail["job_spec"]);
		$this -> smarty -> assign("lead",$ads_detail['lead']);
		$this -> smarty -> assign("show_status",$show_status); 
		$this -> smarty -> assign("status",$status);
		$this -> smarty -> assign("company",$company);
		$this -> smarty -> assign("ratings",$ratings);
		$this -> smarty -> assign("action",$ads_detail['action']);
		$this -> smarty -> assign("history_sequence",count($history['posting_histories']));
		$this -> smarty -> assign("histories",$history['posting_histories']);
		$this -> smarty -> assign('allow_convert_to_ads',$allow_convert_to_ads);
		$this -> smarty -> display("convert_to_ads.tpl");		

	}
	
    public function convert(){

        //GET DECLARED VARIABLES
        $curl = $this -> curl;
        $main_db = $this -> db;
        $base_api_url = $this -> getAPIURL();
        
        //GET JOB ORDER ID
        $job_order_id = $_POST["job_order_id"];
        
        //GET ACTION
        $action = $_POST['action'];
        
        //GET CHANGE BY ID
        $change_by_id = $_POST['change_by_id'];
        
        //GET CHANGE BY TYPE
        $change_by_type = $_POST['change_by_type'];
        
        //ALLOCATE REQUIREMENTS VARIABLES
        $requirements = ( isset($_POST['requirements']) ? $_POST['requirements'] : array() );
        $requirements_rating = ( isset($_POST['requirements_rating']) ? $_POST['requirements_rating'] : array() );
        $requirements_sequence = ( isset($_POST['requirements_sequence']) ? $_POST['requirements_sequence'] : array() );
        $requirements_type = ( isset($_POST['requirements_type']) ? $_POST['requirements_type']: array() );
        $requirements_gsc = ( isset($_POST['requirements_gsc']) ? $_POST['requirements_gsc'] : array() );
        $requirements_selections = ( isset($_POST['requirements_checkbox']) ? $_POST['requirements_checkbox'] : array() );
        
        //ALLOCATE NEW REQUIREMENTS VARIABLES
        $new_requirements = ( isset($_POST['new_requirements']) ? array_values($_POST['new_requirements']) : array() );
        $new_requirements_rating = ( isset($_POST['new_requirements_rating']) ? array_values($_POST['new_requirements_rating']) : array() );
        $new_requirements_sequence = ( isset($_POST['new_requirements_sequence']) ? array_values($_POST['new_requirements_sequence']) : array() );
        $new_requirements_type = ( isset($_POST['new_requirements_type']) ? array_values($_POST['new_requirements_type']) : array() );
        $new_requirements_gsc = ( isset($_POST['new_requirements_gsc']) ? array_values($_POST['new_requirements_gsc']) : array() );
        $new_requirements_selections = ( isset($_POST['new_requirements_checkbox']) ? array_values($_POST['new_requirements_checkbox']) : array() );
        
        //ALLOCATE RESPONSIBILITIES VARIABLES
        $responsibilities = ( isset($_POST['responsibilities']) ? $_POST['responsibilities'] : array() );
        $responsibilities_sequence = ( isset($_POST['responsibilities_sequence']) ? $_POST['responsibilities_sequence'] : array() );
        $responsibilities_selections = ( isset($_POST['responsibilities_checkbox']) ? $_POST['responsibilities_checkbox'] : array() );
        
        //ALLOCATE NEW RESPONSIBILITIES VARIABLES
        $new_responsibilities = ( isset($_POST['new_responsibilities']) ? array_values($_POST['new_responsibilities']) : array() );
        $new_responsibilities_sequence = ( isset($_POST['new_responsibilities_sequence']) ? array_values($_POST['new_responsibilities_sequence']) : array() );
        $new_responsibilities_gsc = ( isset($_POST['new_responsibilities_gsc']) ? array_values($_POST['new_responsibilities_gsc']) : array() );
        $new_responsibilities_selections = ( isset($_POST['new_responsibilities_checkbox']) ? array_values($_POST['new_responsibilities_checkbox']) : array() );

        //CALL ADS DETAIL
        $ads_detail = $curl->get($base_api_url."/ads/get-job-order-details/",array("gs_job_titles_details_id"=>$job_order_id));
        $ads_detail = json_decode($ads_detail,true);

        //CALL LEAD
        $lead = $curl->get($base_api_url."/leads/get-leads-profile-by-id/",array("id"=>$ads_detail["job_role"]["leads_id"]));
        $lead = json_decode($lead,true);

        //NEW POSTING DATA
        $new_posting_data = array();
        $new_posting_data['agent_id'] = $lead['profile']['agent_id'];
        $new_posting_data['lead_id'] = $ads_detail["job_role"]["leads_id"];
        $new_posting_data['ads_title'] = $_POST['ads_title'];
        $new_posting_data['sub_category_id'] = $_POST['sub_category_id'];
        $new_posting_data['job_order_source'] = 'rs';
        $new_posting_data['outsourcing_model'] = $_POST['outsourcing_model'];
        $new_posting_data['companyname'] = $_POST['company'];
        $new_posting_data['jobposition'] = $ads_detail['job_spec']['selected_job_title'];
        $new_posting_data['jobvacancy_no'] = $ads_detail['job_spec']['no_of_staff_needed'];
        $new_posting_data['status'] = $_POST['status'];
        $new_posting_data['heading'] = $_POST['heading'];
        $new_posting_data['show_status'] = $_POST['show_status'];
        $new_posting_data['classification'] = $_POST['classification'];
        //$new_posting_data['special_instruction'] = $_POST['special_instruction'];
        
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
        
		
		
		$job_order_collection = $database->selectCollection("job_orders");
		
		
		
		//UPDATE JOB ORDER DIRECTLY
		$current_job_order = $job_order_collection->findOne(
			array(
				"gs_job_titles_details_id" => intval($job_order_id)
			)
		);
		

		//UNSET POST VARIABLE AFTER ALLOCATIING POST DATA
		unset($_POST);

        //DETERMINE FRONT END ACTION IF UPDATE OR CONVERT
        if($action == 'update' || $action == 'convert'){
			
			//CHECK EXISTING POSTING DATA
			if(!empty($ads_detail['posting'])){
				
				//GET CONVERT TO ADS ACTION
				if($ads_detail['posting']['is_converted']){
					
					$convert_to_ads_action = 'update';
				
				} else {
					
					$convert_to_ads_action = 'new';
					
				}
				
				//GET POSTING ID FROM ADS DETAILS
				$posting_id = $ads_detail['posting']['id'];
				
				//POSTING HISTORY ID
				$posting_history_id = GenerateHistory::ConvertToAdsUpdateContent($new_posting_data,$posting_id,$change_by_id,$change_by_type);

				//UPDATE NEW POSTING VALUE
				$main_db->update('posting',$new_posting_data,$main_db->quoteInto('id=?',$posting_id));
				
				
				
			}else{
				
				//GET CONVERT TO ADS ACTION
				$convert_to_ads_action = 'new';
	
				//ADDED NEW POSTING DATA SPECIALLY FOR NEWLY CREATED POST
				$new_posting_data['created_by_type'] = $change_by_type;
				$new_posting_data['job_order_id'] = $job_order_id;
				$new_posting_data['date_created'] = date('Y-m-d H:i:s');

				//UPDATE GS JOB TITLE CREDENTIALS SPECIAL INSTRUCTION
				//$main_db->update('gs_job_titles_credentials',array('is_updated'=>1),$main_db->quoteInto('gs_job_titles_details_id=? and box="special_instruction"',$job_order_id));

				//POSTING HISTORY ID
				$posting_history_id = GenerateHistory::ConvertToAdsUpdateContent($new_posting_data,0,$change_by_id,$change_by_type);

				//INSERT POSTING
				$main_db->insert('posting',$new_posting_data);
				
				//REQUEST POSTING ID FOR UPDATING POSTING HISTORY ID
				$posting_id = $main_db->lastInsertId();

				//UPDATE POSTING HISTORY POSTING ID
				$main_db->update('posting_history',array('posting_id'=>$posting_id),$main_db->quoteInto('id=?',$posting_history_id));
				
				
				
				unset($current_job_order["_id"]);
				
				$current_job_order["posting_id"] = intval($posting_id);
				
				$job_order_collection->update(
					array(
						"gs_job_titles_details_id" => intval($job_order_id)
					),
					array(
						'$set' => $current_job_order
					)
				);
			}
			
        }
        

        //SET HISTORY CHANGES
        $history_changes = '';

		//CHECK IF REQUIREMENTS VARIABLE EXISTS AND NOT EMPTY
		if(isset($requirements)&&count($requirements)){
			
			//STORAGE FOR REQUIREMENTS REMAINING IDS
			$new_requirements_remaining_ids = array();
			foreach($requirements as $id=>$requirement){
				
				//CONTSTRUCT POSTING REQUIREMENTS VARIABLE
				$new_posting_requirement = array();
				$new_posting_requirement['posting_id'] = $posting_id;
				$new_posting_requirement['requirement'] = $requirement;
				$new_posting_requirement['rating'] = $requirements_rating[$id];
				$new_posting_requirement['sequence'] = $requirements_sequence[$id];
				$new_posting_requirement['type'] = $requirements_type[$id];
				$new_posting_requirement['is_selected'] = $requirements_selections[$id];
				
				//CONSTRUCT REQUIREMENT HISTORY STRING
				$history_changes .= GenerateHistory::ConvertToAdsUpdateRequirement($new_posting_requirement,$id);

				//UPDATE POSTING REQUIREMENT
				$main_db->update('posting_requirement',$new_posting_requirement,$main_db->quoteInto('id=?',$id));
				
				//GET REQUIREMENTS EXISTING IDS
				$new_requirements_remaining_ids[] = $id;
		
			}

		}
		
		//GET PREVIOUS IDS OF REQUIREMENTS
		$requirements_previous_ids_sql = $main_db->select()
											->from('posting_requirement','id')
											->where('posting_id=?',$posting_id);
		$requirements_previous_ids = $main_db->fetchAll($requirements_previous_ids_sql);
		
		//STORAGE FOR REQUIREMENTS PREVIOUS IDS
		$new_requirements_previous_ids = array();
		foreach($requirements_previous_ids as $requirements_previous){
			$new_requirements_previous_ids[] = $requirements_previous['id'];
		}
		
		if(!isset($new_requirements_remaining_ids)){
			$new_requirements_remaining_ids = array();
		}
		
		//GET REQUIREMENT IDS TO BE REMOVED
		$delete_requirements_ids = array_diff($new_requirements_previous_ids, $new_requirements_remaining_ids);
		
		//CHECK IF THERE ARE REQUIREMENTS THAT NEEDS TO REMOVE
		if(count($delete_requirements_ids)) {
			
			foreach($delete_requirements_ids as $requirement_id) {
				
				//GET THE POSTING REQUIREMENT INFO BEFORE DELETING
				$delete_posting_requirement_sql = $main_db->select()
														->from('posting_requirement')
														->where('id=?',$requirement_id);
														
				$delete_posting_requirement = $main_db->fetchRow($delete_posting_requirement_sql);
				
				//CONSTRUCT REQUIREMENT HISTORY STRING MANUALLY
				$history_changes .= 'Requirement => ' . $delete_posting_requirement['requirement'] . ' has been deleted <br>';
				
				//DELETE POSTING REQUIREMENT
				$main_db->delete('posting_requirement', $main_db->quoteInto('id=?',$requirement_id));
				
			}
			
		}
		
		//CHECK IF NEW REQUIREMENTS VARIABLE EXISTS AND NOT EMPTY
		if(isset($new_requirements)&&count($new_requirements)){
			
			foreach($new_requirements as $key=>$new_requirement){
				
				//CONTSTRUCT POSTING REQUIREMENTS VARIABLE
				$new_posting_requirement = array();
				$new_posting_requirement['posting_id'] = $posting_id;
				$new_posting_requirement['requirement'] = $new_requirement;
				$new_posting_requirement['rating'] = $new_requirements_rating[$key];
				$new_posting_requirement['sequence'] = $new_requirements_sequence[$key];
				$new_posting_requirement['type'] = $new_requirements_type[$key];
				$new_posting_requirement['is_selected'] = $new_requirements_selections[$key];
				
				//CONSTRUCT REQUIREMENT HISTORY STRING
				$history_changes .= GenerateHistory::ConvertToAdsUpdateRequirement($new_posting_requirement,0);

				//INSERT POSTING REQUIREMENT
				$main_db->insert('posting_requirement',$new_posting_requirement);
				
				//CHECK IF GSC IS EXISTING AND HAVE VALUE
				if(isset($new_requirements_gsc[$key])&&!empty($new_requirements_gsc[$key])){
					$main_db->update('gs_job_titles_credentials',array('is_updated'=>1),$main_db->quoteInto('gs_job_titles_credentials_id=?',$new_requirements_gsc[$key]));
				}
				
			}
			
		}

		//CHECK IF RESPONSIBILITIES VARIABLE EXISTS AND NOT EMPTY
		if(isset($responsibilities)&&count($responsibilities)){
			
			//STORAGE FOR RESPONSIBILITIES REMAINING IDS
			$new_responsibilities_remaining_ids = array();
			foreach($responsibilities as $id=>$responsibility){
				
				//CONTSTRUCT POSTING RESPONSIBILITIES VARIABLE
				$new_posting_responsibility = array();
				$new_posting_responsibility['posting_id'] = $posting_id;
				$new_posting_responsibility['responsibility'] = $responsibility;
				$new_posting_responsibility['sequence'] = $responsibilities_sequence[$id];
				$new_posting_responsibility['is_selected'] = $responsibilities_selections[$id];
				
				//CONSTRUCT RESPONSIBILITY HISTORY STRING
				$history_changes .= GenerateHistory::ConvertToAdsUpdateResponsibility($new_posting_responsibility,$id);

				//UPDATE POSTING RESPONSIBILITIES
				$main_db->update('posting_responsibility',$new_posting_responsibility,$main_db->quoteInto('id=?',$id));
				
				//GET RESPONSIBILITIES EXISTING IDS
				$new_responsibilities_remaining_ids[] = $id;
		
			}
	
		}
		
		//GET PREVIOUS IDS OF RESPONSIBILITIES
		$responsibilities_previous_ids_sql = $main_db->select()
											->from('posting_responsibility','id')
											->where('posting_id=?',$posting_id);
		$responsibilities_previous_ids = $main_db->fetchAll($responsibilities_previous_ids_sql);
		
		//STORAGE FOR RESPONSIBILITIES PREVIOUS IDS
		$new_responsibilities_previous_ids = array();
		foreach($responsibilities_previous_ids as $responsibilities_previous){
			$new_responsibilities_previous_ids[] = $responsibilities_previous['id'];
		}
		
		if(!isset($new_responsibilities_remaining_ids)){
			$new_responsibilities_remaining_ids = array();
		}
		
		//GET RESPONSIBILITIES IDS TO BE REMOVED
		$delete_responsibilities_ids = array_diff( $new_responsibilities_previous_ids, $new_responsibilities_remaining_ids );
		
		//CHECK IF THERE ARE RESPONSIBILITIES THAT NEEDS TO REMOVE
		if(count($delete_responsibilities_ids)) {
			
			foreach($delete_responsibilities_ids as $responsibility_id) {
				
				//GET THE POSTING RESPONSIBILITY INFO BEFORE DELETING
				$delete_posting_responsibility_sql = $main_db->select()
														->from('posting_responsibility')
														->where('id=?',$responsibility_id);
														
				$delete_posting_responsibility = $main_db->fetchRow($delete_posting_responsibility_sql);
				
				//CONSTRUCT RESPONSIBILITY HISTORY STRING MANUALLY
				$history_changes .= 'Responsbility => ' . $delete_posting_responsibility['responsibility'] . ' has been deleted <br>';
				
				//DELETE POSTING RESPONSIBILITY
				$main_db->delete('posting_responsibility', $main_db->quoteInto('id=?',$responsibility_id));
				
			}
			
		}

		//CHECK IF NEW RESPONSIBILITIES VARIABLE EXISTS AND NOT EMPTY
		if(isset($new_responsibilities)&&count($new_responsibilities)){
			
			foreach($new_responsibilities as $key=>$new_responsibility){
				
				//CONTSTRUCT POSTING RESPONSIBILITIES VARIABLE
				$new_posting_responsibility = array();
				$new_posting_responsibility['posting_id'] = $posting_id;
				$new_posting_responsibility['responsibility'] = $new_responsibility;
				$new_posting_responsibility['sequence'] = $new_responsibilities_sequence[$key];
				$new_posting_responsibility['is_selected'] = $new_responsibilities_selections[$key];
				
				//CONSTRUCT RESPONSIBILITY HISTORY STRING
				$history_changes .= GenerateHistory::ConvertToAdsUpdateResponsibility($new_posting_responsibility,0);

				//INSERT POSTING RESPONSIBILITY
				$main_db->insert('posting_responsibility',$new_posting_responsibility);
				
				//CHECK IF GSC IS EXISTING AND HAVE VALUE
				if(isset($new_responsibilities_gsc[$key])&&!empty($new_responsibilities_gsc[$key])){
					$main_db->update('gs_job_titles_credentials',array('is_updated'=>1),$main_db->quoteInto('gs_job_titles_credentials_id=?',$new_responsibilities_gsc[$key]));
				}
				
			}
			
		}
		
		//CHECK IF THERE IS HISTORY CHANGES
		if($history_changes != ''){
			
			//GET CURRENT HISTORY CHANGES
			$current_history_changes = GenerateHistory::getCurrentHistory($posting_history_id);
			
			//COMBINE CURRENT HISTORY AND NEW HISTORY CHANGES CONTENT
			$current_history_changes = $current_history_changes . $history_changes;
			
			//UPDATE HISTORY CHANGES
			$posting_history_id = GenerateHistory::updateCurrentHistoryChanges($posting_history_id,$current_history_changes,$posting_id,$change_by_id,$change_by_type);
			
		}
			
        //CHANGE ALL FLAG OF POSTING REQUIREMENTS AND RESPONSIBILITIES DATA TO CONVERTED
        $main_db->update('posting',array('is_converted'=>1),$main_db->quoteInto('id=?',$posting_id));
        $main_db->update('posting_requirement',array('is_converted'=>1),$main_db->quoteInto('posting_id=?',$posting_id));
        $main_db->update('posting_responsibility',array('is_converted'=>1),$main_db->quoteInto('posting_id=?',$posting_id));

        //GENERATE HISTORY WHEN ADS IS CONVERTED
        GenerateHistory::ConvertToAds($posting_id,$convert_to_ads_action,$change_by_id,$change_by_type);

		
        //CALL ADS DETAIL WITH UPDATED POSTING DATA VALUES
        $new_ads_detail = $curl->get($base_api_url."/ads/get-job-order-details/",array("gs_job_titles_details_id"=>$job_order_id));
        $new_ads_detail = json_decode($new_ads_detail,true);
        
		
		
		

        //SAVE NEW ADS DETAIL TO MONGO DB
        /*
        $ads_collection = $database->selectCollection("ads");
        $cursor = $ads_collection->find(array("job_order_id"=>$job_order_id));
        if($cursor -> hasNext()){
            $result = $cursor->getNext();
            $ads_collection->update(array("_id"=>$result["_id"]),array('$set'=>$new_ads_detail));
        }else{
            $ads_collection->insert($new_ads_detail);
        }
        */


		//CONSTRUCT RESULT ARRAY
        $result['success'] = true;
        $result['job_order_id'] = $job_order_id;
        $result['action'] = $action;
        //$result['new_ads_detail'] = $new_ads_detail;

        //FORMAT RESULT INTO JSON
        echo json_encode($result);
        exit;

    }
}
