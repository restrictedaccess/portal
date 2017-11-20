<?php
require_once('../conf/zend_smarty_conf.php');
require_once('class_xls.php');
include_once('../ticketmgmt/lib/Utils.php');
include_once('admin_revmonitor_class.php');

$filter_by = isset($_GET['filter_by']) ? $_GET['filter_by'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$contract_status = isset($_GET['contract_status']) ? $_GET['contract_status'] : 'ACTIVE';
$revmon = revenue_monitoring::get_instance($db_query_only, false);

$revmon->php_rates = $PHP_RATES;
//$revmon->admin_manage_confi = $ADMIN_MANAGE_INHOUSE_CONFIDENTIAL_INFO;

if( $contract_status ) $revmon->where_clause['contract_status'] = $contract_status;

if( $search && $search != 'keyword') {
    $revmon->where_clause['filter_by'] = $filter_by;
    $revmon->where_clause['search'] = $search;
}

$xls_fname = $revmon->toXLS();

$utils = Utils::getInstance();
$utils->db = $db;
$admin = $utils->check_admin_session();

$email_body = "<p><strong>Date: </strong>".date("M j, Y H:i a")."</p>"
."<p><strong>Admin: </strong>".$admin['admin_fname']." ".$admin['admin_lname']."<br/>
<strong>Filename: </strong>".$xls_fname.".xls</p>";

$utils->send_email('Subconlist Exporting', $email_body, '', 'Remotestaff Notification', false);
?>