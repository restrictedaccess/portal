<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf.php');
if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] != NULL || $_SESSION['admin_id'] != "" || $_SESSION['admin_id'] != NULL)
{
	$agent_no = $_SESSION['agent_no'];
	$key = @$_GET["key"];
	
	$from = "FROM leads ";
	$order_by = "ORDER BY fname DESC";	
	$fields = "
	id,
	fname,
	lname,
	email
	";
	if($key == "ALL" || $key == "all" || $key == "All")
	{
		if(isset($_SESSION['agent_no']))
		{
			$where = "WHERE (business_partner_id='$agent_no') AND status <> 'REMOVED' ";
		}
		else
		{
			$where = "";			
		}
	}
	else
	{
		if(isset($_SESSION['agent_no']))
		{
			$where = "WHERE (business_partner_id='$agent_no') AND (email='$key' || CONCAT(fname, ' ', lname) LIKE '%$key%') AND status <> 'REMOVED' ";
		}
		else
		{
			$where = "WHERE (email='$key' || CONCAT(fname, ' ', lname) LIKE '%$key%') AND status <> 'REMOVED' ";
		}
	}	
	$query = "SELECT $fields $from $where $order_by";
	
	$result = $db->fetchAll($query);
	//$result =  mysql_query($query);
	
	$return_data = '
	 <table cellpadding="2" cellspacing="2" bgcolor="#FFFF99">
		<tr><td colspan="2"><font color="#FF0000" size=1>(Keyword: <strong>ALL</strong> \'<em>displays all leads</em>\')</font></td></tr>	 
		<tr>
			<td colspan="2">
				<input name="key" id="key_id" type="text" value="'.$key.'" onMouseOut="javascript: if(this.value=="") { this.value=\'(fname/lname/email)\'; } " onClick="javascript: if(this.value==\'(fname/lname/email)\') { this.value=""; } ">
				<input type="button" value="Search" class="button" onClick="javascript: query_lead();">
			</td>
		</tr>
	';
	foreach($result as $r){
		$name = $r['fname']." ".$r['lname'];
		$email = $r['email'];
		$id = $r['id'];
		$return_data = $return_data.'	
			<tr>
				<td><input type="radio" name="lead_option" onChange="javascript: assign_email(\''.$id.'\',\''.addslashes($name).'\', \''.$email.'\'); hideSubMenu(); "></td>
				<td>'.$name.'('.$email.')</td>
			</tr>
		';		
	}		
	
	$return_data = $return_data.'
		<tr>
			<td>&nbsp;</td>
			<td align="right"><a href="javascript: hideSubMenu(); ">Close</a></td>
		</tr>	
	 </table>	
	 ';
}
else
{
	$return_data = "SESSION EXPIRED!";
}
echo $return_data;
?>
