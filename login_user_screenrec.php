<?php
/*login_user_screenrec.php 2013-10-07
 login page used by screen recorder
*/
include('conf/zend_smarty_conf.php');

if( !isset($_POST['email']) && !isset($_POST['password']) ) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="verify-v1" content="LaxjipBphycGX3aaNPJVEJ4TawiiEs/3kDSe15OJ8D8=" />
<meta http-equiv="Content-Language" content="en-gb">
<link rel="stylesheet" type="text/css" href="css/index.css" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body id="loginx">
	<form id="login" class="expose" method="POST" action="">
			<table width="250" border="0" cellspacing="0" cellpadding="0" id="login">
			<tr>
			<td colspan="2" align="center" class="htitle"><strong>Remotestaff Login</strong></td>
			</tr>
			<tr>
			<td width="80" align="right">Email:</td>
			<td width="170"><input type="text" required="required" name="email" type="text" size="20" /></td>
			</tr>
			<tr>
			<td width="80" align="right">Password:</td>
			<td width="170"><input name="password" type="password" required="required" size="20" /></td>
			</tr>
			<tr>
			<td colspan="2" align="center"><input type="image" src="images/btn-login.png" width="80" height="17" /></td>
			</tr>
			</table>
    </form>
</body>
</html>
<?php
	exit;
}

$password = sha1(trim($_POST['password']));
$email = trim($_POST['email']);



$sql = $db->select()->from('leads', 'count(id)')
	->where('email = ?', $email)
	->where('password = ?', $password)
	->where('status = ?', 'Client');
	
if( $db->fetchOne($sql) > 0 ) { exit; }
else {
	$sql =$db->select()->from('client_managers', 'count(id)')
	->where('email =?', $email)
	->where('password = ?', $password)
	->where('status = ?','active');
	
	if( $db->fetchOne($sql) > 0 ) {
		exit;
	}
	else {
		$sql = $db->select()->from('admin', 'count(admin_id)')
		->where('admin_email = ?', $email)
		->where('admin_password = ?', $password)
		->where('status != ?', 'PENDING')
		->where('status != ?', 'REMOVED');
		
		if( $db->fetchOne($sql) > 0 ) { exit; }
		else {
			$sql = $db->select()->from(array('p'=>'personal'), array('count(p.userid)'))
			->joinLeft(array('s'=>'subcontractors'), 'p.userid=s.userid', array())
			->where('p.email = ?', $email)
			->where('p.pass = ?', $password)
			->where('s.userid IS NOT NULL')
			->where('s.status IN (?)', array('ACTIVE', 'suspended'));
			if( $db->fetchOne($sql) > 0 ) {
				header('');
			}
			else {?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="verify-v1" content="LaxjipBphycGX3aaNPJVEJ4TawiiEs/3kDSe15OJ8D8=" />
				<meta http-equiv="Content-Language" content="en-gb">
				<link rel="stylesheet" type="text/css" href="css/index.css" />
				<link rel="stylesheet" type="text/css" href="css/login.css" />
				<link rel="icon" href="favicon.ico" type="image/x-icon" />
				</head>
				<body id="loginx">
				Email / Password does not match!
				</body></html>
				
			<?php
			}
		}
	}
}
?>