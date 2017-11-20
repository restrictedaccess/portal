<?php class TopNavPlugin extends Zend_Controller_Plugin_Abstract {
    public $userid;
    public $name;
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
		
		$userid = Zend_Registry::get('userid');
		$table = Zend_Registry::get('table');
		
		/*if( $table == 'personal' ) $user = new Subcontractors();
		elseif( $table == 'leads' ) $user = new Leads();
		else $user = new Admin();*/
		
		$classname = ucfirst($table);
		
		if( !@class_exists($classname) ) {
			exit($classname.' type class does not exist!');
		}
		
		$user = new $classname();
		
		$staff = $user->fetch_staff( $userid );
		
		Zend_Registry::set('leads_id', $staff['leads_id']);
		
		$view->report = !empty($_GET['item']) && $_GET['item']=='report' ? true : false ;
		$view->reports_allowed = (($table == 'admin' && $staff['status'] == 'FULL-CONTROL') ||
								  ($table == 'leads' && $staff['status'] == 'Client') ||
								  ($table == 'client_managers' && $staff['status'] == 'active')) ? true : false;
        $view->userid = $userid;
        $view->name = $staff['fname'].' '.$staff['lname'];
		
		$view->is_client = ($table == 'leads' && $staff['status'] == 'Client') ? true : false;
    }
}