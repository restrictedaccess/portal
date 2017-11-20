<?php
//  2011-12-22  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   used subcontractors.job_designation instead of currentjob.latest_job_title for the invoice description
//  2011-06-30  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   set the start_date of invoice_detail based on timesheet.client_invoice_start_day
//  2011-04-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   updates from the new subcontractor system
//  -   rounded off client_hourly_rate
//  2011-03-30  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   renamed currency_rate field to currency due to normans new subcontractor system
//  2011-03-14  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   add the year into the invoice description
//  2010-05-16  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   exclude GST on accounts that are not on AUD
//  2010-04-15  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   retrieved currency_rate
//  2010-02-02  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Added tracking on pro-rata
//  2010-01-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Tracked using the sum of timesheet_details.diff_charged_to_client
//  2010-01-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on staff without latest_job_title which does not show up
//  -   removed get_months function
//  -   removed logger
//  2009-12-18  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Add 5 days as the default Invoice due date
//  -   Added 10% GST 
//  2009-12-02  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
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


class GenerateClientInvoice {
    const GST = 10;
    function __construct() {
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            throw new Exception('Please Login');
        }
        $this->admin_id = $admin_id;
    }


    public function get_draft_invoice() {
        global $db;
        $sql = $db->select()
            ->from('client_invoice')
            ->where('status = "draft"')
            ->order("description");

        $data = $db->fetchAll($sql);
        return $data;
    }


    public function get_time_sheets() {
        global $db, $logger;
        //get timesheet_details
        $sql = $db->select()
                ->from(array("t" => "timesheet"), array("id", "month_year", "userid", "leads_id", "subcontractors_id"))
                ->joinLeft(array("p" => "personal"), "t.userid = p.userid", array("personal_fname" => "fname", "personal_lname" => "lname"))
                ->joinLeft(array("l" => "leads"), "t.leads_id = l.id", array("leads_fname" => "fname", "leads_lname" => "lname"))
                ->joinLeft(array("s" => "subcontractors"), "t.subcontractors_id = s.id", 
                    array("subcontractors_id" => "id", 
                        "client_price" => "client_price", 
                        "currency" => "currency",
                        "work_status" => "work_status",
                        "latest_job_title" => "job_designation"))
                ->where('t.notify_client_invoice_generator = "Y"')
                ->order(array("l.fname", "l.lname"));


        $timesheets_data = $db->fetchAll($sql);
        $invoice_details = array();

        //loop over timesheet_data to retrieve total hours
        $i = 0;
        foreach ($timesheets_data as $data) {
            $month = new Zend_Date($data['month_year'], "yyyy-MM-dd");
            $sql = $db->select()
                ->from("timesheet_details", array(
                    'sum_hrs_charged_to_client' => "SUM(hrs_charged_to_client)", 
                    'sum_adj_hrs' => "SUM(adj_hrs)",
                    'sum_diff_charged_to_client' => "SUM(diff_charged_to_client)"
                ))
                ->where("timesheet_id = ?", $data['id']);
            $result = $db->fetchRow($sql);
            $sum_hrs_charged_to_client = $result['sum_hrs_charged_to_client'];
            $sum_diff_charged_to_client = $result['sum_diff_charged_to_client'];
            $timesheets_data[$i]['sum_hrs_charged_to_client'] = $sum_hrs_charged_to_client;
            $timesheets_data[$i]['invoiced_hrs'] = $sum_hrs_charged_to_client;
            $sum_adj_hrs = $result['sum_adj_hrs'];
            $timesheets_data[$i]['sum_adj_hrs'] = $sum_adj_hrs;

            $work_status = $data['work_status'];
            if ($work_status == 'Part-Time') {
                $working_hours = 4;
            }
            else {
                $working_hours = 8;
            }

            $working_days = 5;

            try {
                error_reporting(E_ERROR);
                $client_hourly_rate = round(($data['client_price'] * 12 / 52 / $working_days / $working_hours), 2);
            }
            catch (Exception $e){
                $client_hourly_rate = 0;
            }

            //get currentjob.latest_job_title to be added on description
            $latest_job_title = $data['latest_job_title'];

            $timesheets_data[$i]['client_hourly_rate'] = number_format($client_hourly_rate, 2, ".", "");
            $amount = $sum_hrs_charged_to_client * $client_hourly_rate;
            $timesheets_data[$i]['amount'] = number_format($amount, 2, ".", "");
            $timesheets_data[$i]['amount_str'] = number_format($amount, 2, ".", ",");
            $timesheets_data[$i]['timesheet_month'] = $month->toString('MMMM'); 
            if ($latest_job_title == '') {
                $timesheets_data[$i]['description'] = sprintf("%s %s (%s) ", $data['personal_fname'], $data['personal_lname'], $month->toString('MMMM')); 
            }
            else {
                $timesheets_data[$i]['description'] = sprintf("%s %s [%s] (%s) ", $data['personal_fname'], $data['personal_lname'], $latest_job_title, $month->toString('MMMM')); 
            }
            $timesheets_data[$i]['adjustment'] = 'N'; 

            //grab the first day
            $start_date = new Zend_Date(sprintf("%s-%s-01",$month->toString('yyyy'), $month->toString('MM')), "yyyy-MM-dd" );

            //grab the last day
            $sql = $db->select()
                ->from("timesheet_details", array('end_date' => 'MAX(day)'))
                ->where('timesheet_id = ?', $data['id'])
                ->where('hrs_charged_to_client IS NOT NULL')
                ->where('hrs_charged_to_client != 0');

            $data_end_date = $db->fetchOne($sql);
            if ($data_end_date == '') { //just blank the dates
                $start_date = '';
                $end_date = '';
            }
            else {
                $start_date = $start_date->toString("yyyy-MM-dd"); 
                $end_date = new Zend_Date(sprintf("%s-%s", $month->toString('yyyy-MM'), $data_end_date), "yyyy-MM-dd");
                $end_date = $end_date->toString("yyyy-MM-dd"); 
            }
            $timesheets_data[$i]['start_date'] = $start_date;
            $timesheets_data[$i]['end_date'] = $end_date;

            //obtain total_days_work
            $sql = $db->select()
                ->from("timesheet_details", array('total_days_work' => 'COUNT(*)'))
                ->where('timesheet_id = ?', $data['id'])
                ->where('hrs_charged_to_client IS NOT NULL')
                ->where('hrs_charged_to_client != 0');
            $total_days_work = $db->fetchOne($sql);
            $timesheets_data[$i]['total_days_work'] = $total_days_work;

            //check if records exist on timesheet_client_invoice_tracking table
            $sql = $db->select()
                ->from('timesheet_client_invoice_tracking')
                ->where("timesheet_id = ?", $data['id']);
            $previous_invoices = $db->fetchAll($sql);
            if (count($previous_invoices) == 0) {
                $invoice_details[] = $timesheets_data[$i];
            }
            else {
                //subtract all invoiced hours, get client_invoice_details_id
                $client_invoice_details_id = array();
                foreach ($previous_invoices as $previous_invoice) {
                    $sum_hrs_charged_to_client -= $previous_invoice['invoiced_hrs'];
                    $client_invoice_details_id[] = $previous_invoice['client_invoice_details_id'];
                }

                $timesheets_data[$i]['invoiced_hrs'] = number_format($sum_hrs_charged_to_client, 2, ".", "");
                $amount = $sum_hrs_charged_to_client * $client_hourly_rate;
                $timesheets_data[$i]['amount'] = number_format($amount, 2, ".", "");
                $timesheets_data[$i]['amount_str'] = number_format($amount, 2, ".", ",");
                if ($latest_job_title == '') {
                    $timesheets_data[$i]['description'] = sprintf("%s %s (%s) Remainder/Pro-rata ", $data['personal_fname'], $data['personal_lname'], $month->toString('MMMM')); 
                }
                else {
                    $timesheets_data[$i]['description'] = sprintf("%s %s [%s] (%s) Remainder/Pro-rata ", $data['personal_fname'], $data['personal_lname'], $data['latest_job_title'], $month->toString('MMMM')); 
                }
                $timesheets_data[$i]['adjustment'] = 'Y'; 

                //As per tams request, start date will always be the first of the month invoice
                $start_date = new Zend_Date($data['month_year'], 'yyyy-MM-dd');
                $timesheets_data[$i]['start_date'] = $start_date->toString('yyyy-MM-dd');

                //obtain total_days_work
                $sql = $db->select()
                    ->from("timesheet_details", array('total_days_work' => 'COUNT(*)'))
                    ->where('timesheet_id = ?', $data['id'])
                    ->where('hrs_charged_to_client IS NOT NULL')
                    ->where('hrs_charged_to_client != 0')
                    ->where('day >= ?', $start_date->toString('dd'));
                $total_days_work = $db->fetchOne($sql);
                $timesheets_data[$i]['total_days_work'] = $total_days_work;
                $invoice_details[] = $timesheets_data[$i];


                //tracked using the sum of timesheet_details.diff_charged_to_client
                $timesheets_data[$i]['invoiced_hrs'] = number_format($sum_diff_charged_to_client, 2, ".", "");
                $amount = $sum_diff_charged_to_client * $client_hourly_rate;
                $timesheets_data[$i]['amount'] = number_format($amount, 2, ".", "");
                $timesheets_data[$i]['amount_str'] = number_format($amount, 2, ".", ",");
                if ($latest_job_title == '') {
                    $timesheets_data[$i]['description'] = sprintf("%s %s (%s) Adjustments ", $data['personal_fname'], $data['personal_lname'], $month->toString('MMMM')); 
                }
                else {
                    $timesheets_data[$i]['description'] = sprintf("%s %s [%s] (%s) Adjustments ", $data['personal_fname'], $data['personal_lname'], $data['latest_job_title'], $month->toString('MMMM')); 
                }
                $invoice_details[] = $timesheets_data[$i];
            }

            $i++;
        }
    
        return $invoice_details;
    }


    public function create_invoice($leads_id, $description, $invoice_date, $total_amount, $invoice_details) {
        global $db, $logger;
        /*  TODO debug code please delete
        foreach($invoice_details as $d) {
            $logger->info($d['id']);
        }
        return 'ok';
        */

        //grab subcontrators_id
        $subcontractors_ids = array();
        foreach ($invoice_details as $invoice_detail) {
            $subcontractors_ids[] = $invoice_detail['subcontractors_id'];
        }

        //grab currencies
        $sql = $db->select()
                ->distinct()
                ->from('subcontractors', 'currency')
                ->where('leads_id = ?', $leads_id)
                ->where('id in (?)', $subcontractors_ids);

        $currencies = $db->fetchAll($sql);

        if (count($currencies) == 0) {
            return 'no currency set';
        }

        if (count($currencies) > 1) {
            return 'multiple currency was set';
        }

        $currency = $currencies[0]['currency'];


        $now = new Zend_Date();

        $invoice_date = new Zend_Date($invoice_date, 'yyyy-MM-dd');
        $invoice_payment_due_date = clone $invoice_date;
        $invoice_payment_due_date->add(5, Zend_Date::DAY);
        $month = $invoice_date->toString("MMMM");
        $year = $invoice_date->toString("Y");
        //grab maximum number from clieninvoice_payment_due_datet_invoice.invoice_number
        $sql = $db->select()
            ->from('client_invoice', array('invoice_number' => 'MAX(invoice_number)'));
        $invoice_number = $db->fetchOne($sql);
        $invoice_number += 1;


        $data = array(
            'leads_id' => $leads_id,
            'description' => sprintf("#%s %s %s %s", $invoice_number, $description , $month, $year),
            'drafted_by' => $_SESSION['admin_id'],
            'drafted_by_type' => 'admin',
            'status' => 'draft',
            'draft_date' => $now->toString("yyyy-MM-dd"),
            'last_update_date' => $now->toString("yyyy-MM-dd"),
            'invoice_date' => $invoice_date->toString('yyyy-MM-dd'),
            'invoice_number' => $invoice_number,
            'currency' => $currency,
            'invoice_payment_due_date' => $invoice_payment_due_date->toString('yyy-MM-dd'),
        );

        $db->insert('client_invoice', $data);
        $client_invoice_id = $db->lastInsertId();

        //invoice details
        $i = 1;
        $sub_total = 0;
        foreach ($invoice_details as $invoice_detail) {
            //need to check timesheet.client_invoice_start_day
            $timesheet_id = $invoice_detail['id'];
            $sql = $db->select()
                    ->from('timesheet', array('client_invoice_start_day', 'month_year'))
                    ->where('id = ?', $timesheet_id);
            $ts_result = $db->fetchRow($sql);
            if ($ts_result['client_invoice_start_day'] == null) {
                $start_date = $invoice_detail['start_date'];
            }
            else {
                $month_year = new Zend_Date($ts_result['month_year'], "yyyy-MM-dd");
                $month_year->set($ts_result['client_invoice_start_day'], Zend_Date::DAY);
                $start_date = $month_year->toString("YYYY-MM-dd");
            }

            $qty = $invoice_detail['qty'];
            $unit_price = $invoice_detail['unit_price'];
            $amount = $qty * $unit_price;
            $sub_total += $amount;
            $data = array(
                'client_invoice_id' => $client_invoice_id,
                'start_date' => $start_date,
                'end_date' => $invoice_detail['end_date'],
                'decription' => $invoice_detail['description'],
                //'total_days_work' => $invoice_detail['total_days_work'],
                'qty' => $qty,
                'unit_price' => $unit_price,
                'amount' => $amount,
                'counter' => $i,
                'sub_counter' => $i,
                'subcon_id' => $invoice_detail['subcontractors_id']
            );
            $db->insert('client_invoice_details', $data);
            $client_invoice_details_id = $db->lastInsertId();

            //timesheet/invoice tracking
            $data = array(
                'timesheet_id' => $invoice_detail['id'],
                'client_invoice_id' => $client_invoice_id,
                'client_invoice_details_id' => $client_invoice_details_id,
                'invoiced_hrs' => $qty,
                'sum_adj_hrs' => $invoice_detail['sum_adj_hrs'],
                'sum_hrs_chrge_to_client' => $invoice_detail['sum_hrs_chrge_to_client'],
                'adjustment' => $invoice_detail['adjustment'],
                'date_linked' => $now->toString("yyyy-MM-dd HH:mm:ss"),
            );
            $db->insert('timesheet_client_invoice_tracking', $data);

            //set the notifier so that it won't show up again
            $data = array(
                'notify_client_invoice_generator' => 'N',
            );
            $timesheet_id = $invoice_detail['id'];
            $db->update('timesheet', $data, "id = $timesheet_id");

            //add record to history
            $data = array(
                'timesheet_id' => $timesheet_id,
                'changes' => 'notify_client_invoice_generator set to "N"',
                'changed_by_id' => $this->admin_id,
                'date_changed' => $now->toString("YYYY-MM-dd HH:mm:ss"),
            );
            $db->insert('timesheet_history', $data);

            $i++;
        }

        //update sub_total, gst, total_amount of client invoice
        if ($currency == 'AUD') {   //specific to AUD currency
            $gst = $sub_total * self::GST / 100;
        }
        else {
            $gst = 0;
        }
        $total_amount = $sub_total + $gst;
        $data = array(
            'sub_total' => $sub_total,
            'gst' => $gst,
            'total_amount' => $total_amount
        );
        $sql = $db->update('client_invoice', $data, "id = $client_invoice_id");

        return 'ok';
    }


    public function remove_from_list($timesheet_ids) {
        global $db;
        $now = new Zend_Date();
        foreach ($timesheet_ids as $timesheet_id) {
            $data = array(
                'notify_client_invoice_generator' => 'N',
            );
            $db->update('timesheet', $data, "id = $timesheet_id");

            //add history
            $data = array(
                'timesheet_id' => $timesheet_id,
                'changes' => 'notify_client_invoice_generator set to "N"',
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
    $server->setClass('GenerateClientInvoice');
}
$server->handle();
?>
