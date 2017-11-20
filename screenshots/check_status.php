<?php
    //2010-11-09 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  updated to the newest RSSC version, disabling the old ones
    //2009-12-18 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  - Add email activity note tracker to client on logout
    //2009-05-14 Lawrence Sunglao <locsunglao@yahoo.com>
    //  - fix take_screen_shot when user is on quick break
    //2009-03-02 Lawrence Sunglao <locsunglao@yahoo.com>
    //  - include toilet breaks
    //2009-02-27 Lawrence Sunglao <locsunglao@yahoo.com>
    //  - use the variable activity_note_interval on activity_tracker table
    die();
    require_once('../zend_conf.php');
    require_once('../time_recording/ActivityNotesMailer.php');

    if ($_POST) {
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $break_type = $_POST['break_type'];
        $start_work = $_POST['start_work'];
        $finish_work = $_POST['finish_work'];
        $subcontractors_id = $_POST['subcontractors_id'];

        $status = 'OK';
        $message = 'Not Working.';
        $take_screen_shot = 'N';
        $get_activity_note = 'N';
        $screen_capture_status = 'N';
        $activity_tracker_status = 'not working';
        $break_status = '';
        $widget_status = array(
            'button_start_work' => False,
            'button_finish_work' => False,
            'button_quick_break' => True,
            'button_lunch_break' => False,
            'choice_select_client' => False 
        );
        $alert_title = '';      //future use?
        $alert_message = '';    //future use?
        $now = new DateTime();

        $personal_id = $db->fetchOne('SELECT userid from personal where email = ? and pass = ?', array($email, $password));
        if ($personal_id == null) {
            $status = 'ERROR';
            $message = 'Username / password does not match!';
        }

        //get record from activity_tracker table
        if ($status == 'OK') {
            $activity_tracker = $db->fetchRow('SELECT * from activity_tracker where userid = ?', $personal_id);
            $activity_tracker_status = $activity_tracker['status'];
        }

        //process only when staff is in working status
        $possible_status = array('working', 'quick break');
        if (in_array($activity_tracker_status, $possible_status)) {

            //get client name
            $message = sprintf("Working for %s.", $activity_tracker['leads_name']);
            $screen_capture_status = 'Y';

            //check if we need to take a screenshot
            $last_snapshot_time = new DateTime($activity_tracker['last_snapshot_time']);
            $screenshot_time_delta = $now->format('U') - $last_snapshot_time->format('U');
            if ($screenshot_time_delta > SCREEN_SHOT_INTERVAL) {
                $take_screen_shot = 'Y';
            }
            else {
                //instant snapshot requested!
                $take_screen_shot = $activity_tracker['request_snapshot'];
            }

            //check if we need to get activity note
            $last_activity_note_time = new DateTime($activity_tracker['last_activity_note_time']);
            $activity_time_delta = $now->format('U') - $last_activity_note_time->format('U');
            $activity_note_interval = $db->fetchOne('SELECT activity_note_interval from activity_tracker where userid = ?', $personal_id);
            //get activity note only when tracker status is working???
            if (($activity_time_delta > $activity_note_interval) and ($activity_tracker_status == 'working')) {
                $get_activity_note = 'Y';
            }

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
                'last_machine_reported_time' => $now->format('Y-m-d H:i:s')
            );
            $n = $db->update('activity_tracker', $data, "userid = $personal_id");
        }

        //process quick breaks
        if ($break_type == 'quick') {
            if ($activity_tracker_status == 'working') {
                //add record to activity_tracker_breaks
                $data = array(
                    'userid' => $activity_tracker['userid'],
                    'leads_id' => $activity_tracker['leads_id'],
                    'subcontractors_id' => $activity_tracker['subcontractors_id'],
                    'start' => $now->format('Y-m-d H:i:s'),
                    'type' => $break_type
                );
                $db->insert('activity_tracker_breaks', $data);

                //update activity_tracker table
                if ($break_type == 'quick') {
                    $new_status = 'quick break';
                }
                $data = array(
                    'status' => $new_status
                );
                $db->update('activity_tracker', $data, "userid = $personal_id");
                $activity_tracker_status = $new_status;
                $activity_tracker['status'] = $new_status;
            }

            else {  //activity_tracker_status is not working
                $data = array(
                    'end' => $now->format('Y-m-d H:i:s')
                );
                $db->update('activity_tracker_breaks', $data, "userid = $personal_id and end is NULL");

                $data = array(
                    'status' => 'working',
                    'last_snapshot_time' => $now->format("Y-m-d H:i:s"),
                    'last_machine_reported_time' => $now->format("Y-m-d H:i:s"),
                    'last_activity_note_time' => $now->format("Y-m-d H:i:s")
                );
                $db->update('activity_tracker', $data, "userid = $personal_id");
                $activity_tracker_status = 'working';
                $activity_tracker['status'] = 'working';
            }
        }

        //process lunch break
        if ($break_type == 'lunch') {
            //check lunch break record on timerecord table if no entry with time_out set to null add new record
            //verify first if timerecord has mode='regular' and time_out IS NULL
            //check for the button_lunch_break
            $sql = $db->select()
                ->from('timerecord', 'time_in')
                ->where('mode = "regular"')
                ->where('userid = ?', $personal_id)
                ->where('time_out is NULL')
                ->order('time_in DESC')
                ->limit('1');

            $time_in = $db->fetchOne($sql);

            if ($time_in != null) {
                $sql = $db->select()
                    ->from('timerecord')
                    ->where('mode = "lunch_break"')
                    ->where('userid = ?', $personal_id)
                    ->where('time_in >= ?', $time_in)
                    ->order('time_in DESC');

                $lunch_break_records = $db->fetchAll($sql);
                if (count($lunch_break_records) == 0) {
                    //add lunch record on timerecord table
                    $data = array(
                        'userid' => $personal_id,
                        'leads_id' => $activity_tracker['leads_id'],
                        'subcontractors_id' => $activity_tracker['subcontractors_id'],
                        'time_in' => $now->format("Y-m-d H:i:s"),
                        'mode' => 'lunch_break'
                    );
                    $db->insert('timerecord', $data);

                    //update activity_tracker table
                    $data = array('status' => 'lunch break');
                    $db->update('activity_tracker', $data, "userid = $personal_id");
                    $activity_tracker_status = 'lunch break';
                    $activity_tracker['status'] = 'lunch break';

                }
                elseif ($lunch_break_records[0]['time_out'] == null) {
                    $data = array('time_out' => $now->format("Y-m-d H:i:s"));
                    $id = $lunch_break_records[0]['id'];
                    $db->update('timerecord', $data, "id = $id");

                    //update activity_tracker table
                    $data = array(
                        'status' => 'working',
                        'last_snapshot_time' => $now->format("Y-m-d H:i:s"),
                        'last_machine_reported_time' => $now->format("Y-m-d H:i:s"),
                        'last_activity_note_time' => $now->format("Y-m-d H:i:s")
                    );
                    $db->update('activity_tracker', $data, "userid = $personal_id");
                    $activity_tracker_status = 'working';
                    $activity_tracker['status'] = 'working';
                }

            }

        }
        
        //process widget_status
        if ($activity_tracker_status == 'working') {
            $widget_status['button_start_work'] = False;
            $widget_status['button_finish_work'] = True;
            $widget_status['button_quick_break'] = True;

            //check for the button_lunch_break
            $sql = $db->select()
                ->from('timerecord', 'time_in')
                ->where('mode = "regular"')
                ->where('userid = ?', $personal_id)
                ->where('time_out is NULL')
                ->order('time_in DESC')
                ->limit('1');

            $time_in = $db->fetchOne($sql);
            if ($time_in != null) {
                $sql = $db->select()
                    ->from('timerecord')
                    ->where('mode = "lunch_break"')
                    ->where('userid = ?', $personal_id)
                    ->where('time_in >= ?', $time_in);

                $lunch_break_records = $db->fetchAll($sql);
                if (count($lunch_break_records) == 0) {
                    $widget_status['button_lunch_break'] = True;
                }
                else {
                    $widget_status['button_lunch_break'] = False;
                }

                if ($finish_work == 'Y') {
                    $sql = $db->select()
                        ->from('timerecord', 'id')
                        ->where('mode = "regular"')
                        ->where('userid = ?', $personal_id)
                        ->where('time_out is NULL')
                        ->order('time_in DESC')
                        ->limit('1');

                    $timerecord_id = $db->fetchOne($sql);
                    $data = array(
                        'time_out' => $now->format('Y-m-d H:i:s')
                    );

                    $db->update('timerecord', $data, "id = $timerecord_id");  

                    //sends email upon logout if its set by client
                    $activity_notes_mailer = new ActivityNotesMailer($timerecord_id);
                    $activity_notes_mailer->Logout();

                    //update activity_tracker
                    $data = array(
                        'last_machine_reported_time' => $now->format('Y-m-d H:i:s'),
                        'subcontractors_id' => null,
                        'leads_id' => null,
                        'leads_name' => '',
                        'status' => 'not working'
                    );
                    $n = $db->update('activity_tracker', $data, "userid = $personal_id"); 

                    $activity_tracker_status = 'not working';
                    $activity_tracker['status'] = 'not working';
                    $message = 'Not Working.';
                
                }
            }

        }

        if (($activity_tracker_status == null) or ($activity_tracker_status == 'not working')) {
            $widget_status['button_start_work'] = True;
            $widget_status['button_finish_work'] = False;
            $widget_status['button_quick_break'] = False;
            $widget_status['button_lunch_break'] = False;
            $widget_status['choice_select_client'] = True;
            $take_screen_shot = 'N';
            $screen_capture_status = 'N';
            if ($start_work == 'Y') {
                if ($subcontractors_id == ''){
                    $status = "ERROR";
                    $message = 'Missing value on subcontractor id';
                }
                else {
                    //get leads_id, posting_id for timerecord
                    $sql = $db->select()
                        ->from('subcontractors')
                        ->where('id = ?', $subcontractors_id);

                    $subcontractors_record = $db->fetchRow($sql);

                    //get leads record
                    $sql = $db->select()
                        ->from('leads')
                        ->where('id = ?', $subcontractors_record['leads_id']);
                    $leads_record = $db->fetchRow($sql);

                    //insert record on timerecord table
                    $data = array(
                        'userid' => $personal_id,
                        'leads_id' => $subcontractors_record['leads_id'],
                        'posting_id' => $subcontractors_record['posting_id'],
                        'subcontractors_id' => $subcontractors_id,
                        'time_in' => $now->format("Y-m-d H:i:s"),
                        'mode' => 'regular'
                    );

                    $db->insert('timerecord', $data);

                    //insert/update record on activity_tracker table
                    $sql = $db->select()
                        ->from('activity_tracker')
                        ->where('userid = ?', $personal_id);

                    $actvity_tracker_record = $db->fetchAll($sql);

                    if (count($actvity_tracker_record) == 0) {
                        //no record found add record
                        $data = array(
                            'userid' => $personal_id,
                            'last_snapshot_time' => $now->format("Y-m-d H:i:s"),
                            'last_machine_reported_time' => $now->format("Y-m-d H:i:s"),
                            'last_activity_note_time' => $now->format("Y-m-d H:i:s"),
                            'subcontractors_id' => $subcontractors_id,
                            'leads_id' => $subcontractors_record['leads_id'],
                            'leads_name' => $leads_record['fname'] . ' ' . $leads_record['lname'],
                            'status' => 'working',
                            'activity_note_interval' => 1200,
                        );

                        $x = $db->insert('activity_tracker', $data);

                    }
                    else {
                        //update record
                        $data = array(
                            'last_snapshot_time' => $now->format("Y-m-d H:i:s"),
                            'last_machine_reported_time' => $now->format("Y-m-d H:i:s"),
                            'last_activity_note_time' => $now->format("Y-m-d H:i:s"),
                            'subcontractors_id' => $subcontractors_id,
                            'leads_id' => $subcontractors_record['leads_id'],
                            'leads_name' => $leads_record['fname'] . ' ' . $leads_record['lname'],
                            'status' => 'working'
                        );

                        $db->update('activity_tracker', $data, "userid = $personal_id");
                    }

                    $widget_status['button_start_work'] = False;
                    $widget_status['button_finish_work'] = True;
                    $widget_status['button_quick_break'] = False;
                    $widget_status['button_lunch_break'] = False;
                    $widget_status['choice_select_client'] = False;
                    $activity_tracker_status = 'working';
                    $activity_tracker['status'] = 'working';
                    $status = 'Working for ' . $leads_record['fname'] . ' ' . $leads_record['lname'];

                }
            }
        }

        if ($activity_tracker_status == 'lunch break') {
            $widget_status['button_start_work'] = False;
            $widget_status['button_finish_work'] = False;
            $widget_status['choice_select_client'] = False;
            $widget_status['button_quick_break'] = False;
            $widget_status['button_lunch_break'] = True;
            $take_screen_shot = 'N';
            $screen_capture_status = 'N';

            //compute for the time since lunch break
            //get lunch record
            $sql = $db->select()
                ->from("timerecord")
                ->where("userid = ?", $personal_id)
                ->where("mode = 'lunch_break'")
                ->where("time_out is NULL")
                ->order("time_in DESC")
                ->limit("1");

            $lunch_record = $db->fetchRow($sql);
            $lunch_start = new DateTime($lunch_record['time_in']);
            $lunch_start_str = $lunch_start->format("H:i");
            $seconds_delta = $now->format('U') - $lunch_start->format('U');
            $minutes = floor($seconds_delta / 60);
            $break_status = "OUT TO LUNCH - $lunch_start_str ($minutes mins).";
            $message = "Out to lunch";
        }

        if ($activity_tracker_status == 'quick break') {
            $widget_status['button_start_work'] = False;
            $widget_status['button_finish_work'] = False;
            $widget_status['choice_select_client'] = False;
            $widget_status['button_quick_break'] = True;
            $widget_status['button_lunch_break'] = False;
            $take_screen_shot = 'N';
            $screen_capture_status = 'N';

            //get quick break record
            $sql = $db->select()
                ->from("activity_tracker_breaks")
                ->where("userid = ?", $personal_id)
                ->where("type = 'quick'")
                ->where("end IS NULL")
                ->order("start DESC")
                ->limit("1");

            $quick_break_record = $db->fetchRow($sql);
            $quick_break_start = new DateTime($quick_break_record['start']);
            $quick_break_start_str = $quick_break_start->format("H:i");
            $seconds_delta = $now->format('U') - $quick_break_start->format('U');
            $minutes = floor($seconds_delta / 60);
            $break_status = "QUICK BREAK - $quick_break_start_str ($minutes mins).";
            $message = "Quick Break";
        }

        $data = array('status' => $status, 
            'message' => $message,
            'take_screen_shot' => $take_screen_shot,
            'get_activity_note' => $get_activity_note,
            'alert_title' => $alert_title,
            'alert_message' => $alert_message,
            'screen_capture_status' => $screen_capture_status,
            'activity_tracker_status' => $activity_tracker_status,
            'widget_status' => $widget_status,
            'break_status' => $break_status
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
<input type="submit"/>
</form>
