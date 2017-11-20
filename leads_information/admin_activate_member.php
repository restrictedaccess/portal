<?php
//2011-02-22    Lawrence Sunglao<lawrence.sunglao@remotestaff.com.au>
//  -   provide redirect for admins from php environment to django
include('../conf/zend_smarty_conf.php');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$admin_id = $_SESSION['admin_id'];
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($admin_id == '') {
    header("location:../index.php");
    exit;
}

//$leads_id = $_REQUEST['leads_id'];

//check if the lead is already a member
$sql = $db->select()
    ->from('member', 'id')
	->where('leads_id =?', $_REQUEST['leads_id']);
$member_id = $db->fetchOne($sql);

if($member_id == ""){
	$data=array('leads_id' => $_REQUEST['leads_id'], 'datecreated' => $ATZ);
	$db->insert('member', $data);
	
	//add lead history
	$data = array(
		'leads_id' => $_REQUEST['leads_id'], 
		'date_change' => $ATZ, 
		'changes' => 'Membership Activated', 
		'change_by_id' => $admin_id, 
		'change_by_type' => 'admin'
	);
	$db->insert('leads_info_history', $data);
}


$url=sprintf("/portal/AdminRunningBalance/RunningBalance.html?client_id=%s", $_REQUEST['leads_id']);
header(sprintf("location:%s", $url));
exit;
/*
$redirect1 = '/portal/django/admin_activate_member/session_transfer/';
$redirect2 = '/portal/django/admin_activate_member/'.$leads_id;

if ($redirect1 == '') {
    die('expecting a GET redirect1 argument');
}

if ($redirect2 == '') {
    die('expecting a GET redirect2 argument');
}

function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    // Length of character list
    $chars_length = strlen($chars);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i++) {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        $string = $string . $r;
    }
   
    // Return the string
    return $string;
}

$now = new Zend_Date();

$random_string_exists = True;
while ($random_string_exists) {
    $random_string = rand_str();
    $data = array(
        'random_string' => $random_string,
        'date_created' => $now->toString("yyyy-MM-dd HH:mm:ss"),
        'session_data' => sprintf('admin_id=%s', $admin_id),
        'redirect' => $redirect2
    );

    try {
        $db->insert('django_session_transfer', $data);
        $random_string_exists = False;
    }
    catch (Exception $e) {
        $random_string_exists = True;
    }
}
//echo $redirect1.$random_string;
//exit;
#redirect to django with the random string
header(sprintf("location:%s%s", $redirect1, $random_string));
exit;
*/
?>