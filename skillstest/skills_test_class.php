<?php
/* $Id: skills_test_class.php 2012-08-22 mike $ */

class skills_test {
    private $db;
    private $question_status = 1;
    private $quiz_total = 0;
    public $tests = Array();
    private $enabled_question = '';
    private $test_id;
    public static $dbase = NULL;
	
	private static $instance = NULL;
	public $log;
	
	// return Singleton instance
	public static function getInstance( $id = 0, $status=1) {
		if (self::$instance === NULL) {
			self::$instance = new self($id, $status);
		}
        return self::$instance;
    }

    function __construct($test_id = 0, $test_status = 1) {
        $this->db = $this::$dbase;
        
        $this->test_id = $test_id;


        if ($this->question_status) $this->enabled_question = " AND question_status=1 ";

        $sql = "SELECT t.id, t.test_name, t.test_desc, t.test_instruction, t.test_creation_date, t.test_status,
			t.test_duration, if(t.test_status=1,'Yes','No') published, a.admin_fname created_by FROM skills_tests t LEFT JOIN admin a ON t.test_author=a.admin_id";
		
		$where = array();
		if( $test_status ) array_push($where, "test_status=$test_status");
        if( $test_id ) array_push($where, "id=".$test_id);
		
		if( count($where) > 0 ) $sql .= " WHERE ".implode(' AND ', $where);
		

        $this->tests =  $this->db->fetchAll($sql);
		
		for( $i=0, $len=count($this->tests); $i<$len; $i++ ) {
			$str = nl2br(htmlspecialchars($this->tests[$i]['test_instruction']));
			$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
			$str = preg_replace('/\\\/', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);

			$this->tests[$i]['test_instruction'] = $str;
			$this->tests[$i]['question_count'] = $this->test_question_count($this->tests[$i]['id']);
		}

    }
    
    
    public function test_question_count($id = 0) {
        $sql = "SELECT count(id) FROM test_questions WHERE question_status=1 AND test_id=".($id > 0 ? $id : $this->test_id);
        return $this->db->fetchOne($sql);
    }

