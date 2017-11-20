<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'time_recording/TimeRecording.php';

    /**
     *
     * extends TimeRecording class
     *
     */
    class SubconStatus extends TimeRecording {
        /**
        *
        *   returns a string indicating status of the subcontractor
        */
        function GetStatus() {
            if ($this->buttons['lunch_end']) {
                return "Out to lunch.";
            }
            if ($this->buttons['work_start']) {
                //return "Not working.";
        return "Finish Work.";
            }
            else {
                return "Working.&nbsp;<img src='images/onlinenowFINAL.gif' alt='working'>";
            }
        }
    }

if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}    
    
$userid = $_SESSION['userid'];
//echo $userid;
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$server_time =date('jS \of F Y ');

/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality
*/
$query="SELECT lname, fname, email, handphone_country_code, handphone_no, tel_area_code, tel_no, image,DATE_FORMAT(dateupdated,'%D %b %Y'),DATE_FORMAT(datecreated,'%D %b %Y'), payment_details,voice_path FROM personal WHERE userid=$userid";
//echo $query;
$result=mysql_query($query);
list($lname, $fname, $email, $handphone_country_code, $handphone_no, $tel_area_code, $tel_no, $image, $dateupdated,$datecreated,$payment_details,$voice_path) = mysql_fetch_array ($result); 
$name =$fname."  ".$lname;
$email=$email;
$mobile=$handphone_country_code.$handphone_no;
$tel=$handphone_country_code."-".$tel_area_code.$tel_no;
$image=$image;

$payment_details=str_replace("\r\n","<br>",$payment_details);

if($image=="")
{
  $image="images/Client.png";
}
  

$email2=$_REQUEST['email'];
$handphone_country_code2 =$_REQUEST['handphone_country_code'];
$mobile2=$_REQUEST['mobile'];
$area_code2=$_REQUEST['area_code'];
$tel2=$_REQUEST['tel'];
/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality
*/
if(isset($_POST['update']))
{
  $sql="UPDATE personal SET email = '$email2' ,handphone_country_code = '$handphone_country_code2' , handphone_no = '$mobile2', tel_area_code = '$area_code2' , tel_no = '$tel2' , dateupdated = '$ATZ' WHERE  userid= $userid;";
  //echo $sql;
  
  mysql_query($sql)or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());  
  echo("<html><head><script>function update(){top.location='subcon_account_settings.php';}var refresh=setInterval('update()',1500);
  </script></head><body onload=refresh><body></html>");
  
}

