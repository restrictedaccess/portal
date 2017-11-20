<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";



$uploadDir = 'uploads/pics/'; 
//temporary name of image
$tmpName	 = $_FILES['file']['tmp_name']; 
$file = $_FILES['file']['name']; 
$filesize= $_FILES['file']['size']; 
$filetype = $_FILES['file']['type'];
echo $file;

?>