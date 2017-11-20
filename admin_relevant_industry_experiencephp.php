<?
include 'config.php';
include 'conf.php';
$userid = @$_GET["userid"];
$relevant_experience=$_POST['relevant_experience'];
if(isset($_POST['Add']))
{
	$query="INSERT INTO tb_relevant_industry_experience(name,userid) VALUE ('$relevant_experience', '$userid');";
	$result=mysql_query($query);
?>
	<script language="javascript">
		alert("Form Saved.");
		window.location="admin_relevant_industry_experience.php?userid=<?php echo $userid; ?>";
	</script>
<?php		
}
?>