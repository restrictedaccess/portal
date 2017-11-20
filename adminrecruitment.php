<?
include 'config.php';
include 'function.php';
include 'conf.php';

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$leads_id=$_REQUEST['id'];
$pid = $_REQUEST['pid'];
$stat=$_REQUEST['stat'];

if ($stat=="")
{
	$stat ="Unprocessed";
}

////////// 
$sql="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Unprocessed';";
	$res1 = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
	$unprocessed=@mysql_num_rows($res1);
	//////////
	$sql2="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Prescreened';";
	$res2 = mysql_query ($sql2) or trigger_error("Query: $sql2\n<br />MySQL Error: " . mysql_error());	
	$prescreened=@mysql_num_rows($res2);
	
	//////////
	$sql3="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Hired';";
	$res3 = mysql_query ($sql3) or trigger_error("Query: $sql3\n<br />MySQL Error: " . mysql_error());	
	$hired=@mysql_num_rows($res3);
	//////////
	$sql4="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Kept for Referenced';";
	$res4 = mysql_query ($sql4) or trigger_error("Query: $sql4\n<br />MySQL Error: " . mysql_error());	
	$kept_for_reference=@mysql_num_rows($res4);
	//////////
	$sql5="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Shortlisted';";
	$res5 = mysql_query ($sql5) or trigger_error("Query: $sql5\n<br />MySQL Error: " . mysql_error());	
	$short_listed=@mysql_num_rows($res5);
	//////////
	$sql6="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Rejected';";
	$res6 = mysql_query ($sql6) or trigger_error("Query: $sql6\n<br />MySQL Error: " . mysql_error());	
	$rejected=@mysql_num_rows($res6);
	////	
	$sql7="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Invite to Interview';";
	$res7 = mysql_query ($sql7) or trigger_error("Query: $sql7\n<br />MySQL Error: " . mysql_error());	
	$invite=@mysql_num_rows($res7);
	//////////////////////
