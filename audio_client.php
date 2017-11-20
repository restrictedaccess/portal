<?php
/* ah_rschat.php  // 2011-02-11 */
session_start();
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$hostname = 'http://'.$_SERVER['HTTP_HOST'];

if (isset($_POST['login'])) $login = $_POST['login']; elseif (isset($_GET['login'])) $login = $_GET['login']; else $login = "";
//if (isset($_POST['chatid'])) $chatid = $_POST['chatid']; elseif (isset($_GET['chatid'])) $chatid = $_GET['chatid']; else $chatid = "";
if (isset($_POST['email'])) $email = $_POST['email']; elseif (isset($_GET['email'])) $email = $_GET['email']; else $email = "";
if( !empty($_SESSION['userid']) )
   $chatid = $_SESSION['userid'] . 'js';
else {
   echo "<script language='javascript'>alert('Session expired!');</script>";
   exit;
}
?>

<html lang="en">
   <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <!--  BEGIN Browser History required section -->
	  <!--<link rel="stylesheet" type="text/css" href="/portal/history/history.css" />-->
<!--  END Browser History required section -->
<title>RS Voice Recording</title>
<script src="/portal/AC_OETags.js" language="javascript"></script>
<!--  BEGIN Browser History required section -->
<!--<script src="/portal/history/history.js" language="javascript"></script>-->
<!--  END Browser History required section -->
<!--<script src="js/cbox.js" type="text/javascript"></script>-->
<style>
body { margin: 0px; overflow:hidden }
</style>
<script language="JavaScript" type="text/javascript">
<!--
// -----------------------------------------------------------------------------
// Globals
// Major version of Flash required
var requiredMajorVersion = 10;
// Minor version of Flash required
var requiredMinorVersion = 3;
// Minor version of Flash required
var requiredRevision = 0;


function enableSaveVR() {
   window.parent.enablesavevr();
}
var appName = 'audio_client';

// -----------------------------------------------------------------------------
// -->
</script>
   </head>
<body scroll="no">
   <script language="JavaScript" type="text/javascript">
   <!--
   // Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
 var hasProductInstall = DetectFlashVer(6, 0, 65);
 // Version check based upon the values defined in globals
var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
if ( hasProductInstall && !hasRequestedVersion ) {
   // DO NOT MODIFY THE FOLLOWING FOUR LINES
   // Location visited after installation is complete if installation is required
   var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
   var MMredirectURL = window.location;
   document.title = document.title.slice(0, 47) + " - Flash Player Installation";
   var MMdoctitle = document.title;
   AC_FL_RunContent(
		"src", "http://vps01.remotestaff.biz:5080/remote/livechat/playerProductInstall",
		"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
		"width", "100%",
		"height", "100%",
		"align", "middle",
		"id", "audio_client",
		"quality", "high",
		"bgcolor", "#869ca7",
		"name", "audio_client",
		"allowScriptAccess","always",
		"type", "application/x-shockwave-flash",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
   );
   //show_flashApp();
   
} else if (hasRequestedVersion) {
   // if we've detected an acceptable version
   // embed the Flash Content SWF when all tests are passed
   AC_FL_RunContent(
	"src", "http://vps01.remotestaff.biz:5080/remote/livechat/audio_client",
	"width", "100%",
	"height", "100%",
	"align", "middle",
	"id", "audio_client",
	"quality", "high",
	"bgcolor", "#869ca7",
	"name", "audio_client",
	"flashvars", "<?php echo 'emailaddr='.$email.'&logintype='.$login.'&hostname='.$hostname.'&chatid='.$chatid; ?>",
	"allowScriptAccess","always",
	"type", "application/x-shockwave-flash",
	"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
   //window.parent.preloading();
} else {  // flash is too old or we can't detect the plugin
   var alternateContent =
   "<\?xml version=\"1.0\" encoding=\"UTF-8\"?>"
   + "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">"
+ "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">"
+ "<head><title>Remotestaff Chat</title></head>"
+ "<body  style='margin-left:auto;margin-right:auto'>"
+ "<div id='content' style='width:95%;float:left;margin:10px;font-size:12px;'>"
+ "The RSChat uses Adobe Flash for its voice chat and other interfaces.<br/>Get Flash Player for free <a href='http://www.adobe.com/go/getflash/' target='_blank'>HERE.</a><br/><br/>"
+ "If you don't wish to do this, please call us on our numbers below or quickly fill out the inquiry"
+ "form <a href='/contactus.php' target='_blank'>HERE.</a> <br/> We will get back to you within 24 business hours."
+ "<p>Australia: 1-300-733-430</p><p>"
+ "United Kingdom: +44 209-386-9010</p>"
+ "USA: 1-800-760-5113<p>"
+ "Or call us from anywhere at +61 3 9017 2828</p>"
+ "</div></body></html>";

    document.write(alternateContent);  // insert non-flash content
	
	//show_flashApp();
}
// -->
</script>
   <noscript>
	  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
		 id="audio_client" width="100%" height="100%"
		 codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
		 <param name="movie" value="http://vps01.remotestaff.biz:5080/remote/livechat/audio_client.swf" />
		 <param name="quality" value="high" />
		 <param name="bgcolor" value="#869ca7" />
		 <param name="allowScriptAccess" value="always" />
		 <param name="wmode" value="transparent" />
		 <param name="flashvars" value="<?php echo 'emailaddr='.$email.'&logintype='.$login.'&hostname='.$hostname.'&chatid='.$chatid; ?>" />
		 <embed src="http://vps01.remotestaff.biz:5080/remote/livechat/audio_client.swf" flashvars="<?php echo 'emailaddr='.$email.'&logintype='.$login.'&hostname='.$hostname.'&chatid='.$chatid; ?>"
			quality="high" bgcolor="#869ca7"
			width="100%" height="100%" name="audio_client" align="middle"
			play="true"
			loop="false"
			quality="high"
			allowScriptAccess="always"
			type="application/x-shockwave-flash"
			pluginspage="http://www.adobe.com/go/getflashplayer">
		</embed>
	  </object>
   </noscript>
</body>
</html>
