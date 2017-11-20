<?php
    include('../conf.php');
    include('../time_recording/TimeRecording.php');
    $blank = $_POST['blank'];
    $broadcast = $_POST['broadcast'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $record_id = $_POST['record_id'];
    $userid = $_POST['userid'];
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

    if ($userid == null or $userid == ''){
        die('Invalid user id');
    }

    if ($blank == '' or $blank == null) {
        die('Invalid data, blank.');
    }
    if ($record_id == '' or $record_id == null) {
        die('Invalid data, record_id.');
    }
    if ($date == '' or $date == null) {
        die('Invalid data, date.');
    }
    $date = new DateTime($date);    //convert to DateTime format
    $date_str = $date->format('Y-m-d');

    if ($note == '' or $note == null) {
        die('Invalid data, note.');
    }

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');

    $formatted_time_record = new FormattedTimeRecord($userid);
    if ($broadcast == 'yes') {
        $query = "insert into timerecord_notes(reference_date, posted_by_id, posted_by_type, note, note_type) values('$date_str', $admin_id, 'admin', '$note', 'broadcast')";
        $dbh->exec($query);
        $return_data = $formatted_time_record->GetRecordNotes($record_id) . ' ' . $formatted_time_record->GetRecordNotesOnBlankDays($date) . ' ' . $formatted_time_record->GetBroadcastRecordNotes($date);
    }
    else {
        if ($blank == 'yes') {
            $query = "insert into timerecord_notes(reference_date, userid, posted_by_id, posted_by_type, note, note_type) values('$record_id', $userid, $admin_id, 'admin', '$note', 'unique')";
            $dbh->exec($query);
            $return_data = $formatted_time_record->GetRecordNotesOnBlankDays($date) . ' ' . $formatted_time_record->GetBroadcastRecordNotes($date);
        }

        if ($blank == 'no') {
            $query = "insert into timerecord_notes(timerecord_id, userid, posted_by_id, posted_by_type, note, note_type) values('$record_id', $userid, $admin_id, 'admin', '$note', 'unique')";
            $dbh->exec($query);
            $return_data = $formatted_time_record->GetRecordNotes($record_id) . ' ' . $formatted_time_record->GetRecordNotesOnBlankDays($date) . ' ' . $formatted_time_record->GetBroadcastRecordNotes($date);
        }
    }

    echo $return_data;
?>
