<?php
//2009-08-17 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added time stamp
//2009-05-02 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// provides a list of time records given the date and userid

    require('../conf/zend_smarty_conf.php');

    $userid = $_GET['userid'];
    $date_param = $_GET['date'];
    $timerecord_id = $_GET['timerecord_id'];

    $date = new DateTime($date_param);

    $time_record_notes_final = array();

    //get broadcast notes
    $sql = $db->select()
        ->from(array('t' => 'timerecord_notes'))
        ->join(array('a' => 'admin'),
            't.posted_by_id = a.admin_id',
            array('admin_fname'))
        ->where("t.reference_date = ?", $date->format('Y-m-d'))
        ->where("t.note_type = 'broadcast'");

    foreach ($db->fetchAll($sql) as $timerecord_note) {
        $time_record_notes_final[] = array(
            'name' => $timerecord_note['admin_fname'], 
            'note' => $timerecord_note['note'], 
            'time_stamp' => $timerecord_note['time_stamp']
        );
    }

    //get unique notes
    if ($timerecord_id == '') {
        $sql = $db->select()
            ->from('timerecord_notes')
            ->where("reference_date = ?", $date->format('Y-m-d'))
            //->where('timerecord_id = ?', $timerecord_id)
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
            $time_record_notes_final[] = array(
                'name' => $name, 
                'note' => $timerecord_note['note'],
                'time_stamp' => $timerecord_note['time_stamp']
            );
        }
    }

    $sql = $db->select()
        ->from('timerecord_notes')
        //->where("reference_date = ?", $date->format('Y-m-d'))
        ->where('timerecord_id = ?', $timerecord_id)
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
        $time_record_notes_final[] = array(
            'name' => $name, 
            'note' => $timerecord_note['note'],
            'time_stamp' => $timerecord_note['time_stamp']
        );
    }


    $smarty = new Smarty();
    $smarty->assign('time_record_notes_final', $time_record_notes_final);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_get_timerecord_notes.tpl');
?>
