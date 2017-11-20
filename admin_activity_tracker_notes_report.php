<?
include 'conf.php';
include 'config.php';
include 'lib/admin_activity_tracker_notes_perstaff.php';


//post
$rt = @$_REQUEST["rt"];
$mystaff = @$_REQUEST["mystaff"];
$mystaff_selected = @$_REQUEST["mystaff_selected"];
$p = @$_REQUEST["p"];

if (!isset($p)) $p = 1 ;

$client_id = $_SESSION['admin_id'];
//ended


//send activity notes per staff
if(@isset($_REQUEST["send"]))
{
	$result = activity_tracker_notes_perstaff($mystaff_selected,$client_id,'manual');
}
//ended


//current status seetings
$query="SELECT status, hour, minute, client_timezone FROM tb_client_account_settings WHERE client_id='$client_id' LIMIT 1;";
$result=mysqli_query($link2, $query);
while(list($status,$h,$m,$client_timezone) = mysqli_fetch_array($result))
{
	$activity_notes_status = $status;
	$hour = $h;	
	$minute = $m;	
	$tz = $client_timezone;
}
//ended


//client subcontructor's options
$query="SELECT DISTINCT(subcontractors.userid), personal.fname, personal.lname FROM subcontractors, personal WHERE subcontractors.status='ACTIVE' AND personal.userid=subcontractors.userid ORDER BY personal.fname;";
$result=mysqli_query($link2, $query);

if($mystaff == "")
{
	$mystaff_options = "<option value='' selected>Select Staff</option>";
}
while(list($userid,$fname,$lname) = mysqli_fetch_array($result))
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
	$query = "SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') ORDER BY expected_time DESC LIMIT $set, $maxp";
	$result=mysqli_query($link2, $query);
	$x =0 ;

	while ($row = mysqli_fetch_assoc($result)) 
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
	$query = "SELECT expected_time, checked_in_time, note FROM activity_tracker_notes WHERE userid='$mystaff' AND (DATE_FORMAT(expected_time,'%Y-%m-%d') BETWEEN '$a_' AND '$b_') ORDER BY expected_time";
	$result=mysqli_query($link2, $query);
	return mysqli_num_rows($result) ;
}
//ended


//generate report
switch ($rt) 
{
	case "today" :
		$a_1 = time();
		$b_1 = time() + (1 * 24 * 60 * 60);
		$a_ = date("Y-m-d"); 
		$b_ = $a_; //date("Y-m-d",$b_1);
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
		$title = "All time (".date("M d, Y").")";			
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

function update_activity(client_id,status)
{
	if(status == 'all')
	{
		hour = document.getElementById('hour_id'+client_id).value;
		minute = document.getElementById('minute_id'+client_id).value;
		tz = document.getElementById('tz_id'+client_id).value;
		request.open('get', 'activity_notes_setting_update.php?tz='+tz+'&hour='+hour+'&minute='+minute+'&status='+status+'&client_id='+client_id)
	}
	else
	{
		request.open('get', 'activity_notes_setting_update.php?status='+status+'&client_id='+client_id)
	}

	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	request.send(1)
	alert("New setting has been applied.");
}


function checkFields()
{
	
	missinginfo = "";
	
	if (document.form.fname.value == "")
	{
		missinginfo += "\n     -  Please enter your First name";
	}
	if (document.form.lname.value == "")
	{
		missinginfo += "\n     -  Please enter your Last name";
	}
	
	if (document.form.email.value == "")
	{
		missinginfo += "\n     -  Please site a email address"; //
	}
	
		
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;
	
}


function showhide(str)
{
	if(str=="Yes")
	{
		newitem1="<p><label>Type it here</label>";
		newitem1+="<br>";
	 	newitem1+="<textarea name=\"usedoutsourcingstaff\" +";
		newitem1+="\" cols=\"25\" rows=\"5\" class=\"select\"><? echo $outsourcing_experience_descriptio;?></textarea></p><p></p>";
		document.getElementById("txtHint").innerHTML=newitem1;
	}
	if(str=="No")
	{
		document.getElementById("txtHint").innerHTML="&nbsp;";
	}
}
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<td width="76%" >
<table width="99%"  cellspacing="0" cellpadding="3" style="border:#CCCCCC solid 1px; margin-left:0px; margin-top:5px; margin-bottom:5px;">
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
									<font size="1">Subcontractors</font>
								</td>						
								<td align="left">
								  <select name="mystaff_selected" id="mystaff_id" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
									<?php echo $mystaff_options; ?>
								  </select>
								</td>
								<td width="0%" align="left">
								  <input type="submit" value="Send" name="send" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
									<font size="1">(to be send to your admin email)</font>
								</td>				
						</tr>
					</table>
			</td>
          </tr>		
          <tr>
            <td><font size="1">Date</font></td>
            <td><font size="1">Subcontractors</font></td>
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
		  <?php if(count($notes) > 0) { ?>
          <tr>
            <td colspan="3" bgcolor="#E9E8E9">
              <table width="100%">
                <tr>
                  <td align="right"><?php echo $navpage ; ?></td>
                </tr>
            </table></td>
          </tr>		  		  
          <tr>
            <td colspan="3">
			
				<table cellpadding="3" cellspacing="3">
				  <tr>
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
								
								//convert to manila time
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
</table>

</td>
</tr>
</table></td>
</tr>
</table>
</body>
</html>
