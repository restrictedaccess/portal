<?
include 'conf.php';
include 'config.php';
include 'function.php';
include 'time.php';
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

$control=$_REQUEST['control'];
$delete=$_REQUEST['delete'];

$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['leads_id'];
$id=$_REQUEST['id'];
$mess=$_REQUEST['mess'];


if($delete=="TRUE")
{
	$sqlDELETE="DELETE FROM notes WHERE id =$id";
	mysql_query($sqlDELETE);
}



$query="SELECT * FROM admin_notes WHERE leads_id = $leads_id AND id=$id;";
$resulta=mysql_query($query);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$starting_date =$row['starting_date'];
	$position =$row['position'];
	$subcon =$row['subcon'];
	$subcon_no =$row['subcon_no'];
	$working_start_date = $row['working_start_date'];
	$notes=$row['notes'];
}

if(isset($_POST['save']))
{	// table : notes
	//id, agent_no, leads_id, starting_date, position, subcon, subcon_no, working_start_date, notes, date_created
	$leads_id=$_REQUEST['leads_id'];
	$id=$_REQUEST['id'];
	//echo $agent_no."<br>".$leads_id;
	$starting_date =$_REQUEST['starting_date'];
	$position =$_REQUEST['position'];
	$subcon_no=$_REQUEST['subcon_no'];
	$subcon =$_REQUEST['subcon'];
	$working_start_date = $_REQUEST['working_start_date'];
	$notes=$_REQUEST['notes'];

	if($id==""){
	$sql="INSERT INTO admin_notes SET admin_id = $agent_no, 
						leads_id = $leads_id, 
						starting_date = '$starting_date', 
						position = '$position', 
						subcon_no = '$subcon_no',
						subcon = '$subcon', 
						working_start_date = '$working_start_date', 
						notes = '$notes', 
						date_created = '$ATZ',
						user_type = 'agent';";
	$mess=1;					
	}
	if($id!=""){
	$sql="UPDATE admin_notes SET starting_date = '$starting_date', 
						position = '$position',
						subcon_no = '$subcon_no', 
						subcon = '$subcon', 
						working_start_date = '$working_start_date', 
						notes = '$notes' 
						WHERE id=$id;";
	$mess=2;
	}
	$result2=mysql_query($sql);
	if (!$result2)
	{
		echo "Query: $sql\n<br />MySQL Error: " . mysql_error();
	}
	else
	{
		echo("<html><head><script>function update(){top.location='addNotes.php?leads_id=$leads_id&mess=$mess';}var refresh=setInterval('update()',1200);
	</script></head><body onload=refresh><body></html>");
	}
	
}

?>

<html>
<head>
<title>Recruitment Process Notes</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>
</head>

<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">
<form method="post" name="form" action="addNotes.php">
<input type="hidden" name="leads_id" id="leads_id" value="<?=$leads_id;?>">
<input type="hidden" name="id" id="id" value="<?=$id;?>">
<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;<font style='font: bold 10pt verdana;'>Recruitment Preparation Notes</font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td valign="top" bgcolor="#FFFFFF">
	
	<p align="right"><b><a href='addNotes.php?leads_id=<?=$leads_id;?>&control=show'>Add</a> </b></p>
<? if($control=="show") {?>
<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#999999 solid 1px;">
<tr><td width="49%" valign="top" ><b>Recruitment Start Date</b></td>
<td width="1%" valign="top">:</td>
<td width="50%" valign="top"><input type='text' id="starting_date" name='starting_date' style='color:#666666;' class='text' value="<?=$starting_date;?>" >&nbsp;<img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red';" onMouseOut="this.style.background='';" />
	 <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "starting_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td>
</tr>
<tr>
  <td valign="top"><strong>Recruit for Position </strong></td>
  <td valign="top">:</td><td valign="top"><input type="text" name="position" id="position" value="<?=$position;?>" class="text"></td>
</tr>
<tr><td valign="top"><strong>No. Needed</strong></td>
<td valign="top">:</td><td valign="top"><input type="text" name="subcon_no" id="subcon_no" value="<?=$subcon_no;?>" class="text" style="width:20px;"></td></tr> 
<tr><td valign="top"><strong>Person to Fill the Position</strong></td>
<td valign="top">:</td><td valign="top"><font color="#666666">Please separate names by a comma(",")</font><br>
<textarea name="subcon" id="subcon" cols="40" class="text"><?=$subcon;?></textarea></td></tr> 
<tr><td valign="top"><strong>Sub-Contracted Start Date</strong></td>
<td valign="top">:</td><td valign="top"><input type='text' id="working_start_date" name='working_start_date' style='color:#666666;' class='text' value="<?=$working_start_date;?>" >&nbsp;<img align="top" src="images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red';" onMouseOut="this.style.background='';" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "working_start_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd2",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td></tr>
<tr><td valign="top"><strong>Notes</strong></td>
<td valign="top">:</td><td valign="top"><textarea name="notes" id="notes" cols="35" rows="5"><?=$notes;?></textarea></td></tr> 
<tr><td colspan="3"><input type="submit" name="save"  id="save" value="Save"></td></tr>
</table>
<? }?>
<center>
<? if ($mess==1){ echo"<span style='background:#FFFFCC; margin-left:90px;'><b>SAVE SUCCESSFULLY</b></span>"; } ?>
<? if ($mess==2){ echo"<span style='background:#FFFFCC; margin-left:90px;'><b>UPDATE SUCCESSFULLY</b></span>"; } ?>
</center>


<div id="display">
<?
$query="SELECT DATE_FORMAT(n.starting_date,'%D %b %Y'),n.position,n.subcon,DATE_FORMAT(n.working_start_date,'%D %b %Y'),n.notes, DATE_FORMAT(n.date_created,'%D %b %Y'),n.id,n.subcon_no ,n.admin_id ,n.user_type
FROM admin_notes n WHERE  leads_id = $leads_id;";
//echo $query;
$resulta=mysql_query($query);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	echo "<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff>";
	while(list($starting_date,$position,$subcon,$working_start_date,$notes,$date_created,$id,$subcon_no,$admin_id,$user_type)=mysql_fetch_array($resulta))
	{ //$date_created
		if($user_type == ""){
			$user_type = "admin";
		}
		echo "<tr>";
		echo "<td colspan=3 align =right>$date_created<br>
				<a href='addNotes.php?leads_id=$leads_id&id=$id&control=show'>Edit</a> | <a href='addNotes.php?leads_id=$leads_id&id=$id&delete=TRUE'>Delete</a></td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td width=40%>Recruitment Start Date</td><td width=1%>:</td><td width=70%>$starting_date</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>Recruit for Position</td><td>:</td><td>$position</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>No. Needed</td><td>:</td><td>$subcon_no</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>Person to Fill the Position</td><td>:</td><td>$subcon</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>Sub-Contracted Start Date</td><td>:</td><td>$working_start_date</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td colspan=3 height =30>$notes</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=3 height=1>Created By ";
			if($user_type == "admin"){
				$sql = "SELECT admin_fname, admin_lname FROM admin WHERE admin_id = $admin_id;";
			}
			if($user_type == "agent"){
				$sql = "SELECT fname, lname FROM agent WHERE agent_no = $admin_id;";
			}
			$results = mysql_query($sql);
			list($fname,$lname)=mysql_fetch_array($results);
			echo strtoupper($user_type)." : ".$fname." ".$lname;
		echo "</td>";	
		
		echo "</tr>";
		
		echo "<tr>";
		echo "<td colspan=3 height=1><hr></td>";
		echo "</tr>";
	}
	echo "</table>";
}	

?>
</div>
		
		
	</td></tr>
	</table>
</form>
	</body>
	</html>

