<?php

/* Users class*/
class Users {
    private $db;

    private $leads_id;
	
	public $user_info;
	public $user_exists;
	public $error;
	private $login_type;
	private $aliasid;
	private $last_login;
	private $inhouse_leadid;
	public static $dbase = NULL;
	
	private static $instance = NULL;
	
	// return Singleton instance
	public static function getInstance( $unique = array('', 'staff', 0) ) {
		if (self::$instance === NULL) {
			self::$instance = new self($unique);
		}
        return self::$instance;
    }
    
    function __construct($unique = array('', 'staff', 0), $where = "") {

		//if( !isset($this->db) )
		$root_dir = dirname(dirname(dirname(__FILE__)));
		//echo dirname(__FILE__).'<';
		//if (HOME_DIR) include HOME_DIR."/portal/conf/zend_smarty_conf.php";
		//include $root_dir."/portal/conf/zend_smarty_conf.php";
        $this->db = $this::$dbase;//$db;
		
		$this->inhouse_leadid = 11;
		$this->error = '';
		$this->user_exists = 0;
		$this->user_info['id'] = 0;
		$this->aliasid = 0;
		$this->login_type = '';
		$this->last_login = strtotime("-365 days",date(time())); //2012-02-02 - from 120 to 365
		
		if($unique[0] != '' || $unique[2] > 0) {
			
			$user_email = strtolower($unique[0]);
			$this->login_type = $unique[1];
			$userid = !empty($unique[2]) ? $unique[2] : 0;
					
			$sql_array = array();
			
			/* replaced the query by zend db select()- 2013-06-11 */
			switch ($this->login_type) {
				case 'admin':
					if( $this->login_type == 'adhoc' ) $pfix = 'as';
					$query = $this->db->select()
					->from(array('p'=>'admin'),
						array('id'=>'admin_id', 'fname'=>'admin_fname', 'lname'=>'admin_lname', 'email'=>'admin_email', 'pword'=>'admin_password'))
					->columns(array('leads_id' => new Zend_Db_Expr($this->inhouse_leadid)))
					->where("p.admin_email='$user_email' OR p.admin_id=$userid" )
					->where("p.admin_id != 0")->where("p.admin_email != ''");
					break;
				
				case 'jobseeker':
				case 'adhoc':
				case "staff":
					$pfix = 'js';
					if( $this->login_type == 'adhoc' ) $pfix = 'as';
					$query = $this->db->select()
					->from(array('p'=>'personal'),
						array('id'=>'userid', 'fname', 'lname', 'email', 'image', 'gender', 'country_id', 'handphone_no','password'=>'pass'))
					->joinLeft(array('s'=>'subcontractors'), 's.userid=p.userid', array('leads_id') )
					->where("p.email='$user_email' OR p.userid=$userid")
					->where("p.userid != 0")->where("p.email != ''");
					
					if( $this->login_type == 'staff' )
						$query->where("s.status='ACTIVE'");
					break;
				
				case "business_partner":
					$query = $this->db->select()
					->from(array('p'=>'agent'),
						array('id'=>'agent_no', 'fname', 'lname', 'email', 'password'=>'agent_password'))
					->columns(array('leads_id' => new Zend_Db_Expr($this->inhouse_leadid)))
					//->joinLeft(array('s'=>'subcontractors'), 's.userid=p.userid', array('leads_id') )
					->where("p.email='$user_email' OR p.agent_no=$userid")
					->where("p.agent_no != 0")->where("p.email != ''");
					
					break;
				
				case "client":
				case 'leadrfi':
					if( $_SESSION['clienttype'] == 'manager' ) {
						$query = $this->db->select()
						->from(array('p'=>'client_managers'),
							array('id', 'fname', 'lname', 'email', 'leads_id', 'password'))
						->where("p.email='$user_email' OR p.id=$userid" )
						->where("p.id != 0")->where("p.email != ''");
					} else {
						$query = $this->db->select()
						->from(array('p'=>'leads'),
							array('id', 'fname', 'lname', 'email', 'leads_id' => 'id', 'password'))
						->where("p.email='$user_email' OR p.id=$userid" )
						->where("p.id != 0")->where("p.email != ''");
					}
					break;
				
			}
			$this->user_info = $this->db->fetchRow($query);

			if( $this->user_info['id'] > 0 ) {
				$this->user_exists = 1;
			}
		
		}
    }
	
