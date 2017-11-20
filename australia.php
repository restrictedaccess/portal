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
<style type="text/css">

.gallerycontroller{
width: 250px
}

.gallerycontent{
width: 936px;
height: 697px;
border: 1px solid black;
background-color: #DFDFFF;
padding: 3px;
display: block;
}

</style>

<script type="text/javascript">

/***********************************************
* Advanced Gallery script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice must stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var tickspeed=5000 //ticker speed in miliseconds (2000=2 seconds)
var displaymode="auto" //displaymode ("auto" or "manual"). No need to modify as form at the bottom will control it, unless you wish to remove form.

if (document.getElementById){
document.write('<style type="text/css">\n')
document.write('.gallerycontent{display:none;}\n')
document.write('</style>\n')
}

var selectedDiv=0
var totalDivs=0

function getElementbyClass(classname){
partscollect=new Array()
var inc=0
var alltags=document.all? document.all.tags("DIV") : document.getElementsByTagName("*")
for (i=0; i<alltags.length; i++){
if (alltags[i].className==classname)
partscollect[inc++]=alltags[i]
}
}

function contractall(){
var inc=0
while (partscollect[inc]){
partscollect[inc].style.display="none"
inc++
}
}

function expandone(){
var selectedDivObj=partscollect[selectedDiv]
contractall()
selectedDivObj.style.display="block"
if (document.gallerycontrol)
temp.options[selectedDiv].selected=true
selectedDiv=(selectedDiv<totalDivs-1)? selectedDiv+1 : 0
if (displaymode=="auto")
autocontrolvar=setTimeout("expandone()",tickspeed)
}

function populatemenu(){
temp=document.gallerycontrol.menu
for (m=temp.options.length-1;m>0;m--)
temp.options[m]=null
for (i=0;i<totalDivs;i++){
var thesubject=partscollect[i].getAttribute("subject")
thesubject=(thesubject=="" || thesubject==null)? "HTML Content "+(i+1) : thesubject
temp.options[i]=new Option(thesubject,"")
}
temp.options[0].selected=true
}

function manualcontrol(menuobj){
if (displaymode=="manual"){
selectedDiv=menuobj
expandone()
}
}

function preparemode(themode){
displaymode=themode
if (typeof autocontrolvar!="undefined")
clearTimeout(autocontrolvar)
if (themode=="auto"){
document.gallerycontrol.menu.disabled=true
autocontrolvar=setTimeout("expandone()",tickspeed)
}
else
document.gallerycontrol.menu.disabled=false
}


function startgallery(){
if (document.getElementById("controldiv")) //if it exists
document.getElementById("controldiv").style.display="block"
getElementbyClass("gallerycontent")
totalDivs=partscollect.length
if (document.gallerycontrol){
populatemenu()
if (document.gallerycontrol.mode){
for (i=0; i<document.gallerycontrol.mode.length; i++){
if (document.gallerycontrol.mode[i].checked)
displaymode=document.gallerycontrol.mode[i].value
}
}
}
if (displaymode=="auto" && document.gallerycontrol)
document.gallerycontrol.menu.disabled=true
expandone()
}

if (window.addEventListener)
window.addEventListener("load", startgallery, false)
else if (window.attachEvent)
window.attachEvent("onload", startgallery)
else if (document.getElementById)
window.onload=startgallery

</script>
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


<tr>
<td  width="100%" height="248" valign="top">
<!--HTML for gallery control options below. Remove checkboxes or entire outer DIV if desired -->

<div id="controldiv" style="display:none" class="gallerycontroller">
<form name="gallerycontrol">

<select class="gallerycontroller" name="menu" onChange="manualcontrol(this.options.selectedIndex)">
<option>Blank form</option>
</select><br>

Auto: <input type="radio" checked name="mode" value="auto" onClick="preparemode('auto')"> Manual: <input type="radio" name="mode" value="manual" onClick="preparemode('manual')">
</form>
</div>
<div class="clear"></div>
<div class="gallerycontent" subject="1) Australia"><img style="border:#CCCCCC outset 1px;" src="images/australia/1.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="2) Australia"><img style="border:#CCCCCC outset 1px;" src="images/australia/2.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="3) Australia"><img style="border:#CCCCCC outset 1px;" src="images/australia/3.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="New South Wales (NSW)"><img style="border:#CCCCCC outset 1px;" src="images/australia/4.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Australian Capital Territory (ACT)"><img style="border:#CCCCCC outset 1px;" src="images/australia/5.jpg" width="936" height="697" ></div>

<div class="gallerycontent" subject="Queensland (QLD)"><img style="border:#CCCCCC outset 1px;" src="images/australia/6.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Northern Territory (NT)"><img style="border:#CCCCCC outset 1px;" src="images/australia/7.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Western Australia (WA)"><img style="border:#CCCCCC outset 1px;" src="images/australia/8.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="South Australia (SA)"><img style="border:#CCCCCC outset 1px;" src="images/australia/9.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Victoria (VIC)"><img style="border:#CCCCCC outset 1px;" src="images/australia/10.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Tasmania (TAS)"><img style="border:#CCCCCC outset 1px;" src="images/australia/11.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="1) Australians"><img style="border:#CCCCCC outset 1px;" src="images/australia/12.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="2) Australians"><img style="border:#CCCCCC outset 1px;" src="images/australia/13.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Working With Australians"><img style="border:#CCCCCC outset 1px;" src="images/australia/14.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="1) Slang Language"><img style="border:#CCCCCC outset 1px;" src="images/australia/15.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="2) Slang Language"><img style="border:#CCCCCC outset 1px;" src="images/australia/16.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="3) Slang Language"><img style="border:#CCCCCC outset 1px;" src="images/australia/17.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="4) Slang Language"><img style="border:#CCCCCC outset 1px;" src="images/australia/18.jpg" width="936" height="697" ></div>
<div class="gallerycontent" subject="Useful Links"><img src="images/australia/19.jpg" width="936" height="697" border="0" usemap="#Map" style="border:#CCCCCC outset 1px;" ></div></td>
</tr>
</table>

  

</td>
</tr>
</table>


<map name="Map"><area shape="rect" coords="76,180,429,215" href="http://www.whereis.com"><area shape="rect" coords="80,242,578,273" href="http://www.yellowpages.com.au"><area shape="rect" coords="78,304,441,333" href="http://www.wikipedia.org"></map></body>
</html>
