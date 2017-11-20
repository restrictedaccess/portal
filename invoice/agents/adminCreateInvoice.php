<?php
    include("../../conf.php");
	include("../../config.php");
    include("../../time_recording/TimeRecording.php");
	
	
    date_default_timezone_set("Asia/Manila");
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }

    $invoice_date = $_POST['invoice_date'];
    $agentid = $_POST['agentid'];
    $description = $_POST['description'];
    $payment_details = $_POST['payment_details'];
    $mode = $_POST['mode'];

    if (($invoice_date == "") or ($invoice_date == null)) {
        die("Invoice date missing.");
    }

    if (($agentid == "") or ($agentid == null)) {
        die("agentid missing.");
    }

    if (($mode == "") or ($mode == null)) {
        die("mode missing.");
    }

    $now = new DateTime();
    $now_str = $now->format('Y-m-d');
	
// Get the Affiliates Commission rate / type
$queryAgent="SELECT * FROM agent  WHERE agent_no = $agentid";
$result_agent = mysql_query($queryAgent);
$rows=mysql_fetch_array($result_agent);
$commission_type =$rows['commission_type'];
if($commission_type == "LOCAL")
{
	$percent = .10;
}
elseif($commission_type == "INTERNATIONAL")
{
	$percent = 0;
}
else
{
	$commission_rate = 0;
	$percent = 0;
}
	
  
    if ($mode == 'blank') {
        $query = "INSERT INTO agent_invoice (agentid, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, invoice_date, draft_date,percent) values ($agentid, '$description', '$payment_details', $admin_id, 'admin', $admin_id, 'admin', 'draft', '$invoice_date', '$now_str','$GST')";
        $dbh->exec($query);
        $invoice_id = $dbh->lastInsertId();
        echo "<div id='invoice_id' invoice_id='$invoice_id'>Loading invoice number $invoice_id</div>";
		//echo "<div id='invoice_id' invoice_id='$invoice_id'>Here :: $mode</div>";
        exit;
    }


