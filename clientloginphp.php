<?php



include 'config.php';
include 'conf.php';
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);

if(isset($_POST['email'])) $email = $_POST['email']; else $email = '';

// 2010-11-14 mike
if(isset($_POST['password'])) $password = $_POST['password']; else $password = 'nopass';
$crypt_password = sha1($password);


/*
id, tracking_no, agent_id, timestamp, status, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, password, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt
*/
$query="SELECT * FROM leads WHERE email ='".$email."' AND password='".$crypt_password."' AND status = 'Client';";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//clientHome.php
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$_SESSION['client_id'] =$row[0]; 
	header("location:clientHome.php");
	die();
	//echo "here";
}
else
{
	header("Location:index.php?mess=2");
	die();
}



?>