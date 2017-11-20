<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}
$agent_no = $_SESSION['agent_no'];

$sql ="SELECT * FROM agent WHERE agent_no = $agent_no;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$agent_code = $row['agent_code'];
	$length=strlen($agent_code);
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$keyword=$_REQUEST['keyword'];
$event_date=$_REQUEST['event_date'];
$ratings=$_REQUEST['ratings'];
$month=$_REQUEST['month'];


$querycheck="SELECT * FROM leads WHERE agent_id =0 AND SUBSTRING(tracking_no,1,$length)='$agent_code'";
$result2=mysql_query($querycheck);
$ctr3=@mysql_num_rows($result2);
if ($ctr3 >0 )
{
	//echo "Numrows ".$ctr3;
	$updateLeads="UPDATE leads SET agent_id = $agent_no WHERE agent_id =0 AND SUBSTRING(tracking_no,1,$length)='$agent_code'";
	mysql_query($updateLeads);
}

///
$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++)
{
  //if($month == $monthArray[$i])
  //{
 //	$monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  //}
  //else
  //{
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
  //}
}

if(isset($_POST['transfer']))
{
		
	//echo "transfer";
	$keyword="";
	$applicants =$_REQUEST['applicants'];
	$agent_id=$_REQUEST['agent_id'];
	$users=split(",",$applicants);
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE leads SET  agent_id =$agent_id,date_move='$ATZ',agent_from=$agent_no WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		$queryUpdateHistory = "UPDATE history SET agent_no = $agent_id WHERE leads_id = $users[$i];";
		mysql_query($queryUpdateHistory)or trigger_error("Query: $queryUpdateHistory\n<br />MySQL Error: " . mysql_error());	
		//echo $query."<br>";
	}
	$query="";
	$month="";
}

// Count the Business Partner Leads and the Affiliates Leads
$sqlGetAgentAffi="SELECT affiliate_id FROM agent_affiliates WHERE business_partner_id = $agent_no";
$rs=mysql_query($sqlGetAgentAffi);
$AffArray=array($agent_no);
while(list($aff_id)=mysql_fetch_array($rs))
{
	array_push($AffArray, $aff_id);
}
	
//$BP_leads=0;
$AFF_leads=0;
for($i=0; $i<count($AffArray);$i++)
{
		if($AffArray[$i]==$agent_no) {
			$sqlCount="SELECT COUNT(id) AS numrows1 FROM leads l  WHERE l.status = 'Keep In-Touch' AND agent_id = ".$AffArray[$i];
			//echo $sqlCount;
			$rs2=mysql_query($sqlCount);
			$rows=mysql_fetch_array($rs2);
			$BP_leads =	$rows['numrows1'];
		}else{
			$sqlCount3="SELECT COUNT(id) AS numrows2 FROM leads l  WHERE l.status = 'Keep In-Touch' AND agent_id = ".$AffArray[$i];
			//echo $sqlCount;
			$rs3=mysql_query($sqlCount3);
			$rows2=mysql_fetch_array($rs3);
			//$AFF_leads =$rows2['numrows2'];
			$AFF_leads =$AFF_leads+$rows2['numrows2'];
		}
			
}

//echo $BP_leads."<br>";
//echo $AFF_leads."<br>";
//
?>

<html>
<head>
<title>Business Partner Keep In-Touch</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../css/leads_tab.css">
<link rel=stylesheet type=text/css href="../menu.css">

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />
<script type='text/javascript' language='JavaScript' src='../js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>

<style>
<!--
div.scroll {
		height: 400px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		margin-top:0px;
		
	}
.add_note{
 FONT: 8pt Verdana; 
}
-->
</style>
	
	
	
</head>


<body style="background:#ffffff; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="../js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
 <li ><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li class="current"><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
   <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<div style="clear:both;">&nbsp;</div
><div style="clear:both;"></div>
<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr><td bgcolor="#FFFFFF" colspan="6" valign="top">
<div id="legend_form">
<b>LEGEND</b>

