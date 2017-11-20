<?php
//  2009-01-08 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   used tinymce editor
//  2009-12-28 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed extra slashes before sending email
//  -   added note to not to copy/paste directly from a word processor
//	2013-08-27 Normaneil E. Macutay <normanm@remotestaff.com.au>
//	-	created django based "Bulletin Board"

include './conf/zend_smarty_conf.php';
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
	exit;
}

header("location:/portal/django/bulletin_board/");
exit;

include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";
$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	$admin_email = $row['admin_email'];
	
}



$contents=$_REQUEST['contents'];
//$contents = filterfield($contents);
if(isset($_POST['save']))
{
	//echo $contents;
	// TABLE : newsletter
	// FIELDS :id, admin_id, topic, contents, date_created, status
	$subject="MESSAGE FROM ADMIN REMOTESTAFF.COM.AU";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
	//$headers .= 'Bcc: chrisj@remotestaff.com.au,ricag@remotestaff.com.au.com,normanm@remotestaff.com.au' . "\r\n";
	//$headers .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";
	
	$sqlInsert="INSERT INTO subcon_updates SET admin_id = $admin_id, contents = '$contents', date_created = '$ATZ'";
	mysql_query($sqlInsert)or trigger_error("Query: $sqlInsert\n<br />MySQL Error: " . mysql_error());	
	$message ="<div style='text-align:center; background-color:#FFFFCC; padding:10px 10px 10px 10px;'><b>New Bulletin has been Posted !</b></div>";
	
    //remove slashes before sending it to mail
    $contents = stripslashes($contents);

	mail("chrisj@remotestaff.com.au,ricag@remotestaff.com.au",$subject, $contents, $headers);
	
	$queryGetAllSubCon2 = "SELECT distinct(s.userid), p.email 
		from subcontractors as s left join personal as p on s.userid = p.userid where s.status ='ACTIVE' order by p.fname ASC;";
		$result5=mysql_query($queryGetAllSubCon2);
		$email_sent_count=0;
		$email_failed_count=0;
		$subcon_count=0;
		while(list($subcon_id,$subcon_emails) = mysql_fetch_array($result5))
		{
			//echo $subcon_emails."<br>";
			//echo $body;
			$subcon_count++;
		    $check_email=mail($subcon_emails,$subject, $contents, $headers);
			if($check_email) {
					$email_sent_count++;
			}	
			else{
					$email_failed_count++;
			}
		}
		
$result_email ="<div style='margin-bottom:10px; text-align:center; background:#FFFFDF; padding-bottom:5px; padding-top:5px;'>
<b>No. of Message Sent &nbsp;:".$email_sent_count."</b>&nbsp;&nbsp;Status[".$email_sent_count."/".$subcon_count."]<br>
<b>No. of Message Sending Failed &nbsp;:".$email_failed_count."&nbsp;</b>&nbsp;&nbsp;Status[".$email_failed_count."/".$subcon_count."]
</div>";
	
	
//
}

$delete = $_REQUEST['delete'];
$subcon_updates_id=$_REQUEST['id'];
if($delete=="TRUE")
{
	$sqlDelete="DELETE FROM subcon_updates WHERE id = $subcon_updates_id;";
	mysql_query($sqlDelete);
	$message ="<div style='text-align:center; background-color:#FFFFCC; padding:10px 10px 10px 10px;'><b>Bulletin has been Deleted !</b></div>";
}



?>

<html>
<head>
<title>SUB-CON HOMEPAGE UPDATES</title>
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
<!--
    <script language="JavaScript" type="text/javascript" src="wyswig/wysiwyg.js"></script>
-->

<script type="text/javascript" src="/portal/media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
    // General options
    mode : "textareas",
    theme : "advanced",
    plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    // Example content CSS (should be your site CSS)
    content_css : "css/example.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "js/template_list.js",
    external_link_list_url : "js/link_list.js",
    external_image_list_url : "js/image_list.js",
    media_external_list_url : "js/media_list.js",

    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});
</script>



<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="194" style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<? include 'adminleftnav.php';?>
</td>
<td width=100% valign=top bgcolor="#EBEBEB" >
<input type="button" value="Add Message" onClick="javascript:redo();">
<?=$result_email;
?>
<?=$message;?>
<!-- contents here -->
<style>
<!--
.newsletter{float:left; margin-bottom:20px; margin-left:10px; margin-top:10px;  border: 1px solid #abccdd; width: 90%;  background-color:#FFFFFF;padding:10px 10px 10px 20px;}
-->
</style>
<?
// id, admin_id, topic, contents, date_created, status
$sql="SELECT id , contents, DATE_FORMAT(date_created,'%D %b %Y') FROM subcon_updates ORDER BY date_created DESC;";
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
//echo $sql."<br>".$ctr."<br>";
$counter=0;
while(list($id, $contents ,$date_created)=mysql_fetch_array($result))
{
	$counter++;
?>
<div  class="newsletter"><b><?=$counter;?></b>)
<div style="text-align:right; color:#333333"><a href="admin_subcon_updates.php?id=<?=$id;?>&delete=TRUE" class="link15"><img src="images/delete.png" alt="Delete" border="0" align="absmiddle"> Delete</a>&nbsp;&nbsp;<?=$date_created;?></div>
<? echo $contents;;?>
</div>
<? }?>
<!-- ends here -->

<!--wyswyg here --->
<div id="dropin" >
<div id="forms">
<div align="right"><a href="#" class="link10" onClick="dismissbox();return false" title="Close Box">[X]</a>&nbsp;&nbsp;</div>
<form name="form" method="POST" action="admin_subcon_updates.php">
<h2>NEW BULLETIN MESSAGE</h2>
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
