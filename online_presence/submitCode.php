<?php 
    include('../conf.php');
    include("../securimage/securimage.php");
    include("OnlinePresence.php");
    $img = new Securimage();
    $valid = $img->check($_POST['code']);

    if($valid == true) {
        $user_type = $_POST['user_type'];
        if ($user_type == 'agent') {
            $userid = $_SESSION['agent_no'];
        }
        else {
            $userid = $_SESSION['userid'];
        }
        $online_presence = new OnlinePresence($userid, $user_type);
        echo $online_presence->logPresence();
    }
    else {
        echo "Invalid code.";
    }
?>
