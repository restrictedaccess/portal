<?php

$page = "admin_personnel_info";

require_once('./conf/zend_smarty_conf_root.php');
require_once('./lib/misc_functions.php');
require_once('./lib/paginator.class.php'); 

$admin_id = getVar("admin_id");
$admin_status = getVar("admin_status");

// SET ERROR REPORTING
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);

if($admin_id=="")
{
	header("location:index.php");
}
$ipp = getVar("ipp", 0);

$pages = new Paginator;

$smarty = new Smarty();

// set the templates dir.
$smarty->template_dir = "./templates";
$smarty->compile_dir = "./templates_c";





/*
$query="SELECT DISTINCT u.userid, u.fname, u.lname,u.payment_details,i.total_amount
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		LEFT OUTER JOIN subcon_invoice i ON i.userid = s.userid
		WHERE s.status = 'ACTIVE'
		ORDER BY u.fname ASC;";
*/

/*
$sql = $db->select()
    ->distinct()
	->from(array('s' => 'subcontractors'), 'userid')
    ->joinLeft(array('p' => 'personal'), 's.userid = p.userid', array('lname', 'fname'))
	->joinLeft(array('i' => 'subcon_bank_iremit_sterling_visa'), 's.userid = i.userid', array('iremit_card_number' => 'card_number', 'iremit_account_holders_name' =>'account_holders_name'))
	->joinLeft(array('h' => 'subcon_bank_hsbc_remotestaff'), 's.userid = h.userid', array('hsbc_account_number' => 'account_number', 'hsbc_account_holders_name' => 'account_holders_name'))
	->joinLeft(array('o' => 'subcon_bank_others'), 's.userid = o.userid', array('other_bank_name' => 'bank_name', 'other_bank_branch' => 'bank_branch', 'other_swift_address' => 'swift_address', 'other_bank_account_number' => 'bank_account_number', 'other_account_holders_name' => 'account_holders_name'))
	->where('s.status = "ACTIVE"')
	->order(array('p.fname', 'p.lname'));
*/	
$pages->items_total = $db->fetchOne("select count(total_count) as total_all FROM "
	. "( SELECT count(*) total_count FROM personal p LEFT JOIN subcontractors s ON s.userid=p.userid "
	. "WHERE s.status='ACTIVE' group by p.userid) cnt");

$pages->mid_range = 7;
$pages->items_per_page = 50;
$pages->paginate();

$query = "SELECT p.* FROM personal p LEFT JOIN subcontractors s ON s.userid=p.userid "
. "WHERE s.status='ACTIVE' group by p.userid order by p.fname, p.lname ".$pages->limit;

$personnel_info = $db->fetchAll($query);


$smarty->assign('personnel_info', $personnel_info);
$smarty->assign('ipp', $pages->low);
$smarty->assign('items_total', $pages->items_total);
$smarty->assign('pages', $pages->display_pages());
$smarty->assign('jump_menu', $pages->display_jump_menu());
$smarty->assign('items_pp', $pages->display_items_per_page());
$smarty->display($page.".tpl");

?>