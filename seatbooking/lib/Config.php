<?php

class Config
{
	private $smarty;
	public static $templ_dir = 'views';
	public static $lib_dir = 'lib';
	
	public static $db_conf = null;
    // dispatch request to the appropriate controller/method
    /*public function __construct() {
		//echo 'config';
		include '../conf/zend_smarty_conf.php';
		include_once('./lib/Config.php');
		$this::$db_conf = $db;
    }*/
	public static function header() {
		return Config::$templ_dir.'/seat_header.php';
	}
	
	public static function footer() {
		return Config::$templ_dir.'/seat_footer.php';
	}
	
	public static function static_dir() {
		return '/portal';
	}
}// End Config class