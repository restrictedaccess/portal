<?php
class IndexController extends Zend_Controller_Action {
	private $config = array();
	private $couch_dsn;
	private $wsclient = NULL;
	private $source;
	private $rs_site;
	private $utils;
    public function init() {

        $this->view->pageTitle = "Remotestaff Test Admin";
		
        $response = $this->getResponse();
        // insert other templates
		if( !($this->_getParam('item')) ) {
		//if( $this->_getParam('item') == 'index' ) {
			//$response->insert('sidebar', $this->view->render('layouts/sidebar.phtml'));
			$response->insert('topnav', $this->view->render('layouts/topnav.phtml'));
		}
		
		$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
						? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
		$this->config = Zend_Registry::get('config');
		$this->source = $this->config->source;
		
		$this->utils = Utils::getInstance();
    }
	
	

	protected function _doAction($action) {
		try {
		$method = $action.'Action';
		$this->_helper->viewRenderer($action);
		return $this->$method();
		} catch( Exception $e) {
			die($e->getMessage());
		}
	}
	
	public function indexAction() {
		
		//$this->_redirect('index');
		
		$item = $this->_getParam('item');
		if( $item && $item != 'index' ) {
			return $this->_doAction($item);
		}
		
		$this->view->sub_title = 'Create Test Session';

        $assessment = new AssessmentLists();
		$response = $this->getResponse();
		
		$this->view->categories = $assessment->get_categories();
		
		$form = new emailForm();
		
		$this->view->form = $form;
		
    }
	
	public function testlistAction() {
        $cat = $this->_getParam('cat');
		$posArray = explode('__pos__', $cat);
		if( count($posArray) > 1 ) $where = "assessment_title REGEXP '".$posArray[1]."' AND status='active'";
		else $where = "assessment_category = '$cat' AND status='active'";
		
		$assessment = new AssessmentLists();
		$tests = $assessment->fetchAll($assessment->select()->where($where));
		
        echo json_encode($tests->toArray());
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
    }
	
