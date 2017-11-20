<?php
class clientConcernQuestions extends Zend_Db_Table {
    protected $_name = 'client_concern_questions';
    
    public function fetch_questions($id=0, $is_question = false) {
        $select = $this->select()
        //->setIntegrityCheck(false)
        ->from(array('q'=>$this->_name), array('id', 'question_text', 'q_date'=>"date(question_create_date)") )
        //->joinLeft(array('a'=>'client_concern_answers'), 'q.id=a.concern_question_id', array('aid'=>'id', 'answer_text'))
        ->where('q.answer_id is NULL');
        
        if( $is_question ) {
            $select->setIntegrityCheck(false)
            ->joinLeft(array('c'=>'client_concerns'), 'q.concern_id=c.id', array('concern_title'))
            ->where('q.id = ?', $id);
        }
        else $select->where('q.concern_id = ?', $id);
        
        //echo $select->__toString();
        $result = $this->fetchAll($select);
        return is_object($result) ? $result->toArray() : array();
    }
}