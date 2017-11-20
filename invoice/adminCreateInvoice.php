<?php
    include("../conf.php");
    include("../time_recording/TimeRecording.php");
    date_default_timezone_set("Asia/Manila");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    $invoice_date = $_POST['invoice_date'];
    $userid = $_POST['userid'];
    $description = $_POST['description'];
    $payment_details = $_POST['payment_details'];
    $mode = $_POST['mode'];

    if (($invoice_date == "") or ($invoice_date == null)) {
        die("Invoice date missing.");
    }

    if (($userid == "") or ($userid == null)) {
        die("userid missing.");
    }

    if (($mode == "") or ($mode == null)) {
        die("mode missing.");
    }

    $now = new DateTime();
    $now_str = $now->format('Y-m-d');

    if ($mode == 'blank') {
        $query = "insert into subcon_invoice (userid, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, invoice_date, draft_date) values ($userid, '$description', '$payment_details', $admin_id, 'admin', $admin_id, 'admin', 'draft', '$invoice_date', '$now_str')";
        $dbh->exec($query);
        $invoice_id = $dbh->lastInsertId();
        echo "<div id='invoice_id' invoice_id='$invoice_id'>Loading invoice number $invoice_id</div>";
        exit;
    }
    if ($mode == 'time_records') {

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $invoice_date = $_POST['invoice_date'];
        $description = $_POST['description'];

        if (($start_date == "") or ($start_date == null)) {
            die("Start date missing.");
        }

        if (($end_date == "") or ($end_date == null)) {
            die("End date missing.");
        }

        $now_date_time_str = $now->format("Y-m-d H:i:s");
        if (($invoice_date == "") or ($invoice_date == null)) {
            $invoice_date = $now->format("Y-m-d");
        }

        //insert record on the subcon_invoice
        $query = "insert into subcon_invoice (userid, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date) values ($userid, '$description', '$payment_details', $admin_id, 'admin', $admin_id, 'admin', 'draft', '$start_date', '$end_date', '$invoice_date', '$now_str')";
        $dbh->exec($query);
        $invoice_id = $dbh->lastInsertId();

        $start_date_obj = new DateTime($start_date);
        $start_date_str = $start_date_obj->format("Y-m-d 00:00:00");
        $start_date_obj = new DateTime($start_date_str);

        //parse end_date use last second before the next day
        $end_date_obj = new DateTime($end_date);
        $end_date_str = $end_date_obj->format("Y-m-d 23:59:59");
        $end_date_obj = new DateTime($end_date_str);

        $time_recording = new TimeRecording($userid);
        //create invoice details
        $time_recording->CreateAutomaticInvoice($start_date_obj, $end_date_obj, $invoice_id);

        echo "<div id='invoice_id' invoice_id='$invoice_id'>Loading invoice number $invoice_id</div>";
        exit;

    }

?>