<p><label ><img src='../images/action_check.gif' title='Your Regstered Keep In-Touch' /></label> : Your own Registered Keep In-Touch <span style="margin-left:10px;"><b><?=$BP_leads;?></b></span></p>
<div style="clear:both;"></div>
<p ><label><img src='../images/adduser16.png' title='Affiliate : $agent_fname&nbsp;$agent_lname Keep In-Touch' /></label> : Affiliates Keep In-Touch <span style="margin-left:20px;"><b><?=$AFF_leads;?></b></span></p>
<div style="clear:both;">&nbsp;</div>


<div style="clear:both;">&nbsp;</div>
<h3>Keep In-Touch</h3>
</div>

</td>
<td valign="top" colspan="6" bgcolor="#FFFFFF">
<form name="form" method="post" action="keep_in_touch_leads.php" >
<input type="hidden" name="applicants" value="">
<div id="leads_search_form">
<b>ADVANCED SEARCH</b>

<p><label >Search :</label><input type="text" name="keyword" id="keyword" value="<?=$keyword;?>" style=" width:300px;" > </p>
<p><label>Date Registered :</label><input type="text" name="event_date" id="event_date"  size="15" > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
	     <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "event_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></p>
<p><label>Ratings :</label><select name="ratings" class="text" onChange="setStar(this.value);" >
<option value="">-</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>
<span id="star" ></span>
<script>
<!--
function setStar(s)
{
	if (s==1)
	{
		newitem1="<img src='../images/star.png' align='top'>";
	}
	if (s==2)
	{
		newitem1="<img src='../images/star.png' align='top'><img src='../images/star.png' align='top'>";
	}
	if (s==3)
	{
		newitem1="<img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'>";
	}
	if (s==4)
	{
		newitem1="<img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'>";
	}
	if (s==5)
	{
		newitem1="<img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'><img src='../images/star.png' align='top'>";
	}	
	if (s=="")
	{
		newitem1="";
	}
	document.getElementById("star").innerHTML=newitem1;
}
-->
</script>
</p>
<p><label>Month : </label>
  <select name="month"  style="font-size: 12px;" >
    <? echo $monthoptions;?>
  </select>
</p>
<p><label>Actions :</label><input type="submit" name="search" value="Search"> &nbsp;<input type="button" name="add" value="Add New Lead" onClick="self.location='addnewlead.php'"/> &nbsp;<input type="submit" name="transfer" value="Begin Tranfer to" >&nbsp;&nbsp;
<select name="agent_id" class="text">
<option value="2">Chris Jankulovski</option>
<option value="8">Barbara  Campbell</option>
</select></p>
<div style="clear:both;"></div>
</div>
</form>
</td>
</tr>
<tr bgcolor='#666666' class="leads_label">
    <td width='2%' align=left class="leads_label"><b><font  color='#FFFFFF'>#</font></b></td>
	<td width="2%" class="leads_label"><img src="../images/configure16.png" title="Process Leads"></td>
	<td width="2%" class="leads_label"><img src="../images/groupofusers16.png" title="Leads Owner"></td>
	<td width="2%" class="leads_label"><img src="../images/undo16.png" title="Transfer Leads"></td>
    <td width='15%' align=left class="leads_label"><b><font  color='#FFFFFF'>Name</font></b></td>
    <td width='12%' align=left class="leads_label"><b><font  color='#FFFFFF'>Date Registered</font></b></td>
    <td width='11%' align=center class="leads_label"><b><font  color='#FFFFFF'>Promotional Code</font></b></td>
    <td width='17%' align=left class="leads_label"><b><font  color='#FFFFFF'>Company</font></b></td>
    <td width='17%' align=left class="leads_label"><b><font  color='#FFFFFF'>Remarks</font></b></td>
	 <td width='20%' align=left class="leads_label"><b><font  color='#FFFFFF'>Steps Taken</font></b></td>
  </tr>
<?
//Check if the Business Partner has a Affiliate
$sqlGetAgentAffiliate="SELECT affiliate_id FROM agent_affiliates WHERE business_partner_id = $agent_no";
$r=mysql_query($sqlGetAgentAffiliate);

$counter = 0;
$AffiliatesArray=array($agent_no);
while(list($affiliate_id)=mysql_fetch_array($r))
{
	array_push($AffiliatesArray, $affiliate_id);
}

