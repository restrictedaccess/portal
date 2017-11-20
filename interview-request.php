<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf_root.php');

if($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==NULL){
	header("Location: index.php");
}

$agent_no = $_SESSION['agent_no'];

//REDUCE THE SIZE OF COMMENTS
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ENDED



//POST
$date_requested1 = $_REQUEST['date_requested1'];
$date_requested2 = $_REQUEST['date_requested2'];
$key = $_REQUEST['key'];
$status = $_REQUEST['status'];
$max = @$_REQUEST["max"];
$p = @$_REQUEST["p"];
$stat = @$_REQUEST["stat"];
$id = @$_REQUEST["id"];
//ENDED



//UPDATE STATUS
if(isset($stat))
{
	mysql_query("UPDATE tb_request_for_interview SET status='$stat' WHERE id='$id'");
}
//ENDED



//FUNCTIONS
function search($date_requested1,$date_requested2,$key,$status,$p,$maxp,$max) 
{
	$set = ($p-1)*$maxp ;

	$a_ = $date_requested1; 
	$b_ = $date_requested2;
	$title = "Between (".$a_." and ".$b_.")";	
	
	$from = "FROM tb_request_for_interview r, leads l, voucher v ";
	$order_by = "ORDER BY r.leads_id DESC LIMIT $set, $maxp";	
	$fields = "
	r.id,
	r.order_id,
	r.job_sub_category_applicants_id,
	r.leads_id,
	r.applicant_id,
	r.comment,
	r.date_interview,
	r.time,
	r.alt_time,
	r.alt_date_interview,
	r.time_zone,
	r.status,
	r.date_added,
	l.fname,
	l.lname,
	r.voucher_number
	";

	//date query
	if($a_ == "Any" || $b_ == "Any" || $a_ == "" || $b_ == "")
	{
		$date_query = "";
	}
	else
	{
		$date_query = "(DATE_FORMAT(r.date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND";	
	}
	//ended

	//default	
	$where = "WHERE $date_query (l.business_partner_id=".$_SESSION['agent_no'].") AND (r.leads_id=l.id) AND (r.voucher_number=v.code_number) AND r.status='NEW'";
	$query = "SELECT $fields $from $where $order_by";
	//ended
	
	if(@isset($rt))
	{	
		if($key == "")
		{
			//search - no search key
			$where = "WHERE $date_query (l.business_partner_id='".$_SESSION['agent_no']."') AND (r.leads_id=l.id) AND r.status='$status' AND (r.voucher_number=v.code_number) ";
			$query = "SELECT $fields $from $where $order_by";
			//ended
		}
		else
		{
			//search w/ keyword
			$where = "WHERE $date_query (l.business_partner_id=".$_SESSION['agent_no'].") AND (r.leads_id=l.id) AND r.status='$status' AND (r.voucher_number=v.code_number) AND (r.voucher_number='$key' OR l.fname LIKE '%$key%' OR l.lname LIKE '%$key%')";
			$query = "SELECT $fields $from $where $order_by";
			//ended
		}
	}

	$result =  mysql_query($query);
	
	if(!isset($max))
	{
		$m =  mysql_query("SELECT r.id $from $where");
		$max = mysql_num_rows($m);
	}
	
	$x = 0 ;	
	while ($r = mysql_fetch_assoc($result)) 
	{
		$temp[$x]['title'] = $title;
		$temp[$x]['max'] = $max;
		$temp[$x]['id'] = $r['id'];
		$temp[$x]['order_id'] = $r['order_id'];
		$temp[$x]['job_sub_category_applicants_id'] = $r['job_sub_category_applicants_id'];
		$temp[$x]['leads_id'] = $r['leads_id'];
		$temp[$x]['applicant_id'] = $r['applicant_id'];
		$temp[$x]['comment'] = $r['comment'];
		$temp[$x]['date_interview'] = $r['date_interview'];
		$temp[$x]['time'] = $r['time'];
		$temp[$x]['alt_time'] = $r['alt_time'];
		$temp[$x]['alt_date_interview'] = $r['alt_date_interview'];
		$temp[$x]['time_zone'] = $r['time_zone'];
		$temp[$x]['status'] = $r['status'];
		$temp[$x]['date_added'] = $r['date_added'];
		$temp[$x]['fname'] = $r['fname'];
		$temp[$x]['lname'] = $r['lname'];
		$temp[$x]['voucher_number'] = $r['voucher_number'];

		if($temp[$x]['voucher_number'] == "" || $temp[$x]['voucher_number'] == NULL)
		{
				$temp[$x]['date_expire'] = "";
				$temp[$x]['date_expire_status'] = "";
		}
		else
		{
			$name = mysql_query("SELECT * FROM voucher WHERE code_number='".$temp[$x]['voucher_number']."' LIMIT 1");
			$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
			$temp[$x]['voucher_comment'] = mysql_result($name,0,"comment");
			$today = date("Y-m-d");
			if($temp[$x]['date_expire'] == "" || $temp[$x]['date_expire'] == "0000-00-00")
			{
				$temp[$x]['date_expire'] = "0000-00-00";
				$temp[$x]['date_expire_status'] = "<strong><font color=#FF0000>No Expiration Date Assigned</font></strong>";
			}
			elseif($today <= $temp[$x]['date_expire'])
			{
				$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
				$temp[$x]['date_expire_status'] = "<strong>Active</strong>";
			}
			else
			{
				$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
				$temp[$x]['date_expire_status'] = "<strong><font color=#FF0000>Expired</font></strong>";
			}
		}	
		
		
		$temp[$x]['date_created'] = mysql_result($name,0,"date_created");
		$temp[$x]['admin_id'] = mysql_result($name,0,"admin_id");
		if($temp[$x]['admin_id'] == "" || $temp[$x]['admin_id'] == 0)
		{
			$temp[$x]['admin_name'] = "System Generated";
		}
		else
		{		
			$name = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$temp[$x]['admin_id']."' LIMIT 1");
			$fname = mysql_result($name,0,"admin_fname");
			$lname = mysql_result($name,0,"admin_lname");
			$temp[$x]['admin_name'] = $fname." ".$lname;
		}
		
		$name = mysql_query("SELECT fname, lname FROM leads WHERE id='".$temp[$x]['leads_id']."' LIMIT 1");
		$fname = mysql_result($name,0,"fname");
		$lname = mysql_result($name,0,"lname");
		$temp[$x]['client_name'] = $fname." ".$lname;
		
		$name = mysql_query("SELECT fname, lname FROM personal WHERE userid='".$temp[$x]['applicant_id']."' LIMIT 1");
		$fname = mysql_result($name,0,"fname");
		$lname = mysql_result($name,0,"lname");
		$temp[$x]['applicant_name'] = $fname." ".$lname;

		$x++ ;
	}
	return $temp ;
}