    public function test_question($cnt = 0) {

        $questions_list = array();
        $answers_list = array();
        $resources_list = array();
		
		$tab = "<span style=\"width: 10px\"></span>";


        $question_row = $this->db->fetchRow("SELECT tq.* FROM test_questions AS tq
            WHERE tq.test_id=".$this->test_id." AND tq.question_status=1 ORDER BY tq.id, tq.question_order LIMIT $cnt, 1");
		
		$str = nl2br(htmlspecialchars($question_row['question_text']));
		//$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $question_row['question_text']);
		$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
		$str = preg_replace('/\\\/', '', $str);
		$str = preg_replace('/\//', '', $str);
		$str = str_replace("/\s+/", '&nbsp;', $str);

		$question_row['question_text'] = $str;
        
        $answer_rows = $this->db->fetchAll("SELECT ta.* FROM test_answers AS ta
                WHERE ta.question_id=".$question_row['id']." ORDER BY ta.id");
		
		for( $i=0, $len=count($answer_rows); $i<$len; $i++ ) {
			$str = nl2br(htmlspecialchars($answer_rows[$i]['answer_text']));
			$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
			$str = preg_replace('/\\\/', '', $str);
			$str = preg_replace('/\//', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);
			
			$answer_rows[$i]['answer_text'] = $str;
		}
        $question_row['answers'] = $answer_rows;
        
        $tq_resources =  $this->db->fetchAll("SELECT question_resource_display, question_resource_filename
            FROM  test_question_resources WHERE question_id=". $question_row['id'] . " ORDER BY id ASC");
		for( $i=0, $len=count($tq_resources); $i<$len; $i++ ) {
			$str = nl2br(htmlspecialchars($tq_resources[$i]['question_resource_display']));
			$str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $str);
			$str = preg_replace('/\\\/', '', $str);
			$str = preg_replace('/\//', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);
			
			$tq_resources[$i]['question_resource_display'] = $str;
		}   
        $question_row['resources'] = $tq_resources;


        
        
        echo json_encode($question_row);

        //return $question_rows;//Array($questions_list, $answers_list, $resources_list);
    }
    
    public function user_answer_save($data = array()) {
		$userid = $data['userid'];
		$uaid = $data['user_answer_id'];
		if( $this->db->fetchOne("SELECT user_answer_id FROM test_access_log WHERE user_answer_id='$uaid' AND userid=$userid") == "") {
			$this->db->insert('test_access_log', $data);
		}
        
    }
    
    public function user_test_access_count($userid) {
        return $this->db->fetchOne("SELECT count(id) FROM test_access_log WHERE userid=$userid AND test_id=".$this->test_id);
    }
    
    public function user_test_answered($userid) {
		$sql = "SELECT q.id, q.question_text, a.id, a.answer_score,
			if((select group_concat(ta.id) from test_answers ta
			where ta.answer_iscorrect=1 and ta.question_id=q.id)=l.user_answer_id,1,0) score
			FROM test_questions q
			LEFT JOIN test_access_log l ON l.question_id=q.id
			LEFT JOIN test_answers a ON l.user_answer_id=a.id
			where l.userid=$userid AND q.test_id=".$this->test_id." GROUP BY l.user_answer_id ORDER BY l.id";
			
        /*$sql = "SELECT q.question_text, a.id, a.answer_iscorrect, a.answer_score,
            case a.answer_order when 1 then 'A' when 2 then 'B'
            when 3 then 'C' when 4 then 'D' end order_char
            FROM test_access_log l
            LEFT JOIN test_answers a ON l.user_answer_id=a.id
            LEFT JOIN test_questions q ON a.question_id=q.id
            where l.userid=$userid AND q.test_id=".$this->test_id." GROUP BY l.user_answer_id";*/
        $result = $this->db->fetchAll($sql);
		
		/*for( $i=0, $len=count($result); $i<$len; $i++ ) {
			$iscorrect = 'Incorrect';
			$score = 0;
			
			$correct_answers = explode(",", $result[$i]['ans']);
			$user_answers = explode(",", $result[$i]['user_answer_id']);
			
			for( $j=0, $cnt=count($user_answers); $j<$cnt; $j++ ) {
		  		if( in_array($user_answers[$j], $correct_answers) ) {
					$score++;
					$iscorrect = 'Correct';
				}
			}
			$result[$i]['iscorrect'] = $iscorrect;
			$result[$i]['score'] = $score;
		}*/
        echo json_encode($result);
    }
	
	public function user_test_compute_score($userid) {
        $sql = "SELECT cnt.test_name, from_unixtime(min(tstamp)) date_taken,
		sum(cnt.answer_score) score,
		date_format(from_unixtime(max(tstamp)-min(tstamp)), '%i:%s') timer
		FROM (
			SELECT t.test_name, a.answer_score,
            case a.answer_order when 1 then 'A' when 2 then 'B'
            when 3 then 'C' when 4 then 'D' end order_char,
			l.test_log_tstamp tstamp
            FROM test_access_log l
            LEFT JOIN test_answers a ON l.user_answer_id=a.id
            LEFT JOIN skills_tests t ON l.test_id=t.id
            where userid=$userid ORDER BY l.id ) cnt
			GROUP BY cnt.test_name";
			
        return $this->db->fetchAll($sql);
    }
	
	public function user_test_count_score($userid) {
        $sql = "SELECT cnt.test_name, from_unixtime(min(tstamp)) date_taken,
		sum(cnt.answer_iscorrect) score, count(cnt.test_name) total,
		date_format(from_unixtime(max(tstamp)-min(tstamp)), '%i:%s') timer
		FROM (
			SELECT t.test_name, a.answer_iscorrect,
            case a.answer_order when 1 then 'A' when 2 then 'B'
            when 3 then 'C' when 4 then 'D' end order_char,
			l.test_log_tstamp tstamp
            FROM test_access_log l
            LEFT JOIN test_answers a ON l.user_answer_id=a.id
            LEFT JOIN skills_tests t ON l.test_id=t.id
            where userid=$userid GROUP BY l.user_answer_id ORDER BY l.id ) cnt
		GROUP BY cnt.test_name";
			
        return $this->db->fetchAll($sql);
    }
    
    public function test_questions_all($test_id = 0) {

        $questions_list = array();
        $answers_list = array();
        $resources_list = array();


        $question_rows = $this->db->fetchAll('SELECT tq.* FROM test_questions AS tq
            WHERE tq.test_id='.$test_id.' ORDER BY tq.id, tq.question_order');


        for ($i = 0, $len = count($question_rows); $i < $len ; $i++ ) {

            $str = preg_replace('(\\\r\\\n|\\\r|\\\n)', '<br/>', $question_rows[$i]['question_text']);
			$str = preg_replace('/\\\/', '', $str);
			$str = preg_replace('/\//', '', $str);
			$str = str_replace("/\s+/", '&nbsp;', $str);
			$question_rows[$i]['question_text'] = $str;
			
            $answer_rows = $this->db->fetchAll('SELECT ta.* FROM test_answers AS ta
                WHERE ta.question_id='.$question_rows[$i]['id'].' ORDER BY ta.id');
            
            $question_rows[$i]['answers'] = $answer_rows;

            /*for ($j=0; $j<count($answer_rows); $j++) {
                $answers_list[$i][$j] = array(
                'id' => $answer_rows[$j]['answer_id'],
                'str' => $answer_rows[$j]['answer_text'],
                'iscorrect' => $answer_rows[$j]['answer_iscorrect'],
                'score' => $answer_rows[$j]['answer_score']
                );

            }*/


            $tq_resources =  $this->db->fetchAll('SELECT id, question_resource_display, question_resource_filename
            FROM  test_question_resources WHERE question_id='. $question_rows[$i]['id']
            . ' ORDER BY id ASC');
            
            $question_rows[$i]['resources'] = $tq_resources;
            
            /*for ($j = 0; $j < count($qq_resources); $j++ ) {
                $patt = '/^\.\//';
                $repl = '';

                $resources_list[$i][$j] = array(
                'resource_id' => $qq_resources[$j][question_resource_id],
                'resource_path' => preg_replace($patt, $repl, $qq_resources[$j][question_resource_filepath])
                ) ;
            }*/

        }
        
        //echo json_encode($question_rows);

        return $question_rows;//Array($questions_list, $answers_list, $resources_list);


    }
	
	public function test_update($id, $data_array = array()) {
		$this->db->update( 'skills_tests', $data_array, 'id='.$id );	
	}
		
	public function question_update($id, $text) {
		$updated = 0;
		if( $this->db->fetchOne("SELECT question_text FROM test_questions WHERE id=$id") != $text) {
			$this->db->update( 'test_questions', array('question_text'=>$text, 'question_update_date'=>date("Y-m-d H:i:s")), 'id='.$id );
			$updated = 1;
			// log question updates
            //$this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
			//field_update' => serialize(array('Question Update id#'.$key => $value, 'date_updated' => time() ))) );
		}
		return $updated;
	}
	
	public function answer_update($qid, $id, $text, $score, $correct) {
		$data_array = array('answer_text' => $text, 'answer_iscorrect' => $correct, 'answer_score' => $score);
		$action = '';
		
		if( $this->db->fetchOne("SELECT id FROM test_answers WHERE id=$id AND question_id=$qid") != "") {
						
			$curr_ans = $this->db->fetchRow("SELECT answer_text, answer_iscorrect, answer_score FROM test_answers WHERE id=$id AND question_id=$qid");

			if( count( array_diff($data_array, $curr_ans) ) > 0 ) {
				$action = 'update';
				
				// log answer updates
				//$this->log->log_insert( array('test_id' => $test_id, 'admin_id' => $admin,
				//'field_update' => serialize(array('Answer Update: id#'.$aid => $text, 'date_updated' => time() ))) );
			}
			
			$this->db->update( 'test_answers', $data_array, 'id='.$id );
		} else {
			$answer_order = $this->db->fetchOne("SELECT max(answer_order) FROM test_answers WHERE question_id=$qid");
			$data_array['question_id'] = $qid;
			$data_array['answer_order'] = $answer_order+1;
			$this->answer_insert($data_array);
			$action = 'insert';
		}
		
		return $action;
	}
	
	public function resources_update($id, $data_array = array()) {
		//$id = $data_array['rid'];
		$qid = $data_array['question_id'];
		$display = $data_array['question_resource_display'];
		
		$action = '';
		//echo "->>> SELECT id FROM test_question_resources WHERE id=$id AND question_id=$qid\n";
		
		if( $this->db->fetchOne("SELECT id FROM test_question_resources WHERE id=$id AND question_id=$qid") != "") {
			
			if( $this->db->fetchOne("SELECT question_resource_display FROM test_question_resources WHERE id=$id AND question_id=$qid") != $display) {
				$action = 'update';
			}
			
			$this->db->update( 'test_question_resources', $data_array, 'id='.$id );
			
		} else {
			//$answer_order = $this->db->fetchOne("SELECT max(answer_order) FROM test_question_resources WHERE question_id=$qid");
			//$data_array['question_id'] = $qid;
			//$data_array['answer_order'] = $answer_order+1;
			$this->resources_insert($data_array);
			$action = 'insert';
		}
		return $action;
	}
	
	public function question_set_status($id, $status) {
		$this->db->update( 'test_questions',
			array('question_status'=>$status, 'question_update_date'=>date("Y-m-d H:i:s")), 'id='.$id );
	}
	
	public function test_set_status($id, $status) {
		$this->db->update( 'skills_tests',
			array('test_status'=>$status, 'test_update_date'=>date("Y-m-d H:i:s")), 'id='.$id );
	}
	
	public function test_insert($data_array = array()) {
		$this->db->insert( 'skills_tests', $data_array );
		return $this->db->lastInsertId('skills_tests');
	}
	
	public function question_insert($text) {
		$data_array = array('question_text'=>$text, 'test_id' => $this->test_id);
		$this->db->insert( 'test_questions', $data_array );
		return $this->db->lastInsertId('test_questions');
		
	}
	
	public function answer_insert($data_array = array()) {
		if( count($data_array) > 0 )
			$this->db->insert( 'test_answers', $data_array );
		return $this->db->lastInsertId('test_answers');
	}
	
	public function resources_insert($data_array = array()) {
		if( count($data_array) > 0 )
			$this->db->insert( 'test_question_resources', $data_array );
		return $this->db->lastInsertId('test_question_resources');
	}
    
    public function get_user($userid) {
        return $this->db->fetchRow("SELECT fname, lname, email FROM personal WHERE userid=". $userid);
    }
	
	public function answer_delete($id) {
		$this->db->delete( 'test_answers', 'id='.$id );
	}
	
	public function resource_delete($id) {
		$this->db->delete( 'test_question_resources', 'id='.$id );
	}


}


?>