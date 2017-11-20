<?php
include 'config.php';
include 'conf.php';
include 'time.php';



if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}


$userid = @$_GET["userid"];
mysql_query("UPDATE applicants SET status='Unprocessed' WHERE userid='$userid' LIMIT 1");
$a = mysql_query("SELECT fname, lname FROM personal WHERE userid='$userid' LIMIT 1");
$name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");
?>
<script language="javascript">
	alert("<?php echo $name; ?> has been successfully moved to Unprocessed.");
	window.close();
</script>

<html>
<head><title>Move Applicant</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="category/category.css">

<style type="text/css">
<!--
.style2 {color: #666666}
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;

visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
#searchbox
{
 padding-left:30px; padding-bottom:5px; padding-top:5px; margin-left:10px;
 border: 8px solid #E7F0F5;
 
}

#searchbox p
{
	margin-top:5px; margin-bottom:5px;
}


.pagination{
padding: 2px;
margin-top:10px; 
text-align:center;

}

.pagination ul{
margin: 0;
padding: 0;
text-align: center; /*Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 11px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

#tabledesign{
border:#666666 solid 1px;
}
#tabledesign tr:hover{
background-color:#FFFFCC;
}
-->
</style>
</head>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<center>
<br><br><br>
<form method="post" action="?userid=<?php echo @$userid; ?>">
<table cellpadding="3" cellspacing="3">
						<tr>
							<td align="right">
								<strong>Select Position: </strong>
							</td>
							<td>
							<select name="position">
							<option value=""></option>

		<?php
			$queryAllLeads = "SELECT sub_category_id, sub_category_name
				FROM job_sub_category 
				ORDER BY sub_category_name ASC;";
			//echo $queryAllLeads;
			$result = mysql_query($queryAllLeads);
			while(list($sub_category_id, $sub_category_name)=mysql_fetch_array($result))
			{
		?>
								<option value="<?php echo $sub_category_name; ?>"><?php echo $sub_category_name; ?></option>
		<?php
			}
		?>								
							</select>
									
							</td>
						</tr>
						<tr>
							<td align="right"></td>
							<td><input type="submit" value="Select Now" name="endorse"></td>
						</tr>						
					</table>
</form>					
</center>
</body>
</html>



