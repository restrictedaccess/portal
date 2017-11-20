<?
include './conf/zend_smarty_conf_root.php';
$admin_id = $_SESSION['admin_id'];
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
//$db->setFetchMode(Zend_Db::FETCH_OBJ);
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";
$result = $db->fetchRow($query);
$admin_name = "Welcome Admin :".$result['admin_fname']." ".$result['admin_lname'];

?>

<html>

<head>

<title>Administrator-Testimonials</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="testimonials/admin/admin_testi.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="testimonials/admin_testi.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="adminHome.php">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="hidden" name="usertype" id="usertype" value="admin">

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?=$admin_name;?></div>
<table width="100%">
<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>

</td>

<td valign="top"  style="font:12px Arial;">
<div class="testi_hdr" >
	<div style="float:left;">
		<div><b>View Testimonials in</b></div>
		<div style="text-align:right; padding:5px;"><b>Staff Search : </b></div>
	</div>
	<div style="float:left; margin-left:10px;">
	<div>
		<select id="section" name="section" class="select" onChange="getTestimonialsFrom();">
			 <option value="clients">Clients</option>
			 <option value="staff" selected=>Staff</option>
		</select>
	</div>
	<div><input type="text" name="keyword" id="keyword" value="<?=$keyword;?>" class="select" onKeyUp="getTestimonialsFromSearch(this.value)"  ></div>	
	</div>
	
	<div style="float:right;">	
		<input type="button" value="View Displayed Testimonials" onClick="javscript: location.href = 'admin_view_displayed_testimonials.php';">
	</div>
	<div style="clear:both;"></div>
</div>
<table width="100%" border="1">
<tr>
<td width="21%" valign="top" style="font:12px Arial;">
<div class="section_txt">
	<div id="section_txt" style="float:left;">LOADING...</div>
	<div style="float:right;"><a href="javascript: getTestimonialsFrom();" class="link10">Refresh List</a></div>
	<div style="clear:both;"></div>
</div>
<div id="sections">Loading...</div>
</td>
<td width="79%" valign="top">
<div id="testimonials">Click one of the Staff</div>
</td>
</tr>

</table>




</td>
</tr>
</table>
<script type="text/javascript">
<!--
	getTestimonialsFrom()

-->
</script>
<? include 'footer.php';?>
</form>	
</body>
</html>



