<?php
//  2013-10-29  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix string variables to integer type on publishing message
//  2013-10-24  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updated to retrieve activity notes directly from couch
//  2013-09-23  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bugfix on missing timesheets due to php upgrade
//  2013-09-10  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bugfix on missing staff (with multiple records)
//  2013-08-29  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Task #4580, remove staff off the list on the drop down if contract has been inactive for the past 3 months.
//  2013-03-30  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   show suspended/terminated/resigned staff
//  -   fix dates
//  2013-03-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   match the subcontractors_id of timerecords to timesheet
//  2013-03-13  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix timesheet issue on client with one staff / multiple role
//  2012-11-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix some rounding offs and lunch time computation to match prepaid automatic charging
//  2012-11-01  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix timezone issues on client side, wf 3218
//  2011-11-10  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   rssc settings moved from mysql to couchdb
//  2011-09-06  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add session transfer for django service
//  2011-02-23  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed rating on activity notes
//  2011-02-18  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add notes for leave requests
//  2011-01-12 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add activity not report settings
//  -   Add sending of activity notes
//  2011-01-04 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   More time formatting consistency updates
//  2011-01-04 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Made the screenshot time format same as the activity note format
//  2010-12-27 Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack
require('../conf/zend_smarty_conf.php');
require('../../portal/lib/validEmail.php');
DEFINE('ACTIVITY_NOTE_LIMIT', 40);
DEFINE('GUI_VERSION', '2011-09-02 17:04:00');


class LoginClient {
    public function login($email, $password) {
        global $db;
        $password = sha1($password);
        $sql = $db->select()
                ->from('leads')
                ->where('email = ?', $email)
                ->where('password = ?', $password)
                ->where('status = "Client"');
        $result = $db->fetchAll($sql);
        if (count($result) == 0) {
            return 'Invalid Login';
        }
        $_SESSION['client_id'] =$result[0]['id']; 
        return "OK";
    }
}


class SubconManagement {
    function __construct() {
        global $db;
        $client_id = $_SESSION['client_id'];
        if (($client_id == "") || ($client_id == Null)) {
            throw new Exception('Please Login');
        }
        $this->client_id = $client_id;

        //get clients timezone
        $sql = $db->select()
                ->from(Array('t' => 'timezone_lookup'), 'timezone')
                ->join(Array('l' => 'leads'), 'l.timezone_id = t.id')
                ->where('l.id = ?', $client_id);
        $tz = $db->fetchOne($sql);
        if ($tz == Null) {
            $this->client_tz = 'Australia/Sydney';
        }
        else {
            $this->client_tz = $tz;
        }

        //get clients email
        $sql = $db->select()
                ->from('leads', 'email')
                ->where('id = ?', $client_id);
        $this->client_email = $db->fetchOne($sql);
    }


    public function get_days() {
        $available_days = Array();

        $tz = new DateTimeZone($this->client_tz);
        $now = new DateTime();
        $now->setTimezone($tz);
        $available_days['Today'] = $now->format('Y-m-d');

        $now->modify("-1 days");
        $available_days['Yesterday'] = $now->format('Y-m-d');

        for ($i = 0; $i < 5; $i++) {
            $now->modify("-1 days");
            $available_days[$now->format('l')] = $now->format('Y-m-d');
        }

        return $available_days;
    }


    public function get_staff() {
        global $db;
        $sql = $db->select()
                ->from(array('s' => 'subcontractors'), array('userid', 'end_date', 'status'))
                ->joinLeft(array('p' => 'personal'), 's.userid = p.userid', array('fname', 'lname'))
                ->where('s.status IN ("ACTIVE", "suspended", "terminated", "resigned")')
                ->where('s.leads_id = ?', $this->client_id)
                ->order('p.fname')
                ->order('p.lname');
        $data = $db->fetchAll($sql);

        $past_date = new Zend_Date();
        $past_date->add('-100', Zend_Date::DAY);  //remove terminated/resigned older than 100 days

        $userids = Array(); // collection of userids to prevent duplication
        $new_data = Array();
        foreach ($data as $d) {
            if (in_array($d['status'], Array('terminated', 'resigned'))) {
                $end_date = new Zend_Date($d['end_date']);
                if ($end_date->isEarlier($past_date)) {
                    continue;
                }
            }

            if (in_array($d['userid'], $userids)) {
                continue;
            }
            $userids[] = $d['userid'];

            $new_data[] = $d;
        }
        return $new_data;
    }


    public function get_intervals($userid) {
        global $db, $couch_dsn;
        #get the subcontractors_id first
        $sql = $db->select()
                ->from('subcontractors', 'id')
                ->where('leads_id = ?', $this->client_id)
                ->where('userid = ?', $userid)
                ->where('status = "ACTIVE"');
        $subcontractors_id = $db->fetchOne($sql);

        #get the intervals
        $couch_client = new couchClient($couch_dsn, 'rssc');
        $subcon_settings = $couch_client->getDoc(sprintf('subcon-%s', $subcontractors_id));

        $data = Array();
        $data['screenshot_interval'] = $subcon_settings->intervals->screenshot;
        $data['activity_note_interval'] = $subcon_settings->intervals->activity_note;
        return $data;
    }


