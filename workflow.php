<?
include 'config.php';
include 'conf.php';
include 'time.php';
$client_id = $_SESSION['client_id'];
$userid=$_GET['userid'];

$status=$_REQUEST['status'];
if($status=="" || $status=="NEW")
{
	$status ='NEW';
	$folder ='Active / Current Task';
}
else
{
	$folder ='Archive Task';
	$status2 =" OR status ='DONE' ";
}	
//echo $userid;
$query="SELECT lname, fname FROM personal WHERE userid=$userid";
$result=mysql_query($query);
list($lname, $fname) = mysql_fetch_array ($result); 


$work_task_id=$_REQUEST['id'];
$action=$_REQUEST['action']; //DELETE

if($work_task_id!="")
{
	if($action =="ARCHIVE")
	{
		$sqlUpdate="UPDATE workflow SET status='ARCHIVE' WHERE id=$work_task_id";
		mysql_query($sqlUpdate);
	}
	if($action =="UPDATE")
	{
		$sqlAction ="SELECT date_start, date_finished ,date_created, work_details, notes, priority
		FROM workflow WHERE id = $work_task_id;";
		$result=mysql_query($sqlAction);
		list($date_start2, $date_finished2 ,$date_created2, $work_details2, $notes2, $priority2) = mysql_fetch_array($result);
		$button="<input type='submit' name='update' value='Update'>";

	}
	if($action =="DELETE")
	{
		$sqlDelete ="DELETE FROM workflow WHERE id = $work_task_id;";
		$sqlDelete2 ="DELETE FROM workflow_chat WHERE workflow_id = $work_task_id;";
		mysql_query($sqlDelete);
		mysql_query($sqlDelete2);
	}	
}




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


if($button=="")
{
	$button="<input type='submit' name='add' value='Save'>";
}
?>
<html>
<head>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="chat.css">
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>
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
-->
</style>



</head>
<body>
<table width="99%" bgcolor="#FFFFFF">
<tr>
<td width="27%" valign="top">
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">
<form method="post" name="form" action="workflowphp.php" >
<input type="hidden" name="work_task_id" value="<? echo $work_task_id;?>" />
<input type="hidden" name="userid" value="<?=$userid;?>">
<script language=javascript src="js/functions.js"></script>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr>
	  <td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>Work Task of <?=$fname." ".$lname;?></font></td>
	</tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td>

		<table width="100%" style="border:#FFFFFF solid 1px;"  cellpadding=2 >
          <tr>
            <td colspan="11"><b>Add</b></td>
          </tr>
          <tr>
            <td>Subject</td>
			<td>:</td>
            <td colspan="9"><input type="text" name="jobdetails" id="jobdetails" style=" width:100%" value="<? echo $work_details2;?>"></td>
          </tr>
		   <tr>
            <td colspan="11" height="1"><hr></td>
          </tr>
          <tr>
            <td width="8%">Due Date</td>
            <td width="2%">:</td>
            <td width="15%"><input type="text" id="finish_date" name="finish_date"  style="width:90px; font-size:9px;" value="<? echo $date_finished2;?>">
                            
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
                  </script>              </td>
            <td width="3%">&nbsp;</td>
            <td width="7%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td width="8%">Start Date</td>
            <td width="2%">:</td>
            <td width="15%"><input type="text" id="start_date" name="start_date"  style="width:90px; font-size:9px;" value="<? echo $date_start2;?>">
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
                  </script>              </td>
            <td width="3%">&nbsp;</td>
            <td width="7%">Priority</td>
            <td width="1%">:</td>
            <td width="11%">
			<select name="priority" style="width:90px; font-size:9px;">
			<option value="0">-</option>
              <? echo $priorityoptions;?>
              </select>            </td>
            <td width="1%">&nbsp;</td>
            <td width="9%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="42%">&nbsp;</td>
          </tr>
		  <tr>
            <td colspan="11" height="1"><hr></td>
          </tr>
       <tr><td colspan="11" valign="top" align="center"><textarea name="notes" cols="48" rows="7" class="text"  style="width:100%"><? echo $notes2;?></textarea>
         <?=$button;?>

</td>
</tr>
</table>
</td>
</tr>
<tr><td valign="top">
<!-- list -->
<a href="workflow.php?id=<?=$id;?>&userid=<?=$userid;?>" title="Active Work Task">
<img src="images/folder_open.gif" title="Archive"  align="absmiddle" border="0"> Active
</a>
|
<a href="workflow.php?id=<?=$id;?>&status=ARCHIVE&userid=<?=$userid;?>" title="Put on the Archive">
<img src="images/folder_open.gif" title="Archive"  align="absmiddle" border="0"> Archive
</a>
<table width="100%" style="border:#666666 solid 1px;" cellspacing="0" cellpadding="3">
<tr bgcolor="#CCCCCC"><td width="7%" valign="top" style="border-bottom:#666666 solid 1px;" align="left"><font color="#999999">#</font></td>
<td width="28%"  valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; "><b>Work Details</b></td>
<td width="24%"  valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; "><b style="color:#FFFF00"><?=$folder;?></b></td>
<td  align="center" width="6%" valign="top" style="border-bottom:#666666 solid 1px; border-left:#666666 solid 1px;"><font color="#FF0000"><b>Priority</b></font></td>
<td  align="center" width="6%" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#0033FF"><b>Progress</b></font></td>
<td width="9%" valign="top" style="border-bottom:#666666 solid 1px;"><font color='#999999'>Date Created</font></td>
<td width="10%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Start Date</b></td>
<td width="10%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Due Date</b></td>
</tr>
<?
//id, client_id, userid, date_start, date_finished, date_created, work_details, notes, percentage, status, subcon_reply, priority, client_reply

