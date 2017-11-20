<?php

    /* $ TicketController.php 2012-04-08 mike $ */
    //include_once('./lib/class_xls.php');
    
    class TicketController {
        private $db = NULL;
        private $schedule_model = NULL;
        public static $admin = array();
        private $types;
        private $clientstaff;
        private $file_upload;
        private $comm;
        private $utils;
        private $log;
        private $day_priority = array(
            array('count' => 1, 'label' => 'First day resolution'), array('count' => 2, 'label' => '1 to 2 Days to Solve'),
            array('count' => 5, 'label' => '3 to 5 Days to Solve'), array('count' => 7, 'label' => 'Over 1 Week to Solve'),
            array('count' => 14, 'label' => 'Over 2 Weeks to solve'), array('count' => 22, 'label' => 'Over 1 Month to solve') );
        private $accounts_ids = array(165, 203, 219, 273, 294, 329, 364, 373, 375, 374, 406, 419);
        
        // constructor
        public function __construct() {
            $this->db = config::$db_conf;

            //$this->ticket_model = ticketInfo::getInstance($this->db);
            $this->types = TicketTypes::getInstance($this->db);
            $this->clientstaff = TicketClientStaff::getInstance($this->db);
            $this->file_upload = TicketFileUploads::getInstance($this->db);
            $this->comm = TicketCommunications::getInstance($this->db);
            
            $this->utils = Utils::getInstance();
            $this->utils->db = $this->db;
            
            $this::$admin = $this->utils->check_admin_session();
            
            $this->log = new TicketLogs($this->db);
            
            $this->clientstaff->log = $this->log;
        }
        
        public function index($view_type) {
            $leads = 0;
            $userid = 0;
            
            //$prioritylevel = 'Priority Level';
            
            $current_date = date("Y-m-d");
            if( !$view_type ) $view_type = 'open';
            //$users_model = new SeminarUsers($this->db);
            if( !empty($_SESSION['referer']) ) unset($_SESSION['referer']);
            
            $method = $_SERVER['REQUEST_METHOD'];
            if( $method == 'POST' ) {
                $params = $_POST;
                $leads = Input::post('leads_id');
                $userid = Input::post('userid');
            } else {
                $params = $_GET;
                $leads = Input::get('leads_id');
                $userid = Input::get('userid');
            }
            
            /*if( isset($_GET['leads_id']) ) {
                $leads = Input::get('leads_id');
                $_POST['leads_id'] = $leads;
            } elseif( isset($_POST['leads_id']) ) {
                $leads = Input::post('leads_id');
            }
            
            if( isset($_GET['userid']) ) {
                $userid = Input::get('userid');
                $_POST['userid'] = $userid;
            } elseif( isset($_POST['userid']) ) {
                $userid = Input::post('userid');
            }*/
            
            
            
            $view_status = $this->db->quote($view_type);
            
            $where = "ticket_status=".$view_status;
            
            switch( $view_type ) {
                case 'closed':
                    $where .= " OR ticket_status='Resolved'";
                    break;
                case 'all':
                    $where = "ticket_status!='deleted' AND ticket_status!=''";
                    break;
                case 'prioritylevel':
                    $pday = $_GET['day'];
                    $where = 'day_priority='.$this->db->quote($pday, 'INTEGER');
                    
                    $prioritylevel_arr =
                        array('1' => '1 Day', '2' => '1 to 2 Days', '5' => '3 to 5 Days', '7' => 'Over 1 Week',
                            '14' => 'Over 2 Weeks', '22' => 'Over 1 Month');
                    //$prioritylevel = $prioritylevel_arr[$pday]. ' Priority';
                    break;
            }
            //if( $view_type == 'closed' ) $where .= " OR ticket_status='Resolved'";
            //elseif( $view_type == 'all' ) $where = "ticket_status!='deleted' AND ticket_status!=''";
            
            
            
            
            $tab = Input::get('tab') ? Input::get('tab') : (Input::post('tab') ? Input::post('tab') : '0');
            
            $ticket_model = new TicketInfo($this->db);
            $ticket_model->log = $this->log;

            $ticket_array = $ticket_model->fetchAll($where, $params);
            
            $update = $this->log->fetchAll($where);
            
            
            
            $view = new View('ticket_main');
            //print_r($ticket_array);
            //$view->days = array(1'2', '3');
            $view->types = $this->types->fetch_all();
            $view->ticket_info = $ticket_array;
            //$view->title = 'ticket Management - CSRO';
            //$view->heading = 'Admin Reports';
            $view->history = $update;
            $view->tab = $tab;
            $view->status = $view_type;
            $view->filter = $params;
            
            $view->suser = ($this::$admin['admin_id'] == 6) ? 1 : 0;
            
            
            $view->leads = $leads;
            $view->userid = $userid;
            
            $view->csro_array = $ticket_model->admin_get("csro='Y'"); //csro_list();
            
            $view->accounts_array = $ticket_model->admin_get("admin_id IN (".implode(',', $this->accounts_ids).")"); //accounts_list($this->accounts_ids);
            $view->day_priority = $this->day_priority;
            //$view->prioritytab = $prioritylevel;
            
            if( !empty($_POST['from_age']) ) $view->from_age = $_POST['from_age'];
            if( !empty($_POST['to_age']) ) $view->to_age = $_POST['to_age'];
             
            $view->display();
        }
        
        public function reports() {
            $leads = 0;
            $userid = 0;
            
            //$prioritylevel = 'Priority Level';
            
            $current_date = date("Y-m-d");
            if( !$view_type ) $view_type = 'open';
            //$users_model = new SeminarUsers($this->db);
            if( !empty($_SESSION['referer']) ) unset($_SESSION['referer']);
            
            if( isset($_GET['leads_id']) ) {
                $leads = Input::get('leads_id');
                $_POST['leads_id'] = $leads;
            } elseif( isset($_POST['leads_id']) ) {
                $leads = Input::post('leads_id');
            }
            
            if( isset($_GET['userid']) ) {
                $userid = Input::get('userid');
                $_POST['userid'] = $userid;
            } elseif( isset($_POST['userid']) ) {
                $userid = Input::post('userid');
            }
            
            if( empty($_POST['ticket_date1']) ) {
                $_POST['ticket_date1'] = date('Y-m-d');
                $_POST['ticket_date2'] = date('Y-m-d');
            }
            
            $ticket_model = new TicketInfo($this->db);
            $ticket_model->log = $this->log;

            $ticket_counts = $ticket_model->reports_count($_POST);
            
            //$update = $this->log->fetchAll();
            $view = new View('ticket_report');

            $view->types = $this->types->fetch_all();
            $view->ticket_counts = $ticket_counts;
            //$view->title = 'ticket Management - CSRO';
            //$view->heading = 'Admin Reports';
            //$view->tab = $tab;
            //$view->status = $view_type;
            $view->filter = $_POST;
            
            $view->suser = ($this::$admin['admin_id'] == 6) ? 1 : 0;
            
            
            $view->leads = $leads;
            $view->userid = $userid;
            
            $view->csro_array = $ticket_model->admin_get("csro='Y'"); //csro_list();
            
            $view->accounts_array = $ticket_model->admin_get("admin_id IN (".implode(',', $this->accounts_ids).")"); //accounts_list($this->accounts_ids);
            $view->day_priority = $this->day_priority;
            $view->reports = true;
            
            if( !empty($_POST['from_age']) ) $view->from_age = $_POST['from_age'];
            if( !empty($_POST['to_age']) ) $view->to_age = $_POST['to_age'];
            
            $view->filter_date1 = $_POST['ticket_date1'];
            $view->filter_date2 = $_POST['ticket_date2'];
             
            $view->display();
        }
        
        public function loadtab($view_type) {
            $where = "ticket_status='$view_type'";
            $ticket_model = TicketInfo::getInstance($this->db);
            if( $view_type == 'closed' ) $where .= " OR ticket_status='Resolved'";
           
            
            $ticket_array = $ticket_model->fetchAll($where);
            echo json_encode($ticket_array);
        }
        
        public function ticketinfo($id = 0) {
            if($id < 0) $id = 0;
            $ticket_model = new TicketInfo($this->db, $id);
            
            $leads_id = isset($_GET['leads_id']) ? Input::get('leads_id') : 0;
            $userid = isset($_GET['userid']) ? Input::get('userid') : 0;
            
            $client = array();
            $staff = array();
            
            if( empty($_SESSION['referer']) ) {
                $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
            }
            
            $view = new View('ticket_details');
            
            if( $ticket_model->ticket_exists > 0 ) {
                $view->next_id = $id;
                $view->submit = 'Update Ticket';
                $view->ticket_info = $ticket_model->ticket_info;
                
                $client = $this->clientstaff->fetch_users("ticket_id=$id AND ref_table='leads.id'");
                $staff = $this->clientstaff->fetch_users("ticket_id=$id AND ref_table='personal.userid'");
                $files_array = $this->file_upload->fetchAll('ticket_id='.$id);
                $client_notes = $this->comm->fetchAll("ticket_id=$id AND type='client-note'");
                $staff_notes = $this->comm->fetchAll("ticket_id=$id AND type='staff-note'");
                $client_email = $this->comm->fetchAll("ticket_id=$id AND type='client-email'");
                $staff_email = $this->comm->fetchAll("ticket_id=$id AND type='staff-email'");
                
                //$details = $this->log->fetchHistory($id, 'ticket_details', 'ASC');
                

                $case_det = $ticket_model->ticket_info['ticket_details'];
                $date_created = $ticket_model->ticket_info['date_created'];
                $case_sol = $ticket_model->ticket_info['ticket_solution'];
                
                $case_det = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $case_det);
                $case_det = preg_replace('/\\\/', '', $case_det);
                $case_det = str_replace("/\s+/", '&nbsp;', $case_det);
                
                $case_sol = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $case_sol);
                $case_sol = preg_replace('/\\\/', '', $case_sol);
                $case_sol = str_replace("/\s+/", '&nbsp;', $case_sol);
                
                $details = array(
                    array('field_update' => $case_det, 'admin_fname' => $this->log->case_created_by($id),
                        'date_updated' => date("m/d/Y", $date_created))
                );
                
                
                
                $details = array_merge($details, $this->log->fetchHistory($id, 'ticket_details', 'ASC'));
                
                if( $case_sol ) {
                    $solution = array(
                    array('field_update' => $case_sol, 'admin_fname' => $this->log->case_created_by($id),
                        'date_updated' => date("m/d/Y", $date_created))
                    );
                    $solution = array_merge($solution, $this->log->fetchHistory($id, 'ticket_solution', 'ASC'));
                } else {
                    $solution = $this->log->fetchHistory($id, 'ticket_solution', 'ASC');
                }
                
                $view->files = $files_array;
                $view->client_notes = $client_notes;
                $view->staff_notes = $staff_notes;
                $view->staff_email = $staff_email;
                $view->client_email = $client_email;
                $view->case_details = $details;
                $view->case_solution = $solution;
                
                //$view->history = $this->log->fetchHistory($id);
            } else {
                $view->next_id = $ticket_model->next_id();
                //$view->status_array = array('Open');
                $view->submit = 'Create Ticket';
                
                // set default client or staff
                if( $leads_id ) $client = $this->clientstaff->fetch_users_add($leads_id, 'id', 'leads');
                if( $userid ) $staff = $this->clientstaff->fetch_users_add($userid, 'userid', 'personal');
            }
            
            $view->ticket_id = $id;
            
            $view->client = $client;
            $view->staff = $staff;
            
            $view->types = $this->types->fetch_all();
            //$view->status_array = array('Open', 'Resolved');
            
            $view->csro_array = $ticket_model->admin_get("csro='Y'");
            
            $view->accounts_array = $ticket_model->admin_get("admin_id IN (".implode(',', $this->accounts_ids).")");
            
            //$view->csro_array = $ticket_model->csro_list();
            
            //$view->accounts_array = $ticket_model->accounts_list($this->accounts_ids);
            
            
            $view->day_priority = $this->day_priority;
            $view->referer = preg_match('/reports/', $_SESSION['referer'], $match)?"?/index/":$_SESSION['referer'];
            $view->leads = $leads_id;
            $view->userid = $userid;
            $view->display();
        }
        
        public function process_ticket() {
            $button_name = Input::post('upload') ? Input::post('upload') : Input::post('new_update');
            
            $id = Input::post('ticket_id');
            $diff_ticket = new TicketInfo($this->db, $id);

            if ($button_name == 'Upload') {
                $err_msg = $this->fileupload($id);
                if(!$err_msg) {
                    $diff_ticket->auto_responder( array('ticket_id' => $id, 'admin_fname'=>$this::$admin['admin_fname'],
                            'title'=>$diff_ticket->ticket_info['ticket_title'], 'date_updated' => time()) );
                }
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.uploadResult("'.$err_msg.'","'.$id.'");'; //,"'.$file_return.'","'.$_FILES['inpfile']['name'].'");';
                echo "</script></head><body></body></html>";
                exit;
            } else {
                $status = Input::post('ticket_status') ? Input::post('ticket_status') : Input::post('case_status');
                
                $csro = Input::post('ticket_csro');
                $type = Input::post('ticket_type');
                $title = Input::post('ticket_title');
                $accts = Input::post('ticket_accounts');
                //$client_id = Input::post('client_id');
                //$client_name = Input::post('client_name');
                //$staff_id = Input::post('staff_id');
                //$staff_name = Input::post('staff_name');
                $details = Input::post('ticket_details');
                $solution = Input::post('ticket_solution');
                $day_priority = Input::post('day_priority');
                //}
                
                $data_array = array('ticket_type' => $type, 'ticket_title' => $title,// 'ticket_details' => $details,
                        'csro' => $csro, 'day_priority' => $day_priority, 'accounts' => $accts);
                
                if( trim($details) != "" ) $data_array['ticket_details'] = $details;
                
                
                $diff_ticket->update = $button_name == 'Update Ticket' ? true : false;
                $diff_ticket->ticket_check($data_array);
                $is_error = $diff_ticket->is_error;
                
                if( !$is_error ) {
                    if ( count($_POST['client_id']) == 1 && count($_POST['client_id']) == 1 &&
                        $_POST['client_id'][0] == 'Search id...' && $_POST['staff_id'][0] == 'Search id...' ) {
                        $is_error = "Client or contractor field should not be empty.";
                    }
                }

                if( $is_error == "") {
                    if( trim($solution) != "" ) $data_array['ticket_solution'] = $solution;
                    //$data_array['ticket_solution'] = $solution;
                    $data_array['ticket_status'] = $status;
                    
                    $ticket_id = 0;
                    
                    $admin = $this::$admin['admin_id'];
                    
                    //if( $diff_ticket->ticket_exists > 0 ) {
                    if ($button_name == 'Update Ticket') {
                        $data_array['date_updated'] = time();
                        
                        $ret = $diff_ticket->ticket_update($id, $data_array);
                        
                        $ticket_id = $id;

                        if( $ret ) {
                            $last_updates = array_diff($data_array, $diff_ticket->ticket_info);
                            if( count($last_updates) > 1 ) {                                
                                $this->log->log_insert( array('ticket_id' => $ticket_id, 'admin_id' => $admin,
                                        'field_update' => serialize($last_updates)) );
                                
                                $diff_ticket->auto_responder( array('ticket_id' => $ticket_id, 'admin_fname'=>$this::$admin['admin_fname'],
                                      'title'=>$title, 'date_updated' => time()) );
                            }
                        }
                        
                    //} else {
                    } elseif( $button_name == 'Create Ticket' ) {
                        $notes_id = Input::post('notes_id');
                
                        $data_array['date_created'] = time();
                        $data_array['date_updated'] = $data_array['date_created'];
                        
                        $new_id = $diff_ticket->ticket_create($data_array);
                        
                        if( $new_id ) {
                            $last_updates = array('Case created' => 'case #'.$new_id, 'date_updated' => $data_array['date_created']);
                            //insert log
                            $this->log->log_insert( array('ticket_id' => $new_id, 'admin_id' => $admin,
                                    'field_update' => serialize($last_updates) ) );
                            
                            // populate ticket id to the notes if any
                            $this->comm->noteticket_update($new_id, $notes_id);
                            //$this->fileupload->fileticket_update($new_id, $files_id);
                            
                            // handle file uploads
                            $this->fileupload($new_id);
                            
                            $ticket_id = $new_id;
                            
                            $diff_ticket->auto_responder( array('ticket_id' => $ticket_id, 'admin_fname'=>$this::$admin['admin_fname'],
                                      'title'=>$title, 'date_updated'=>$data_array['date_created']), true );
                            
                        }
                    }
                    
                    $is_error = $diff_ticket->is_error;
                    
                    if( $ticket_id && $is_error == "" ) {
                        $this->clientstaff->user_create($ticket_id, $admin, $_POST['client_id']);
                        $this->clientstaff->user_create($ticket_id, $admin, $_POST['staff_id'], 'personal.userid');
                    }
                    
                    
                    
                    // save the users data
                }
            }
            // RUN JAVASCRIPT TO UPDATE MAIN PAGE
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            if($status && $status == "Resolved" && $is_error == "") {
                echo 'window.parent.class_ticket.animate_close();';
            }
            echo 'window.parent.createResult("'.$is_error.'");';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        private function fileupload($ticket_id) {
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
            
            $upload_path = "../uploads/$ticket_id";
            if (!is_dir($upload_path)) {
                mkdir( $upload_path, 0755 );
                $handle = fopen( $upload_path ."/index.html", 'x+' );
                fclose( $handle );
            }
            $upload_path .= "/";
            
            foreach( $_FILES as $file ) {
                for ($i = 0; $i < count($file); $i++) {
                    $error_code = $file['error'][$i];

                    if( $file['tmp_name'][$i] != "" && $error_code == 0 ) {
                        $file_ext = strtolower(str_replace(".", "", strrchr($file['name'][$i], ".")));
                        
                        $file_dest = $upload_path . $file['name'][$i];
                        
                        // sending file with spaces on filename resulted into zero-byte file
                        $file_dest = str_replace(" ", "_", $file_dest);
                        $file_dest = str_replace("'", "", $file_dest); // single quote splitted the filename
                        //echo '<br/>->'.$file['tmp_name'][$i]. ' = '.$file_dest;
                        if(!move_uploaded_file($file['tmp_name'][$i], $file_dest)) {
                            $err_msg = "Upload failed!";
                        } else {
                            $admin = $this::$admin['admin_id'];
                            
                            chmod($file_dest, 0666);
                            $data_array = array('ticket_id' => $ticket_id, 'filepath' => $file_dest, 'date_uploaded' => time());
                            
                            $file_return = $this->file_upload->file_insert($data_array);
                            $this->log->log_insert( array('ticket_id' => $ticket_id, 'admin_id' => $admin,
                                'field_update' => serialize(array('File' => $file['name'][$i],
                                'date_updated' => time() )) ) );
                        }
                    } else {
                        if( trim($error_code) != "" ) $err_msg = $file_error[$error_code];
                    }
                }
                
            }
            
            return $err_msg;

        }
        
        public function filelisting() {
            $ticket_id = Input::post('ticket_id');
            $this->file_upload = new TicketFileUploads($this->db);
            $files_array = $this->file_upload->fetchAll('ticket_id='.$ticket_id);
            echo json_encode($files_array);
        }
        
        public function addnote() {
            $note_return = 0;
            $admin = $this::$admin['admin_id']; //Input::post('csro') ? Input::post('csro');
            $ticket_id = Input::post('ticket_id');
            $type = Input::post('type');
            $note_content = Input::post('note_content');
            if( trim($note_content) == "") {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Enter your note!");';
                echo "</script></head><body></body></html>";
                exit;
            }
            $note_content = addslashes($note_content);
            
            $data_array = array('ticket_id' => $ticket_id, 'date_created' => time(), 'content' => $note_content,
                'sender' => $admin, 'type' => $type);
            
            $note_return = $this->comm->note_create($data_array);
            
            if( is_numeric($note_return) ) {
                $this->log->log_insert( array('ticket_id' => $ticket_id, 'admin_id' => $admin,
                    'field_update' => serialize(array('Notes' => $note_content, 'date_updated' => time() )) ) );
                
                $diff_ticket = new TicketInfo($this->db, $ticket_id);
                if($diff_ticket->ticket_exists > 0) {
                    $diff_ticket->auto_responder( array('ticket_id' => $ticket_id, 'admin_fname'=>$this::$admin['admin_fname'],
                            'title'=>$diff_ticket->ticket_info['ticket_title'], 'date_updated' => time() ) );
                }
            }
            
            //echo $note_return;
            // RUN JAVASCRIPT TO UPDATE MAIN PAGE
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            if( $ticket_id ) {
                echo 'window.parent.commResult("'.$note_return.'","'.$type.'");';
            } else {
                // 8-22-12
                $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $note_content);
                $str = preg_replace('/\\\/', '', $str);
                $str = str_replace("/\s+/", '&nbsp;', $str);
                echo 'window.parent.commResult_wait("'.$note_return.'","'.$type.'","'.$str.'","'.$admin.'");';
            }
            echo "</script></head><body></body></html>";
            exit;
            //echo json_encode($files_array);
        }
        
        public function createemail() {
            //print_r($_POST);
            $ticket_id = Input::post('ticket_id');
            $type = Input::post('type');
            $admin = $this::$admin['admin_id'];
            $subject = Input::post('email_subject');
            $email_content = Input::post('email_content');
            
            if( trim($email_content) == "") {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Enter your email message!");';
                echo "</script></head><body></body></html>";
                exit;
            }
            $ref_tbl = "personal.userid";
            if( $type == "client-email") $ref_tbl = "leads.id";
            
            $users_email = $this->clientstaff->fetch_users("ticket_id=$ticket_id AND ref_table='$ref_tbl'");
            
            //$email_array = array();
            //foreach($users_email as $rows => $entry) array_push($email_array, $entry['email']);
            
            
            //echo "'".implode(', ', $email_array) ."'";
            //$data_array = array('ticket_id' => $ticket_id, 'date_created' => time(), 'content' => $note_content,
            //    'sender' => $admin, 'type' => 'note');
            //exit;
            //$stripped_content = stripslashes($email_content);
			$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $email_content);
			$str = preg_replace('/\\\/', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);
            
            
            //if( $this->utils->send_email('RS Case Management System: '.$subject, $str, "'".implode(', ', $email_array) ."'") ) {
                
            $data_array = array('ticket_id' => $ticket_id, 'date_created' => time(), 'content' => addslashes($email_content),
                'sender' => $admin, 'type' => $type);
                
            $createemail_return = $this->comm->email_create($data_array);
                
            if( is_numeric($createemail_return) ) {
                // send email
                if( TEST ) {
                    $this->utils->send_email('RS Case Management System: '.$subject, $str);
                }else {
                    foreach($users_email as $rows => $entry) //array_push($email_array, $entry['email']);
                        $this->utils->send_email('RS Case Management System: '.$subject, $str, $entry['email']);
                }
                $this->log->log_insert( array('ticket_id' => $ticket_id, 'admin_id' => $admin,
                    'field_update' => serialize(array('Email' => $email_content, 'date_updated' => time() )) ) );
                
                $diff_ticket = new TicketInfo($this->db, $ticket_id);
                if($diff_ticket->ticket_exists > 0) {
                    $diff_ticket->auto_responder( array('ticket_id' => $ticket_id, 'admin_fname'=>$this::$admin['admin_fname'],
                            'title'=>$diff_ticket->ticket_info['ticket_title'], 'date_updated' => time() ) );
                }
            }
            //}
            
             // RUN JAVASCRIPT TO UPDATE MAIN PAGE
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.commResult("'.$createemail_return.'","'.$type.'");';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        public function commlisting() {
            $ticket_id = Input::post('ticket_id');
            $type = Input::post('comm_type');
            $this->comm = new TicketCommunications($this->db);
            //$files_array = $this->file_upload->fetchAll('ticket_id='.$ticket_id);
            $content = $this->comm->fetchAll("ticket_id=$ticket_id AND type='$type'");
            //print_r($content);
            echo json_encode($content);
        }
        
        public function historylist() {
            $ticket_id = Input::post('ticket_id');
            $history = $this->log->fetchHistory($ticket_id);
            echo json_encode($history);
        }
        
        public function search_keyword() {
            $search_result = $this->process_keyword();
            echo json_encode($search_result);
        }
        
        public function filter_list() {
            $search_result = $this->process_filter();
            echo json_encode($search_result);
        }
        
        public function delete() {
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            $diff_ticket = new TicketInfo($this->db);

            $diff_ticket->ticket_delete($_POST['tick']);
            echo 'window.parent.location.href="?/index/";';
            
            echo "</script></head><body></body></html>";
            exit;
            
        }
    }
