<?php
//2010-02-25 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  strip slashes on invoice notes
//2009-08-18 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  send email on posting notes
//  modified to conform to the new standards
//upon successfull insertion of comment,  return the comments

    require("../conf/zend_smarty_conf.php");
    require("../lib/validEmail.php");

    $userid = $_SESSION['userid']; 
    if ($userid == null){
        die('Invalid user id');
    }

    $invoice_id = $_POST['invoice_id'];
    $comment = trim(stripslashes($_POST['comment']));

    if (($invoice_id == "") or ($invoice_id == null)) {
        die("Invoice ID missing.");
    }

    if (($comment == "") or ($comment == null)) {
        die("Comment missing.");
    }


    //insert record on the subcon_invoice_comments
    $data = array(
        'subcon_invoice_id' => $invoice_id,
        'comment'           => $comment,
        'commented_by_id'   => $userid,
        'commented_by_type' => 'subcon'
    );
    $db->insert('subcon_invoice_comments', $data);

    
    //query all comment records
    function GetName($userid, $user_type) {
        global $db;
        if ($user_type == 'admin') {
            $sql = "select admin_fname from admin where admin_id = $userid";
            return "@" . $db->fetchOne($sql);
        }
        else {
            $sql = "select fname from personal where userid = $userid";
            return $db->fetchOne($sql);
        }
    }

    //query invoice comments
    $sql = "select id, comment, commented_by_id, commented_by_type from subcon_invoice_comments where subcon_invoice_id = ? order by comment_date desc";
    $result = $db->fetchAll($sql, $invoice_id);

    $invoice_comments = array();
    forEach ($result as $record) {
        $name = GetName($record['commented_by_id'], $record['commented_by_type']);
        $new_record = $record;
        $new_record['commented_by'] = $name;
        $invoice_comments[] = $new_record;
    }


    //send email
    $subcon_name = GetName($userid, 'subcon');
    $subcon_email = trim($db->fetchOne("select email from personal where userid = $userid"));
    $now = new DateTime();
    $now_date_time_str = $now->format("Y-m-d H:i:s");

    $mail = new Zend_Mail();
    $mail->setBodyText("Noted By: $subcon_name\nNoted On: $now_date_time_str\nInvoice ID: $invoice_id\n\n$comment");
    $mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
    if (TEST) {
        $mail->addTo('devs@remotestaff.com.au');
    }
    else {
        $mail->addTo($subcon_email);
    }
    $mail->setSubject("Invoice Note by $subcon_name on Invoice # $invoice_id");

    //get admin emails 
    $select = $db->select()
        ->from('admin', 'admin_email')
        ->where('notify_invoice_notes = "Y"');

    $result = $db->fetchCol($select);

    //loop to add admin emails
    if (! TEST) {
        forEach($result as $admin_email) {
            if (validEmail($admin_email)) {
                $mail->addTo($admin_email);
            }
        }
    }

    //send it
    $mail->send($transport);

    $smarty = new Smarty();
    $smarty->assign('invoice_comments', $invoice_comments);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    $smarty->display('adminAddComment.tpl');
?>