    public function set_screenshot_interval($userid, $interval) {
        global $db, $couch_dsn;
        #get the subcontractors_id first
        $sql = $db->select()
                ->from('subcontractors', 'id')
                ->where('leads_id = ?', $this->client_id)
                ->where('userid = ?', $userid)
                ->where('status = "ACTIVE"');
        $subcontractors_id = $db->fetchOne($sql);
        if ($subcontractors_id == False) {
            return "subcontractor id not found!";
        }

        $couch_client = new couchClient($couch_dsn, 'rssc');
        $doc = $couch_client->getDoc(sprintf('subcon-%s', $subcontractors_id));
        $old_interval = $doc->intervals->screenshot;

        #add history
        #get clients name
        $sql = $db->select()
                ->from('leads', 'fname')
                ->where('id = ?', $this->client_id);
        $client_fname = $db->fetchOne($sql);

        $now = new Zend_Date();

        $doc = $couch_client->getDoc(sprintf('subcon-%s', $subcontractors_id));
        $doc->intervals->screenshot = (int)$interval;

        $history = $doc->history;
        if ($history == null) {
            $history = Array();
        }
        $data = Array(
            'note' => sprintf('Client %s set screenshot from %s to %s', $client_fname, $old_interval, $interval),
            'date' => $now->toString('yyyy-MM-dd HH:mm:ss')
        );
        $history[] = $data;
        
        $doc->history = $history;

        try {
            $response = $couch_client->storeDoc($doc);
        }
        catch (Exception $e){
            return "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")";
        }

