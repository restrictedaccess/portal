<?php
    include("../conf.php");
    require("../lib/Smarty/libs/Smarty.class.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    $start_date = $_GET['start_date'];
    if (($start_date == null) or ($start_date == '')){
        die('Invalid Start Date');
    }

    $end_date = $_GET['end_date'];
    if (($start_date == null) or ($start_date == '')){
        die('Invalid Start Date');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    date_default_timezone_set("Asia/Manila");

    $query = "SELECT id, invoice_date, status, description, updated_by, updated_by_type, start_date, end_date, total_amount from subcon_invoice where (status = 'draft' or status = 'posted' or status = 'approved') and invoice_date between '$start_date' and '$end_date' order by invoice_date";
    $data = $dbh->query($query);

    $draft_records = array();
    $posted_records = array();
    $approved_records = array();
    forEach ($data->fetchAll() as $row) {
        $id = $row['id'];
        $invoice_date = $row['invoice_date'];
        $status = $row['status'];
        $description = $row['description'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $total_amount = $row['total_amount'];

        //check if record is modifiable
        $modifiable = 'no';
        $record = array('id' => $id, 'invoice_date' => $invoice_date, 'description' => $description, 'modifiable' => $modifiable, 'start_date' => $start_date, 'end_date' => $end_date, 'total_amount' => $total_amount, 'status' => $status);
        if ($status == 'draft') {
            //always modifiable by admin
            $record['modifiable'] = 'yes';
            $draft_records[] = $record;
        }
        else if ($status == 'posted') {
            $posted_records[] = $record;
        }
        else if ($status == 'approved'){
            $approved_records[] = $record;
        }
    }

    $smarty = new Smarty();
    $smarty->assign('draft_records', $draft_records);
    $smarty->assign('approved_records', $approved_records);
    $smarty->assign('posted_records', $posted_records);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminGetInvoiceList.tpl');
?>
