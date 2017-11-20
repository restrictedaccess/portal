<?
include './conf/zend_smarty_conf_root.php';

if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];


$query="SELECT * FROM leads WHERE id = $client_id;";
$row = $db->fetchRow($query);
$client_name = $row['fname']." ".$row['lname'];
$agent_id = $row['agent_id'];
$email = $row['email'];

$site = $_SERVER['HTTP_HOST'];
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$outsourcing_model=$_REQUEST['outsourcing_model'];
$companyname=$_REQUEST['companyname'];
$jobposition=$_REQUEST['jobposition'];
$jobvacancy_no=$_REQUEST['jobvacancy_no'];
$heading = $_REQUEST['heading'];





$data = array(
		'agent_id' =>  $agent_id ,
		'lead_id' =>  $client_id ,
		'date_created' =>  $ATZ ,
		'outsourcing_model' => $outsourcing_model,
		'companyname' => $companyname,
		'jobposition' => $jobposition,
		'jobvacancy_no' => $jobvacancy_no,
		'status' => 'NEW' ,
		'heading' => $heading
		);

$db->insert('posting', $data);
$posting_id = $db->lastInsertId();




for ($i = 0; $i < count($_POST['responsibility']); ++$i)
{
	if($_POST['responsibility'][$i]!="")
	{
		$data = array(
			'posting_id' =>  $posting_id ,
			'responsibility' =>  $_POST['responsibility'][$i]
		);
		$db->insert('posting_responsibility', $data);

	}	
}
////
for ($x = 0; $x < count($_POST['requirement']); ++$x)
{
	if($_POST['requirement'][$x]!="")
	{
		$data = array(
			'posting_id' =>  $posting_id ,
			'requirement' =>  $_POST['requirement'][$x]
		);
		$db->insert('posting_requirement', $data);

	}	
}


//SEND MAIL
if(! TEST){
	//admin email
	$to = 'admin@remotestaff.com.au'; // replace admin@remotestaff.com.au
	$fullname = "Rica J.";
}else{
	$to = 'devs@remotestaff.co.uk'; //replace devs@remotestaff.co.au to devs@remotestaff.co.uk for production deployment
	$fullname = "Remotestaff Developers";
}




$details =  "<h3>NEW ADS CREATED</h3>
			<p>CLIENT : ".$client_name."</p>
			<p>POSITION : ".$jobposition."</p>
			<p>HEADING : ".$heading."</p>
			<p>Created by : ".$client_name."</p>
			<p>NOTE : THIS AD IS NOT YET POSTED WAITING FOR ADMIN APPROVAL.</p><p>See it in Advertisement Tab Admin Section</p>";
			


$mail = new Zend_Mail();
$mail->setBodyHtml($details);
$mail->setFrom($email, $client_name);
$mail->addTo($to, $fullname);
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject($site." NEW ADS CREATED BY ".$client_name);
$mail->send($transport);


header("location:myjobposting.php?mess=1");

?>