	public function user_displayname() {
		if( $this->user_info['display_name'] ) $display = $this->user_info['display_name'];
		else if( $this->user_info['fname'] ) $display = $this->user_info['fname'] .' '. $this->user_info['lname'];
		return $display;
	}
	
	
	public function staff_name_position() {
		$select = $this->db->select()
		->from( array("a" => "{$this->service_type}_aliases"), array() )
		->joinLeft( array('j' => 'staff_job_position'), "a.staff_job_position_id=j.id", array('job_position') )
		->where('a.id = ?', $this->aliasid);
		
		return array('fname'=>$this->staff_info[fname], 'position'=>$this->db->fetchOne($select));
	}
	
	// 2012-01-17 - set $lead_id to deprecated
	public function get_inhouse_list($lead_id=0, $userid=0, $adhoc=0) {
		$lead_id = Input::post('lid');
		$userid = Input::post("userid");
		$adhoc = Input::post("adhoc");
		
		if( $this->user_info['leads_id'] != $this->inhouse_leadid ) return 0;
		
		$query = "SELECT * FROM (
			SELECT admin_id userid, concat(admin_id,'ad') chatid, admin_fname fname, concat(admin_lname,' (adm)') lname, admin_email email, ctry.printable_name country, status, users.display_name, 
			
			if ( users.send_notice is not null, users.send_notice, 1) as send_notice, 
			users.job_title, users.contact_no contactno, users.gender, 
			users.image_path image,
			11 as leads_id, users.chat_status, users.online, users.custom_status, users.tstamp
			FROM admin LEFT JOIN rschat_users users ON concat(admin.admin_id,'ad')=users.chatid 
			LEFT JOIN country ctry ON users.country=ctry.iso
			WHERE status <> 'REMOVED' AND status<>'PENDING' AND admin_id<>".$this->user_info['id'];
			
			//if ($userid) $query .= " AND admin_id<>". $userid;
			$query .= " GROUP BY admin.admin_email 
			
			UNION ALL
			
			SELECT s.userid, concat(s.userid,'sc') chatid, p.fname, p.lname, p.email, ctry.printable_name country, 
			s.status, u.display_name,  if ( u.send_notice is not null, u.send_notice, 1) as send_notice,
			if(u.job_title is not null, u.job_title, cj.latest_job_title) job_title, 
			
			if(p.handphone_no is not null, p.handphone_no, u.contact_no) contactno,
			if(p.gender is not null, p.gender, u.gender) gender,
			if(u.image_path is not null, u.image_path, p.image ) image,
			 s.leads_id, u.chat_status, u.online, u.custom_status, u.tstamp
			 FROM subcontractors s LEFT JOIN personal p ON s.userid=p.userid
			 LEFT JOIN currentjob cj ON cj.userid=p.userid LEFT JOIN leads l ON s.leads_id=l.id
			 LEFT JOIN rschat_users u ON concat(s.userid,'sc')=u.chatid
			 LEFT JOIN country ctry ON u.country=ctry.iso WHERE s.status='ACTIVE'
			 AND p.email IS NOT NULL AND s.leads_id=11
			AND s.userid<>".$this->user_info['id'];
			 
			 $query .= " GROUP BY p.email
			 
			UNION ALL
			SELECT agent_no userid, concat(agent_no,'bp') chatid, fname, concat(lname,' (bp)') lname, email, 
			ctry.printable_name country, status, users.display_name, 
			if ( users.send_notice is not null, users.send_notice, 1) as send_notice, 
			users.job_title, users.contact_no contactno, users.gender, 
			users.image_path image, 11 as leads_id, users.chat_status, users.online, 
			users.custom_status, users.tstamp 
			FROM agent LEFT JOIN rschat_users users 
			ON concat(agent_no,'bp')=users.chatid 
			LEFT JOIN country ctry ON users.country=ctry.iso 
			WHERE status='ACTIVE' AND work_status='BP' AND agent_no<>".$this->user_info['id'];
			
			$query .= " GROUP BY email ";
			
		$query .=	") as list
		GROUP BY list.email, list.lname
		ORDER BY list.fname, list.lname ASC";
		//ORDER BY list.online DESC, list.fname, list.lname ASC,  list.tstamp DESC";

		return $this->db->fetchAll($query);
	}
	
