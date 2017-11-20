<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  fix rowCount dependency
    //2008-10-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  added a field for leads_id in internet_connection_status_log table to separate clients view
    //2008-07-02 Lawrence Sunglao <locsunglao@yahoo.com>
    //  add a table for internet connection status

    date_default_timezone_set("Asia/Manila");
    include('../online_presence/OnlinePresence.php');
    $ph_tz = new DateTimeZone('Asia/Manila');

    if ($_POST) {
        include_once('LibScreenShots.php');
        $email = $_POST['user'];
        $password = sha1($_POST['password']);
        $flag_valid_user_type = true;
        $enable_upload = false;

        $user_type = $_POST['user_type'];
        $confirm_online_presence = false;
        $confirm_online_presence_msg = '';
        $confirm_online_presence_title = '';

        switch ($user_type) {
            case('agent'):
                $query="SELECT agent_no, lname, fname FROM agent WHERE email ='$email' AND agent_password='$password'";
                break;
            case('subcon'):
                $query="SELECT userid, lname, fname FROM personal WHERE email ='$email' AND pass='$password'";
                break;
            default:
                $flag_valid_user_type = false;
        }

        if ($flag_valid_user_type) {
            $result = $dbh->query($query)->fetchAll();

            //record found
            if (count($result) > 0) {
                $status = 'OK';
                $message = 'Authentication successful!';

                //verify if we can log records
                $data = $result[0];
                $userid = $data[0];
                $time_recording = new TimeRecording($userid);
                if ($time_recording->GetMonitorUser()) {
                    $ph_tz = new DateTimeZone('Asia/Manila');
                    $now = new DateTime();
                    $now->setTimeZone($ph_tz);
                    $now_str = $now->format('Y-m-d H:i:s');
                    $leads_id = $time_recording->GetCurrentLeadsID();
                    $query = "insert into internet_connection_status_log (user_type, userid, leads_id, post_time) values ('$user_type', $userid, $leads_id, '$now_str')";
                    $affected = $dbh->exec($query);
                    $enable_upload = true;
                    //online presence stuff
                    $now = new DateTime();
                    $now->setTimeZone($ph_tz);
                    $online_presence = new OnlinePresence($userid, $user_type);
                    $next_login_time = $online_presence->getNextLoginTime();
                    $unix_seconds = $now->format('U') - $next_login_time->format('U');
                    if ($unix_seconds >= 0) {
                        //test if $next_login_time was yesterday, modify message
                        $date_yesterday = clone($now);
                        $date_yesterday->modify('-1 days');
                        $date_yesterday_str = $date_yesterday->format('Y-m-d');
                        if ($date_yesterday_str == $next_login_time->format('Y-m-d')) {
                            $confirm_online_presence = false;
                        }
                        else {
                            $confirm_online_presence = True;
                            $confirm_online_presence_msg = 'Please confirm your presence by logging on to remotestaff site and input the captcha displayed on your home page.';
                            $confirm_online_presence_title = 'Think Innovations System Message.';
                        }
                    }
                }
            }
            else {
                $status = 'ERROR';
                $message = 'Authentication error.';
            }
        }
        else {
            $status = 'ERROR';
            $message = 'Invalid user type.';
        }

        $data = array('status' => $status, 
            'message' => $message, 
            'enable_upload' => $enable_upload,
            'confirm_online_presence' => $confirm_online_presence,
            'confirm_online_presence_msg' => $confirm_online_presence_msg,
            'confirm_online_presence_title' => $confirm_online_presence_title);
        $output = json_encode($data);
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header('Content-type: text/plain');
        echo $output;
        exit;
    }
?>
<form method="POST" action=<?php echo $_SERVER['PHP_SELF'] ?>>
<label for="user">User</label><input type="text" name="user" id="user"></input>
<br/>
<label for="password">Password</label><input type="password" name="password" id="password"></input>
<br/>
<label for="user_type">User Type</label><input type="text" name="user_type" id="user_type"></input>
<br/>
<input type="submit"/>
</form>
