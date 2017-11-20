<?
include './conf/zend_smarty_conf_root.php';
define('TEST', False);
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}



$userid = @$_GET["userid"];

$s = "SELECT DISTINCT lname, fname FROM personal WHERE userid='$userid' LIMIT 1;";
$r=mysql_query($s);
while(list($lname, $fname) = mysql_fetch_array($r))
{
	 $FullName=$fname." ".$lname;
	 $FullName=filterfield($FullName);
}


$sql3 = "SELECT DISTINCT l.id, l.lname, l.fname FROM leads l WHERE status='Client' ORDER BY l.fname ASC;";
$result3=mysql_query($sql3);
while(list($lead_id, $client_lname, $client_fname) = mysql_fetch_array($result3))
{
	 $client_fullname =$client_fname." ".$client_lname;
	 if ($kliyente==$lead_id)
	 {
	 	$usernameOptions2 .="<option selected value=".$lead_id.">".$client_fullname."</option>";
	 }
	 else
	 {
	 	$usernameOptions2 .="<option  value=".$lead_id.">".$client_fullname."</option>";
	 }	
}


if(@isset($_POST["send"]))
{
		$AusTime = date("H:i:s"); 
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		$date=date('l jS \of F Y h:i:s A');
		
		$admin_id = $_SESSION['admin_id'];
		$admin_status=$_SESSION['status'];
		
		$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
		
		$resulta=mysql_query($sql);
		$ctr=@mysql_num_rows($resulta);
		if ($ctr >0 )
		{
			$row = mysql_fetch_array ($resulta); 
			$admin_email = $row['admin_email'];
		}
		
		// used to create automatic creation of ads
		$kliyente=$_REQUEST['kliyente'];
		
		// check the client Business Partner
		$sqlAgentcheck="SELECT * FROM leads WHERE id=$kliyente";
		$resultAgentCheck=mysql_query($sqlAgentcheck);
		$rowAgentCheck = mysql_fetch_array ($resultAgentCheck); 
		
		$agent_no = $rowAgentCheck['agent_id'];
		$client_email = $rowAgentCheck['email'];
		if($agent_no=="")
		{
			$query="SELECT * FROM agent WHERE email ='$admin_email';";
			$result=mysql_query($query);
			$ctr2=@mysql_num_rows($result);
			if ($ctr2 >0 )
			{
				$row = mysql_fetch_array ($result); 
				$agent_no = $row['agent_no'];
			}
		}	
		
		if(isset($_REQUEST['ads']))
		{
			$ads=$_REQUEST['ads'];
		}
		else
		{
			$ads=$_REQUEST['ads_temp'];
		}

		$sql="SELECT jobposition FROM posting WHERE id = '$ads';";
		$r=mysql_query($sql);
		$ctr=@mysql_num_rows($r);
		if ($ctr >0 )
		{
			$rw = mysql_fetch_array ($r); 
			$ads = $rw['jobposition'];
			$pos = "for the ".$rw['jobposition']." position to one of our clients.";			
		}
		if ($ads=="")
		{
			$ads="";
			$pos = "to one of our clients.";
		}
		



		$status = "Active";
		$date_endoesed = date("Y-m-d");
		$final_Interview = "";
		$comment = "";
		$status = "On Hold";
		$part_time_rate = $_POST['p_time'];
		$full_time_rate = $_POST['f_time'];
		mysql_query("INSERT INTO tb_endorsement_history (userid, client_name, position, final_Interview, comment, part_time_rate, full_time_rate, status, date_endoesed) VALUES('$userid', '$kliyente', '$ads', '$final_Interview', '$comment', '$part_time_rate', '$full_time_rate', '$status', '$date_endoesed')");
		mysql_query("UPDATE applicants SET status='Endorsed' WHERE userid='$userid' LIMIT 1");

		// SEND AN EMAIL TO SUB-CONTRACTOR
		$sqlEmail="SELECT * FROM personal p WHERE p.userid=$userid";
		$result=mysql_query($sqlEmail);
		$row = mysql_fetch_array ($result); 
		//$email =$row['email'];
		$fullname =$row['fname']." ".$row['lname'];
		$subcontructor_email =$row['email'];
		
		$from_email="ricag@remotestaff.com.au";

		
		//$header  = 'MIME-Version: 1.0' . "\r\n";
		//$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";	

		
		
//<!----- BODY ---------------------------------------------------------------------------------------------------------->
$query="SELECT * FROM personal p  WHERE p.userid=$userid";
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysql_query($query2);
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$row2 = mysql_fetch_array ($result2); 
	$latest_job_title=$row2['latest_job_title'];
	$image=basename($row['image']);

/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality	
*/

	$u_id =$row['userid'];
	$name =$row['fname']." ".$row['lname'];
	$dateapplied =$row['datecreated'];
	$dateupdated =$row['dateupdated'];
	$address=$row['address1']." ".$row['city']." ".$row['postcode']." <br>".$row['state']." ".$row['country_id'];
	$tel=$row['tel_area_code']." - ".$row['tel_no'];
	$cell =$row['handphone_country_code']."+".$row['handphone_no'];
	$email =$row['email'];
	$byear = $row['byear'];
	$bmonth = $row['bmonth'];
	$bday = $row['bday'];
	$gender =$row['gender'];
	$nationality =$row['nationality'];
	$residence =$row['permanent_residence'];
	
	$yahoo_id =$row['yahoo_id']; 
	$skype_id=$row['skype_id'];
	
	$home_working_environment=$row['home_working_environment'];
	$internet_connection=$row['internet_connection'];
	$isp=$row['isp'];
	$computer_hardware=$row['computer_hardware'];
	$headset_quality=$row['headset_quality'];
	
	$computer_hardware2=str_replace("\n","<b>",$computer_hardware);
	if($headset_quality=="0") {
		$headset_quality ="No Headset Available";
	}	
	$message="<p align =justify>Working Environment :".$home_working_environment."<br>";
	$message.="Internet Connection :".$internet_connection."<br>";
	$message."Internet Provider :".$isp."<br>";
	$message.="Computer Hardware/s :".$computer_hardware2."<br>";
	$message.="Headset Quality :".$headset_quality."<br></p>";
	
	$yr = date("Y");
	switch($bmonth)
	{
		case 1:
		$bmonth= "Jan";
		break;
		case 2:
		$bmonth= "Feb";
		break;
		case 3:
		$bmonth= "Mar";
		break;
		case 4:
		$bmonth= "Apr";
		break;
		case 5:
		$bmonth= "May";
		break;
		case 6:
		$bmonth= "Jun";
		break;
		case 7:
		$bmonth= "Jul";
		break;
		case 8:
		$bmonth= "Aug";
		break;
		case 9:
		$bmonth= "Sep";
		break;
		case 10:
		$bmonth= "Oct";
		break;
		case 11:
		$bmonth= "Nov";
		break;
		case 12:
		$month= "Dec";
		break;
		default:
		break;
	}
}
$txt = $_POST["body_message"];
$txt=str_replace("\n","<br>",$txt);

