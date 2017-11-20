<?php
//  2011-09-19 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   added status, stored the report to couch instead of sending it directly
//  2011-02-23 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed rating column
//  -   bugfix on timeout displaying even if the staff is still working
//  2010-12-30 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   attached the images on the email
//  2010-05-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   bugfix on query using NOW()
//  2010-05-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed devs on bcc
//  2010-04-15 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed MINUTES = 280 on test
//  2010-04-14 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   use the new email/cc field on tb_client_account_settings table
//  2010-04-06 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   moved the addition of records to the activity_tracker_notes_daily.php cronjob
//  2010-03-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   adding exception to prevent lead_id with no lead reference
//  2010-03-09 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   used the config settings
//  2010-02-08 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add logic on weekends, if no time_records, dont send an email
//  2010-02-08 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   changed the date format
//  -   add date/time to the subject of the email 
//  2010-01-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add notes that are on a per country/city basis
//  -   add default records on tb_client_account_settings if client doesnt exist yet
//  2010-01-13 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix lunch record bug
//  2010-01-06 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add admin notes
//  2009-12-29 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   rounded up to the nearest minute
//  2009-12-21 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   executed with cronjob

define('DEFAULT_CLIENT_TIMEZONE', 'Australia/Sydney');  
require_once('../conf/zend_smarty_conf.php');
require('../lib/validEmail.php');

define('MINUTES', 9); 


$now = new Zend_Date();
$after = clone($now);
$after->add(MINUTES, Zend_Date::MINUTE);
$sql = $db->select()
            ->from('tb_client_account_settings')
            ->where("status = 'ALL'")
            ->where(sprintf("send_time BETWEEN '%s' and '%s'", $now->toString("HH:mm"), $after->toString("HH:mm")));


$data = $db->fetchAll($sql);


