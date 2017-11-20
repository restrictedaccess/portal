<?php
/****/

class IndexController {
	private static $instance = NULL;
	private $smarty;
	private $template;
	private $client = NULL;
	private $admin_id = 0;
	public static function get_instance($db) {
		if( self::$instance === NULL) self::$instance = new self($db);
		return self::$instance;
	}
	
	function __construct($db) {
		$this->db = $db;
		$this->admin_id = $_SESSION['admin_id'];
		$this->smarty = new Smarty();
		// set the templates dir.
		$this->smarty->template_dir = "./templates";
		$this->smarty->compile_dir = "./templates_c";
		
		$this->client = new client_class($db);
		
		$this->rs_site = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
					? "https://". $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST'];
		
	}
	
	public function index($leads_id = 0) {
		$this->template = 'index.tpl';
		$_SESSION['session'] = 'index';
		
		$clients = $this->client->get_client_info(1);
		/*$clients = array(
			array('id'=>11, 'fname'=>'Chris', 'lname'=>'Jankulovski'),
			array('id'=>12, 'fname'=>'Normaneil', 'lname'=>'Macutay'),
			array('id'=>13, 'fname'=>'Anne Charise', 'lname'=>'Mancenido')
		);*/
		
		//$aUsers = array_map( function($a){return $a['id'];}, $clients);
		//$this->smarty->assign('subtitle', 'Home');
		$this->smarty->assign('date_now', date('M d, Y'));
		$this->smarty->assign('clients', $clients);
		$this->smarty->assign('admin', $this->admin_info());
		$this->smarty->assign('home', true);
		$this->smarty->assign('leads_id', $leads_id);
		
		$this->render();
	}
	
	public function admin($content) {
		if( !$content) $content = 'client_concerns';
		$_SESSION['session'] = 'admin';
		
		$page = Input::get('page');
		$concern_id = Input::get('cid');
		//if( !$page) $this->admin_client_concerns();
		$this->template = 'admin.tpl';
		//$this->smarty->assign('subtitle', 'Admin');
		$this->smarty->assign('date_now', date('M d, Y'));
		$this->smarty->assign('admin', $this->admin_info());
		$this->smarty->assign('content', $content);
		$this->smarty->assign('param', $concern_id?$concern_id:'0' );
		$this->render();
	}
	
	public function admin_client_concerns($id = 0) {
		$this->template = 'admin_client_concerns.tpl';
		$allowed = 0;
		if( isset($_GET['modal'])) $modal = Input::get('modal');
		else $modal = 0;
		
		if( in_array($this->admin_id, array(6, 43, 214) ) && !$modal) $allowed = 1;
		
		
		
		if( !$id ) $id = 0;
		$clientConcerns = new clientConcerns();
		$client_concerns = $clientConcerns->fetchAll($clientConcerns->select()->where('concern_status=?','1'));
		//print_r($client_concerns->toArray());
		$this->smarty->assign('client_concerns', $client_concerns->toArray());
		$this->smarty->assign('concern_id', $id);
		$this->smarty->assign('modal', $modal);
		$this->smarty->assign('allowed', $allowed);
		$this->render();
	}
	
	public function clientlist() {
		$clients = array(
			array('id'=>11, 'fname'=>'Chris', 'lname'=>'Jankulovski'),
			array('id'=>12, 'fname'=>'Normaneil', 'lname'=>'Macutay'),
			array('id'=>13, 'fname'=>'Anne Charise', 'lname'=>'Mancenido')
		);
		
		echo json_encode($this->client->get_client_info());
		//echo json_encode($clients);
	}
	
	public function staff_member($leads_id) {
		$this->template = 'client_staff.tpl';
		$this->client->$leads_id = $leads_id;
		
		$concernInput = new clientConcernInput();
		
		$client_input = $concernInput->fetch_client_input($leads_id);
		//print_r($client_input);
		$this->smarty->assign('client_name', $this->client->get_client_info($leads_id));
		$this->smarty->assign('staff_members', $this->client->get_staff($leads_id));
		$this->smarty->assign('cci', $client_input);
		/*$staff = array(
			array('userid'=>100, 'fname'=>'Juan', 'lname'=>'Dela Cruz'),
			array('userid'=>101, 'fname'=>'Antonio', 'lname'=>'Procopio'),
			array('userid'=>102, 'fname'=>'Maria', 'lname'=>'Tapia')
			);
		$this->smarty->assign('staff_members', $staff);*/
		$this->render();
		
	}
	
