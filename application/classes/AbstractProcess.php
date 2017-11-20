<?php
class AbstractProcess{
	protected $db, $smarty;	
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
	}
}
