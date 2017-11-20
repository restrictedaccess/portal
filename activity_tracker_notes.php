<?php
include 'conf.php';
include 'config.php';
include 'lib/activity_tracker_notes_perstaff.php';
include 'lib/activity_tracker_notes_all_staff.php';


//post
$rt = @$_REQUEST["rt"];
$mystaff = @$_REQUEST["mystaff"];
$mystaff_selected = @$_REQUEST["mystaff_selected"];

$p = @$_REQUEST["p"];

if (!isset($p)) $p = 1 ;

if($_SESSION['client_id']=="")
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
$query="SELECT status, hour, minute, client_timezone FROM tb_client_account_settings WHERE client_id='$client_id' LIMIT 1;";
$result=mysql_query($query);
while(list($status,$h,$m,$client_timezone) = mysql_fetch_array($result))
{
	$activity_notes_status = $status;
	$hour = $h;	
	$minute = $m;	
	$tz = $client_timezone;
}
//ended



//client subcontructor's options
$query="SELECT subcontractors.userid, personal.fname, personal.lname FROM subcontractors, personal WHERE subcontractors.status='ACTIVE' AND subcontractors.leads_id=$client_id AND personal.userid=subcontractors.userid ORDER BY personal.fname;";
$result=mysql_query($query);
if($mystaff == "")
{
	$mystaff_options = "<option value='' selected>Select Staff</option>";
}
while(list($userid,$fname,$lname) = mysql_fetch_array($result))
{
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
	$set = ($p-1)*$maxp ;
	$query = "SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE leads_id='$client_id' AND userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') ORDER BY expected_time DESC LIMIT $set, $maxp";
	$result=mysql_query($query);
	$x =0 ;

	while ($row = mysql_fetch_assoc($result)) 
	{
		$temp[$x][0] = $row['expected_time'] ;
		$temp[$x][1] = $row['checked_in_time'] ;
		$temp[$x][2] = $row['note'] ;
		$x++ ;
	}
	return @$temp ;
}

