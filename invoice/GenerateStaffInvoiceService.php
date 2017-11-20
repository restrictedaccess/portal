<?php
//  2011-07-18  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Throw an exception if this backend is used
//  2009-11-30  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Tracking of invoice_details added
//  2009-11-27  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Tracking of invoices added
//  2009-10-23  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack

require('../conf/zend_smarty_conf.php');

class LoginAdmin {
    public function login($email, $password) {
        global $db;
#TODO add hash on verification
        $sql = $db->select()
                ->from('admin')
                ->where('admin_email = ?', $email)
                ->where('admin_password = ?', $password);
        $result = $db->fetchAll($sql);
        if (count($result) == 0) {
            return 'Invalid Login';
        }
        $_SESSION['admin_id'] =$result[0]['admin_id']; 
        $_SESSION['status'] =$result[0]['status']; 
        return "OK";
    }
}


class GenerateStaffInvoice {
    function __construct() {
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        throw new Exception('This is the old backend service. Please clear your browser cache and relogin.');
        if ($admin_id == "") {
            throw new Exception('Please Login');
        }
        $this->admin_id = $admin_id;
    }


    public function get_months() {
        $date_today = new Zend_Date();
        $current_month_date = new Zend_Date($date_today->toString('YYYY-MM-01 00:00:00'), Zend_Date::ISO_8601);

        $timesheet_months = array();

        for($i = -12; $i < 4; $i++) {
            $date_temp = clone $current_month_date;
            $date_temp->add($i, Zend_Date::MONTH);
            $selected = '';
            $label = $date_temp->toString('MMMM YYYY');
            if ($current_month_date == $date_temp) {
                $selected = 'selected';
                $label = 'Current Month';
            }
            $timesheet_months[] = array('date' => $date_temp->toString('YYYY-MM-01'), 'label' => $label, 'selected' => $selected);
        }
        return $timesheet_months;
    }


    public function get_draft_invoice() {
        global $db;
        $sql = $db->select()
            ->from('subcon_invoice')
            ->where('status = "draft"')
            ->order("description");

        $data = $db->fetchAll($sql);
        return $data;
    }


    public function get_time_sheets() {
        global $db;
        //get timesheet_details
        $sql = $db->select()
                ->from(array("t" => "timesheet"), array("id", "month_year", "userid", "leads_id", "subcontractors_id"))
                ->join(array("p" => "personal"), "t.userid = p.userid", array("personal_fname" => "fname", "personal_lname" => "lname"))
                ->join(array("l" => "leads"), "t.leads_id = l.id", array("leads_fname" => "fname", "leads_lname" => "lname"))
                ->join(array("s" => "subcontractors"), "t.subcontractors_id = s.id", array("subcontractors_id" => "id", "php_hourly" => "php_hourly"))
                ->where('t.notify_staff_invoice_generator = "Y"')
                ->order(array("p.fname", "p.lname"));

        $timesheets_data = $db->fetchAll($sql);

        //loop over timesheet_data to retrieve total hours
        $i = 0;
        foreach ($timesheets_data as $data) {
            $month = new Zend_Date($data['month_year'], "YYYY-MM-dd");
            $sql = $db->select()
                ->from("timesheet_details", array('sum_hrs_to_be_subcon' => "SUM(hrs_to_be_subcon)", 'sum_adj_hrs' => "SUM(adj_hrs)"))
                ->where("timesheet_id = ?", $data['id']);
            $result = $db->fetchRow($sql);
            $sum_hrs_to_be_subcon = $result['sum_hrs_to_be_subcon'];
            $timesheets_data[$i]['sum_hrs_to_be_subcon'] = $sum_hrs_to_be_subcon;
            $timesheets_data[$i]['invoiced_hrs'] = $sum_hrs_to_be_subcon;
            $sum_adj_hrs = $result['sum_adj_hrs'];
            $timesheets_data[$i]['sum_adj_hrs'] = $sum_adj_hrs;
            $amount = $sum_hrs_to_be_subcon * $data['php_hourly'];
            $timesheets_data[$i]['amount'] = $amount;
            $timesheets_data[$i]['amount_str'] = number_format($amount, 2, ".", ",");
            $timesheets_data[$i]['timesheet_month'] = $month->toString('MMMM'); 
            $timesheets_data[$i]['description'] = sprintf("%s %s - %s ", $data['leads_fname'], $data['leads_lname'], $month->toString('MMMM')); 
            $timesheets_data[$i]['adjustment'] = 'N'; 
            //$timesheets_data[$i]['description'] = sprintf("%s %s - %s " % array($data['leads_fname'], $data['leads_lname'], $month->toString('MMMM'))); 

            //check if records exist on timesheet_subcon_invoice_tracking table
            $sql = $db->select()
                ->from('timesheet_subcon_invoice_tracking')
                ->where("timesheet_id = ?", $data['id']);
            $previous_invoices = $db->fetchAll($sql);
            if (count($previous_invoices) != 0) {
                $invoiced_hrs = $sum_adj_hrs - $sum_hrs_to_be_subcon;
                //check on the previous invoices if there is an adjustment already
                foreach ($previous_invoices as $previous_invoice) {
                    if ($previous_invoice['adjustment'] == 'Y') {
                        //subtract the hours
                        $invoiced_hrs -= $previous_invoice['invoiced_hrs'];
                    }
                }

                $timesheets_data[$i]['invoiced_hrs'] = number_format($invoiced_hrs, 2, ".", "");
                $amount = $invoiced_hrs * $data['php_hourly'];
                $timesheets_data[$i]['amount'] = $amount;
                $timesheets_data[$i]['amount_str'] = number_format($amount, 2, ".", ",");
                $timesheets_data[$i]['description'] = sprintf("%s %s - %s Adjustments", $data['leads_fname'], $data['leads_lname'], $month->toString('MMMM')); 
                $timesheets_data[$i]['adjustment'] = 'Y'; 
            }

            $i++;
        }
    
        return $timesheets_data;
    }


