<?php
    include('../conf.php');
    include('../time_recording/TimeRecording.php');
    require("../lib/Smarty/libs/Smarty.class.php");

    $blank = $_GET['blank'];
    $record_id = $_GET['record_id'];
    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }
    date_default_timezone_set("Asia/Manila");

    $admin_id = $_SESSION['admin_id'];
    if ($admin_id == null or $admin_id == '') {
        die('Invalid admin id');
    }

    $userid = $_GET['userid'];
    if ($userid == null){
        die('Invalid user id');
    }

    if ($blank == '' or $blank == null) {
        die('Invalid data, blank.');
    }
    if ($record_id == '' or $record_id == null) {
        die('Invalid data, record_id.');
    }
    $date = new DateTime($date);

    function GetFirstName($id, $type) {
        global $dbh;
        switch ($type) {
            case 'subcon':
                $query = "select fname from personal where userid = $id";
                break;
            case 'admin':
                $query = "select admin_fname from admin where admin_id = $id";
                break;
        }
        $data = $dbh->query($query);
        $record = $data->fetch();
        $first_name = $record[0];
        return $first_name;
    }

    #TODO work here
    $time_record_notes = Array();
    if ($blank == 'yes') {
        $reference_date = $record_id;   //record_id is used as a reference date when no timerecord_id is present
        $query = "select id, posted_by_id, posted_by_type, note from timerecord_notes where timerecord_id is null and userid = $userid and reference_date = '$record_id' and note_type='unique'";
        $result = $dbh->query($query);
        $data = $result->fetchAll();
        foreach($data as $note) {
            $first_name = GetFirstName($note['posted_by_id'], $note['posted_by_type']);
            $time_record_notes[] = array('first_name' => $first_name, 'note' => $note['note']);
        }
    }

    if ($blank == 'no') {   
        $query = "select id, posted_by_id, posted_by_type, note from timerecord_notes where timerecord_id = $record_id and note_type='unique'";
        $result = $dbh->query($query);
        $data = $result->fetchAll();
        foreach($data as $note) {
            $first_name = GetFirstName($note['posted_by_id'], $note['posted_by_type']);
            $time_record_notes[] = array('first_name' => $first_name, 'note' => $note['note']);
        }

        //consider also blank records but get first the reference_date grab it from timerecords[time_in]
        $query = "select time_in from timerecord where id = $record_id";
        $result = $dbh->query($query);
        $data = $result->fetch();
        $reference_date = $data['time_in'];
        $reference_date_date_time = new DateTime($reference_date);
        $reference_date = $reference_date_date_time->format('Y-m-d');

        $query = "select id, posted_by_id, posted_by_type, note from timerecord_notes where timerecord_id is null and userid = $userid and reference_date = '$reference_date' and note_type='unique'";
        $result = $dbh->query($query);
        $data = $result->fetchAll();
        foreach($data as $note) {
            $first_name = GetFirstName($note['posted_by_id'], $note['posted_by_type']);
            $time_record_notes[] = array('first_name' => $first_name, 'note' => $note['note']);
        }
    }

    //grab also timerecord_notes with a note_type of 'broad_cast'
    $query = "select id, posted_by_id, posted_by_type, note from timerecord_notes where timerecord_id is null and reference_date = '$reference_date' and note_type='broadcast'";
    $result = $dbh->query($query);
    $data = $result->fetchAll();
    foreach($data as $note) {
        $first_name = GetFirstName($note['posted_by_id'], $note['posted_by_type']);
        $time_record_notes[] = array('first_name' => $first_name, 'note' => $note['note']);
    }


    $smarty = new Smarty();
    $smarty->assign('time_record_notes', $time_record_notes);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    $smarty->display('adminGetNote.tpl');
?>