function max_rec($client_id,$mystaff,$a_,$b_) 
{
	$query = "SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE leads_id='$client_id' AND userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') ORDER BY expected_time";
	$result=mysql_query($query);
	return mysql_num_rows($result) ;
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
var current_status = '';
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
var request = makeObject() 				//all object
var tz_request = makeObject()			//tz object
var one_request = makeObject()			//one option object
var none_request = makeObject()			//none option object

function update_setting(id,client_id,tz,update_type)
{
	var objtype;
	if(current_status == "ALL")
	{
		objtype = request
	}
	else
	{
		objtype = one_request
	}
	
	
	hours = document.getElementById('hour_id'+id).value;
	minutes = document.getElementById('minute_id'+id).value;
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
		objtype.open('get', 'activity_notes_setting_update.php?update_type='+update_type+'&cc='+cc_counter+'&email='+email_counter+'&client_id='+client_id+'&tz='+tz+'&hour='+hours+'&minute='+minutes+'&status=UPDATE&id='+id)
		objtype.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		current_status = update_type;
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
		email_counter = document.getElementById('email_id2').value;
		cc_counter = document.getElementById('cc_id2').value;		
	}
	else
	{
		objtype = one_request
		email_counter = document.getElementById('email_id').value;
		cc_counter = document.getElementById('cc_id').value;		
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
		hours = document.getElementById('hour_id').value;
		minutes = document.getElementById('minute_id').value;
		objtype.open('get', 'activity_notes_setting_update.php?add_type='+add_type+'&cc='+cc_counter+'&email='+email_counter+'&client_id='+client_id+'&tz='+tz+'&hour='+hours+'&minute='+minutes+'&status=ADD')
		objtype.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		objtype.onreadystatechange = get_client_settings 
		objtype.send(1)
	}	
}
function none_setting(id,client_id,tz)
{
	if(current_status=="ALL")
	{
		var answer = confirm ("This will remove all your settings for the 'Send Group Activity Notes Daily'. Are you sure you want to continue?")
	}	
	else
	{
		var answer = confirm ("This will change your settings to 'Do not send activity notes'. Are you sure you want to continue?")
	}
	if (answer)
	{
		none_request.open('get', 'activity_notes_setting_update.php?tz='+tz+'&client_id='+client_id+'&status=NONE')
		none_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		document.getElementById("time_settings").innerHTML="";
		none_request.send(1)
		alert("New Setting has been saved.");
		current_status = "NONE";
	}
	else
	{
		validate_section("NONE");
	}
}
function delete_setting(id,client_id,tz,delete_type)
{
	var objtype;
	if(current_status == "ALL")
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
		current_status = delete_type;
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
		current_status = "ONE";
		one_request.onreadystatechange = get_client_settings 
		one_request.send(1)
	}	
	else
	{
		validate_section("ONE");
	}
}
function all_setting(id,client_id,tz)
{
	var answer = confirm ("This will change your settings to 'Send Group Activity Notes Daily'. Are you sure you want to continue?")
	if (answer)
	{
		request.open('get', 'activity_notes_setting_update.php?tz='+tz+'&client_id='+client_id+'&status=ALL')
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		current_status = "ALL";
		request.onreadystatechange = get_client_settings 
		request.send(1)
	}
	else
	{
		validate_section("ALL");
	}
}
function validate_section(selected)
{
	if(current_status=="ALL")
	{
		document.getElementById('ID_ALL').checked=true;
	}
	else if(current_status=="ONE")
	{
		document.getElementById('ID_ONE').checked=true;
	}
	else
	{
		document.getElementById('ID_NONE').checked=true;
	}
	document.getElementById(current_status).checked=false;
	current_status = selected;
}
function timezone_setting(tz,client_id)
{
	tz_request.open('get', 'activity_notes_setting_update.php?client_id='+client_id+'&tz='+tz+'&status=TZ')
	tz_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	tz_request.send(1)
	alert("Timezone settings has been changed.");
}
function get_client_settings()
{
	var objtype;
	var data;
	if(current_status == "ALL")
	{
		objtype = request
	}
	else if(current_status == "ONE")
	{
		objtype = one_request
	}
	else
	{
		objtype = none_request
	}
	data = objtype.responseText
	if(objtype.readyState == 4)
	{
		window.location="activity_tracker_notes.php"; //document.getElementById("time_settings").innerHTML=data;
	}
	else
	{
		document.getElementById("time_settings").innerHTML="<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td><img src='images/ajax-loader.gif'></td></tr></table>";
	}
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

<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="24%"style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"><? include 'clientleftnav.php';?></td>
<td width="76%" >



<table width="60%"  cellspacing="0" cellpadding="3" style="border:#0080C0 solid 1px; margin-left:10px; margin-top:20px; margin-bottom:20px;">
<tr bgcolor="#0080C0">
<td height="21" colspan="3" valign="middle" style="border-bottom:#0080C0 solid 1px;"><font color="#ffffff"><B>Activity Tracker Notes Settings</B></font>
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
					
					$query="SELECT id, status, hour, minute, client_timezone FROM tb_client_account_settings WHERE client_id='$client_id' LIMIT 1;";
					$result=mysql_query($query);
				
					while(list($id,$status,$h,$m,$client_timezone) = mysql_fetch_array($result))
					{
						$setting_id = $id;
						$activity_notes_status = $status;
						$hour = $h;
						$minute = $m;
						$tz = $client_timezone;
						echo '<script language="javascript"> current_status="'.$status.'"; </script>';
					}
			?>				
			<table width="99%" cellspacing="0" cellpadding="3" style="margin-left:0px; margin-top:5px; margin-bottom:5px;">	
				   <tr bgcolor="<?php echo $clr; ?>">
					<td width='0%' <?php echo $clr; ?> valign='top'>
						<input name="activity_notes_seetings" type="radio" id="ID_NONE" value="NONE" <?php if($activity_notes_status=='NONE') echo "checked"; ?> <?php echo "onClick=\"javascript: none_setting(0,".$client_id.",'".$client_timezone."');\""; ?>>
					</td>				   
					<td width='0%' <?php echo $clr; ?> valign='top'>:</td>
					<td width='100%' <?php echo $clr; ?> valign='top'>Do not send Activity Notes.</td>
				  </tr>				 
				 <tr bgcolor="<?php echo $clr; ?>" >
					<td width='0%' valign='top' <?php echo $clr; ?>>
						<input name="activity_notes_seetings" type="radio" id="ID_ONE" value="ONE" <?php if($activity_notes_status=='ONE') echo "checked"; ?> <?php echo "onClick=\"javascript: one_setting(0,".$client_id.",'".$client_timezone."');\""; ?>>
					</td>				 
					<td width='0%' valign='top' <?php echo $clr; ?>>:</td>
					<td width='100%' valign='top' <?php echo $clr; ?>>Send Individual Activity Tracker Notes when Sub-Contractor Finishes work.</td>
				  </tr>
				<tr bgcolor="<?php echo $clr; ?>">	  
					<td width='0%' valign='top' <?php echo $clr; ?>>
						<input name="activity_notes_seetings" type="radio" id="ID_ALL" value="ALL" <?php if($activity_notes_status=='ALL') echo "checked"; ?> <?php echo "onClick=\"javascript: all_setting(0,".$client_id.",'".$client_timezone."');\""; ?>>
					</td>
					<td width='0%' valign='top' <?php echo $clr; ?>>:</td>
					<td width='100%' valign='top' <?php echo $clr; ?>>Send Group Activity Notes Daily.</td>
				</tr>	
				<tr bgcolor="<?php echo $clr; ?>">
					<td width='40%' <?php echo $clr; ?> valign='top' colspan="3">
					
					
					
						<div id="time_settings">
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
							<?php if($tz == "") echo "<OPTION VALUE='' selected>Select Time Zone</OPTION>"; else echo "<OPTION VALUE='".$tz."' selected>".$tz."</OPTION>"; ?>
							<OPTION VALUE="Australia/Sydney">Australia/Sydney</OPTION>
							<OPTION VALUE="Asia/Manila">Asia/Manila</OPTION>
							<OPTION VALUE="Europe/London">Europe/London</OPTION>
							<OPTION VALUE="America/New_York">America/New_York</OPTION>
						</SELECT><br /><br />								
						<?php
						}
						?>
						<table width="100%" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC" border="0">
						<?php
								//check the number of records
								$queryCheck="SELECT id, status, hour, minute, client_timezone, email, cc FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');";
								$result=mysql_query($queryCheck);
								$ctr=@mysql_num_rows($result);
								//end
														
								$query="SELECT id, status, hour, minute, client_timezone, email, cc FROM tb_client_account_settings WHERE client_id='$client_id' AND (status='ALL' OR status='ONE');";
								$result=mysql_query($query);
								while(list($id,$status,$h,$m,$client_timezone,$email,$cc) = mysql_fetch_array($result))
								{
										//date formating
										$tm = $h.":".$m.":00";
										$date_time = new DateTime($tm);
										$time = $date_time->format('h:i:a');	
										$date = $date_time->format('M-d');
										//ended											
								
									echo "<tr>";	
									echo "<td width='34%' bgcolor='#ffffff'>";
									
									
									
									
									
									
									
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
																													else
																													{
																														$hour_display = "<OPTION VALUE=".$h." selected>".$h." AM</OPTION>";
																													}
																													break;
																											}	
																																															
																											if($hour == "")
																												echo "<OPTION VALUE='' SELECTED>Hour</OPTION>";
																											else
																												echo $hour_display;
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
																							<td><a href="javascript: hideSubMenu();">Close</a>
																							</td>
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
																								<td><input type="button" value="Save" onClick="javascript: update_setting('<?php echo $id; ?>','<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ONE');" id="save_id<?php echo $id; ?>" name="save<?php echo $id; ?>" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
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
									
									
									
									
									
									
									
									
									if($activity_notes_status=='ALL')
									{
										if($cc != "")
										{
											echo "<strong>Email:&nbsp;</strong><em>".$email."</em>,&nbsp;<strong>CC:</strong>&nbsp;<em>".$cc."&nbsp;</em>,&nbsp;<strong>Time:&nbsp;</strong><em>".$time."</em>";
										}	
										else
										{
											echo "<strong>Email:&nbsp;</strong><em>".$email."</em>,&nbsp;<strong>Time:&nbsp;</strong><em>".$time."</em>";
										}									
									}
									else
									{
										if($cc != "")
										{
											echo "<strong>Email:&nbsp;</strong><em>".$email."</em>,&nbsp;<strong>CC:</strong>&nbsp;<em>".$cc."&nbsp;</em>";
										}	
										else
										{
											echo "<strong>Email:&nbsp;</strong><em>".$email."</em>";
										}									
									}	
									echo "</td>";
									echo "<td width='34%'onclick=\"showSubMenu('notes_".$id."'); \" onMouseOver=\"javascript:this.style.background='#F1F1F3';\" onMouseOut=\"javascript:this.style.background='#ffffff'; \" bgcolor=#FFFFFF valign='top' width='90%'>

										<a href=\"javascript: showSubMenu('notes_".$id."'); \">Edit</a>
										</td>
										";
									echo "<td width='33%'onclick=\"remove('".$id."'); \" onMouseOver=\"javascript:this.style.background='#F1F1F3';\" onMouseOut=\"javascript:this.style.background='#ffffff'; \" bgcolor=#FFFFFF valign='top' width='90%'>";
									if($ctr > 1)
									{
										echo "<a href=\"javascript: delete_setting('".$id."','".$client_id."','".$client_timezone."','".$activity_notes_status."'); \">Remove</a></td>";
									}
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
																				<td>Email</td><td><INPUT type="text" ID="email_id2" NAME="email2" value="" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																				<td>CC</td><td><INPUT type="text" ID="cc_id2" NAME="cc2" value="" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>																			
																				<td>
																					<SELECT ID="hour_id" NAME="hour" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
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
	
																					<select id="minute_id" name="minute" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
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
																			<td><input type="button" value="Add" onClick="javascript: add_setting('<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ALL');" id="save_id" name="save" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																			<td><a href="javascript: hideSubMenu();">Close</a></td>
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
										
										
																		<!--<INPUT type="hidden" ID="hour_id" NAME="hour" value="">-->
																		<!--<INPUT type="hidden" id="minute_id" NAME="minute" value="">-->
																		<table border="0">
																			<tr>
																				<td>Email</td><td><INPUT type="text" ID="email_id" NAME="email" value="" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																				<td>CC</td><td><INPUT type="text" ID="cc_id" NAME="cc" value="" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
																				<td><input type="button" value="Add" onClick="javascript: add_setting('<?php echo $client_id; ?>','<?php echo $client_timezone; ?>','ONE');" id="save_id" name="save" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></td>
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









