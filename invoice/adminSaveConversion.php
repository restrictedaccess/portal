<?php
    //upon successfull insertion of salary conversion
	
    include("../conf.php");
    require("../lib/Smarty/libs/Smarty.class.php");
    date_default_timezone_set("Asia/Manila");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    $invoice_id = $_POST['invoice_id'];
    $converted_amount = $_POST['converted_amount'];
	$input_currency = $_POST['input_currency'];

    if (($invoice_id == "") or ($invoice_id == null)) {
        die("Invoice ID missing.");
    }

    if (($converted_amount == "") or ($converted_amount == null)) {
        die("Converted Amount is missing.");
    }
	
	if (($input_currency == "") or ($input_currency == null)) {
        die("Exchange Rate is missing.");
    }


    //INSERT THE CONVERSION MADE on the subcon_invoice table
    $query = "UPDATE subcon_invoice SET converted_amount = '$converted_amount', exchange_rate = '$input_currency' WHERE  id= $invoice_id;";
    $dbh->exec($query);

   /*
    //query all comment records
    function GetName($userid, $user_type) {
        global $dbh;
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

   $query = "select p.lname, p.fname, p.email, s.description, s.payment_details, s.status, s.invoice_date, s.start_date, s.end_date, s.total_amount,s.converted_amount,s.exchange_rate from subcon_invoice as s left join personal as p on s.userid = p.userid where s.id = $invoice_id";
    $data = $dbh->query($query);
    $result = $data->fetch();
    $subcon_name = $result['lname'] . ", " . $result['fname'];

    //query invoice details
    $query = "select id, item_id, description, amount from subcon_invoice_details where subcon_invoice_id = $invoice_id order by item_id";
    $data = $dbh->query($query);
    $invoice_details = $data->fetchAll();

    //query invoice comments
    $query = "select id, comment, commented_by_id, commented_by_type from subcon_invoice_comments where subcon_invoice_id = $invoice_id order by comment_date desc";
    $data = $dbh->query($query);
    $invoice_comments = array();
    forEach ($data->fetchAll() as $record) {
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
	$smarty->assign('converted_amount', $result['converted_amount']);
	$smarty->assign('exchange_rate', $result['exchange_rate']);
	*/
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    //$smarty->display('adminGetInvoiceDetails.tpl');
	
?>
