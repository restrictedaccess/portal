<?
include 'config.php';
include 'conf.php';
include 'function.php';
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];

//leads info
$query="SELECT CONCAT(fname,' ',lname),email FROM leads WHERE id=$client_id;";
$result=mysql_query($query);
list($name, $email) = mysql_fetch_array ($result); 


$code=$_REQUEST['code'];
$testimony_id = $_REQUEST['testimony_id'];

if($testimony_id!=NULL){
	
	$query="SELECT recipient_id, title, testimony FROM testimonials t WHERE testimony_id = $testimony_id;";
	$result = mysql_query($query);
	list($recipient_id, $title, $testimony)=mysql_fetch_array($result);
	
}



$queryStaff="SELECT DISTINCT(u.userid), CONCAT(u.fname,' ',u.lname),u.image
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		WHERE s.leads_id = $client_id AND s.status='ACTIVE' ORDER BY u.fname ASC;";
$resulta=mysql_query($queryStaff);
while(list($userid,$staff_name,$image)=mysql_fetch_array($resulta))
{
	if($recipient_id == $userid)
    {
	 	$staff_options.= "<option selected value=\"$userid\">$staff_name</option>\n";
    }
    else
    {
	 	$staff_options.= "<option value=\"$userid\">$staff_name</option>\n";
    }
}




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="testimonials/testi.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="testimonials/testi.js"></script>
<script type="text/javascript">
<!--
function validateInputs(){
	if(document.getElementById("testimony").value==""){
		alert("Please type a message!");
		return false;
	}
	return true;
}
-->
</script>

	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="client_create_testimonialsphp.php" onSubmit="return validateInputs();">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="hidden" name="testimony_id" id="testimony_id" value="<?=$testimony_id;?>">
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="clientHome.php"><b>Home</b></a></li>
   <li ><a href="myscm.php"><b>Sub-Contractor Management</b></a></li>
     <li ><a href="work_with_remotestaff.php"><b>How To Work With RemoteStaff </b></a></li>
<li ><a href="comments_suggestion.php"><b>Comments &amp; Suggestions</b></a></li>
</ul>
<div style="font:12px Arial; background:#c0e0f5; padding:5px;"><b>Welcome Client <? echo $name;?></b></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="14%" height="176" bgcolor="#ffffff"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<? include 'clientleftnav.php';?>
</td>
<td width="100%" valign="top" style=" font:12px Arial;">
<div style="padding:5px; background:#333333; color:#FFFFFF;">
	<div style="float:left;">
		<b>Create Testimonials</b>
	</div>
	<div style="float:right;"><input type="button" value="Back" onClick="self.location='mytestimonials.php'" style="font:11px tahoma;"></div>
	<div style="clear:both;"></div>
</div>

<table id="create_testi" width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2" align="center" bgcolor="#FFFFCC"><b>
<? if($code==1) { echo "New Testimonial has been Saved! <input type='button' value='View' onClick=self.location='client_testimonials.php' style='font:11px tahoma; margin-left:20px;'>"; } 
if($code==2) { echo "Testimonial has been Updated! <input type='button' value='View' onClick=self.location='client_testimonials.php' style='font:11px tahoma; margin-left:20px;'>"; }
?></b></td></tr>
	<tr>
		<td width="21%" valign="top">Choose Staff</td>
		<td width="79%" valign="top">
		<div>
		
		  <select name="userid"  id="userid" class="select" style="width:500px;" onChange="showImage(this.value);" >
            <?=$staff_options;?>
          </select>
		
		
		</div>		</td>
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
		<td width="79%" valign="top"><textarea name="testimony" id="testimony" style="width:800px; height:350px; font:11px tahoma;"><?=$testimony;?>
		</textarea></td>
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
</table>

<? include 'footer.php';?>
</form>
</body>
</html>