<table width="60%"  cellspacing="0" cellpadding="3" style="border:#0080C0 solid 1px; margin-left:10px; margin-top:20px; margin-bottom:20px;">
  <tr bgcolor="#0080C0">
    <td height="21" colspan="3" valign="middle" style="border-bottom:#0080C0 solid 1px;"><font color="#ffffff"><b>Report on Activity tracker notes</b></font></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;' colspan="3">
      <form action="?" id="form" name="form" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="3">
					<table>
						<tr>
								<td align="left">
									<font size="1">My&nbsp;RemoteStaff</font>
								</td>						
								<td align="left">
								  <select name="mystaff_selected" id="mystaff_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
									<?php echo $mystaff_options; ?>
								  </select>
								</td>
								<td width="0%" align="left">
								  <input type="submit" value="Send Selected Staff Activity Notes" name="send" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
								</td>				
								<td width="100%" align="left">
								  <input type="submit" value="Send All Staff Activity Notes" name="send_all" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
								</td>										
						</tr>
					</table>
			</td>
          </tr>		
          <tr>
            <td><font size="1">Date</font></td>
            <td><font size="1">My&nbsp;RemoteStaff</font></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <select size="1" name="rt" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                <?php
																					switch ($rt) 
																					{
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
            </td>
            <td align="left">
              <select name="mystaff" id="mystaff_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
                <?php echo $mystaff_options; ?>
              </select>
            </td>
            <td width="100%" align="left">
              <input type="submit" value="View Result" name="quick_search" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
            </td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
		  <?php if(count($notes) > 0) { ?>
          <tr>
            <td colspan="3" bgcolor="#E9E8E9">
              <table width="100%">
                <tr>
                  <td><strong><?php echo $mystaff_name."<i> (".$title.")</i>"; ?></strong></td>
                  <td align="right"><?php echo $navpage ; ?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3">
					<table cellpadding="3" cellspacing="3">
							
								<?php
										$clr = "#CCFFCC";
										//$query="SELECT note FROM tb_admin_activity_tracker_notes WHERE client_id='$client_id' AND subcon_id='$mystaff' AND (DATE_FORMAT(date_to_execute_from,'%Y-%m-%d') <= '$a_' AND DATE_FORMAT(date_to_execute_to,'%Y-%m-%d') >= '$b_')";
										$query="SELECT note, date_to_execute_from, date_to_execute_to FROM tb_admin_activity_tracker_notes WHERE status='ACTIVE' AND client_id='$client_id' AND subcon_id='$mystaff'";
										$result=mysql_query($query);
										while(list($note,$date_to_execute_from,$date_to_execute_to) = mysql_fetch_array($result))
										{
										
											$date_time1 = new DateTime($date_to_execute_from);
											$date1 = $date_time1->format('M d, Y');		
											
											$date_time2 = new DateTime($date_to_execute_to);
											$date2 = $date_time2->format('M d, Y');
											
											if($clr == "#CCFFCC")
												$clr = "#EEFFEE";
											else
												$clr = "#CCFFCC";		
											echo '<tr bgcolor='.$clr.'>
													<td colspan=3>
													<i>Note(s) on '.$date1.' to '.$date2.'</i>
													</td>
											</tr>';																					
											echo '<tr bgcolor='.$clr.'>
													<td colspan=3>
													'.$note.'
													</td>
											</tr>';										
										}
								?>
					  
					  <tr bgcolor="#E9E8E9">
						<td><strong>Date</strong></td>
						<td><strong>Time</strong></td>
						<td><strong>Activity&nbsp;Notes</strong></td>
					  </tr>						  
								<?php
								$clr = "#CCFFCC";
								for ($x = 0 ;$x<count($notes) ;$x++) 
								{																	
									if($clr == "#CCFFCC")
										$clr = "#EEFFEE";
									else
										$clr = "#CCFFCC";
										
										//change date format
										$date_time = new DateTime($notes[$x][1]);
										$time = $date_time->format('h:i:a');	
										$date = $date_time->format('M-d');	
										//ended					
								?>

									  <tr bgcolor="<?php echo $clr; ?>">
										<td width="10%">
											<?php 
												if($date == $current_date)
												{
													//do nothing
												}
												else
												{
													echo $date;
												}
											?>
										</td>
										<td width="10%"><?php echo $time; ?></td>
										<td width="80%"><?php echo $notes[$x][2]; ?></td>
									  </tr>
								<?php
									$current_date = $date;
								}
								?>
					</table>
			</td>
          </tr>		  
          <tr>
            <td colspan="3" bgcolor="#E9E8E9">
              <table width="100%">
                <tr>
                  <td align="right"><?php echo $navpage ; ?></td>
                </tr>
            </table></td>
          </tr>
		  <?php } ?>
        </table>
    </form></td>
  </tr>
</table></td>
</tr>
<tr>
<td colspan="3" style="border-top:#666666 solid 1px;">&nbsp;</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="3" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center">
</td></tr>
</table></td>
</tr>
</table>
<? include 'footer.php';?>

</body>
</html>