function linkpage($date_requested1,$date_requested2,$key,$status,$p,$size,$d) 
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?date_requested2='.$date_requested2.'&date_requested1='.$date_requested1.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p-1).'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?date_requested2='.$date_requested2.'&date_requested1='.$date_requested1.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p + 1).'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ENDED - FUNCTIONS



//GENERATE REPORT
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($date_requested1,$date_requested2,$key,$status,$p,$maxp,$max) ;
$pages = linkpage($date_requested1,$date_requested2,$key,$status,$p,$maxp,$found[0]['max']) ;
//ENDED

?>   
<html>
<head>
<title>Create A Quote</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<!--calendar picker - setup-->
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script language="javascript">
		var curSubMenu = '';
		var selected_x_id = 0;
		
		function lead(id) 
		{
			previewPath = "viewLead.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function resume(id) 
		{
			previewPath = "../available-staff-resume.php?userid="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			
		
		function update(id) 
		{
			previewPath = "update_endorse_to_client.php?id="+id;
			window.open(previewPath,'_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
	
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') 
				hideSubMenu();
			
			eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
		}
		
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
		}
		
		function makeObject()
		{
			var x ; 
			var browser = navigator.appName ;
			if(browser == 'Microsoft Internet Explorer')
			{
				x = new ActiveXObject('Microsoft.XMLHTTP')
			}
			else
			{
				x = new XMLHttpRequest()
			}
			return x ;
		}
		var voucher_obj = makeObject()
		function update_voucher(id,voucher)
		{
			selected_x_id = id;
			var comments = document.getElementById('comments_'+id).value;
			var date_expire = document.getElementById('date_expire_'+id).value;
			voucher_obj.open('get', 'admin_request_for_interview_voucher_update.php?code_number='+voucher+'&date_expire='+date_expire+'&comment='+comments)
			voucher_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			voucher_obj.onreadystatechange = voucher_details_preview 
			voucher_obj.send(1)
			hideSubMenu();
		}
		function voucher_details_preview()
		{
			var data;
			data = voucher_obj.responseText
			if(voucher_obj.readyState == 4)
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML = data;
			}
			else
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML="<img src='images/ajax-loader.gif'>";
			}
		}			
		
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="">
<form name="form">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'bp-order-report-leftnav.php';?>
<br></td>
<td width=100% valign=top >



