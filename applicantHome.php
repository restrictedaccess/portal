<?php
include('conf/zend_smarty_conf.php') ;
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
require_once "recruiter/util/HTMLUtil.php";

if(isset($_REQUEST['k']))
{
	if($_REQUEST['k']!="")
	{
		
		$retries = 0;
		while(true){
			try{
				if (TEST) {
					$mongo = new MongoClient(MONGODB_TEST);
				} else {
					$mongo = new MongoClient(MONGODB_SERVER);
				}
				
				
				$database = $mongo -> selectDB('sessions');
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}	
		
		$session_collection = $database -> selectCollection("sessions");
		$key = $_REQUEST["k"];
	
		$cursor = $session_collection -> find(array("_id" => new MongoId($key)));
		while ($cursor -> hasNext()) {
			$session_data = $cursor -> getNext();
			$_SESSION = $session_data["SESSION"];
			break;
		}
	}
}
	
	
if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}
header("Location:/portal/jobseeker/");


$userid = $_SESSION['userid'];
//echo $userid;
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$server_time =date('jS \of F Y ');

$emailaddr = $_SESSION['emailaddr'];

if(@isset($_POST["upload_file"]))
{
            if(basename($_FILES['fileimg']['name']) != NULL || basename($_FILES['fileimg']['name']) != "")
            {
                $file_description = $_POST["file_description"];
                $date_created = $AusDate;

                $name = $userid."_".basename($_FILES['fileimg']['name']);
                $name = str_replace(" ", "_", $name);
                $name = str_replace("'", "", $name);
                $name = str_replace("-", "_", $name);
                $name = str_replace("#", "", $name);
                $name = str_replace("php", "php.txt", $name);                                
                
                $file = "applicants_files/".$userid."_".basename($_FILES['fileimg']['name']);
                $file = str_replace(" ", "_", $file);
                $file = str_replace("'", "", $file);
                $file = str_replace("-", "_", $file);        
                $file = str_replace("#", "", $file);        
                $file = str_replace("php", "php.txt", $file);        
                
                
                $result= move_uploaded_file($_FILES['fileimg']['tmp_name'],$file);
                if (!$result)
                {
                    echo '
                    <script language="javascript">
                        alert("Error uploading file, file type is not allowed.");
                    </script>
                    ';
                }
                else
                {
                    $filename_ = "applicants_files/".$userid."_".basename($_FILES['fileimg']['name']);
                    $file_p = pathinfo($filename_);
                    extract(pathinfo($filename_));
                    chmod($filename_, 0777);
                    mysql_query("INSERT INTO tb_applicant_files(userid, file_description, name, date_created) VALUES('$userid', '$file_description', '$name', '$date_created')");
                    echo '
                    <script language="javascript">
                        alert("File uploaded.");
                    </script>                        
                    ';                    
                }
            }
}










/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality
*/
$query="SELECT lname, fname, email, handphone_country_code, handphone_no, tel_area_code, tel_no, image,DATE_FORMAT(dateupdated,'%D %b %Y'),DATE_FORMAT(datecreated,'%D %b %Y'),voice_path FROM personal WHERE userid=$userid";
//echo $query;
$result=mysql_query($query);
list($lname, $fname, $email, $handphone_country_code, $handphone_no, $tel_area_code, $tel_no, $image, $dateupdated,$datecreated,$voice_path) = mysql_fetch_array ($result); 
$name =$fname."  ".$lname;
$email=$email;
$mobile=$handphone_country_code.$handphone_no;
$tel=$handphone_country_code."-".$tel_area_code.$tel_no;
$image=$image;

if($image=="")
{
    $image="images/Client.png";
}

$_SESSION['txtname'] = $name;

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
    echo("<html><head><script>function update(){top.location='applicantHome.php';}var refresh=setInterval('update()',1500);
    </script></head><body onload=refresh><body></html>");
    
}

