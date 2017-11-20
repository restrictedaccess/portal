<?
include '../config.php';
include '../function.php';
include '../conf.php';

$agent_no = $_SESSION['agent_no'];
$leads_id = $_REQUEST['id'];

if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}

$queryLeads ="SELECT * FROM leads WHERE id = $leads_id;";
$resultLeads=mysql_query($queryLeads);
$rows = mysql_fetch_array($resultLeads);
$lname =$rows['lname'];
$fname =$rows['fname'];
$mode =  $_REQUEST['mode'];
$todo_id =$_REQUEST['todo_id'];
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

if($folder!="" || $folder=="ARCHIVE")
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

?>

<html>
<head>
<title>Business Partner  Lead Management</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../css/style.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel="stylesheet" type="text/css" href="tab/tabcontent.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="tab/tabcontent.js"></script>
<script type="text/javascript" src="script/apply_action.js"></script>
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../js/functions.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="showLeadInfo();">
<form method="POST" name="form" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="id" id="id" value="<? echo $leads_id;?>">
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
</tr>
<tr><td width="178" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='../images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=722 valign=top  align="left">

<div id="pettabs" class="indentmenu" style="margin-left:10px; margin-top:10px;">
<ul>
<li><a href="#" rel="lead" class="selected" >Lead : <span id="lead_name"><?=$fname." ".$lname;?></span></a></li>
<li><a href="#" rel="steps_taken">Steps Taken</a></li>
<li><a href="#" rel="action_records">Action Records</a></li>
<li><a href="#" rel="todo_reminders" ><span onClick="javascript:showTodoList();">To Do's</span></a></li>
</ul>
<br style="clear: left" />
</div>
<div style="border:1px solid gray; width:1000px; height: auto; padding: 5px; margin-bottom:1em; margin-left:10px;">
	<div id="lead" class="tabcontent">
		<!-- Lead Description -->
		<img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="steps_taken" class="tabcontent">
	   <img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="action_records" class="tabcontent">
		<!-- Action Records -->
		<img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="todo_reminders" class="tabcontent">
		
			<p><b>To Do's</b></p>
			<p>Archives &nbsp;<img src="../images/folder_open.gif" alt="Archives" border="0" align="texttop">&nbsp;
			Current Active List &nbsp;<img src="../images/folder_open.gif" alt="New" border="0" align="texttop"></p>
			<div style="padding:10px; border:#CCCCCC solid 1px;">
			<p><label>Subject :</label><input type="text" name="subject" id="subject" style="width:500px;" value="<? echo $subject;?>"></p>
			<p><label>Start Date :</label><span><input type="text" id="start_date" name="start_date"  style="width:90px;" readonly value="<? echo $start_date;?>">
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
			</span><label>Status :</label><select name="status"  id="status" style="width:130px;">
				<option value="0">-</option>
               <? echo $statusoptions;?>
              </select>	  
			</p>
			<p><label>Due Date : </label><span><input type="text" id="due_date" name="due_date"  style="width:90px;" readonly value="<? echo $due_date;?>">
                            
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
                  </script></span>
				  <label>Priority :</label><span><select name="priority" id="priority" style="width:90px; ">
			<option value="0">-</option>
              <? echo $priorityoptions;?>
              </select></span><label>% Complete : </label><select name="percentage" id="percentage" style="width:90px;">
              <? echo $percentoptions;?>
            </select>
				  </p>
			<p><textarea name="details" id="details" cols="48" rows="7" class="text"  style="width:100%"><? echo $details;?></textarea></p>
			<p align="center"><input type="hidden" name="mode" id="mode" value="<?=$mode ? $mode : 'save';?>"><input type="hidden" name="todo_id" id="todo_id" value="<?=$todo_id;?>"><input type="button" name="todo_button" value="Save/Update Todo" onClick="saveupdate_todo();"></p>	  
		
		</div>
		<input type="button" value="Refresh List" onClick="javascript:showTodoList();">
		<div id="todo_list">Loading...</div>
		<div style="clear:both;"></div>
	</div>

</div>


<script type="text/javascript">

var mypets=new ddtabcontent("pettabs")
mypets.setpersist(true)
mypets.setselectedClassTarget("link")
mypets.init(0)
showTodoList();
</script>
</td>
</tr></table>
<? include 'footer.php';?>
</form>
</body>
</html>
