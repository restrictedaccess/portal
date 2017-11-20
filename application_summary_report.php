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



	//fix data ---- remove this after execution
	//$query = "SELECT id, jobposition FROM posting";
	//$r_s = mysql_query($query);
	//while ($row = mysql_fetch_assoc($r_s)) 
	//{
		//$id = $row["id"];
		//$p = $row["jobposition"];
		//mysql_query("UPDATE tb_endorsement_history SET position='$id' WHERE position='$p'");
	//}	
	//end
	
	
	if(@isset($rt))
	{	
		$pre_screened = 0;
		$Unprocessed = 0;
		$shortlist = 0;
		$selected = 0;
		$subcontracted = 0;
		$no_Potential = 0;
		$endorsed = 0;
		$others = 0;
		$i = 0;	
		$stat = $status;
		
		if($stat == "ACTIVE")
		{
			$query = "SELECT id, lead_id, jobposition FROM posting WHERE status='ACTIVE' AND (DATE(date_created) BETWEEN '$a_' AND '$b_')";
		}
		elseif($stat == "ARCHIVE")
		{
			$query = "SELECT id, lead_id, jobposition FROM posting WHERE status='ARCHIVE' AND (DATE(date_created) BETWEEN '$a_' AND '$b_')";
		}
		elseif($stat == "NEW")
		{
			$query = "SELECT id, lead_id, jobposition FROM posting WHERE status='NEW' AND (DATE(date_created) BETWEEN '$a_' AND '$b_')";
		}		
		else
		{
			$query = "SELECT id, lead_id, jobposition, date_created FROM posting WHERE (DATE(date_created) BETWEEN '$a_' AND '$b_')";
		}		
			
		$r_s = mysql_query($query);
		while ($row = mysql_fetch_assoc($r_s)) 
		{
			$id = $row["id"];
			$counter_active_jobposition[$i] = $row["jobposition"];
			
			//client
			$l_id = $row['lead_id'];
			$l = mysql_query("SELECT fname, lname FROM leads WHERE id='$l_id' LIMIT 1") ;
			$counter_client[$i] = @mysql_result($l,0,"fname") . " " . @mysql_result($l,0,"lname") ;	
			//end
			
			//date posted
			$counter_date_posted[$i] = $row['date_created'];
			//end			
								
			//shortlist
			$query = "SELECT DISTINCT(a.userid)
			FROM personal a, tb_shortlist_history s
			WHERE a.userid = s.userid AND s.position = '$id'";
			$q = mysql_query($query);
			$counter_shortlist[$i] = mysql_num_rows($q);
			$counter_shortlist_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Shortlist\','.$id.','.$l_id.'); ">';
			if($counter_shortlist[$i] == "") $counter_shortlist[$i] = 0;
			//end shortlist
			
			//endorsement
			$query = "SELECT DISTINCT(a.userid)
			FROM personal a, tb_endorsement_history e
			WHERE a.userid = e.userid AND e.position = '$id'";
			$q = mysql_query($query);
			$counter_endorsed[$i] = mysql_num_rows($q);
			$counter_endorsed_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Endorsed\','.$id.','.$l_id.'); ">';
			if($counter_endorsed[$i] == "") $counter_endorsed[$i] = 0;
			//end endorsement			

			//subcontructed
			$query = "SELECT DISTINCT(s.userid)
			FROM subcontractors s
			WHERE s.posting_id = '$id' AND s.status='ACTIVE'";
			$q = mysql_query($query);
			$counter_subcontracted[$i] = mysql_num_rows($q);
			$counter_subcontracted_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Subcontracted\','.$id.','.$l_id.'); ">';
			if($counter_subcontracted[$i] == "") $counter_subcontracted[$i] = 0;
			//end subcontructed

			//pre screened
			$query = "SELECT DISTINCT(a.userid)
			FROM applicants a
			WHERE a.posting_id = '$id' AND a.status = 'Pre-Screen'";
			$q = mysql_query($query);
			$counter_pre_screened[$i] = mysql_num_rows($q);
			$counter_pre_screened_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Pre-Screened\','.$id.','.$l_id.'); ">';
			if($counter_pre_screened[$i] == "") $counter_pre_screened[$i] = 0;
			//pre screened

			//pre no potential
			$query = "SELECT DISTINCT(a.userid)
			FROM applicants a
			WHERE a.posting_id = '$id' AND a.status = 'No Potential'";
			$q = mysql_query($query);
			$counter_no_potential[$i] = mysql_num_rows($q);
			$counter_no_potential_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'No Potential\','.$id.','.$l_id.'); ">';
			if($counter_no_potential[$i] == "") $counter_no_potential[$i] = 0;
			//end
	
			//pre Unprocessed
			$query = "SELECT DISTINCT(a.userid)
			FROM applicants a
			WHERE a.posting_id = '$id' AND a.status = 'Unprocessed'";
			$q = mysql_query($query);
			$counter_unprocessed[$i] = mysql_num_rows($q);
			$counter_unprocessed_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Unprocessed\','.$id.','.$l_id.'); ">';
			if($counter_unprocessed[$i] == "") $counter_unprocessed[$i] = 0;
			//end

			$counter_each_position_total[$i] = $counter_shortlist[$i]+$counter_endorsed[$i]+$counter_selected[$i]+$counter_subcontracted[$i]+$counter_pre_screened[$i]+$counter_no_potential[$i]+$counter_unprocessed[$i];
			$counter_each_position_total_link[$i] = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Right_Total\','.$id.','.$l_id.'); ">';
			
			$pre_screened = $pre_screened + $counter_pre_screened[$i];
			$Unprocessed = $Unprocessed + $counter_unprocessed[$i];
			$shortlist = $shortlist + $counter_shortlist[$i];
			$selected = $selected + $counter_selected[$i];
			$subcontracted = $subcontracted + $counter_subcontracted[$i];
			$no_Potential = $no_Potential + $counter_no_potential[$i];
			$endorsed = $endorsed + $counter_endorsed[$i];			
			$all_position_total = $all_position_total+$counter_each_position_total[$i];

			$i++;
		}
		$pre_screened = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_Pre-Screened\',0,0); ">'.$pre_screened.'</a>';
		$Unprocessed = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_Unprocessed\',0,0); ">'.$Unprocessed.'</a>';
		$shortlist = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_Shortlist\',0,0); ">'.$shortlist.'</a>';
		$subcontracted = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_Subcontracted\',0,0); ">'.$subcontracted.'</a>';
		$no_Potential = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_No Potential\',0,0); ">'.$no_Potential.'</a>';
		$endorsed = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_Endorsed\',0,0); ">'.$endorsed.'</a>';
		$all_position_total = '<a href="javascript: move(\''.$rt.'\',\''.$status.'\',\'Below_Total\',0,0); ">'.$all_position_total.'</a>';
	}
	$counter = $i;
