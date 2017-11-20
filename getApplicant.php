<?
include './conf/zend_smarty_conf_root.php';
include 'function.php';
$userid=$_GET['q'];

$query="SELECT * FROM personal p LEFT OUTER JOIN currentjob c ON c.userid = p.userid WHERE p.userid= $userid;";
$result = $db->fetchRow($query);

$latest_job_title=$result['latest_job_title'];
$image= $result['image'];
$name = $result['fname']." ".$result['lname'];
$email =$result['email'];
$skype = $result['skype_id'];
$tel=$result['tel_area_code']." - ".$result['tel_no'];
$cell =$result['handphone_country_code']."+".$result['handphone_no'];
$gender =$result['gender'];
$dateapplied =$result['datecreated'];
$dateupdated =$result['dateupdated'];
$address=$result['address1']." ".$result['city']." ".$result['postcode']." ".$result['state']." ".$result['country_id'];
$nationality =$result['nationality'];

?>

<div style="border:#CCCCCC solid 1px; padding:5px;">
	<div class="showApp_img"><img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>"  /></div>
	<div style="float:left;">
	<fieldset>
	<legend>Edit Staff Email / Skype </legend>
	<p ><label ><b>Name : </b></label><a href="javascript:popup_win('./resume3.php?userid=<?php echo $userid;?>',800,500);"><?php echo strtoupper($name);?></a></p>
	<p ><label ><b>Email :</b></label><input type="text" class="select" name="email" id="email" value="<?php echo $email;?>" /></p>
	<p ><label ><b>Skype :</b></label><input type="text" class="select" name="skype" id="skype" value="<?php echo $skype;?>" /></p>
	</fieldset>
	</div>
	<div style="float:left; margin-left:5px;">
	<p><b>Date Registered : </b><?php echo format_date($dateapplied);?></p>
	<p ><label ><b>Mobile : </b></label><?php echo $cell ? $cell : '&nbsp;';?></p>
	<p ><label ><b>Phone : </b></label><?php echo $tel ? $tel : '&nbsp;';?></p>
	<p ><label ><b>Address : </b></label><?php echo $address ? $address : '&nbsp;';?></p>
	</div>
	<div style="clear:both;"></div>
</div>


