<?php
require_once('conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

if($_SESSION['admin_id']=="")
{
	die("Session Expires . Please re login");
}

$sql = $db->select()
	->from('admin')
	->where('admin_id =?' , $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);	


$table = $_REQUEST['section'];
if($table){
	if($table == 'clients'){
		$sql = $db->select()
			->from(array('s' => 'subcontractors') , Array('leads_id'))
			->join(array('l' => 'leads') , 'l.id = s.leads_id' , Array('email'))
			->where('s.status=?', 'ACTIVE')
			->group('s.leads_id')
			->order('l.fname ASC');
		//echo $sql."<br>";	
		$clients = $db->fetchAll($sql);	
		foreach($clients as $client){
		
				if($client['email']!=""){
					$emails .=sprintf("%s," ,trim($client['email']));
				}
				/*
				if($client['acct_dept_email1']!=""){ //check email
					if($client['acct_dept_name1'] == ""){ // check name
						$client['acct_dept_name1'] = $client['fname']." ".$client['lname'];
					}
					$emails .=sprintf("%s," ,trim($client['acct_dept_email1']));
				}
				
				if($client['acct_dept_email2']!=""){ //check email
					if($client['acct_dept_name2'] == ""){ // check name
						$client['acct_dept_name2'] = $client['fname']." ".$client['lname'];
					}
					$emails .=sprintf("%s," ,trim($client['acct_dept_email2']));
				}
			    */
			
		}
		
		$tb = 'leads';
	}else if($table == 'subcon'){
		$sql = $db->select()
			->from(array('s' => 'subcontractors'), Array('id', 'userid'))
			->join(array('p' => 'personal'), 'p.userid = s.userid' , Array('fname', 'lname', 'email'))
			->where('s.status =?', 'ACTIVE')
			->order('p.fname ASC');
		$subcons = $db->fetchAll($sql);
		foreach($subcons as $subcon){
			if($subcon['email']!=""){
				$emails .=sprintf("%s," ,trim($subcon['email']));
			}
		}
	    $tb = 'personal';	
	}
	
	$emails=substr($emails,0,(strlen($emails)-1)); // remote the last , 
	$smarty->assign('table', $tb);
	$smarty->assign('emails',$emails);
}

function GetName($table, $id){
    global $db;
	$name='';
	if($table =="leads"){
	    $sql = "SELECT fname, lname FROM leads WHERE id=".$id;
		$result = $db->fetchRow($sql);
		$name = $result['fname']." ".$result['lname'];
	}else if($table == 'personal'){
	    $sql = "SELECT fname, lname FROM personal WHERE userid=".$id;
		$result = $db->fetchRow($sql);
		$name = $result['fname']." ".$result['lname'];
	}else{
	    $name = '';
	}
	return $name;
	
}
if ($_POST["emails"]) {
   
    $emails = $_POST["emails"];
    $email_array = explode(",", $emails);
	
	
    $subject = stripslashes($_POST["subject"]);
    $message = stripslashes($_POST["message"]);
	//$table = $_POST['table'];
	
	if($subject==""){
		if(! TEST){
			$subject="MESSAGE FROM REMOTE STAFF";
		}else{
			$subject="TEST MESSAGE FROM REMOTE STAFF";
		}
	}
	
	$path = "mass_mailer/messages/";
	$ourFileName = microtime().".html";
	$fh = fopen($path.$ourFileName, 'w') or die("can't open file");
	
	
	$stringData = "SENDER : ".$admin['admin_fname']." ".$admin['admin_lname']." <br>";
	fwrite($fh, $stringData);
	
	$stringData = "DATE : ".date('Y-m-d H:m:s')." <br>";
	fwrite($fh, $stringData);
	
	$stringData = "SUBJECT : ".$subject." <br>";
	fwrite($fh, $stringData);
	
	$stringData = "TO : ".$emails." <br>";
	fwrite($fh, $stringData);
	
	$stringData = "MESSAGE : ".$message." <br>";
	fwrite($fh, $stringData);
	
	fclose($fh);
	
    $mail = new Zend_Mail('utf-8');
	$mail->setFrom($admin['admin_email'], $admin['admin_fname']." ".$admin['admin_lname']);
    $mail->setSubject($subject);
    $mail->setBodyHtml($message);
    
	//echo $message;exit;
	foreach($email_array as $email) {
	    
        echo "sending email for: $email</br>";
        
       
		if(! TEST){
			$mail->addTo($email , $email);
			
		}else{
			$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
			
		}
	
        //$mail->addBcc('devs@remotestaff.com.au'); //TODO remove this
        $mail->send($transport);
        
    }

	die('all emails sent');
    
}

$smarty->assign('php_self',$_SERVER['PHP_SELF']);
$smarty->display('mass_mailer.tpl');
?>