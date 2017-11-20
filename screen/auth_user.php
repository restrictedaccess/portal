<?php
include '../conf/zend_smarty_conf.php';
$noresult = array('Result'=>false);

if( isset($_GET['userid']) ) $userid = $_GET['userid']; else {echo json_encode($noresult); exit;}
if( isset($_GET['token']) ) $token = $_GET['token']; else {json_encode($noresult); exit;}

$select = $db->select()->from('rschat_users', array('id', "tte"=>"unix_timestamp(date_add(tstamp, INTERVAL 1 DAY) )") )
->where('userid = ?', $userid)
->where('conn_id = ?', $token);

$row = $db->fetchRow( $select );

if( !empty($row['id']) ) echo json_encode(array('Result' => time() < $row['tte'] ));
else echo json_encode($noresult);
?>