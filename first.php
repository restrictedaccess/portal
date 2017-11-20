<?
$tracking_no = $_REQUEST['id'];
echo "track =".$tracking_no;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript1.2">
function subLogin()
{
	document.form.submit();
}
</script>
</head>
<body onload=subLogin()><!-- onload=subLogin()-->
<!-- -->
<form action="inquiry.php" name="form" method="POST">
<input type="hidden" name="tracking_no" value="<? echo $tracking_no;?>" />
</form>	 
 <!-- -->
</body>
</html>

