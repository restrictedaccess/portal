<?
include_once("hash.lib.php") ;
$zig_hash = new zig_hash ;
$hash_email = $zig_hash->hash("hash","encrypt",$fetch['email']) ;



$email="normaneil007@yahoo.com";
$agent_email="chrisj@remotestaff.com.au";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: RemoteStaff.Com.Au \r\n"."Reply-To: ".$agent_email."\r\n";

//////////  SEND CONFIRMATION EMAIL TO THE USER  TO VERIFY HIS EMAIL ADDRESS ////////////////		

$body= "Hi <br><br>"."To complete your request, you need to confirm your email address by clicking on the link below or copy and paste the link to the browser: <br><br>".
"<a href ='http://www.philippinesatwork.com/dev/norman/Chris/authenticate.php?zig_hash=$hash_email'>http://www.philippinesatwork.com/dev/norman/Chris/authenticate.php?zig_hash=$hash_email</a>";
mail($email,'PLEASE VERIFY YOUR EMAIL ADDRESS',$body,$headers);
////////////////////////////////////////////////////////////////////////////////////////////
?>
