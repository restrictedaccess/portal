<?php
include 'config.php';
include 'conf.php'; 
include 'function.php';
include('../conf/zend_smarty_conf.php');
include 'lib/AvailableStaffCheckSum.php';
include 'lib/validEmail.php';
if($_SESSION['admin_id']=="")
{
	if($_SESSION['agent_no']=="")
	{
		header("location:index.php");
	}
}

$agent_no = $_SESSION['agent_no'];



//VALIDATE BP SESSION					
if(isset($_SESSION['agent_no']))
{
	$agent_no = $_SESSION['agent_no'];
	$temp = 0;
	$query=mysql_query("SELECT fname, lname, email FROM agent WHERE agent_no='$agent_no' LIMIT 1");
	$transaction_status = 0;
	$transaction_error_return = "<strong>Invalid Session ID</strong>";
	while ($row = mysql_fetch_assoc($query)) 
	{
		$_SESSION['auto_name'] = $row['fname']." ".$row['lname'];
		$_SESSION['auto_email'] = $row['email'];
		$transaction_status = 1;
		$transaction_error_return = "";
		$temp = 1;
	}	

	$query="SELECT * FROM agent a WHERE agent_no = ".$_SESSION['agent_no'];
    //echo $query."<br>";
    $result=mysql_query($query);
    $ctr=@mysql_num_rows($result);
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
    if($row['email']!="") $admin_email="Email :  ".$row['email'];
    //$signature_company = $row['signature_company'];
    //$signature_notes = $row['signature_notes'];
    $signature_contact_nos = $row['agent_contact'];
    //$signature_websites = $row['signature_websites'];
}	
else
{
	$admin_id = $_SESSION['admin_id'];
	$temp = 0;
	$query=mysql_query("SELECT admin_fname, admin_lname, admin_email FROM admin WHERE admin_id='$admin_id' LIMIT 1");
	$transaction_status = 0;
	$transaction_error_return = "<strong>Invalid Session ID</strong>";
	while ($row = mysql_fetch_assoc($query)) 
	{
		$_SESSION['auto_name'] = $row['admin_fname']." ".$row['admin_lname'];
		$_SESSION['auto_email'] = $row['admin_email'];
		$transaction_status = 1;
		$transaction_error_return = "";
		$temp = 1;
	}	
	//get default signature
	$query="SELECT * FROM admin a WHERE admin_id = ".$_SESSION['admin_id'];
    //echo $query."<br>";
    $result=mysql_query($query);
    $ctr=@mysql_num_rows($result);
    if ($ctr >0 )
    {
      $row = mysql_fetch_array ($result); 
      $name = $row['admin_fname']." ".$row['admin_lname'];
      if($row['admin_email']!="") $admin_email="Email :  ".$row['admin_email'];
      $signature_company = $row['signature_company'];
      $signature_notes = $row['signature_notes'];
      $signature_contact_nos = $row['signature_contact_nos'];
      $signature_websites = $row['signature_websites'];  
	}
}
//ENDED - VALIDATE CLIENT 

	//compose signature
	  if($signature_notes!=""){
        $signature_notes = "<p><i>$signature_notes</i></p>";
      }else{
        $signature_notes = "";
      }
      if($signature_company!=""){
        $signature_company="<br>$signature_company";
      }else{
        $signature_company="<br>RemoteStaff";
      }
      if($signature_contact_nos!=""){
        $signature_contact_nos = "<br>".nl2br($signature_contact_nos);
      }else{   
        $signature_contact_nos = "";
      }
      if($signature_websites!=""){
        $signature_websites = "<br>Websites : $signature_websites";
      }else{
        $signature_websites = "";  
      }
      

      $signature_template .="<br><img src='http://".$_SERVER['HTTP_HOST']."/portal/images/remote_staff_logo.png' width='171' height='49' border='0'><br>";
      $signature_template .= "<p><b>$name</b><br>$admin_email$signature_contact_nos$signature_websites<br>$signature_notes</p>";
	


