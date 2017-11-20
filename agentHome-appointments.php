<table width="100%">
	<tr>
		<td width="50%" valign="top">







							<?php

								require_once("conf/connect.php");

								$time_offset ="0"; // Change this to your time zone

								$time_a = ($time_offset * 120);

								$h = date("h",time() + $time_a);

								$m = date("i",time() + $time_a);

								$d = date("Y-m-d" ,time());

								$type = date("a",time() + $time_a);								

							

								$db=connsql();

								$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$agent_no' AND date_start='$d'");	

							

								$num_result = mysql_num_rows($c);

							?>

										<table width="100%" cellpadding="0" cellspacing="0">							
			
											<tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Today's Appointments(<?php echo $num_result; ?>)</b></font><br /></td></tr>
			
											<?php if($num_result > 0) { ?>
			
											<tr >
			
												<td colspan=3 valign="top" >
			
														<iframe id="frame" name="frame" width="100%" height="150" src="todays_appointments.php?agent_no=<?php echo $agent_no; ?>" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			
												</td>	
			
											</tr>
											<?php } ?>
										</table>		





		</td>
		
		
		<td width="50%" valign="top">

										<?php
			
											$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$agent_no' AND date_start > '$d'");	
			
											$num_result = mysql_num_rows($c);
			
										?>
			
										<table width="100%">							
			
											<tr><td bgcolor="#F1F1F3" height="25" colspan=3><font color='#000000'><b>Other Days Appointments(<?php echo $num_result; ?>)</b></font><br /></td></tr>
			
											<?php if($num_result > 0) { ?>
			
											<tr >
			
												<td colspan=3 valign="top" >
			
														<iframe id="frame" name="frame" width="100%" height="150" src="other_appointments.php?agent_no=<?php echo $agent_no; ?>" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			
												</td>	
			
											</tr>
											<?php } ?>
										</table>			


		</td>		


	</tr>	
</table>