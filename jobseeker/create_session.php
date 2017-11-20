<?php
/* create_session.php - 2013-02-14
  creates tempfile then returns only string of hash - used by voice recording to transfer session
*/
session_start();
if( empty($_SESSION['VREC']) ) exit();
//2013-10-25 unset($_SESSION['VREC']);
if( empty($_SESSION['userid']) ) {
    $hash_code = "usernotfound";
} else {
    $uid = $_SESSION['userid'];
    $hash_code = chr(rand(ord("a"), ord("z"))) . md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $uid ) ;
    $tmpfile = './__'.$uid;
    file_put_contents( $tmpfile, $hash_code );
    chmod($tmpfile, 0600);
}
echo $hash_code;
exit();