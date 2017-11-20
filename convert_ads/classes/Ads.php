<?php


include '../conf/zend_smarty_conf.php';
class Ads {
    private $db, $smarty, $base_api_url, $curl;
    public function __construct($db, $base_api_url, $curl) {
        $this -> db = $db;
        $this -> smarty = new Smarty();
        $this -> base_api_url = $base_api_url;
        $this -> curl = $curl;
    }

    public function render() {
		
		//MAIN DB
        $db = $this -> db;
        
        
        //GET JOB ORDER ID
        $job_order_id = $_REQUEST['job_order_id'];
        
        //CHECK IF JOB ORDER ID IS 
        if(!isset($job_order_id)&&empty($job_order_id)){
			die("Job_Order ID is missing!");
		}
        $base_api_url = $this -> base_api_url;
        $curl = $this -> curl;
        //SET PARAMETER FROM API
        $result = $curl -> get($base_api_url . "/ads/get-job-order-details/", array("gs_job_titles_details_id" =>$job_order_id));
        
        
        $ads_detail = json_decode($result, true);
        
        //CHECK CONVERTED ADS IF FLAG TO CONVERTED
        if(!$ads_detail['posting']['is_converted']){
			header('Location: /portal/convert_ads/convert_to_ads.php?gs_job_titles_details_id='.$job_order_id);
		}
        
        //echo "<pre>";
        //print_r($ads_detail);
        //die;

        //CHECK LOGGED SESSION & TOGGLING OF ADS BUTTON
        if ($_SESSION["userid"] != "") {
            $this -> smarty -> assign('applicant_used', True);
        } else if ($_SESSION["admin_id"] != "") {
            $this -> smarty -> assign('applicant_used', False);
        } else if ($_SESSION["agent_no"] != "") {
            $this -> smarty -> assign('applicant_used', False);
        } else {
            $this -> smarty -> assign('applicant_used', True);
        }

        //DISPLAY JOB CATEGORY IF ADS TITLE IS NULL
        $ads_header = "";
        if(empty($ads_detail["posting"]["ads_title"])){
            $ads_header = $ads_detail["posting"]["jobposition"];
        }else{
            $ads_header = $ads_detail["posting"]["ads_title"];
        }
        
        //CUSTOMIZE RENDERING ON ADS PAGE
        $ads_level = ucfirst($ads_detail["job_spec"]["level"]);
        $ads_created_date = date('F j, Y, g:i A', strtotime($ads_detail["job_role"]["date_created"]));
        
        //CONVERTED REQUIREMENTS
        $posting_requirements = $ads_detail["converted_posting_requirements"];
        $posting_requirements_must = array();
        $posting_requirements_good = array();
        
        if(count($posting_requirements)){
          foreach($posting_requirements as $posting_requirements_items){
				if($posting_requirements_items["type"]=="good to have"){
					$posting_requirements_good[] = array("requirement"=>$posting_requirements_items["requirement"]);
				}
				if($posting_requirements_items["type"]=="must to have"){
					$posting_requirements_must[] = array("requirement"=>$posting_requirements_items["requirement"]);
				}
			}  
        }
        
        
        //ADJUST TIMEZONE TO PHILIPPINES
        $ads_start_work = $ads_detail["job_spec"]["start_work"];
        $ads_finish_work = $ads_detail["job_spec"]["finish_work"];
        
        if(strlen($ads_start_work) == 2 ){
            $ads_start_work = date('h:i A', strtotime($ads_start_work.":00"));
        }else{
            $ads_start_work= date('h:i A', strtotime($ads_start_work));
        }
        
        if(strlen($ads_finish_work) == 2){
            $ads_finish_work = date('h:i A', strtotime($ads_finish_work.":00"));
        }else{
            $ads_finish_work = date('h:i A', strtotime($ads_finish_work));
        }
        
        
        date_default_timezone_set($ads_detail["job_spec"]["working_timezone"]);
        $converted_timezone = new DateTimeZone('Asia/Manila');
        $selected_start_work = new DateTime($ads_start_work);
        $selected_finish_work = new DateTime($ads_finish_work);
        $selected_start_work -> setTimezone($converted_timezone);
        $selected_finish_work -> setTimezone($converted_timezone);
        
        $ads_start_work= $selected_start_work->format('h:i A');
        $ads_finish_work = $selected_finish_work->format('h:i A');
        
        
       
        //DISPLAYING TO TEMPLATE
        $this -> smarty -> assign("ads_header", $ads_header);
        $this -> smarty -> assign("job_spec_level", $ads_level);
        $this -> smarty -> assign("ads_created_date", $ads_created_date);
        $this -> smarty -> assign("ads_start_work", $ads_start_work);
        $this -> smarty -> assign("ads_finish_work", $ads_finish_work);
        $this -> smarty -> assign("posting", $ads_detail["posting"]);
        $this -> smarty -> assign("job_spec", $ads_detail["job_spec"]);
        $this -> smarty -> assign("must_to_have_requirements", $posting_requirements_must);
        $this -> smarty -> assign("good_to_have_requirements", $posting_requirements_good);
        
        //$this -> smarty -> assign("requirements", $ads_detail["converted_posting_requirements"]);
        //$this -> smarty -> assign("responsibilities", $ads_detail["converted_posting_responsibilities"]);


        //NOT CONVERTED REQUIREMENTS
        $this -> smarty -> assign('requirements',$ads_detail['requirements']);
        $this -> smarty -> assign('requirements_must_to_have',$ads_detail['requirements_must_to_have']);
        $this -> smarty -> assign('requirements_good_to_have',$ads_detail['requirements_good_to_have']);
        
        //CONVERTED REQUIREMENTS
        $this -> smarty -> assign('converted_posting_requirements_neutral',$ads_detail['converted_posting_requirements_neutral']);
        $this -> smarty -> assign('converted_posting_requirements_must_have',$ads_detail['converted_posting_requirements_must_have']);
        $this -> smarty -> assign('converted_posting_requirements_good_to_have',$ads_detail['converted_posting_requirements_good_to_have']);
        
        //NOT CONVERTED RESPONSIBILITIES
        $this -> smarty -> assign('responsibilities',$ads_detail['responsibilities']);
        
        //CONVERTED RESPONSIBILITIES
        $this -> smarty -> assign('converted_posting_responsibilities', $ads_detail['converted_posting_responsibilities']);
        
        
        //GS CREDENTIALS REQUIREMENTS UPDATED
        $this -> smarty -> assign('gs_credential_requirements_updated',$ads_detail['gs_credential_requirements_updated']);
        
        //GS CREDENTIALS REQUIREMENT NOT UPDATED
        $this -> smarty -> assign('gs_credential_requirements_not_updated',$ads_detail['gs_credential_requirements_not_updated']);
        
        //GS CREDENTIALS RESPONSIBILITY UPDATED
        $this -> smarty -> assign('gs_credential_responsibilities_updated', $ads_detail['gs_credential_responsibilities_updated']);
        
        //GS CREDENTIALS RESPONSIBILITY NOT UPDATED
        $this -> smarty -> assign('gs_credential_responsibilities_not_updated', $ads_detail['gs_credential_responsibilities_not_updated']);
        
        
        //USE ADS TEMPLATE
        $this -> smarty -> display("ads.tpl");

    }

