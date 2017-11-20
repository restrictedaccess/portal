<?php
    //2009-02-16 Lawrence Sunglao <locsunglao@yahoo.com>
    //  Major Over Haul!
    //2008-10-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  added a field for leads_id in screenshots table to separate clients view
    require_once('../zend_conf.php');

    if ($_POST) {
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $status = 'OK';
        $message = 'Not defined';
        $alert_title = '';
        $alert_message = '';

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
        $possible_status = array('working', 'toilet break', 'coffee break');
        if (in_array($activity_tracker_status, $possible_status)) {
            //get client name
            $message = sprintf("Working for %s.", $activity_tracker['leads_name']);

            //check if directory exists create one if it doesnt
            $now = new DateTime();
            $date_str = $now->format('Y-m-d');
            $time_str = $now->format('H-i-s');
            $path = UPLOAD_IMAGE_DIR."subcon/$date_str/$personal_id/";
            if (file_exists($path) == false) {
                mkdir($path, 0777, true);
                //create a dummy indexfile so that they cant browse the directory
                $index_file = fopen($path . 'index.html', 'w') or die("Can't create index.html");
                fclose($index_file);
            }

            //move the file, insert record on the screenshots table
            $now_str = $now->format('Y-m-d H:i:s');
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], "$path$time_str.jpg")) {
                $status = 'OK';
                $data = array(
                    'user_type' => 'subcon',
                    'userid' => $personal_id,
                    'leads_id' => $activity_tracker['leads_id'],
                    'subcontractors_id' => $activity_tracker['subcontractors_id'],
                    'post_time' => $now->format('Y-m-d H:i:s'),
                    'request_snapshot_by_id' => $activity_tracker['request_snapshot_by_id'],
                    'request_snapshot_by_type' => $activity_tracker['request_snapshot_by_type']
                );

                $db->insert('screenshots', $data);

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
                    'last_snapshot_time' => $now->format('Y-m-d H:i:s'),
                    'request_snapshot' => 'N',
                    'request_snapshot_by_id' => null,
                    'request_snapshot_by_type' => 'system',
                    'last_machine_reported_time' => $now->format('Y-m-d H:i:s')
                );
                $n = $db->update('activity_tracker', $data, "userid = $personal_id");

            } else {
                $status = 'ERROR';
                $message = "Possible file upload attack! " . $_FILES;
                $alert_title = 'Server Message.';
                $alert_message = 'Possible file upload attack!';
            }
        }   //end of verify if we can upload files

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
<form enctype="multipart/form-data" method="POST" action=<?php echo $_SERVER['PHP_SELF'] ?>>
<label for="email">User: </label><input type="text" name="email" id="email"></input>
<br/>
<label for="password">Password: </label><input type="password" name="password" id="password"></input>
<br/>
<label for"userfile">Send this file: </label><input name="userfile" id="userfile" type="file" />
<br/>
<input type="submit"/>
</form>
