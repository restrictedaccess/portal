<?php
// use for transferring of leads to uk database from remotestaff.com.au database
// TABLES INVOLVE
// leads
// history
// leads_remarks
// quote
// quote_details
// service_agreement
// service_agreement_details


include './conf/zend_smarty_conf_root_2db.php'; //remotestaff db connection



function checkClientsBPAFF($agent_id,$business_partner_id){
	global $db;
	$query = "SELECT fname, lname , email FROM agent a WHERE agent_no = $business_partner_id;";
	$result = $db->fetchRow($query);
	$BPName =  "Business Partner : ".$result['fname']." ".$result['lname'];
	
	if($agent_id != $business_partner_id){
		$query = "SELECT fname, lname , email FROM agent a WHERE agent_no = $agent_id AND work_status = 'AFF';";
		$result = $db->fetchRow($query);
		$AFFName = "Affiliates : ".$result['fname']." ".$result['lname'];
	}
	
	return $BPName." ".$AFFName;
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


//2 Chris agent_id in remoteuk.agent
//139 Paul De leon agent_id in remotestaff.agent


//2 Chris id in remotestaff.agent
//6 Lance Harvie id in remotestaff.agent

$keyword =$_REQUEST['keyword'];
if($keyword == ""){
	$keyword = "adtech";
}
$agent_from = 139; 
//$keyword = strtoupper("adtech");
$agent_to = 6; 



/*
id, tracking_no, agent_id, business_partner_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt, show_to_affiliate, leads_country, leads_ip, contact_person, logo_image, company_owner, contact, others, accounts, acct_dept_name1, acct_dept_name2, acct_dept_contact1, acct_dept_contact2, acct_dept_email1, acct_dept_email2, supervisor_staff_name, supervisor_job_title, supervisor_skype, supervisor_email, supervisor_contact, business_owners, business_partners
*/
//agent_id = $agent_from  AND business_partner_id = $agent_from  AND
//$query = "SELECT * FROM leads l  WHERE  l.status != 'Client' AND l.status != 'transferred'   AND ( UPPER(tracking_no) REGEXP '^.*($keyword).*$' );";
$query = "SELECT * FROM leads l  WHERE  l.status != 'transferred'   AND tracking_no LIKE '%$keyword%';";
echo $query."<br>";
$result = $db->fetchAll($query);	

echo count($result)." Results<br>";
//print_r($result);
echo "<hr>";


?>
<form name="form" method="post" action="transfer_to_uk_site.php">
promocode <input type="text" name="keyword" value="<?php echo $keyword;?>" />
<input type="submit" value="search" />
<table width="100%" >
<tr bgcolor="#33333" style="color:#FFFFFF;">
<td>ID</td>
<td align="center">PROMOCODES</td>
<td align="center">FULLNAME</td>
<td align="center">STATUS</td>
<td>Leads of</td>
</tr>
<tr><td colspan="5">
<?php
foreach($result as $row){
	
//	echo "<tr><td>".$row['id']."</td><td>".$row['tracking_no']."</td><td> ".$row['fname']." ".$row['lname']."</td><td> ".$row['status']."</td><td>".checkClientsBPAFF($row['agent_id'],$row['business_partner_id'])."</td></tr>";
	
	$agent_from = $row['agent_id'];
	
	//begin transfer to database remoteuk
	$data = $row;
	$data['agent_id'] = $agent_to;
	$data['business_partner_id'] = $agent_to;
	unset($data['id']); // removed the leads id in the list
	
	
	$db_uk->insert('leads', $data);
	$leads_id = $db_uk->lastInsertId();
	
	
	// update the leads status to "transfered"
	$data = array(
		'status'   => "transferred",
		'date_move'  => $ATZ
	);
	$where = "id = ".$row['id'];
	$db->update('leads', $data, $where);
	
	
	//TABLE history
	// id, agent_no, leads_id, actions, history, date_created, subject, created_by_type
	$sql = "SELECT * FROM history h WHERE agent_no = $agent_from AND created_by_type = 'agent' AND leads_id = ".$row['id'];
	$result2 = $db->fetchAll($sql);
	foreach($result2 as $row2){
		$data2 = $row2;
		$data2['agent_no'] = $agent_to;
		$data2['leads_id'] = $leads_id;
		unset($data2['id']); // removed the history id in the list
		$db_uk->insert('history', $data2);
	}
	
	 
	//TABLE : SELECT * FROM leads_remarks l;
	//id, leads_id, remark_creted_by, created_by_id, remark_created_on, remarks
	$sql2 = "SELECT * FROM leads_remarks WHERE leads_id = ".$row['id'];
	$result3 = $db->fetchAll($sql2);
	//echo $sql2."<br>";
	foreach($result3 as $row3){
		$data3 = $row3;
		$data3['leads_id'] = $leads_id;
		unset($data3['id']); // removed the leads_remarks.id in the list
		$db_uk->insert('leads_remarks', $data3);
	}
	 
	//TABLE : SELECT * FROM `quote` q;
	// id, created_by, created_by_type, leads_id, date_quoted, quote_no, status, date_posted, ran
	$sql3 = "SELECT * FROM quote WHERE created_by = $agent_from AND  created_by_type = 'agent' AND leads_id = ".$row['id'];
	$result4 = $db->fetchAll($sql3);
	//echo $sql3."<br>";
	foreach($result4 as $row4){
		$data4 = $row4;
		$data4['leads_id'] = $leads_id;
		unset($data4['id']); // removed the leads_remarks.id in the list
		$db_uk->insert('quote', $data4);
		$quote_id = $db_uk->lastInsertId();
		//PARSE ALL DATA from TABLE : SELECT * FROM quote_details q;
		//id, quote_id, work_position, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price, work_status, currency, work_description, notes, currency_fee, currency_rate, gst, no_of_staff, quoted_quote_range
		$sql4 =  "SELECT * FROM quote_details q WHERE quote_id = ".$row4['id'];
		$result5 = $db->fetchAll($sql4);
		foreach($result5 as $row5){
			$data5 = $row5;
			$data5['quote_id'] = $quote_id;
			unset($data5['id']); 
			$db_uk->insert('quote_details', $data5);
		}
		
	}
	
	//TABLE : SELECT * FROM service_agreement s;
	//service_agreement_id, quote_id, leads_id, created_by, created_by_type, date_created, status, date_posted, posted_by, posted_by_type, ran
	$sql5 = "SELECT * FROM service_agreement WHERE created_by = $agent_from AND  created_by_type = 'agent' AND leads_id = ".$row['id'];
	$result6 = $db->fetchAll($sql5);
	foreach($result6 as $row6){
		$data6 = $row6;
		$data6['leads_id'] = $leads_id;
		unset($data6['service_agreement_id']); 
		$db_uk->insert('service_agreement', $data6);
		$service_agreement_id = $db_uk->lastInsertId();
		
		//parse table : SELECT * FROM service_agreement_details s;
		//service_agreement_details_id, service_agreement_id, service_agreement_details
		$sql6 = "SELECT * FROM service_agreement_details WHERE service_agreement_id = ".$row6['service_agreement_id'];
		$result7 = $db->fetchAll($sql6);
		foreach($result7 as $row7){
			$data7 = $row7;
			$data7['service_agreement_id'] = $service_agreement_id;
			unset($data7['service_agreement_details_id']); 
			$db_uk->insert('service_agreement_details', $data7);
		}
	}	
	
	
	echo "Transferred";
}

?>
</td></tr>
</table>
</form>