<?
include 'conf.php';
include 'config.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$user=$_REQUEST['user'];
//echo $user;
if(isset($_POST['send']))
{
	$user=$_REQUEST['user'];  //CLIENT, AGENT, APPLICANT,SUBCON
	$email=$_REQUEST['email'];
	//echo $user."<br>".$email;
	
	///CHECK IF THE EMAIL EXIST 
	if ($user == "CLIENT") {
	 	$sqlCheck="SELECT * FROM leads WHERE email = '$email' AND status ='Client'";
		$result1=mysql_query($sqlCheck);
		$ctr1=@mysql_num_rows($result1);
		if ($ctr1 >0 )
		{
			//send email
			$row = mysql_fetch_array ($result1); 
			$password=$row['password'];
			$name =$row['fname']." ".$row['lname'];
			$from ="info@remotestaff.com.au";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";
			$header .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";		
			$message ="<div style='background:#F4F4F4; height:174px;'>
					    <div style='background:#FFFFFF; margin-top:10px; margin-bottom:10px; margin-left:10px; margin-right:10px;'>
					    <p style='margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;' >
						Hi  ".$name." ,<br /><br />
						As you requested here is your Login Details as : ".$user ." ". $_SERVER['HTTP_HOST']." <br /><br />
						EMAIL : ".$email. "<br />
						PASSWORD : ".$password."<br /><br /><br />
						Best Regards,<br />
						info@remotestaff.com.au
						</p>
						</div>
						</div>";
			$status = 1;			
	
		}
		else
		{
			$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><b><font color='#FF0000'>Email Does not Exist!</font></b></td></TR>";
			
		}
		
	}
	
	if ($user == "AGENT") {
	 	$sqlCheck2="SELECT * FROM agent WHERE email = '$email'";
		$result2=mysql_query($sqlCheck2);
		$ctr2=@mysql_num_rows($result2);
		if ($ctr2 >0 )
		{
			//send email
			$row = mysql_fetch_array ($result2); 
			$password=$row['agent_password'];
			$name =$row['fname']." ".$row['lname'];
			$from ="info@remotestaff.com.au";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";
			$header .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";				
			$message ="<div style='background:#F4F4F4; height:174px;'>
					    <div style='background:#FFFFFF; margin-top:10px; margin-bottom:10px; margin-left:10px; margin-right:10px;'>
					    <p style='margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;' >
						Hi  ".$name." ,<br /><br />
						As you requested here is your Login Details as : ".$user ." ". $_SERVER['HTTP_HOST']." <br /><br />
						EMAIL : ".$email. "<br />
						PASSWORD : ".$password."<br /><br /><br />
						Best Regards,<br />
						info@remotestaff.com.au
						</p>
						</div>
						</div>";
		$status = 1;
		}
		else
		{
			$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><b><font color='#FF0000'>Email Does not Exist!</font></b></td></TR>";
			
		}
	}
	if ($user == "APPLICANT") {
	 	$sqlCheck3="SELECT * FROM personal WHERE email = '$email'";
		$result3=mysql_query($sqlCheck3);
		$ctr3=@mysql_num_rows($result3);
		if ($ctr3 >0 )
		{
			//send email
			$row = mysql_fetch_array ($result3); 
			//$password=$row['pass'];
			$password=RandomCode();
			$name =$row['fname']." ".$row['lname'];
			$from ="info@remotestaff.com.au";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";	
			$header .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";			
			$message ="<div style='background:#F4F4F4; height:174px;'>
					    <div style='background:#FFFFFF; margin-top:10px; margin-bottom:10px; margin-left:10px; margin-right:10px;'>
					    <p style='margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;' >
						Hi  ".$name." ,<br /><br />
						As you requested here is your Login Details as : ".$user ." ". $_SERVER['HTTP_HOST']." <br /><br />
						EMAIL : ".$email. "<br />
						PASSWORD : ".$password."<br /><br /><br />
						Best Regards,<br />
						info@remotestaff.com.au
						</p>
						</div>
						</div>";
		$sqlUpdate="UPDATE personal SET pass ='".sha1($password)."' WHERE email = '$email'";	
		//echo $sqlUpdate."<br>";		
		mysql_query($sqlUpdate);
		$status = 1;
		}
		else
		{
			$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><b><font color='#FF0000'>Email Does not Exist!</font></b></td></TR>";
			
		}
	}
	
	if ($user == "SUBCON") {
	 	$sqlCheck4="SELECT * FROM personal WHERE email = '$email'";
		$result4=mysql_query($sqlCheck4);
		$ctr4=@mysql_num_rows($result4);
		if ($ctr4 >0 )
		{
			//send email
			$row = mysql_fetch_array ($result4); 
			//$password=$row['pass'];
			$password=RandomCode();
			$name =$row['fname']." ".$row['lname'];
			$from ="info@remotestaff.com.au";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";
			$header .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";				
			$message ="<div style='background:#F4F4F4; height:174px;'>
					    <div style='background:#FFFFFF; margin-top:10px; margin-bottom:10px; margin-left:10px; margin-right:10px;'>
					    <p style='margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;' >
						Hi  ".$name." ,<br /><br />
						As you requested here is your Login Details as : SUB-CONTRACTOR ". $_SERVER['HTTP_HOST']."<br /><br />
						EMAIL : ".$email. "<br />
						PASSWORD : ".$password."<br /><br /><br />
						Best Regards,<br />
						info@remotestaff.com.au
						</p>
						</div>
						</div>";
						
		$sqlUpdate="UPDATE personal SET pass ='".sha1($password)."' WHERE email = '$email'";	
		//echo $sqlUpdate."<br>";		
		mysql_query($sqlUpdate);
		$status = 1;
		}
		else
		{
			$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><b><font color='#FF0000'>Email Does not Exist!</font></b></td></TR>";
			
		}
	}
	
	//ADMIN
	if ($user == "ADMIN") {
	 	$sqlCheck5="SELECT * FROM admin WHERE admin_email = '$email'";
		$result5=mysql_query($sqlCheck5);
		$ctr5=@mysql_num_rows($result5);
		if ($ctr5 >0 )
		{
			//send email
			$row = mysql_fetch_array ($result5); 
			$password=RandomCode();
			$name =$row['admin_fname']." ".$row['admin_lname'];
			$from ="info@remotestaff.com.au";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from." \r\n"."Reply-To: ".$from."\r\n";
			$header .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";				
			$message ="<div style='background:#F4F4F4; height:174px;'>
					    <div style='background:#FFFFFF; margin-top:10px; margin-bottom:10px; margin-left:10px; margin-right:10px;'>
					    <p style='margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;' >
						Hi  ".$name." ,<br /><br />
						As you requested here is your Login Details as : ADMIN ". $_SERVER['HTTP_HOST']."<br /><br />
						EMAIL : ".$email. "<br />
						PASSWORD : ".$password."<br /><br /><br />
						Best Regards,<br />
						info@remotestaff.com.au
						</p>
						</div>
						</div>";
		$sqlUpdate="UPDATE admin SET admin_password ='".sha1($password)."' WHERE admin_email = '$email'";	
		//echo $sqlUpdate."<br>";		
		mysql_query($sqlUpdate);
		$status = 1;
		}
		else
		{
			$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><b><font color='#FF0000'>Email Does not Exist!</font></b></td></TR>";
			
		}
	}		
	
	//echo $message;
	
	if($status == 1){
	$mail=mail($email.$to,'REMOTESTAFF LOGIN DETAILS',$message,$header);
	if(!$mail)
	{
	$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><b><font color='#FF0000'>Message Sending Failed Please try Again!</font></b></td></TR>";
	}
	else
	{
	$error="<TR><td height='37' colspan='2' bgcolor='#FFFFCC' align='center'><font color='#0000FF'>Your Password has been sent to ".$email.".<br>
Please check your Email.</font></td></TR>";
	}
	}
	
}

?>
<html>
<head>
<title>RemoteStaff.com</title>
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
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>RETRIEVE PASSWORD</font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td>
<table width="99%" height="147" border="0" cellpadding="0" cellspacing="0" class="text">
                <!--DWLayoutTable-->
                <form action="forgotpassword.php" name="form" method="post">
				<input type="hidden"  name="user" value="<?=$user;?>">
                 <? if ($error!="") {echo $error;}?>
                  <tr> 
                    <td height="108">&nbsp;</td>
                    <td valign="top"> 
                     Enter your email address to generate New Password. <span class="tip">(System Generated)</span> <br> 
                      <br>
					 E-mail Address: &nbsp; <input type="text" name="email" class="text" style="width:40%" value="<?=$email;?>"> 
                      <br> <br> <input name="send" type="submit" value="Send password"></td>
                  </tr>
                 
                </form>
            </table>
		</td></tr>
		</table>
	</td></tr>
	</table>

	</body>
	</html>

