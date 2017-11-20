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



<td width=100% valign=top height="2000">
	<table cellpadding="3" cellspacing="3" height="100%" width="100%"><tr><td height="100%" width="100%" valign="top">
		<iframe id="frame" name="frame" width="100%" height="100%" marginheight="1" marginwidth="1" src="../portal-index.php?to=<?php echo @$_REQUEST["to"]; ?>" frameborder="0" scrolling="yes">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
	</td></tr></table>
</td>



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