<?php
    //  2013-09-23 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  -   used db_query_only variable on retrieving/sending activity notes email
    //  2010-09-14 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  -   removed devs@remotestaff.com.au and removed [TEST MODE] on subject
    //  2010-02-08 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  -   changed the date format
    //  -   changed the subject of the email
    //2010-01-25 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  added the per country/city settings of admin notes
    //2010-01-13 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  modifications on admin notes
    //2010-01-05 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  add the notes that the admin has setup for the client
    //2009-12-17 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    //  initial hack to integrate roys table
    include("../conf/zend_smarty_conf.php");

define('DEBUG', False);
define('DEFAULT_CLIENT_TIMEZONE', 'Australia/Sydney');  

    /**
     *
     * Mails Activity Notes
     *
     * @author		Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au
     */
    class ActivityNotesMailer {
        /**
        *
        * Initialize
        *
        * @return	none
        */
        function __construct($timerecord_id) {
            global $db;
            //get userid and leads id from timerecord_id
            $sql = $db->select()
                ->from('timerecord')
                ->where('id = ?', $timerecord_id);
            $this->timerecord_data = $db->fetchRow($sql);
            //initialize variables
            $this->userid = $this->timerecord_data['userid'];
            $this->leads_id = $this->timerecord_data['leads_id'];
            $this->timerecord_id = $timerecord_id;
            $this->subcontractors_id = $this->timerecord_data['subcontractors_id'];
        }

        /**
        *
        * On Logout
        *
        * @return	none
        * @access	public
        * @see		??
        */
        function Logout() {
            global $db_query_only, $transport, $logger;
            //check if tb_client_account_settings is set to 'ONE'
            $sql = $db_query_only->select()
                ->from("tb_client_account_settings", array('status' => 'status', 'client_timezone' => 'client_timezone'))
                ->where("client_id = ?", $this->leads_id);
            $tb_client_account_settings = $db_query_only->fetchRow($sql);
            $status = $tb_client_account_settings['status'];
            $client_timezone = $tb_client_account_settings['client_timezone'];

            if ($status == 'ONE') { //send mail to client

                $now = new Zend_Date();

                //grab record from subcontractors table
                $sql = $db_query_only->select()
                            ->from(array('s' => 'subcontractors'), array('id' => 'id', 'userid' => 'userid'))
                            ->join(array('p' => 'personal'), 's.userid = p.userid', array('fname' => 'fname', 'lname' => 'lname'))
                            ->where("s.status = 'ACTIVE'")
                            ->where("s.id = ?", $this->subcontractors_id)
                            ->where('s.leads_id = ?', $this->leads_id);
                $subcontractors = $db_query_only->fetchAll($sql);

                //get time_in, time_out
                $time_in = new Zend_Date($this->timerecord_data['time_in'], 'YYYY-MM-dd HH:mm:ss');
                $time_out = $this->timerecord_data['time_out'];

                //time out is null, use current time
                if ($time_out == Null) {
                    $time_out = new Zend_Date();
                }
                else {
                    $time_out = new Zend_Date($this->timerecord_data['time_out'], 'YYYY-MM-dd HH:mm:ss');
                }

                //get activity tracker notes
                $sql = $db_query_only->select()
                            ->from('activity_tracker_notes')
                            ->where('leads_id = ?', $this->leads_id)
                            ->where('userid = ?', $subcontractors[0]['userid'])
                            ->where('checked_in_time >= ?', $time_in->toString('yyyy-MM-dd HH:mm:ss'))
                            ->where('checked_in_time < ?', $time_out->toString('yyyy-MM-dd HH:mm:ss'))
                            ->order('checked_in_time');
                $activity_tracker_notes = $db_query_only->fetchAll($sql);

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
                $subcontractors[0]['activity_tracker_notes'] = $activity_tracker_notes;


                //grab notes from tb_admin_activity_tracker_notes
                $sql = $db_query_only->select()
                            ->from('tb_admin_activity_tracker_notes')
                            ->where('client_id = ?', $this->leads_id)
                            ->where('subcon_id = ?', $subcontractors[0]['userid'])
                            ->where('method = "PER STAFF"')
                            ->where('status = "ACTIVE"')
                            ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                            ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));

                $admin_notes_per_staff = $db_query_only->fetchAll($sql);
                if (count($admin_notes_per_staff) != 0) {
                    $subcontractors[0]['admin_notes_per_staff'] = $admin_notes_per_staff;
                }

                //get time in/out lunch in/out
                $sql = $db_query_only->select()
                            ->from('timerecord')
                            ->where('id = ?', $this->timerecord_id);
                $time_records = $db_query_only->fetchAll($sql);

                //insert lunch record
                for ($j = 0; $j < count($time_records); $j++) {
                    if ($time_records[$j]['time_out'] == null) {
                        $sql = $db_query_only->select()
                                ->from('timerecord')
                                ->where(sprintf('time_in BETWEEN "%s" AND NOW()', $time_records[$j]['time_in']))
                                ->where('mode = "lunch_break"')
                                ->where('leads_id = ?', $this->leads_id)
                                ->where('userid = ?', $subcontractors[0]['userid']);
                    }
                    else {
                        $sql = $db_query_only->select()
                                ->from('timerecord')
                                ->where(sprintf('time_in BETWEEN "%s" AND "%s"', $time_records[$j]['time_in'], $time_records[$j]['time_out']))
                                ->where('mode = "lunch_break"')
                                ->where('leads_id = ?', $this->leads_id)
                                ->where('userid = ?', $subcontractors[0]['userid']);
                    }
                    $lunch_records = $db_query_only->fetchRow($sql);   //only one lunch record per time in/out
                    $time_records[$j]['lunch_start'] = $lunch_records['time_in'];
                    $time_records[$j]['lunch_fin'] = $lunch_records['time_out'];
                }

                //loop over time_records and change it to clients time zone
                for ($j = 0; $j < count($time_records); $j++) {
                    $time_in = new Zend_Date($time_records[$j]['time_in'], 'YYYY-MM-dd HH:mm:ss');
                    $time_out = new Zend_Date($time_records[$j]['time_out'], 'YYYY-MM-dd HH:mm:ss');
                    $lunch_start = new Zend_Date($time_records[$j]['lunch_start'], 'YYYY-MM-dd HH:mm:ss');
                    $lunch_fin = new Zend_Date($time_records[$j]['lunch_fin'], 'YYYY-MM-dd HH:mm:ss');

                    $time_in->setTimezone($client_timezone);
                    $time_out->setTimezone($client_timezone);
                    $lunch_start->setTimezone($client_timezone);
                    $lunch_fin->setTimezone($client_timezone);

                    //asign it back
                    $time_records[$j]['time_in'] = $time_in->toString('MM/dd hh:mm a');
                    $time_records[$j]['time_out'] = $time_out->toString('MM/dd hh:mm a');
                    if ($lunch_records) {
                        $time_records[$j]['lunch_start'] = $lunch_start->toString('MM/dd hh:mm a');
                        $time_records[$j]['lunch_fin'] = $lunch_fin->toString('MM/dd hh:mm a');
                    }
                }
        
                $subcontractors[0]['time_records'] = $time_records;


                //get admin notes that are method='ALL'
                $sql = $db_query_only->select()
                            ->from('tb_admin_activity_tracker_notes')
                            ->where('method = "ALL"')
                            ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                            ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));
                $admin_notes_all = $db_query_only->fetchAll($sql);

                //get admin notes that are method='PER CLIENT'
                $sql = $db_query_only->select()
                            ->from('tb_admin_activity_tracker_notes')
                            ->where('client_id = ?', $this->leads_id)
                            ->where('method = "PER CLIENT"')
                            ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                            ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));
                $admin_notes_per_client = $db_query_only->fetchAll($sql);

                //get admin notes that are method='PER COUNTRY CITY'
                $sql = $db_query_only->select()
                            ->from('tb_admin_activity_tracker_notes')
                            ->where('client_id = ?', $this->leads_id)
                            ->where('method = "PER COUNTRY CITY"')
                            ->where('country_city = ?', $client_timezone)
                            ->where('date_to_execute_from <= ?', $now->toString("yyyy-MM-dd"))
                            ->where('date_to_execute_to >= ?', $now->toString("yyyy-MM-dd"));
                $admin_notes_per_country_city = $db_query_only->fetchAll($sql);


                //create a smarty object
                $smarty = New Smarty();
                $smarty->register_modifier('ss', 'stripslashes');
                $smarty->assign('admin_notes_all', $admin_notes_all);
                $smarty->assign('admin_notes_per_client', $admin_notes_per_client);
                $smarty->assign('admin_notes_per_country_city', $admin_notes_per_country_city);
                $smarty->assign('client_timezone', $client_timezone);
                $smarty->assign('subcontractors', $subcontractors);

                $smarty->template_dir = '../cronjobs/templates';
                $smarty->compile_dir = '../cronjobs/templates_c';
                //$this->output = $smarty->fetch('ActivityNotesMailer.tpl');
                $this->output = $smarty->fetch('activity_tracker_notes.tpl');

                if (! DEBUG) {
                    //get clients email address
                    $sql = $db_query_only->select()
                                ->from('leads', array('email'))
                                ->where('id = ?', $this->leads_id);
                    $client_email = $db_query_only->fetchOne($sql);

                    //get clients preferred timezone 
                    $clients_current_time = new Zend_Date();
                    $clients_current_time->setTimezone($client_timezone);

                    //send the mail
                    $mail = new Zend_Mail();
                    $mail->setBodyHtml($this->output);
                    $mail->setFrom('noreply@remotestaff.com.au', 'REMOTESTAFF.COM.AU SYSTEM');
                    if (TEST) {
                        $mail->addTo('devs@remotestaff.com.au');
                        $mail->setSubject(sprintf("[TEST MODE] Remote Staff Daily Activity Tracker Notes %s", $clients_current_time->toString("MMM dd")));
                    }
                    else {
                        $mail->addTo($client_email);
                        $mail->setSubject(sprintf("Remote Staff Daily Activity Tracker Notes %s", $clients_current_time->toString("MMM dd")));
                    }
                    $mail->send($transport);
                }
            }
        }
    }

?>
<?php
    if (DEBUG) {
        $mailer = new ActivityNotesMailer(78661);
        $mailer->Logout();
        echo $mailer->output;
    }
?>
