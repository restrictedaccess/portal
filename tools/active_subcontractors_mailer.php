<?php
//  2010-03-09  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   One time script sending notifications to all active clients regarding activity tracker notes

require_once('../conf/zend_smarty_conf.php');
require_once('../lib/validEmail.php');
if($_SESSION['admin_id']=="") {
	header("location:../index.php");
}

$sql = $db->select()
    ->from(array('s' => 'subcontractors'), Null)
    ->distinct()
    ->joinLeft(array('l' => 'leads'), 's.leads_id = l.id', array('email', 'fname', 'lname'))
    ->where('s.status = "ACTIVE"');
$data = $db->fetchAll($sql);

foreach ($data as $client) {

    //get clients email address
    $client_email = trim($client['email']);
    if (validEmailv2($client_email) == False) {
        echo sprintf('invalid email from %s %s "%s"<br/>', $client['fname'], $client['lname'], $client['email']);
        continue;
    }

    //create a smarty object
    $smarty = New Smarty();
    $smarty->register_modifier('ss', 'stripslashes');
    $smarty->assign('client', $client);
    $output = $smarty->fetch('active_subcontractors_mailer.tpl');


    //send the mail
    $mail = new Zend_Mail();
    $mail->setBodyHtml($output);

    if (TEST) {
        $client_email = 'devs@remotestaff.com.au';
    }
    else {
        $mail->addBcc('may@remotestaff.com.au'); 
        $mail->addBcc('lawrence.sunglao@remotestaff.com.au');
    }

    $mail->addTo($client_email);
    $mail->setFrom('clientactivitynotes@remotestaff.com.au', 'The Remote Staff Team');
    $mail->setSubject('REMOTE STAFF DAILY ACTIVITY NOTES E-MAILS'); 
    $mail->send($transport);

echo sprintf('sending email to %s %s %s<br/>', $client['fname'], $client['lname'], $client['email']);
}


?>
