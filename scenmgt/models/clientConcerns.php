<?php
class clientConcerns extends Zend_Db_Table {
    protected $_name = 'client_concerns';
    
    public function fetch_all() {
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('c'=>$this->_name), array('id', 'concern_title', 'date_created'=>"date(concern_create_date)", 'admin_id') )
        ->joinLeft(array('q'=>'client_concern_questions'), 'c.id=q.concern_id', array('question_text'))
        ->where('c.status = ?', '1');
        
        $result = $this->fetchAll($select);
        return is_object($result) ? $result->toArray() : array();
    }
    
    public function fetch_client_concern($id=0) {
        $select = $this->select()
        //->setIntegrityCheck(false)
        ->from(array('c'=>$this->_name), array('id', 'concern_title', 'date_created'=>"date(concern_create_date)", 'admin_id') )
        //->joinLeft(array('q'=>'client_concern_questions'), 'c.id=q.concern_id', array('question_text'))
        ->where('c.id = ?', $id);
        
        $result = $this->fetchRow($select);
        return is_object($result) ? $result->toArray() : array();
    }
}