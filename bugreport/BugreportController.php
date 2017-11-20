<?php
    /* $ BugReportController.php 2012-09-03 mike $ */
    
    class BugreportController {
        private $db = NULL;

        public static $admin = array();
        private $report_model;
        private $upload_path = "../uploads/bugs/";
        private $test_id;
        private $log;
        private $note;
        private $user_obj;
        
        public static $emailaddr;
        private $login_type;
        private $user_id;
        private $author;
        private $qausers;
        //private $user_home;
        
        private $ref_table;
        private $fileattach = array();
        private $resolutions = array('open','fixed','reopened','unable to reproduce','not fixable',
                                     'duplicate','suspended','won\'t fix', 'not a bug');

        public static $dbase = NULL;
        public $tests = Array();
        // constructor
        public function __construct($id = 1) {
            $this->db = $this::$dbase;
            
            $this->test_id = $id;
            
            $this->login_type = $_SESSION['logintype'];
            
            $this->log = new ReportLogs($this->db);
            $this->note = new ReportNotes($this->db);
            
            BugReports::$log = $this->log;
            $this->report_model = BugReports::getInstance($this->db);
            
            //$this->report_model->log = $this->log;
            
            $this->user_obj = new Users( array($this::$emailaddr, $this->login_type, 0) );
            
            $this->user_id = $this->user_obj->user_info['id'];
            $this->author = $this->user_obj->user_displayname();
            
            switch( $this->login_type ) {
                case 'admin':
                    $this->ref_table = 'admin.admin_id';
                    //$this->user_home = 'adminHome.php';
                    break;
                case 'client':
                    if( isset($_SESSION['clienttype']) && $_SESSION['clienttype'] == 'manager' )
                        $this->ref_table = 'client_managers.id';
                    else $this->ref_table = 'leads.id';
                    //$this->user_home = 'clientHome.php';
                    break;
                case 'staff': case 'jobseeker':
                    $this->ref_table = 'personal.userid';
                    if( $this->login_type == 'staff' ) $this->user_home = 'subconHome.php';
                    //else $this->user_home = 'applicantHome.php';
                    break;
                case 'business_partner':
                    $this->ref_table = 'agent.agent_no';
                    //$this->user_home = 'agentHome.php';
                    break;
            }
            
            //$this->qausers = new QAusers();

           // skills_test::$dbase = $this->db;
            //$this->test_model = skills_test::getInstance();
            if( $id ) {
            $sql = "SELECT id, test_name, test_duration, test_content, test_creation_date, test_status
            FROM typing_test WHERE id=".$this->test_id;
            
            
            $this->tests =  $this->db->fetchRow($sql);
            
            //for( $i=0, $len=count($this->tests); $i<$len; $i++ ) {
            $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $this->tests['test_content']);
            $str = preg_replace('/\\\/', '', $str);
            $str = str_replace("/\s+/", '&nbsp;', $str);
    
            $this->tests['test_content'] = $str;
            }
            //$this->tests[$i]['question_count'] = $this->test_question_count($this->tests[$i]['id']);
            //}
            
        }
        
        public function index($view_type) {
            //$user_email = 'remote.michaell@gmail.com';
            $current_date = date("Y-m-d");
            if($this->login_type == 'jobseeker' || $this->user_obj->user_info['leads_id'] != 11) {
                header("Location: /portal/bugreport/index.php?/reportform");
                exit;
            } elseif( $this->login_type == 'staff' && $this->user_obj->user_info['leads_id'] == 11 ) {
                // redirect to assigned ticket/s 2013-07-04
                header("Location: /portal/bugreport/?/view_all/".$this->user_obj->user_info['id']);
                exit;
            }
            
            
            View::$templ_dir = 'views';
            $view = new View('summary');

            $where = "i.status != 'deleted'";
            $where .= $assignto ? " AND i.assignto=".$assignto:"";
            
            $view->newtickets = $this->report_model->fetchAll("i.status = 'new'", array(), "i.id DESC");
            $view->resolved = $this->report_model->fetchAll("i.status = 'resolved'", array(), "i.id DESC");
            $view->updated = $this->report_model->fetchAll("i.status NOT IN ('new', 'resolved', 'deleted')", array(), "i.id DESC");
            
            $view->display();
        }
        
        public function reportform($view_type='full') {
            //$user_email = 'remote.michaell@gmail.com';
            $current_date = date("Y-m-d");
            //$test_object = skills_test::getInstance(0, 0);
            
            
            View::$templ_dir = 'views';
            $view = new View('bugform');

            $view->user_id = $this->user_id;
            $view->reporter = $this->author;
            $view->inhouse_staff = $this->user_obj->get_inhouse_list(11);
            $view->view_type = $view_type;
            //$view->user_home = $this->user_home;
            
            $view->display();
        }
        
        public function view_all($assignto = 0) {
            $args = array();
            
            $orderby = "i.severity DESC";
            $current_date = date("Y-m-d");
            $sort_order = "ASC";
            
            View::$templ_dir = 'views';
            
            if($this->login_type == 'jobseeker' || $this->user_obj->user_info['leads_id'] != 11
               || $assignto == -1) {
                $args['l.userid'] = $this->user_id;
                $args['l.ref'] = $this->ref_table;
                $args['l.field_update'] = "%report created%";
                $view = new View('mybugreport');
            }
            else {
                $qausers = new QAusers();
                $users = $qausers->fetchAll();
                foreach( $users as $k => $v ) unset($users[$k]['name']);
                
                $user_array = array('email'=>$this->user_obj->user_info['email'], 'userid'=>$this->user_id);
            
                if( !in_array($user_array, $users) && $assignto != $this->user_id ) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("User not found or permission denied.");';
                echo 'history.go(-1);';
                echo "</script></head><body></body></html>";
                exit;
                }
                $view = new View('buglist');
            }
            
            if( !empty($_POST['keyword']) ) {
                $args['keyword'] = Input::post('keyword');
            }
            
            $order_by = Input::get('orderby');
            $sort = Input::get('sort');
            
            if( $assignto != 'deleted' ) {
                $where = "i.status != 'deleted'";
                if( $assignto > 0 ) $where .= " AND i.assignto=".$assignto;
            } else {
                $where = "i.status = 'deleted'";
            }
            
            if( $order_by && $sort ) {
                $orderby = "$order_by $sort";
                
                $sort_order = $sort == 'ASC' ? 'DESC' : 'ASC';
            }
            
            //$where = "i.status != 'deleted'";
            //$where .= $assignto ? " AND i.assignto=".$assignto:"";
            
            $report_list = $this->report_model->fetchAll($where, $args, $orderby);
            
            
            
            
            $view->userid = $this->user_id;

            $view->reports = $report_list;
            $view->last = $this->log->lastUpdate();
            $view->first = $this->log->lastUpdate('min');
            
            $view->view_param = $assignto;
            $view->sort_order = $sort_order;
            //$view->qry_str = $_SERVER['QUERY_STRING'];

            $view->duration = (int)$this->tests['test_duration'] / 60;
            $view->display();
        }
        
        public function view_myreport() {
            $this->view_all(-1);
        }
        
        public function get_userinfo($userid) {
            $sql = $this->db->select()
				->from('personal', array('userid', 'fname', 'lname', 'email' ) )
					->where('userid = ?', $userid);
			return $this->db->fetchRow($sql);
        }
        
        public function create_report() {
            $button_name = Input::post('upload') ? Input::post('upload') : Input::post('new_update');
            
            //$id = Input::post('ticket_id');
            
            $diff_report = new BugReports($this->db);
            
            $link = Input::post('report_link');
            $severity = Input::post('severity');
            $title = Input::post('report_title');
            
            $steptorep = Input::post('steptorep');
            $actual_res = Input::post('actualresult');
            $expected_res = Input::post('expectedresult');
            $other_info = Input::post('otherinfo');
            $assign_to = Input::post('assignto');
            $staff_name = Input::post('staff_name');
            
            //$report_note = Input::post('report_note');
             
            $data_array = array('report_link' => $link, 'report_title' => $title, 'severity' => $severity,
                'steps_reproduce' => $steptorep, 'actual_result' => $actual_res, 'assignto' => $assign_to);
                
            
                
            $diff_report->report_check($data_array);
            $is_error = $diff_report->is_error;
            
            if( $is_error == "") {
                if( trim($expected_res) != "" ) $data_array['expected_result'] = $expected_res;
                if( trim($other_info) != "" ) $data_array['other_info'] = $other_info;
                
                if( $staff_name ) {
                    $assignto_ref = substr($staff_name, -7) == '(admin)' ? 'admin.admin_id' :
                        (substr($staff_name, -4) == '(bp)' ? 'agent.agent_no' : 'personal.userid');
                    $data_array['assignto_ref'] = $assignto_ref;
                }
                    
                $report_id = 0;
                    
                $admin = $this::$admin['admin_id'];
                
                
                $data_array['creation_date'] = date("Y-m-d H:i:s");
                $data_array['update_date'] = $data_array['creation_date'];

                $new_id = $diff_report->report_create($data_array, $this->user_obj->user_info['email']);

                if( $new_id ) {
                    if( isset($_POST['fileattach']) ) {
                        $attachment = Input::post('fileattach');
                        foreach( $attachment as $file ) {
                            $diff_report->save_attachment_path( array('report_id' => $new_id, 'file_name' => $this->user_id.'/'.$file,
                                                                      'file_submit_date' => $data_array['creation_date']) );
                        }
                    }
                    
                    // save notes
                    $this->add_note($new_id);
                    
                    
                    //insert log
                    $this->log->log_insert( array('report_id' => $new_id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                        'field_update' => serialize(array('Bug report created' => 'report #'.$new_id, 'update_date' => $data_array['creation_date'])) ) );
                            
                            
                    // handle file uploads
                    //$this->fileupload($new_id);
                    /*$send = $this->email_responder($new_id, array('severity'=>$severity, 'title'=>$title,
                    'reporter'=>$this->author, 'status'=>'New', 'link'=>$link, 'steptorep'=>$steptorep) );
                    */
                    $ticket_id = $new_id;
                }
                
                $is_error = $diff_report->is_error;
                
            }
            
            // RUN JAVASCRIPT TO UPDATE MAIN PAGE
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.createResult("'.$is_error.'");';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        public function view_details($id) {
            $diff_report = new BugReports($this->db, $id);
            View::$templ_dir = 'views';
            
            if($this->login_type == 'jobseeker' || $this->user_obj->user_info['leads_id'] != 11) {
                if($this->ref_table != $diff_report->report_info['ref'] && $this->user_id != $diff_report->report_info['userid']) {
                    echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                    echo 'window.parent.alert("Invalid id or permission denied.");';
                    echo 'history.go(-1);';
                    echo "</script></head><body></body></html>";
                    exit;
                }
                $view = new View('view_details_only');
                $qry_array = array();
                foreach($this->resolutions as $res) {
                    if($res != 'open') array_push($qry_array, "note_content LIKE '".addslashes($res).":%'");
                }
                $view->notes = $this->note->fetchAll("report_id=$id AND (".implode(' OR ', $qry_array).")");
            } else {
                $view = new View('view_details');
                $view->notes = $this->note->fetchAll("report_id=$id");
            }
            $view->report = $diff_report->report_info;
            //$view->inhouse_staff = $this->user_obj->get_inhouse_list(11);
            $view->status_array = array('assigned','reopened','resolved');
            //$view->last = $this->log->lastUpdate();
            //$view->first = $this->log->lastUpdate('min');
            //print_r($this->note->fetchAll("WHERE id=$id"));
            $view->referrer = $_SERVER['HTTP_REFERER'];
            

            //$view->duration = (int)$this->tests['test_duration'] / 60;
            $view->display();
        }
        
        public function edit_details($id) {
            $diff_report = new BugReports($this->db, $id);
            //$diff_report->log = $this->log;
            
            
            View::$templ_dir = 'views';
            $view = new View('edit_details');

            $view->report = $diff_report->report_info;
            $view->inhouse_staff = $this->user_obj->get_inhouse_list(11);
            $view->severity_array = array('low', 'medium', 'high', 'critical');
            $view->status_array = array('assigned','reopened','resolved');
            $view->resolution_array = $this->resolutions;
            //array('open','fixed','reopened','unable to reproduce','not fixable',
             //                               'duplicate','suspended','won\'t fix', 'not a bug');
            //$view->last = $this->log->lastUpdate();
            //$view->first = $this->log->lastUpdate('min');
            
            
            

            //$view->duration = (int)$this->tests['test_duration'] / 60;
            $view->display();
        }
        
        public function tester() {
            $action = Input::post('action');
            $userid = Input::post('userid');
            $email = Input::post('emailaddr');
            $staff_name = Input::post('staff_name');
            
            if($this->login_type != 'admin' && $this->user_obj->user_info['id'] != 6) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Permission denied.");';
                echo 'history.go(-1);';
                echo "</script></head><body></body></html>";
                exit;
            }
            
            if( $staff_name ) {
                if( substr($staff_name, -7) == '(admin)' )
                    $staff_name = str_replace("(admin)", "", $staff_name);
                elseif( substr($staff_name, -4) == '(bp)' )
                    $staff_name = str_replace("(bp)", "", $staff_name);
            }
            
            //$diff_user = new Users( array('', $this->login_type) );
            //if( !$staff_name ) {
            //    $diff_user = new Users( array($this::$emailaddr, $this->login_type) );
            //}

            View::$templ_dir = 'views';
            $view = new View('bugtester');
            //$view->last = $this->log->lastUpdate();
            //$view->first = $this->log->lastUpdate('min');
            $qausers = new QAusers();

            if( $action ) {
                switch( $action ) {
                    case 'add':
                        $qausers->user_insert(array('userid'=>$userid, 'email'=>$email, 'name'=>trim($staff_name)));
                        break;
                    case 'del':
                        $ticks = Input::post('tick');
                        foreach( $ticks as $id ) {
                            $qausers->user_delete($id);
                        }
                        break;
                }

                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.createResult("'.$err_msg.'");';
                echo "</script></head><body></body></html>";
                exit;
            }

            $view->users = $qausers->fetchAll();
            $view->display();
            
        }
        
        public function fileupload($report_id = 0) {
            //$fldname = Input::post($fld_var) ? Input::post($fld_var) : Input::get($fld_var);
            //$ticket_id = Input::post('ticket_id');
            
            $err_msg = '';
            $file_return = 0;
            $file_error = array(
                0 => "The file uploaded with success",
                1 => "The uploaded file exceeds the upload_max_filesize",
                2 => "The uploaded file exceeds the MAX_FILE_SIZE directive",
                3 => "The uploaded file was only partially uploaded",
                4 => "No file was uploaded",
                6 => "Missing a temporary folder");
            
            $upload_path = "../uploads/bugreport";

            if (!is_dir($upload_path)) {
                mkdir( $upload_path, 0755 );
                $handle = fopen( $upload_path ."/index.html", 'x+' );
                fclose( $handle );
            }
            
            if( $this->user_id ) {
                $upload_path = $upload_path . "/" . $this->user_id;
                if (!is_dir($upload_path)) {
                    mkdir( $upload_path, 0755 );
                    $handle = fopen( $upload_path ."/index.html", 'x+' );
                    fclose( $handle );
                }
            } else {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Invalid session or user not found.");';
                echo "</script></head><body></body></html>";
                exit;
            }
            
            $upload_path .= "/";
            
            foreach( $_FILES as $file ) {
                for ($i = 0; $i < count($file); $i++) {
                    if( $file['tmp_name'][$i] == "" ) continue;
                    $error_code = $file['error'][$i];

                    if( $file['tmp_name'][$i] != "" && $error_code == 0 ) {
                        $file_ext = strtolower(str_replace(".", "", strrchr($file['name'], ".")));
                        
                        $fname = $file['name'][$i];
                        
                        // sending file with spaces on filename resulted into zero-byte file
                        //$fname = str_replace(" ", "_", $fname);
                        $fname = preg_replace("/\s+/", "_", $fname);
                        $fname = str_replace("'", "", $fname); // single quote splitted the filename
                        
                        $fileID = str_replace('.', '', $fname);
                        
                        $file_dest = $upload_path . $fname;
                        
                        //if(!move_uploaded_file($file['tmp_name'], $file_dest)) {
                        if(!move_uploaded_file($file['tmp_name'][$i], $file_dest)) {
                            $err_msg = "Upload failed!";
                        } else {
                            
                            chmod($file_dest, 0666);
                            
                            $this->fileattach[] = $this->user_id . '/' . $fname;
                        }
                    } else {
                        if( trim($error_code) != "" ) $err_msg = $file_error[$error_code];
                    }
                }
                
            }
            if( !$report_id ) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo "window.parent.disable_button('new_report');";
                echo 'window.parent.createUploadResult("'.$err_msg.'","'.$fileID.'");';
                echo "</script></head><body></body></html>";
                exit;
            }

        }
        
        public function update_report() {
            $report_id = Input::post('report_id');
            
            $diff_report = new BugReports($this->db, $report_id);
            
            if( $diff_report->report_exists > 0 ) {
                $old_data = $diff_report->report_info;
            }
            
            $link = Input::post('report_link');
            $severity = Input::post('severity');
            $title = stripslashes(Input::post('report_title'));
            
            $steptorep = Input::post('steptorep');
            $actual_res = Input::post('actualresult');
            $expected_res = Input::post('expectedresult');
            $other_info = Input::post('otherinfo');
            $assign_to = Input::post('assignto');
            
            $status = Input::post('status');
            $resolution = Input::post('resolution');
            
            $staff_name = Input::post('staff_name');
            
            if( $staff_name ) {
                if( substr($staff_name, -7) == '(admin)' )
                    $assignto_ref = 'admin.admin_id';
                elseif( substr($staff_name, -4) == '(bp)' )
                    $assignto_ref = 'agent.agent_no';
                else $assignto_ref = 'personal.userid';
            }
            
            //print_r($_POST);
            //$severity_number = array('Low' => '1', 'Medium' => '2', 'High' => '3', 'Critical' => '4');
                
            $data_array = array('report_link' => $link, 'report_title' => $title, 'severity' => $severity,
                'steps_reproduce' => $steptorep, 'actual_result' => $actual_res,
                'status' => $status, 'resolution' => $resolution, 'assignto_ref' => $assignto_ref);
            
            if( $assign_to ) $data_array['assignto'] = $assign_to;
            
            $diff_report->report_check($data_array);
            $is_error = $diff_report->is_error;
            
            if( $is_error == "") {
                if( trim($expected_res) != "" ) $data_array['expected_result'] = $expected_res;
                if( trim($other_info) != "" ) $data_array['other_info'] = $other_info;
                    
                $admin = $this::$admin['admin_id'];
                
                
                //$data_array['creation_date'] = date("Y-m-d H:i:s");
                //$data_array['update_date'] = date("Y-m-d H:i:s");
                //print_r($data_array);
                
                
                /*unset($old_data['reporter']);
                unset($old_data['priority']);
                unset($old_data['filecnt']);
                unset($old_data['updated_by']);
                unset($old_data['files']);
                unset($old_data['assigned']);
                unset($old_data['id']);*/
                //print_r($old_data);

                $diff_report->report_update($report_id, $data_array);
                
                // add any note for resolution
                if( $resolution != 'open' && !empty($_POST['report_note']) ) {
                    $_POST['report_note'] = $resolution.': '.$_POST['report_note'];
                    $this->add_note($report_id);
                }
                
                $diff_array = array_diff_assoc($data_array, $old_data);
                
                unset($diff_array['assignto_ref']);

                if( count($diff_array) > 0) {
                    $diff_array['update_date'] = date("Y-m-d H:i:s");
                    if( !empty($diff_array['assignto'])) $diff_array['assignto'] .= " $assignto_ref";
                    //insert log
                    $this->log->log_insert( array('report_id' => $report_id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                    'field_update' => serialize($diff_array) ) );
                }
             
                // send auto-responder (this will work only if report is already assigned)
                //2013-07-04 $diff_report->send_autoresponder($report_id);
                
                $is_error = $diff_report->is_error;
                
            }
            
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.createResult("'.$is_error.'",'.$report_id.');';
            echo "</script></head><body></body></html>";
            exit;

        }
        
        public function upload_files() {
            
            $report_id = Input::post('id');
            $this->fileupload($report_id);
            //$attachment = Input::post('fileattach');

            if( count($this->fileattach) > 0 ) {
                $current_date = date("Y-m-d H:i:s");
                foreach( $this->fileattach as $file ) {
                    $this->report_model->save_attachment_path( array('report_id' => $report_id, 'file_name' => $file, 'file_submit_date' => $current_date) );
                    
                    $this->log->log_insert( array('report_id' => $report_id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                    'field_update' => serialize(array('attachment' => $file, 'update_date' => $current_date ))) );
                }
            }
            
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.createResult("'.$is_error.'",'.$report_id.');';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        public function add_note($id = 0) {
            $notestr = "";
            $report_id = $id > 0 ? $id : Input::post('id');
            $report_note = Input::post('report_note');
            if( trim($report_note) != "" ) {
                
                $current_date = date("Y-m-d H:i:s");
            
                $data_array = array('report_id' => $report_id, 'note_content' => $report_note,
                                    'note_submit_date' => $current_date, 'userid' => $this->user_id, 'ref' => $this->ref_table);
                
                $this->note->note_create($data_array);
                
                $notestr = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $report_note);
                $notestr = preg_replace('/\\\/', '', $notestr);
                
                if( !$id ) {
                    $this->log->log_insert( array('report_id' => $report_id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                    'field_update' => serialize(array('note' => $report_note, 'update_date' => $current_date ))) );
                }
            }
            
            if( !$id ) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.displayNote("'.date('Y-m-d H:i').'","'.$this->user_obj->user_info['fname'].'","'.$notestr.'");';
                echo "</script></head><body></body></html>";
                exit;
            }
        }
        
        public function assign_report() {
            $report_id = Input::post('report_id');
            $userid = Input::post('userid');
            
            if( !$userid ) exit;
            $result_array = array('result' => 'Failed');
            
            $diff_report = new BugReports($this->db, $report_id);
            
            $staff_name = Input::post('staff_name');
            if( substr($staff_name, -7) == '(admin)' )
                $assignto_ref = 'admin.admin_id';
            elseif( substr($staff_name, -4) == '(bp)' )
                $assignto_ref = 'agent.agent_no';
            else $assignto_ref = 'personal.userid'; 

            if( $diff_report->report_assignto($report_id, $userid, $assignto_ref) ) {
                //2013-07-04 $diff_report->send_autoresponder($report_id);
                
                if( $diff_report->report_info['status'] != 'assigned' ) {
                    // set status to 'assigned'
                    $diff_report->report_set_status($report_id, 'assigned');
                    $result_array['status'] = 'assigned';
                    $result_array['result'] = 'Ok';
                }
                
                // log test status
                $this->log->log_insert( array('report_id' => $report_id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                    'field_update' => serialize(array('assignto' => $userid.' '.$assignto_ref, 'update_date' => date("Y-m-d H:i:s") ))) );
                
                echo json_encode($result_array);
            }
            
            
        }
        
        public function set_status() {
            $report_id = Input::post('report_id');
            $status = Input::post('status');
            
            if( !$status ) exit;
            
            $this->report_model->report_set_status($report_id, $status);
            
            // log test status
            $this->log->log_insert( array('report_id' => $report_id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                'field_update' => serialize(array('status' => $status, 'update_date' => date("Y-m-d H:i:s") ))) );
            
            echo json_encode(array('result' => ucfirst($status) ));
        }
        
        public function delete_multiple() {
            $ticks = Input::post('tick');
            foreach( $ticks as $id ) {

                $diff_report = new BugReports($this->db, $id);
                if( $diff_report->report_exists > 0 ) {
                    $diff_report->report_delete($id);
                    
                    $this->log->log_insert( array('report_id' => $id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                    'field_update' => serialize(array('report#'.$id => 'Mark as deleted', 'update_date' => date("Y-m-d H:i:s") ))) );
                }
            }
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.createResult("'.$err_msg.'");';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        public function delete_report($id) {
            //$status = Input::post('status');
            //$this->report_model->report_set_status($report_id, $status);
            $diff_report = new BugReports($this->db, $id);
            if( $diff_report->report_exists > 0 ) {
                if( $diff_report->report_delete($id) ) {
                    $this->log->log_insert( array('report_id' => $id, 'userid' => $this->user_id, 'ref' => $this->ref_table,
                    'field_update' => serialize(array('report#'.$id => 'Mark as deleted', 'update_date' => date("Y-m-d H:i:s") ))) );
                    
                    header("Location: ".$_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            
            //echo json_encode(array('result' => ucfirst($status) ));
        }
        
        public function historylist() {
            $report_id = Input::post('report_id');
            $history = $this->log->fetchHistory($report_id);
            echo json_encode($history);
        }
        
        private function email_responder($id, $data) {
            $severity = $data['severity'];
            $title = stripslashes($data['title']);
            $status = $data['status'];
            $reporter = $data['reporter'];
            $link = $data['link'];
            $steps = nl2br(htmlspecialchars($data['steptorep']));
            $steps = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $steps);
            $steps = stripslashes($steps);
            // EMAIL BODY
        $emailtpl =	"<p>#$id: $title</p>
            <table border='0' cellspacing='3' cellpadding='0'>
            <tr><td style='font-weight:bold'>Reporter </td><td>$reporter</td></tr>
            <tr><td style='font-weight:bold'>Priority </td><td>$severity</td></tr>
            <tr><td  style='font-weight:bold'>Status </td><td>$status</td></tr>
            <tr><td  style='font-weight:bold'>Link </td><td>$link</td></tr>
            </table><br/><strong>Steps to reproduce:</strong><br/>
            $steps<br/><p>
            Click <a href='http://".$_SERVER['HTTP_HOST']."/portal/bugreport/?/view_details/$id'>here</a> for more information,
            or you may login to admin <a href='www.remotestaff.com.au/portal/'>portal</a> and select Bug Report link.<br/>
            </p><br/>".
            "This is auto-generated email.";
            
            $qausers = new QAusers();
            $users = $qausers->fetchAll();
            $to_emails = array();
            foreach( $users as $k => $v ) {
                array_push($to_emails, $v['email']);
            }
            
            $subject = "[RS Bug Report] #$id: $title";
            
            $utils = Utils::getInstance();
            
            $utils->send_email($subject, $emailtpl, $to_emails, 'Bug Report Notification', false); 

        }
        
    }