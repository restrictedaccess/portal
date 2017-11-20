<?php
// CHANGES HISTORY
//2011-08-15  Roy Pepito <roy.pepito@remotestaff.com.au>

//START: construct
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
$action = $_REQUEST["action"];
//ENDED: construct
	
if($action == "cancel")
{
	$_SESSION["mass_email_status"] = "cancelled";
	echo '<input type="checkbox" name="mass_email" onClick="javascript: check_emailing_status(this); ">Apply Result to Mass Emailing list</div>';	
}
elseif($action == "replace")
{
	$_SESSION["mass_email_status"] = "waiting";
	echo '<input type="checkbox" name="mass_email" onClick="javascript: check_emailing_status(this); " checked="checked" onchange="javascript: cancel_emailing_status(); ">Apply Result to Mass Emailing list</div>';		
}
else
{
	$query = $db->select()
	->from('personal')
	->where('mass_emailing_status = ?' , 'WAITING');
	$e = $db->fetchOne($query);	
	if($e == "" or $e == NULL)
	{
		echo '
			<table bgcolor="#FF0000" cellpadding="3" cellspacing="3"><tr><td>	
				<font color="#FFFFFF">You are about to clear and replace all sent items on mass emailing list, Click yes to confirm.&nbsp;&nbsp;<INPUT type="button" value="Yes" onclick="javascript: replace_emailing_status();" /><INPUT type="button" value="Cancel" onclick="javascript: cancel_emailing_status();" />
			</td></tr></table>
			';
	}
	else
	{
		echo '
			<table bgcolor="#FF0000" cellpadding="3" cellspacing="3"><tr><td>	
				<font color="#FFFFFF">Sending email to the current emailing staff list is not yet completed, click yes to clear and replace the existing list.&nbsp;&nbsp;<INPUT type="button" value="Yes" onclick="javascript: replace_emailing_status();" /><INPUT type="button" value="Cancel" onclick="javascript: cancel_emailing_status();" />
			</td></tr></table>
			';
	}	
}
?>