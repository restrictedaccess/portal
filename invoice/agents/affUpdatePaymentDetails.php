<?php
    include("../../conf.php");
    
    session_start();
	$agentid = $_SESSION['agent_no'];
    if ($agentid == null){
        die('Invalid user id');
    }

    date_default_timezone_set("Asia/Manila");
    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

	

    $invoice_id = $_POST['invoice_id'];
    if (($invoice_id == null) or ($invoice_id == '')){
        die('Invalid Invoice number.');
    }

    //check if invoice is in draft or approved state
    $query = "select status from agent_invoice where id = $invoice_id";
    $result = $dbh->query($query);
    $data = $result->fetch();
    $status = $data['status'];
    if ((($status == 'draft') or ($status == 'approved')) == false) {
        die("$status Invoice is not in draft or approved mode. Cannot update payment details.");
    }

    $payment_details = $_POST['payment_details'];
    if (($payment_details == null) or ($payment_details == '')) {
        die('Invalid payment details.');
    }

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');

    $query = "update agent_invoice set payment_details='$payment_details' where id = $invoice_id";
    $rows_affected = $dbh->exec($query);
    if ($rows_affected == 1) {
        echo "<textarea id='text_area_payment_details' readonly='true'>$payment_details</textarea>";
        exit;
    }

    if ($rows_affected == 0) {
        echo "No records updated for invoice number $invoice_id";
        exit;
    }
    else {
        echo "Weird response for invoice number $invoice_id";
        exit;
    }
?>