if(isset($_POST['upload']))
{
    $uploadDir = 'uploads/pics/'; 
    //temporary name of image
    $tmpName     = $_FILES['img']['tmp_name']; 
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
            $sql="DELETE FROM users WHERE userid =$userid";
            mysql_query($sql);
            exit; 
        } 
        else 
        { 
            imageResize($uploadDir.$userid.$imgtype,200,200);
            $sql2="UPDATE personal SET image='$uploadDir$userid$imgtype' , dateupdated = '$ATZ' WHERE userid=$userid";
            mysql_query($sql2);
            echo("<html><head><script>function update(){top.location='applicantHome.php';}var refresh=setInterval('update()',1500);
    </script></head><body onload=refresh><body></html>");
      
        } 
    }    
}
////
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
        elseif($soundtype=="audio/mpeg3") 
        { 
            $soundtype=".mp3"; 
        } 
	     else if ($soundtype=="audio/mp3"){
	      $soundtype=".mp3"; 	
	    }
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
            ?>
            <script type="text/javascript">
	            alert("Voice has been uploaded.");
	            window.location="/portal/applicantHome.php";
            </script>
            <?php
            	/* 
                echo("<html><head><script>function update(){top.location='applicantHome.php';}var refresh=setInterval('update()',1500);
    </script></head><body onload=refresh><body></html>");
    			*/
	          if (($soundtype==".wma")||$soundtype==".wav"){
		      	$util = new HTMLUtil();
		      	$util->convert($userid, "");	
		      }
        } 
}
?>

<html>
<head>
<title>Applicant Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
    toggle(element);
}
-->
</script>
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
<form name="form" method="post" action ="applicantHome.php" enctype="multipart/form-data" >
<input type="hidden" name="userid" value="<? echo $userid?>">

<!-- HEADER -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remote-staff-logo.jpg" alt="think" width="484" height="89"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<ul class="glossymenu">
	<li class="current"><a href="applicantHome.php"><b>Home</b></a></li>
	<li ><a href="/portal/personal/myresume.php"><b>MyResume</b></a></li>
	<li><a href="myapplications.php"><b>Applications</b></a></li>
	<li><a href="jobs.php"><b>Search Jobs</b></a></li>
	<?php $hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ), 2, 17 ); ?>
    <li><a href="javascript:popup_win8('rschat.php?portal=1&email=<?php echo $emailaddr ?>&hash=<?php echo $hash_code ?>',800,600);" title="Open remostaff chat"><b>RSChat</b></a></li>
	<li><a href="applicant_test.php"><b>Take a Test</b></a></li>
</ul>


<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?> this is your personal page</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="100%" height="108" valign="top">
<div style=" margin-left:50px; margin-right:50px; margin-top:50px; border:#FFFFFF solid 1px;">
 <table cellpadding="0" cellspacing="0" border="0" width="1220">
        <tr><td width="823" bgcolor="#ffffff" align="center">
            <table width="823" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr><td width="823">
<table border='0' width='100%' align='center'>
 <tr>
    <td width="309" valign='top'><table border='0' width='274' align='center' valign='top'>
    <tr>
   <td width='268' valign='top'><table cellSpacing='0' cellPadding='0' width='100%' border='0'><tr bgColor='#c0e0f5'><td align='center' height='20'><b>My Resume Status</b></td></tr></table><table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'><tr><td><table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'><tr><td height="70" valign="top"><table cellspacing='0' cellpadding='4' width='100%' border='0'><tr valign=bottom><td>Online Resume last updated since<br><font color=red><b><?=$dateupdated;?></b></font></td><td><a href='#'><img src='images/update.gif' align='bottom' border='0' alt='Update Resume' /></a></td></tr></table></td></tr></table></td></tr></table><br><table cellSpacing='0' cellPadding='0' width='100%' border='0'><tr bgColor='#c0e0f5'><td align='middle' height='20'><b>My Application Status</b></td></tr></table><table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'><tr><td><table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'><tr><td height="50">
  
  <table cellspacing='0' cellpadding='4' width='100%' border='0'>
  <tr><td><a class='t3' href='myapplications.php'>Applications</a></td><td>: 
  <?
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
  
  </td></tr></table></td></tr></table><br><table cellSpacing='0' cellPadding='0' width='100%' border='0'><tr bgColor='#c0e0f5'><td align='center' height='20'><b>Control Panel</b></td></tr></table><table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'><tr><td><table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'><tr><td height="97"><? include 'applicantleftnav.php';?></td></tr></table></td></tr></table></td></tr></table></td>
    
  <td width='17' background='images/dot.gif' rowspan='2' style='background-repeat:repeat-y;'>&nbsp;</td><td width='483' valign='top' rowspan='2'>
 <div class="album">
