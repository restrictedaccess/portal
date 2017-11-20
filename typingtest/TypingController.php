<?php

    /* $ TypingController.php 2012-09-03 mike $ */
    //include_once('./lib/class_xls.php');
    
    class TypingController {
        private $db = NULL;

        public static $admin = array();
        private $test_model;
        private $upload_path = "../uploads/test/";
        private $test_id;

        public static $dbase = NULL;
        public $tests = Array();
        // constructor
        public function __construct($id = 1) {
            $this->db = $this::$dbase;
            
            $this->test_id = $id;

           // skills_test::$dbase = $this->db;
            //$this->test_model = skills_test::getInstance();
            $sql = "SELECT id, test_name, test_duration, test_content, test_creation_date, test_status
            FROM typing_test WHERE id=".$this->test_id;
            
            
            $this->tests =  $this->db->fetchRow($sql);
            
            //for( $i=0, $len=count($this->tests); $i<$len; $i++ ) {
            $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $this->tests['test_content']);
            $str = preg_replace('/\\\/', '', $str);
            $str = str_replace("/\s+/", '&nbsp;', $str);
    
            $this->tests['test_content'] = $str;
            //$this->tests[$i]['question_count'] = $this->test_question_count($this->tests[$i]['id']);
            //}
            
        }
        
        public function index($view_type) {
            $current_date = date("Y-m-d");
            //$test_object = skills_test::getInstance(0, 0);
            
            View::$templ_dir = 'views';
            $view = new View('ttlogin');

            //$view->test_info = $test_object->tests;

            
            $view->display();
        }
        
        public function typing_start() {
            $current_date = date("Y-m-d");
            $userid = !empty($_SESSION['userid']) ? $_SESSION['userid'] : 0 ;
            
            if( !$userid ) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Invalid user id or session expired");';
                echo 'window.location.href="/portal/applicant_test.php";';
                echo "</script></head><body></body></html>";
                exit;
            }
            
            $sql = $this->db->select()
				->from('typing_access_log', array('count(id)') )
				->where('userid = ?', $userid)
                ->where('correct > 0');
			$access_count = $this->db->fetchOne($sql);
            
            if( $access_count == 3 ) {
                echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
                echo 'window.parent.alert("Sorry, you\'ve reached the maximum number of tries.");';
                echo 'window.location.href="/portal/applicant_test.php";';
                echo "</script></head><body></body></html>";
                exit;
            }
            
            View::$templ_dir = 'views';
            $view = new View('typing_test');

            $view->test_info = $this->tests;
            $view->user_info = $this->get_userinfo($userid);

            $view->duration = (int)$this->tests['test_duration'] / 60;
            $view->display();
        }
        
        public function get_userinfo($userid) {
            $sql = $this->db->select()
				->from('personal', array('userid', 'fname', 'lname', 'email' ) )
					->where('userid = ?', $userid);
			return $this->db->fetchRow($sql);
        }
        
        public function user_result_save() {
            $gwpm = explode(' ', Input::post('gwpm'));
            $nwpm = explode(' ', Input::post('nwpm'));
            $error = explode(' ', Input::post('errors'));
            $keys = explode(' ', Input::post('keys'));
            $test_id = Input::post('test_id');
            $userid = Input::post('userid');
            $correct = Input::post('correct');

            $data_array = array('test_id' => $test_id, 'test_log_tstamp' => time(), 'userid' => $userid,'correct'=>$correct,
                    'gwpm' => $gwpm[0], 'nwpm' => $nwpm[0], 'error' => $error[0], 'keystroke' => $keys[0]);
            
            $this->db->insert('typing_access_log', $data_array);
        }
        
        public function user_test_result($userid) {
            //$sql = "SELECT t.test_name, ROUND( l.keystroke / LENGTH(t.test_content)  * 100) accuracy,
            $sql = "SELECT t.test_name, ROUND( ( correct - l.error) / correct * 100) accuracy,
            t.test_duration DIV 60 duration, from_unixtime(l.test_log_tstamp) date_taken,
            l.gwpm, l.nwpm, l.error, l.keystroke FROM typing_access_log l
            LEFT JOIN typing_test t ON l.test_id=t.id where userid=$userid AND l.correct > 0
            GROUP BY l.id ORDER BY l.id DESC";
            
            return $this->db->fetchAll($sql);
        }
        
    }