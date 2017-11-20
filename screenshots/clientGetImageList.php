<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependency on rowCount
    //2008-10-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  copied from getImageList.php
    //  modify to only retrieve screenshot image list relative to the client

    require('LibScreenShots.php');
    $userid = $_GET['userid'];
    $user_type = $_GET['user_type'];
    $date_param = $_GET['date_param'];
    $flag_valid_user_type = true;

    $client_id = $_SESSION['client_id'];

    /**
    *
    * returns an array of Latest image list
    *
    * This is the long description for the Class
    *
    * @return	array	 Description
    * @access	public
    * @see		??
    */
    function GetLatestImageList($uid, $user_type) {
        global $dbh, $date_param, $client_id;
        $date_time_start = new DateTime($date_param);
        $date_time_end = clone($date_time_start);
        $date_time_end->modify('1 hour');

        $image_list = Array();
        for ($i = 0; $i < 24; $i++) {
            $date_time_start_str = $date_time_start->format('Y-m-d H:i:s');
            $date_time_end_str = $date_time_end->format('Y-m-d H:i:s');
            $query = "select post_time from screenshots where userid = $uid and user_type = '$user_type' and post_time >= '$date_time_start_str' and post_time < '$date_time_end_str' and leads_id = $client_id order by post_time";
            $result = $dbh->query($query)->fetchAll();
            $date_time_label = $date_time_start->format('H:i');
            $date_time_start->modify('+1 hours');
            $date_time_end->modify('+1 hours');

            if (count($result) == 0) {
                continue;
            }

            $image_list_per_hr = Array();
            foreach ($result as $row){
                $image_list_per_hr[] = $row['post_time'];
            }
            $image_list[] = Array('time_span' => $date_time_label, 'images' => $image_list_per_hr);
        }

        return $image_list;
    }

    switch ($user_type) {
        case('agent'):
            $query="SELECT agent_no, lname, fname, email FROM agent WHERE agent_no ='$userid'";
            break;
        case('subcon'):
            $query="SELECT userid, lname, fname, email FROM personal WHERE userid ='$userid'";
            break;
        default:
            $flag_valid_user_type = false;
    }

    if ($flag_valid_user_type) {
        $result = $dbh->query($query)->fetchAll();

        //record found
        if (count($result) > 0) {
            $status = 'OK';
            list($uid, $lname, $fname, $email) = $result[0];
            $msg = "User : $lname, $fname";
            $image_list = GetLatestImageList($uid, $user_type);
        }
        else {
            $status = 'ERROR';
            $msg = "Invalid email";
        }
    }
    else {
        $status = 'ERROR';
        $msg = 'Invalid user type';
    }

    $data = array("stat" => $status, 
        "msg" => $msg,
        "uid" => $uid,
        "image_list" => $image_list
    );
    $output = json_encode($data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: application/json');
    echo $output;
?>