/// PARSE AGENT'S SUBCONS

    if ($mode == 'time_records') {

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $invoice_date = $_POST['invoice_date'];
        $description = $_POST['description'];

        if (($start_date == "") or ($start_date == null)) {
            die("Start date missing.");
        }

        if (($end_date == "") or ($end_date == null)) {
            die("End date missing.");
        }

        $now_date_time_str = $now->format("Y-m-d H:i:s");
        if (($invoice_date == "") or ($invoice_date == null)) {
            $invoice_date = $now->format("Y-m-d");
        }

        //insert record on the subcon_invoice
        $query = "INSERT INTO agent_invoice (agentid, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date) VALUES ($agentid, '$description', '$payment_details', $admin_id, 'admin', $admin_id, 'admin', 'draft', '$start_date', '$end_date', '$invoice_date', '$now_str')";
        $dbh->exec($query);
        $invoice_id = $dbh->lastInsertId();
		
		
        $start_date_obj = new DateTime($start_date);
        $start_date_str = $start_date_obj->format("Y-m-d 00:00:00");
        $start_date_obj = new DateTime($start_date_str);

        //parse end_date use last second before the next day
        $end_date_obj = new DateTime($end_date);
        $end_date_str = $end_date_obj->format("Y-m-d 23:59:59");
        $end_date_obj = new DateTime($end_date_str);

        //get the maximum item_id
        //$query = "SELECT MAX(item_id) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
        //$data = $dbh->query($query);
        //$result = $data->fetch();
        //$item_id = $result[0] + 1;
//------------

$query="SELECT DISTINCT(l.id),l.fname,l.lname FROM leads l JOIN subcontractors s ON s.leads_id = l.id WHERE l.status = 'Client' 
AND l.agent_id =$agentid ORDER BY timestamp DESC;";
$result=mysql_query($query);
$check=@mysql_num_rows($result);
if ($check > 0)
{		
	$query2 = "SELECT MAX(item_id) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
	$result2 = mysql_query($query2);
	$row=mysql_fetch_array($result2);
	$item_id = $row[0] + 1;
	
	while(list($leads_id,$fname,$lname)=mysql_fetch_array($result))
	{	
		$query3 = "SELECT MAX(counter) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
		$result3 = mysql_query($query3);
		$rows=mysql_fetch_array($result3);
		$counter = $rows[0] + 1;
				
		$description ="Client :".$fname." ".$lname;
		$sql = "INSERT INTO agent_invoice_details (agent_invoice_id, item_id, description,counter) 
		VALUES ($invoice_id, $item_id, '$description',$counter)";
		mysql_query($sql);
		$invoice_details_id = mysql_insert_id();
		//echo $invoice_details_id;
		/*
		$query3="SELECT s.userid,p.fname,p.lname,COUNT(t.id) AS dayswork,s.work_status
				FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid
				LEFT JOIN timerecord t ON t.userid = p.userid 
				WHERE s.leads_id = $leads_id AND s.agent_id = $agentid AND s.status = 'ACTIVE' AND t.mode = 'regular'
				AND t.time_in BETWEEN '$start_date_str' AND '$end_date_str' GROUP BY s.userid;";
		*/
		$query3="SELECT s.userid,p.fname,p.lname,COUNT(t.id) AS dayswork,s.work_status,s.client_price,s.working_days
				FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid
				LEFT JOIN timerecord t ON t.userid = p.userid 
				WHERE s.leads_id = $leads_id AND s.agent_id = $agentid AND s.status = 'ACTIVE' AND t.mode = 'regular'
				AND t.time_in BETWEEN '$start_date_str' AND '$end_date_str' GROUP BY s.userid;";		
		//echo $query3."<br><br>";
		$result3 = mysql_query($query3);
		while(list($userid,$sfname,$slname,$dayswork,$work_status,$client_price,$working_days)=mysql_fetch_array($result3))
		{
			
					
			$query2 = "SELECT MAX(item_id) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
	        $result2 = mysql_query($query2);
			$row=mysql_fetch_array($result2);
			$item_id = $row[0] + 1;
			
			$daily_rate = $client_price * .06;
			//Check if the Subcon is a Part-Time then the daily rate must 50%
			if($work_status=="Part-Time"){
				$daily_rate = ($daily_rate * .50);
			}
			
			$yearly = ($daily_rate * 12 );
			$weekly = $yearly / 52 ;
			$daily = $weekly / 5 ;
			
			
			
			$total_amount = $daily * $dayswork;
			
			//$sql2 ="SELECT * FROM agent_invoice_details WHERE id = $invoice_details_id";
			//$result4 = mysql_query($sql2);
			//$row= mysql_fetch_array($result4);


			$description ="Subcon ".$work_status.": ".$sfname." ".$slname."  Charge Out Price ".number_format($client_price,2,'.',','). " * 6% = ".number_format($daily_rate,2,'.',',')." (".$dayswork." days worked * ".number_format($daily,2,'.',',')." = ".number_format($total_amount,2,'.',',').") ";
			$sql3 = "INSERT INTO agent_invoice_details SET agent_invoice_id = $invoice_id, item_id = $item_id , description = '$description', amount = $total_amount;";
			mysql_query($sql3);

			$amount=0;
			$total_amount=0;
			$yearly = 0;
			$weekly = 0;
			$daily = 0;
			$daily_rate =0;
			
		}
		$amount=0;
		$total_amount=0;
		$yearly = 0;
		$weekly = 0;
		$daily = 0;
		$daily_rate =0;
	}
	//echo "here";
	   
}
		
		
//------------
		//
		$query = "SELECT SUM(amount) FROM agent_invoice_details WHERE agent_invoice_id = $invoice_id";
        $result = $dbh->query($query);
		$data = $result->fetch();
	    $total_amount = $data[0];
		
		$GST = $total_amount * $percent;
		
		$converted_amount =  $total_amount + $GST;   
    	$query = "UPDATE agent_invoice SET total_amount = '$total_amount' , converted_amount = '$converted_amount',percent = '$GST' where id = $invoice_id";
	    $dbh->exec($query);

	
	    //
        echo "<div id='invoice_id' invoice_id='$invoice_id'>Loading invoice number $invoice_id</div>";
        exit;
		
    }

?>
