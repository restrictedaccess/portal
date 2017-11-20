<?php
include('conf/zend_smarty_conf.php');

$id=$_REQUEST['id'];
/*
$query ="SELECT tracking_no ,DATE_FORMAT(timestamp,'%D %b %Y')AS date_registered,CONCAT(fname,' ',lname)AS client,company_position, company_name, company_address  FROM leads WHERE id = $id;";

$result=$db->fetchRow($query);
$tracking_no = $result['tracking_no']; 
$date_registered = $result['date_registered'];
$client = $result['client']; 
$company_position = $result['company_position']; 
$company_name = $result['company_name']; 
$company_address = $result['company_address'];
*/
?>

<html>
<head>
<title>Client <?php echo $client;?> Staff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">
<script language=javascript src="js/functions.js"></script>
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr>
	<td><img src="images/remote_staff_logo.png" alt="think" ></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
<tr>
<td colspan="2" valign="top">
<div style="font:12px Arial; padding:10px;">
	<div style="background:#CCCCCC; border:#CCCCCC outset 1px; margin-top:5px; padding:5px;">Client <b><?php echo $client;?></b> Staff</div>
	<div style="border-left:#CCCCCC outset 1px; border-right:#CCCCCC outset 1px; border-top:#CCCCCC outset 1px; ">
	<?php
	$query="SELECT u.userid, CONCAT(u.fname,' ',u.lname)AS staff,DATE_FORMAT(s.starting_date,'%D %b %Y')AS starting_date, u.image , s.job_designation
			FROM personal u
			JOIN subcontractors s ON s.userid = u.userid
			JOIN leads l ON l.id = s.leads_id
			WHERE s.leads_id = $id
			AND s.status IN('ACTIVE', 'suspended')
			ORDER BY u.fname ASC;";
	$results= $db->fetchAll($query);
	$counter=0;
	foreach($results as $result)
	{
		
		$userid = $result['userid'];
		$staff = $result['staff'];
		$date = $result['starting_date'];
		$image = $result['image'];
		$job_designation = $result['job_designation'];	
		$counter++;
	?>
		<div style="margin-bottom:10px; border-bottom:#CCCCCC solid 1px; margin-top:5px; padding-bottom:5px;">
			<div style="float:left; display:block; width:40px;"><?php echo $counter;?>)</div>
			<div style="float:left; display:block; width:110px;"><img src="http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id=<?php echo $userid;?>"  /></div>
			<div style="float:left; display:block; margin-left:10px;">
			<div style="margin-bottom:5px;"><b><?php echo $staff;?></b><br><?php echo $job_designation;?>
</div>
			<div>Date Sub-Contracted : <?php echo $date;?></div>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?	
	}
	?>
	</div>
</div>
</td>
</tr>
</table>

</body>
	</html>

