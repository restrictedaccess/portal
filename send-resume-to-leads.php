<?php
include('../ShowPrice.php');
include 'config.php';
include 'conf.php';

include('../conf/zend_smarty_conf.php') ;

if(TEST || STAGING){
	$retries = 0;
	while(true){
		try{
			if (TEST){
				$mongo = new MongoClient(MONGODB_TEST);
			}else{
				$mongo = new MongoClient(MONGODB_SERVER);
			}

			$database = $mongo->selectDB('sessions');
			break;
		} catch(Exception $e){
			++$retries;

			if($retries >= 30){
				break;
			}
		}
	}
	$sessions = $database->selectCollection('sessions');

	$result = $sessions->findOne(
		array(
			'$query' => array(
				"date_created" => [
					'$exists' => true
				]
			),
			'$orderby' => [
				"date_created" => -1
			]
		)
	);

	if(!empty($result)){
		UNSET($result["_id"]);
		UNSET($result["date_created"]);

		$_SESSION = $result;
	}

}


if($_SESSION['admin_id']=="")
{
	if($_SESSION['agent_no']=="")
	{
		header("location:index.php");
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Business Partner</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="../text/javascript" src="video/flowplayer-3.1.4.min.js"></script>
<link href="../css/bp-style.css" type="text/css" rel="stylesheet"  />
<link href="../css/rsscroll-staff.css" type="text/css" rel="stylesheet" />

<style type="text/css">
<!--
div.scroll {
	height: 100%;
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
.remind_data{
font:9px tahoma;
padding:3px;
}  
.remind_label{
font:9px tahoma;
} 
.remind_tr{
border:#CCCCCC solid 1px;
}
-->
</style>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" class="sub-bg" id="availstaffx">
<form method="POST" name="form" action="agentHome.php">
<?php 
include 'header.php';
if($_SESSION['admin_id'])
{
	include 'admin_header_menu.php';
}
else
{
	include 'BP_header.php';
}
?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php
if($_SESSION['admin_id'])
{
	include 'adminleftnav.php';
}
else
{
	include 'agentleftnav.php';
}
?>

</td>
<td width=100% valign=top height="2000">
	<table cellpadding="3" cellspacing="3" height="100%" width="100%"><tr><td height="100%" width="100%" valign="top">
		<iframe id="frame" name="frame" width="100%" height="100%" marginheight="1" marginwidth="1" src="../portal-index.php?to=<?php echo @$_REQUEST["to"]; ?>" frameborder="0" scrolling="yes">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
	</td></tr></table>
</td>
</tr>
</table>
<?php include 'footer.php';?>
</form>	
</body>
</html>