if(isset($_POST['upload']))
{
  $uploadDir = 'uploads/pics/'; 
  //temporary name of image
  $tmpName   = $_FILES['img']['tmp_name']; 
  $img = $_FILES['img']['name']; 
  $imgsize= $_FILES['img']['size']; 
  $imgtype = $_FILES['img']['type'];
  //check extension of image
  if($img != '')
  {  
    if($imgtype=="image/pjpeg") 
    { 
      $imgtype=".jpg"; 
    } 
    elseif($imgtype=="image/jpeg") 
    { 
      $imgtype=".jpg"; 
    } 
    elseif($imgtype=="image/gif") 
    { 
      $imgtype=".gif"; 
    } 
    elseif($imgtype=="image/png") 
    { 
      $imgtype=".png"; 
    } 
    else 
    { 
      echo "Error uploading file, file type is not allowed"; 
      exit; 
    } 
  }
  
  if ($img != '')
  {
    $result= move_uploaded_file($tmpName, $uploadDir.$userid.$imgtype); 
    if (!$result) 
    { 
      echo "Error uploading file"; 
      //mysql_query("DELETE FROM users WHERE userid =$userid"); 
      //$sql="DELETE FROM users WHERE userid =$userid";
      //mysql_query($sql);
      exit; 
    } 
    else 
    { 
      $sql2="UPDATE personal SET image='$uploadDir$userid$imgtype' , dateupdated = '$ATZ' WHERE userid=$userid";
      mysql_query($sql2);
      echo("<html><head><script>function update(){top.location='subcon_account_settings.php';}var refresh=setInterval('update()',1500);
  </script></head><body onload=refresh><body></html>");
    
    } 
  }
  
  //echo $img;  
}

if(isset($_POST['sound_btn']))
{
  $uploadDir = 'uploads/voice/'; 
  $tmpName = $_FILES['sound_file']['tmp_name']; 
  $sound = $_FILES['sound_file']['name']; 
  $soundsize= $_FILES['sound_file']['size']; 
  $soundtype = $_FILES['sound_file']['type'];
  
  //echo $sound."<br>".$soundtype."<br>";
  if($sound != '')
  {
    if($soundtype=="audio/x-ms-wma") 
    { 
      $soundtype=".wma"; 
    } 
    elseif($soundtype=="audio/wav") 
    { 
      $soundtype=".wav"; 
    } 
    elseif($soundtype=="audio/mpeg") 
    { 
      $soundtype=".mp3"; 
    }
    elseif($soundtype=="application/octet-stream") 
    { 
      $soundtype=".mp3"; 
    } 
    //
    else 
    { 
      echo "Error uploading file, file type is not allowed<br>"; 
      echo $sound."<br>";
      echo $soundtype."<br>";
      exit; 
    } 
    //echo $soundtype."<br>";
  }
  
  $result= move_uploaded_file($tmpName, $uploadDir.$userid.$soundtype); 
  if (!$result) 
    { 
      echo "Error uploading file"; 
      //mysql_query("DELETE FROM users WHERE userid =$userid"); 
      //$sql="DELETE FROM users WHERE userid =$userid";
      //mysql_query($sql);
      exit; 
    } 
    else 
    { 
      $sql2="UPDATE personal SET voice_path='$uploadDir$userid$soundtype' , dateupdated = '$ATZ' WHERE userid=$userid";
      mysql_query($sql2);
      echo("<html><head><script>function update(){top.location='subcon_account_settings.php';}var refresh=setInterval('update()',1500);
  </script></head><body onload=refresh><body></html>");
    
    } 
  
}
?>

<html>
<head>
<title>Sub-Contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
  toggle(element);
}
-->
</script>
<script type='text/javascript' language='JavaScript' src='audio_player/audio-player.js'></script>
<style>
<!--
body {
  font: normal 70%/200% "Verdana", "Lucida Grande";
  color:#0033FF;
}
.album {
  margin-top:0px;
  margin-left:10px;
  padding-bottom:10px;
  padding-left:10px;
  padding-right:10px;
  padding-top:10px;
  
  border: 8px solid #E7F0F5;
  background: #F7F9FD;
    line-height: 100%;
}
.album a img {  }
.album .thumb {
    float: left; 
    margin-right: 6px;
}
.album h3 {
  padding: 0;
  margin: 0;
}
.album p {
  line-height: 12px;
  font-size: 11px;
    padding: 4px 0px 0px;
    margin: 0px;
}
.albumdesc{
  height: 150px;
  float:left; margin-left:5px; width:250px;
}
.albumdesc small {
  color: #8DB8CF;
}
-->
</style>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action ="subcon_account_settings.php" enctype="multipart/form-data" >
<input type="hidden" name="userid" value="<?php  echo $userid?>">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
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
<ul class="glossymenu">
 <li class="current"><a href="subconHome.php"><b>Home</b></a></li>
  <li ><a href="subcon_myresume.php"><b>MyResume</b></a></li>
  <li><a href="subcon_myapplications.php"><b>Applications</b></a></li>
   <li><a href="subcon_jobs.php"><b>Search Jobs</b></a></li>
</ul>


<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <?php  echo $name;?> this is your personal page</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="100%" height="108" valign="top">
<div style=" margin-left:50px; margin-right:50px; margin-top:50px; border:#FFFFFF solid 1px;">
 <table cellpadding="0" cellspacing="0" border="0" width="897">
    <tr><td width="897" bgcolor="#ffffff" align="center">
      <table width="823" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr><td width="823">
<table border='0' width='100%' align='center'>
 <tr>
    <td width="309" valign='top'><table border='0' width='274' align='center' valign='top'>
    <tr>
   <td width='268' valign='top'><table cellSpacing='0' cellPadding='0' width='100%' border='0'><tr bgColor='#c0e0f5'><td align='center' height='20'><b>My Resume Status</b></td></tr></table><table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'><tr><td><table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'><tr><td height="112"><table cellspacing='0' cellpadding='4' width='100%' border='0'><tr valign=bottom><td>Online Resume last updated since<br>
     <font color=red><b><?php echo $dateupdated;?></b></font></td>
  </tr><tr valign=bottom><td>Online Resume has been viewed<br> 0 time(s)</td></tr></table></td></tr></table></td></tr></table><br><table cellSpacing='0' cellPadding='0' width='100%' border='0'><tr bgColor='#c0e0f5'><td align='middle' height='20'><b>My Application Status</b></td></tr></table><table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'><tr><td><table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'><tr><td height="50">
  
  <table cellspacing='0' cellpadding='4' width='100%' border='0'>
  <tr><td><a class='t3' href='subcon_myapplications.php'>Applications</a></td><td>: 
  <?php
  $sql = "SELECT COUNT(a.id)
FROM applicants a
JOIN posting p ON p.id = a.posting_id
WHERE a.userid= $userid
AND a.status <>'Sub-Contracted'
AND p.status ='ACTIVE'";
$res=mysql_query($sql);
list($no)=mysql_fetch_array($res);
echo "<b>".$no."</b>";

  ?>
  </td></tr>
  </table>
  
  </td></tr></table></td></tr></table><br><table cellSpacing='0' cellPadding='0' width='100%' border='0'><tr bgColor='#c0e0f5'><td align='center' height='20'><b>Control Panel</b></td></tr></table><table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'><tr><td><table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'><tr><td height="97"><?php include 'subcon_leftnav.php';?></td></tr></table></td></tr></table></td></tr></table></td>
    
  <td width='17' background='images/dot.gif'  style='background-repeat:repeat-y;'>&nbsp;</td><td width='500' valign='top' >
  
<div class="album">
<div  style="float:left;"><img src='./tools/staff_image.php?w=176&id=<?php echo $_SESSION['userid'];?>'><br />

</div>
<div  class="albumdesc">
<small><a href='javascript: show_hide("change_picture");' class="link5"  >Change Picture</a></small><br>
<small>&nbsp;</small>
<div id="change_picture" style="display:none; height:100px;  margin-top:0px; margin-left:10PX;  border: 5px solid #c0e0f5; padding-bottom:10px; padding-top:10px; padding-left:5px;">
<p style="text-align:right; margin-right:10px; margin-bottom:2px;"><a href='javascript: show_hide("change_picture");' class="link5">[X]</a></p>
<br />
<small>File type allowed (".jpg",".png",".gif") only...</small>
<p>
<input type="file" name="img" id="img" style="">
<input type="submit" name="upload" id="upload" value="upload"></p>
</div>
<?php
if ($voice_path!="") 
{ //echo $voice_path;
?>

<small>Audio Attachments</small><br>
 <br />

<?php
} else { echo "<small>No Audio Attachements</small>"; }
?>

<?php
$subcon_status = new SubconStatus($userid);
echo "<p>".$subcon_status->GetStatus()."</p>";
?>
</div>
<p style="clear: both; "></p>
</div>
 <p style="clear: both; "></p>
 
<div style="background-color:#c0e0f5 ; height:20px; padding: 5px 5px 5px 5px; margin-left:10PX; margin-top:20px; ">
<p style="float:left; margin-top:2px; margin-bottom:2px;">
<b>Add Voice to your Resume....</b> </p>
<p style="float:right;margin-top:2px; margin-bottom:2px;">Click <a href='javascript: show_hide("add_sound_control");' class="link5" >HERE</a></p>
 </div>
 
  <div id="add_sound_control" style=" display:none; height:80px;  margin-top:0px; margin-left:10PX; border: 5px solid #c0e0f5; padding-bottom:10px; padding-top:10px; padding-left:40px;">
 <p style="text-align:right; margin-right:10px; margin-bottom:2px;"><a href='javascript: show_hide("add_sound_control");' class="link5">[X]</a></p>
 <p style="margin-right:10px; margin-bottom:2px; margin-top:2px; color:#9A5201; font-weight:bold;">File type allowed (".mp3",".wma",".wav") only...</p>
 
<input type="file" name="sound_file" id="sound_file">
<input type="submit" name="sound_btn" id="sound_btn" value="upload">
 </div>
 <!--
<div style="background-color:#D9AC51 ; height:20px; margin-left:10PX; margin-top:20px;color:#FFFFCC; font-weight:bold; padding-left:20px; padding-top:10px; padding-bottom:5px; ">
Payment Details
</div>

<div style=" margin-bottom: 12px; margin-left:10PX; margin-top:0px; border: 8px solid #D9AC51; padding-left:10px; padding-top:10px; ">
<?php
if ($payment_details!="") 
{
  echo $payment_details;
  echo "<p>&nbsp;</p>
    <p>Incorrect Information Click <a href='subcon_payment_details.php' class='link20'>HERE</a></p>";
}
else
{
?>
<h4>
<script language="JavaScript1.2">

/*
Neon Lights Text
By JavaScript Kit (http://javascriptkit.com)
For this script, TOS, and 100s more DHTML scripts,
Visit http://www.dynamicdrive.com
*/

var message="YOU HAVE NO PAYMENT DETAILS !"
var neonbasecolor="black"
var neontextcolor="red"
var flashspeed=100  //in milliseconds

///No need to edit below this line/////

var n=0
if (document.all||document.getElementById){
document.write('<font color="'+neonbasecolor+'">')
for (m=0;m<message.length;m++)
document.write('<span id="neonlight'+m+'">'+message.charAt(m)+'</span>')
document.write('</font>')
}
else
document.write(message)

function crossref(number){
var crossobj=document.all? eval("document.all.neonlight"+number) : document.getElementById("neonlight"+number)
return crossobj
}

function neon(){

//Change all letters to base color
if (n==0){
for (m=0;m<message.length;m++)
//eval("document.all.neonlight"+m).style.color=neonbasecolor
crossref(m).style.color=neonbasecolor
}

//cycle through and change individual letters to neon color
crossref(n).style.color=neontextcolor

if (n<message.length-1)
n++
else{
n=0
clearInterval(flashing)
setTimeout("beginneon()",1500)
return
}
}

function beginneon(){
if (document.all||document.getElementById)
flashing=setInterval("neon()",flashspeed)
}
beginneon()


</script>
</h4>
<p>Click <a href='subcon_payment_details.php?edit=TRUE' class='link20'>HERE</a></p>
<?php  
}
?>
</div>
-->
 </td></tr></table></td>
        </tr>
      </table>
    </td></tr>
  </table>
</div>



</td>
</tr>
</table>


<?php include 'footer.php';?>
</form>
</body>
</html>
