<?php
//  2010-04-23  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack

require('../conf/zend_smarty_conf.php');

class LoginAdmin {
    public function login($email, $password) {
        global $db, $logger_admin_login;
        $password = sha1($password);
        $sql = $db->select()
                ->from('admin')
                ->where('admin_email = ?', $email)
                ->where('admin_password = ?', $password);
        $result = $db->fetchAll($sql);
        if (count($result) == 0) {
            $details = sprintf("FAILED %s %s %s'", $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $email);
            $logger_admin_login->info("$details");
            return 'Invalid Login';
        }
        $details = sprintf("LOGIN %s %s %s'", $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $email);
        $logger_admin_login->info("$details");
        $_SESSION['admin_id'] =$result[0]['admin_id']; 
        $_SESSION['status'] =$result[0]['status']; 
        return "OK";
    }
}


class IremitSender {
    function __construct() {
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            throw new Exception('Please Login');
        }
        $this->admin_id = $admin_id;
    }


    public function get_staff_and_sender_list() {
        global $db;
        //get staff that's already on the list
        $sql = $db->select()
            ->from(array('i' =>'iremit_sender_data'), array('userid', 'sender_id'))
            ->joinLeft(array('p' => 'personal'), 'i.userid = p.userid', array('fname', 'lname'))
            ->order(array('p.fname', 'p.lname'));
        $staff_on_list = $db->fetchAll($sql);

        //get list of sender
        $sql = $db->select()
            ->from('iremit_sender_lookup')
            ->order(array('first_name', 'last_name'));
        
        $senders = $db->fetchAll($sql);

        //get the list of existing userids
        $existing_userid = array();
        foreach ($staff_on_list as $staff) {
            $existing_userid[] = $staff['userid'];
        }

        //query the subcontractors that are active but not on existing_userid
        $sql = $db->select()
            ->distinct()
            ->from(array('s' => 'subcontractors'), 'userid')
            ->joinLeft(array('p' => 'personal'), 's.userid = p.userid', array('userid', 'fname', 'lname'))
            ->where('s.status = "ACTIVE"')
            ->order(array('p.fname', 'p.lname'));

        if (count($existing_userid) > 0) {
            $sql->where('s.userid NOT IN (?)', $existing_userid);
        }
        $not_on_the_list = $db->fetchAll($sql);

        return array('staff_on_list' => $staff_on_list,
            'senders' => $senders,
            'not_on_the_list' => $not_on_the_list);
    }


    public function set_sender($sender_id, $selected_staffs) {
        global $db;
        foreach ($selected_staffs as $userid) {
            $sql = $db->select()
                    ->from("iremit_sender_data")
                    ->where("userid = ?", $userid);
            $iremit_sender_data = $db->fetchAll($sql);

            $data = array (
                "userid" => $userid,
                "sender_id" => $sender_id
            );
            if (count($iremit_sender_data) == 0) {
                $db->insert("iremit_sender_data", $data);
            }
            else {
                $iremit_sender_data_id = $iremit_sender_data[0]['id'];
                $db->update("iremit_sender_data", $data, "id = $iremit_sender_data_id");
            }
        }
    }
}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
if ($method == 'login') {
    $server->setClass('LoginAdmin');
}
else {
    $server->setClass('IremitSender');
}
$server->handle();
?>
