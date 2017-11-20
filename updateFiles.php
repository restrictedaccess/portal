<?php
putenv("TZ=Australia/Sydney");
include('conf/zend_smarty_conf.php') ;
include 'config.php';
include 'function.php';
include 'conf.php';
require_once "recruiter/util/HTMLUtil.php";

if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}

//$userid=$_GET['userid'];
$userid=$_SESSION['userid'];
$id=$_SESSION['userid'];



if($_SESSION['userid']=="")
{
  echo '
  <script language="javascript">
    alert("Session expired.");
  </script>
  ';
  header("location:http:index.php");
}

$voice = "";
if( isset($_POST['action']) && $_POST['action'] == 'upload' ){
	$result = file_get_contents("http://vps01.remotestaff.biz:5080/remote/user_stream.jsp?cid=".$userid."js");
	$result = json_encode($result);
	$result = preg_replace('/[\\\n|\\\"|\[|\]]*/', "", $result);
	//$raw_array = str_replace("\n", "", $raw_array);
	$raw_array = explode(',', $result);
	if( count($raw_array) > 1 && (int)$raw_array[1] > 0 ) {
		$voice="http://vps01.remotestaff.biz:5080/remote/audio/".$raw_array[0];
	}
	
	$sql2="UPDATE personal SET voice_path='$voice' , dateupdated = '$ATZ' WHERE userid=$userid";
      mysql_query($sql2);
}

if(@isset($_POST["upload_file"]))
{
      if(basename($_FILES['fileimg']['name']) != NULL || basename($_FILES['fileimg']['name']) != "")
      {
        $file_description = $_POST["file_description"];
        $AusTime = date("h:i:s"); 
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		$date = $ATZ;
        
        $date_created = $AusDate;
        $name = $id."_".basename($_FILES['fileimg']['name']);
        
        $name = str_replace(" ", "_", $name);
        $name = str_replace("'", "", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("php", "php.txt", $name);
        
        if (preg_match("/^.*\.(jpg|jpeg|png|gif|pdf|doc|docx|php|ppt|pptx|xls|xlsx|txt|php|html|rb|py|)$/i", $name)){
        	$filesize = filesize($_FILES['fileimg']['tmp_name']);
        	$file_mb = round(($filesize / 1048576), 2);
        	if ($file_mb<=10){
        		mysql_query("INSERT INTO tb_applicant_files(userid, file_description, name, permission, date_created) VALUES('$id', '$file_description', '$name', 'ALL', '$date_created')");
		        $file = "applicants_files/".$id."_".basename($_FILES['fileimg']['name']);
		        $file = str_replace(" ", "_", $file);
		        $file = str_replace("'", "", $file);
		        $file = str_replace("-", "_", $file); 
		        $file = str_replace("py", "py.txt", $file);       
		        $file = str_replace("php", "php.txt", $file);
		        $file = str_replace("html", "html.txt", $file);		        
		        if (move_uploaded_file($_FILES['fileimg']['tmp_name'],$file)) 
		        {
		          $filename_ = "applicants_files/".$id."_".basename($_FILES['fileimg']['name']);
		          $filename_ = str_replace(" ", "_", $filename_);
		          $filename_ = str_replace("'", "", $filename_);
		          $filename_ = str_replace("-", "_", $filename_);  
		          $filename_ = str_replace("php", "php.txt", $filename_);                
		          $file_p = pathinfo($filename_);
		          extract(pathinfo($filename_));
		          chmod($filename_, 0777);
		        }
        	}else{
        		?>
        	<script language="javascript">
		        alert("Error uploading file, file exceeded 5 MB.");
		      </script>  
        	<?php 
        	}
        	

        }
      }
}
elseif(isset($_POST['sound_btn']))
{
  $userid = $_GET["userid"];
  $uploadDir = 'uploads/voice/'; 
  $tmpName = $_FILES['sound_file']['tmp_name']; 
  $sound = $_FILES['sound_file']['name']; 
  $soundsize= $_FILES['sound_file']['size']; 
  $soundtype = $_FILES['sound_file']['type'];
	
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
    else if ($soundtype=="audio/mp3"){
      $soundtype=".mp3"; 	
    }
    else 
    { 
?>      
      <script language="javascript">
        alert("Error uploading file, file type is not allowed.");
      </script>    
<?php        
      exit; 
    } 
  }
  
  $result= move_uploaded_file($tmpName, $uploadDir.$id.$soundtype); 
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
      $sql2="UPDATE personal SET voice_path='$uploadDir$id$soundtype' , dateupdated = '$ATZ' WHERE userid=$id";
      mysql_query($sql2);
      
      
      if (($soundtype==".wma")||$soundtype==".wav"){
      	$util = new HTMLUtil();
      	$util->convert($id, "");	
      }
?>
      <script language="javascript">
        alert("Voice has been uploaded.");
        window.location="/portal/applicantHome.php";
      </script>
<?php  
    
    } 
  
}


