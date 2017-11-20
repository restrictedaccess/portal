<?php
include 'config.php';
include 'conf.php';
include 'time.php';

if($_SESSION['userid']=="")
{
	header("location:index.php");
}

$userid = $_SESSION['userid'];

$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['fname']."  ".$row['lname'];
}

?>

<html>
<head>
<title>Sub-Contractor Testimonials</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="testimonials/testi.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="testimonials/testi.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="hidden" name="userid" id="userid" value="<?=$userid;?>">
<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" height="502" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="170" height="502" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?></td>
<td width="1064" valign="top" style=" font:12px Arial;">
<div class="testi_hdr" ><b>Testimonials</b></div>
<div style="text-align:right; padding:5px;"><a style="text-decoration:none;" href="javascript:show_hide_blog_request_form('blog_request');"><span id="close_form">[close]</span></a></div>
<div id="blog_request" style="padding:20px; text-align:justify; border-bottom:#333333 solid 1px; display:block; background:#FFFFFF;">
Dear <?=$name;?>,<br>
<br>


 

You have been servicing our client for over a month now. We’re curious to hear your experience. We wanna know how’s it been since you started working from home freeing yourself from the hassle of office bound career. <br>
<br>
 

We wanna know the story. How you found RemoteStaff and your experience throughout the application process. <br>
<br>
 

How’s your first week sitting on your own working with a team half way around the world from you? Did you feel welcome and part of their in-house local team? Are you involved on the day to day business activities and do you feel like you have performed well and helped them out? What is your day to day activity as a remote contractor for your client ?<br>
<br>


What have you learned from this experience? What did you HAVE to learn to perform well on this post? Have you learned anything from your client? From Google?  Or from Remote Staff admin team? Do you like what you’ve learned?
<br>
<br>

As much as we all love (well, I do and majority of the people I know) working from home. There are also some challenges and hoops on this kind of set up. What have you experienced so far and what actions have you undertaken get through these challenges?
<br>
<br>

Please share your experience. We would appreciate it along with clients and applicants considering to join the company. 
<br>
<br>

Please fill out the box below with a blog like testimonial. Please note that this testimonial will go live on our website. 
<br>
<br>

(PS: For staff who have been with us for over a month only. But if you're new and you really really wanna be heard, go ahead say something. ) 
</div>
<div id="staff_testimonial_section"></div>
</td>
</tr>
</table>
<script type="text/javascript">
<!--
getStaffClient();
-->
</script>
<? include 'footer.php';?>
</form>
</body>
</html>