<!-- REPORT CONTAINER -->
<table width="100%" border="0" bgcolor="#2A629F" cellpadding="10" cellspacing="2">
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff" colspan="5">

						
					<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                      <tr>
							<td align="left" valign="top" bgcolor="#ffffff"> <font color="#000000"><strong>
								<form action="?" method="post" name="formtable">
								<table width="0%"  border="0" cellspacing="3" cellpadding="3">
									<tr>
										<td></td>
										<td><font size="1">(Client&nbsp;First&nbsp;Name&nbsp;/&nbsp;Client&nbsp;Last&nbsp;Name&nbsp;/&nbsp;Voucher)</font></td>							  
									</tr>								
									<tr>
										<td>	  
											<strong>Keyword</strong><em>(optional)</em>
										</td>
										<td><input type="text" id="key_id" name="key" value="<?php echo $key; ?>" class="select" /></td>							  
									</tr>
									<tr>
										<td scope="row"><font color="#000000"><strong>Date&nbsp;Requested Between</strong></font></td>
										<td>
                                        


													<table>
                                                    	<tr>
                                                        	<td><img align="absmiddle" src="../images/date-picker.gif" id="date_requested1_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                            <td>
                                        					<input type="text" name="date_requested1" id="id_date_requested1" class="text" value="<?php if($date_requested1 == "") echo "Any"; else echo $date_requested1; ?>">
															<script type="text/javascript">
																Calendar.setup({
																		inputField	: "id_date_requested1",
																		ifFormat	: "%Y-%m-%d",
																		button		: "date_requested1_button",
																		align		: "Tl",
																		showsTime	: false, 
																		singleClick	: true
																});
															</script>                                         
                                                            </td>
                                                        </tr>
													</table>
													<table>
                                                    	<tr>
                                                        	<td><img align="absmiddle" src="../images/date-picker.gif" id="date_requested2_button" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" /></td>
                                                            <td>
                                        					<input type="text" name="date_requested2" id="id_date_requested2" class="text" value="<?php if($date_requested2 == "") echo "Any"; else echo $date_requested2; ?>">
															<script type="text/javascript">
																Calendar.setup({
																		inputField	: "id_date_requested2",
																		ifFormat	: "%Y-%m-%d",
																		button		: "date_requested2_button",
																		align		: "T2",
																		showsTime	: false, 
																		singleClick	: true
																});
															</script>                                         
                                                            </td>
                                                        </tr>
													</table>                                                    

                                        

										</td>
									</tr>
									<tr>
										<td scope="row"><font color="#000000"><strong>Status</strong></font></td>
										<td>
											  <select size="1" class="text" name="status">
												<?php
													switch ($status) 
													{
														case "ACTIVE":
															echo "<option value='NEW' selected>ACTIVE</option>";
															echo "<option value='ARCHIVED'>ARCHIVED</option>";
															break;
														case "ARCHIVED":
															echo "<option value='ARCHIVED' selected>ARCHIVED</option>";
															echo "<option value='NEW'>ACTIVE</option>";
															break;
														default:
															echo "<option value='NEW' selected>ACTIVE</option>";
															echo "<option value='ARCHIVED'>ARCHIVED</option>";
															break;											
													}
												?>
											  </select>
										</td>							
									</tr>
									<tr>
										<td></td><td valign="top"><font color="#000000"><input type="submit" value="Search" name="submit" class="button">									
									</tr>
								</table>
								</form>
							</td>
						<tr />
					</table>
						
						
						
						
						
						</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" colspan="4">
						
								<table>
									<tr>
										<td><strong><FONT color="#FF0000">ACTION STATS:</FONT></strong></td>
									</tr>
									<tr>
										<td valign="top">Move&nbsp;to&nbsp;Active&nbsp;List</td>
										<td valign="top"><img src='images/forward.png' border=0 alt='Move to Active'></td>
									</tr>
									<tr>
										<td valign="top">Move&nbsp;to&nbsp;Archived&nbsp;List</td>
										<td valign="top"><img src='images/back.png' border=0 alt='Move to Archive'></td>
									</tr>	
									<tr>
										<td>Order&nbsp;Details</td>
										<td><img width="20" src="images/icon-people.gif" border="0"></td>
									</tr>	
								</table>
						
						</td>
                      </tr>
					  <tr>
						<td align="left" valign="middle" bgcolor="#2A629F" colspan="4"><font color="#FFFFFF"><strong>Showing Result for: <?php echo $found[0]['title']; ?></strong></font></td>
						<td colspan="4" align="right"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
					  </tr>						  

	
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Client</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Applicant</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Schedule</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Alternative&nbsp;Schedule</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Time&nbsp;Zone</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Requested</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Voucher</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Notes</strong></font></td>
                      </tr>	

					  
					  
