<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
ini_set("default_socket_timeout", 120);
require_once('../conf/zend_smarty_conf.php');
include_once('../ticketmgmt/lib/Utils.php');

if( empty($_SESSION['admin_id']) ) {
	die("Unauthorized Access.");
}

define('ROOT_DIR', dirname(__FILE__));

set_include_path('.'
. PATH_SEPARATOR . ROOT_DIR . '/library'
. PATH_SEPARATOR . ROOT_DIR . '/application/models'
. PATH_SEPARATOR . ROOT_DIR . '/application/forms'
. PATH_SEPARATOR . get_include_path()
);

$conf = new Zend_Config_Ini(ROOT_DIR.'/application/config.ini', 'general');
//$conf['couch_dsn'] = $couch_dsn;
Zend_Registry::set('config', $conf);

//Zend_Registry::set('couch_dsn', $couch_dsn);

Zend_Db_Table::setDefaultAdapter($db);

$options = array(
    'layout'     => 'layout',
    'layoutPath' => ROOT_DIR.'/application/views/scripts/layouts/',
    'contentKey' => 'content'
);
Zend_Layout::startMvc($options);

$cache = Zend_Cache::factory(
        'Core', 'File',
        array( 'lifetime' => 3600 * 24, // 1 day
            'automatic_serialization' => true ),
        array('cache_dir' => ROOT_DIR.'/application/cache')
);

Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
Zend_Registry::set('Cache', $cache);
    

$frontController = Zend_Controller_Front::getInstance();

$frontController->throwExceptions(true);

$frontController->setControllerDirectory(ROOT_DIR.'/application/controllers');
try {
    $frontController->dispatch();
} catch(Exception $e) {
    echo nl2br($e->__toString());
}