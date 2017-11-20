<?php
include('../conf/zend_smarty_conf.php');

include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	header("location:index.php");
}

include('../lib/staff_history.php');
$userid=$_REQUEST['userid'];
$admin_id = $_SESSION['admin_id'];

//START: delete file
if(@isset($_REQUEST["delete_id"]))
{
	$r = $db->fetchAll("SELECT name FROM csro_files WHERE id='".$_REQUEST["delete_id"]."'");	
	foreach($r as $r)
	{	
		$f_name = $r['name'];
		$d_id = $_REQUEST["delete_id"];
		mysql_query("DELETE FROM csro_files WHERE id='".$_REQUEST["delete_id"]."'");	
		unlink("../uploads/csro_files/".$f_name);
	}
	header("location: ?userid=".$_REQUEST["userid"]);
}
//ENDED: delete file


//START: delete applicants files
if(@isset($_REQUEST["file_id"]))
{
	$file_id = $_REQUEST["file_id"];
	$sql=$db->select()
		->from('tb_applicant_files')
		->where('id = ?', $file_id)
		->where('userid = ?', $userid);
	$f = $db->fetchRow($sql);
	$name = $f['name'];
	$file_description = $f['file_description'];
	$file_id = $_REQUEST["file_id"];
	$where = "id = '$file_id' AND userid = '$userid'";	
	$result = $db->delete('tb_applicant_files', $where);
	
	if($result)
	{
		$name = basename($name);
		unlink("../applicants_files/".$name);
		
		//START: insert staff history
		staff_history($db, $userid, $admin_id, 'ADMIN', $file_description, 'DELETE', $name);
		//ENDED: insert staff history		
	}
}
//ENDED: delete applicants files


//START: load files listings
$bgcolor = "#E4E4E4";
$counter_checker = 1;
$queryAllStaff = "SELECT DISTINCT(s.leads_id), l.fname, l.lname 
FROM leads l, subcontractors s
WHERE l.id = s.leads_id AND s.userid = '$userid'";
$result = $db->fetchAll($queryAllStaff);
$files_counter = 0;
foreach($result as $result)
{
	$r = $db->fetchAll("SELECT * FROM csro_files WHERE userid ='$userid' AND leads_id='".$result['leads_id']."'");	
	$counter = 0;
	foreach($r as $r)
	{
		$files_counter = files_counter + 1;
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
			<td class="td_info td_la">'.$files_counter.'</td>
			<td width=100% class="td_info" colspan=2>Uploaded&nbsp;by: '.$uploaded_by.'</td>
		</tr>
		<tr>
			<td></td>
			<td class="td_info">
				<a href="?userid='.$userid.'&delete_id='.$r['id'].'"><img src="../images/delete.png" border=0></a>
			</td>
			<td width=100% class="td_info">
				'.$r['type'].':&nbsp;<i><a href="../uploads/csro_files/'.$r["name"].'" target="_blank">'.$r["name"].'</a></i>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td width=100% class="td_info" colspan=2>"'.$r['comment'].'"</td>
		</tr>	
		<tr>
			<td colspan=3>&nbsp;</td>
		</tr>			
		';
		$counter++;
	}
												
	$output = "
	<tr>
		<td></td>
		<td colspan=2><strong>".$result['fname']." ".$result['lname']."</strong>(".$counter.")</td>
	</tr>
	".$output;
}

$counter = 0;
$c = mysql_query("SELECT * FROM tb_applicant_files WHERE (file_description = 'SIGNED CONTRACT' OR file_description = 'CREDIT CARD FORM' OR file_description = 'DIRECT DEBIT FORM' OR file_description = 'OTHER STAFF FILES') AND userid='$userid'");
while ($row = mysql_fetch_assoc($c)) 
{
	$counter++;
	$staff_files .= '<tr>
		<td align="left" valign="top" class="td_info td_la">'.$counter.'</td>
		<td align="left" valign="top" class="td_info"><a href="?userid='.$userid.'&file_id='.$row['id'].'"><img src="../images/delete.png" border=0></a></td>
		<td align="left" valign="top" class="td_info" width=100%><a href="../applicants_files/'.$row["name"].'" target="_blank">'.$row["name"].'</a></td>
	</tr>';
}                            
//ENDED: load files listings


//START: staff name
$query="SELECT fname, lname FROM personal p  WHERE p.userid=$userid LIMIT 1";
$result=mysql_query($query);
$row = mysql_fetch_array ($result); 
$name =$row['fname']."  ".$row['lname'];
//ENDED: staff name

$smarty->assign('staff_files', $staff_files);
$smarty->assign('name', $name);
$smarty->assign('userid', $userid);
$smarty->assign('output', $output);
$smarty->display('staff_csro_report.tpl');
?>
