<?
// from: adminadvertise_positions.php
include 'config.php';
include 'conf.php';
include 'time.php';
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";
$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}

$message=$_REQUEST['message'];
$emails=$_REQUEST['emails'];

$subj="MESSAGE FROM REMOTESTAFF.COM.AU";
$applicant=explode(",",$emails);
$subj="MESSAGE FROM REMOTESTAFF.COM.AU";
$agent_email="normanm@remotestaff.com.au";



for ($i=0; $i<count($applicant);$i++)
{
	$to=$applicant[$i];
	$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
$headers = "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
$headers .= "MIME-Version: 1.0\r\n" ."Content-Type: multipart/mixed;\r\n" ." boundary=\"{$mime_boundary}\"";
$message = "This is a multi-part message in MIME format.\n\n" .
		  "--{$mime_boundary}\n" .
		  "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
		  "Content-Transfer-Encoding: 7bit\n\n" .
$message . "\n\n";

		   foreach($_FILES as $userfile){
	      // store the file information to variables for easier access
      $tmp_name = $userfile['tmp_name'];
      $type = $userfile['type'];
      $name = $userfile['name'];
      $size = $userfile['size'];
      // if the upload succeded, the file will exist
      if (file_exists($tmp_name)){
         // check to make sure that it is an uploaded file and not a system file
         if(is_uploaded_file($tmp_name)){
            // open the file for a binary read
            $file = fopen($tmp_name,'rb');
            // read the file content into a variable
            $data = fread($file,filesize($tmp_name));
            // close the file
            fclose($file);
            // now we encode it and split it into acceptable length lines
            $data = chunk_split(base64_encode($data));
         }
        // now we'll insert a boundary to indicate we're starting the attachment
         // we have to specify the content type, file name, and disposition as
         // an attachment, then add the file content.
         // NOTE: we don't set another boundary to indicate that the end of the 
         // file has been reached here. we only want one boundary between each file
         // we'll add the final one after the loop finishes.
         $message .= "--{$mime_boundary}\n" .
            "Content-Type: {$type};\n" .
            " name=\"{$name}\"\n" .
            "Content-Disposition: attachment;\n" .
            " filename=\"{$fileatt_name}\"\n" .
            "Content-Transfer-Encoding: base64\n\n" .
         $data . "\n\n";
      }

   }

   // here's our closing mime boundary that indicates the last of the message
   $message.="--{$mime_boundary}--\n";
   // now we just send the message
	
	
	mail($to,$subj, $message, $headers);
}

//header("location:sendAds.php?mess=2");


?>