$body="
<html>
<head>
<title>Online Resume ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href=\"http://www.remotestaff.com.au/portal/css/font.css\">
<link rel=stylesheet type=text/css href=\"http://www.remotestaff.com.au/portal/css/style.css\">
<link rel=stylesheet type=text/css href=\"http://www.remotestaff.com.au/portal/css/resume.css\">
<meta HTTP-EQUIV='Content-Type' charset='utf-8'>


<style type=\"text/css\"> 
    .cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
    .cName label{ font-style:italic; font-size:8pt}
    .cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
    .jobRESH {color:#000000; size:2; font-weight:bold}
</style>
<style>
<!--
div.scroll {
		height: 300px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
			
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
		margin-left:0px;
	}
	.scroll label
	{
	
		width:90px;
		float: left;
		text-align:right;
		
	}
	.spanner
	{
		width: 400px;
		overflow: auto;
		padding:5px 0 5px 10px;
		margin-left:20px;
		
	}
	
#l {
	float: left;
	width: 350px;
	text-align:left;
	padding:5px 0 5px 10px;
	}	
#l ul{
	   margin-bottom: 10px;
		margin-top: 10px;
		margin-left:20px;
	}	

#r{
	float: right;
	width: 120px;
	text-align: left;
	padding:5px 0 5px 10px;
	
	
	}
	
	
