<?php
    //2008-09-25 Lawrence Sunglao <locsunglao@yahoo.com>
    //grabbed payment details from the personal table
    include("../conf.php");
    require("../lib/Smarty/libs/Smarty.class.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    $mode = $_GET['mode'];
    if (($mode == null) or ($mode == '')){
        die('Invalid mode');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    date_default_timezone_set("Asia/Manila");

    $query = "select distinct(s.userid), p.fname, p.lname, p.payment_details from subcontractors as s left join personal as p on s.userid=p.userid where s.status='ACTIVE' order by fname, lname";
    $data = $dbh->query($query);
    $subcontractors = $data->fetchAll();

    $subcontractor_ids = array();
    $subcontractor_names = array();
    $subcontractor_fnames = array();
    $subcontractor_payment_details = array();
    $subcontractor_ids[] = 'None';
    $subcontractor_names[] = '-- Select Subcontractor --';
    $subcontractor_fnames[] = '';
    $subcontractor_payment_details[] = '';

    forEach ($subcontractors as $subcon) {
        $subcontractor_ids[] = $subcon['userid'];
        $subcontractor_names[] = $subcon['fname'] . ' ' . $subcon['lname'];
        $subcontractor_fnames[] = $subcon['fname'];
        $subcontractor_payment_details[] = $subcon['payment_details'];
    }

    $now = new DateTime();
    $now_str = $now->format('Y-m-d');
    $date_start = $now->format('Y-m-01');
    $date_end = $now->format('Y-m-t');
    $current_month = $now->format('F');

    $smarty = new Smarty();
    $smarty->assign('subcontractors', $subcontractors);
    $smarty->assign('mode', $mode);
    $smarty->assign('subcontractor_names', $subcontractor_names);
    $smarty->assign('subcontractor_fnames', $subcontractor_fnames);
    $smarty->assign('subcontractor_ids', $subcontractor_ids);
    $smarty->assign('subcontractor_payment_details', $subcontractor_payment_details);
    $smarty->assign('now_str', $now_str);
    $smarty->assign('date_start', $date_start);
    $smarty->assign('date_end', $date_end);
    $smarty->assign('current_month', $current_month);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminGetNewInvoiceForm.tpl');
?>
