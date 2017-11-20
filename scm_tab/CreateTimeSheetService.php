<?php
//  2013-09-18 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bug fix due to php upgrade
//  2013-02-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bug fix for missing staff on creation of timesheets
//  2013-01-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   wf 3458, considered subcontractors_scheduled_close_cotract.scheduled_date from creation of ts
//  2013-01-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed checking on flexi and based the hours on mon_number_hrs, tue_number_hrs instead
//  2012-03-21 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   considered checking subcontractors_id upon generation for prepaid
//  2011-12-08 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   considered end_date rather than resignation_date
//  2011-07-07 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   considered contracts that are flexi
//  2011-07-04 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   ignored end_date as per anne/norman
//  2011-04-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updates on new subcontractor system
//  2011-03-02 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   prevent creating of duplicate timesheet with the same month_year/userid/leads_id and status='open'
//  2011-01-07 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add default timezone on timesheet creation
//  2010-01-31 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   compute diff charge to client upon creation of timesheet
//  2009-12-28 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix for 'YYYY' toString format
//  -   hrs_charged_to_client set to regular_rostered as per regs
//  2009-12-02 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Bugfix January next year shows as 2009
//  2009-09-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack, JSON-RPC service
//  2009-10-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Perform a cross check on subcontractor table for generating regular rostered hours

require('../conf/zend_smarty_conf.php');
define('OLD_TIMESHEET_TZ', 'Asia/Manila');
define('HOURS_PER_DAY_PART_TIME', 4);
define('HOURS_PER_DAY_FULL_TIME', 8);

