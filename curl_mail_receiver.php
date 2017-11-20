<?php


define(CURL_PASSWORD, '143x244y');
if ($_POST) {
    $emails = $_POST['emails'];
    $subject = $_POST['subject'];
    $headers = $_POST['headers'];
    $message = $_POST['message'];
    $curl_password = $_POST['curl_password'];
    $message = stripslashes($message);
    $headers = stripslashes($headers);
    
    if ($curl_password != CURL_PASSWORD) {
        echo 'Error!';
        exit;
    }

    $email=explode(",",$emails);

    //echo count($email)."<br>";
    for ($i=0; $i<count($email);$i++)
    {

        $to=$email[$i];
        mail($to, $subject, $message, $headers);
    }
    echo 'Success!';
}
?>
