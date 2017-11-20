<?php
    //upon successfull insertion of comment,  return the comments
   include("../../conf.php");
     require("../../lib/Smarty/libs/Smarty.class.php");
	
 session_start();
   $agentid = $_SESSION['agent_no'];
    if ($agentid == null){
        die('Invalid user id');
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
    $query = "insert into agent_invoice_comments (agent_invoice_id, comment, commented_by_id, commented_by_type) values ($invoice_id, '$comment', $agentid, 'subcon')";
    $dbh->exec($query);

    //query all comment records
    function GetName($agentid, $user_type) {
        global $dbh;
        if ($user_type == 'admin') {
            $query = "select admin_fname from admin where admin_id = $agentid";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return "@" . $result['admin_fname'];
        }
        else {
            $query = "select fname from agent where agent_no = $agentid";
            $data = $dbh->query($query);
            $result = $data->fetch();
            return $result['fname'];
        }
    }

    //query invoice comments
    $query = "select id, comment, commented_by_id, commented_by_type from agent_invoice_comments where agent_invoice_id = $invoice_id order by comment_date desc";
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
