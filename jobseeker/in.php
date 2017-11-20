<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_REQUEST["c"])){
	$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("userid"))->where("mass_responder_code = ?", $_REQUEST["c"]));
	try{
		$db->insert("inactive_staff", array("userid"=>$personal["userid"], "admin_id"=>0, "date"=>date("Y-m-d H:i:s"), "type"=>"NOT INTERESTED"));
	}catch(Exception $e){
		
	}
	echo "Thanks for your response. If you wish to reconsider your decision, please contact us by dialing 09479959825 or sending an email to <a href='mailto:recruitment@remotestaff.com.au'>recruitment@remotestaff.com.au</a>";
}else{
	echo "Invalid link";
}
