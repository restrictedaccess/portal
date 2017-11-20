<?php
//  2013-10-16  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   replaced this backend with django
//  2013-09-13  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   moved query to replication server
//  2011-01-10  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   bugfix on end date
//  2011-01-05  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
//  -   Integrate timezone settings
//  2010-12-20 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add Rating
//  2010-02-18 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack, JSON-RPC service
require('../conf/zend_smarty_conf.php');

class SubconActivityTrackerNotes {
    function __construct() {
        global $db_query_only;    
        throw new Exception('Please clear your browsers cache.');
        $userid = $_SESSION['userid'];
        if ($userid == "") {
            throw new Exception('Please Login');
        }
        $this->userid = $userid;

        //get staffs timezone
        $sql = $db_query_only->select()
                ->from(Array('t' => 'timezone_lookup'), 'timezone')
                ->join(Array('p' => 'personal'), 'p.timezone_id = t.id')
                ->where('p.userid = ?', $userid);
        $tz = $db_query_only->fetchOne($sql);
        if ($tz == Null) {
            $this->staff_tz = 'Asia/Manila';
        }
        else {
            $this->staff_tz = $tz;
        }

    }


    public function get_notes($start_date, $end_date) {
        global $db_query_only;

        date_default_timezone_set($this->staff_tz);
        $start_date = new Zend_Date($start_date, 'YYYY-MM-dd');
        $start_date->setTimezone('Asia/Manila');
        $end_date = new Zend_Date($end_date . ' 23:59:59', 'YYYY-MM-dd HH:mm:dd');
        $end_date->setTimezone('Asia/Manila');

        //get notes
        $sql = $db_query_only->select()
                    ->from(array('a' => 'activity_tracker_notes'), array('month_day' => "DATE_FORMAT(checked_in_time, '%b %D - %a')", 
                        'time' => "checked_in_time", 
                        'note' => 'note', 
                        'rate' => 'rate'))
                    ->joinLeft(array('l' => 'leads'), 
                        'a.leads_id = l.id', 
                        array('client_id' => 'id', 
                            'client_fname' => 'fname', 'client_lname' => 'lname'))
                    ->where('a.userid = ?', $this->userid)
                    ->where(sprintf("a.checked_in_time BETWEEN '%s' AND '%s'", $start_date->toString('yyyy-MM-dd HH:mm:dd'), $end_date->toString('yyyy-MM-dd HH:mm:dd')))
                    ->order('a.checked_in_time DESC');

        $notes = $db_query_only->fetchAll($sql);

        for ($i = 0; $i < count($notes); $i++) {
            date_default_timezone_set("Asia/Manila");
            $time = new Zend_Date($notes[$i]['time'], 'YYYY-MM-dd HH:mm:ss');
            $time->setTimezone($this->staff_tz);
            $notes[$i]['time'] = $time->toString('hh:mm a');
        }

        return array('notes' => $notes);
    }

}

$server = new Zend_Json_Server();
$server->setClass('SubconActivityTrackerNotes');
$server->handle();
?>