.ads{
	width:580px;
	
		}
.ads h2{
	color:#990000;
	font-size: 2.5em;
	}	
.ads p{	
		margin-bottom: 5px;
		margin-top: 5px;
		margin-left:30px;
	}
.ads h3
{
	color:#003366;
	font-size: 1.5em;
	margin-left:30px;
}	
#comment{
	float: right;
	width: 500px;
	padding:5px 0 5px 10px;
	margin-right:20px;
	margin-top:0px;
}
#comment p
{

margin-bottom: 4px;
margin-top: 4px;
}


#comment label
{
display: block;
width:100px;
float: left;
padding-right: 10px;
font-size:11px;
text-align:right;

}


-->
</style>
</head>
<body background=\"http://www.remotestaff.com.au/portal/images/gray_bg.gif\">
<table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor=\"666666\">
";

//message
$body = $body."
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
	<td valign='top' bgcolor='#ffffff'>
	<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
	".$txt.	"
	</div>
	</td>
</tr>
</table></td></tr>
";
//end message


//samples
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Samples</b></td></tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
	<td valign='top' bgcolor='#ffffff'>
	<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
																<table>";
																			$f_counter = @$_POST["f_counter"];
																			$num = 1;
																			$temp = "";
																			for($i = 1; $i <= $f_counter; $i++)
																			{
																				if(@isset($_POST["file".$i]))
																				{
																					$temp = $temp."<tr><td valign=top><font face='arial' size=2>".$num.")</font></td>";
																					$temp = $temp."<td valign=top>"."<font color='#000000' face='arial' size=2>".$row["file_description"]."</font><font color='#CCCCCC' face='arial' size=1><b>(Download</b><i>&nbsp;&nbsp;<a href='http://www.remotestaff.com.au/portal/applicants_files/".$_POST["file".$i]."' target='_blank'>".$_POST["file".$i]."</a></i><strong>)</strong></font></td></tr>";
																					$num++;
																				}	
																			}
																			$body=$body.$temp;
$body = $body."
																</table>
	</div>
	</td>
</tr>
</table></td></tr>
";
//end samples




//comment
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Comments</b></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
			  																<td valign='top' bgcolor='#ffffff'>
																			<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
																			<table>
																			";
																			$c_counter = @$_POST["c_counter"];
																			$num = 1;
																			$temp = "";
																			for($i = 1; $i <= $c_counter; $i++)
																			{
																				if(@isset($_POST["comment".$i]))
																				{
																					$temp = $temp."<tr><td valign=top>".$num.")</td>";
																					$temp = $temp."<td>".$_POST["comment".$i]."</td></tr>";
																					$num++;
																				}	
																			}
																			$body=$body.$temp;
$body = $body."																					
																			</table>							
																			</div>
																			</td>
</tr>
</table></td></tr>
";
//end comment



//signature
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
	<td valign='top' align=left bgcolor='#ffffff'>";




										$subject =@$_POST["subject"];		
										//SEGNATURE						   
										$admin_id = $_SESSION['admin_id'];
										$admin_status=$_SESSION['status'];
										$site = $_SERVER['HTTP_HOST'];
										
										$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
										$result=mysql_query($sql);
										$ctr=@mysql_num_rows($result);
										if ($ctr >0 )
										{
											$row = mysql_fetch_array ($result); 
											$admin_email = $row['admin_email'];
											$name = $row['admin_fname']." ".$result['admin_lname'];
											$admin_email=$row['admin_email'];
											$signature_company = $row['signature_company'];
											$signature_notes = $row['signature_notes'];
											$signature_contact_nos = $row['signature_contact_nos'];
											$signature_websites = $row['signature_websites'];
										}
										
										if($signature_notes!=""){
											$signature_notes = "<p><i>$signature_notes</i></p>";
										}else{
											$signature_notes = "";
										}
										if($signature_company!=""){
											$signature_company="<br>$signature_company";
										}else{
											$signature_company="<br>RemoteStaff";
										}
										if($signature_contact_nos!=""){
											$signature_contact_nos = "<br>$signature_contact_nos";
										}else{
											$signature_contact_nos = "";
										}
										if($signature_websites!=""){
											$signature_websites = "<br>Websites : $signature_websites";
										}else{
											$signature_websites = "";
										}
										
										$signature_template = $signature_notes;
										$signature_template .="<a href='http://$site/$agent_code'>
													<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
										$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
										//END SEGNATURE		