	public function show_form($leads_id = 0) {
		//echo 'leads:'.$leads_id;
		$this->template = 'client_concern_input_form.tpl';
		$clientConcerns = new clientConcerns();
		$client_concerns = $clientConcerns->fetchAll($clientConcerns->select()->where('concern_status=?','1'));
		//print_r($client_concerns->toArray());
		$this->smarty->assign('client_concerns', $client_concerns->toArray());
		
		$this->smarty->assign('leads_id', $leads_id);
		$this->render();
	}
	
	public function show_concerns_list($leads_id = 0) {
		//echo 'leads:'.$leads_id;
		$this->template = 'client_concerns_list.tpl';
		$clientConcerns = new clientConcerns();
		$client_concerns = $clientConcerns->fetchAll($clientConcerns->select()->where('concern_status=?','1'));
		//print_r($client_concerns->toArray());
		$this->smarty->assign('client_concerns', $client_concerns->toArray());
		
		$this->smarty->assign('leads_id', $leads_id);
		$this->render();
	}
	
	public function show_concern($id=0) {
		//echo 'leads:'.$_SERVER['QUERY_STRING'];
		$this->template = 'client_concern_qa.tpl';
		$modal = Input::get('modal');
		$client_input = Input::get('cci');
		$client_response = Input::get('resp');
		$qid = Input::get('qid');
		$client_input = $client_input ? $client_input : 0;
		$params = array('cci'=>$client_input, 'resp'=>$client_response, 'qid'=>$qid);
		
		$cci = new clientConcernInput();
		//$clientConcern = new clientConcerns();
		//$data = $clientConcern->fetch_client_concern($id);
		//print_r($data);
		$aId = explode('&', $id, 2);
		$id = $aId[0];
		
		
		$this->smarty->assign('modal', $modal);
		$this->smarty->assign('cid', $id);
		$this->smarty->assign('cci', $client_input ? $client_input : 0);
		$this->smarty->assign('resp', $client_response);
		$this->smarty->assign('params', $params);
		$this->render();
	}
	
	// get list of concern that related to selected staff
	public function staff_concern_input($userid = 0) {
		$leads_id = Input::get('lead');
		$ccs = new clientConcernStaff();
		$result = $ccs->fetch_concern_staff($userid, $leads_id);
		echo json_encode($result);
	}
	
	// get specific client concerns list
	public function client_concern_input($leads_id = 0) {
		$concernInput = new clientConcernInput();
		$result = $concernInput->fetch_client_input($leads_id);
		echo json_encode($result);
	}
	
	public function get_client_concern($id = 0) {
		//echo 'leads:'.$leads_id;
		//$this->template = 'client_concern.tpl';
		$clientConcern = new clientConcerns();
		$data = $clientConcern->fetch_client_concern($id);
		
		$ccq = new clientConcernQuestions();
		$questions = $ccq->fetch_questions($id);
		
		/*$cca = new clientConcernAnswers();
		$answers = $cca->fetch_answers($id);
		
		//$aID = array_map( function($a){return $a['id'];}, $answers);
        //$answers = array_combine($aID, $aID);
		$response_array = array();
		foreach( $answers as $answer ) {
			//echo '<br/>'.$answer['id'].'-'.$answer['answer_text'];
			$response_array[ $answer['id'] ]['answer'] = $answer['answer_text'];
			$response_array[ $answer['id'] ]['followupq'][] = array('id'=>$answer['fqid'],
															  'fup_q'=>$answer['fup_question']);
		}*/
		
		$data['q'] = $questions;
		//---$data['a'] = $response_array;
		//print_r($data);
		//print_r($questions);
		//print_r($response_array);
		
		$admin_info = $this->admin_info();
		$data['can-edit'] = ($_SESSION['session'] == 'admin' && strtolower($admin_info['status']) == 'full-control');
		echo json_encode($data);
		
		//$this->smarty->assign('concern', $data);
		//$this->render();
	}
	
	public function get_question($qid) {
		$this->template = 'client_concern_qa_edit.tpl';
		$ccq = new clientConcernQuestions();
		$result = $ccq->fetch_questions($qid, true);
		/*$select = $ccq->select()
        ->where('id = ?', $qid)
        ->where('answer_id is NULL');
		$result = $ccq->fetchRow($select)->toArray();*/
		
		$this->smarty->assign('question', $result);
		$this->render();
	}
	
