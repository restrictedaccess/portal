<?php
//  2013-08-28  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   retired, new django version exist
//  2013-03-12  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   associate timesheet timerecords with the proper contract, instances where staff has multiple roles for the same client
//  2013-02-04  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   display timesheet even if the status is locked, list by client
//  2013-01-02  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   display timesheet even if the status is locked, wf 3427
//  2012-11-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix some rounding offs and lunch time computation to match prepaid automatic charging
//  2012-03-29  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   added adjust_time_sheet permission
//  2012-03-22  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Update, regular/prepaid status, added subcontractors_id
//  2012-03-21  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added regular/prepaid on the timesheets status
//  2011-02-18  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add notes for leave requests
//  2011-01-13  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   bugfix on lunch records not showing up due to timezone changes
//  2011-01-12  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   add timezone change of the timesheet
//  -   show history
//  -   based the time in/out of staff on the timesheet timezone
//  2010-03-12  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   stripslashes on notes
//  2010-03-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on admin with disabled account
//  2010-01-12  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix client invoice tracking display
//  2010-01-11  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Add client invoice tracking
//  2009-12-28  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix dont add timesheet with 'delete' status
//  -   strip off extra characters from staff email
//  2009-12-14  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on dates
//  2009-12-03  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Sets the notify_client_invoice_generator to "Y" when timesheet_details are updated
//  2009-11-27  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   add the involved invoice for the timesheet via timesheet_subcon_invoice_tracking table
//  2009-11-26  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Sets the notify_staff_invoice_generator to "Y" when timesheet_details are updated
//  2009-11-17  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Add and display timesheet notes
//  2009-10-28  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Remove automatic update of hrs_to_be_subcon when adj_hrs is updated
//  2009-10-22  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on lunch records display
//  2009-10-14  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Removed Unneccessary methods, fixed glitch on total time sheet
//  2009-10-14  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   As per Reg request, automatically update hrs_to_be_subcon when adj_hrs is updated
//  2009-09-29  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack, JSON-RPC service

require('../conf/zend_smarty_conf.php');
require('../lib/validEmail.php');
define('DEFAULT_TS_TZ', 'Asia/Manila');

