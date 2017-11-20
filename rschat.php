<?php
/* livechat.php  // 2010-08-19 */
//include './conf/zend_smarty_conf_root.php';
/*  2012-12-22 Lawrence Sunglao
    -   used redis for session transfer, previous implementation leaves a 
    -   temporary file on the server if the user closes the chat window before it loads
*/

include 'conf/zend_smarty_conf.php';
include '../livechat/include/livechatController.php';

$logintype = '';

$emailaddr = '';

$hostname = 'http://'.$_SERVER['HTTP_HOST'];

if (isset($_POST['portal'])) $link = $_POST['portal']; elseif (isset($_GET['portal'])) $link = $_GET['portal']; else $link = "";
if (isset($_POST['email'])) $email = $_POST['email']; elseif (isset($_GET['email'])) $email = $_GET['email']; else $email = "";
if (isset($_POST['login'])) $login = $_POST['login']; elseif (isset($_GET['login'])) $login = $_GET['login']; else $login = "";

if( empty($_SESSION['firstrun']) || $link=="1")
{
	//$logintype = $_SESSION['logintype'];
    //$emailaddr = $_SESSION['emailaddr'];
	$_SESSION['firstrun'] = "chat autologin";
}

/*if ($email && !$emailaddr) {
	echo "<script>alert('Unable to continue the chat auto-login. Please check your session login.');</script>";
	exit;
}*/

$emailaddr = $_SESSION['emailaddr'];
$logintype = $_SESSION['logintype'];

if ( !$emailaddr && !$logintype ) {
	die('Session login not found, please re-login.');
}
	

$domain_array = explode('.', $hostname);
if( $domain_array[0] != 'http://test' ) $hostname = "http://www.remotestaff.com.au";
$hash_code = chr(rand(ord("a"), ord("z"))) . md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ) ;
$redis_key = "rschat_transfer:$hash_code";
$redis = new Predis\Client();
$redis->hmset($redis_key, Array('email'=>$emailaddr,'login'=>$logintype));
$redis->expire($redis_key, 30);
livechatController::$dbase = $db;
livechatController::set_userdata($emailaddr, $logintype);
// redirect to new html/js chat interface
header("Location: $hostname/livechat/rschat.php?hash=".$hash_code);
exit;
