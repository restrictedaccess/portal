<?php
//  2011-02-04 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed extra line so that cronjob won't send an output
//  -   add TEST condition
//  2011-01-24 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   executed with cronjob
//  -   report is set to send to contract_monitoring@remotestaff.com.au

require_once('../conf/zend_smarty_conf.php');

//check if all client is on tb_client_account_settings 
$sql = $db->select()
            ->from(Array('s' =>'subcontractors'), 
                        Array('id', 'userid', 'work_status', 'leads_id',
                        'php_monthly', 'php_hourly'))
            ->joinLeft(Array('p' => 'personal'), 's.userid = p.userid', Array('p_fname' => 'fname', 'p_lname' => 'lname'))
            ->joinLeft(Array('l' => 'leads'), 's.leads_id = l.id', Array('fname','lname'))
            ->where("s.status = 'ACTIVE'");
$active_contracts = $db->fetchAll($sql);

$contracts_in_question = Array();
foreach ($active_contracts as $active_contract) {
    if (in_array($active_contract['work_status'], Array('Full-Time', 'Part-Time'))) {
        $php_monthly = $active_contract['php_monthly'];
        $php_hourly = $active_contract['php_hourly'];
        if ($active_contract['work_status'] == 'Full-Time') {
            $hours = 8;
        }
        else {
            $hours = 4;
        }

        $php_hourly_computed = round($php_monthly * 12 / 52 / 5 / $hours, 2);
        if ($php_hourly != $php_hourly_computed) {
            $contracts_in_question[] = Array('contract_id' => $active_contract['id'],
                'staff' => sprintf('%s :: %s %s', $active_contract['userid'], $active_contract['p_fname'], $active_contract['p_lname']),
                'client' => sprintf('%s :: %s %s', $active_contract['leads_id'], $active_contract['fname'], $active_contract['lname']),
                'issue' => sprintf('Hourly rate incorrect!: Computed = %s, Recorded = %s', $php_hourly_computed, $php_hourly)
                );
        }
    }
    else {
        //invalid work status
        $contracts_in_question[] = Array('contract_id' => $active_contract['id'],
            'staff' => sprintf('%s :: %s %s', $active_contract['userid'], $active_contract['p_fname'], $active_contract['p_lname']),
            'client' => sprintf('%s :: %s %s', $active_contract['leads_id'], $active_contract['fname'], $active_contract['lname']),
            'issue' => 'Work Status Unknown'
            );
    }
}

if (count($contracts_in_question) > 0) {
    $smarty = New Smarty();
    $smarty->assign('contracts_in_question', $contracts_in_question);
    $output = $smarty->fetch('subcontract_php_hourly_rate_check.tpl');

    $mail = new Zend_Mail();
    $mail->setBodyHtml($output);
    if (TEST) {
        $mail->addTo('devs@remotestaff.com.au');
    }
    else {
        $mail->addTo('contract_monitoring@remotestaff.com.au');
    }
    $mail->setSubject('PHP Hourly Rate Check.');
    $mail->setFrom('noreply@remotestaff.com.au', 'System Generated, do not reply.');
    $mail->send($transport);
}

?>
