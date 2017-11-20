<?php
mb_language('uni'); 
mb_internal_encoding('UTF-8');
include('conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');

$smarty = new Smarty;


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$aff_no=$_REQUEST['aff_no'];

$action = $_REQUEST['action'];
$subject=$_REQUEST['subject'];

//AFF
$email=$_REQUEST['email'];
$fullname=$_REQUEST['fullname'];
$txt = stripslashes($_REQUEST['txt']);


//BP
$agent_no = $_SESSION['agent_no'];
$sql=$db->select()
	->from('agent')
	->where('agent_no = ?' ,$agent_no);
$agent = $db->fetchRow($sql);
$link = sprintf("<a href='http://%s/%s' target='_blank'>http://%s/%s</a>",$_SERVER['HTTP_HOST'],$agent['agent_code'],$_SERVER['HTTP_HOST'],$agent['agent_code']);
$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s</div>" ,$name,$agent['agent_address'],$agent['agent_contact']);
//echo $email.' '.$fullname.' '.$aff_no.'<br>'.$link;







if($action=="EMAIL"){
    if($subject==""){
		 if(! TEST){
	         $subject='Message from RemoteStaff c/o  BP: '.$agent['fname'].' '.$agent['lname'];
         }else{
	         $subject='TEST Message from RemoteStaff c/o  BP: '.$agent['fname'].' '.$agent['lname'];
         }
    }else{
	     if(TEST){
	         $subject='TEST '.$subject;
         }
	}

    $site = $_SERVER['HTTP_HOST'];
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
	
	// Processes \r\n's first so they aren't converted twice.
	$newstr = str_replace($order, $replace, $txt);
	$body =" <div style='font:12px Tahoma; padding:10px;'>
							<div align='justify' style='padding:15px;margin-top:10px;' >".stripslashes($newstr)."</div>
							<div style='margin-top:20px;'>
							<a href='http://$site/$agent_code'>
							<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>
							
							<span style='color:#00CCCC;'>$site</span>
							".$signature_notes."
							</div>
						</div>";
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyHtml($body);
    $mail->setFrom($agent['email'], $agent['fname'].' '.$agent['lname']);
	
    if(! TEST){
	    $mail->addTo($email , $fullname);
    }else{
	    $mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	    //$mail->addTo('normanm@remotestaff.com.au', 'Remotestaff Developers');
    }

    $mail->setSubject(stripslashes($subject));
	
    foreach($_FILES as $userfile){
	    // store the file information to variables for easier access
	    $tmp_name = $userfile['tmp_name'];
	    $type = $userfile['type'];
	    $name = $userfile['name'];
	    $size = $userfile['size'];
		
	    if($tmp_name != ""){
		    $myImage = file_get_contents($tmp_name);
		    $at = new Zend_Mime_Part($myImage);
		    $at->type        = $type;
		    $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
		    $at->encoding = Zend_Mime::ENCODING_BASE64;
		    $at->filename    = $name;
		    $mail->addAttachment($at);
			$attached_file_names .= "<li>".$name."</li>";
	    }

    } 
    $result=$mail->send($transport);
    if($result){
	   
	   //id, created_by_id, created_by_type, to_by_id, to_by_type, actions, history, date_created, subject
	   $txt=str_replace("\n","<br>",$txt);
	   $data = array(
	       'created_by_id' => $agent_no, 
		   'created_by_type' => 'agent', 
		   'to_by_id' => $aff_no, 
		   'to_by_type' => 'affiliate', 
		   'actions' => $action, 
		   'history' => $txt, 
		   'date_created' => $ATZ, 
		   'subject' => $subject
	   );
	   $db->insert('history_affiliates', $data);
	   
	   header("location:apply_action_affiliates.php?id=$aff_no&code=1");
	   exit;
	   //echo 'email sent';
	}else{
	   //echo 'Problem in sending email';
	   header("location:apply_action_affiliates.php?id=$aff_no&code=2");exit;
	}
	//exit;
}else{
    $txt=str_replace("\n","<br>",$txt);
    $data = array(
	       'created_by_id' => $agent_no, 
		   'created_by_type' => 'agent', 
		   'to_by_id' => $aff_no, 
		   'to_by_type' => 'affiliate', 
		   'actions' => $action, 
		   'history' => $txt, 
		   'date_created' => $ATZ
	);
	$db->insert('history_affiliates', $data);
    header("location:apply_action_affiliates.php?id=$aff_no");exit;	   
}	
?>