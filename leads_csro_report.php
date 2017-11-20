<?php
//2011-07-29  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   updated csro files link
include('conf/zend_smarty_conf.php');
include ('./leads_information/AdminBPActionHistoryToLeads.php');

include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';

if(@isset($_REQUEST["delete_id"]))
{
	$r = $db->fetchAll("SELECT name FROM csro_files WHERE id='".$_REQUEST["delete_id"]."'");	
	foreach($r as $r)
	{	
		$f_name = $r['name'];
		mysql_query("DELETE FROM csro_files WHERE name='$f_name'");	
		unlink("uploads/csro_files/".$f_name);
	}
	header("location: ?userid=".$_REQUEST["userid"]);
}

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
	$update_page = "admin_updateinquiry.php";

}else{
	header("location:index.php");
}

$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}

$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

										$csro_report = "";
										
										
										//add other files or client files
												$sql=$db->select()
													->from('leads')
													->where('id = ?' ,$leads_id);
												$ad = $db->fetchRow($sql);
												$client_name = $ad['fname']." ".$ad['lname'];
																							
                                                $r = $db->fetchAll("SELECT * FROM csro_files WHERE leads_id ='$leads_id' AND (userid='0' OR userid='') AND userid <> '99999999'");	
												$output = "";
												$counter = 0;
												foreach($r as $r)
												{
													if($r["admin_id"] > 0)
													{
														$sql=$db->select()
															->from('admin')
															->where('admin_id = ?' ,$r["admin_id"]);
														$ad = $db->fetchRow($sql);
														$uploaded_by = $ad['admin_fname']." ".$ad['admin_lname'];
													}
													else
													{
														$sql=$db->select()
															->from('agent')
															->where('agent_no = ?' ,$r["bp_id"]);
														$bp = $db->fetchRow($sql);
														$uploaded_by = $bp['fname']." ".$bp['lname'];
													}
													$output = $output.'	
                                                    <tr>
                                                    	<td align="right"><img src="../images/bullet-check.jpg">&nbsp;Uploaded&nbsp;by: </td>
                                                        <td width=100%>
                                                            '.$uploaded_by.' 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="right">
															<a href="?id='.$leads_id.'&lead_status=CSRO&delete_id='.$r['id'].'"><img src="images/delete.png" border=0></a>
                                                        </td>
                                                        <td width=100%>
                                                            '.$r['type'].':&nbsp;<i><a href="get_csro_files.php?file_id='.$r["id"].'" target="_blank">'.$r["name"].'</a></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>&nbsp;</td>
                                                        <td width=100%>
                                                            "'.$r['comment'].'"<br /><br />
                                                        </td>
                                                    </tr>													
													';
													$counter++;
                                                }
												
												//display output
												$csro_report = $csro_report."
												<tr>
													<td colspan=2><table><tr><td><img src='../images/icon-cref-client.png'></td><td valign='midle'><strong>CLIENT FILES:</strong></FONT></td></tr></table></td>
												</tr>												
												<tr>
													<td colspan=2><table><tr><td>&nbsp;&nbsp;&nbsp;</td><td><img src='../images/bullet-arrow.jpg'></td><td valign=midle><strong>".$client_name."</strong>(".$counter.")</td></tr></table></td>
												</tr>
												".$output."
												<tr>
													<td colspan=2><table><tr><td><img src='../images/icon-cref-client.png'></td><td valign='midle'><strong>SUBCONTRACTORS FILES:</strong></td></tr></table></td>
												</tr>
												";
												//ended	
										//ended												

										
										//add files for each subcontractors
										$queryAllStaff = "SELECT DISTINCT(s.userid), p.fname, p.lname 
											FROM personal p, subcontractors s
											WHERE p.userid = s.userid AND s.leads_id = '$leads_id'";
											$result = $db->fetchAll($queryAllStaff);
											foreach($result as $result)
											{
                                                $r = $db->fetchAll("SELECT * FROM csro_files WHERE leads_id ='$leads_id' AND userid='".$result['userid']."' AND userid <> '99999999'");	
												$output = "";
												$counter = 0;
												foreach($r as $r)
												{
													
													if($r["admin_id"] > 0)
													{
														$sql=$db->select()
															->from('admin')
															->where('admin_id = ?' ,$r["admin_id"]);
														$ad = $db->fetchRow($sql);
														$uploaded_by = $ad['admin_fname']." ".$ad['admin_lname'];
													}
													else
													{
														$sql=$db->select()
															->from('agent')
															->where('agent_no = ?' ,$r["bp_id"]);
														$bp = $db->fetchRow($sql);
														$uploaded_by = $bp['fname']." ".$bp['lname'];
													}
													$output = $output.'	
                                                    <tr>
                                                    	<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
														<td width="100%"><img src="../images/bullet-check.jpg">&nbsp;Uploaded&nbsp;by:&nbsp;'.$uploaded_by.' </td>
                                                    </tr>
                                                    <tr>
														<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                        <td width=100%>
															<table>
																<tr>
																	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td><a href="?id='.$leads_id.'&lead_status=CSRO&delete_id='.$r['id'].'"><img src="../images/close.gif" border=0></a></td>
																	<td width="100%">'.$r['type'].':&nbsp;<i><a href="get_csro_files.php?file_id='.$r["id"].'" target="_blank">'.$r["name"].'</a></i></td>
																</tr>
																<tr>
																	<td colspan="2">
																	<td align="left">"'.$r['comment'].'"<br /><br /></td>
																</tr>
															</table>	
                                                        </td>
                                                    </tr>
													';
													$counter++;
                                                }
												
												//display output
												$csro_report = $csro_report."
												<tr>
													<td colspan=2><table><tr><td>&nbsp;&nbsp;&nbsp;</td><td><img src='../images/bullet-arrow.jpg'></td><td valign=midle><strong>".$result['fname']." ".$result['lname']."</strong>(".$counter.")</td></tr></table></td>
												</tr>
												".$output;
												//ended											
											}
											//ended
											
											$csro_report = "<table>".$csro_report."</table>";


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';

header('Content-type: text/html; charset=utf-8');

$smarty = new Smarty();

$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}
//echo $page_type;exit;
$smarty->assign('page_type',$page_type);
$smarty->assign('csro_report',$csro_report);
$leads_csro_info = $smarty->fetch('leads_csro_info.tpl');
?>




<html>
<head>
<title>Remotestaff <?php echo $name;?>Job Advertisements Applicants</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>
<script language=javascript src="js/functions.js"></script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="#"  onsubmit="return checkFields();">
<input type="hidden" name="id" id="leads_id" value="<?php echo $leads_id;?>">
<input type="hidden" name="lead_status" id="lead_status" value="<?php echo $_GET['lead_status'];?>"/>




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

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
  <tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td width="220" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php 
if($page_type == "TRUE"){ 
	if($_SESSION['agent_no']!=""){
		include 'agentleftnav.php';
	}
	
	if($_SESSION['admin_id']!=""){
		include 'adminleftnav.php';
	}
}
?>
</td>
<td width=100% valign=top >
<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >
<tr>
<td >
<?php include("leads_information/top-tab.php");?>
</td>
</tr>
<tr><td height="100%" colspan=2 valign="top" >
<!-- Clients Details starts here -->
<h2>Files Uploaded</h2>
<?php echo $leads_csro_info;?>
<!-- Clients Details ends here -->
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php 
if($page_type == "TRUE"){
include 'footer.php';
}
?>
</form>	
</body>
</html>
