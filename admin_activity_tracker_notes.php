<?

include 'config.php';

include 'conf.php';

include 'time.php';

include 'function.php';

include 'time.php';

include 'time_recording/TimeRecording.php';

//putenv("TZ=Philippines/Manila");



//echo $AusDate;

if($_SESSION['admin_id']=="")

{

	header("location:index.php");

}





$lunch_count=0;

$not_working_count=0;

$working_count=0;

    /**

     *

     * extends TimeRecording class

     *

     */

    class SubconStatus extends TimeRecording {

        /**

        *

        *   returns a string indicating status of the subcontractor

        */

        function GetStatus() {

            if ($this->buttons['lunch_end']) {

                return "Out to lunch.";

				

            }

            if ($this->buttons['work_start']) {

                return "Not working.";

				//return "Finish Work.";

				

            }

            else {

                return "Working.&nbsp;<img src='images/onlinenowFINAL.gif' alt='working' align='absmiddle'>";

				

            }

        }

		function GetWorkSchedule($userid){

		$AusDate = date("Y")."-".date("m")."-".date("d");

		$sql="SELECT l.id,l.fname, l.lname , s.starting_hours, s.ending_hours 

		FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.userid = $userid AND s.status = 'ACTIVE' ORDER BY s.starting_hours DESC;";

		//echo $sql;

			$result = mysqli_query($link2, $sql);

			while(list($lead_id,$l_fname,$l_lname,$starting_hours, $ending_hours)=mysqli_fetch_array($result))

			{

				//Check to whose Client did the Subcon currently working on....

					$sqlCheck="SELECT * FROM timerecord t 

					WHERE leads_id = $lead_id AND userid = $userid AND DATE(time_in) BETWEEN '$AusDate' AND '$AusDate' AND mode = 'regular' ;";

					//echo $sqlCheck;

					$res=mysqli_query($link2, $sqlCheck);

					$row=mysqli_fetch_array($res);

					$time_in = $row['time_in'];

					$time_out = $row['time_out'];

					$mode = $row['mode'];

					$check = @mysqli_num_rows($res);

					//echo $check;

					if($time_in!="" and $time_out=="" and $mode == "regular" and $check >0 )

					{

						$online ="<img src='images/navi_bullet.gif' alt='working' align='absmiddle'>";

						

					}else{ $online ="";}

					

				

					

					

				//

	if ($starting_hours=="6")

	{

		$starting_hours = "6:00 am";

	}		

	if ($starting_hours=="7")

	{

		$starting_hours = "7:00 am";

	}		

	if ($starting_hours=="8")

	{

		$starting_hours = "8:00 am";

	}		

	if ($starting_hours=="9")

	{

		$starting_hours = "9:00 am";

	}		

	if ($starting_hours=="10")

	{

		$starting_hours = "10:00 am";

	}

	if ($starting_hours=="11")

	{

		$starting_hours = "11:00 am";

	}

	if ($starting_hours=="12")

	{

		$starting_hours = "12:00 noon";

	}

	if ($starting_hours=="13")

	{

		$starting_hours = "1:00 pm";

	}

	if ($starting_hours=="14")

	{

		$starting_hours = "2:00 pm";

	}

	if ($starting_hours=="15")

	{

		$starting_hours = "3:00 pm";

	}

	if ($starting_hours=="16")

	{

		$starting_hours = "4:00 pm";

	}

	if ($starting_hours=="17")

	{

		$starting_hours = "5:00 pm";

	}

	if ($starting_hours=="18")

	{

		$starting_hours = "6:00 pm";

	}

	if ($starting_hours=="19")

	{

		$starting_hours = "7:00 pm";

	}

	if ($starting_hours=="20")

	{

		$starting_hours = "8:00 pm";

	}

	if ($starting_hours=="21")

	{

		$starting_hours = "9:00 pm";

	}

	if ($starting_hours=="22")

	{

		$starting_hours = "10:00 pm";

	}

	if ($starting_hours=="23")

	{

		$starting_hours = "11:00 pm";

	}

	if ($starting_hours=="24")

	{

		$starting_hours = "12:00 am";

	}

	

	//////////////////////////////////

	if ($ending_hours=="6")

	{

		$ending_hours = "6:00 am";

	}

	if ($ending_hours=="7")

	{

		$ending_hours = "7:00 am";

	}

	if ($ending_hours=="8")

	{

		$ending_hours = "8:00 am";

	}

	if ($ending_hours=="9")

	{

		$ending_hours = "9:00 am";

	}

	if ($ending_hours=="10")

	{

		$ending_hours = "10:00 am";

	}

	if ($ending_hours=="11")

	{

		$ending_hours = "11:00 am";

	}

	if ($ending_hours=="12")

	{

		$ending_hours = "12:00 noon";

	}

	if ($ending_hours=="13")

	{

		$ending_hours = "1:00 pm";

	}

	if ($ending_hours=="14")

	{

		$ending_hours = "2:00 pm";

	}

	if ($ending_hours=="15")

	{

		$ending_hours = "3:00 pm";

	}

	if ($ending_hours=="16")

	{

		$ending_hours = "4:00 pm";

	}

	if ($ending_hours=="17")

	{

		$ending_hours = "5:00 pm";

	}

	if ($ending_hours=="18")

	{

		$ending_hours = "6:00 pm";

	}

	if ($ending_hours=="19")

	{

		$ending_hours = "7:00 pm";

	}

	if ($ending_hours=="20")

	{

		$ending_hours = "8:00 pm";

	}

	if ($ending_hours=="21")

	{

		$ending_hours = "9:00 pm";

	}

	if ($ending_hours=="22")

	{

		$ending_hours = "10:00 pm";

	}

	if ($ending_hours=="23")

	{

		$ending_hours = "11:00 pm";

	}

	if ($ending_hours=="24")

	{

		$ending_hours = "12:00 am";

	}

				echo "<div style='margin:3px; padding:3px; font:10px tahoma; border: #CCCCCC solid 1px;'>

					  <label style='float:left; display:block;'>$online".$l_fname."</label>

					  <label style='float:right; display:block; margin-left:2px;'>".$starting_hours." - ".$ending_hours."</label>

					  <div style='clear:both'></div>

					  </div><div style='clear:both'></div> ";

					  

					  

			}

		}

		

    }



