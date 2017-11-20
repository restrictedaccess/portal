<?php 
//2010-02-24 Normaneil Macutay <normanm@remotestaff.com.au>
// - change the php short tags(<?) to <?php
// - zend script enable

include './conf/zend_smarty_conf_root.php';
include ('./leads_information/AdminBPActionHistoryToLeads.php');

include 'time.php';
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$client_id = $_SESSION['client_id'];
$query="SELECT * FROM leads WHERE id = $client_id;";
$row = $db->fetchRow($query);
$lname = $row['lname'];
$fname = $row['fname'];
$email = $row['email'];
$created_by_id = $row['business_partner_id'];
$company_name = $row['company_name'];

$client_name= $fname." ".$lname;

if(isset($_POST['post'])){
	$lead_id=$_REQUEST['lead_id'];
	$outsourcing_model=$_REQUEST['outsourcing_model'];
	$companyname=$_REQUEST['companyname'];
	$jobposition=$_REQUEST['jobposition'];
	$jobvacancy_no=$_REQUEST['jobvacancy_no'];
	$heading = $_REQUEST['heading'];
	$category_id = $_REQUEST['category_id'];
	$status = $_REQUEST['status'];
	$show_status = $_REQUEST['show_status'];
	
	$data = array(
			'agent_id' => $_SESSION['client_id'], 
			'created_by_type' => 'leads',
			'lead_id' => $lead_id, 
			'category_id' => $category_id,
			'date_created' => $ATZ, 
			'outsourcing_model' => $outsourcing_model, 
			'companyname' => $companyname, 
			'jobposition' => $jobposition, 
			'jobvacancy_no' => $jobvacancy_no, 
			'heading' => $heading,
			'status' => 'NEW',
			'show_status' => 'NO'
			);
	//echo $client_name;		
	//print_r($data);die;		
			
	$db->insert('posting', $data);
	$posting_id = $db->lastInsertId();
	
	
	for ($i = 0; $i < count($_POST['responsibility']); ++$i)
	{
		if($_POST['responsibility'][$i]!="")
		{
			$data =  array(
						'posting_id' => $posting_id,
						'responsibility' => $_POST['responsibility'][$i]
						);
			$db->insert('posting_responsibility', $data);
			
		}	
	}
	
	for ($x = 0; $x < count($_POST['requirement']); ++$x)
	{
		if($_POST['requirement'][$x]!="")
		{
			$data =  array(
						'posting_id' => $posting_id,
						'requirement' => $_POST['requirement'][$x]
						);
			$db->insert('posting_requirement', $data);
		}	
	}


	//add history
	$history_changes = 'New Advertisement created and added';
	$changes = array('posting_id' => $posting_id,
				 'date_change' => $ATZ, 
				 'changes' => $history_changes, 
				 'change_by_id' => $_SESSION['client_id'], 
				 'change_by_type' => 'leads');
	$db->insert('posting_history', $changes);
	
	
	
	//send email
	
	$details =  "<h3>NEW ADS CREATED</h3>
				<p>CLIENT : ".$client_name."</p>
				<p>POSITION : AD#".$posting_id." ".$jobposition."</p>
				<p>HEADING : ".$heading."</p>
				<p>Created by : ".$client_name."</p>
				<p>NOTE : THIS AD IS NOT YET POSTED WAITING FOR ADMIN APPROVAL.</p><p>See it in Recruitment tab under Advertisement Management --> New Job Advertisement Admin Section</p>";
				
	
	
	$mail = new Zend_Mail();
	$mail->setBodyHtml($details);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	

	if(! TEST){
		$mail->addTo('admin@remotestaff.com.au', 'Rica J.');
		$mail->addTo('peterb@remotestaff.com.au', 'Peter B.');
		$mail->addTo('applicants@remotestaff.com.au', 'applicants@remotestaff.com.au');
		$mail->setSubject("REMOTESTAFF NEW ADS CREATED BY ".$client_name);
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
		$mail->addTo('peterb@remotestaff.com.au', 'Peter B.');
		$mail->addTo('applicants@remotestaff.com.au', 'applicants@remotestaff.com.au');
		$mail->setSubject("TEST REMOTESTAFF NEW ADS CREATED BY ".$client_name);
	}
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	
	$mail->send($transport);


	$mess = "Successfully added . An email was sent to Admin waiting for approval.";
	
}







