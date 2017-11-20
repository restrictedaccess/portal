<?
include '../config.php';
include '../conf.php';
include '../time.php';
include '../conf/zend_smarty_conf.php';


if($_SESSION['userid']=="")
{
	die("Session Expires Please Re-Login!");
}
$userid = $_SESSION['userid'];
$commission_id = $_REQUEST['commission_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
/*
commission_id, leads_id, created_by, created_by_type, commission_title, commission_amount, commission_desc, commission_status, date_created, date_approved, date_cancelled, date_paid, response_by_id, response_by_type, client_invoice_id

'new','claiming','approved','cancel','paid'
commission_staff_id, commission_id, userid, include_by, include_by_type, date_included, commission_staff_status, subcon_invoice_id, date_claiming, date_approved, date_cancelled, date_paid
*/

$query = "SELECT DISTINCT(l.id),CONCAT(l.fname,' ',l.lname),l.email,CONCAT(p.fname,' ',p.lname),p.email, c.commission_title , c.commission_amount
			FROM commission c
			LEFT JOIN commission_staff s ON s.commission_id = c.commission_id
			LEFT JOIN leads l ON l.id = c.leads_id
			LEFT JOIN personal p ON  p.userid = s.userid
			WHERE c.commission_id = $commission_id
			AND s.userid = $userid;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
list($leads_id,$leads_name,$leads_email,$staff_name,$staff_email, $commission_title , $commission_amount) = mysql_fetch_array($result);

$query2 = "UPDATE commission_staff SET commission_staff_status = 'claiming' , date_claiming = '$ATZ' WHERE commission_id = $commission_id AND userid = $userid;";
$result2 = mysql_query($query2);
if(!$result2) die("Error In Script.<br>".$query2);


// send a notification email to the client that a staff is claiming a commission to the client's commission rule
$body = "Dear ".$leads_name.",<br><br>".
		"One of your staff is claiming for commissions <br><br>".
		"Commission Rule  ".$commission_title ."<br><br>".
		"Amount : ".$commission_amount."<br><br>".
		"Staff Name : ".$staff_name; 

//$leads_email = "normaneil007@yahoo.com";
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'Remotestaff');
$mail->addTo($leads_email, $leads_name);
// Adds a recipient to the mail with a "Cc" header
//$mail->addBcc('normanm@remotestaff.com.au');
//$mail->addBcc('elainem@remotestaff.com.au');
$mail->addBcc('ricag@remotestaff.com.au');
//$mail->addBcc('daniel@remotestaff.com.au');

$mail->setSubject('REMOTESTAFF [ Staff Commission Claims ]');
$mail->send($transport);
echo "pending";

?>
