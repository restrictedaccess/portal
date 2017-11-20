<?php
class clientConcernInput extends Zend_Db_Table {
    protected $_name = 'client_concerns_input';
    
    public function fetch_client_input($leads_id=0) {
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('i'=>$this->_name), array('input_id'=>'id', 'date_created'=>"date(date_created)",
                                               'admin_id', 'resp'=>'client_response') )
        ->joinLeft(array('c'=>'client_concerns'), 'i.concern_id=c.id', array('concern_id'=>'id','concern_title'))
        ->joinLeft(array('a'=>'client_concern_answers'), 'i.client_response=a.id', array('qid'=>'question_id'))
        ->where('i.leads_id = ?', $leads_id);
        
        $result = $this->fetchAll($select);
        return is_object($result) ? $result->toArray() : array();
    }
}