//loop over the result and create a document email
foreach ($data as $client_account_settings) {
    $leads_id = $client_account_settings['client_id'];
    $client_timezone = $client_account_settings['client_timezone'];
    if ($client_timezone == '') {
        $client_timezone = DEFAULT_CLIENT_TIMEZONE;
    }

    $clients_current_date = new Zend_Date();
    $clients_current_date->setTimezone($client_timezone);

    $start_date = new Zend_Date(sprintf("%s %s", $now->toString("yyyy-MM-dd"), $client_account_settings['send_time']), 'YYYY-MM-dd HH:mm:ss');
    $end_date = clone($start_date);
    $start_date->add('-1', Zend_Date::DAY);

    //grab all clients subcontractors from the subcontractors table
    $sql = $db->select()
                ->from(array('s' => 'subcontractors'), array('id' => 'id', 'userid' => 'userid'))
                ->join(array('p' => 'personal'), 's.userid = p.userid', array('fname' => 'fname', 'lname' => 'lname'))
                ->where("s.status = 'ACTIVE'")
                ->where('s.leads_id = ?', $leads_id)
                ->order(array('p.fname', 'p.lname'));
    $subcontractors = $db->fetchAll($sql);

    //initialize time_records_count for weekend logic
    $time_records_count = 0;

    //loop over subcontractors and get their activity_tracker_notes and time in/out lunch in/out 
    //and notes from tb_admin_activity_tracker_notes table
    for ($i = 0; $i < count($subcontractors); $i++) {
        $sql = $db->select()
                    ->from('activity_tracker_notes')
                    ->where('leads_id = ?', $leads_id)
                    ->where('userid = ?', $subcontractors[$i]['userid'])
                    ->where('checked_in_time >= ?', $start_date->toString('yyyy-MM-dd HH:mm:ss'))
                    ->where('checked_in_time < ?', $end_date->toString('yyyy-MM-dd HH:mm:ss'))
                    ->order('checked_in_time');
        $activity_tracker_notes = $db->fetchAll($sql);

        $checked_in_date = '';
        //change time zone
        for ($j = 0; $j < count($activity_tracker_notes); $j++) {
            $checked_in_time = new Zend_Date($activity_tracker_notes[$j]['checked_in_time'], 'YYYY-MM-dd HH:mm:ss');
            $checked_in_time->setTimezone($client_timezone);
            $activity_tracker_notes[$j]['checked_in_time'] = $checked_in_time->toString('hh:mm a');
            //separator for the date to change or blank if the same as previous
            if ($checked_in_date != $checked_in_time->toString('MMM dd')) {
                $checked_in_date = $checked_in_time->toString('MMM dd');
                $activity_tracker_notes[$j]['checked_in_date'] = $checked_in_date;
            }
            else {
                $activity_tracker_notes[$j]['checked_in_date'] = '';
            }
        }
        
        //assign it to the variable for smarty consumption
        $subcontractors[$i]['activity_tracker_notes'] = $activity_tracker_notes;

        //grab notes from tb_admin_activity_tracker_notes
        $sql = $db->select()
                    ->from('tb_admin_activity_tracker_notes')
                    ->where('client_id = ?', $leads_id)
                    ->where('subcon_id = ?', $subcontractors[$i]['userid'])
                    ->where('method = "PER STAFF"')
                    ->where('status = "ACTIVE"')
                    ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                    ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));

        $admin_notes_per_staff = $db->fetchAll($sql);
        if (count($admin_notes_per_staff) != 0) {
            $subcontractors[$i]['admin_notes_per_staff'] = $admin_notes_per_staff;
        }

        //get time in/out lunch in/out
        $sql = $db->select()
                    ->from('timerecord')
                    ->where(sprintf('time_in BETWEEN "%s" AND "%s"', $start_date->toString('yyyy-MM-dd HH:mm:ss'), $end_date->toString('yyyy-MM-dd HH:mm:ss')))
                    ->where('mode = "regular"')
                    ->where('leads_id = ?', $leads_id)
                    ->where('userid = ?', $subcontractors[$i]['userid']);
        $time_records = $db->fetchAll($sql);

        $time_records_count += count($time_records);

        //insert lunch record
        for ($j = 0; $j < count($time_records); $j++) {
            if ($time_records[$j]['time_out'] == null) {
                $sql = $db->select()
                        ->from('timerecord')
                        ->where(sprintf('time_in BETWEEN "%s" AND "%s"', $time_records[$j]['time_in'], $now->toString("yyyy-MM-dd HH:mm:ss")))
                        ->where('mode = "lunch_break"')
                        ->where('leads_id = ?', $leads_id)
                        ->where('userid = ?', $subcontractors[$i]['userid']);
            }
            else {
                $sql = $db->select()
                        ->from('timerecord')
                        ->where(sprintf('time_in BETWEEN "%s" AND "%s"', $time_records[$j]['time_in'], $time_records[$j]['time_out']))
                        ->where('mode = "lunch_break"')
                        ->where('leads_id = ?', $leads_id)
                        ->where('userid = ?', $subcontractors[$i]['userid']);
            }
            $lunch_records = $db->fetchRow($sql);   //only one lunch record per time in/out

            if($lunch_records) {
                $time_records[$j]['lunch_start'] = $lunch_records['time_in'];
                $time_records[$j]['lunch_fin'] = $lunch_records['time_out'];
            }
            else {
                $time_records[$j]['lunch_start'] = False;
                $time_records[$j]['lunch_fin'] = False;
            }
        }


        //loop over time_records and change it to clients time zone
        for ($j = 0; $j < count($time_records); $j++) {
            $time_in = new Zend_Date($time_records[$j]['time_in'], 'YYYY-MM-dd HH:mm:ss');
            $time_out = $time_records[$j]['time_out'];
            if ($time_out) {
                $time_out = new Zend_Date($time_records[$j]['time_out'], 'YYYY-MM-dd HH:mm:ss');
            }
            if ($time_records[$j]['lunch_start']) {
                $lunch_start = new Zend_Date($time_records[$j]['lunch_start'], 'YYYY-MM-dd HH:mm:ss');
            }
            if ($time_records[$j]['lunch_fin']) {
                $lunch_fin = new Zend_Date($time_records[$j]['lunch_fin'], 'YYYY-MM-dd HH:mm:ss');
            }

            $time_in->setTimezone($client_timezone);
            if ($time_out) {
                $time_out->setTimezone($client_timezone);
            }
            if ($time_records[$j]['lunch_start']) {
                $lunch_start->setTimezone($client_timezone);
            }
            if ($time_records[$j]['lunch_fin']) {
                $lunch_fin->setTimezone($client_timezone);
            }

            //asign it back
            $time_records[$j]['time_in'] = $time_in->toString('MM/dd hh:mm a');
            if ($time_out) {
                $time_records[$j]['time_out'] = $time_out->toString('MM/dd hh:mm a');
            }
            if ($time_records[$j]['lunch_start']) {
                $time_records[$j]['lunch_start'] = $lunch_start->toString('MM/dd hh:mm a');
            }
            if ($time_records[$j]['lunch_fin']) {
                $time_records[$j]['lunch_fin'] = $lunch_fin->toString('MM/dd hh:mm a');
            }
        }

        $subcontractors[$i]['time_records'] = $time_records;
    }


    //time_records_count dont send any emails
    if ($time_records_count == 0) {
        continue;
    }

    //get admin notes that are method='ALL'
    $sql = $db->select()
                ->from('tb_admin_activity_tracker_notes')
                ->where('method = "ALL"')
                ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));
    $admin_notes_all = $db->fetchAll($sql);

    //get admin notes that are method='PER CLIENT'
    $sql = $db->select()
                ->from('tb_admin_activity_tracker_notes')
                ->where('client_id = ?', $leads_id)
                ->where('method = "PER CLIENT"')
                ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));
    $admin_notes_per_client = $db->fetchAll($sql);

    //get admin notes that are method='PER COUNTRY CITY'
    $sql = $db->select()
                ->from('tb_admin_activity_tracker_notes')
                ->where('method = "PER COUNTRY CITY"')
                ->where('country_city = ?', $client_timezone)
                ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));
    $admin_notes_per_country_city = $db->fetchAll($sql);


    //validate email address
    $client_email = trim($client_account_settings['email']);
    if (validEmail($client_email) == False) {   //email not valid, use the clients login email
        $sql = $db->select()    
                    ->from('leads', array('email'))
                    ->where('id = ?', $leads_id);
        $client_email = $db->fetchOne($sql);
    }

    $client_email_cc = trim($client_account_settings['cc']);

    //create a smarty object
    $smarty = New Smarty();
    $smarty->register_modifier('ss', 'stripslashes');
    $smarty->assign('admin_notes_all', $admin_notes_all);
    $smarty->assign('admin_notes_per_client', $admin_notes_per_client);
    $smarty->assign('admin_notes_per_country_city', $admin_notes_per_country_city);
    $smarty->assign('client_timezone', $client_timezone);
    $smarty->assign('subcontractors', $subcontractors);
    $smarty->assign('cid_logo', $at_logo->id);

    $output = $smarty->fetch('activity_tracker_notes.tpl');

    //get clients preferred timezone 
    $clients_current_time = new Zend_Date();
    $clients_current_time->setTimezone($client_timezone);

    $year = intval($now->toString("yyyy"));
    $month = intval($now->toString("MM"));
    $day = intval($now->toString("dd"));
    $hour = intval($now->toString("HH"));
    $minute = intval($now->toString("mm"));
    $second = intval($now->toString("ss"));

    $couch_client = new couchClient($couch_dsn, "rssc_activity_notes_email");

    $doc = new stdClass();
    $doc->to = array($client_email);
    if (validEmail($client_email_cc)) {
        $doc->cc = array($client_email_cc);
    }
    $doc->subject = sprintf("Remote Staff Daily Activity Tracker Notes %s", $clients_current_time->toString("MMM dd"));

    $doc->created = array($year, $month, $day, $hour, $minute, $second);
    $doc->generated_by = 'portal/cronjobs/activity_tracker_notes.php';
    $doc->leads_id = intval($leads_id);
    $doc->from = 'REMOTESTAFF.COM.AU SYSTEM<clientactivitynotes@remotestaff.com.au>';
    $doc->type = 'activity_note_daily';
    try {
        $response = $couch_client->storeDoc($doc);
        //attach the file
        $doc = $couch_client->getDoc($response->id);
        $couch_client->storeAsAttachment($doc, $output, 'message.html', 'text/html');
    }
    catch (Exception $e) {
        echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
        exit(1);
    }

}

?>
