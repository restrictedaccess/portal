<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
$userid = $_REQUEST["userid"];
?>
<table width="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#CCCCCC>
	<tr>
    	<td>
            <table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
                <tr bgcolor="#FFFFFF">
                    <td width="100%" align="left" valign="top">
                    	<div class="hiresteps">
                        	<table width="100%">
                            	<tr>
                                	<td><font color="#003366"><strong>Sent Samples</strong></font></td>
                                    <td align="right"><a href='javascript: staff_files_counter_exit(); '><img src="../../portal/images/closelabel.gif" border="0" /></a></td>
								</tr>
							</table>
						</div>
					</td>
                </tr>
                <tr>
                    <td valign="top">
						<table width="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
							<tr>
								<td width="5%" align="left" valign="top" class="td_info td_la">#</td>
								<td width="20%" align="left" valign="top" class="td_info td_la">Lead</td>
								<td width="60%" align="left" valign="top" class="td_info td_la" width="">Message</td>
                                <td width="15%" align="left" valign="top" class="td_info td_la" width="">Date Sent</td>
							</tr>	
							<?php
							$counter = 0;
							$rows = $db->fetchAll("SELECT * FROM staff_samples_email_sent WHERE userid='$userid'");
							//$c = mysql_query("SELECT * FROM staff_samples_email_sent WHERE userid='$userid'");
							foreach($rows as $row){
								$counter++;
								$a = $db->fetchRow("SELECT fname, lname FROM leads WHERE id='".$row['leads_id']."'");
								//$a = mysql_query("SELECT fname, lname FROM leads WHERE id='".$row['leads_id']."' LIMIT 1");
								$client_name = $a["fname"]." ".$a["lname"];								
							?>                            
							<tr>
								<td align="left" valign="top" class="td_info td_la"><?php echo $counter; ?></td>
								<td align="left" valign="top" class="td_info"><a href="javascript: lead(<?php echo $row['leads_id']; ?>); "><?php echo $client_name; ?></a></td>
								<td align="left" valign="top" class="td_info">
                                	<DIV ID='staff_samples_message<?php echo $counter; ?>' STYLE='POSITION: Absolute; VISIBILITY: hidden'>
										<table width="100%" cellpadding="1" cellspacing="4" border="0" bgcolor=#CCCCCC>
                                        	<tr>
                                            	<td align="right"><a href="javascript: close_staff_samples_message(<?php echo $counter; ?>); ">Close</a></td>
                                           </tr>	
                                        	<tr>
                                            	<td><?php echo $row["message"]; ?></td>
											</tr>
										</table>
                                	</DIV>
                                    <a href="javascript: open_staff_samples_message(<?php echo $counter; ?>); ">Click to view the message</a>
								</td>
                                <td align="left" valign="top" class="td_info"><?php echo date('F j, Y',strtotime($row["date"])); ?></td>
							</tr>
							<?php }?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>                                    