<?php
//  2010-07-22  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   modified so that leads can view this invoice as well
//  2010-06-24  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   first hack
require_once("conf/zend_smarty_conf_root.php");
mb_language('uni'); mb_internal_encoding('UTF-8');
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$id = $_GET['id'];
if ($id == '') {
    die('Missing invoice id');
}

$flag_show_invoice = False;
$flag_is_bp = False;

//check session if this is an admin
if(!($_SESSION['admin_id']=="" || $_SESSION['admin_id'] == Null)) {
    $flag_show_invoice = True;
}
//check session if this is a business partner
else if(!($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==Null)) {
    $flag_show_invoice = True;
    $agent_no = $_SESSION['agent_no'];
    $flag_is_bp = True;
}

if ($flag_show_invoice == False) {
    die('Not Allowed!');
}

//grab the leads_invoice
$sql = $db->select()
        ->from('leads_invoice')
        ->join('leads', 'leads_invoice.leads_id = leads.id', Array('leads_id'=> 'id', 'fname', 'lname', 'email'))
        ->join('currency_lookup', 'leads_invoice.currency = currency_lookup.id', Array('code', 'sign'))
        ->where('leads_invoice.id = ?', $id);

if ($flag_is_bp) {  //check if this lead belongs to this business partner
    $sql->where('leads.business_partner_id = ?', $agent_no);
}
$leads_invoice = $db->fetchRow($sql);

if ($leads_invoice == False) {
    die('Invoice not found!');
}

//grab the invoice items
$sql = $db->select()
        ->from('leads_invoice_item')
        ->join('products', 'leads_invoice_item.product_id = products.id', Array('code', 'name'))
        ->where('leads_invoice_item.leads_invoice_id = ?', $id);
$leads_invoice_items = $db->fetchAll($sql);

//get subtotal
$subtotal = 0;
$sum_qty = 0;
foreach ($leads_invoice_items as $item) {
    $subtotal += $item['qty'] * $item['unit_price'];
    $sum_qty += $item['qty'];
}

//get other charges
$sql = $db->select()
        ->from('leads_invoice_other_charges')
        ->where('leads_invoice_id = ?', $id);
$other_charges = $db->fetchAll($sql);

$other_charges_2 = Array();
$total = $subtotal;
foreach($other_charges as $charge) {
    if ($charge['type'] == 'variable') {
        $charge['amount'] = $charge['rate'] * 0.01 * $subtotal;
    }
    $other_charges_2[] = $charge;
    $total += $charge['amount'];
}


header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty();
$smarty->assign("leads_invoice", $leads_invoice);
$smarty->assign("leads_invoice_items", $leads_invoice_items);
$smarty->assign("sum_qty", $sum_qty);
$smarty->assign("subtotal", $subtotal);
$smarty->assign("other_charges", $other_charges_2);
$smarty->assign("total", $total);
$smarty->display('leads_invoice.tpl');
?>