if($stat=="Prescreened")
{
$folder="<img src='images/folder_clip.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'>Unprocessed</a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_clip.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'> Invited for Interview </a>&nbsp; ($invite)&nbsp;
<img src='images/folder_open.gif'  alt='Prescreened'><b><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a></b> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_clip.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'> Shortlisted </a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_clip.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'> Hired </a>&nbsp; ($hired)&nbsp;
<img src='images/folder_clip.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'> Kept for Referenced </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_clip.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'> Rejected </a>&nbsp ($rejected)&nbsp;";
}
 if($stat=="Shortlisted")
{
$folder="<img src='images/folder_clip.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'>Unprocessed</a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_clip.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'> Invited for Interview </a>&nbsp; ($invite)&nbsp;
<img src='images/folder_clip.gif'  alt='Prescreened'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_open.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'><b> Shortlisted </b></a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_clip.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'> Hired </a>&nbsp; ($hired)&nbsp;
<img src='images/folder_clip.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'> Kept for Referenced </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_clip.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'> Rejected </a>&nbsp ($rejected)&nbsp;";
}

 if($stat=="Hired")
{
$folder="<img src='images/folder_clip.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'>Unprocessed</a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_clip.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'> Invited for Interview </a>&nbsp; ($invite)&nbsp;
<img src='images/folder_clip.gif'  alt='Prescreened'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_clip.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'> Shortlisted </a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_open.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'><b> Hired </b></a>&nbsp; ($hired)&nbsp;
<img src='images/folder_clip.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'> Kept for Referenced </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_clip.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'> Rejected </a>&nbsp ($rejected)&nbsp;";
}
 if($stat=="Kept for Referenced")
{
$folder="<img src='images/folder_clip.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'>Unprocessed</a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_clip.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'> Invited for Interview </a>&nbsp; ($invite)&nbsp;
<img src='images/folder_clip.gif'  alt='Prescreened'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_clip.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'> Shortlisted </a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_clip.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'> Hired </a>&nbsp; ($hired)&nbsp;
<img src='images/folder_open.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'><b> Kept for Referenced</b> </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_clip.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'> Rejected </a>&nbsp ($rejected)&nbsp;";
}
 if($stat=="Rejected")
{
$folder="<img src='images/folder_clip.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'>Unprocessed</a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_clip.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'> Invited for Interview </a>&nbsp; ($invite)&nbsp;
<img src='images/folder_clip.gif'  alt='Prescreened'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_clip.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'> Shortlisted </a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_clip.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'> Hired </a>&nbsp; ($hired)&nbsp;
<img src='images/folder_clip.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'> Kept for Referenced </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_open.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'><b> Rejected </b></a>&nbsp ($rejected)&nbsp;";
}
 if($stat=="Unprocessed")
{
$folder="<img src='images/folder_open.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'><b>Unprocessed</b> </a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_clip.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'> Invited for Interview </a>&nbsp; ($invite)&nbsp;
<img src='images/folder_clip.gif'  alt='Prescreened'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_clip.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'> Shortlisted </a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_clip.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'> Hired </a>&nbsp; ($hired)&nbsp;
<img src='images/folder_clip.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'> Kept for Referenced </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_clip.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'> Rejected </a>&nbsp ($rejected)&nbsp;";
}

 if($stat=="Invite to Interview")
{
$folder="<img src='images/folder_clip.gif'  alt='Unprocessed'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Unprocessed'>Unprocessed</a> &nbsp; ($unprocessed)&nbsp;
<img src='images/folder_open.gif'  alt='Invited for Interview'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Invite to Interview'><b> Invited for Interview </b></a>&nbsp; ($invite)&nbsp;
<img src='images/folder_clip.gif'  alt='Prescreened'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Prescreened'>Prescreened</a> &nbsp; ($prescreened)&nbsp;
<img src='images/folder_clip.gif'  alt='Shortlisted'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Shortlisted'> Shortlisted </a>&nbsp; ($short_listed)&nbsp;
<img src='images/folder_clip.gif'  alt='Hired'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Hired'> Hired </a>&nbsp; ($hired)&nbsp;
<img src='images/folder_clip.gif'  alt='Kept for Referenced'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Kept for Referenced'> Kept for Referenced </a>&nbsp; ($kept_for_reference)&nbsp;
<img src='images/folder_clip.gif'  alt='Rejected'><a href='adminrecruitment.php?pid=$pid&id=$leads_id&stat=Rejected'> Rejected </a>&nbsp ($rejected)&nbsp;";
}



/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program
*/
$query ="SELECT * FROM leads WHERE id = $leads_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);

	$tracking_no =$row['tracking_no'];
	$timestamp =$row['timestamp'];
	$status =$row['status'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
	$your_questions =$row['your_questions'];
		
	$lname =$row['lname'];
	$fname =$row['fname'];
	$company_position =$row['company_position'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$email =$row['email'];
	$website =$row['website'];
	$officenumber =$row['officenumber'];
	$mobile =$row['mobile'];
	$company_description =$row['company_description'];
	$company_industry =$row['company_industry'];
	$company_size =$row['company_size'];
	$outsourcing_experience =$row['outsourcing_experience'];
	$outsourcing_experience_description =$row['outsourcing_experience_description'];
	$company_turnover =$row['company_turnover'];
	$referal_program =$row['referal_program'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);
	$rate =$row['rating'];
	$personal_id =$row['personal_id'];
	
	if($rate=="1")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}

	
	
}
?>

<html>
<head>
<title>Job Advertisement Process</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<link rel="stylesheet" type="text/css" href="css/classifieds.css" media="screen" lang="en-us" />
<script language="javascript" src="js/prototype.js"></script>
<script language="javascript" src="js/classifiedsph.js"></script>
<script language="javascript" src="js/imagepopup.js"></script>

<script type="text/javascript" src="js/tooltip.js"></script>

