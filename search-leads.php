<?php 
include 'config.php';
include 'conf.php';
include 'time.php';
include('conf/zend_smarty_conf_root.php');
if($_SESSION['admin_id'] != "" || $_SESSION['admin_id'] != NULL)
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
		$where = "";			
	}
	else
	{
		$where = "WHERE (email='$key' || fname LIKE '%$key%' || lname LIKE '%$key%')";
	}	
	$query = "SELECT $fields $from $where $order_by";
	$result =  mysql_query($query);
	
	$return_data = '
	 <table cellpadding="2" cellspacing="2" bgcolor="#FFFF99">
		<tr><td colspan="2"><font color="#FF0000" size=1>(Keyword: <strong>ALL</strong> \'<em>displays all leads</em>\')</font></td></tr>	 
		<tr>
			<td colspan="2">
				<input name="key" id="key_id" type="text" value="'.$key.'" onMouseOut="javascript: if(this.value=="") { this.value=\'(fname/lname/email)\'; } " onClick="javascript: if(this.value==\'(fname/lname/email)\') { this.value=""; } ">
				<input type="button" value="Search" class="button" onClick="javascript: SL_query_lead(); ">
			</td>
		</tr>
	';
				
	while ($r = mysql_fetch_assoc($result)) 
	{
		$name = $r['fname']." ".$r['lname'];
		$id = $r['id'];
		$email = $r['email'];
		$return_data = $return_data.'	
			<tr>
				<td><input type="radio" name="lead_option" onChange="javascript: SL_assign(\''.$id.'\',\''.$name.'\'); SL_hideSubMenu(); get_client_name(\''.$id.'\'); "></td>
				<td>'.$name.'('.$email.')</td>
			</tr>
		';
	}
	
	$return_data = $return_data.'
		<tr>
			<td>&nbsp;</td>
			<td align="right"><a href="javascript: SL_hideSubMenu(); "><img src="images/action_delete.gif" border="0"></a></td>
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
