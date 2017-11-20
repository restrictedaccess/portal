<?php
    include("../conf.php");
    require("../lib/Smarty/libs/Smarty.class.php");
	$userid = $_SESSION['userid']; 

    if (($userid == "") or ($userid == null)) {
        die("userid missing.");
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
            $result = $data->fetch();
            return "@" . $result['admin_fname'];
        }
        else {
            $query = "select fname from personal where userid = $userid";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return $result['fname'];
        }
    }

    $query = "select p.lname, p.fname, p.email, s.description, s.payment_details, s.status, s.invoice_date, s.start_date, s.end_date, s.total_amount, s.updated_by_type from subcon_invoice as s left join personal as p on s.userid = p.userid where s.id = $invoice_id";
    $data = $dbh->query($query);
    $result = $data->fetch();
    $subcon_name = $result['lname'] . ", " . $result['fname'];
    $updated_by_type = $result['updated_by_type'];

    //query invoice details
    $query = "select id, item_id, description, amount from subcon_invoice_details where subcon_invoice_id = $invoice_id order by item_id";
    $invoice_details = $dbh->query($query)->fetchAll();
//    $invoice_details = $data->fetchAll();

    //query invoice comments
    $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
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
    $smarty->assign('updated_by_type', $updated_by_type);
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

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('subconGetInvoiceDetails.tpl');
?>