<script type="text/javascript">
<!--
function checkFields()
{
	if(document.form.stat.value!="Hired")
	{
		if(document.form.applicants.value=="")
		{
			alert("There are no Applicant(s) selected?");
			return false;
		}
	}
	if(document.form.stat.value=="Hired")
	{
		//if(document.form.applicants.value=="")
		//{
		//	alert("There are no Applicant(s) selected?");
		//	return false;
		//}
		alert(document.form.stat.value);
	}	
	return true;
	
}
function togglead(adid) {
        if ($('adbody'+adid).style.display=='block') {
          $('adbody'+adid).style.display='none'
          $('editadlink'+adid).style.display='block'
          $('img'+adid).src='images/dn-arw.gif'
          $('img'+adid).alt='show'
        } else {
          $('adbody'+adid).style.display='block'
          $('editadlink'+adid).style.display='none'
          $('img'+adid).src='images/up-arw.gif'
          $('img'+adid).alt='hide'
        }
      }

      function togglepaidad(adid) {
        if ($('paidadbody'+adid).style.display=='block') {
          $('paidadbody'+adid).style.display='none'
          $('pimg'+adid).src='images/paidad-dn-arw.gif'
          $('pimg'+adid).alt='show'
        } else {
          $('paidadbody'+adid).style.display='block'
          $('pimg'+adid).src='images/paidad-up-arw.gif'
          $('pimg'+adid).alt='hide'
        }
      }

      function checkifloggedin() {
       // notloggedin = ""
       // if(notloggedin == "")
          //alert('Please register or log in to post an ad.');
       // else
         // window.location.href='cp-post-new-ad.php?maincat=1&subcat=8';
      }

      function showSearchHelp() {
        $('searchExplanation').style.display = "block";
      }

      function hideSearchHelp() {
        $('searchExplanation').style.display = "none";
      }
	 
	  
-->
</script>	
<script type="text/javascript">
<!--
function check_val()
{
	/*
	var ins = document.getElementsByName('users')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
	if(ins[i].checked==true)
	vals[j]=ins[i].value;
	j++;
	}

document.form.applicants.value=(vals);
*/
var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2 =new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true)
		{
			if(ins[i].value!="" || ins[i].value!="undefined")
			{
				vals[j]=ins[i].value;
				//vals2[j]=id;
				j++;
			}		
		}
	}
//if(document.getElementsByName('users').checked==true)
//{	
//	document.getElementById("applicants").value+=(id);
//}

document.form.applicants.value=(vals);
}
-->
</script>
<style type="text/css">
<!--
	div.scroll {
		height: 100px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
	}
	.spanner
	{
		float: right;
		text-align: right;
		padding:5px 0 5px 10px;
	
	
	}
	.spannel
	{
		float: left;
		text-align:left;
		padding:5px 0 5px 10px;
		border:#f2cb40 solid 1px;
		
	}	
	#l {
	float: left;
	text-align:left;
	padding:5px 0 5px 10px;
	text-decoration:underline;
	
	}	

#r{
	float:right;
	margin:0 0 0 450px;
	font-weight:bold;
	font-size:16px;
	font-style:italic;
	text-decoration:underline;
	color:#FF0000;
	border:#f2cb40 solid 1px;
	
	
	
	}
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
-->
</style>	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>


<!-- HEADER -->
<? include 'header.php';?>
<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li ><a href="adminHome.php"><b>Home</b></a></li>
  <li class="current"><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
   <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li ><a href='adminHome.php'><b>Home</b></a></li>
  <li class='current'><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
   <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>";
}
?>


<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="100%" bgcolor="#ffffff" align="center">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
  <tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td width="220" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'adminleftnav.php';?>
<br></td>
<td width=1014 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr>
<td height="50">
<div class="animatedtabs">
<ul>
<li class="selected"><a href="adminadvertise_positions.php" title="Registered Applicants Search"><span>Registered Applicants Search</span></a></li>
<li class="selected"><a href="adminadvertise_positions2.php" title="Recruitment Process"><span>Recruitment Process</span></a></li>
</ul>
</div></td>
</tr>
<tr><td>

