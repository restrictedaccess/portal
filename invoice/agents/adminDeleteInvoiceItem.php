<?php
    //upon successfull insertion of comment,  return the comments
    include("../../conf.php");
   require("../../lib/Smarty/libs/Smarty.class.php");
    date_default_timezone_set("Asia/Manila");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    $invoice_id = $_POST['invoice_id'];
    if (($invoice_id == "") or ($invoice_id == null)) {
        die("Invoice ID missing.");
    }

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    $invoice_comment_id = $_POST['invoice_comment_id'];

    if (($invoice_comment_id == "") or ($invoice_comment_id == null)) {
        die("Invoice comment ID missing.");
    }


    //delete the record
    $query = "DELETE FROM agent_invoice_details WHERE id = $invoice_comment_id";
    $result = $dbh->exec($query);

    //update the total_amount on subcon_invoice table
    $query = "SELECT SUM(amount) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
    $result = $dbh->query($query);
    $data = $result->fetch();
    $total_amount = $data[0];
    
    $query = "UPDATE agent_invoice SET total_amount = '$total_amount' WHERE id = $invoice_id";
    $dbh->exec($query);


    //query invoice details
    $query = "SELECT id, item_id, description, amount FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id ORDER BY item_id";
    $data = $dbh->query($query);
    $invoice_details = $data->fetchAll();

    $smarty = new Smarty();
    $smarty->assign('invoice_details', $invoice_details);
    $smarty->assign('amount', $total_amount);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminAddEditInvoiceDetail.tpl');
?>
