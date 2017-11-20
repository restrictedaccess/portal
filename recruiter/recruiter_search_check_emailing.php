<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
$action = $_REQUEST["action"];
//ENDED: construct
	
if($action == "cancel"){
	$_SESSION["mass_email_status"] = "cancelled";
	echo '<div style="display:inline-block;float:left;width:500px;"><input class="mass_email cancel" type="checkbox" name="mass_email">Apply Result to Mass Emailing list</div>';	
}
elseif($action == "replace"){
	$_SESSION["mass_email_status"] = "waiting";
	echo '<div style="display:inline-block;float:left;width:500px;"><input class="mass_email replace" type="checkbox" name="mass_email" checked="checked">Apply Result to Mass Emailing list</div>';		
	$db->update("staff_mass_mail_logs", array("finish"=>1), $db->quoteInto("admin_id = ?", $_SESSION["admin_id"]));
}else{
	$query = $db->select()
	->from('personal')
	->where('mass_emailing_status = ?' , 'WAITING');
	$e = $db->fetchOne($query);	
	if($e == "" or $e == NULL){
		echo "<div class='inline-message' style='float:left;width:490px;padding:10px;display:inline-block;background-color:#ff0000;color:#ffffff;'>";
		echo 'You are about to clear and replace all sent items on mass emailing list, Click yes to confirm.&nbsp;&nbsp;<INPUT type="button" value="Yes" class="mass_emailer"/><INPUT type="button" value="Cancel" class="mass_emailer"/>';
		echo "</div>";
	}else{
		echo "<div class='inline-message' style='float:left;width:490px;padding:10px;display:inline-block;background-color:#ff0000;color:#ffffff;'>";
		echo 'Sending email to the current emailing staff list is not yet completed, click yes to clear and replace the existing list.&nbsp;&nbsp;<INPUT type="button" value="Yes" class="mass_emailer"/><INPUT type="button" value="Cancel" class="mass_emailer"/>';
		echo "</div>";
	}	
}