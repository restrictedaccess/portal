<?php
    //2009-05-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependecy on fetch
    include("../conf.php");
    require("../lib/Smarty/libs/Smarty.class.php");
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
	global $dbserver, $dbname, $dbuser, $dbpwd;
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
        if ($user_type == 'admin') {
            $query = "select admin_fname from admin where admin_id = $userid";
            $data = $dbh->query($query);
            $result = $data->fetchAll();
            return "@" . $result[0]['admin_fname'];
        }
        else {
            $query = "select fname from personal where userid = $userid";
            $data = $dbh->query($query);
            $result = $data->fetchAll();
            return $result[0]['fname'];
        }
    }

    // modified the query by Normaneil 10/24/2008  Added : s.converted_amount,s.exchange_rate
	
    $query = "select p.lname, p.fname, p.email, s.description, s.payment_details, s.status, s.invoice_date, s.start_date, s.end_date, s.total_amount,s.converted_amount,s.exchange_rate from subcon_invoice as s left join personal as p on s.userid = p.userid where s.id = $invoice_id";
    $data = $dbh->query($query);
    $results = $data->fetchAll();
    $result = $results[0];
    $subcon_name = $result['lname'] . ", " . $result['fname'];

    //query invoice details
    $query = "select id, item_id, description, amount from subcon_invoice_details where subcon_invoice_id = $invoice_id order by item_id";
    $invoice_details = array();
    forEach($dbh->query($query) as $invoice_detail) {
	$invoice_details[] = $invoice_detail;
    }

    //query invoice comments
    $query = "select id, comment, commented_by_id, commented_by_type from subcon_invoice_comments where subcon_invoice_id = $invoice_id order by comment_date desc";
    $data = $dbh->query($query);
    $invoice_comments = array();
    forEach ($data as $record) {
        $name = GetName($record['commented_by_id'], $record['commented_by_type']);
        $new_record = $record;
        $new_record['commented_by'] = $name;
        $invoice_comments[] = $new_record;
    }

    $smarty = new Smarty();
    $smarty->assign('subcon_name', $subcon_name);
    $smarty->assign('description', $result['description']);
    $smarty->assign('payment_details', $result['payment_details']);
    $smarty->assign('status', $result['status']);
    $smarty->assign('invoice_id', $invoice_id);
    $smarty->assign('invoice_date', $result['invoice_date']);
    $smarty->assign('start_date', $result['start_date']);
    $smarty->assign('end_date', $result['end_date']);
    $smarty->assign('amount', $result['total_amount']);
    $smarty->assign('invoice_details', $invoice_details);
    $smarty->assign('invoice_comments', $invoice_comments);
	
	// Added by Normaneil 10/23/2008
	$smarty->assign('converted_amount', $result['converted_amount']);
	$smarty->assign('exchange_rate', $result['exchange_rate']);
	// 
	
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminGetInvoiceDetails.tpl');
?>
