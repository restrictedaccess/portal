<?
//from : application_apply_action.php
include 'config.php';
include 'conf.php';
include 'function.php';
include("lib/validEmail.php");

include 'time.php';
include('AgentCurlMailSender.php');


if(!isset($_SESSION['admin_id']) && !isset($_SESSION['agent_no']))
{
	echo '
	<script language="javascript">
		alert("Session expired...'.$_SESSION['admin_id'].'");
		window.location="index.php";
	</script>
	';
}



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_POST['userid'];
if(!isset($id))
{
	$id=$_GET['userid'];
}

if(@isset($_POST["upload_file"]))
{
			if(basename($_FILES['fileimg']['name']) != NULL || basename($_FILES['fileimg']['name']) != "")
			{
				$file_description = $_POST["file_description"];
				$date_created = $AusDate;
				$name = $id."_".basename($_FILES['fileimg']['name']);
				
				$name = str_replace(" ", "_", $name);
				$name = str_replace("'", "", $name);
				$name = str_replace("-", "_", $name);
				$name = str_replace("#", "", $name);
				$name = str_replace("php", "php.txt", $name);								
				
				$file = "applicants_files/".$id."_".basename($_FILES['fileimg']['name']);
				
				$file = str_replace(" ", "_", $file);
				$file = str_replace("'", "", $file);
				$file = str_replace("-", "_", $file);
				$file = str_replace("#", "", $file);
				$file = str_replace("php", "php.txt", $file);	
								
				$result= move_uploaded_file($_FILES['fileimg']['tmp_name'],$file); 
				if (!$result)
				{
					echo '
					<script language="javascript">
						alert("Error uploading file, file type is not allowed.");
						window.location="application_apply_action.php?userid="+'.$id.';
					</script>						
					';
				}
				else
				{
					$filename_ = "applicants_files/".$id."_".basename($_FILES['fileimg']['name']);
					
					$filename_ = str_replace(" ", "_", $filename_);
					$filename_ = str_replace("'", "", $filename_);
					$filename_ = str_replace("-", "_", $filename_);
					
					$file_p = pathinfo($filename_);
					extract(pathinfo($filename_));
					chmod($filename_, 0777);
					mysql_query("INSERT INTO tb_applicant_files(userid, file_description, name, date_created) VALUES('$id', '$file_description', '$name', '$date_created')");
					echo '
					<script language="javascript">
						alert("File uploaded.");
						window.location="application_apply_action.php?userid="+'.$id.';
					</script>						
					';	
				}
			}
			header("location:application_apply_action.php?userid=$id");
}
elseif(isset($_POST['sound_btn']))
{
	$userid = $_GET["userid"];
	$uploadDir = 'uploads/voice/'; 
	$tmpName = $_FILES['sound_file']['tmp_name']; 
	$sound = $_FILES['sound_file']['name']; 
	$soundsize= $_FILES['sound_file']['size']; 
	$soundtype = $_FILES['sound_file']['type'];
	if($sound != '')
	{
		if($soundtype=="audio/x-ms-wma") 
		{ 
			$soundtype=".wma"; 
		} 
		elseif($soundtype=="audio/wav") 
		{ 
			$soundtype=".wav"; 
		} 
		elseif($soundtype=="audio/mpeg") 
		{ 
			$soundtype=".mp3"; 
		}
		elseif($soundtype=="application/octet-stream") 
		{ 
			$soundtype=".mp3"; 
		} 
		elseif($soundtype=="audio/mpeg3") 
		{ 
			$soundtype=".mp3"; 
		} 
		else 
		{ 
?>
			<script language="javascript">
				alert("Error uploading file, file type is not allowed.");
				window.location="application_apply_action.php?userid="+<?php echo $id; ?>;
			</script>		
<?php
			exit; 
		} 
	}
	
	$result= move_uploaded_file($tmpName, $uploadDir.$id.$soundtype); 
	if (!$result) 
		{ 
			echo "Error uploading file"; 
			//mysql_query("DELETE FROM users WHERE userid =$userid"); 
			//$sql="DELETE FROM users WHERE userid =$userid";
			//mysql_query($sql);
			exit; 
		} 
		else 
		{ 
			$sql2="UPDATE personal SET voice_path='$uploadDir$id$soundtype' , dateupdated = '$ATZ' WHERE userid=$id";
			mysql_query($sql2);
?>
			<script language="javascript">
				alert("Voice has been uploaded.");
				window.location="application_apply_action.php?userid="+<?php echo $id; ?>;
			</script>
<?php
		} 
}
elseif(isset($_POST['picture']))
{
	$uploadDir = 'uploads/pics/'; 
	//temporary name of image
	$tmpName = $_FILES['img']['tmp_name']; 
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
?>
			<script language="javascript">
				alert("Error uploading file, file type is not allowed.");
				window.location="application_apply_action.php?userid="+<?php echo $id; ?>;
			</script>
<?php		
			exit; 
		} 
	}
	if ($img != '')
	{
		$result= move_uploaded_file($tmpName, $uploadDir.$id.$imgtype); 
		if (!$result) 
		{ 
?>
			<script language="javascript">
				alert("Error uploading file.");
				window.location="application_apply_action.php?userid="+<?php echo $id; ?>;
			</script>
<?php				
			exit; 
			$sql="DELETE FROM users WHERE userid=$id";
			mysql_query($sql);
			
		} 
		else 
		{ 
			$sql2="UPDATE personal SET image='$uploadDir$id$imgtype' , dateupdated = '$ATZ' WHERE userid='$id'";
			mysql_query($sql2);
?>
			<script language="javascript">
				alert("The picture has been changed.");
				window.location="application_apply_action.php?userid="+<?php echo $id; ?>;
			</script>
<?php	
			exit;
		} 
	}	
	//header("location:application_apply_action.php?userid=$id");	
}
elseif(@isset($_GET["delete"]))
{
	$name = @$_GET["delete"];
	mysql_query("DELETE FROM tb_applicant_files WHERE name='$name'");	
	$name = basename($name);
	unlink("applicants_files/".$_GET["delete"]);
?>
			<script language="javascript">
				alert("File deleted.");
				window.location="application_apply_action.php?userid="+<?php echo $id; ?>;
			</script>
<?php		
}
else
{
					$agent_no = $_SESSION['admin_id'];
					$action = $_REQUEST['action'];
					$txt = $_REQUEST['txt'];
					$subject=$_REQUEST['subject'];
					$mode =$_REQUEST['mode'];
					$hid =$_REQUEST['hid'];
					$star=$_REQUEST['star'];
					$templates=$_REQUEST['templates'];
					
					
					if(isset($_POST['Add']))
					{
					
					if($mode=="")
					{
					
						if($action=="EMAIL")
						{	
							$email=$_REQUEST['email'];
							if($email == "" || $email == " ")
							{
											?>
														<script language="javascript">
															alert("Email not found.");
															window.location="application_apply_action.php?userid=<?php echo $id; ?>&code=2";
														</script>
											<?php						
							}	
							else							
							{
									if (validEmail($email)) 
									{						
										$query="SELECT * FROM admin WHERE admin_id='$agent_no';";
										$result=mysql_query($query);
										$ctr=@mysql_num_rows($result);
										if ($ctr >0 )
										{
											$row = mysql_fetch_array ($result); 
											$name = $row['admin_fname']." ".$row['admin_lname'];
											$agent_email=$row['admin_email'];
											$agent_address =$row['admin_email'];
											$agent_contact =$row['admin_email'];
											$agent_abn =$row['admin_email'];
											$email2 =$row['admin_email'];
											$agent_code=$row['admin_id'];
											$link="<a href='http://www.remotestaff.com.au/$agent_code' target='_blank'>http://www.remotestaff.com.au/$agent_code</a>";
											if($email2!="")
											{
												$agent_email = $email2;
											}
										}
										if($subject=="")
										{
											$subject='Message from RemoteStaff.com c/o  '.$name;
										}
										
										$email=$_REQUEST['email'];
										$fullname=$_REQUEST['fullname'];
										$txt=str_replace("\n","<br>",$txt);
										$to=$email;
										$subj=$subject;
											
										$mess =$txt;
										$text = $quote_MESSAGE.$service_agreement_MESSAGE.$setup_fee_MESSAGE.$credit_debit_card_MESSAGE.$job_order_form_MESSAGE;
										
										if (($templates =="signature")||($templates ==""))
										{
												$message ="<div style='font:12px Tahoma; padding:10px;'>
															<div align='justify' style='padding:15px;margin-top:10px;' >".$mess."</div>
															<div align='justify' style='padding:15px;margin-top:10px;' >".$text."</div>
															
															<div style='margin-top:20px;'>
															<a href='http://www.remotestaff.com.au/$agent_code'>
															<img src='http://www.remotestaff.com.au/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>
															<span style='color:#00CCCC;'>www.remotestaff.com.au</span><br /><br />
															Email: ".$agent_email."<br />
															</div>
														</div>";
										}
								
										if($templates=="promotional")
										{
												$message="
														<h1>Template For Applicantions</h1>
														<div style='font:12px Tahoma; padding:10px;'>".$mess .$text."</div>";
										}
										if ($templates =="plain")
										{
											$message = $mess .$text;
										}	
										
										
										////////////////// FILE ATTACHEMENTS /////////////////
										$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
										//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$headers = "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
										$headers .= "MIME-Version: 1.0\r\n" ."Content-Type: multipart/mixed;\r\n" ." boundary=\"{$mime_boundary}\"";
										$message = "This is a multi-part message in MIME format.\n\n" .
												  "--{$mime_boundary}\n" .
												  "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
												  "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
								
										  foreach($_FILES as $userfile)
										  {
											  // store the file information to variables for easier access
											  $tmp_name = $userfile['tmp_name'];
											  $type = $userfile['type'];
											  $name = $userfile['name'];
											  $size = $userfile['size'];
											 // if the upload succeded, the file will exist
											  if (file_exists($tmp_name))
											  {
													// check to make sure that it is an uploaded file and not a system file
													if(is_uploaded_file($tmp_name))
													{
														// open the file for a binary read
														$file = fopen($tmp_name,'rb');
														// read the file content into a variable
														$data = fread($file,filesize($tmp_name));
														// close the file
														fclose($file);
														// now we encode it and split it into acceptable length lines
														$data = chunk_split(base64_encode($data));
													 }
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
											//$curl_mail_sender = new AgentCurlMailSender();
											//$result = $curl_mail_sender->SendMailWithHeaders($to, $subject, $message, $headers);
									   
									   
													//SEGNATURE						   
													$admin_id = $_SESSION['admin_id'];
													$admin_status=$_SESSION['status'];
													$site = $_SERVER['HTTP_HOST'];
													
													$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
													$result=mysql_query($sql);
													$ctr=@mysql_num_rows($result);
													if ($ctr >0 )
													{
														$row = mysql_fetch_array ($result); 
														$admin_email = $row['admin_email'];
														$name = $row['admin_fname']." ".$result['admin_lname'];
														$admin_email=$row['admin_email'];
														$signature_company = $row['signature_company'];
														$signature_notes = $row['signature_notes'];
														$signature_contact_nos = $row['signature_contact_nos'];
														$signature_websites = $row['signature_websites'];
													}
													
			
													
													if($signature_notes!="")
													{
														$signature_notes = "<p><i>$signature_notes</i></p>";
													}
													else
													{
														$signature_notes = "";
													}
													if($signature_company!="")
													{
														$signature_company="<br>$signature_company";
													}
													else
													{
														$signature_company="<br>RemoteStaff";
													}
													if($signature_contact_nos!="")
													{
														$signature_contact_nos = "<br>$signature_contact_nos";
													}
													else
													{
														$signature_contact_nos = "";
													}
													if($signature_websites!="")
													{
														$signature_websites = "<br>Websites : $signature_websites";
													}
													else
													{
														$signature_websites = "";
													}
													
													$signature_template = $signature_notes;
													$signature_template .="<a href='http://$site/$agent_code'>
																<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
													$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
													$message .= $signature_template;						   
													//END SEGNATURE						   
									   
									   
										mail($to, $subject, $message, $headers);
										//echo $message;
										
										//if($result != 'Success!'){
											//echo "Failed to send email.";
											
											//header("location:application_apply_action.php?userid=$id&code=2");
										//}
										//else
										//{
											$txt=filterfield($txt);
											$query ="INSERT INTO applicant_history (agent_no, userid, actions, history, date_created) VALUES ('$agent_no', '$id', 'EMAIL', '$txt', '$ATZ');";
											mysql_query($query);
											$history_id = mysql_insert_id();
											if($quote_id!=NULL)
											{
												$sql="INSERT INTO applicant_history_attachments SET 
														history_id = $history_id, 
														userid = $id ,
														attachment =$quote_id, 
														attachment_type = 'Quote',
														date_attach = '$ATZ', 
														user_type_id = $agent_no, 
														user_type = 'agent';";
												mysql_query($sql);	
												//echo $sql;	
											}
											if($service_agreement_id!=NULL)
											{
												$sql="INSERT INTO applicant_history_attachments SET 
														history_id = $history_id, 
														userid = $id ,
														attachment = $service_agreement_id, 
														attachment_type = 'Service Agreement',
														date_attach = '$ATZ', 
														user_type_id = $agent_no, 
														user_type = 'agent';";
												mysql_query($sql);	
											}
											if($setup_fee_id!=NULL)
											{
												$sql="INSERT INTO applicant_history_attachments SET 
														history_id = $history_id, 
														userid = $id ,
														attachment = $setup_fee_id, 
														attachment_type = 'Set-Up Fee Invoice',
														date_attach = '$ATZ', 
														user_type_id = $agent_no, 
														user_type = 'agent';";
												mysql_query($sql);	
											}
											?>
														<script language="javascript">
															alert("Email has been sent.");
															window.location="application_apply_action.php?userid=<?php echo $id; ?>&code=2";
														</script>
											<?php						
											//header("location:application_apply_action.php?userid=$id&code=1");
											//echo $message;
										//}
									}
									else
									{
											?>
														<script language="javascript">
															alert("Invalid Email Address.");
															window.location="application_apply_action.php?userid=<?php echo $id; ?>&code=2";
														</script>
											<?php						

									}	
							}
						}
						else
						{
							$txt=filterfield($txt);
							$query="INSERT INTO applicant_history (agent_no, userid,actions, history,date_created) VALUES ('$agent_no', '$id','$action', '$txt', '$ATZ');";
							$result=mysql_query($query);
							if (!$result)
							{
								//$mess="Error";
								echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
						
							}
							else
							{
								//echo "Data Inserted";
								//header("location:education");
							header("location:application_apply_action.php?userid=$id");
							}
						}
						
					}
					
					
					
						if($mode=="update")
						{	$txt=filterfield($txt);
							$query="UPDATE applicant_history SET history ='$txt' WHERE id=$hid;";
							$result=mysql_query($query);
							if (!$result)
							{
								//$mess="Error";
								echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
							}
							else
							{
								//echo "Data Inserted";
								//header("location:education");
								header("location:application_apply_action.php?userid=$id");
							}
						}
					}
}
?>
