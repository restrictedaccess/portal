<?php
include './conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

include 'time.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
	exit;
}

if($_REQUEST['userid'] != ""){
    $url =  sprintf('/portal/django/subcontractors/create/%s', $_REQUEST['userid']);
}else{
	$url =  '/portal/django/subcontractors/select_staff';
}
header("location:$url");
exit;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($admin_status == 'HR'){
	$resume_page = "recruiter/staff_information.php";
}else{
	$resume_page = "application_apply_action.php";
}

if($_POST['search'] == ""){
	$smarty->assign('search_any', 'checked="checked"');			
}

//if (array_key_exists('_submit_check', $_POST)) {
	

	$keyword = $_REQUEST['keyword'];
	$search = $_REQUEST['search'];
	if($search == "keyword") {
		if($keyword!=NULL){
	
				$search_text = $keyword;
				$search_text=ltrim($search_text);
				$search_text=rtrim($search_text);
				
				$kt=explode(" ",$search_text);//Breaking the string to array of words
				// Now let us generate the sql 
				while(list($key,$val)=each($kt)){
					if($val<>" " and strlen($val) > 0){
					$queries .= " p.userid like '%$val%' or p.fname like '%$val%' or p.lname like '%$val%' or p.email like '%$val%' or p.skype_id like '%$val%' or";
					}
				}// end of while
				
				$queries=substr($queries,0,(strlen($queries)-3));
				// this will remove the last or from the string. 
				$keyword_search =  " WHERE ( ".$queries." ) ";
				//echo $keyword_search;exit;
				$search_flag = True;
				$smarty->assign('search_any', 'checked="checked"');			
			}else{
					$smarty->assign('search_result', 'There is no keyword to be search.');
			}
	}

	if($search == "userid"){
		if($keyword!=NULL){
			$keyword_search =  " WHERE p.userid = $keyword ";
			$search_flag = True;
			$smarty->assign('search_userid', 'checked="checked"');
		}else{
			$smarty->assign('search_result', 'There is no userid to be search.');
		}
	}
	
	if($search_flag == True){
		//echo $keyword_search;exit;
		$query="SELECT p.userid , p.fname, p.lname ,p.image , p.email ,p.handphone_no, p.skype_id ,p.tel_area_code, p.tel_no , p.image , p.registered_email FROM personal p $keyword_search  ORDER BY p.fname ASC ;";
					
		$staff = $db->fetchAll($query);
		$ctr = 0;
		$resultOptions ="<table width='100%' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>";
		
		foreach($staff as $staff){
			$ctr++;
			
			if($bgcolor=="#EEEEEE"){
				$bgcolor="#CCFFCC";
			}else{
				$bgcolor="#EEEEEE";
			}
			
			
			if($staff['image']!=""){
				$image = "<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id=".$staff['userid']."' border='0' align='texttop'  />";
			}else{
				$image = "<img src='images/ava002.jpg' border='0' align='texttop' width='48'  />";
			}
			
			if($staff['registered_email']!= ""){
				$email_str = "Staff Email : ".$staff['email']."<br>Personal Email : ".$staff['registered_email'];
			}else{
				$email_str = "Personal Email : ".$staff['email'];
			}
			
			$staff_userid = $staff['userid'];
			$parse_url =sprintf('?userid=%s&keyword=%s&search=%s', $staff['userid'],  $keyword, $_REQUEST['search']);
			
			$resultOptions .="<tr bgcolor='$bgcolor' class='staff_name'>";	
			$resultOptions .="<td width='4%' valign='top'>".$ctr."</td>";
			$resultOptions .="<td width='34%' valign='top'><input type='radio' name='userid' value='".$staff['userid']."' onclick=location.href='adminaddsubcon.php$parse_url' /><a href=".$resume_page."?userid=".$staff['userid']." target='_blank'>".$image."</a><div style='float:left; display:block; font:11px tahoma;'><small>USERID : ".$staff['userid']."</small><br> <a href=".$resume_page."?userid=".$staff['userid']." target='_blank'><b>".$staff['fname']." ".$staff['lname']."</b></a><br>".$email_str."<br>Skype : ".$staff['skype_id']."<br>".$staff['tel_area_code'].$staff['tel_no']."</div></td>";
			$resultOptions .="<td width='62%' valign='top'>";	
				
				$sql = "SELECT s.id ,s.userid, s.status ,leads_id , CONCAT(l.fname,' ',l.lname)AS client_name , contract_updated , l.company_address , s.starting_date ,(l.status)AS leads_status  FROM subcontractors s LEFT JOIN leads l ON l.id = s.leads_id WHERE s.userid = ".$staff['userid']."  ORDER BY s.status ASC;";
				$clients = $db->fetchAll($sql);
				if($clients){
					foreach($clients as $client){
					
						$det = new DateTime($client['starting_date']);
						$starting_date = $det->format("F j, Y");
						
					
						$resultOptions.= "<div><input type='radio' align='absmiddle' name='userid' onclick=javascript:location.href='contractForm.php?userid=".$staff['userid']."&sid=".$client['id']."&lid=".$client['leads_id']."' /> <a href='leads_information.php?id=".$client['leads_id']."&lead_status=".$client['leads_status']."' target='_blank'><b>".$client['client_name']."</b></a></div><div style='margin-left:25px;'>Status : <span style='color:red;font-weight:bold;'>".$client['status']."</span><br>Starting Date : ".$starting_date."<br><small>".$client['company_address']."</small></div>";
						
					}
				}else{
						$resultOptions.= "<div>No Remotestaff employment record</div>";
				}
				
			$resultOptions .="</td>";	
			$resultOptions .="</tr>";	
			
			
		}

		$resultOptions .="</table>";
		$smarty->assign('search_result', $resultOptions);
	}

//}




$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
//$date->modify("+2 day");
$date_advanced = $date->format("Y-m-d");
$min_date = $date->format("Ymd");

$smarty->assign('userid', $_REQUEST['userid']);
$smarty->assign('min_date', $min_date);
$smarty->assign('admin_status',$_SESSION['status']);
$smarty->assign('keyword',$keyword);
$smarty->assign('search_flag',$search_flag);
$smarty->display('adminaddsubcon.tpl');
?>