<?php
include './conf/zend_smarty_conf.php';
if($_SESSION['userid']=="")
{
	header("location:index.php");
	exit;
}
header("location:/portal/django/bulletin_board/message_board/");
exit;


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
	$name =$row['fname']." ".$row['lname'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>RemoteStaff Bulletin Board</title>
<link rel=stylesheet type=text/css href="css/font.css">

 


 
<style type="text/css">
<!--
.style2 {
	color: #006600;
	font-weight: bold;
	text-decoration:none;
}
-->
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
<tr>
  <td  width="100%" height="248" valign="top">
  <div id="" style=" border: 1px solid #abccdd; width: 99%; padding: 8px; background-color:#F2F2F2;">

	<h4>
<script language="JavaScript1.2">

/*
Neon Lights Text
By JavaScript Kit (http://javascriptkit.com)
For this script, TOS, and 100s more DHTML scripts,
Visit http://www.dynamicdrive.com
*/

var message="REMOTESTAFF BULLETIN BOARD!"
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
<!-- contents here -->
<style>
<!--
.newsletter{ border: 1px solid #abccdd; width: 98%;  background-color:#FFFFFF;padding:10px 10px 10px 10px; margin-bottom:20px;}
-->
</style>
<?
// id, admin_id, topic, contents, date_created, status
$sql="SELECT id , contents, DATE_FORMAT(date_created,'%D %b %Y') FROM subcon_updates ORDER BY date_created DESC;";
$result=mysql_query($sql);
$counter=0;
while(list($id, $contents ,$date_created)=mysql_fetch_array($result))
{
	$counter++;
?>
<div  class="newsletter">
<div style="text-align:right; color:#333333"><?=$date_created;?></div>
<? echo $contents;;?>
</div>
<? }?>
<!-- ends here -->

	


   
 
</div>
<div class="clear"></div>
  </td>
</tr>
</table>

  

</td>
</tr>
</table>
<? include 'footer.php';?>
</body>
</html>