for($i=0; $i<count($AffiliatesArray);$i++)
{
    $sqlGetName="SELECT * FROM agent WHERE agent_no=".$AffiliatesArray[$i];
    $res=mysql_query($sqlGetName);
	$row_res=mysql_fetch_array($res);
	if($AffiliatesArray[$i]==$agent_no){
	$BP="<b>Business Partner : </b>";	
	}else{
	//$BP="<b>Affiliate : </b>";
		if($row_res['work_status']=="BP")
		{
			$BP="<b>Business Partner : </b>";	
		}
		if($row_res['work_status']=="AFF")
		{
			$BP="<b>Affiliate : </b>";
		}
	}
	
	

if(isset($_POST['search']))
{	

if($keyword!=""){
//echo "Keyword : ".$keyword;	
$query="SELECT DISTINCT(id),tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
l.lname,l.fname,company_position,company_name,l.email,company_turnover ,
rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
agent_from ,officenumber, mobile,agent_id,
a.fname,a.lname
FROM leads l
LEFT OUTER JOIN agent a ON a.agent_no = l.agent_id
WHERE 
agent_id = ".$AffiliatesArray[$i]."
AND 
l.status = 'Keep In-Touch' 
AND
(
RTRIM(LTRIM(l.fname)) LIKE '$keyword'
OR RTRIM(LTRIM(l.lname)) LIKE '$keyword'
OR RTRIM(LTRIM(l.email)) LIKE '$keyword'
OR RTRIM(LTRIM(company_name)) LIKE '$keyword'
OR RTRIM(LTRIM(company_address)) LIKE '%$keyword%'
OR RTRIM(LTRIM(mobile)) = '$keyword'
OR RTRIM(LTRIM(officenumber)) = '$keyword'
OR RTRIM(LTRIM(tracking_no)) = '$keyword'
)
ORDER BY timestamp DESC;";
}

if($ratings!="")
{
//echo "Ratings : ".$ratings;	
$query="SELECT DISTINCT(id),tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
l.lname,l.fname,company_position,company_name,l.email,company_turnover ,
rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
agent_from ,officenumber, mobile,agent_id,
a.fname,a.lname
FROM leads l
LEFT OUTER JOIN agent a ON a.agent_no = l.agent_id
WHERE 
agent_id = ".$AffiliatesArray[$i]."
AND 
l.status = 'Keep In-Touch' 
AND
(rating='$ratings')
ORDER BY timestamp DESC;";
}
if($event_date!="")
{
//echo "Event Date : ".$event_date;
$query="SELECT DISTINCT(id),tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
l.lname,l.fname,company_position,company_name,l.email,company_turnover ,
rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
agent_from ,officenumber, mobile,agent_id,
a.fname,a.lname
FROM leads l
LEFT OUTER JOIN agent a ON a.agent_no = l.agent_id
WHERE 
agent_id = ".$AffiliatesArray[$i]."
AND 
l.status = 'Keep In-Touch' 
AND
(DATE(timestamp) = '$event_date')
ORDER BY timestamp DESC;";
}
if($month!="")
{
//echo "Month : ".$month;
$query="SELECT DISTINCT(id),tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
l.lname,l.fname,company_position,company_name,l.email,company_turnover ,
rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
agent_from ,officenumber, mobile,agent_id,
a.fname,a.lname
FROM leads l
LEFT OUTER JOIN agent a ON a.agent_no = l.agent_id
WHERE 
agent_id = ".$AffiliatesArray[$i]."
AND 
l.status = 'Keep In-Touch' 
AND
(DATE_FORMAT(l.timestamp,'%m') = '$month')
ORDER BY timestamp DESC;";

}

///
}
if(($query=="" or $keyword=="") and $ratings=="" and $event_date=="" and $month=="") {
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
l.lname,l.fname,company_position,company_name,l.email,company_turnover ,
rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
agent_from ,officenumber, mobile,agent_id,
a.fname,a.lname
FROM leads l
LEFT OUTER JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Keep In-Touch' AND agent_id = ".$AffiliatesArray[$i]." ORDER BY timestamp DESC;";
}


	
	//echo $query."<br>";	
	$result=mysql_query($query);
	$count=@mysql_num_rows($result);
	if($count >0) {
		//$ctr=@mysql_num_rows($result);
	echo "<tr><td colspan='12'>$BP<span style='margin-left:20px; color:#FF0000; font-weight:bold;'>".$row_res['fname']." ".$row_res['lname']."</span></td></tr>";  
	$bgcolor="#FFFFFF";
	//id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
	while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$lname,$fname,$company_position,$company_name,$email,$company_turnover,$rate,$inactive_since,$personal_id,$date_move,$agent_from,$officenumber, $mobile,$agent_id,$agent_fname,$agent_lname) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		$contact_nos = "-- ".$officenumber." /".$mobile;
		$fname=str_replace("'","",$fname);
		$lname=str_replace("'","",$lname);
		
			  if($rate=="1")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		
	$add_remark='<form name="add_remark_form" method="post" action="leads_add_remark.php">
		 <input type="hidden" name="leads_id" value='.$id.'>
		 <input type="hidden" name="created_by_id" value='.$agent_no.'>
		 <input type="hidden" name="remark_created_by" value="BP">
		 <input type="hidden" name="url" value='.$_SERVER['PHP_SELF'].'>
		 <textarea style="width:100%;" rows="4" class="add_note" name="remarks"></textarea>
		 <input type="submit" name="save_remark" value="Save" class="add_note">
		 <input type="button" class="add_note" name="cancel_remark" value="Cancel" onClick="javascript: show_hide('."'$id'".');"></form>';	
		
?>
  <tr bgcolor=<? echo $bgcolor;?> class="leads_label">
    <td width='2%' height="25" align=left class="leads_label"><? echo $counter.")";?>    </td>
	<td ><input type="radio" name="action" value="<? echo $id;?>" onClick ="goto(<? echo $id;?>); return false;"></td>
	<td ><?
	if($agent_id!=$agent_no){
	echo "<img src='../images/adduser16.png' title='$agent_fname&nbsp;$agent_lname Keep In-Touch' />";
	}else{
	echo "<img src='../images/action_check.gif' title='Your own Regstered Keep In-Touch' />";
	}
	?></td>
	<td class="leads_label" >
	<? if($agent_id==$agent_no){?>
	<input type="checkbox" onClick="check_val()" name="users" value="<? echo $id;?>"  title="Transfer <? echo $fname." ".$lname;?>" >
	<? } else {?>
	<input type="checkbox" onClick="check_val()" name="users" value="<? echo $id;?>" disabled="disabled"  title="Transfer <? echo $fname." ".$lname;?>. Not Available" >
	<? }?>
	</td>
    <td class="leads_label" width='15%' align=left><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);> <? echo $fname." ".$lname;?> 
