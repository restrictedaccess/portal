<?php
//  2010-03-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack, JSON-RPC service for client
require('../conf/zend_smarty_conf.php');

class ClientTimeSheetForSubconService {
    function __construct() {
        $client_id = $_SESSION['client_id'];
        if ($client_id == "") {
            throw new Exception('Please Login');
        }
        $this->client_id = $client_id;
    }


    public function get_subcontractors() {
        global $db;
        //based on timesheet table, get all staff
        $sql = $db->select()
                ->distinct()
                ->from(array('t' => 'timesheet'), array('userid'))
                ->joinLeft(array('p' => 'personal'), 't.userid = p.userid', array('lname', 'fname'))
                ->where('t.leads_id = ?', $this->client_id)
                ->order(array('p.fname', 'p.lname'));
        return $db->fetchAll($sql);
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


    public function get_timesheet($userid, $date) {
        global $db;
        //get timesheet
        $sql = $db->select()
                ->from('timesheet', 'id')
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
            $day = new Zend_Date($date->toString('yyyy-MM-') . $detail['day'], 'YYYY-MM-dd');
            $end_day = clone $day;
            $end_day->add('24:00:00', Zend_Date::TIMES);

            //get time records, initialize some variables
            $time_in = array();
            $time_out = array();
            $total_hrs = 0;
            $lunch_in = array();
            $lunch_out = array();
            $total_lunch_hrs = 0;

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
                $time_in_tmp = new Zend_Date($timerecord['time_in'], 'YYYY-MM-dd HH:mm:ss');
                $time_in[] = $time_in_tmp->toString('MM/dd HH:mm');
                if ($timerecord['time_out'] != Null) {
                    $time_out_tmp = new Zend_Date($timerecord['time_out'], 'YYYY-MM-dd HH:mm:ss');
                    $time_out[] = $time_out_tmp->toString('MM/dd HH:mm');
                    $total_hrs_x = $time_out_tmp->toString("U") - $time_in_tmp->toString("U");
                    $total_hrs_x = $total_hrs_x / 3600;
                    $total_hrs += $total_hrs_x;

                }
                else {
                    $time_out[] = '';
                }

                if ($timerecord['time_out'] != Null) {
                    //get lunch records
                    $sql_lunch = $db->select()
                            ->from('timerecord')
                            ->where('userid = ?', $userid)
                            ->where('time_in >= ?', $time_in_tmp->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('time_in < ?', $time_out_tmp->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('mode = "lunch_break"')
                            ->where('leads_id = ?', $this->client_id);

                    foreach ($db->fetchAll($sql_lunch) as $timerecord_lunch){
                        $lunch_in_tmp = new Zend_Date($timerecord_lunch['time_in'], 'YYYY-MM-dd HH:mm:ss');
                        $lunch_in[] = $lunch_in_tmp->toString('MM/dd HH:mm');
                        if ($timerecord_lunch['time_out'] != Null) {
                            $lunch_out_tmp = new Zend_date($timerecord_lunch['time_out'], 'YYYY-MM-dd HH:mm:ss');
                            $lunch_out[] = $lunch_out_tmp->toString('MM/dd HH:mm');
                            $total_hrs_x = $lunch_out_tmp->toString("U") - $lunch_in_tmp->toString("U");
                            $total_hrs_x = $total_hrs_x / 3600;
                            $total_lunch_hrs += $total_hrs_x;
                            $total_hrs -= $total_lunch_hrs;
                        }
                        else {
                            $lunch_out[] = '';
                        }

                    }
                }

            }

            //get timesheet notes
            $notes = $this->GetTimeSheetNotes($detail['id']);

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

        return array('timesheet_details' => $data, 'timesheet_totals' => $totals, 'timesheet_status' => $status);
    }


    private function GetTimeSheetNotes($timesheet_detail_id) {
        global $db;
        $notes = array();
        //staff notes
        $sql = $db->select()
                ->from(array('t' => 'timesheet_notes_subcon'), array('id', 'timestamp', 'note'))
                ->join(array('p' => 'personal'), 't.userid = p.userid', array('fname', 'lname'))
                ->where('t.timesheet_details_id = ?', $timesheet_detail_id);
        $timesheet_notes_subcon = $db->fetchAll($sql);

        foreach ($timesheet_notes_subcon as $note) {
            $notes[] = array(
                'timestamp' => $note['timestamp'],
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
            $notes[] = array(
                'timestamp' => $note['timestamp'],
                'fname' => $note['admin_fname'],
                'lname' => $note['admin_lname'],
                'note' => $note['note']
            );
        }
        asort($notes);
        return $notes;
    }


}

$server = new Zend_Json_Server();
$server->setClass('ClientTimeSheetForSubconService');
$server->handle();
?>