$body = $body.$signature_template."
	</td>
</tr>
</table></td></tr>
</table>
</html>
";
//end end signature





//send the mail
if (! TEST) 
{		
	//mail($client_email, $subject, $body, $header);
	$from_address = $from_email;
	$from_name = "REMOTESTAFF.COM.AU";				
	sendZendMail($client_email,$subject,$body,$from_address,$from_name);
}
else
{
	$client_email = "devs@remotestaff.com.au";
	//mail($client_email, $subject, $body, $header);
	$from_address = $from_email;
	$from_name = "REMOTESTAFF.COM.AU";				
	sendZendMail($client_email,$subject,$body,$from_address,$from_name);
}
			
$to_counter = $_POST["to_counter"];
if($to_counter > 0)
{
	for($i = 0; $i <= $to_counter; $i++)
	{
		$to = $_POST["to".$i];
		if($to == "" || $to == NULL)
		{
			//do nothing
		}
		else
		{
			$from_address = $from_email;
			$from_name = "REMOTESTAFF.COM.AU";	
			if (! TEST) 
			{		
				//mail($to, $subject, $body, $header);							
				sendZendMail($to,$subject,$body,$from_address,$from_name);
			}
			else
			{
				$to = "devs@remotestaff.com.au";
				//mail($to, $subject, $body, $header);			
				sendZendMail($to,$subject,$body,$from_address,$from_name);
			}
		}	
	}
}	
//end send email














$userid = @$_GET["userid"];
$a = mysql_query("SELECT fname, lname FROM personal WHERE userid='$userid' LIMIT 1");
$name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");
?>
<script language="javascript">
	alert("<?php echo $name; ?> samples has been sent.");
	window.close();
</script>
<?php		
}
$subject_value = "Remotestaff: (".$FullName.")";
?>


<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>

<script src="selectClient.js"></script>

<script type="text/javascript" src="media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
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


