<?php
    //2010-02-19 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  stripped slashes on activity note
    //2009-05-14 Lawrence Sunglao <locsunglao@yahoo.com>
    //  bug fix on activity note interval
    require_once('../zend_conf.php');

    if ($_POST) {
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $activity = stripslashes(trim($_POST['activity']));

        $status = 'OK';
        $message = 'Not defined';
        $alert_title = '';
        $alert_message = '';
        $now = new DateTime();

        $personal_id = $db->fetchOne('SELECT userid from personal where email = ? and pass = ?', array($email, $password));
        if ($personal_id == null) {
            $status = 'ERROR';
            $message = 'Username / password does not match!';
        }

        //check activity
        if ($activity == '') {
            $status = 'ERROR';
            $message = 'Empty input.';
            $alert_title = 'Empty input.';
            $alert_message = 'Please fill up the form properly.';
        }

        //get record from activity_tracker table
        if ($status == 'OK') {
            $activity_tracker = $db->fetchRow('SELECT * from activity_tracker where userid = ?', $personal_id);
            $activity_tracker_status = $activity_tracker['status'];
        }

        //process only when staff is in working status
        if ($activity_tracker_status == 'working') {
            //get client name
            $activity_tracker = $db->fetchRow('SELECT * from activity_tracker where userid = ?', $personal_id);
            $message = sprintf("Working for %s.", $activity_tracker['leads_name']);
            $activity_note_interval = $activity_tracker['activity_note_interval'];

            //insert record on activity_tracker_notes
            $last_activity_note_time = new DateTime($activity_tracker['last_activity_note_time']);
            $expected_time = clone($last_activity_note_time);
            $expected_time->modify("+$activity_note_interval seconds");
            $data = array(
                'userid' => $personal_id,
                'leads_id' => $activity_tracker['leads_id'],
                'subcontractors_id' => $activity_tracker['subcontractors_id'],
                'expected_time' => $expected_time->format('Y-m-d H:i:s'),
                'checked_in_time' => $now->format('Y-m-d H:i:s'),
                'note' => $activity,
            );
            $db->insert('activity_tracker_notes', $data);

            //connectivity status
            $last_machine_reported_time = new DateTime($activity_tracker['last_machine_reported_time']);
            $machine_lag = $now->format('U') - $last_machine_reported_time->format('U');
            if ($machine_lag > INTERNET_CONNECTION_LAG) {
                $data = array(
                    'userid' => $personal_id,
                    'leads_id' => $activity_tracker['leads_id'],
                    'subcontractors_id' => $activity_tracker['subcontractors_id'],
                    'last_seen' => $activity_tracker['last_machine_reported_time'],
                    'reported_time' => $now->format('Y-m-d H:i:s')
                );
                $db->insert('internet_connection_log', $data);
            }

            //update activity_tracker
            $data = array(
                'last_machine_reported_time' => $now->format('Y-m-d H:i:s'),
                'last_activity_note_time' => $now->format('Y-m-d H:i:s')
            );
            $n = $db->update('activity_tracker', $data, "userid = $personal_id");

        }
        

        $data = array('status' => $status, 
            'message' => $message,
            'alert_title' => $alert_title,
            'alert_message' => $alert_message
        );

        $output = json_encode($data);
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header('Content-type: text/plain');
        echo $output;
        exit;
    }
?>
<form method="POST" action=<?php echo $_SERVER['PHP_SELF'] ?>>
<label for="user">User</label><input type="text" name="email" id="email"></input>
<br/>
<label for="password">Password</label><input type="password" name="password" id="password"></input>
<br/>
<label for="activity">Activity</label><textarea name="activity" id="activity"></textarea>
<br/>
<input type="submit"/>
</form>
