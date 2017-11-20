<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
include '../conf/zend_smarty_conf.php';
ini_set("include_path",  implode(':', array(get_include_path(), './lib')) );
//include_once('./lib/Config.php');
Config::$db_conf = $db;

//Config::config();
// application's front controller
require_once('lib/Autoloader.php');