    public function validate() {
            
        // VARIABLE DECLARATION
        $db = $this -> db;
        $AusTime = date("H:i:s"); 
        $AusDate = date("Y")."-".date("m")."-".date("d");
        $ATZ = $AusDate." ".$AusTime;
        $response = array();
        $response['success'] = true;
        $response['error_message'] = '';
        $response['success_message'] = '';
        $response['logged'] = false;
        
        $submit_form = $_POST['submit_form'];
        $posting_id = $_POST['posting_id'];
        
        //SESSION VALIDATION
        if (isset($_SESSION['userid']) && !empty($_SESSION['userid'] )) {

            $response['logged'] = true;
            
        } else if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'] )) {
            
            $response['logged'] = true;
            
        }else{
            
             $response['logged'] = false;
        
        }

        if ( $response['logged'] ) {

            $userid = $_SESSION['userid'];

            if (isset($submit_form)) {

                $application_status = 0;
                $application_role_limit_sql = $db -> select() 
                                                  -> from(array("app" => "applicants"), array("app.id")) 
                                                  -> joinInner(array("post" => "posting"), "post.id = app.posting_id", array()) 
                                                  -> where("app.userid = ?", $userid) 
                                                  -> where("app.status <> 'Sub-Contracted'") 
                                                  -> where("app.expired = 0") 
                                                  -> where("post.status = 'ACTIVE'");
                $application_role_limit = $db -> fetchAll($application_role_limit_sql);
            
                // VERIFY IF APPLICANTS APPLY ON THE SAME POSITION
                $application_submit_sql = $db -> select() 
                                              -> from('applicants') 
                                              -> where('posting_id =?', $posting_id) 
                                              -> where("expired = 0") 
                                              -> where('userid =?', $userid);
                $application_submit = $db -> fetchAll($application_submit_sql);
               

                if (count($application_limit) > 9) {

                    //MESSAGE ALERT HERE
                    $application_status = 1;

                    $response['success'] = false;
                    $response['error_message'] = 'Sorry, you cannot apply for this job ad. You currently have reached the limit of 10 job applications. If you want to be considered for this job , please contact recruitment@remotestaff.com.au';

                } else if (count($application_submit) > 0) {

                    //MESSAGE ALERT HERE
                    $application_status = 1;

                    $response['success'] = false;
                    $response['error_message'] = 'YOUVE ALREADY APPLIED FOR THIS JOB';

                }

                //INSERT DATA IF CONDITION MET
                if ($application_status == 0) {
                    $posting_data = array('posting_id' => $posting_id, 'userid' => $userid, 'status' => 'Unprocessed', 'date_apply' => $ATZ);
                    $db -> insert('applicants', $posting_data);
                    
               //SEND MAIL TO APPLCIANT
                $leads_info_sql = $db->select()
                                     ->from(array("p"=>'posting'), array("p.jobposition"))
                                     ->joinInner(array("l"=>"leads"), "l.id = p.lead_id", array("l.fname AS lead_firstname", "l.lname AS lead_lastname"))
                                     ->where('p.id =?' ,$posting_id);
                $leads_info = $db->fetchRow($leads_info_sql);  
                
                $emailSmarty = new Smarty();
                
                $recruiter_info_sql = $db->select()
                                         ->from(array("rs"=>"recruiter_staff"), array())
                                         ->joinInner(array("p"=>"personal"), "p.userid = rs.userid", array("p.fname", "p.lname"))
                                         ->joinLeft(array("a"=>"admin"), "a.admin_id = rs.admin_id", array("a.admin_fname", "a.admin_lname", "a.admin_email"))
                                         ->where("rs.userid = ?", $userid);
                $recruiter_info = $db->fetchRow($recruiter_info_sql);
                
                if ($recruiter_info){
                    $emailSmarty->assign("recruiter_full_name", $recruiter_info["admin_fname"]." ".$recruiter_info["admin_lname"]);
                    $emailSmarty->assign("candidate_full_name", $recruiter_info["fname"]." ".$recruiter_info["lname"]);
                    $emailSmarty->assign("candidate_id", $userid);
                    $emailSmarty->assign("today", date("F j, Y"));
                    $emailSmarty->assign("lead_fullname", $leads_info["lead_firstname"]." ".$leads_info["lead_lastname"]);
                    $emailSmarty->assign("ad_name", $leads_info["jobposition"]);
                    
                    $output = $emailSmarty->fetch("email_recruiter_notifier.tpl");                                                    
                    $mail = new Zend_Mail();
                    $mail->setBodyHtml($output);
                    if (!TEST){
                        $mail->setSubject("The applicant assigned to you applied for the position {$leads_info["jobposition"]}.");
                    }else{
                        $mail->setSubject("TEST - The applicant assigned to you applied for the position {$leads_info["jobposition"]}");
                    }
                    $mail->setFrom("noreply@remotestaff.com.au", "noreply@remotestaff.com.au");
                    if (!TEST){
                        $mail->addTo($recruiter_info["admin_email"]);                  
                    }else{
                        $mail->addTo("devs@remotestaff.com.au");
                    }
        
                    $mail->send($transport);
                } 
					global $curl;
					
					global $base_api_url;
					
					$curl->get($base_api_url. "/mongo-index/sync-all-candidates/", array("userid" => $userid));
					
					
                    $response['success_message'] = 'THANK YOU FOR APPLYING PLEASE WAIT FOR FURTHER NOTICE FROM US!';

                }

            }

        }

        echo json_encode($response);

    }



}
