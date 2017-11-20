<?php
//  2010-04-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   executed with cronjob
//  -   fix the staffs starting_hours/ending hours daily

require_once('../conf/zend_smarty_conf.php');

//check if all client is on tb_client_account_settings 
$sql = $db->select()
            ->from('subcontractors', array('id', 'userid', 'client_timezone', 'client_start_work_hour', 'client_finish_work_hour'))
            ->where("status = 'ACTIVE'");
$active_contracts = $db->fetchAll($sql);

foreach ($active_contracts as $active_contract) {
    if ($active_contract['client_start_work_hour'] == Null) {
        continue;
    }
    if ($active_contract['client_start_work_hour'] == '') {
        continue;
    }
    if ($active_contract['client_finish_work_hour'] == Null) {
        continue;
    }
    if ($active_contract['client_finish_work_hour'] == '') {
        continue;
    }
    if ($active_contract['client_timezone'] == Null) {
        continue;
    }
    if ($active_contract['client_timezone'] == '') {
        continue;
    }

    date_default_timezone_set($active_contract['client_timezone']);
    $id = $active_contract['id'];
    $now = new Zend_Date();
    $start_work = clone $now;
    $finish_work = clone $now;
    $start_work->set($active_contract['client_start_work_hour'], Zend_Date::TIMES);
    $finish_work->set($active_contract['client_finish_work_hour'], Zend_Date::TIMES);
    $start_work->setTimezone("Asia/Manila");
    $finish_work->setTimezone("Asia/Manila");

    $data = array (
        'starting_hours' => $start_work->toString('HH:mm'),
        'ending_hours' => $finish_work->toString('HH:mm')
    );

    //update the subcontractors table
    $db->update('subcontractors', $data, "id = $id");

}
?>
