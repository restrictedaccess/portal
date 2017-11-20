<?php
/* admin_revmonitor_class.php 2013-08-01 */
class revenue_monitoring {
	private $smarty;
	private $db;
	private $tbl;
	private $leads_inhouse_id;
	private $show_export;
	private static $instance = NULL;
	public $pages;
	public $where_clause = array();
	public $filter_by;
	public $search;
	public $php_rates = array();
	//public static $admin_manage_confi = array();
	public static function get_instance($db, $use_smarty = true) {
		if( self::$instance === NULL ) self::$instance = new self($db, $use_smarty);
		return self::$instance;
	}
	
	function __construct($db, $use_smarty = true) {
		// SET ERROR REPORTING
		error_reporting(E_ALL ^ E_NOTICE);
		ini_set('display_errors', TRUE);
		$this->db = $db;
		
		$this->show_export = false;
		
		if( empty($_SESSION['admin_id']) ) {
			header("Location: /portal/index.php");
			exit;
		}
		
		$select = $this->db->select()->from( array('a'=>'admin'),
						array('admin_id', 'admin_fname', 'admin_lname', 'view_revenue') )
		->where('admin_id=?', $_SESSION['admin_id']);
		
		$admin = $this->db->fetchRow($select);
		if( $admin['view_revenue'] == 'Y' ) $this->show_export = true;
		else {
			$utils = Utils::getInstance();
			
			$subject = "Access Denied on Revenue Monitoring (Admin #{$admin['admin_id']})";
			$email_body = "<p><strong>Date: </strong>".date("M j, Y H:i a")."</p>"
			."<p><strong>Admin: </strong>{$admin['admin_fname']} {$admin['admin_lname']} #{$admin['admin_id']}</p>";
			$utils->send_email($subject, $email_body, '', 'Remotestaff Notification', false);
			
			die("You do not have permission.");
		}
		
		//if( in_array($_SESSION['admin_id'], self::$admin_manage_confi) ) $this->show_export = true;
		
		if( $use_smarty ) {
			$this->smarty = new Smarty();
			$this->smarty_settings();
		}
		
		$this->tbl = 'vw_subcon';
		$this->leads_inhouse_id = 11;
	}
	
	private function smarty_settings() {
		// set the templates dir.
		$this->smarty->template_dir = ".";
		$this->smarty->compile_dir = "../templates_c";
	}
	
