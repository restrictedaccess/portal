<?php
include 'config.php';
include 'conf.php';
include 'time.php';


if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$userid = $_SESSION['userid'];
$client_id = $_REQUEST['clients'];

if($client_id!="")
{
	$search ="AND w.client_id = $client_id";
}
else{
	$search ="";
}


$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['lname']."  ,".$row['fname'];
}


$sqlClient="SELECT l.id, l.fname, l.lname, l.company_name
FROM subcontractors as s
left join leads as l on s.leads_id = l.id
where userid=$userid  and s.status = 'ACTIVE' order by s.date_contracted";

$resulta=mysql_query($sqlClient);
while(list($lead_id,$lead_fname,$lead_lname,$lead_company)=mysql_fetch_array($resulta))
{
	if($clients == $lead_id)
      {
	 $clientoptions .= "<option selected value=\"$lead_id\">$lead_fname&nbsp;$lead_lname&nbsp;($lead_company)</option>\n";
      }
      else
      {
	 $clientoptions .= "<option value=\"$lead_id\">$lead_fname&nbsp;$lead_lname&nbsp;($lead_company)</option>\n";
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

for($i=1;$i<6;$i++)
{
	  if($priority2 == $i)
      {
	 $priorityoptions .= "<option selected value=\"$i\">$i</option>\n";
      }
      else
      {
	 $priorityoptions .= "<option value=\"$i\">$i</option>\n";
      }
}


if(isset($_POST['save_task']))
{
}

?>

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language=javascript src="js/timer.js"></script>

<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<style>
<!--
.rad
{
	height:20px;
	width:50px;
}
div.scroll {
		height: 200px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	
#add_task_form {
	display:none; 
	background:#FFFFFF;
	border:#CCCCCC solid 5px; 
	position:absolute; 
	width:800px; 
	padding:5px;
	
	
	font: 12px Arial;
}
#add_task_form p {
	margin-bottom:5px;
	margin-top:5px;
}
#add_task_form label {
	display:block;
	float:left;
	width:70px;
	font-weight:bold;
}
-->
</style>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" height="502" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="170" height="502" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?></td>
<td width="1064" valign="top">
<table width="100%" style="border:#666666 solid 1px;" cellspacing="0" cellpadding="3">
<tr bgcolor="#666666"><td height="35" colspan="8" valign="middle"><font color="#FFFFFF"><b>Work Task</b></font></td>
</tr>
<tr><td height="35" colspan="8" valign="middle">
<form name='form' method='POST' action="addtask.php">
Select Clients 
<select name="clients"  style="font-size: 12px;" class="text" >
<?=$clientoptions;?>
</select> <input type="image" align="absmiddle"  src="images/001_25.gif" title="go">
<div>
<input type="button" value="Add a Task" onClick="show_hide('add_task_form');">
</div>
<div id="add_task_form">
<div style="background:#E9E9E9; border:#E9E9E9 outset 1px; padding:5px;"><b>Add Task</b></div>
<p><label>Subject :</label><input type="text" name="jobdetails" id="jobdetails" style=" width:700px" class="select" value="<? echo $work_details2;?>"> </p>

<p><label>Details :</label><textarea name="notes" cols="48" rows="7"  class="select"  style="width:700px"><? echo $notes2;?></textarea></p>
<p><label>Start Date : </label><input type="text" id="start_date" name="start_date"  style="width:90px; font-size:9px;" value="<? echo $date_start2;?>">
                <img align="top" src="images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "start_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd2",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script> </p>
				  
<p><label>Finish Date : </label><input type="text" id="finish_date" name="finish_date"  style="width:90px; font-size:9px;" value="<? echo $date_finished2;?>">
                            
							  <img align="top" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "finish_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></p>
				  
<p><label>Priority : </label><select name="priority" style="width:90px; font-size:9px;">
			<option value="0">-</option>
              <? echo $priorityoptions;?>
              </select>
</p>
<p><input type="checkbox" name="notify" value="yes"> Email a copy of this Task to the client</p>
<p><input type="submit" value="Save" name="save_task" id="save_task"> <input type="button" value="Cancel" onClick="show_hide('add_task_form');"></p>
</div>

</form>
</td>
</tr>


