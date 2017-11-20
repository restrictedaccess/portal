<?
include '../config.php';
include '../conf.php';
include '../function.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['leads_id'];
$url=$_REQUEST['url'];

//echo "Agent :".$agent_no."<br>".
//	"Lead Id :".$leads_id."<br>".
//	"URL :".$url."<br>";


$subject=$_REQUEST['subject'];
$start_date =$_REQUEST['start_date'];
$due_date=$_REQUEST['due_date'];
$status=$_REQUEST['status'];
$priority=$_REQUEST['priority'];
$details=$_REQUEST['details'];
$priority=$_REQUEST['priority'];

$mode=$_REQUEST['mode'];
$todo_id=$_REQUEST['id'];

$folder =$_REQUEST['folder'];

if($folder!="" && $folder=="ARCHIVE")
{
	$folder="ARCHIVE";
	$list ="ARCHIVE";
}
else
{
	$folder="NEW";
	$list ="CURRENT ACTIVE LIST";
}

if($priority!="" && $priority=="TRUE")
{
	$priority2="priority DESC";
}
if($priority=="")
{
	$priority2="due_date ASC";
}


//$date=ATZ();
//date_default_timezone_set('Australia/Perth');
//echo date_default_timezone_get()."<br>";
//echo ' => '.date('H')."<br>";
//echo ' => '.date('h')."<br>";
//echo $date;

if($mode=="UPDATE")
{
	//id, agent_no, date_created, subject, start_date, due_date, status, priority, percentage, details, folder
	$sql3="SELECT * FROM todo WHERE id=$todo_id AND agent_no=$agent_no;";
	//echo $sql3;
	$result3=mysql_query($sql3);
	$ctr3=@mysql_num_rows($result3);
	if ($ctr3 >0 )
	{
		$row3 = mysql_fetch_array($result3); 
		$subject = $row3['subject'];
		$start_date = $row3['start_date'];
		$due_date = $row3['due_date'];
		$status = $row3['status'];
		$priority = $row3['priority'];
		$percentage=$row3['percentage'];
		$details = $row3['details'];
		$value="Update";
	}	
}
if($mode=="DELETE")
{
	$sql4="DELETE FROM todo WHERE id=$todo_id AND agent_no=$agent_no;";
	//echo $sql4;
	mysql_query($sql4);
}

if($mode=="MOVE")
{
	$sql5="UPDATE todo SET folder='ARCHIVE' WHERE id=$todo_id;";	
	//echo $sql5;
	mysql_query($sql5);
}

if($mode=="BACK")
{
	$sql6="UPDATE todo SET folder='NEW' WHERE id=$todo_id;";	
	//echo $sql5;
	mysql_query($sql6);
}

$query2="SELECT * FROM agent WHERE agent_no =$agent_no;";
$result2=mysql_query($query2);
$ctr2=@mysql_num_rows($result2);
if ($ctr2 >0 )
{
	$row2 = mysql_fetch_array ($result2); 
	$name = $row2['fname']." ".$row2['lname'];
	
}

