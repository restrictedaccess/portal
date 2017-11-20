<?
include 'config.php';
include 'conf.php';
include 'time.php';


if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];


//// USE FOR PAGING ///
// how many rows to show per page
$rowsPerPage = 100;
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
//////////////////////
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";
$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}
$query=="";
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$companyname=$_REQUEST['company_name'];
$promotional_code=$_REQUEST['promotional_code'];
$companyaddress=$_REQUEST['company_address'];
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];

$agent_fname=$_REQUEST['agent_fname'];
$agent_lname=$_REQUEST['agent_lname'];
$date_registered=$_REQUEST['date_registered'];
$month=$_REQUEST['month'];

$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
 for ($i = 0; $i < count($monthArray); $i++)
  {
      if($month == $monthArray[$i])
      {
	 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
      else
      {
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
   }

$leads=$_REQUEST['leads'];
$users=explode(",",$leads);
if(isset($_POST['delete']))
{
	for ($i=0; $i<count($users);$i++)
	{	$sqlDeleteLeads="DELETE FROM leads WHERE id=".$users[$i];
		//echo $sqlDeleteLeads."<br>";
		mysql_query($sqlDeleteLeads);
	}
}



if($agent_fname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %M %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %M %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND a.fname ='$agent_fname' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";

$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND a.fname ='$agent_fname';";

}
if($agent_lname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND a.lname = '$agent_lname' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";

$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND a.lname = '$agent_lname';";


}


if($fname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.fname like '$fname' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";

$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.fname like '$fname';";

}

if($lname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.lname like '$lname' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";

$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.lname like '$lname';";


}

if($fname!="" && $lname!="" )
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.fname ='$fname' AND l.lname ='$lname' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.fname ='$fname' AND l.lname ='$lname';";

}


if($companyname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.company_name like '$companyname' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";

$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.company_name like '$companyname';";

}

if($promotional_code!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.tracking_no LIKE '$promotional_code%' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.tracking_no LIKE '$promotional_code%';";

}

if($companyaddress!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.company_address like '$companyaddress%' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.company_address like '$companyaddress%';";

}


if($email!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.email = '$email' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.email = '$email';";

}

if($mobile!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' AND l.mobile = '$mobile' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND l.mobile = '$mobile';";

}

if($date_registered!="")
{
	//echo $date_registered;
	$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
	l.remote_staff_needed,
	l.fname,l.lname,
	l.company_position,
	l.company_name,l.email,l.company_turnover ,l.rating,
	DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
	DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
	a.agent_no,a.fname,a.lname,a.work_status
	,l.leads_country,leads_ip
	FROM leads l
	JOIN agent a ON a.agent_no = l.agent_id
	WHERE l.status = 'Contacted Lead' AND DATE_FORMAT(l.timestamp,'%Y-%m-%d') = '$date_registered' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
	$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND DATE_FORMAT(l.timestamp,'%Y-%m-%d') = '$date_registered';";
}
//
if($month!="")
{
	//echo $date_registered;
	$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
	l.remote_staff_needed,
	l.fname,l.lname,
	l.company_position,
	l.company_name,l.email,l.company_turnover ,l.rating,
	DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
	DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
	a.agent_no,a.fname,a.lname,a.work_status
	,l.leads_country,leads_ip
	FROM leads l
	JOIN agent a ON a.agent_no = l.agent_id
	WHERE l.status = 'Contacted Lead' AND DATE_FORMAT(l.timestamp,'%m') = '$month' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
	$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead' AND DATE_FORMAT(l.timestamp,'%m') = '$month';";
}


if($query=="")
{

$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname,a.work_status
,l.leads_country,leads_ip
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Contacted Lead' ORDER BY l.timestamp DESC LIMIT $offset, $rowsPerPage;";
$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l JOIN agent a ON a.agent_no = l.agent_id WHERE l.status = 'Contacted Lead';";
}


?>

<html>
<head>
<title>Administrator Contacted Lead</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/leads_tab.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
<script type="text/javascript">
<!--
function checkFields()
{
	if (confirm("Are you sure"))
	{
		return true;
	}
	else return false;		
	
}

function check_val2()
{

userval =new Array();
//var userlen = document.form.userss.length;
var userlen = document.getElementsByName("userss").length;

var counter=0;
for(i=0; i<userlen; i++)
{
	if(document.getElementsByName("userss")[i].checked==true)
	{	
		userval.push(document.getElementsByName("userss")[i].value);
		counter++;
	}
}
if(counter<6) {
document.getElementById("leads").value=(userval);
}else
{
	alert("Maximum of 5 records is allowed to Delete !");
}

}
-->
</script>	
<style type="text/css">
<!--
.pagination{
padding: 2px;
text-align:center;
float:left;
margin-left:20px;

}

.pagination ul{
margin: 0;
padding: 0;
text-align: center; /*Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 11px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

.add_note{
 FONT: 8pt Verdana; 
}
-->
</style>	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
 <li ><a href="adminHome.php"><b>Home</b></a></li>
  <li ><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li class="current"><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>

<!-- /CONTENT -->
<br>

<form name="form" method="post" action="admincontactedleads.php" >
<input type='hidden' id='leads' name="leads" >
<table width="98%" border="0" style="border:#666666 solid 1px; margin-left:10px; margin-right:1px;">
    <tr>
      <td height="21" colspan="8" valign="top"><b>Advanced Search</b></td>
    </tr>
    <tr>
      <td width="10%" align="right">First Name :</td>
      <td width="14%"><input type="text" name="fname" ></td>
      <td width="10%" align="right">Last Name :</td>
      <td width="14%"><input type="text" name="lname" ></td>
      <td width="12%" align="right">Company Name :</td>
      <td width="15%"><input type="text" name="company_name" ></td>
      <td width="10%" align="right">Promotional Code :</td>
      <td width="15%"><input type="text" name="promotional_code" ></td>
    </tr>
    <tr>
      <td height="38" align="right">State :</td>
      <td><input type="text" name="company_address" ></td>
      <td align="right">Email Add :</td>
      <td><input type="text" name="email" ></td>
      <td align="right">Mobile No. :</td>
      <td><input type="text" name="mobile" ></td>
	   <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
	<td height="38" colspan="" align="right"><b>Agent Firstname :</b></td>
      <td colspan=""><input type="text" name="agent_fname" ></td>
      <td align="left"  ><b>Agent Lastname :</b></td>
      <td colspan=""><input type="text" name="agent_lname" ></td>
	   <td align="right"  ><b>Date Registered :</b></td>
      <td colspan=""><input type="text" name="date_registered" id="date_registered" value="<?=$date_registered;?>" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "date_registered",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td>
	   <td align="right"  ><b>Month of :</b></td>
      <td colspan=""><select name="month"  style="font-size: 12px;" class="text" onChange="javascript: document.form.submit();">
<? echo $monthoptions;?>
</select></td>
	</tr>
    <tr>
      <td colspan="8" align="center"><input type="submit" name="search" class="button" value="Search" onClick="show();">&nbsp;<input type='submit' name='delete' value='Delete Leads' class='button' style=' width:150px;'>
	  <div align="center"  id="searching"></div>
	  <script type="text/javascript">
	  <!--
	  function show()
	  {
	  	newitem1="<img src=\"images/loading.gif\" alt=\"loading\">Searching.......";
		document.getElementById("searching").innerHTML=newitem1;
	  }
	  -->
	  </script>	  </td>
    </tr>
	</table>
 </form>
<?
//echo $query;
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
?>
<table width=99% cellspacing=0 cellpadding=0 align=center>
<tr><td><table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr><td colspan="11"><div style=" float:left;"></div>
<div class="pagination">
<ul>
<?
$result_page  = mysql_query($query2) or die('Error, query failed');
$row     = mysql_fetch_array($result_page);
$numrows = $row['numrows'];
//echo $numrows;
// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);
// print the link to access each page
$self = "./admincontactedleads.php";
$nav = '';
for($page = 1; $page <= $maxPage; $page++)
{
	if ($page == $pageNum)
	{
		//$nav .= " $page ";   // no need to create a link to current page
		$nav .= " <li><a class='currentpage' href=\"$self?page=$page\">$page</a></li> ";
	}
	else
	{
		$nav .= " <li><a href=\"$self?page=$page\">$page</a></li> ";
	}
}
// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
	$page = $pageNum - 1;
	$prev = " <li><a class='prevnext disablelink' href=\"$self?page=$page\">[Prev]</a></li> ";
	$first = "<li><a href=\"$self?page=1\">[First Page]</a></li>";
}
else
{
	$prev  = '&nbsp;'; // we're on page one, don't print previous link
	$first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage)
{
	$page = $pageNum + 1;
	$next = " <li><a class='prevnext' href=\"$self?page=$page\">[Next]</a></li>";
	$last = " <li><a href=\"$self?page=$maxPage\">[Last Page]</a></li> ";
}
else
{
	$next = '&nbsp;'; // we're on the last page, don't print next link
	$last = '&nbsp;'; // nor the last page link
}

	//echo $numrows;
	echo $first . $prev . $nav. $next . $last;
	echo "Note : shows 100 rows per page&nbsp;&nbsp;";
	echo "[".$numrows."&nbsp;rows results]";

?>
</ul>
</div>
<div style="clear:both;">&nbsp;</div>
</td></tr>
  <tr bgcolor='#666666'>
    <td width='4%' align=left><b><font  color='#FFFFFF'>#</font></b></td>
	<td width="2%" class="leads_label"><img src="images/delete.png" alt="Delete This Applicant"></td>
	<td width='8%' class="leads_label" align=left><b><font  color='#FFFFFF'>BP/AFF</font></b></td>
	<td width="2%" class="leads_label"><b><font  color='#FFFFFF'>Edit</font></b></td>
    <td width='13%' class="leads_label" align=left><b><font  color='#FFFFFF'>Name</font></b></td>
    <td width='12%' class="leads_label" align=left><b><font  color='#FFFFFF'>Company Position</font></b></td>
    <td width='10%' class="leads_label" align=left><b><font  color='#FFFFFF'>Date Registered</font></b></td>
    <td width='10%' class="leads_label" align=LEFT><b><font  color='#FFFFFF'>Promotional Code</font></b></td>
    <td width='9%' class="leads_label" align=left><b><font  color='#FFFFFF'>Company</font></b></td>
    <td width='9%' class="leads_label" align=left><b><font  color='#FFFFFF'>Email</font></b></td>
     <td width='23%'  class="leads_label"align=left><b><font  color='#FFFFFF'>Remarks</font></b></td>
  </tr>
  <?
	$bgcolor="#FFFFFF";
	$counter=$offset;
	//id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
	while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$fname,$lname,$company_position,$company_name,$email,$company_turnover,$rate,$inactive_since,$personal_id,$date_move,$agent_from,$agent_no,$agent_fname,$agent_lname,$work_status,$leads_country,$leads_ip) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
			  if($rate=="1")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	$add_remark='<form name="add_remark_form" method="post" action="leads_add_remark.php">
		 <input type="hidden" name="leads_id" value='.$id.'>
		 <input type="hidden" name="created_by_id" value='.$admin_id.'>
		 <input type="hidden" name="remark_created_by" value="ADMIN">
		 <input type="hidden" name="url" value='.$_SERVER['PHP_SELF'].'>
		 <textarea style="width:100%;" rows="4" class="add_note" name="remarks"></textarea>
		 <input type="submit" name="save_remark" value="Save" class="add_note">
		 <input type="button" class="add_note" name="cancel_remark" value="Cancel" onClick="javascript: show_hide('."'$id'".');"></form>';		
?>
  <tr bgcolor=<? echo $bgcolor;?>>
    <td width='4%' class="leads_label" align=left><? echo $counter.")";?>
     </td>
	<td class="leads_label"><input name="userss" id="userss" type="checkbox" onClick="check_val2(<? echo $id;?>);" value="<? echo $id;?>" title="Delete Lead <?=$fname." ".$lname;?>"  ></td>
	 <td width='8%' class="leads_label" align=left><? echo $work_status." : ".$agent_fname;?></td>
	 <td width="2%" class="leads_label"><a href="admin_updateinquiry.php?leads_id=<? echo $id;?>&page=CONTACT"><img src="images/b_edit.png" border="0"></a></td>
    <td width='13%' class="leads_label" align=left><div style="cursor:pointer; color:#0000FF; font-weight:bold;" onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);> <? echo $fname." ".$lname;?></div>
      <? echo $rate;?>
	   <?="<div>".$leads_country."</div>";?>
	  <?="<div>".$leads_ip."</div>";?>
</td>
    <td width='12%' class="leads_label" align=left><? echo $company_position;?></td>
    <td width='10%' class="leads_label" align=left><? echo $timestamp;?></td>
    <td width='10%' class="leads_label" align=LEFT><a href='#'onClick=javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);><? echo $tracking_no;?></a></td>
    <td width='9%' class="leads_label" align=left><? echo $company_name;?></td>
    <td width='9%' class="leads_label" align=left><? echo $email;?></td>
	  <td width='23%' class="leads_label" align=left valign="top">
	 <div style="float:left;">
	<input type="button" class="add_note" name="add_remark" value="Add" title="Add a Remarks/Notes" onClick='javascript: show_hide("<? echo $id;?>");'>
	</div>
 <div id="<?=$id;?>" style="position:absolute; display:none; padding:5px; z-index:2; background:#F3F3F3; border:#000000 solid 1px; text-align:center; width: 226px; left: 960px; ">
<span>Add remarks (<? echo $fname." ".$lname;?>)</span>
		   <? echo $add_remark;  ?></div>
<div style="float:left; margin-left:10px; z-index:1;">
	<small style="color:#999999;"><? 
			   if($date_move!="")
			   {
			   		$sql="SELECT * FROM agent WHERE agent_no = $agent_from";
					$resulta=mysql_query($sql);
					$ctr=@mysql_num_rows($resulta);
					if ($ctr >0 )
					{
						$row = mysql_fetch_array ($resulta); 
						$name = $row['fname'];
					}
			   		echo "Came from BP : " .$name." ".$date_move."<br>";
			   }
			   
			   if($inactive_since!="")
			{	$personalid=substr($personal_id,0,1);
				if($personalid=="C")
				{
					//$remarks ="Move back to Contacted List from Client since ".$inactive_since;
					echo "Move back to Contacted List from Client since ".$inactive_since."<br>";
				}	
			}
			//echo $remarks;
			/// determine if the the leads has a remarks
			$sqlCheckRemark="SELECT * FROM leads_remarks WHERE leads_id = $id ORDER BY id DESC;";
			//echo $sqlCheckRemark;
			$get_result=mysql_query($sqlCheckRemark);
			$check_result=@mysql_num_rows($get_result);
			 if($check_result>0)
			 {
			 	$row_result=mysql_fetch_array($get_result);
				echo '<a href="javascript: show_hide('."'leads$id'".');">'.substr($row_result['remarks'],0,40)."</a>";
			 	//$meron="TRUE";
			 }  
			   ?>
	    </small>
	  </div>
			  
			   <div style="clear:both;"></div>
			   
	      </td>
  </tr>
 <? 
if($check_result>0)
{
?>
  <tr>
  <td colspan="7" valign="top"></td>
  <td colspan="3" class="leads_label">
  <div id="leads<?=$id?>" style="display:none">
  <b>Remarks</b>
  <?
  // id, leads_id, remark_creted_by, created_by_id, remark_created_on, remarks
  $sqlGetAllRemarks="SELECT remark_creted_by,remarks ,DATE_FORMAT(remark_created_on,'%D %b %Y') FROM leads_remarks WHERE leads_id = $id ORDER BY id DESC;";
  $get_all_result=mysql_query($sqlGetAllRemarks);
  while(list($remark_creted_by,$remarks,$remarks_date)=mysql_fetch_array($get_all_result))
  {
  	echo '<p style="margin-top:2px;margin-bottom:2px;"><label style="float:left; margin-left:2px; display:block; width:100px;">'.$remark_creted_by.'</label>'.$remarks.'</p>';
	
  }
  ?>
  <div style="clear:both;"></div>
  </div>
  </td>
  </tr>
<? }?>  
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
</table></td>
</tr>
	<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1></td></tr></table>
<script language=javascript>
<!--
	function go(id,name) 
	{
			//if (confirm("You selected " + name + " ?")) {
				location.href = "apply_action.php?id="+id;
				//alert(id);
			//}
		
	}
	
	
//-->
</script>

	

<? include 'footer.php';?>

</body>
</html>