class CreateTimeSheet {
    function __construct() {
        $admin_id = $_SESSION['admin_id'];
        $admin_status = $_SESSION['status'];
        if ($admin_id == "") {
            $response = new Zend_Json_Server_Error();
            $response->setMessage("Please Login");
            $response->setData("Session not found!");
            throw new Exception($response);
            return $response;
        }
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

    public function get_distinct_status() {
        global $db;
        $sql = $db->select()
            ->from('subcontractors', "DISTINCT(status)");
        return $db->fetchCol($sql);
    }

    public function get_blank_time_sheet ($date, $status) {
        global $db;
        $timesheet_date = new Zend_Date($date, 'YYYY-MM-dd');

        //get records from subcontractors table
        $sql = $db->select()
            ->from(array('s' => 'subcontractors'), array('id', 'leads_id', 'agent_id', 'userid', 'status'))
            ->join(array('l' => 'leads'), 's.leads_id = l.id', array('client_lname' => 'lname', 'client_fname' => 'fname'))
            ->join(array('p' => 'personal'), 's.userid = p.userid', array('staff_lname' => 'lname', 'staff_fname' => 'fname'));
        if ($status != "ALL") {
            $sql->where('s.status = ?', $status);
        }
        $subcon_records = $db->fetchAll($sql);

        //get records from timesheet table
        $sql = $db->select()
            ->from('timesheet', array('subcontractors_id'))
            ->where('month_year = ?', $timesheet_date->toString("yyyy-MM-dd 00:00:00"))
            ->where('status in ("open", "locked")');
        $timesheet_records = $db->fetchCol($sql);

        //remove records that already exists
        $blank_time_sheets = array();
        foreach ($subcon_records as $subcon_record) {
            if (in_array($subcon_record['id'], $timesheet_records) == false) {
                $staff = $subcon_record['staff_fname'] . " " . $subcon_record['staff_lname'];
                $client = $subcon_record['client_fname'] . " " . $subcon_record['client_lname'];
                $x_record = array(
                    'staff' => ucwords(strtolower($staff)), 
                    'client' => ucwords(strtolower($client)), 
                    'userid' => $subcon_record['userid'],
                    'leads_id' => $subcon_record['leads_id'],
                    'subcontractors_id' => $subcon_record['id'],
                    'status' => $subcon_record['status']
                );
                $blank_time_sheets[] = $x_record;
            } 
        }
        sort($blank_time_sheets);
        return $blank_time_sheets;
    }

    public function create_time_sheet ($time_sheet_date_str, $userid, $leads_id, $subcontractors_id) {
//        global $db;
        global $db, $logger;
        $time_sheet_date = new Zend_Date($time_sheet_date_str, 'YYYY-MM-dd');
        $date_today = new Zend_Date();
        $admin_id = $_SESSION['admin_id'];

        //check if timesheet already exists
        $sql = $db->select()
                ->from('timesheet')
                ->where('userid = ?', $userid)
                ->where('month_year = ?', $time_sheet_date->toString("yyyy-MM-dd 00:00:00"))
                ->where('leads_id = ?', $leads_id)
                ->where('subcontractors_id = ?', $subcontractors_id)
                ->where('status = "open"');
        if (count($db->fetchAll($sql)) > 0) {
            return "Timesheet already created."; 
        }

        //get clients timezone
        $sql = $db->select()
                ->from('leads', 'timezone_id')
                ->where('id = ?', $leads_id);
        $timezone_id = $db->fetchOne($sql);

        //no timezone found on clients id, assign default
        if ($timezone_id == Null) {
            //defaults to OLD_TIMESHEET_TZ
            $sql = $db->select()
                    ->from('timezone_lookup', 'id')
                    ->where('timezone = ?', OLD_TIMESHEET_TZ);
            $timezone_id = $db->fetchOne($sql);
        }

        //insert record on timesheet table
        $data = array(
            'month_year' => $time_sheet_date_str,
            'userid' => $userid,
            'leads_id' => $leads_id,
            'subcontractors_id' => $subcontractors_id,
            'generated_by_id' => $admin_id,
            'date_generated' => $date_today->toString("yyyy-MM-dd HH:mm:ss"),
            'timezone_id' => $timezone_id
        );		
        $db->insert('timesheet', $data);

        //create records for timesheet_details table
        $timesheet_id = $db->lastInsertId();
        $number_of_days = $time_sheet_date->get(Zend_Date::MONTH_DAYS);

        //get subcontractors details
        $sql = $db->select()
            ->from('subcontractors')
            ->where('id = ?', $subcontractors_id);
        $subcontractors_details = $db->fetchRow($sql);

        //check if contract is scheduled for termination
        $sql = $db->select()
            ->from('subcontractors_scheduled_close_cotract', 'scheduled_date')
            ->where('status = "waiting"')
            ->where('subcontractors_id = ?', $subcontractors_id);
        $scheduled_termination = $db->fetchOne($sql);

        for ($i = 1; $i <= $number_of_days; $i++) {
            $x_date = new Zend_Date($time_sheet_date->toString("yyyy-MM-").$i, 'YYYY-MM-dd');
            $regular_rostered_hrs = 0;
            switch ($x_date->toString('EEE')) {
                case 'Mon':
                    $regular_rostered_hrs = $subcontractors_details['mon_number_hrs'];
                    break;
                case 'Tue':
                    $regular_rostered_hrs = $subcontractors_details['tue_number_hrs'];
                    break;
                case 'Wed':
                    $regular_rostered_hrs = $subcontractors_details['wed_number_hrs'];
                    break;
                case 'Thu':
                    $regular_rostered_hrs = $subcontractors_details['thu_number_hrs'];
                    break;
                case 'Fri':
                    $regular_rostered_hrs = $subcontractors_details['fri_number_hrs'];
                    break;
                case 'Sat':
                    $regular_rostered_hrs = $subcontractors_details['sat_number_hrs'];
                    break;
                case 'Sun':
                    $regular_rostered_hrs = $subcontractors_details['sun_number_hrs'];
                    break;
                default:
                    $regular_rostered_hrs = 0;
                    break;
            }

            #cross check from subcontractor table about starting_date and end_date
            $starting_date = $subcontractors_details['starting_date'];
            $end_date = $subcontractors_details['end_date'];

            if ($starting_date != '') {
                $z_starting_date = new Zend_Date($starting_date, 'YYYY-MM-dd');
                if ($x_date->isEarlier($z_starting_date)) {
                    $regular_rostered_hrs = 0;
                }
            }

            if ($scheduled_termination != Null) {
                if ($x_date->isLater($scheduled_termination)) {
                    $regular_rostered_hrs = 0;
                }
            }

            //if ($end_date != '') {
            //    $z_end_date = new Zend_Date($end_date, 'YYYY-MM-dd');
            //    if ($x_date->isLater($z_end_date)) {
            //        $regular_rostered_hrs = 0;
            //    }
            //}

            $hrs_charged_to_client = $regular_rostered_hrs;         //request for the hrs_charged_to_client = regular_rostered_hrs
            $adj_hrs = 0;    //adj hrs on creation is zero
            $diff_charged_to_client = $adj_hrs - $hrs_charged_to_client;
			
			$reference_date = date("Y-m", strtotime($time_sheet_date_str));
			$reference_date = $reference_date."-".$i;
			$reference_date = date("Y-m-d", strtotime($reference_date));
			
			
            $data = array(
                'timesheet_id' => $timesheet_id,
                'day' => $i,
                'regular_rostered' => $regular_rostered_hrs,
                'hrs_charged_to_client' => $hrs_charged_to_client,
                'diff_charged_to_client' => $diff_charged_to_client,
                'reference_date' => $reference_date,
                'status' => 'locked'
            );
			//echo "<pre>";
			//print_r($data);
			//echo "</pre>";
			//exit;
            $db->insert('timesheet_details', $data);
        }
        return "Succesfully created timesheets.";
    }

}

$server = new Zend_Json_Server();
$server->setClass('CreateTimeSheet');
$server->handle();
?>