<? if ($stat!="Hired") {?>
<form name="form" method="post" action="action.php" onSubmit="return checkFields();" >
<? }?>
<input type="hidden" name="leads_id" value="<? echo $leads_id;?>">
<input type="hidden" name="pid" value="<? echo $pid;?>">
<input type="hidden" name="applicants" value="">
<input type="hidden" name="stat" value="<? echo $stat;?>">


<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >
<tr bgcolor="#666666" >
  <td width=100%  colspan=2><b><font color="#FFFFFF">Recruitment Process </font></b></td>
</tr>
<tr><td height="100%" colspan=2 valign="top" >
<!-- Clients Details starts here -->
<!-- Clients Details starts here -->
<table width="100%" style="margin-left:10px;" >
<tr>
<td colspan="3">
<? if ($rate!="") {echo "<h4>Client Rate :&nbsp;" .$rate."</h4>"; }?></p></td>
</tr>
<tr>
<td ><b>Client ID </b></td><td>:</td>
<td><? echo $personal_id;?></td>
</tr>
<tr>
<td width="14%" ><b>Client </b></td><td>:</td>

<td width="86%"><? echo $fname." ".$lname;?></td>
</tr>
<tr>
<td ><b>Date Registered	</b></td><td>:</td>
<td><? echo format_date($timestamp);?></td>
</tr>
<tr>
<td ><b>Email </b></td><td>:</td>
<td><? echo $email;?></td>
</tr>
<tr>
</table>
<!-- Clients Details ends here -->
<!-- Clients Details ends here -->

</td>
</tr>
<tr bgcolor="#666666" >
  <td width=100%  colspan=2><b><font color="#FFFFFF">Advertise Positions</font></b></td>
</tr>
<tr>
<td colspan="2">
<?
/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status

$row = mysql_fetch_array($result);
$jobposition=$row['jobposition'];
*/
$sqlJobPosition ="SELECT * FROM posting WHERE id = $pid;";
$res=mysql_query($sqlJobPosition);
$row = mysql_fetch_array($res);
$jobposition=$row['jobposition'];


$query="SELECT a.id,u.userid, u.fname, u.lname,DATE_FORMAT(a.date_apply,'%D %b %Y'),u.image
		FROM personal u JOIN applicants a ON a.userid = u.userid 
		JOIN posting p ON a.posting_id = p.id 
		WHERE a.posting_id =$pid  AND p.lead_id = $leads_id AND a.status = '$stat' ORDER BY a.date_apply DESC;";
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
 
?>
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td>


<div id="l"><font size="+1"><b><a href='#'  onClick= "javascript:popup_win('./ads2.php?id=<? echo $pid;?>',800,500);">
<? echo $jobposition;?></a></b></font></div>  <br>
<p align="right"><font color="#0000FF" size="+1"><b><? echo $stat;?>&nbsp;Applicant(s)</b></font></p>

<? echo $folder;?>

</td></tr>

