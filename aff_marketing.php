<?php 
/*
2010-06-24 Normaneil Macutay <normanm@remotestaff.com.au>
- change the url 'philippinesatwork' to remotestaff
- php long tag
- Zend_DB coding

*/

include './conf/zend_smarty_conf_root.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}

$sql=$db->select()
	->from('agent')
	->where('agent_no = ?' , $agent_no);
	
$row = $db->fetchRow($sql);	
$name = $row['fname']." ".$row['lname'];
$agent_code = $row['agent_code'];
$agent_email = $row['email'];
$length=strlen($agent_code);
	


$site = $_SERVER['HTTP_HOST'];

?>
<html>
<head>
<title>Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<link rel=stylesheet type=text/css href="css/marketing_gallery.css">

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
	
<script src="lightbox/js/prototype.js" type="text/javascript"></script>
<script src="lightbox/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
<script src="lightbox/js/lightbox.js" type="text/javascript"></script>
<script language=javascript src="js/functions.js"></script>
	
</head>
<!-- background:#E7F0F5; -->
<body style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="affHome.php">
<table width="1055" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td width="999"><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top"><?php include 'aff_header_menu.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">
<script language="JavaScript1.2">

/*
Neon Lights Text
By JavaScript Kit (http://javascriptkit.com)
For this script, TOS, and 100s more DHTML scripts,
Visit http://www.dynamicdrive.com
*/

var message="Affiliate System"
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
</h3>
<div class="welcome">
Welcome <?php echo $name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<div id="page_desc">Copy &amp; Paste the code to your Website, Blogs, Facebook, etc..</div>
<table width="100%">
<tr>
<td width="230px" valign="top"><?php include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">
<table width="99%" style="border: #A4D1FF solid 3px;">
<tr>
<td >
<div class="img_container" style="width:800px;" align="center" >
<div style="font:bold 18pt Arial; color:#0000FF; text-align:center;">
  RemoteStaff Enquiry Form
</div>
<div class="view">
<textarea style="width:98%;">
<iframe id="frame" name="frame" src="http://remoteStaff.com.au/affiliate_leftpanel.php?booking_code=<?php echo $agent_code;?>"  frameborder="0" width="250px;" height="1000px;" scrolling="">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
</textarea></div>
</div></td>
</tr>
<tr>
<td valign="top">
<div class="img_container" style="width:160px; height:220px;">
<center>
<img src="images/banner2/JPEG/125x125_wlogo.jpg" title="Remotestaff.com.au" border="0" >
</center>
<div class="view">
<textarea style="width:98%;">
<span style="margin:10px; padding:5px;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/125x125_wlogo.jpg" title="Remotestaff.com.au" border="0" >
</a>
</span>
</textarea>
</div>
</div>
<div class="img_container" style="width:160px; height:220px;">
<center>
  <img src="images/banner2/JPEG/125x125.jpg" alt="Image 3" >
</center>
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/125x125.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

<div class="img_container" style="width:160px; height:220px;">
<center>
<img src="images/banner2/JPEG/120x60.jpg" alt="Image 4" >
</center>
<div style="clear:both;">&nbsp;</div>
<div style="clear:both;">&nbsp;</div>
<div style="clear:both;">&nbsp;</div>
<div style="clear:both;">&nbsp;</div>
<div style="clear:both;">&nbsp;</div>
<div class="view" >
<textarea style="width:98%; ">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/120x60.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea></div>
</div>

<div class="img_container" style="width:150px;" >
<center>
  <img src="images/banner2/JPEG/120x240.jpg" alt="Image 5"  >
</center>
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/120x240.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea></div>
</div>


</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td valign="top">
<div style="width:300px; border:#CCCCCC solid 1px; padding:5px; float:left;">
<center>
<img src="images/banner2/JPEG/300x250_wlogo.jpg"  ></center>
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/300x250_wlogo.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

<div style="width:470px; border:#CCCCCC solid 1px; padding:5px; float:left;">
<img src="images/banner2/JPEG/468x60.jpg"   >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/468x60.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>
<br>
<br>

<div style="width:470px; border:#CCCCCC solid 1px; padding:5px; float:left; margin-top:20px;">
<img src="images/banner2/JPEG/468x60_wlogo.jpg"   >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/468x60_wlogo.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td valign="top" >
<div class="img_container" style="width:650px;" >
<img src="images/banner2/JPEG/728x90.jpg"  width="645" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/728x90.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td valign="top">
<div class="img_container" style="width:650px;" >
<img src="images/banner2/JPEG/728x90_wlogo.jpg"  width="645" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/728x90_wlogo.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td valign="top">
<div class="img_container" style="width:300px;" >
<img src="images/banner2/JPEG/banner_remote1.jpg" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/banner_remote1.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

<div class="img_container" style="width:300px;" >
<img src="images/banner2/JPEG/banner_remote1b.jpg" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/banner_remote1b.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>
</td>
</tr>
<tr><td><div class="img_container" style="width:300px;" >
<img src="images/banner2/JPEG/banner_remote2.jpg" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/banner_remote2.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

<div class="img_container" style="width:300px;" >
<img src="images/banner2/JPEG/banner_remote_set2a.jpg" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/banner_remote_set2a.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><div class="img_container" style="width:300px;" >
<img src="images/banner2/JPEG/banner_remote_set2b.jpg" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/banner_remote_set2b.jpg" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div>

<div class="img_container" style="width:300px;" >
<img src="images/banner2/JPEG/proposed_final_layout.gif" >
<div class="view">
<textarea style="width:98%;">
<a href='http://<?php echo $site;?>/<?php echo $agent_code?>' target="_blank">
<img src="http://<?php echo $site;?>/portal/images/banner2/JPEG/proposed_final_layout.gif" title="Remotestaff.com.au" border="0" >
</a>
</textarea>
</div>
</div></td></tr>
<tr><td>&nbsp;</td></tr>
</table>

  <p style="margin-top:20px; margin-left:10px;">Your promotional code is : <font color="#999999"><b><? echo $agent_code;?></b></font></p></td>
</tr>
</table>


<!-- Contents Here -->
</td>
</tr>
<tr><td><?php include 'footer.php';?></td></tr>
</table>
</form>	
</body>
</html>



