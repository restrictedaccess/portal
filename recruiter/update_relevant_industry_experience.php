<?php
//START: construct
include('../conf/zend_smarty_conf.php') ;
if (!isset($_SESSION["admin_id"])){
	die;
}
$id=$_REQUEST['id'];
$userid=$_REQUEST['userid'];
//ENDED: construct

$where = "id = ".$id;	
$db->delete('tb_relevant_industry_experience' , $where);

$sql = "SELECT *
FROM tb_relevant_industry_experience WHERE userid='$userid'
ORDER BY name ASC;";		
$result = $db->fetchAll($sql);	

$counter = 1;
$relevant_industry_experience .= '
<table width="100%">';
foreach($result as $rows)
{
	$relevant_industry_experience .= '
	<tr>
		<td class="td_info td_la" width="10%">#'.$counter.'</td>
		<td class="td_info td_la" width="40%">'.$rows['name'].'</td>
		<td class="td_info td_la" width="50%" align=right><a href="javascript: delete_relevant_industry_experience('.$rows['id'].','.$rows['userid'].'); ">Delete</a></td>
	</tr>';
	$counter++;
}
$relevant_industry_experience .= "</table>";

echo $relevant_industry_experience;
?>