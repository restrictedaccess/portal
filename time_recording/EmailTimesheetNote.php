<?php
/**
*
* Sends emails to the admin and the user
*
*/
//2009-11-13 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  check notify_timesheet_notes field on admin table for sending timesheet note emails
//  use zend_smarty_conf.php for database access and email stuff
//2009-08-03 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  removed debug statements
//2009-08-03 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  prevent invalid emails

include('../lib/validEmail.php');
include('../conf/zend_smarty_conf.php');

function EmailTimesheetNote($subcon_email, $subject, $message) {

    global $db, $transport;
    //send email to staff
    if (validEmail($subcon_email)) {
        $mail = new Zend_Mail();
        $mail->setBodyText($message);
        $mail->addTo($subcon_email);
        $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
        $mail->setSubject($subject);
        $mail->send($transport);
    }

    //grab all admin emails
    $sql = $db->select()
        ->from('admin', array('admin_email'))
        ->where('notify_timesheet_notes = "Y"');
    $emails = $db->fetchAll($sql);

    foreach ($emails as $email) {
        $admin_email = $email['admin_email'];
        if (validEmail($admin_email)) {
            $mail = new Zend_Mail();
            $mail->setBodyText($message);
            $mail->addTo($admin_email);
            $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
            $mail->setSubject($subject);
            $mail->send($transport);
        }
    }


}
?>
