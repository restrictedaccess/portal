<?php
class ActivityLogs extends Zend_Db_Table {
	protected $_name = "activity_logs";
	public $today_activity = false;
	public $from_date = null;
	public $to_date = null;
	public $order_desc = false;
	public $today = null;
	public $category = null;
	
	public function fetch_logs($userid, $where = null) {
		//$now = date('Y-m-d H:i:s');
		$select1 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid', 'category', 'activity_details') )
		->joinLeft( array('p'=>'personal'), 'p.userid=l.userid', array('fname', 'lname', 'email') )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status', 'date_added', 'admin',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->today}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",
						 'time_ended'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_status'=>"(select h2.status from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_started'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid and h2.status='ongoing' order by h2.id DESC limit 1)",
						 'task_from_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.admin and h.admin > 0 order by h2.id limit 1)") )
		->where('l.userid IN (?)', $userid)
		->where('l.reference IN (?)', array('personal', 'subcontractors'));
		//->where('h.id = (select max(h3.id) from activity_logs_history h3 where h3.aid=h.aid)');
		//->group('l.id')
		//->order('h.id DESC');
		
		$select2 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid','category', 'activity_details') )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.userid', array('fname'=>'admin_fname', 'lname'=>'admin_lname', 'email'=>'admin_email') )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status', 'date_added', 'admin',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->today}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",
						 'time_ended'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_status'=>"(select h2.status from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_started'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid and h2.status='ongoing' order by h2.id DESC limit 1)",
						 'task_from_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.admin and h.admin > 0 order by h2.id limit 1)") )
		->where('l.userid IN (?)', $userid)
		->where('l.reference = ?', 'admin');
		//->where('h.id = (select max(h3.id) from activity_logs_history h3 where h3.aid=h.aid)');
		//->group('l.id');
		//->order('h.id DESC');
		
		$select3 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid','category', 'activity_details') )
		->joinLeft( array('c'=>'leads'), 'c.id=l.userid', array('fname', 'lname', 'email') )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status', 'date_added', 'admin',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->today}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",
						 'time_ended'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_status'=>"(select h2.status from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_started'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid and h2.status='ongoing' order by h2.id DESC limit 1)",
						 'task_from_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.admin and h.admin > 0 order by h2.id limit 1)") )
		->where('l.userid IN (?)', $userid)
		->where('l.reference = ?', 'leads');
		
		$select4 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid'=>"IF(a.userid is NULL, l.userid, a.userid )",'category', 'activity_details') )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.userid', array() )
		->joinLeft( array('p'=>'personal'), 'p.userid=a.userid', array('fname', 'lname', 'email') )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status', 'date_added', 'admin',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->today}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",
						 'time_ended'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_status'=>"(select h2.status from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_started'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid and h2.status='ongoing' order by h2.id DESC limit 1)",
						 'task_from_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.admin and h.admin > 0 order by h2.id limit 1)") )
		->where('p.userid IN (?)', $userid)
		->where('l.reference = ?', 'admin');
		
		$select5 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid','category', 'activity_details') )
		->joinLeft( array('c'=>'client_managers'), 'c.id=l.userid', array('fname', 'lname', 'email') )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status', 'date_added', 'admin',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->today}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",
						 'time_ended'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_status'=>"(select h2.status from activity_logs_history h2 where h2.aid=h.aid order by h2.id DESC limit 1)",
						 'last_started'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid and h2.status='ongoing' order by h2.id DESC limit 1)",
						 'task_from_date'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.admin and h.admin > 0 order by h2.id limit 1)") )
		->where('l.userid IN (?)', $userid)
		->where('l.reference = ?', 'client_managers');
		
		if( $this->today_activity ) {
			$select1->having("date(activity_date) = date('{$this->to_date}')");
			$select2->having("date(activity_date) = date('{$this->to_date}')");
			$select3->having("date(activity_date) = date('{$this->to_date}')");
			$select4->having("date(activity_date) = date('{$this->to_date}')");
			$select5->having("date(activity_date) = date('{$this->to_date}')");
			
			if( count($_SESSION['fin_act']) ) {
				// dont include the finished entries
				$select1->where('l.id NOT IN (?)', $_SESSION['fin_act']);
				$select2->where('l.id NOT IN (?)', $_SESSION['fin_act']);
				$select3->where('l.id NOT IN (?)', $_SESSION['fin_act']);
				$select4->where('l.id NOT IN (?)', $_SESSION['fin_act']);
				$select5->where('l.id NOT IN (?)', $_SESSION['fin_act']);
			}
		} else {
			/*if( $this->from_date == null && $this->to_date == null) {
				$this->from_date = date("Y-m-d", strtotime("-7 days"));
				$this->to_date = $now;	
			}*/
			$select1->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
			$select2->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
			$select3->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
			$select4->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
			$select5->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
		}
		
		if( $this->category !== null ) {
			$select1->where('l.category=?', $this->category);
			$select2->where('l.category=?', $this->category);
			$select3->where('l.category=?', $this->category);
			$select4->where('l.category=?', $this->category);
			$select5->where('l.category=?', $this->category);
		}
		
		if( $where !== null) {
			$select1->having($where);
			$select2->having($where);
			$select3->having($where);
			$select4->having($where);
			$select5->having($where);
		}
		//echo '<br/>'.$select4->__toString();
		//echo '<br/>'.$select2->__toString();
		/*if( $from == null && $to == null) {
			$select1->where("date(activity_started) = date('{$now}')");
			$select2->where("date(activity_started) = date('{$now}')");
		} else {
			$select1->where("date(activity_started) => date('{$from}') and date(activity_started) <= date('{$to}')");
			$select2->where("date(activity_started) => date('{$from}') and date(activity_started) <= date('{$to}')");
		}*/
		
		$union = $this->getDefaultAdapter()->select()
		->union( array( $select1, $select2, $select3, $select4, $select5) );
		//if( $this->order_desc ) $union->order('aid DESC');
		//echo '<br/>'.$union->__toString();
		$main_select = $this->select()
		->setIntegrityCheck(false)
		->from( array('sub' => $union),
			   array('id','hid', 'userid', 'fname', 'lname', 'email', 'category'=>"LOWER(category)", 'activity_details', 'admin',
					'activity_status'=>'last_status', 'time_diff'=>"sec_to_time(sum(time_diff))",
					'pausecnt'=>"COUNT( IF(status='paused',1,null) )", 'last_started'=>"DATE_FORMAT(sub.last_started, '%r')",
					'time_ended'=>"DATE_FORMAT(sub.time_ended, '%r')",
					'activity_date', 'time_started'=>"DATE_FORMAT(activity_date, '%r')",
					'task_from_date'=>"date(task_from_date)") )
		->group('sub.id')
		->order('sub.hid DESC');
		
		//echo '<br/>'.$main_select->__toString();
		$db = Zend_Db_Table::getDefaultAdapter();
		$stmt = $db->query($main_select);
		//$stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function fetch_logs_old($userid) {
		//$now = date('Y-m-d H:i:s');
		$select1 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid', 'time_started'=>"DATE_FORMAT(activity_started, '%H:%i:%s')",
								"time_ended"=>"IF(activity_ended, DATE_FORMAT(activity_ended, '%H:%i:%s'), 'ongoing')",
								"activity_date"=>"DATE_FORMAT(activity_started, '%b %d, %Y')", 'activity_status', 'category', 'activity_details',
								"time_diff"=>"IF(activity_ended, timediff(activity_ended, activity_started), timediff('{$this->to_date}', activity_started) )") )
		->joinLeft( array('p'=>'personal'), 'p.userid=l.userid', array('fname', 'lname', 'email') )
		->where('l.userid = ?', $userid)
		->where('l.reference = ?', 'personal');
		
		$select2 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid', 'time_started'=>"DATE_FORMAT(activity_started, '%H:%i:%s')",
								"time_ended"=>"IF(activity_ended, DATE_FORMAT(activity_ended, '%H:%i:%s'), 'ongoing')",
								"activity_date"=>"DATE_FORMAT(activity_started, '%b %d, %Y')", 'activity_status', 'category', 'activity_details',
								"time_diff"=>"IF(activity_ended, timediff(activity_ended, activity_started), timediff('{$this->to_date}', activity_started) )") )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.userid', array('fname'=>'admin_fname', 'lname'=>'admin_lname', 'email'=>'admin_email') )
		->where('l.userid = ?', $userid)
		->where('l.reference = ?', 'admin');
		
		
		if( $this->today_activity ) {
			$select1->where("date(activity_started) = date('{$this->to_date}')");
			$select2->where("date(activity_started) = date('{$this->to_date}')");
			
			if( count($_SESSION['fin_act']) ) {
				// dont include the finished entries
				$select1->where('id NOT IN (?)', $_SESSION['fin_act']);
				$select2->where('id NOT IN (?)', $_SESSION['fin_act']);
			}
		} else {
			$select1->where("date(activity_started) >= date('{$this->from_date}') and date(activity_started) <= date('{$this->to_date}')");
			$select2->where("date(activity_started) >= date('{$this->from_date}') and date(activity_started) <= date('{$this->to_date}')");
		}
		
		
		$union = $this->getDefaultAdapter()->select()
		->union( array( $select1, $select2) );
		if( $this->order_desc ) $union->order('id DESC');
		
		//echo '<br/>'.$union->__toString();
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$stmt = $db->query($union);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function elapsed_time($id) {
		$sub_select = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id') )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id', array('status',
								'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->to_date}',h.date_added)), h.time_diff)",
								'last_started'=>"(select h2.date_added from activity_logs_history h2 where h2.aid=h.aid and h2.status='ongoing' order by h2.id DESC limit 1)") )
		->where('l.id=?', $id);
		
		$select = $this->select()
		->setIntegrityCheck(false)
		->from( array('sub' => $sub_select),
			   array('time_diff'=>"sec_to_time(sum(time_diff))", 'pausecnt'=>"COUNT( IF(status='paused',1,null) )",
					 'last_started'=>"DATE_FORMAT(sub.last_started, '%r')") )
		->group('sub.id');
		return $this->fetchRow($select)->toArray();
	}
	
	public function activity_get($id) {
		$select = $this->select()
		->from($this->_name, array('activity_details', 'category', 'reference') )
		->where('id=?', $id);
		return $this->fetchRow($select)->toArray();
	}
	
	public function elapsed_time_day($aUid ) {
		$select1 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid') )
		->joinLeft( array('p'=>'personal'), 'p.userid=l.userid', array() )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->to_date}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select date(h2.date_added) from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",) )
		->where('l.userid IN (?)', $aUid)
		->where('l.reference IN (?)', array('personal', 'subcontractors'));
		
		$select2 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid') )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.userid', array() )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->to_date}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select date(h2.date_added) from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)") )
		->where('l.userid IN (?)', $aUid)
		->where('l.reference = ?', 'admin');
		
		$select3 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid') )
		->joinLeft( array('c'=>'leads'), 'c.id=l.userid', array() )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->to_date}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select date(h2.date_added) from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",) )
		->where('l.userid IN (?)', $aUid)
		->where('l.reference = ?', 'leads');
		
		$select4 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid'=>"IF(a.userid is NULL, l.userid, a.userid )") )
		->joinLeft( array('a'=>'admin'), 'a.admin_id=l.userid', array() )
		->joinLeft( array('p'=>'personal'), 'p.userid=a.userid', array() )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->to_date}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select date(h2.date_added) from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)") )
		->where('p.userid IN (?)', $aUid)
		->where('l.reference = ?', 'admin');
		
		$select5 = $this->select()
		->setIntegrityCheck(false)
		->from(array('l'=>$this->_name), array('id', 'userid') )
		->joinLeft( array('c'=>'client_managers'), 'c.id=l.userid', array() )
		->joinLeft( array('h'=>'activity_logs_history'), 'h.aid=l.id',
				   array('hid'=>'id', 'status',
						 'time_diff'=>"IF(h.status='ongoing' AND (h.id=l.current_hid OR l.current_hid=0), time_to_sec(timediff('{$this->to_date}',h.date_added)), h.time_diff)",
						 'activity_date'=>"(select date(h2.date_added) from activity_logs_history h2 where h2.aid=h.aid order by h2.id limit 1)",) )
		->where('l.userid IN (?)', $aUid)
		->where('l.reference = ?', 'client_managers');
		
		
		$select1->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
		$select2->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
		$select3->having("date(activity_date) >= date('{$this->from_date}') and date(activity_date) <= date('{$this->to_date}')");
		
		
		$union = $this->getDefaultAdapter()->select()
		->union( array( $select1, $select2, $select3, $select4, $select5) );
		
		$main_select = $this->select()
		->setIntegrityCheck(false)
		->from( array('sub' => $union), array('time_diff'=>"sum(time_diff)", 'activity_date', 'userid') )
		->group('sub.activity_date')
		->group('sub.userid')
		->order('sub.hid DESC');
		
		//echo '<br/>'.$main_select->__toString();
		$db = Zend_Db_Table::getDefaultAdapter();
		$stmt = $db->query($main_select);
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function act_users($userid = 0, $table = 'admin') {
		$now = date('Y-m-d');
		
		switch( $table) {
			case 'admin':
				$admin = $this->select()
				->setIntegrityCheck(false)
				->from( array('l'=>$this->_name), array('userid'=>"IF(a.userid is NULL, l.userid, a.userid )") )
				->joinLeft(array('a'=>'admin'), 'a.admin_id=l.userid', array('fname'=>'admin_fname', 'lname'=>'admin_lname', new Zend_Db_Expr('"admin" as type')))
				->joinLeft( array('p'=>'personal'), 'p.userid=a.userid', array() )
				->joinLeft(array('cj'=>'currentjob'), 'cj.userid=a.userid', array('latest_job_title'))
				->where('l.reference=?', 'admin')
				->where('a.admin_id != ?', $userid)
				->group('l.userid');
				
				$leads = $this->select()
				->setIntegrityCheck(false)
				->from( array('l'=>$this->_name), array('userid') )
				->joinLeft(array('c'=>'leads'), 'c.id=l.userid', array('fname', 'lname', new Zend_Db_Expr('"client" as latest_job_title, "Client" as type')))
				->where('l.reference=?', 'leads')
				->group('l.userid');
				
				$mgrs = $this->select()
				->setIntegrityCheck(false)
				->from( array('l'=>$this->_name), array('userid') )
				->joinLeft(array('c'=>'client_managers'), 'c.id=l.userid', array('fname', 'lname', new Zend_Db_Expr('"client" as latest_job_title, "Manager" as type')))
				->where('l.reference=?', 'client_managers')
				->group('l.userid');
				
				$staff = $this->select()
				->setIntegrityCheck(false)
				->from( array('l'=>$this->_name), array('userid') )
				->joinLeft(array('p'=>'personal'), 'p.userid=l.userid', array('fname', 'lname', new Zend_Db_Expr('"staff" as type')))
				->joinLeft(array('cj'=>'currentjob'), 'cj.userid=l.userid', array('latest_job_title'))
				->where('l.reference=?', 'personal')
				->group('l.userid');
				
				$union = $this->getDefaultAdapter()->select()
				->union( array($admin, $leads, $staff, $mgrs) );
				
				$select = $this->select()
				->setIntegrityCheck(false)
				->from( array('sub' => $union),
					   array('userid', 'fname', 'lname', 'type') )
				->group('sub.userid')
				->order('sub.fname')
				->order('sub.lname')
				->order('sub.userid');
				break;
			case 'leads':
			case 'client_managers':
				$select = $this->select()
				->setIntegrityCheck(false)
				//->from( array('l'=>$this->_name), array('userid') )
				->from( array('p'=>'personal'), array('userid', 'fname', 'lname', new Zend_Db_Expr('"staff" as type')) )
				->joinLeft(array('cj'=>'currentjob'), 'cj.userid=p.userid', array('latest_job_title'))
				->joinLeft(array('s'=>'subcontractors'), 'p.userid=s.userid', array() )
				->where('s.leads_id=?', $userid)
				->where('s.status = ?', 'ACTIVE')
				->order('p.fname')
				->order('p.lname')
				->group('p.userid');
				break;
			default:
				$staff = $this->select()
				->setIntegrityCheck(false)
				->from( array('l'=>$this->_name), array('userid') )
				->joinLeft(array('p'=>'personal'), 'p.userid=l.userid', array('fname', 'lname', new Zend_Db_Expr('"staff" as type')))
				->joinLeft(array('cj'=>'currentjob'), 'cj.userid=l.userid', array('latest_job_title'))
				->where('l.reference=?', 'personal')
				->where('p.userid == ?', $userid);
				break;
		}
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$stmt = $db->query($select);
		return $stmt->fetchAll();
	}
}
?>