<?php 
include './conf/zend_smarty_conf_root.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Remotestaff - Complete Applicants List</title>
</head>
<body>
<?php
$query = "SELECT * FROM personal ORDER BY userid DESC;";
$result = $db->fetchAll($query);
foreach($result as $row){
	$image = $row['image'];
?>
<div style="margin-bottom:10px; border-bottom:#CCCCCC solid 1px;">
	<div style="float:left; margin-right:10px;">
		<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>"   />
	</div>
	<div style="float:left;">
	<?php
	echo "userid : ".$row['userid']."<br>";
	echo $row['fname']." ".$row['lname']."<br>";
	echo $row['email']."<br>";
	?>
	</div>
	<div style="clear:both;"></div>
</div>
<?php
}
?>

</body>
</html>
