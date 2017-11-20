<?php
include 'config.php';
include 'conf.php';

if(isset($_SESSION['admin_id']) || isset($_SESSION['agent_no']))
{
	$code_number = @$_REQUEST["code_number"];
	$date_expire = @$_REQUEST['date_expire'];
	$comment = @$_REQUEST['comment'];
	$date_created = date('Y-m-d');
	$admin_id = $_SESSION['admin_id'];
	$bp_id = $_SESSION['agent_no'];
	
	$q_amount=mysql_query("SELECT id FROM voucher WHERE code_number='$code_number' LIMIT 1");
	$ctr=@mysql_num_rows($q_amount);
	if ($ctr > 0)
	{
		mysql_query("UPDATE voucher SET comment='$comment', date_expire='$date_expire' WHERE code_number='$code_number' LIMIT 1");
	}	
	else
	{
		mysql_query("INSERT INTO voucher SET admin_id='$admin_id', bp_id='$bp_id', code_number='$code_number', comment='$comment', date_expire='$date_expire', date_created='$date_created'");
	}
	
	
		//RETURN CHANGES
		$name = mysql_query("SELECT * FROM voucher WHERE code_number='$code_number' LIMIT 1");
		$date_expire = mysql_result($name,0,"date_expire");
		$today = date("Y-m-d");
		$date_created = mysql_result($name,0,"date_created");
		if($date_expire == "" || $date_expire == "0000-00-00")
		{
			$date_expire = "0000-00-00";
			$date_expire_status = "<strong><font color=#FF0000>No Expiration Date Assigned</font></strong>";
		}
		elseif($today <= $date_expire)
		{
			$date_expire = mysql_result($name,0,"date_expire");
			$date_expire_status = "<strong>Active</strong>";
		}
		else
		{
			$date_expire = mysql_result($name,0,"date_expire");
			$date_expire_status = "<strong><font color=#FF0000>Expired</font></strong>";
		}	
		echo '
		<font size="1">Date&nbsp;Created:&nbsp;<strong>'.$date_created.'</strong></font><br />
		<font size="1">Date&nbsp;Expire:&nbsp;<strong>'.$date_expire.'</strong></font><br />
		<font size="1">Status:&nbsp;<strong>'.$date_expire_status.'</strong></font>	
		';
		//ENDED
}	
?>