<?php

class IndexController {
	private static $instance = NULL;
	private $db;
	private $smarty;
	private $template;
	private $feedback;
	private $rs_site;
	private $scoring;
	public static function get_instance() {
		if( self::$instance === NULL) self::$instance = new self($db);
		return self::$instance;
	}
	
	function __construct($db) {
		//echo 'constructing...';
		$this->db = $db;
		$this->smarty = new Smarty();
		// set the templates dir.
		$this->smarty->template_dir = "./templates";
		$this->smarty->compile_dir = "./templates_c";
		
		$this->feedback = new ClientFeedback();
		
		$this->scoring = array('No'=>0, 'Trainee'=>0, 'Poor'=>0, 'Partly'=>20, 'Average'=>20, 'Mostly'=>30, 'Average'=>30, 'Good'=>30,
						'Fully'=>40, 'Great'=>40, 'Champion'=>40, 'Genius'=>50, 'Outstanding'=>50, 'Brilliant'=>50, 'Legend'=>50, 'Excellent'=>50);
		
		$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
					? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
	}
	
	function __destruct() {
		//echo '<br/>de-constructing...';
		
	}
	
	public function index() {
		echo 'index method';
	}
	
	public function create_feedback($option = '') {
		//$feedback = new ClientFeedback();
		$leads_id = Input::post('leads_id') ? Input::post('leads_id') : Input::get('leads_id');
		$ticket_id = Input::post('ticket_id') ? Input::post('ticket_id') : Input::get('ticket_id');
		$emailaddr = Input::post('email') ? Input::post('email') : Input::get('email');
		
		
		$hash = $this->feedback->get_hash($leads_id, $ticket_id);
		if( !$hash ) {
			//$hash = chr(rand(ord("a"), ord("z"))) . md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ) ;
			$hash = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ), 2, 14 );
			
			$admin_id = $_SESSION['admin_id']; // assuming this is for admin users only
			$id = $this->feedback->insert(array('leads_id'=>$leads_id, 'ticket_id'=>$ticket_id,
												'admin_id'=>$admin_id, 'hash'=>$hash));
			
