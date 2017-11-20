<?php
    include("../../conf.php");
    require("../../lib/Smarty/libs/Smarty.class.php");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    $invoice_id = $_GET['invoice_id'];
    if (($invoice_id == null) or ($invoice_id == '')){
        die('Invalid Invoice ID');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    date_default_timezone_set("Asia/Manila");

    function GetName($userid, $user_type) {
        global $dbh;
        if ($user_type == 'admin') {
            $query = "select admin_fname from admin where admin_id = $userid";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return "@" . $result['admin_fname'];
        }
        else {
            $query = "select fname from agent where agent_no = $userid";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return $result['fname'];
        }
    }

    // modified the query by Normaneil 10/24/2008  Added : s.converted_amount,s.exchange_rate
	
    $query = "SELECT p.lname, p.fname, p.email, s.description, s.payment_details, s.status, s.invoice_date, s.start_date, s.end_date, s.total_amount,s.converted_amount,s.percent FROM agent_invoice AS s LEFT JOIN agent AS p ON s.agentid = p.agent_no WHERE s.id = $invoice_id";
    $data = $dbh->query($query);
    $result = $data->fetch();
    $agent_name = $result['fname'] . " " . $result['lname'];
	//
	//query invoice details
    $query = "SELECT id, item_id, description, amount, counter FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id ORDER BY item_id";
    $data = $dbh->query($query);
    $invoice_details = $data->fetchAll();

    //query invoice comments
    $query = "SELECT id, comment, commented_by_id, commented_by_type FROM agent_invoice_comments WHERE agent_invoice_id = $invoice_id ORDER BY comment_date desc";
    $data = $dbh->query($query);
    $invoice_comments = array();
    forEach ($data->fetchAll() as $record) {
        $name = GetName($record['commented_by_id'], $record['commented_by_type']);
        $new_record = $record;
        $new_record['commented_by'] = $name;
        $invoice_comments[] = $new_record;
    }


    $smarty = new Smarty();
    $smarty->assign('agent_name', $agent_name);
    $smarty->assign('description', $result['description']);
    $smarty->assign('payment_details', $result['payment_details']);
    $smarty->assign('status', $result['status']);
	
	//
	$smarty->assign('converted_amount', $result['converted_amount']);
	$smarty->assign('percent', $result['percent']);
	
    $smarty->assign('invoice_id', $invoice_id);
    $smarty->assign('invoice_date', $result['invoice_date']);
    $smarty->assign('start_date', $result['start_date']);
    $smarty->assign('end_date', $result['end_date']);
    $smarty->assign('total_amount', $result['total_amount']);
    $smarty->assign('invoice_details', $invoice_details);
    $smarty->assign('invoice_comments', $invoice_comments);
		 
	
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminGetInvoiceDetails.tpl');
?>