<tr><td>
<? if ($stat!="Hired") {?>
<br>
Select candidate and click an action below
<p>

<input type="submit" name="Invite" value="Invite to Phone Interview" style="width:160px;" class="button2" >&nbsp;&nbsp;
<input style="width:100px" type="submit" name="Prescreen" value="Prescreen" class="button2">&nbsp;&nbsp;
<input style="width:100px" type="submit" name="Shortlist" value="Shortlist" class="button2">&nbsp;&nbsp;
<input  type="submit" style="width:120px" name="Kept" value="Kept for Reference" class="button2">&nbsp;&nbsp;
<input type="submit" style="width:100px" name="Hire" value="Hire" class="button2">&nbsp;&nbsp;
<input type="submit" name="Reject" value="Reject" style="width:100px" class="button2" >&nbsp;
<input type="submit" name="delete" id="delete" value="Delete" style="width:100px" class="button2" title="Delete from List of Applications" >
</p>
<p>&nbsp;</p>
<? } else { echo "<p>&nbsp;</p>";}?>
</td></tr>
<tr><td>
<? if ($stat!="Hired") {?>
<table width=100% class="tablecontent" cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr><td bgcolor=#333366 height=2 colspan="7"></td></tr>
<tr bgcolor="#666666" >
<td width='4%' height="20" align=left><b><font size='1' color="#FFFFFF">#</font></b></td>
<td width="3%"></td>
<td width='30%' align=left><b><font size='1' color="#FFFFFF">Name </font></b></td>
<td width='9%' align=left><b><font size='1' color="#FFFFFF">Date Applied</font></b></td>
<td width='54%' align=center><b><font size='1' color="#FFFFFF">Skills</font></b></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	while(list($aid,$userid,$fname,$lname,$date,$image) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
if ($image!="")
{
	$filename = $image;
	if (file_exists($filename))
	{
		//echo "The file $filename exists";
		$pic= "<img border=0 src=$image width=110 height=150>";
	} else {
		$image="http://www.remotestaff.com.au/".$image;
		//echo $image;
		$pic= "<img border=0 src=$image width=110 height=150>";
		//echo "The file $filename does not exist";
	}
}
else
{
$pic= "<img border=0 src=images/Client.png width=110 height=150>";
} //
		
	
?>
	<tr bgcolor=<? echo $bgcolor;?>>
	<td width='4%' height="20" align=left valign="top"><? echo $counter;?>)</td>
	<td valign="top">
	  <input type="checkbox" onClick="check_val()" name="users" value="<? echo $aid;?>" ></td>

	<td width='30%' align=left valign="top"><font size='1'>
	<a href='#' onMouseOut="hideddrivetip();" onMouseOver="ddrivetip('<?=$pic;?>')" class='link5' onClick= "javascript:popup_win('./resume2.php?userid=<? echo $userid;?>&aid=<? echo $aid;?>',800,500);"><b>
	<? echo $fname." ".$lname;?>	</b></a>
<? 
$sql="SELECT latest_job_title FROM currentjob c WHERE c.userid= $userid;";
$result2=mysql_query($sql);
list($latest_job_title)=mysql_fetch_array($result2);
if ($latest_job_title!=""){ echo "<br><b style='color:#660000'>".$latest_job_title."</b>";}
?>
	</font></td>
	<td width='9%' align=left valign="top"><font size='1'><? echo $date;?></font></td>
	<td width='54%' align=center valign="top"><font size='1'>
	<div style="margin-left:10px; text-align:center">
<i>
<?
$sqlSkill="SELECT skill FROM skills WHERE userid=$userid ;";
$resultSkill=mysql_query($sqlSkill);
while(list($skill) = mysql_fetch_array($resultSkill))
{
		echo $skill.",&nbsp;&nbsp;";
}
?>
</i></div>

	</font></td>
	</tr>
 <?
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}	
	?>
<tr><td bgcolor=#333366 height=1 colspan="7"></td></tr>
</table>
<!-- Script Here -->

