<?php
//2010-060-22 Normaneil Macutay <normanm@remotestaff.com.au>
// - fix typo error in SetUp Fee Invoice

include './conf/zend_smarty_conf_root.php';

function showToolTip($leads_id){
	global $db;
	$queryNOtes="SELECT DATE_FORMAT(starting_date,'%D %b %Y'),position,REPLACE(subcon,'\r\n','<br>'),DATE_FORMAT(working_start_date,'%D %b %Y'),subcon_no FROM admin_notes WHERE leads_id = $leads_id;";
	$result = $db->fetchAll($queryNOtes);
	$ctr = count($result);
	if ($ctr >0 )
	{
		$tooltip ="";
		$counter=0;
		//echo "<a href='#' onMouseOut='hideddrivetip();' onMouseOver='ddrivetip(\"$tooltip\")' onClick=javascript:popup_win('./admin_addNotes.php?leads_id=$leads_id',600,400);><img src='images/attach.gif' border='0'></a>";
	}else{
		//echo "<a href='#' onMouseOut='hideddrivetip();' onMouseOver='ddrivetip(\"Click on the Icon to Insert a Recruitment Preparation Notes!\")' onClick=javascript:popup_win('./admin_addNotes.php?leads_id=$leads_id',600,400);><img src='images/attach.gif' border='0'></a>";
	}	

}
function leadsInfoDetails($leads_id){
	global $db;
	$query ="SELECT * FROM leads WHERE id = $leads_id;";
	$result = $db->fetchRow($query);
	$lname = $result['lname'];
	$fname = $result['fname'];
	$email = $result['email'];
	echo "<div style='margin-bottom:10px; border-bottom:#000000 solid 1px; padding-bottom:5px;'><b>".$fname." ".$lname."</b> [ ".$email." ]</div>";
}

function getClientStaff($leads_id){
	global $db;
	$sql="SELECT COUNT(id)AS employee_no FROM subcontractors WHERE leads_id = $leads_id AND status = 'ACTIVE' GROUP BY leads_id;";
	//echo $sql;
	$result = $db->fetchRow($sql);	
	$employee_no = $result['employee_no'];
	//echo $employee_no;
	if ($employee_no >0){
		echo "<div style='margin-bottom:8px;'>";
		echo "<img src='images/groupofusers16.png' align='absmiddle' border='0' >
		<a href='#' onClick="."javascript:popup_win('./viewClientStaff.php?id=$leads_id',600,600);".">".$employee_no."&nbsp;Sub-Contractors</a>";
		echo "</div>";
	}
 
}

function showAgentFrom($date_move,$agent_from){
	global $db;
	if($date_move!="")
    {	if($agent_from!=""){
			$sql="SELECT * FROM agent WHERE agent_no = $agent_from";
			$result = $db->fetchRow($sql);
			$name = $result['fname']." ".$result['lname'];
			echo "Came from BP : " .$name." ".$date_move."<br>";
		}
	 }
}

function showViewButton($leads_id){
	global $db;
	$sqlCheckRemark="SELECT * FROM leads_remarks WHERE leads_id = $leads_id ORDER BY id DESC;";
	//echo $sqlCheckRemark;
	$result = $db->fetchAll($sqlCheckRemark);
	$ctr = count($result);
	if($ctr>0){
		//echo "<input type='button' value='view note' style='font:10px tahoma; width:65px;' onClick = 'javascript: show_hide(\"leads$leads_id\");'>";
		//echo substr($result[0]['remarks'],0,50)
		echo "<a href='javascript: show_hide(\"leads$leads_id\");'>".substr($result[0]['remarks'],0,90)."</a>";
	}else{
		echo "";
	}  
}

