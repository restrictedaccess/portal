<?php
//2010-09-27: Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add sterling bank of asia
//2010-09-03 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed quote from iremit/hsbc/otherbank
//  -   strip off carriage returns/line feeds on some columns
//2010-04-26 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added iremit sender
//2010-04-26 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added iremit sender
//2010-03-29 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added address and phone numbers as per iremits requirements
//2010-01-28 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added userid and bank account details
//2009-08-28 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added export of invoices that are in drafts and paid section
//2009-08-24 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial Hack

require('../conf/zend_smarty_conf.php');
$admin_id = $_SESSION['admin_id'];
$admin_status = $_SESSION['status'];

if ($admin_id == null){
    die('Invalid ID for Admin.');
}

$start_date = $_GET['start_date'];
if (($start_date == null) or ($start_date == '')){
    die('Invalid Start Date');
}

$end_date = $_GET['end_date'];
if (($end_date == null) or ($end_date == '')){
    die('Invalid End Date');
}

$status = $_GET['status'];
if (in_array($status, array('draft', 'approved', 'posted')) == false) {
    die("Invalid invoice status!");
}

$query = $db->select()
            ->from(array('i' => 'subcon_invoice'), array('id', 'userid', 'description', 'invoice_date', 'total_amount', 'converted_amount'))
            ->joinLeft(array('p' => 'personal'), 'i.userid = p.userid', 
                array('lname', 
                    'fname',
                    'handphone_country_code',
                    'handphone_no', 
                    'tel_area_code',
                    'tel_no',
                    'address1',
                    'address2',
                    'postcode',
                    'city'
                ))
            ->joinLeft(array('sterling' => 'subcon_bank_sterling_bank_of_asia'),
                'i.userid = sterling.userid', 
                array('sterling_card_number' => 'card_number', 
                    'sterling_account_holders_name' => 'account_holders_name'))
            ->joinLeft(array('iremit' => 'subcon_bank_iremit_sterling_visa'), 
                'i.userid = iremit.userid', 
                array('iremit_card_number' => 'card_number', 
                    'iremit_account_holders_name' => 'account_holders_name'))
            ->joinLeft(array('iremit_sender_data' => 'iremit_sender_data'), 
                'i.userid = iremit_sender_data.userid', 
                array('sender_id'))
            ->joinLeft(array('iremit_sender_lookup' => 'iremit_sender_lookup'),
                'iremit_sender_data.sender_id = iremit_sender_lookup.id',
                    array(
                        'iremit_sender_fname' => 'first_name',
                        'iremit_sender_lname' => 'last_name'
                    )
                )
            ->joinLeft(array('hsbc' => 'subcon_bank_hsbc_remotestaff'), 'i.userid = hsbc.userid', array('hsbc_account_number' => 'account_number', 'hsbc_account_holders_name' => 'account_holders_name'))
            ->joinLeft(array('bank_other' => 'subcon_bank_others'), 'i.userid = bank_other.userid', 
                array(
                    'other_bank_name' => 'bank_name', 
                    'other_bank_branch' => 'bank_branch', 
                    'other_swift_address' => 'swift_address', 
                    'other_bank_account_number' => 'bank_account_number', 
                    'other_account_holders_name' => 'account_holders_name'))
            ->where('i.status = ?', $status)
            ->where("i.invoice_date between '$start_date' and '$end_date'");

$invoice_records = $db->fetchAll($query);

$tmpfname = tempnam(null, null);

$handle = fopen($tmpfname, "w");

/**
*
* Filters a card number
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

//put csv header
fputcsv($handle, array(
    'Userid', 
    'Co./Last Name', 
    'First Name', 
    'Inclusive', 
    'Purchase #', 
    'Date', 
    'Supplier Invoice #', 
    'Description', 
    'Account #', 
    'Amount', 
    'Tax Code', 
    'Card ID',
    'Amount PHP',
    'Sterling Card #',
    'Sterling Account Holders Name',
    'IRemit Card #',
    'IRemit Account Holders Name',
    'IRemit Sender',
    'HSBC Account #',
    'HSBC Account Holders Name',
    'Other Bank Name',
    'Other Bank Branch',
    'Other Bank Swift Address',
    'Other Bank Account Number',
    'Other Bank Account Holders Name',
    'Address of Beneficiary',
    'Contact Number Beneficiary',
));

foreach ($invoice_records as $line) {
    $record = array(
        $line['userid'], 
        $line['lname'], 
        $line['fname'],
        'X',
        $line['id'],
        $line['invoice_date'],
        $line['id'],
        $line['description'],
        " ",
        $line['converted_amount'],
        "NTD",
        "*None",
        $line['total_amount'],
        FilterCardNumber($line['sterling_card_number']),
        $line['sterling_account_holders_name'],
        FilterCardNumber($line['iremit_card_number']),
        $line['iremit_account_holders_name'],
        sprintf("%s, %s", $line['iremit_sender_lname'], $line['iremit_sender_fname']),
        FilterCardNumber($line['hsbc_account_number']),
        $line['hsbc_account_holders_name'],
        StripCrLfTab($line['other_bank_name']),
        $line['other_bank_branch'],
        StripCrLfTab(sprintf("'%s", $line['other_swift_address'])),
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

if ($status == 'posted') {
    $filename_status = "PAID";
}
else {
    $filename_status = strtoupper($status);
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=STAFF_INVOICE_'.$filename_status."_".$start_date."_TO_".$end_date."_".basename($tmpfname . ".csv"));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));
ob_clean();
flush();

readfile($tmpfname);

unlink($tmpfname);
?>
