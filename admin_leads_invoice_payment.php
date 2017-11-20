<?php
//  2010-06-24  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   first hack
require_once("conf/zend_smarty_conf.php");
mb_language('uni'); mb_internal_encoding('UTF-8');
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($_SESSION['admin_id']=="") {
        header("location:index.php");
}


//get payments
$sql = $db->select()
        ->from('leads_invoice_payment')
        ->join('leads', 
            'leads.id = leads_invoice_payment.leads_id', 
            Array('leads_id' => 'id', 
                'leads_lname' => 'lname', 
                'leads_fname' => 'fname', 
                'leads_email' => 'email'))
        ->join('leads_invoice', 
            'leads_invoice.id = leads_invoice_payment.leads_invoice_id', 
            Array('leads_invoice_id' => 'id', 
                'leads_invoice_description' =>'description'))
        ->join('currency_lookup', 
            'leads_invoice_payment.currency_id = currency_lookup.id', 
            Array('code', 'sign'))
        ->join('payment_mode_lookup', 
            'leads_invoice_payment.payment_mode_id = payment_mode_lookup.id', 
            Array('payment_mode' => 'mode'))
        ->order('leads_invoice_payment.date DESC');

$leads_invoice_payment = $db->fetchAll($sql);


header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty();
$smarty->assign('leads_invoice_payment', $leads_invoice_payment);
$smarty->display('admin_leads_invoice_payment.tpl');

?>
