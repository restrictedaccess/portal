 <?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../function.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}

$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
mysql_query('SET time_zone='.$timeZone);

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

/// Check the Business Partners TO DO's List and Calendar
$sqlCheckTodo="SELECT l.fname,l.lname ,t.id, t.date_created, t.subject, DATE_FORMAT(t.start_date,'%D %b %Y'), DATE_FORMAT(t.due_date,'%D %b %Y'), t.percentage, t.details
FROM todo t
LEFT OUTER JOIN leads l ON lead_id = l.id
WHERE agent_no = $agent_no AND due_date >= '$AusDate';";
$result_sql_1 =mysql_query($sqlCheckTodo);
$count1=@mysql_num_rows($result_sql_1);
//echo $count1;
$sqlCheckCalendar="SELECT l.fname,l.lname ,c.title,c.details,ctime,DATE_FORMAT(event_date,'%D %b %Y')
FROM calendar c
LEFT OUTER JOIN leads l ON lead_id = l.id WHERE agent_no = $agent_no AND event_date >='$AusDate';";
$result_sql_2 =mysql_query($sqlCheckCalendar);
$count2=@mysql_num_rows($result_sql_2);


$total_count=$count1+$count2;
///





$action=$_REQUEST['action'];

$month=$_REQUEST['month'];
$yesterday=$_REQUEST['yesterday'];
$this_day=$_REQUEST['this_day'];
$tomorrow=$_REQUEST['tomorrow'];
$day=$_REQUEST['day'];
$event_date =$_REQUEST['event_date'];
//$searchDate=$_REQUEST['searchDate'];
//echo $event_date;
//echo $month;
switch($month)
	{
		case '01':
		$bmonth= "January";
		break;
		case '02':
		$bmonth= "February";
		break;
		case '03':
		$bmonth= "March";
		break;
		case '04':
		$bmonth= "April";
		break;
		case '05':
		$bmonth= "May";
		break;
		case '06':
		$bmonth= "June";
		break;
		case '07':
		$bmonth= "July";
		break;
		case '08':
		$bmonth= "August";
		break;
		case '09':
		$bmonth= "September";
		break;
		case '10':
		$bmonth= "October";
		break;
		case '11':
		$bmonth= "November";
		break;
		case '12':
		$bmonth= "December";
		break;
		
	}

if($this_day=="" && $yesterday=="" && $tomorrow=="" && $event_date=="")
{
	$this_day="TRUE";
}

if ($this_day=="TRUE")
{
	$this_day="TRUE";
	$current ="Current";
	$day=0;
}

if($yesterday=="TRUE" && $this_day=="")
{
	$day=$day+1;
	$current ="Previous";
	if($day==0){
	$current ="Current";
	}
}

if($tomorrow=="TRUE" && $this_day=="")
{
	$day=$day-1;
	$current ="Next";
	if($day==0){
	$current ="Current";
	}
}



/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$length=strlen($agent_code);
	
}