<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<style type="text/css">
<!--
div.scroll {
	height: 400px;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">
var i=0;
var temp;
var sub_value = "Remotestaff: (<?php echo $FullName; ?>)";

function createNewTextBox()
{
	i = i + 1;
	document.getElementById('myDivName').innerHTML = document.getElementById('myDivName').innerHTML + "<input type='text' name='to" + i + "' style='width:50%' class='text' value=''><br />";
	document.getElementById('to_counter_id').value = i;
}

function fillAds(ads)
{
	document.form.ads2.value=ads;
}
function checkFields()
{
	if(document.form.flag.value=="")
	{
		alert("Please choose an Option in Adding a Sub-Contractor.");
		return false;
	}
	if(document.form.flag.value=="1")
	{
		if(document.form.fname.value=="")
		{
			alert("Firstname is a required Field!");
			return false;
		}
		if(document.form.lname.value=="")
		{
			alert("Lastname is a required Field!");
			return false;
		}
		if(document.form.email.value=="")
		{
			alert("Email is a required Field!");
			return false;
		}
			
	}
	if(document.form.flag.value=="2")
	{
		if(document.form.subcon.selectedIndex=="0")
		{
			alert("Please choose an Applicant in the List!");
			return false;
		}
	}
	// kliyente
	if(document.form.kliyente.selectedIndex=="0")
		{
			alert("Please choose a Client in the List!");
			return false;
		}
		
	//if(document.form.ads2.value=="")
	//{
	//	alert("Please choose a Client Job Advertisement!");
	//	return false;
	//}
	return true;
}
-->

</script>


<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">



<form name="form" method="post" action="?userid=<?php echo @$_GET["userid"]; ?>" onSubmit="return checkFields();">
<input type="hidden" size="20%" name="to_counter" id="to_counter_id" value=0 />
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
	<tr>
		<td height="40" colspan="2">
			<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
				<b>Send Samples to Client</b>
			</div>				
		</td>
	</tr>	
	<tr>
		<td valign="top" colspan="2">
			<b><?php echo $FullName; ?></b>
		</td>
	</tr>  
	<tr>
		<td colspan="2" valign="top"><hr></td>
	</tr>
	<tr>
		<td height="32" colspan="2" valign="middle">
			<table width="100%">
				<tr>
					<td colspan="3" height="24"><strong>Send to</strong></td>
				</tr>
				<tr>
					<td width="11%" height="28">Client</td>
					<td width="1%">:</td>
					<td width="88%">
						<select name="kliyente" class="select">
							<option value="0">-</option>
							<?=$usernameOptions2;?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="11%" height="28">CC</td>
					<td width="1%">:</td>
					<td width="88%">
						<div name="temp" id="myDivName"></div><input type='button' onclick="createNewTextBox();" value="Add" />					
					</td>
				</tr>				
				<tr>
					<td width="11%" height="28">Subject</td>
					<td width="1%">:</td>
					<td width="88%">
                      <input type="text" id="subject_id" name="subject" class="text" style="width:70%" value="<?php echo $subject_value; ?>">
</td>
				</tr>			
				<tr>
					<td width="11%" height="28" valign="top">Include Comments</td>
					<td width="1%" valign="top">:</td>
					<td width="88%">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<?php
							$userid = @$_GET["userid"];
							$c = "SELECT comments FROM evaluation_comments WHERE userid='$userid';";
							$r=mysql_query($c);
							$c_counter = 0;
							while(list($comments) = mysql_fetch_array($r))
							{
								$c_counter++;
						?>		
							<tr>
								<td valign="top"><input type="checkbox" name="comment<?php echo $c_counter; ?>" value="<?php echo $comments; ?>" checked></td>
								<td width="100%"><?php echo $comments; ?></td>
							</tr>
						<?php	
							}
						?>
						<input type="hidden" value="<?php echo $c_counter; ?>" name="c_counter">
						</table>
					</td>
				</tr>
				
				
				<tr>
					<td width="11%" height="28" valign="top">Include Samples</td>
					<td width="1%" valign="top">:</td>
					<td width="88%">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<?php
							$c = mysql_query("SELECT * FROM tb_applicant_files WHERE userid='$userid'");	
							$c_counter = 0;
							while ($row = @mysql_fetch_assoc($c)) 
							{		
								$c_counter++;
						?>			
							<tr>
								<td valign="top"><input type="checkbox" name="file<?php echo $c_counter; ?>" value="<?php echo $row["name"]; ?>" checked></td>
								<td width="100%">
								<?php 
									if($row["file_description"] != "" || $row["file_description"] != NULL)
									{
										echo $row["file_description"].":&nbsp;<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$row["name"]."</a></i>"; 
									}
									else
									{
										echo "<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$row["name"]."</a></i>"; 
									}
								?>										
								</td>
							</tr>
						<?php	
							}
						?>
						<input type="hidden" value="<?php echo $c_counter; ?>" name="f_counter">
						</table>
					</td>
				</tr>					
				<tr>
					<td colspan="3">
					Your Message to Client
					</td>
				</tr>					
				<tr>
					<td colspan="3">
					<textarea name="body_message" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"></textarea>
					<script language="javascript1.2">
						generate_wysiwyg('contents');
					</script>					
					</td>
				</tr>				
				<tr>
					<td>
					<INPUT type="submit" value="Send" name="send" class="button" style="width:120px">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top"></td>
	</tr>
</table>
</form>




</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>
 
</body>
</html>