<tr bgcolor="#CCCCCC"><td width="3%" valign="top" style="border-bottom:#666666 solid 1px;" align="left"><font color="#999999">#</font></td>
<td width="48%"  valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; "><b>Work Details</b></td>
<td width="12%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Client</b></td>
<td  align="center" width="5%" valign="top" style="border-bottom:#666666 solid 1px; border-left:#666666 solid 1px;"><font color="#FF0000"><b>Priority</b></font></td>
<td  align="center" width="6%" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#0033FF"><b>Progress</b></font></td>
<td width="8%" valign="top" style="border-bottom:#666666 solid 1px;"><font color='#999999'>Date Created</font></td>
<td width="9%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Start Date</b></td>
<td width="9%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Due Date</b></td>
</tr>
<?
//id, client_id, userid, date_start, date_finished, date_created, work_details, notes, percentage, status, subcon_reply, priority, client_reply
$sqlList ="SELECT w.id, DATE_FORMAT(w.date_start,'%D %b %Y'),DATE_FORMAT(w.date_finished,'%D %b %Y') ,DATE_FORMAT(w.date_created,'%D %b %Y') , work_details, notes, percentage ,priority,l.fname,l.lname,client_id
		FROM workflow w 
		JOIN leads l ON l.id = w.client_id
		WHERE  userid = $userid AND w.status !='ARCHIVE' $search ORDER BY date_created DESC";// $search ="AND w.client_id = $client_id";
