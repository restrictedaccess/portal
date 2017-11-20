<?php

class client_class {
    private static $instance = NULL;
    private $db = NULL;
    private $user_exist = 0;
    private $client_info = array();
    private $client_list = array();
    public static $leads_id = 0;
    public function __construct($db) {
        $this->db = $db;
        $this->client_info['id'] = 0;
        //if( $id ) {
            $select = $this->db->select()
            ->from( array('l'=>'leads'), array('id','fname', 'lname', 'email',
                                               'cnt'=>"count(s.userid)"))
            ->joinInner( array('s'=>'subcontractors'), 'l.id=s.leads_id', array())
            //->joinInner( array('p'=>'personal'), 's.userid=p.userid', array('fname'))
            ->where('l.status = ?', 'Client')
            ->where('s.status in (?)', array('ACTIVE', 'suspended'))
            ->group('l.id')
            ->order('l.fname')->order('l.lname');
            //echo $select;
            //$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
            $this->client_list = $this->db->fetchAll($select);
        //}
        
        if( count($this->client_list) ) {
            $this->user_exist = 1;
            //$aID = array_map( function($a){return $a['id'];}, $this->client_list);
           // $this->client_list = array_combine($aID, $this->client_list);
            //print_r( $this->client_list);
        }
    }
    
    public function fetch_all() {
        $select = $this->db->select()
            ->from('leads', array('id','fname', 'lname', 'email'));
            $this->client_info = $this->db->fetchAll($select);
            $this->db->setFetchMode(Zend_Db::FETCH_ASSOC);
        return $this->db->fetchAll($select);
    }
    
    public function get_staff($leads_id) {
        //echo 'getstaff>>'.$this->leads_id;
        $select = $this->db->select()
        ->from( array('s'=>'subcontractors'), array('id', 'userid') )
        ->joinInner( array('p'=>'personal'), 's.userid=p.userid', array('fname', 'lname', 'email') )
        ->where('s.leads_id = ?', $leads_id) //$this->client_info['id']);
        ->where('s.status = ?', 'active')
        ->order(array('p.fname', 'p.lname'));
        //echo $select;
        return $this->db->fetchAll($select);
    }
    
    public function get_client_info($id = 0) {
        if( $id ) {
            $aID = array_map( function($a){return $a['id'];}, $this->client_list);
            $this->client_list = array_combine($aID, $this->client_list);
            return $this->client_list[$id];
        } else return $this->client_list;
    }

}