<?php
include './conf/zend_smarty_conf.php';
include 'conf.php';
include 'config.php';
include 'function.php';
include 'class.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$userid="";
$code=$_REQUEST['code'];
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
$orig_pass=$_REQUEST['pass'];
$password=$_REQUEST['pass'];
$pass=sha1($_REQUEST['pass']);

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

$state = @$_REQUEST['state'];
$state2 = @$_REQUEST['state2'];
$location_code = @$_REQUEST['location_code'];

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

//$email=filterfield($email);
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

$pass2 = $_REQUEST['pass2'];
$passGen = new passGen(5);
$rv = $_REQUEST['rv'];

?>
<form method="POST" name="frmPersonalPhp" action="personal.php"  >            
    <input type="hidden" name="code" value="<?=$code?>" >
    <input type="hidden" name="pass" value="<?=$orig_pass?>" >
    <input type="hidden" name="fname" value="<?=$fname?>" >
    <input type="hidden" name="lname" value="<?=$lname?>" >
    <input type="hidden" name="bday" value="<?=$bday?>" >
    <input type="hidden" name="bmonth" value="<?=$bmonth?>" >
    <input type="hidden" name="byear" value="<?=$byear?>" >
    <input type="hidden" name="auth_no_type_id" value="<?=$auth_no_type_id?>" >
    <input type="hidden" name="msia_new_ic_no" value="<?=$msia_new_ic_no?>" >
    <input type="hidden" name="gender" value="<?=$gender?>" >
    <input type="hidden" name="nationality" value="<?=$nationality?>" >
    <input type="hidden" name="permanent_residence" value="<?=$permanent_residence?>" >
    <input type="hidden" name="email" value="<?=$email?>" >
    <input type="hidden" name="alt_email" value="<?=$alt_email?>" >
    <input type="hidden" name="handphone_country_code" value="<?=$handphone_country_code?>" >
    <input type="hidden" name="handphone_no" value="<?=$handphone_no?>" >
    <input type="hidden" name="tel_area_code" value="<?=$tel_area_code?>" >
    <input type="hidden" name="tel_no" value="<?=$tel_no?>" >
    <input type="hidden" name="address1" value="<?=$address1?>" >
    <input type="hidden" name="address2" value="<?=$address2?>" >
    <input type="hidden" name="postcode" value="<?=$postcode?>" >
    <input type="hidden" name="country_id" value="<?=$country_id?>" >
    <input type="hidden" name="msia_state_id" value="<?=$msia_state_id?>" >
    <input type="hidden" name="state" value="<?=$state?>" >
    <input type="hidden" name="state2" value="<?=$state2?>" >
    <input type="hidden" name="location_code" value="<?=$location_code?>" >
    <input type="hidden" name="city" value="<?=$city?>" >
    <input type="hidden" name="home_working_environment" value="<?=$home_working_environment?>" >
    <input type="hidden" name="internet_connection" value="<?=$internet_connection?>" >
    <input type="hidden" name="isp" value="<?=$isp?>" >
    <input type="hidden" name="computer_hardware" value="<?=$computer_hardware?>" >
    <input type="hidden" name="headset_quality" value="<?=$headset_quality?>" >
    <input type="hidden" name="msn_id" value="<?=$msn_id?>" >
    <input type="hidden" name="yahoo_id" value="<?=$yahoo_id?>" >
    <input type="hidden" name="icq_id" value="<?=$icq_id?>" >
    <input type="hidden" name="skype_id" value="<?=$skype_id?>" >
    <input type="hidden" name="pass2" value="<?=$pass2?>" >
    <input type="hidden" name="rv" value="<?=$rv?>" >
<?