?>

	
	
	
<html><head>
<title>Administrator - Job Category Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">
<script type="text/javascript" src="category/category.js"></script>

<script type="text/javascript" src="js/tooltip.js"></script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>

<script language="javascript">
	function move(rt,status,type,position,client) 
	{
		previewPath = "adminadvertise_category_popup.php?rt="+rt+"&status="+status+"&type="+type+"&position="+position+"&client="+client;
		window.open(previewPath,'_blank','width=1100,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
</script>
	

	
	
	
<style type="text/css">
<!--
.style2 {color: #666666}
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
                        <td align="left" valign="top" bgcolor="#F1F1F3" colspan="6> <font color="#000000"><strong>
                          <form action="" method="post" name="formtable" onSubmit="if (this.report_t.value =='') return false;">
                            <table width="0%"  border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td scope="row"><font color="#000000"><strong>Posting Date</strong></font></td>
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
																		default:
																			echo "<option value='alltime' selected>all time</option>";
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
								  Status
                                  <select size="1" name="status">
                                    						<?php
																	switch ($status) 
																	{
																		case "ACTIVE":
																			echo "<option value=\"$status\" selected>ACTIVE</option>";
																			break;																	
																		case "NEW":
																			echo "<option value=\"$status\" selected>NEW</option>";
																			break;
																		case "ARCHIVE":
																			echo "<option value=\"$status\" selected>ARCHIVE</option>";
																			break;
																		default:
																			echo "<option value='' selected>All</option>";
																			break;
																	}
															?>
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="NEW">NEW</option>
                                    <option value="ARCHIVE">ARCHIVE</option>
                                    <option value="">All</option>
                                  </select>
                                </strong></font></td>
                                <td valign="top"><font color="#000000"><strong>
                                  <input type="submit" value="Search" name="submit">
                                </strong></font></td>
                              </tr>
                            </table>
                          </form>

                        </strong></font> </td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF" colspan="4">Showing Result for: <?php echo @$title; ?></td>
                      </tr>
					  
					  
<?php
	if(@isset($rt))
	{
?>
	
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3" colspan="12"><font color="#000000"><strong>Applicant's Summary Report</strong></font></td>
                      </tr>					  
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong><font color="#000000">Active Positions</font></strong></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><strong>Client</strong></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><strong>Date&nbsp;Posted</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><strong>Pre-Screened</strong></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Unprocessed</strong></font></td>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Shortlist</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Subcontracted</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>No&nbsp;Potential</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Endorsed</strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Total</strong></font></td>
                      </tr>
					  
					  
					<?php
						for($i=0; $i<@$counter; $i++)
						{
					?>
						  <tr>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_active_jobposition[$i]; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_client[$i]; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_date_posted[$i]; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_pre_screened_link[$i].$counter_pre_screened[$i]."</a>"; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_unprocessed_link[$i].$counter_unprocessed[$i]."</a>"; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_shortlist_link[$i].$counter_shortlist[$i]."</a>"; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_subcontracted_link[$i].$counter_subcontracted[$i]."</a>"; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_no_potential_link[$i].$counter_no_potential[$i]."</a>"; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_endorsed_link[$i].$counter_endorsed[$i]."</a>"; ?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo @$counter_each_position_total_link[$i].$counter_each_position_total[$i]."</a>"; ?></td>
						  </tr>
					<?php 
						}
					?>
					
					
                      <tr>
                        <td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Total(<?php echo $i; ?>)</strong></font></td>
						<td></td>
						<td></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$pre_screened; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$Unprocessed; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$shortlist; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$subcontracted; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$no_Potential; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$endorsed; ?></strong></font></td>
						<td align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong><?php echo @$all_position_total; ?></strong></font></td>
                      </tr>
					  
<?php
	}
?>					  
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



