<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}
$id=$_REQUEST['id'];

$sql="SELECT lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, email2, status, hosting,access_aff_leads FROM agent WHERE agent_no=$id;";
	$result2=mysql_query($sql);
	list($agent_lname, $agent_fname, $agent_email, $agent_password, $date_registered, $agent_code, $agent_address, $agent_contact, $email2, $agent_status,$agent_website,$access_aff_leads  ) = mysql_fetch_array($result2);


?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}

/////
function check_val()
{
	var ins = document.getElementsByName('affiliate')
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

document.form.affiliate_chosen.value =(vals);
}

-->
</script>
<style type="text/css">
<!--
  
#aff_form{
padding:3px; margin-top:0px; width:300px;
}  
#aff_form fieldset
{
background:#FFF;
border: 1px dashed #AAA;
}

#aff_form legend
{
background:#DDD;
border: 2px solid #CCC;
margin-left: 25px;
font-weight: bold;
font-size: 11px;
padding:5px;
}
-->
</style>
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form method="POST" name="form" action="admin_assign_bp_php.php" >
<input type="hidden" name="id" value="<? echo $id;?>">
<input type="hidden" name="affiliate_chosen" id="affiliate_chosen" value="">



<!-- HEADER -->
<? include 'header.php';?>
<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li ><a href="adminHome.php"><b>Home</b></a></li>
  <li ><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li class='current'><a href='adminHome.php'><b>Home</b></a></li>
  <li ><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>";
}
?>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Admin Home</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td><td colspan="2">&nbsp;</td></tr>
<tr><td width="18%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="82%" valign="top" align="left"><!-- list here -->
<table width="860"><tr><td width="450" valign="top">
<div class="box_contacted_leads" >Assign Business Partners
<div class="box_new_leads_content" >
<div style=" clear:both;"></div>
<p><b><?=$agent_fname." ".$agent_lname;?></b></p>
<?
 //id, business_partner_id, affiliate_id
$sqlGetAff="SELECT f.id, a.fname,a.lname
FROM agent_affiliates f
JOIN agent a  ON a.agent_no = f.affiliate_id
WHERE
a.status = 'ACTIVE' AND
a.work_status ='BP' AND
f.business_partner_id =$id;";
		  //echo $sqlGetAff;
$r=mysql_query($sqlGetAff);
$counter=0;
echo "<b>Current List of Assign Business Partner</b>";
while(list($fid, $affname,$afflname)=mysql_fetch_array($r))
{ $counter++;
?>
<span class="leads_wrapper">
<label class="leads_wrapper_label" style="width:40px;"><? echo $counter;?>)</label>
<label class="leads_wrapper_label" style="width:300px; "><? echo $affname." ".$afflname;?></label>
<label class="leads_wrapper_label" style="width:50px;"><a href="admin_assign_bp_php.php?id=<?=$id;?>&aff_id=<?=$fid;?>">remove</a></label>
</span>
<?  
}

?>
<div style=" clear:both;"></div>
</div>
</div>
</td>
<td width="361" valign="top">
<? if($access_aff_leads=="YES") {?>
<div id="aff_form">
<fieldset>
<?
$sqlGetAllAffiliates="SELECT agent_no,fname,lname FROM agent WHERE work_status='BP' AND status='ACTIVE' AND agent_no <>$id ORDER BY fname ASC;";
$resulta=mysql_query($sqlGetAllAffiliates);
$ctr=0;
while(list($aff_no,$aff_fname,$aff_lname)=mysql_fetch_array($resulta))
{
	 // checked=\"checked\"
	 // Check if the Affiliate has already assign to Business Partner dont show it..
	 $sqlCheckAff="SELECT * FROM agent_affiliates WHERE affiliate_id=$aff_no;";
	 $result_check=mysql_query($sqlCheckAff);
	 $check=@mysql_num_rows($result_check);
	 if($check==0){
     	$affoptions .= "<input type =\"checkbox\" name=\"affiliate\" value=\"$aff_no\" onClick=\"check_val();\" >$aff_fname&nbsp;$aff_lname<br>";
		$ctr++;
	 }
  
}
if($ctr>0) $button='<input type="submit" name="assign" value="Assign">';
?>
<legend>Select/Assign Affiliate</legend>
<br><b>Available Affiliates</b><br>
<?=$affoptions;?>
<p align="center"><?=$button;?></p>
</fieldset>
</div>
<? }?>
</td>
</tr>
</table>
</td>
</tr>
</table>

</td>
</tr>
</table>
</td></tr>
</table>

<!-- LIST HERE -->
<? include 'footer.php';?>
</form>	
</body>
</html>
