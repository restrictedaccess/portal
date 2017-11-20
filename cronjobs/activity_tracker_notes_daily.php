<?php
//  2013-09-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updated so that suspended clients wont be removed from tb_client_account_settings
//  2010-04-06 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   executed with cronjob
//  -   remove clients on the list when no active record on subcontractors is present
//  -   add clients if no record on tb_client_account_settings

define('DEFAULT_CLIENT_TIMEZONE', 'Australia/Sydney');  
define('DEFAULT_HOUR', 20);
define('DEFAULT_MINUTE', 0);
require_once('../conf/zend_smarty_conf.php');


/*
remove clients without active subcontractors
*/
//get the distinct leads_id from the subcontractors table
$sql = $db->select()
        ->distinct()
        ->from('subcontractors', array('leads_id' => 'leads_id'))
        ->where('status IN ("ACTIVE", "suspended")');

$active_leads = $db->fetchAll($sql);

//get the distinct leads_id from the tb_client_account_settings
$sql = $db->select()
        ->distinct()
        ->from('tb_client_account_settings', array('leads_id' => 'client_id'));
$leads_on_activity_notes = $db->fetchAll($sql);

//iterate on the array
$leads_to_be_deleted = array();
foreach ($leads_on_activity_notes as $leads_id) {
    if (in_array($leads_id, $active_leads) == False) {
        $leads_to_be_deleted[] = $leads_id['leads_id'];
    }
}

//delete record from the tb_client_account_settings table
foreach($leads_to_be_deleted as $leads_id) {
    $db->delete('tb_client_account_settings', "client_id = $leads_id");
}


/*
add clients
*/
//check if all client is on tb_client_account_settings 
$sql = $db->select()
            ->distinct()
            ->from(array('s' => 'subcontractors'), array('leads_id' => 'leads_id'))
            ->joinLeft(array('c' => 'tb_client_account_settings'), 's.leads_id = c.client_id', NULL)
            ->where("s.status = 'ACTIVE'")
            ->where('c.id is NULL');
$leads = $db->fetchAll($sql);

$now = new Zend_Date();
$now->setTimezone(DEFAULT_CLIENT_TIMEZONE);
$now->set(sprintf("%02d:%02d:00", DEFAULT_HOUR, DEFAULT_MINUTE), Zend_Date::TIMES);
$now->setTimezone('Asia/Manila');   //timezone used by the cronjob

//insert default record for tb_client_account_settings
foreach($leads as $lead) {
    $data = array(
        'client_id' => $lead['leads_id'],
        'type' => 'ACTIVITY NOTES',
        'hour' => DEFAULT_HOUR,
        'minute' => DEFAULT_MINUTE,
        'client_timezone' => DEFAULT_CLIENT_TIMEZONE,
        'send_time' => $now->toString('HH:mm'),
        'status' => 'ALL'
    );
    try {
        $db->insert('tb_client_account_settings', $data);
    }
    catch (Exception $e) {
        echo sprintf("Caught Exception (%s)</br>%s</br>%s</br>", $e->getMessage(), $e, $lead['leads_id']);
    }
}
?>
