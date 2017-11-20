<?php
if($_SESSION['client_id']){
    $logs = array(
        'leads_id' => $_SESSION['client_id'],
	    'log_date' => date("Y-m-d H:i:s"), 
	    'browser' => $_SERVER['HTTP_USER_AGENT'], 
	    'ip' => $_SERVER['REMOTE_ADDR'], 
	    'page' => $_SERVER['SCRIPT_FILENAME']
    );
	$db->insert('client_logs', $logs);
}
?>