<?php
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
include('conf/zend_smarty_conf.php');
include 'config.php';
include 'conf.php';
include 'time.php';
//error_reporting(E_ALL);


//REDUCE THE SIZE OF COMMENTS
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ENDED


//SESSION CHECKER
$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];
if($admin_id=="" && $agent_no=="")
{
	header("location:index.php");
}
//ENDED



//POST
$date_requested1 = $_REQUEST['date_requested1'];
$date_requested2 = $_REQUEST['date_requested2'];
$key = $_REQUEST['key'];
$status = $_REQUEST['status'];
$payment_status = $_REQUEST['payment_status'];
$payment_stat = $_REQUEST['payment_stat'];
$max = @$_REQUEST["max"];
$p = @$_REQUEST["p"];
$stat = @$_REQUEST["stat"];
$hired_visiblity = @$_REQUEST["hired_visiblity"];
$id = @$_REQUEST["id"];
//ENDED


//UPDATE RECRUITMENT STATUS
if(isset($stat))
{
	mysql_query("UPDATE tb_request_for_interview SET status='$stat' WHERE id='$id'");
	if($stat=='ARCHIVED' || $stat=='HIRED' || $stat=='REJECTED' || $stat=='CANCELLED')
	{
		mysql_query("UPDATE tb_app_appointment SET status='not active' WHERE request_for_interview_id='$id'");	
	}
	if($stat=='HIRED')
	{
		$u = mysql_query("SELECT applicant_id FROM tb_request_for_interview WHERE id='$id'");
		$uid = mysql_result($u,0,"applicant_id");
		if($hired_visiblity == "yes")
		{
			mysql_query("UPDATE job_sub_category_applicants SET ratings='1' WHERE ratings='0' AND userid='$uid'");
		}
	}
}
//ENDED


//UPDATE PAYMENT STATUS
if(isset($payment_stat))
{
	mysql_query("UPDATE tb_request_for_interview SET payment_status='$payment_stat' WHERE id='$id'");
}
//ENDED