//echo $sqlList;
$result=mysql_query($sqlList);
$counter=0;
$percentArray=array("0%","25%","50%","75%","100%");
for($i=0;$i<count($percentArray);$i++)
{
	  if($percentage == $percentArray[$i])
      {
	 $percentoptions .= "<option selected value=\"$percentArray[$i]\">$percentArray[$i]</option>\n";
	  }
      else
      {
	 $percentoptions .= "<option value=\"$percentArray[$i]\">$percentArray[$i]</option>\n";
	 
      }
}	
while(list($id, $date_start, $date_finished, $date_created, $work_details, $notes, $percentage,$priority,$client_fname,$client_lname,$lead_id) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		$notes=str_replace("\n","<br>",$notes);
		$rate =$priority;
		if($rate=="1")
		{
			$rate="*";
		}
		if($rate=="2")
		{
			$rate="**";
		}
		if($rate=="3")
		{
			$rate="***";
		}
		if($rate=="4")
		{
			$rate="****";
		}
		if($rate=="5")
		{
			$rate="*****";
		}
$percentArray=array("0%","25%","50%","75%","100%");
if($percentage == $percentArray[0])
{
$percentoptions = "<option selected value=\"$percentArray[0]\">$percentArray[0]</option>\n";
$percentoptions .= "<option value=\"$percentArray[1]\">$percentArray[1]</option>\n";
$percentoptions .= "<option value=\"$percentArray[2]\">$percentArray[2]</option>\n";
$percentoptions .= "<option value=\"$percentArray[3]\">$percentArray[3]</option>\n";
$percentoptions .= "<option value=\"$percentArray[4]\">$percentArray[4]</option>\n";
}
if($percentage == $percentArray[1])
{
$percentoptions = "<option  value=\"$percentArray[0]\">$percentArray[0]</option>\n";
$percentoptions .= "<option selected value=\"$percentArray[1]\">$percentArray[1]</option>\n";
$percentoptions .= "<option value=\"$percentArray[2]\">$percentArray[2]</option>\n";
$percentoptions .= "<option value=\"$percentArray[3]\">$percentArray[3]</option>\n";
$percentoptions .= "<option value=\"$percentArray[4]\">$percentArray[4]</option>\n";
}

if($percentage == $percentArray[2])
{
$percentoptions = "<option  value=\"$percentArray[0]\">$percentArray[0]</option>\n";
$percentoptions .= "<option  value=\"$percentArray[1]\">$percentArray[1]</option>\n";
$percentoptions .= "<option selected value=\"$percentArray[2]\">$percentArray[2]</option>\n";
$percentoptions .= "<option value=\"$percentArray[3]\">$percentArray[3]</option>\n";
$percentoptions .= "<option value=\"$percentArray[4]\">$percentArray[4]</option>\n";
}

if($percentage == $percentArray[3])
{
$percentoptions = "<option  value=\"$percentArray[0]\">$percentArray[0]</option>\n";
$percentoptions .= "<option  value=\"$percentArray[1]\">$percentArray[1]</option>\n";
$percentoptions .= "<option  value=\"$percentArray[2]\">$percentArray[2]</option>\n";
$percentoptions .= "<option selected value=\"$percentArray[3]\">$percentArray[3]</option>\n";
$percentoptions .= "<option value=\"$percentArray[4]\">$percentArray[4]</option>\n";
}

if($percentage == $percentArray[4])
{
$percentoptions = "<option  value=\"$percentArray[0]\">$percentArray[0]</option>\n";
$percentoptions .= "<option  value=\"$percentArray[1]\">$percentArray[1]</option>\n";
$percentoptions .= "<option  value=\"$percentArray[2]\">$percentArray[2]</option>\n";
$percentoptions .= "<option  value=\"$percentArray[3]\">$percentArray[3]</option>\n";
$percentoptions .= "<option selected value=\"$percentArray[4]\">$percentArray[4]</option>\n";
}

	  

	
$reply="<form method='post' name='form' action='worktaskphp.php' >
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='client_id' value='$lead_id'>
		<textarea name='subcon_reply' cols='48' rows='7' class='text'  style='width:98%'></textarea><br>
		Work Progress 
		<select name='percentage' style='width:90px; font-size:9px;'>
        ".$percentoptions."
         </select>
        <input type='submit' name='reply' value='Reply' class='button'></form>";
		
		if($percentage=="100%")
		{
			//$bgcolor="#C4DFAA";
			$finish="<p align=center><img src='images/action_check.gif' alt='Finished'></p>";
		}
		else
		{
			$finish="&nbsp;";
		}
	

	
		
?>		
		<tr><td width='3%' valign='top' style="border-bottom:#666666 solid 1px;" ><?=$counter;?>) </td>
		<td  valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; '><?="<b><font color='#999999'>SUBJECT</font></b> :" .$work_details."<br><br><b><font color='#999999'>NOTES</font></b> ".$notes;?><br> <a class="link10" href='javascript: show_hide("reply_form<? echo $counter;?>");'>Response <img src="images/view2.gif" border="0" alt="Response from Sub-Contractor" align="top"></a> <br>
		<div id='reply_form<? echo $counter;?>' style='display:none; '>
			<? 
		// parse all messages in the chat
		//id, workflow_id, client_id, subcon_id, message, chat_date, created_by
		$sqlChat = "SELECT created_by, message, DATE_FORMAT(chat_date,'%D %b %Y %r'),l.fname,p.fname
					FROM workflow_chat w
					JOIN leads l ON l.id = w.client_id
					JOIN personal p ON p.userid = w.subcon_id
					WHERE workflow_id = $id	ORDER BY chat_date ASC;";
		//echo $sqlChat;
		$resulta=mysql_query($sqlChat);
		$ctr=@mysql_num_rows($resulta);
		if ($ctr >0 )
		{
		echo "<div class='scroll'><table width='100%'>";
		while(list($created_by, $message, $chat_date,$clientfname,$subconfname)=mysql_fetch_array($resulta))
		{
			if ($created_by =="SUBCON")
			{
				$bgcolor="#c0e0f5";
				$name =$subconfname;
			}
			else
			{
				$bgcolor="#abccdd";
				$name =$clientfname;
			}
			$message=str_replace("\n","<br>",$message);
			echo  "<tr bgcolor=$bgcolor><td width=60%><b>$name says :</b></td><td width =40%>$chat_date</td></tr>
							<tr bgcolor=#eeeeee><td colspan='2'>$message</td></tr>";
		}
		
		echo "</table></div>";
		}
		echo "<br>".$reply;
		?>
		</div>
		</td>
		<td width="12%" valign="top" style="border-bottom:#666666 solid 1px;border-left:#666666 solid 1px;"><font color="#FF0000" size="2"><b><?=$client_fname." ".$client_lname?></b></font></td>
		<td  align="center" width="5%" valign="top" style="border-bottom:#666666 solid 1px;border-left:#666666 solid 1px;"><font color="#FF0000" size="2"><b><? if($rate!=""){echo $rate;}else {echo "&nbsp;";}?></b></font></td>
		<td width='6%' align="center" valign='top' style="border-bottom:#666666 solid 1px;"><font color="#0033FF"><b><? if($percentage!=""){echo $percentage;}else{echo "&nbsp;";}?><?=$finish;?></b></font></td>
		<td width='8%' valign='top' style="border-bottom:#666666 solid 1px;"><font color="#CCCCCC"><? if($date_created!=""){echo $date_created;}else{echo "&nbsp;";}?></font></td>
		<td width='9%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;'><? if($date_start!=""){echo $date_start;;}else{echo "&nbsp;";}?></td>
		<td width='9%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;'><? if($date_finished!=""){echo $date_finished;}else{echo "&nbsp;";} ?></td>
		</tr>

		
<?	
	}


?>
</table>



</td>
</tr>
</table>
<? include 'footer.php';?>
</body>
</html>
