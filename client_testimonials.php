<?
include 'config.php';
include 'conf.php';
include 'function.php';
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];
//leads info
$query="SELECT CONCAT(fname,' ',lname),email FROM leads WHERE id=$client_id;";
$result=mysql_query($query);
list($name, $email) = mysql_fetch_array ($result); 

if(isset($_POST['upload'])){
   //$uploadDir = 'uploads/clients/'; 
   $path = 'uploads/clients/';
   if (file_exists($path) == false) {
         mkdir($path, 0777, true);
	}			
   $tmpName	 = $_FILES['img']['tmp_name']; 
   $img = $_FILES['img']['name']; 
   $imgsize= $_FILES['img']['size']; 
   $imgtype = $_FILES['img']['type'];
	//echo $imgtype;
	/*
	image/pjpeg 
	image/x-png 
	image/gif 
	image/png
	*/
	if($img != '')
	{	
		// Check if the file is image or graphics
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
		elseif($imgtype=="image/x-png") 
		{ 
			$imgtype=".png"; 
		} 
		else 
		{ 
			echo "Error uploading file, file type is not allowed"; 
			exit; 
		} 
		
		// now upload the file
		$result= move_uploaded_file($tmpName, $path.$name.$imgtype); 
		if (!$result) 
		{ 
			echo "Error uploading file"; 
		}else{ 
			$query = "UPDATE leads SET logo_image = '$path$name$imgtype' WHERE id = $client_id;";
			$data = mysql_query($query);
			if(!$data) die ("Error in Script :<br>".$query);
			
		}
		
	}
	
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Client RemoteStaff Testimonials</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="testimonials/testi.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="testimonials/testi.js"></script>


	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="client_testimonials.php" enctype="multipart/form-data">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<input type="hidden" name="usertype" id="usertype" value="leads">
<input type="hidden" name="leads_id" id="leads_id" value="<?=$_SESSION['client_id'];?>">

<?php
if ($_REQUEST["page_type"]!="iframe"){
	?>
		<!-- HEADER -->
		<?php include 'header.php';?>
		<?php include 'client_top_menu.php';?>	
	<?php	
}
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<?php
if ($_REQUEST["page_type"]!="iframe"){?>
<td width="14%" height="176" bgcolor="#ffffff"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<? include 'clientleftnav.php';?>
</td>
<?php
}?>
<td width="100%" valign="top" style=" font:12px Arial;">
<div class="testi_hdr" ><b>Testimonials</b></div>

<div id="client_testimonial_section"></div>

</td>
</table>
<script type="text/javascript">
<!--
getClientStaff();
-->
</script><?php
if ($_REQUEST["page_type"]!="iframe"){?>
<? include 'footer.php';?>
<?php }?>
</form>
</body>
</html>