			if( $id ) {
				$date_now = date('Y-m-d H:i:s');
				
				$aHistory = array('leads_id' => $leads_id, 'date_created' => $date_now, 'actions' => 'FEEDBACK',
								 'history' => "<a href='/portal/client_feedback/?/form/".$hash."' target='_blank'>Feedback Form Created (".$id.") With Case Ticket #".$ticket_id."</a>",
								 'agent_no' => $admin_id, 'created_by_type' => 'admin');
				$history = new History();
				$hist_id = $history->insert($aHistory);
				
				if( $hist_id ) {
					$aLeadsHistory = array('leads_id' => $leads_id, 'date_change' => $date_now,
									 'changes' => 'Communication Record Type : [ Feedback Form ] History id #'.$hist_id,
									 'change_by_id' => $admin_id, 'change_by_type' => 'admin');
					
					$leads_hist = new LeadsInfoHistory();
					$leads_hist->insert($aLeadsHistory);
				}
			}
		}
		
		if( $option == 'email') {		
			$this->template = 'feedbackform_email.tpl';
			$leads_name = Input::post('name') ? Input::post('name') : Input::get('name');
			
			//$result = $this->feedback->fetch_feedback($hash);
			
			$this->smarty->assign('emailaddr', $emailaddr);
			$this->smarty->assign('client_fullname', $leads_name); //$result[0]['fname'].' '.$result[0]['lname']);
			//$this->smarty->assign('csro_name', $result[0]['admin_fname']);
			$this->smarty->assign('hash', $hash);
			$this->render();
		} else {
			echo "<script type='text/javascript'>";
			echo "window.prompt('Copy Feedback Link To Clipboard: Ctrl+C, [Enter]', '{$this->rs_site}/portal/client_feedback/?/form/{$hash}')";
			echo "</script>";
			
			//$this->template = 'feedbackform_link.tpl';
			//$admin_id = Input::post('admin_id');
			//$this->smarty->assign('feedbacklink', $this->rs_site.'/portal/client_feedback/?/form/'.$hash);
		}
		
		//$this->render();
	}
	
	public function send_email() {
		$leads_id = Input::get('leads_id');
		$hash = Input::post('hash');
		$emailaddr = Input::post('email'); //'remote.michaell@gmail.com';//
		$client_name = Input::post('client_name');
		//echo $this->rs_site.'/portal/client_feedback/form/'.$hash;
		//$tpl = file_get_contents($this->rs_site.'/portal/client_feedback/?/form/'.$hash);
		
		//$htmlbody = htmlspecialchars($tpl, ENT_QUOTES);
		$result = $this->feedback->fetch_admin($hash);
		$result = $result[0];
		
		$utils = Utils::getInstance();
		//print_r(array('Remotestaff Feedback Form', $tpl, $emailaddr, $result['admin_fname'], false));
		
		$msgbody = "<p>Hi {$client_name},</p>
				Thank you for using Remotestaff products and services. <br/><br/>
				Please allow us to serve you better by sharing your feedback through this quick <a href='{$this->rs_site}/portal/client_feedback/?/form/{$hash}'>survey</a>.
				<p></p><br/>
				Thanks!
				<p>{$result['admin_fname']} {$result['admin_lname']}<br/>
				{$result['signature_notes']} <br/>
				{$result['signature_contact_nos']} <br/><br/>
				{$result['signature_websites']}
				</p>";
				
		echo "<script type='text/javascript'>";
		if(	$utils->send_email('Your Feedback Is Important To Us', $msgbody, $emailaddr, 'Remotestaff.com.au', false) )
			echo "window.parent.endloading('')";
		else echo "window.parent.endloading('Unable to send email!')";
		echo "</script>";
		

	}
	
	public function ticket_ids($div) {
		if( empty($_SESSION['admin_id']) ) exit('No session found!');
		
		$this->template = 'ticket_ids.tpl';
		$tickets = new TicketInfo();
		$list = $tickets->fetch_tickets( $_SESSION['admin_id']);
		$this->smarty->assign('tickets', $list);
		$this->smarty->assign('catdiv', $div);
		$this->render();
	}
	
	public function save_answers() {
		
		//print_r($_POST);
		$feedback_id = Input::post('fid');
		$clunder = Input::post('clunder');
		$poprof = Input::post('poprof');
		$cleardef = Input::post('cleardef');
		$how_fast = Input::post('how_fast');
		$rate = Input::post('rate');
		$ovrallcustxp = Input::post('ovrallcustxp');
		
		$comments = Input::post('comments');
		$needreply = Input::post('needreply');
		
		$email = Input::post('email');
		
		$feedback_answers = new ClientFeedbackAnswers();
		
		if( !$feedback_answers->check_id($feedback_id) ) {
			
			$answers = array('clunder'=>$clunder, 'poprof'=>$poprof, 'cleardef'=>$cleardef,
						  'how_fast'=>$how_fast, 'rate'=>$rate, 'ovrallcustxp'=>$ovrallcustxp, 'email'=>$email);
			$id = $feedback_answers->insert( array('feedback_id'=>$feedback_id, 'answers'=>serialize($answers),
												   'comments'=>$comments, 'reply'=>$needreply) );
			
			if( $id ) {
				$this->feedback->update( array('status'=>'1'), 'id='.$feedback_id);
			}
			echo "<script type='text/javascript'>";
			echo "window.parent.Index.endloading('Thank you for sharing your feedback.')";
			echo "</script>";
			exit;
		}
	}
	
	public function form($hash) {

		$this->template = 'client_feedbackform.tpl';
		
		if( !$hash) {
			exit('Invalid Feedback Form');
		} else {
			$result = $this->feedback->fetch_feedback($hash);
			if( !$result ) exit('Invalid Feedback Form');
			//$survey_questions = $test->fetch();
			//if( empty($_SESSION['client_id']) || $_SESSION['logintype'] != 'client') {	
				$_SESSION['client_id'] = $result[0]['leads_id'];
				$_SESSION['logintype'] = 'client';
				$_SESSION['emailaddr'] = $result[0]['email'];
			//}
		}
		
		
		$clear_under = array('No', 'Partly', 'Mostly', 'Fully', 'Genius');
		$poprof = array('No', 'Partly', 'Mostly', 'Fully', 'Outstanding');
		$clear_def = array('No', 'Average', 'Good', 'Excellent', 'Brilliant');
		$how_fast = array('Immediately', '1-2 days', 'Over 1 week', 'Over 2 wks', '1 month+');
		$rate = array('Trainee', 'Average', 'Good', 'Champion', 'Legend');
		$ovrallcustxp = array('Poor', 'Average', 'Good', 'Great', 'Excellent');
		
		$reply = array('No', 'Yes');
		
		$login_email = $_SESSION['emailaddr'];
		
		//$feedback = new ClientFeedback();
		//$result = $this->feedback->fetch_feedback($hash);
		
		
		$this->smarty->assign('clear_under', $clear_under);
		$this->smarty->assign('poprof', $poprof);
		$this->smarty->assign('clear_def', $clear_def);
		$this->smarty->assign('how_fast', $how_fast);
		$this->smarty->assign('rate', $rate);
		$this->smarty->assign('ovrallcustxp', $ovrallcustxp);
		$this->smarty->assign('result', $result[0]);
		
		/*$feedback_answers = new ClientFeedbackAnswers();
		if( $feedback_answers->check_id($result['id']) ) {
			$answers = $feedback_answers->fetch($result['id']);
			
			$this->smarty->assign('answers', unserialize($answers['answers']));
			$this->smarty->assign('comments', $answers['comments']);
			$this->smarty->assign('reply', $answers['reply']);
			$this->smarty->assign('unserializedans', $answers['answers']);
		}*/
		//print_r($result[0]);
		//print_r(array($login_email, $result[0]['email']));
		
		$this->smarty->assign('isOwner', $login_email == $result[0]['email'] ? 1 : 0);
		
		$this->render();
	}
	
	public function reports() {
		if( empty($_SESSION['admin_id']) ) exit('No session found!');
		
		$this->template = 'feedbackform_reports.tpl';
		$where = array();
		$statuses = array(0 => 'Not Filed', 1 => 'Filed');
		
		$from_date = Input::get('from_date');
		$to_date = Input::get('to_date');
		
		$leads_id = Input::get('client');
		$status = Input::get('status');
		$csro = Input::get('csro');
		
		if( $leads_id) $where[] = "f.leads_id = ".$leads_id;
		if( $csro) $where[] = "a.admin_id = ".$csro;
		if( $status != "") $where[] = "f.status = '$status'";
		
		if( !$from_date) $from_date = date('Y-m-1');
		//else $from_date = date('Y-m-d H:i:s', strtotime("-5 days"));
		
		if( !$to_date) $to_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('t'), date('Y') ));

		
		$where[] = "date(f.date_created) >= '$from_date'";
		$where[] = "date(f.date_created) <= '$to_date'";
		
		
		
		//else $to_date = date('Y-m-d H:i:s');
		
		$clunder = array('No'=>0, '');

		
		/*$clear_def = array('No', 'Average', 'Good', 'Excellent', 'Brilliant');
		$how_fast = array('Immediately', '1-2 days', 'Over 1 week', 'Over 2 wks', '1 month+');
		$rate = array('Trainee', 'Average', 'Good', 'Champion', 'Legend');
		$ovrallcustxp = array('Poor', 'Average', 'Good', 'Great', 'Excellent');*/
		
		$result = $this->feedback->fetch_feedback('', $where);
		
		$clients = $this->feedback->clients();
		$csros = $this->feedback->fetch_admin();
		
		$this->smarty->assign('result', $result);
		$this->smarty->assign('scoring', $this->scoring);
		
		$this->smarty->assign('clients', $clients);
		$this->smarty->assign('csro', $csros);
		
		$this->smarty->assign('rs_site', $this->rs_site);
		
		$this->smarty->assign('from_date', $from_date);
		$this->smarty->assign('to_date', $to_date);
		$this->smarty->assign('status', $status!=''?$statuses[$status]:'All');
		$this->smarty->assign('leads_id', $leads_id);
		$this->smarty->assign('csro_val', $csro);
		
		$this->render();
	}
	
	public function summary() {
		$this->template = 'feedbackform_summary.tpl';
		$where = array();
		
		$from_date = Input::get('from_date');
		$to_date = Input::get('to_date');
		
		if( !$from_date) $from_date = date('Y-m-1');
		
		if( !$to_date) $to_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('t'), date('Y') ));

		
		$where[] = "date(f.date_created) >= '$from_date'";
		$where[] = "date(f.date_created) <= '$to_date'";
		
		$results = $this->feedback->fetch_feedback('', $where);
		$consultants = array();
		foreach( $results as $feedback) {
			$score = 0;
			//$filled = 0;
			//$consultants[ $feedback['admin_id'] ]['filled'] = 0;
			if( $feedback['answers'] ) {
				$answers = unserialize($feedback['answers']);
				
				$score += $this->scoring[$answers['clunder']];
				$score += $this->scoring[$answers['poprof']];
				$score += $this->scoring[$answers['cleardef']];
				$score += $this->scoring[$answers['rate']];
				$score += $this->scoring[$answers['ovrallcustxp']];
			}
			
			if( $feedback['status'] == 'Filled') $consultants[ $feedback['admin_id'] ]['filled']++;
					
			$consultants[ $feedback['admin_id'] ]['scores'][] = $score;
			$consultants[ $feedback['admin_id'] ]['name'] = $feedback['admin_fname'].' '.$feedback['admin_lname'];
		}

		$this->smarty->assign('results', $consultants);
		$this->smarty->assign('from_date', $from_date);
		$this->smarty->assign('to_date', $to_date);
		$this->render();
		
	}
	
	private function render() {
		$this->smarty->display($this->template);
	}
	
	
}