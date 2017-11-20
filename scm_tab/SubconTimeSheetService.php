<?php
//  2014-04-02  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   considered absent on leave request
//  2013-03-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add subcontractors.job_designation on staffs timesheet selection
//  2013-03-12  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   display correct timerecords on timesheets with same leads
//  2012-11-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix some rounding offs and lunch time computation to match prepaid automatic charging
//  2011-02-18  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add notes for leave requests
//  2011-01-13  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add timezone reference of timesheet
//  2011-01-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Integrate timezone settings
//  2010-03-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on admin with disabled account
//  2010-02-11  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix, trimmed subcontractors and admin emails
//  2010-01-04  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix on days for 2010
//  -   Removed deleted timesheets
//  2009-11-17  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Add to, server rejects email without to
//  2009-11-17  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Add email notifications
//  2009-11-16  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Add Timesheet Notes
//  2009-10-28  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack, JSON-RPC service

require('../conf/zend_smarty_conf.php');
require('../lib/validEmail.php');


class SubconTimeSheet {
    function __construct() {
        global $db;    
        $userid = $_SESSION['userid'];
        if ($userid == "") {
            throw new Exception('Please Login');
        }
        $this->userid = $userid;

        //get staffs timezone
        $sql = $db->select()
                ->from(Array('t' => 'timezone_lookup'), 'timezone')
                ->join(Array('p' => 'personal'), 'p.timezone_id = t.id')
                ->where('p.userid = ?', $userid);
        $tz = $db->fetchOne($sql);
        if ($tz == Null) {
            $this->staff_tz = 'Asia/Manila';
        }
        else {
            $this->staff_tz = $tz;
        }

    }


    public function get_time_sheets() {
        global $db;    
        $now = new Zend_Date();

        $sql = $db->select()
                ->from(array('t' => 'timesheet'), array('id', 'month_year', 'status'))
                ->join(array('l' => 'leads'), 't.leads_id = l.id', array('leads_fname' => 'fname', 'leads_lname' => 'lname'))
                ->join(array('s' => 'subcontractors'), 't.subcontractors_id = s.id', array('job_designation'))
                ->joinLeft(array('tz' => 'timezone_lookup'), 't.timezone_id = tz.id', array('timezone'))
                ->where('t.userid = ?', $this->userid)
                ->where('t.status != "deleted"')
                ->order(array('month_year', 'leads_fname', 'leads_lname'));
        
        $data = $db->fetchAll($sql);

        $time_sheets = array();
        $selected = False;

        foreach ($data as $timesheet) {
            $timezone = $timesheet['timezone'];
            if ($timezone == Null) {
                $timezone = 'Asia/Manila';
            }
            if ($timezone == 'PST8PDT') {
                $timezone = 'San Francisco';
            }

            $month_year = new Zend_Date($timesheet['month_year'], 'YYYY-MM-dd');
            //test for same month and year
            if (($now->toString('yyyy') == $month_year->toString('yyyy')) and ($now->toString('MM') == $month_year->toString('MM'))){
                if ($selected == False) {
                    $time_sheets[] = array('item' => "Current Month : " . $timesheet['job_designation']. " : " . $timesheet['leads_fname'] . " " . $timesheet['leads_lname'] , 'value' => $timesheet['id'], 'selected' => 'selected', 'timezone' => $timezone);
                    $selected = True;
                }
                else {
                    $time_sheets[] = array('item' => "Current Month : " . $timesheet['job_designation']. " : " . $timesheet['leads_fname'] . " " . $timesheet['leads_lname'] , 'value' => $timesheet['id'], 'selected' => '',  'timezone' => $timezone);
                }
            }
            else {
                $time_sheets[] = array('item' => $month_year->toString('MMMM') . " : " . $timesheet['job_designation']. " : " . $timesheet['leads_fname'] . " " . $timesheet['leads_lname'], 'value' => $timesheet['id'], 'selected' => '', 'timezone' => $timezone);
            }
        }

        return $time_sheets;
    }


