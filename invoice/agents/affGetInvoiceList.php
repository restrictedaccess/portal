<?php
     include("../../conf.php");
     require("../../lib/Smarty/libs/Smarty.class.php");
    session_start();
	$agentid = $_SESSION['agent_no'];
    if ($agentid == null){
        die('Invalid user id');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    date_default_timezone_set("Asia/Manila");

    $query = "SELECT id, invoice_date, status, description, payment_details, updated_by, updated_by_type, start_date, end_date, total_amount from agent_invoice where agentid = $agentid and (status = 'draft' or status = 'posted' or status = 'approved') order by invoice_date";
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
    $smarty->display('subconGetInvoiceList.tpl');
?>
