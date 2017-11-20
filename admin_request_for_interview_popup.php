<?php
include('conf/zend_smarty_conf.php');
include 'config.php';
include 'conf.php';
include 'time.php';



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
$v = $_REQUEST['v'];

if(!$v){
	echo "Voucher Number is missing!";
	exit;
}
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
function search($v) 
{
	$from = "FROM tb_request_for_interview r, leads l";
	$order_by = "ORDER BY r.leads_id DESC";	
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
	r.voucher_number,
	r.session_id
	";

	//search - no search key
	$where = "WHERE r.voucher_number='$v' AND r.leads_id=l.id ";
	$query = "SELECT $fields $from $where $order_by";
	//ended

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
		$temp[$x]['session_id'] = $r['session_id'];


		if($temp[$x]['voucher_number'] == "" || $temp[$x]['voucher_number'] == NULL)
		{
				$temp[$x]['date_expire'] = "";
				$temp[$x]['date_expire_status'] = "";
		}
		else
		{
			$name = mysql_query("SELECT * FROM voucher WHERE code_number='".$temp[$x]['voucher_number']."' LIMIT 1");
			$temp[$x]['voucher_comment'] = mysql_result($name,0,"comment");
			$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
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
//ENDED - FUNCTIONS



//GENERATE REPORT
$found = search($v,$status) ;
//ENDED
?>

	
	
<html><head>
<title>Available Staff - Request For Interview</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script type="text/javascript" src="js/functions.js"></script>
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
	
<style type="text/css">
<!--
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;

visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
#searchbox
{
 padding-left:30px; padding-bottom:5px; padding-top:5px; margin-left:10px;
 border: 8px solid #E7F0F5;
 
}

#searchbox p
{
	margin-top:5px; margin-bottom:5px;
}


.pagination{
padding: 2px;
margin-top:10px; 
text-align:center;

}

.pagination ul{
margin: 0;
padding: 0;
text-align: center; /*Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 11px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

#tabledesign{
border:#666666 solid 1px;
}
#tabledesign tr:hover{
background-color:#FFFFCC;
}
-->
</style>
</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>


<table width="100%">
<tr>
	<td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
		<?php include 'applicationsleftnav.php';?>
	</td>

	<td valign="top"  style="width:82%;">
					<p style="padding:5px;"><a href="admin_request_for_interview_voucher.php">Voucher Manager</a> -> Voucher # <?php echo $v;?></p>
					
					<table width="100%" border="0" bgcolor="#2A629F" cellpadding="10" cellspacing="2">
					  <tr>
						<td align="left" valign="middle" bgcolor="#2A629F" colspan="8"><font color="#FFFFFF"><strong>Showing Result for: <?php echo $v; ?></strong></font></td>
					  </tr>						  

	
                      <tr>
                        <td width="15%" align="left" valign="top" bgcolor="#F1F1F3"><strong>Client</strong></td>
                        <td width="16%" align="left" valign="top" bgcolor="#F1F1F3"><strong>Applicant</strong></td>
                        <td width="11%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Schedule</strong></font></td>
						<td width="13%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Alternative&nbsp;Schedule</strong></font></td>
                        <td width="10%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Time&nbsp;Zone</strong></font></td>
                        <td width="10%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Requested</strong></font></td>
						<td width="13%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Voucher</strong></font></td>
						<td width="12%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Job Order Details</strong></font></td>
                      </tr>	

					  
					  
<!----------------------------------------------------------------------------------------->
<?php
$x = 0;
if ($found[0]['max'] <> 0) 
{
	$total = count($found);
	$counter=0;

	for ($x=0; $x < $total; $x++) 
	{
	
					$counter++;
			//check the session_id if existing in `request_for_interview_job_order`
			$request_for_interview_job_order_id ="";
			$job_position_id = "";
			$job_order_flag ="";
			$applicant_job_order_id ="";
			$sql = $db->select()
				->from('request_for_interview_job_order' , 'id')
				->where('lead_id =?' ,$found[$x]['leads_id'])
				->where('session_id =?' ,$found[$x]['session_id']);
			$request_for_interview_job_order_id = $db->fetchOne($sql);
			if($request_for_interview_job_order_id){
					//id, request_for_interview_job_order_id, no_of_applicant, proposed_start_date, duration_status, jr_cat_id, category_id, sub_category_id, date_created, form_filled_up, date_filled_up
					$sql= $db->select()
						->from('request_for_interview_job_order_position')
						->where('request_for_interview_job_order_id =?' , $request_for_interview_job_order_id);
					$job_positions = $db->fetchAll($sql);
					foreach($job_positions as $job_position){
						//id, request_for_interview_job_order_position_id, userid, work_status, working_timezone, start_work, finish_work, app_working_details_filled_up, app_working_details_date_filled_up
						$sql = $db->select()
							->from('request_for_interview_job_order_applicants' , 'id')
							->where('request_for_interview_job_order_position_id =?' , $job_position['id'])
							->where('userid =?' , $found[$x]['applicant_id']);
						$applicant_job_order_id = $db->fetchOne($sql);
						if($applicant_job_order_id){
							$jr_cat_id = $job_position['jr_cat_id'];
							$job_position_id = $job_position['id'];
							break;
						}	
					}
				
			}
	
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
															<a href="?v=<?php echo $v; ?>&stat=ARCHIVED&id=<?php echo $found[$x]['id']; ?>"><img src='images/forward.png' border=0 alt='Move to Archived List'></a>
											<?php	
												}
												else
												{
											?>
															<a href="?v=<?php echo $v; ?>&stat=NEW&id=<?php echo $found[$x]['id']; ?>"><img src='images/back.png' border=0 alt='Move to Active List'></a>											
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
								<?php 
								
								//echo $found[$x]['date_interview']; 
								$det = new DateTime($found[$x]['date_interview']);
								echo $det->format("M. j, Y");

								?><br />
								<?php echo $found[$x]['time']; ?>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php //echo $found[$x]['alt_date_interview']; 
								$det = new DateTime($found[$x]['alt_date_interview']);
								echo $det->format("M. j, Y");
								
								?><br />
								<?php echo $found[$x]['alt_time']; ?>
							</td>							
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo $found[$x]['time_zone']; ?>	</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
							<?php //echo $found[$x]['date_added']; 
								$det = new DateTime($found[$x]['date_added']);
								echo $det->format("M. j, Y");
							?>	</td>
							<td align="left" valign="top" bgcolor="#FFFFFF" onClick="showSubMenu('voucher_<?php echo $x; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<a href="javascript: showSubMenu('voucher_<?php echo $x; ?>'); "><?php echo $found[$x]['voucher_number']; ?></a><br />
								<div id="voucher_details_<?php echo $x; ?>" STYLE='VISIBILITY: visible'>
								<font size="1">Date&nbsp;Created:&nbsp;<strong><?php echo $found[$x]['date_created']; ?></strong></font><br />
								<font size="1">Date&nbsp;Expire:&nbsp;<strong><?php echo $found[$x]['date_expire']; ?></strong></font><br />
								<font size="1">Status:&nbsp;<strong><?php echo $found[$x]['date_expire_status']; ?></strong></font>
								</div>
							</td>
							<td bgcolor="#FFFFFF">
							<?php 
									if($applicant_job_order_id){
										echo "<span style='float:right;'><a href=javascript:popup_win('../asl/ShowJobSpecAppWorkingDetails.php?id=$job_position_id&jr_cat_id=$jr_cat_id&applicant_id=$applicant_job_order_id&view=True',820,600);><img src='images/flag_red.gif' border='0'></a></span>";
									}
							?>
							</td>
						  </tr>
<?php 
	}
}				
?>
<!------------------------------------------------------------------------------->
					

					
                      <tr>
                        <td align="left" valign="top" bgcolor="#2A629F" colspan="8"><font color="#FFFFFF"><strong>Total(<?php echo $x; ?>)</strong></font></td>
                      </tr>
		
                    </table>

    </td>
</tr>
</table>



</td>
</tr>
</table>
<?php include 'footer.php'; ?>	
</body>
</html>

