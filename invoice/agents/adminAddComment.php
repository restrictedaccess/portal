<?php
    //upon successfull insertion of comment,  return the comments
    include("../../conf.php");
   require("../../lib/Smarty/libs/Smarty.class.php");
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
    $comment = $_POST['comment'];

    if (($invoice_id == "") or ($invoice_id == null)) {
        die("Invoice ID missing.");
    }

    if (($comment == "") or ($comment == null)) {
        die("Comment missing.");
    }


    //insert record on the subcon_invoice_comments
    $query = "INSERT INTO agent_invoice_comments (agent_invoice_id, comment, commented_by_id, commented_by_type) VALUES ($invoice_id, '$comment', $admin_id, 'admin')";
    $dbh->exec($query);

    //query all comment records
    function GetName($admin_id, $user_type) {
        global $dbh;
        if ($user_type == 'admin') {
            $query = "SELECT admin_fname FROM admin WHERE admin_id = $admin_id";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return "@" . $result['admin_fname'];
        }
        else {
            $query = "SELECT fname FROM agent WHERE agent_no = $admin_id";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return $result['fname'];
        }
    }

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
    $smarty->assign('invoice_comments', $invoice_comments);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminAddComment.tpl');
?>
