<?
include 'config.php';
include 'conf.php';
$client_id = $_SESSION['client_id'];


$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y'),p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id
FROM posting p JOIN leads l ON l.id = p.lead_id WHERE p.lead_id= $client_id  AND p.status='ACTIVE' ORDER BY p.date_created DESC;";
	




?>

<html>
<head>
<title>Client Job Advertisement @Think Innovations</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript">
<!--
function checkFields()
{


	
}
-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="clientHome.php"><b>Home</b></a></li>
  <li><a href="myadvertise_positions.php"><b>Applications</b></a></li>
  <li class="current"><a href="myadvertisement.php"><b>Advertisements</b></a></li>
  <li><a href="myscm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
  <td width="100%" bgcolor="#ffffff" >

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'></td>
</tr>
<tr><td  align="left" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'clientleftnav.php'; ?>
<br></td>
<td  valign=top >
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td><div class="animatedtabs">
<ul>
<li class="selected"><a href="myadvertisement.php" title="Active Job Advetisements"><span>Active Job Advetisements</span></a></li>
<li ><a href="myadvertisement2.php" title="Pending Job Advetisements"><span>Pending Job Advetisements</span></a></li>
<li ><a href="myjobposting.php" title="Add New Job Advetisements"><span>Add Job Advetisements</span></a></li>
</ul>
</div></td></tr>
<tr><td width="100%">
<form method="POST" name="form" action="activate_ads.php" >
<?
$counter = 0;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);

?>
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td><br>
<b>Active Job Advertisement List</b><br>
<br>
</td></tr>
<tr><td bgcolor=#333366 height=2></td></tr>
<tr><td>


<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor='#666666'>
<td width='5%' align=LEFT><b><font size='1' color="#FFFFFF">#</font></b></td>
<td width='17%' align=left><b><font size='1' color="#FFFFFF">Job Position</font></b></td>
<td width='21%' align=left><b><font size='1' color="#FFFFFF">Company Name</font></b></td>
<td width='12%' align=left><b><font size='1' color="#FFFFFF">Client</font></b></td>
<td width='12%' align=left><b><font size='1' color="#FFFFFF">Date</font></b></td>
<td width='14%' align=left><b><font size='1' color="#FFFFFF">Outsourcing Model</font></b></td>

<td width='10%' align=left><b><font size='1' color="#FFFFFF">Status</font></b></td>

</tr>
<?
	$bgcolor="#f5f5f5";
	while(list($id,$date,$model,$companyname,$position,$status,$fname,$lname,$lead_id) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
	

?>
		<tr bgcolor=<? echo $bgcolor;?>>
				
			  <td width='5%' align=left><font size='1'><? echo $counter;?>)  </font></td>
			   <td width='17%' align=left><font size='1'>
			  <a href='ads.php?id=<? echo $id;?>' target="_blank" >
			  <? echo $position;?>			  </a>
			  </font></td>
			  	  <td width='21%' align=left><font size='1'><? echo $companyname;?></font></td>
			  <td width='12%' align=left><b><font size='1'>
			  <a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $lead_id;?>',600,600);>
			  <? echo $fname."".$lname;?></a></font></b></td>
			   <td width='12%' align=left><font size='1'><? echo $date;?></font></td>
			  <td width='14%' align=left><font size='1'><? echo $model;?></font></td>
		
			 
			  <td width='10%' align=left><font size='1'>
			  <? 
			  
			  echo $status;
			  
			  ?></font></td>
			 
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
	//javascript:popup_win(./viewTrack.php?id=$id,500,400);
?>	
</table>
</td></tr>
<tr><td bgcolor=#333366 height=1>



<img src='images/space.gif' height=1 width=1></td></tr></table>
	


<!-- --->
<br></form>

</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
<? include 'footer.php';?>
</body>
</html>
