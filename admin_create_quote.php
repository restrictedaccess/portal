<?php

if($_GET['leads_id']){
   $url = sprintf('quote.php?leads_id=%s', $_GET['leads_id']);
}else{
    $url = 'quote.php';
}
//echo $url;
header("location:$url");
exit;

include 'config.php';
include 'conf.php';
include 'time.php';
$timezone_identifiers = DateTimeZone::listIdentifiers();

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	header("location:index.php");
}
$url=$_GET['url'];

$leads_id = $_REQUEST['leads_id'];
if($leads_id!=""){
	$display = "style='display:block;'";
}else{
	$display = "style='display:none;'";
}


$sql ="SELECT * FROM admin WHERE admin_id = $admin_id;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$admin_lname = $row['admin_lname'];
	$admin_fname = $row['admin_fname'];
}

/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip
*/
$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id
FROM leads l
WHERE l.status !='Inactive'
ORDER BY l.fname ASC;";

//echo $queryAllLeads;
$result = mysql_query($queryAllLeads);
while(list($id, $lname, $fname , $company_name)=mysql_fetch_array($result))
{
	$company_name ?  "( ".$company_name." )" : '&nbsp;';
	if($leads_id == $id ) {
		$leads_Options.="<option value=".$id." selected>".$fname." ".$lname." ". $company_name."</option>";
	}else{
		$leads_Options.="<option value=".$id.">".$fname." ".$lname." ". $company_name."</option>";
	}	
}



?>   
<html>
<head>
<title>Admin Create A Quote</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="quote/quote.css">
<script type="text/javascript" src="quote/quote.js"></script>


</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="">
<form name="form">
<input type="hidden" name="leads" id="leads" value="<? echo $leads_id;?>">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'adminleftnav.php';?>
<br></td>
<td width=100% valign=top >
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="272" height="115" valign="top" style="border-right:#999999 solid 1px;">
				<div class="hdr"><b>Create a New Quote </b></div>
			  <div style="padding:2px;">
					<input type="button" class="btn" value="Manual Entry" onClick="showForm('manual')">
				    <input name="button" type="button" class="btn" onClick="showForm('leads')" value="Select from Leads">
					<?php if ($url!="") {?>
					<input type="button" class="btn" value="Back" onClick="self.location='<?php echo $url;?>&lead_status=<?php echo $_GET['lead_status'];?>'"/>
					<?php } ?>
			  </div>
				<div id="search_div">
					<div style="float:left; display:block; width:50px;"><b>Search</b></div>
						<input type="text" name="keyword" id="keyword" value="<?=$keyword;?>" class="select"  onKeyUp="searchQuote(this.value)"  >
					<div style="clear:both;"></div>
				</div>
				<div class="hdr"><b>Quote LIst</b></div>
				<div id="quote_list"></div>			</td>
			<td width="807" valign="top" bgcolor="#F0F0F0">
			<div id="quote_status"></div>
			<div id="right_panel">
			<?
			if($leads_id!=""){
			?>
				<div id="leads" style="margin:10px; margin-right:20px; border:#CCCCCC solid 1px;">
<div class="hdr"><b>Select from Leads List</b></div>
	<div style="padding:20px;">
	<div style="color:#999999; padding:5px;">Choose Leads from the system</div>
		<div style="float:left;">	
			<p><label>Leads :</label><select id="leads_id" name="leads_id" class="select" >
									 <option value="0">--</option><?=$leads_Options;?>
									 </select>
			</p>
		</div>
		<div style="float:left; margin-left:10px;">	
			<input type="button" value="Generate" onClick="generateQuote('leads')">
			<input type="button" value="Cancel" onClick="hide('leads');">
		</div>
		<div style="clear:both;"></div>
	</div>
</div>

			<?	
			} else {
			?>
			
			To generate a Quote to be given . Select from &quot;Manual Entry&quot; or &quot;Select from Leads&quot; List
			
			<? }?>
			</div></td>
		</tr>
		<tr>
		<td height="2" colspan="2"></td>
		</tr>
	</table>
</td></tr>
</table>
<script type="text/javascript">
<!--
//showAllQuotes();
searchQuote();
-->
</script>
<? include 'footer.php';?>		
</form>	
</body>
</html>