</a><br>
<? echo $rate;?>
	</td>
    <td class="leads_label" width='12%' align=left><? echo $timestamp;?></td>
    <td  class="leads_label"width='11%' align=center><a href='#'onClick=javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);><? echo $tracking_no;?></a></td>
    <td class="leads_label" width='17%' align=left><? echo $company_name;?></td>
    <td class="leads_label" width='17%' align=left valign="top">
	<div style="float:left;">
	<input type="button" class="add_note" name="add_remark" value="Add" title="Add a Remarks/Notes" onClick='javascript: show_hide("<? echo $id;?>");'>
	</div>
 <div id="<?=$id;?>" style="position:absolute; display:none; padding:5px; z-index:2; background:#F3F3F3; border:#000000 solid 1px; text-align:center; width: 226px; left: 800px; ">
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
				echo '<a href="javascript: show_hide('."'leads$id'".');">'.substr($row_result['remarks'],0,50)."</a>";
			 	//$meron="TRUE";
			 }  
			   ?>
	    </small>
	  </div>
			  
			   <div style="clear:both;"></div>
			  
			  
    </td>
	  <td class="leads_label" width='20%' align=left>&nbsp;</td>
  </tr>
<? 
if($check_result>0)
{
?>
  <tr>
  <td colspan="8" valign="top"></td>
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
	//echo $count;
	//if($keyword!=""){
	// break ;
	//} 
	}
	
}
	

   
?>
</table>

<script language=javascript>
<!--
function goto(id) 
{
	location.href = "apply_action.php?id="+id;
}
function check_val()
{
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
}

//-->
</script>

	

<? include 'footer.php';?>	

</body>
</html>
