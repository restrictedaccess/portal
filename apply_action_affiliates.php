<?php
include 'config.php';
include 'function.php';
include 'conf.php';

if($_SESSION['agent_no']==""){
	header("location:index.php");
}

$agent_no = $_SESSION['agent_no'];
$aff_no=$_REQUEST['id'];
$hid=$_REQUEST['hid'];

if($hid!=NULL){
	$query="DELETE FROM history_affiliates WHERE id  = $hid;";
	mysql_query($query);
}

//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads, agent_bank_account, aff_marketing_plans, companyname, companyposition, integrate, country_location, commission_type

$query = "SELECT CONCAT(fname,' ',lname), email,  DATE_FORMAT(date_registered,'%D %b %Y'), agent_code, agent_address, agent_contact, hosting, aff_marketing_plans, companyname, companyposition
		  FROM agent a WHERE agent_no = $aff_no;";
$result = mysql_query($query);	
list($aff_name,$email,$date_registered,$agent_code, $agent_address, $agent_contact, $hosting, $aff_marketing_plans, $companyname, $companyposition)=mysql_fetch_array($result);	  

	
?>



<html>

<head>

<title>Business Partner Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script language=javascript src="js/functions.js"></script>
<link rel=stylesheet type=text/css href="product_need/product_needs.css">
<script language=javascript src="product_need/product_need.js"></script>

<style>
<!--
#affiliate_info{
	
}
#affiliate_info p{
	margin-bottom:8px;
	margin-top:5px;
}
#affiliate_info label{
	display:block;
	float:left;
	width:150px;
	color:#666666;
	
}
#action_records {
	margin-top:10px;
	padding:5px;
}
-->
</style>
</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="apply_actionphp_affiliates.php" enctype="multipart/form-data" >
<input type="hidden" name="aff_no" id="aff_no" value="<? echo $aff_no;?>">
<input type="hidden" name="job_order" id="job_order" >
<input type="hidden" name="fullname" value="<?=$aff_name;?>">
<input type="hidden" name="email" value="<? echo $email;?>">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'agentleftnav.php';?>
</td>

