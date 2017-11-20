<?php
include 'config.php';
include 'conf.php';
include 'time.php';

	$rt = @$_POST['rt'];
	if(@isset($_GET['rt'])){
		$rt = @$_GET['rt'];
	}
	
	$status = @$_POST['status'];
	if(@isset($_GET['status'])){
		$status = @$_GET['status'];
	}	

		//reporting code
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


	$query = "SELECT DISTINCT(e.client_name), l.id, l.fname, l.lname
	FROM leads l, tb_endorsement_history e
	WHERE (DATE_FORMAT(e.date_endoesed,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND l.id = e.client_name AND l.status='client' $stat";
	if(@isset($rt))
	{	
	
		switch(@$_POST["status"])
		{
			case "On Hold":
				$stat = "AND e.status='On Hold(archived)'";
				break;
			case "Hired":
				$stat = "AND e.status='Hired(archived)'";
				break;
			case "Rejected":
				$stat = "AND e.status='Rejected(archived)'";
				break;
			default:
				$stat = "AND (e.status='On Hold(archived)' || e.status='Hired(archived)' || e.status='Rejected(archived)' || e.status='Active(archived)')";
				break;	
		}

		$query = "SELECT DISTINCT(e.client_name), l.id, l.fname, l.lname
		FROM leads l, tb_endorsement_history e
		WHERE (DATE_FORMAT(e.date_endoesed,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND l.id = e.client_name AND l.status='client' $stat";
	}
	if(@isset($_GET["delete"]))
	{
		$id = @$_GET["delete"];
		$a = "DELETE FROM tb_endorsement_history WHERE id='$id'";
		$r_e = mysql_query($a);		
	}
		
	if(@isset($_GET["stat"]))
	{
		$id = @$_GET["id"];
		$stat = @$_GET["stat"];
		$r = str_replace("(archived)", "", $stat);
		$a = "UPDATE tb_endorsement_history SET status='$r' WHERE id='$id'";
		$r_e = mysql_query($a);		
	}		
?>

	
	
	
<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script language="javascript">
		var curSubMenu = '';
		
		function resume(id) 
		{
			previewPath = "popup_resume.php?userid="+id;
			window.open(previewPath,'_blank','width=630,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}		
				
		function update(id) 
		{
			previewPath = " update_endorse_to_client.php?id="+id;
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

<? include 'header.php';?>
<? include 'admin_header_menu.php';?>



<table width="106%">
<tr>
	<td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
		<? include 'applicationsleftnav.php';?>
	</td>
	<td valign="top"  style="width:100%;">












<center>
					<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="10" cellspacing="1">
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff" colspan="6> <font color="#000000"><strong>
						ARCHIVED PAGE<br /><br />
                          <form action="" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">
                            <table width="0%"  border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td scope="row"><font color="#000000"><strong>Endorsement&nbsp;Date</strong></font></td>
                                <td><font color="#000000"><strong>
                                  <select size="1" name="rt">
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
								  Status
							</td>
							<td>	  
                                  <select size="1" name="status">
                                    						<?php
																	switch ($status) 
																	{
																		case "On Hold":
																			echo "<option value=\"$status\" selected>On Hold(archived)</option>";
																			break;																	
																		case "Hired":
																			echo "<option value=\"$status\" selected>Hired(archived)</option>";
																			break;
																		case "Rejected":
																			echo "<option value=\"$status\" selected>Rejected(archived)</option>";
																			break;
																		default:
																			echo "<option value='' selected>Any</option>";
																			break;
																	}
															?>
                                    <option value="On Hold">On Hold(archived)</option>
                                    <option value="Hired">Hired(archived)</option>
                                    <option value="Rejected">Rejected(archived)</option>
                                    <option value="">Any</option>
                                  </select>
                                </td>
                                <td valign="top"><font color="#000000">
                                  <input type="submit" value="Search" name="submit">
                                </td>
                                <td valign="top"><font color="#000000">
                                  <input type="button" onclick="javascript: window.location='application_endorsement_summary_report.php'; " value="Go to Active Page" name="submit">
                                </td>
                              </tr>
                            </table>
                          </form>

                        </strong></td>
                        
                      </tr>
					  

						<tr><td align="left" valign="middle" bgcolor="#FFFFFF" colspan="6">Showing Result for: <?php echo @$title; ?></td></tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Endorsements</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date&nbsp;Endorsed</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Final&nbsp;Interview</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Status</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Comment</strong></font></td>
                      </tr>	
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
<!----------------------------------------------------------------------------------------->
<?php					  
		$r_s = mysql_query($query);
		$i = 0;
		while ($row = mysql_fetch_assoc($r_s)) 
		{					
?>		  
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3" colspan="12"><font color="#000000"><strong><?php echo strtoupper($row['fname']." ".$row['lname']); ?></strong></font></td>
                      </tr>					  
					  
					  
<?php
						$id = $row["id"];
						
						switch(@$_POST["status"])
						{
							case "On Hold":
								$stat = "AND status='On Hold(archived)'";
								break;
							case "Hired":
								$stat = "AND status='Hired(archived)'";
								break;
							case "Rejected":
								$stat = "AND status='Rejected(archived)'";
								break;
							default:
								$stat = "AND (status='On Hold(archived)' || status='Hired(archived)' || status='Rejected(archived)' || status='Active(archived)')";
								break;	
						}
															
						$query = "SELECT *
						FROM tb_endorsement_history
						WHERE client_name = '$id' AND (DATE_FORMAT(date_endoesed,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') $stat";
						$r_e = mysql_query($query);
						
						while ($row = mysql_fetch_assoc($r_e)) 
						{
							$i++;
?>
						  <tr>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<table>
									<tr>
										<td><a href="?rt=<?php echo $rt; ?>&status=<?php echo $status; ?>&stat=<?php echo $row["status"]."(archived)"; ?>&id=<?php echo $row["id"]; ?>"><img src='images/back.png' border=0 alt='Move to Archive'></a></td><td><?php echo @$row["position"]; ?><em>(<a href="javascript: update(<?php echo $row["id"]; ?>); ">update</a>)</em></td>
									</tr>
								</table>
								<div id="notes_<?php echo $i; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
									<table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5">
										<tr>
											<td align="right"><font size="1"><i>(<a href="javascript: hideSubMenu(); ">Close</a>)</i></font></td>
										</tr>
										<tr>
											<td>
												<font size="1"><?php echo @$row["comment"]; ?></font>
											</td>
										</tr>
									</table>
								</div>								
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<a href="javascript: resume(<?php echo $row["userid"]; ?>); ">
								<?php 
									$name = mysql_query("SELECT fname, lname FROM personal WHERE userid='".$row["userid"]."' LIMIT 1");
									$fname = mysql_result($name,0,"fname");
									$lname = mysql_result($name,0,"lname");
									echo $fname." ".$lname;
								?>
								</a>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$row["date_endoesed"]; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$row["final_Interview"]; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$row["status"]; ?></td>
							<td onclick="showSubMenu('notes_<?php echo $i; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; " bgcolor=#FFFFFF valign="top" width="90%">
								<?php 
									$temp = str_split($row["comment"],40);
									echo $temp[0]."...";
								?>
							</td>
						  </tr>
<?php 
						}
		}				
?>
<!------------------------------------------------------------------------------->
					
					
					
					
					
					
					
					
					
					
					
					
					
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Total(<?php echo $i; ?>)</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$pre_screened; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$Unprocessed; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$shortlist; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$selected; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$subcontracted; ?></strong></font></td>
                      </tr>
					  
		  
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


<? include 'footer.php';?>	
</body>
</html>



