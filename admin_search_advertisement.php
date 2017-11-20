<?php
include './conf/zend_smarty_conf_root.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if (array_key_exists('_submit_check', $_POST)) {
	$keyword=$_REQUEST['keyword'];
	
	

	$search_text = $keyword;
	$search_text=ltrim($search_text);
	$search_text=rtrim($search_text);
	
	$kt=explode(" ",$search_text);//Breaking the string to array of words
	// Now let us generate the sql 
	while(list($key,$val)=each($kt)){
		if($val<>" " and strlen($val) > 0){
			
			$queries .= " p.id like '%$val%' or p.jobposition like '%$val%' or l.lname like '%$val%' or l.fname like '%$val%' or p.companyname like '%$val%' or p.heading like '%$val%' or l.email like '%$val%' or";
		}
	}// end of while
	
	$queries=substr($queries,0,(strlen($queries)-3));
	// this will remove the last or from the string. 
	$keyword_search =  " ( ".$queries." ) ";
	
	

	$sql = "SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y')AS date,p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id,p.show_status FROM posting p JOIN leads l ON l.id = p.lead_id WHERE $keyword_search ORDER BY id DESC;"; 
	//echo $sql;//exit;
	$result = $db->fetchAll($sql);

}


$field_array = array('lead_id' , 'companyname' , 'jobposition');  
$searchOptions;

?>

<html>
<head>
<title>Search Job Advertisements @Remotestaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="js/functions.js"></script>	

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<!--
< ?php include 'header.php';?>
< ?php include 'admin_header_menu.php';?>
< ?php include 'admin-sub-tab.php';?>
-->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
  <td width="100%" bgcolor="#ffffff" >

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<!--
<td  align="left" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
< ?php include 'adminleftnav.php';?>
<br></td>
-->
<td  valign=top >
<?php include 'admin-ads-tab.php'?>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td width="100%">
<form name="form" method="post" action="admin_search_advertisement.php">

<div style="padding:10px; border-bottom:#000000 solid 1px;"><b>Search : </b><input type="text" name="keyword" id="keyword" size="60" value="<?php echo $keyword;?>"> 
<input type="submit" value="Search"></div>

<?php
if(count($result) > 0) {
?>

<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor='#666666'>
<td width='5%' align=LEFT><b><font size='1' color="#FFFFFF">#</font></b></td>
<td width='24%' align=left><b><font size='1' color="#FFFFFF">Job Position</font></b></td>
<td width='19%' align=left><b><font size='1' color="#FFFFFF">Company Name</font></b></td>
<td width='21%' align=left><b><font size='1' color="#FFFFFF">Client</font></b></td>
<td width='13%' align=left><b><font size='1' color="#FFFFFF">Date</font></b></td>
<td colspan="2" align=left><b><font size='1' color="#FFFFFF">Status</font></b></td>
</tr>

<?php 
$bgcolor="#f5f5f5";
foreach($result as $ad){
	$id = $ad['id'];
	$date = $ad['date'];
	$model = $ad['outsourcing_model'];
	$companyname = $ad['companyname'];
	$position = $ad['jobposition'];
	$status = $ad['status'];
	$fname = $ad['fname'];
	$lname = $ad['lname'];
	$lead_id = $ad['lead_id'];
	$show_status = $ad['show_status'];
	$counter=$counter+1;
	
	  if($bgcolor=="#f5f5f5")
	  {
		$bgcolor="#FFFFFF";
	  }
	  else
	  {
		$bgcolor="#f5f5f5";
	  }
?>
	
<tr bgcolor=<?php echo $bgcolor;?>>
<td align=left><font size='1'><?php echo $counter;?>)</font></td>
<td><font size='1'><a href='Ad.php?id=<?php echo $id;?>' target="_blank" ><?php echo $position;?></a> </font></td>
<td><font size='1'><?php echo $companyname;?></font></td>
<td><b><font size='1'><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<?php echo $lead_id;?>',600,600);> <?php echo $fname."".$lname;?></a></font></b></td>
<td><font size='1'><?php echo $date;?></font></td>
<td colspan="2" ><?php echo $status;?></td>
</tr>	
	
<?php
}
?>

</table>

<?php } else {
	echo "<tr><td colspan='7' align='center'>No <b>".$keyword."</b> found.</td></tr>";
}
?>





<input type="hidden" name="_submit_check" value="1"/>
</form>
</td>
</tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
<!--< ?php include 'footer.php';?>-->
</body>
</html>
