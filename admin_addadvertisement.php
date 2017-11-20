<?php
include('conf/zend_smarty_conf.php');

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($_SESSION['admin_id'] == "" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}

$created_by_id = $_SESSION['admin_id'];
$created_by_type = 'admin';

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
			'agent_id' => $created_by_id, 
			'created_by_type' => $created_by_type,
			'lead_id' => $lead_id, 
			'category_id' => $category_id,
			'date_created' => $ATZ, 
			'outsourcing_model' => $outsourcing_model, 
			'companyname' => $companyname, 
			'jobposition' => $jobposition, 
			'jobvacancy_no' => $jobvacancy_no, 
			'heading' => $heading,
			'status' => $status,
			'show_status' => $show_status
			);
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
				 'change_by_id' => $_SESSION['admin_id'], 
				 'change_by_type' => 'admin');
	$db->insert('posting_history', $changes);
	$mess = "Added successfully";
}

//$lead_id =$_REQUEST['lead_id'];
//echo $kliyente."<br>";
$sql = "SELECT DISTINCT l.id, l.lname, l.fname,l.email FROM leads l WHERE status!='Inactive' AND status!='REMOVED' AND status!='transferred'  ORDER BY l.fname ASC;";
$result=$db->fetchAll($sql);
foreach($result as $result){
	
	 if ($lead_id==$result['id']){
	 	$usernameOptions .="<option selected value= ".$result['id'].">".$result['fname']." ".$result['lname']." [".$result['email']."]</option>";
	 }else{
	 	$usernameOptions .="<option value= ".$result['id'].">".$result['fname']." ".$result['lname']." [".$result['email']."]</option>";
	 }	
	 
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

$statuses = array('NEW' , 'ARCHIVE', 'ACTIVE');
for($i=0; $i<count($statuses); $i++){
	if($status == $statuses[$i]){
		$status_Options .="<option value='".$statuses[$i]."' selected='selected'>".$statuses[$i]."</option>";
	}else{
		$status_Options .="<option value='".$statuses[$i]."'>".$statuses[$i]."</option>";
	}
}

$statuses = array('YES','NO');
for($i=0; $i<count($statuses); $i++){
	if($show_status == $statuses[$i]){
		$show_status_Options .="<option value='".$statuses[$i]."' selected='selected'>".$statuses[$i]."</option>";
	}else{
		$show_status_Options .="<option value='".$statuses[$i]."'>".$statuses[$i]."</option>";
	}
}

?>

<html>
<head>
<title>Remotestaff Advertisements</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="js/addrow-v2.js"></script>
<script src="./media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">
<script type="text/javascript" src="category-management/media/js/category-management.js"></script>
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<!--
< ?php include 'header.php';?>
< ?php include 'admin_header_menu.php';?>
< ?php include 'admin-sub-tab.php';?>
-->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
  <td width="100%" bgcolor="#ffffff" >

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<!--
<td  align="left" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
< ?php	include 'adminleftnav.php'; 

? >
<br></td>
-->
<td  valign=top >
<?php include 'admin-ads-tab.php'?>
<?php if($mess){?>
<div style="background:#FFFF00; font-weight:bold; text-align:center; padding:5px;"><?php echo $mess;?></div>
<?php } ?>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td width="100%">
<form method="POST" name="form" action="admin_addadvertisement.php"  onSubmit="return ValidateNewAds();" >

<table width=100% border=0 cellspacing=1 cellpadding=5 style="border:#CCCCCC solid 1px;">

 <tr>
    <td align="right">Lead</td>
    <td><span id="leads_details"><select id="lead_id" name="lead_id" style="width:300px;" disabled="disabled" >
      <option value="">Please Select</option>
     </select> </span>  <span id="leads_name" style="color:#0000FF; cursor:pointer;">Search</span>
	<div id="search_form" style="background:#EEEEEE; padding:5px; border:#999999 solid 1px; width:337px; height:80px; position:absolute; left: 565px; top: 60px; display:none;">
	<span style="float:right; cursor:pointer; color:#0000FF; font-size:10px;" title="close" onClick="fade('search_form')">close</span>
	<strong>Search Lead</strong>
	<p>
	<input type="text" name="search_str" id="search_str">
	<select id="search_type" name="search_type">
      <option value="fname">First Name</option>
      <option value="lname">Last Name</option>
      <option value="email">Email</option>
      <option value="id">Leads ID</option>
    </select>
	<input id="search_button" name="button" type="button" value="search">
	</p>
	</div>	</td>
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
    <td><input type="text" name="companyname" id="companyname" value="Remote Staff" size="50"></td>
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
	</script>	</td>
  </tr>
  <tr>
    <td align="right">Status</td>
    <td><select id="status" name="status" style="width:120px;">
	<option value="" selected="selected">Please Select</option>
	<?php echo $status_Options;?>
	</select></td>
  </tr>
   <tr>
    <td align="right">Show Status</td>
    <td><select id="show_status" name="show_status" style="width:120px;">
	<option value="" selected="selected">Please Select</option>
	<?php echo $show_status_Options;?>
	</select></td>
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
</table>

<br></form>

</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
<!--< ? include 'footer.php';?>-->
<script>
connect('leads_name','onclick',ShowSearchWindow);
connect('search_button','onclick',SearchLead);
</script>
</body>
</html>
