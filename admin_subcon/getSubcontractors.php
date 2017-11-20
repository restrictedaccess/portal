<?php
header('Content-Type: text/html; charset=utf-8');
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();
if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$admin_id = $_SESSION['admin_id'];

$mode = $_REQUEST['mode'];
$userid = $_REQUEST['userid'];
$keyword = $_REQUEST['keyword'];




if($mode == "select"){
	$query="SELECT DISTINCT(s.userid) , CONCAT(p.fname,' ',p.lname)AS staff_name ,p.image , p.email ,p.handphone_no, p.skype_id ,p.tel_area_code, p.tel_no, p.image FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.status = 'ACTIVE' AND s.userid = $userid ORDER BY p.fname ASC ;";
}

else if($mode == "keyword"){
	$keyword_search = " ";
	if($keyword!=NULL){
		# convert to upper case, trim it, and replace spaces with "|": 
		$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
		# create a MySQL REGEXP for the search: 
		$regexp = "REGEXP '^.*($search).*\$'"; 
		$keyword_search = " (
					UPPER(p.lname) $regexp 
					OR UPPER(p.fname) $regexp 
					OR UPPER(p.email) $regexp 
					OR UPPER(l.fname) $regexp 
					OR UPPER(l.lname) $regexp 
					) ";
	}
	$query="SELECT DISTINCT(s.userid) , CONCAT(p.fname,' ',p.lname)AS staff_name ,p.image , p.email ,p.handphone_no, p.skype_id ,p.tel_area_code, p.tel_no , p.image FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid LEFT JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' AND l.status = 'Client' AND  $keyword_search ORDER BY p.fname ASC;";
}
else{
	$query="SELECT DISTINCT(s.userid) , CONCAT(p.fname,' ',p.lname)AS staff_name ,p.image , p.email ,p.handphone_no, p.skype_id ,p.tel_area_code, p.tel_no , p.image FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.status = 'ACTIVE' GROUP BY s.userid  ORDER BY p.fname ASC ;";

}
//echo $query;

$result = $db->fetchAll($query);
$ctr=0;
$resultOptions = "<table id='active_staff' width=\"100%\" cellpadding=\"3\" cellspacing=\"0\">
					<tr bgcolor = '#333333'>
					<td width=\"5%\"><b style='color:white;'>#</b></td>
					<td width=\"30%\"><b style='color:white;'>STAFF NAME</b></td>
					<td width=\"15%\"><b style='color:white;'>SKYPE</b></td>
					<td width=\"17%\"><b style='color:white;'>PHONE</b></td>
					<td width=\"33%\"><b style='color:white;'>CLIENT NAME</b></td>
					</tr>";
					
foreach($result as $row){
	 if($bgcolor=="#EEEEEE")
	  {
		$bgcolor="#FFFFFF";
	  }
	  else
	  {
		$bgcolor="#EEEEEE";
	  }
	$ctr++;

	if($row['image']!=""){
		$image = "<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id=".$row['userid']."' border='0' align='texttop'  />";
	}else{
		$image = "";
	}
	
	$resultOptions.="<tr bgcolor='$bgcolor'>
					<td valign='top' style='border-bottom:#333333 solid 1px; border-right:#333333 solid 1px;'  >".$ctr."</td>
				<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'><div class='staff_name'><a href='javascript:showResume(".$row['userid'].")'>$image ".strtoupper($row['staff_name'])."</a><br><span class='staff_email'>".$row['email']."</span></div></td>
					<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>".$row['skype_id']."</td>
					<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>".$row['handphone_no']." / ".$row['tel_area_code'].$row['tel_no']."</td>";
					
	$resultOptions.="<td valign='top' style='border-bottom:#333333 solid 1px;'>";
	
	$sql = "SELECT s.id ,s.userid, leads_id , CONCAT(l.fname,' ',l.lname)AS client_name , contract_updated  FROM subcontractors s LEFT JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' 	AND s.userid = ".$row['userid']."  ORDER BY s.id DESC;";
	
		$resulta = $db->fetchAll($sql);
		
		$warning ="";
		foreach($resulta as $row2){
			
			$contract_updated = $row2['contract_updated'];
			if($contract_updated == 'n'){ //this contract need to be updated
				$warning = "<img src='images/warning.png' title='Staff ".$row['staff_name']." contract to Client ".$row2['client_name']." needs to be updated'>";
				$warning_str = "staff contract needs update";
			}else{
				$warning = "<img src='images/9.gif' title='Staff ".$row['staff_name']." contract to Client ".$row2['client_name']." is updated'>";
				$warning_str ="";
			}
			$resultOptions.= "<div><div style='float:left;'>$warning<input type='radio' align='absmiddle' name='userid' onclick=javascript:location.href='contractForm.php?userid=".$row['userid']."&sid=".$row2['id']."&lid=".$row2['leads_id']."' />".$row2['client_name']."</div><div style='float:right;font:9px tahoma;color:red;'>$warning_str</div><div style='clear:both;'></div></div>";

		}
	
	
	$resultOptions.="</td></tr>";				
	
	
	
}

$resultOptions .= "</table>";



$smarty->assign('resultOptions',$resultOptions);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('getSubcontractors.tpl');

?>
