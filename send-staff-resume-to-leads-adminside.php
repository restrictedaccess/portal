<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'time_recording/TimeRecording.php';
putenv("TZ=Philippines/Manila");
//error_reporting(E_ALL);


//REDUCE THE SIZE OF COMMENTS
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ENDED


//SESSION CHECKER
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
//ENDED



//POST
$rt = $_REQUEST['rt'];
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
	mysql_query("UPDATE staff_resume_leads_sent SET status='$stat' WHERE id='$id'");
}
//ENDED



//FUNCTIONS
function search($rt,$key,$status,$p,$maxp,$max) 
{
	$set = ($p-1)*$maxp ;
	switch ($rt) 
	{
		case "today" :
			$a_1 = time();
			$b_1 = time() + (1 * 24 * 60 * 60);
			$a_ = date("Y-m-d"); 
			$b_ = date("Y-m-d",$b_1);
			$title = "Today (".date("M d, Y").")";
			break;
		case "yesterday" :
			$a_1 = time() - (1 * 24 * 60 * 60);
			$b_1 = time() - (1 * 24 * 60 * 60);
			$a_ = date("Y-m-d",$a_1);
			$b_ = date("Y-m-d",$b_1);
			$title = "Yesterday (".date("M d, Y",$a_1).")";
			break;
		case "curmonth" :
			$a_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
			$b_1 = mktime(0, 0, 0, date("n"), 31, date("Y"));
			$a_ = date("Y-m-d",$a_1);
			$b_ = date("Y-m-d",$b_1);
			$title = "Current Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
			break;
		case "curweek" :
			$wd_arr = array('Mo ', 'Tu ', 'We ', 'Th ', 'Fr ', 'Sa ', 'Su ');
			$a_1 = mktime(0, 0, 0,(int)date('m'),(int)date('d')+(1-(int)date('w')),(int)date('Y'));
			$b_1 = time();
			$a_ = date("Y-m-d",$a_1);
			$b_ = date("Y-m-d",$b_1);
			$title = "Current Week (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
			break;
		case "lmonth" : 
			$a_1 = mktime(0, 0, 0, date("n"), -31, date("Y"));
			$b_1 = mktime(0, 0, 0, date("n"), 0, date("Y"));
			$a_ = date("Y-m-d",$a_1);
			$b_ = date("Y-m-d",$b_1);
			$title = "Last Month (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
			break;
		case "last7" :
			$a_1 = time() - (14 * 24 * 60 * 60);
			$b_1 = time() - (7 * 24 * 60 * 60);
			$a_ = date("Y-m-d",$a_1);
			$b_ = date("Y-m-d",$b_1);
			$title = "Last 7 Days (".date("M d, Y", $a_1)."-".date("M d, Y", $b_1).")";
			break;
		case "alltime" :
			$a_1 = mktime(0, 0, 0, 1, 11, 2006);
			$b_1 = time();
			$a_ = date("Y-m-d",$a_1);			
			$b_ = date("Y-m-d",$b_1);
			$title = "All time (".date("M d, Y").")";			
			break;
		default :
			$a_ = date("Y-m-d"); 
			$b_ = date("Y-m-d",time() + (1 * 24 * 60 * 60));
			$title = "Today (".date("M d, Y").")";	
	}
	
	$from = "FROM staff_resume_leads_sent e, leads l, personal p ";
	$order_by = "ORDER BY e.date_added DESC LIMIT $set, $maxp";	
	$fields = "
	e.id,
	e.admin_id,
	e.agent_id,
	e.lead_id,
	e.userid,
	e.position_id,
	e.final_Interview,
	e.comment,
	e.status,
	e.date_added,
	l.lname as c_lname,
	l.fname as c_fname,
	p.fname as a_fname,
	p.lname as a_lname
	";

	//default	
	$where = "WHERE (DATE_FORMAT(e.date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND (e.lead_id=l.id) AND (e.userid=p.userid) AND e.status='ON HOLD'";
	$query = "SELECT $fields $from $where $order_by";
	//ended
	
	if(@isset($rt))
	{	
		if($key == "")
		{
			//search - no search key
			$where = "WHERE (DATE_FORMAT(e.date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND (e.lead_id=l.id) AND (e.userid=p.userid) AND e.status='$status' ";
			$query = "SELECT $fields $from $where $order_by";
			//ended
		}
		else
		{
			//search w/ keyword
			$where = "WHERE (DATE_FORMAT(e.date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND (e.lead_id=l.id) AND (e.userid=p.userid) AND e.status='$status' AND ((p.userid='$key' OR p.email='$key' OR p.fname LIKE '%$key%' OR p.lname LIKE '%$key%') OR (l.id='$key' OR l.email='$key' OR l.fname LIKE '%$key%' OR l.lname LIKE '%$key%'))";
			$query = "SELECT $fields $from $where $order_by";
			//ended			
		}
	}

	$result =  mysql_query($query);
	
	if(!isset($max))
	{
		$m =  mysql_query("SELECT e.id $from $where");
		$max = mysql_num_rows($m);
	}
	
	$x = 0 ;	
	while ($r = mysql_fetch_assoc($result)) 
	{
		$temp[$x]['title'] = $title;
		$temp[$x]['max'] = $max;
		$temp[$x]['id'] = $r['id'];
		$temp[$x]['leads_id'] = $r['lead_id'];
		$temp[$x]['applicant_id'] = $r['userid'];
		//get position
		$sql="SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='".$r['position_id']."' LIMIT 1";
		$s = mysql_query($sql);
		while(list($sub_category_name)=mysql_fetch_array($s))
		{
			$temp[$x]['position_name'] = $sub_category_name;
		}
		//end
		$temp[$x]['message'] = $r['comment'];
		$temp[$x]['status'] = $r['status'];
		$temp[$x]['date'] = $r['date_added'];
		$temp[$x]['applicant_name'] = $r['a_fname']." ".$r['a_lname'];
		$temp[$x]['client_name'] = $r['c_fname']." ".$r['c_lname'];
		$x++ ;
	}
	return $temp ;
}

