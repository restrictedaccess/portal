<?
include 'config.php';
include 'function.php';
include 'conf.php';
$mess="";
$mess=$_REQUEST['mess'];
$agent_no = $_SESSION['agent_no'];

$applicants =$_REQUEST['applicants'];
if($applicants!="") {
$users=explode(",",$applicants);
for ($i=0; $i<count($users);$i++)
{
	$email.=$users[$i].";";
}
	$emails=$email;
}	
	

$sql ="SELECT * FROM agent WHERE agent_no = $agent_no;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$agent_code = $row['agent_code'];
	$lname = $row['lname'];
	$fname = $row['fname'];
	$email = $row['email'];
	//$desc= str_replace("\n","<br>",$desc);
	
}
$query="";
$flag=0;
$search=$_REQUEST['search'];
$keyword=$_REQUEST['keyword'];

if($search!="all"){
	$leads_status = " AND status = '$search' ";
}else{
	$leads_status = " AND status != 'Inactive' ";
}

if($keyword!=NULL){
# convert to upper case, trim it, and replace spaces with "|": 
$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
# create a MySQL REGEXP for the search: 
$regexp = "REGEXP '^.*($search).*\$'"; 
$keyword_search = " AND (
				UPPER(tracking_no) $regexp 
				OR UPPER(l.lname) $regexp 
				OR UPPER(l.fname) $regexp 
				OR UPPER(company_position) $regexp 
				OR UPPER(company_name) $regexp 
				OR UPPER(company_address) $regexp 
				OR UPPER(l.email) $regexp 
				OR UPPER(company_turnover) $regexp 
				OR UPPER(officenumber) $regexp 
				OR UPPER(mobile) $regexp 
				) ";

}else{
	$keyword_search = " ";
}

if($query=="")
{
	$query="SELECT id,fname,lname,email,DATE_FORMAT(timestamp,'%D %b %Y'),rating,status
	FROM leads l
	WHERE business_partner_id = $agent_no  $leads_status  $keyword_search ORDER BY timestamp DESC;";
	$flag=1;
	//echo $query;
}

$searchArrays=array("New Leads","Follow-Up","Keep In-Touch","Client","pending");
for ($i = 0; $i < count($searchArrays); $i++) {
      if($search == $searchArrays[$i])
      {
	 $searchoptions .= "<option selected value=\"$searchArrays[$i]\">$searchArrays[$i]</option>\n";
      }
      else
      {
	 $searchoptions .= "<option value=\"$searchArrays[$i]\">$searchArrays[$i]</option>\n";
      }
   }	



?>

<html>
<head>
<title>Email Campaigns</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkFields()
{
	
	if(document.form.templates[0].checked==false && document.form.templates[1].checked==false )
	{
		alert("Please choose Email Templates !");
		return false;
	}
	if(document.form.emails.value=="")
	{
		 alert("There is no email(s) address.");
		 return false;
	}
	 return true;
	
	
	
}



