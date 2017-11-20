<?php
include 'conf.php';
include 'config.php';
include('conf/zend_smarty_conf.php');
include 'lib/activity_tracker_notes_perstaff.php';
include 'lib/activity_tracker_notes_all_staff.php';

$keyword = $_POST["keyword"];
if($keyword=="")
{
	$keyword = $_GET["keyword"];
}
$selected_client = $_POST["selected_client"];
if($selected_client=="")
{
	$selected_client = $_GET["selected_client"];
}
		
//post
$rt = @$_REQUEST["rt"];
$mystaff = @$_REQUEST["mystaff"];
$mystaff_selected = @$_REQUEST["mystaff_selected"];


$p = @$_REQUEST["p"];

if (!isset($p)) $p = 1 ;

if($_SESSION['client_id']=="" && $_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];
//ended


//send activity notes per staff
if(@isset($_REQUEST["send"]))
{
	$result = activity_tracker_notes_perstaff($mystaff_selected,$client_id,'manual');
}
//ended


//send all activity notes
if(@isset($_REQUEST["send_all"]))
{
	$result = activity_tracker_notes_all($client_id,'manual');
}
//ended


//current status seetings
$result=$db -> fetchAll("SELECT status, hour, minute, client_timezone FROM tb_client_account_settings WHERE client_id='$client_id';");
//while(list($status,$h,$m,$client_timezone) = mysqli_fetch_array($result))
foreach($result as $r)
{
	$status = $r["status"];
	$h = $r["hour"];
	$m = $r["minute"];
	$client_timezone = $r["client_timezone"];
		
		
	$activity_notes_status = $status;
	$hour = $h;	
	$minute = $m;	
	$tz = $client_timezone;
}
//ended



//client subcontructor's options
$result = $db -> fetchAll("SELECT subcontractors.userid, personal.fname, personal.lname FROM subcontractors, personal WHERE subcontractors.status='ACTIVE' AND subcontractors.leads_id='$client_id' AND personal.userid=subcontractors.userid ORDER BY personal.fname;");
//$result=mysqli_query($link2, $query);
if($mystaff == "")
{
	$mystaff_options = "<option value='' selected>Select Staff</option>";
}
//while(list($userid,$fname,$lname) = mysqli_fetch_array($result))
foreach($result as $r)
{
	$userid = $r["userid"];
	$fname = $r["fname"];
	$lname = $r["lname"];
	
	if($mystaff == $userid)
	{
		$mystaff_options = $mystaff_options."<option value='".$userid."' selected>".$fname." ".$lname."</option>";
		$mystaff_name = $fname." ".$lname;
	}
	else
	{	
		$mystaff_options = $mystaff_options."<option value='".$userid."'>".$fname." ".$lname."</option>";
	}
}
//ended




//functions
function linkpage($mystaff,$rt,$d,$p,$size)
{
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		if ($p > 1) $pv = '<a href="?mystaff='.$mystaff.'&rt='.$rt.'&p='.($p-1).'">Previous</a>' ;
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?mystaff='.$mystaff.'&rt='.$rt.'&p='.($p + 1).'">Next</a>' ;
		}
		return @$p1.'-'.@$p2.' of '.@$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n ;
	}
}

function getNotes($client_id,$mystaff,$a_,$b_,$p,$maxp) 
{
	global $db;
	$set = ($p-1)*$maxp ;
	$row = $db -> fetchAll("SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE leads_id='$client_id' AND userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') ORDER BY expected_time DESC LIMIT $set, $maxp");
	//$result=mysqli_query($link2, $query);
	$x =0 ;
	
	//while ($row = mysqli_fetch_assoc($result)) 
	
		$temp[$x][0] = $row['expected_time'] ;
		$temp[$x][1] = $row['checked_in_time'] ;
		$temp[$x][2] = $row['note'] ;
		$x++ ;
		
	return @$temp ;
}

function max_rec($client_id,$mystaff,$a_,$b_) 
{
	global $db;
	$result = $db -> fetchRow("SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE leads_id='$client_id' AND userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') ORDER BY expected_time");
	return $result ;
}
//ended


//generate report
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
		$a_1 = mktime(0, 0, 0, 1, 11, 2000);
		$b_1 = time();
		$a_ = date("Y-m-d",$a_1);
		$b_ = date("Y-m-d",$b_1);
		$title = "All time";			
		break;
	default :
		$a_ = date("Y-m-d"); 
		$b_ = date("Y-m-d",time() + (1 * 24 * 60 * 60));
		$title = "Today (".date("M d, Y").")";	
}

	$m_length = 30 ;
	$notes = getNotes($client_id,$mystaff,$a_,$b_,$p,$m_length) ;
	$max = max_rec($client_id,$mystaff,$a_,$b_) ;
	$navpage = linkpage($mystaff,$rt,$max,$p,$m_length) ;

