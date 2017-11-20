<?php
    //2009-11-13 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  moved stripslashes down
    //2009-11-13 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  Strip slashes from notes
    //2008-09-15 Lawrence Sunglao <locsunglao@yahoo.com>
    //      send email after posting
    include('../conf.php');
    include('TimeRecording.php');
    include('EmailTimesheetNote.php');
    $blank = $_POST['blank'];
    $record_id = $_POST['record_id'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }
    date_default_timezone_set("Asia/Manila");

    $userid = $_SESSION['userid'];
    if ($userid == null){
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
    $date = new DateTime($date);
    if ($note == '' or $note == null) {
        die('Invalid data, note.');
    }


    //grab the subcons email address
    $query = "select email, lname, fname from personal where userid = $userid";
    $data = $dbh->query($query);
    $subcon_data = $data->fetchAll();
    $subcon_email = $subcon_data[0]['email'];
    $subcon_fname = $subcon_data[0]['fname'];
    $subcon_lname = $subcon_data[0]['lname'];


    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');

    $formatted_time_record = new FormattedTimeRecord($userid);
    if ($blank == 'yes') {
        $query = "insert into timerecord_notes(reference_date, userid, posted_by_id, posted_by_type, note, note_type) values('$record_id', $userid, $userid, 'subcon', '$note', 'unique')";
        $dbh->exec($query);

        $return_data = $formatted_time_record->GetRecordNotesOnBlankDays($date) . ' ' . $formatted_time_record->GetBroadcastRecordNotes($date);

    }

    if ($blank == 'no') {
        $query = "insert into timerecord_notes(timerecord_id, userid, posted_by_id, posted_by_type, note, note_type) values('$record_id', $userid, $userid, 'subcon', '$note', 'unique')";
        $dbh->exec($query);
        $return_data = $formatted_time_record->GetRecordNotes($record_id) . ' ' . $formatted_time_record->GetRecordNotesOnBlankDays($date) . ' ' . $formatted_time_record->GetBroadcastRecordNotes($date);
        $message = "Date noted: $record_id\r\nNoted by: $subcon_fname $subcon_lname\r\n\r\nNote: $note";
    }


    echo $return_data;

    $note = stripslashes($note);

    //send an email
    $subject = "New Timesheet Note from : $subcon_fname $subcon_lname";
    $date_str = $date->format('Y-m-d');
    $message = "Date noted: $date_str\r\nNoted by: $subcon_fname $subcon_lname\r\n\r\nNote: $note";
    EmailTimesheetNote($subcon_email, $subject, $message);

?>