-->
</script>	
<style>
<!--
.rad
{
	height:20px;
	width:50px;
}
div.scroll {
		height: 200px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
-->
</style>
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_header.php';?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td colspan="3" bgcolor="#ffffff" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="220"  bgcolor="#ffffff" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '><? include 'agentleftnav.php';?></td>
<td width="100%" bgcolor="#ffffff" valign="top">
<table width="100%">
<tr>
<td valign="top" colspan="2">
<form name="form2" method="post" action="sendAds.php">
<div id="searchControl" style="border:#666666 solid 1px; margin-left:5px; margin-right:5px;">
  <table width="99%" border="0" cellpadding="1" cellspacing="0">
  <?
  if($mess==2){
	echo "<tr><td colspan='8' bgcolor='#FFFFCC' align='center'><b>Email Sent</b></td></tr>";
}

  
  ?>
   <tr bgcolor='#666666'>
      <td height="21" colspan="8" valign="middle"><font color="#FFFFFF">&nbsp;&nbsp;<b>Advanced Search</b></font></td>
    </tr>
	<tr>
      <td height="21" colspan="8" valign="middle"><br>
&nbsp;&nbsp;<b>Search Leads In :</b>&nbsp;
<select name="search" class="select" >
<option value="all">Search all folders</option>
  <? echo $searchoptions;?>
</select> &nbsp;Search : <input type="text" name="keyword" id="keyword" value="<?=$keyword;?>" style=" width:300px;" >
&nbsp;<input type="submit" name="search2" value="Search" onClick="show();">
	  <div align="center"  id="searching"></div>
	  <script type="text/javascript">
	  <!--
	  function show()
	  {
	  	newitem1="<img src=\"images/loading.gif\" alt=\"loading\">Searching.......";
		document.getElementById("searching").innerHTML=newitem1;
		
	  }
	  -->
	  </script>	  
<hr></td>
    </tr>
   
    
	<tr><td colspan="8">
	<!-- Listings Here -->
	
<?
if($flag ==1) {
//echo $query;
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
?>
<div class="scroll">
<table width="99%" border="0" cellpadding="1" cellspacing="0" style="margin-left:5px; border:#CCCCCC solid 1px;">
<tr bgcolor='#666666'>
<td width="6%"  valign="top"><font color="#FFFFFF" size="1"><b>#</b></font></td>
<td width="2%"><img src="images/action_check.gif" alt="Select All" onClick="checkAll()" style="cursor: pointer;" title="Click to select all"></td>
<td width="27%"  valign="top"><font color="#FFFFFF" size="1"><b>Name</b></font></td>
<td width="18%"  valign="top"><font color="#FFFFFF" size="1"><b>Status</b></font></td>
<td width="20%"  valign="top"><font color="#FFFFFF" size="1"><b>Email</b></font></td>
<td width="14%"  valign="top"><font color="#FFFFFF" size="1"><b>Date Registered</b></font></td>
<td width="13%"  valign="top"><font color="#FFFFFF" size="1"><b>Ratings</b></font></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	//id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
	while(list($id,$fname,$lname,$email,$date,$rate,$status) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
<tr bgcolor=<? echo $bgcolor;?>>
<td width="6%"  valign="top"><font  size="1"><? echo $counter;?>)</font></td>
<td><input type="checkbox" onClick="check_val(<? echo $id;?>)" name="users" id="users"  value="<? echo $email;?>" ></td>
<td width="27%"  valign="top"><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);><font  size="1"><b><? echo $fname." ".$lname;?></b></font></a></td>
<td width="18%"  valign="top"><font  size="1"><? echo $status;?></font></td>
<td width="20%"  valign="top"><font  size="1"><b><? echo $email;?></b></font></td>
<td width="14%"  valign="top"><font  size="1"><? echo $date;?></font></td>
<?
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
	?>	
	<td width="13%"  valign="top"><font  size="1"><? echo $rate;?></font></td>
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

 }?>
</table>
</div>
<? }?>
<input type="hidden" id="applicants" value="">
<script type="text/javascript">
<!--
function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2;
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true)
		{
			if(ins[i].value!="" || ins[i].value!="undefined")
			{
				vals[j]=ins[i].value;
				j++;
			}		
		}
	}

//document.form.applicants.value=(vals);
document.getElementById("applicants").value=(vals);
document.getElementById("emails").value =(vals);
}


function checkAll()
{
	/*
	userval2 =new Array();
	for (i = 0; i < field.length; i++)
		{
	   		field[i].checked = true ;
			userval2.push(field[i].value);	
		}
	document.getElementById("emails").value=(userval2);
	*/
	var ins = document.getElementsByName('users')
	var i;
	var x;
	var j=0;
	var vals= new Array();
	var vals2;
	for(i=0;i<ins.length;i++)
	{
		vals[j]=ins[i].value;
		ins[i].checked = true ;
		j++;
		
	}

//document.form.applicants.value=(vals);
document.getElementById("applicants").value=(vals);
document.getElementById("emails").value =(vals);
	
}
-->
</script>

	
	<!-- Listings Here -->
	
	</td></tr>
  </table>


</div>
</form>
</td>
</tr>
<!-- next -->
<form method="POST" name="form" action="sendAdsphp.php" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="fill" value="">

<tr>
<td width="54%" valign="top"><table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td bgcolor=#DEE5EB colspan=2><b>Send Email Campaigns</b></td>
</tr>
<tr><td colspan="2" valign="top">
<b>Promotional Codes</b><br>
<div class='scroll'>
<?
$counter = 0;
$query="SELECT id,tracking_no, DATE_FORMAT(tracking_created,'%D %M %Y'), tracking_createdby,tracking_desc FROM tracking WHERE tracking_createdby =$agent_no AND status ='NEW' ORDER BY tracking_created DESC;";
//DATE_FORMAT(a.dateapplied,'%M %e %Y')
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
 echo "<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td bgcolor=#333366 height=2></td></tr>