if(@isset($_GET["delete"]))
{
  $name = @$_GET["delete"];
  mysql_query("DELETE FROM tb_applicant_files WHERE name='$name'");  
  $name = basename($name);
  unlink("applicants_files/".$_GET["delete"]);
}

$query="SELECT voice_path FROM personal p  WHERE p.userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
  $row = mysql_fetch_array ($result); 
  $voice_path = $row['voice_path'];
}
//ENDED

?>

<html>
<head>
<title>My Files</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<script language=javascript src="js/util.js"></script>
<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/java.js"></script>
<script language=javascript src="js/activeX.js"></script>
<script language=javascript src="js/aj_ptitle_spe.js"></script>
<script language=javascript src="js/jquery.js"></script>
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#sound_btn").click(function(){
			jQuery("#from_button").val("sound");
		});
		jQuery("#uploader").submit(function(){
			if (jQuery("#from_button").val()=="sound"){
				if (jQuery("#sound_file").val()==""){
					alert("No file has been selected");
					return false;
				}
				jQuery("#from_button").val("");
			}
		});
		jQuery('div#vrwin').jqm();
	});
function enablesavevr(cid) {
	jQuery("input#savevr").removeAttr("disabled");
}
</script>
<style type="text/css">
.jqmWindow {
    display: none;   
    position: fixed;
	top: 17%;left: 50%;
    margin-left: -300px;
	
    background-color: #EEE;
    color: #333;
    border: 1px solid black;
    padding: 12px;
	width:600px;padding:12px;
	border:1px solid #ff9900;
	text-align:center;
}

