<?php class HeaderTitlePlugin extends Zend_Controller_Plugin_Abstract {
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
		
		if( !empty($_SESSION['admin_id']) ) {
			$admin_id = $_SESSION['admin_id'];
		
			$admin = new Admin();
		
			$admin_user = $admin->fetchRow( $admin->select()->where('admin_id=?', $admin_id) )->toArray();
		
			$view->admin_id = $admin_id;
			$view->name = $admin_user['admin_fname'].' '.$admin_user['admin_lname'];
		}
    }
}