<!----------------------------------------------------------------------------------------->
<?php
$x = 0;
if ($found[0]['max'] <> 0) 
{
	$total = count($found);
	for ($x=0; $x < $total; $x++) 
	{
?>

						  <tr>
							<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<table cellpadding="2" cellspacing="2">
									<tr>
										<td>
											<?php
												if($status == "NEW")
												{
											?>
															<a href="?key=<?php echo $key; ?>&rt=<?php echo $rt; ?>&status=<?php echo $status; ?>&stat=ARCHIVED&id=<?php echo $found[$x]['id']; ?>"><img src='images/forward.png' border=0 alt='Move to Archived List'></a>
											<?php	
												}
												else
												{
											?>
															<a href="?key=<?php echo $key; ?>&rt=<?php echo $rt; ?>&status=<?php echo $status; ?>&stat=NEW&id=<?php echo $found[$x]['id']; ?>"><img src='images/back.png' border=0 alt='Move to Active List'></a>											
											<?php	
												}
											?>
										</td>
										<td><a href="javascript: alert('development inprogress'); "><img width="20" src="images/icon-people.gif" border="0"></a></td>
										<td>
											<a href="javascript: lead(<?php echo $found[$x]['leads_id']; ?>); "><?php echo $found[$x]['client_name']; ?></a>
										</td>
									</tr>
								</table>
								<?php 
									$temp = truncate_comment($found[$x]['comment']);
								?>
								
								
								
								<!-- NOTES BOX -->	
								<div id="notes_<?php echo $x; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
								<table bgcolor="#2A629F" width="300" cellpadding="1" cellspacing="1"><tr><td>
									<table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5">
										<tr>
											<td align="right"><a href="javascript: hideSubMenu(); "><img src="images/action_delete.png" border="0"></a></td>
										</tr>
										<tr>
											<td>
												<font size="1"><?php echo $found[$x]['comment']; ?></font>
											</td>
										</tr>
									</table>
								</td></tr>	
								</table>	
								</div>
								<!-- ENDED - NOTES BOX -->	
																
																
																
								<!-- VOUCHER BOX -->								
								<div id="voucher_<?php echo $x; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
								<table bgcolor="#2A629F" width="300" cellpadding="1" cellspacing="1"><tr><td>
									<table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5">
										<tr>
											<td align="right" colspan="2"><a href="javascript: hideSubMenu(); "><img src="images/action_delete.png" border="0"></a></td>
										</tr>
										<tr>
											<td>Source: </td><td><font size="1"><?php echo $found[$x]['admin_name']; ?></font></td>
										</tr>										
										<tr>
											<td>Voucher&nbsp;Code: </td><td><font size="1"><?php echo $found[$x]['voucher_number']; ?></font></td>
										</tr>
										<tr>
											<td>Date&nbsp;Created: </td><td><font size="1"><?php echo $found[$x]['date_created']; ?></font></td>
										</tr>
										<tr>
											<td>Date&nbsp;Expire: </td>
											<td>
												<input type="text" id="date_expire_<?php echo $x; ?>" value="<?php echo $found[$x]['date_expire']; ?>" class="select" />
											</td>
										</tr>
										<tr>
											<td valign="top">Comment: </td><td>
											<textarea cols="20" id="comments_<?php echo $x; ?>" rows="3" border="textarea" class="select"><?php echo $found[$x]['voucher_comment']; ?></textarea>											
											</td>
										</tr>
										<tr>
											<td></td><td><font size="1"><input type="button" value="Save" name="save" class="button" onClick="javascript: update_voucher(<?php echo $x; ?>,'<?php echo $found[$x]['voucher_number']; ?>');"></font></td>
										</tr>																								
									</table>
								</td></tr>	
								</table>	
								</div>	
								<!-- ENDED - VOUCHER BOX -->																		
																
																
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<a href="javascript: resume(<?php echo $found[$x]['applicant_id']; ?>); "><?php echo $found[$x]['applicant_name']; ?></a>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['date_interview']; ?><br />
								<?php echo $found[$x]['time']; ?>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['alt_date_interview']; ?><br />
								<?php echo $found[$x]['alt_time']; ?>
							</td>							
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo $found[$x]['time_zone']; ?>	</td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo $found[$x]['date_added']; ?>	</td>
							<td align="left" valign="top" bgcolor="#FFFFFF" onClick="showSubMenu('voucher_<?php echo $x; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<a href="javascript: showSubMenu('voucher_<?php echo $x; ?>'); "><?php echo $found[$x]['voucher_number']; ?></a><br />
								<div id="voucher_details_<?php echo $x; ?>" STYLE='VISIBILITY: visible'>
								<font size="1">Date&nbsp;Created:&nbsp;<strong><?php echo $found[$x]['date_created']; ?></strong></font><br />
								<font size="1">Date&nbsp;Expire:&nbsp;<strong><?php echo $found[$x]['date_expire']; ?></strong></font><br />
								<font size="1">Status:&nbsp;<strong><?php echo $found[$x]['date_expire_status']; ?></strong></font>
								</div>
							</td>
							<td onClick="showSubMenu('notes_<?php echo $x; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top" width="90%">
								<a href="javascript: showSubMenu('notes_<?php echo $x; ?>'); "><?php echo $temp; ?></a>
							</td>
						  </tr>
<?php 
	}
}				
?>
<!------------------------------------------------------------------------------->
					

					
                      <tr>
                        <td align="left" valign="top" bgcolor="#2A629F"><font color="#FFFFFF"><strong>Total(<?php echo $x; ?>)</strong></font></td>
						<td align="right" valign="top" bgcolor="#2A629F" colspan="7"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
                      </tr>
		
                    </table>
<!-- ENDED - REPORT CONTAINER -->



</td>
</tr>
</table>
<?php include 'footer.php';?>		
</form>	
</body>
</html>
