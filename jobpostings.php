<?php
include('conf/zend_smarty_conf_root.php');

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$update_page ="updateinquiry.php";
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$update_page ="admin_updateinquiry.php";
	$admin_status=$_SESSION['status'];
	

}else{
	header("location:index.php");
}



include ('./leads_information/AdminBPActionHistoryToLeads.php');

include 'config.php';
include 'function.php';
include 'conf.php';


//$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}

$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';

//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);		
$leads_of = checkAgentAffiliates($leads_id);
$date_registered = format_date($leads_info['timestamp']);

$name =  $leads_info['fname']." ".$leads_info['lname'];
//LEADS RATINGS
$rating = $leads_info['rating'];
if($rating == "") $rating =0;
for($i=0; $i<=5;$i++){
	//rate
	if($leads_info['rating'] == $i){
		$rate_Options .="<option value=".$i." selected='selected'>".$i."</option>";
	}else{
		$rate_Options .="<option value=".$i.">".$i."</option>";
	}	
}
//stars to be displayed
for($i=1; $i<=$rating;$i++){
	$starOptions.='<img src="images/star.png" align="top">';
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
/*
	if($category_id == $category['jr_cat_id']){
		$category_Options .="<option value='".$category['jr_cat_id']."' selected='selected'>".$category['cat_name']."</option>";
	}else{
		$category_Options .="<option value='".$category['jr_cat_id']."' >".$category['cat_name']."</option>";
	}

*/	



header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty();

$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}
//echo $page_type;exit;
$smarty->assign('page_type',$page_type);

$smarty->assign('update_page',$update_page);
$smarty->assign('url' ,$url);
$smarty->assign('leads_id',$leads_id);
$smarty->assign('lead_status' , $lead_status);
$smarty->assign('starOptions' , $starOptions);
$smarty->assign('rate_Options' , $rate_Options);
$smarty->assign('leads_info', $leads_info);
$smarty->assign('date_registered' , $date_registered);
$smarty->assign('leads_of' , $leads_of);
$leads_info = $smarty->fetch('leads_info.tpl');

?>

<html>
<head>
<title>Remotestaff <?php echo $name;?>Job Advertisements</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="js/addrow-v2.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>
<script language=javascript src="js/functions.js"></script>
<script src="./media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">
<script type="text/javascript" src="category-management/media/js/category-management.js"></script>
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<?php
if($page_type == "TRUE"){ 
	include 'header.php';
	
	if($_SESSION['agent_no']!=""){
		include 'BP_header.php';
	}
	
	if($_SESSION['admin_id']!=""){
		include 'admin_header_menu.php';
	}
}
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<?php 
if($admin_status != "HR"){ 
	if($page_type == "TRUE"){ 
		echo "<td width='173' style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>";
			if($_SESSION['agent_no']!=""){
				include 'agentleftnav.php';
			}
			
			if($_SESSION['admin_id']!=""){
				include 'adminleftnav.php';
			}
		echo "</td>";	
	}
}
?>

<td width=100% valign=top align=left>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="jobpostingsphp.php?page_type=<?php echo $page_type;?>"  onsubmit="return checkAdsFields();">
<input type="hidden" name="id" id="leads_id" value="<?php echo $leads_id;?>">
<input type="hidden" name="lead_status" id="lead_status" value="<?php echo $_GET['lead_status'];?>"/>
<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >
<tr>
<td valign="bottom">
<?php include("leads_information/top-tab.php");?>
</td>
</tr>



<tr><td height="100%" colspan=2 valign="top" >
<span class="toggle-btn" onClick="toggle('personal_information')">SHOW / HIDE</span>
<h2>Information</h2>
<div id="personal_information" style="display:none;"><?php echo $leads_info;?></div>
<!-- Clients Details ends here -->
</td>
</tr>
<tr><td valign="top"  colspan="2">
<h2>Post an Ad</h2></td></tr>

<?php if($_REQUEST['mess']){?>
<tr>
  <td align="center" width=100% bgcolor="#FFFF00" colspan=2><strong><?php echo $_REQUEST['mess'];?></strong></td>
</tr>

<?php }?>
<tr>
  <td width=100% bgcolor=#DEE5EB colspan=2><strong>Confined Client Needs / Job Titles</strong></td>
</tr>

<tr><td colspan="2" valign="top">
<table width=100% border=0 cellspacing=1 cellpadding=5 style="border:#CCCCCC solid 1px;">
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
</table>
</form>

</td></tr>
<tr>
<td colspan="2">
<h2><a name="ads">Advertisement List</a></h2>
<div class="hiresteps" style=" padding-top:10px;">
<?php

$query="SELECT id,DATE_FORMAT(date_created,'%D %M %Y')AS date_created,outsourcing_model, companyname, jobposition, status ,agent_id, created_by_type FROM posting WHERE lead_id=$leads_id ORDER BY id DESC;";
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

</table></td>
</tr></table>
<?php 
if($page_type == "TRUE"){ 
	include 'footer.php';
}
?>	
</body>
</html>
