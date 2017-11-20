<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}

$mode=$_REQUEST['mode'];
$month = date('m');
$current_year =date("Y");

$sql = $db->select()
    ->from(array('c' => 'clients'), Array('leads_id'))
	->join(array('l' => 'leads'), 'l.id = c.leads_id', Array('fname', 'lname', 'email'))
	->order('fname ASC');
$clients = $db->fetchAll($sql);	

$monthArray=array("1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($month == $monthArray[$i])
  {
 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  }
  else
  {
$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  }
}


for ($i=$current_year; $i>=2008; $i--)
{
	
	if($current_year == $i){
		$yearoptions .= "<option selected value=\"$i\">$i</option>\n";
	}else{
		$yearoptions .= "<option value=\"$i\">$i</option>\n";
	}
}


$sql = $db->select()
    ->from('currency_lookup');
	//->where('code !=?', 'PHP');
$currencies = $db->fetchAll($sql);

$smarty->assign('clients',$clients);
$smarty->assign('monthoptions', $monthoptions);
$smarty->assign('yearoptions', $yearoptions);
$smarty->assign('currencies', $currencies);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('BlankClientInvoiceForm.tpl');
?>