//AUTORESPONDER - HEADER/FOOTER SETUP
													$body_header="
													<style type=\"text/css\"> 
														.cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
														.cName label{ font-style:italic; font-size:8pt}
														.cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
														.jobRESH {color:#000000; size:2; font-weight:bold}
													</style>
													<style>
													body{font: Arial 12px;}
													div.scroll {
															height: 300px;
															width: 100%;
															overflow: auto;
															border: 1px solid #CCCCCC;
																
														}
														.scroll p{
															margin-bottom: 10px;
															margin-top: 4px;
															margin-left:0px;
														}
														.scroll label
														{
														
															width:90px;
															float: left;
															text-align:right;
															
														}
														.spanner
														{
															width: 400px;
															overflow: auto;
															padding:5px 0 5px 10px;
															margin-left:20px;
															
														}
														
													#l {
														float: left;
														width: 350px;
														text-align:left;
														padding:5px 0 5px 10px;
														}	
													#l ul{
														   margin-bottom: 10px;
															margin-top: 10px;
															margin-left:20px;
														}	
													
													#r{
														float: right;
														width: 120px;
														text-align: left;
														padding:5px 0 5px 10px;
														}
													.ads{
														width:580px;
														
															}
													.ads h2{
														color:#990000;
														font-size: 2.5em;
														}	
													.ads p{	
															margin-bottom: 5px;
															margin-top: 5px;
															margin-left:30px;
														}
													.ads h3
													{
														color:#003366;
														font-size: 1.5em;
														margin-left:30px;
													}	
													#comment{
														float: right;
														width: 500px;
														padding:5px 0 5px 10px;
														margin-right:20px;
														margin-top:0px;
													}
													#comment p
													{
													
													margin-bottom: 4px;
													margin-top: 4px;
													}
													
													
													#comment label
													{
													display: block;
													width:100px;
													float: left;
													padding-right: 10px;
													font-size:11px;
													text-align:right;
													
													}
											
													</style>
													</head>
													<div align='center'>
													<table width='484' cellpadding='5' cellspacing='1' bgcolor='#FFFFFF'>
													<tr>
													<td bgcolor='#FFFFFF'>		
													<table width='484' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>
													";

													$body_footer="
															<tr>
																<td colspan=2>
																	<font >
																			<p>&nbsp;</p>
																			<p>Should you have any questions, please don't hesitate to contact us. </p>
																			<p>".$signature_template."
																			</p>
																	</font>
																</td>
															</tr>								
													</table>
													</td>
													</tr>
													</table>		
													</div>
													";
//ENDED AUTORESPONDER - HEADER/FOOTER SETUP	



