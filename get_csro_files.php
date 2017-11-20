<?php
//2011-07-28 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   initial release 
//  -   log and secure access to csro files
//  -   only rica and tam has access to "Credit card form" and 
//  "Direct debit form"

include('conf/zend_smarty_conf.php');

define(EMAIL_ADD_ALERT, 'devs@remotestaff.com.au');  //TODO update
$CC_DB_ALLOW_ADMIN_IDS = array(6, 19);    //rica and tam

//check if we have a get file_id parameter
$file_id = $_GET['file_id'];
if ($file_id == '') {
    die('missing file_id');
}

//check if admin_id session exists
$admin_id = $_SESSION['admin_id'];
if($admin_id == ''){
    //get ip address, send an email to devs
    if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        $ip = sprintf("HTTP_X_FORWARDED_FOR %s %s", $ip, $_SERVER['REMOTE_ADDR']);
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $mail = new Zend_Mail();
    $mail->setBodyText(sprintf("IP Address %s trying to access csro_files with file_id %s.", $ip, $file_id));
    $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
    $mail->addTo(EMAIL_ADD_ALERT);
    $mail->setSubject("CSRO FILE ACCESS ALERT");
    $mail->send($transport);
    header("HTTP/1.0 403 Forbidden");
    exit("forbidden\n");
}

//get record from csro_files table
$sql = $db->select()
    ->from('csro_files')
    ->where('id = ?', $file_id);

$result = $db->fetchRow($sql);

//record not found
if (!$result) {
    $mail = new Zend_Mail();
    $mail->setBodyText(sprintf("admin_id %s is trying to access %s. A non-existing id.", $admin_id, $file_id));
    $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
    $mail->addTo(EMAIL_ADD_ALERT);
    $mail->setSubject("CSRO FILE ACCESS ALERT");
    $mail->send($transport);
    header("HTTP/1.0 404 Not Found");
    exit("not found\n");
}

$file_name = $result['name'];
$file_path = sprintf("uploads/csro_files/%s", $file_name);
if (!file_exists($file_path)) {
    $mail = new Zend_Mail();
    $mail->setBodyText(sprintf("admin_id %s is trying to access %s. A non-existing file.", $admin_id, $file_name));
    $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
    $mail->addTo(EMAIL_ADD_ALERT);
    $mail->setSubject("CSRO FILE ACCESS ALERT");
    $mail->send($transport);
    header("HTTP/1.0 404 Not Found");
    exit("not found\n");
}

//check if its a cc/dd form
$type = $result['type'];
if (in_array($type, array("Credit card form", "Direct debit form"))) {
    if (in_array($admin_id, $CC_DB_ALLOW_ADMIN_IDS) == False) {
        $mail = new Zend_Mail();
        $mail->setBodyText(sprintf("admin_id %s is trying to access %s. A Credit card/Direct debit form.", $admin_id, $file_name));
        $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
        $mail->addTo(EMAIL_ADD_ALERT);
        $mail->setSubject("CSRO FILE ACCESS ALERT");
        $mail->send($transport);
        header("HTTP/1.0 403 Forbidden");
        exit("forbidden\n");
    }
}

//log access
$now = new Zend_Date();
$data = array(
    'admin_id' => $admin_id,
    'csro_files_id' => $file_id,
    'date_time' => $now->toString('yyyy-MM-dd HH:mm:ss')
);
$db->insert('csro_files_access_log', $data);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($file_path));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));
ob_clean();
flush();
readfile($file_path);

?>