    public function create_invoice($userid, $description, $invoice_date, $total_amount, $invoice_details) {
        global $db;

        $now = new Zend_Date();

        $invoice_date = new Zend_Date($invoice_date, 'YYYY-MM-dd');
        $month = $invoice_date->toString("MMMM");

        //get payment details
        $sql = $db->select()
                ->from('personal', 'payment_details')
                ->where('userid = ?', $userid);
        $payment_details = sprintf("%s", $db->fetchOne($sql));

        $data = array(
            'userid' => $userid,
            'description' => $description . $month,
            'status' => 'draft',
            'draft_date' => $now->toString("YYYY-MM-dd"),
            'payment_details' => $payment_details,
            'drafted_by' => $_SESSION['admin_id'],
            'drafted_by_type' => 'admin',
            'total_amount' => $total_amount,
            'invoice_date' => $invoice_date->toString('YYYY-MM-dd'),
        );

        $db->insert('subcon_invoice', $data);
        $subcon_invoice_id = $db->lastInsertId();

        //invoice details
        $i = 1;
        foreach ($invoice_details as $invoice_detail) {
            $qty = $invoice_detail['qty'];
            $unit_price = $invoice_detail['unit_price'];
            $amount = $qty * $unit_price;
            $data = array(
                'subcon_invoice_id' => $subcon_invoice_id,
                'item_id' => $i,
                'description' => $invoice_detail['description'],
                'subcontractors_id' => $invoice_detail['subcontractors_id'],
                'qty' => $qty,
                'unit_price' => $unit_price,
                'amount' => $amount,
            );
            $db->insert('subcon_invoice_details', $data);
            $subcon_invoice_details_id = $db->lastInsertId();

            //timesheet/invoice tracking
            $data = array(
                'timesheet_id' => $invoice_detail['id'],
                'subcon_invoice_id' => $subcon_invoice_id,
                'subcon_invoice_details_id' => $subcon_invoice_details_id,
                'invoiced_hrs' => $qty,
                'sum_adj_hrs' => $invoice_detail['sum_adj_hrs'],
                'sum_hrs_to_be_subcon' => $invoice_detail['sum_hrs_to_be_subcon'],
                'adjustment' => $invoice_detail['adjustment'],
                'date_linked' => $now->toString("YYYY-MM-dd HH:mm:ss"),
            );
            $db->insert('timesheet_subcon_invoice_tracking', $data);

            //set the notifier so that it won't show up again
            $data = array(
                'notify_staff_invoice_generator' => 'N',
            );
            $timesheet_id = $invoice_detail['id'];
            $db->update('timesheet', $data, "id = $timesheet_id");

            //add record to history
            $data = array(
                'timesheet_id' => $timesheet_id,
                'changes' => 'notify_staff_invoice_generator set to "N"',
                'changed_by_id' => $this->admin_id,
                'date_changed' => $now->toString("YYYY-MM-dd HH:mm:ss"),
            );
            $db->insert('timesheet_history', $data);

            $i++;
        }

        return 'ok';
    }

    public function remove_from_list($timesheet_ids) {
        global $db;
        $now = new Zend_Date();
        foreach ($timesheet_ids as $timesheet_id) {
            $data = array(
                'notify_staff_invoice_generator' => 'N',
            );
            $db->update('timesheet', $data, "id = $timesheet_id");

            //add history
            $data = array(
                'timesheet_id' => $timesheet_id,
                'changes' => 'notify_staff_invoice_generator set to "N"',
                'changed_by_id' => $this->admin_id,
                'date_changed' => $now->toString("YYYY-MM-dd HH:mm:ss"),
            );
            $db->insert('timesheet_history', $data);

        }
        return 'ok';
    }
}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
if ($method == 'login') {
    $server->setClass('LoginAdmin');
}
else {
    $server->setClass('GenerateStaffInvoice');
}
$server->handle();
?>
