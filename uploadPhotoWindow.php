<?


$userid=$_REQUEST['userid'];
if ($_SERVER['REQUEST_METHOD']=="POST"){
	include 'config.php';
	$userid=$_REQUEST['userid'];
	//echo $userid;
	$uploadDir = 'uploads/pics/'; 
	//temporary name of image
	$tmpName	 = $_FILES['img']['tmp_name']; 
	$img = $_FILES['img']['name']; 
	$imgsize= $_FILES['img']['size']; 
	$imgtype = $_FILES['img']['type'];
	//check extension of image
	if($img != '')
	{	
		if($imgtype=="image/pjpeg") 
		{ 
			$imgtype=".jpg"; 
		} 
		elseif($imgtype=="image/jpeg") 
		{ 
			$imgtype=".jpg"; 
		} 
		elseif($imgtype=="image/gif") 
		{ 
			$imgtype=".gif"; 
		} 
		elseif($imgtype=="image/png") 
		{ 
			$imgtype=".png"; 
		} 
		else 
		{ 
			echo "Error uploading file, file type is not allowed"; 
			exit; 
		} 
	}
	if ($img != '')
	{
		$result= move_uploaded_file($tmpName, $uploadDir.$userid.$imgtype); 
		if (!$result) 
		{ 
			echo "Error uploading file"; 
			//mysql_query("DELETE FROM users WHERE userid =$userid"); 
			$sql="DELETE FROM users WHERE userid =$userid";
			mysql_query($sql);
			exit; 
		} 
		else 
		{ 
			$sql2="UPDATE personal SET image='$uploadDir$userid$imgtype' WHERE userid=$userid";
			mysql_query($sql2);
			echo("<html><head>
			<script>function update()
			{
			top.location='uploadPhoto.php?userid=$userid';
			window.close(); 
			}
			var refresh=setInterval('update()',2000);
			</script>
			</head><body onload=refresh>Please try to Refresh the Page<body></html>");				
	  
		} 
	}	


}
else {
?>
<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">


<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><a href="#"><img src="images/remotestafflogo.jpg" border="0" ></a></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>Upload Photo</font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td><br>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data" >
<input type="hidden" name="userid" value="<? echo $userid?>" />

<table width=100% cellspacing=1 cellpadding=4 border=0 align=center>
<tr><td>
<li>Photo must be in <b>JPEG(.jpg or .jpeg)</b> or <b>GIF(.gif)</b> format</li>
<li>File size must not exceed <b>15K</b></li>
<li>Recommended dimension of photo : <b>110 x 150 pixels</b></li>
<br><br>
Click <b>Browse</b> to locate the file on your computer. Then click <b>Upload</b> to begin the uploading process.
<br><br>
<center><input name="img" type="file" / id="img"   />
<br><br>
<input type=button name=btnCancel value="Cancel" style='width:80px' class=button onClick='javascript:window.close();'>&nbsp;&nbsp;
<input type=submit name=btnUpload value="Upload Photo" style='width:110px' class=button>
</td></tr>
</table>

</form>

		</td></tr>
		</table>
	</td></tr>
	</table>

	</body>
	</html>
<? }?>	
