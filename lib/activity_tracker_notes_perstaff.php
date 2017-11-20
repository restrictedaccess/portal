<?
function activity_tracker_notes_perstaff($userid, $client_id, $method_type)
{
	
	putenv("TZ=Philippines/Manila");
	
	//assign values
	$mystaff = $userid;
	$client_id = $client_id;
	$date_today = date("Y-m-d"); 
	//ended

	
	//current status seetings
	$query="SELECT status FROM tb_client_account_settings WHERE client_id='$client_id' LIMIT 1;";
	$result=mysql_query($query);
	while(list($status) = mysql_fetch_array($result))
	{
		$activity_notes_status = $status;
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
	$query="SELECT * FROM tb_activity_tracker_notes_mail_status WHERE subcon_id='$mystaff' AND client_id='$client_id' AND date='$date_today';";
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
			$query="INSERT INTO tb_activity_tracker_notes_mail_status(client_id, subcon_id, date) VALUES('$client_id', '$mystaff', '$date_today')";
			$result=mysql_query($query);
		}
		else
		{
			if($activity_notes_status == "ONE")
			{
				$is_send = "yes";
				$query="INSERT INTO tb_activity_tracker_notes_mail_status(client_id, subcon_id, date) VALUES('$client_id', '$mystaff', '$date_today')";
				$result=mysql_query($query);
			}	
		}	
	}
	//ended
	
	
	
	//generate report
	if($is_send == "yes")
	{
		//subcontructor
		$query="SELECT fname, lname FROM personal WHERE userid='$mystaff';";
		$result=mysql_query($query);
		while(list($fname,$lname) = mysql_fetch_array($result))
		{
			$mystaff_name = $fname." ".$lname;
		}
		//ended
		
		//generate report
		$a_1 = time();
		$b_1 = time() + (1 * 24 * 60 * 60);
		$a_ = date("Y-m-d"); 
		$b_ = date("Y-m-d",$b_1);
		$title = date("M d, Y");
		$query = "SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE leads_id='$client_id' AND userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d')='$a_') ORDER BY expected_time ";
		$result=mysql_query($query);
		//ended
		
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
			<td height="21" colspan="3" valign="middle" style="border-bottom:#666666 solid 1px;"><font color="#000000"><b>Activity Tracker Notes Per Staff</b><i>('.$title.')</i></font></td>
		  </tr>
		  <tr>
			<td></td>
		  </tr>
		  <tr>
			<td width=\'40%\' valign=\'top\' style=\'border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;\' colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
				  <tr>
					<td colspan="3" bgcolor="#E9E8E9">
					  <table width="100%">
						<tr>
						  <td><strong>'.$mystaff_name.'</strong></td>
						</tr>
					</table></td>
				  </tr>
				  <tr>
					<td><strong>Date</strong></td>
					<td><strong>Time</strong></td>
					<td><strong>Activity&nbsp;Notes</strong></td>
				  </tr>					  
				  <tr>
		';		  
								$clr = "#CCFFCC";
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
			</td>
		  </tr>
		</table>
		
		</body>
		</html>
		';
		$from_email="noreply@remotestaff.com.au";
		$subject = "Activity Tracker Notes: ".$mystaff_name;
		$header  = 'MIME-Version: 1.0' . "\r\n";
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
	//ended
}
?>
