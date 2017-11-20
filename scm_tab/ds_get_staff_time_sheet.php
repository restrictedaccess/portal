<?php
//2009-09-14 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Remove Automatic insertion of adjusted time sheet
//2009-08-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add status for admin who could force a logout
//2009-05-15 Lawrence Sunglao <locsunglao@yahoo.com>
//  -   Add status for admin who could update time sheets
//2009-05-13 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Remove clip on total hours base on subcontractors->overtime field
//2009-04-24 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// provides a list of time records given the date and userid

    require('../conf/zend_smarty_conf.php');
    require('ds_validate_admin.php');

    $userid = $_GET['userid'];
    $date_param = $_GET['date_param'];
    if ($date_param == "Current Month") {
        $date_param = "";
    }

    $date_time_ref = new DateTime($date_param);

    //check for adjust_time_sheet
    $sql = $db->select()
        ->from('admin', 'adjust_time_sheet')
        ->where('admin_id = ?', $admin_id);
    $adjust_time_sheet = $db->fetchOne($sql);

    //check for force_logout permission
    $sql = $db->select()
        ->from('admin', 'force_logout')
        ->where('admin_id = ?', $admin_id);
    $force_logout = $db->fetchOne($sql);

    //compare dates, get number of days
    $now = new DateTime();
    $date_time_ref_str = $date_time_ref->format("Y-m-01");
    $now_str = $now->format("Y-m-01");
    if ($now_str == $date_time_ref_str) { //current month just output the current day until the first
        $number_of_days = $now->format("d");
    }
    else {
        $number_of_days = $date_time_ref->format("t");
    }

    $time_records_final = array();    //initialize

    $year = $date_time_ref->format("y");
    $month = $date_time_ref->format("m");

    for ($i=$number_of_days; $i>=1; $i--) {
        $date_time_start = new DateTime($year . '-' . $month . '-' . $i . ' 00:00:00');
        $date_time_end = new DateTime($year . '-' . $month . '-' . $i . ' 23:59:59');
        $date_time_start_str = $date_time_start->format("Y-m-d H:i:s");
        $date_time_end_str = $date_time_end->format("Y-m-d H:i:s");

        //compose sql for grabbing the time records
        $sql = $db->select()
            ->from(array('t' => 'timerecord'),
                ("t.*, TIMEDIFF(t.time_out, t.time_in) as tdiff"))
            ->join(array('l' => 'leads'),
                't.leads_id = l.id',
                array('lname', 'fname', 'company_name'))
            ->where("t.userid = ?", $userid)
            ->where("t.time_in >= ?", $date_time_start_str)
            ->where("t.time_in <= ?", $date_time_end_str)
            ->where("t.mode = 'regular'")
            ->order('t.time_in desc');

        $time_records = $db->fetchAll($sql);

        if (count($time_records) == 0) {    //just add a day
            $notes = GetNotes($date_time_start);
            $time_record = array('day_of_week' => $date_time_start_str, 'notes' => $notes);
            $time_records_final[] = $time_record;
            continue;
        }

        //loop on each time_record
        foreach ($time_records as $time_record) {

            $notes = GetNotes($date_time_start);
            $notes .= GetNotesWithRecordId($time_record['id']);

            $time_record['notes'] = $notes;

            //continue loop if no time_out
            if ($time_record['time_out'] == "") {
                $time_record['day_of_week'] = $date_time_start_str;
                $time_records_final[] = $time_record;
                continue;
            }

            //get total seconds
            $time_in = new DateTime($time_record['time_in']);
            $time_out = new DateTime($time_record['time_out']);
            $total_seconds = $time_out->format("U") - $time_in->format("U");

            //sql for lunch records
            $sql = $db->select()
                ->from('timerecord', "*, TIMEDIFF(time_out, time_in) as ltdiff")
                ->where("userid = ?", $userid)
                ->where("time_in >= ?", $time_record['time_in'])
                ->where("time_in <= ?", $time_record['time_out'])
                ->where("mode = 'lunch_break'")
                ->order('time_in desc');

            $lunch_time_records = $db->fetchAll($sql);

            //subtract lunch hours
            foreach($lunch_time_records as $lunch_time_record) {
                $lunch_time_start = new DateTime($lunch_time_record['time_in']);
                $lunch_time_end = new DateTime($lunch_time_record['time_out']);
                $total_lunch_time_seconds = $lunch_time_end->format("U") - $lunch_time_start->format("U");
                $total_seconds -= $total_lunch_time_seconds;

                //add to array
                $time_record['total_lunch_hrs'] = sprintf("%0.2f", SecondsToFloatHours($total_lunch_time_seconds));
                $time_record['time_in_lunch'] = $lunch_time_start->format("Y-m-d H:i:s");
                $time_record['time_out_lunch'] = $lunch_time_end->format("Y-m-d H:i:s");
            }

            $time_record['day_of_week'] = $date_time_start_str;
            $time_record['computed_total_hrs'] = sprintf("%0.2f", SecondsToFloatHours($total_seconds));

            //get working_hours from subcontractors table
            $sql = $db->select()
                ->from("subcontractors", 'working_hours')
                ->where("id = ?", $time_record['subcontractors_id']);
            $working_hours = $db->fetchOne($sql);

            $time_record['regular_hrs'] = sprintf("%0.2f", $working_hours);;

            //search if record already exist on timerecord_adjustment table
            $sql = $db->select()
                ->from('timerecord_adjustment', 'total_hrs')
                ->where("timerecord_id = ?", $time_record['id'])
                ->order('time_updated desc')
                ->limit('1');

            $total_hrs = $db->fetchOne($sql);

            if ($total_hrs == null) {
                $time_record['adjusted_total_hrs'] = sprintf("%0.2f", 0);
            }
            else {
                $time_record['adjusted_total_hrs'] = sprintf("%0.2f", $total_hrs);
            }

            $time_records_final[] = $time_record;
        }
    }

    /**
    *
    * Converts integer seconds to float hours
    *
    * @return	integer	 Description
    */
    function SecondsToFloatHours($seconds){
        $hours = floor($seconds / 3600);
        $remaining_seconds = floor($seconds - ($hours * 3600));
        $decimal_hours = number_format($remaining_seconds / 3600, 2);
        return $hours + $decimal_hours;
    }


    /**
    *
    * Returns a string of notes given the date
    *
    * @return	string	
    * @access	public
    * @see		??
    */
    function GetNotes($date) {
        global $db, $userid;

        $notes = '';

        //get broadcast notes
        $sql = $db->select()
            ->from(array('t' => 'timerecord_notes'))
            ->join(array('a' => 'admin'),
                't.posted_by_id = a.admin_id',
                array('admin_fname'))
            ->where("t.reference_date = ?", $date->format('Y-m-d'))
            ->where("t.note_type = 'broadcast'");
        
        foreach ($db->fetchAll($sql) as $timerecord_note) {
            $notes .= sprintf("%s:%s ", $timerecord_note['admin_fname'], $timerecord_note['note']);
        }

        //get unique notes
        $sql = $db->select()
            ->from('timerecord_notes')
            ->where("reference_date = ?", $date->format('Y-m-d'))
            ->where("note_type = 'unique'")
            ->where("userid = ?", $userid);
    
        $timerecord_notes = $db->fetchAll($sql);

        foreach ($timerecord_notes as $timerecord_note) {
            if ($timerecord_note['posted_by_type'] == 'admin') {
                //get admin name
                $sql = $db->select()
                    ->from('admin', "admin_fname")
                    ->where('admin_id = ?', $timerecord_note['posted_by_id']);
            }
            else {
                //get the staff name
                $sql = $db->select()
                    ->from('personal', "fname")
                    ->where('userid = ?', $timerecord_note['posted_by_id']);
            }
            $name = $db->fetchOne($sql);
            $notes .= sprintf("%s:%s ", $name, $timerecord_note['note']);
        }

        return $notes;
    }

    function GetNotesWithRecordId($record_id) {
        global $db, $userid;

        //get notes for the time_record
        $sql = $db->select()
            ->from('timerecord_notes')
            ->where('timerecord_id = ?', $record_id)
            ->where('note_type = "unique"');
        
        $time_record_notes = $db->fetchAll($sql);

        $notes = '';
        foreach ($time_record_notes as $timerecord_note) {
            if ($timerecord_note['posted_by_type'] == 'admin') {
                //get admin name
                $sql = $db->select()
                    ->from('admin', "admin_fname")
                    ->where('admin_id = ?', $timerecord_note['posted_by_id']);
            }
            else {
                //get the staff name
                $sql = $db->select()
                    ->from('personal', "fname")
                    ->where('userid = ?', $timerecord_note['posted_by_id']);
            }
            $name = $db->fetchOne($sql);
            $notes .= sprintf("%s:%s ", $name, $timerecord_note['note']);
        }

        return $notes;
    }

    $smarty = new Smarty();
    $smarty->assign('time_records_final', $time_records_final);
    $smarty->assign('adjust_time_sheet', $adjust_time_sheet);
    $smarty->assign('force_logout', $force_logout);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_get_staff_time_sheet.tpl');
?>
