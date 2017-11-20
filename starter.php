<?php
// 2009-09-14 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   changed location of the videoFile
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

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language=javascript src="js/timer.js"></script>
<script src="swf/flashembed.min.js"></script>
<script>
    flashembed("screen_cast", {src:'swf/FlowPlayerDark.swf',
        width: 852,
        height:480 
    }, 
        {config: {
            autoPlay: false,
            autoBuffering: true,
            controlBarBackgroundColor: '0x2e8860',
            videoFile: 'http://www.remotestaff.com.au/portal/swf/subcon_screen_cast.flv',
            initialScale: 'scale',
            splashImageFile: 'swf/splashImage.jpg'
    }})
</script>
<style type-"text/css">
@import url(scm_tab/scm_tab.css);
#leftbox{float:left; width:350px; margin-bottom:20px; margin-top:20px; padding-bottom:10px; border:#FFFFFF solid 1px;}
#leftbox p {margin-top:5px; margin-bottom:7px;}
#rightbox{float:right; width:400px; margin-bottom:20px; margin-top:20px; padding-bottom:10px; border:#FFFFFF solid 1px;}
#rightbox p {margin-top:5px; margin-bottom:7px;}
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
  <div id="" style="margin-bottom: 12px; border: 1px solid #abccdd; width: 80%; padding: 8px;">
    <b>Welcome to Think Innovations and Remote Staff!</b><br>

<p>
As a member of remotestaff.com.au you agree to be contracted under Think Innovations, an Australian company that has been in operation since Sept 2000. Once contracted, Think Innovations will be sub-contracting you to Australian clients so as to provide you continued work. </p>
<p>
Think Innovations is a company that serves as a bridge to connect Australian employers and Filipino professionals working from home online. We will set you up with all the internet tools you need to get work started, on top of that, we will also give you an Australian phone number and a soft phone to download onto your computer. </p>

<ul>
  <strong>This welcome guide will help you: </strong>
  <li>Create an understanding of remote staffing and working from home.</li>
	<li>Build a foundation of skills and competencies: customer service, teamwork, leadership, and communication - in each employee.</li>
	<li>Simplify and shorten the new employee’s learning curve so that s/he becomes more efficient in performing tasks.</li>
	<li>Instill staff dedication and loyalty to Think Innovations.  </li>
	<li>Increase staff retention by ensuring a better fit between employee expectations and Think Innovations culture.</li>
	<li>Promote awareness and commitment.</li>
</ul>
Think Innovations will provide with you with the right tools and help you develop adequate skills to compete in the international workplace.

<DIV>
<div id="leftbox" >
<p><a href="welcomekit.php" class="link15">Welcome Kit</a></p>
<p><a href="company_rules.php" class="link15">Company Rules</a></p>
<p><a href="hr_policies.php" class="link15">HR Policies</a></p>
<p><a href="downloads/Welcom Kit.rar" target="_blank" class="link15">Download</a> the <a href="downloads/WelcomeKit.pdf" target="_blank" class="link20">Welcome Kit</a></p>

</div>
<div id="rightbox" >
<p><a href="googletutorial.php" class="link15">Google Docs Tutorial</a></p>
<p><a href="skype_rules.php" class="link15">Skype Tutorial</a></p>
<p><a href="australia.php" class="link15">More About Australia</a></p>
</div>






<div class="clear"></div>
</DIV>
</div>
<div class="clear"></div>

<div id="screen_cast"></div>

<div class="clear"></div>

 <div id="" style="margin-top: 12px; margin-bottom: 12px; border: 1px solid #abccdd; width: 80%; padding: 8px;">
<b>Message from the Director:</b>
<p>
We are all contracted to Think Innovations but sub contracted to Think Innovations clients. What this means is that you will be working in different companies on different teams that may be in totally different industries. All of this doesn’t matter because we are all working together on the same team under Think Innovations.
 </p>
<p>
We can all keep in touch with skype and improve our skills and abilities by benchmarking each other from fellow Think Innovations colleges. 
</p>
<p>
Also, if in anyway something doesn’t work out between you and the clients, it’s in Think Innovations interested to work it out for you and to keep you employed as long as we possibly can.  We do this by keeping both you as the contractor and the client happy and working efficiently together.</p>
<p>
All the best regards<br>
<br>



<b>Chris Jankulovski</b><br>

Director of<br>

Think Innovations Pty Ltd & <br>

Remote Staff<br>

</p>





 
 <p></p>
 </div>

</td>
</tr>
</table>

  

</td>
</tr>
</table>

</body>
</html>
