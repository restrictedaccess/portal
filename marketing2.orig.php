<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
mysql_query('SET time_zone='.$timeZone);
$agent_no = $_SESSION['agent_no'];
/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$agent_email=$row['email'];
	$agent_address =$row['agent_address'];
	$agent_contact =$row['agent_contact'];
	$agent_abn =$row['agent_abn'];
	$email2 =$row['email2'];
	$agent_code=$row['agent_code'];
	if($email2!="")
	{
		$agent_email = $email2;
	}
	
}


$img=$_REQUEST['img'];
$imglink2=$_REQUEST['imagelink2'];
$subject=$_REQUEST['subject'];
//////////// SEND MESSAGE /////////////
$txt=$_REQUEST['message'];
$txt=str_replace("\n","<br>",$txt);

$emails=$_REQUEST['emails'];
if($subject=="")
{
	$subject='Message from RemoteStaff.com c/o  '.$name;
}


$applicant=explode(",",$emails);
$imglink="http://philippinesatwork.com/dev/norman/Chris/";
$imgUrl=$imglink.$imglink2;
$mess ="<a href='http://www.remotestaff.com.au/$agent_code' target='_blank'><img src='$imgUrl' class='img'></a>"."<br><br>".$txt;
$message =" <html>
					    <head>
						<title>RemoteStaff.Com.Au</title>
						<style>
						body{font-family:Tahoma; font-size:14px;}
						.message{margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;}
						</style>
						</head>
						<body>
						<table style=' border:#FFFFFF solid 1px;' width='100%'>
						<tr><td><img src='http://www.philippinesatwork.com/dev/norman/Chris/images/banner/remoteStaff-small.jpg'></td></tr>
						<tr><td width='100%%' valign='top'><hr style='border:#99CC66 solid 1px;'></td></tr>
						<tr><td height='105' width='100%%' valign='top'>
						<p class='message' align='justify'>".$mess."</p>
						</td></tr>
						<tr><td height='28' background='http://www.philippinesatwork.com/dev/norman/Chris/images/banner/remote.jpg'>&nbsp;</td>
						</tr>
						<tr><td height='10' width='100%%' valign='top' style='color:#999999; font-size:12px;'>
						<div style='margin-left:10px; margin-top:5px;'>
						Address : ".$agent_address."<br>
						Contact No : ".$agent_contact."<br>
						Email : ".$agent_email."<br />
						</div>
						</td></tr>
						</table>
						</body>
						</html>";

if(isset($_POST['send']))
{
$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
$headers = "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
$headers .= "MIME-Version: 1.0\r\n" ."Content-Type: multipart/mixed;\r\n" ." boundary=\"{$mime_boundary}\"";
$message = "This is a multi-part message in MIME format.\n\n" .
"--{$mime_boundary}\n" .
"Content-Type: text/html; charset=\"iso-8859-1\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" .
$message . "\n\n";

foreach($_FILES as $userfile){
// store the file information to variables for easier access
$tmp_name = $userfile['tmp_name'];
$type = $userfile['type'];
$name = $userfile['name'];
$size = $userfile['size'];
// if the upload succeded, the file will exist
if (file_exists($tmp_name)){
// check to make sure that it is an uploaded file and not a system file
if(is_uploaded_file($tmp_name)){
// open the file for a binary read
$file = fopen($tmp_name,'rb');
// read the file content into a variable
$data = fread($file,filesize($tmp_name));
// close the file
fclose($file);
// now we encode it and split it into acceptable length lines
$data = chunk_split(base64_encode($data));
}
// now we'll insert a boundary to indicate we're starting the attachment
// we have to specify the content type, file name, and disposition as
// an attachment, then add the file content.
// NOTE: we don't set another boundary to indicate that the end of the 
// file has been reached here. we only want one boundary between each file
// we'll add the final one after the loop finishes.
$message .= "--{$mime_boundary}\n" .
"Content-Type: {$type};\n" .
" name=\"{$name}\"\n" .
"Content-Disposition: attachment;\n" .
" filename=\"{$fileatt_name}\"\n" .
"Content-Transfer-Encoding: base64\n\n" .
$data . "\n\n";
}

}

// here's our closing mime boundary that indicates the last of the message
$message.="--{$mime_boundary}--\n";
// now we just send the message
for ($i=0; $i<count($applicant);$i++)
{
	$to=$applicant[$i];
	mail($to,$subject, $message, $headers);
	//echo $to."<br>";
	//echo $message;
}
	
	
	
}
//////////////////////////////////////////////
$imageArray=array(
"images/banner2/JPEG/proposed_final_layout.gif",
"images/banner2/JPEG/125x125_wlogo.jpg",
"images/banner2/JPEG/125x125.jpg",
"images/banner2/JPEG/125x125.jpg",
"images/banner2/JPEG/125x125_wlogo.jpg",
"images/banner2/JPEG/300x250_wlogo.jpg",
"images/banner2/JPEG/468x60.jpg",
"images/banner2/JPEG/468x60_wlogo.jpg",
"images/banner2/JPEG/120x60.jpg",
"images/banner2/JPEG/120x240.jpg",
"images/banner2/JPEG/728x90.jpg",
"images/banner2/JPEG/728x90_wlogo.jpg",
"images/banner2/JPEG/banner_remote1.jpg",
"images/banner2/JPEG/banner_remote1b.jpg",
"images/banner2/JPEG/banner_remote2.jpg",
"images/banner2/JPEG/banner_remote_set2a.jpg",
"images/banner2/JPEG/banner_remote_set2b.jpg",
"images/banner2/JPEG/proposed_final_layout.gif");


