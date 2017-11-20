<?php

/* ticketLogs.php 2012-04-13 $ */
//include '../portal/lib/validEmail.php';

class QAusers {
    private $db;
	private $filename = 'testers.txt';

	private static $instance = NULL;
	
	public static function getInstance() {
		if (self::$instance === NULL) {
			self::$instance = new self();
		}
        return self::$instance;
    }
    
    function __construct() {
        //$this->db = $db;
		//$this->utils = Utils::getInstance();
		//$this->utils->db = $db;
    }
	
	public function user_insert($data_array = array()) {
		$contents = array();
		if( file_exists($this->filename) ) {
			$contents = unserialize(file_get_contents($this->filename));
		}
		//print_r($contents);
		if( count($data_array) > 0 ) {
			$contents[] = $data_array;
			file_put_contents( $this->filename, serialize($contents) );
		}
	}
	
	public function user_delete($userid) {
		$contents = array();
		if( file_exists($this->filename) ) {
			$contents = array_values(unserialize(file_get_contents($this->filename)));
		}

		for( $i=0, $len=count($contents); $i<$len; $i++ ) {
			if( $contents[$i]['userid'] == $userid ) {
				unset($contents[$i]);
			}
		}
		if( count($contents) > 0 )
			file_put_contents( $this->filename, serialize($contents) );
	}
		
	public function lastUpdate($val = 'max', $id = 0) {
	}
	
	public function fetchAll() {
		$contents = array();
		//$contents = file_get_contents($this->filename);
		if( file_exists($this->filename) ) {
			$contents = unserialize(file_get_contents($this->filename));
		}
		return $contents;
		
	}
}