if (isset($_POST['submitted'])) // Check if the form has been submitted.
{
	$todo_id=$_REQUEST['todo_id'];
	
	$agent_no=$_REQUEST['agentno'];
	
	$leads_id=$_REQUEST['leads_id'];
	$url=$_REQUEST['url'];

	$subject=$_REQUEST['subject'];
	$start_date =$_REQUEST['start_date'];
	$due_date=$_REQUEST['due_date'];
	$status=$_REQUEST['status'];
	$priority=$_REQUEST['priority'];
	$percentage=$_REQUEST['percentage'];
	$details=$_REQUEST['details'];
	$subject=filterfield($subject);
	$details=filterfield($details);
	
	if($mode!="UPDATE")
	{
	//id, agent_no, lead_id, date_created, subject, start_date, due_date, status, priority, percentage, details, folder
		if($leads_id!=""){
		$query3="INSERT INTO todo (agent_no,lead_id, date_created, subject, start_date, due_date, status, priority, percentage,details, folder) 
				VALUES ($agent_no, $leads_id,'$ATZ', '$subject', '$start_date', '$due_date', '$status', '$priority', '$percentage','$details', 'NEW');";	
		}
		if($leads_id==""){
		$query3="INSERT INTO todo (agent_no, date_created, subject, start_date, due_date, status, priority, percentage,details, folder) 
				VALUES ($agent_no,'$ATZ', '$subject', '$start_date', '$due_date', '$status', '$priority', '$percentage','$details', 'NEW');";	
		}		
	}
	else
	{
		$query3="UPDATE todo SET subject ='$subject', start_date ='$start_date', due_date ='$due_date', status ='$status', priority ='$priority' ,
			 percentage ='$percentage',details ='$details' WHERE id=$todo_id;";
	}
	$result3=mysql_query($query3);
	if (!$result3)
	{
		echo "Query: $query3\n<br />MySQL Error: " . mysql_error();
	}
	else
	{
		echo("<html><head><script>function update(){top.location='todo.php?leads_id=$leads_id&url=$url';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
	}
}

$statusArray=array("Not Started","In Progress","Completed","Waiting on somene else","Deffered");
for($i=0;$i<count($statusArray);$i++)
{
	  if($status == $statusArray[$i])
      {
	 $statusoptions .= "<option selected value=\"$statusArray[$i]\">$statusArray[$i]</option>\n";
      }
      else
      {
	 $statusoptions .= "<option value=\"$statusArray[$i]\">$statusArray[$i]</option>\n";
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
	  if($priority == $i)
      {
	 $priorityoptions .= "<option selected value=\"$i\">$i</option>\n";
      }
      else
      {
	 $priorityoptions .= "<option value=\"$i\">$i</option>\n";
      }
}
if($value=="")
{
	$value="Save";
}

?>

<html>
<head>
<title>Leads &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkFields()
{
	if(document.form.subject.value=="")
	{
		alert("Please enter subject");
		return false;
	}
	
	if(document.form.due_date.value=="")
	{
		alert("Please specify a Due Date!");
		return false;
	}
	if(document.form.start_date.value=="")
	{
		alert("Please specify a Starting Date");
		return false;
	}
	if(document.form.status.selectedIndex==0)
	{
		alert("Please specify a Status");
		return false;
	}
	if(document.form.priority.selectedIndex==0)
	{
		alert("Please Rate your Message !");
		return false;
	}
	//if(document.form.percentage.selectedIndex==0)
	//{
	//	alert("Please specify percentage!");
	//	return false;
	//}
	if(document.form.details.value=="")
	{
		alert("Please enter your Message !");
		return false;
	}
	return true;
		
	
}
-->
</script>	


<style type="text/css">
<!--
	div.scroll {
		height: 500px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	#l {
	float: left;
	width: 250px;
	text-align:left;
	padding:5px 0 5px 10px;
	color:#000000;
	font-weight:bold;
	border: 1px solid #CCCCCC;
	}	

#r{
	float: right;
	width: 450px;
	text-align:justify;
	margin-right:10px;
	
	padding:5px 0 5px 10px;
	color:#000000;
	border: 1px solid #CCCCCC;
	}
-->
</style>	
</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">
<form method="post" name="form" action="todo.php" onSubmit="return checkFields();">
<input type="hidden" name="todo_id" value="<? echo $todo_id;?>" />
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="mode" value="<? echo $mode;?>" />
<input type="hidden" name="agentno" value="<? echo $agent_no; ?>" />
<input type="hidden" name="leads_id" value="<? echo $leads_id;?>">
<input type="hidden" name="url" value="<? echo $url;?>">
<script language=javascript src="../js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="../images/remote_staff_logo.png" alt="think" ></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="../images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="../images/space.gif" height=1 width=1></td></tr>
	<tr>
	  <td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>To do List</font></td>
	</tr>
	<tr><td height=1><img src="../images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td>
<a href="todo.php?agentno=<? echo $agent_no;?>&folder=ARCHIVE" class="link18">Archives &nbsp;<img src="../images/folder_open.gif" alt="Archives" border="0" align="texttop"></a> &nbsp;&nbsp;&nbsp;
<a href="todo.php?agentno=<? echo $agent_no;?>" class="link18">Current Active List &nbsp;<img src="../images/folder_open.gif" alt="New" border="0" align="texttop"></a>
		<br>
		
		<table width="100%" style="border:#FFFFFF solid 1px;"  cellpadding=2 >
<!-- -->
<? if ($folder!="ARCHIVE") {?>		
          <tr>
            <td colspan="11"><b>Add</b></td>
          </tr>
          <tr>
            <td>Subject</td>
			<td>:</td>
            <td colspan="9"><input type="text" name="subject" style=" width:100%" value="<? echo $subject;?>"></td>
          </tr>
		   <tr>
            <td colspan="11" height="1"><hr></td>
          </tr>
          <tr>
            <td width="8%">Due Date</td>
            <td width="2%">:</td>
            <td width="15%"><input type="text" id="due_date" name="due_date"  style="width:90px; font-size:9px;" value="<? echo $due_date;?>">
                            
							  <img align="top" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "due_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script>
							 
	              </td>
            <td width="3%">&nbsp;</td>
            <td width="4%">Status</td>
            <td width="1%">:</td>
            <td colspan="5"><select name="status" style="width:130px; font-size:9px;">
				<option value="0">-</option>
               <? echo $statusoptions;?>
              </select>            </td>
          </tr>
          <tr>
            <td width="8%">Start Date</td>
            <td width="2%">:</td>
            <td width="15%"><input type="text" id="start_date" name="start_date"  style="width:90px; font-size:9px;" value="<? echo $start_date;?>">
                <img align="top" src="../images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "start_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd2",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script>
                  </td>
            <td width="3%">&nbsp;</td>
            <td width="4%">Priority</td>
            <td width="1%">:</td>
            <td width="14%">
			<select name="priority" style="width:90px; font-size:9px;">
			<option value="0">-</option>
              <? echo $priorityoptions;?>
              </select>
            </td>
            <td width="1%">&nbsp;</td>
            <td width="9%">% Complete</td>
            <td width="1%">&nbsp;</td>
            <td width="42%">
			<select name="percentage" style="width:90px; font-size:9px;">
              <? echo $percentoptions;?>
            </select></td>
          </tr>
		  <tr>
            <td colspan="11" height="1"><hr></td>
          </tr>
       <tr><td colspan="11" valign="top" align="center">
<textarea name="details" cols="48" rows="7" class="text"  style="width:100%"><? echo $details;?></textarea>
<input type="submit" name="Add" value="<? echo $value;?>">

</td>
</tr>
<!-- -->
<? }?>
<tr>
<td colspan="11" valign="top"><p align="right" style="margin-top:0px; margin-bottom:1px;"><b>
<a href="todo.php?agentno=<? echo $agent_no;?>&priority=TRUE&folder=<? echo $folder;?>">Sort by Priority</a></b></p>
<table width="100%" style="border:#666666 solid 1px;" cellspacing="0" cellpadding="3">
<tr bgcolor="#CCCCCC"><td width="8%" valign="top" style="border-bottom:#666666 solid 1px;" align="right"><font color="#999999">Actions&nbsp;|&nbsp;Priority</font>&nbsp;&nbsp;&nbsp;</td>
<td width="21%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; "><b>Subject</b></td>
<td width="26%" valign="top" style="border-bottom:#666666 solid 1px; "><b><font color="#FFFFFF"><? echo $list;?></font></b></td>
<td width="18%" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#999999">Client</font></td>
<td width="11%" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#999999">Date Created</font></td>
<td width="16%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Due Date</b></td>
</tr>
<?
//id, agent_no, lead_id, date_created, subject, start_date, due_date, status, priority, percentage, details, folder
if($leads_id!=""){
$sqlList="SELECT  t.id,lead_id, subject, start_date, DATE_FORMAT(due_date,'%a %D %b %Y'), priority,DATE_FORMAT(date_created,'%D %b %Y'),details
FROM todo t 
WHERE agent_no =$agent_no 
AND lead_id = $leads_id
AND folder='$folder' ORDER BY $priority2;";
}		

if($leads_id==""){
$sqlList="SELECT  t.id,lead_id, subject, start_date, DATE_FORMAT(due_date,'%a %D %b %Y'), priority,DATE_FORMAT(date_created,'%D %b %Y'),details
FROM todo t 
WHERE agent_no =$agent_no 
AND folder='$folder' ORDER BY $priority2;";
}		

//echo $sqlList;
$result=mysql_query($sqlList);
$counter=0;
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
while(list($id, $lead_id,$subject, $start_date, $due_date, $priority, $date_created,$details,$fname,$lname) = mysql_fetch_array($result))
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
?>		
		<tr><td width='8%' valign='top' style="border-bottom:#666666 solid 1px;" ><? if ($folder =="NEW") {?><a href="../todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=MOVE"><img src="../images/action_check.gif" alt="Finished Move to Archives" align="top" border="0" ></a><? } if ($folder =="ARCHIVE") {?><a href="../todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=BACK"><img src="../images/arrow_back.gif" alt="Back to Current Active List" align="top" border="0" ></a><? }?>&nbsp;<a href="../todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=DELETE"><img src="../images/action_delete.gif" alt="Delete" align="top" border="0"></a>&nbsp;<? echo $counter; ?>)<font color="#FF9900" size="3"><b><? echo $rate;?></b></font></td>
		<td colspan="2" valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; '>
		<a href="todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=UPDATE&url=<?=$url;?>&leads_id=<?=$leads_id;?>" class="link2" title="<? echo $details;?>">
		<? echo strtoupper($subject);?>	
		<? if ($lead_id!=""){
		$sqlLead ="SELECT * FROM leads WHERE id = $lead_id;";
		$resulta=mysql_query($sqlLead);
		$rowa = mysql_fetch_array($resulta);
		$lname =$rowa['lname'];
		$fname =$rowa['fname'];
		}?>	</a>		</td>
		<td width='18%' valign='top' style="border-bottom:#666666 solid 1px;"><font color="#CCCCCC"><? if ($fname!=""){echo $fname." ".$lname;} else { echo "&nbsp;";}?></font></td>
		<td width='11%' valign='top' style="border-bottom:#666666 solid 1px;"><font color="#CCCCCC"><? echo $date_created;?></font></td>
		<td width='16%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;'><? echo $due_date;?></td>
		</tr>
<?		
	}
}	

?>
</table>



</td>
</tr>
 </table>
		
	<? echo "Welcome  ".$name;?>
		
		
		</td>
		</tr>
		</table>
	</td></tr>
	</table>
</form>
	</body>
	</html>

