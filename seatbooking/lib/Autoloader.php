<?php

// application's front controller
/*include_once('Dispatcher.php');
include_once('ClassBooking.php');
include_once('Input.php');
include_once('View.php');*/
//set_include_path( implode(';', array(get_include_path(), './lib') ) );
// specify parameters for autoloading classes
/*spl_autoload_register(NULL, FALSE);
spl_autoload_extensions('.php');
spl_autoload_register(array('Autoloader', 'load'));
*/
// define custom ClassNotFoundException exception class
class ClassNotFoundException extends Exception{}

// define Autoloader class
/*class Autoloader
{
	// attempt to autoload a specified class
	public static function load($class)
	{
		if (class_exists($class, FALSE))
		{
			return;
		}
		if( substr($class, -10) == 'Controller')
			$file = $class . '.php';
		else $file = 'lib/'. $class . '.php';
		echo $file.'<br/>';
		if (!file_exists($file))
		{
			eval('class ' . $class . '{}');
			throw new Exception('File ' . $file . ' not found.');
		}
		
		require_once($file);
		unset($file);
		if (!class_exists($class, FALSE))
		{
			eval('class ' . $class . '{}');
			throw new ClassNotFoundException('Class ' . $class . ' not found.');
		}
	}
}*/
// handle request and dispatch it to the appropriate controller
try{
	Dispatcher::dispatch();
}
// catch exceptions
catch (ClassNotFoundException $e){
	echo $e->getMessage();
	exit();
}
catch (Exception $e){
	echo $e->getMessage();
	exit();
}// End front controller