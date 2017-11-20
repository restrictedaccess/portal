<?php

    /* $ TicketController.php 2012-04-08 mike $ */
    //include_once('./lib/class_xls.php');
    
    class ApptestController {
        private $db = NULL;
        private $schedule_model = NULL;
        public static $admin = array();
        private $test_model;
        private $upload_path = "../uploads/test/";

        public static $dbase = NULL;
        private $log;
        private $utils;
       
        // constructor
        public function __construct() {
            $this->db = $this::$dbase;

            //$this->ticket_model = ticketInfo::getInstance($this->db);
            skills_test::$dbase = $this->db;
            $this->test_model = skills_test::getInstance(0, 0);
            $this->test_model->log = $this->log;
            
            $this->log = new TestHistory($this->db);
            $this->utils = Utils::getInstance();
            $this->utils->db = $this->db;
            
            $this::$admin = $this->utils->check_admin_session();
            
        }
        
        public function index($view_type) {
            $current_date = date("Y-m-d");
            $test_object = skills_test::getInstance(0, 0);
            
            //$test_object->log = $this->log;
            
            View::$templ_dir = 'views';
            $view = new View('test_main');

            $view->test_info = $test_object->tests;

            
            $view->display();
        }
        
        public function loadtab($view_type) {
            $where = "ticket_status='$view_type'";
            $ticket_model = TicketInfo::getInstance($this->db);
            if( $view_type == 'closed' ) $where .= " OR ticket_status='Resolved'";
           
            
            $ticket_array = $ticket_model->fetchAll($where);
            echo json_encode($ticket_array);
        }
        
        public function testinfo($id = 0) {
            if($id < 0) $id = 0;

            $test_object = new skills_test($id, 0);
            
            //print_r($test_object->tests);
            //exit;
            
            if( empty($_SESSION['referer']) ) {
                $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
            }
            
            View::$templ_dir = 'views';
            
            $view = new View('test_details');
            
            if( $id > 0 ) {
                $view->next_id = $id;
                
                
               $view->test = $test_object->tests;
               $view->questions = $test_object->test_questions_all($id);
                
                //$view->history = $this->log->fetchHistory($id);
            } else {
                //$view->next_id = $ticket_model->next_id();
                //$view->status_array = array('Open');
                $view->submit = 'Create Ticket';
            }
            $view->test_id = $id;           
            
            
            $view->display();
        }
        
        public function process_test() {

            $test_id = Input::post('test_id');
            
            $test_name = Input::post('test_name');
            $test_desc = Input::post('test_desc');
            $test_instr = Input::post('test_instruction');
            $test_duration = Input::post('test_duration');
            
            $answer_text = Input::post('answer_text');
            $answer_score = Input::post('answer_score');
            $answer_iscorrect = Input::post('answer_iscorrect');
            
            $questions = Input::post('question_text');
            
            $resource_display = Input::post('resource_display');
            $resource_fname = Input::post('resource_filename');
            
            $admin = $this::$admin['admin_id'];
            
            $test_array = array('test_name'=>$test_name, 'test_desc'=>$test_desc,
                            'test_instruction' => $test_instr, 'test_duration' => $test_duration);
            
            $is_error = '';
            if( !$test_id ) {
                if( $test_name ) {
                    /*$test_array = array('test_name'=>$test_name, 'test_desc'=>$test_desc,
                                'test_instruction' => $test_instr, 'test_duration' => $test_duration);*/
                    $test_id = $this->test_model->test_insert($test_array);
                    
                    if( $test_id )
                        $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                            'field_update' => serialize(array('Test created' => 'Test ID#'.$test_id, 'date_updated' =>  time() )) ) );
                                
                }
                
                
            } else {
                
                $diff_test = new skills_test($test_id, 0);
                
                if( $test_name ) {
                    /*$test_array = array('test_name'=>$test_name, 'test_desc'=>$test_desc,
                                'test_instruction' => $test_instr, 'test_duration' => $test_duration);*/
                    
                    $this->test_model->test_update($test_id, $test_array);
                    
                    //$last_data = array('test_name'=>$diff_test->tests[0]['test_name'], 'test_desc'=>$test_desc,
                    //            'test_instruction' => $test_instr);
                    $last_updates = array_diff($test_array, $diff_test->tests[0]);
                    
                    if( count($last_updates) > 1 ) {
                        $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                        'field_update' => serialize($last_updates)) );
                    }
                    
                }
                
                //for( $i = 0, $len = count($questions); $i < $len; $i++ ) {
                foreach( $questions as $key => $value ) {
                    //echo '<br/>'.$key.':'.$value;
                    if( trim($value) != "" ) {
                        if( $this->test_model->question_update($key, $value) ) {
                            // log question updates
                            $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                            'field_update' => serialize(array('Question Update id#'.$key => $value, 'date_updated' => time() ))) );
                        }
                    }
                    
                    $iscorrect = $answer_iscorrect[$key];
                    $scores = $answer_score[$key];
                    
                    foreach( $answer_text[$key] as $aid => $text ) {
                        if( !$text ) continue;
                        $action = $this->test_model->answer_update($key, $aid, $text, $scores[$aid], (in_array($aid, $iscorrect) ? 1 : 0));

                        if( $action ) {
                            // log answer updates
                            $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                            'field_update' => serialize(array("Answer $action: id#".$aid => $text, 'date_updated' => time() ))) );
                        }
                    }
                    if( count($resource_display[$key]) > 0) {
                        foreach( $resource_display[$key] as $rid => $display ) {
                            
                            $data_array = array('question_id' => $key);
                            if( $display )  $data_array['question_resource_display'] = $display;
                            
                            if( $_FILES['resource_filename']['tmp_name'][$key][$rid] != "") {
                                $fname = $_FILES['resource_filename']['name'][$key][$rid];
                                
                                // for some reason sending file with spaces on filename resulted into zero-byte file
                                $fname = str_replace(" ", "_", $fname);
                                $fname = str_replace("'", "", $fname);
                                $file_dest = $this->upload_path . $fname;
                                
                                                          
                            
                                // TRY MOVING UPLOADED FILE, RETURN ERROR UPON FAILURE
                                if(!move_uploaded_file($_FILES['resource_filename']['tmp_name'][$key][$rid], $file_dest)) {
                                    $is_error = "Upload failed!";
                                } else {
                                    chmod($file_dest, 0666);
                                    
                                    
                                    $data_array['question_resource_filename'] = $fname;
                                    
                                    //$diff_test->resources_insert($data_array);
                                }
                            }
    
                            if( !empty($data_array['question_resource_filename']) ||
                               !empty($data_array['question_resource_display']) ) {
                                $action = $this->test_model->resources_update($rid, $data_array);
                           
                                if( $action ) {
                                    // log resource updates
                                    $data_array['resource_id'] = $rid;
                                    $data_array['date_updated'] = time();
                                    $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                                    'field_update' => serialize( $data_array )) );
                                }
                            }
                            
                            
                        }
                    }
                    
                }
            }
            if(!$test_id) $test_id=0;
            
            // RUN JAVASCRIPT TO UPDATE MAIN PAGE
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.createResult("'.$is_error.'",'.$test_id.');';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        public function createquestion() {
            $test_id = Input::post('test_id');
            $diff_test = new skills_test($test_id);
            
            $question_text = Input::post('question_text');
            
            $answer_text = Input::post('answer_text');
            $answer_score = Input::post('answer_score');
            $answer_iscorrect = Input::post('answer_iscorrect');
            
            if( trim($question_text) == "" ) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Please enter value for question!");';
                echo "</script></head><body></body></html>";
                exit;
            }
            $question_id = $diff_test->question_insert($question_text);
            
            $admin = $this::$admin['admin_id'];
            
            if( $question_id ) {
                // log new question
                $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                'field_update' => serialize(array('New Question: id#'.$question_id => $question_text, 'date_updated' => time() ))) );
            
            
                $resource_display = Input::post('resource_display');
                $resource_array = array('question_id' => $question_id);
                
                $msg_error = '';
                
                for( $i=0, $len=count($answer_text); $i < $len; $i++ ) {
                    echo "\n".$i.':'.$answer_text[$i]. ' = '.$answer_score[$i]. '>>'. (in_array($i, $answer_iscorrect) ? 1 : 0);
                    
                    $order = $i + 1;
                    $data_array = array('question_id' => $question_id, 'answer_text' => $answer_text[$i], 'answer_order' => $order,
                        'answer_score' => $answer_score[$i], 'answer_iscorrect' => (in_array($i, $answer_iscorrect) ? 1 : 0) );
                    $aid = $this->test_model->answer_insert($data_array);
                    
                    // log new answer
                    //$data_array['New Answer: id#'] = $aid;
                    //$data_array['date_updated'] = time();
                    //$this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
                    //'field_update' => serialize($data_array)) );
                }
                
                if($_FILES['resource_filename']['tmp_name'] != "") {
                    
                    
                    $fname = $_FILES['resource_filename']['name'];
                    
                    // for some reason sending file with spaces on filename resulted into zero-byte file
                    $fname = str_replace(" ", "_", $fname);
                    $fname = str_replace("'", "", $fname);
                    $file_dest = $this->upload_path . $fname;
                    
                                              
                
                    // TRY MOVING UPLOADED FILE, RETURN ERROR UPON FAILURE
                
                    if(!move_uploaded_file($_FILES['resource_filename']['tmp_name'], $file_dest)) {
                        $msg_error = "Upload failed!";
                    } else {
                        chmod($file_dest, 0666);
                        
                        $resource_array['question_resource_filename'] = $fname;
                    }
                }
                
                //$data_array = array('question_id' => $question_id, 'question_resource_filename' => $fname);
                if( $resource_display )
                    $resource_array['question_resource_display'] = $resource_display;
                
                if( !empty($resource_array['question_resource_filename']) ||
                   !empty($resource_array['question_resource_display']) ) {
                    $diff_test->resources_insert($resource_array);
                }
            }

            // RUN JAVASCRIPT TO UPDATE MAIN PAGE
            echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
            echo 'window.parent.createResult("'.$msg_error.'",'.$test_id.');';
            echo "</script></head><body></body></html>";
            exit;
        }
        
        public function setqstatus() {
            $question_id = Input::post('question_id');
            $status = Input::post('status');
            $test_id = Input::post('test_id');
            $this->test_model->question_set_status($question_id, ($status=='Publish'?1:0));
            
            // log question status
            $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $this::$admin['admin_id'],
                'field_update' => serialize(array('Set status: Question id#'.$question_id => $status, 'date_updated' => time() ))) );
        }
        
        public function teststatus() {
            $test_id = Input::post('test_id');
            $status = Input::post('status');
            $this->test_model->test_set_status($test_id, ($status=="Enable Test"?1:0));
            
            // log test status
            $this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $this::$admin['admin_id'],
                'field_update' => serialize(array('Set status: Test id#'.$test_id => $status, 'date_updated' => time() ))) );
        }
        
        
        
        public function delete($cat) {
            $id = Input::post('id');
            switch( $cat ) {
                case 'answer':
                    $this->test_model->answer_delete($id);
                    break;
                case 'resource':
                    $this->test_model->resource_delete($id);
                    break;
            }
            
            echo json_encode(array('result'=>'ok'));            
        }
        
        public function historylist() {
            $test_id = Input::post('test_id');
            $history = $this->log->fetchHistory($test_id);
            echo json_encode($history);
        }
    }