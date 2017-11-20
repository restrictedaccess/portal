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
	$name =$row['lname']."  ,".$row['fname'];
}

?>

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language=javascript src="js/timer.js"></script>
<script src="selectImage.js"></script>
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
   <? include 'subconleftnav.php';?></td>
<td width="1081" valign="top" align="">
<div id="" style="margin-bottom: 12px; width: 100%; padding: 8px;">
   <p><b>COMPANY RULES</b></p>
   <p><b>1. <a href="#" onClick="setPicture('1')">Rules</a> | 2. <a href="#" onClick="setPicture('2')">Skype Response</a> | 3. <a href="#" onClick="setPicture('3')">Screen Share</a> | 4. <a href="#" onClick="setPicture('4')">Lunch Breaks</a> | 5. <a href="#" onClick="setPicture('5')">Overtime</a> | 6. <a href="#" onClick="setPicture('6')">Holiday</a> | 7. <a href="#" onClick="setPicture('7')">Timesheets</a> | 8. <a href="#" onClick="setPicture('8')">Screen Capture</a> | 9. <a href="#" onClick="setPicture('9')">Absences</a></b></p>
   <p style="color:#999999"><a href="company_rules.php" style="color:#999999;">Slideshow</a></p>
   </div>
<div id="ad">
<SCRIPT language=JavaScript> 
<!-- // BannerAD 
var bannerAD=new Array(); 
var bannerADlink=new Array(); 
var adNum=0; 

bannerAD[0]="images/company_rules/1.png"; 
bannerADlink[0]="#"; 
bannerAD[1]="images/company_rules/1.png"; 
bannerADlink[1]="#"; 
bannerAD[2]="images/company_rules/2.png"; 
bannerADlink[2]="#"; 
bannerAD[3]="images/company_rules/3.png"; 
bannerADlink[3]="#"; 
bannerAD[4]="images/company_rules/4.png"; 
bannerADlink[4]="#"; 
bannerAD[5]="images/company_rules/5.png"; 
bannerADlink[5]="#"; 
bannerAD[6]="images/company_rules/6.png"; 
bannerADlink[6]="#"; 
bannerAD[7]="images/company_rules/7.png"; 
bannerADlink[7]="#"; 
bannerAD[8]="images/company_rules/8.png"; 
bannerADlink[8]="#"; 
bannerAD[9]="images/company_rules/9.png"; 
bannerADlink[8]="#"; 


var preloadedimages=new Array(); 
for (i=1;i<bannerAD.length;i++){ 
preloadedimages[i]=new Image(); 
preloadedimages[i].src=bannerAD[i]; 
} 

function setTransition(){ 
if (document.all){ 
bannerADrotator.filters.revealTrans.Transition=Math.floor(Math.random()*23); 
bannerADrotator.filters.revealTrans.apply(); 
} 
} 

function playTransition(){ 
if (document.all) 
bannerADrotator.filters.revealTrans.play() 
} 

function nextAd(){ 
if(adNum<bannerAD.length-1)adNum++ ; 
else adNum=0; 
setTransition(); 
document.images.bannerADrotator.src=bannerAD[adNum]; 
playTransition(); 
theTimer=setTimeout("nextAd()", 4000); 
} 

function jump2url(){ 
jumpUrl=bannerADlink[adNum]; 
jumpTarget='_blank'; 
if (jumpUrl != ''){ 
if (jumpTarget != '')window.open(jumpUrl,jumpTarget); 
else location.href=jumpUrl; 
} 
} 
function displayStatusMsg() { 
status=bannerADlink[adNum]; 
document.returnValue = true; 
} 

//--> 
</SCRIPT> 

<center>
<img style="FILTER: revealTrans(duration=2,transition=20); border:#0000FF outset 2px;" src="images/company_rules/1.png" width="936" height="697" name=bannerADrotator 
id=bannerADrotator></center>
<SCRIPT language=JavaScript>nextAd()</SCRIPT> 
</div>

</td>
</tr>
</table>

</body>
</html>
