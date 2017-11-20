<?php
include('conf/zend_smarty_conf_root.php');

if($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==NULL){
	header("Location: index.php");
}

$agent_no = $_SESSION['agent_no'];

//get payments related to this agent
$sql = $db->select()
        ->from('leads_invoice_payment')
        ->join('leads', 'leads.id = leads_invoice_payment.leads_id', Array('leads_id' => 'id', 'leads_lname' => 'lname', 'leads_fname' => 'fname', 'leads_email' => 'email'))
        ->join('leads_invoice', 'leads_invoice.id = leads_invoice_payment.leads_invoice_id', Array('leads_invoice_id' => 'id', 'leads_invoice_description' =>'description'))
        ->join('currency_lookup', 'leads_invoice_payment.currency_id = currency_lookup.id', Array('code', 'sign'))
        ->where('leads.business_partner_id = ?', $agent_no)
        ->order('leads_invoice_payment.date DESC');

$leads_invoice_payment = $db->fetchAll($sql);


header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty();
$smarty->assign('leads_invoice_payment', $leads_invoice_payment);
$secure_pay_list = $smarty->fetch('bp_leads_invoice_payment.tpl');

?>   
<html>
<head>
<title>Secure Pay Payments</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="">
<form name="form">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'bp-order-report-leftnav.php';?>
<br></td>
<td width=100% valign=top ><?php echo $secure_pay_list ?></td>
</tr>
</table>
<?php include 'footer.php';?>		
</form>	
</body>
</html>