<div  style="float:left;"><img src='<?=$image;?>' height="200" width="176"><br />
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
<?
if ($voice_path!="") 
{ 
?>

<small>Audio Attachments</small><br>
 <br />
<div id="player">
	
	<?php if( substr($voice_path, 0, 7) == 'uploads' ):?>
	<object type="application/x-shockwave-flash" data="/audio_player/player_mp3_maxi.swf" width="260" height="30">
        <param name="movie" value="/audio_player/player_mp3_maxi.swf" />
         <param name="FlashVars" value="mp3=<?php echo '/portal/'.$voice_path;?>" />
    </object>
	<?php else:?>
    <object type="application/x-shockwave-flash" data="/audio_player/player_flv_maxi.swf" width="260" height="30">
        <param name="movie" value="/audio_player/player_flv_maxi.swf" />
         <param name="FlashVars" value="flv=<?=$voice_path?>" />
    </object>
	<?php endif;?>
</div>
<br> 
<?
} else { echo "<small>No Audio Attachements</small>"; }
?>
</div>
<p style="clear: both; "></p>
</div>
 <p style="clear: both; "></p>
     <table border="0">
        <tr>
            <td>
            <div style="background-color:#c0e0f5 ; padding: 5px 5px 5px 5px;">
            <p style="float:left; margin-top:2px; margin-bottom:2px;">
                        <p>Dear <? echo $name;?>, </p>
                        <p>You are now steps away from having a professional and rewarding career from home. </p>
                        <p>Please note the following: </p>
                        <table width="100%" border="0">
                          <tr>
                            <td valign="top">1.</td>
                            <td width="100%">Be as detailed as you can with your resume. This will allow the RemoteStaff recruiter to easily assess your qualification and match you to post matching your skills and background. </td>
                          </tr>
                          <tr>
                            <td valign="top">2.</td>
                            <td>Attach sample work. Attaching sample work will speed up your application process as we will be able to assess your talent, skills and sophistication at a first glance. You can attach: sample written materials/content, sample design portfolio, sample source code etc. which ever is relevant to the position you are applying for. </td>
                          </tr>
                        </table>
                        <p>TELEMARKETERS : If you are applying for a telemarketing or any phone based position be sure to attach a very good voice recording introducing yourself and summary of your past work experiences. The recording should not be longer than 3 minutes. </p>
                        <p>You can also use a spiel or a call flow you are used to as a sample work. Live recording from previous campaigns handled will also be a very good form of work sample. </p>
                        <table width="100%" border="0">
                          <tr>
                            <td valign="top">3.</td>
                            <td width="100%">Upload a voice introduction. Indicating your name and a quick summary of your work experiences. The voice recording should not last more than 3 minutes and should be in English. We only hire people who can communicate and understand verbal and written English. You <strong>don't </strong> need to sound American or Australian or have any specific accent. What is important is to have a clear, easily understood voice with no noise background. </td>
                          </tr>
                          <tr>
                            <td valign="top">4.</td>
                            <td>Please read out current contract <strong><a href="http://www.remotestaff.com.au/portal/contract_image/INDEPENDENT_CONTRACTOR_AGREEMENT.pdf" target="_blank">HERE</a> </strong>. This will give you a more detailed idea on how RemoteStaff works along with our Rules and Regulations. It is important that you know this from the very beginning. </td>
                          </tr>
                        </table>
                        <p>Should you have any questions, please don't hesitate to contact us at <a href="mailto:recruitment@remotestaff.com.au">recruitment@remotestaff.com.au </a></p>

            </p>
             </div>             
            </td>
        </tr>
        <tr>
            <td>
            <div style="background-color:#c0e0f5 ; height:20px; padding: 5px 5px 5px 5px;">
            <p style="float:left; margin-top:2px; margin-bottom:2px;">
            <b>Add Voice, Files, Resume....</b> </p>
            <p style="float:right;margin-top:2px; margin-bottom:2px;">Click <a href='javascript: show_hide("add_sound_control");' class="link5" >HERE</a></p>
             </div>
             
              <div id="add_sound_control" style=" display:none; height:400px;border: 5px solid #c0e0f5;">
             <p style="text-align:right; margin-right:10px; margin-bottom:2px;"><a href='javascript: show_hide("add_sound_control");' class="link5">[X]</a></p>
             <p style="margin-right:10px; margin-bottom:2px; margin-top:2px; color:#9A5201; font-weight:bold;">File type/size allowed (".mp3",".wma",".wav",".doc",".pdf") upload limit per file is 5 MB</p>
             
                 <table>
                    <tr>
                        <td>
                                <table cellspacing=1 cellpadding=3 width=100%>
                                            <tr>
                                                <td><b>Upload File / Resume</b></td>
                                            </tr>                
                                            <tr>
                                                <td><font color='#000000'>File Description</font></td>
                                            </tr>        
                                            <tr>
                                                <td>
                                                <select name="file_description">
                                                    <option value="Resume" selected>Resume</option>
                                                    <option value="Sample Work">Sample Work</option>
                                                    <option value="Other">Other</option>
                                                </select>                                                
                                               </td>
                                            </tr>
                                            <tr>
                                                <td><font color='#000000'>File</font></td>
                                            </tr>            
                                            <tr>
                                                <td><input type="file" name="fileimg" value="" size="35" />    </td>
                                            </tr>
                                            <tr>
                                                <td><input type="submit" value="Upload File" name="upload_file"></td>
                                            </tr>            
                                </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <table cellspacing=1 cellpadding=3 width=100%>
                                            <tr>
                                                <td><br /><b>Add Voice to your Resume....</b></td>
                                            </tr>                
                                            <tr>
                                                <td>
                                                    <FONT size="1">
                                                    Voice recording should be: <BR />
                                                    <em>
                                                    Size: Equal or less than 2000kb in size<BR />
                                                    Format: WAV, Mpeg, WMA, MP3 <BR />
                                                    Length: Should be equal or less than 3 minutes<BR />
                                                    Content: Quick voice resume. Introduction and summary of experience         <BR />
                                                    </em></FONT>                                                
                                                    <input type="file" name="sound_file" id="sound_file">
                                                    <input type="submit" name="sound_btn" id="sound_btn" value="upload">
                                                </td>
                                            </tr>
                                </table>        
                        </td>
                    </tr>
                 </table>
             </div>                
            </td>
        </tr>
    </table>





    

 
 </td></tr></table></td>
                </tr>
            </table>
        </td>
        <td width="397" valign="top">
        " <strong>We're on Facebook! To get updated with our urgent job openings via Faceboook please LIKE US at  <a href="http://www.facebook.com/Remotestaff" target="_blank">http://www.facebook.com/Remotestaff</a></strong> "<br><br>
        <fb:like-box href="http://www.facebook.com/pages/Remote-Staff-wwwremotestaffcomau/186026291427516" width="380" height="600" show_faces="true" stream="false" header="false"></fb:like-box>
        </td>
        </tr>
    </table>
</div>



</td>
</tr>
</table>


<? include 'footer.php';?>
</form>
</body>
</html>