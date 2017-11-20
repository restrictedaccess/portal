<?php
//  2009-09-14  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Updated videoFile location
include 'config.php';
include 'conf.php';
include 'time.php';
$userid = $_SESSION['userid'];

$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['lname']."  ,".$row['fname'];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
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
			videoFile: 'http://www.remotestaff.com.au/portal/swf/GoogleDocsTutorials2.flv'
		}} 
	);
	</script>	



<script language=javascript src="js/timer.js"></script>
<style type-"text/css">
@import url(scm_tab/scm_tab.css);
</style>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?>
</td>
<td width="1081" valign="top">
  <table width=100%  cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Sub-Contractor Starter Kit</b></td></tr>

<tr><td align=right width=30% >&nbsp;</td>

</tr>
<tr>
  <td  width="100%" height="248" valign="top">
<div id="" style="margin-bottom: 12px; border: 1px solid #abccdd; width: 900px; padding: 8px;">
<p><b>GOOGLE DOCS TUTOTRIAL</b></p>
<p style=" color:#999999">You must have a Gmail email Account</p>
<div class="clear"></div>
<div id="player"></div>
<div class="clear"></div>
<div class="clear"></div>
</div>
  </td>
</tr>
</table>

  

</td>
</tr>
</table>

</body>
</html>
