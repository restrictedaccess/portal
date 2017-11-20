<?php
//2010-03-12 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Strip slashes on reason, add the note to the timesheet_notes_admin table as well
//  -   send an email with the same format on the time sheet
//2009-08-17 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial hack forces a staff to timeout

require('../conf/zend_smarty_conf.php');
require('ds_validate_admin.php');

$timerecord_id = $_POST['timerecord_id'];
$reason = stripslashes($_POST['reason']);
$date_time = $_POST['date_time'];
$userid = $_POST['userid'];
$admin_id = $_SESSION['admin_id'];

$now = new Zend_Date();

//insert record on timerecord_notes
$data = array(
    'timerecord_id' => $timerecord_id,
    'userid' => $userid,
    'posted_by_id' => $admin_id,
    'posted_by_type' => 'admin',
    'note' => "Forced Timeout: $reason",
    'note_type' => 'unique'
);

$db->insert('timerecord_notes', $data);

//update timerecord table
$data = array(
    'time_out' => $date_time
);

$db->update('timerecord', $data, "id = $timerecord_id");

//update activity_tracker table
$data = array(
    'status' => 'not working',
    'leads_name' => '',
    'subcontractors_id' => null,
    'leads_id' => null
);

$db->update('activity_tracker', $data, "userid = $userid");

//add note on timesheet_notes_admin
//grab the timerecord data
$sql = $db->select()
        ->from('timerecord')
        ->where('id = ?', $timerecord_id);

$timerecord = $db->fetchRow($sql);
$time_in = $timerecord['time_in'];
$leads_id = $timerecord['leads_id'];
$userid = $timerecord['userid'];
$subcontractors_id = $timerecord['subcontractors_id'];
$time_in_date = new Zend_Date($time_in, "YYYY-MM-dd");

//check from the timesheet table if month_year and leads_id exist for this staff
$sql = $db->select()
        ->from('timesheet', 'id')
        ->where('userid = ?', $userid)
        ->where('leads_id = ?', $leads_id)
        ->where('subcontractors_id = ?', $subcontractors_id)
        ->where('status != "deleted"')
        ->where('month_year = ?', $time_in_date->toString("yyyy-MM-01"));

$timesheet_id = $db->fetchOne($sql);
if ($timesheet_id) {
    //timesheet found, 
    //search for the timesheet_details id to add note on the timesheet_notes_admin table
    $sql = $db->select()
            ->from('timesheet_details', 'id')
            ->where('timesheet_id = ?', $timesheet_id)
            ->where('day = ?', $time_in_date->toString('d'));
    $timesheet_details_id = $db->fetchOne($sql);

    if($timesheet_details_id) {
        //add note
        $data = array(
            'timesheet_details_id' => $timesheet_details_id,
            'admin_id' => $admin_id ,
            'timestamp' => $now->toString('yyyy-MM-dd HH:mm:ss'),
            'note' => "Forced Timeout: $reason",
        );
        $db->insert('timesheet_notes_admin', $data);

        //send an email
        $sql = $db->select()
            ->from('leads', array('fname','lname'))
            ->where('id = ?', $leads_id);

        $client = $db->fetchRow($sql);
        $client_fname = $client['fname'];
        $client_lname = $client['lname'];

        //mail to user and admins
        //grab all admin emails
        $sql = $db->select()
            ->from('admin', array('admin_email'))
            ->where('notify_timesheet_notes = "Y"')
            ->where('status != "REMOVED"');
        $emails = $db->fetchAll($sql);

        //grab subcon details
        $sql = $db->select()
            ->from('personal', array('fname', 'lname', 'email'))
            ->where('userid = ?', $userid);
        $personal = $db->fetchRow($sql);
        $subcon_fname = $personal['fname'];
        $subcon_lname = $personal['lname'];
        $subcon_email = trim($personal['email']);

        $sql = $db->select()
            ->from('admin', array('admin_fname', 'admin_lname', 'admin_email'))
            ->where('admin_id = ?', $admin_id);
        $admin_data = $db->fetchRow($sql);
        $admin_fname = $admin_data['admin_fname'];
        $admin_lname = $admin_data['admin_lname'];

        $subject = "New Timesheet Note for : $subcon_fname $subcon_lname";
        $date_str = $now->toString('yyyy-MM-dd hh:mm a z');
        $message = "Timesheet Month: $timesheet_month_str\r\nTimesheet Day: $timesheet_day\r\nDate/Time noted: $date_str\r\nClient: $client_fname $client_lname\r\nNoted by: $admin_fname $admin_lname\r\n\r\nNote: Forced Timeout - $reason";

        $mail = new Zend_Mail();
        $mail->setBodyText($message);
        $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
        $mail->setSubject($subject);

        if (TEST) {
                $mail->addTo('devs@remotestaff.com.au');
        }
        else {
            if (validEmail($subcon_email)) {
                $mail->addTo($subcon_email);
            }

            foreach ($emails as $email) {
                $admin_email = trim($email['admin_email']);
                if (validEmail($admin_email)) {
                    $mail->addBcc($admin_email);
                }
            }
        }

        $mail->send($transport);
    }
}

$smarty = new Smarty();
$smarty->assign('status', 'ok');
$smarty->assign('message', 'Successfully updated time record.');


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Content-type: text/xml");
$smarty->display('response.tpl');

?>
