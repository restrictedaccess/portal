<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../conf/zend_smarty_conf.php');
define('ROOT_DIR', dirname(__FILE__));

set_include_path('.'
. PATH_SEPARATOR . ROOT_DIR . '/library'
. PATH_SEPARATOR . ROOT_DIR . '/application/models'
. PATH_SEPARATOR . ROOT_DIR . '/application/forms'
. PATH_SEPARATOR . get_include_path()
);

//require_once "Zend/Loader/Autoloader.php";
//$autoloader = Zend_Loader_Autoloader::getInstjance();
//$autoloader->setFallbackAutoloader(true);

/*db.adapter = PDO_MYSQL
db.params.host = localhost
db.params.username = root
db.params.password =
db.params.dbname = zend
*/
if( empty($_SESSION['admin_id']) && empty($_SESSION['userid']) && empty($_SESSION['client_id'])) {
	header("location: /portal/");
	exit;
	//die("Unauthorized Access.");
}
$logintype = $_SESSION['logintype'];
switch( $logintype) {
	case 'staff':
		if( !empty($_SESSION['userid']) ) {
			$userid = $_SESSION['userid'];
			$table = 'subcontractors';
		}
		break;
	case 'client':
		if( !empty($_SESSION['client_id']) ) {
			$userid = $_SESSION['client_id'];
			$table = 'leads';
		} elseif( !empty($_SESSION['manager_id']) ) {
			$userid = $_SESSION['manager_id'];
			$table = 'client_managers';
		}
		break;
	case 'admin':
		if( !empty($_SESSION['admin_id']) ) {
			$userid = $_SESSION['admin_id'];
			$table = 'admin';
		}
		break;
	case 'business_partner':
		if( !empty($_SESSION['agent_no']) ) {
			$userid = $_SESSION['agent_no'];
			$table = 'agent';
		}
		break;
	default:
		if( !empty($_SESSION['client_id']) ) {
			$userid = $_SESSION['client_id'];
			$table = 'client';
		}
}

//$conf = new Zend_Config_Ini(ROOT_DIR.'/application/config.ini', 'general');
//$conf['couch_dsn'] = $couch_dsn;
//Zend_Registry::set('config', $conf);
Zend_Registry::set('couch_dsn', $couch_dsn);

Zend_Registry::set('userid', $userid);
Zend_Registry::set('table', $table);

//$dbase = Zend_Db::factory($db->getConfig());
Zend_Db_Table::setDefaultAdapter($db);

$options = array(
    'layout'     => 'layout',
    'layoutPath' => ROOT_DIR.'/application/views/scripts/layouts/',
    'contentKey' => 'content'
);
Zend_Layout::startMvc($options);
//Zend_Layout::startMvc(array('layoutPath' => ROOT_DIR.'/application/views/scripts/layouts'));

//echo $layout->getLayoutPath();
//var_dump($layout);
$cache = Zend_Cache::factory(
        'Core', 'File',
        array( 'lifetime' => 3600 * 24, //cache is cleaned once a day
            'automatic_serialization' => true ),
        array('cache_dir' => ROOT_DIR.'/application/cache')
);
//cache database table schema metadata for faster SQL queries
Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
Zend_Registry::set('Cache', $cache);
    

$frontController = Zend_Controller_Front::getInstance();

$frontController->throwExceptions(true);

$frontController->registerPlugin(new TopNavPlugin());

$router = $frontController->getRouter();

$route = new Zend_Controller_Router_Route_Static('forktask',
array('controller' => 'index', 'action' => 'daterange'));
//$router->addRoute('index', $route);

$frontController->setControllerDirectory(ROOT_DIR.'/application/controllers');
try {
    $frontController->dispatch();
} catch(Exception $e) {
    echo nl2br($e->__toString());
}

?>