<?php
    include("../../conf.php");
    require("../../lib/Smarty/libs/Smarty.class.php");
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

    $query = "SELECT DISTINCT(agent_no), fname, lname FROM agent WHERE status='ACTIVE' AND work_status ='AFF' ORDER BY fname";
	
    $data = $dbh->query($query);
    $agents = $data->fetchAll();

    $agent_ids = array();
    $agent_names = array();
    forEach ($agents as $agent) {
        $agent_ids[] =$agent['agent_no'];
        $agent_names[] = $agent['fname'] . ' ' . $agent['lname'];
    }

    $now = new DateTime();
    $now_str = $now->format('Y-m-d');
    $date_start = $now->format('Y-m-01');
    $date_end = $now->format('Y-m-t');
    $current_month = $now->format('F');

    $smarty = new Smarty();
    $smarty->assign('agents', $agents);
    $smarty->assign('mode', $mode);
    $smarty->assign('agent_names', $agent_names);
    $smarty->assign('agent_ids', $agent_ids);
    $smarty->assign('now_str', $now_str);
    $smarty->assign('date_start', $date_start);
    $smarty->assign('date_end', $date_end);
    $smarty->assign('current_month', $current_month);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminAffGetNewInvoiceForm.tpl');
?>