	public function get_question_response($id=0) {
		$cca = new clientConcernAnswers();
		$answers = $cca->fetch_answers($id);
		
		$response_array = array();
		foreach( $answers as $answer ) {
			//echo '<br/>'.$answer['id'].'-'.$answer['answer_text'];
			$response_array[ $answer['id'] ]['answer'] = $answer['answer_text'];
			$response_array[ $answer['id'] ]['followupq'][] = array('id'=>$answer['fqid'],
															  'fup_q'=>$answer['fup_question']);
		}
		
		//$response_array;
		//print_r($response_array);
		//print_r($questions);
		//print_r($response_array);
		echo json_encode($response_array);
	}
	
	public function add_concern() {
		//$this->template = 'client_concern_input.tpl';
		
		$concernInput = new clientConcernInput();
		
		$clientConcern = new clientConcerns();
		 
		//$this->render();
		$leads_id = Input::post('leads_id');
		//$admin_id = 214;
		$pre_clientconcern = (int)Input::post('pre_clientconcern');
		
		
		$staff_concern = Input::post('userid');
		
		if( $pre_clientconcern == 0 ) {
			$client_concern_input = Input::post('client_concern');
			if( $client_concern_input && $client_concern_input != '0' ) {
				$concern_data = array('admin_id'=>$this->admin_id, 'concern_title'=>$client_concern_input);
				$concern_id = $clientConcern->insert($concern_data);
			}
		} else $concern_id = $pre_clientconcern;
		
		if( $concern_id ) {
			$data_array = array('leads_id'=>$leads_id, 'admin_id'=>$this->admin_id, 'concern_id'=>$concern_id);
			//print_r($staff_concern);
			$concern_inp_id = $concernInput->insert($data_array);
			
			if( count($staff_concern) ) {
				$clientStaff = new clientConcernStaff();
				foreach( $staff_concern as $userid )
					//print_r( array('concern_input_id'=>$concern_id, 'userid'=>$userid) );
					$clientStaff->insert( array('concern_input_id'=>$concern_inp_id, 'userid'=>$userid) );
			}
		}
		
		
		echo "<script type='text/javascript'>";
		echo "window.parent.scenario.endResult()";
		echo "</script>";
		exit;
	}
	
	public function add_concern_title() {
		$concern_title = Input::post('concern_title');
		if( $concern_title ) {
			$clientConcern = new clientConcerns();
			$concern_data = array('admin_id'=>$this->admin_id, 'concern_title'=>$concern_title);
			$concern_id = $clientConcern->insert($concern_data);
			echo "<script type='text/javascript'>";
			echo "parent.window.location.href='/portal/scenmgt/?/admin/client_concerns/&cid={$concern_id}'";
			echo "</script>";
			exit;
		}
	}
	
	public function edit_concern_title() {
		$concern_id = Input::post('concern_id');
		$concern_title = Input::post('concern_title');
		//$admin_id = 214;
		if( $concern_title ) {
			$clientConcern = new clientConcerns();
			$concern_data = array('concern_title'=>$concern_title);
			$clientConcern->update($concern_data, 'id='.$concern_id);
			echo "<script type='text/javascript'>";
			echo "parent.window.location.href='/portal/scenmgt/?/admin/client_concerns/&cid={$concern_id}'";
			echo "</script>";
			exit;
		}
	}
	
	public function delete_client_concern() {
		$concern_id = Input::post('concern_id');
		if( $concern_id ) {
			$clientConcern = new clientConcerns();
			$clientConcern->update(array('concern_status'=>'0'), 'id='.$concern_id);
			echo "<script type='text/javascript'>";
			echo "parent.window.location.href='/portal/scenmgt/?/admin/client_concerns/'";
			echo "</script>";
			exit;
		}
	}
	
	public function add_question() {
		$concernQuestions = new clientConcernQuestions();
		$concern_id = Input::post('concern_id');
		$concern_question = Input::post('new_q');
		$concern_question = trim($concern_question);
		if( $concern_question != "" ) {
			$data = array('concern_id'=>$concern_id, 'question_text'=>$concern_question);
			$aid = Input::post('answer_id');
			if( $aid ) $data['answer_id'] = $aid;
			$concernQuestions->insert($data);
		}
		echo "<script type='text/javascript'>";
		if( $aid ) {
			$question_id = Input::post('question_id');
			echo "window.parent.admin_qa.showQuestionResponse({$question_id});";
			echo "window.parent.admin_qa.reset_aform()";
		} else echo "window.parent.admin_qa.showConcernQuestions({$concern_id})";
		echo "</script>";
		exit;
		
	}
	
