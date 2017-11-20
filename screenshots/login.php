<?php
    //2010-11-09 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  updated to the newest RSSC version, disabling the old ones
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependency on rowCount
    //2009-01-29 Lawrence Sunglao <locsunglao@yahoo.com>
    //   -Updated version where screenshot interval is set to 3 minutes
    //
    //2008-07-15 Lawrence Sunglao <locsunglao@yahoo.com>
    //copied from verify.php add a versioning feature

    define(CLIENT_VERSION, "20101105");

    date_default_timezone_set("Asia/Manila");
    include('../time_recording/TimeRecording.php');

    if ($_POST) {
        include_once('LibScreenShots.php');
        $email = $_POST['user'];
        $password = sha1($_POST['password']);
        $client_version = $_POST['client_version'];
        $flag_valid_user_type = true;
        $enable_upload = false;

        $user_type = $_POST['user_type'];

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
                //verify if we can log records
                $data = $result[0];
                $userid = $data[0];
                $time_recording = new TimeRecording($userid);
                if ($time_recording->GetMonitorUser()) {
                    $enable_upload = true;
                }
                $status = 'OK';
                $message = 'Authentication successful!';
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

        $data = array('status' => $status, 'message' => $message, 'enable_upload' => $enable_upload, 'client_version' => CLIENT_VERSION);
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
<label for="user_type">Version</label><input type="text" name="version" id="version"></input>
<br/>
<input type="submit"/>
</form>
