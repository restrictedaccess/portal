<?php
include 'config.php';
include 'conf.php';
include 'time.php';

$rating = @$_GET["rating"];
$userid = @$_GET["userid"];
mysql_query("UPDATE tb_additional_information SET rating='$rating' WHERE userid='$userid'");
$a = mysql_query("SELECT fname, lname FROM personal WHERE userid='$userid' LIMIT 1");
$name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");
?>
<script language="javascript">
	alert("<?php echo $name; ?>'s rating has been successfully changed.");
	window.close();
</script>