//$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));

//mysqli_query('SET time_zone='.$timeZone);



$AusTime = date("H:i:s"); 

$AusDate = date("Y")."-".date("m")."-".date("d");

$current_month=date("m");

$current_month_name=date("F");

$ATZ = $AusDate." ".$AusTime;

$date=date('jS \of F Y \[l\]');





$admin_id = $_SESSION['admin_id'];

$admin_status=$_SESSION['status'];

/*

admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status

*/

$query="SELECT * FROM admin WHERE admin_id=$admin_id;";



$result=mysqli_query($link2, $query);

$ctr=@mysqli_num_rows($result);

if ($ctr >0 )

{

	$row = mysqli_fetch_array ($result); 

	$name = $row['admin_fname']." ".$row['admin_lname'];

	

}



$summary=$_REQUEST['summary'];

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



	

?>

<html>

<head>

<title>Administrator-Home</title>

<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="adminmenu.css">

<link rel=stylesheet type=text/css href="css/affiliate.css">



<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>

<script type="text/javascript" src="timezones/cheatclock.php"></script>

<script type="text/javascript">

<!--

function show_hide(element) 

{

	toggle(element);

}

-->

</script>



<script type="text/javascript">



/***********************************************

* Local Time script- � Dynamic Drive (http://www.dynamicdrive.com)

* This notice MUST stay intact for legal use

* Visit http://www.dynamicdrive.com/ for this script and 100s more.

***********************************************/



var weekdaystxt=["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]



function showLocalTime(container, servermode, offsetMinutes, displayversion){

if (!document.getElementById || !document.getElementById(container)) return

this.container=document.getElementById(container)

this.displayversion=displayversion

var servertimestring=(servermode=="server-php")? '<? print date("F d, Y H:i:s", time())?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'

this.localtime=this.serverdate=new Date(servertimestring)

this.localtime.setTime(this.serverdate.getTime()+offsetMinutes*60*1000) //add user offset to server time

this.updateTime()

this.updateContainer()

}



showLocalTime.prototype.updateTime=function(){

var thisobj=this

this.localtime.setSeconds(this.localtime.getSeconds()+1)

setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second

}



showLocalTime.prototype.updateContainer=function(){

var thisobj=this

if (this.displayversion=="long")

this.container.innerHTML=this.localtime.toLocaleString()

else{

var hour=this.localtime.getHours()

var minutes=this.localtime.getMinutes()

var seconds=this.localtime.getSeconds()

var ampm=(hour>=12)? "PM" : "AM"

var dayofweek=weekdaystxt[this.localtime.getDay()]

//this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes)+":"+formatField(seconds)+" "+ampm+" ("+dayofweek+")"

this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes)+":"+formatField(seconds)+" "+ampm+" "

}

setTimeout(function(){thisobj.updateContainer()}, 1000) //update container every second

}



