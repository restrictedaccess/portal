<?php
include 'config.php';
include 'conf.php';

$userid = $_REQUEST["userid"];

if($_SESSION['admin_id']=="" && $_SESSION['agent_no'] == "")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}

$result =  mysql_query("SELECT time_zone FROM staff_timezone WHERE userid='$userid' LIMIT 1");

while ($r = mysql_fetch_assoc($result)) 
{
	$data_set = $r["time_zone"];
}

$US = stristr($data_set, "US");
$AU = stristr($data_set, "AU");
$UK = stristr($data_set, "UK");
$ANY = stristr($data_set, "ANY");

$a_n_y = "checked";
$a_u = "checked";
$u_k = "checked";
$u_s = "checked";

if($ANY === FALSE)
{	
	$a_n_y = "";
}
if($AU === FALSE)
{
	$a_u = "";
}
if($UK === FALSE)
{
	$u_k = "";
}
if($US === FALSE)
{
	$u_s = "";
}

?>


<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">

<script language="javascript">
function staff_timezone(userid,id,t)
{
	var x=null;
	var ac='';
	try
	{
		x=new XMLHttpRequest();
	}
	catch (e)
	{
		try
		{
			x=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			x=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	
	if(document.getElementById("tz"+id).checked == true)
	{
		ac = "check";
	}
	else
	{
		ac = "uncheck";
	}

	if (x==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	x.open("GET","staff_timezone_update.php?time_zone="+t+"&action="+ac+"&userid="+userid,true);
	x.send(null);
	alert("Changes has been saved.");	
}
</script>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<style type="text/css">
<!--
div.scroll {
	height: 400px;
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
-->
</style>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">


<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
	<tr>
		<td height="40" colspan="2">
			<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
				<b>Staff Time-Zone</b>
			</div>				
		</td>
	</tr>	
	<tr>
		<td height="32" colspan="2" valign="middle">
        
        
        
    	<table>
        	<tr>
            	<td><strong>SELECTED TIMEZONE: </strong> </td>
                <td><?php echo $data_set; ?> </td>
            </tr>        
        	<tr>
            	<td><strong>Australian Shift</strong> (7am to 4pm Manila Time +/-DST) </td>
                <td><input type="checkbox" name="tz1_name" id="tz1" onClick="staff_timezone('<?php echo $userid; ?>',1,'AU');" <?php echo $a_u; ?> />Yes </td>
            </tr>
        	<tr>
            	<td><strong>UK Shift</strong> (4pm to 1am Manila Time +/-DSTcheckTimeZone)</td>
                <td><input type="checkbox" name="tz2_name" id="tz2" onClick="staff_timezone('<?php echo $userid; ?>',2,'UK');" <?php echo $u_k; ?> />Yes </td>
            </tr>
        	<tr>
            	<td><strong>US </strong> (Night Shift) </td>
                <td><input type="checkbox" name="tz3_name" id="tz3" onClick="staff_timezone('<?php echo $userid; ?>',3,'US');" <?php echo $u_s; ?> />Yes </td>
            </tr>
        	<tr>
            	<td><strong>Any Shift</strong></td>
                <td><input type="checkbox" name="tz4_name" id="tz4" onClick="staff_timezone('<?php echo $userid; ?>',4,'ANY');" <?php echo $a_n_y; ?> />Yes </td>
            </tr>
        </table>
        
        
                
        </td>
	</tr>
	<tr>
		<td colspan="2" valign="top"></td>
	</tr>
</table>




</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>
 
</body>
</html>