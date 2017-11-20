<?php
include './conf/zend_smarty_conf_root.php';
header("location:/portal/django/subcontractors/subcon_payment_details/");
exit;
function sendZendMail($email_to,$subject,$message,$from_address,$from_name){
	$mail = new Zend_Mail();
	$mail->setBodyHtml($message);
	$mail->setFrom($from_address,$from_name);
	$mail->addTo($email_to);
	$mail->setSubject($subject);
	$mail->send($transport);
}

$userid = $_REQUEST['userid'];
if(!isset($_SESSION['admin_id']) && !isset($_SESSION['agent_no']))
{
	echo '
	<script language="javascript">
		alert("Session expired...'.$_SESSION['admin_id'].'");
		window.location="index.php";
	</script>
	';
}

$query="SELECT * FROM personal WHERE userid=$userid";
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];
$email = $result['email'];
$payment_details=$result['payment_details'];
$image = $result['image'];


if(@isset($_REQUEST["save"]))
{
	$hsbc_account_name = stripslashes($_REQUEST["hsbc_account_name"]);
	$hsbc_account_holder_name = stripslashes($_REQUEST["hsbc_account_holder_name"]);	
	$query="SELECT userid FROM subcon_bank_hsbc_remotestaff WHERE userid='$userid'";
    $sql = $db->select()
                ->from('subcon_bank_hsbc_remotestaff')
                ->where('userid = ?', $userid);
    $data = $db->fetchAll($sql);
	if (count($data) >0)
	{
        $data = array(
            'account_number' => $hsbc_account_name,
            'account_holders_name' => $hsbc_account_holder_name
        );

        $db->update('subcon_bank_hsbc_remotestaff', $data, "userid = $userid");
	}
	else
	{
        $data = array(
            'userid' => $userid,
            'account_number' => $hsbc_account_name,
            'account_holders_name' => $hsbc_account_holder_name
        );
        $db->insert('subcon_bank_hsbc_remotestaff', $data);
	}	
	
	$iremit_card_name = stripslashes($_REQUEST["iremit_card_name"]);
	$iremit_card_holder_name = stripslashes($_REQUEST["iremit_card_holder_name"]);
    $sql = $db->select()
                ->from('subcon_bank_iremit_sterling_visa')
                ->where('userid = ?', $userid);
    $data = $db->fetchAll($sql);

	if (count($data) > 0) {
        $data = array(
            'card_number' => $iremit_card_name,
            'account_holders_name' => $iremit_card_holder_name,
        );
        $db->update('subcon_bank_iremit_sterling_visa', $data, "userid = $userid");
	}
	else
	{
        $data = array(
            'card_number' => $iremit_card_name,
            'account_holders_name' => $iremit_card_holder_name,
            'userid' => $userid
        );
        $db->insert('subcon_bank_iremit_sterling_visa', $data);
	}	
	
	
	
	
	
	//BANK OF ASIA
    $sql = $db->select()
                ->from('subcon_bank_sterling_bank_of_asia')
                ->where('userid = ?', $userid);
    $data = $db->fetchRow($sql);
	if (count($data) >0) {
		$OLD_sterling_bank_of_asia_card_name = $data["card_number"];
		$OLD_sterling_bank_of_asia_card_holder_name = $data["account_holders_name"];
	}
	
	$sterling_bank_of_asia_card_name = stripslashes($_REQUEST["sterling_bank_of_asia_card_name"]);
	$sterling_bank_of_asia_card_holder_name = stripslashes($_REQUEST["sterling_bank_of_asia_card_holder_name"]);
	
	//if($OLD_sterling_bank_of_asia_card_name != $sterling_bank_of_asia_card_name || $OLD_sterling_bank_of_asia_card_holder_name !=$sterling_bank_of_asia_card_holder_name)
	//{
		//$send_autoresponder = 1;	
	//}
	//else
	//{
		//$send_autoresponder = 0;
	//}
	
    $sql = $db->select()
                ->from('subcon_bank_sterling_bank_of_asia')
                ->where('userid = ?', $userid);
    $data = $db->fetchAll($sql);

	if (count($data) > 0) {
        $data = array(
            'card_number' => $sterling_bank_of_asia_card_name,
            'account_holders_name' => $sterling_bank_of_asia_card_holder_name,
        );
        $db->update('subcon_bank_sterling_bank_of_asia', $data, "userid = $userid");
	}
	else
	{
        $data = array(
            'card_number' => $sterling_bank_of_asia_card_name,
            'account_holders_name' => $sterling_bank_of_asia_card_holder_name,
            'userid' => $userid
        );
        $db->insert('subcon_bank_sterling_bank_of_asia', $data);
	}	
	
	
	//if($send_autoresponder == 1)
	//{
									//AUTORESPONDER - HEADER/FOOTER SETUP
									
													//GENERATE EMAIL BODY HEADER
													$body_header="
													<meta HTTP-EQUIV='Content-Type' charset='utf-8'>
													<style type=\"text/css\"> 
														.cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
														.cName label{ font-style:italic; font-size:8pt}
														.cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
														.jobRESH {color:#000000; size:2; font-weight:bold}
													</style>
													<style>
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
													<div align='center'>
													<table width='400' cellpadding='5' cellspacing='1' bgcolor='#FFFFFF'>
													<tr>
													<td bgcolor='#FFFFFF'>		
													<table width='100%' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>
													";
													//ENDED - GENERATE EMAIL BODY HEADER
													
													
													//GENERATE EMAIL BODY FOOTER
													$body_footer="
															<tr>
																<td colspan=2>
																	<font size=1 face='Verdana, Arial, Helvetica, sans-serif'>
																		<!--SOME MESSAGE HERE FOR FOOTER -->
																	</font>
																</td>
															</tr>								
													</table>
													</td>
													</tr>
													</table>		
													</div>
													";
													//ENDED EMAIL BODY FOOTER
									
															$body="
																	<tr>
																		<td colspan=2><img src='".$_SERVER['HTTP_HOST']."/images/remote-staff-logo.jpg' /></td>
																	</tr>
																	<tr>
																		<td colspan=2 align='left'>
																			<p>Hi ".$name.",</p> 
																			<p>Your bank account details have been updated by RemoteStaff Admin.</p>
																			<!--<p>Your next pay will be credited to your Sterling Bank account number ".$sterling_bank_of_asia_card_name.".</p>-->
																			<p>Should you have any questions please don't hesitate to contact your Client Staff relations Officer.</p><br />
																			<p><a href='mailto:staffclientrelations@remotestaff.com.au'>staffclientrelations@remotestaff.com.au</a></p>
																			</p>
																		</td>
																	</tr>
																	<tr>
																		<td colspan=2>&nbsp;</td>
																	</tr>
															";									
									
														$body = $body_header.$body.$body_footer;
														//$headers  = 'MIME-Version: 1.0' . "\r\n" ;
														//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ;
														//$headers .= "From: REMOTESTAFF.COM.AU<staffclientrelations@remotestaff.com.au>\r\nReply-To: REMOTESTAFF.COM.AU<staffclientrelations@remotestaff.com.au>\r\nReturn-Path: REMOTESTAFF.COM.AU<sstaffclientrelations@remotestaff.com.au>\r\n" ;
														$subject = "STAFF BANK ACCOUNT UPDATES";
														$message = $body;
														if (TEST)
														{
															$email = "devs@remotestaff.com.au";			
														}														
														//mail($email,$subject,$message,$headers) ;
														$from_address = "staffclientrelations@remotestaff.com.au";
														$from_name = "REMOTESTAFF.COM.AU";				
														//sendZendMail($email,$subject,$message,$from_address,$from_name);														
																							
									//ENDED AUTORESPONDER - HEADER/FOOTER SETUP		
	//}
	//ENDED - BANK OF ASIA
			
			
			
			
			
			

	$ba_bank_name = stripslashes($_REQUEST["ba_bank_name"]);
	$ba_bank_branch = stripslashes($_REQUEST["ba_bank_branch"]);
	$ba_swift_address = stripslashes($_REQUEST["ba_swift_address"]);
	$ba_bank_account_number = stripslashes($_REQUEST["ba_bank_account_number"]);
	$ba_account_holder_name = stripslashes($_REQUEST["ba_account_holder_name"]);
    $sql = $db->select()
                ->from('subcon_bank_others')
                ->where('userid = ?', $userid);
    $data = $db->fetchAll($sql);
	if (count($data) >0) {
        $data = array(
            'bank_name' => $ba_bank_name,
            'bank_branch' => $ba_bank_branch,
            'swift_address' => $ba_swift_address,
            'bank_account_number' => $ba_bank_account_number,
            'account_holders_name' => $ba_account_holder_name
        );
        $db->update('subcon_bank_others', $data, "userid = $userid");

	}
	else
	{
        $data = array(
            'bank_name' => $ba_bank_name,
            'bank_branch' => $ba_bank_branch,
            'swift_address' => $ba_swift_address,
            'bank_account_number' => $ba_bank_account_number,
            'account_holders_name' => $ba_account_holder_name,
            'userid' => $userid
        );
        $db->insert('subcon_bank_others', $data);
	}	
	echo '<script language="javascript"> alert("Changes has been applied."); </script>';
}
else
{

    $sql = $db->select()
                ->from('subcon_bank_hsbc_remotestaff')
                ->where('userid = ?', $userid);
    $data = $db->fetchRow($sql);
	if (count($data) >0) {
		$hsbc_account_name = $data['account_number'];
		$hsbc_account_holder_name = $data['account_holders_name'];	
	}
	
	
    $sql = $db->select()
                ->from('subcon_bank_iremit_sterling_visa')
                ->where('userid = ?', $userid);
    $data = $db->fetchRow($sql);

	if (count($data) >0) {
		$iremit_card_name = $data["card_number"];
		$iremit_card_holder_name = $data["account_holders_name"];
	}			


    $sql = $db->select()
                ->from('subcon_bank_sterling_bank_of_asia')
                ->where('userid = ?', $userid);
    $data = $db->fetchRow($sql);

	if (count($data) >0) {
		$sterling_bank_of_asia_card_name = $data["card_number"];
		$sterling_bank_of_asia_card_holder_name = $data["account_holders_name"];
	}	
	

    $sql = $db->select()
                ->from('subcon_bank_others')
                ->where('userid = ?', $userid);
    $data = $db->fetchRow($sql);
	if (count($data) > 0) {
		$ba_bank_name = $data["bank_name"];
		$ba_bank_branch = $data["bank_branch"];
		$ba_swift_address = $data["swift_address"];
		$ba_bank_account_number = $data["bank_account_number"];
		$ba_account_holder_name = $data["account_holders_name"];
	}	
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $name; ?>: <?php echo $userid; ?></title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden"  id="payment_details" name="payment_details" value="<?=$payment_details;?>">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="1081" valign="top">






<form method="post" action="?">
<input type="hidden" name="userid" value="<?php echo $userid; ?>">
<table width="823" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td width="823">
<table border='0' width='100%' align='center'>
 <tr>
   <td width='483' valign='top' rowspan='2'>



	
 	<table border="0" width="100%">
		<tr>
			<td valign="top">
				<table cellSpacing='0' cellPadding='0' width='100%' border='0'>
					<tr bgColor='#c0e0f5'>
						<td align='center' height='20'><b>HSBC Remote Staff Account</b></td>
					</tr>
				</table>
				<table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'>
					<tr>
						<td>
							<table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'>
								<tr>
									<td height="112" valign="top">
									
									
										<table cellspacing='0' cellpadding='4' width='100%' border='0'>
											<tr>
												<td width=30% align=right>HSBC Account Number :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='hsbc_account_name' value="<?php print htmlentities($hsbc_account_name, ENT_QUOTES);?>">
												</td>
											</tr>
											<tr>
												<td width=30% align=right>HSBC Account Holder Name :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='hsbc_account_holder_name' value="<?php print htmlentities($hsbc_account_holder_name, ENT_QUOTES);?>">
												</td>
											</tr>											
										</table>
										
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


	<br />
	

	<table border="0" width="100%">
		<tr>
			<td valign="top">
				<table cellSpacing='0' cellPadding='0' width='100%' border='0'>
					<tr bgColor='#c0e0f5'>
						<td align='center' height='20'><b>iRemit Sterling Visa Debit Card</b></td>
					</tr>
				</table>
				<table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'>
					<tr>
						<td>
							<table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'>
								<tr>
									<td height="112" valign="top">
									
									
										<table cellspacing='0' cellpadding='4' width='100%' border='0'>
											<tr>
												<td width=30% align=right>Card Number :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='iremit_card_name' value="<?php print htmlentities($iremit_card_name, ENT_QUOTES);?>">
												</td>
											</tr>
											<tr>
												<td width=30% align=right>Account Holder Name :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='iremit_card_holder_name' value="<?php print htmlentities($iremit_card_holder_name, ENT_QUOTES);?>">
												</td>
											</tr>											
										</table>
										
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


	<br />


	<table border="0" width="100%">
		<tr>
			<td valign="top">
				<table cellSpacing='0' cellPadding='0' width='100%' border='0'>
					<tr bgColor='#c0e0f5'>
						<td align='center' height='20'><b>Sterling Bank of Asia</b></td>
					</tr>
				</table>
				<table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'>
					<tr>
						<td>
							<table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'>
								<tr>
									<td height="112" valign="top">
									
									
										<table cellspacing='0' cellpadding='4' width='100%' border='0'>
											<tr>
												<td width=30% align=right>Card Number :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='sterling_bank_of_asia_card_name' value="<?php print htmlentities($sterling_bank_of_asia_card_name, ENT_QUOTES);?>">
												</td>
											</tr>
											<tr>
												<td width=30% align=right>Account Holder Name :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='sterling_bank_of_asia_card_holder_name' value="<?php print htmlentities($sterling_bank_of_asia_card_holder_name, ENT_QUOTES);?>">
												</td>
											</tr>											
										</table>
										
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


	<br />
    
    
	<table border="0" width="100%">
		<tr>
			<td valign="top">
				<table cellSpacing='0' cellPadding='0' width='100%' border='0'>
					<tr bgColor='#c0e0f5'>
						<td align='center' height='20'><b>Bank Account</b></td>
					</tr>
				</table>
				<table cellSpacing='1' cellPadding='0' width='100%' bgColor='#c0e0f5' border='0'>
					<tr>
						<td>
							<table cellSpacing='0' cellPadding='8' width='100%' bgColor='#ffffff' border='0'>
								<tr>
									<td height="112" valign="top">
									
									
										<table cellspacing='0' cellpadding='4' width='100%' border='0'>
											<tr>
												<td width=30% align=right>Bank Name :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='ba_bank_name' value="<?php print htmlentities($ba_bank_name, ENT_QUOTES);?>">
												</td>
											</tr>
											<tr>
												<td width=30% align=right>Bank Branch :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='ba_bank_branch' value="<?php print htmlentities($ba_bank_branch, ENT_QUOTES);?>">
												</td>
											</tr>	
											<tr>
												<td width=30% align=right>Swift Address :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='ba_swift_address' value="<?php print htmlentities($ba_swift_address, ENT_QUOTES);?>">
												</td>
											</tr>				
											<tr>
												<td width=30% align=right>Bank Account Number :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='ba_bank_account_number' value="<?php print htmlentities($ba_bank_account_number, ENT_QUOTES);?>">
												</td>
											</tr>
											<tr>
												<td width=30% align=right>Account Holder Name :</td><td colspan=2 >
												<INPUT size='30' class='text' style="width:270px" name='ba_account_holder_name' value="<?php print htmlentities($ba_account_holder_name, ENT_QUOTES);?>">
												</td>
											</tr>																															
										</table>
										
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


	<br />


	<table border="0" width="100%">
		<tr>
			<td valign="top">
				<table cellSpacing='0' cellPadding='0' width='100%' border='0'>
					<tr bgColor='#c0e0f5'>
						<td align='center' height='20'><INPUT type=submit value='Update' name="save" class="button" style='width:120px'></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>	






 
 </td></tr></table></td>
				</tr>
			</table>
</form>





</div>
</div></td>
</tr>
</table>
<script type="text/javascript">
<!--
checkPaymentDetails();
-->
</script>
</body>
</html>