<td valign='top' align='left' style="font:12px Arial; padding:5px;" >
<div id="affiliate_info">
	<div style="padding:5px; font-size:16px;"><b>Manage Affiliate</b></div>
	<div style="padding:5px;" >
		<p><b style="color:#FF0000;">Affiliate Information</b></p>
		<p><label>Name : </label><b><?=$aff_name;?></b></p>
		<p><label>Email : </label><?=$email;?></p>
		<p><label>Company Name : </label><?=$companyname ? $companyname:'&nbsp;';?></p>
		<p><label>Company Position : </label><?=$companyposition ? $companyposition :'&nbsp;';?></p>
		<p><label>Date Registered : </label><?=$date_registered;?></p>
		<p><label>Agent Code : </label><?=$agent_code;?></p>
		<p><label>Address : </label><?=$agent_address ? $agent_address : '&nbsp;';?></p>
		<p><label>Contact Info : </label><?=$agent_contact ? $agent_contact : '&nbsp;';?></p>
		<p><label>Website : </label><?=$hosting ? $hosting : '&nbsp;';?></p>
		<p><label>Marketing Plans : </label><?=$aff_marketing_plans ? $aff_marketing_plans : '&nbsp;';?></p>
	</div>
	<div id="action_records">
		<div style="padding:5px; background:#DEE5EB; border:#DEE5EB outset 1px;"><b>Action Records</b></div>
		<div style="padding:5px; border:#DEE5EB solid 1px;">
			<p style="color:#333333;">Please send all Service Agreements Contracts to contracts@remotestaff.com.au</p>
			<div style="padding:5px;">
				<input type="radio" name="action" value="EMAIL" onClick="showEmailForm();" > Email &nbsp;
				<input type="radio" name="action" value="CALL" onClick="hideEmailForm();"> Call &nbsp;
				<input type="radio" name="action" value="MAIL" onClick="hideEmailForm();"> Notes &nbsp;
				<input type="radio" name="action" value="MEETING FACE TO FACE" onClick="hideEmailForm();"> Meeting face to face
			</div>
			<div>
			<textarea name="txt" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"><? echo $desc;?></textarea>
			<div id="email_form" style="display:none; padding:5px; margin-top:5px;">
			<p><label>Subject :</label><input type="text" name="subject" id="subject"></p> 
			<p><label>Attach File :</label><input type="file" name="image" id="image"  style="width:300px;"></p>
			
			</div>
			<div style="padding:5px; margin-top:10px;">
			<INPUT type="submit" value="save" name="Add" class="button" style="width:120px">&nbsp;&nbsp;
			<INPUT type="reset" value="Cancel" name="Cancel" class="button" style="width:120px">
			</div>
			</div>
		</div>
	<div align="center" style="font-weight:bold">
	<?php
	if($_GET['code'] == 1){
        echo "Email Sent";
    }
	?>
	</div>
		<div style="padding:5px; background:#DEE5EB; border:#DEE5EB outset 1px; margin-top:10px;"><b>Communication History</b></div>
		<div style=" border:#DEE5EB solid 1px;">
			<?
			$query = "SELECT id,  actions, history, DATE_FORMAT(date_created,'%D %b %Y %l:%i %p'), subject FROM history_affiliates h WHERE to_by_id = $aff_no AND to_by_type = 'affiliate' ORDER BY date_created DESC;";
			$result = mysql_query($query);
			$ctr_email=0;
			$ctr_call=0;
			$ctr_mail=0;
			$ctr_meet=0;
			while(list($id,  $actions, $history , $date ,$subject)=mysql_fetch_array($result))
			{
				$history_short=substr($history,0,50);
				if ($actions == "EMAIL"){
					$ctr_email++;
					$actions_email.="<div style='padding:5px; border-bottom:#999999 solid 1px;'>
										<div style='float:left; display:block; width:50px;'>".$ctr_email.")</div>
										<div style='float:left; display:block; width:800px;'><a href=javascript:popup_win('./viewAffHistory.php?id=$id&view=aff',500,400); title='$history'>".$history_short."</a></div>
										<div style='float:left; display:block; width:120px; font:10px tahoma; color:#999999'>
											<div style='float:left;'>".$date."</div>
											<div style='float:right;'><a href=javascript:deleteHistory($id,'$actions');>X</a></div>
										<div style='clear:both;'></div>
										</div>
										<div style='clear:both;'></div>
			</div>";
				}
				if ($actions == "CALL"){
					$ctr_call++;
					$actions_call.="<div style='padding:5px; border-bottom:#999999 solid 1px;'>
										<div style='float:left; display:block; width:50px;'>".$ctr_call.")</div>
										<div style='float:left; display:block; width:800px;'><a href=javascript:popup_win('./viewAffHistory.php?id=$id&view=aff',500,400); title='$history'>".$history_short."</a></div>
										<div style='float:left; display:block; width:120px; font:10px tahoma; color:#999999'>
											<div style='float:left;'>".$date."</div>
											<div style='float:right;'><a href=javascript:deleteHistory($id,'$actions');>X</a></div>
										<div style='clear:both;'></div>
										</div>
										<div style='clear:both;'></div>
									</div>";
				}
				if ($actions == "MAIL"){
					$ctr_mail++;
					$actions_mail.="<div style='padding:5px; border-bottom:#999999 solid 1px;'>
										<div style='float:left; display:block; width:50px;'>".$ctr_mail.")</div>
										<div style='float:left; display:block; width:800px;'><a href=javascript:popup_win('./viewAffHistory.php?id=$id&view=aff',500,400); title='$history'>".$history_short."</a></div>
										<div style='float:left; display:block; width:120px; font:10px tahoma; color:#999999'>
											<div style='float:left;'>".$date."</div>
											<div style='float:right;'><a href=javascript:deleteHistory($id,'$actions');>X</a></div>
										<div style='clear:both;'></div>
										</div>
										<div style='clear:both;'></div>
									</div>";
				}
				if ($actions == "MEETING FACE TO FACE"){
					$ctr_meet++;
					$actions_meet.="<div style='padding:5px; border-bottom:#999999 solid 1px;'>
										<div style='float:left; display:block; width:50px;'>".$ctr_meet.")</div>
										<div style='float:left; display:block; width:800px;'><a href=javascript:popup_win('./viewAffHistory.php?id=$id&view=aff',500,400); title='$history'>".$history_short."</a></div>
										<div style='float:left; display:block; width:120px; font:10px tahoma; color:#999999'>
											<div style='float:left;'>".$date."</div>
											<div style='float:right;'><a href=javascript:deleteHistory($id);>X</a></div>
										<div style='clear:both;'></div>
										</div>
										<div style='clear:both;'></div>
									</div>";
				}
			}
			if($ctr_email>0){
				echo "<div style='padding:5px; border-bottom:#999999 solid 1px; background:#EEEEEE'><img border='0' src='images/email.gif' >&nbsp;<b>Email</b></div>";
				echo "<div id='email' style='overflow:auto; height:150px;'>";
				echo $actions_email;
				echo "</div>";
			}
			if($ctr_call>0){
				echo "<div style='padding:5px; border-bottom:#999999 solid 1px; background:#EEEEEE'><img src='images/icon-telephone.jpg' alt='Call'>&nbsp;<b>CALL</b></div>";
				echo "<div style='overflow:auto; height:150px;'>";
				echo $actions_call;
				echo "</div>";
			}
			if($ctr_mail>0){
				echo "<div style='padding:5px; border-bottom:#999999 solid 1px; background:#EEEEEE'><img src='images/textfile16.png' alt='Notes' >&nbsp;<b>NOTES</b></div>";
				echo "<div style='overflow:auto; height:150px;'>";
				echo $actions_mail;
				echo "</div>";
			}
			if($ctr_meet>0){
				echo "<div style='padding:5px; border-bottom:#999999 solid 1px; background:#EEEEEE'><img src='images/icon-person.jpg' alt='Meet personally'>&nbsp;<b>MEETING FACE TO FACE</b></div>";
				echo "<div style='overflow:auto; height:150px;'>";
				echo $actions_meet;
				echo "</div>";
			}
			?>
			
		</div>
	</div>
</div>	
</td>
</tr>
</table>

<script type="text/javascript">
<!--
var xmlHttp
PATH;
function showEmailForm(){
	obj = document.getElementById("email_form");
	obj.style.display = (obj.style.display == "block") ? "none" : "block";
}
function hideEmailForm(){
	obj = document.getElementById("email_form");
	obj.style.display = "none";
}
function deleteHistory(id,actions){
	//alert(id);
	location.href = "apply_action_affiliates.php?hid="+id+"&id="+<?=$aff_no;?>;
}

--> 
</script>
<? include 'footer.php';?>
</form>
</body>
</html>

