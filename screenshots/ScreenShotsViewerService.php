<?php
//  2013-09-23 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   used $db_query_only variable
//  2011-05-02 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on sorting
//  2009-01-07 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack
require('../conf/zend_smarty_conf.php');


class LoginAdmin {
    public function login($email, $password) {
        global $db_query_only, $logger_admin_login;
        $password = sha1($password);
        $sql = $db_query_only->select()
                ->from('admin')
                ->where('admin_email = ?', $email)
                ->where('admin_password = ?', $password);
        $result = $db_query_only->fetchAll($sql);
        if (count($result) == 0) {
            $details = sprintf("FAILED %s %s %s'", $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $email);
            $logger_admin_login->info("$details");
            return 'Invalid Login';
        }
        $details = sprintf("LOGIN %s %s %s'", $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $email);
        $logger_admin_login->info("$details");
        $_SESSION['admin_id'] =$result[0]['admin_id']; 
        $_SESSION['status'] =$result[0]['status']; 
        return "OK";
    }
}


class ScreenShotViewer {
    function __construct() {
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            throw new Exception('Please Login');
        }
        $this->admin_id = $admin_id;
    }


    private function get_days() {
        $available_days = Array();

        $ph_tz = new DateTimeZone('Asia/Manila');
        $now = new DateTime();
        $now->setTimezone($ph_tz);
        $available_days['Today'] = $now->format('Y-m-d');

        $now->modify("-1 days");
        $available_days['Yesterday'] = $now->format('Y-m-d');

        for ($i = 0; $i < 5; $i++) {
            $now->modify("-1 days");
            $available_days[$now->format('l')] = $now->format('Y-m-d');
        }

        return $available_days;
    }


    private function get_staff() {
        global $db_query_only;
        $sql = $db_query_only->select()
                ->distinct()
                ->from(array('s' => 'subcontractors'), 'userid')
                ->joinLeft(array('p' => 'personal'), 's.userid = p.userid', array('fname', 'lname'))
                ->where('s.status = "ACTIVE"')
                ->order('p.fname')
                ->order('p.lname');
        return $db_query_only->fetchAll($sql);
    }


    public function get_staff_and_days() {
        return Array(
            'available_days' => $this->get_days(),
            'staff' => $this->get_staff()
        );
    }


    private function get_staff_activity_tracker_status($userid) {
        global $db_query_only;
        $sql = $db_query_only->select()
                ->from('activity_tracker', array('last_machine_reported_time', 'last_activity_note_time', 'subcontractors_id', 'leads_id', 'leads_name', 'status'))
                ->where('userid = ?', $userid);
        return $db_query_only->fetchRow($sql);
    }

    
    public function get_screenshots($timezone, $date, $userid) {
        global $db_query_only;
        
        $asia_manila_tz = new DateTimeZone('Asia/Manila');
        $selected_tz = new DateTimeZone($timezone);

        $max_date = new DateTime($date, $selected_tz);    //date reference

        $max_date->setTime(23, 59, 59);
        $min_date = clone($max_date);
        $min_date->setTime(0, 0, 0);

        //set it back to asia manila timezone
        $max_date ->setTimezone($asia_manila_tz);
        $min_date ->setTimezone($asia_manila_tz);
        $sql = $db_query_only->select()
                ->from('screenshots', array('id','post_time'))
                ->where('userid = ?', $userid)
                ->where(sprintf('post_time BETWEEN "%s" AND "%s"', $min_date->format('Y-m-d H:i:s'), $max_date->format('Y-m-d H:i:s')))
                ->order('post_time');
        $screenshots = $db_query_only->fetchAll($sql);

        //get all activity_tracker_notes
        $sql = $db_query_only->select()
                ->from('activity_tracker_notes')
                ->where('userid = ?', $userid)
                ->where(sprintf('checked_in_time BETWEEN "%s" AND "%s"', $min_date->format('Y-m-d H:i:s'), $max_date->format('Y-m-d H:i:s')));

        $notes = $db_query_only->fetchAll($sql);

        //loop over screenshots and add the display timezone
        for ($i = 0; $i < count($screenshots); $i++) {
            $screenshot_date = new DateTime($screenshots[$i]['post_time'], $asia_manila_tz);
            $screenshot_date->setTimezone($selected_tz);
            $screenshots[$i]['display_time'] = $screenshot_date->format('Y-m-d H:i:s');

            $post_time = strtotime($screenshots[$i]['post_time']);
            $note_time = strtotime($notes[0]['checked_in_time']);
            $time_diff = $post_time - $note_time;
            if ($time_diff < 0) {
                $time_diff *= -1;   //always positive
            }
            $screenshots[$i]['note'] = $notes[0]['note'];
            $secs_interval = strtotime($notes[0]['checked_in_time']) - strtotime($notes[0]['expected_time']);
            $time_to_respond = new DateTime('2010-01-01 00:00:00');
            $time_to_respond->modify(sprintf('+%s sec', $secs_interval));
            $screenshots[$i]['time_to_respond'] = $time_to_respond->format('H:i:s');

            $expected_time = new DateTime($notes[$j]['expected_time']);
            $expected_time->setTimezone($selected_tz);
            $screenshots[$i]['expected_time'] = $expected_time->format('H:i:s');

            //bubble sort - loop over notes
            for ($j = 1; $j < count($notes) - 1; $j++) {
                $note_time = strtotime($notes[$j]['checked_in_time']);
                $new_time_diff = $post_time - $note_time;
                if ($new_time_diff < 0) {
                    $new_time_diff *= -1;   //always positive
                }

                if ($new_time_diff < $time_diff) {
                    $time_diff = $new_time_diff;
                    $screenshots[$i]['note'] = $notes[$j]['note'];
                    $secs_interval = strtotime($notes[$j]['checked_in_time']) - strtotime($notes[$j]['expected_time']);
                    $time_to_respond = new DateTime('2010-01-01 00:00:00');
                    $time_to_respond->modify(sprintf('+%s sec', $secs_interval));
                    $screenshots[$i]['time_to_respond'] = $time_to_respond->format('H:i:s');
                }
            }

            unset($screenshots[$i]['post_time']);   //removed to improve data transfer
        }

        return Array(
            'userid' => $userid,
            'screenshots' => $screenshots,
            'staffs_current_status' => $this->get_staff_activity_tracker_status($userid),
        );
    }
}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
if ($method == 'login') {
    $server->setClass('LoginAdmin');
}
else {
    $server->setClass('ScreenShotViewer');
}
$server->handle();
?>
