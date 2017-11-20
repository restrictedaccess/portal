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
		return mysql_escape_string(trim($_GET[$inp]));
	}
	
	// get $_POST variable
	public static function post($inp = NULL) {
		if (!isset($_POST[$inp])) return 0;
		return mysql_escape_string(trim($_POST[$inp]));
	}
}// End Input class