	/* GET STAFF LIST*/
	public function staff_list($lead_id=0, $userid=0, $adhoc=0) {
		$lead_id = Input::post('lid');
		$userid = Input::post("userid");
		$adhoc = Input::post("adhoc");
		if( $adhoc ) {
			$query = "SELECT ah.ah_active, u.userid, u.fname, u.lname, u.image,u.email,u.handphone_no, "
				. "rs.chatid, rs.image_path image, rs.online, rs.chat_status, rs.display_name, rs.date_added, rs.job_title "
				. "FROM as_staff ah LEFT JOIN personal u ON ah.userid=u.userid "
				. "LEFT JOIN subcontractors s ON s.userid = u.userid "
				. "LEFT JOIN rschat_users rs ON s.userid=rs.userid "
				. "WHERE (SUBSTRING(rs.chatid, -2)='sc' OR SUBSTRING(rs.chatid, -2)='js') "
				. "AND s.status = 'ACTIVE' AND ah.ah_active='1' GROUP BY u.userid ORDER BY fname";
				
			$staff_array = $this->db->fetchAll($query);
			
		} else {
			//$date_interval = strtotime("{$hours} hours", date(time()) );
			//$date_from = strtotime("-60 days",date(time()));
			
			if( $this->login_type != 'admin' && $this->user_info['leads_id'] )
				$lead_id = $this->user_info['leads_id'];
			
			$query = "SELECT s.userid, if(u.chatid IS NULL, concat(s.userid,'sc'), u.chatid) chatid, s.date_contracted, p.lname, p.fname, p.email, "
			. "ctry.printable_name country, u.display_name, u.custom_status, "
			. "if(u.job_title is not null, u.job_title, cj.latest_job_title) job_title, "
			. "if(p.handphone_no is not null, p.handphone_no, u.contact_no) contactno, "
			. "s.leads_id, if(p.gender is not null, p.gender, u.gender) gender, "
			. "if (u.image_path is not null, u.image_path, p.image ) image, "
			. "l.fname c_fname, l.lname c_lname, if ( u.send_notice is not null, u.send_notice, 1) as send_notice, "
			. "u.chat_status, u.online "
			. "FROM subcontractors s LEFT JOIN personal p ON s.userid=p.userid "
			. "LEFT JOIN currentjob cj ON cj.userid=p.userid "
			. "LEFT JOIN leads l ON s.leads_id=l.id "
			. "LEFT JOIN rschat_users u ON s.userid=u.userid "
			. "LEFT JOIN country ctry ON u.country=ctry.iso "
			. "WHERE s.status='ACTIVE' AND p.email IS NOT NULL ";//AND u.chatid IS NOT NULL "
			//. "AND unix_timestamp(u.tstamp) >='{$this->last_login}'";
			 
			if ($lead_id) $query .= " AND s.leads_id IN (".$lead_id.")";
		
			if ($userid) $query .= " AND s.userid<>". $userid;
			
			// quick way to deny listing of subcon for specific client
			if ($lead_id == 7539 && $this->login_type != 'client') $query .= " AND s.leads_id is NULL";
					
			$query .= " GROUP BY p.email ORDER BY u.online DESC, p.fname, p.lname ASC, u.tstamp DESC";
			
			$staff_array = $this->db->fetchAll($query);
		
		}
		return $staff_array;
	}
	
