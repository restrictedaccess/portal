<?
function activity_tracker_notes_all($client_id, $method_type)
{

	putenv("TZ=Philippines/Manila");
	
	//assign values
	$client_id = $client_id;
	$date_today = date("Y-m-d"); 
	//ended
	
	
	//current status seetings
	$query="SELECT id, status FROM tb_client_account_settings WHERE client_id='$client_id' LIMIT 1;";
	$result=mysql_query($query);
	while(list($id, $status) = mysql_fetch_array($result))
	{
		$activity_notes_status = $status;
		$settings_id = $id;
	}
	//ended
	
	
	//get client email
	$query="SELECT email FROM leads WHERE id='$client_id' LIMIT 1;";
	$result=mysql_query($query);
	while(list($email) = mysql_fetch_array($result))
	{
		$client_email = $email;
	}
	//ended
		
	
	//mail status
	$query="SELECT * FROM tb_activity_tracker_notes_mail_status WHERE settings_id='$settings_id' AND client_id='$client_id' AND date='$date_today';";
	$result=mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0)
	{
		if($method_type == "manual")
		{	
			$is_send = "yes";
		}
		else
		{
			$is_send = "no";
		}	
	}
	else
	{
		if($method_type == "manual")
		{	
			$is_send = "yes";
			$query="INSERT INTO tb_activity_tracker_notes_mail_status SET settings_id='$settings_id', client_id='$client_id', date='$date_today'";
			$result=mysql_query($query);
		}
		else
		{
			if($activity_notes_status == "ALL")
			{
				$is_send = "yes";
				$query="INSERT INTO tb_activity_tracker_notes_mail_status SET settings_id='$settings_id', client_id='$client_id', date='$date_today'";
				$result=mysql_query($query);
			}	
		}	
	}
	//ended
	
	
	//generate date
	$a_1 = time();
	$b_1 = time() + (1 * 24 * 60 * 60);
	$a_ = date("Y-m-d"); 
	$b_ = date("Y-m-d",$b_1);
	$title = date("M d, Y");	
	//ended	
	
	
	//body header
		$body = '
		<html>
		<head>
		<title>My Account-Client</title>
		<link rel=stylesheet type=text/css href="http://www.remotestaff.com.au/portal/css/font.css">
		<link rel=stylesheet type=text/css href="http://www.remotestaff.com.au/portal/menu.css">
		</head>
		<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
		<!-- HEADER -->
		
					<table width="100%"  cellspacing="0" cellpadding="3" style="border:#CCCCCC solid 1px; margin-left:10px; margin-top:20px; margin-bottom:20px;">
					  <tr bgcolor="#CCCCCC">
						<td height="21" colspan="3" valign="middle" style="border-bottom:#666666 solid 1px;"><font color="#000000"><b>Activity Tracker Notes on All Staff</b><i>('.$title.')</i></font></td>
					  </tr>
					  <tr>
						<td width=\'40%\' valign=\'top\' style=\'border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;\' colspan="3">		
		';	
	//ended
	
	
	//generate report
	if($is_send == "yes")
	{
		$q="SELECT userid FROM subcontractors WHERE status='ACTIVE' AND leads_id='$client_id';";
		$r=mysql_query($q);
		while(list($u_id) = mysql_fetch_array($r))
		{
					//subcontructor
					$query="SELECT userid, fname, lname FROM personal WHERE userid='$u_id';";
					$result=mysql_query($query);
					while(list($userid,$fname,$lname) = mysql_fetch_array($result))
					{
						$mystaff_name = $fname." ".$lname;
						$mystaff = $userid;
					}
					//ended
					
					//generate report
					$query = "SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE leads_id='$client_id' AND userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d')='$a_') ORDER BY expected_time ";
					$result=mysql_query($query);
					//ended
					
					$body = $body.'
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
							  <tr>
								<td colspan="3" bgcolor="#E9E8E9"><strong>'.$mystaff_name.'</strong></td>
							  </tr>
							  <tr>
								<td><strong>Date</strong></td>
								<td><strong>Time</strong></td>
								<td><strong>Activity&nbsp;Notes</strong></td>
							  </tr>								  
						';		  
								$clr = "#CCFFCC";
								$date = "";
								$current_date = "";
								while ($row = mysql_fetch_assoc($result)) 
								{														
									if($clr == "#CCFFCC")
										$clr = "#EEFFEE";
									else
										$clr = "#CCFFCC";
										
										//date formating
										$date_time = new DateTime($row['expected_time']);
										$time = $date_time->format('h:i:a');	
										$date = $date_time->format('M-d');	
										//ended					
									  $body = $body.'<tr bgcolor="'.$clr.'">
										<td width="10%">';
												if($date == $current_date)
												{
													//do nothing
												}
												else
												{
													$body = $body.$date;
												}
										$body = $body.'			
										</td>
										<td width="10%">'.$time.'</td>
										<td width="80%">'.$row['note'].'</td>
									  </tr>';				
									$current_date = $date;
								}
		$body = $body.'
							</table>
					';
		}			





		$body = $body.'	
						</td>
					  </tr>
					</table>		
		</body>
		</html>	
		';
		//ended
		$from_email="noreply@remotestaff.com.au";
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$subject = "Activity Tracker Notes";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";		
		
		//send the mail
		if (TEST) 
		{
			$client_email = 'devs@remotestaff.com.au';
		}
		mail($client_email, $subject, $body, $header);		
		
		if($method_type == "manual")
		{
			echo '<script language="javascript"> alert("Activity tracker notes has been sent to your email."); </script>';
		}	
	}
}
?>

