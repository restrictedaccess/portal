<?php
include ('../conf/zend_smarty_conf.php');
require_once "fb/facebook.php";
if (TEST){
	$fbconfig['appUrl'] = "http://test.remotestaff.com.au/portal/fb_register/"; 
	
}else{
	$fbconfig['appUrl'] = "https://apps.facebook.com/remotestaff_register/"; 
	
}
$smarty =  new Smarty();
$facebook = new Facebook(array(
  'appId'  => '141234452753604',
  'secret' => '4e473f2c006ae4adea347deb85f845c0',
));
// Get User ID
$user = $facebook->getUser();
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	//$email = $facebook->api("/me/email");
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// If the user is authenticated then generate the variable for the logout URL
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();  
} else {
  $loginUrl = $facebook->getLoginUrl(array('redirect_uri' => $fbconfig['appUrl'],"scope"=>array("email", "user_birthday","user_about_me")
  ));
 print "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
}
if (isset($_REQUEST["error"])){
	$smarty->assign("error", $_REQUEST["error"]);
}

foreach($_REQUEST as $key=>$val){
	$smarty->assign($key, $val);
}

$internet_connection_list = array("PLDT MyDSL", "PLDT WeRoam Wireless", "BayanTel DSL", "Globelines Broadband", "Globelines Wireless/WiMax/Tattoo", "Smart Bro Wireless", "Sun Broadband Wireless", "Others");
$smarty->assign("internet_connection_list", $internet_connection_list);
$smarty->assign("user_profile", $user_profile);
$smarty->display("index.tpl");