        return "ok";
    }


    public function set_activity_note_interval($userid, $interval) {
        global $db, $couch_dsn;
        #get the subcontractors_id first
        $sql = $db->select()
                ->from('subcontractors', 'id')
                ->where('leads_id = ?', $this->client_id)
                ->where('userid = ?', $userid)
                ->where('status = "ACTIVE"');
        $subcontractors_id = $db->fetchOne($sql);
        if ($subcontractors_id == False) {
            return "subcontractor id not found!";
        }

        $couch_client = new couchClient($couch_dsn, 'rssc');
        $doc = $couch_client->getDoc(sprintf('subcon-%s', $subcontractors_id));
        $old_interval = $doc->intervals->activity_note;

        #add history
        #get clients name
        $sql = $db->select()
                ->from('leads', 'fname')
                ->where('id = ?', $this->client_id);
        $client_fname = $db->fetchOne($sql);

        $now = new Zend_Date();

        $doc = $couch_client->getDoc(sprintf('subcon-%s', $subcontractors_id));
        $doc->intervals->activity_note = (int)$interval;

        $history = $doc->history;
        if ($history == null) {
            $history = Array();
        }
        $data = Array(
            'note' => sprintf('Client %s set activity_note from %s to %s', $client_fname, $old_interval, $interval),
            'date' => $now->toString('yyyy-MM-dd HH:mm:ss')
        );
        $history[] = $data;
        
        $doc->history = $history;

        try {
            $response = $couch_client->storeDoc($doc);
        }
        catch (Exception $e){
            return "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")";
        }

        return "ok";
    }


    public function get_months () {
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


    public function get_timesheets() {
        global $db, $logger;
        $date_today = new Zend_Date();
        $current_month_date = new Zend_Date($date_today->toString('yyyy-MM-01 00:00:00'), Zend_Date::ISO_8601);
        $start_date = clone $current_month_date;
        $start_date->add(-1, Zend_Date::YEAR);
        $sql = $db->select()
                ->from(Array('t' => 'timesheet'), Array('t.id', 't.month_year', 't.userid'))
                ->join(Array('s' => 'subcontractors'), 't.subcontractors_id = s.id', Array('s.job_designation'))
                ->where('t.leads_id = ?', $this->client_id)
                ->where('t.status IN ("open", "locked")')
                ->where('t.month_year >= ?', $start_date->toString('yyyy-MM-01 00:00:00'))
                ->where('t.month_year <= ?', $current_month_date->toString('yyyy-MM-01 00:00:00'))
                ->order('t.month_year');
        $timesheet = $db->fetchAll($sql);

        $timesheet_data = Array();
        foreach($timesheet as $t) {
            $month = new Zend_Date($t['month_year'], Zend_Date::ISO_8601);
            if ($month->toString('yyyy-MM') == $date_today->toString('yyyy-MM')) {
                $t['item'] = sprintf('%s :: %s', 'Current Month', $t['job_designation']);
            }
            else {
                $t['item'] = sprintf('%s :: %s', $month->toString('MMMM yyyy'), $t['job_designation']);
            }
            $t['year'] = $month->toString('yyyy');
            $timesheet_data[] = $t;
        }
        return $timesheet_data;
    }


    public function get_timesheet($userid, $date) {
        global $db;
        //get timesheet
        //TODO this function will be deprecated in favor of get_timesheet_by_id function
        $sql = $db->select()
                ->from('timesheet', Array('id', 'timezone_id'))
                ->where('month_year = ?', $date)
                ->where('userid = ?', $userid)
                ->where('leads_id = ?', $this->client_id)
                ->where('status != "deleted"');

        $timesheet = $db->fetchAll($sql);
        if (count($timesheet) == 0) {
            return array('error message' => 'No Time Sheet Available');
        }

        if (count($timesheet) > 1) {
            return array('error message' => 'Multiple Time Sheets. Please notify admin.');
        }


        //get timesheets timezone
        $timezone_id = $timesheet[0]['timezone_id'];
        if ($timezone_id == Null) {
            $timezone = 'Asia/Manila';
        }
        else {
            $sql = $db->select()
                    ->from('timezone_lookup', 'timezone')
                    ->where('id = ?', $timezone_id);
            $timezone = $db->fetchOne($sql);
            if ($timezone == False) {
                $timezone = 'Asia/Manila';
            }
        }

        $timesheet_id = $timesheet[0]['id'];

        $sql = $db->select()
                ->from('timesheet_details', array('id', 'timesheet_id', 'day', 'total_hrs', 'adj_hrs', 'regular_rostered', 'hrs_charged_to_client', 'diff_charged_to_client'))
                ->where('timesheet_id = ?', $timesheet_id);
        $details = $db->fetchAll($sql);
        $data = array();
        $date = new Zend_Date($date, 'YYYY-MM-dd');

        $grand_total_hrs = 0;
        $grand_total_adj_hrs = 0;
        $grand_total_reg_ros_hrs = 0;
        $grand_total_hrs_charged_to_client = 0;
        $grand_total_diff_charged_to_client = 0;
        $grand_total_lunch_hrs = 0;

        foreach($details as $detail) {
            date_default_timezone_set($timezone);
            $day = new Zend_Date($date->toString('yyyy-MM-') . $detail['day'], 'YYYY-MM-dd');
            //$day->setTimezone('Asia/Manila');
            $end_day = clone $day;
            $end_day->add('24:00:00', Zend_Date::TIMES);

            //get time records, initialize some variables
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
                    ->where('time_in >= ?', $day->toString('yyyy-MM-dd'))
                    ->where('time_in < ?', $end_day->toString('yyyy-MM-dd'))
                    ->where('mode = "regular"')
                    ->where('leads_id = ?', $this->client_id);

            //loop over the result
            foreach ($db->fetchAll($sql) as $timerecord) {
                date_default_timezone_set('Asia/Manila');
                $time_in_tmp = new Zend_Date($timerecord['time_in'], 'YYYY-MM-dd HH:mm:ss');
                $time_in_tmp->setTimezone($timezone);
                $time_in[] = $time_in_tmp->toString('MM/dd HH:mm');
                if ($timerecord['time_out'] != Null) {
                    $time_out_tmp = new Zend_Date($timerecord['time_out'], 'YYYY-MM-dd HH:mm:ss');
                    $time_out_tmp->setTimezone($timezone);
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
                            ->where('leads_id = ?', $this->client_id);

                    foreach ($db->fetchAll($sql_lunch) as $timerecord_lunch){
                        date_default_timezone_set('Asia/Manila');
                        $lunch_in_tmp = new Zend_Date($timerecord_lunch['time_in'], 'YYYY-MM-dd HH:mm:ss');
                        $lunch_in_tmp->setTimezone($timezone);
                        $lunch_in[] = $lunch_in_tmp->toString('MM/dd HH:mm');
                        if ($timerecord_lunch['time_out'] != Null) {
                            $lunch_out_tmp = new Zend_date($timerecord_lunch['time_out'], 'YYYY-MM-dd HH:mm:ss');
                            $lunch_out_tmp->setTimezone($timezone);
                            $lunch_out[] = $lunch_out_tmp->toString('MM/dd HH:mm');
                            $total_hrs_x = $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_seconds -= $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_hrs_x = round(($total_hrs_x / 3600), 2);
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
                'lunch_hours' => number_format($total_lunch_hrs, 2),
                'lunch_in' => $lunch_in,
                'lunch_out' => $lunch_out,
                'notes' => $notes
            );

            $grand_total_hrs += number_format($total_hrs, 2);
            $grand_total_adj_hrs += number_format($detail['adj_hrs'], 2);
            $grand_total_reg_ros_hrs += number_format($detail['regular_rostered'], 2);
            $grand_total_hrs_charged_to_client += number_format($detail['hrs_charged_to_client'], 2);
            $grand_total_diff_charged_to_client += number_format($detail['diff_charged_to_client'], 2);
            $grand_total_lunch_hrs += number_format($total_lunch_hrs, 2);
        }

        $totals = array(
            'grand_total_hrs' => number_format($grand_total_hrs, 2),
            'grand_total_adj_hrs' => number_format($grand_total_adj_hrs, 2),
            'grand_total_reg_ros_hrs' => number_format($grand_total_reg_ros_hrs, 2),
            'grand_total_hrs_charged_to_client' => number_format($grand_total_hrs_charged_to_client, 2),
            'grand_total_diff_charged_to_client' => number_format($grand_total_diff_charged_to_client, 2),
            'grand_total_lunch_hrs' => number_format($grand_total_lunch_hrs, 2),
        );

        return array('timesheet_details' => $data, 'timesheet_totals' => $totals, 'timesheet_status' => $status, 'timezone' => $timezone);
    }


    public function get_timesheet_by_id($timesheet_id) {
        global $db;
        //get timesheet
        $sql = $db->select()
                ->from('timesheet', Array('id', 'timezone_id', 'userid', 'subcontractors_id', 'month_year'))
                ->where('id = ?', $timesheet_id)
                ->where('leads_id = ?', $this->client_id)
                ->where('status != "deleted"');

        $timesheet = $db->fetchAll($sql);
        if (count($timesheet) == 0) {
            return array('error message' => 'No Time Sheet Available');
        }

        //get timesheets timezone
        $timezone_id = $timesheet[0]['timezone_id'];
        $userid = $timesheet[0]['userid'];
        $subcontractors_id = $timesheet[0]['subcontractors_id'];

        if ($timezone_id == Null) {
            $timezone = 'Asia/Manila';
        }
        else {
            $sql = $db->select()
                    ->from('timezone_lookup', 'timezone')
                    ->where('id = ?', $timezone_id);
            $timezone = $db->fetchOne($sql);
            if ($timezone == False) {
                $timezone = 'Asia/Manila';
            }
        }

        $sql = $db->select()
                ->from('timesheet_details', array('id', 'timesheet_id', 'day', 'total_hrs', 'adj_hrs', 'regular_rostered', 'hrs_charged_to_client', 'diff_charged_to_client'))
                ->where('timesheet_id = ?', $timesheet_id);
        $details = $db->fetchAll($sql);
        $data = array();
        $month_year = $timesheet[0]['month_year'];
        $date = new Zend_Date($month_year, 'YYYY-MM-dd');

        $grand_total_hrs = 0;
        $grand_total_adj_hrs = 0;
        $grand_total_reg_ros_hrs = 0;
        $grand_total_hrs_charged_to_client = 0;
        $grand_total_diff_charged_to_client = 0;
        $grand_total_lunch_hrs = 0;

        foreach($details as $detail) {
            date_default_timezone_set($timezone);
            $day = new Zend_Date($date->toString('yyyy-MM-') . $detail['day'], 'YYYY-MM-dd');
            //$day->setTimezone('Asia/Manila');
            $end_day = clone $day;
            $end_day->add('24:00:00', Zend_Date::TIMES);

            //get time records, initialize some variables
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
                    ->where('subcontractors_id = ?', $subcontractors_id)
                    ->where('time_in >= ?', $day->toString('yyyy-MM-dd'))
                    ->where('time_in < ?', $end_day->toString('yyyy-MM-dd'))
                    ->where('mode = "regular"')
                    ->where('leads_id = ?', $this->client_id);

            //loop over the result
            foreach ($db->fetchAll($sql) as $timerecord) {
                date_default_timezone_set('Asia/Manila');
                $time_in_tmp = new Zend_Date($timerecord['time_in'], 'YYYY-MM-dd HH:mm:ss');
                $time_in_tmp->setTimezone($timezone);
                $time_in[] = $time_in_tmp->toString('MM/dd HH:mm');
                if ($timerecord['time_out'] != Null) {
                    $time_out_tmp = new Zend_Date($timerecord['time_out'], 'YYYY-MM-dd HH:mm:ss');
                    $time_out_tmp->setTimezone($timezone);
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
                            ->where('leads_id = ?', $this->client_id);

                    foreach ($db->fetchAll($sql_lunch) as $timerecord_lunch){
                        date_default_timezone_set('Asia/Manila');
                        $lunch_in_tmp = new Zend_Date($timerecord_lunch['time_in'], 'YYYY-MM-dd HH:mm:ss');
                        $lunch_in_tmp->setTimezone($timezone);
                        $lunch_in[] = $lunch_in_tmp->toString('MM/dd HH:mm');
                        if ($timerecord_lunch['time_out'] != Null) {
                            $lunch_out_tmp = new Zend_date($timerecord_lunch['time_out'], 'YYYY-MM-dd HH:mm:ss');
                            $lunch_out_tmp->setTimezone($timezone);
                            $lunch_out[] = $lunch_out_tmp->toString('MM/dd HH:mm');
                            $total_hrs_x = $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_seconds -= $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_hrs_x = round(($total_hrs_x / 3600), 2);
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
                'lunch_hours' => number_format($total_lunch_hrs, 2),
                'lunch_in' => $lunch_in,
                'lunch_out' => $lunch_out,
                'notes' => $notes
            );

            $grand_total_hrs += number_format($total_hrs, 2);
            $grand_total_adj_hrs += number_format($detail['adj_hrs'], 2);
            $grand_total_reg_ros_hrs += number_format($detail['regular_rostered'], 2);
            $grand_total_hrs_charged_to_client += number_format($detail['hrs_charged_to_client'], 2);
            $grand_total_diff_charged_to_client += number_format($detail['diff_charged_to_client'], 2);
            $grand_total_lunch_hrs += number_format($total_lunch_hrs, 2);
        }

        $totals = array(
            'grand_total_hrs' => number_format($grand_total_hrs, 2),
            'grand_total_adj_hrs' => number_format($grand_total_adj_hrs, 2),
            'grand_total_reg_ros_hrs' => number_format($grand_total_reg_ros_hrs, 2),
            'grand_total_hrs_charged_to_client' => number_format($grand_total_hrs_charged_to_client, 2),
            'grand_total_diff_charged_to_client' => number_format($grand_total_diff_charged_to_client, 2),
            'grand_total_lunch_hrs' => number_format($grand_total_lunch_hrs, 2),
        );

        return array('timesheet_details' => $data, 'timesheet_totals' => $totals, 'timesheet_status' => $status, 'timezone' => $timezone);
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
            $timestamp->setTimezone($timezone);
            $notes[] = array(
                'timestamp' => $timestamp->toString('MM/dd hh:mm a'),
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
            $timestamp->setTimezone($timezone);
            $notes[] = array(
                'timestamp' => $timestamp->toString('MM/dd hh:mm a'),
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


    public function get_screenshots($date, $userid) {
        global $db;
        
        $asia_manila_tz = new DateTimeZone('Asia/Manila');
        $selected_tz = new DateTimeZone($this->client_tz);

        $max_date = new DateTime($date, $selected_tz);    //date reference

        $max_date->setTime(23, 59, 59);
        $min_date = clone($max_date);
        $min_date->setTime(0, 0, 0);

        //set it back to asia manila timezone
        $max_date->setTimezone($asia_manila_tz);
        $min_date->setTimezone($asia_manila_tz);
        $sql = $db->select()
                ->from('screenshots', array('id','post_time'))
                ->where('userid = ?', $userid)
                ->where('leads_id = ?', $this->client_id)
                ->where(sprintf('post_time BETWEEN "%s" AND "%s"', $min_date->format('Y-m-d H:i:s'), $max_date->format('Y-m-d H:i:s')))
                ->order('post_time');
        $screenshots = $db->fetchAll($sql);

        //get all activity_tracker_notes
        $sql = $db->select()
                ->from('activity_tracker_notes')
                ->where('userid = ?', $userid)
                ->where('leads_id = ?', $this->client_id)
                ->where(sprintf('checked_in_time BETWEEN "%s" AND "%s"', $min_date->format('Y-m-d H:i:s'), $max_date->format('Y-m-d H:i:s')));

        $notes = $db->fetchAll($sql);

        //loop over screenshots and add the display timezone
        for ($i = 0; $i < count($screenshots); $i++) {
            $screenshot_date = new DateTime($screenshots[$i]['post_time'], $asia_manila_tz);
            $screenshot_date->setTimezone($selected_tz);
            $screenshots[$i]['display_time'] = $screenshot_date->format('Y-m-d h:i:s A');

            $post_time = strtotime($screenshots[$i]['post_time']);
            $note_time = strtotime($notes[0]['checked_in_time']);
            $time_diff = $post_time - $note_time;
            if ($time_diff < 0) {
                $time_diff *= -1;   //always positive
            }
            $screenshots[$i]['note'] = $notes[0]['note'];
            $secs_interval = strtotime($notes[0]['checked_in_time']) - strtotime($notes[0]['expected_time']);
            $time_to_respond = new DateTime('2010-01-01 00:00:00');
            $time_to_respond->modify(sprintf('+%s sec', $secs_interval));
            $screenshots[$i]['time_to_respond'] = $time_to_respond->format('H:i:s');

            $expected_time = new DateTime($notes[0]['expected_time'], $asia_manila_tz);
            $expected_time->setTimezone($selected_tz);
            $screenshots[$i]['expected_time'] = $expected_time->format('h:i:s A');

            //bubble sort - loop over notes
            for ($j = 1; $j < count($notes); $j++) {
                $note_time = strtotime($notes[$j]['checked_in_time']);
                $new_time_diff = $post_time - $note_time;
                if ($new_time_diff < 0) {
                    $new_time_diff *= -1;   //always positive
                }

                if ($new_time_diff < $time_diff) {
                    $time_diff = $new_time_diff;
                    $screenshots[$i]['note'] = $notes[$j]['note'];
                    $secs_interval = strtotime($notes[$j]['checked_in_time']) - strtotime($notes[$j]['expected_time']);
                    $time_to_respond = new DateTime('2010-01-01 00:00:00');
                    $time_to_respond->modify(sprintf('+%s sec', $secs_interval));
                    $screenshots[$i]['time_to_respond'] = $time_to_respond->format('H:i:s');
                    $expected_time = new DateTime($notes[$j]['expected_time'], $asia_manila_tz);
                    $expected_time->setTimezone($selected_tz);
                    $screenshots[$i]['expected_time'] = $expected_time->format('h:i:s A');
                }
            }

            unset($screenshots[$i]['post_time']);   //removed to improve data transfer
        }

        return Array(
            'userid' => $userid,
            'screenshots' => $screenshots,
            'staffs_current_status' => $this->get_staff_activity_tracker_status($userid),
        );
    }


    private function get_staff_activity_tracker_status($userid) {
        global $db;
        $sql = $db->select()
                ->from('activity_tracker', array('status'))
                ->where('userid = ?', $userid);
        return $db->fetchRow($sql);
    }


    public function get_activity_notes($date_from, $date_to, $prev, $userid) {
        global $db, $couch_dsn;

        date_default_timezone_set($this->client_tz);
        $date_from = new Zend_Date($date_from, 'YYYY-MM-dd');
        $date_to = new Zend_Date($date_to, 'YYYY-MM-dd');
        $date_to->add('23:59:59', Zend_Date::TIMES);

        //set it back to asia manila timezone
        $date_from->setTimezone('Asia/Manila');
        $date_to->setTimezone('Asia/Manila');

        $date_from_array = Array(
            intval($date_from->get(Zend_Date::YEAR)),
            intval($date_from->get(Zend_Date::MONTH)),
            intval($date_from->get(Zend_Date::DAY)),
            intval($date_from->get(Zend_Date::HOUR)),
            intval($date_from->get(Zend_Date::MINUTE)),
            intval($date_from->get(Zend_Date::SECOND))
        );

        $date_to_array = Array(
            intval($date_to->get(Zend_Date::YEAR)),
            intval($date_to->get(Zend_Date::MONTH)),
            intval($date_to->get(Zend_Date::DAY)),
            intval($date_to->get(Zend_Date::HOUR)),
            intval($date_to->get(Zend_Date::MINUTE)),
            intval($date_to->get(Zend_Date::SECOND))
        );

        //get all activity_tracker_notes
        $couch_client = new couchClient($couch_dsn, 'rssc_activity_notes');
        $userid = intval($userid);
        $client_id = intval($this->client_id);
        $notes = $couch_client
            ->startkey(Array($userid, $client_id, $date_from_array))
            ->endkey(Array($userid, $client_id, $date_to_array))
            ->limit(ACTIVITY_NOTE_LIMIT + 1)
            ->skip($prev)->include_docs(true)
            ->getView("activity_note", "userid_leadsid_date");
        $return_notes = Array();

        date_default_timezone_set('Asia/Manila');   //need to set this back for timezone conv
        foreach ($notes->rows as $note) {
            $doc = $note->doc;
            $a = $doc->responded;
            $b = Array(
                'year' => $a[0],
                'month' => $a[1],
                'day' => $a[2],
                'hour' => $a[3],
                'minute' => $a[4],
                'second' => $a[5]
            );
            $c = new Zend_Date($b);
            $c->setTimezone($this->client_tz);
            $return_notes[] = Array(
                'note' => $doc->note, 
                'date' => $c->toString('MMMM d'),
                'time' => $c->toString('hh:mm:ss a')
            );
        }
        
        if (count($return_notes) == (ACTIVITY_NOTE_LIMIT + 1)) {
            $next = $prev + ACTIVITY_NOTE_LIMIT;
        }
        else {
            $next = False;
        }

        if ($prev <= 0) {
            $prev = False;
        }

        if ($prev >= ACTIVITY_NOTE_LIMIT) {
            $prev = $prev - ACTIVITY_NOTE_LIMIT;
        }

        return Array(
            'prev' => "$prev",
            'return_notes' => $return_notes,
            'next' => $next
        );

    }


    public function get_activity_report_settings() {
        global $db;
        //get the state at which client wants his activity notes
        $sql = $db->select()
                ->from('tb_client_account_settings')
                ->where('client_id = ?', $this->client_id);
        $data = $db->fetchAll($sql);

        if (count($data) == 0) {
            //no records found
            $status = 'NONE';
        }
        else {
            //just grab the first one
            $status = $data[0]['status'];
        }

        //get timezone lookups
        $sql = $db->select()
                ->from('timezone_lookup');

        $timezone_lookup = $db->fetchAll($sql);

        return Array(
            'status' => $status,
            'client_id' => $this->client_id,
            'data' => $data,
            'timezone_lookup' => $timezone_lookup,
            'default_timezone' => $this->client_tz,
        );
    }


    public function set_activity_note_setting($report_settings) {
        global $db;
        if (in_array($report_settings, Array('ONE', 'ALL', 'NONE'))) {
            //delete all
            $db->delete('tb_client_account_settings', "client_id = $this->client_id");

            if (in_array($report_settings, Array('ONE', 'NONE'))) {
                $hour = 0;
                $send_time = '00:00:00';
            }
            else {
                $hour = 20;
                date_default_timezone_set($this->client_tz);
                $client_current_date = new Zend_Date();
                $client_current_date->set('20:00:00', Zend_Date::TIMES);
                $client_current_date->setTimezone('Asia/Manila');
                $send_time = $client_current_date->toString('HH:mm:ss');
            }

            //insert one
            $data = Array(
                'status' => $report_settings,
                'client_id' => $this->client_id,
                'hour' => $hour,
                'minute' => 0,
                'email' => $this->client_email,
                'client_timezone' => $this->client_tz,
                'send_time' => $send_time,
                'type' => 'ACTIVITY NOTES'
            );

            $db->insert('tb_client_account_settings', $data);
            return 'OK';
        }
        else {
            return 'not an option';
        }
    }


    public function del_activity_note_setting($id) {
        global $db;
        $db->delete('tb_client_account_settings', "id = $id AND client_id = $this->client_id");
        return 'OK';
    }


    public function add_recepient_one($email, $cc) {
        global $db;
        if (validEmailv2($email) == False) {
            return "Invalid Email !\nPlease Check your Email input.";
        }
        $cc = trim($cc);

        if ($cc != '') {
            if (validEmailv2($cc) == False) {
                return "Invalid CC !\nPlease Check your CC input.";
            }
        }

        $data = Array(
            'status' => 'ONE',
            'client_id' => $this->client_id,
            'hour' => 0,
            'minute' => 0,
            'email' => $email,
            'cc' => $cc,
            'client_timezone' => $this->client_tz,
            'send_time' => '00:00:00',
            'type' => 'ACTIVITY NOTES'
        );
        $db->insert('tb_client_account_settings', $data);
        return 'OK';
    }


    public function edit_recepient_one($id, $email, $cc) {
        global $db;
        if (validEmailv2($email) == False) {
            return "Invalid Email !\nPlease Check your Email input.";
        }
        $cc = trim($cc);

        if ($cc != '') {
            if (validEmailv2($cc) == False) {
                return "Invalid CC !\nPlease Check your CC input.";
            }
        }

        $data = Array(
            'status' => 'ONE',
            'client_id' => $this->client_id,
            'hour' => 0,
            'minute' => 0,
            'email' => $email,
            'cc' => $cc,
            'client_timezone' => $this->client_tz,
            'send_time' => '00:00:00',
            'type' => 'ACTIVITY NOTES'
        );
        $db->update('tb_client_account_settings', $data, "id = $id AND client_id = $this->client_id");
        return 'OK';
    }


    public function add_recepient_all($email, $cc, $tz_id, $hour, $minutes) {
        global $db;
        if (validEmailv2($email) == False) {
            return "Invalid Email !\nPlease Check your Email input.";
        }
        $cc = trim($cc);

        if ($cc != '') {
            if (validEmailv2($cc) == False) {
                return "Invalid CC !\nPlease Check your CC input.";
            }
        }

        //get timezone
        $sql = $db->select()
                ->from('timezone_lookup', 'timezone')
                ->where('id = ?', $tz_id);
        $timezone = $db->fetchOne($sql);

        date_default_timezone_set($timezone);
        $client_current_date = new Zend_Date();
        $client_current_date->set(sprintf('%02d:%02d:00', $hour, $minutes), Zend_Date::TIMES);
        $client_current_date->setTimezone('Asia/Manila');
        $send_time = $client_current_date->toString('HH:mm:ss');

        $data = Array(
            'status' => 'ALL',
            'client_id' => $this->client_id,
            'hour' => $hour,
            'minute' => $minutes,
            'email' => $email,
            'cc' => $cc,
            'client_timezone' => $timezone,
            'send_time' => $send_time,
            'type' => 'ACTIVITY NOTES'
        );
        $db->insert('tb_client_account_settings', $data);
        return 'OK';
    }


    public function edit_recepient_all($id, $email, $cc, $tz_id, $hour, $minutes) {
        global $db;
        if (validEmailv2($email) == False) {
            return "Invalid Email !\nPlease Check your Email input.";
        }
        $cc = trim($cc);

        if ($cc != '') {
            if (validEmailv2($cc) == False) {
                return "Invalid CC !\nPlease Check your CC input.";
            }
        }

        //get timezone
        $sql = $db->select()
                ->from('timezone_lookup', 'timezone')
                ->where('id = ?', $tz_id);
        $timezone = $db->fetchOne($sql);

        date_default_timezone_set($timezone);
        $client_current_date = new Zend_Date();
        $client_current_date->set(sprintf('%02d:%02d:00', $hour, $minutes), Zend_Date::TIMES);
        $client_current_date->setTimezone('Asia/Manila');
        $send_time = $client_current_date->toString('HH:mm:ss');

        $data = Array(
            'status' => 'ALL',
            'client_id' => $this->client_id,
            'hour' => $hour,
            'minute' => $minutes,
            'email' => $email,
            'cc' => $cc,
            'client_timezone' => $timezone,
            'send_time' => $send_time,
            'type' => 'ACTIVITY NOTES'
        );
        $db->update('tb_client_account_settings', $data, "id = $id AND client_id = $this->client_id");
        return 'OK';
    }


    public function set_unified_intervals($interval_screenshot, $interval_activity) {
        global $db, $couch_dsn;
        $couch_client = new couchClient($couch_dsn, 'rssc');
        #get the subcontractors_id first
        $sql = $db->select()
                ->from('subcontractors', 'id')
                ->where('leads_id = ?', $this->client_id)
                ->where('status = "ACTIVE"');
        $subcontractor_ids = $db->fetchAll($sql);

        #get clients name
        $sql = $db->select()
                ->from('leads', 'fname')
                ->where('id = ?', $this->client_id);
        $client_fname = $db->fetchOne($sql);

        $now = new Zend_Date();

        foreach($subcontractor_ids as $rec) {
            $subcontractors_id = $rec['id'];
            //check if record exists
            $doc = $couch_client->getDoc(sprintf('subcon-%s', $subcontractors_id));

            if ($doc == Null) {
                continue;
            }

            $old_screenshot_interval = $doc->intervals->screenshot;
            $old_activity_note_interval = $doc->intervals->activity_note;

            $history = $doc->history;
            if ($history == null) {
                $history = Array();
            }

            $data = Array(
                'note' => sprintf('Client %s set unified intervals: screenshot from %s to %s, set activity_note from %s to %s', $client_fname, $old_screenshot_interval, $interval_screenshot, $old_activity_note_interval, $interval_activity),
                'date' => $now->toString('yyyy-MM-dd HH:mm:ss')
            );
            $history[] = $data;
            
            $doc->history = $history;
            $doc->intervals->screenshot = (int)$interval_screenshot;
            $doc->intervals->activity_note = (int)$interval_activity;

            try {
                $response = $couch_client->storeDoc($doc);
            }
            catch (Exception $e){
                return "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")";
            }
        }
        return "ok";
    }


    public function send_report($date_from, $date_to, $userid) {
        global $db, $transport;

        date_default_timezone_set($this->client_tz);
        $date_from = new Zend_Date($date_from, 'YYYY-MM-dd');
        $date_to = new Zend_Date($date_to, 'YYYY-MM-dd');
        $date_to->add('23:59:59', Zend_Date::TIMES);

        if ($date_from->isLater($date_to)) {
            return 'Date From is Later than Date To.';
        }

        //send job via mq
        $exchange = 'celery_send_task';
        $queue = 'celery_send_task';
        $conn = new AMQPConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS, MQ_VHOST);
        $ch = $conn->channel();
        $ch->queue_declare($exchange, false, true, false, false);
        $ch->exchange_declare($exchange, 'direct', false, true, false);
        $ch->queue_bind($queue, $exchange);

        if ($userid == 'ALL') {
            $staff = $this->get_staff();
            $userids = Array();
            foreach ($staff as $a) {
                $userids[] = (int)$a['userid'];
            }
        }
        else {
            $userids = Array((int)$userid);
        }

        //convert to json
        $data = Array(
            'task' => 'activity_tracker_notes.email_notes',
            'args' => Array(
                sprintf("Remote Staff Activity Tracker Notes %s - %s", $date_from->toString("MMM dd"), $date_to->toString("MMM dd")),
                Array(
                    $this->client_email
                ),
                Array(),
                Array('devs@remotestaff.com.au'),
                $userids,
                $date_from->toString('yyyy-MM-dd HH:mm:ss'),
                $date_to->toString('yyyy-MM-dd HH:mm:ss'),
                $this->client_tz,
                (int)$this->client_id
            )
        );

        $msg = new AMQPMessage(json_encode($data), 
            Array(
                'content_type' => 'text/plain', 
                'delivery-mode' => 2
            )
        );

        $ch->basic_publish($msg, $exchange);
        $ch->close();
        $conn->close();

        return 'Activity notes has been sent to your email.';
    }


    /*
    returns a random string for django consumption
    */
    public function check_php_session($gui_version) {
        global $db;
        if ($gui_version != GUI_VERSION) {
            throw new Exception('gui version mismatch');
        }

        $now = new Zend_Date();

        $random_string_exists = True;
        while ($random_string_exists) {
            $random_string = $this->rand_str();
            $data = array(
                'random_string' => $random_string,
                'date_created' => $now->toString("yyyy-MM-dd HH:mm:ss"),
                'session_data' => sprintf('client_id=%s', $this->client_id),
                'redirect' => 'from ClientSubconManagementService.php django redirect',
            );

            try {
                $db->insert('django_session_transfer', $data);
                $random_string_exists = False;
            }
            catch (Exception $e) {
                $random_string_exists = True;
            }
        }

        return $random_string;

    }

    private function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
        // Length of character list
        $chars_length = strlen($chars);

        // Start our string
        $string = $chars{rand(0, $chars_length)};
       
        // Generate random string
        for ($i = 1; $i < $length; $i++) {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};
            $string = $string . $r;
        }
       
        // Return the string
        return $string;
    }
}

$server = new Zend_Json_Server();
$method = $server->getRequest()->getMethod();
if ($method == 'login') {
    $server->setClass('LoginClient');
}
else {
    $server->setClass('SubconManagement');
}
$server->handle();
?>
