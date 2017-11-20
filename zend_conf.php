<?php
    //2010-02-25 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au          
    //  defined TEST
    define(TEST, False);

    //default timezone is Asia/Manila
    date_default_timezone_set("Asia/Manila");
    define(SCREEN_SHOT_INTERVAL, 180);       //3 minutes
    //define(INTERNET_CONNECTION_LAG, 180);    //3 minutes
    define(INTERNET_CONNECTION_LAG, 300);    //5 minutes
    define(ACTIVITY_NOTE_INTERVAL, 1200);    //20 minutes
    //define(ACTIVITY_NOTE_INTERVAL, 60);    //1 minute
    define(UPLOAD_IMAGE_DIR, '/home/remotestaff/www.remotestaff.com.au/html/portal/screenshots/images/');
    //define(UPLOAD_IMAGE_DIR, '/home/remotestaff/public_html/portal/screenshots/images/');
    //define(UPLOAD_IMAGE_DIR, '/home/oliver/philippinesatwork.com/Chris/screenshots/images/');
    //define(UPLOAD_IMAGE_DIR, '/home/philipp4/public_html/dev/norman/Chris/screenshots/images/');

    //define(CLIENT_VERSION, "20090331");
    define(CLIENT_VERSION, "20101105");
    define(SECONDS_POLL_INTERVAL, 20);       //sets how many seconds interval

    //Create connection parameters to the MySQL using ZEND db.     

    ini_set("include_path",  ".:../lib");
    require_once('../lib/Zend/Db.php');
    require_once("../lib/Smarty/libs/Smarty.class.php");

    $db = Zend_Db::factory('Pdo_Mysql', array(
        'host'     => 'iweb11',
        'username' => 'remotestaff',
        'password' => 'i0MpD3k6yqTz',
        'dbname'   => 'remotestaff'
    ));

    //TODO delete this on production
    require_once '../lib/Zend/Log/Writer/Stream.php';
    require_once '../lib/Zend/Log.php';
    require_once '../lib/Zend/Debug.php';
    //$writer = new Zend_Log_Writer_Stream('/var/log/lighttpd/debug.log');
    //$logger = new Zend_Log($writer);

?>
