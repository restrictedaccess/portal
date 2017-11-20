<?php
// from: education.php
include('conf/zend_smarty_conf.php');
include 'conf.php';
include 'config.php';
include 'function.php';

//$userid=$_REQUEST['userid'];
$userid=$_SESSION['userid'];

$educationallevel=$_REQUEST['educationallevel'];
$fieldstudy=$_REQUEST['fieldstudy'];
$major=$_REQUEST['major'];
$grade=$_REQUEST['grade'];
$gpascore=$_REQUEST['gpascore'];
$college_name=$_REQUEST['college_name'];
$college_country=$_REQUEST['college_country'];
$graduate_month=$_REQUEST['graduate_month'];
$graduate_year=$_REQUEST['graduate_year'];


$major=filterfield($major);
//$gpascore=filterfield($gpascore);
$college_name=filterfield($college_name);
if($gpascore=="")
{
	$gpascore=0;
}

$trainings_seminars = filterfield($_REQUEST['trainings_seminars']);

$data = array(
'userid' => $userid,
'educationallevel' => $educationallevel,
'fieldstudy' => $fieldstudy,
'major' => $major,
'grade' => $grade,
'gpascore' => $gpascore,
'college_name' => $college_name,
'college_country' => $college_country,
'graduate_month' => $graduate_month,
'graduate_year' => $graduate_year,
'trainings_seminars' => $trainings_seminars
);

$db->insert('education', $data);	
header("location:currentJob.php");

//to: -> currentJob.php
?>

