<?php
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
//Check if the User has upload his Contract...
$sqlCheckContract="SELECT * FROM contract_image WHERE userid = $userid;";
$result_check=mysql_query($sqlCheckContract);
$ctr2=@mysql_num_rows($result_check);
if ($ctr >0 )
{
	// id, userid, image, date_uploaded
	$rowa = mysql_fetch_array ($result_check); 
	$id =$rowa['id'];
	$image =$rowa['image'];
	$date_uploaded =$rowa['date_uploaded'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
	
	<script src="lightbox/js/prototype.js" type="text/javascript"></script>
	<script src="lightbox/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="lightbox/js/lightbox.js" type="text/javascript"></script>



<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<title>My Contract</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link href="css/upload.css" rel="stylesheet" type="text/css" />
 


 
<script language="javascript" type="text/javascript">
<!--
function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
      }
	  else if (success == 2){
         result = '<span class="emsg">File Type Not Allowed!<\/span><br/><br/>';
      }
      else {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" value="Upload" /><\/label>&nbsp;<input type="button" onClick="setRefreshPage();" name="submitBtn" value="Finish" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
}
function setRefreshPage()
{
	top.location='subcon_contract.php';
	var refresh=setInterval('setRefreshPage()',1200);
}
//-->
</script>
<style type="text/css">
<!--
.style2 {
	color: #666666;
	font-weight: bold;
}
.style3 {
	color: #006600;
	font-weight: bold;
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
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Sub-Contractor Contract</b></td></tr>

<tr><td align=right width=30% >&nbsp;</td>

</tr>
<tr>
  <td  width="100%" height="248" valign="top">
  <div id="" style="margin-bottom: 12px; border: 1px solid #abccdd; width: 900px; padding: 8px;">
   <?
   /*
   //Check if the User has upload his Contract...
	$sqlCheckContract="SELECT id, image, date_uploaded, image_path FROM contract_image WHERE userid = $userid;";
	$result_check=mysql_query($sqlCheckContract);
	$ctr2=@mysql_num_rows($result_check);
	if ($ctr2 >0 )
	{
		while(list($id, $image, $date_uploaded, $image_path)=mysql_fetch_array($result_check))
		{
			 echo "<a href='$image_path' rel='lightbox'><img src='$image_path' alt='' width = 100 height = 150 border =0 /></a> &nbsp;";
		}
	
	}
	*/
	?>	
	
	<div id="" style="margin-bottom: 12px; border: 1px solid #abccdd; width: 98%; padding: 8px;">
	<h4>
<script language="JavaScript1.2">

/*
Neon Lights Text
By JavaScript Kit (http://javascriptkit.com)
For this script, TOS, and 100s more DHTML scripts,
Visit http://www.dynamicdrive.com
*/

var message="ATTENTION!"
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
<!--	
	<b>To all RemoteStaff contractors: </b>
	<ul>
	<li> Click <a href="contract_image/INDEPENDENT_CONTRACTOR_AGREEMENT.pdf" target="_blank" class="link20"> HERE </a> to view the Contract.   </li>
	<li>Read, fill out then sign with the date of your official first working day for RemoteStaff. Scan the contract and upload <a href='#' class="style2" onclick='javascript: show_hide("reply_form1");'>HERE</a>. </li>
	<li>For any comments and suggestions, please don’t hesitate to e-mail <a href="mailto:ricag@remotestaff.com.au" class="link15">ricag@remotestaff.com.au</a> </li>
	
	</ul>
	<p>Thanks. Have a fun and productive working day! <br />
<br />

RemoteStaff Team
</p>
-->
<p>Hi <b><?php echo $name;?></b>,</p>
<p>The RemoteStaff Contractor agreement will be revised when needed. </p>
<p>You will be notified via email when revision is made.  </p>
<p>If you have any questions or clarification regarding the revised contract please email <span class="style3">contracts@remotestaff.com.au </span>. </p>
<p>If you don’t agree with the points changed or added please email <span class="style3">contracts@remotestaff.com.au </span> otherwise it will be assumed that you agree and will abide to the agreement changes. </p>

<span class="style2">Remote Staff Management </span></div>
	<div id='reply_form1' style='display:none;'>
	    <div id="content">
                <form action="upload.php" name="form" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                     <p id="f1_upload_process"  style="margin-left:200px;"><br />
<br />
<br />
Loading...<br/><img src="images/loader.gif" /><br/></p>
					 <p>Please Upload Contract Image Here. File types Accepted (".jpg" , ".png" ,".gif")</p>
                     <p id="f1_upload_form" align="center"><br/>
                         <label>File:  
                              <input name="myfile" type="file" size="30" />
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" value="Upload" />
                         </label>
                     </p>
                     
                     <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 </form>
             </div>
	</div>


   
 
</div>
<div>
<object data="./contract_image/INDEPENDENT_CONTRACTOR_AGREEMENT.pdf" type="application/pdf" width="900" height="800">
alt : <a href="./contract_image/INDEPENDENT_CONTRACTOR_AGREEMENT.pdf">INDEPENDENT_CONTRACTOR_AGREEMENT.pdf</a>
</object>
</div>

<div class="clear"></div>
  </td>
</tr>
</table>

  

</td>
</tr>
</table>

</body>
</html>