for($i=0; $i<count($imageArray);$i++)
{
	if(($img-1)==$i)
	{
		$image= "<img src='$imageArray[$i]' class='img'>";
		$imagelink2="$imageArray[$i]";
		break;
	}
}



?>
<html>
<head>
<title>Business Partner - Marketing</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">


<script type="text/javascript">
<!--
-->
</script>	
<style type="text/css">
<!--
div.scroll {
	height: 100%;
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

.img{
border:#666666 solid 3px;
margin-left:10px;
}
.imglink:hover{
border:#FFFF00 inset 3px;
}
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="marketing2.php" enctype="multipart/form-data" > 
<input type="hidden" name="img" value="<?=$img;?>">
<input type="hidden" name="imagelink2" value="<?=$imagelink2;?>">
<!-- HEADER -->
<? include 'header.php';?>

<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="advertisement.php"><b>Advertisements</b></a></li>
  <li><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
   <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'agentleftnav.php';?>
</td>
<td width=100% valign=top >
<table width=100%  cellspacing=2 cellpadding=2 border=0 align=left >
<tr><td bgcolor="#666666" height="20" colspan=3><font color='#FFFFFF'><b>Marketing</b></font></td></tr>
<tr><td height="51" colspan=3 style="border:#CCCCCC solid 1px;"><font color="#999999"><b>Send Email with Banner Attached :</b></font></td></tr>

<tr><td height="51" colspan=3>
<!--IMAGES HERE -->

<p><?=$image;?></p>
<br>
<br>
<font color='#999999'>
Type multiple email address here separated by (",") comma in sending message to multiple clients.</font>
<p align='center' style='margin-bottom:3px; margin-top:3px;'>
<textarea name='emails' cols='48' rows='5' wrap='physical' class='text'  style='width:85%'></textarea>
</p>
<b>Subject :</b> <font color='#999999'>(Optional)</font>
<p style='margin-bottom:3px; margin-top:3px; margin-left:80px;'><input type="text" name="subject" class="text"></p><br>

<b>Message :</b> <font color='#999999'>(Type your message here)</font>
<p align='center' style='margin-bottom:3px; margin-top:3px;'>
<textarea name='message' cols='48' rows='5' wrap='physical' class='text'  style='width:85%'></textarea>
</p>
<p>Attach File :</b> <input name='logo' type='file' id='logo' class=text > 
&nbsp;<input type='submit' name='send' value='Send Email' class='text' style=' width:150px;'>
</p>


<!-- IMAGES ENDS HERE -->
</td></tr>
</table>





</td>
</tr>
</table>
<!-- LIST HERE --><!-- LIST HERE -->
<? include 'footer.php';?>
</form>	
</body>
</html>
