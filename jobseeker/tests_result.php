<?php /* tests_result.php 2013-06-13 */
include('../conf/zend_smarty_conf.php') ;
require_once "../skills_test/models/AssessmentResults.php";
include_once('../lib/users_class.php');
$userid = $_SESSION['userid'];
Users::$dbase = $db;
$user_obj = new Users( array('', 'jobseeker', $userid) );
$test_obj = AssessmentResults::getInstance($db);
$test_results = $test_obj->fetchAll("result_uid={$userid} OR result_uid='{$user_obj->user_info['email']}'");
$new_test_result = array();
foreach($test_results as $key =>$test_result){
	$new_test_result[$key] = $test_result;
	$new_test_result[$key]['assessment_typing'] = ( strpos( strtolower( $test_result['assessment_title'] ), 'typing' ) !== false ? 1 : 0 ); 
}
if( count($new_test_result) > 0 ) {
    $smarty = new Smarty();
    $smarty->assign("user", $user_obj->user_info);
    $smarty->assign('test_taken', $new_test_result);
    $smarty->assign('testresult_active', 'active');
    $smarty->display('tests_result.tpl');
} else {
    echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript' src='/portal/jobseeker/js/utils.js'></script>
    <script type='text/javascript'>";
    echo "popup_win7('/skills_test/',970,600);";
    echo "history.go(-1);";
    echo "</script></head><body></body></html>";
    exit;
}

 


