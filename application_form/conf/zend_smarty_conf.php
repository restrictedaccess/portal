<?php
    define(TEST, True);
    define(LOCATION_ID, 4); #refers to leads_location_lookup table
	session_start();

    if (TEST == False) {
       // error_reporting(E_ERROR);
    }

    //default timezone is Asia/Manila
    date_default_timezone_set("Asia/Manila");
	
	ini_set("include_path",  ".:/home/remotestaff/test.remotestaff.com.au/html/portal/lib");
    require_once('/home/remotestaff/test.remotestaff.com.au/html/portal/lib/Zend/Loader.php');
    require_once("/home/remotestaff/test.remotestaff.com.au/html/portal/lib/Smarty/libs/Smarty.class.php");



    //Zend Autoloader
    Zend_Loader::registerAutoLoad();

    //Create connection parameters to the MySQL using ZEND db.     
    $db = Zend_Db::factory('Pdo_Mysql', array(
        'host'     => 'localhost',
        'username' => 'remotestaff',
        'password' => 'i0MpD3k6yqTz',
        'dbname'   => 'remotestaff'
    ));     //change parameters on production
    $db->getConnection()->exec("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");


        //parameters for smtp connection, used by the Zend_Mail_Transport_Smtp
    $config = array(
        'auth' => 'login',
        'username' => 'noreply@remotestaff.com.au',
        'password'  => 'noreplyxnoreplyy',
        'port' => 587
    );
    $transport = new Zend_Mail_Transport_Smtp('smtp.remotestaff.biz', $config);
    //using servers default smtp
    //$transport = new Zend_Mail_Transport_Sendmail('-fnoreply@remotestaff.com.au');

    $admin_salt_value = 'CHANGEME';

    $writer_admin_login = new Zend_Log_Writer_Stream('/home/remotestaff/test.remotestaff.com.au/log/admin_login.log');
    $logger_admin_login = new Zend_Log($writer_admin_login);

    $writer_admin_mails_sent = new Zend_Log_Writer_Stream('/home/remotestaff/test.remotestaff.com.au/log/admin_sent_emails.log');
    $logger_admin_mails_sent = new Zend_Log($writer_admin_mails_sent);

    $writer = new Zend_Log_Writer_Stream('/home/remotestaff/test.remotestaff.com.au/log/debug.log');
    $logger = new Zend_Log($writer);

    //Used for Smarty Navigation menus
    $DEFAULT_NAV = Array(
        Array('id' => 'homenav', 'href' => '/index.php', 'text' => 'Home'),
        Array('id' => 'jobopennav', 'href' => '/jobopenings.php', 'text' => 'Job Openings'),
        Array('id' => 'registernownav', 'href' => '/registernow-step1-personal-details.php', 'text' => 'Register Now'),
        Array('id' => 'hownav', 'href' => '/howwework.php', 'text' => 'How We Work'),
        Array('id' => 'qnanav', 'href' => '/qanda-jobseeker.php', 'text' => 'Q & A'),
		Array('id' => 'qualitiesnav', 'href' => '/qualities.php', 'text' => 'Qualities Needed From You'),
		Array('id' => 'showcasenav', 'href' => '/showcasing-staff.php', 'text' => 'Existing Staff'),
        Array('id' => 'aboutnav', 'href' => '/aboutus.php', 'text' => 'About Us'),
        Array('id' => 'loginnav', 'href' => '/login.php', 'text' => 'Login')
    );

   // $writer_admin_login = new Zend_Log_Writer_Stream('/var/log/lighttpd/admin_login.txt');
   // $logger_admin_login = new Zend_Log($writer_admin_login);

   // $writer = new Zend_Log_Writer_Stream('/var/log/lighttpd/debug.log');
    //$logger = new Zend_Log($writer);
?>
