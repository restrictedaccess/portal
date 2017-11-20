<?php
//2011-02-22    Lawrence Sunglao<lawrence.sunglao@remotestaff.com.au>
//  -   provide redirect for subcons from php environment to django
include('../conf/zend_smarty_conf.php');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$userid = $_SESSION['userid'];


if($userid == '') {
    header("location:/portal/index.php");
    exit;
}


//get redirect parameter

$redirect1 = trim($_GET["redirect1"]);
$redirect2 = trim($_GET["redirect2"]);

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
        'session_data' => sprintf('userid=%s', $userid),
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

#redirect to django with the random string
header(sprintf("location:%s%s", $redirect1, $random_string));

?>