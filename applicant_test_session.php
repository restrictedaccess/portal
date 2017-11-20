<?php
include('conf/zend_smarty_conf.php');
/*include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';*/
include('skillstest/skills_test_class.php');

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

skills_test::$dbase = $db;

if( isset($_POST['item']) ) $item = $_POST['item'];
elseif (isset($_GET['item'])) $item = $_GET['item']; else $item = '';

if( isset($_POST['test_id']) ) $test_id = $_POST['test_id'];
elseif (isset($_GET['test_id'])) $test_id = $_GET['test_id']; else $link = 0;


if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
	exit;
}
$userid = $_SESSION['userid'];

$emailaddr = $_SESSION['emailaddr'];

$error = '';

$test = skills_test::getInstance($test_id); //new skills_test();

$test_taken = $test->user_test_access_count($userid);
if( $test_taken > 0 ) {
	$error = 'You have already taken this test before';
}

switch( $item ) {
	case 'session':
		$qcnt = isset($_POST['qcnt']) ? $_POST['qcnt'] : ( isset($_GET['qcnt']) ? $_GET['qcnt'] : 0);
		$test->test_question($qcnt);
		//break;
		exit;
	case 'save_answer':
		$uaid = isset($_POST['uaid']) ? $_POST['uaid'] : ( isset($_GET['uaid']) ? $_GET['uaid'] : 0);
		$qid = isset($_POST['qid']) ? $_POST['qid'] : ( isset($_GET['qid']) ? $_GET['qid'] : 0);
		$tstamp = isset($_POST['tstamp']) ? $_POST['tstamp'] : ( isset($_GET['tstamp']) ? $_GET['tstamp'] : 0);
		
		$data_array = array('user_answer_id' => $uaid, 'test_log_tstamp' => $tstamp,
							'userid' => $userid, 'test_id' => $test_id, 'question_id' => $qid);
		
		$test->user_answer_save($data_array);
		exit;
	case 'get_answer':
		$test->user_test_answered($userid);
		exit;
}




$smarty = new Smarty;


$admin_id = $_SESSION['admin_id'];

/*if($admin_id == ''){
	header("location:index.php");
    exit();
}*/

/*$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);*/

$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $test->tests[0]['test_instruction']);
$str = preg_replace('/\\\/', '', $str);
$str = str_replace("/\s+/", '&nbsp;', $str);

$test->tests[0]['test_instruction'] = $str;

//print_r($test->test_question());

//var_dump($test->tests);
$smarty->assign('test_array', $test->tests);
$smarty->assign('question_count', $test->test_question_count());
$smarty->assign('testcount', $test_taken);

$smarty->assign('admin',$admin);
$smarty->assign('userid', $userid);
$smarty->assign('error', $error);

$smarty->display('applicant_test_session.tpl');

?>