	/* GET ADMIN LIST*/
	public function admin_list($admin_id=0, $sortbyname='', $online=0) {
		
		$query = "SELECT admin_id userid, concat(admin_id,'ad') chatid, admin_fname fname, admin_lname lname, admin_email email, status, "
		. "users.display_name, if ( users.send_notice is not null, users.send_notice, 1) as send_notice, users.online, "
		. "users.chat_status, users.image_path image, users.gender, users.job_title, users.contact_no contactno, users.custom_status "
		. "FROM admin LEFT JOIN rschat_users users ON concat(admin.admin_id,'ad')=users.chatid "
		. "WHERE status <> 'REMOVED' AND status<>'PENDING' AND users.chatid IS NOT NULL "
		. "AND unix_timestamp(u.tstamp) >='{$this->last_login}'";
		
		if ($online) $query .= " AND c.session_status = 'Start'";
		
		if ($admin_id) $query .= " AND admin_id<>". $admin_id;
		
		$query .= " GROUP BY admin.admin_email ";
		
		if ($sortbyname) $query .= "ORDER BY admin_fname, admin_lname ASC";
		else $query .= "ORDER BY users.online DESC, admin_fname, admin_lname ASC, users.tstamp DESC"; //users.tstamp DESC, admin_fname, admin_lname ASC";

		echo json_encode( $this->db->fetchAll($query) );
	}
	
	
	/* client list */
	public function get_client($leads_id=0, $agent_no=0, $subcon_no=0) {
		$leads_id = Input::post('lid');
		$agent_no = Input::post("bpID");
		$subcon_no = Input::post("scID");
		
		if ($agent_no) {
			if( ($this->login_type != 'business_partner' || $agent_no != $this->user_info['id'])
			   && $this->login_type != 'admin' ) return 0;
			
				$join_tbl = "LEFT JOIN agent a ON a.agent_no=p.business_partner_id ";
				$join_cond = " AND p.business_partner_id=".$agent_no;
			
		} elseif ($subcon_no) {
			if( (!in_array($this->login_type, array('jobseeker', 'adhoc', 'staff')) ||
				$subcon_no != $this->user_info['id']) && $this->login_type != 'admin' ) return 0;
			
				$join_tbl = "LEFT JOIN subcontractors s ON s.leads_id=p.id ";
				$join_cond = " AND s.status='ACTIVE' AND s.userid=".$subcon_no;
		} else {
			if( $this->login_type == 'client' ) return 0;
		}
		
		$query = "SELECT p.id userid, concat(p.id,'cl') chatid, p.fname, p.lname, p.email, p.company_name, p.company_position, "
		. "if ( u.send_notice is not null, u.send_notice, 1) as send_notice, u.online, "
		. "p.officenumber, u.chat_status, u.gender, u.display_name, u.custom_status,"
		. "u.country, u.job_title, if(p.mobile is not null,p.mobile, u.contact_no) contactno, u.image_path image "
		. "FROM leads p LEFT JOIN rschat_users u ON concat(p.id,'cl')=u.chatid "
		. $join_tbl
		. "WHERE p.status='Client' AND u.chatid IS NOT NULL "
		. "AND unix_timestamp(u.tstamp) >='{$this->last_login}'";
		
		if ($leads_id) $query .= " AND p.id=".$leads_id;
			 
		$query .= $join_cond;
					
		$query .= " GROUP BY p.email ORDER BY u.online DESC, p.fname ASC, u.tstamp DESC";
		
		echo json_encode( $this->db->fetchAll($query) );
			 
	}
	
	/* bp list */
	public function get_bp($agent_no = 0) {
		$query = "SELECT p.agent_no userid, concat(p.agent_no,'bp') chatid, p.fname, p.lname, p.email, "
		. "p.companyname, p.companyposition, u.display_name, "
		. "u.chat_status, u.gender, u.online, u.custom_status, "
		. "u.country, u.job_title,  u.contact_no contactno, u.image_path image "
		. "FROM agent p LEFT JOIN rschat_users u ON concat(p.agent_no,'bp')=u.chatid "
		. "WHERE p.status='ACTIVE' AND work_status='BP'";
		
		if ($agent_no) $query .= " AND p.agent_no=".$agent_no;
			   
		$query .= " GROUP BY p.email ORDER BY u.online DESC, p.fname ASC, u.tstamp DESC";
		
		return $this->db->fetchAll($query);
		
	}
	
	public function applicant_online() {
		$query = "SELECT rs.chatid, p.userid, o.tstamp, o.last_sender, o.user_ipaddr, o.remote_host,
			rs.image_path image, rs.online, rs.chat_status, rs.display_name, p.fname, p.lname, p.email
			FROM rschat_users rs LEFT JOIN personal p ON rs.userid=p.userid
			LEFT JOIN rschat_online o ON rs.conn_id=o.userid
			WHERE SUBSTRING(rs.chatid, -2)='js' AND rs.online='1'
			GROUP BY p.email ORDER BY rs.online DESC, p.fname, p.lname ASC, rs.tstamp DESC";
			
		echo json_encode( $this->db->fetchAll($query) );
	}
	
	public function login($email, $password, $fbid = 0, $field_name = 'userid') {
		//$user = new self( array(0, $email) );
		
		$user_passwd = sha1($password);
		
		// SHOW ERROR IF NO USER ROW FOUND
		if($this->user_exists == 0)
			  $this->error = 'User does not exist.';
		elseif( trim($email) == "" || $email != $this->user_info['email'] )
			  $this->error = 'Invalid email address.';
		// VALIDATE PASSWORD
		elseif( (trim($password) == "" || $user_passwd != $this->user_info['password']) && $fbid == 0 )
			  $this->error = 'Invalid password.';
		elseif( $fbid > 0 && $fbid != $this->facebook_id() )
			$this->error = 'Invalid Facebook ID';
		else {
			//$login_result = TRUE;
			//update last login, etc.
			$_SESSION[ $field_name ] = $this->user_info['id'];
            $_SESSION['emailaddr'] = $email;
			$_SESSION['logintype'] = $this->login_type;
		}
	}
	
