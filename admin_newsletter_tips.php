<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$contents=$_REQUEST['contents'];
$contents = filterfield($contents);
if(isset($_POST['save']))
{
	//echo $contents;
	// TABLE : newsletter
	// FIELDS :id, admin_id, topic, contents, date_created, status
	$sqlInsert="INSERT INTO newsletter SET admin_id = $admin_id, contents = '$contents', date_created = '$ATZ'";
	mysql_query($sqlInsert)or trigger_error("Query: $sqlInsert\n<br />MySQL Error: " . mysql_error());	
	$message ="<div style='text-align:center; background-color:#FFFFCC; padding:10px 10px 10px 10px;'><b>New Newsletter has been Posted !</b></div>";

}

$delete = $_REQUEST['delete'];
$newsletter_id=$_REQUEST['id'];
if($delete=="TRUE")
{
	$sqlDelete="DELETE FROM newsletter WHERE id = $newsletter_id;";
	mysql_query($sqlDelete);
	$message ="<div style='text-align:center; background-color:#FFFFCC; padding:10px 10px 10px 10px;'><b>Newsletter/Announcement has been Deleted !</b></div>";
}



?>

<html>
<head>
<title>Clients Comments</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<style>
<!--
#dropin{
	position:absolute;
	visibility:hidden;
	left:200px;

	background-color:#FFFF33;
	border:#666666 solid 3px;
	}
#forms{ background-color:#FFFFFF; margin:2px 2px 2px 2px; height:98% }
-->
</style>
<script language="JavaScript1.2">

// Drop-in content box- By Dynamic Drive
// For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
// This credit MUST stay intact for use

var ie=document.all
var dom=document.getElementById
var ns4=document.layers
var calunits=document.layers? "" : "px"

var bouncelimit=32 //(must be divisible by 8)
var direction="up"

function initbox(){
if (!dom&&!ie&&!ns4)
return
crossobj=(dom)?document.getElementById("dropin").style : ie? document.all.dropin : document.dropin
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
crossobj.top=scroll_top-250+calunits
crossobj.visibility=(dom||ie)? "visible" : "show"
dropstart=setInterval("dropin()",50)
}

function dropin(){
scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
if (parseInt(crossobj.top)<100+scroll_top)
crossobj.top=parseInt(crossobj.top)+40+calunits
else{
clearInterval(dropstart)
bouncestart=setInterval("bouncein()",50)
}
}

function bouncein(){
crossobj.top=parseInt(crossobj.top)-bouncelimit+calunits
if (bouncelimit<0)
bouncelimit+=8
bouncelimit=bouncelimit*-1
if (bouncelimit==0){
clearInterval(bouncestart)
}
}

function dismissbox(){
if (window.bouncestart) clearInterval(bouncestart)
crossobj.visibility="hidden"
}

function redo(){
bouncelimit=32
direction="up"
initbox()
}

function truebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

	//window.onload=initbox
	

</script>

</head>
<script language="JavaScript" type="text/javascript" src="wyswig/wysiwyg.js"></script>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<? include 'header.php';?>
<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li class="current"><a href="adminHome.php"><b>Home</b></a></li>
  <li ><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li ><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li ><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li ><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
   <li><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li ><a href='adminHome.php'><b>Home</b></a></li>
  <li ><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li class='current'><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li ><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li ><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
  <li><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>";
}
?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="194" style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<? include 'adminleftnav.php';?>
</td>
<td width=100% valign=top bgcolor="#EBEBEB" >
<a href="javascript:redo();" class="link20" title="Click here to create new Newsletter / Announcement" >Create a Newsletter / Annoucement</a>
<p></p>
<?=$message;?>
<!-- contents here -->
<style>
<!--
.newsletter{float:left; margin-bottom:20px; margin-left:10px; margin-top:10px;  border: 1px solid #abccdd; width: 90%;  background-color:#FFFFFF;padding:10px 10px 10px 20px;}
-->
</style>
<?
// id, admin_id, topic, contents, date_created, status
$sql="SELECT id , contents, DATE_FORMAT(date_created,'%D %b %Y') FROM newsletter ORDER BY date_created DESC;";
$result=mysql_query($sql);
$counter=0;
while(list($id, $contents ,$date_created)=mysql_fetch_array($result))
{
	$counter++;
?>
<div  class="newsletter"><b><?=$counter;?></b>)
<div style="text-align:right; color:#333333"><a href="admin_newsletter_tips.php?id=<?=$id;?>&delete=TRUE" class="link15"><img src="images/delete.png" alt="Delete" border="0" align="absmiddle"> Delete</a>&nbsp;&nbsp;<?=$date_created;?></div>
<? echo $contents;;?>
</div>
<? }?>
<!-- ends here -->

<!--wyswyg here --->
<div id="dropin" >
<div id="forms">
<div align="right"><a href="#" class="link10" onClick="dismissbox();return false" title="Close Box">[X]</a>&nbsp;&nbsp;</div>
<form name="form" method="POST" action="admin_newsletter_tips.php">
<h3>Announcements Newletters and Tips</h3>
<input type="hidden" name="topic" id="topic" value="" class="text">
  <textarea id="contents" name="contents" style="height: 300px; width: 900px; background-color:#FFFFFF; border:#D2CFEB solid 1px;">Please type Here.......</textarea>
  <script language="javascript1.2">
  generate_wysiwyg('contents');
</script>
<br>
<input type="submit" id="save" name="save" value="POST" />
</form>
</div>
</div></td>
</tr></table>

<? include 'footer.php';?>

</body>
</html>
