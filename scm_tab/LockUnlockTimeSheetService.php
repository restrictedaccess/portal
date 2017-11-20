<?php
//  2013-11-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add permission to lock/unlock timesheet
//  2013-11-09 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bug fix due to php upgrade
//  2009-09-28 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack, JSON-RPC service
require('../conf/zend_smarty_conf.php');

class LockUnlockTimeSheet {
    function __construct() {
        global $db;
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            $response = new Zend_Json_Server_Error();
            $response->setMessage("Please Login");
            $response->setData("Session not found!");
            throw new Exception($response);
            return $response;
        }

        //check if admin has permission
        $sql = $db->select()
            ->from(array('a' => 'admin'), array('lock_unlock_timesheet'))
            ->where('a.admin_id = ?', $admin_id);
        $lock_unlock_timesheet = $db->fetchOne($sql);
        if ($lock_unlock_timesheet != "Y") {
            $response = new Zend_Json_Server_Error();
            $response->setMessage("Permission Denied");
            $response->setData("You are not allowed to lock or unlock timesheet!");
            throw new Exception($response);
            return $response;
        }

    }


    public function get_months() {
        $date_today = new Zend_Date();
        $current_month_date = new Zend_Date($date_today->toString('yyyy-MM-01 00:00:00'), Zend_Date::ISO_8601);

        $timesheet_months = array();

        for($i = -12; $i < 4; $i++) {
            $date_temp = clone $current_month_date;
            $date_temp->add($i, Zend_Date::MONTH);
            $selected = '';
            $label = $date_temp->toString('MMMM yyyy');
            if ($current_month_date == $date_temp) {
                $selected = 'selected';
                $label = 'Current Month';
            }
            $timesheet_months[] = array('date' => $date_temp->toString('yyyy-MM-01'), 'label' => $label, 'selected' => $selected);
        }
        return $timesheet_months;
    }


    public function get_time_sheet($date, $status) {
        global $db;
        $sql = $db->select()
            ->from(array('t' => 'timesheet'))
            ->join(array('p' => 'personal'), ('t.userid = p.userid'), array('staff_fname' => 'fname', 'staff_lname' => 'lname'))
            ->join(array('l' => 'leads'), ('t.leads_id = l.id'), array('client_fname' => 'fname', 'client_lname' => 'lname'))
            ->where('t.month_year = ?', $date . ' 00:00:00')
            ->where('t.status = ?', $status);
        $time_sheets = array();
        foreach ($db->fetchAll($sql) as $time_sheet) {
            $time_sheets[] = array(
                'staff_fname' => ucwords(strtolower($time_sheet['staff_fname'])),
                'staff_lname' => ucwords(strtolower($time_sheet['staff_lname'])),
                'client_fname' => ucwords(strtolower($time_sheet['client_fname'])),
                'client_lname' => ucwords(strtolower($time_sheet['client_lname'])),
                'id' => $time_sheet['id'],
            );
        }
        sort($time_sheets);
        return $time_sheets;
    }


    public function change_status($id, $status) {
        global $db;
        $now = new Zend_Date();
        $admin_id = $_SESSION['admin_id'];
        $data = array(
            'status' => $status
        );
        $db->update('timesheet', $data, "id = $id");

        $data = array(
            'timesheet_id' => $id,
            'changes' => "status set to $status",
            'changed_by_id' => $admin_id,
            'date_changed' => $now->toString("yyyy-MM-dd HH:mm:ss")
        );

        $db->insert('timesheet_history', $data);
        return "OK";
    }
}

$server = new Zend_Json_Server();
$server->setClass('LockUnlockTimeSheet');
$server->handle();
?>
