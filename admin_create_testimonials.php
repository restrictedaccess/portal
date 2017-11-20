<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$admin_name = "Welcome Admin :".$row['admin_fname']." ".$row['admin_lname'];
}

$code=$_REQUEST['code'];
$testimony_id = $_REQUEST['testimony_id'];
if($testimony_id!=NULL){
	
	$query="SELECT created_by_id, created_by_type, recipient_id, recipient_type, testimony_status, date_created, date_updated, date_posted, title, testimony 
	FROM testimonials t WHERE testimony_id = $testimony_id;";
	$result = mysql_query($query);
	list($created_by_id, $created_by_type, $recipient_id, $recipient_type, $testimony_status, $date_created, $date_updated, $date_posted, $title, $testimony)=mysql_fetch_array($result);
	
}

$recipientArray = array('subcon','leads');
$recipientArrayNames = array('Staff','Client');
for($i = 0; $i <count($recipientArray); $i++){
	if($recipient_type == $recipientArray[$i]){
		$recipientOptions.="<option selected value=\"$recipientArray[$i]\">$recipientArrayNames[$i]</option>\n";
	}else{
		$recipientOptions.="<option value=\"$recipientArray[$i]\">$recipientArrayNames[$i]</option>\n";
	}
}


$testimony_statusArray=array('new','posted','cancel','updated');
for($i=0;$i<count($testimony_statusArray);$i++){
	if($testimony_status == $testimony_statusArray[$i]){
		$statusOptions.="<option selected value=\"$testimony_statusArray[$i]\">$testimony_statusArray[$i]</option>\n";
	}else{
		$statusOptions.="<option value=\"$testimony_statusArray[$i]\">$testimony_statusArray[$i]</option>\n";
	}
}
?>

<html>

<head>

<title>Administrator-Testimonials</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="testimonials/testi.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="testimonials/testi.js"></script>
<script type="text/javascript">
<!--
function validateInputs(){
	if(document.getElementById("testimony").value==""){
		alert("Please type a message!");
		return false;
	}
	if(document.getElementById("recipient_type").value == 0){
		alert("Please choose either Subcon or Client");
		return false;
	}
	return true;
}
-->
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="admin_create_testimonialsphp.php" onSubmit="return validateInputs();">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="hidden" name="testimony_id" id="testimony_id" value="<?=$testimony_id;?>">
<input type="hidden" name="usertype" id="usertype" value="admin">

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?=$admin_name;?></div>
<table width="100%">
<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>

</td>

<td valign="top"  style=" font:12px Arial;">
<div style="padding:5px; background:#333333; color:#FFFFFF;">
	<div style="float:left;">
		<b>Create Testimonials</b>
	</div>
	<div style="float:left; margin-left:10px;">
		<select name="recipient_type" id="recipient_type" class="select" onChange="showStaffClientCreateTestimonialsForm(this.value);">
			<option value="0" >Please choose</option>
			<?=$recipientOptions;?>
		</select>
	</div>
	<div style="float:right;"><input type="button" value="Back" onClick="self.location='admin_testimonials.php'" style="font:11px tahoma;"></div>
	<div style="clear:both;"></div>
</div>
<table id="create_testi" width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2" align="center" bgcolor="#FFFFCC"><b>
<? if($code==1) { echo "New Testimonial has been Saved! <input type='button' value='View' onClick=self.location='admin_testimonials.php' style='font:11px tahoma; margin-left:20px;'>"; } 
if($code==2) { echo "Testimonial has been Updated! <input type='button' value='View' onClick=self.location='admin_testimonials.php' style='font:11px tahoma; margin-left:20px;'>"; }
?></b></td></tr>

	<tr>
		<td width="79%" valign="top" colspan="2">
		<div id="result">
		
		  </div>
		</td>
	</tr>
	<tr>
		<td width="21%" valign="top">Status</td>
		<td width="79%" valign="top">
			<select name="testimony_status" id="testimony_status" class="select">
				<?=$statusOptions;?>
			</select>
		
		</td>
	</tr>
	<tr>
		<td width="21%" valign="top">Title</td>
		<td width="79%" valign="top">
		<input type="text" name="title" id="title" class="select" style="width:500px;" value="<?=$title;?>">		</td>
	</tr>
	<tr>
		<td width="21%" valign="top">Testimonials
		
		<div id="show_image" style="display:block; margin-top:10px; text-align:center; "></div>
		</td>
		<td width="79%" valign="top"><textarea name="testimony" id="testimony" style="width:800px; height:350px; font:11px tahoma;"><?=$testimony;?></textarea></td>
	</tr>
	
	<tr>
		<td width="21%" valign="top" colspan="2">
		<? if($testimony_id=="") {?>
		<input type="submit" value="Submit" name="save" id="save">
		<? }else {?>
		<input type="submit" value="Update" name="update" id="update">
		<? }?>
		<input type="reset" value="Cancel">		</td>
	</tr>
</table>
</td>
</tr>
</table>
<script type="text/javascript">
<!--
showStaffClientCreateTestimonialsForm('<?=$recipient_type;?>');
-->
</script>
<? include 'footer.php';?>
</form>	
</body>
</html>



