<?php
    //2010-01-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  prevent multiple lunch starts
    //2009-12-17 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  added mailer for activity notes when staff has logged out
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependencies on rowCount
    //  convert date comparison to Ymd type
    //2009-02-09 Lawrence Sunglao <locsunglao@yahoo.com>
    //  Modified to suit the new screen capture system
    //2009-01-26 Lawrence Sunglao <locsunglao@yahoo.com>
    //  Display clients preferred timezone on Subcontractor Management/Timesheet
    //  Display staffs start time/end time 

	/*
	Added By Norman Dec.1,2008
	-	To determine the subcon working hours in a day if it is Wholeday, Halfday work...
	-   and also to determine what kind of payment will be charge to the subcon's Client
	Modified 
	- The working days and working hours must come to subcon's registered working days and working hours save from subcontractors table
	- Charge to Client is per day...
	- Created GetClientPaymentTotalAmount() to get the total payments that will be charge to Client...
	
	Added By Norman Dec.3, 2008
	-	added fields in the subcon_invoice
	*/
	
    //2008-11-25
    //  CreateAutomaticInvoice to include generated, subcontractors_id, client_amount
    //2008-11-23
    //  remove the 24 hour limit
    //2008-10-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  added a function GetCurrentLeadsID() to grab the leads_id that the current subcon is working on
    //  added functions GetMonthlyTimeSheetForClient and GetTimeRecordsForClient
    //revisions 2008-09-02 11:00 am by Lawrence Sunglao<locsunglao@yahoo.com>
    //  display all days/dates
    //  add notes
    //revisions 2008-07-02 11:24 am by Lawrence Sunglao<locsunglao@yahoo.com>
    //removed AM/PM stuff and just replace it with start work/stop work

    //include("../conf.php");
    include_once("../zend_conf.php");
    include_once("ActivityNotesMailer.php");
    //ini_set("include_path",  ".:../lib:..");
    //TODO remove OnlinePresence.php library
    //include_once("online_presence/OnlinePresence.php");
    date_default_timezone_set("Asia/Manila");


    /**
     *
     * TimeRecording Library
     *
     * This is the long description for the Class
     *
     * @author		Lawrence Oliver C. Sunglao
     */
    class TimeRecording{
        public $dbh;
        public $db;
        private $userid;
        public $buttons;
        private $tz;    //timezone
        private $latest_lead_record_id;
        private $last_record;
        private $last_lunch_record;

        function __construct($userid) {
            global $dbserver, $dbname, $dbuser, $dbpwd, $db;
            $this->db = $db;
            try {
                $this->dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
            } catch (PDOException $exception) {
                echo "Connection errorss: " . $exception->getMessage();
                die();
            }
            if ($userid == null) {
                die('User id not found!');
            }
            $this->userid = $userid;

            $this->tz = new DateTimeZone('Asia/Manila');
            $this->now = new DateTime();
            $this->now->setTimeZone($this->tz);
            $this->date_today = new DateTime($this->now->format('Y-m-d'));
            $this->date_today->setTimeZone($this->tz);
            $this->last_lunch_record = null;

            $this->buttons = array();
            $this->buttons['work_start'] = false;
            $this->buttons['work_end'] = false;
            $this->buttons['lunch_start'] = false;
            $this->buttons['lunch_end'] = false;
            $this->latest_lead_record_id = false;

            $this->ProcessButtons();
        }


        function GetSubcontractorsList($leads_id = false) {
            //query the subcontractors table
            if ($leads_id) {
                $query = "select s.id, l.fname, l.lname, l.company_name, s.posting_id, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour from subcontractors as s left join leads as l on s.leads_id = l.id where userid=$this->userid and s.leads_id = $leads_id and s.status = 'ACTIVE' order by s.date_contracted;";
            }
            else {
                $query = "select s.id, l.fname, l.lname, l.company_name, s.posting_id, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour from subcontractors as s left join leads as l on s.leads_id = l.id where userid=$this->userid and s.status = 'ACTIVE' order by s.date_contracted;";
            }

            $result = $this->dbh->query($query);

            //TODO all staffs default to asia/Manila
            $staff_time_zone = new DateTimeZone('Asia/Manila');

            $subcon_list = array();
            foreach ($result->fetchAll() as $row){
                try {
                    $time_zone = new DateTimeZone($row['client_timezone']);
                }
                catch (Exception $e) {
                    $time_zone = new DateTimeZone('Asia/Manila');
                }

                $start_work_hour_str = $row['client_start_work_hour'];
                if ($start_work_hour_str == null) {
                    $start_work_hour = "";
                }
                else {
                    //INFO: Due to the client_start_work_hour field type, I had to append a :00
                    $time = new DateTime($start_work_hour_str.":00", $time_zone);
                    $time->setTimeZone($staff_time_zone);
                    $start_work_hour = $time->format('h:i a');
                }

                $finish_work_hour_str = $row['client_finish_work_hour'];
                if ($finish_work_hour_str == null) {
                    $finish_work_hour = "";
                }
                else {
                    //INFO: Due to the client_start_work_hour field type, I had to append a :00
                    $time = new DateTime($finish_work_hour_str.":00", $time_zone);
                    $time->setTimeZone($staff_time_zone);
                    $finish_work_hour = $time->format('h:i a');
                }

                $subcon_list[] = array('id' => $row['id'], 
                    'fname' => $row['fname'], 
                    'lname' => $row['lname'], 
                    'company_name' => $row['company_name'],
                    'posting_id' => $row['posting_id'],
                    'start_work_hour' => $start_work_hour,
                    'finish_work_hour' => $finish_work_hour,
                    'staff_timezone' => $staff_time_zone->getName());
            }

            return $subcon_list;
        }


        function GetActiveClient() {
            if ($this->latest_lead_record_id) {
                return array('locked' => true, 'leads' => $this->GetSubcontractorsList($this->latest_lead_record_id));
            }
            else {
                return array('locked' => false, 'leads' => $this->GetSubcontractorsList());
            }
        }

        /**
        *
        * Returns the current leads_id that the subcontractor is working for
        *
        * @return	integer
        * @access	public
        */
        function GetCurrentLeadsID() {
            return $this->latest_lead_record_id;
        }

        function GetAllLunchTimeRecordsForToday() {
            $date_today_str = $this->date_today->format('Y-m-d');
            $date_end = clone($this->date_today);
            $date_end->modify('+1 day');
            $date_end_str = $date_end->format('Y-m-d');
            $query = "select * from timerecord where userid = $this->userid and time_in BETWEEN '$date_today_str' and '$date_end_str' and mode='lunch_break' order by time_in";
            $result = $this->dbh->query($query);
            $data = array();
            foreach ($result->fetchAll() as $row) {
                $data[] = array('id' => $row['id'], 
                    'leads_id' => $row['leads_id'], 
                    'subcontractors_id' => $row['subcontractors_id'],
                    'time_in' => $row['time_in'],
                    'time_out' => $row['time_out'],
                    'mode' => $row['mode'],
                    'notes' => $row['notes']);
            }
            return $data;
        }

        function GetAllRegularTimeRecordsForToday() {
            $date_today_str = $this->date_today->format('Y-m-d');
            $date_end = clone($this->date_today);
            $date_end->modify('+1 day');
            $date_end_str = $date_end->format('Y-m-d');
            $query = "select * from timerecord where userid = $this->userid and time_in BETWEEN '$date_today_str' and '$date_end_str' and mode='regular' order by time_in";
            $result = $this->dbh->query($query);
            $data = array();
            foreach ($result->fetchAll() as $row) {
                $data[] = array('id' => $row['id'], 
                    'leads_id' => $row['leads_id'], 
                    'subcontractors_id' => $row['subcontractors_id'],
                    'time_in' => $row['time_in'],
                    'time_out' => $row['time_out'],
                    'mode' => $row['mode'],
                    'notes' => $row['notes']);
            }
            return $data;
        }
    

        function EnableButton($button_key) {
            $this->buttons[$button_key] = true;
        }

        function DisableButton($button_key) {
            $this->buttons[$button_key] = false;
        }

        private function DisableAllButtons() {
            forEach ($this->buttons as $button) {
                $button = false;
            }
        }


        function GetLatestRegularTimeRecord() {
            $query = "select * from timerecord where userid = $this->userid and mode = 'regular' order by time_in desc limit 1";
            $result = $this->dbh->query($query);
            $data = array();
            foreach ($result->fetchAll() as $row) {
                $data[] = array('id' => $row['id'], 
                    'leads_id' => $row['leads_id'], 
                    'subcontractors_id' => $row['subcontractors_id'],
                    'time_in' => $row['time_in'],
                    'time_out' => $row['time_out'],
                    'mode' => $row['mode'],
                    'notes' => $row['notes']);
            }
            return $data;
        }


        function GetLatestLunchTimeRecord() {
            $query = "select * from timerecord where userid = $this->userid and mode = 'lunch_break' order by time_in desc limit 1";
            $result = $this->dbh->query($query);
            $data = array();
            foreach ($result->fetchAll() as $row) {
                $data[] = array('id' => $row['id'], 
                    'leads_id' => $row['leads_id'], 
                    'subcontractors_id' => $row['subcontractors_id'],
                    'time_in' => $row['time_in'],
                    'time_out' => $row['time_out'],
                    'mode' => $row['mode'],
                    'notes' => $row['notes']);
            }
            return $data;
        }


        function ProcessButtons() {
            //disables all buttons first
            $this->DisableAllButtons();

            //check if no clients
            $query = "select id from subcontractors where userid = $this->userid";
            $result = $this->dbh->query($query)->fetchAll();
            if (count($result) == 0) {
                return;
            }

            $latest_regular_time_record = $this->GetLatestRegularTimeRecord();

            //no time records yet probably a new employee
            if (count($latest_regular_time_record) == 0) {  
                $this->EnableButton('work_start');
                return;
            }

            $this->last_record = $latest_regular_time_record[0];
            $time_in = $latest_regular_time_record[0]['time_in'];
            $time_out = $latest_regular_time_record[0]['time_out'];

            //time_out has value just enable the 'work_start'
            if ($time_out != null) {
                $this->EnableButton('work_start');
                return;
            }

            //we reached here, enable 'work_end'
            $this->EnableButton('work_end');
            $this->latest_lead_record_id = $this->last_record['leads_id'];

            //check for lunch_break, must have only one lunch break per regular type time record
            $latest_lunch_time_record = $this->GetLatestLunchTimeRecord();

            //no lunch time records yet, just enable it for now
            if (count($latest_lunch_time_record) == 0) {
                $this->EnableButton('lunch_start');
                return;
            }

            $this->last_lunch_record = $latest_lunch_time_record[0];

            $lunch_time_in = $latest_lunch_time_record[0]['time_in'];
            $lunch_time_out = $latest_lunch_time_record[0]['time_out'];

            $regular_time_in_date = new DateTime($time_in);
            $lunch_time_in_date = new DateTime($lunch_time_in);

            //regular_time_in is greater that lunch_time
            if ($regular_time_in_date->format('U') > $lunch_time_in_date->format('U')) {
                $this->EnableButton('lunch_start');
                $this->EnableButton('work_end');
                return;
            }

            if ($lunch_time_out == null) {
                $this->EnableButton('lunch_end');
                $this->DisableButton('work_end');
                return;
            }

        }


        function GetButtons() {
            return $this->buttons;
        }


        function RecordTimeIn($subcontractor_id) {
            if (($this->last_record != null) && ($this->last_record['time_out'] == null)) {
                return array('status' => 'ERROR 1', 'msg' => 'Invalid response, please contact admin.');
            }

            //query subcontractor
            $query = "select id, leads_id, agent_id, posting_id from subcontractors where id = $subcontractor_id";
            $result = $this->dbh->query($query);
            $subcontractor_record = $result->fetchAll();

            //insert record on timerecord
            $leads_id = $subcontractor_record[0]['leads_id'];
            $posting_id = $subcontractor_record[0]['posting_id'];
            $now = $this->now->format('Y-m-d H:i:s');
            $query = "insert into timerecord (userid, leads_id, posting_id, subcontractors_id, time_in, mode) values ('$this->userid', '$leads_id', $posting_id, '$subcontractor_id', '$now', 'regular')";

            $affected = $this->dbh->exec($query);
            if ($affected != 1) {
                return array('status' => 'ERROR 3', 'msg' => 'Invalid response, please contact admin.');
            }

            //reset online presence
            $online_presence = new OnlinePresence($this->userid, 'subcon');
            $online_presence->logIn($leads_id);

            //activity_tracker table
            //grab the subcontractors name
            $leads_id = $this->db->fetchOne('SELECT leads_id from subcontractors where id = ?', $subcontractor_id);

            $leads_data = $this->db->fetchRow('SELECT * from leads where id = ?', $leads_id);
            $leads_name = $leads_data['fname'] . ' ' . $leads_data['lname'];

            $data = array(
                'userid' => $this->userid,
                'last_snapshot_time' => $now,
                'last_machine_reported_time' => $now,
                'last_activity_note_time' => $now,
                'subcontractors_id' => $subcontractor_id,
                'leads_id' => $leads_id,
                'leads_name' => $leads_name,
                'status' => 'working'
            );

            $result = $this->db->fetchOne('SELECT userid from activity_tracker where userid = ?', $this->userid);

            if ($result == null) {
                $this->db->insert('activity_tracker', $data);
            }
            else {
                $this->db->update('activity_tracker', $data, "userid = $this->userid");
            }
            
            return array('status' => 'OK', 'msg' => 'Work started...');
        }


        function RecordTimeOut() {
            if ($this->last_record['time_out'] != null) {
                return array('status' => 'ERROR', 'msg' => 'Invalid response, please contact admin.');
            }
            if ($this->last_record['mode'] != 'regular') {
                return array('status' => 'ERROR', 'msg' => 'Invalid response, please contact admin.');
            }
            $id = $this->last_record['id'];
            $now = $this->now->format('Y-m-d H:i:s');

            //sends email upon logout if its set by client
            $activity_notes_mailer = new ActivityNotesMailer($id);
            $activity_notes_mailer->Logout();
            
            //update timerecord
            $query = "update timerecord set time_out = '$now' where id = $id";
            $affected = $this->dbh->exec($query);
            if ($affected != 1) {
                return array('status' => 'ERROR', 'msg' => 'Invalid response, please contact admin.');
            }

            //reset online presence
            $online_presence = new OnlinePresence($this->userid, 'subcon');
            $online_presence->logOut($this->latest_lead_record_id);

            // activity_tracker table
            $data = array(
                'userid' => $this->userid,
                'last_machine_reported_time' => $now,
                'subcontractors_id' => $subcontractor_id,
                'leads_name' => '',
                'leads_id' => null,
                'status' => 'not working'
            );
            $this->db->update('activity_tracker', $data, "userid = $this->userid");

            return array('status' => 'OK', 'msg' => 'Work ended...');
        }


        function RecordLunchStart($subcontractor_id) {
            if (($this->last_record != null) && ($this->last_record['time_out'] != null)) {
                return array('last_record' => $this->last_record,'status' => 'ERROR', 'msg' => 'Invalid response, You are not logged in yet.');
            }

            //check for multiple lunch start
            $last_regular_record_id = $this->last_record['id'];
            $query = "select * from timerecord where mode='lunch_break' and id > $last_regular_record_id and userid=$this->userid";
            $result = $this->dbh->query($query);

            if (count($result->fetchAll()) > 0) {
                return array('status' => 'ERROR', 'msg' => 'You have started your lunch already.');
            }

            //query subcontractor
            $query = "select id, leads_id, agent_id, posting_id from subcontractors where id = $subcontractor_id";
            $result = $this->dbh->query($query);
            $subcontractor_record = $result->fetchAll();

            //insert record on timerecord
            $leads_id = $subcontractor_record[0]['leads_id'];
            $posting_id = $subcontractor_record[0]['posting_id'];
            $now = $this->now->format('Y-m-d H:i:s');
            $query_insert = "insert into timerecord (userid, leads_id, posting_id, subcontractors_id, time_in, mode) values ('$this->userid', '$leads_id', '$posting_id', '$subcontractor_id', '$now', 'lunch_break')";

            $affected = $this->dbh->exec($query_insert);
            if ($affected != 1) {
                return array('status' => 'ERROR', 'msg' => 'Invalid response, please contact admin.');
            }

            // activity_tracker table
            $data = array(
                'last_machine_reported_time' => $now,
                'last_activity_note_time' => $now,
                'last_snapshot_time' => $now,
                'status' => 'lunch break'
            );
            $this->db->update('activity_tracker', $data, "userid = $this->userid");

            return array('status' => 'OK', 'msg' => 'Lunch started...');
        }


        function RecordLunchEnd($subcontractor_id) {
            if ($this->last_lunch_record['time_out'] != null) {
                return array('status' => 'ERROR', 'msg' => 'Invalid response, please contact admin.');
            }
            $id = $this->last_lunch_record['id'];
            $now = $this->now->format('Y-m-d H:i:s');
            $query = "update timerecord set time_out = '$now' where id = $id";
            $affected = $this->dbh->exec($query);
            if ($affected != 1) {
                return array('status' => 'ERROR', 'msg' => 'Invalid response, please contact admin.');
            }

            // activity_tracker table
            $data = array(
                'last_machine_reported_time' => $now,
                'last_activity_note_time' => $now,
                'last_snapshot_time' => $now,
                'status' => 'working'
            );
            $this->db->update('activity_tracker', $data, "userid = $this->userid");

            return array('status' => 'OK', 'msg' => 'Lunch ended...');
        }


        function GetDayOf($record) {
            $time_in = new DateTime($record['time_in']);
            $day_of = $time_in->format('D m/d');
            return $day_of;
        }

        /**
        *
        * This is the short Description for the Function
        *
        * This is the long description for the Class
        *
        * @return	mixed	 Description
        * @access	public
        * @see		??
        *
        */
        function CreateAutomaticInvoice($date_start, $date_end, $invoice_id) {
            $date_start_str = $date_start->format('Y-m-d');
            $date_end_str = $date_end->format('Y-m-d 23:59:59');
            //subcontractors_id field refers to the id of the subcontractor table
            $query = "select t.id, t.userid, l.fname, l.lname, l.company_name, t.subcontractors_id, t.posting_id, t.time_in, t.time_out, s.working_hours from timerecord as t left join leads as l on t.leads_id = l.id left join subcontractors as s on t.subcontractors_id = s.id where t.userid = $this->userid and t.mode = 'regular' and t.time_in BETWEEN '$date_start_str' and '$date_end_str' order by t.time_in desc";
            $result = $this->dbh->query($query);
            $invoice_details = new InvoiceDetails($invoice_id);
            forEach ($result->fetchAll() as $record) {
                $invoice_details->AddRecord($record);
            }
            $total_amount = $invoice_details->GetTotalAmount();
			//$client_payment_total_amount = $invoice_details->GetClientPaymentTotalAmount();
			$subcon_total_days_work = $invoice_details-> GetSubconDaysWork();
			$client_daily_rate = $invoice_details->GetClientDailyRate();
			$client_payment_total_amount = $client_daily_rate * $subcon_total_days_work;
			
            //update total amount on subcon_invoice table
            $query = "update subcon_invoice set total_amount = '$total_amount' , client_payment_total_amount = $client_payment_total_amount , subcon_total_days_work = $subcon_total_days_work where id = $invoice_id";
            $result = $this->dbh->exec($query);
			
			
        }

        function GetTimeRecords($date_start, $date_end){
            $date_start_clone = clone($date_start);
            $date_end_clone = clone($date_end);

            //check if date_end_clone is greater than current date, if greater, use current date
            $date_now = new DateTime();
            if ($date_end_clone->format("Ymd") > $date_now->format("Ymd")) {
                $date_end_clone = clone($date_now);
                $date_end_clone_str = $date_end_clone->format('Y-m-d 00:00:00');
                $date_end_clone = new DateTime($date_end_clone_str);
                $date_end_clone->modify('+1 day');
            }

            $formattedTimeRecord = new FormattedTimeRecord($this->userid);
            while ($date_start_clone->format("Ymd") < $date_end_clone->format("Ymd")) {
                $date_end_clone->modify('-1 day');
                $date_start_str = $date_end_clone->format('Y-m-d 00:00:00');
                $date_end_str = $date_end_clone->format('Y-m-d 23:59:59');

                //subcontractors_id field refers to the id of the subcontractor table
                $query = "select t.id, t.userid, l.fname, l.lname, l.company_name, t.subcontractors_id, t.posting_id, t.time_in, t.time_out, s.working_hours, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour from timerecord as t left join leads as l on t.leads_id = l.id left join subcontractors as s on t.subcontractors_id = s.id where t.userid = $this->userid and t.mode = 'regular' and t.time_in BETWEEN '$date_start_str' and '$date_end_str' order by t.time_in desc";
                $result = $this->dbh->query($query)->fetchAll();
                
                if (count($result) == 0) {
                    $formattedTimeRecord->AddBlankRecord($date_end_clone);
                }
                else {
                    foreach ($result as $record) {
                        $formattedTimeRecord->AddRecord($record);
                    }
                }
            } 
            return $formattedTimeRecord->GetFormattedRecord();
        }

        function GetTimeRecordsForClient($date_start, $date_end, $leads_id){
            $date_start_clone = clone($date_start);
            $date_end_clone = clone($date_end);

            //check if date_end_clone is greater than current date, if greater, use current date
            $date_now = new DateTime();
            if ($date_end_clone->format("Ymd") > $date_now->format("Ymd")) {
                $date_end_clone = clone($date_now);
                $date_end_clone_str = $date_end_clone->format('Y-m-d 00:00:00');
                $date_end_clone = new DateTime($date_end_clone_str);
                $date_end_clone->modify('+1 day');
            }

            $formattedTimeRecord = new FormattedTimeRecord($this->userid);
            while ($date_start_clone->format("Ymd") < $date_end_clone->format("Ymd")) {
                $date_end_clone->modify('-1 day');
                $date_start_str = $date_end_clone->format('Y-m-d 00:00:00');
                $date_end_str = $date_end_clone->format('Y-m-d 23:59:59');

                //subcontractors_id field refers to the id of the subcontractor table
                $query = "select t.id, t.userid, l.fname, l.lname, l.company_name, t.subcontractors_id, t.posting_id, t.time_in, t.time_out, s.working_hours, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour from timerecord as t left join leads as l on t.leads_id = l.id left join subcontractors as s on t.subcontractors_id = s.id where t.userid = $this->userid and t.mode = 'regular' and t.time_in BETWEEN '$date_start_str' and '$date_end_str' and t.leads_id = $leads_id order by t.time_in desc";
                $result = $this->dbh->query($query)->fetchAll();
                
                if (count($result) == 0) {
                    $formattedTimeRecord->AddBlankRecord($date_end_clone);
                }
                else {
                    foreach ($result as $record) {
                        $formattedTimeRecord->AddRecord($record);
                    }
                }
            } 
            return $formattedTimeRecord->GetFormattedRecord();
        }

        function GetMonthlyTimeSheet($date_str) {
            $date_ref = new DateTime($date_str);
            $day_start_str = $date_ref->format('Y-m-01');
            $day_start = new DateTime($day_start_str);

            $day_end = clone($day_start);
            $day_end->modify('+1 months');
            $return_data = $this->GetTimeRecords($day_start, $day_end);
            return $return_data;
        }

        function GetMonthlyTimeSheetForClient($date_str, $leads_id) {
            $date_ref = new DateTime($date_str);
            $day_start_str = $date_ref->format('Y-m-01');
            $day_start = new DateTime($day_start_str);

            $day_end = clone($day_start);
            $day_end->modify('+1 months');
            $return_data = $this->GetTimeRecordsForClient($day_start, $day_end, $leads_id);
            return $return_data;
        }


        function GetTimeSheet() {
            $day_of_week = $this->now->format('N');
            $day_start = clone($this->now);

            $day_start->modify('-' . $day_of_week . ' days');

            $day_end = clone($this->now);
            $day_end->modify('+1 days');
            $return_data = $this->GetTimeRecords($day_start, $day_end);
            return $return_data;
        }


        function GetMonitorUser() {
            if (($this->buttons['work_start'] == false) && ($this->buttons['lunch_end'] == false)) {
                return true;
            }
            else {
                return false;
            }
        }

    }

    class FormattedTimeRecord {
        var $dbh;
        private $total_hours;
        private $client_with_subcontractors_details;
        private $formatted_record;
        private $record_no;
        var $tz_ph;
        var $tz_au;
        function __construct($user_id) {
            global $dbserver, $dbname, $dbuser, $dbpwd;
            try {
                $this->dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
                die();
            }
            $this->day_of = '';
            $this->formatted_record = array();
            $this->am_or_pm = '';
            $this->record_no = 0;
            $this->tz_ph = new DateTimeZone('Asia/Manila');
            $this->tz_au = new DateTimeZone('Australia/Sydney');
            $this->userid = $user_id;
        }

        /**
        *
        * @return	string	 Description
        * @access	public
        * @see		??
        */
        function GetBroadcastRecordNotes($date) {
            $date_str = $date->format('Y-m-d');
            $userid = $this->userid;
            $query = "SELECT note from timerecord_notes where reference_date = '$date_str' and posted_by_type = 'admin' and note_type = 'broadcast' order by time_stamp";
            $data = $this->dbh->query($query);
            $return_string = '';
            foreach ($data->fetchAll() as $row) {
                $return_string .= $row['note'] . ' ';
            }
            return $return_string;
        }

        /**
        *
        * Returns records from timerecord_notes table those with timerecord_id reference
        *
        * @return	String
        * @access	public
        */
        function GetRecordNotes($record_id) {
            $query = "SELECT note from timerecord_notes where timerecord_id = $record_id order by time_stamp";
            $data = $this->dbh->query($query);
            $return_string = '';
            foreach ($data->fetchAll() as $row) {
                $return_string .= $row['note'] . ' ';
            }
            return $return_string;
        }

        /**
        *
        * Returns records from timerecord_notes table those with out timerecord_id reference
        *
        * @return	String
        * @access	public
        */
        function GetRecordNotesOnBlankDays($date) {
            $date_str = $date->format('Y-m-d');
            $userid = $this->userid;
            $query = "SELECT note from timerecord_notes where reference_date = '$date_str' and userid = $userid order by time_stamp";
            $data = $this->dbh->query($query);
            $return_string = '';
            foreach ($data->fetchAll() as $row) {
                $return_string .= $row['note'] . ' ';
            }
            return $return_string;
        }

        /**
        * class FormattedTimeRecord
        */
        function AddRecord($record) {
            $day_of = $this->GetDayOf($record);
            if ($day_of != $this->day_of) {
                $this->day_of = $day_of;
            }
            else {
                $day_of = '';
            }

            $client_with_subcontractors_details = $this->GetClientWithSubcontracDetails($record);

            $total_hours = $this->GetTotalHours($record);
            list($start_lunch_ph, $finish_lunch_ph, $start_lunch_au, $finish_lunch_au) = $this->GetLunchHours($record);
            list($start_lunch, $finish_lunch) = $this->GetLunchHoursRawTime($record);
            $total_lunch_hours = $this->GetTotalLunchSeconds($record) / 60 / 60;

            $time_in_ph = $this->FormatTimePH($record['time_in']);
            $time_out_ph = $this->FormatTimePH($record['time_out']);
            $time_in_au = $this->FormatTimeAU($record['time_in']);
            $time_out_au = $this->FormatTimeAU($record['time_out']);

            $record_date = new DateTime($record['time_in']);
            $timerecord_notes = $this->GetRecordNotes($record['id']) . ' ' . $this->GetRecordNotesOnBlankDays($record_date) . ' ' . $this->GetBroadcastRecordNotes($record_date);

            try {
                $client_timezone = new DateTimeZone($record['client_timezone']);
            } catch (Exception $e) {
                $client_timezone = new DateTimeZone('Asia/Manila');
            }

            $time_in_default = $this->FormatTimeClientTimezone($record['time_in'], $client_timezone);
            $time_out_default = $this->FormatTimeClientTimezone($record['time_out'], $client_timezone);
            $start_lunch_default = $this->FormatTimeClientTimezone($start_lunch, $client_timezone);
            $finish_lunch_default = $this->FormatTimeClientTimezone($finish_lunch, $client_timezone);
            
            $new_record = $this->GetNewRecordTemplate();
            $new_record['day_of'] = $day_of;
            $new_record['total_hours'] = $total_hours;
            $new_record['time_in_ph'] = $time_in_ph;
            $new_record['time_out_ph'] = $time_out_ph;
            $new_record['time_in_au'] = $time_in_au;
            $new_record['time_out_au'] = $time_out_au;
            $new_record['client'] = $client_with_subcontractors_details;
            $new_record['subcontractors_id'] = $record['subcontractors_id'];
            $new_record['working_hours'] = $record['working_hours'];
            $new_record['start_lunch_ph'] = $start_lunch_ph;
            $new_record['start_lunch_au'] = $start_lunch_au;
            $new_record['finish_lunch_ph'] = $finish_lunch_ph;
            $new_record['finish_lunch_au'] = $finish_lunch_au;
            $new_record['total_lunch_hours'] = $total_lunch_hours;

            $new_record['blank'] = 'no';
            $new_record['notes_day_of_week'] = $this->GetDayOf($record);
            $new_record['timerecord_notes'] = $timerecord_notes;
            $new_record['record_id'] = $record['id'];
            $new_record['date'] = $record_date->format('Y-m-d');
            $new_record['day_of_notes'] = $this->GetDayOf($record);

            $new_record['time_in_default'] = $time_in_default;
            $new_record['time_out_default'] = $time_out_default;
            $new_record['start_lunch_default'] = $start_lunch_default;
            $new_record['finish_lunch_default'] = $finish_lunch_default;
            $new_record['client_timezone'] = $client_timezone->getName();


            $this->formatted_record[] = $new_record;

        }

        
        /**
        *
        * Converts time to clients time zone
        *
        * @return	string
        */
        function FormatTimeClientTimezone($time, $time_zone) {
            if ($time == null) {
                return '';
            }
            $time = new DateTime($time);
            $time->setTimeZone($time_zone);
            return $time->format('h:i a');
        }


        function AddBlankRecord($date) {
            $day_of = $date->format('D d/m');
            if ($day_of != $this->day_of) {
                $this->day_of = $day_of;
            }
            else {
                $day_of = '';
            }

            $client_with_subcontractors_details = '';

            $new_record = $this->GetNewRecordTemplate();
            $new_record['day_of'] = $day_of;
            $new_record['total_hours'] = '';
            $new_record['time_in_ph'] = '';
            $new_record['time_out_ph'] = '';
            $new_record['time_in_au'] = '';
            $new_record['time_out_au'] = '';
            $new_record['client'] = '';
            $new_record['subcontractors_id'] = '';
            $new_record['working_hours'] = '';
            $new_record['start_lunch_ph'] = '';
            $new_record['start_lunch_au'] = '';
            $new_record['finish_lunch_ph'] = '';
            $new_record['finish_lunch_au'] = '';
            $new_record['total_lunch_hours'] = '';

            $new_record['blank'] = 'yes';
            $new_record['notes_day_of_week'] = $date->format('D d/m');
            $new_record['timerecord_notes'] = $this->GetRecordNotesOnBlankDays($date) . ' ' . $this->GetBroadcastRecordNotes($date);
            $new_record['record_id'] = $date->format('Y-m-d');
            $new_record['date'] = $date->format('Y-m-d');
            $new_record['day_of_notes'] = $date->format('D d/m');

            $this->formatted_record[] = $new_record;

        }


        //returns a list of string of start_lunch, finish_lunch
        function GetLunchHours($record) {
            list($start_lunch, $finish_lunch) = $this->GetLunchHoursRawTime($record);

            $start_lunch_ph = $this->FormatTimePH($start_lunch);
            $start_lunch_au = $this->FormatTimeAU($start_lunch);
            $finish_lunch_ph = $this->FormatTimePH($finish_lunch);
            $finish_lunch_au = $this->FormatTimeAU($finish_lunch);

            return array($start_lunch_ph, $finish_lunch_ph, $start_lunch_au, $finish_lunch_au);
        }

        //returns the raw time for lunch hours
        function GetLunchHoursRawTime($record) {
            $userid = $record['userid'];
            $time_in = $record['time_in'];
            $time_out = $record['time_out'];
            if ($time_out == null) {
                //$new_time_out = new DateTime($time_in);
                $new_time_out = new DateTime();
                $time_out = $new_time_out->format('Y-m-d 23:59:59');
                $query = "select time_in, time_out from timerecord where userid = $userid and mode='lunch_break' and time_in >= '$time_in' and (time_out <= '$time_out' or time_out is NULL) and time_in BETWEEN '$time_in' and '$time_out'";
            }
            else {
                $query = "select time_in, time_out from timerecord where userid = $userid and mode='lunch_break' and time_in >= '$time_in' and time_out <= '$time_out'";
            }
            $data = $this->dbh->query($query);

            //assumes only one hour lunch break
            $record = $data->fetch();
            $start_lunch = $record['time_in'];
            $finish_lunch = $record['time_out'];

            return array($start_lunch, $finish_lunch);
        }

        function GetTotalLunchSeconds($record) {
            $userid = $record['userid'];
            $time_in = $record['time_in'];
            $time_out = $record['time_out'];
            //no time_out yet, use the last hour of the time_in
            if ($time_out == null) {
                $new_time_out = new DateTime($time_in);
                $time_out = $new_time_out->format('Y-m-d 23:59:59');
            }
            $query = "select time_in, time_out from timerecord where userid = $userid and mode='lunch_break' and time_in >= '$time_in' and time_out <= '$time_out'";
            $data = $this->dbh->query($query);

            $total_seconds = 0;
            foreach ($data->fetchAll() as $row) {
                $start_date = new DateTime($row['time_in']);
                $end_date = new DateTime($row['time_out']);
                $total_seconds += $end_date->format('U') - $start_date->format('U');
            }
            return $total_seconds;
        }

        function GetTotalHours($record) {
            if ($record['time_out'] == null) {
                return '';
            }
            $time_start = new DateTime($record['time_in']);
            $time_end = new DateTime($record['time_out']);
            $total_lunch_seconds = $this->GetTotalLunchSeconds($record);
            $total_seconds = $time_end->format('U') - $time_start->format('U') - $total_lunch_seconds;
            $total_hours = $total_seconds / 60 / 60;
            return $total_hours;
        }

        function FormatTimeAU($time) {
            if ($time == null) {
                return '';
            }
            $time = new DateTime($time);
            $time->setTimeZone($this->tz_au);
            return $time->format('h:i a') . ' au';
        }

        function FormatTimePH($time) {
            if ($time == null) {
                return '';
            }
            $time = new DateTime($time);
            $time->setTimeZone($this->tz_ph);
            return $time->format('h:i a') . ' ph';
        }

        function GetClientWithSubcontracDetails($record) {
            $client_with_subcontractors_details = $record['lname'] . ', ' . $record['fname'] . ' | ' . $record['company_name'] . ' | ' . $record['subcontractors_id'];
            return $client_with_subcontractors_details;
        }

        function GetDayOf($record){
            $time_in = new DateTime($record['time_in']);
            return $time_in->format('D d/m');
        }

        function GetNewRecordTemplate() {
            return array('day_of' => '',
                'time_in_ph' => '',
                'time_out_ph' => '',
                'time_in_au' => '',
                'time_out_au' => '',
                'client' => '',
                'subcontractors_id' => '',
                'total_hours' => '',
                'working_hours' => '',
                'start_lunch_ph' => '',
                'start_lunch_au' => '',
                'finish_lunch_ph' => '',
                'finish_lunch_au' => '',
                'total_lunch_hours' => '',
                'blank' => 'no',
                'timerecord_notes' => null,
                'record_id' => null,
                'date' => null,
                'day_of_notes' => '',
                'time_in_default' => '',
                'time_out_default' => '',
                'start_lunch_default' => '',
                'finish_lunch_default' => '',
                'client_timezone' => ''
            );
        }

        function GetFormattedRecord() {
            return $this->formatted_record;
        }
    }

    /**
     *
     * Invoice Details creation
     *
     * @author		Lawrence Sunglao <locsunglao@yahoo.com>
     */
    class InvoiceDetails extends FormattedTimeRecord{
        /**
        *
        * Initialize
        *
        */
        function __construct($invoice_id) {
            parent::__construct();

            $this->invoice_id = $invoice_id;
            $this->item_id = 0; //increments upon adding records
            $this->total_amt = 0;
			$this->total_client_payment_amount = 0; //
			$this->total_days_work = 0;
			$this->client_daily_rate=0;
            $this->day_of = ""; //container to determine multiple records per day
			
        }


        /**
        *
        * Returns total amount
        *
        * @return	float	 Description
        */
        function GetTotalAmount() {
            return $this->total_amt;
			//return $this->total_client_payment_amount;
        }
		
		// Addedd by Norman
		function GetClientPaymentTotalAmount() {
            return $this->total_client_payment_amount;
        }
		
		function GetSubconDaysWork() {
            return $this->total_days_work;
        }
		
		function GetClientDailyRate(){
			return $this->client_daily_rate;
		}
		//
        function AddRecord($record) {
            $day_of = $this->GetDayOf($record);

            $client_name = $record['fname'] . ' ' . $record['lname'] . ' (' . $record['company_name'] . ')';
            $timerecord_id = $record['id'];

            //Grab official Total Hours from timerecord_adjustment table, other wise compute from $record
            $query = "select * from timerecord_adjustment where timerecord_id = $timerecord_id order by time_updated desc limit 1";
            $data = $this->dbh->query($query);
            $result = $data->fetch();

            if ($result == null) {
                $total_hours = $this->GetTotalHours($record);
            }
            else {
                $total_hours = $result['total_hrs'];
            }

            list($start_lunch_ph, $finish_lunch_ph, $start_lunch_au, $finish_lunch_au) = $this->GetLunchHours($record);
            $total_lunch_hours = $this->GetTotalLunchSeconds($record) / 60 / 60;

            $time_in_ph = $this->FormatTimeInvoice($record['time_in']);
            $time_out_ph = $this->FormatTimeInvoice($record['time_out']);
            $subcontractors_id = $record['subcontractors_id'];

            //get the hourly rate and and working hours , working days
            $query = "select php_hourly, client_price, working_hours, working_days, overtime from subcontractors where id = $subcontractors_id";
            $data = $this->dbh->query($query);
            $result = $data->fetch();
            $php_hourly_rate = $result['php_hourly'];
            $registered_working_hours = $result['working_hours'];
			$registered_working_days = $result['working_days'];
            $client_price = $result['client_price'];
            $overtime = $result['overtime'];
            
			/*
			Modified on Dec.1,2008
				- The working days and working hours must come to subcon's registered working days and working hours save from subcontractors table
				- Charge to Client is per day...
			*/
			
			$client_hourly_rate = (((($client_price*12)/52)/$registered_working_days)/$registered_working_hours);
			$client_daily_rate = ((($client_price*12)/52)/$registered_working_days);
			$this->client_daily_rate = $client_daily_rate;
			

            //insert to subcon_invoice_details
            $this->item_id += 1;
            $total_hours = number_format($total_hours, 2, '.', ',');

            //add a hash (#) on the description if its the same day
            if ($this->day_of == $day_of) {
                $description = "#";
            }
            else {
                $description = "";
            }
            $this->day_of = $day_of;

            $description .= "$day_of from $time_in_ph to $time_out_ph for $client_name with total hours of $total_hours @ $php_hourly_rate/hr.";

            if ($overtime == "Yes") {
                $amount = $php_hourly_rate * $total_hours;
                if ($total_hours > $registered_working_hours) { //add asterisk (*), description of extra hours worked and registered working hours
                    $overtime_hours = number_format(($total_hours - $registered_working_hours), 2, '.', '');
                    $description = "*$description | Extra hours worked : $overtime_hours | Registered working hours : $registered_working_hours |";
                }
            }
            else {
                if ($total_hours > $registered_working_hours) {
                    $amount = $php_hourly_rate * $registered_working_hours;
                    //$client_amount = $client_hourly_rate * $registered_working_hours;
                    //$client_amount =$client_daily_rate;
                }
                else {
                    $amount = $php_hourly_rate * $total_hours;
                    //$client_amount = $total_hours;
                }
            }
			
			/*
			 Added By Norman Dec.1,2008
			-	To determine the subcon working hours in a day if it is Wholeday, Halfday work...
			-   and also to determine what kind of payment will be charge to the subcon's Client
			*/
			if ($total_hours >= $registered_working_hours) // wholeday
			{ 
				//$client_amount = $client_daily_rate ;
				$day_work = 1;
			}
			elseif ($total_hours >=($registered_working_hours-1)) // wholeday
			{
				//$client_amount =$client_daily_rate ;
				$day_work = 1;
			}
			elseif ($total_hours >=($registered_working_hours - 2)) // wholeday
			{
				//$client_amount =$client_daily_rate ;
				$day_work = 1;
			}
			elseif ($total_hours >=($registered_working_hours/2) and $total_hours < ($registered_working_hours - 2)) // halfday
			{ 
				//$client_amount =($client_daily_rate * .50) ;
				$day_work = 0.5;
			}
			else
			{
				//$client_amount = $total_hours * $client_hourly_rate;
				$day_work = 0.5;
			}

			/*****/
			
            $amount = number_format($amount, 2, '.', '');
            $this->total_amt += $amount;
			//$this->total_client_payment_amount += $client_amount;
			$this->total_days_work += $day_work;
            $query = "insert into subcon_invoice_details (subcon_invoice_id, item_id, generated, description, subcontractors_id, amount, day_work) values ($this->invoice_id, $this->item_id, 'auto', '$description', '$subcontractors_id', '$amount' ,$day_work)";
            $this->dbh->exec($query);

        }

        /**
        *
        * Formats the time
        *
        * @return	string
        */
        function FormatTimeInvoice($time) {
            if (($time == null) or ($time == '')) {
                return '';
            }
            $time = new DateTime($time);
            $time->setTimeZone($this->tz_ph);
            return $time->format('h:i a');
        }
    }
?>