//FUNCTIONS
function search($payment_status,$date_requested1,$date_requested2,$key,$status,$p,$maxp,$max) 
{
	$agent_no = $_SESSION['agent_no'];
	$admin_id = $_SESSION['admin_id'];
	if($_SESSION['agent_no'] <> "")
	{
		$session_query = "rp.request_for_interview_id=r.id AND rp.agent_id='$agent_no' AND ";	
	}
	else
	{
		//$session_query = "rp.request_for_interview_id=r.id AND rp.admin_id='$admin_id' AND ";	
		$session_query = "rp.request_for_interview_id=r.id AND ";	
	}
	
	$set = ($p-1)*$maxp ;

	$a_ = $date_requested1; 
	$b_ = $date_requested2;
	$title = "Between (".$a_." and ".$b_.")";	
	
	$from = "FROM tb_request_for_interview r, leads l, voucher v, request_for_interview_portal rp ";
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
	r.payment_status,
	r.date_added,
	l.fname,
	l.lname,
	r.voucher_number,
	r.session_id,
	rp.admin_id,
	rp.agent_id
	";

	//date query
	if($a_ == "Any" || $b_ == "Any" || $a_ == "" || $b_ == "")
	{
		$date_query = "";
	}
	else
	{
		$date_query = "(DATE_FORMAT(r.date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') AND ";	
	}
	//ended
	
	//payment status query
	if($payment_status == "Any" || $payment_status == "ANY" || $payment_status == "")
	{
		//do nothing
	}
	else
	{
		$date_query = $date_query."r.payment_status='$payment_status' AND ";	
	}
	//ended	
	
	//default	
	$where = "WHERE $session_query $date_query (r.leads_id=l.id) AND (r.voucher_number=v.code_number) AND r.status='NEW'";
	$query = "SELECT $fields $from $where $order_by";
	//ended
	
	if($date_requested1 != "" || $date_requested2 != "")
	{	
		if($key == "")
		{
			//search - no search key
			$where = "WHERE $session_query $date_query (r.leads_id=l.id) AND r.status='$status' AND (r.voucher_number=v.code_number) ";
			$query = "SELECT $fields $from $where $order_by";
			//ended
		}
		else
		{
			//search w/ keyword
			$where = "WHERE $session_query $date_query (r.leads_id=l.id) AND r.status='$status' AND (r.voucher_number=v.code_number) AND (r.voucher_number='$key' OR l.fname LIKE '%$key%' OR l.lname LIKE '%$key%')";
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
		$temp[$x]['payment_status'] = $r['payment_status'];
		$temp[$x]['date_added'] = $r['date_added'];
		$temp[$x]['fname'] = $r['fname'];
		$temp[$x]['lname'] = $r['lname'];
		$temp[$x]['voucher_number'] = $r['voucher_number'];
		$temp[$x]['session_id'] = $r['session_id'];
		$temp[$x]['admin_id'] = $r['admin_id'];
		$temp[$x]['agent_id'] = $r['agent_id'];
		if($temp[$x]['admin_id'] <> "")
		{
			$name = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$temp[$x]['admin_id']."' LIMIT 1");
			$temp[$x]['creator'] = mysql_result($name,0,"admin_fname")." ".mysql_result($name,0,"admin_lname");
		}
		else
		{
			$name = mysql_query("SELECT fname, lname FROM agent WHERE agent_no='".$temp[$x]['agent_id']."' LIMIT 1");
			$temp[$x]['creator'] = mysql_result($name,0,"fname")." ".mysql_result($name,0,"lname");			
		}

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

		//get calendar facilitator
		$ag = mysql_query("SELECT user_id FROM tb_app_appointment WHERE request_for_interview_id='".$temp[$x]['id']."'");
		while ($row_a = @mysql_fetch_assoc($ag))
		{
			$name = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$row_a["user_id"]."' LIMIT 1");
			$fname = mysql_result($name,0,"admin_fname");
			$lname = mysql_result($name,0,"admin_lname");
			$temp[$x]['facilitator'] = "-&nbsp;".$fname." ".$lname."<br />";
		}
		if(!isset($temp[$x]['facilitator']))
		{
			$temp[$x]['facilitator'] = "None";
		}
		//ended
													
		$x++ ;
	}
	return $temp ;
}

function linkpage($payment_status,$date_requested1,$date_requested2,$key,$status,$p,$size,$d) 
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?payment_status='.$payment_status.'&date_requested2='.$date_requested2.'&date_requested1='.$date_requested1.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p-1).'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?payment_status='.$payment_status.'&date_requested2='.$date_requested2.'&date_requested1='.$date_requested1.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p + 1).'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ENDED - FUNCTIONS



//GENERATE REPORT
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($payment_status,$date_requested1,$date_requested2,$key,$status,$p,$maxp,$max) ;
$pages = linkpage($payment_status,$date_requested1,$date_requested2,$key,$status,$p,$maxp,$found[0]['max']) ;
//ENDED
?>

	
	
<html><head>
<title>Available Staff - Request For Interview</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="category/category.css">

<!--calendar picker - setup-->
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-win2k-1.css" title="win2k-1" />
<!--ended - calendar picker setup -->

