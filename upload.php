<?php
include 'config.php';
include 'conf.php';
include 'time.php';
if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}
$userid = $_SESSION['userid'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

$path = "uploads/contracts/"; // directory
$result = 0;

//temporary name of image
$tmpName = $_FILES['myfile']['tmp_name']; 
$img = $_FILES['myfile']['name']; 
$imgsize= $_FILES['myfile']['size']; 
$imgtype = $_FILES['myfile']['type'];


//echo $imgtype;

if($img != ''){
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
		//echo "Error uploading file, file type is not allowed"; 
		$flag = 2;
		//exit; 
	} 
}


   // Edit upload location here
  
   ///// Check if the User has Already upload a image contract ..
    $sqlCheckContract="SELECT * FROM contract_image WHERE userid = $userid;";
	$result_check=mysql_query($sqlCheckContract);
	$ctr=@mysql_num_rows($result_check);
	if ($ctr >0 )
	{
		$folder_name =$userid; // folder name
	}
	else
	{
		$folder_name =$userid;
		mkdir("$path$folder_name",0755); // create a new Folder php function to make a new folder
		
	}
   
   $target_path = $path .$folder_name."/". basename($_FILES['myfile']['name']);
   chmod($target_path, 0755);
   
 if($flag ==2 )
 {
 	echo "<script language='javascript' type='text/javascript'>window.top.window.stopUpload('2');</script>   ";
	exit;
 }
else {
   if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
     
	  /// check if the file is existing then replace the old file
	  $image =basename($_FILES['myfile']['name']);
	  $sqlCheckfile="SELECT * FROM contract_image WHERE userid = $userid AND image = '$image';";
	  $result_checkfile=mysql_query($sqlCheckfile);
	  $ctr_check=@mysql_num_rows($result_checkfile);
	 
	  if($ctr_check > 0)
	  {
			 // File Exist .. Update file
		chmod($target_path, 0755);	 
		 $sql="UPDATE contract_image SET 
		 		image = '$image',
				date_uploaded = '$ATZ',
				image_path = '$target_path' WHERE userid = $userid AND image = '$image';";
	  }
	  else
	  {
	  	  // file Does not Exist .. Insert new File
		 // id, userid, image, date_uploaded, image_path
		 chmod($target_path, 0755);
		 $sql="INSERT INTO contract_image SET userid = $userid,
		 		image = '$image',
				date_uploaded = '$ATZ',
				image_path = '$target_path'";
	  }
	   //echo $sql;
	   chmod($target_path, 0755);
	   $result_sql=mysql_query($sql);  
	   if(!$result_sql)
	   {
	   		$result = 0;
	   }
	   else
	   {
	   		$result = 1;	
	   }
	   
	
	}
      sleep(1);
	  
	  
}
?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);</script>   

