<?php
    //2010-02-25 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  -   magicquotes update
    //upon successfull insertion of comment,  return the comments
    require("../conf/zend_smarty_conf.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    $invoice_id = $_POST['invoice_id'];
    if (($invoice_id == "") or ($invoice_id == null)) {
        die("Invoice ID missing.");
    }

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }


    $invoice_comment_id = $_POST['invoice_comment_id'];

    if (($invoice_comment_id == "") or ($invoice_comment_id == null)) {
        die("Invoice comment ID missing.");
    }


    //delete the record
    $db->delete('subcon_invoice_details', "id = $invoice_comment_id");

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