    public function get_timesheet_details($timesheet_id) {
        global $db;
        $sql = $db->select()
                ->from('timesheet', array('month_year', 'userid', 'leads_id', 'status', 'subcontractors_id'))
                ->where('id = ?', $timesheet_id)
                ->where('userid = ?', $this->userid);
        $data = $db->fetchRow($sql);
        $month_year = $data['month_year'];
        $userid = $data['userid'];
        $leads_id = $data['leads_id'];
        $status = $data['status'];
        $subcontractors_id = $data['subcontractors_id'];

        $sql = $db->select()
                ->from('timesheet_details', array('id', 'timesheet_id', 'day', 'total_hrs', 'adj_hrs', 'regular_rostered', 'hrs_to_be_subcon'))
                ->where('timesheet_id = ?', $timesheet_id);
        $details = $db->fetchAll($sql);
        $data = array();

        date_default_timezone_set($this->staff_tz);
        $date = new Zend_Date($month_year, 'YYYY-MM-dd');

        $grand_total_hrs = 0;
        $grand_total_adj_hrs = 0;
        $grand_total_reg_ros_hrs = 0;
        $grand_total_hrs_to_be_subcon = 0;
        $grand_total_lunch_hrs = 0;

        foreach($details as $detail) {
            date_default_timezone_set($this->staff_tz);
            $day = new Zend_Date($date->toString('yyyy-MM-') . $detail['day'], 'YYYY-MM-dd');
            $day->setTimezone('Asia/Manila');
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
                    ->where('time_in >= ?', $day->toString('yyyy-MM-dd HH:mm:ss'))
                    ->where('time_in < ?', $end_day->toString('yyyy-MM-dd HH:mm:ss'))
                    ->where('mode = "regular"')
                    ->where('subcontractors_id = ?', $subcontractors_id)
                    ->where('leads_id = ?', $leads_id);

            //loop over the result
            foreach ($db->fetchAll($sql) as $timerecord) {
                date_default_timezone_set('Asia/Manila');
                $time_in_tmp = new Zend_Date($timerecord['time_in'], 'YYYY-MM-dd HH:mm:ss');
                $time_in_tmp->setTimezone($this->staff_tz);
                $time_in[] = $time_in_tmp->toString('MM/dd HH:mm');
                if ($timerecord['time_out'] != Null) {
                    date_default_timezone_set('Asia/Manila');
                    $time_out_tmp = new Zend_Date($timerecord['time_out'], 'YYYY-MM-dd HH:mm:ss');
                    $time_out_tmp->setTimezone($this->staff_tz);
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
                    //get lunch records
                    $time_in_tmp->setTimezone('Asia/Manila');
                    $time_out_tmp->setTimezone('Asia/Manila');
                    $sql_lunch = $db->select()
                            ->from('timerecord')
                            ->where('userid = ?', $userid)
                            ->where('time_in >= ?', $time_in_tmp->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('time_in < ?', $time_out_tmp->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('mode = "lunch_break"')
                            ->where('leads_id = ?', $leads_id);

                    foreach ($db->fetchAll($sql_lunch) as $timerecord_lunch){
                        $lunch_in_tmp = new Zend_Date($timerecord_lunch['time_in'], 'YYYY-MM-dd HH:mm:ss');
                        $lunch_in_tmp->setTimezone($this->staff_tz);
                        $lunch_in[] = $lunch_in_tmp->toString('MM/dd HH:mm');
                        if ($timerecord_lunch['time_out'] != Null) {
                            $lunch_out_tmp = new Zend_date($timerecord_lunch['time_out'], 'YYYY-MM-dd HH:mm:ss');
                            $lunch_out_tmp->setTimezone($this->staff_tz);
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
            $notes = $this->GetTimeSheetNotes($detail['id']);

            $day->setTimezone($this->staff_tz);

            $data[] = array(
                'id' => $detail['id'],
                'day' => $day->toString('EEE'),
                'date' => $day->toString('dd'),
                'time_in' => $time_in,
                'time_out' => $time_out,
                'total_hrs' => number_format($total_hrs, 2),
                'adjusted_hrs' => number_format($detail['adj_hrs'], 2),
                'regular_rostered_hrs' => number_format($detail['regular_rostered'], 2),
                'hrs_to_be_subcon' => number_format($detail['hrs_to_be_subcon'], 2),
                'lunch_hours' => number_format($total_lunch_hrs, 2),
                'lunch_in' => $lunch_in,
                'lunch_out' => $lunch_out,
                'notes' => $notes
            );

            $grand_total_hrs += number_format($total_hrs, 2);
            $grand_total_adj_hrs += number_format($detail['adj_hrs'], 2);
            $grand_total_reg_ros_hrs += number_format($detail['regular_rostered'], 2);
            $grand_total_hrs_to_be_subcon += number_format($detail['hrs_to_be_subcon'], 2);
            $grand_total_lunch_hrs += number_format($total_lunch_hrs, 2);
        }

        $totals = array(
            'grand_total_hrs' => number_format($grand_total_hrs, 2),
            'grand_total_adj_hrs' => number_format($grand_total_adj_hrs, 2),
            'grand_total_reg_ros_hrs' => number_format($grand_total_reg_ros_hrs, 2),
            'grand_total_hrs_to_be_subcon' => number_format($grand_total_hrs_to_be_subcon, 2),
            'grand_total_lunch_hrs' => number_format($grand_total_lunch_hrs, 2),
        );

        return array('timesheet_details' => $data, 'timesheet_totals' => $totals, 'timesheet_status' => $status);
    }


    private function GetTimeSheetNotes($timesheet_detail_id) {
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
            $timestamp->setTimezone($this->staff_tz);
            $notes[] = array(
                'timestamp' => $timestamp->toString('YYYY-MM-dd HH:mm:ss'),
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
            $timestamp->setTimezone($this->staff_tz);
            $notes[] = array(
                'timestamp' => $timestamp->toString('YYYY-MM-dd HH:mm:ss'),
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
                ->from('leave_request_dates', array('leave_request_id', 'status'))
                ->where('date_of_leave = ?', $date_of_leave)
                ->where('status IN ("approved", "absent")');
        $leave_requests = $db->fetchAll($sql);

        $has_leave_request = array();
        foreach ($leave_requests as $data_leave_request) {
            $leave_request_id = $data_leave_request['leave_request_id'];
            $status = $data_leave_request['status'];
            $sql = $db->select()
                    ->from('leave_request', array('userid', 'leads_id', 'date_requested'))
                    ->where('id = ?', $leave_request_id);
            $leave_request = $db->fetchRow($sql);
            if (($userid == $leave_request['userid']) && ($leads_id == $leave_request['leads_id'])){
                date_default_timezone_set('Asia/Manila');
                $timestamp = new Zend_Date($leave_request['date_requested'], 'YYYY-MM-dd HH:mm:ss');
                $timestamp->setTimezone($this->staff_tz);
                if ($status == 'approved') {
                    $note = 'ON LEAVE';
                }
                else {
                    $note = 'ABSENT';
                }
                $has_leave_request[] = array(
                    'timestamp' => $timestamp->toString('YYYY-MM-dd HH:mm:ss'),
                    'fname' => 'LEAVE REQUEST SYSTEM',
                    'lname' => '',
                    'note' => $note
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
            'userid' => $this->userid,
            'timestamp' => $now->toString('yyyy-MM-dd HH:mm:ss'),
            'note' => $note
        );

        $db->insert('timesheet_notes_subcon', $data);

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

        $leads_id = $timesheet_data['leads_id'];
		$subcontractors_id = $timesheet_data['subcontractors_id'];
		
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
            ->where('userid = ?', $this->userid);
        $personal = $db->fetchRow($sql);
        $subcon_fname = $personal['fname'];
        $subcon_lname = $personal['lname'];
        $subcon_email = trim($personal['email']);
		
		
		//Get staff subcontractors.staff_email
		$sql=$db->select()
			->from('subcontractors', 'staff_email')
			->where('id =?', $subcontractors_id);
		$staff_email = $db->fetchOne($sql);	
		
		if($staff_email){
			$subcon_email = trim($staff_email);
		}

        $subject = "New Timesheet Note from : $subcon_fname $subcon_lname";
        $date_str = $now->toString('yyyy-MM-dd hh:mm a z');
        $message = "Timesheet Month: $timesheet_month_str\r\nTimesheet Day: $timesheet_day\r\nDate/Time noted: $date_str\r\nClient: $client_fname $client_lname\r\nNoted by: $subcon_fname $subcon_lname\r\n\r\nNote: $note";

        $mail = new Zend_Mail();
        $mail->setBodyText($message);
        $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
        $mail->setSubject($subject);

        if (TEST) {
                $mail->addTo('devs@remotestaff.com.au');
        }
        else {
            if (validEmailv2($subcon_email)) {
                $mail->addTo($subcon_email);
            }

            foreach ($emails as $email) {
                $admin_email = trim($email['admin_email']);
                if (validEmailv2($admin_email)) {
                    $mail->addBcc($admin_email);
                }
            }
        }

        $mail->send($transport);

        $notes = $this->GetTimeSheetNotes($timesheet_details_id);
        return $notes;
    }


    public function get_time_zone() {
        global $db;    

        $sql = $db->select()
                ->from(Array('p' => 'personal'), 't.timezone')
                ->join(Array('t' => 'timezone_lookup'), 'p.timezone_id = t.id')
                ->where('p.userid = ?', $this->userid);
        
        $tz = $db->fetchOne($sql);

        if ($tz == False) {
            $tz = 'Asia/Manila';
        }
        
        if ($tz == 'PST8PDT') {
            $tz = 'San Francisco';
        }

        #get timezone list
        $sql = $db->select()
                ->from('timezone_lookup', Array('id','timezone'))
                ->order('timezone');
        $tz_list = $db->fetchAll($sql);

        $tz_list2 = Array();

        #loop over list and replace PST8PDT
        foreach ($tz_list as $x) {
            if ($x['timezone'] == 'PST8PDT') {
                $tz_list2[] = Array('id' => $x['id'], 'timezone' => 'San Francisco');
            }
            else {
                $tz_list2[] = Array('id' => $x['id'], 'timezone' => $x['timezone']);
            }
        }

        asort($tz_list2);
        
        return Array('tz' => $tz, 'tz_list' => $tz_list2);
    }


    public function set_time_zone($tz_id) {
        global $db;    
        $data = Array(
            'timezone_id' => $tz_id
        );

        $db->update('personal', $data, "userid = $this->userid");
        return $tz_id;
    }
}

$server = new Zend_Json_Server();
$server->setClass('SubconTimeSheet');
$server->handle();
?>