	public function newsessionAction() {
		$form = new emailForm();
				
		$redirect_url = $this->rs_site."/portal/skills_test/index.php?/closewin/";
		
		if( $this->getRequest()->isPost() ) {
			$formdata = $this->_request->getPost();
			
			$data_array = array();
			
			if( $form->isValid($formdata) ) {
				$emailaddr = $formdata['emailaddr'];
				$fname = $formdata['fname'];
				$test_id = $formdata['test_id'];
				
				$personal = new Personal();
				
				
				$candidate_xml = '';
				$firstname_tag = array();
				$ctr=0;
				foreach( $emailaddr as $email ) {
					
					$candidate_id = $personal->get_user($email);
					
					$redirect_url = $this->rs_site."/portal/skills_test/index.php?/closewin/&amp;amp;candidate_id=" . $candidate_id;
					
					$candidate_xml .= "
					<Candidate>
						<FirstName>{$fname[$ctr++]}</FirstName>
						<LastName></LastName>
						<UID>$email</UID>
						<ReturnCandidateURL>$redirect_url</ReturnCandidateURL>
						<Assessments>";
					
					$assessment_xml = '';
					foreach( $test_id as $id ) {
						$assessment_xml .= "\n\t\t\t\t\t\t<AssessmentID>$id</AssessmentID>";
						//$data_array[$email]['aid'] = $id;
					}
					$candidate_xml .= $assessment_xml;
					$candidate_xml .= "\n\t\t\t\t\t</Assessments>
					</Candidate>\n";
					
					
				}
				
				$data_array = $this->request_session($candidate_xml);
				
				if( !empty($data_array['error']) ) {
					echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
					echo "window.parent.test.errormsg('{$data_array['error_obj']}');";
					echo "</script></head><body></body></html>";
				}
				
				$sessions_aid = new AssessmentSessionsAid();
				$assessment_sessions = new AssessmentSessions();
				$admin = new Admin();
				
				$admin_user = $admin->fetchRow($admin->select()->where('admin_id=?',$_SESSION['admin_id']))->toArray();
				
				// EMAIL BODY
				$msgbody_candis = "";
				$msgbody_candis .= "<p>Dear __FNAME__,</p>";
				$msgbody_candis .= "<br>";
				$msgbody_candis .= "<p>Please take the skills test necessary for the role you are applying for <a href='__ASSESMENT_URL__' target='_blank'>HERE</a>.</p>";
				$msgbody_candis .= "<p><span style='color:red; font-weight:700;'>Note</span>: Before taking the skills test exam please check the following system requirements <a href='http://www.proveit.com/marketing/sysrequirements.asp' target='_blank'>HERE</a>.</p>";
				$msgbody_candis .= "<br>";
				$msgbody_candis .= "<br>";
				$msgbody_candis .= "<p>Good Luck!</p>";
				$msgbody_candis .= "<br>";
				$msgbody_candis .= "<p>{$admin_user['admin_fname']} {$admin_user['admin_lname']}</p>";
				$msgbody_candis .= "<br>";
				if($admin_user['signature_company']) {
					$msgbody_candis .= "<p>{$admin_user['signature_company']}</p>";
				}
				$msgbody_candis .= "<br>";
				if($admin_user['signature_contact_nos']) {
					$msgbody_candis .= "<p>{$admin_user['signature_contact_nos']}</p>";
				}
				$msgbody_candis .= "<p>";
				$msgbody_candis .= "<a href='www.remotestaff.com.au' target='_blank'><img src='https://remotestaff.com.au/portal/images/email_sig/RS_rycr.png.jpg'></a>";
				$msgbody_candis .= "</p>";
				
				// EMAIL BODY TO ADMIN
				/*$msgbody_admin = "<p>Dear Admin,</p>
				You have successfully created Test session. <br/>Please see the candidates details and its designated session link.<br/><br/>\n
				__CANDI_TEST_SESSION__
				<p></p><br/>
				Regards,
				<p>RemoteStaff Team</p>";*/
				
				$candis_links = array();
				foreach( $data_array as $idx => $data ) {
					
					$email_subject = "Remotestaff Test Session (ID: {$data['sessionid']})";
					
					$aid_array = $data['aid'];
					unset($data['aid']);
					unset($data['sessionid']);
					
					if( $assessment_sessions->if_exists($data['uid'], $data['kas_url']) ) continue;
					$data['created_by'] = (int)$_SESSION['admin_id'];
					
					$sid = $assessment_sessions->insert($data);
					
					foreach($aid_array as $aid) {
						$sessions_aid->insert(array('session_id'=>$sid, 'assessment_id'=>$aid));
					}
					
					
					$test_url = $this->rs_site."/portal/skills_test/index.php?/start_assessment/&assessment_url=".$data['kas_url'];
					
					$email_candis = str_replace('__FNAME__', $data['fname'] ? $data['fname'] : $data['uid'], $msgbody_candis);
					$email_candis = str_replace('__ASSESMENT_URL__', $test_url, $email_candis);
					
					// send the test link
					$this->utils->send_email($email_subject, $email_candis, $data['uid'], 'Remotestaff Notification', false);
					
					//array_push( $candis_links, $data['fname']." ".$data['uid']." - ". "<a href='$test_url'>Test Link</a>");
					
				}
				
				/*if( count($candis_links) > 0 ) {
					$msgbody_admin = str_replace('__CANDI_TEST_SESSION__', implode("<br/><br/>", $candis_links), $msgbody_admin);
					$this->utils->send_email($email_subject, $msgbody_admin, $admin_user['admin_email'], 'Remotestaff Notification', false);
				}*/
				
				echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
				echo "window.parent.test.hide_loading();";
				echo "</script></head><body></body></html>";
				
			} else {
				$aErrmsg = array();
				foreach( $form->getMessages() as $key=>$val ) $aErrmsg[] = $val[0][0];
				
				echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
				echo "window.parent.test.errormsg('".implode("\n", $aErrmsg)."');";
				echo "</script></head><body></body></html>";
			}
		}
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
	
	
	/* session request */
    private function request_session($candidate_xml) {
		$ws_account_info = $this->config->{$this->source}->accountid;
		$kasatsid = $this->config->{$this->source}->kasatsid;
		
		if( $this->wsclient === NULL ) $this->get_ws_client();
		
        $request =
		"<SessionRequest>
			<AccountInfo>
				<AccountID>$ws_account_info</AccountID>
				<KASATS_ID>$kasatsid</KASATS_ID>
			</AccountInfo>
			<PostResultsURL>".$this->rs_site."/portal/skills_test/index.php?/get_result/</PostResultsURL>
			<Candidates>
				$candidate_xml
			</Candidates>
		</SessionRequest>";
		
		
		$data = array();
		
        try {
			$result = $this->wsclient->SessionRequest (array('InXML' => $request));
			$response = $this->wsclient->__getLastResponse();
			
			$xml = new SimpleXMLElement($response);
			$session_node = $xml->children('http://www.w3.org/2003/05/soap-envelope')->Body->children('http://www.proveit2.com/KPIATS/WebServiceKAS')
				->SessionRequestResponse->SessionRequestResult;
                
			$axml = simplexml_load_string($session_node);
			
			$status_result = $axml->Status->Result;
                    
			if( $status_result == "Success" ) {
				$candidates = $axml->Candidates->Candidate;
				
				$idx = 0;
				foreach($axml->Candidates->Candidate as $candidate) {
					
					$data[$idx] = array('fname' => (string)$candidate->FirstName,
									  'uid' => (string)$candidate->UID,
									  'kas_url' => (string)$axml->Candidates->KASAssessmentURL[$idx],
									  'expiry_date' => (string)$axml->Candidates->SessionExpiryDate[$idx],
									  'sessionid' => (string)$axml->Candidates->SessionID[$idx]
									  );
					
					$ctr = 0;
					foreach($candidate->Assessments->AssessmentID as $aid) {
						//var_dump($aid);
						$data[$idx]['aid'][$ctr++] = (string)$aid;
					}
					
					$idx++;
				}				
				
			} else {
				$data = array('error' => $status_result);
			}                    
                    
		} catch (SoapFault $e) {
			$data = array('error' => 'SOAP Fault: '.$e->getMessage(), "error_obj" => $e);
		}
		
		return $data;

    }
	
	private function get_ws_client() {
		
		$ws_url = $this->config->{$this->source}->url;
		
		$this->wsclient = new SoapClient( "$ws_url?WSDL",
			array(
				'trace' => 1,
				'exceptions' => true,
				'location' => $ws_url,
				'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
				'soap_version' => SOAP_1_2,
				'encoding' => 'ISO-8859-1',
				'style' => SOAP_RPC,
				'use' => SOAP_ENCODED,
				'keep_alive' => false,
				'ssl' => array('verify_peer' => false, 'allow_self-signed' => true)
			));
    }
}