	public function add_answer() {
		$concernAnswers = new clientConcernAnswers();
		$question_id = Input::post('question_id');
		$concern_answer = Input::post('new_a');
		$concern_answer = trim($concern_answer);
		if( $concern_answer != "" ) {
			$concernAnswers->insert( array('question_id'=>$question_id, 'answer_text'=>$concern_answer));
		}
		echo "<script type='text/javascript'>";
		echo "window.parent.admin_qa.showQuestionResponse({$question_id})";
		echo "</script>";
		exit;
		
	}
	
	public function edit_question() {
		/*update `client_concern_answers` 
set answer_text = case id
when 9 then 'test response #9'
when 10 then 'i cannot login to portal page'
when 29 then 'unable to continue message'
end
where id in (9, 10, 29)*/
		$question_id = Input::post('question_id');
		$question_text = Input::post('question_text');
		unset($_POST['question_id']);
		unset($_POST['question_text']);
		
		$aResp = array();
		$aFup = array();
		
		$aRespKeys = array();
		$aFupKeys = array();
		foreach($_POST as $k => $value) {
			//echo "\n ==>>>".$value;
			$aK = explode('-', $k);
			$escape_val = $this->db->quote($value);
			switch($aK[0]) {
				case 'resp':
					//$resp = $this->db->quote($value);
					$aResp[] = "WHEN {$aK[2]} THEN {$escape_val}";
					$aRespKeys[] = $aK[2];
					break;
				case 'fup':
					//$fup = $this->db->quote($value);
					$aFup[] = "WHEN {$aK[1]} THEN {$escape_val}";
					$aFupKeys[] = $aK[1];
					break;
			}
		}

		if( count($aResp)) {
			// set the query update on answers
			$update_answers = "UPDATE client_concern_answers SET answer_text = CASE id "
			.implode(' ', $aResp)
			." END WHERE id IN ("
			.implode(', ', $aRespKeys)
			.")";
			
			$cca = new clientConcernAnswers();
			$stmt = $this->db->prepare($update_answers);
			$stmt->execute();
		}
		
		$ccq = new clientConcernQuestions();
		
		//update question text
		if( $question_text )
			$ccq->update(array('question_text' => $question_text), 'id='.$question_id);
			
		if( count($aFupKeys)) {
			// set the query update on followup questions
			$update_questions = "UPDATE client_concern_questions SET question_text = CASE id "
			.implode(' ', $aFup)
			." END WHERE id IN ("
			.implode(', ', $aFupKeys)
			.")";
			
			//echo '<br/>'.$update_questions;
			
			$stmt = $this->db->prepare($update_questions);
			$stmt->execute();
		}
				
		echo "<script type='text/javascript'>";
		echo "window.parent.admin_qa.showQuestionResponse({$question_id})";
		echo "</script>";
		exit;
		
	}
	
	public function delete_question() {
		$question_id = Input::post('question_id');
		$concern_id = Input::post('concern_id');
		if( $question_id ) {
			$ccq = new clientConcernQuestions();
			$ccq->delete('id='. $question_id);
			
			$cca = new clientConcernAnswers();
			$cca->delete('question_id='. $question_id);
			
			echo "<script type='text/javascript'>";
			echo "parent.window.location.href='/portal/scenmgt/?/admin/client_concerns/&cid={$concern_id}'";
			echo "</script>";
		}
		exit;
	}
	
	public function select_response() {
		$answer_id = Input::post('answer_id');
		$cc_id = Input::post('cc_id');
		$question_id = Input::post('question_id');
		$leads_id = Input::post('leads_id');
		$unselect = Input::post('unselect');
		if( $answer_id && $cc_id ) {
			if( $unselect == 'true' ) $answer_id = 0;
			$cci = new clientConcernInput();
			$cci->update(array('client_response'=>$answer_id), 'id='. $cc_id);
			
			echo "<script type='text/javascript'>";
			echo "parent.window.location.href='/portal/scenmgt/?/index/{$leads_id}'";
			echo "</script>";
		}
		exit;
	}
	
	private function admin_info() {
		
		$select = $this->db->select()
		->from('admin', array('admin_id', 'admin_fname', 'admin_lname', 'admin_email', 'status'))
		->where('admin_id = ?', $this->admin_id);
		return $this->db->fetchRow($select);
	}
	
	private function queryString($param) {
		$qstr = array();
		foreach( $param as $key => $val) $qstr[] = $key.'='.urlencode($val);
		return implode('&', $qstr);
	}
	
	private function render() {
		$this->smarty->display($this->template);
	}
	
	
}
