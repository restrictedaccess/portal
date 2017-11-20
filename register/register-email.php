<?

$body="<div align='center' style=' margin:10px; background-color: #FAFCEE; border: 1px solid #D8E899; text-align: left;  ; font: 12px tahoma; padding:20px;'>
							<img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'>
							<p>Hi ".$_POST['fname']."&nbsp;".$_POST['lname'].",</p>
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
								$mail->addTo($_POST['email'], $_POST['fname']." ".$_POST['lname']);
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
?>