//$sql = $db->select()
//exit;
$queryCheck="SELECT * FROM tb_temporary_email_account WHERE email='$email' AND code='$code';";
$result=mysql_query($queryCheck);
$ctr=@mysql_num_rows($result);
$row = mysql_fetch_assoc($result) ;
if($email == "")
{
    //header("location:personal.php?code=$code&mess=6&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
    echo '<input type="hidden" name="mess" value="6" >';
    echo '<script type="text/javascript">document.forms["frmPersonalPhp"].submit()</script>';
}
else
{    
    $transaction_status = true;
    if($ctr > 0)
    {
        if(isset($_REQUEST['send']))
        {
            if($passGen->verify($pass2, $rv))
            {
                //image validator is correct!
                $queryCheck="SELECT * FROM personal WHERE email = '$email';";
                $result=mysql_query($queryCheck);
                $ctr=@mysql_num_rows($result);
                if($ctr > 0)
                {
                    // email exist
                    //header("location:personal.php?mess=4&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
                    echo '<input type="hidden" name="mess" value="4" >';
                    echo '<script type="text/javascript">document.forms["frmPersonalPhp"].submit()</script>';
                }
                else
                {
                    $status = 1;  
                }
                
            }
            else 
            {
                $status = 2;
                //header("location:personal.php?mess=2&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv"); // image validator is not correct!
                echo '<input type="hidden" name="mess" value="2" >';
                echo '<script type="text/javascript">document.forms["frmPersonalPhp"].submit()</script>';
            }
        
            if($status == 1)
            {

                    $query="INSERT INTO personal (lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email,pass,
                    alt_email,handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id,
                    icq_id, skype_id, image, datecreated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality , registered_email) 
                    VALUES ('$lname', '$fname','$byear','$bmonth', '$bday', '$auth_no_type_id', '$msia_new_ic_no', '$gender', '$nationality', '$permanent_residence', '$email','$pass', '$alt_email', '$handphone_country_code', '$handphone_no', '$tel_area_code', '$tel_no', '$address1', '$address2', '$postcode', '$country_id', '$state', '$city', '$msn_id', '$yahoo_id', '$icq_id', '$skype_id', '$image', '$ATZ', 'New', '$home_working_environment', '$internet_connection', '$isp', '$computer_hardware', '$headset_quality' , '$email')";
                    $result=mysql_query($query);
                    
                    if (!$result)
                    {
                        $mess="- Error";
                        echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
                        $transaction_status = false;
                        //header("location:personal.php?mess=3");
                    }
                    else
                    {
                        $userid=mysql_insert_id(); 
                        $_SESSION['userid']=$userid;


						//START: set applicant default status
						$datetime = date("Y-m-d")." ".date("H:i:s");
						$sql = $db->select()
							->from('unprocessed_staff')
							->where('userid =?' , $userid);
						$result = $db->fetchRow($sql);
						$result	= $result['id'];
						if($result)
						{
							$data = array(
							//'admin_id' => 54,
							'date' => $datetime
							);
							$where = "userid = ".$userid;	
							$db->update('unprocessed_staff' , $data , $where);			
						}
						else
						{
							$data = array(
							'userid' => $userid,
							//'admin_id' => 54,
							'date' => $datetime
							);
							$db->insert('unprocessed_staff', $data);			
						}
						//ENDED: set applicant default status
						
						
                        include_once('lib/staff_files_manager.php');
                        $file_manager = new staff_files_manager($userid);                        


                        //START - upload photos
                        //$tmpName = $_FILES['img']['tmp_name']; 
                        //$img = $_FILES['img']['name'];
                        //$imgsize= $_FILES['img']['size'];
                        //$imgtype = $_FILES['img']['type'];                
                        //$upload_photo_result = $file_manager->add_photo($tmpName, $img, $imgsize, $imgtype);
                        //ENDED - upload photos
                        
                        
                        //START - upload voice file
                        //$tmpName = $_FILES['sound_file']['tmp_name']; 
                        //$sound = $_FILES['sound_file']['name']; 
                        //$soundsize= $_FILES['sound_file']['size']; 
                        //$soundtype = $_FILES['sound_file']['type'];
                        //$upload_voice_result = $file_manager->add_voice_file($tmpName, $sound, $soundsize, $soundtype);
                        //ENDED - upload voice file    
                        
                        
                        //START - upload resume file
                        $tmpName = $_FILES['resume_file']['tmp_name']; 
                        $resume = $_FILES['resume_file']['name']; 
                        $upload_resume_result = $file_manager->add_resume($tmpName, $resume);
                        //ENDED - upload resume file                            
                        

                        //if($upload_photo_result == false)
                        //{
                            //header("location:personal.php?code=$code&mess=6&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
                            //mysql_query("DELETE FROM personal WHERE userid = '$userid'");
                        //}
                        //elseif($upload_voice_result == false)
                        //{
                            //header("location:personal.php?code=$code&mess=7&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
                            //mysql_query("DELETE FROM personal WHERE userid = '$userid'");
                        //}
                        //elseif($upload_resume_result == false)
                        //{
                            //header("location:personal.php?code=$code&mess=8&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
                            //mysql_query("DELETE FROM personal WHERE userid = '$userid'");
                        //}
                        //else
                        //{
                            //echo "Data Inserted";
                            //header("location:education");
                            //
                            //$admin_email ="admin@remotestaff.com.au";
                            //$headers  = 'MIME-Version: 1.0' . "\r\n";
                            //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            //$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";    
                        
                            $body="<div align='center' style=' margin:10px; background-color: #FAFCEE; border: 1px solid #D8E899; text-align: left;  ; font: 12px tahoma; padding:20px;'>
                            <img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'>
                            <p>Hi $fname&nbsp;$lname,</p>
                            <p>Thank you for completing your online job profile. I would like to congratulate you for taking this first important step towards embracing <em>Global Employment &nbsp;Opportunities </em> and <em>expanding your career choices </em>. </p>
                            <p><a href=\"http://www.remotestaff.com.au/\">RemoteStaff.com.ph </a> and <a href=\"http://www.remotestaff.com.au/\">www.remotestaff.com.au </a> matches your professional skill set with an Australian/UK/US company or employer and lets you continue to do what you're best at while keeping relatively normal daytime work hours. &nbsp; We will assist and guide you to achieve the level of expectations your Australian/English/American employer has with doing the job – if you don't already have it to begin with! </p>
                            <p><strong>Countless Employment Opportunities Await </strong><strong>Filipino Professionals who have: </strong></p>
                            <ul>
                              <li>Confidence in Speaking and Understanding English </li>
                              <li>A Working Computer with Reliable Broadband Internet Connection </li>
                              <li>A Quiet and Private Room to Work From </li>
                              <li>Pride Commitment and loyalty for home-based work </li>
                              </ul>
                            <p>Within the last decade, hundreds of offshore offices have mushroomed in the Philippines , and it seems like the trend is going upward, what with it being the third largest English speaking country in the world! </p>
                            <p>Important things to remember about your online resume and application: </p>
                            <ol>
                              <li>Be as detailed as you can with describing the past role/post you have handled. This will help us identify if you are qualified for a specific position or not, it will speed up your application process. Also note that the recruitment team will prioritize those who have made an effort to communicate their work background. </li>
                              <li>Be as detailed and accurate as you are with filling out the resume form </li>
                              <li>Add your skill set and makes sure that everything is spelled correctly. We use keyword to search applicants who can be qualified for a specific opening. </li>
                              <li>Add a photo. How you look will obviously not affect our decision but it's always nice to know how the people we talk to looks like. </li>
                              <li>Add a voice recording indicating a quick summary of your work background and the position you are applying for. We only hire professionals who have functional English. You <strong>don't </strong> need to sound American with all the accents they require in BPOs in the Philippines . What is important is the ability to speak , communicate, listen and understand using the English language. </li>
                              <li>Attach sample work or portfolio. If you are applying for writing, design, development or any output based role, please attach your sample work. This will speed up your application process as we can clearly identify your ability, talent and sophistication. </li>
                            </ol>
                            <p>Our goal is to partner long term with our staff and to contract as much quality staff as we can. So feel free to talk about <a href=\"http://www.remotestaff.com.au/\">RemoteStaff.com.ph </a> / <a href=\"http://www.remotestaff.com.au/\">www.remotestaff.com.au </a>to your friends, relatives and former colleagues. Surely such a great opportunity is worth spreading around! </p>
                            <p>Kind Regards, </p>
                            <p></p>
                            <p>Cheers!<br><br>
                            <span style='color:#999999'><br />
                            <strong>Rica Gil</strong><br /><br />
                            General Manager, <br />
                            Think Innovations Pty Ltd <br />
                            Remote Staff Ltd. <br />
                            +612 90117706<br />
                            Email: Ricag@remotestaff.com.au  
                            </span></p>
                            </div>
                            <div align='center' style='font:10px tahoma; margin-top:0px;'> 
                                     <p class='footer-verd'><a href='http://www.remotestaff.com.ph/index.php'>Home</a> | <a href='http://www.remotestaff.com.ph/prosandcons.php'>Pros &amp; Cons</a> | <a href='http://www.remotestaff.com.ph/qualities.php'>Qualities Needed from You</a> | <a href='http://www.remotestaff.com.ph/howwework.php'>How We Work</a> | <a href='http://www.remotestaff.com.ph/testimonials.php'>Testimonials</a> | 
                                      <a href='http://www.remotestaff.com.ph/apply.php'>Apply Now</a> | <a href='http://www.remotestaff.com.ph/jobopenings.php'>Job Openings</a></p>
                                       <p class='footer-verd'>Copyright 2008 <a href='http://www.remotestaff.com.ph'>Remote Staff</a>, ACN 
                                      Number 094-364-511. All rights reserved. </p>
                            </div>
                            ";
                    
                            //mail($email,$subject, $body, $headers);
                            
                            $mail = new Zend_Mail();
                            $mail->setBodyHtml($body);
                            
                            $mail->setFrom('recruitment@remotestaff.com.au', 'REMOTESTAFF HR');
                            if(!TEST)
                            {
                                $subject="WELCOME TO REMOTESTAFF";
                                $mail->addTo($email, $fname." ".$lname);
                            }
                            else
                            {
                                $subject="TEST WELCOME TO REMOTESTAFF";
                                $mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
                            }
                            //$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil Macutay');
                            //$mail->addCc();// Adds a recipient to the mail with a "Cc" header
                            $mail->setSubject($subject);
                            $mail->send($transport);
                            
                            $queryCheck="DELETE FROM tb_temporary_email_account WHERE email = '$email' AND code='$code';";
                            $result=mysql_query($queryCheck);
							echo '
                            <script language="javascript">
								window.location = "education.php";
							</script>
							';
                            //header("location:education.php");
                        //}
                    }
            }
        }
        
    }
    else
    {
        //header("location:personal.php?code=$code&mess=5&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
        echo '<input type="hidden" name="mess" value="5" >';
        echo '<script type="text/javascript">document.forms["frmPersonalPhp"].submit()</script>';
    }
    if($transaction_status == false)
    {
        //header("location:personal.php?f=f&code=$code&mess=$mess&pass=$orig_pass&fname=$fname&lname=$lname&bday=$bday&bmonth=$bmonth&byear=$byear&auth_no_type_id=$auth_no_type_id&msia_new_ic_no=$msia_new_ic_no&gender=$gender&nationality=$nationality&permanent_residence=$permanent_residence&email=$email&alt_email=$alt_email&handphone_country_code=$handphone_country_code&handphone_no=$handphone_no&tel_area_code=$tel_area_code&tel_no=$tel_no&address1=$address1&address2=$address2&postcode=$postcode&country_id=$country_id&msia_state_id=$msia_state_id&state=$state&state2=$state2&location_code=$location_code&city=$city&home_working_environment=$home_working_environment&internet_connection=$internet_connection&isp=$isp&computer_hardware=$computer_hardware&headset_quality=$headset_quality&msn_id=$msn_id&yahoo_id=$yahoo_id&icq_id=$icq_id&skype_id=$skype_id&pass2=$pass2&rv=$rv");
        echo '<input type="hidden" name="f" value="f" ><input type="hidden" name="mess" value="$mess" >';
        echo '<script type="text/javascript">document.forms["frmPersonalPhp"].submit()</script>';
    }
}
?>
</form>