//ended

?>

<html>
<head>
<title>My Account-Client</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">




<script type="text/javascript">
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
var tz_request = makeObject()
var one_request = makeObject()
var none_request = makeObject()
var temp = makeObject()
var time_setting_client_id;
var current_status = '';

function update_setting(id,client_id,tz,update_type)
{
	var objtype;
	if(update_type == "ALL")
	{
		objtype = request
		
	}
	else
	{
		objtype = one_request
	}
	
	email_counter = document.getElementById('email_id'+id).value;
	cc_counter = document.getElementById('cc_id'+id).value;	
	emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
	var regex = new RegExp(emailReg);
	if(email_counter == "")
	{
		alert("Please enter your email address.");
	}
	else if(regex.test(email_counter) == false)
	{
		alert('Please enter a valid email address and try again!');
	}	
	else
	{
		hours = document.getElementById('hour_id'+id).value;
		minutes = document.getElementById('minute_id'+id).value;
		objtype.open('get', 'activity_notes_setting_update.php?update_type='+update_type+'&email='+email_counter+'&cc='+cc_counter+'&client_id='+client_id+'&tz='+tz+'&hour='+hours+'&minute='+minutes+'&status=UPDATE&id='+id)
		objtype.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		time_setting_client_id = client_id;
		document.getElementById("current_status"+client_id).value=update_type;
		objtype.onreadystatechange = get_client_settings
		objtype.send(1)
	}		

}
function add_setting(client_id,tz,add_type)
{
	var objtype;
	if(add_type == "ALL")
	{
		objtype = request
		email_counter = document.getElementById('email_id2'+client_id).value;
		cc_counter = document.getElementById('cc_id2'+client_id).value;		
	}
	else
	{
		objtype = one_request
		email_counter = document.getElementById('email_id'+client_id).value;
		cc_counter = document.getElementById('cc_id'+client_id).value;
	}
	
	emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
	var regex = new RegExp(emailReg);
	if(email_counter == "")
	{
		alert("Please enter your email address.");
	}
	else if(regex.test(email_counter) == false)
	{
		alert('Please enter a valid email address and try again!');
	}	
	else
	{
		hours = document.getElementById('hour_id_'+client_id).value;
		minutes = document.getElementById('minute_id_'+client_id).value;
		objtype.open('get', 'activity_notes_setting_update.php?add_type='+add_type+'&email='+email_counter+'&cc='+cc_counter+'&client_id='+client_id+'&tz='+tz+'&hour='+hours+'&minute='+minutes+'&status=ADD')
		objtype.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		time_setting_client_id = client_id;
		document.getElementById("current_status"+client_id).value=add_type;
		objtype.onreadystatechange = get_client_settings
		objtype.send(1)
	}	
}
function none_setting(id,client_id,tz)
{
	var answer = confirm ("This will remove all the settings for the 'Send Group Activity Notes Daily'. Are you sure you want to continue?")
	if (answer)
	{
		none_request.open('get', 'activity_notes_setting_update.php?tz='+tz+'&client_id='+client_id+'&status=NONE')
		none_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		time_setting_client_id = client_id;
		document.getElementById("time_settings"+client_id).innerHTML="";
		none_request.send(1)
		alert("New Setting has been saved.");
		document.getElementById("current_status"+client_id).value="NONE";
	}
	else
	{
		validate_section("NONE",client_id);
	}	
}
function delete_setting(id,client_id,tz,delete_type)
{
	if(delete_type == "ALL")
	{
		objtype = request
	}
	else
	{
		objtype = one_request
	}
	var answer = confirm ("Are you sure you want to delete this setting?")
	if (answer)
	{
		objtype.open('get', 'activity_notes_setting_update.php?delete_type='+delete_type+'&client_id='+client_id+'&tz='+tz+'&id='+id+'&status=DELETE')
		objtype.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		time_setting_client_id = client_id;
		document.getElementById("current_status"+client_id).value=delete_type;		
		objtype.onreadystatechange = get_client_settings 
		objtype.send(1)
	}
}
function one_setting(id,client_id,tz)
{
	if(current_status=="ALL")
	{
		var answer = confirm ("This will remove all your settings for the 'Send Group Activity Notes Daily'. Are you sure you want to continue?")
	}	
	else
	{
		var answer = confirm ("This will change your settings to 'Send Individual Activity Notes per Staff'. Are you sure you want to continue?")
	}
	if (answer)
	{
		one_request.open('get', 'activity_notes_setting_update.php?tz='+tz+'&client_id='+client_id+'&status=ONE')
		one_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		time_setting_client_id = client_id;
		document.getElementById("current_status"+client_id).value="ONE";
		one_request.onreadystatechange = get_client_settings 
		one_request.send(1)
	}
	else
	{
		validate_section("ONE",client_id);
	}
}
function all_setting(id,client_id,tz)
{
	var answer = confirm ("This will change the settings to 'Send Group Activity Notes Daily'. Are you sure you want to continue?")
	if (answer)
	{
		request.open('get', 'activity_notes_setting_update.php?tz='+tz+'&client_id='+client_id+'&status=ALL')
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		time_setting_client_id = client_id;
		document.getElementById("current_status"+client_id).value="ALL";
		request.onreadystatechange = get_client_settings
		request.send(1)
	}	
	else
	{
		validate_section("ALL",client_id);
	}	
}
function timezone_setting(tz,client_id)
{
	tz_request.open('get', 'activity_notes_setting_update.php?client_id='+client_id+'&tz='+tz+'&status=TZ')
	tz_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	tz_request.send(1)
	alert("Timezone settings has been changed.");
}