//GENERATE CODE / PASSWORD
function rand_str($length = 12, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') 
{
				// Length of character list
				$chars_length = strlen($chars);
				// Start our string
				$string = $chars{rand(0, $chars_length)};
				// Generate random string
				for ($i = 1; $i < $length; $i++) 
				{
					// Grab a random character from our list
					$r = $chars{rand(0, $chars_length)};
					$string = $string . $r;
				}
				// Return the string
				return $string;
}
//ENDED - GENERATE CODE / PASSWORD


//SEND EMAIL
if(@isset($_POST["send"]))
{
	
	if(!validEmailv2($_POST['email'])){
	    $transaction_status = 0;
	    $transaction_error_return = sprintf("<strong><br />Invalid Email Address => %s</strong>", $_POST['email']);
	}
	
	foreach($_POST['cc'] as $cc){
		if($cc){
		    if(!validEmailv2($cc)){
			    $transaction_status = 0;
	            $transaction_error_return = sprintf("<strong><br />Invalid CC Email Address => %s</strong>", $cc);
				break;
		    }
		}
		
	}
	//echo sprintf('%s %s<br>', $cc, $transaction_error_return);
	//exit;
		//process send email 
		if($transaction_status == 1)
		{
							$email_footer_message = '
							<tr>
								<td colspan=2></td>
							</tr>							
							';
				
				
							//SETUP EMAIL - IF NO PROBLEM FOUND ON THE LEADS PROCESSING
										//GENERATE EMAIL BODY 1, BEFORE MAIN BODY
										$b_message = $_REQUEST['body_message'];
										$a = explode("\n", $b_message) ;
										$b_message = "";
										for ($q=0 ;$q<count($a) ;$q++) 
										{
											$b_message .= $a[$q]."<br>" ;
										}
										$body1="
												<tr>
													<td colspan=2><img src='".$_SERVER['HTTP_HOST']."/images/remote-staff-logo.jpg' /></td>
												</tr>
												<tr>
													<td colspan=2><br /><br />".$b_message."</font></td>
												</tr>
												<tr>
													<td colspan=2>&nbsp;</td>
												</tr>	
												<tr>
													<td colspan=2>&nbsp;</td>
												</tr>
										";
										//ENDED - GENERATE EMAIL BODY 1
								
								
										//SEND EMAIL SETUP
										$processing_result = "";
										$date_today = date('Y-m-d');
										$order_counter = $_SESSION["request_counter"];
										$subject = @$_REQUEST["subject"];						
										$to = $_POST["email"];
										$cc = $_POST["cc"];
										//echo $to." ".$cc;exit;
										$to = str_replace(" ","",$to);	
										
																//generate staff name array
																for($i = 0; $i < $order_counter; $i++)
																{
																		$applicant_id = @$_REQUEST["send_resume".$i];
																		//get personal
																		$p=mysql_query("SELECT fname FROM personal WHERE userid='$applicant_id' LIMIT 1");
																		$ctr=@mysql_num_rows($p);
																		if ($ctr > 0)
																		{
																			$r = mysql_fetch_array ($p); 
																			if($applicant_id == "" || $applicant_id == 0)
																			{
																				$app_fname[$i] = "";
																			}
																			else
																			{
																				//$fname_md5 = new AvailableStaffCheckSum($applicant_id, $db, 'personal', 'fname');
																				//if ($fname_md5->Valid()) 
																				//{
																				//	$app_fname[$i] = "<strong>".$r['fname']."</strong>";
																				//	$app_fname[$i] = str_replace(" ","&nbsp;",$app_fname[$i]);
																				//}
																				//else
																				//{
																				//	$app_fname[$i] = $applicant_id;
																				//}
																				
																						$couch_resume = new couchClient($couch_dsn, $couch_resume_db);
																
																						try{
																							$resume=null;
																							$resume=$couch_resume->getDoc($applicant_id);
																							
																							$app_fname[$i] = "<strong>".$applicant_id." ".$r['fname']."</strong>";
																							$app_fname[$i] = str_replace(" ","&nbsp;",$app_fname[$i]);
																								
																						} catch ( Exception $e ) {
																							$resume=null;
																							$app_fname[$i] = $applicant_id;
																						}
																						
																																										
																				
																			}	
																		}	
																		//ended
																}	
																//ended	
																
																//generate staff skills array
																for($i = 0; $i < $order_counter; $i++)
																{												
																		$applicant_id = @$_REQUEST["send_resume".$i];
																		$s=mysql_query("SELECT id, skill FROM skills WHERE userid='$applicant_id' LIMIT 1");
																		$ctr=@mysql_num_rows($s);
																		if ($ctr > 0)
																		{
																			if($applicant_id == "" || $applicant_id == 0)
																			{
																			}
																			else
																			{
																				if($skill_id == "" || $skill_id == 0)
																				{
																					$skill_selected[$i] = "";
																				}
																				else
																				{
																						$r = mysql_fetch_array ($s); 
																						$skill_id = $r['id'];
																						//$md5 = new AvailableStaffCheckSum($applicant_id, $db, 'skills', $skill_id);
																						//if ($md5->Valid()) 
																						//{
																							$skill_selected[$i] = $r['skill'];
																						//}					
																						//else
																						//{
																						//	$skill_selected[$i] = $skill_id;
																						//}
																				}		
																			}	
																		}
																  }
																  //ended
            $processing_result = $processing_result."<br /><br />".strtoupper($to);
			$lead_id = $_POST['leads_id'];
			//generate email body ------------------------------------------------
			$body = "";
			for($i = 0; $i < $order_counter; $i++)
			{
					$applicant_id = @$_REQUEST["send_resume".$i];
					if($applicant_id == "" || $applicant_id == 0)
					{
									//do nothing
					}
					else
					{

									$admin_id = $_SESSION['admin_id']; 
									$agent_id = $_SESSION['agent_no'];
									$userid = $applicant_id;
									
									$position_id = @$_REQUEST["position".$i]; 
									 
									//ON HOLD
									//HIRED
									//REJECTED
									//ARCHIVED
									$status = "ON HOLD";
									
									$date_added = date("Y-m-d");
									$final_Interview = "";
									$comment = $b_message;
									
									$body = $body."
									<tr>
										<td width='100%'><a href=\"http://".$_SERVER['HTTP_HOST']."/available-staff-resume.php?userid=".$applicant_id."\">".$app_fname[$i]."</a></td><td width='70%'>".$skill_selected[$i]."</td>
									</tr>
									";		
									$q = "INSERT INTO staff_resume_leads_sent SET admin_id='$admin_id', agent_id='$agent_id', userid='$userid', lead_id='$lead_id', position_id='$position_id', status='$status', date_added='$date_added', final_Interview='$final_Interview', comment='$comment'";
									mysql_query($q);
									$processing_result = $processing_result."<br /> - ".$app_fname[$i]."(sent)";
									$content_checker++;
					}															
							
			}
			//ended	-------------------------------------------
			if($content_checker > 0)
			{
				
				$email_content = $body_header.$body1.$body.$email_footer_message.$body_footer;
				$mail = new Zend_Mail();
				$mail->setBodyHtml($email_content);
				$mail->setFrom($_SESSION['auto_email'], 'REMOTESTAFF.COM.AU');
				if(! TEST){
					$mail->addTo($_POST['email'], $_POST['email']);
					foreach($_POST['cc'] as $cc){
						if($cc !=""){
						    $mail->addCc($cc, $cc);
						}
					}
					$mail->setSubject($subject);
				}else{
					$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
					$cc_str='';
					foreach($_POST['cc'] as $cc){
						if($cc !=""){
						    $mail->addCc('devs@remotestaff.com.au', $cc);
							$cc_str .=sprintf('%s,', $cc);
						}
					}
				    $mail->setSubject(sprintf('TEST %s [To=>%s Cc=>%s]', $subject, $_POST['email'], $cc_str));
				}	
				
				$mail->send($transport);																					
			}   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   

																
										//ENDED - SEND EMAIL SETUP
										
										//MESSAGE AFTER THE PROCESSING	
										$transaction_status = 1;
										echo '
										<table width=100% height="100%" cellpadding=10 cellspacing=10 border=0 align=center>
											<tr>
												<td width=100% height="100%" valign="middle" align="center">
													<table width=60% height="100%" cellpadding=10 cellspacing=10 border=0 align=center>
														<tr>
															<td width=100% height="100%" valign="middle">
																<font face="Verdana, Arial, Helvetica, sans-serif" size="2">
																<p>Thank You! </p>
																<p>
																'.$processing_result.'
																<p>RemoteStaff.com.au is news worth spreading around! </p>
																<br /><br /><input type="button" value="Close" onClick="javascript: window.close();">
																</p>
																</font>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>';
										//ENDED							
							//ENDED - SETUP EMAIL - IF NO PROBLEM FOUND ON THE LEADS PROCESSING
							//echo "=> ".$_POST['leads_id'];
			if(isset($_POST['leads_id']) != ""){				
			    $data = array('last_updated_date' => date('Y-m-d H:i:s'));
                $db->update('leads', $data, 'id='.$_POST['leads_id']);
			}	
		
		}
		else
		{
			$transaction_error_return = $transaction_error_return;	
		}	
		//ended - send email process
}
//ENDED - SEND EMAIL


$sql = $db->select()
    ->from('leads')
	->where('email =?', $_REQUEST['to']);
$lead = $db->fetchRow($sql);	
$email = $lead['email'];
$asl_cc_emails=array();

//check leads asl email setting
$sql = $db->select()
   ->from('leads_send_invoice_setting')
->where('leads_id =?', $lead['id']);
$invoice_setting = $db->fetchRow($sql);
if($invoice_setting['asl_default_email']){
	$email = $lead[$invoice_setting['asl_default_email']];
}
if($invoice_setting['asl_cc_emails']){
	$asl_cc_emails=explode(',',$invoice_setting['asl_cc_emails']);
}


//START: generate output box from selected order
$method_options = "EMAIL";
include("../available-staff-booking-session-selected.php");
//ENDED: generate output box from selected order
?>



<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
<style type="text/css">
<!--
div.scroll {
	height: 400px;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>


<script type="text/javascript">
	var curSubMenu = '';
	var sub_value = "Remotestaff: (<?php echo $FullName; ?>)";
	var to_array=new Array();
	var to_inputbox;
	var checker;
	var i=0;
	var temp;
	var num_selected = 0;
	var keyword;
	
	
	//SEARCH LEADS
	function makeObject()
	{
		var x ; 
		var browser = navigator.appName ;
		if(browser == 'Microsoft Internet Explorer')
		{
			x = new ActiveXObject('Microsoft.XMLHTTP')
		}
		else
		{
			x = new XMLHttpRequest()
		}
		return x ;
	}
	var request = makeObject()
	function query_lead()
	{
		keyword = document.getElementById('key_id').value;
		if(keyword == "" || keyword == "(fname/lname/email)")
		{
			alert("Please Enter Your Keyword!");
		}
		else
		{
			request.open('get', 'available-staff-search-leads.php?key='+keyword)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = active_listings 
			request.send(1)
		}
	}
	function active_listings()
	{
		var data;
		data = request.responseText
		if(request.readyState == 4)
		{
			document.getElementById('listings_div').innerHTML = data;
			document.getElementById('div'+num_selected).innerHTML = document.getElementById('listings_div').innerHTML;
		}
		else
		{
			document.getElementById("listings_div").innerHTML="<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='images/ajax-loader.gif'></td></tr></table>";
			document.getElementById('div'+num_selected).innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='images/ajax-loader.gif'></td></tr></table>";
		}
	}		
	//ENDED - SEARCH LEADS
	
	
	
	function validate(form) 
	{
		emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
		var regex = new RegExp(emailReg);
		if (form.email.value == '') { alert("You forgot to enter the email of your lead."); form.email.focus(); return false; }	
		if (form.subject.value == '') { alert("You forgot to enter the subject."); form.subject.focus(); return false; }	
		if (form.body_message.value == '') { alert("You forgot to enter the message."); form.body_message.focus(); return false; }			

		if(regex.test(form.email.value) == false)
		{
			alert('Please enter a valid email address of your lead and try again!');
			form.email.focus();
			return false;
		}
		return true;
	}
	
	function resume(id) 
	{
		previewPath = "../available-staff-resume.php?userid="+id;
		window.open(previewPath,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
	
	function createNewTextBox()
	{
		i = i + 1;
		document.getElementById('myDivName').innerHTML = document.getElementById('myDivName').innerHTML + "<table><tr><td><div id='name" + i + "'></div></td></tr><tr><td><input type='text' id='to_id" + i + "' name='to" + i + "' style='width:200' class='text' value=''></td><td><a href=\"javascript: search_lead("+i+"); \"><img src='images/view.gif' border='0'></a></td><td><div id='div"+i+"' STYLE='POSITION: Absolute'></div></td></tr></table>";
		document.getElementById('to_counter_id').value = i;
	}
	
	function search_lead(num)
	{
		num_selected = num;
		if (curSubMenu!='') 
			hideSubMenu();
			
		document.getElementById('div'+num).innerHTML = document.getElementById('search_box').innerHTML;	
		curSubMenu='div'+num;
	}
	function hideSubMenu()
	{
		document.getElementById(curSubMenu).innerHTML = "";
		curSubMenu='';
	}	
	function assign_email(email,name)
	{
		document.getElementById('to_id'+num_selected).value = email;
		document.getElementById('name'+num_selected).innerHTML = name + '<img src="images/arrow_down.gif">';			
	}
</script>


</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">
<form name="form" method="post" action="" onSubmit="return validate(this)">
<input type="hidden" size="20%" name="to_counter" id="to_counter_id" value=0 />
<input type="hidden" name="leads_id" id="leads_id" value="<?php echo $lead['id'];?>" />
<input type="hidden" name="client_type" id="client_type_id" value="not_registered">
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
<?php
if(@$transaction_error_return != "")
{
?>
	<tr>
		<td height="40" colspan="2">
				<h2 align="center" style="color:#F00"><?php echo $transaction_error_return;?></h2>
		</td>
	</tr>	
<?php 	
}
?>
	<tr>
		<td height="40" colspan="2">
			<div style='padding:3px; font:12px Arial;background:#2A629F; border:#2A629F outset 1px;'>
				<b><font color="#FFFFFF">Email Setup</font></b>
			</div>				
		</td>
	</tr>	
	<tr>
		<td height="32" colspan="2" valign="middle">
			<table width="100%">
				<tr>
					<td colspan="3">
						<table width="0%" border="0" cellspacing="5" cellpadding="5" style="margin:5px 8px 0px 8px;">		
							<tr>
								<td><strong>Option</strong></td>
								<td><strong>Candidate</strong></td>
								<td><strong>Category Where Sent</strong></td>
							</tr>	
							<?php echo $return_output; ?>
						</table><br /><br /> 
					</td>
				</tr>
                <tr>
                  <td colspan="3"><strong><?php echo $lead['fname']." ".$lead['lname']; ?></strong></td></tr>							
				<tr>
					<td width="11%" height="28" valign="top">To&nbsp;<font size="1"><em>(Email)</em></font><font color='#FF0000'><strong><img src='images/star.png'></strong></font></td>
					<td width="1%" valign="top">:</td>				
					<td><input type="text" id="email" name="email" value="<?php echo $email;?>" style="width:300px;" /></td>
				</tr>
                <?php 
					if(count($asl_cc_emails) > 0){
						foreach($asl_cc_emails as $cc){
				?>
                        <tr>
					    <td width="11%" height="28" valign="top">Cc</td>
					    <td width="1%" valign="top">:</td>				
					    <td><input type="text" name="cc[]" style="width:300px;" value="<?php echo $lead[$cc];?>" /></td>
				        </tr>
                <?php 
						} 
					}else{ ?>
                <tr>
					<td width="11%" height="28" valign="top">Cc</td>
					<td width="1%" valign="top">:</td>				
					<td><input type="text" name="cc[]" style="width:300px;" /></td>
				</tr>
                <?php } ?>		
				<tr>
					<td width="11%" height="28">Subject<font color="#FF0000"><strong><img src='images/star.png'></strong></font></td>
					<td width="1%">:</td>
					<td width="88%">
                      <input type="text" id="subject_id" name="subject" " style="width:70%" value="<?php echo @$_REQUEST["subject"]; ?>">
					</td>
				</tr>
				<tr>
					<td width="11%" height="28" valign="top">Message<font color="#FF0000"><strong><img src='images/star.png'></strong></font></td>
					<td width="1%" valign="top">:</td>				
					<td><textarea name="body_message" cols="48" rows="7" wrap="physical"   style="width:100%"><?php echo @$_REQUEST["body_message"]; ?></textarea></td>
				</tr>
				<tr>
					<td width="11%" height="28"></td>
					<td width="1%"></td>
					<td width="88%">
                      <INPUT type='submit' value='    SEND    ' name='send' class='button' style='width:120px'>
					</td>
				</tr>						
			</table>	
		</td>
	</tr>	
</table>
</form>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>




<div id="search_box" STYLE='POSITION: Absolute; visibility:hidden'>
<table cellpadding="1" cellspacing="0" bgcolor="#003366">
 <tr><td>
 <div id="listings_div">
 <table cellpadding="2" cellspacing="2" bgcolor="#FFFF99">
 	<tr><td colspan="2">(Keyword: <font color="#FF0000"><strong>ALL</strong></font> '<em>displays all leads</em>')</td></tr>	 
 	<tr>
		<td colspan="2">
			<input name="key" id="key_id" type="text" value="(fname/lname/email)" onMouseOut="javascript: if(this.value=='') { this.value='(fname/lname/email)'; } " onClick="javascript: if(this.value=='(fname/lname/email)') { this.value=''; } ">
			<input type="button" value="Search" class="button" onClick="javascript: query_lead();">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right"><a href="javascript: hideSubMenu(); "><img src="images/action_delete.gif" border="0"></a></td>
	</tr>	
 </table>
 </div>
 </td></tr>
 </table>
</div>


</body>
</html>