class LoginAdmin {
    public function login($email, $password) {
        throw new Exception('New version exists. Please clear your browsers cache.');
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


class UpdateTimeSheet {
    function __construct() {
        throw new Exception('New version exists. Please clear your browsers cache.');
        global $db;
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            throw new Exception('Please Login');
        }
        $this->admin_id = $admin_id;

        //get admins timezone
        $sql = $db->select()
                ->from(Array('t' => 'timezone_lookup'), 'timezone')
                ->join(Array('a' => 'admin'), 'a.timezone_id = t.id')
                ->where('a.admin_id = ?', $admin_id);
        $tz = $db->fetchOne($sql);
        if ($tz == Null) {
            $this->admin_tz = 'Asia/Manila';
        }
        else {
            $this->admin_tz = $tz;
        }

        //get adjust_time_sheet permission
        $sql = $db->select()
                ->from('admin', 'adjust_time_sheet')
                ->where('admin_id = ?', $admin_id);
        $this->adjust_time_sheet = $db->fetchOne($sql);
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


    public function get_timezones() {
        global $db;
        $sql = $db->select()
                ->from('timezone_lookup', Array('timezone', 'id'));
        $data = $db->fetchAll($sql);

        $return_tz = Array();

        foreach ($data as $tz) {
            if ($tz['timezone'] == 'PST8PDT') {
                $tz['timezone'] = 'San Francisco';
            }
            $return_tz[] = $tz;
        }

        return $return_tz;
    }


    public function change_timezone($timesheet_id, $timezone_id) {
        global $db;
        //update timesheet
        $data = Array(
            'timezone_id' => $timezone_id
        );
        $db->update('timesheet', $data, "id = $timesheet_id");

        //get timezone for logging purposes
        $sql = $db->select()
                ->from('timezone_lookup', 'timezone')
                ->where('id = ?', $timezone_id);
        $timezone = $db->fetchOne($sql);

        $now = new Zend_Date();
        //log changes
        $data = Array(
            'timesheet_id' => $timesheet_id,
            'changes' => "timezone set to $timezone",
            'changed_by_id' => $this->admin_id,
            'date_changed' => $now->toString("yyyy-MM-dd HH:mm:ss")
        );

        $db->insert('timesheet_history', $data);

        return True;
    }


    public function get_timesheet_details($timesheet_id) {
        global $db;
        $sql = $db->select()
                ->from('timesheet', array('month_year', 'userid', 'leads_id', 'status', 'timezone_id', 'subcontractors_id'))
                ->where('id = ?', $timesheet_id);
        $data = $db->fetchRow($sql);
        $month_year = $data['month_year'];
        $userid = $data['userid'];
        $leads_id = $data['leads_id'];
        $timezone_id = $data['timezone_id'];

        $subcontractors_id = $data['subcontractors_id'];

        $sql = $db->select()
                ->from('subcontractors', array('prepaid'))
                ->where('id = ?', $subcontractors_id);
        $prepaid = $db->fetchOne($sql);

        if ($prepaid == 'yes') {
            $status = sprintf('prepaid %s', $data['status']);
        }
        else {
            $status = sprintf('regular %s', $data['status']);
        }
        $status = $data['status'];

        //get timezone
        if ($timezone_id == Null) {
            $sql = $db->select()
                    ->from('timezone_lookup', 'id')
                    ->where('timezone = ?', DEFAULT_TS_TZ);
            $timezone_id = $db->fetchOne($sql);
        }
        $sql = $db->select()
                ->from('timezone_lookup')
                ->where('id = ?', $timezone_id);
        $timezone = $db->fetchRow($sql);

        $sql = $db->select()
                ->from('timesheet_details')
                ->where('timesheet_id = ?', $timesheet_id);
        $details = $db->fetchAll($sql);
        $data = array();
        $date = new Zend_Date($month_year, 'YYYY-MM-dd');

        $grand_total_hrs = 0;
        $grand_total_adj_hrs = 0;
        $grand_total_reg_ros_hrs = 0;
        $grand_total_hrs_chrg_client = 0;
        $grand_total_diff_chrg_client = 0;
        $grand_total_hrs_to_be_subcon = 0;
        $grand_total_lunch_hrs = 0;
        $grand_total_diff_pay_adj = 0;

        foreach($details as $detail) {
            date_default_timezone_set($timezone['timezone']);
            $day = new Zend_Date($date->toString('yyyy-MM-') . $detail['day'], 'YYYY-MM-dd');
            $day->setTimezone('Asia/Manila');
            $end_day = clone $day;
            $end_day->add('23:59:59', Zend_Date::TIMES);

            //get time records
            $time_in = array();
            $time_out = array();
            $total_hrs = 0;
            $lunch_in = array();
            $lunch_out = array();
            $total_lunch_hrs = 0;
            $total_seconds = 0;

            //prepare query
            $sql = $db->select()
                    ->from('timerecord')
                    ->where('userid = ?', $userid)
                    ->where('time_in >= ?', $day->toString('yyyy-MM-dd HH:mm:ss'))
                    ->where('time_in < ?', $end_day->toString('yyyy-MM-dd HH:mm:ss'))
                    ->where('mode = "regular"')
                    ->where('subcontractors_id = ?', $subcontractors_id)
                    ->where('leads_id = ?', $leads_id);

            //loop over the result
            foreach ($db->fetchAll($sql) as $timerecord) {
                date_default_timezone_set('Asia/Manila');
                $time_in_tmp = new Zend_Date($timerecord['time_in'], 'YYYY-MM-dd HH:mm:ss');
                $time_in_tmp->setTimezone($timezone['timezone']);
                $time_in[] = $time_in_tmp->toString('MM/dd HH:mm');
                if ($timerecord['time_out'] != Null) {
                    date_default_timezone_set('Asia/Manila');
                    $time_out_tmp = new Zend_Date($timerecord['time_out'], 'YYYY-MM-dd HH:mm:ss');
                    $time_out_tmp->setTimezone($timezone['timezone']);
                    $time_out[] = $time_out_tmp->toString('MM/dd HH:mm');
                    $total_hrs_x = $time_out_tmp->toString("U") - $time_in_tmp->toString("U");
                    $total_seconds += $time_out_tmp->toString("U") - $time_in_tmp->toString("U");
                    $total_hrs_x = round(($total_hrs_x / 3600), 2);
                    $total_hrs += $total_hrs_x;

                }
                else {
                    $time_out[] = '';
                }

                if ($timerecord['time_out'] != Null) {
                    $time_in_tmp->setTimezone('Asia/Manila');
                    $time_out_tmp->setTimezone('Asia/Manila');
                    //get lunch records
                    $sql_lunch = $db->select()
                            ->from('timerecord')
                            ->where('userid = ?', $userid)
                            ->where('time_in >= ?', $time_in_tmp->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('time_in < ?', $time_out_tmp->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('mode = "lunch_break"')
                            ->where('leads_id = ?', $leads_id);

                    foreach ($db->fetchAll($sql_lunch) as $timerecord_lunch){
                        date_default_timezone_set('Asia/Manila');
                        $lunch_in_tmp = new Zend_Date($timerecord_lunch['time_in'], 'YYYY-MM-dd HH:mm:ss');
                        $lunch_in_tmp->setTimezone($timezone['timezone']);
                        $lunch_in[] = $lunch_in_tmp->toString('MM/dd HH:mm');
                        if ($timerecord_lunch['time_out'] != Null) {
                            date_default_timezone_set('Asia/Manila');
                            $lunch_out_tmp = new Zend_date($timerecord_lunch['time_out'], 'YYYY-MM-dd HH:mm:ss');
                            $lunch_out_tmp->setTimezone($timezone['timezone']);
                            $lunch_out[] = $lunch_out_tmp->toString('MM/dd HH:mm');
                            $total_hrs_x = $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_seconds -= $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_hrs_x = $total_hrs_x / 3600;
                            $total_lunch_hrs += $total_hrs_x;
                            //$total_hrs -= $total_lunch_hrs;
                            $total_hrs = round($total_seconds / 3600, 2);
                        }
                        else {
                            $lunch_out[] = '';
                        }

                    }
                }

            }

            //get timesheet notes
            $notes = $this->GetTimeSheetNotes($detail['id'], $timezone);

            $diff_pay_adj = $detail['adj_hrs'] - $detail['hrs_to_be_subcon'];

            $day->setTimezone($timezone['timezone']);

            $data[] = array(
                'id' => $detail['id'],
                'day' => $day->toString('EEE'),
                'date' => $day->toString('dd'),
                'time_in' => $time_in,
                'time_out' => $time_out,
                'total_hrs' => number_format($total_hrs, 2),
                'adjusted_hrs' => number_format($detail['adj_hrs'], 2),
                'regular_rostered_hrs' => number_format($detail['regular_rostered'], 2),
                'hrs_charged_to_client' => number_format($detail['hrs_charged_to_client'], 2),
                'diff_charged_to_client' => number_format($detail['diff_charged_to_client'], 2),
                'hrs_to_be_subcon' => number_format($detail['hrs_to_be_subcon'], 2),
                'diff_pay_adj' => number_format($diff_pay_adj, 2),
                'lunch_hours' => number_format($total_lunch_hrs, 2),
                'lunch_in' => $lunch_in,
                'lunch_out' => $lunch_out,
                'notes' => $notes
            );

            $grand_total_hrs += number_format($total_hrs, 2);
            $grand_total_adj_hrs += number_format($detail['adj_hrs'], 2);
            $grand_total_reg_ros_hrs += number_format($detail['regular_rostered'], 2);
            $grand_total_hrs_chrg_client += number_format($detail['hrs_charged_to_client'], 2);
            $grand_total_diff_chrg_client += number_format($detail['diff_charged_to_client'], 2);
            $grand_total_hrs_to_be_subcon += number_format($detail['hrs_to_be_subcon'], 2);
            $grand_total_lunch_hrs += number_format($total_lunch_hrs, 2);
            $grand_total_diff_pay_adj += $diff_pay_adj;
        }

        $totals = array(
            'grand_total_hrs' => number_format($grand_total_hrs, 2),
            'grand_total_adj_hrs' => number_format($grand_total_adj_hrs, 2),
            'grand_total_reg_ros_hrs' => number_format($grand_total_reg_ros_hrs, 2),
            'grand_total_hrs_chrg_client' => number_format($grand_total_hrs_chrg_client, 2),
            'grand_total_diff_chrg_client' => number_format($grand_total_diff_chrg_client, 2),
            'grand_total_hrs_to_be_subcon' => number_format($grand_total_hrs_to_be_subcon, 2),
            'grand_total_lunch_hrs' => number_format($grand_total_lunch_hrs, 2),
            'grand_total_diff_pay_adj' => number_format($grand_total_diff_pay_adj, 2),
        );

        // get staff invoice related to this timesheet
        $sql = $db->select()
            ->from('timesheet_subcon_invoice_tracking')
            ->where('timesheet_id = ?', $timesheet_id)
            ->order('id');
        $invoices = $db->fetchAll($sql);

        //generate sum diff pay
        $i = 0;
        foreach ($invoices as $invoice) {
            $sum_diff_pay_adj = $invoice['sum_adj_hrs'] - $invoice['sum_hrs_to_be_subcon'];
            $invoices[$i]['sum_diff_pay_adj'] = number_format($sum_diff_pay_adj, 2);
            $i++;
        }

        // get client invoice related to this timesheet
        $sql = $db->select()
            ->from(array('t' => 'timesheet_client_invoice_tracking'))
            ->join(array('c' => 'client_invoice'), 't.client_invoice_id = c.id', array('invoice_number' => 'c.invoice_number'))
            ->where('t.timesheet_id = ?', $timesheet_id)
            ->order('t.id');
        $client_invoices = $db->fetchAll($sql);

        //change PST8PDT
        if ($timezone['timezone'] == 'PST8PDT') {
            $timezone['timezone'] = 'San Francisco';
        }

        return array('timesheet_details' => $data, 
            'timesheet_totals' => $totals, 
            'timesheet_status' => $status, 
            'subcontractors_id' => $subcontractors_id,
            'prepaid' => $prepaid,
            'invoices' => $invoices, 
            'client_invoices' => $client_invoices,
            'timezone' => $timezone);
    }


    public function update_hrs($id, $hrs, $field_name) {
        global $db;

        if ($this->adjust_time_sheet != 'Y') {
            throw new Exception('Not allowed to update timesheet.');
        }

        $hrs = number_format($hrs, 2);

        $data = array(
            $field_name => $hrs,
        );

        $db->update('timesheet_details', $data, "id = $id");

        //grab the whole record needed
        $sql = $db->select()
            ->from('timesheet_details')
            ->where('id = ?', $id);
        $updated_data = $db->fetchRow($sql);

        //verify the adj hrs
        $hrs = $updated_data[$field_name];

        //insert record on history
        $now = new Zend_Date();
        $data = array(
            'timesheet_details_id' => $id,
            'changes' => "$field_name changed to $hrs",
            'changed_by_id' => $_SESSION['admin_id'],
            'date_changed' => $now->toString("yyyy-MM-dd HH:mm:ss")
        );

        $db->insert('timesheet_details_history', $data);

        //automatic recomputation of diff_charged_to_client when adj_hrs and hrs_charged_to_client are modified
        //formula is diff_charged_to_client = adj_hrs - hrs_charged_to_client
        $diff_charged_to_client = Null;
        if (($field_name == 'adj_hrs') or ($field_name == 'hrs_charged_to_client')) {

            $adj_hrs = $updated_data['adj_hrs'];
            if ($adj_hrs == Null) {
                $adj_hrs = 0;
            }
            $hrs_charged_to_client = $updated_data['hrs_charged_to_client'];
            if ($hrs_charged_to_client == Null) {
                $hrs_charged_to_client = 0;
            }

            $diff_charged_to_client = $adj_hrs - $hrs_charged_to_client;
            $updated_data['diff_charged_to_client'] = $diff_charged_to_client;

            $data = array(
                'diff_charged_to_client' =>$diff_charged_to_client,
            );

            $db->update('timesheet_details', $data, "id = $id");

            //add history
            $data = array(
                'timesheet_details_id' => $id,
                'changes' => "diff_charged_to_client changed to $diff_charged_to_client",
                'changed_by_id' => $_SESSION['admin_id'],
                'date_changed' => $now->toString("yyyy-MM-dd HH:mm:ss")
            );

            $db->insert('timesheet_details_history', $data);

        }

        //grab totals
        $sql = $db->select()
            ->from('timesheet_details', 'timesheet_id')
            ->where('id = ?', $id);
        $timesheet_id = $db->fetchOne($sql);
        $details = $this->get_timesheet_details($timesheet_id);


        $diff_pay_adj = $updated_data['adj_hrs'] - $updated_data['hrs_to_be_subcon'];

        $updated_data_formatted = array(
            'id' => $updated_data['id'],
            'adj_hrs' => number_format($updated_data['adj_hrs'], 2),
            'regular_rostered' => number_format($updated_data['regular_rostered'], 2),
            'hrs_charged_to_client' => number_format($updated_data['hrs_charged_to_client'], 2),
            'diff_charged_to_client' => number_format($updated_data['diff_charged_to_client'], 2),
            'hrs_to_be_subcon' => number_format($updated_data['hrs_to_be_subcon'], 2),
            'diff_pay_adj' => number_format($diff_pay_adj, 2),
            'notes' => $updated_data['notes'],
        );

        //update timesheet.notify_staff_invoice_generator
        $data = array(
            'notify_staff_invoice_generator' => 'Y',
            'notify_client_invoice_generator' => 'Y'
        );
        $db->update('timesheet', $data, "id = $timesheet_id");

        //add history
        $data = array(
            'timesheet_id' => $timesheet_id,
            'changes' => "notify_staff_invoice_generator and notify_client_invoice_generator set to 'Y'",
            'changed_by_id' => $this->admin_id,
            'date_changed' => $now->toString("yyyy-MM-dd HH:mm:ss")
        );
        $db->insert('timesheet_history', $data);

        return array('updated_data' => $updated_data_formatted, 'timesheet_totals' => $details['timesheet_totals']);
    }


    public function get_staff_names_by_month($date) {
        global $db;
        $sql = $db->select()
                ->distinct()
                ->from(array('t' => 'timesheet'), 'userid')
                ->join(array('p' => 'personal'), 't.userid = p.userid', array('fname', 'lname'))
                ->where('t.month_year = ?', $date)
                ->where('t.status != "deleted"')
                ->order(array('p.fname', 'p.lname'));
        return $db->fetchAll($sql);
    }


    public function get_staff_clients($date, $userid) {
        global $db;
        $sql = $db->select()
                ->from(array('t' => 'timesheet'))
                ->join(array('l' => 'leads'), 't.leads_id = l.id', array('fname', 'lname'))
                ->where('t.month_year = ?', $date)
                ->where('t.userid = ?', $userid)
                ->where('t.status IN ("open", "locked")')
                ->order(array('l.fname', 'l.lname'));
        return $db->fetchAll($sql);
    }


    public function get_client_names_by_month($date) {
        global $db;
        $sql = $db->select()
                ->distinct()
                ->from(array('t' => 'timesheet'), 'leads_id')
                ->join(array('l' => 'leads'), 't.leads_id = l.id', array('fname', 'lname'))
                ->where('t.month_year = ?', $date)
                ->order(array('fname', 'lname'));
        return $db->fetchAll($sql);
    }


    public function get_client_staff_by_month($date, $leads_id) {
        global $db;
        $sql = $db->select()
                ->from(array('t' => 'timesheet'))
                ->join(array('p' => 'personal'), 't.userid = p.userid', array('fname', 'lname'))
                ->where('t.month_year = ?', $date)
                ->where('t.leads_id = ?', $leads_id)
                ->where('t.status IN ("open", "locked")')
                ->order(array('p.fname', 'p.lname'));
        return $db->fetchAll($sql);
    }


    public function recompute_diff_chrge_to_client($id) {
        global $db;

        if ($this->adjust_time_sheet != 'Y') {
            throw new Exception('Not allowed to update timesheet.');
        }

        $sql = $db->select()
                ->from('timesheet_details')
                ->where('timesheet_id = ?', $id);

        $now = new Zend_Date();

        foreach ($db->fetchAll($sql) as $record) {
            $adj_hrs = $record['adj_hrs'];
            $hrs_charged_to_client = $record['hrs_charged_to_client'];
            $diff_charged_to_client = $adj_hrs - $hrs_charged_to_client;

            $data = array(
                'diff_charged_to_client' => $diff_charged_to_client,
            );

            $timesheet_details_id = $record['id'];
            $db->update('timesheet_details', $data, "id = $timesheet_details_id");

            //add record to history
            $data = array(
                'timesheet_details_id' => $timesheet_details_id,
                'changes' => "updated diff_charged_to_client to $diff_charged_to_client",
                'changed_by_id' => $_SESSION['admin_id'],
                'date_changed' => $now->toString("yyyy-MM-dd HH:mm:ss")
            );

            $db->insert('timesheet_details_history', $data);
        }


        return $this->get_timesheet_details($id);
    }

    private function GetTimeSheetNotes($timesheet_detail_id, $timezone) {
        global $db;

        $notes = array();

        //retrieve leave requests
        $leave_requests = $this->get_leave_request($timesheet_detail_id);
        foreach($leave_requests as $leave_request) {
            $notes[] = $leave_request;
        }

        //staff notes
        $sql = $db->select()
                ->from(array('t' => 'timesheet_notes_subcon'), array('id', 'timestamp', 'note'))
                ->join(array('p' => 'personal'), 't.userid = p.userid', array('fname', 'lname'))
                ->where('t.timesheet_details_id = ?', $timesheet_detail_id);
        $timesheet_notes_subcon = $db->fetchAll($sql);

        foreach ($timesheet_notes_subcon as $note) {
            date_default_timezone_set('Asia/Manila');
            $timestamp = new Zend_Date($note['timestamp'], 'YYYY-MM-dd HH:mm:ss');
            $timestamp->setTimezone($timezone['timezone']);
            $notes[] = array(
                'timestamp' => $timestamp->toString('yyyy-MM-dd HH:mm:ss'),
                'fname' => $note['fname'],
                'lname' => $note['lname'],
                'note' => $note['note']
            );
        }

        //admin notes
        $sql = $db->select()
                ->from(array('t' => 'timesheet_notes_admin'), array('id', 'timestamp', 'note'))
                ->join(array('a' => 'admin'), 't.admin_id = a.admin_id', array('admin_fname', 'admin_lname'))
                ->where('t.timesheet_details_id = ?', $timesheet_detail_id);
        $timesheet_notes_admin = $db->fetchAll($sql);

        foreach ($timesheet_notes_admin as $note) {
            date_default_timezone_set('Asia/Manila');
            $timestamp = new Zend_Date($note['timestamp'], 'YYYY-MM-dd HH:mm:ss');
            $timestamp->setTimezone($timezone['timezone']);
            $notes[] = array(
                'timestamp' => $timestamp->toString('yyyy-MM-dd HH:mm:ss'),
                'fname' => $note['admin_fname'],
                'lname' => $note['admin_lname'],
                'note' => $note['note']
            );
        }
        asort($notes);
        return $notes;
    }

    private function get_leave_request($timesheet_detail_id) {
        global $db;
        //leave request notes get timesheet to retrieve month and year
        $sql = $db->select()
                ->from('timesheet_details', array('timesheet_id', 'day'))
                ->where('id = ?', $timesheet_detail_id);
        $timesheet_id_day = $db->fetchRow($sql);

        //get month_year from timesheet
        $sql = $db->select()
                ->from('timesheet', array('month_year', 'userid', 'leads_id'))
                ->where('id = ?', $timesheet_id_day['timesheet_id']);

        $timesheet = $db->fetchRow($sql);
        $date_of_leave = sprintf('%s%02d', substr($timesheet['month_year'], 0, 8), $timesheet_id_day['day']);
        $userid = $timesheet['userid'];
        $leads_id = $timesheet['leads_id'];

        //collect all records from leave_request_dates for the said date
        $sql = $db->select()
                ->from('leave_request_dates', 'leave_request_id')
                ->where('date_of_leave = ?', $date_of_leave)
                ->where('status = "approved"');
        $leave_requests = $db->fetchAll($sql);

        $has_leave_request = array();
        foreach ($leave_requests as $leave_request_id) {
            $sql = $db->select()
                    ->from('leave_request', array('userid', 'leads_id', 'date_requested'))
                    ->where('id = ?', $leave_request_id);
            $leave_request = $db->fetchRow($sql);
            if (($userid == $leave_request['userid']) && ($leads_id == $leave_request['leads_id'])){
                date_default_timezone_set('Asia/Manila');
                $timestamp = new Zend_Date($leave_request['date_requested'], 'YYYY-MM-dd HH:mm:ss');
                $timestamp->setTimezone($this->staff_tz);
                $has_leave_request[] = array(
                    'timestamp' => $timestamp->toString('YYYY-MM-dd HH:mm:ss'),
                    'fname' => 'LEAVE REQUEST SYSTEM',
                    'lname' => '',
                    'note' => 'ON LEAVE'
                );
            }
        }

        return $has_leave_request;
    }


    public function add_note($timesheet_details_id, $note) {
        global $db, $transport;
        $note = trim($note);
        if ($note == '') {
            throw new Exception('Blank note not allowed!');
        }

        $now = new Zend_Date();
        $data = array(
            'timesheet_details_id' => $timesheet_details_id,
            'admin_id' => $this->admin_id,
            'timestamp' => $now->toString('yyyy-MM-dd HH:mm:ss'),
            'note' => $note
        );

        $db->insert('timesheet_notes_admin', $data);

        //grab timesheet details
        $sql = $db->select()
            ->from('timesheet_details', array('timesheet_id', 'day'))
            ->where('id = ?', $timesheet_details_id);
        $timesheet_details = $db->fetchRow($sql);
        $timesheet_id = $timesheet_details['timesheet_id'];
        $timesheet_day = sprintf("%02s", $timesheet_details['day']);

        $sql = $db->select()
            ->from('timesheet')
            ->where('id = ?', $timesheet_id);
        $timesheet_data = $db->fetchRow($sql);
        $timesheet_month = new Zend_Date($timesheet_data['month_year'], 'YYYY-MM-dd');
        $timesheet_month_str = $timesheet_month->toString('MMMM');
        $userid = $timesheet_data['userid'];

        $leads_id = $timesheet_data['leads_id'];
        $sql = $db->select()
            ->from('leads', array('fname','lname'))
            ->where('id = ?', $leads_id);

        $client = $db->fetchRow($sql);
        $client_fname = $client['fname'];
        $client_lname = $client['lname'];

        //mail to user and admins
        //grab all admin emails
        $sql = $db->select()
            ->from('admin', array('admin_email'))
            ->where('notify_timesheet_notes = "Y"')
            ->where('status != "REMOVED"');
        $emails = $db->fetchAll($sql);

        //grab subcon details
        $sql = $db->select()
            ->from('personal', array('fname', 'lname', 'email'))
            ->where('userid = ?', $userid);
        $personal = $db->fetchRow($sql);
        $subcon_fname = $personal['fname'];
        $subcon_lname = $personal['lname'];
        $subcon_email = trim($personal['email']);

        $sql = $db->select()
            ->from('admin', array('admin_fname', 'admin_lname', 'admin_email'))
            ->where('admin_id = ?', $this->admin_id);
        $admin_data = $db->fetchRow($sql);
        $admin_fname = $admin_data['admin_fname'];
        $admin_lname = $admin_data['admin_lname'];
        $admin_email = $admin_data['admin_email'];

        $subject = "New Timesheet Note for : $subcon_fname $subcon_lname";
        $date_str = $now->toString('yyyy-MM-dd hh:mm a z');
        $message = "Timesheet Month: $timesheet_month_str\r\nTimesheet Day: $timesheet_day\r\nDate/Time noted: $date_str\r\nClient: $client_fname $client_lname\r\nNoted by: $admin_fname $admin_lname\r\n\r\nNote: $note";

        $mail = new Zend_Mail();
        $mail->addHeader('Reply-To', $admin_email);
        $mail->setBodyText($message);
        $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
        $mail->setSubject($subject);

        if (TEST) {
                $mail->addTo('devs@remotestaff.com.au');
        }
        else {
            if (validEmail($subcon_email)) {
                $mail->addTo($subcon_email);
            }

            foreach ($emails as $email) {
                $admin_email = trim($email['admin_email']);
                if (validEmail($admin_email)) {
                    $mail->addBcc($admin_email);
                }
            }
        }

        $mail->send($transport);

        $timezone_id = $timesheet_data['timezone_id'];

        //get timezone
        if ($timezone_id == Null) {
            $sql = $db->select()
                    ->from('timezone_lookup', 'id')
                    ->where('timezone = ?', DEFAULT_TS_TZ);
            $timezone_id = $db->fetchOne($sql);
        }
        $sql = $db->select()
                ->from('timezone_lookup')
                ->where('id = ?', $timezone_id);
        $timezone = $db->fetchRow($sql);

        $notes = $this->GetTimeSheetNotes($timesheet_details_id, $timezone);
        return $notes;
    }


    public function get_history($timesheet_id) {
        global $db;
        $history = Array();

        $sql = $db->select()
                ->from(Array('t' => 'timesheet'), Array('date_generated'))
                ->join(Array('a' => 'admin'), 't.generated_by_id = a.admin_id', Array('admin_fname'))
                ->where('t.id = ?', $timesheet_id);

        $data = $db->fetchRow($sql);
        $history[] = Array(
            'date' => $data['date_generated'], 
            'name' => $data['admin_fname'], 
            'changes' => 'Created Timesheet');

        //get timesheet_history
        $sql = $db->select()
                ->from(Array('t' => 'timesheet_history'), Array('date_changed', 'changes'))
                ->join(Array('a' => 'admin'), 't.changed_by_id = a.admin_id', Array('admin_fname'))
                ->where('t.timesheet_id = ?', $timesheet_id);
        $data = $db->fetchAll($sql);
        foreach ($data as $rec) {
            $history[] = Array(
                'date' => $rec['date_changed'],
                'name' => $rec['admin_fname'],
                'changes' => $rec['changes']
            );
        }

        //get timesheet_details first
        $sql = $db->select()
                ->from('timesheet_details', 'id')
                ->where('timesheet_id = ?', $timesheet_id);



        $data = $db->fetchAll($sql);

        $timesheet_details_ids = Array();
        foreach ($data as $rec) {
            $timesheet_details_ids[] = sprintf("'%s'", $rec['id']);
        }

        $timesheet_details_ids_string = implode(",", $timesheet_details_ids);
        
        //get timesheet_details_history
        $sql = $db->select()
                ->from(Array('t' =>'timesheet_details_history'), Array('date_changed', 'changes'))
                ->join(Array('a' => 'admin'), 't.changed_by_id = a.admin_id', Array('admin_fname'))
                ->where("t.timesheet_details_id IN ($timesheet_details_ids_string)");

        $data = $db->fetchAll($sql);
        foreach ($data as $rec) {
            $history[] = Array(
                'date' => $rec['date_changed'],
                'name' => $rec['admin_fname'],
                'changes' => $rec['changes']
            );
        }

        array_multisort($history);

        //convert time based on admins time zone
        $return_data = Array();
        foreach ($history as $rec) {
            $date = new Zend_Date($rec['date'], 'YYYY-MM-dd HH:mm:ss');
            $date->setTimezone($this->admin_tz);
            $return_data[] = Array(
                'date' => $date->toString('yyyy-MM-dd hh:mm:ss a'),
                'name' => $rec['name'],
                'changes' => $rec['changes']
            );
        }

        return Array(
            'admin_tz' => $this->admin_tz,
            'history' => $return_data
        );
    }

}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
if ($method == 'login') {
    $server->setClass('LoginAdmin');
}
else {
    $server->setClass('UpdateTimeSheet');
}
$server->handle();
?>
