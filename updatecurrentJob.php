<?php
//2010-08-17    Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   check for existing records, create if none
//2010-08-12    Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   major re-write

require('conf/zend_smarty_conf.php');
require('lib/htmlpurifier/HTMLPurifier.standalone.php');

if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}
$userid = $_SESSION['userid'];
if ($userid == '') {
    die('session missing');
}

$purifier = new HTMLPurifier();
if ($_POST) {
    $fields_to_purify = Array('freshgrad',
        'years_worked',
        'months_worked',
        'intern_status',
        'iday',
        'imonth',
        'iyear',
        'intern_notice',
        'available_status',
        'available_notice',
        'aday',
        'amonth',
        'ayear',
        'salary_currency',
        'expected_salary',
        'expected_salary_neg',
        'companyname',
        'position',
        'monthfrom',
        'yearfrom',
        'monthto',
        'yearto',
        'duties',
        'companyname2',
        'position2',
        'monthfrom2',
        'yearfrom2',
        'monthto2',
        'yearto2',
        'duties2',
        'companyname3',
        'position3',
        'monthfrom3',
        'yearfrom3',
        'monthto3',
        'yearto3',
        'duties3',
        'companyname4',
        'position4',
        'monthfrom4',
        'yearfrom4',
        'monthto4',
        'yearto4',
        'duties4',
        'companyname5',
        'position5',
        'monthfrom5',
        'yearfrom5',
        'monthto5',
        'yearto5',
        'duties5',
        'latest_job_title',
        'companyname6',
        'position6',
        'monthfrom6',
        'yearfrom6',
        'monthto6',
        'yearto6',
        'duties6',
        'companyname7',
        'position7',
        'monthfrom7',
        'yearfrom7',
        'monthto7',
        'yearto7',
        'duties7',
        'companyname8',
        'position8',
        'monthfrom8',
        'yearfrom8',
        'monthto8',
        'yearto8',
        'duties8',
        'companyname9',
        'position9',
        'monthfrom9',
        'yearfrom9',
        'monthto9',
        'yearto9',
        'duties9',
        'companyname10',
        'position10',
        'monthfrom10',
        'yearfrom10',
        'monthto10',
        'yearto10',
        'duties10',
    );

    $data = Array();
    foreach($fields_to_purify as $field) {
        $$field = $purifier->purify(stripslashes($_POST[$field]));
        $data[$field] = $$field;
    }

    //check if record exist, insert if it doesn't
    $sql = $db->select()
            ->from('currentjob', 'userid')
            ->where('userid = ?', $userid);
    $currentjob_exists = $db->fetchAll($sql);

    if ($currentjob_exists) {
        $db->update('currentjob', $data, "userid = $userid");
    }
    else {
        $data['userid'] = $userid;
        $db->insert('currentjob', $data);
    }

    echo "<script>alert('Employment history updated!');window.location = 'myresume.php';</script>";
    die();
}

//retrieve the latest
$sql = $db->select()
        ->from('currentjob')
        ->where('userid = ?', $userid)
        ->order('id desc')
        ->limit(1);

$currentjob = $db->fetchRow($sql);


header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=utf-8");

$month_array = Array('', 'Current Month', 'JAN', 'FEB', 'MAR', 'APR',
    'MAY', 'JUN', 'JUL', 'AUG', 'SEP',
    'OCT', 'NOV', 'DEC');

$currency_array = Array("Australian Dollar","Bangladeshi Taka",
    "British Pound","Chinese RenMinBi","Euro","HongKong Dollar",
    "Indian Rupees","Indonesian Rupiah","Japanese Yen",
    "Malaysian Ringgit","New Zealand Dollar","Philippine Peso",
    "Singapore Dollar","Thai Baht","US Dollars","Vietnam Dong");   

$now = new DateTime();
$current_year = $now->format('Y') + 1;

$smarty = new Smarty();
$smarty->assign('currentjob', $currentjob);
$smarty->assign('month_array', $month_array);
$smarty->assign('current_year', $current_year);
$smarty->assign('currency_array', $currency_array);

$smarty->display('updatecurrentJob.tpl');