function getStepsTaken($leads_id){
	global $db;
	//Check if the leads is given by quote and set-up fee invoice
	//Quote 
	//$sqlQuote="SELECT id, DATE(date_posted)AS date_posted , ran FROM quote q WHERE leads_id = $leads_id AND status = 'posted';";
	$sqlQuote = "SELECT DISTINCT(q.id)AS quote_id, DATE_FORMAT(date_posted,'%D %b %y %h:%i %p')AS date_posted , ran , CONCAT(d.work_status ,' ' ,d.work_position , ' : ')AS description   , d.currency , d.quoted_price FROM quote q LEFT JOIN quote_details d ON d.quote_id =  q.id WHERE leads_id = $leads_id AND status = 'posted'";
	//echo $sqlQuote;
	$result = $db->fetchAll($sqlQuote);
	$ctr = count($result);
	if($ctr>0){
		echo "<div style='margin-bottom:8px;'>";
		echo "<b>$ctr Quote(s)</b>";
		foreach($result as $result){
			if($result['currency']=="AUD"){
				$currency = "\$ AUD ";
			}
			if($result['currency']=="USD"){
				$currency = "\$ USD ";
			}
			if($result['currency']=="POUND"){
				$currency = "£ UK ";
			}
			
			//echo $result['currency']."<br>";
			$ran = $result['ran'];
			echo "<div style='margin-bottom:3px;'><a style='color:green;' href='./pdf_report/quote/?ran=$ran' target='_blank'> - ".$result['date_posted']." quote given ".$result['description']." ".$currency.$result['quoted_price']."</a></div>";
		}
		echo "</div>";
	}
	
	//service agreement
	/*
	service_agreement_id, quote_id, leads_id, created_by, created_by_type, date_created, status, date_posted, posted_by, posted_by_type, ran
	*/
	$sqlServiceAgreement = "SELECT service_agreement_id , DATE(date_posted)AS date_posted , DATE_FORMAT(date_posted,'%h:%i %p')AS time_posted , ran  FROM service_agreement s WHERE leads_id = $leads_id AND status = 'posted';";
	$result = $db->fetchAll($sqlServiceAgreement);
	$ctr = count($result);
	if($ctr>0){
		echo "<div style='margin-bottom:8px;'>";
		echo "<div style=' margin-bottom:3px;'><b>".$ctr." Service Agreement given</b></div>";
		$initial_date = $result[0]['date_posted'];
		echo $initial_date."<br>";
		foreach($result as $row){
			$ran = $row['ran'];
			if($row['date_posted'] == $initial_date ) {
				echo "<a  style = 'color:#663300;' href='./pdf_report/service_agreement/?ran=$ran' target='_blank' class=''>- ".$row['time_posted']." Service Agreement # ".$row['service_agreement_id']."</a><br>";
			}
			if($row['date_posted'] != $initial_date ) {
				echo $row['date_posted']."<br>";
				echo "<a style = 'color:#663300;' href='./pdf_report/service_agreement/?ran=$ran' target='_blank' class=''>- ".$row['time_posted']." Service Agreement # ".$row['service_agreement_id']."</a><br>";
				$initial_date = $row['date_posted'];
			}
			
			
		}
		echo "</div>";
	}
	
	// Set-Up Fee
	$sqlSetUpFeeInvoice ="SELECT DISTINCT(s.id)AS id , s.status , DATE(post_date)AS post_date , DATE_FORMAT(post_date,'%h:%i %p')AS time_posted, DATE_FORMAT(paid_date,'%D %b %y %h:%i %p')AS paid_date , ran , invoice_number   FROM set_up_fee_invoice s WHERE leads_id = $leads_id AND s.status!='draft';";
	//echo $sqlSetUpFeeInvoice; 
	
	$result = $db->fetchAll($sqlSetUpFeeInvoice);
	$ctr = count($result);
	if($ctr>0){
		echo "<div style='margin-bottom:8px;'>";
		echo "<b>$ctr Set-up Fee Tax Invoice(s)</b><br>";
		$initial_date = $result[0]['post_date'];
		echo $initial_date."<br>";
		foreach($result as $row){
			$ran = $row['ran'];
			if($row['status'] == "paid"){
				$paid_status = " <img src='images/action_check.gif' align='absmiddle' border=0 /> Paid . ( ".$row['paid_date']. " )";
			}else{
				$paid_status = "";
			}
			
			if($row['post_date'] == $initial_date ) {
				echo " <a style='color:#6600FF;' href='./pdf_report/spf/?ran=$ran' target='_blank'> - ".$row['time_posted']." # ".$row['invoice_number']." Set-up Fee Invoice ".$paid_status."</a><br>";
			}
			if($row['post_date'] != $initial_date ) {
				echo $row['post_date']."<br>";
				echo " <a style='color:#6600FF;' href='./pdf_report/spf/?ran=$ran' target='_blank'> - ".$row['time_posted']." # ".$row['invoice_number']." Set-up Fee Invoice ".$paid_status."</a><br>";
				$initial_date = $row['post_date'];
			}
			
			
		}
		
		echo "</div>";
	}
	


	
	
	
	// Check if given Job Order form
	//job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type, form_filled_up, date_filled_up, ran
	$sqlJobOrderForm="SELECT DISTINCT(job_order_id),DATE(date_posted)AS posted_date,DATE_FORMAT(date_posted,'%h:%i %p')AS time_posted , DATE_FORMAT(date_filled_up,'%D %b %y %h:%i %p')AS date_filled_up,form_filled_up, ran
	  FROM job_order j WHERE leads_id = $leads_id AND j.status = 'posted';";
	  //echo $sqlJobOrderForm;
	$result = $db->fetchAll($sqlJobOrderForm);
	$form_filled_up = 0;
	
	if(count($result) > 0) {
		echo "<div style='margin-bottom:8px;'>";
		$initial_date = $result[0]['posted_date'];
		echo "<div style='margin-bottom:3px;'><b>".count($result). " Job Specification Form given</b></div>";
		echo $initial_date."<br>";
		foreach($result as $row) {
			
			if($row['form_filled_up'] == "yes") {
				$ran = $row['ran'];
				$date_filled_up = " (<img src='images/action_check.gif' align='absmiddle' /><a class='link15' href='./pdf_report/job_order_form/?ran=$ran' target='_blank' class=''>#".$row['job_order_id']." Job Specification Form filled up ".$row['date_filled_up']."</a> )";	
			}else{
				$date_filled_up="";
				$ran ="";
				
			}
			if($row['posted_date'] == $initial_date ) {
				echo " - ".$row['time_posted'].$date_filled_up."<br>";
			}
			if($row['posted_date'] != $initial_date ) {
				echo "<b>".$row['posted_date']."</b>";
				echo " - ".$row['time_posted'].$date_filled_up."<br>";
				$initial_date = $row['posted_date'];
			}
			
		}
		
		echo "</div>";
		
	}
	
	
}	