//SELECT * FROM job_role_category
//jr_cat_id, cat_name
$sql = $db->select()
	->from('job_role_category');
$categories = $db->fetchAll($sql);	
foreach($categories as $category){
	$query = $db->select()
		->from('job_category')
		->where('job_role_category_id =?' , $category['jr_cat_id'])
		->where('status != ?','removed');
	$sub_cats = $db->fetchAll($query);
	
	$category_Options.="<OPTGROUP LABEL='".strtoupper($category['cat_name'])."'>";
	foreach($sub_cats as $sub_cat){
		if($category_id == $sub_cat['category_id']){
			$category_Options .="<option value='".$sub_cat['category_id']."' selected='selected'>".$sub_cat['category_name']."</option>";
		}else{
			$category_Options .="<option value='".$sub_cat['category_id']."' >".$sub_cat['category_name']."</option>";
		}
	
	}
	$category_Options.="</OPTGROUP><OPTGROUP>&nbsp;</OPTGROUP>";
	
}

?>

<html>
<head>
<title>Client Add Job Advertisement</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="js/addrow-v2.js"></script>
<script language=javascript src="js/functions.js"></script>
<script src="./media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">
<script type="text/javascript" src="category-management/media/js/category-management.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<?php include 'clientleftnav.php';?>
<br></td>
<td width=100% valign=top align=left>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="myjobposting.php"  onSubmit="return EditUpdatedAds();">


<?php if($mess){?>
<div style="background:#FFFF00; font-weight:bold; text-align:center; padding:5px;"><?php echo $mess;?></div>
<?php } ?>
<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >

<tr><td colspan="2" valign="top">
<table width=100% border=0 cellspacing=1 cellpadding=5 style="border:#CCCCCC solid 1px;">
<tr><td colspan="2" align="right" style="color:#FF0000; font-weight:bold;">Newly created advertisements are subject for Remotestaff Admin approval.</td></tr>
 <tr>
    <td align="right">Client</td>
    <td><select id="lead_id" name="lead_id" style="width:300px;">
         <option value="<?php echo $_SESSION['client_id'];?>"><?php echo $row['fname']." ".$row['lname'];?></option>
    </select></td>
 </tr>

 <tr>
    <td align="right">Category</td>
    <td><select id="category_id" name="category_id" style="width:300px;">
      <option value="">Please Select</option>
      <?php echo $category_Options;?>
    </select> <span id="sub_cat"></span></td>
 </tr>
  <tr>
    <td align="right">Outsourcing Model</td>
    <td><select id="outsourcing_model" name="outsourcing_model" style="width:200px;">
	<option value="" selected="selected">Please Select</option>
	<option value="Home Office">Home Office</option>
	<option value="Office Location">Office Location</option>
	<option value="Project Base">Project Base</option>
	</select></td>
  </tr>
   <tr>
    <td width="15%" align="right">Job Title Position :&nbsp;</td>
    <td width="85%" ><input type="text" name="jobposition" id="jobposition" size="100">    </td>
	</tr>
  
  <tr>
    <td align="right">Company :&nbsp;</td>
    <td><input type="text" name="companyname" id="companyname" value="<?php echo $company_name;?>" size="50"></td>
  </tr>
	 
 <tr>
 <td colspan="3"> </td>
 </tr>
							   
 
	<tr>
    <td width="15%" align="right">Vancancy :&nbsp;</td>
    <td>
        <input type="text" name="jobvacancy_no" id="jobvacancy_no"  size="3"></td>
  </tr>
  <tr>
    <td valign="top" align="right">Heading :</td>
    <td ><textarea name="heading" id="heading" cols="40" rows="10" wrap="physical" style="width:90%; "></textarea>
	<script type="text/javascript">
	<!--
	tinyMCE.execCommand("mceAddControl", true, 'heading')
	-->
	</script>
	</td>
  </tr>
  
  <tr>
    <td valign="top" align="right" ><b>Skill(s) / Requirements :&nbsp;</b></td>
    <td > <table width="100%" border="0" cellpadding="2" cellspacing="2">
  		 <tr class="row_to_clone">
	     <td width="2%" align="right"><img src="images/box.gif"></td>
    	 <td width="98%" align="left"><input name="requirement[0]" type="text" class="text" style="width:98%;"  /></td>
    	 </tr>
    	</table>
   <div  ><input name="" type="button" value="Add More "  onclick="addRow(); return false;"/></div></td>
  </tr>
  <tr>
    <td valign="top" align="right"><b>Responsibilities :&nbsp;</b></td>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
  		 <tr class="row_to_clone2">
	     <td width="2%" align="right"><img src="images/box.gif"></td>
    	 <td width="98%" align="left"><input name="responsibility[0]" type="text" class="text" style="width:98%;"  /></td>
    	 </tr>
    	</table>
   <div  ><input name="" type="button" value="Add More "  onclick="addRow2(); return false;"/></div></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="submit" name="post" value="POST"></td>
  </tr>
