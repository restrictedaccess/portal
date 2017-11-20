<?php
    //2010-02-25 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  -   magicquotes update
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependencies on rowCount function
    //upon successfull insertion of comment,  return the comments
    require("../conf/zend_smarty_conf.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
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


    //check if subcon_invoice record is still in draft mode
    $sql = $db->select()
        ->from('subcon_invoice', array('id', 'description'))
        ->where('id = ?', $invoice_id)
        ->where('status = "draft"');
    $data = $db->fetchAll($sql);
    if (count($data) == 0) {
        die('Invoice is not in draft mode');
    }

    //insert/update record on the subcon_invoice_comments
    if ($mode == 'add') {
        //get the maximum item_id
        $sql = $db->select()
            ->from('subcon_invoice_details', 'MAX(item_id)')
            ->where('subcon_invoice_id = ?', $invoice_id);
        $item_id = $db->fetchOne($sql) + 1;

        //insert
        $data = array(
            'subcon_invoice_id' => $invoice_id,
            'item_id' => $item_id,
            'description' => $description,
            'amount' => $amount
        );
        $db->insert('subcon_invoice_details', $data);
    }
    else {
        //update
        if ($invoice_comment_id == '') {
            die("Invalid invoice comment id");
        }
        $data = array(
            'description' => $description,
            'amount' => $amount
        );
        $db->update('subcon_invoice_details', $data, "id = $invoice_comment_id");
    }

    //update the total_amount on subcon_invoice table
    $sql = $db->select()
        ->from('subcon_invoice_details', 'SUM(amount)')
        ->where('subcon_invoice_id = ?', $invoice_id);
    $total_amount = $db->fetchOne($sql);
    
    $data = array(
        'total_amount' => $total_amount,
    );
    $db->update('subcon_invoice', $data, "id = $invoice_id");

    
    //query invoice details
    $sql = $db->select()
        ->from('subcon_invoice_details', array('id', 'item_id', 'description', 'amount'))
        ->where('subcon_invoice_id = ?', $invoice_id)
        ->order(array('item_id'));
    $invoice_details = $db->fetchAll($sql);

    $smarty = new Smarty();
    $smarty->assign('invoice_details', $invoice_details);
    $smarty->assign('amount', $total_amount);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminAddEditInvoiceDetail.tpl');
?>