	private function create_sql_query($having = array()) {
		$query = $this->db->select()
		->distinct()
		->from( array('s'=>'subcontractors'),
			   array('userid', 'contract_id'=>'id', 'client_price', 'php_monthly', 'currency', 'work_status',
					 "contract_year"=>"DATE_FORMAT( date_contracted, '%Y')", 'status', 'job_designation',
					 "contract_status"=>"IF(s.status NOT IN ('ACTIVE','suspended'), 'Inactive', s.status)",
					 'starting_date', 'end_date') )
		->joinLeft( array('l'=>'leads'), 'l.id=s.leads_id', array('client_id'=>'id', 'csro_id', 'coordinator'=>'hiring_coordinator_id',
																 "client_name"=>"concat(l.fname,' ',l.lname)" ) )
		//->joinLeft( array('a'=>'admin'), 'a.admin_id=l.csro_id', array() )
		->joinLeft( array('p'=>'personal'), 'p.userid=s.userid', array("staff_name"=>"concat(p.fname,' ',p.lname)") )
		->joinLeft( $this->db->select()->from( array('h'=>'subcontractors_history'), array('subcontractors_id', 'last_update'=>'max(date_change)'))
				   ->group('subcontractors_id'), 'subcontractors_id=s.id', array('last_update') )
		->where('s.leads_id!=?', $this->leads_inhouse_id)
		->where('l.status=?', 'Client');
		
		if( count($having) > 0 ) {
			foreach( $having as $arr ) {
				foreach( $arr as $k => $v) $query->having($k.'=?', $v);
			}
		}
		
		$subqry = $this->db->select()
		->from( array('sub'=>$query), array('*',
							"contract_length"=>"CASE WHEN status='ACTIVE' THEN FLOOR((unix_timestamp(NOW())- unix_timestamp(starting_date))/86400)
							WHEN end_date IS NOT NULL THEN FLOOR((unix_timestamp(end_date)- unix_timestamp(starting_date))/86400)
							ELSE FLOOR((unix_timestamp(last_update)- unix_timestamp(starting_date))/86400)
							END")
			   );

		return $subqry;
	}
	
	private function page_settings($query = '') {
		$this->pages->items_total = $this->db->fetchOne($query);
		$this->pages->mid_range = 7;
		$this->pages->items_per_page = 50;
		$this->pages->paginate();
	}
	
	public function list_csro_coord($field_name, $val = 0) {
		if( !$field_name ) return 0;
		if( $field_name == 'coordinator' ) $field_name = 'hiring_coordinator_id';
		$qry = $this->db->select()
		->distinct($field_name)
		->from( array('s'=>'subcontractors'), array() )
		->joinLeft( array('l'=>'leads'), 'l.id=s.leads_id', array($field_name) )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.'.$field_name, array('admin_fname', 'admin_lname') )
		->where('s.leads_id!=?', $this->leads_inhouse_id)
		->where('l.status=?', 'Client');
		if( !$val ) $qry->where($field_name.'!=?', 'NULL');
		else $qry->where($field_name.'=?', $val);
		return $this->db->fetchAll($qry);
	}
	
	public function list_filter_data($field_name, $val = 0) {
		if( !in_array($field_name, array('currency', 'contract_year', 'contract_status')) ) return 0;
		
		$fields = array('currency' => 'currency',
		"contract_year" =>" DATE_FORMAT( date_contracted, '%Y')",
		"contract_status" => "IF(s.status NOT IN ('ACTIVE','suspended'), 'Inactive', s.status)");
					 
		$qry = $this->db->select()
		->distinct($field_name)
		->from( array('s'=>'subcontractors'), array($field_name => $fields[ $field_name ] ) )
		->joinLeft( array('l'=>'leads'), 'l.id=s.leads_id', array() )
		//->joinLeft( array('a'=>'admin'), 'a.admin_id=l.'.$field_name, array('admin_fname', 'admin_lname') )
		->where('s.leads_id!=?', $this->leads_inhouse_id)
		->where('l.status=?', 'Client');
		
		//->from( array('v'=>$this->tbl), array($field_name) );
		if( !$val ) $qry->having($field_name.'!=?', 'NULL');
		else $qry->having($field_name.'=?', $val);
		return $this->db->fetchAll($qry);
	}
	
	public function toXLS() {
		$filters = $this->having_clause();
		
		$query = $this->create_sql_query( $filters );	
		
		$listing = $this->db->fetchAll($query . " ORDER BY contract_id DESC ");
		
		$xls_fname = 'revenue_'.date('Y-m-d', time());
		
		if( count($filters) > 0 ) {
			foreach( $filters as $arr ) {
					foreach( $arr as $k => $v) $xls_fname .= $k . '_' . $v;
			}
		}
	
		$xls = new class_xls($xls_fname.'.xls');
		$xls->xlsHeader();
		// header string
		$xls->xlsWriteString(0, 0, 'Client Name' );
		$xls->xlsWriteString(0, 1, 'Staff Name' );
		$xls->xlsWriteString(0, 2, 'Contract ID' );
		$xls->xlsWriteString(0, 3, 'Contract Status' );
		$xls->xlsWriteString(0, 4, 'Contract Length' );
		$xls->xlsWriteString(0, 5, 'Job Designation' );
		$xls->xlsWriteString(0, 6, 'Staff Monthly Salary' );
		$xls->xlsWriteString(0, 7, 'Client Price' );
		$xls->xlsWriteString(0, 8, 'Staff Work Status' );
		$xls->xlsWriteString(0, 9, 'Currency' );
		$xls->xlsWriteString(0, 10, 'Revenue' );
					
		for($i = 0; $i < 11; $i++) {
			$xls->xlsWriteString( 1 , $i , '' );
		}
		$ctr = 2;
		$total_revenue = 0;
		foreach($listing as $result) {
			$rate = $this->php_rates[ $result['currency'] ];
			$cp = $result['client_price'];
			$php = $result['php_monthly'];
			$revenue = 0;
			if( $rate && $cp && $php ) {
				$revenue = sprintf("%.2f", $cp-($php/$rate));
				$total_revenue += $revenue;
			}
			
			if( $result['contract_length'] ) {
				$days = $result['contract_length'];
				$year = sprintf("%d year", 0);
				$month = sprintf("%d month", 0);
				$day = sprintf("%d day", 0);
				
				$y = 365;
				$m = 30;
				if( $days > $y ) {
					$year = sprintf("%d year", $days/$y);
					$month = sprintf("%d month/s", $days % $y / $m);
					$day = sprintf("%d day/s", $days % $y % $m);
				} elseif( $days > $m ) {
					$month = sprintf("%d month/s", $days / $m);
					$day = sprintf("%d day/s", $days % $m);
				} elseif( $days > 0 )
					$day = sprintf("%d day/s", $days);				
			}
			
			$xls->xlsWriteString( $ctr , 0 , $result['client_name'] );
			$xls->xlsWriteString( $ctr , 1 , $result['staff_name'] );
			$xls->xlsWriteNumber( $ctr , 2 , $result['contract_id'] );
			$xls->xlsWriteString( $ctr , 3 , $result['status'] );
			$xls->xlsWriteString( $ctr , 4 , $year.', '.$month.', '.$day );
			$xls->xlsWriteString( $ctr , 5 , $result['job_designation'] );
			$xls->xlsWriteNumber( $ctr , 6 , $result['php_monthly'] );
			$xls->xlsWriteNumber( $ctr , 7 , $cp );
			$xls->xlsWriteString( $ctr , 8 , $result['work_status'] );
			$xls->xlsWriteString( $ctr , 9 , $result['currency'] );
			$xls->xlsWriteNumber( $ctr , 10 , $revenue );
			
			$ctr++;
		}
		
		for($i = 0; $i < 10; $i++) {
			$xls->xlsWriteString( $ctr , $i , '' );
		}
		$xls->xlsWriteNumber( $ctr , 10 , $total_revenue );
		$xls->xlsClose();
		return $xls_fname;
	}
	
	private function having_clause() {
		$having = array();
		if( !empty($this->where_clause['search']) )
			$having[] = array($this->where_clause['filter_by'] => $this->where_clause['search']);
		
		if( !empty($this->where_clause['contract_status']) )
			$having[] = array("contract_status" => $this->where_clause['contract_status']);
			
		return $having;
	}
	
	public function display($page) {
		$query = $this->create_sql_query( $this->having_clause() );
		
		$subq = $this->db->select()
		->from( array('sq' => $query), array('total_count' => 'count(*)') );
		
		$this->page_settings($subq);
		
		$listing = $this->db->fetchAll($query . " ORDER BY contract_id DESC ".$this->pages->limit);
		
		$this->smarty->assign('data_array', $listing);
		
		$this->smarty->assign('contract_status', $this->where_clause['contract_status']);
		
		$this->smarty->assign('filter_by', $this->where_clause['filter_by']);
		if( !empty($this->where_clause['search']) )
			$this->smarty->assign('search', $this->where_clause['search']);
		
		$this->smarty->assign('rates', $this->php_rates);
		$this->smarty->assign('show_export', $this->show_export);
		
		$this->smarty->assign('ipp', $this->pages->low);
		$this->smarty->assign('items_total', $this->pages->items_total);
		$this->smarty->assign('pages', $this->pages->display_pages());
		$this->smarty->assign('jump_menu', $this->pages->display_jump_menu());
		$this->smarty->assign('items_pp', $this->pages->display_items_per_page());
		$this->smarty->display($page.".tpl");
	}
}

?>