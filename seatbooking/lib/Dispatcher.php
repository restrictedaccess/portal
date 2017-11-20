<?php

class Dispatcher
{
    // dispatch request to the appropriate controller/method
    public static function dispatch()
    {
    	$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
		//echo $_SERVER['REQUEST_URI'];
    	array_shift($url);
		//print_r($url);
		
        // get controller name
        $controller = !empty($url[1]) ? ucfirst(strstr($url[1], '.', TRUE)) . 'Controller' : 'SeatbController';
		//$controller = !empty($url[1]) ? $url[1] . 'Controller' : 'SeatController';
        // get method name of controller
        $method = !empty($url[2]) ? $url[2] : 'index';
        // get argument passed in to the method
        $arg = !empty($url[3]) ? $url[3] : NULL;
        // create controller instance and call the specified method
		$cont = new $controller;
		if( method_exists($cont, $method) )
			$cont->$method($arg);
		else throw new ClassNotFoundException('Method ' . $method . ' not found.');
    }
}// End Dispatcher class