.jqmOverlay { background-color: #000; }

* html .jqmWindow {
     position: absolute;
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}
</style>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
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
<ul class="glossymenu">
 <li ><a href="applicantHome.php"><b>Home</b></a></li>
  <li class="current"><a href="/portal/personal/myresume.php"><b>MyResume</b></a></li>
  <li><a href="myapplications.php"><b>Applications</b></a></li>
  <li><a href="jobs.php"><b>Search Jobs</b></a></li>
</ul>

<!-- header -->
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>
</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'applicantleftnav.php';?>

</td>
<td width=566 valign=top align=right><img src='images/space.gif' width=1 height=10><br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<tr>
  <td>
  
  
  
  <table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
  <tr>
    <td width=100>











<!-------- content ------------->
<form action="" method="post" enctype="multipart/form-data" id="uploader">
<table>
<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Voice</b>
    </div>    
  </td>
</tr>

<tr><td colspan=2 >

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr>
  <td width="50%" valign="top">
    <table cellspacing=1 cellpadding=3 width=100% >
      <tr>
        <td><font color='#000000'><b>Voice Recorded</b></font></td>
      </tr>
      <tr>
        <td>
          <?php
		  if ($voice_path != "") {
			if( substr($voice_path, 0, 7) == 'uploads' ):?>
			<div id="player">
			<object type="application/x-shockwave-flash" data="/audio_player/player_mp3_maxi.swf" width="200" height="30">
            <param name="movie" value="/audio_player/player_mp3_maxi.swf" />
			<param name="allowScriptAccess" value="always" />
            <param name="FlashVars" value="mp3=/portal/<?php echo $voice_path;?>" />
			</object>
			</div>
			<br>
			<?php else:?>
			<div id="player">
			<object type="application/x-shockwave-flash" data="/audio_player/player_flv_maxi.swf" width="200" height="30">
            <param name="movie" value="/audio_player/player_flv_maxi.swf" />
			<param name="allowScriptAccess" value="always" />
            <param name="FlashVars" value="flv=<?php echo $voice_path;?>" />
			</object>
			</div>
			<?php endif;
			
		  } else  echo 'No voice file was found.';?>
        </td>
      </tr>
	  <!--<tr>
        <td valign='bottom'>
		<input type="button" name="sound_btn" id="sound_btn" class="jqModal" value="Record your voice">
		</td>
		</tr>-->
	  
    </table>
  </td>
  <td valign="top" width="50%">
	<form name="upload" action="" method="post" enctype="multipart/form-data" id="uploader">
    <table cellspacing=1 cellpadding=3 width=100%>
      <tr>
        <td>
          <font color='#000000'><b>Voice</b><br />
          <i>
			Voice recording should be:<br />
Size: Equal or less than 5000kb in size<br />
Format: WAV, Mpeg, WMA, MP3<br />
<!--Voice recording should be:<br />-->
Length: Should be equal or less than 3 minutes<br />
Content: Quick voice resume. Introduction and summary of experience
          </i>
          </font>
        </td>
      </tr>
	  
      <tr>
        <td><input type="file" name="sound_file" id="sound_file"></td>
      </tr>
	  <tr>
		<td><input type="submit" name="sound_btn" id="sound_btn" value="upload">
		<input type="hidden" id="from_button"/> &nbsp; or &nbsp;
		<input type="button" name="sound_btn" id="sound_btn" class="jqModal" value="Record your voice"></td>
	  </tr>
           <!--<input type="submit" name="sound_btn" id="sound_btn" value="save">-->
    </table>
    </form>
  </td>
</tr>
<!--<tr>
  <td valign="top" width="100%" colspan="2">
    <table cellspacing=1 cellpadding=3 width=100%>
		<tr >
						<td style="text-align:center;">
							<iframe id='vrframe' frameborder='0' scrolling='no'
							src='/portal/audio_client.php?login=jobseeker&email=<?php echo $_SESSION['emailaddr'];?>'
							style='width:100%;height:150px;'></iframe>
						</td>											
					</tr>
		 <tr>
        <td align="right">
		<input id='savevr' type='button' onclick="document.upload.submit();" value='update' disabled='disabled'/>
        <input type="hidden" id="from_button"/></td>
      </tr>
	</table>
  </td>
  </tr>-->
</table>





<tr>
  <td width=100% colspan=2>
    <div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
      <b>Files</b>
    </div>    
  </td>
</tr>

<tr><td colspan=2 >

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
<tr>
  <td width="50%" valign="top">
    <table cellspacing=1 cellpadding=3 width=100% >
      <tr>
        <td><font color='#000000'><b>Files Uploaded</b></font></td>
      </tr>
      <?php
        $c = mysql_query("SELECT * FROM tb_applicant_files WHERE userid='$userid' AND permission='ALL'");  
        while ($row = @mysql_fetch_assoc($c)) 
        {    
      ?>                    
      <tr>
        <td>
          <?php 
            if($row["file_description"] != "" || $row["file_description"] != NULL)
            {
              echo "<a href='?delete=".$row['name']."'><img src='images/delete.png' border=0></a>&nbsp;&nbsp;".$row["file_description"].":&nbsp;<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$row["name"]."</a></i>"; 
            }
            else
            {
              echo "<a href='?delete=".$row['name']."'><img src='images/delete.png' border=0></a> "."<i>".$row["name"]."</i>"; 
            }
          ?>
        </td>
      </tr>
      <?php
        }
      ?>
    </table>
  </td>
  <td valign="top" width="50%">
    <table cellspacing=1 cellpadding=3 width=100%>
      <tr>
        <td><font color='#000000'><b>File Type</b> <font color="#666666"><em>(doc, pdf or image format - Upload limit per file is 5 MB)</em></font></font></td>
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
        <td><font color='#000000'><b>File</b></font></td>
      </tr>      
      <tr>
        <td><input type="file" name="fileimg" value="" size="35" />  </td>
      </tr>
      <tr>
        <td><input type="submit" value="Upload File" name="upload_file"></td>
      </tr>      
    </table>
    
  </td>
</tr>
</table>
</form>




<!-------- ended --------------->



      </td>
    </tr>
  </table>




</td></tr></table>
        </td></tr>
      </table>
    </td></tr>
</table>

<div class='jqmWindow' id='vrwin'>
	<span id='log_testname'>Voice Recording</span>
	<a href='#' class='jqmClose' style='float:right'>Close</a><hr>
	<form name="upload" action="" method="post" enctype="multipart/form-data" id="uploader">
	<input type="hidden" id="action" name="action" value="upload"/>
	<table cellspacing="1" cellpadding="3" width="100%">
		<tr >
			<td style="text-align:center;">
			<iframe id='vrframe' frameborder='0' scrolling='no'
			src='/portal/audio_client.php?login=jobseeker&email=<?php echo $_SESSION['emailaddr'];?>'
			style='width:100%;height:150px;'></iframe>
			</td>											
		</tr>
		<tr>
			<td align='left'>
				Click on Record button above.
				State your first name and a quick introduction on your work experiences and skills.
				The recording should not last more than 2 minutes. You can re-do your voice recording until you are satisfied.
				Click Sync to finally upload your voice recording. The voice recording is important to identify your level of spoken English.
				DO NOT RECORD ANY CONTACT DETAILS.  
			</td>
		</tr>
		<tr>
        <td align="right"><!--<input type="submit" name="sound_btn" id="sound_btn" value="save">-->
		<input id='savevr' type='button' onclick="document.upload.submit();" value='Sync' disabled='disabled'/>
        <input type="hidden" id="from_button"/></td>
      </tr>
	</table>
	</form>
	
</div>

<? include 'footer.php'?>
</body>
</html>
