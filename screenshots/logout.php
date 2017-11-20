<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  fix rowCount dependency
    //2008-07-12 Lawrence Sunglao <locsunglao@yahoo.com>

    date_default_timezone_set("Asia/Manila");
    include('../time_recording/TimeRecording.php');

    if ($_POST) {
        include_once('LibScreenShots.php');
        $email = $_POST['user'];
        $password = sha1($_POST['password']);
        $flag_valid_user_type = true;

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

        $data = array('status' => $status, 'message' => $message);
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
