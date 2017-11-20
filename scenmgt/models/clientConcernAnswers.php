<?php
class clientConcernAnswers extends Zend_Db_Table {
    protected $_name = 'client_concern_answers';
    
    public function fetch_answers($id=0) {
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('a'=>$this->_name), array('id', 'answer_text') )
        ->joinLeft(array('q2'=>'client_concern_questions'), 'a.id=q2.answer_id', array('fqid'=>'id', 'fup_question'=>'question_text'))
        ->where('a.question_id = ?', $id);
        //->where('a.concern_id = ?', $id);
        //echo $select->__toString();
        $result = $this->fetchAll($select);
        return is_object($result) ? $result->toArray() : array();
    }
}