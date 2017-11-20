<?php
include '../conf/zend_smarty_conf.php';

$sql = $db->select()
	->from('leads')
	->where('status =?' , 'Client')
	->order('fname ASC');
$leads = $db->fetchAll($sql);
foreach($leads as $lead){
	
		//show the leads
		$leads_str .= "<li>".$lead['id']." ".$lead['fname']." ".$lead['lname']." ".$lead['email']." </li>";
		
		//save the lead
		//check if the lead is existing in the leads table
		$sql = $db->select()
			->from('clients' , 'id')
			->where('leads_id =?' , $lead['id']);
		$id = $db->fetchOne($sql);
		if(!$id){
				$data =array('leads_id' => $lead['id']);
				$db->insert('clients' , $data);
		}
	
		
}	

$sql = $db->select()
	->from(Array('c' => 'clients') , Array('leads_id'))
	->join(Array('l' => 'leads') , 'l.id = c.leads_id')
	->where('l.status =?' , 'Client')
	->order('fname ASC');
$clients = $db->fetchAll($sql);
foreach($clients as $client){
	$clients_str .= "<li>".$client['id']." ".$client['fname']." ".$client['lname']." ".$client['email']." </li>";
}
	
?>
<table width="100%">
<tr>
<td width="50%" valign="top">
<ol><strong>CLIENTS IN THE LEADS TABLE</strong>
<?php echo $leads_str;?>
</ol>
</td>
<td width="50%" valign="top"><ol><strong>LEADS IN THE CLIENTS TABLE</strong>
<?php echo $clients_str;?>
</ol>
</td>
</tr>
</table>