//checked
function get_client_settings()
{
	var objtype;
	var data;
	current_status = document.getElementById("current_status"+time_setting_client_id).value
	if(current_status == "ALL")
	{
		data = request.responseText
		objtype = request
	}
	else if(current_status == "ONE")
	{
		data = one_request.responseText
		objtype = one_request
	}
	if(objtype.readyState == 4)
	{
		//document.getElementById("time_settings"+time_setting_client_id).innerHTML=data;
		window.location="admin_activity_tracker_notes_client_settings.php?keyword=<?php echo $keyword; ?>&selected_client=<?php echo $selected_client; ?>";
		//time_setting_client_id = "";
	}
	else
	{
		document.getElementById("time_settings"+time_setting_client_id).innerHTML="<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td><img src='images/ajax-loader.gif'></td></tr></table>";
	}
}			
//end


function validate_section(selected,client_id)
{
	current_status = document.getElementById("current_status"+client_id).value;
	if(current_status=="ALL")
	{
		document.getElementById('ID_ALL'+client_id).checked=true;
	}
	else if(current_status=="ONE")
	{
		document.getElementById('ID_ONE'+client_id).checked=true;
	}
	else
	{
		document.getElementById('ID_NONE'+client_id).checked=true;
	}
	document.getElementById(current_status).checked=false;
	current_status = selected;
}
function validate(form) 
{
	if (form.add_tz.value == '') { alert("You forgot select your time zone."); form.add_tz.focus(); return false; }
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





</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">



<table width="80%">
	<tr>
		<td>
				<form method="post" action="" name="clients">
				<table>
					<tr>
						<td><font size="1">Keyword(Optional)</font></td>
						<td><font size="1">Select Client(Optional)</font></td>
						<td></td>
					</tr>
					<tr>
						 <td><input type="text" name="keyword" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
						 <td>
							<select name="selected_client" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
								<option value=""></option>
								<?php
								$rows = $db -> fetchAll("SELECT id,fname,lname FROM leads WHERE status='CLIENT' ORDER BY fname;");
								//$r=mysqli_query($link2, $q);
								//while(list($id,$fname,$lname) = mysqli_fetch_array($r))
								foreach($rows as $r)
								{
									$id = $r["id"];
									$fname = $r["fname"];
									$lname = $r["lname"];
								?>
								<option value="<?php echo $id; ?>"><?php echo $fname." ".$lname; ?></option>
								<?php } ?>						
								<option value="all">All</option>
							</select>	
						 </td>
						 <td><input type="submit" name="search" value="View" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
					</tr>
				</table>
				</form>		
		</td>
	</tr>

		



	<?php
	//current status seetings
	$clr = "#F2F1F2";
	if(@isset($_REQUEST["search"]) || $keyword != "" || $selected_client != "")
	{
		$row = "";
		if($keyword == "")
		{
			if($selected_client == "all")
			{
				$row = $db -> fetchAll("SELECT id,fname,lname FROM leads WHERE status='CLIENT';");
			}
			else
			{
				$row = $db -> fetchAll("SELECT id,fname,lname FROM leads WHERE status='CLIENT' AND id='$selected_client';");		
			}
		}
		else
		{
			$row = $db -> fetchAll("SELECT id,fname,lname FROM leads WHERE status='CLIENT' AND (fname LIKE '%$keyword%' OR lname LIKE '%$keyword%');");				
		}
		$counter = 0;
		//while(list($id,$fname,$lname) = mysqli_fetch_array($r))
		foreach($row as $r)
		{
			$id = $r["id"];
			$fname = $r["fname"];
			$lname = $r["lname"];
			
			if($clr == "#F6F4F4")
				$clr = "#E4E2E2";
			else
				$clr = "#F6F4F4";
		
			$client_id = $id;
			$name = $fname." ".$lname;
			$activity_notes_status = "";
			$hour = "";
			$minute = "";
			$tz = "";

	?>

	<tr>
		<td>
				<table width="100%"  cellspacing="0" cellpadding="3" style="border:#ffffff solid 1px; margin-left:10px; margin-top:20px; margin-bottom:20px;">
				<tr bgcolor="#0080C0">
				<td height="21" colspan="3" valign="middle" style="border-bottom:#0080C0 solid 1px;"><font color="#ffffff"><B><?php echo $name; ?></B></font>
				</tr>
				   <tr>
					<td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
					
							
							<?php
									//current status seetings
									$clr = "#FFFFFF";
									$activity_notes_status = "";
									$hour = "";
									$minute = "";
									$tz = "";
									
									$result = $db ->fetchAll("SELECT id, status, hour, minute, client_timezone FROM tb_client_account_settings WHERE client_id='$client_id';");
										
									//while(list($id,$status,$h,$m,$client_timezone) = mysqli_fetch_array($result))
									foreach ($result as $r)
									{
										
										$id = $r["id"];
										$status = $r["status"];
										$h = $r["hour"];
										$m = $r["minute"];
										$client_timezone = $r["client_timezone"];
										$setting_id = $id;
										$activity_notes_status = $status;
										$hour = $h;	
										$minute = $m;	
										$tz = $client_timezone;
									}	
							?>				
							<input type="hidden" id="current_status<?php echo $client_id; ?>" value="<?php echo $activity_notes_status; ?>">
							<table width="99%" cellspacing="0" cellpadding="3" style="margin-left:0px; margin-top:5px; margin-bottom:5px;">				 															  
								   <tr bgcolor="<?php echo $clr; ?>">
									<td width='0%' <?php echo $clr; ?> valign='top'>
										<input name="activity_notes_seetings<?php echo $client_id; ?>" id="ID_NONE<?php echo $client_id; ?>" type="radio" value="NONE" <?php if($activity_notes_status=='NONE') echo "checked"; ?> <?php echo "onClick=\"javascript: none_setting(0,".$client_id.",'".$client_timezone."');\""; ?>>
									</td>				   
									<td width='0%' <?php echo $clr; ?> valign='top'>:</td>
									<td width='100%' <?php echo $clr; ?> valign='top'>Do not send Activity Notes.</td>
								  </tr>								 
								 <tr bgcolor="<?php echo $clr; ?>" >
									<td width='0%' valign='top' <?php echo $clr; ?>>
										<input name="activity_notes_seetings<?php echo $client_id; ?>" id="ID_ONE<?php echo $client_id; ?>" type="radio" value="ONE" <?php if($activity_notes_status=='ONE') echo "checked"; ?> <?php echo "onClick=\"javascript: one_setting(0,".$client_id.",'".$client_timezone."');\""; ?>>
									</td>				 
									<td width='0%' valign='top' <?php echo $clr; ?>>:</td>
									<td width='100%' valign='top' <?php echo $clr; ?>>Send Individual Activity Tracker Notes when Sub-Contractor Finishes work.</td>
								  </tr>
								<tr bgcolor="<?php echo $clr; ?>">	  
									<td width='0%' valign='top' <?php echo $clr; ?>>
										<input name="activity_notes_seetings<?php echo $client_id; ?>" id="ID_ALL<?php echo $client_id; ?>" type="radio" value="ALL" <?php if($activity_notes_status=='ALL') echo "checked"; ?> <?php echo "onClick=\"javascript: all_setting(0,".$client_id.",'".$client_timezone."');\""; ?>>
									</td>
									<td width='0%' valign='top' <?php echo $clr; ?>>:</td>
									<td width='100%' valign='top' <?php echo $clr; ?>>Send Group Activity Notes Daily.</td>
								</tr>	
								<tr bgcolor="<?php echo $clr; ?>">
									<td width='80%' <?php echo $clr; ?> valign='top' colspan="3">
									
									
									
										<div id="time_settings<?php echo $client_id; ?>">
										<?php	
											if($activity_notes_status=='ALL' || $activity_notes_status=='ONE')
											{						
										?>	
										<br />
										<?php
										if($activity_notes_status=='ALL')
										{
										?>										
										Select Your Time Zone:
										<SELECT name="tz" onChange="javascript: timezone_setting(this.value,<?php echo $client_id; ?>); " id="tz_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
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
															if($tz == $tz_result['timezone'])
															{
																$is_executed = 1;
																echo "<OPTION VALUE='".$tz_result['timezone']."' SELECTED>".$admin_timezone_display."</OPTION>";
															}
															else
															{
																echo "<OPTION VALUE='".$tz_result['timezone']."'>".$admin_timezone_display."</OPTION>";
															}
														}
														if($is_executed == 0)
														{
															echo "<OPTION VALUE='' SELECTED></OPTION>";
														}
														?>                                                            
										</SELECT><br /><br />
										<?php
										}
										?>																	
										<table width="100%" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC" border="0">
										<?php
												//check the number of records
												//$ctr = $db -> fetchRow("SELECT id, status, hour, minute, client_timezone, email, cc FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');");
												//$result=mysqli_query($link2, $queryCheck);
												//$ctr=@mysqli_num_rows($result);
												//end										
												$results=$db -> fetchAll("SELECT id, status, hour, minute, client_timezone, email, cc FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');");
												//$result=mysqli_query($link2, $query);
												//while(list($id,$status,$h,$m,$client_timezone,$email,$cc) = mysqli_fetch_array($result))
												foreach($results as $r)
												{
													$id = $r["id"];
													$status = $r["status"];
													$h = $r["hour"];
													$m = $r["minute"];
													$client_timezone = $r["client_timezone"];
													$email = $r["email"];
													$cc = $r["cc"];
													
													//date formating
													$tm = $h.":".$m.":00";
													$date_time = new DateTime($tm);
													$time = date_format($date_time,'g:i:A');	
													$date = $date_time->format('M-d');
													
													//ended										
												
													echo "<tr>";	
													echo "<td width='90%' bgcolor='#ffffff'>";
															if($activity_notes_status == "ALL")
															{
																echo "<strong>Email:&nbsp;</strong><em>".$email."</em>";
																if($cc != "")
																{
																	echo ",&nbsp;<strong>CC:</strong>&nbsp;<em>".$cc."</em>";
																}
																if($time != "")
																{
																	echo ",&nbsp;<strong>Time:</strong>&nbsp;<em>".$time."</em>";
																}
															}
															else
															{
																echo "<strong>Email:&nbsp;</strong><em>".$email."</em>";
																if($cc != "")
																{
																	echo ",&nbsp;<strong>CC:</strong>&nbsp;<em>".$cc."</em>";
																}
															}
														
														echo "
																<div id='notes_".$id."' STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
																	<table bgcolor='#cccccc' width='300' cellpadding='0' cellspacing='2'><tr><td>
																		<table bgcolor='#FFFFCC' width='300' cellpadding='3' cellspacing='3'>
																			<tr>
																				<td colspan=2>";
		
		
																					if($activity_notes_status=='ALL')
																					{														
											?>		
																								<table border="0">
																									<tr>
																										<td>Email</td><td><INPUT type="text" ID="email_id<?php echo $id; ?>" NAME="email<?php echo $id; ?>" value="<?php echo $email; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																										<td>CC</td><td><INPUT type="text" ID="cc_id<?php echo $id; ?>" NAME="cc<?php echo $id; ?>" value="<?php echo $cc; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>																									
																										<td>
							
																											<SELECT ID="hour_id<?php echo $id; ?>" NAME="hour<?php echo $id; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
							
																												<?php
																													switch($h)
																													{
																														case "12":
																															$hour_display = "<OPTION VALUE=12 selected>12 PM</OPTION>";
																															break;																							
																														case "13":
																															$hour_display = "<OPTION VALUE=13 selected>01 PM</OPTION>";
																															break;
																														case "14":		
																															$hour_display = "<OPTION VALUE=14 selected>02 PM</OPTION>";
																															break;
																														case "15":
																															$hour_display = "<OPTION VALUE=15 selected>03 PM</OPTION>";
																															break;
																														case "16":		
																															$hour_display = "<OPTION VALUE=16 selected>04 PM</OPTION>";
																															break;
																														case "17":		
																															$hour_display = "<OPTION VALUE=17 selected>05 PM</OPTION>";
																															break;
																														case "18":		
																															$hour_display = "<OPTION VALUE=18 selected>06 PM</OPTION>";
																															break;
																														case "19":		
																															$hour_display = "<OPTION VALUE=19 selected>07 PM</OPTION>";
																															break;
																														case "20":		
																															$hour_display = "<OPTION VALUE=20 selected>08 PM</OPTION>";
																															break;
																														case "21":		
																															$hour_display = "<OPTION VALUE=21 selected>09 PM</OPTION>";
																															break;
																														case "22":		
																															$hour_display = "<OPTION VALUE=22 selected>10 PM</OPTION>";
																															break;
																														case "23":		
																															$hour_display = "<OPTION VALUE=23 selected>11 PM</OPTION>";
																															break;
																														case "24":		
																															$hour_display = "<OPTION VALUE=24 selected>12 AM</OPTION>";
																															break;
																														default:
																															if($h < 10)
																															{
																																$hour_display = "<OPTION VALUE=".$h." selected>0".$h." AM</OPTION>";
																															}
																															break;
																													}	
																																																	
																													if($hour == "")
																														echo "<OPTION VALUE='' SELECTED>Hour</OPTION>";
																													else
																														
																												?>
																												<OPTION VALUE=1>01 AM</OPTION>
																												<OPTION VALUE=2>02 AM</OPTION>
																												<OPTION VALUE=3>03 AM</OPTION>
																												<OPTION VALUE=4>04 AM</OPTION>
																												<OPTION VALUE=5>05 AM</OPTION>
																												<OPTION VALUE=6>06 AM</OPTION>
																												<OPTION VALUE=7>07 AM</OPTION>
																												<OPTION VALUE=8>08 AM</OPTION>
																												<OPTION VALUE=9>09 AM</OPTION>
																												<OPTION VALUE=10>10 AM</OPTION>
																												<OPTION VALUE=11>11 AM</OPTION>
																												<OPTION VALUE=12>12 PM</OPTION>
																												<OPTION VALUE=13>01 PM</OPTION>
																												<OPTION VALUE=14>02 PM</OPTION>
																												<OPTION VALUE=15>03 PM</OPTION>
																												<OPTION VALUE=16>04 PM</OPTION>
																												<OPTION VALUE=17>05 PM</OPTION>
																												<OPTION VALUE=18>06 PM</OPTION>
																												<OPTION VALUE=19>07 PM</OPTION>
																												<OPTION VALUE=20>08 PM</OPTION>
																												<OPTION VALUE=21>09 PM</OPTION>
																												<OPTION VALUE=22>10 PM</OPTION>
																												<OPTION VALUE=23>11 PM</OPTION>
																												<OPTION VALUE=24>12 AM</OPTION>	
																											</SELECT>											
							
																									</td>
																									<td>
							
																											<select id="minute_id<?php echo $id; ?>" name="minute<?php echo $id; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																												<?php
																													if($m == "")
																														echo '<option value="" selected>Minute</option>';
																													else
																													{
																														if($m < 10)
																														{
																															echo "<option value='".$m."' selected>0".$m."</option>";
																														}
																														else
																														{
																															echo "<option value='".$m."' selected>".$m."</option>";
																														}
																													}	
																												?>
																											  <option value="0">00</option>
																											  <option value="1">01</option>
																											  <option value="2">02</option>
																											  <option value="3">03</option>
																											  <option value="4">04</option>
																											  <option value="5">05</option>
																											  <option value="6">06</option>
																											  <option value="7">07</option>
																											  <option value="8">08</option>
																											  <option value="9">09</option>
																											  <option value="10">10</option>
																											  <option value="11">11</option>
																											  <option value="12">12</option>
																											  <option value="13">13</option>
																											  <option value="14">14</option>
																											  <option value="15">15</option>
																											  <option value="16">16</option>
																											  <option value="17">17</option>
																											  <option value="18">18</option>
																											  <option value="19">19</option>
																											  <option value="20">20</option>
																											  <option value="21">21</option>
																											  <option value="22">22</option>
																											  <option value="23">23</option>
																											  <option value="24">24</option>
																											  <option value="25">25</option>
																											  <option value="26">26</option>
																											  <option value="27">27</option>
																											  <option value="28">28</option>
																											  <option value="29">29</option>
																											  <option value="30">30</option>
																											  <option value="31">31</option>
																											  <option value="32">32</option>
																											  <option value="33">33</option>
																											  <option value="34">34</option>
																											  <option value="35">35</option>
																											  <option value="36">36</option>
																											  <option value="37">37</option>
																											  <option value="38">38</option>
																											  <option value="39">39</option>
																											  <option value="40">40</option>
																											  <option value="41">41</option>
																											  <option value="42">42</option>
																											  <option value="43">43</option>
																											  <option value="44">44</option>
																											  <option value="45">45</option>
																											  <option value="46">46</option>
																											  <option value="47">47</option>
																											  <option value="48">48</option>
																											  <option value="49">49</option>
																											  <option value="50">50</option>
																											  <option value="51">51</option>
																											  <option value="52">52</option>
																											  <option value="53">53</option>
																											  <option value="54">54</option>
																											  <option value="55">55</option>
																											  <option value="56">56</option>
																											  <option value="57">57</option>
																											  <option value="58">58</option>
																											  <option value="59">59</option>
																											</select>												
																									</td>
																									<td><input type="button" value="Save" onClick="javascript: update_setting('<?php echo $id; ?>','<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ALL');" id="save_id<?php echo $id; ?>" name="save<?php echo $id; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																									<td><a href="javascript: hideSubMenu();">Close</a></td>
																								</tr>
																							</table>
												<?php											
																			}
																			else
																			{
												?>
												
												
																								<INPUT type="hidden" ID="hour_id<?php echo $id; ?>" NAME="hour<?php echo $id; ?>" value="<?php echo $h; ?>">
																								<INPUT type="hidden" id="minute_id<?php echo $id; ?>" NAME="minute<?php echo $id; ?>" value="<?php echo $m; ?>">
																								<table border="0">
																									<tr>
																										<td>Email</td><td><INPUT type="text" ID="email_id<?php echo $id; ?>" NAME="email<?php echo $id; ?>" value="<?php echo $email; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																										<td>CC</td><td><INPUT type="text" ID="cc_id<?php echo $id; ?>" NAME="cc<?php echo $id; ?>" value="<?php echo $cc; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																										<td>
																											<input type="button" value="Save" onClick="javascript: update_setting('<?php echo $id; ?>','<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ONE');" id="save_id<?php echo $id; ?>" name="save<?php echo $id; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																										</td>
																										<td><a href="javascript: hideSubMenu();">Close</a></td>
																									</tr>
																								</table>												
												
												
												<?php							
																			}				
													echo "
																				</td>
																			</tr>
																		</table>	
																	</td></tr></table>
																</div>";														
														
														
													echo "</td>";
													echo "<td width='10%'onclick=\"showSubMenu('notes_".$id."'); \" onMouseOver=\"javascript:this.style.background='#F1F1F3';\" onMouseOut=\"javascript:this.style.background='#ffffff'; \" bgcolor=#FFFFFF valign='top'>
														<a href=\"javascript: showSubMenu('notes_".$id."'); \">Edit</a>
														</td>
														";
													echo "<td width='10%'onclick=\"remove('".$id."'); \" onMouseOver=\"javascript:this.style.background='#F1F1F3';\" onMouseOut=\"javascript:this.style.background='#ffffff'; \" bgcolor=#FFFFFF valign='top' width='90%'>";
													//$ctr = count($ctr);
													
														echo "<a href=\"javascript: delete_setting('".$id."','".$client_id."','".$client_timezone."','".$activity_notes_status."'); \">Remove</a></td>";
													
													echo "</tr>";
												}								
										?>		
										</table>
										
										
										<?php
													if($activity_notes_status=='ALL')
													{
										?>			
														<br />Click <a href="javascript: showSubMenu('notes<?php echo $client_id; ?>'); ">Here</a> to Add the Time you want to receive the note.
										<?php			
													}
													else
													{
										?>
														<br />Click <a href="javascript: showSubMenu('notes_one<?php echo $client_id; ?>'); ">Here</a> to Add the Schedule when Sub-Contractor Finishes work.
										<?php			
													}												
											} 
										?>
										</div>
										
										
										
										
										<div id='notes<?php echo $client_id; ?>' STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
											<table bgcolor='#cccccc' width='300' cellpadding='0' cellspacing='2'><tr><td>
												<table bgcolor='#FFFFCC' width='300' cellpadding='3' cellspacing='3'>
													<tr>
														<td>
														
																						<table border="0">
																							<tr>
																								<td>Email</td><td><INPUT type="text" ID="email_id2<?php echo $client_id; ?>" NAME="email2<?php echo $client_id; ?>"  style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																								<td>CC</td><td><INPUT type="text" ID="cc_id2<?php echo $client_id; ?>" NAME="cc2<?php echo $client_id; ?>"  style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																								<td>
																									<SELECT ID="hour_id_<?php echo $client_id; ?>" NAME="hour" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																										<OPTION VALUE=1>01 AM</OPTION>
																										<OPTION VALUE=2>02 AM</OPTION>
																										<OPTION VALUE=3>03 AM</OPTION>
																										<OPTION VALUE=4>04 AM</OPTION>
																										<OPTION VALUE=5>05 AM</OPTION>
																										<OPTION VALUE=6>06 AM</OPTION>
																										<OPTION VALUE=7>07 AM</OPTION>
																										<OPTION VALUE=8>08 AM</OPTION>
																										<OPTION VALUE=9>09 AM</OPTION>
																										<OPTION VALUE=10>10 AM</OPTION>
																										<OPTION VALUE=11>11 AM</OPTION>
																										<OPTION VALUE=12>12 PM</OPTION>
																										<OPTION VALUE=13>01 PM</OPTION>
																										<OPTION VALUE=14>02 PM</OPTION>
																										<OPTION VALUE=15>03 PM</OPTION>
																										<OPTION VALUE=16>04 PM</OPTION>
																										<OPTION VALUE=17>05 PM</OPTION>
																										<OPTION VALUE=18>06 PM</OPTION>
																										<OPTION VALUE=19>07 PM</OPTION>
																										<OPTION VALUE=20>08 PM</OPTION>
																										<OPTION VALUE=21>09 PM</OPTION>
																										<OPTION VALUE=22>10 PM</OPTION>
																										<OPTION VALUE=23>11 PM</OPTION>
																										<OPTION VALUE=24>12 AM</OPTION>																					
																									</SELECT>											
																							</td>
																							<td>
					
																									<select id="minute_id_<?php echo $client_id; ?>" name="minute" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																									  <option value="0">00</option>
																									  <option value="1">01</option>
																									  <option value="2">02</option>
																									  <option value="3">03</option>
																									  <option value="4">04</option>
																									  <option value="5">05</option>
																									  <option value="6">06</option>
																									  <option value="7">07</option>
																									  <option value="8">08</option>
																									  <option value="9">09</option>
																									  <option value="10">10</option>
																									  <option value="11">11</option>
																									  <option value="12">12</option>
																									  <option value="13">13</option>
																									  <option value="14">14</option>
																									  <option value="15">15</option>
																									  <option value="16">16</option>
																									  <option value="17">17</option>
																									  <option value="18">18</option>
																									  <option value="19">19</option>
																									  <option value="20">20</option>
																									  <option value="21">21</option>
																									  <option value="22">22</option>
																									  <option value="23">23</option>
																									  <option value="24">24</option>
																									  <option value="25">25</option>
																									  <option value="26">26</option>
																									  <option value="27">27</option>
																									  <option value="28">28</option>
																									  <option value="29">29</option>
																									  <option value="30">30</option>
																									  <option value="31">31</option>
																									  <option value="32">32</option>
																									  <option value="33">33</option>
																									  <option value="34">34</option>
																									  <option value="35">35</option>
																									  <option value="36">36</option>
																									  <option value="37">37</option>
																									  <option value="38">38</option>
																									  <option value="39">39</option>
																									  <option value="40">40</option>
																									  <option value="41">41</option>
																									  <option value="42">42</option>
																									  <option value="43">43</option>
																									  <option value="44">44</option>
																									  <option value="45">45</option>
																									  <option value="46">46</option>
																									  <option value="47">47</option>
																									  <option value="48">48</option>
																									  <option value="49">49</option>
																									  <option value="50">50</option>
																									  <option value="51">51</option>
																									  <option value="52">52</option>
																									  <option value="53">53</option>
																									  <option value="54">54</option>
																									  <option value="55">55</option>
																									  <option value="56">56</option>
																									  <option value="57">57</option>
																									  <option value="58">58</option>
																									  <option value="59">59</option>
																									</select>												
																							</td>
																							<td>
																								<input type="button" value="Add" onClick="javascript: add_setting('<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ALL');" id="save_id" name="save" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																							</td><td><a href="javascript: hideSubMenu();">Close</a></td>	
																						</tr>
																					</table>	
																					

													

																																																
														</td>
													</tr>
												</table>
											</table>
										</div>			
										
										
										
										
										
										<div id='notes_one<?php echo $client_id; ?>' STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
											<table bgcolor='#cccccc' width='300' cellpadding='0' cellspacing='2'><tr><td>
												<table bgcolor='#FFFFCC' width='300' cellpadding='3' cellspacing='3'>
													<tr>
														<td>
														
																						<table border="0">
																							<tr>
																								<td>Email</td><td><INPUT type="text" ID="email_id<?php echo $client_id; ?>" NAME="email<?php echo $client_id; ?>" value="<?php echo $email; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																								<td>
																								<td>CC</td><td><INPUT type="text" ID="cc_id<?php echo $client_id; ?>" NAME="cc<?php echo $client_id; ?>" value="<?php echo $cc; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																								<td>
																									<input type="button" value="Save" onClick="javascript: add_setting('<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ONE');" id="save_id<?php echo $client_id; ?>" name="save<?php echo $client_id; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																								</td>
																								<td><a href="javascript: hideSubMenu();">Close</a></td>
																							</tr>
																						</table>									
														</td>
													</tr>
												</table>
											</table>
										</div>											
										
										
										
										
																					
									</td>
								</tr>				  
							</table>	
					
					</td>
				  </tr>  
				</table>	
		</td>
	</tr>
<?php
		}
	}	
?>		
</table>




</body>
</html>
