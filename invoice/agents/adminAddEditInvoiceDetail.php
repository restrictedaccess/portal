<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed rowCount dependencies
    //upon successfull insertion of comment,  return the comments
    include("../../conf.php");
    require("../../lib/Smarty/libs/Smarty.class.php");
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

    $invoice_id = $_POST['invoice_id'];
    $description = $_POST['description'];
    $mode = $_POST['mode'];
    $amount = $_POST['amount'];
    $invoice_comment_id = $_POST['invoice_comment_id'];

    if (($invoice_id == "") or ($invoice_id == null)) {
        die("Invoice ID missing.");
    }

    if (($description == "") or ($description == null)) {
        die("Description missing.");
    }

    if ($mode == '') {
        die("Invalid mode.");
    }

    if ($amount == '') {
        die("Invalide amount.");
    }


    //check if agent_invoice record is still in draft mode
    $query = "SELECT id, description FROM agent_invoice WHERE id = $invoice_id and status = 'draft'";
    $data = $dbh->query($query)->fetchAll();
    if (count($data) == 0) {
        die('Invoice is not in draft mode');
    }

    //insert/update record on the subcon_invoice_comments
    if ($mode == 'add') {
        //get the maximum item_id
        $query = "SELECT MAX(item_id) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
        $data = $dbh->query($query);
        $result = $data->fetch();
        $item_id = $result[0] + 1;
		
		$query3 = "SELECT MAX(counter) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
		$data2 = $dbh->query($query3);
        $result2 = $data2->fetch();
        $counter = $result2[0] + 1;
		
        //insert
        $query = "INSERT INTO agent_invoice_details (agent_invoice_id, item_id, description, amount,counter) VALUES ($invoice_id, $item_id, '$description', $amount,$counter)";
        $dbh->exec($query);
    }
    else {
        //update
        if ($invoice_comment_id == '') {
            die("Invalid invoice comment id");
        }
        $query = "UPDATE agent_invoice_details SET description = '$description', amount = '$amount' where id = $invoice_comment_id";
        $dbh->exec($query);
    }

    //update the total_amount on subcon_invoice table
    $query = "SELECT SUM(amount) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
    $result = $dbh->query($query);
    $data = $result->fetch();
    $total_amount = $data[0];
	//
	
	$query4 = "SELECT  percent FROM agent_invoice WHERE id = $invoice_id";
	$data4 = $dbh->query($query4);
    $result4 = $data4->fetch();
	
    $percent = $result4[0];
    $converted_amount = $total_amount + $percent;
	
	
    
    $query = "UPDATE agent_invoice SET total_amount = '$total_amount' ,converted_amount ='$converted_amount' where id = $invoice_id";
    $dbh->exec($query);

    //query invoice details
    $query = "SELECT id, item_id, description, amount,counter FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id order by item_id";
    $data = $dbh->query($query);
    $invoice_details = $data->fetchAll();

    $smarty = new Smarty();
    $smarty->assign('invoice_details', $invoice_details);
    $smarty->assign('amount', $total_amount);
	$smarty->assign('converted_amount', $converted_amount);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminAddEditInvoiceDetail.tpl');
?>
