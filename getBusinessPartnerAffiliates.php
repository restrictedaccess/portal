<?php
include './conf/zend_smarty_conf_root.php';
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];
$agent_no = $_REQUEST['agent_no'];
$affiliate_id = $_REQUEST['affiliate_id'];

$query="SELECT DISTINCT(a.agent_no),CONCAT(a.fname,' ',a.lname)AS fullname ,f.business_partner_id
FROM agent a
LEFT JOIN agent_affiliates f ON f.affiliate_id = a.agent_no
WHERE a.status='ACTIVE'
AND a.work_status = 'AFF'
AND f.business_partner_id = $agent_no
ORDER BY fname ASC;;";

//echo $query;
$result = $db->fetchAll($query);
foreach($result as $row){
	if($row['agent_no'] == $affiliate_id){
		$agentAffiliatesOptions.="<option selected value=".$row['agent_no'].">".$row['fullname']."</option>";
	}else{
		$agentAffiliatesOptions.="<option value=".$row['agent_no'].">".$row['fullname']."</option>";
	}
}



?>


<select name="affiliate_id" id="affiliate_id" class="select" onChange="getAgentsPromocodes(this.value);setDefault('other_affiliate_id');">
<option value="">-</option>
<?php echo $agentAffiliatesOptions;?>
</select>