$sqlList ="SELECT id, DATE_FORMAT(date_start,'%D %b %Y'),DATE_FORMAT(date_finished,'%D %b %Y') ,DATE_FORMAT(date_created,'%D %b %Y') , work_details, notes, percentage ,priority,status
FROM workflow WHERE client_id = $client_id AND userid = $userid AND (status ='$status' $status2)  ORDER BY date_created DESC";
//echo $sqlList;
$result=mysql_query($sqlList);
$counter=0;
while(list($id, $date_start, $date_finished, $date_created, $work_details, $notes, $percentage,$priority,$status) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
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
$reply="<form method='post' name='form' action='workflowphp.php' >
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='userid' value='$userid'>
		<textarea name='client_reply' cols='48' rows='7' class='text'  style='width:98%'></textarea><br>
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
		$notes=str_replace("\n","<br>",$notes);
		
?>		
		
		<tr ><td width='7%' valign='top' style="border-bottom:#666666 solid 1px;" ><?=$counter;?>) 
		<a href="#" onclick ='go3(<? echo $id;?>,<?=$userid;?>,"<?=$status;?>"); return false;' title="Delete <?=$work_details;?>"> <img src="images/delete.png"  align="absmiddle" border="0"> </a>
		<a href="workflow.php?id=<?=$id;?>&action=UPDATE&userid=<?=$userid;?>" title="Update <?=$work_details;?>"> <img src="images/b_edit.png"  align="absmiddle" border="0"></a>
		<?
		if($status=="NEW") {
		?>
		<a href="workflow.php?id=<?=$id;?>&action=ARCHIVE&userid=<?=$userid;?>" title="Put on the Archive"> <img src="images/foldermove16.png"  align="absmiddle" border="0"></a>
		<? }?>
		<br><br><?php if ($status == "DONE") echo $status;?>
		</td>
		<td  colspan="2" valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; '><?="<b><font color='#999999'>SUBJECT</font></b> :" .$work_details."<br><br><b><font color='#999999'>NOTES</font></b> ".$notes;?><br> <br> 
		
		<a class="link10" href='javascript: show_hide("reply_form<? echo $counter;?>");'>
		Response <img src="images/view2.gif" border="0" alt="Response from Sub-Contractor" align="top"></a> <br>
		
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
			if ($created_by =="CLIENT")
			{
				$bgcolor="#c0e0f5";
				$name =$clientfname;
			}
			else
			{
				$bgcolor="#abccdd";
				$name =$subconfname;
			}
			$message=str_replace("\n","<br>",$message);
			echo  "<tr bgcolor=$bgcolor><td width=70%><b>$name says :</b></td><td width =30%>$chat_date</td></tr>
							<tr bgcolor=#eeeeee><td colspan='2'>$message</td></tr>";
		}
		
		echo "</table></div>";
		}
		echo "<br>".$reply;
		?>
		</div>
		
		</td>
		<td  align="center" width="6%" valign="top" style="border-bottom:#666666 solid 1px;border-left:#666666 solid 1px;"><font color="#FF0000" size="2"><b><? if($rate!=""){echo $rate;}else {echo "&nbsp;";}?></b></font></td>
		<td width='6%' align="center" valign='top' style="border-bottom:#666666 solid 1px;"><font color="#0033FF"><b><? if($percentage!=""){echo $percentage;}else{echo "&nbsp;";}?><?=$finish;?></b></font></td>
		<td width='9%' valign='top' style="border-bottom:#666666 solid 1px;"><font color="#CCCCCC"><? if($date_created!=""){echo $date_created;}else{echo "&nbsp;";}?></font></td>
		<td width='10%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;'><? if($date_start!=""){echo $date_start;;}else{echo "&nbsp;";}?></td>
		<td width='10%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;'><? if($date_finished!=""){echo $date_finished;}else{echo "&nbsp;";} ?></td>
		</tr>
	<? if($answer!="") {?>	
		<tr ><td></td><td colspan='4' valign="top"></td>
		<td></td><td></td>
		</tr>
	<? }?>	
		
<?	
	}


?>
</table>
<script language=javascript>
<!--
	function go3(id,userid,status) 
	{
			if (confirm("Delete this Selected Task ?")) {
				location.href = "workflow.php?id="+id+"&action=DELETE&userid="+userid+"&status="+status;
				//alert(id +"\n"+userid+"\n"+status);
			}
		
	}
	
//-->
</script>

<!-- -->
</td></tr>
</table>
</body>