$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
 for ($i = 0; $i < count($monthArray); $i++)
  {
      if($month == $monthArray[$i])
      {
	 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
      else
      {
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
   }

if(isset($_POST['save']))
{
	$action_record = $_REQUEST['action_record'];
	$quantity =$_REQUEST['quantity']; 
	$txt = $_REQUEST['txt'];
	$txt=filterfield($txt);
	
	$sqlCheck="SELECT id, quantity,history 
				FROM manual_history 
				WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' 
				AND actions = '$action_record' 
				AND agent_no =$agent_no;";
				
	$result1=mysql_query($sqlCheck);
	$ctr=@mysql_num_rows($result1);
	if ($ctr >0 )
	{
		list($id,$quantities,$history)=mysql_fetch_array($result1);	
		$total = $quantities + $quantity;
		$history.="<br>".$txt;
		$sql="UPDATE manual_history SET quantity = $total ,
					history = '$history'
					WHERE id = $id 
					AND DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' 
					AND actions = '$action_record' 
					AND agent_no =$agent_no;";
	}
	else {
		
		$sql="INSERT INTO manual_history SET agent_no = $agent_no, 
						actions = '$action_record', 
						history = '$txt', 
						date_created = '$ATZ', 
						quantity = $quantity ;";
	
	}
	$result = mysql_query($sql);						
	if(!$result)
	{
		echo ("Query: $queryInsert\n<br />MySQL Error: " . mysql_error());
	}
	else
	{
		echo("<html><head><script>function update(){top.location='agentHome.php';}var refresh=setInterval('update()',1200);
	</script></head><body onload=refresh><body></html>");
	}
	

						
}
//email_update  call_update notes_update meeting_update
// id, agent_no, actions, history, date_created, quantity, quantity2
if(isset($_POST['email_update']))
{
	$quantity2=$_REQUEST['quantity2'];
	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'EMAIL' AND agent_no =$agent_no;";
	$result =mysql_query($checkSql);
	$row = mysql_fetch_array($result);
	$counter = $row[0];
	if($counter >0 ){
		$sql="UPDATE manual_history SET quantity2 = $quantity2 WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'EMAIL' AND agent_no =$agent_no;";
	}else{
		$sql="INSERT INTO manual_history SET quantity2 = $quantity2 , date_created = '$ATZ' , actions = 'EMAIL' , agent_no = $agent_no;";
	}	
	//echo $sql;
	mysql_query($sql);
}
if(isset($_POST['call_update']))
{
	$quantity3=$_REQUEST['quantity3'];
	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'CALL' AND agent_no =$agent_no;";
	$result =mysql_query($checkSql);
	$row = mysql_fetch_array($result);
	$counter = $row[0];
	if($counter >0 ){
		$sql2="UPDATE manual_history SET quantity2 = $quantity3 WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'CALL' AND agent_no =$agent_no;";
	}else{
		$sql2="INSERT INTO manual_history SET quantity2 = $quantity3 , date_created = '$ATZ' , actions = 'CALL' , agent_no = $agent_no;";
	}
	//echo $sql2; 
	mysql_query($sql2);
}

if(isset($_POST['notes_update']))
{
	$quantity4=$_REQUEST['quantity4'];
	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MAIL' AND agent_no =$agent_no;";
	$result =mysql_query($checkSql);
	$row = mysql_fetch_array($result);
	$counter = $row[0];
	if($counter >0 ){
		$sql3="UPDATE manual_history SET quantity2 = $quantity4  WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MAIL' AND agent_no =$agent_no;";
	}else{
		$sql3="INSERT INTO manual_history SET quantity2 = $quantity4 , date_created = '$ATZ' , actions = 'MAIL' , agent_no = $agent_no;";
	}	
	mysql_query($sql3);
}

if(isset($_POST['meeting_update']))
{
	$quantity5=$_REQUEST['quantity5'];
	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MEETING FACE TO FACE' AND agent_no =$agent_no;";
	$result =mysql_query($checkSql);
	$row = mysql_fetch_array($result);
	$counter = $row[0];
	if($counter >0 ){
		$sql4="UPDATE manual_history SET quantity2 = $quantity5 WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MEETING FACE TO FACE' AND agent_no =$agent_no;";
	}else{
		$sql4="INSERT INTO manual_history SET quantity2 = $quantity5 , date_created = '$ATZ' , actions = 'MEETING FACE TO FACE' , agent_no = $agent_no;";
	}	
	mysql_query($sql4);
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Business Partner</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">

<script type='text/javascript' language='JavaScript' src='../js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='../js/form_utils.js'></script>

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../ang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

<script src="../select_addControl.js"></script>	
<script src="../selectRecords.js"></script>
<script type="text/javascript">
<!--

function checkFields()
{
	//var count = document.form.quantity.value;
	//alert(document.form.action_record.value);
	//return false;
	
	if(document.form.quantity.value=="")
	{
		alert("Please put a Quantity!");
		return false;
	}
	if(isNaN(document.form.quantity.value))
	{
		alert("Quantity is not a Number!");
		document.form.quantity.focus();
		document.form.quantity.value="";
		return false;
	}
	if(document.form.action_record.selectedIndex=="0")
	{
		alert("Please choose a Action!");
		return false;
	}
	/*
	//email_no call_no, mail_no , meeting_no
	//EMAIL CALL MAIL MEETING FACE TO FACE
	if(document.form.action_record.value=="EMAIL")
	{
		if(document.form.quantity.value > document.form.email_no.value)
		{
			alert("Quantity must not be More than the result!");
			return false;
		}
	}
	
	if(document.form.action_record.value=="CALL")
	{
		if(document.form.quantity.value > document.form.call_no.value)
		{
			alert("Quantity must not be More than the result!");
			return false;
		}
	}
	
	if(document.form.action_record.value=="MAIL")
	{
		if(document.form.quantity.value > document.form.mail_no.value)
		{
			alert("Quantity must not be More than the result!");
			return false;
		}
	}
	
	if(document.form.action_record.value=="MEETING FACE TO FACE")
	{
		if(document.form.quantity.value > document.form.meeting_no.value)
		{
			alert("Quantity must not be More than the result!");
			return false;
		}
	}
	*/
	return true;
	
}
function checkFields2(actions)
{
/*
//email_update  call_update notes_update meeting_update
//EMAIL
if(actions =="email")
{
	if(document.form.email_no.value!=""){
	if(document.form.quantity2.value!=""){
	    if(!isNaN(document.form.quantity2.value)){
			if(parseInt(document.form.quantity2.value) > parseInt(document.form.email_no.value))
				{
					alert("Must not be more than the Total!");
					document.form.quantity2.value="";
					document.form.quantity2.focus();
					return false;
				}
		}
		else{
			alert("Not a Number");
			document.form.quantity2.value="";
			document.form.quantity2.focus();
			return false;
		}
	}else{
		alert("Please enter a Number!");
		return false;
	}
	}else{
		alert("Please add first a Record! ");
		//document.getElementById("email_update").disabled=true;
		document.form.email_update.disabled=true;
		document.getElementById("quantity2").disabled=true;
		return false;
	}	
	
}
///CALL
if(actions =="call")
{
if(document.form.call_no.value!=""){
	if(document.form.quantity3.value!=""){
	    if(!isNaN(document.form.quantity3.value)){
			if(parseInt(document.form.quantity3.value) > parseInt(document.form.call_no.value))
				{
					alert("Must not be more than the Total!");
					document.form.quantity3.value="";
					document.form.quantity3.focus();
					return false;
				}
			}
			else{
			alert("Not a Number");
			document.form.quantity3.value="";
			document.form.quantity3.focus();
			return false;
			}
		}else{
		alert("Please enter a Number!");
		return false;
	}
}else{
		alert("Please add first a Record! ");
		//document.getElementById("call_update").disabled=true;
		document.form.call_update.disabled=true;
		document.getElementById("quantity3").disabled=true;
		return false;
	}	

}
///NOTES
if(actions =="notes")
{
if(parseInt(document.form.mail_no.value)>0){
	if(document.form.quantity4.value!=""){
		  if(!isNaN(document.form.quantity4.value)){
				if(parseInt(document.form.quantity4.value) > parseInt(document.form.mail_no.value))
				{
					alert("Must not be more than the Total!");
					document.form.quantity4.value="";
					document.form.quantity4.focus();
					return false;
				}
			}
			else{
			alert("Not a Number");
			document.form.quantity4.value="";
			document.form.quantity4.focus();
			return false;
			}
		}else{
		alert("Please enter a Number!");
		return false;
		}	
}else{
  alert("Please add first a Record! ");
  //sdocument.getElementById("notes_update").disabled=true;
  document.form.notes_update.disabled=true;
  document.getElementById("quantity4").disabled=true;
  return false;
 }	
}
///MEETING

if(actions =="meeting")
{
if(parseInt(document.form.meeting_no.value)>0){
if(document.getElementById("quantity5").value!=""){
		  if(!isNaN(document.getElementById("quantity5").value)){
				if(document.getElementById("quantity5").value > document.getElementById("meeting_no").value)
				{
					alert("Must not be more than the Total!");
					document.getElementById("quantity5").value="";
					document.getElementById("quantity5").focus();
					return false;
				}
			}
			else{
			alert("Not a Number");
			document.getElementById("quantity5").value="";
			document.getElementById("quantity5").focus();
			return false;
			}
		}else{
		alert("Please enter a Number!");
		return false;
		}	
}else{
  alert("Please add first a Record! ");
  //sdocument.getElementById("notes_update").disabled=true;
  document.form.meeting_update.disabled=true;
  document.getElementById("quantity5").disabled=true;
  return false;
 }	
 		
}








//////////////////
*/
return true;
	
}
-->
</script>
<script language="JavaScript1.2">

// Drop-in content box- By Dynamic Drive
// For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
// This credit MUST stay intact for use

var ie=document.all
var dom=document.getElementById
var ns4=document.layers
var calunits=document.layers? "" : "px"

var bouncelimit=32 //(must be divisible by 8)
var direction="up"

function initbox(){
if (!dom&&!ie&&!ns4)
return
crossobj=(dom)?document.getElementById("dropin").style : ie? document.all.dropin : document.dropin
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
crossobj.top=scroll_top-250+calunits
crossobj.visibility=(dom||ie)? "visible" : "show"
dropstart=setInterval("dropin()",50)
}

function dropin(){
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
if (parseInt(crossobj.top)<170+scroll_top) //// top
crossobj.top=parseInt(crossobj.top)+40+calunits
else{
clearInterval(dropstart)
bouncestart=setInterval("bouncein()",50)
}
}

function bouncein(){
crossobj.top=parseInt(crossobj.top)-bouncelimit+calunits
if (bouncelimit<0)
bouncelimit+=8
bouncelimit=bouncelimit*-1
if (bouncelimit==0){
clearInterval(bouncestart)
}
}

function dismissbox(){
if (window.bouncestart) clearInterval(bouncestart)
crossobj.visibility="hidden"
}

function redo(){
bouncelimit=32
direction="up"
initbox()
}

function truebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
<? if ($total_count >0 ) {?>
	window.onload=initbox
<? }?>

</script>



<style type="text/css">
<!--
div.scroll {
	height: 100%;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
  
.remind_data{
font:9px tahoma;
padding:3px;
}  

.remind_label{
font:9px tahoma;
} 

.remind_tr{
border:#CCCCCC solid 1px;
}
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div id="dropin" style="position:absolute; visibility:hidden; border: 9px solid orange; background-color:#FFFFFF; width: 710px; padding: 8px; left: 289px; top: 157px; height:auto ; font: bold 11px 'Lucida Grande', 'Trebuchet MS', Verdana, Helvetica, sans-serif; color: #2d2b2b; " >
<div style="float:left;">Things that needs your Attention:</div>
<div style="float:right" ><a href="#" class="link10" onClick="dismissbox();return false" title="Close Box">[X]</a>&nbsp;&nbsp;</div>
<div style="clear:both;"></div>
<table width="100%">
<tr><td width="48%" valign="top"><b>CALENDAR</b>
<? if ($count2>0) {?>
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="0" cellspacing="0" >
<tr >
<td width="14%" height="29"  class="remind_label"><b>#</b></td>
<td width="41%" class="remind_label"><b>Leads</b></td>
<td width="11%" class="remind_label"><b>Event Time</b></td>
<td width="34%" class="remind_label"><B>Event Date</B></td>
</tr>
<?
//l.fname,l.lname ,c.title,c.details,ctime,event_date
$bgcolor="#E6E6F0";	
$counter1=0;
while(list($leads_fname,$leads_lname ,$title,$details,$time,$event_date)=mysql_fetch_array($result_sql_2))
{
	$details=str_replace("\n","<br>",$details);
	$counter1++;
	if ($time=="10")
	{
		$time = "10:00 am";
	}
	else if ($time=="11")
	{
		$time = "11:00 am";
	}
	else if ($time=="12")
	{
		$time = "12:00 noon";
	}
	else if ($time=="13")
	{
		$time = "1:00 pm";
	}
	else if ($time=="14")
	{
		$time = "2:00 pm";
	}
	else if ($time=="15")
	{
		$time = "3:00 pm";
	}
	else if ($time=="16")
	{
		$time = "4:00 pm";
	}
	else if ($time=="17")
	{
		$time = "5:00 pm";
	}
	else if ($time=="18")
	{
		$time = "6:00 pm";
	}
	else if ($time=="19")
	{
		$time = "7:00 pm";
	}
	else if ($time=="20")
	{
		$time = "8:00 pm";
	}
	else if ($time=="21")
	{
		$time = "9:00 pm";
	}
	else if ($time=="22")
	{
		$time = "10:00 pm";
	}
	else if ($time=="23")
	{
		$time = "11:00 pm";
	}
	else if ($time=="24")
	{
		$time = "12:00 am";
	}
	else
	{
		$time = $time."am";
	}
?>
<tr bgcolor=<? echo $bgcolor;?>>
<td class="remind_data"><?=$counter1;?>)</td>
<td class="remind_data"><?=$leads_fname." ".$leads_lname;?></td><td class="remind_data"><?=$time;?></td><td class="remind_data"><?=$event_date;?></td></tr>
<tr bgcolor=<? echo $bgcolor;?>>
<td valign="top" colspan="4" class="remind_data" style="border-bottom: solid 1px #CCCCCC;"><?=$title;?><br><?=$details;?></tr>

<?	
if($bgcolor=="#E6E6F0"){$bgcolor="#FFFFFF";}else{$bgcolor="#E6E6F0";}
}
?>
</table>
<? }?>
</td>
<td width="52%" valign="top"><b>TO DO's</b>
<? if ($count1>0) {?>
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="0" cellspacing="0" >
<tr >
<td width="14%" height="29"  class="remind_label"><b>#</b></td>
<td width="21%" height="30" class="remind_label"><b>Start Date</b></td>
<td width="22%" class="remind_label"><b>Due Date</b></td>
<td width="57%" class="remind_label"><B>Subject</B></td>
</tr>
<?
$bgcolor="#E6E6F0";	
$counter2=0;
while(list($leads_fname,$leads_lname ,$lead_id, $date_created, $subject, $start_date, $due_date, $percentage, $details)=mysql_fetch_array($result_sql_1))
{
	$details=str_replace("\n","<br>",$details);
	$counter2++;
?>
<tr bgcolor=<? echo $bgcolor;?>>
<td class="remind_data"><?=$counter2;?>)</td>
<td class="remind_data"><?=$start_date;?></td><td class="remind_data"><?=$due_date;?></td><td class="remind_data"><?=$subject;?></td></tr>
<tr bgcolor=<? echo $bgcolor;?>>
<td height="41" colspan="4" valign="top" class="remind_data" style="border-bottom: solid 1px #CCCCCC;"><?=$details?>
</tr>

<?	
if($bgcolor=="#E6E6F0"){$bgcolor="#FFFFFF";}else{$bgcolor="#E6E6F0";}
}
?>
</table>
<? }?>
</td>
</tr>
</table>
</div>
<form method="POST" name="form" action="agentHome.php">
<script language=javascript src="../js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>

<ul class="glossymenu">
  <li class="current"><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
   <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'agentleftnav.php';?>
</td>
<td width=100% valign=top >
<table width=100%  cellspacing=2 cellpadding=2 border=0 align=left >
<tr><td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Business Partner Home</b></font></td>
</tr>
<tr ><td colspan=3 valign="top" ><b><? echo $name;?></b></td></tr>
<tr>
<td width="74%" valign="top" align="left">

<p style=" border:#CCCCCC solid 1px; width:97%"><a href="agentHome.php?day=<? echo $day;?>&yesterday=TRUE" class="link10"><img src="../images/arrow_back.gif" alt="previous day" border="0" align="texttop"> Previous Day </a> | <a href="agentHome.php?this_day=TRUE" class="link10">Current Day</a> | <a href="agentHome.php?day=<? echo $day;?>&tomorrow=TRUE" class="link10">Next Day</a> <img src="../images/arrow_next.gif" alt="previous day" border="0" align="texttop">&nbsp;&nbsp;Date Search
<input type="text" name="event_date" id="event_date" class="text" style=" width:10%;" > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" /><input type="image" align="absmiddle"  src="../images/001_25.gif" title="go">
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "event_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script>
</p>
<p style=" border:#CCCCCC solid 1px; width:97%">&nbsp;&nbsp;<b><font color="#666666">Month</font></b>&nbsp;<select name="month"  style="font-size: 12px;" class="text" onChange="javascript: document.form.submit();">
<? echo $monthoptions;?>
</select></p>

<?

if ($month=="") {

if ($event_date =="")
{
$sqlDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%W'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e'),
DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%D %M %Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%c'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e')";
//echo "<p>".$sqlDay."</p>";
$result=mysql_query($sqlDay);
list($dayname,$date,$date2,$cyear,$cmonth,$cday)=mysql_fetch_array($result);
$event_date=$cyear."-".$cmonth."-".$cday;
}
if ($event_date!="")
{
	$searchDate=$event_date;
	$sqlDay="SELECT DATE_FORMAT('$searchDate','%W %D %M %Y'),DATE_FORMAT('$searchDate','%Y'),DATE_FORMAT('$searchDate','%c'),DATE_FORMAT('$searchDate','%e')";
	//echo $sqlDay;
	$result=mysql_query($sqlDay);
	list($dayname,$cyear,$cmonth,$cday)=mysql_fetch_array($result);
}

$conditions ="AND YEAR(date_created) = '$cyear' AND  MONTH(date_created) = '$cmonth' AND DAY(date_created) ='$cday'";
$conditions2 ="AND YEAR(timestamp) = '$cyear' AND  MONTH(timestamp) = '$cmonth' AND DAY(timestamp) ='$cday'";

}
if($month!="")
{
	//echo $month;
	$conditions ="AND  MONTH(date_created) = '$month' ";
	$conditions2 ="AND MONTH(timestamp) = '$month'";
	$current ="Monthly (".$bmonth.")";


}

?>



<table width="97%" height="34%" style="border:#CCCCCC solid 1px;" cellpadding="4" cellspacing="0">
<tr bgcolor='#666666'>
<td height="20" colspan="2" valign="middle"><font color='#FFFFFF'><b>&nbsp;&nbsp;<? echo $current;?> Business Partner Summary Action Reports</b></font></td>
<td width="54%" align="right"><font color='#FFFFFF'><b><? echo $dayname;//echo $AustodayDate;?></b></font></td>
</tr>
</table>
<table width="97%" height="34%" style="border:#CCCCCC solid 1px;" cellpadding="4" cellspacing="0">
<tr><td style="border-bottom: #666666 solid 1px;"> <strong>Actions</strong></td>
<td style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><strong>&nbsp;</strong></td>
<td style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;" align="center"><strong>Manually Added</strong></td>
<td colspan="2" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><strong>Successful Contacts</strong></td>
</tr>
<tr >
<td width="192"  style="border-bottom: #666666 solid 1px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="agentHome.php?action=EMAIL&event_date=<? echo $event_date;?>&yesterday=<? echo $yesterday;?>&this_day=<? echo $this_day;?>&tomorrow=<? echo $tomorrow;?>&month=<? echo $month;?>" class="link20">Email:</a></b></td>
<td width="168" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?

$sql="SELECT COUNT(actions) FROM history h WHERE actions='EMAIL' AND agent_no =$agent_no $conditions GROUP BY actions;";
$res = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
list($email_no) = mysql_fetch_array($res);
if($email_no > 0)
{
	echo "<b>".$email_no ."</b> &nbsp;&nbsp;&nbsp;&nbsp;Sent emails made";
}
else
{
	echo "&nbsp;";
}
?></td>
<td width="189" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;" align="center"><?
$queryRecord1="SELECT quantity FROM manual_history WHERE actions='EMAIL' AND agent_no =$agent_no $conditions ;";
//echo $queryRecord1;
$query_result1=mysql_query($queryRecord1);
$email_count = 0;
list($email_count )=mysql_fetch_array($query_result1);
if($email_count > 0) {
	echo "<a href='#' onClick=showRecords('EMAIL')>".$email_count ."</a>";
}
else
{
	echo "&nbsp;";
}
?>
<input type="hidden" name="email_no" id="email_no" value="<?=$email_count;?>"></td>
<td valign="top" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;">
<?
$sqlRecord1="SELECT quantity2 FROM manual_history WHERE actions='EMAIL' AND agent_no =$agent_no $conditions ;";
$sql_result1=mysql_query($sqlRecord1);
$email_count2 = 0;
list($email_count2 )=mysql_fetch_array($sql_result1);
if($email_count2 > 0) {
	echo $email_count2;
}
else
{
	echo "&nbsp;";
}
?></td>
<td width="363" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;" valign="top">

<a href='javascript: show_hide("reply_form1");'><img src="../images/add.gif" alt="Add Successful Number of Contacts" border="0"></a>
<div id='reply_form1' style='display:none;'>
<i>
<input type='text' name="quantity2" id='quantity2' style='width:30' class='text'>
No. of Successful Contact 
<input type='submit' name="email_update" value="Update" onClick="return checkFields2('email');" >
&nbsp;</i></div>
<?=$error1;?></td>
</tr>
<tr >
<td width="192"  style="border-bottom: #666666 solid 1px;"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="agentHome.php?action=CALL&event_date=<? echo $event_date;?>&yesterday=<? echo $yesterday;?>&this_day=<? echo $this_day;?>&tomorrow=<? echo $tomorrow;?>&month=<? echo $month;?>" class="link20">Phone</a></b></td>
<td width="168" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?
$sql="SELECT COUNT(actions) FROM history h WHERE actions='CALL' AND agent_no =$agent_no $conditions GROUP BY actions;";
//echo $sql."<br>";
$res = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
list($call_no) = mysql_fetch_array($res);
if ($call_no >0 ){
	echo "<b>".$call_no."</b> &nbsp;&nbsp;&nbsp;&nbsp;Phone Call/s made";

}
else
{
	echo "&nbsp;";
}
?> </td>
<td width="189" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;" align="center"><?
$queryRecord2="SELECT quantity FROM manual_history WHERE actions='CALL' AND agent_no =$agent_no $conditions ;";
$query_result2=mysql_query($queryRecord2);
$call_count = 0;
list($call_count)=mysql_fetch_array($query_result2);
if($call_count > 0) {
	echo "<a href='#' onClick=showRecords('CALL')>".$call_count . "</a>";
	//echo  $call_count;
}
else
{
	echo "&nbsp;";
}
?><input type="hidden" name="call_no" id="call_no" value="<?=$call_count;?>"></td>
<td valign="top" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;">
<?
$sqlRecord2="SELECT quantity2 FROM manual_history WHERE actions='CALL' AND agent_no =$agent_no $conditions ;";
$sql_result2=mysql_query($sqlRecord2);
$call_count2 = 0;
list($call_count2)=mysql_fetch_array($sql_result2);
if($call_count2 > 0) {
	echo $call_count2;
}
else
{
	echo "&nbsp;";
}
?></td>
<td style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><i>
<a href='javascript: show_hide("reply_form2");'><img src="../images/add.gif" alt="Add Successful Number of Contacts" border="0"></a>
<div id='reply_form2' style='display:none;'>
<i>
<input type='text' name="quantity3" id='quantity3' style='width:30' class='text'>
No. of Successful Contact 
<input type='submit' name="call_update" value="Update" onClick="return checkFields2('call');" >
&nbsp;</i></div>
</i></td>
</tr>
<tr>
<td width="192"  style="border-bottom: #666666 solid 1px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="agentHome.php?action=MAIL&event_date=<? echo $event_date;?>&yesterday=<? echo $yesterday;?>&this_day=<? echo $this_day;?>&tomorrow=<? echo $tomorrow;?>&month=<? echo $month;?>" class="link20">Notes</a></b></td>
<td width="168" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?
$sql="SELECT COUNT(actions) FROM history h WHERE actions='MAIL' AND agent_no =$agent_no $conditions GROUP BY actions;";
//echo $sql."<br>";
$res = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
list($mail_no) = mysql_fetch_array($res);
if ($mail_no >0 ){

	echo "<b>".$mail_no."</b> &nbsp;&nbsp;&nbsp;&nbsp;Notes made";

}
else
{
	echo "&nbsp;";
}
?>   </td>
   <td width="189" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;" align="center"><?
$queryRecord3="SELECT quantity FROM manual_history WHERE actions='MAIL' AND agent_no =$agent_no $conditions ;";
$query_result3=mysql_query($queryRecord3);
$mail_count = 0;
list($mail_count)=mysql_fetch_array($query_result3);
if($mail_count > 0) {
	echo "<a href='#' onClick=showRecords('MAIL')>".$mail_count . "</a>";
	//echo $mail_count;
}
else
{
	echo "&nbsp;";
}
?><input type="hidden" name="mail_no" id="mail_no" value="<?=$mail_count;?>"></td>
<td valign="top" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?
$sqlRecord3="SELECT quantity2 FROM manual_history WHERE actions='MAIL' AND agent_no =$agent_no $conditions ;";
$sql_result3=mysql_query($sqlRecord3);
$mail_count3 = 0;
list($mail_count3)=mysql_fetch_array($sql_result3);
if($mail_count3 > 0) {
	echo $mail_count3;
}
else
{
	echo "&nbsp;";
}
?></td>
<td style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;">
<a href='javascript: show_hide("reply_form3");'><img src="../images/add.gif" alt="Add Successful Number of Contacts" border="0"></a>
<div id='reply_form3' style='display:none;'>
<i>
<input type='text' name="quantity4" id='quantity4' style='width:30' class='text'>
No. of Successful Contact 
<input type='submit' name="notes_update" value="Update" onClick="return checkFields2('notes');" >
&nbsp;</i></div></td>
</tr>
<tr>
<td width="192"  style="border-bottom: #666666 solid 1px;"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="agentHome.php?action=MEETING FACE TO FACE&event_date=<? echo $event_date;?>&yesterday=<? echo $yesterday;?>&this_day=<? echo $this_day;?>&tomorrow=<? echo $tomorrow;?>&month=<? echo $month;?>" class="link20">Meeting Face to Face</a></b></td>
<td width="168" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?
$sql="SELECT COUNT(actions) FROM history h WHERE actions='MEETING FACE TO FACE' AND agent_no =$agent_no $conditions GROUP BY actions;";
//echo $sql."<br>";
$res = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
list($meeting_no) = mysql_fetch_array($res);
if ($meeting_no >0 ){

	echo "<b>".$meeting_no."</b> &nbsp;&nbsp;&nbsp;&nbsp;Face to Face meeting made";

}
else
{
	echo "&nbsp;";
}
?>  </td>
<td width="189" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;" align="center"><?
$queryRecord4="SELECT quantity FROM manual_history WHERE actions='MEETING FACE TO FACE' AND agent_no =$agent_no $conditions ;";
$query_result4=mysql_query($queryRecord4);
$meeting_count = 0;
list($meeting_count)=mysql_fetch_array($query_result4);
if($meeting_count > 0) {
	echo "<a href='#' onClick=showRecords('MEETING%20FACE%20TO%20FACE')>".$meeting_count . "</a>";
}
else
{
	echo "&nbsp;";
}
?><input type="hidden" name="meeting_no" id="meeting_no" value="<?=$meeting_count;?>"></td>
<td valign="top" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?
$sqlRecord4="SELECT quantity2 FROM manual_history WHERE actions='MEETING FACE TO FACE' AND agent_no =$agent_no $conditions ;";
//echo $queryRecord4;
$sql_result4=mysql_query($sqlRecord4);
$meeting_count = 0;
list($meeting_count4)=mysql_fetch_array($sql_result4);
if($meeting_count4 > 0) {
	echo $meeting_count4;
}
else
{
	echo "&nbsp;";
}
?></td>
<td style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><a href='javascript: show_hide("reply_form4");'><img src="../images/add.gif" alt="Add Successful Number of Contacts" border="0"></a>
<div id='reply_form4' style='display:none;'>
<i>
<input type='text' name="quantity5" id='quantity5' style='width:30' class='text'>
No. of Successful Contact 
<input type='submit' name="meeting_update" value="Update" onClick="return checkFields2('meeting');" >
&nbsp;</i></div></td> 
</tr>
<tr>
<td valign="top" style="border-bottom: #666666 solid 1px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="agentHome.php?action=LEADS&event_date=<? echo $event_date;?>&yesterday=<? echo $yesterday;?>&this_day=<? echo $this_day;?>&tomorrow=<? echo $tomorrow;?>&month=<? echo $month;?>" class="link20">Registered Leads</a></b></td>
<td width="168" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;"><?
$querycheck="SELECT * FROM leads WHERE agent_id =0 AND SUBSTRING(tracking_no,1,$length)='$agent_code'";
//echo $querycheck;
$result2=mysql_query($querycheck);
$ctr3=@mysql_num_rows($result2);
if ($ctr3 >0 )
{
	//echo "Numrows ".$ctr3;
	$updateLeads="UPDATE leads SET agent_id = $agent_no WHERE agent_id =0 AND SUBSTRING(tracking_no,1,$length)='$agent_code'";
	mysql_query($updateLeads);
}
$s="SELECT COUNT(id) FROM leads l WHERE agent_id = $agent_no $conditions2;";
//echo $s;
$r=mysql_query($s);
//$c=@mysql_num_rows($r);
list($num) = mysql_fetch_array($r);
if($num >0)
{
	echo "<b>".$num."</b> &nbsp;&nbsp;&nbsp;&nbsp;Registered Lead";
}
else
{
	echo "&nbsp;";
}

?></td>
<td valign="top" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;">&nbsp;</td>
<td width="70" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;">&nbsp;</td>
<td valign="top" style="border-bottom: #666666 solid 1px; border-left: #666666 solid 1px;">&nbsp;</td>
</tr>
</table>
<br>
<div id="show_record"></div>
<br>
<?
// iinsert in to manual_history 
// id, agent_no, actions, history, date_created, quantity
?>
<div id="add_record"><a href='#' class='link17' onClick="show_addControl('1');">Add Manually Action Record</a></div>
</td>
</tr>
</table>

</td></tr>
</table>
<!-- LIST HERE -->
<?
if($action!="")
{
	if($month=="")
	{
		$searchDate=$event_date;
		$sqlDay="SELECT DATE_FORMAT('$searchDate','%W %D %M %Y'),DATE_FORMAT('$searchDate','%Y'),DATE_FORMAT('$searchDate','%c'),DATE_FORMAT('$searchDate','%e')";
		//echo $sqlDay;
		$result=mysql_query($sqlDay);
		list($dayname,$cyear,$cmonth,$cday)=mysql_fetch_array($result);
		
		$conditions ="AND YEAR(date_created) = '$cyear' AND  MONTH(date_created) = '$cmonth' AND DAY(date_created) ='$cday'";
		$conditions2 ="AND YEAR(timestamp) = '$cyear' AND  MONTH(timestamp) = '$cmonth' AND DAY(timestamp) ='$cday'";

		
	}
	if($month!="")
	{
		$dayname="Month of ".$bmonth;
		$conditions ="AND  MONTH(date_created) = '$month' ";
		$conditions2 ="AND MONTH(timestamp) = '$month'";
		
	}
	
?>
<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td align=left colspan="8" style="border-top: #006699 2px solid;"><b><font size='2' color='#FFFFFF'><? echo $dayname;?></font></b></td>
</tr>
<tr>
<td valign="top" align="center" >

<?
if ($action!="LEADS")
{

$query="SELECT  h.id,h.actions,h.history,DATE_FORMAT(h.date_created,'%D %M %Y %r'),h.leads_id

FROM history h

#JOIN leads l ON l.id = h.leads_id

WHERE actions='$action'

AND agent_no =$agent_no

$conditions

ORDER BY date_created ASC";

//echo $query."<br>";
$resulta=mysql_query($query);
$counter=0;
?>
<table width='97%' class='tablecontent' style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="0">
<tr   bgcolor="#CCCCCC" >
<td width='4%' align=left style="border-bottom:#999999 solid 1px;"><b><font size='1'>#</font><b></td>
<td width='13%' align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><b><font size='1'>Name</a></font></b></td>
<td width='18%' align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><b><font size='1'>Time</font></b></td>
<td width='13%' align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><b><font size='1'>Action</font></b></td>
<td width='52%' colspan="4" align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><b><font size='1'>Details</font></b></td>
</tr>

<?
	while(list($id, $actions, $history , $time , $leads_id  ) = mysql_fetch_array($resulta))	
	{	$counter=$counter+1;
	
	if($actions =="MAIL")
	{
		$actions="NOTES";
	}
?>
<tr bgcolor=<? echo $bgcolor;?> >
<td width='4%' align=left style="border-bottom:#999999 solid 1px;"><font size='1'><? echo $counter.")";?></font></td>
<td width='13%' align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><font size='1'><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $leads_id;?>',600,600);>
<?
$sqlNameCheck="SELECT lname,fname FROM leads WHERE id = $leads_id;";
$result_sql =mysql_query($sqlNameCheck);
list($lname,$fname)=mysql_fetch_array($result_sql);
if($fname!="" || $lname != ""){ echo $fname." ".$lname;}
else {echo "&nbsp;";}
?></a></font></td>
<td width='18%' align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><font size='1'><? echo $time;?></font></td>
<td width='13%' align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><font size='1'><? echo $actions;?></font></td>
<td width='52%' colspan="4" align=left style="border-bottom:#999999 solid 1px; border-left: #999999 solid 1px;"><font size='1'><? echo $history;?></font></td>
</tr>
<?
 			if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}
}
?>
</table>
</td>
</tr>
</table>
<? }?>
<?
if ($action =="LEADS")
{
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating,DATE_FORMAT(inactive_since,'%D %M %Y'),personal_id,DATE_FORMAT(date_move,'%D %M %Y'),agent_from,status
FROM leads l
WHERE agent_id = $agent_no $conditions2 ORDER BY timestamp ASC;";


$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);

?>
<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr><td colspan="10"><B>REGISTERED LEADS</B></td></tr>
 <tr   bgcolor="#CCCCCC" >
    <td width='4%' align=left><b><font size='1' >#</font></b></td>
    <td width='8%' align=left><b><font size='1' >Status</font></b></td>
    <td width='13%' align=left><b><font size='1' >Name</font></b></td>
    <td width='9%' align=left><b><font size='1' >Company Position</font></b></td>
    <td width='9%' align=left><b><font size='1' >Date Registered</font></b></td>
    <td width='10%' align=center><b><font size='1' >Promotional Code</font></b></td>
    <td width='9%' align=left><b><font size='1' >Company</font></b></td>
    <td width='9%' align=left><b><font size='1' >Email</font></b></td>
  <!--  <td width='10%' align=left><b><font size='1' >Company Turnover</font></b></td> -->
    <td width='8%' align=left><b><font size='1' >Rating</font></b></td>
    <td width='21%' align=left><b><font size='1' >Remarks</font></b></td>
  </tr>
  <?
	$bgcolor="#FFFFFF";
	//id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
	while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$lname,$fname,$company_position,$company_name,$email,$company_turnover,$rate,$inactive_since,$personal_id,$date_move,$agent_from,$status) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
  <tr bgcolor=<? echo $bgcolor;?>>
    <td width='4%' align=left><font size='1'><? echo $counter.")";?></font> </td>
	 <td width='8%' align=left><font size='1' ><? echo $status;?></font></td>
    <td width='13%' align=left><font size='1'><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);> <? echo $fname." ".$lname;?> </a> </font></td>
    <td width='9%' align=left><font size='1'><? echo $company_position;?></font></td>
    <td width='9%' align=left><font size='1'><? echo $timestamp;?></font></td>
    <td width='10%' align=center><font size='1'><a href='#'onClick=javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);><? echo $tracking_no;?></a></font></td>
