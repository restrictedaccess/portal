<?php
include('../conf/zend_smarty_conf.php');
include '../leads_information/ShowLeadsOrder.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../config.php';
include '../time.php';
include '../conf.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$status = @$_REQUEST["status"];
$id = @$_REQUEST["id"];
$hired_visiblity = @$_REQUEST["hired_visiblity"];

//START: validate session
$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];
if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}
//ENDED: validate session

//START: recruitment status update
if(isset($status))
{
    /**
     * Injected By Josef Balisalisa START
     */
    $previous_interview = $db->fetchRow(
        $db->select()
        ->from("tb_request_for_interview", array("status", "leads_id", "applicant_id"))
        ->joinLeft("personal", "personal.userid = applicant_id", array("applicant_fname" => "fname", "applicant_lname" => "lname"))
        ->joinLeft("leads", "leads.id = leads_id", array("client_fname" => "fname", "client_lname" => "lname"))
        ->where("tb_request_for_interview.id = ?", $id)
    );
    /**
     * Injected By Josef Balisalisa END
     */
	$date_updated = date("Y-m-d h:i:s");
	
	$db->update("tb_request_for_interview", array("status"=>$status,
						"date_updated"=>$date_updated),
						$db -> quoteInto("id =?", $id));

	//mysql_query("UPDATE tb_request_for_interview SET status='$status', date_updated='$date_updated' WHERE id='$id'");
	if($stat=='ARCHIVED' || $stat=='HIRED' || $stat=='REJECTED' || $stat=='CANCELLED')
	{
		$db->update("tb_app_appointment", array("status"== "not active"), $db ->quoteInto("request_for_interview_id =?",$id));
		//mysql_query("UPDATE tb_app_appointment SET status='not active' WHERE request_for_interview_id='$id'");	
	}
	if($status=='HIRED')
	{
		//$u = mysql_query("SELECT applicant_id FROM tb_request_for_interview WHERE id='$id'");
		$uid = $db->fetchOne("SELECT applicant_id FROM tb_request_for_interview WHERE id='$id'");
		if($hired_visiblity == "yes")
		{
			$jscas = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.userid"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("sub_category_name"))->where("userid = ?",$uid));
			foreach($jscas as $jsca){
				$history_changes = "<span style='color:#ff0000'>Removed</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span>";
				$changeByType = $_SESSION["status"];
				if ($changeByType=="FULL-CONTROL"){
					$changeByType = "ADMIN";
				}
				
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$jsca["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
						
			}
			//mysql_query("UPDATE job_sub_category_applicants SET ratings='1' WHERE ratings='0' AND userid='$uid'");
			$db -> update("job_sub_category_applicants", array("ratings"=>"1"), 
							$db->quoteInto("ratings = 0 AND userid =?", $uid));
                            
            $curl->get($base_api_url."/mongo-index/sync-all-candidates/", array("userid" => $uid));
            $curl->get($base_api_url."/solr-index/sync-asl/", array("userid" => $uid));
           
			
			
		}
	}
	
	$sql = $db->select()
        ->from('tb_request_for_interview', 'leads_id')
	    ->where('id =?', $id);
    $leads_id = $db->fetchOne($sql);


    if($leads_id)
    {
        while(true){
            try{

                if (TEST){
                    $mongo = new MongoClient(MONGODB_TEST);
                }else{
                    $mongo = new MongoClient(MONGODB_SERVER);
                }
                $database = $mongo->selectDB('prod');
                break;
            } catch(Exception $e){
                ++$retries;

                if($retries >= 100){
                    break;
                }
            }
        }//end while

        $job_orders = $database->selectCollection('job_orders');
        $leads_job_orders = $job_orders->find(array('leads_id'=>intval($leads_id)));

        try{

            foreach($leads_job_orders as $key=>$leads_job_order){
                if($leads_job_order['tracking_code'])
                {
                    $curl->get($base_api_url."/job-order/delete-job-order-mysql/", array("tracking_code" => $leads_job_order['tracking_code']));
                }
            }

        }catch(Exception $e){

            print_r($e);
        }

    }

    $orders_str = CheckLeadsOrderInASL($leads_id);
    if($orders_str > 0){
        $data = array('asl_orders' => 'yes');
	    addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
	    $db->update('leads', $data, 'id='.$leads_id);
    }else{
	    $data = array('asl_orders' => 'no');
	    addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
	    $db->update('leads', $data, 'id='.$leads_id);
    }
    
    $sql = $db->select()
        ->from(array("tbr"=>"tb_request_for_interview"), array("tbr.date_interview AS schedule"))
        ->joinInner(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("pers.fname AS staff_fname", "pers.email AS staff_email", "pers.userid AS applicant_id"))
        
        ->joinInner(array("l"=>"leads"), "l.id = tbr.leads_id", array("l.fname AS client_fname"))
        ->where('tbr.id =?', $id);
    $row = $db->fetchRow($sql);
    
    
    
   $facilitator = $db->fetchRow($db->select()
   		->from(array("app"=>"tb_app_appointment"), array())
   		->joinInner(array("adm"=>"admin"), "adm.admin_id = app.user_id", array("adm.admin_fname AS admin_fname", "adm.admin_lname AS admin_lname", "adm.admin_email AS admin_email"))
   		->where("app.request_for_interview_id = ?", $id));
	if (!$facilitator){
	   	$facilitator = $db->fetchRow($db->select()
	   			->from(array("adm"=>"admin"),array("adm.admin_fname AS admin_fname", "adm.admin_lname AS admin_lname", "adm.admin_email AS admin_email"))
	   			->where("adm.admin_id = ?", $_SESSION["admin_id"]));
	}

   	$admin_email = $facilitator['admin_email'];
	$name = $facilitator['admin_fname']." ".$result['admin_lname'];
	$admin_email=$facilitator['admin_email'];
	$signature_company = $facilitator['signature_company'];
	$signature_notes = $facilitator['signature_notes'];
	$signature_contact_nos = $facilitator['signature_contact_nos'];
	$signature_websites = $facilitator['signature_websites'];
	$site = $_SERVER['HTTP_HOST'];
	
	if($signature_notes!=""){
		$signature_notes = "<p><i>$signature_notes</i></p>";
	}else{
		$signature_notes = "";
	}
	if($signature_company!=""){
		$signature_company="<br>$signature_company";
	}else{
		$signature_company="<br>RemoteStaff";
	}
	if($signature_contact_nos!=""){
		$signature_contact_nos = "<br>$signature_contact_nos";
	}else{
		$signature_contact_nos = "";
	}
	if($signature_websites!=""){
		$signature_websites = "<br>Websites : $signature_websites";
	}else{
		$signature_websites = "";
	}

	$signature_template = $signature_notes;
	$signature_template .="<a href='http://$site/$agent_code'>
											<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
	$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : {$facilitator["admin_email"]}$signature_websites</p><br /><br />";
	//END SEGNATURE
   		
	$smarty = new Smarty();
	$smarty->assign("staff_fname", $row["staff_fname"]);
	$smarty->assign("client_fname", $row["client_fname"]);
	$smarty->assign("scheduleDate", $row["schedule"]);
	$smarty->assign("signature_admin", $signature_template);
    if ($status=="REJECTED"){
    	$output = $smarty->fetch("rejected_candidate_autoresponder.tpl");
    }else if ($status=="CANCELLED"){
    	$output = $smarty->fetch("cancelled_candidate_autoresponder.tpl");    	
    }else if ($status=="HIRED"){
    	$output = $smarty->fetch("hired_autoresponder.tpl");
    }else if ($status=="DONE"){
    	$output = $smarty->fetch("waiting_for_feedback_autoresponder.tpl");
    }
    
    if ($status=="REJECTED"||$status=="CANCELLED"||$status=="DONE"
        /**
         * removed by Josef Balisalisa due to email from sir Eds:
         *
         * Hi Anne, Allan

        May I request that this automated e-mail after a candidate is tagged as HIRED on Interview Bookings page be removed since No Service Agreement has been accepted yet at this stage. Moreover, the request for them to prepare for the documents below is already part of the e-mail being sent to them by Peachy together with the Independent Sub-Contractor Agreement and Offer Letter.

        Reason for this is that candidates are receiving this notice even though Service Agreement from the client side is not accepted and therefore creating confusion to the candidates and even to the Staffing Consultants.

        For your kind attention and consideration. Thank you


        Edward
         */
//        ||$status=="HIRED"
    ){
    	
	    $mail = new Zend_Mail();
		$mail->setBodyHtml($output);
		if (!TEST){
			$mail->setSubject("Updates for your application at Remotestaff");
		}else{
			$mail->setSubject("TEST - Updates for your application at Remotestaff");
		}
		$mail->setFrom($facilitator["admin_email"], "Remotestaff");
		if(!TEST){
			$mail->addTo($row["staff_email"], $row["staff_email"]);
		}else{
			$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
			//$mail->addTo('remote.allanaire@gmail.com', 'remote.allanaire@gmail.com');
			
		}
		//query the recruiter assigned and cc them to update
		$recruiter = $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"), array())->joinInner(array("adm"=>"admin"), "adm.admin_id = rs.admin_id", array("adm.admin_email AS recruiter_email"))->where("rs.userid = ?", $row["applicant_id"]));
		if ($recruiter){
			if (!TEST){
				$mail->addCc($recruiter["recruiter_email"]);
			}else{
				$mail->addCc("devs@remotestaff.com.au");
			}
			
		}
		
	    $mail->send($transport);
    }
    $previous_interview_status = $previous_interview["status"];

    $current_previous_status_string = $previous_interview_status;

    switch ($previous_interview_status)
    {
        case "ACTIVE":
            $current_previous_status_string = "New";
            break;
        case "ARCHIVED":
            $current_previous_status_string = "Archived";
            break;
        case "ON-HOLD":
            $current_previous_status_string = "On Hold";
            break;
        case "HIRED":
            $current_previous_status_string = "Hired";
            break;
        case "REJECTED":
            $current_previous_status_string = "Rejected";
            break;
        case "CONFIRMED":
            $current_previous_status_string = "Confirmed/In Process";
            break;
        case "YET TO CONFIRM":
            $current_previous_status_string = "Client contacted, no confirmed date";
            break;
        case "DONE":
            $current_previous_status_string = "Interviewed; waiting for feedback";
            break;
        case "RE-SCHEDULED":
            $current_previous_status_string = "Confirmed/Re-Booked";
            break;
        case "CANCELLED":
            $current_previous_status_string = "Cancelled";
            break;
        case "CHATNOW INTERVIEWED":
            $current_previous_status_string = "Contract Page Set";
            break;
        case "ON TRIAL":
            $current_previous_status_string = "On Trial";
            break;
    }
    
	switch ($status) 
	{
		case "ACTIVE":
			$stat = "New";
			break;
		case "ARCHIVED":
			$stat = "Archived";
			break;
		case "ON-HOLD":
			$stat = "On Hold";
			break;															
		case "HIRED":
			$stat = "Hired";
			break;															
		case "REJECTED":
			$stat = "Rejected";
			break;		
		case "CONFIRMED":
			$stat = "Confirmed/In Process";	
			break;		
		case "YET TO CONFIRM":
			$stat = "Client contacted, no confirmed date";
			break;		
		case "DONE":
			$stat = "Interviewed; waiting for feedback";
			break;
		case "RE-SCHEDULED":
			$stat = "Confirmed/Re-Booked";
			break;	
		case "CANCELLED":
			$stat = "Cancelled";
			break;	
		case "CHATNOW INTERVIEWED":
			$stat = "Contract Page Set";
			break;	
		case "ON TRIAL":
			$stat = "On Trial";
			break;				
	}

    /**
     * Injected By Josef Balsialisa START
     */
    $changeByType = $_SESSION["status"];
    if ($changeByType=="FULL-CONTROL"){
        $changeByType = "ADMIN";
    }
    $history_changes = "<font color=#FF0000>Updated</font> status of Interview between client(" . $previous_interview["client_fname"] . " " . $previous_interview["client_lname"] . " #" . $previous_interview["leads_id"] . ") and applicant(" . $previous_interview["applicant_fname"] . " " . $previous_interview["applicant_lname"] . " #" . $previous_interview["applicant_id"] . ") from " . $current_previous_status_string . "=>" . $stat;

    $db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$previous_interview["applicant_id"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
    $db->insert("request_for_interiew_history", array("changes"=>$history_changes, "tb_request_for_interview_id"=>$id, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));

    /**
     * Injected By Josef Balisalisa END
     */


    echo $stat;
}
//ENDED: recruitment status update
?>