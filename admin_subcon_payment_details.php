<?php
//2010-09-07 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   changed the config file
//2010-09-06 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add sterling bank of asia
//  2010-04-26  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add IRemit Sender
//  2010-01-29  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   fix cardnumbers
//  2010-01-18  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   overhauled
//  -   used new bank account details

require_once("conf/zend_smarty_conf.php");
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($_SESSION['admin_id']=="") {
    header("location:index.php");
	exit;
}

header("location:/portal/django/subcontractors/subcon_payment_details/");
exit;
$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);
//print_r($admin);
//exit;
if($admin['manage_staff_invoice'] == 'N'){
    
	$body = sprintf('Admin #%s %s %s is trying to view Subcontractors Payment Details.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
	$body .= sprintf('<p><em>%s</em></p>', $_SERVER['SCRIPT_FILENAME']);
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	
	if(!TEST){
	    $mail->addTo('admin@remotestaff.com.au', 'Admin');
		$mail->addBcc('devs@remotestaff.com.au', 'DEVS');
	    $mail->setSubject("ALERT Subcontractors Payment Details Permission Denied.");
	}else{
	    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject("TEST ALERT Subcontractors Payment Details Permission Denied.");
	}	
	
	$mail->send($transport);
	die("Subcontractors Payment Details Permission Denied");
}


/**
*
* Filters a card number and quote string appended
*
*
* @return	string	 Description
*/
function FilterCardNumber($card_number) {
    $card_number = trim($card_number);
    $card_number = str_replace(array(" ", "-"), array("", ""), $card_number);
    return sprintf("%s", $card_number);
}


/**
*
* Removes unprintable character for csv consumption
*
*/
function StripCrLfTab($string) {
    $string = trim($string);
    $string = str_replace(array("\r", "\n", "\t"), array(" ", " ", ""), $string);
    return sprintf("%s", $string);
}


$sql = $db->select()
            ->distinct()
            ->from(array('s' => 'subcontractors'), 'userid')
            ->joinLeft(array('p' => 'personal'), 's.userid = p.userid', 
                array(
                    'lname', 
                    'fname',
                    'handphone_country_code',
                    'handphone_no', 
                    'tel_area_code',
                    'tel_no',
                    'address1',
                    'address2',
                    'postcode',
                    'city'
                )
            )
            ->joinLeft(array('i' => 'subcon_bank_iremit_sterling_visa'), 
                's.userid = i.userid', 
                    array('iremit_card_number' => 'card_number', 
                        'iremit_account_holders_name' =>'account_holders_name'))
            ->joinLeft(array('sterling' => 'subcon_bank_sterling_bank_of_asia'),
                's.userid = sterling.userid', 
                array('sterling_card_number' => 'card_number', 
                    'sterling_account_holders_name' => 'account_holders_name'))
            ->joinLeft(array('iremit_sender_data' => 'iremit_sender_data'), 
                's.userid = iremit_sender_data.userid', 
                    array('sender_id') )
            ->joinLeft(array('iremit_sender_lookup' => 'iremit_sender_lookup'),
                'iremit_sender_data.sender_id = iremit_sender_lookup.id',
                    array(
                        'iremit_sender_fname' => 'first_name',
                        'iremit_sender_lname' => 'last_name'
                    )
                )
            ->joinLeft(array('h' => 'subcon_bank_hsbc_remotestaff'), 
                's.userid = h.userid', 
                array('hsbc_account_number' => 'account_number', 
                    'hsbc_account_holders_name' => 'account_holders_name'))
            ->joinLeft(array('o' => 'subcon_bank_others'), 
                's.userid = o.userid', 
                array('other_bank_name' => 'bank_name', 
                    'other_bank_branch' => 'bank_branch', 
                    'other_swift_address' => 'swift_address', 
                    'other_bank_account_number' => 'bank_account_number', 
                    'other_account_holders_name' => 'account_holders_name'))
            ->where('s.status = "ACTIVE"')
            ->order(array('p.fname', 'p.lname'));

$payment_details = $db->fetchAll($sql);

//CSV output
if ($_GET['csv'] == 'y') {
    $tmpfname = tempnam(null, null);

    $handle = fopen($tmpfname, "w");

    //put csv header
    fputcsv($handle, array(
        'Userid', 
        'Name', 
        'Sterling Card #', 
        'Sterling Account Holders Name', 
        'HSBC Acct #', 
        'HSBC Account Holders Name #', 
        'IRemit Card #', 
        'IRemit Account Holders Name', 
        'IRemit Sender', 
        'Other Bank Name', 
        'Other Bank Branch', 
        'Other Bank Swift Addres', 
        'Other Bank Account #', 
        'Other Bank Account Holders Name',
        'Address of Beneficiary',
        'Contact Number Beneficiary',
    ));

    foreach ($payment_details as $line) {
        $record = array($line['userid'], 
            sprintf("%s %s", $line['fname'], $line['lname']),
            FilterCardNumber($line['sterling_card_number']),
            $line['sterling_account_holders_name'],
            FilterCardNumber($line['hsbc_account_number']),
            $line['hsbc_account_holders_name'],
            FilterCardNumber($line['iremit_card_number']),
            $line['iremit_account_holders_name'],
            sprintf("%s, %s", $line['iremit_sender_lname'], $line['iremit_sender_fname']),
            $line['other_bank_name'],
            $line['other_bank_branch'],
            $line['other_swift_address'],
            FilterCardNumber($line['other_bank_account_number']),
            $line['other_account_holders_name'],
            StripCrLfTab(sprintf("%s, %s, %s, %s", 
                $line['address1'], 
                $line['address2'], 
                $line['city'], 
                $line['postcode']
            )),
            StripCrLfTab(sprintf("+%s %s / (%s) %s", 
                $line['handphone_country_code'], 
                $line['handphone_no'], 
                $line['tel_area_code'], 
                $line['tel_no']
            )),
        );
        fputcsv($handle, $record);
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=STAFF_PAYMENT_DETAILS'.$tmpfname . ".csv");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($tmpfname));
    ob_clean();
    flush();

    readfile($tmpfname);

    unlink($tmpfname);
    exit;
}

$smarty = new Smarty();
$smarty->assign('payment_details', $payment_details);
$smarty->display('admin_subcon_payment_details.tpl');

?>
