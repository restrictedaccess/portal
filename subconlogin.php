<?php
//2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
//  - updated, moved away from using pdo because of ->rowCount problems
//2008-12-09 Lawrence Sunglao <locsunglao@yahoo.com>
//	- removed the login presence upon login

//include('config.php');
include('conf.php');

$email = $_REQUEST['email'];
//$password = $_REQUEST['password'];
$password=sha1($_REQUEST['password']);
include('online_presence/OnlinePresence.php');

try {
    $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    die();
}

//check personal table
$query = "SELECT userid from personal where email = '$email' and pass = '$password'";
$data = $dbh->query($query)->fetchAll();
$flag_is_in_personal = count($data);
if ($flag_is_in_personal == 0) {
	header("Location:index.php?mess=3");
    exit;
}

$userid = $data[0]['userid'];

//check subcontractors table
$query2 = "SELECT id from subcontractors where userid = $userid AND status='ACTIVE'";
$data2 = $dbh->query($query2)->fetchAll();
$flag_is_in_subcontractors = count($data2);
if ($flag_is_in_subcontractors == 0) {
	header("Location:index.php?mess=3");
    exit;
}

$_SESSION['userid'] = $userid; 
//$presence = new OnlinePresence($userid, 'subcon');
//$presence->logIn();
header("Location:subconHome.php");

?>