	public function logout() {
		$this->error = '';
		$this->user_exists = 0;
		$this->user_info = array();
		session_destroy();
		
		$clear_this_id = $this->login_type == "admin" ? 'admin_id' :
                ( $this->login_type == "client" ? 'client_id' :
				( $this->login_type == "business_partner" ? 'agent_id' : 'userid') );
				
		$_SESSION[$clear_this_id] = "";
		$_SESSION['emailaddr'] = "";
	}
	
	public function trial_staff() {
		$clientid = Input::post('clientid') ? Input::post('clientid') : Input::get('clientid');
		$uid = Input::post('uid') ? Input::post('uid') : Input::get('uid');
			
		$query = "SELECT u.chatid, p.userid, ctry.printable_name country, m.leads_id,
		if(u.display_name is not null and u.display_name<>'', u.display_name, p.fname) name,
		u.chat_status, u.online, if(u.job_title is not null, u.job_title, cj.latest_job_title) job_title, if(p.gender is not null, p.gender, u.gender) gender, if (u.image_path is not null, u.image_path, p.image ) image
		FROM member_staff s
		LEFT JOIN tb_request_for_interview i ON i.id=s.tb_request_for_interview_id
		LEFT JOIN personal p ON p.userid=i.applicant_id LEFT JOIN member m ON m.id=s.member_id
		LEFT JOIN ( SELECT userid, display_name, chatid, chat_status, online, job_title, image_path, gender, tstamp
		FROM rschat_users ORDER BY tstamp DESC ) u ON u.userid=p.userid
		LEFT JOIN currentjob cj ON cj.userid=p.userid
		LEFT JOIN country ctry ON ctry.iso=p.country_id WHERE m.leads_id IN ({$clientid}) AND s.active='Y'";
			
		if( $uid ) $query .= " AND p.userid != $uid";

		echo json_encode( $this->db->fetchAll($query . " GROUP BY p.userid") );
	}
	
	public function trial_member() {
		$uid = Input::post('uid') ? Input::post('uid') : Input::get('uid');
			
		$query = "SELECT u.chatid, m.leads_id userid, m.leads_id, p.company_name, p.leads_country country,
		p.company_position job_title, if(u.display_name is not null and u.display_name<>'', u.display_name, p.fname) name,
		u.chat_status, u.online, u.gender, u.image_path image
		FROM member m LEFT JOIN member_staff s ON s.member_id=m.id
		LEFT JOIN tb_request_for_interview i ON i.id=s.tb_request_for_interview_id
		LEFT JOIN leads p ON p.id=m.leads_id
		LEFT JOIN ( SELECT userid, display_name, chatid, chat_status, online, job_title, image_path, gender, tstamp
		FROM rschat_users ORDER BY tstamp DESC ) u ON u.userid=m.leads_id
		WHERE i.applicant_id=$uid AND s.active='Y' GROUP BY m.leads_id";

		echo json_encode( $this->db->fetchAll($query) );
	}
    public function testEmail($emailaddr) {
        return ( trim($emailaddr)==trim($this->user_info['email']) ) ? 1 : 0;
    }
	
	public function user_create($tablename, $data = array()) {
		$this->error = '';
		$fname = $data['fname'];
		$lname = $data['lname'];
		$email = $data['email'];

		if( trim($fname) == "" || trim($lname) == "" || trim($email) == "" ) {
			$this->error = 'Required fields must not be empty';
			return 0;
		}
		
		try {
			$this->db->insert($tablename, $data);
			return $this->db->lastInsertId($tablename);
		}catch (Exception $e){
			$this->error = $e->getMessage();
		}
		return 0;
	}
	
	public function facebook_id($fbid = 0) {
		if( $fbid > 0 ) {
			try {
				$this->db->update('personal', array('facebook_id'=>$fbid), 'userid='.$this->user_info['id']);
				return $fbid;
			} catch (Exception $e) {
				$this->error = $e->getMessage();
				return 0;
			}
			
		} else {
			$sql = $this->db->select()->from( array('p'=>'personal'), array('facebook_id') )
			->where('userid=?',$this->user_info['id']);
			return $this->db->fetchOne($sql);
		}
    }
}

?>