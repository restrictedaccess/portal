<?php
include 'config.php';
include 'conf.php';
include './conf/zend_smarty_conf.php';

if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}
$userid=$_SESSION['userid'];
//$userid=$_REQUEST['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];


$query="SELECT image FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$src=$row[0];
	$image= "<img border=0 src='$src' width=110 height=150>";
}


if(isset($_REQUEST["upload"]))
{
	include_once('lib/staff_files_manager.php');
	$file_manager = new staff_files_manager($userid);	
						
						
	//START - upload voice file
	$tmpName = $_FILES['sound_file']['tmp_name']; 
	$sound = $_FILES['sound_file']['name']; 
	$soundsize= $_FILES['sound_file']['size']; 
	$soundtype = $_FILES['sound_file']['type'];
	$upload_voice_result = $file_manager->add_voice_file($tmpName, $sound, $soundsize, $soundtype);
	//ENDED - upload voice file	
						
	if($upload_voice_result == false)
	{
		$error_result = "<br /><br /><font color=red><b>Error: An error occurred uploading the file... please try again.</b></font>";
	}
	else
	{
		header("location:regcompleted.php");
	}
}
?>
<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- header -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<!-- header -->
<!-- HEADER -->
<!-- /HEADER -->
<script language="JavaScript">
<!-- 
function ConfirmRemovePhoto(url, msg) {
  var confirm_remove = window.confirm (msg);
  if (confirm_remove) {
    parent.location= url;}
}
//-->
</script>


		<!-- SUBHEADER --><!-- /SUBHEADER -->
		
			<!-- WELCOME MESSAGE -->
            <!-- /WELCOME MESSAGE -->
            <!-- CONTENT -->
<table cellpadding="0" cellspacing="0" border="0" width="744">
		<tr><td width="736" bgcolor="#ffffff" align="center">
			<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td></tr><tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?
if ($src!="")
{
	$replace_image ="<img src='images/action_check.gif' align='absmiddle'>";
}
else
{
	$replace_image ="<img src='images/arrow.gif'> <img src='images/cross.gif' >";
}

?>

<div style="border: #FFFFFF solid 1px; width:230px; margin-top:20px;">
<p><a href="index.php" class="link12b">Home</a></p>
<p>Applicants Registration Form</p>
<ul>-- Status --
<li style="margin-bottom:10px;">Personal Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;">Educational Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;">Work Experinced Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;">Skills Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;">Languages Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;">Upload Photo <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;"><b style="color:#0000FF">Voice Recording </b><?=$replace_image?></li>
</ul>
</div>

</td>
<td width=566 valign=top align=right>
	<table width=566 cellpadding=10 cellspacing=0 border=0>
    	<tr>
        	<td>
				<form method="POST" name="frmPersonal" onSubmit="return checkFields();" enctype="multipart/form-data">            
            	<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
                	<tr>
                    	<td width=100% bgcolor=#DEE5EB colspan=2>
                        	<b>Upload Voice Recording (OPTIONAL)</b>
						</td>
					</tr>
                    <tr>
                    	<td colspan=2 class=msg>
                        	<img src='images/tip.gif' alt='Tip'>
                                            Voice recording should be:<br />
                                            Size: Equal or less than 5000kb in size<br />
                                            Format: WAV, Mpeg, WMA, MP3<br />
                                            Length: Should be equal or less than 3 minutes<br />
                                            Content: Quick voice resume. Introduction and summary of experience
                                            <?php echo $error_result; ?>
						</td>
					</tr>
                    <tr>
                        <td width=30% align=right valign="top">Voice :</td>
                        <td colspan=2 ><input type="file" name="sound_file" id="sound_file"></td>
                    </tr>
                    <tr>
                        <td width=30% align=right valign="top"></td>
                        <td colspan=2 ><INPUT type=submit value='Upload & Done' name="upload" class="button" style='width:120px'></td>
                    </tr>
				</table>
                </form>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
	
</body>
</html>
