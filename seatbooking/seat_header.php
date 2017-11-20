<?php

/* $ seat_header.php 2012-02-08 mike $ */

//define('HOME_DIR', dirname(__FILE__) );
//define('HOME_DIR', 'C:/wamp/www' );
//$rootdir = dirname(dirname(__FILE__)) . '/'; // uncomment in non-windows

// SET ERROR REPORTING
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);

// CHECK FOR PAGE VARIABLE
if(!isset($page)) { $page = ""; }

// DEFINE SE PAGE CONSTANT
define('SB_PAGE', TRUE);
define('RS_ROOT', realpath(dirname(dirname(__FILE__))));


// SET INCLUDE PATH TO ROOT OF RS
//set_include_path(get_include_path() . PATH_SEPARATOR . realpath("../"));

//include HOME_DIR.'/seatbooking/conf/zend_smarty_conf.php';
include '../conf/zend_smarty_conf.php';

include '../lib/validEmail.php';
include '../lib/misc_functions.php';

include '../lib/paginator.class.php';

include './include/activecalendar.php';
include './include/class_booking.php';

// INITIATE SMARTY
$smarty = new Smarty();
$smarty->template_dir = "./templates";
$smarty->compile_dir = "./templates_c";

// temp admin vars
//$admin_id = 33;
//$admin = array('admin_id'=>33, 'admin_fname'=>'Remote', 'admin_lname'=>'Testing');

// CHECK FOR ADMIN SESSION
if( $_SESSION['admin_id'] ) {
    $admin_id = $_SESSION['admin_id'];
    $sql=$db->select()->from('admin', array('admin_id', 'admin_fname', 'admin_lname'))
	->where('admin_id = ?' ,$_SESSION['admin_id']);
    $admin = $db->fetchRow($sql);
} else {
	//header("location:/portal/");
    //exit();
}
/* elseif( $_SESSION['agent_no'] ) {
    //$admin_id = $_SESSION['agent_no'];
    $sql=$db->select()->from('admin', array('admin_id', 'admin_fname', 'admin_lname'))
	->where('admin_id = ?' ,$_SESSION['agent_no']);
    $admin = $db->fetchRow($sql);
}*/

// misc functions
$seat_obj = new seat_booking($db);

// TIME OFFSET (default Manila time)
$tz_offset = $seat_obj->get_tzOffset();

?>