<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
    /* $ TestController.php 2012-09-03 mike $ */
    
    class TestController {
        private $db = NULL;

        public static $admin = array();
        private $report_model;
        private $upload_path = "";
        private $test_id;
        private $user_obj;
        private $assessment_model;
        private $result_model;
        protected $ws_account_info = "Remote";
		//protected $ws_account_info = "9c7qs25t";
        
        private $wsclient = NULL;
        public static $dbase = NULL;
        public static $login_type = NULL;
        public $tests = Array();
        private $emailaddr;
        private $user_id;
        private $rs_site;

        // constructor
        public function __construct($id = 1) {
            $this->db = $this::$dbase;
            //$this->get_ws_client();
            $this->assessment_model = AssessmentList::getInstance($this->db);
            $this->result_model = AssessmentResults::getInstance($this->db);
            $this->user_id = 0;
            $this->emailaddr = '';
            
            if( !$this::$login_type === NULL ) $this::$login_type = 'jobseeker';
            
            $this->user_id = $this::$login_type == "admin" ? $_sSESSION['admin_id'] :
                ( $this::$login_type == "client" ? $_SESSION['client_id'] : $_SESSION['userid']);
            
            $this->user_obj = new Users( array($this->emailaddr, $this::$login_type, $this->user_id) );
			
			$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
						? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
			
			//$this->rs_site = $protocol. $_SERVER['HTTP_HOST'];
			//$http_host = $_SERVER['HTTP_HOST'];
            //$this->rs_site = (strstr($http_host, '.', true) != "test" ) ? 'https://remotestaff.com.au' : 'http://'.$http_host;
			//$this->rs_site = 'https://'.$_SERVER['HTTP_HOST'];
            if( !empty($this->user_obj->user_info['email']) )
                $this->emailaddr = $this->user_obj->user_info['email'];
                
        }
        
        private function get_ws_client() {
            $this->wsclient = new SoapClient(
				"http://www.proveit.com/KPIATS/WebServices/WebServiceKAS.asmx?WSDL",
				//"https://staging.proveit.com/KPIATS/WebServices/WebServiceKAS.asmx?WSDL",
				array(
					'trace' => 1,
					'exceptions' => true,
					//'login' => "RemoteRecruiters", 'password' => "remotestaff",
					'location' => 'http://www.proveit.com/KPIATS/WebServices/WebServiceKAS.asmx',
					//'location' => 'https://staging.proveit.com/KPIATS/WebServices/WebServiceKAS.asmx',
					//'uri'=>'http://www.proveit2.com/KPIATS/WebServiceKAS', 
                    'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
                    'soap_version' => SOAP_1_2,
					'encoding' => 'ISO-8859-1',
					'style' => SOAP_RPC,
					'use' => SOAP_ENCODED,
					'keep_alive' => false
				));
        }
        
        public function index() {
			$userid = Input::get('userid');
			$redirect_url = $_SERVER['HTTP_REFERER'];
			if( $redirect_url )
				$redirect_url .= strpos($redirect_url, '?') !== false ? "&userid=$userid" : "?userid=$userid";
				
            $categories = $this->assessment_model->fetch_categories();
			
			$positions_array = array();
			if( file_exists("./positions.txt") ) {
				$positions_array = file("./positions.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			}
            
            View::$templ_dir = 'views';
            $view = new View('home');
            
            $view->class1 = " class='youarehere'";
            $view->color1 = "style='color:#fff' ";
            $view->categories = $categories;
			$view->positions = $positions_array;
            $view->emailaddr = $this->user_obj->user_info['email'];
            if( $this::$login_type == "jobseeker" )
                $view->popup_text = "Do you really want to take this test?";
            else {
				$view->popup_text = "Do you want to add this test?";
				$view->redirect_url = "<div id='referer_url' title='$redirect_url'></div>";
			}
            $view->display();
        }
        
        public function get_test() {
            $cat = Input::get('cat');
			$posArray = explode('__pos__', $cat);
			if( count($posArray) > 1 ) $where = "assessment_title REGEXP '".$posArray[1]."' AND status='active'";
			else $where = "assessment_category = '$cat' AND status='active'";
            $tests = $this->assessment_model->fetchAll($where);
            echo json_encode($tests);
        }
        
        public function request_assessment_list() {
			$this->assessment_model->deactivate_assesslist();
			
			$this->get_ws_client();
			
            $asssementResult = array();
            $request = "<RequestAssessmentList><AccountInfo><AccountID>".$this->ws_account_info."</AccountID><KASATS_ID>KASWS</KASATS_ID></AccountInfo></RequestAssessmentList>";
            
            try {
                $result = $this->wsclient->RequestAssessmentList(array('InXML' => $request));
                $response = $this->wsclient->__getLastResponse();
				
	
                $xml = new SimpleXMLElement($response);
                $assessments_node = $xml->children('http://www.w3.org/2003/05/soap-envelope')->Body->children('http://www.proveit2.com/KPIATS/WebServiceKAS')
                         ->RequestAssessmentListResponse->RequestAssessmentListResult;
				
				// replaced & with &amp; to avoid error in simplexml_load_string()
				$assessments_node = str_replace('&', '&amp;', $assessments_node);

                $axml = simplexml_load_string($assessments_node);
				
                $assess_results = $axml->Assessments->Assessment;
                foreach( $assess_results as $assessment ) {
                    $data = array('assessment_id' => $assessment->AssessmentID, 'assessment_title' => $assessment->TestName,
                                  'assessment_type' => $assessment->Type, 'assessment_category' => $assessment->Category);
                    
					if( $this->assessment_model->assessment_check($data) )
						echo '<br/>'.$data['assessment_id'].' Update: '.$this->assessment_model->set_assessment_active($data);
					else echo '<br/>'.$data['assessment_id'].' Insert: '.$this->assessment_model->assessment_save($data);
					flush();
                }
                
                

            } catch (SoapFault $e) {
                $asssementResult = array('result' => 'SOAP Fault: '.$e->getMessage());
				 print_r($asssementResult);
            }
            
           
            echo 'total:'.count($asssementResult);
            
            View::$templ_dir = 'views';
            $view = new View('assesslist_request');
            
            $view->class1 = " class='youarehere'";
            $view->color1 = "style='color:#fff' ";
            $view->result = 'Assessment list request success';
            
            $view->display();
        }
        
        
        /* session request */
        public function request_session($aid) {
			$this->get_ws_client();
			
			
			$noredirect = (int)Input::get('noredirect');
			if( $noredirect == 1) $redirect_url = $this->rs_site."/portal/skills_test/index.php?/closewin/&amp;amp;candidate_id=" . $this->user_obj->user_info['id'];
			else $redirect_url = $this->rs_site."/portal/skills_test/index.php?/redirect/";
			
            if( $this->user_obj->user_info['id'] == 0 && $this->user_obj->user_info['fname'] == "" &&
               $this->user_obj->user_info['lname'] == "" ) {
                $data = array('error' => 'User account not found!');
            } else {
            
            $request =
"<SessionRequest>
	<AccountInfo>
		<AccountID>".$this->ws_account_info."</AccountID>
		<KASATS_ID>KASWS</KASATS_ID>
	</AccountInfo>
	<PostResultsURL>".$this->rs_site."/portal/skills_test/index.php?/get_result/</PostResultsURL>
	<Candidates>
		<Candidate>
			<FirstName>".$this->user_obj->user_info['fname']."</FirstName>
			<LastName></LastName>
			<UID>".$this->user_obj->user_info['id']."</UID>
			<RETURN_URL>
			<Assessments>
				<AssessmentID>".$aid."</AssessmentID>
			</Assessments>
		</Candidate>
	</Candidates>
</SessionRequest>";

			//if( $redirect_url )
				$request = str_replace("<RETURN_URL>", "<ReturnCandidateURL>".$redirect_url."</ReturnCandidateURL>", $request);
			//else $request = str_replace("<RETURN_URL>", "", $request);
			
			
                try {
                    $result = $this->wsclient->SessionRequest (array('InXML' => $request));
                    $response = $this->wsclient->__getLastResponse();
                    
                    $xml = new SimpleXMLElement($response);
                    $session_node = $xml->children('http://www.w3.org/2003/05/soap-envelope')->Body->children('http://www.proveit2.com/KPIATS/WebServiceKAS')
                             ->SessionRequestResponse->SessionRequestResult;
                
                    $axml = simplexml_load_string($session_node);
                    
                    // create log
                    //$file_name = 'sessreq_'.$this->user_obj->user_info['id'].'_'.$aid.'.xml';
                    
                    //$this->file_write_log($file_name, $session_node);
    
                    $status_result = $axml->Status->Result;
                    
                    if( $status_result == "Success" ) {
                        $data = (string)$axml->Candidates->KASAssessmentURL;
                        //$data = trim( preg_replace('/\s+/', ' ', $data) );
                        $data = array('result' => trim( preg_replace('/\s+/', ' ', $data) ));    
                    } else {
                        //$data = $status_result;
                        $data = array('error' => $status_result);
                    }
                    
                    
                } catch (SoapFault $e) {
                    $data = array('error' => 'SOAP Fault: '.$e->getMessage());
                }
            }
            
            echo json_encode( $data );

        }
        
        public function start_assessment() {
            $url = Input::post('assessment_url');
			
			if( !$url ) {
				$kasURL = explode('assessment_url=', $_SERVER['QUERY_STRING'], 2);
				if( empty($kasURL[1]) ) die('The link for the test result was not found.');
				$url = urldecode($kasURL[1]);
			}
			
            View::$templ_dir = 'views';
			
            //if( !$url ) {
            //    header('Location: ?/index/');
            //} else {
            $view = new View('start_assessment');
            $view->kasAssessURL = $url;
            $view->class1 = " class='youarehere'";
            $view->color1 = "style='color:#fff' ";
            $view->emailaddr = $this->user_obj->user_info['email'];
            $view->start_test = true;
            $view->display();
            //}
        }
        
        /* this should be the reciever of posted result after the completion of proveit assessment*/
        public function get_result() {
            //$test_results = Input::post('Results');
            //$file_name = 'res_'.md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $this->user_obj->user_info['id']);
            //file_put_contents($file_name, $test_results);
            
            $raw_data = file_get_contents('php://input');
            
            if( $raw_data ) {
                $posted_results = explode("Results=", $raw_data, 2);
                
                $axml = simplexml_load_string($posted_results[1]);
                
				$result_id = (int)$axml->Result->ResultID;
                $res_url = (string)$axml->Result->ResultURL;
                $result_uid = (string)$axml->Candidate->UID;
				$result_aid = (int)$axml->Assessments->AssessmentID;
				$result_type = (string)$axml->Result->ResultType;
				$result_score = (string)$axml->Result->ResultScore;
				$result_pct = (int)$axml->Result->ResultPercentage;
				$result_url = $this->rs_site . '/portal/skills_test/?/test_details/&kasURL='.$res_url;
                $sql_data = array(
                    'result_id' => $result_id,
                    'result_type' => $result_type,
                    'result_score' => $result_score,
                    'result_pct' => $result_pct,
                    'result_url' => $result_url,
                    'result_aid' => $result_aid,
                    'result_uid' => $result_uid
                );
				
				if( !is_numeric($result_uid) ) $sql_data['result_session'] = 'yes';
				
				// save first the test result
                $this->result_model->result_save($sql_data);
				
				
				if( $sql_data['result_session'] == 'yes' ) {
					// notify admin
					$qry = $this->db->select()
					->from(array('s'=>'assessment_sessions'), array())
					->joinLeft( array('ai'=>'assessment_sessions_aid'), 's.id=ai.session_id', array() )
					->joinLeft( array('a'=>'admin'), 's.created_by=a.admin_id', array('admin_email', 'admin_fname', 'admin_lname') )
					->joinLeft( array('l'=>'assessment_lists'), 'l.assessment_id=ai.assessment_id', array('assessment_title') )
					->joinLeft( array('p'=>'personal'), 'p.email=s.uid', array('userid', 'fname', 'lname') )
					->where('ai.assessment_id = ?', $result_aid)
					->where('s.uid = ?', $result_uid)
					->where('l.status = ?', 'active');
					
					$aResult = $this->db->fetchRow($qry);
					
					$resultUnit = (strpos(strtolower( $aResult['assessment_title'] ), 'typing' ) !== false ? " WPM" : "%");
					
					$utils = Utils::getInstance();
					
					$candi_name = $aResult['userid'] ? "{$aResult['fname']} {$aResult['lname']} #{$aResult['userid']}" : $result_uid;
					
					$email_subject = "Test Session Completed ({$candi_name})";
					
					// EMAIL BODY TO ADMIN
					$msgbody_admin = "<p>
					
					Hi {$aResult['admin_fname']} {$aResult['admin_lname']},</p>
					Candidate {$candi_name} has completed the Test session that you created. <br/>
					Below is the test result.<br/>\n
					<p>
					<strong>Test Name:</strong> {$aResult['assessment_title']} <br/>
					<strong>Type:</strong> $result_type <br/>
					<strong>Score:</strong> $result_score <br/>
					<strong>Result:</strong> {$result_pct}{$resultUnit} <br/>
					<strong>Result Details:</strong> <a href='{$result_url}'>click here</a> <br/>
					</p><br/>
					Regards,
					<p>RemoteStaff Devs</p>";
					
					$utils->send_email($email_subject, $msgbody_admin, $aResult['admin_email'], 'Remotestaff Notification', false);
				}
            }
            //echo "POSTED RESULT";
            //echo $posted_results;
            //if( $posted_results ) {
			// remove logging of text result
            //$xml_file = 'posted_result_'. date('Y_m_d-H-i-s') . '.xml';
            //$this->file_write_log($xml_file, $posted_results[1]);
            //}
        }
        
        public function request_result($aid) {
			$this->get_ws_client();
			
            $aid = Input::get('aid');
            $userid = Input::get('userid') ? Input::get('userid') : $this->user_obj->user_info['id'];
            
            $request =
"<ResultRequest>
	<AccountInfo>
		<AccountID>".$this->ws_account_info."</AccountID>
		<KASATS_ID>KASWS</KASATS_ID>
	</AccountInfo>
	<Results>
        <Candidate>
            <FirstName>".$this->user_obj->user_info['fname']."</FirstName>
			<LastName>".$this->user_obj->user_info['lname']."</LastName>
			<UID>".$userid."</UID>
            <AssessmentID>".$aid."</AssessmentID>
        </Candidate>
    </Results>
</ResultRequest>";

            try {
                $result = $this->wsclient->RequestResults(array('InXML' => $request));
                $response = $this->wsclient->__getLastResponse();
                $xml = new SimpleXMLElement($response);
                $result_node = $xml->children('http://www.w3.org/2003/05/soap-envelope')->Body->children('http://www.proveit2.com/KPIATS/WebServiceKAS')
                         ->RequestResultsResponse->RequestResultsResult;
			
                $axml = simplexml_load_string($result_node);
                print_r($axml);
                
            } catch (SoapFault $e) {
                echo 'SOAP Fault: '.$e->getMessage();
            }
            
        }
        
        public function redirect() {
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo "window.top.location.href='".$this->rs_site."/portal/jobseeker/';";
            echo "</script></head><body></body></html>";
            exit;
        }
		
		public function closewin($candidate_id) {
			
			if(empty($candidate_id)){
				$candidate_id = $_SESSION["userid"];
			} else{
				$splitted_data = explode("=", $candidate_id);
				
				$candidate_id = $splitted_data[1];
			}
			
			global $base_api_url;
			global $curl;
			
			$curl->get($base_api_url . "/solr-index/sync-all-candidates/", array("userid" => $candidate_id));
			$curl->get($base_api_url . "/mongo-index/sync-all-candidates/", array("userid" => $candidate_id));
			
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
			
			
			echo "alert('Your test result has been recorded.');parent.window.close();";
			
			
            echo "</script></head><body></body></html>";
            exit;
        }
		
        public function whytaketest() {
            //$user_email = 'remote.michaell@gmail.com'            
            
            View::$templ_dir = 'views';
            $view = new View('whytest');
            $view->class2 = " class='youarehere'";
            $view->color2 = "style='color:#fff' ";
            $view->display();
        }
        
        public function instructions() {           
            
            View::$templ_dir = 'views';
            $view = new View('instructions');
            $view->class3 = " class='youarehere'";
            $view->color3 = "style='color:#fff' ";
            $view->display();
        }
        
        public function testlist800plus($cat) {    
            $result = array();

            if( file_exists("./tests_lists.txt") ) {
                $result = file("./tests_lists.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                
               // $words = array_map('preg_quote', $words);
                //$regex = '/'.implode('|', $words).'/i';
                $regex = urldecode('/'.$cat.'/i');
                
                for( $i=0, $len=count($result); $i<$len; $i++ ) {  
                    $fields = explode("\t", $result[$i]);
                   
                    if(!preg_match($regex, $fields[0])) {
                         unset($result[$i]);
                    }
                }
                $result = array_values($result);
            }
			
            View::$templ_dir = 'views';
            $view = new View('testslists');
            $view->class4 = " class='youarehere'";
            $view->color4 = "style='color:#fff' ";
			
			$view->test_lists = $result;
            $view->categories = array('Call Centre', 'Clerical', 'Financial', 'Healthcare',
                                      'Industrial', 'Legal', 'Software', 'Technical');
            $view->category = $cat;
            
            $view->display();
        }
        
        public function reports() {
            $from_date = Input::post('from_date') ? Input::post('from_date') : '';//date("Y-m-d", strtotime("-7 days"));
            $to_date = Input::post('to_date') ? Input::post('to_date') : '';//date("Y-m-d");
            $nologo = Input::post('nl') ? Input::post('nl') : 1;
			
			$filter_by = Input::post('filter_by') ? Input::post('filter_by') : '';
			$search = Input::post('search') ? Input::post('search') : '';

			$from_tstamp = 0;
			$to_tstamp = 0;

            $where = array();
			if( $from_date && $to_date ) {
				$from_tstamp = strtotime($from_date);
				$to_tstamp = strtotime($to_date. "+ 1 day");
				
				if( $from_tstamp > $to_tstamp ) {
					echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
					echo "window.parent.alert('Invalid date range!');";
					echo "</script></head><body></body></html>";
				} else {
					$where[] = "unix_timestamp(result_date) >= $from_tstamp AND unix_timestamp(result_date) <= $to_tstamp";
				}
			}
            
            
			if( $search && $search != 'keyword') {
				$filter_by_fld = ($filter_by == 'p.fname') ? $filter_by_fld = "concat(p.fname,' ',p.lname)" : $filter_by;
				$where[] = "$filter_by_fld = '$search'";
			}
			
			if( count($where) )
				$test_result = $this->result_model->fetchAll( implode(' AND ', $where) );
			else $test_result = array();
            
            View::$templ_dir = 'views';
            $view = new View('reportings');
            $view->report = true;
			
			$view->from_date = $from_date;
			$view->to_date = $to_date;
			$view->filter_by =  $search ? $filter_by : '';
			$view->search = $search;
			
            $view->emailaddr = $this->user_obj->user_info['email'];
            $view->nologo = $nologo;
            
            $view->test_result = $test_result;
            $view->display();
        }
        
		public function get_testname() {
			echo "<script type='text/javascript'>";
			//echo "var myframe = frameRef.contentWindow ? frameRef.contentWindow.document : frameRef.contentDocument;";
			echo "window.parent.testNames = ".json_encode( $this->result_model->results_testname() ).";";
			//echo "document.getElementById('iFrameWin').contentWindow.targetFunction();";
			echo "window.parent.populate_testname();";
			echo "</script>";
			exit;
		}
		
		/*public function testresults() {
			View::$templ_dir = 'views';
            $view = new View('test_details');
			$view->nologo = 1;
			$view->display();
		}*/
		
        public function test_details($kasURL = '') { //param = "ResultID=4815905&TestType=Skills&AcctID=9c7qs25t&CustomReport=") {

            $kasURL = explode('kasURL=', $_SERVER['QUERY_STRING'], 2);

			if( empty($kasURL[1]) ) die('The link for the test result was not found.');
			
			$result_url = $kasURL[1];
			if( preg_match('/staging/', $result_url, $match) ) {
				if( preg_match('/ResultID\=(\d+)\&/', $result_url, $match) )
					$content = file_get_contents('../../skills_test/logs/'.$match[1].'.html');
			} else {
				$result_url = str_replace('https', 'http', $result_url);
				$result_url = str_replace("%3F", "?", $result_url);
				$content = file_get_contents($result_url);
				$content = preg_replace('/<img id="_ctl0_KenexaLogoHeader"(.*)\/>/', "", $content);
				$content = preg_replace('/<\/title>/', "</title>\n<base href='https://www.proveit.com/KPIATS/Reports/'>", $content);
				$content = preg_replace('/<font face="Verdana">Company Name:(\s+)<\/font>/', "", $content);
				$content = preg_replace('/<small>Remote Staff AU integration<\/small>/', "", $content);
				$content = preg_replace('/<small>Remote Staff Integration Account<\/small>/', "", $content);
				$content = preg_replace('/<a href="" onclick="CloseWindow\(\)\;" >Close window<\/a>/', '<a href="#" onclick="CloseWindow();">Close window</a>', $content);
				//preg_match('/<img id="_ctl0_KenexaLogoHeader"(.*)\/>/', $content, $match);
			}
            echo $content;
        }
		
		public function login_form() {
			if( $this::$login_type ) {
				header("location: /portal/skills_test/");
				exit;
			}
			View::$templ_dir = 'views';
			$view = new View('login');
			$view->display();
		}
		
		public function userlogin() {
			$email = Input::post('email');
			$password = Input::post('password');
			
			$diff_user = new Users( array($email, 'jobseeker', 0) );
			$diff_user->login($email, $password);
			
			echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
			echo "window.parent.loginResult('".$diff_user->error."');";
			echo "</script></head><body></body></html>";
			exit;
		}
		        
		public function fb_login() {
			if( $this::$login_type ) {
				header("location: /portal/skills_test/");
				exit;
			}
			header("location: https://www.facebook.com/dialog/oauth?"
				   ."client_id=120769391467061"
				   ."&redirect_uri=".$this->rs_site."/portal/skills_test/fb_oauth_cb.php"
				   ."&response_type=code&scope=email");
			exit;
		}
		public function get_staging_reports() {
			$results = $this->result_model->fetchStaging();
			echo 'Saving the staging reports...<br/>';
			foreach( $results as $result ) {
				$fname = $result['result_id'].'.html';
				$content = file_get_contents($result['result_url']);
				$this->file_write_log($fname, $content);
			}
			die('Done.');
		}
		
		private function file_write_log($fname, $content) {
			$log_dir = './logs';
			if (!is_dir($log_dir)) {
				mkdir( $log_dir, 0755 );
				$handle = fopen( $log_dir . "/index.html", 'x+' );
				fclose( $handle ); 
			}
			$file_name = $log_dir . '/' . $fname;            
			file_put_contents($file_name, $content);
		}
	}