<tr><td>


<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='6%' align=left>#</td>
<td width='40%' align=left><b><font size='1'>Promotional Codes</font></b></td>
<td width='40%' align=left><b><font size='1'>Date Created</font></b></td>

<td width='37%' align=center><b><font size='1'>Choose</font></b></td>
</tr>";

	$bgcolor="#f5f5f5";
	while(list($id,$tracking_no,$date,$creator,$details) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		

		echo "<tr bgcolor=$bgcolor>
			  <td width='6%' align=left><font size='1'>".$counter.")</font></td>
			  <td width='40%' align=left><font size='1'>
			  <a href='#'"."onClick="."javascript:popup_win('./viewTrack2.php?id=$id'".",500,400); title='$details'>".$tracking_no."</a>
			  </td>
			  <td width='40%' align=left><font size='1'>".$date."</font></td>
			 
			  
			  <td width='37%' align=center><font size='1'><input type='radio' name='tracking_no' value=$tracking_no class='rad' onclick ='go($id)' ></font></td>
			 </tr>";
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}	
	//javascript:popup_win(./viewTrack.php?id=$id,500,400);
echo "</table>
	</td></tr>
	<tr><td bgcolor=#333366 height=1>
	<img src='images/space.gif' height=1 width=1></td></tr></table>";
	
	
}
?>
<script language=javascript>
<!--
	function go(id) 
	{
		document.form.fill.value=id;			
	}
-->
</script>
</div>	
</td></tr>
<tr>
<td colspan="2">
<b>Subject :</b>(Optional)<br>
<input type="text" name="subject" value="" size="50"></td>
</tr>

<tr>
<td colspan="2">
<b>Message :</b>(Optional)<br>
<textarea name="message" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"></textarea></td>
</tr>

<tr>
<td>File Attachement :</td>
<td width="78%"><input name="image" type="file" id="image" class="text" ></td>
</tr>

<tr><td colspan=2 >
Type multiple email address here separated by (",") comma in sending message to multiple clients.<br>
<textarea name="emails" id="emails" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"><? echo $emails;?></textarea><br>

</td></tr>
<tr><td align=right width=22% >&nbsp;</td>
<td>&nbsp;</td></tr>

<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<INPUT type="submit" value="Send Message" name="send" class="button" style="width:120px">
</td></tr></table>
</td></tr>
</table></td>
<td width="46%" valign="top"><style>
#templates{border:#333333 solid 1px; margin-left:0px; margin-right:5px;padding:5px 0 5px 10px;}
#templates p {margin-top:3px; margin-bottom:3px;}
#templates label
{
display: block;
width:90px;
float: left;
padding-right: 1px;
font-size:11px;
text-align:right;

}
</style>		
		
		<!--<p style="margin-left:10px; background:#DEE5EB" ><b>Email Templates Sample</b></p>-->
		<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Email Templates </b></td></tr>
<tr><td width="100%" valign="top">
		<!-- Promotional temaplate -->
		<div id="templates" ><input type="radio" name="templates" value="promotional" ><font color="#0000FF"><b>Promotional Template</b></font>
		<br><br>
		<p><a href="#" class="link18" onClick="javascript:popup_win('./promo.html',800,800);"> View Sample</a></p>
		</div>
		<br>
		<br>
		<br>
		<div id="templates" ><input type="radio" name="templates" value="promotional_small" ><font color="#0000FF"><b>Signature Template</b></font>
		<br><br>
		
		<table width="98%" align="center" style=" border:#FFFFFF solid 1px;">
		<tr><td><img src="images/banner/remoteStaff-small.jpg"></td></tr>
		<tr><td width='98%' height="1" valign='top'></td></tr>
		<tr><td height="50" valign="top">
		
		<p align='justify' style='margin-left:10px; margin-top:2px;'>
		Message Here <br>
		Promotional code here
		</p>
		</td></tr>
		<tr><td height="28" width="98%" background="images/banner/remote.jpg">&nbsp;</td>
		</tr>
		<tr><td height='10' width='98%' valign="top" style='color:#999999; font-size:10px;'>
		<div style='margin-left:10px; margin-top:2px;'>
		Address :<br>
		Contact No :<br>
		Email :
		</div>
		</td></tr>
		</table>
		<br>

		</div>
		</td>
		</tr>
		</table>
</td>
</tr>
</form>
</table>
</td>
</tr>
</table>

<? include 'footer.php';?>
</body>
</html>
