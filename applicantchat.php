<?php
/* applicantview.php  // 2010-08-19 */

include './conf/zend_smarty_conf_root.php';
//$userid = $_SESSION['userid'];
//echo $userid;
$logintype = '';
$emailaddr = '';

if (isset($_POST['portal'])) $link = $_POST['portal']; elseif (isset($_GET['portal'])) $link = $_GET['portal']; else $link = "";
if (isset($_POST['email'])) $email = $_POST['email']; elseif (isset($_GET['email'])) $email = $_GET['email']; else $email = "";

//if($_SESSION['firstrun']=="" || $link=="1")
//{
	$logintype = $_SESSION['logintype'];
    $emailaddr = $_SESSION['emailaddr'];
	$txtname = $_SESSION['txtname'];
//}
//if (!$logintype || !$emailaddr || !$email) {
if (($logintype && $emailaddr) && ($emailaddr !== $email)) {
	echo "<script>alert('Auto-login aborted, conflict details found.');</script>";
	$emailaddr = '';
}
?>

<!-- saved from url=(0014)about:internet -->
<html lang="en">

<!-- 
Smart developers always View Source. 

This application was built using Adobe Flex, an open source framework
for building rich Internet applications that get delivered via the
Flash Player or to desktops via Adobe AIR. 

Learn more about Flex at http://flex.org 
// -->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--  BEGIN Browser History required section -->
<link rel="stylesheet" type="text/css" href="history/history.css" />
<!--  END Browser History required section -->

<title></title>
<script src="AC_OETags.js" language="javascript"></script>

<!--  BEGIN Browser History required section -->
<script src="history/history.js" language="javascript"></script>
<!--  END Browser History required section -->

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
var requiredMinorVersion = 0;
// Minor version of Flash required
var requiredRevision = 0;
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
		"src", "http://vps01.remotestaff.biz:5080/remote/beta/playerProductInstall",
		"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
		"width", "100%",
		"height", "100%",
		"align", "middle",
		"id", "aschat",
		"quality", "high",
		"bgcolor", "#869ca7",
		"name", "aschat",
		"allowScriptAccess","sameDomain",
		"type", "application/x-shockwave-flash",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
} else if (hasRequestedVersion) {
	// if we've detected an acceptable version
	// embed the Flash Content SWF when all tests are passed
	AC_FL_RunContent(
			"src", "http://vps01.remotestaff.biz:5080/remote/beta/aschat",
			"width", "100%",
			"height", "100%",
			"align", "middle",
			"id", "aschat",
			"quality", "high",
			"bgcolor", "#869ca7",
			"name", "aschat",
            "flashvars", "emailaddr=<?php echo $emailaddr ?>&logintype=<?php echo $logintype ?>&txtname=<?php echo $txtname ?>",
			"allowScriptAccess","always",
			"type", "application/x-shockwave-flash",
			"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
  } else {  // flash is too old or we can't detect the plugin
    var alternateContent = 'Alternate HTML content should be placed here. '
  	+ 'This content requires the Adobe Flash Player. '
   	+ '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
    document.write(alternateContent);  // insert non-flash content
  }
// -->
</script>
<noscript>
  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="aschat" width="100%" height="100%"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="http://vps01.remotestaff.biz:5080/remote/beta/aschat.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#869ca7" />
			<param name="allowScriptAccess" value="always" />
            <param name="flashvars" value="emailaddr=<?php echo $emailaddr ?>&logintype=<?php echo $logintype ?>&txtname=<?php echo $txtname ?>" />

			<embed src="http://vps01.remotestaff.biz:5080/remote/beta/aschat.swf" flashvars="emailaddr=<?php echo $emailaddr ?>&logintype=<?php echo $logintype ?>&txtname=<?php echo $txtname ?>"
                quality="high" bgcolor="#869ca7"
				width="100%" height="100%" name="aschat" align="middle"
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
<?php
 //$_SESSION['firstrun'] = "chat autologin";
?>
