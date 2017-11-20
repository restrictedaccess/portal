<?php
    //2010-01-26 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //   -disable users if they dont have records in subcontractors table
    //2009-02-27 Lawrence Sunglao <locsunglao@yahoo.com>
    //   -added activity note tracker
    //   -include working status as well as available clients
    //2009-02-13 Lawrence Sunglao <locsunglao@yahoo.com>
    //   -copied from login.php

    require_once('../zend_conf.php');

    if ($_POST) {
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $client_version = $_POST['client_version'];
        $activity_note_interval_post = $_POST['activity_note_interval'];
        $status = 'OK';
        $message = 'Not defined';
        $subcontractor_list = array();
        $locked = 'N';

        $activity_note_interval = 1200; //default value is 20 mins
        if ($activity_note_interval_post == '1') {
            $activity_note_interval = 1800; //set to 30 mins
        }

        //version check!
        if ($client_version != CLIENT_VERSION) {
            $status = 'ERROR';
            $message = 'Please upgrade to the current version by downloading from our home page.';
        }

        //password check
        if ($status == 'OK') {
            $personal_id = $db->fetchOne('SELECT p.userid from personal as p join subcontractors as s on p.userid = s.userid where p.email = ? and p.pass = ? and s.status="ACTIVE"', array($email, $password));
            if ($personal_id == null) {
                $status = 'ERROR';
                $message = 'Invalid Login!';
            }
            else {
                $message = 'Activity tracker is ready.';

                //check if personal_id is already on activity_tracker table
                $activity_tracker_record = $db->fetchAll('SELECT * from activity_tracker where userid = ?', $personal_id);
                if (count($activity_tracker_record) == 0) {
                    //no records found, add record on activity_tracker
                    $data = array(
                        'userid' => $personal_id,
                        'activity_note_interval' => $activity_note_interval
                    );
                    $db->insert('activity_tracker', $data);
                }
                else {
                    $data = array(
                        'activity_note_interval' => $activity_note_interval
                    );
                    $x = $db->update('activity_tracker', $data, "userid = $personal_id");
                }

                //grab subcontractors id,posting_id,details,starting_hours,ending_hours with leads fname,lname,company_name
                $select = $db->select()
                    ->from('activity_tracker')
                    ->where('status is not NULL')
                    ->where('status != "not working"')
                    ->where('userid = ?', $personal_id);

                $activity_tracker = $db->fetchAll($select);

                if (count($activity_tracker) == 0){
                    $locked = 'N';
                }
                else {
                    $locked = 'Y';
                }
                $select = $db->select()
                ->from(array('s' => 'subcontractors'),
                    array('id', 'posting_id', 'details', 'starting_hours', 'ending_hours'))
                ->join(array('l' => 'leads'),
                    's.leads_id = l.id',
                    array('fname', 'lname', 'company_name'))
                ->where('s.userid = ?', $personal_id)
                ->where('s.status = ?', 'ACTIVE');

                $subcontractor_list = $db->fetchAll($select);
            }
        }

        $data = array(
            'status' => $status, 
            'message' => $message, 
            'seconds_poll_interval' => SECONDS_POLL_INTERVAL, 
            'client_version' => CLIENT_VERSION,
            'subcontractor_list' => $subcontractor_list,
            'locked' => $locked,
            'personal_id' => $personal_id
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
<label for="user_type">Version</label><input type="text" name="client_version" id="client_version"></input>
<br/>
<input type="submit"/>
</form>
