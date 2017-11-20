<?php
class clientConcernStaff extends Zend_Db_Table {
    protected $_name = 'client_concern_staff';
    
    public function fetch_concern_staff($userid = 0, $leads_id = 0) {
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from( array('s'=>$this->_name), array() )
        ->joinLeft( array('i'=>'client_concerns_input'), 's.concern_input_id=i.id',
                   array('input_id'=>'id', 'resp'=>'client_response', 'date_created'=>"date(date_created)") )
        ->joinLeft( array('c'=>'client_concerns'), 'i.concern_id=c.id', array('concern_id'=>'id', 'concern_title'))
        ->joinLeft(array('a'=>'client_concern_answers'), 'i.client_response=a.id', array('qid'=>'question_id'))
        ->where('s.userid = ?', $userid)
        ->where('i.leads_id = ?', $leads_id);
        $data = $this->fetchAll($select);
        return is_object($data) ? $data->toArray() : array();
        
    }
}