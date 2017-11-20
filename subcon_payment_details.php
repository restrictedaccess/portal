<?
include 'config.php';
include 'conf.php';
include 'function.php';

$userid = $_SESSION['userid'];
$edit=$_REQUEST['edit'];
//echo $userid;
/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality

*/

$query="SELECT fname,lname,payment_details FROM personal WHERE userid=$userid";
//echo $query;
$result=mysql_query($query);
list($fname,$lname,$payment_details)=mysql_fetch_array($result);
$payment_details=str_replace("\r\n","<br>",$payment_details);

if(isset($_POST['update']))
{
	$payment_details=$_REQUEST['payment_details'];
	$payment_details=filterfield($payment_details);
	$sqlUpdate="UPDATE personal SET payment_details = '$payment_details' WHERE userid = $userid;";
	//echo $sqlUpdate;
	mysql_query($sqlUpdate)or trigger_error("Query: $sqlUpdate\n<br />MySQL Error: " . mysql_error());	
	$message ="<div style='background-color:#FFFFCC;'><b>Payment Details has been Updated!</b></div>";
	echo("<html><head><script>function update(){top.location='subcon_payment_details.php';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
}


?>
<html>
<head>
<title>Sub-Contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<style>
<!--
div.scroll {
		height: 400px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
#error {color:#FF0000;font-family:Tahoma; font-size:13px; margin-left:30px;}

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

<? if ($edit=="TRUE") {?>
	window.onload=initbox
<? }?>	

function checkFields()
{
	if(document.form.payment_details.value=="")
	{
		document.getElementById("error").innerHTML="ERROR : Please enter your PAYMENT DETAILS!";
		return false;
	}
	return true;
}
</script>	
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<ul class="glossymenu">
 <li ><a href="subconHome.php"><b>Home</b></a></li>
  <li ><a href="subcon_myresume.php"><b>MyResume</b></a></li>
  <li ><a href="subcon_myapplications.php"><b>Applications</b></a></li>
   <li><a href="subcon_jobs.php"><b>Search Jobs</b></a></li>
</ul>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="32">
				<tr><td width="736"  bgcolor="#abccdd" >
					<table width="736">
						<tr>
							<td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <?=$fname." ".$lname;?>	</td>
							
						</tr>
					</table>
				</td></tr>
</table>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>

<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'subcon_leftnav.php';?>
</td>
<td width=566 valign=top align="">
<div style="margin-bottom: 12px; margin-left:10PX; margin-top:10PX; border: 1px solid #abccdd; width: 500PX; padding: 8px;">
<h5>Payment Details </h5>
<?
if ($payment_details!="") 
{
	echo $payment_details;
	echo "<p>&nbsp;</p>
		 <p>Incorrect Information Click <a href='subcon_payment_details.php?edit=TRUE' class='link20'>HERE</a></p>";
}
else
{
	echo "<P class='tip'>You have no PAYMENT DETAILS</p>
	<p>Click <a href='subcon_payment_details.php?edit=TRUE' class='link20'>HERE</a></p>";
}
?>
</div>
<!-- forms here -->
<div id="dropin" style="position:absolute; visibility: hidden; border: 9px solid orange; background-color:#FFFFFF; width: 570px; padding: 8px;" >
<div align="right"><a href="#" class="link10" onClick="dismissbox();return false" title="Close Box">[X]</a>&nbsp;&nbsp;</div>
<form name="form" method="post" action="subcon_payment_details.php" onSubmit="return checkFields();">
<div style="margin-bottom: 12px; margin-left:10PX; margin-top:10PX; border: 1px solid #abccdd; padding: 8px;">
<?=$message;?>
<h5>Please enter your Payment Details </h5>
<textarea name="payment_details" id="payment_details" rows="7" style=" width:70%; border:#CECDE0 solid 1px; margin-left:10px;"></textarea>
<div id="error" ></div>
<p style="margin-left:10PX;"><input type="submit" name="update" value="UPDATE PAYMENT DETAILS !"></p>
</div>
</form>
</div>
<!-- ends here -->
</td>
</tr></table>

<? include 'footer.php';?>
</body>
</html>
