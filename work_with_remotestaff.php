<?
//2009-09-14    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Updated videoFile location
include 'config.php';
include 'conf.php';
include 'function.php';
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>
	
	<!-- 
		include flashembed - which is a general purpose tool for 
		inserting Flash on your page. Following line is required.
	-->
	<script type="text/javascript" src="swf/flashembed.min.js"></script>
	<script type="text/javascript">
	 /*
		use flashembed to place flowplayer into HTML element 
		whose id is "example" (below this script tag)
	 */
	 flashembed("player", 
	
		/* 
			first argument supplies standard Flash parameters. See full list:
			http://kb.adobe.com/selfservice/viewContent.do?externalId=tn_12701
		*/
		{
			src:'swf/FlowPlayerDark.swf',
			 width: 852,
        	 height:480 
		},
		
		/*
			second argument is Flowplayer specific configuration. See full list:
			http://flowplayer.org/player/configuration.html
		*/
		{config: {   
			autoPlay: false,
			autoBuffering: true,
			controlBarBackgroundColor:'0x2e8860',
			initialScale: 'scale',
			videoFile: 'http://www.remotestaff.com.au/portal/swf/work_with_remotestaff.flv'
		}} 
	);
	</script>	

	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td colspan="2"><img src='images/space.gif' width=1 height=10></td>
</tr>
<tr>
<td width="14%" height="176" bgcolor="#ffffff"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'clientleftnav.php';?>
<br>
</td>
<td width="100%" valign="top" align="center">
<h6 align="left">1. <img src="images/iconTV.gif" alt="view video" align="absmiddle"> <a href="work_with_remotestaff.php" class="link20">Working with Remotestaff</a> | 2. <img src="images/iconTV.gif" alt="view video" align="absmiddle"> <a href="googledocstutorial.php" class="link20">Google Docs Tutorial</a>  | 3. <img src="images/iconTV.gif" alt="view video" align="absmiddle"> <a href="yuugututorial.php" class="link20">Yuugu Tutorial</a></h6>

<h4>How to Use Remotestaff Sub-Contractor System</h4>

<div class="clear"></div>

<div id="player">If there's no video on the screen. Please try to Refresh(F5) your Page....</div>

<div class="clear"></div>
</td>
</table>
<? include 'footer.php';?>

</body>
</html>