function getStepsTaken2($leads_id){
	global $db;
	//Check if the leads is given by quote and set-up fee invoice
	//Quote 
	//$sqlQuote="SELECT id, DATE(date_posted)AS date_posted , ran FROM quote q WHERE leads_id = $leads_id AND status = 'posted';";
	$sqlQuote = "SELECT DISTINCT(q.id)AS quote_id, DATE_FORMAT(date_posted,'%D %b %y %h:%i %p')AS date_posted , ran , CONCAT(d.work_status ,' ' ,d.work_position , ' : ')AS description   , d.currency , d.quoted_price FROM quote q LEFT JOIN quote_details d ON d.quote_id =  q.id WHERE leads_id = $leads_id AND status = 'posted'";
	//echo $sqlQuote;
	$result = $db->fetchAll($sqlQuote);
	$ctr = count($result);
	if($ctr>0){
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$steps_taken.= "<b>$ctr Quote(s)</b>";
		foreach($result as $result){
			if($result['currency']=="AUD"){
				$currency = "\$ AUD ";
			}
			if($result['currency']=="USD"){
				$currency = "\$ USD ";
			}
			if($result['currency']=="POUND"){
				$currency = "£ UK ";
			}
			
			//$steps_taken.= $result['currency']."<br>";
			$ran = $result['ran'];
			$steps_taken.= "<div style='margin-bottom:3px;'><a style='color:green;' href='./pdf_report/quote/?ran=$ran' target='_blank'> - ".$result['date_posted']." quote given ".$result['description']." ".$currency.$result['quoted_price']."</a></div>";
		}
		$steps_taken.= "</div>";
	}
	
	//service agreement
	/*
	service_agreement_id, quote_id, leads_id, created_by, created_by_type, date_created, status, date_posted, posted_by, posted_by_type, ran
	*/
	$sqlServiceAgreement = "SELECT service_agreement_id , DATE(date_posted)AS date_posted , DATE_FORMAT(date_posted,'%h:%i %p')AS time_posted , ran  FROM service_agreement s WHERE leads_id = $leads_id AND status = 'posted';";
	$result = $db->fetchAll($sqlServiceAgreement);
	$ctr = count($result);
	if($ctr>0){
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$steps_taken.= "<div style=' margin-bottom:3px;'><b>".$ctr." Service Agreement given</b></div>";
		$initial_date = $result[0]['date_posted'];
		$steps_taken.= $initial_date."<br>";
		foreach($result as $row){
			$ran = $row['ran'];
			if($row['date_posted'] == $initial_date ) {
				$steps_taken.= "<a  style = 'color:#663300;' href='./pdf_report/service_agreement/?ran=$ran' target='_blank' class=''>- ".$row['time_posted']." Service Agreement # ".$row['service_agreement_id']."</a><br>";
			}
			if($row['date_posted'] != $initial_date ) {
				$steps_taken.= $row['date_posted']."<br>";
				$steps_taken.= "<a style = 'color:#663300;' href='./pdf_report/service_agreement/?ran=$ran' target='_blank' class=''>- ".$row['time_posted']." Service Agreement # ".$row['service_agreement_id']."</a><br>";
				$initial_date = $row['date_posted'];
			}
			
			
		}
		$steps_taken.= "</div>";
	}
	
	// Set-Up Fee
	$sqlSetUpFeeInvoice ="SELECT DISTINCT(s.id)AS id , s.status , DATE(post_date)AS post_date , DATE_FORMAT(post_date,'%h:%i %p')AS time_posted, DATE_FORMAT(paid_date,'%D %b %y %h:%i %p')AS paid_date , ran , invoice_number   FROM set_up_fee_invoice s WHERE leads_id = $leads_id AND s.status!='draft';";
	//$steps_taken.= $sqlSetUpFeeInvoice; 
	
	$result = $db->fetchAll($sqlSetUpFeeInvoice);
	$ctr = count($result);
	if($ctr>0){
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$steps_taken.= "<b>$ctr Set-up Fee Tax Invoice(s)</b><br>";
		$initial_date = $result[0]['post_date'];
		$steps_taken.= $initial_date."<br>";
		foreach($result as $row){
			$ran = $row['ran'];
			if($row['status'] == "paid"){
				$paid_status = " <img src='images/action_check.gif' align='absmiddle' border=0 /> Paid . ( ".$row['paid_date']. " )";
			}else{
				$paid_status = "";
			}
			
			if($row['post_date'] == $initial_date ) {
				$steps_taken.= " <a style='color:#6600FF;' href='./pdf_report/spf/?ran=$ran' target='_blank'> - ".$row['time_posted']." # ".$row['invoice_number']." Set-up Fee Invoice ".$paid_status."</a><br>";
			}
			if($row['post_date'] != $initial_date ) {
				$steps_taken.= $row['post_date']."<br>";
				$steps_taken.= " <a style='color:#6600FF;' href='./pdf_report/spf/?ran=$ran' target='_blank'> - ".$row['time_posted']." # ".$row['invoice_number']." Set-up Fee Invoice ".$paid_status."</a><br>";
				$initial_date = $row['post_date'];
			}
			
			
		}
		
		$steps_taken.= "</div>";
	}
	


	
	
	
	// Check if given Job Order form
	//job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type, form_filled_up, date_filled_up, ran
	$sqlJobOrderForm="SELECT DISTINCT(job_order_id),DATE(date_posted)AS posted_date,DATE_FORMAT(date_posted,'%h:%i %p')AS time_posted , DATE_FORMAT(date_filled_up,'%D %b %y %h:%i %p')AS date_filled_up,form_filled_up, ran
	  FROM job_order j WHERE leads_id = $leads_id AND j.status = 'posted';";
	  //$steps_taken.= $sqlJobOrderForm;
	$result = $db->fetchAll($sqlJobOrderForm);
	$form_filled_up = 0;
	
	if(count($result) > 0) {
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$initial_date = $result[0]['posted_date'];
		$steps_taken.= "<div style='margin-bottom:3px;'><b>".count($result). " Job Specification Form given</b></div>";
		$steps_taken.= $initial_date."<br>";
		foreach($result as $row) {
			
			if($row['form_filled_up'] == "yes") {
				$ran = $row['ran'];
				$date_filled_up = " (<img src='images/action_check.gif' align='absmiddle' /><a class='link15' href='./pdf_report/job_order_form/?ran=$ran' target='_blank' class=''>#".$row['job_order_id']." Job Specification Form filled up ".$row['date_filled_up']."</a> )";	
			}else{
				$date_filled_up="";
				$ran ="";
				
			}
			if($row['posted_date'] == $initial_date ) {
				$steps_taken.= " - ".$row['time_posted'].$date_filled_up."<br>";
			}
			if($row['posted_date'] != $initial_date ) {
				$steps_taken.= "<b>".$row['posted_date']."</b>";
				$steps_taken.= " - ".$row['time_posted'].$date_filled_up."<br>";
				$initial_date = $row['posted_date'];
			}
			
		}
		
		$steps_taken.= "</div>";
		
	}
	
	return $steps_taken;
}

?>
