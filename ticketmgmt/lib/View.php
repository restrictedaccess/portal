<?php

class View {
    private $viewfile = 'default_view.php';
    private $properties = array();
	
	private $header_global;
	
	private $view_dir;
	
	private $header = '/header.php';
	private $footer = '/footer.php';
	
	public static $templ_dir = NULL;

    // factory method (chainable)
    public static function factory($viewfile = '')
    {
        return new self($viewfile);
    }

    // constructor
    public function __construct($viewfile = '')
    {
		$this->view_dir = $this::$templ_dir === NULL ? Config::$templ_dir : $this::$templ_dir;
		
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
    public function display() {
		//$templ_dir = Config::$templ_dir;
		// set the static directory
		$display_header = $this::$templ_dir === NULL ? Config::$show_header : true;
		$display_footer = $this::$templ_dir === NULL ? Config::$show_footer : true;
		
		if( $this::$templ_dir === NULL ) {
			$this->properties['staticdir'] = Config::static_dir();
			$this->properties['admin_id'] = TicketController::$admin['admin_id'];
			$this->properties['admin_fname'] = TicketController::$admin['admin_fname'];
		}
        extract($this->properties);
        ob_start();
		
		if($display_header) include_once($this::$templ_dir === NULL ?Config::header() : $this::$templ_dir . $this->header);

        include($this->viewfile);
		
		if($display_footer) include_once($this::$templ_dir === NULL ?Config::footer() : $this::$templ_dir . $this->footer);
		ob_end_flush();
        //return ob_get_clean();		
    }
}// End View class