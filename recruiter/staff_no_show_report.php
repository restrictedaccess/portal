<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');
?>

<table width="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#CCCCCC>
	<tr>
    	<td>
            <table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
                <tr bgcolor="#FFFFFF">
                    <td width="100%" align="left" valign="top"><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Staff No Show Report</strong></font></td><td align="right"><a href='javascript: staff_no_show_report_exit(); '><img src="../../portal/images/closelabel.gif" border="0" /></a></td></tr></table></div></td>
                </tr>
                <tr>
                    <td valign="top">
						<table width="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
							<tr>
								<td width="0%" align="left" valign="top" class="td_info td_la">#</td>
								<td width="40%" align="left" valign="top" class="td_info td_la">Recruiter</td>
								<td width="40%" align="left" valign="top" class="td_info td_la" width="">Service Type</td>
                                <td width="20%" align="left" valign="top" class="td_info td_la">Date</td>
							</tr>	
							<?php
							$counter = 0;
							$userid = $_REQUEST["userid"];
							$q ="SELECT ns.service_type, ns.date, a.admin_fname, a.admin_lname FROM staff_no_show ns, admin a WHERE a.admin_id = ns.admin_id AND ns.userid = '$userid' ORDER BY ns.date DESC";
							$result = $db->fetchAll($q);
							foreach($result as $r)
							{
								$date = new Zend_Date($r['date'], 'YYYY-MM-dd HH:mm:ss');	
								$counter++;
							?>                            
							<tr>
								<td align="left" valign="top" class="td_info td_la"><?php echo $counter; ?></td>
								<td align="left" valign="top" class="td_info"><?php echo $r['admin_fname'].' '.$r['admin_lname']; ?></td>
								<td align="left" valign="top" class="td_info"><?php echo $r['service_type']; ?></td>
                                <td align="left" valign="top" class="td_info"><?php echo $date; ?></td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table> 