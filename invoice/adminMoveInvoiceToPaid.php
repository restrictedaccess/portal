<?php
    include("../conf.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    $invoice_id = $_POST['invoice_id'];
    if (($invoice_id == null) or ($invoice_id == '')){
        die('Invalid Invoice number.');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    date_default_timezone_set("Asia/Manila");
    $now = new DateTime();
    $now_str = $now->format('Y-m-d H:i:s');
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');

    $query = "update subcon_invoice set status='posted', post_date='$now_str' where id = $invoice_id";
    $rows_affected = $dbh->exec($query);
    if ($rows_affected == 1) {
        echo "<h2>Succesfully moved invoice number $invoice_id to the Paid section.</h2>";
        echo "<div id='invoice_id' class='invisible' invoice_id='$invoice_id'</div>";
        exit;
    }

    if ($rows_affected == 0) {
        echo "<h2>No records updated for invoice number $invoice_id</h2>";
        exit;
    }
    else {
        echo "<h2>Weird response for invoice number $invoice_id</h2>";
        exit;
    }
?>
