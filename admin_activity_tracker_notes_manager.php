<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf.php');

	$rt = @$_REQUEST["rt"];
	$admin_id = @$_REQUEST["admin_id"];
	$status = @$_REQUEST["status"];
	
	$start_month_from = @$_REQUEST["start_month_from"];
	$start_day_from = @$_REQUEST["start_day_from"];
	$start_year_from = @$_REQUEST["start_year_from"];
	
	$start_month_to = @$_REQUEST["start_month_to"];
	$start_day_to = @$_REQUEST["start_day_to"];
	$start_year_to = @$_REQUEST["start_year_to"];
		
	$country = @$_REQUEST["country"];
	$tz = @$_REQUEST["tz"];	
	$search1 = @$_REQUEST["search1"];
	$search2 = @$_REQUEST["search2"];

			switch ($rt) {
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
?>

	
	
<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script language="javascript">
		var curSubMenu = '';
		


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
		var request = makeObject()
		
		function update_activity_tracker(type,id)
		{
			request.open('get', 'admin_activity_traqcker_notes_manager_archive.php?type='+type+'&id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.send(1)
			if(type=='DELETE')
			{
				alert("Note has been deleted.");
				document.getElementById("action"+id).innerHTML="<FONT color='#FF0000'><strong>DELETED</strong></FONT>";
			}	
			else	
			{
				alert("Note has been moved.");	
				document.getElementById("action"+id).innerHTML="<FONT color='#FF0000'><strong>ARCHIVED</strong></FONT>";
			}	
		}

		
		function add_notes() 
		{
			previewPath = "admin_activity_tracker_create_notes.php";
			window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		
		function resume(id) 
		{
			previewPath = "application_apply_action_popup.php?userid="+id;
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
</script>
<script type="text/javascript" src="category/category.js"></script>

<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>
	
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

<table width="100%">
<tr>
	<td valign="top"  style="width:100%;">












<center>
					<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3" colspan="8> <font color="#000000"><strong>
                          <form action="" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">
                            <table width="0%"  border="0" cellspacing="0" cellpadding="2">
							  <tr>
							  	<td><font color="#000000">Date&nbsp;Added</font></td>
								<td><font color="#000000">Admin Users</font></td>
								<td><font color="#000000">Status</font></td>
							  </tr>	
                              <tr>
                                <td>
                                  <select size="1" name="rt" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
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
							<td>	  
                                  <select size="1" name="admin_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    						<?php
																$query = "SELECT admin_id,admin_fname,admin_lname FROM admin";
																$r_e = mysql_query($query);
																$is_true = 0;
																while ($row = mysql_fetch_assoc($r_e)) 
																{
																	if($admin_id == $row["admin_id"])
																	{
																		$is_true = 1;
																		echo "<option value='".$row["admin_id"]."' selected>".$row["admin_fname"]." ".$row["admin_lname"]."</option>";
																	}
																	else
																	{
																		echo "<option value='".$row["admin_id"]."'>".$row["admin_fname"]." ".$row["admin_lname"]."</option>";
																	}
																}
																if($is_true == 0)
																{
																	echo "<option value='' selected>Any</option>";
																}
																else
																{
																	echo "<option value=''>Any</option>";
																}	
															?>																	
                                  </select>
                                </td>
								<td>
                                  <select size="1" name="status" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                    <?php
										if($status == "ARCHIVED")
										{
											echo '
											<option value="ACTIVE">Active</option>
											<option value="ARCHIVED" SELECTED>Archived</option>
											';
										}
										else
										{
											echo '
											<option value="ACTIVE" SELECTED>Active</option>
											<option value="ARCHIVED">Archived</option>
											';
										}
									?>
                                  </select>								
								</td>
                                <td valign="top">
                                  <input type="submit" value="Search" name="search1" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                </td>
                              </tr>
                            </table>
                          </form>

                        </td>
                      </tr>
					  <tr>
					  	<td colspan=8 color="#FFFFFF">
                          <form action="" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">
                            <table width="0%"  border="0" cellspacing="0" cellpadding="2">
							  <tr>
							  	<td><font color="#000000">Date&nbsp;to&nbsp;Execute Between</font></td>
								<td><font color="#000000">Country/Time&nbsp;Zone</font></td>
								<td><font color="#000000"></font></td>
							  </tr>	
                              <tr>
                                <td>
											<table width='100' border='0'>
												<tr>
													<td>
														<SELECT NAME='start_month_from' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
															<OPTION VALUE='01'>Jan</OPTION>
															<OPTION VALUE='02'>Feb</OPTION>
															<OPTION VALUE='03'>Mar</OPTION>
															<OPTION VALUE='04'>Apr</OPTION>
															<OPTION VALUE='05'>May</OPTION>
															<OPTION VALUE='06'>Jun</OPTION>
															<OPTION VALUE='07'>Jul</OPTION>
															<OPTION VALUE='08'>Aug</OPTION>
															<OPTION VALUE='09'>Sep</OPTION>
															<OPTION VALUE='10'>Oct</OPTION>
															<OPTION VALUE='11'>Nov</OPTION>
															<OPTION VALUE='12'>Dec</OPTION>
														</SELECT>
													</td>
													<td>
														<select name='start_day_from' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
															<option value='01'>01</option>
															<option value='02'>02</option>
															<option value='03'>03</option>
															<option value='04'>04</option>
															<option value='05'>05</option>
															<option value='06'>06</option>
															<option value='07'>07</option>
															<option value='08'>08</option>
															<option value='09'>09</option>
															<option value='10'>10</option>
															<option value='11'>11</option>
															<option value='12'>12</option>
															<option value='13'>13</option>
															<option value='14'>14</option>
															<option value='15'>15</option>
															<option value='16'>16</option>
															<option value='17'>17</option>
															<option value='18'>18</option>
															<option value='19'>19</option>
															<option value='20'>20</option>
															<option value='21'>21</option>
															<option value='22'>22</option>
															<option value='23'>23</option>
															<option value='24'>24</option>
															<option value='25'>25</option>
															<option value='26'>26</option>
															<option value='27'>27</option>
															<option value='28'>28</option>
															<option value='29'>29</option>
															<option value='30'>30</option>
															<option value='31'>31</option>
														</select>
													</td>
													<td>
														<SELECT NAME='start_year_from' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
															<OPTION VALUE='2010'>2010</OPTION>
															<OPTION VALUE='2011'>2011</OPTION>
														</SELECT>
													</td>
													<td>and</td>
													<td>
														<SELECT NAME='start_month_to' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
															<OPTION VALUE='01'>Jan</OPTION>
															<OPTION VALUE='02'>Feb</OPTION>
															<OPTION VALUE='03'>Mar</OPTION>
															<OPTION VALUE='04'>Apr</OPTION>
															<OPTION VALUE='05'>May</OPTION>
															<OPTION VALUE='06'>Jun</OPTION>
															<OPTION VALUE='07'>Jul</OPTION>
															<OPTION VALUE='08'>Aug</OPTION>
															<OPTION VALUE='09'>Sep</OPTION>
															<OPTION VALUE='10'>Oct</OPTION>
															<OPTION VALUE='11'>Nov</OPTION>
															<OPTION VALUE='12'>Dec</OPTION>
														</SELECT>
													</td>
													<td>
														<select name='start_day_to' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
															<option value='01'>01</option>
															<option value='02'>02</option>
															<option value='03'>03</option>
															<option value='04'>04</option>
															<option value='05'>05</option>
															<option value='06'>06</option>
															<option value='07'>07</option>
															<option value='08'>08</option>
															<option value='09'>09</option>
															<option value='10'>10</option>
															<option value='11'>11</option>
															<option value='12'>12</option>
															<option value='13'>13</option>
															<option value='14'>14</option>
															<option value='15'>15</option>
															<option value='16'>16</option>
															<option value='17'>17</option>
															<option value='18'>18</option>
															<option value='19'>19</option>
															<option value='20'>20</option>
															<option value='21'>21</option>
															<option value='22'>22</option>
															<option value='23'>23</option>
															<option value='24'>24</option>
															<option value='25'>25</option>
															<option value='26'>26</option>
															<option value='27'>27</option>
															<option value='28'>28</option>
															<option value='29'>29</option>
															<option value='30'>30</option>
															<option value='31'>31</option>
														</select>
													</td>
													<td>
														<SELECT NAME='start_year_to' style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
															<OPTION VALUE='2010'>2010</OPTION>
															<OPTION VALUE='2011'>2011</OPTION>
														</SELECT>
													</td>													
												</tr>
											</table>
							</td>
							<td>	  
                                  <select size="1" name="country" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
									<?php
														$is_executed = 0;
														$queryAllTimezone = "SELECT * FROM timezone_lookup";
														$tz_result = $db->fetchAll($queryAllTimezone);
														foreach($tz_result as $tz_result)
														{
															switch($tz_result['timezone'])
															{
																case "PST8PDT":
																	$admin_timezone_display = "America/San Francisco";
																	break;
																case "NZ":
																	$admin_timezone_display = "New Zealand/Wellington";
																	break;
																case "NZ-CHAT":
																	$admin_timezone_display = "New Zealand/Chatham_Islands";
																	break;
																default:
																	$admin_timezone_display = $tz_result['timezone'];
																	break;
															}			
															echo "<OPTION VALUE='".$tz_result['timezone']."'>".$admin_timezone_display."</OPTION>";
														}
														if($is_executed == 0)
														{
															echo "<OPTION VALUE='' SELECTED></OPTION>";
														}									
									?>
                                  </select>
                                </td>
                                <td valign="top" align="left">
                                  <input type="submit" value="Search" name="search2" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                                </td>
                              </tr>
                            </table>
                          </form>
						
						</td>
					  </tr>	
					  <tr><td colspan=9><input type="button" onClick="javascript: add_notes(); " value="Create Note" name="submit" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>&nbsp;&nbsp;Showing Result for: <?php echo @$title; ?> </td>				  					  


					  <?php if(isset($search1) || isset($search2)) { ?>
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font size="1"><em>Delete/Archive</em></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Admin</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Subcontractor</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Client</strong></font></td>						
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Method</strong></font></td>				
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Country</strong></font></td>						
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;to&nbsp;Execute</strong></font></td>	
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Added</strong></font></td>	
						<td align="left" valign="top" bgcolor="#F1F1F3" width="100%"><font color="#000000"><strong>Notes</strong></font></td>					
                      </tr>	
					  
					<?php					
						if(isset($search1))
						{
							$s_c = " AND status='$status'";
							if($admin_id != "")
							{
								$s_c = $s_c . " AND admin_id= '$admin_id'";
							}
							
							$query = "SELECT * FROM tb_admin_activity_tracker_notes WHERE (DATE_FORMAT(date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') $s_c";
							$r_e = mysql_query($query);
						}
						else
						{
							$date_to_execute_from = $start_year_from."-".$start_month_from."-".$start_day_from;
							$date_to_execute_to = $start_year_to."-".$start_month_to."-".$start_day_to;
							
							$s_c = " AND status='ACTIVE'";
							if($country != "")
							{
								$s_c = $s_c . " AND country_city='$country'";
							}
							
							$query = "SELECT * FROM tb_admin_activity_tracker_notes WHERE (DATE_FORMAT(date_to_execute_from,'%Y-%m-%d') BETWEEN '$date_to_execute_from' AND '$date_to_execute_to' AND DATE_FORMAT(date_to_execute_to,'%Y-%m-%d') <= '$date_to_execute_to') $s_c";
							$r_e = mysql_query($query);
						}
							while ($row = mysql_fetch_assoc($r_e)) 
							{
								$i++;
					?>
						
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff">
							<div id="action<?php echo $row["id"]; ?>">
								 <?php if($status == "ACTIVE") { ?><table><tr><td><a href="javascript: update_activity_tracker('DELETE',<?php echo $row["id"]; ?>); "><img src="images/action_delete.gif" border=0></a></td><td><a href="javascript: update_activity_tracker('ARCHIVE',<?php echo $row["id"]; ?>); "><img src="images/external.gif" border=0></a></td></table><?php } ?>
							</div>
						</td>
						
                        <td align="left" valign="top" bgcolor="#ffffff">
								<?php 
									$name = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$row["admin_id"]."' LIMIT 1");
									$fname = mysql_result($name,0,"admin_fname");
									$lname = mysql_result($name,0,"admin_lname");
									$full_name = $fname." ".$lname;
									echo str_replace(" ", "&nbsp;", $full_name)
								?>
						</td>
                        <td align="left" valign="top" bgcolor="#ffffff">
								<a href="javascript: resume(<?php echo $row["subcon_id"]; ?>); ">
								<?php 
									$name = mysql_query("SELECT fname, lname FROM personal WHERE userid='".$row["subcon_id"]."' LIMIT 1");
									$fname = mysql_result($name,0,"fname");
									$lname = mysql_result($name,0,"lname");
									$full_name = $fname." ".$lname;
									echo str_replace(" ", "&nbsp;", $full_name)
								?>
								</a>						
						</td>
                        <td align="left" valign="top" bgcolor="#ffffff">
								<?php 
									$name = mysql_query("SELECT fname, lname FROM leads WHERE id='".$row["client_id"]."' LIMIT 1");
									$fname = mysql_result($name,0,"fname");
									$lname = mysql_result($name,0,"lname");
									$full_name = $fname." ".$lname;
									echo str_replace(" ", "&nbsp;", $full_name)
								?>							
						</td>						
                        <td align="left" valign="top" bgcolor="#ffffff">
							<?php echo $row["method"]; ?>						
						</td>						
                        <td align="left" valign="top" bgcolor="#ffffff">
							<?php echo $row["country_city"]; ?>						
						</td>
                        <td align="left" valign="top" bgcolor="#ffffff">
							<?php 
								$date_to_execute_to = $row["date_to_execute_to"]; 
								$d_today = date("Y-m-d"); 
								if($date_to_execute_to < $d_today)
								{
									echo '<strong><font color="#FF0000">Completed</font></strong>';
								}
								else
								{
									echo $row["date_details"]; 								
								}
							?>
									
						</td>	
						<td align="left" valign="top" bgcolor="#ffffff">
							<?php echo $row["date_added"]; ?>
						</td>
						<td onClick="showSubMenu('notes_<?php echo $i; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top" width="90%">
							<?php 
								$temp = str_split($row["note"],40);
								echo $temp[0]."...";
							?>
							<div id="notes_<?php echo $i; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
							<table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5">
								<tr>
									<td align="right"><font size="1"><i>(<a href="javascript: hideSubMenu(); ">Close</a>)</i></font></td>
								</tr>
								<tr>
									<td>
										<font size="1"><?php echo @$row["note"]; ?></font>
									</td>
								</tr>
							</table>
							</div>
						</td>						
                      </tr>							  
					<?php 
						}
					?>
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3" colspan=9><font color="#000000"><strong>Total(<?php echo $i; ?>)</strong></font></td>
                      </tr>
					<?php
						}	
					?>										  

		  
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff" colspan="12">&nbsp;</td>
                      </tr>		
                    </table>
















    </td>
</tr>
</table>



</td>
</tr>
</table>
<input type='hidden' id='applicants' name="applicants" >
<script type="text/javascript">
<!--
function goto(id,stat) 
{
	location.href = "mark_applicantsphp_bycategory.php?stat=<?php echo $stat; ?>&t10_category_id=<?php echo $t10; ?>&t10_category_name=<?php echo $t10_category_name; ?>&main_category_id=<?php echo $main_category_id; ?>&sub_category_id=<?php echo $sub_category_id; ?>&stat=<?php echo $stat; ?>&action=<?php echo $action; ?>&category_a=<?php echo @$category_a; ?>&view_a=<?php echo @$view_a; ?>&rt=<?php echo @$rt; ?>&category=<?php echo @$category; ?>&month_a=<?php echo $month_a; ?>&day_a=<?php echo $day_a; ?>&year_a=<?php echo $year_a; ?>&month_b=<?php echo $month_b; ?>&day_b=<?php echo $day_b; ?>&year_b=<?php echo $year_b; ?>&type=<?php echo $type; ?>&key=<?php echo $key; ?>&view=<?php echo $view; ?>&date_check=<?php echo $date_check; ?>&key_check=<?php echo $key_check; ?>
&id="+id;
}
	
function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2 =new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true)
		{
			if(ins[i].value!="" || ins[i].value!="undefined")
			{
				vals[j]=ins[i].value;
				//vals2[j]=id;
				j++;
			}		
		}
	}
document.getElementById("emails").value =(vals);
}

function check_val2()
{

userval =new Array();
var userlen = document.form.userss.length;
for(i=0; i<userlen; i++)
{
	if(document.form.userss[i].checked==true)
	{	
	//	document.getElementById("applicants").value+=(id);
		//push.userval=(id);
		userval.push(document.form.userss[i].value);
	}
}
document.getElementById("applicants").value=(userval);
}

-->
</script>



<script type="text/javascript">
<!--
getAllCategory();
-->
</script>

</body>
</html>