function formatField(num, isHour){

if (typeof isHour!="undefined"){ //if this is the hour field

var hour=(num>12)? num-12 : num

return (hour==0)? 12 : hour

}

return (num<=9)? "0"+num : num//if this is minute or sec field

}



</script>

<style type="text/css">

<!--

#box_tab

{

width:600px;

	

}

#box_tab ul{

padding: 3px 0;

margin-left: 0;

margin-top: 1px;

margin-bottom: 0;

font: bold 11px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;

list-style-type: none;

text-align: left; /*set to left, center, or right to align the menu as desired*/

}

#box_tab li{

display: inline;

margin: 0;

}

#box_tab a

{



	text-decoration: none;

	padding: 3px 7px;

	margin-right: 3px;

	border: 1px solid #778;

	width:130px;

	color: #2d2b2b;

	background: white url(images/shade.gif) top left repeat-x;



}

#box_tab a:hover

{

	color: black;

}

#box_tab a:active

{

	color:#FF0000;

	border-bottom-color: white;

	background-image: url(images/shadeactive.gif);

}

#box_tab a:focus

{

	color:#FF0000;

	border-bottom-color: white;

	background-image: url(images/shadeactive.gif);

}



.thumbnail

{

float: left;

width: 70px;

border: 1px solid #999;

margin: 0 15px 15px 0;

padding: 5px;

}



.clearboth { clear: both; }



.text_td{

	font: 11px 'Lucida Grande', 'Trebuchet MS', Verdana, Helvetica, sans-serif; color: #2d2b2b;

	padding:3px;

	 

}



.flag{

	height:auto; margin-left:10PX; margin-top:2px; width:450px;

font: bold 11px tahoma; color: #000; float:left;

padding:5px;

border:#333333 solid 1px;

margin-bottom:5px;

}

-->

</style>

	

	

</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="adminHome.php">
<input type="hidden" name="summary" value="<? echo $summary;?>">
<script type="text/javascript" src="js/jquery.js"></script>
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width="100%">

<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">



<? include 'adminleftnav.php';?>

</td>

<td valign="top"  style="width:100%; background: #ffffff;">











<!-- Contents Here -->

<div style="font:12px Arial; margin:3px;">

<div style="background:#0080C0; border:#0080C0 outset 1px; padding:3px;">

<b><font color="#FFFFFF">Activity Tracker Notes Client Account Settings</font></b></div>


<table width="100%">
	<tr>
		<td width="50%" valign="top">


										<table width="100%">							
											<tr >
												<td colspan=3 valign="top" >
														<iframe id="frame" name="frame" width="100%" height="400" src="admin_activity_tracker_notes_client_settings.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
												</td>	
											</tr>
										</table>			


		</td>		
	</tr>	
</table>


<!-- Contents Here -->
<!--
<div style="font:12px Arial; margin:3px;">

<div style="background:#0080C0; border:#0080C0 outset 1px; padding:3px;">

<b><font color="#FFFFFF">Report on Activity tracker notes</font></b></div>


<table width="100%">
	<tr>
		<td width="50%" valign="top">


										<table width="100%">							
											<tr >
												<td colspan=3 valign="top" >
														<iframe id="frame" name="frame" width="100%" height="400" src="admin_activity_tracker_notes_report.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
												</td>	
											</tr>
										</table>			


		</td>		
	</tr>	
</table>

-->

<!-- Contents Here -->
<!--
<div style="font:12px Arial; margin:3px;">

<div style="background:#0080C0; border:#0080C0 outset 1px; padding:3px;">

<b><font color="#FFFFFF">Communication Management within Activity tracker notes</font></b></div>


<table width="100%">
	<tr>
		<td width="50%" valign="top">


										<table width="100%">							
											<tr >
												<td colspan=3 valign="top" >
														<iframe id="frame" name="frame" width="100%" height="400" src="admin_activity_tracker_notes_manager.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
												</td>	
											</tr>
										</table>			


		</td>		
	</tr>	
</table>

-->



















<div style="height:5px; clear:both;">&nbsp;</div>

<!--

<div id="box_tab">

<ul>

<li><a href='javascript: show_hide("tab_1");'>Business Partners</a></li>

<li><a href='javascript: show_hide("tab_2");'>Leads</a></li>

<li><a href='javascript: show_hide("tab_3");'>Sub-Contractors</a></li>

<li><a href='javascript: show_hide("tab_4");'>Clients</a></li>

</ul>

</div>

--></td>
</tr>

</table>



<? include 'footer.php';?>

</form>	

</body>

</html>



