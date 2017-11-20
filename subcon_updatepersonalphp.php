<?
// from : updateperosnal.php
include 'conf.php';
include 'config.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$userid = $_SESSION['userid'];

$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];

$byear=$_REQUEST['byear'];
$bmonth=$_REQUEST['bmonth'];
$bday=$_REQUEST['bday'];

$auth_no_type_id=$_REQUEST['auth_no_type_id'];
$msia_new_ic_no=$_REQUEST['msia_new_ic_no'];

$gender=$_REQUEST['gender'];
$nationality=$_REQUEST['nationality'];
$permanent_residence=$_REQUEST['permanent_residence'];

$email=$_REQUEST['email'];
$pass=$_REQUEST['pass'];
$alt_email=$_REQUEST['alt_email'];

$handphone_country_code=$_REQUEST['handphone_country_code'];
$handphone_no=$_REQUEST['handphone_no'];

$tel_area_code=$_REQUEST['tel_area_code'];
$tel_no=$_REQUEST['tel_no'];

$address1=$_REQUEST['address1'];
$address2=$_REQUEST['address2'];

$postcode=$_REQUEST['postcode'];

$country_id=$_REQUEST['country_id'];
$msia_state_id=$_REQUEST['msia_state_id'];


$city=$_REQUEST['city'];

$msn_id=$_REQUEST['msn_id'];
$yahoo_id=$_REQUEST['yahoo_id'];
$icq_id=$_REQUEST['icq_id'];
$skype_id=$_REQUEST['skype_id'];



///////// new fields ///// June 13 2008
$home_working_environment=$_REQUEST['home_working_environment'];
$internet_connection=$_REQUEST['internet_connection'];
$isp=$_REQUEST['isp'];
$computer_hardware=$_REQUEST['computer_hardware'];
$headset_quality=$_REQUEST['headset_quality'];
$computer_hardware=filterfield($computer_hardware);
//////////////////////////
//$msia_state_id=$_REQUEST['msia_state_id'];
if ($msia_state_id =="00")
{
	$state=$_REQUEST['state'];
}

if ($msia_state_id !="00")
{
	$state=$msia_state_id;
}

//$bday=$byear."-".$bmonth."-".$bday;

$fname=filterfield($fname);
$lname=filterfield($lname);
$auth_no_type_id=filterfield($auth_no_type_id);
$msia_new_ic_no=filterfield($msia_new_ic_no);

$email=filterfield($email);
$alt_email=filterfield($alt_email);

$handphone_no=filterfield($handphone_no);
$tel_area_code=filterfield($tel_area_code);
$tel_no=filterfield($tel_no);

$address1=filterfield($address1);
$address2=filterfield($address2);

$postcode=filterfield($postcode);
$city=filterfield($city);
$msn_id=filterfield($msn_id);
$yahoo_id=filterfield($yahoo_id);
$icq_id=filterfield($icq_id);
$skype_id=filterfield($skype_id);
$state=filterfield($state);
$fname=filterfield($fname);
$fname=filterfield($fname);
$fname=filterfield($fname);

/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality
*/


$query="UPDATE personal SET lname = '$lname', fname = '$fname', byear = '$byear', bmonth = '$bmonth', bday = '$bday', auth_no_type_id = '$auth_no_type_id', msia_new_ic_no = '$msia_new_ic_no', gender = '$gender', nationality = '$nationality', permanent_residence = '$permanent_residence', email = '$email' ,alt_email = '$alt_email', handphone_country_code = '$handphone_country_code', handphone_no = '$handphone_no', tel_area_code = '$tel_area_code', tel_no = '$tel_no', address1 = '$address1', address2 = '$address2', postcode = '$postcode', country_id = '$country_id', state = '$state', city = '$city', msn_id = '$msn_id', yahoo_id = '$yahoo_id', icq_id = '$icq_id', skype_id = '$skype_id', dateupdated = '$ATZ', home_working_environment = '$home_working_environment', internet_connection = '$internet_connection', isp = '$isp', computer_hardware = '$computer_hardware', headset_quality ='$headset_quality' WHERE userid =$userid;";

//echo $query;
$result=mysql_query($query);
if (!$result)
{
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
}
else
{
	header("location:subcon_myresume.php");
}






