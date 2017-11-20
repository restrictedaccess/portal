<?php

class Input
{
	private static $instance = NULL;
	
	// get Singleton instance of Input class
	public static function getInstance() {
		if (self::$instance === NULL) self::$instance = new self;
		return self::$instance;
	}
	
	// get $_GET variable
	public static function get($inp = NULL) {
		if (!isset($_GET[$inp])) return 0;
		return self::mysql_esc(trim($_GET[$inp]));
	}
	
	// get $_POST variable
	public static function post($inp = NULL) {
		if (!isset($_POST[$inp])) return 0;
		return is_string($_POST[$inp]) ? self::mysql_esc(trim($_POST[$inp])) : $_POST[$inp];
	}
	
	public static function mysql_esc($inp) {
		return is_array($inp) ? array_map(__METHOD__, $inp) : !empty($inp) && is_string($inp)? str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp):$inp;
    } 
}// End Input class