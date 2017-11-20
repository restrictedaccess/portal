<?php
    include_once 'GrabPage.php';
    
    $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
   	array_shift($url);
	
	class ClassNotFoundException extends Exception{}
	
    // get method name of controller
    $method = !empty($url[2]) ? $url[2] : 'index';
    // get argument passed in to the method
    $arg = !empty($url[3]) ? $url[3] : NULL;
    // create controller instance and call the specified method	
    $cont = new GrabPage();
    if( method_exists($cont, $method) ){
		$cont->$method($arg);
	}
	else
	throw new ClassNotFoundException('Method ' . $method . ' not found.');    
?>