<? }?>
<? if ($stat=="Hired") {?>
<table border='0' width="98%" cellspacing='2' style='margin:0px 3px 0px 4px' align="center">
<tr><td bgcolor=#333366 height=2 colspan="7"><font color="#FFFFFF"><b>Hired Applicants</b></font></td></tr>
<?
/*userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality
*/
$query="SELECT a.id,u.userid, u.fname, u.lname,DATE_FORMAT(a.date_apply,'%D %M %Y'),u.nationality,e.educationallevel,e.fieldstudy,u.email,u.skype_id,yahoo_id,image,p.agent_id
		FROM personal u JOIN applicants a ON a.userid = u.userid 
		JOIN posting p ON a.posting_id = p.id 
		JOIN education e ON e.userid = u.userid
		WHERE a.posting_id =$pid AND p.lead_id = $leads_id AND a.status = '$stat' ORDER BY a.date_apply DESC;";
//echo $query;
$result=mysql_query($query);
while(list($aid,$userid,$fname,$lname,$date,$nationality,$educationallevel,$fieldstudy,$email,$skype,$yahoo,$image,$agent_id) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		 
		 

?>
	<tr>
	<td valign='top' class='adcell'>
	<div class='paidadbox'>
	<img class='topabsolute' src='images/paidad-ulc.gif'  style='left:0px'/>
	<img class='topabsolute' src='images/paidad-urc.gif' style='right:0px'/>
	<div class='adtitlediv' onClick="togglepaidad('<? echo $counter;?>')">
	<div class='paidadtranstype'><? echo $fname."  ".$lname; ?></div>
	<img id='pimg<? echo $counter; ?>' class='adarrow' src='images/paidad-dn-arw.gif' /> </div>
	<div id='paidadbody<? echo $counter; ?>' class='paidadbody' style='display:none'>
	<img class='topabsolute' src='images/paidad-lsplitter.gif' style='left:0px;  z-index:2'/>
	<img class='topabsolute' src='images/paidad-rsplitter.gif' style='right:0px; z-index:2'/>
	<img class='topabsolute' src='images/adbkg-splitter.gif'   width='100%' height='8' style='z-index:1' />
	<div class='addesc'>
	
<?
echo "<form name='form' method='post' action='contract.php'>
 	<input type='hidden' name='leads_id' value='$leads_id'>
	<input type='hidden' name='posting_id' value='$pid'>
	<input type='hidden' name='agent_no' value='$agent_id'>
	<input type='hidden' name='aid' value='$aid'>
	<input type='hidden' name='userid' value='$userid'>
	<table width='70%' cellpadding='5' cellspacing='0' style='border:#CCCCCC solid 1px;' align='center'>
	<tr><td width='42%' valign='top' style='border-right:#CCCCCC solid 1px;'>
	<table width='100%' height='100%' cellpadding='2' cellspacing='0'>
	<tr>
	<td width='38%'><strong><font size='1'>Date Applied</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><font size='1'>".$date."</font></td>
	</tr>
	<tr>
	<td width='38%'><strong><font size='1'>Nationality</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><font size='1'>".$nationality."</font></td>
	</tr>
	<tr>
	<td width='38%'><strong><font size='1'>Email</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'>".$email."</td>
	</tr>
	<tr>
	<td width='38%'><strong><font size='1'>Skype ID</font></strong></td>
	<td width='3%'><strong>:</strong></td>
	<td width='59%'><font size='1'>".$skype."</font></td>
	</tr>
	<tr>
	<td colspan='3'>		</td>
	</tr>
	</table>
	</td>
	<td width='19%'  valign='top'>
	<!-- Table Money -->
	<img src='$image' width='155' height='160' />
	<!-- Table Money End Here-->	</td>
	<td width='39%' valign='middle' align='center'>
	  <p><font size='1'><b>Process Contract Details</b></font></p>
	  <p><input type='submit' name='process' value='Process' /></p>
	    Move Back to <br>
		<select name='folder' class='text'>
		 <option value=''>-</option>
        <option value='Invite to Interview'>Invite to Interview</option>
        <option value='Prescreened'>Prescreened</option>
        <option value='Shortlisted'>Shortlisted</option>
        <option value='Kept for Referenced'>Kept for Referenced</option>
        <option value='Rejected'>Rejected</option>
      	</select><br>
		<input type='submit' name='move' value='Move' />
		</td>
	</tr>
	</table>
	
</form>";
?>
	</div>
	<img src='images/ad-llc.gif' style='position:absolute; left:0px;  z-index:2'/>
	<img src='images/ad-lrc.gif' style='position:absolute; right:0px; z-index:2'/>
	<img src='images/ad-lm.gif'  width='100%' height='9' style='position:absolute; z-index:1'/>	</div>
	</div>	</td>
    </tr>

<? }?>
<tr><td height=1 colspan="7">&nbsp;</td></tr>
<tr><td width="100%" colspan="7">&nbsp;
</td></tr>
</table>
<? }?>

</td></tr>
</table></td>
</tr>
</table>
<? if ($stat!="Hired") {?>
</form>
<? }?>
<!-- skills list -->
<br clear=all><br>
</td></tr></table></td>

</tr></table>
				</td></tr>
	  </table>
		</td>
		
		
  </tr>
</table>
<? include 'footer.php';?>	
	

</body>
</html>
