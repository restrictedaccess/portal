<?php

class View {
    private $viewfile = 'default_view.php';
    private $properties = array();
	
	private $header_global;
	
	private $view_dir;

    // factory method (chainable)
    public static function factory($templfile = '')
    {
        return new self($viewfile);
    }

    // constructor
    public function __construct($viewfile = '')
    {
		$this->view_dir = Config::$templ_dir;
		
    	if ($viewfile !== '') {
    		$viewfile = $this->view_dir.'/'.$viewfile . '.php';
    		if (file_exists($viewfile)) {
	           $this->viewfile = $viewfile;
	        }
    	}
    }
    
    // set undeclared view property
    public function __set($property, $value)
    {
        if (!isset($this->$property)) {
            $this->properties[$property] = $value;
        }
    }

    // get undeclared view property
    public function __get($property) {
        if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }
    }

    // parse view properties and return output
    public function display($show_header = TRUE) {
		//$templ_dir = Config::$templ_dir;
		// set the static directory
		$this->properties['staticdir'] = Config::static_dir();
		$this->properties['userid'] = SeatbController::$admin['admin_id'];
		$this->properties['userfname'] = SeatbController::$admin['admin_fname'];
		
        extract($this->properties);
		
        ob_start();
		
		if( $show_header ) include_once(Config::header());

        include($this->viewfile);
		
		if( $show_header ) include_once(Config::footer());
		ob_end_flush();
        //return ob_get_clean();
		
    }
}// End View class