<!--    <td width='12%' align=center><font size='1'><? echo $remote_staff_needed;?></font></td> -->
    <td width='9%' align=left><font size='1'><? echo $company_name;?></font></td>
    <td width='9%' align=left><font size='1'><? echo $email;?></font></td>
 <!--   <td width='10%' align=left><font size='1'><? //echo $company_turnover;?></font></td> -->
    <?
			  if($rate=="1")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
			  
			  
			  ?>
    <td width='8%' align=left><font size='1'><? echo $rate;?></font></td>
	  <td width='21%' align=left><font size='1'><? 
			   if($date_move!="")
			   {
			   		$sql="SELECT * FROM agent WHERE agent_no = $agent_from";
					$resulta=mysql_query($sql);
					$ctr=@mysql_num_rows($resulta);
					if ($ctr >0 )
					{
						$row = mysql_fetch_array ($resulta); 
						$name = $row['fname']." ".$row['lname'];
					}
			   		echo "This Lead came from AGENT : " .$name." ".$date_move."<br>";
			   }
			   
			   if($inactive_since!="")
			{	$personalid=substr($personal_id,0,1);
				if($personalid=="C")
				{
					//$remarks ="Move back to Contacted List from Client since ".$inactive_since;
					echo "Move back to Contacted List from Client since ".$inactive_since."<br>";
				}	
			}
			   //echo $remarks;
			   
			   ?></font></td>
  </tr>
  <?
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}	
	?>
</table>
<?	
}

?>
<!-- LIST HERE -->
<? include 'footer.php';?>
</form>	
</body>
</html>