</table></td>
</tr>
<tr>
<td colspan="2">
<h3><a name="ads">Advertisement List</a></h3>
<div class="hiresteps" style=" padding-top:10px;">
<?php

$query="SELECT id,DATE_FORMAT(date_created,'%D %M %Y')AS date_created,outsourcing_model, companyname, jobposition, status ,agent_id, created_by_type FROM posting WHERE lead_id=".$_SESSION['client_id']." ORDER BY id DESC;";
$result = $db->fetchAll($query);

if(count($result) > 0 ){
?>
<table width=100% cellspacing=1 cellpadding=4 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor="#333333" >
<td width='4%' align=center style="color:#FFFFFF">#</td>
<td width='25%' align=left style="color:#FFFFFF"><b>Job Position</b></td>
<td width='12%' align=left style="color:#FFFFFF"><b>Date</b></td>
<td width='14%' align=left style="color:#FFFFFF"> <b>Outsourcing Model</b></td>
<td width='18%' align=left style="color:#FFFFFF"><b>Company Name</b></td>
<td width='7%' align=left style="color:#FFFFFF"><b>Status</b></td>
<td width='20%' align=left style="color:#FFFFFF"><b>Created By</b></td>
</tr>
<?php
$counter = 0;
foreach($result as $result){

	$counter++;
	$bgcolor="#f5f5f5";
	$id = $result['id'];
	$date = $result['date_created'];
	$model = $result['outsourcing_model'];
	$companyname = $result['companyname'];
	$position = $result['jobposition'];
	$status = $result['status'];
	$created_by = getCreator($result['agent_id'] , $result['created_by_type']);

	if($bgcolor=="#f5f5f5")
	{
		$bgcolor="#FFFFFF";
	}
	else
	{
		$bgcolor="#f5f5f5";
	}

?>

<tr bgcolor=<?php echo $bgcolor;?>>
<td align=center><?php echo $counter;?></td>
<td align=left><a href="javascript:popup_win('./Ad.php?id=<?php echo $id;?>',800,500);"><?php echo $position;?></a></td>
<td align=left><?php echo $date;?></td>
<td align=left><?php echo $model;?></td>
<td align=left><?php echo $companyname;?></td>
<td align=left><?php echo $status;?></td>
<td align=left><?php echo $created_by;?></td>
</tr>


<?php } ?>
</table>
<?php
}else{ echo "No Records to be shown."; }
?>

</div>
</td>
</tr>
</table>
<!-- skills list -->
<br clear=all><br>



<!-- --->
<br></form>

</td></tr></table></td>

</tr></table>
<?php include 'footer.php';?>	
	
</body>
</html>