<script language="javascript">
		var curSubMenu = '';
		var selected_x_id = 0;

		function hire_status(id) 
		{
			var s = confirm("Would you like to remove this candidate from ASL? (click OK to move this candidate hired and remove from ASL list, click CANCEL to move this record to hired but still available on ASL list.");
			if(s)
			{
				document.location = "admin_request_for_interview.php?hired_visiblity=yes&key=<?php echo $key; ?>&date_requested1=<?php echo $date_requested1; ?>&date_requested2=<?php echo $date_requested2; ?>&status=<?php echo $status; ?>&stat=HIRED&id="+id;
			}
			else
			{
				document.location = "admin_request_for_interview.php?hired_visiblity=no&key=<?php echo $key; ?>&date_requested1=<?php echo $date_requested1; ?>&date_requested2=<?php echo $date_requested2; ?>&status=<?php echo $status; ?>&stat=HIRED&id="+id;				
			}
		}
		
		function lead(id) 
		{
			previewPath = "leads_information.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function meeting_calendar(id,leads_id,interview_id) 
		{
			previewPath = "application_calendar/popup_calendar.php?is_rescheduled=no&back_link=4&id="+id+"&leads_id="+leads_id+"&interview_id="+interview_id;
			window.open(previewPath,'_blank','width=900,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}	
		
		function rescheduled(id,leads_id,interview_id) 
		{
			previewPath = "application_calendar/popup_calendar.php?is_rescheduled=yes&back_link=4&id="+id+"&leads_id="+leads_id+"&interview_id="+interview_id;
			window.open(previewPath,'_blank','width=900,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}				

		function resume(id) 
		{
			<?php 
			if($admin_id=="")
			{
				echo 'previewPath = "../available-staff-resume.php?userid="+id;';
			}
			else
			{
				echo 'previewPath = "application_apply_action.php?userid="+id+"&page_type=popup";';
			}		
			?>
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
<?php 
if($admin_id=="")
{
	include 'BP_header.php';
}
else
{
	include 'admin_header_menu.php';
}
?>



<table width="106%">
<tr>
	<td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
    
		<?php 
		if($admin_id=="")
		{
			include 'agentleftnav.php';
		}
		else
		{
			include 'applicationsleftnav.php';
		}		
		?>
        
	</td>
	<td valign="top"  style="width:100%;">


					<table width="100%" border="0" bgcolor="#2A629F" cellpadding="4" cellspacing="1">
                      <tr>
                        <td align="left" valign="top" bgcolor="#ffffff" colspan="10">

						
					<table width="100%" border="0" bgcolor="#F1F1F3" cellpadding="4" cellspacing="1">
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
								    <td scope="row"><font color="#000000"><strong>Date Requested Between</strong></font></td>
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
										<td scope="row"><font color="#000000"><strong>Payment Status</strong></font></td>
										<td>
											  <select size="1" class="text" name="payment_status">
												<?php
													switch ($payment_status) 
													{
														case "PAID":
															echo "<option value='ANY'>Any</option>";
															echo "<option value='PAID' selected>Paid</option>";
															echo "<option value='PENDING'>Pending</option>";
															echo "<option value='VOUCHER'>Voucher</option>";
															break;
														case "PENDING":
															echo "<option value='ANY'>Any</option>";
															echo "<option value='PAID'>Paid</option>";
															echo "<option value='PENDING' selected>Pending</option>";
															echo "<option value='VOUCHER'>Voucher</option>";
															break;
														case "VOUCHER":
															echo "<option value='ANY'>Any</option>";
															echo "<option value='PAID'>Paid</option>";
															echo "<option value='PENDING'>Pending</option>";
															echo "<option value='VOUCHER' selected>Voucher</option>";
														default:
															echo "<option value='ANY' selected>Any</option>";
															echo "<option value='PAID'>Paid</option>";
															echo "<option value='PENDING'>Pending</option>";
															echo "<option value='VOUCHER'>Voucher</option>";
															break;											
													}
												?>
											  </select>
										</td>							
									</tr>                                    
									<tr>
										<td scope="row"><font color="#000000"><strong>Recruitment Status</strong></font></td>
										<td>
											  <select size="1" class="text" name="status">
												<?php
													switch ($status) 
													{
														case "ACTIVE":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='NEW' selected>New</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															break;
														case "ARCHIVED":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='ARCHIVED' selected>Archived</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='NEW'>New</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															break;
														//case "ON-HOLD":
															//echo "<option value='CANCELLED'>Cancelled</option>";
															//echo "<option value='ON-HOLD' selected>On Hold</option>";
															//echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															//echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															//echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															//echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															//echo "<option value='NEW'>New</option>";
															//echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='HIRED'>Hired</option>";
															//echo "<option value='REJECTED'>Rejected</option>";
															//break;															
														case "HIRED":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='HIRED' selected>Hired</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															break;															
														case "REJECTED":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='REJECTED' selected>Rejected</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";	
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															break;		
														case "CONFIRMED":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='CONFIRMED' selected>Confirmed/In Process </option>";	
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";														
															echo "<option value='REJECTED'>Rejected</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															break;		
														case "YET TO CONFIRM":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='YET TO CONFIRM' selected>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															break;		
														case "DONE":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE' selected>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															break;
														case "RE-SCHEDULED":
															echo "<option value='CANCELLED'>Cancelled</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED' selected>Confirmed/Re-Booked</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															break;	
														case "CANCELLED":
															echo "<option value='CANCELLED' selected>Cancelled</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date </option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='REJECTED'>Rejected</option>";
															echo "<option value='NEW'>New</option>";
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															break;																																														
														default:
															echo "<option value='NEW' selected>New</option>";
															echo "<option value='CONFIRMED'>Confirmed/In Process </option>";
															echo "<option value='DONE'>Interviewed; waiting for feedback</option>";
															echo "<option value='RE-SCHEDULED'>Confirmed/Re-Booked</option>";
															echo "<option value='YET TO CONFIRM'>Client contacted, no confirmed date</option>";
															echo "<option value='CANCELLED'>Cancelled</option>";																	
															echo "<option value='ARCHIVED'>Archived</option>";
															//echo "<option value='ON-HOLD'>On Hold</option>";
															echo "<option value='HIRED'>Hired</option>";
															echo "<option value='REJECTED'>Rejected</option>";
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
                      </tr>
					  <tr>
						<td align="left" valign="middle" bgcolor="#2A629F" colspan="4"><font color="#FFFFFF"><strong>Showing Result for: <?php echo $found[0]['title']; ?></strong></font></td>
						<td colspan="6" align="right"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
					  </tr>						  

	<tr bgcolor="#FFFFFF">
	<td valign="top" colspan="10" style="padding:0px;">
	<table width="100%" bgcolor="#2A629F" cellspacing="1" cellpadding="1">
	                      <tr>
						   <td width="3%" align="left" valign="top" bgcolor="#F1F1F3"><strong>#</strong></td>
                        <td width="11%" align="left" valign="top" bgcolor="#F1F1F3"><strong>Client</strong></td>
                        <td width="14%" align="left" valign="top" bgcolor="#F1F1F3"><strong>Applicant</strong></td>
                        <td width="6%" align="left" valign="top" bgcolor="#F1F1F3">
                        <strong>
                        Facilitator
						<?php
                        if($admin_id<>"")
                        {
                            echo " / Creator";
                        }
                        ?>
                        </strong>
                        </td>
                        <td width="10%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Schedule</strong></font></td>
						<td width="10%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Alternative<br />
						  Schedule</strong></font></td>
                        <td width="9%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Time&nbsp;Zone</strong></font></td>
                        <td width="10%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Date<br />
                          Requested</strong></font></td>
						<td width="15%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Voucher</strong></font></td>
                        <td width="12%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Recruitment Status / Payment</strong></font></td>
						
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
						  <td align="left" valign="top" bgcolor="#FFFFFF" ><?php echo $counter;?></td>
							<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<table cellpadding="2" cellspacing="2">
									<tr>
										<td colspan="2">
											<a href="javascript: lead(<?php echo $found[$x]['leads_id']; ?>); "><?php echo $found[$x]['client_name']; ?></a><br>

											
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
							
							<?php 
									if($applicant_job_order_id){
										//removed job order flag as per maam rica
										//echo "<span style='float:right;'><a href=javascript:popup_win('../asl/ShowJobSpecAppWorkingDetails.php?id=$job_position_id&jr_cat_id=$jr_cat_id&applicant_id=$applicant_job_order_id&view=True',820,600);><img src='images/flag_red.gif' border='0'></a></span>";
									}
							?>
								
								<a href="javascript: resume(<?php echo $found[$x]['applicant_id']; ?>); "><?php echo $found[$x]['applicant_name']; ?></a>
								
								
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php 
								
								if($admin_id<>"")
								{
									echo " / ".$found[$x]['creator'];
								}
								else
								{
									echo $found[$x]['creator']; 
								}
								?>
                                
							</td>                            
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['date_interview']; ?><br />
								<?php echo $found[$x]['time']; ?>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['alt_date_interview']; ?><br />
								<?php echo $found[$x]['alt_time']; ?>
							</td>							
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php 
															switch($found[$x]['time_zone'])
															{
																case "PST8PDT":
																	$default_timezone_display = "America/San Francisco";
																	break;
																case "NZ":
																	$default_timezone_display = "New Zealand/Wellington";
																	break;
																case "NZ-CHAT":
																	$default_timezone_display = "New Zealand/Chatham_Islands";
																	break;
																default:
																	$default_timezone_display = $found[$x]['time_zone'];
																	break;
															}
															echo $default_timezone_display; 
								 
								?>
                            </td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo $found[$x]['date_added']; ?>	</td>
							<!--<td align="left" valign="top" bgcolor="#FFFFFF" onClick="showSubMenu('voucher_<?php echo $x; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">-->
                            <td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<?php echo $found[$x]['voucher_number']; ?>
                                <!--
                                <a href="javascript: showSubMenu('voucher_<?php echo $x; ?>'); "><?php echo $found[$x]['voucher_number']; ?></a><br />
								<div id="voucher_details_<?php echo $x; ?>" STYLE='VISIBILITY: visible'>
								<font size="1">Date&nbsp;Created:&nbsp;<strong><?php echo $found[$x]['date_created']; ?></strong></font><br />
								<font size="1">Date&nbsp;Expire:&nbsp;<strong><?php echo $found[$x]['date_expire']; ?></strong></font><br />
								<font size="1">Status:&nbsp;<strong><?php echo $found[$x]['date_expire_status']; ?></strong></font>
								</div>
                                -->
							</td>
                            <td align="left" valign="top" bgcolor="#FFFFFF">
							<?php 
													switch ($found[$x]['status']) 
													{
														case "ACTIVE":
															$stat = "<option value='NEW' selected>New</option>";
															break;
														case "ARCHIVED":
															$stat = "<option value='ARCHIVED' selected>Archived</option>";
															break;
														case "ON-HOLD":
															$stat = "<option value='ON-HOLD' selected>On Hold</option>";
															break;															
														case "HIRED":
															$stat = "<option value='HIRED' selected>Hired</option>";
															break;															
														case "REJECTED":
															$stat = "<option value='REJECTED' selected>Rejected</option>";
															break;		
														case "CONFIRMED":
															$stat = "<option value='CONFIRMED' selected>Confirmed/In Process </option>";	
															break;		
														case "YET TO CONFIRM":
															$stat = "<option value='YET TO CONFIRM' selected>Client contacted, no confirmed date </option>";
															break;		
														case "DONE":
															$stat = "<option value='DONE' selected>Interviewed; waiting for feedback</option>";
															break;
														case "RE-SCHEDULED":
															$stat = "<option value='RE-SCHEDULED' selected>Confirmed/Re-Booked</option>";
															break;	
														case "CANCELLED":
															$stat = "<option value='CANCELLED' selected>Cancelled</option>";
															break;	
														default: 
															$stat = $found[$x]['status'];
															break;																																														
													}
								echo "<table>";
								echo "<tr><td valign=top><strong>-</strong></td><td>".$stat."</td></tr>";
								if(isset($found[$x]['payment_status']))
								{
									echo "<tr><td valign=top><strong>-</strong></td><td>".$found[$x]['payment_status']."</td></tr>";
								}
								echo "</table>";
							?>
                            </td>
							
						  </tr>
<?php 
	}
}				
?>

	
	</table>
	
	</td>
	</tr>
<!------------------------------------------------------------------------------->
					

					
                      <tr>
                        <td align="left" valign="top" bgcolor="#2A629F"><font color="#FFFFFF"><strong>Total(<?php echo $x; ?>)</strong></font></td>
						<td align="right" valign="top" bgcolor="#2A629F" colspan="9"><font color="#FFFFFF"><strong><?php echo $pages; ?></strong></font></td>
                      </tr>
		
                    </table>

    </td>
</tr>
</table>
<!--ASL ALARM--> <DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV> <!--ENDED-->


</td>
</tr>
</table>
<?php include 'footer.php'; ?>	
</body>
</html>