function linkpage($rt,$key,$status,$p,$size,$d) 
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?rt='.$rt.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p-1).'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?rt='.$rt.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p + 1).'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ENDED - FUNCTIONS



//GENERATE REPORT
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($rt,$key,$status,$p,$maxp,$max) ;
$pages = linkpage($rt,$key,$status,$p,$maxp,$found[0]['max']) ;
//ENDED
?>


   
<html>
<head>
<title>Voucher Manager</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
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
<form action="?" method="post" name="formtable">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'adminleftnav.php';?>
<br></td>
<td width=100% valign=top >



<!-- REPORT CONTAINER -->
<table width="100%" border="0" bgcolor="#2A629F" cellpadding="10" cellspacing="2">
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff" colspan="4">

						
							<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
								<tr>
									<td align="left" valign="top" bgcolor="#ffffff">
							
										<table width="0%"  border="0" cellspacing="3" cellpadding="3">
											<tr>
												<td colspan="2">
													<font size="1">
														<strong>CLIENT: </strong>ID, First Name, Last Name & Email<br />
														<strong>CANDIDATE: </strong>userID, First Name, Last Name & Email
													</font>
												</td>
											</tr>								
											<tr>
												<td><strong>Keyword</strong><em>(optional)</em></td>
												<td><input type="text" id="key_id" name="key" value="<?php echo $key; ?>" class="select" /></td>							  
											</tr>
											<tr>
												<td scope="row"><font color="#000000"><strong>Date&nbsp;Sent</strong></font></td>
												<td>
																		  <select size="1" class="text" name="rt">
																			<?php
																											switch ($rt) {
																												case "today":
																													echo "<option value=\"$rt\" selected>today</option>";
																													break;
																												case "yesterday":
																													echo "<option value=\"$rt\" selected>yesterday</option>";
																													break;
																												case "curweek":
																													echo "<option value=\"$rt\" selected>current week</option>";
																													break;
																												case "curmonth":
																													echo "<option value=\"$rt\" selected>current month</option>";
																													break;
																												case "lmonth":
																													echo "<option value=\"$rt\" selected>last month</option>";
																													break;
																												case "last7":
																													echo "<option value=\"$rt\" selected>last 7 days</option>";
																													break;
																												case "alltime":
																													echo "<option value=\"$rt\" selected>all time</option>";
																													break;
																											}
																									?>
																			<option value="today">today</option>
																			<option value="yesterday">yesterday</option>
																			<option value="curweek">current week</option>
																			<option value="curmonth">current month</option>
																			<option value="lmonth">last month</option>
																			<option value="last7">last 7 days</option>
																			<option value="alltime">all time</option>
																		  </select>
												</td>
											</tr>
											<tr>
												<td scope="row"><font color="#000000"><strong>Status</strong></font></td>
												<td>
																		  <select size="1" class="text" name="status">
																			<?php
																				switch ($status) 
																				{
																					case "HIRED":
																						echo "<option value='ON HOLD'>ON HOLD</option>";
																						echo "<option value='HIRED' selected>HIRED</option>";
																						echo "<option value='REJECTED'>REJECTED</option>";
																						echo "<option value='ARCHIVED'>ARCHIVED</option>";
																						break;
																					case "REJECTED":
																						echo "<option value='ON HOLD'>ON HOLD</option>";
																						echo "<option value='HIRED'>HIRED</option>";
																						echo "<option value='REJECTED' selected>REJECTED</option>";
																						echo "<option value='ARCHIVED'>ARCHIVED</option>";
																						break;
																					case "ARCHIVED":
																						echo "<option value='ON HOLD'>ON HOLD</option>";
																						echo "<option value='HIRED'>HIRED</option>";
																						echo "<option value='REJECTED'>REJECTED</option>";
																						echo "<option value='ARCHIVED' selected>ARCHIVED</option>";
																						break;																						
																					default:
																						echo "<option value='ON HOLD' selected>ON HOLD</option>";
																						echo "<option value='HIRED'>HIRED</option>";
																						echo "<option value='REJECTED'>REJECTED</option>";
																						echo "<option value='ARCHIVED'>ARCHIVED</option>";
																						break;											
																				}
																			?>
																		  </select>
												</td>							
											</tr>
											<tr>
												<td></td><td valign="top"><input type="submit" value="Search" name="submit" class="button">									
											</tr>
										</table>
							
									</td>
								</tr>
							</table>
						
						
						
						
						
						</td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" colspan="3">
						
								<table cellpadding="2" cellspacing="2">
									<tr>
										<td colspan="2"><strong><FONT color="#FF0000">ACTION STATS:</FONT></strong></td>
									</tr>
									<tr>
										<td valign="top"><img src='images/on-hold.gif' border=0 alt='Move to Active'></td>
										<td valign="top">Move&nbsp;to&nbsp;On-Hold&nbsp;List</td>
									</tr>
									<tr>
										<td valign="top"><img src='images/archived.gif' border=0 alt='Move to Archive'></td>
										<td valign="top">Move&nbsp;to&nbsp;Archived&nbsp;List</td>
									</tr>	
									<tr>
										<td valign="top"><img src='images/hired.gif' border=0 alt='Move to Archive'></td>
										<td valign="top">Move&nbsp;to&nbsp;Hired&nbsp;List</td>
									</tr>				
									<tr>
										<td valign="top"><img src='images/rejected.gif' border=0 alt='Move to Archive'></td>
										<td valign="top">Move&nbsp;to&nbsp;Rejected&nbsp;List</td>
									</tr>																
								</table>
						
						</td>
                      </tr>
					  <tr>
						<td align="left" valign="middle" bgcolor="#2A629F" colspan="4"><font color="#FFFFFF"><strong>Showing Result for: <?php echo $found[0]['title']; ?></strong></font></td>
						<td colspan="3" align="right"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
					  </tr>						  

	
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Actions</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Leads</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><strong>Candidate</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Category&nbsp;Where&nbsp;Sent</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Status</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Sent</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3" width="20%"><font color="#000000"><strong>Message&nbsp;to&nbsp;Sender</strong></font></td>
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
											<a href="?key=<?php echo $key; ?>&rt=<?php echo $rt; ?>&status=<?php echo $_REQUEST['status']; ?>&stat=ON HOLD&id=<?php echo $found[$x]['id']; ?>">
											<img src='images/on-hold.gif' border=0 alt='On Hold'>
											</a>
										</td>
										<td>
											<a href="?key=<?php echo $key; ?>&rt=<?php echo $rt; ?>&status=<?php echo $_REQUEST['status']; ?>&stat=REJECTED&id=<?php echo $found[$x]['id']; ?>">
											<img src='images/rejected.gif' border=0 alt='Rejected'>
											</a>										
										</td>
										<td>
											<a href="?key=<?php echo $key; ?>&rt=<?php echo $rt; ?>&status=<?php echo $_REQUEST['status']; ?>&stat=HIRED&id=<?php echo $found[$x]['id']; ?>">
											<img src='images/hired.gif' border=0 alt='Hired'>
											</a>
										</td>
										<td>
											<a href="?key=<?php echo $key; ?>&rt=<?php echo $rt; ?>&status=<?php echo $_REQUEST['status']; ?>&stat=ARCHIVED&id=<?php echo $found[$x]['id']; ?>">
											<img src='images/archived.gif' border=0 alt='Archived'>
											</a>
										</td>									
									</tr>
								</table>
								<?php 
									$temp = truncate_comment($found[$x]['message']);
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
												<font size="1"><?php echo $found[$x]['message']; ?></font>
											</td>
										</tr>
									</table>
								</td></tr>	
								</table>	
								</div>
								<!-- ENDED - NOTES BOX -->	
																
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<a href="javascript: lead(<?php echo $found[$x]['leads_id']; ?>); "><?php echo $found[$x]['client_name']; ?></a>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<a href="javascript: resume(<?php echo $found[$x]['applicant_id']; ?>); "><?php echo $found[$x]['applicant_name']; ?></a>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['position_name']; ?><br />
							</td>							
							<td onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top">
								<?php echo $found[$x]['status']; ?>
							</td>
							<td onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top">
								<?php echo $found[$x]['date']; ?>
							</td>
							<td onclick="showSubMenu('notes_<?php echo $x; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top" width="90%">
								<a href="javascript: showSubMenu('notes_<?php echo $x; ?>'); "><?php echo $found[$x]['message']; ?></a>
							</td>														
						  </tr>
<?php 
	}
}				
?>
<!------------------------------------------------------------------------------->
					

					
                      <tr>
                        <td align="left" valign="top" bgcolor="#2A629F"><font color="#FFFFFF"><strong>Total(<?php echo $x; ?>)</strong></font></td>
						<td align="right" valign="top" bgcolor="#2A629F" colspan="6"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
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
