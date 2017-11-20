<?php 
include '../conf/zend_smarty_conf.php';
include '../lib/validEmail.php';
include 'time.php';
$smarty = new Smarty();

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

   

if(isset($_POST['validate']))
{
	//TODO 
	$status = 1;
	$code = $_POST['code'];
	$email = trim($_POST['email']);
	$fname = trim($_POST['staff_fname']);
	$lname = trim($_POST['staff_lname']);
	$page = $_POST['page'];

	
	//check the if valid	
	if (!validEmail($email)){ 
		//Invalid Email Address
		$status = 0;
		$error_msg = "Invalid Email Address!";
		$error = "True";
		
	}
	
	//check email if exist
	if($status == 1){
		$sql=$db->select()
			->from('personal')
			->where('email =?',$email);
		$result = $db->fetchAll($sql);
		
		if(count($result) > 0){
			$status = 0;
			$error_msg = "The email address you have entered is already registered with Remotestaff.<br> Should you wish to log in to your account, please click <a href='/portal/'>HERE</a><br>";
			$error = "True"; 
		}
	}
	
	//check the code and email in tb_temporary_email_account
	if($status == 1){
		$sql=$db->select()
			->from('tb_temporary_email_account' ,'id' )
			->where('email = ?' , $email)
			->where('code = ?' , $code);
		$result	= $db->fetchRow($sql);
		$id = $db->fetchOne($sql);
		
		if(!$id){
			$status = 0;
			$error_msg = "Email / Code does not match";
			$error = "True";
		}
	}

	if($status == 1){
		
		$error = "False";
		
		//make a random string password for client 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$rand_pw = '';    
		for ($p = 0; $p < 10; $p++) {
			$rand_pw .= $characters[mt_rand(0, strlen($characters))];
		}
			
		$data = array('email' => $email , 'fname' => $fname , 'lname' => $lname , 'pass' => sha1($rand_pw), 'datecreated' => $ATZ , 'registered_email' => $email );	
		$db->insert('personal', $data);		
		$userid = $db->lastInsertId();
		
		$_SESSION['userid'] = $userid;
		$error = "False";
		$error_msg = "<b>Your registered email is now validated</b>. <br>Please fill all the forms to give employers a snapshot of your profile.";	
	}
	

}
?>
<html>
<head></head>
<body>
<form name="form1" method="post" action="<?php echo $page?>">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="hidden" name="fname" value="<?php echo $fname;?>">
<input type="hidden" name="lname" value="<?php echo $lname;?>">

<input type="hidden" name="code" value="<?php echo $code;?>">
<input type="hidden" name="error" value="<?php echo $error;?>">
<input type="hidden" name="error_msg" value="<?php echo $error_msg;?>">
<script type="text/javascript">
<!--
document.form1.submit();
-->
</script>
</form>
</body>
</html>