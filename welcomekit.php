<?php
include 'config.php';
include 'conf.php';
include 'time.php';
$userid = $_SESSION['userid'];

$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['lname']."  ,".$row['fname'];
}

$site =  $_SERVER['HTTP_HOST'];

if($site == "www.remotestaff.com.au"){
	$company_desc = "Think Innovations Pty. Ltd. T/A RemoteStaff , an Australian company that has been in operation since Sept 2000. ";
	$employers= "Australian";
}
elseif($site == "www.remotestaff.co.uk"){
	$company_desc = " Remote Staff Limited . an UK Company. ";
	$employers= "UK";
}
else{
	$company_desc = "Think Innovations Pty. Ltd. T/A RemoteStaff , an Australian company that has been in operation since Sept 2000. ";
	$employers ="Australian";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Sub-contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">

<script language=javascript src="js/timer.js"></script>
<style type-"text/css">
@import url(scm_tab/scm_tab.css);
#paragraph{margin-bottom: 12px; border: 1px solid #abccdd; width: 900px; padding: 8px;}
#paragraph p{ text-align:justify; }
#paragraph ul{margin-bottom:10px; margin-top:10px; list-style:square ;}
#paragraph li{ padding-bottom:10px; padding-bottom:10px;}
#paragraph span{ text-decoration:underline; font-weight:bold; color:#003300; margin-bottom:1px; margin-top:5px;}
</style>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?>
</td>
<td width="1081" valign="top">
  <table width=100%  cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Sub-Contractor Starter Kit</b></td></tr>
<tr>
  <td  width="100%" height="248" valign="top">
  
<div style=" line-height:25px; padding:10px;">
  <p><strong>New Remote  Staff Contractors, Orientation Starter kit</strong><br>
    Welcome to Think  Innovations and Remote Staff!</p>
  <p>As a member of  RemoteStaff you agree to be contracted under <?php echo $company_desc;?>  Once contracted, Think Innovations will be sub-contracting you to <?php echo $employers;?>  clients so to provide you continuous work.<br>
    Think Innovations  trading as RemoteStaff is a company that serves as a bridge to connect  <?php echo $employers;?> employers and Filipino professionals working from home online. We  will set you up with all the internet tools you need to get work started, on  top of that, we will also give you an <?php echo $employers;?> phone number and a soft phone to  download onto your computer.<br>
    This welcome guide  will help you:</p>
  <ul type="square">
    <li>Create an understanding of remote staffing and working from home.</li>
    <li>Build a foundation of skills and competencies: customer service,       teamwork, leadership, and communication - in each contractor.</li>
    <li>Simplify and shorten the new contractor&rsquo;s learning curve so that       s/he becomes more efficient in performing tasks.</li>
    <li>Instil staff dedication and loyalty to Think Innovations.</li>
    <li>Increase staff retention by ensuring a better fit between contractor       expectations and Think Innovations culture.</li>
    <li>Promote awareness and commitment.</li>
  </ul>
  <p>Think Innovations  will provide with you with the right tools and help you develop adequate skills  to compete in the international workplace.<br>
      <strong>How does being  a <?php echo $site;?> contractor work?</strong><br>
    A legal contract has  been signed between you and RemoteStaff to secure your official commitment and  loyalty with RemoteStaff. Once RemoteStaff has contracted you, RemoteStaff will  attract <?php echo $employers;?> employers to sub-contract on your behalf.<br>
  <strong>What to expect  when you become a contractor with <?php echo $site;?></strong><br>
    Working from home is  a new and exciting work set up. Thanks to outsourcing, the Philippines has been  a main source of working professionals for the US, Australia and European  markets. This opportunity is not just for call center agents, but also for  other roles like receptionists, copy writers, accounting personnel, customer  service roles, marketing assistants, personal assistants, web designers, web  developers, graphic designer, web administrators and many other roles that  could be outsourced.<br><br>

    Australia is the  latest addition in the ever growing outsourcing business model.<br><br>

    For Filipinos who  want to maintain relatively normal day working hours, working for <?php echo $employers;?>  companies is preferred. <?php echo $employers;?> companies are catching up with outsourcing  jobs so more opportunities are opening up for the Filipino workers<br>
    Australia always  ranks among the top 20 happiest people in the world. Credit that to their  convenient lifestyle and high earning power. <?php echo $employers;?> companies often offer a  laidback and relaxed work environment to yield high productivity among their contractors.  They strictly follow working hours and maintain professional relationship.  Laidback doesn&rsquo;t mean that <?php echo $employers;?> companies are not competitive. They are,  only in a nice way.<br><br>

    The good thing about  working with <?php echo $employers;?> companies remotely is that, when they see that you have  the ability and potentials for more, they are quick to offer you a chance to  express your abilities and support your skill development in these areas. You  will find working for most <?php echo $employers;?> companies a refreshing and liberating  experience.<br>
    However, just like a  regular office job, there are pros and cons that go with working from home.<br>
  <strong>The pros of  working from offsite remote or home location</strong><br>
    Any work environment  whether in an actual office or home office has its advantages and  disadvantages. If you&rsquo;re craving for a relaxed and more flexible workplace, a  job that don&rsquo;t need you to leave your family or go work in big cities so to  earn the salary you deserve, working from home offers many advantages.<br>
  <strong><u>No need to commute to work in the midst of traffic rush hour and  pollution</u></strong> <br>
    Though  you need to wake up earlier than most (Australia is three hours ahead so you  need to be online around 6 AM or 7AM), you can easily manage by waking up 5  minutes before your working schedule. Just get online and you&rsquo;re officially  present for the day. It doesn&rsquo;t get any more convenient then that.<br>
  <strong><u>You&rsquo;re working in the most relaxed environment that you can ask for,  your home</u></strong> <br>
    Everything  is right in your home, no worries about forgetting something. No hassle of  interacting with an annoying co-worker. You are free to work in your pajamas if  you wanted to.<br>
  <strong><u>Less working stress, more comfortable work environment</u></strong> <br>
    You  don&rsquo;t need to always ask permission from the boss to do something. When a  result is expected from you, you utilize your own resources and abilities to  achieve it. You don&rsquo;t run around the office, asking your &ldquo;superiors&rdquo; questions  that have obvious answers. In short, you&rsquo;re the manager of yourself when it  comes to your work flow.<br>
  <strong><u>Working from home gives you flexibility and more lifestyle</u></strong> <br>
    Efficient  time and energy management can easily integrate more activities into your life  as well as your work giving you more room to do more work and play in your  life.<br>
  <strong><u>Save up to 20% of your income working from home</u></strong> <br>
    No  transportation expense, less meal expense, no need to set aside budget for  office clothing. It all boils down to saving a big part of your income.<br>
  <strong>The cons of  working from offsite or remote home locations</strong><br>
    If your line of work  requires you to interact more with your co-workers or clients, you will benefit  from a real office environment and working from home may not be to your  advantage. See the list of challenges you might face when working from home:<br>
  <strong><u>Cocooned at home spending hours just in front of the computer</u></strong> <br>
    Meeting  people face to face can bring about new ideas, improve social skills, inspire  and even develop fresh relationships. If you are the type who gets motivated  with face to face competition, home based job is not for you. But there are  many ways you could rejuvenate yourself after a long day working from home, one  way is to pop out of your house for a simple walk or a catch up with friends at  the end of each working day.<br>
  <strong><u>Working from home does take more self responsibility</u></strong> <br>
    Some  people that work from home become less productive while others increase their  productivity. This mainly depends on your own willingness to take ownership of  what you do in the work. Have open-mindedness to accept and embrace change when  working from home is one thing, you will quickly learn that the choices you  make and your ability to respond and solve problems becomes critical to you  keeping your job.<br>
  <strong><u>Television, kids, pets can make one lose focus on work and become  complacent</u></strong> <br>
    The  tendency to push back workload to the end of the day is highly probable and a  big risk when working form home if you don&rsquo;t have discipline. You will need to  take on inner discipline and learn to work with priorities. To sum up,  priorities on your TO DO LIST come first, not last at the end of each day.<br>
  <strong><u>Technology meltdown</u></strong> <br>
    Slow  internet connections, phone lines that drop, power interruption and computer  crashes can happen. Since home based work is almost always technology  dependent, no internet means no work.<br>
    Thanks  to globalization, career choices in the Philippines are far better now than a  few years back. There is no reason not to find satisfaction and fulfillment  from your home based work. It&rsquo;s proving to be a new source of employment for  many people living in the Philippines and offers new ways to broaden your  horizon and benefit from globalization.<br>
  <strong>What is  expected of you as a RemoteStaff.com.au contractor?</strong><br>
    Now that you have  decided to work from home and be a RemoteStaff.com.au contractor, there are  qualities and work ethics expected from you at all times while you&rsquo;re under  contract with us.<br>
    Our <?php echo $employers;?>  clients expect to be allotted the best staff to sub-contract and so RemoteStaff  is always seeking out applicants that possess most of the working qualities  listed below.<br>
  <strong><u>1. Self-Motivation</u></strong> <br>
    You  should be inspired and enthusiastic in doing and dealing with your work. You  should like what you&rsquo;re doing or have a deep reason why you are doing it.<br>
    You  can&rsquo;t be with remote staff if you&rsquo;re &quot;&nbsp;<em>in between  jobs&quot;</em>&nbsp;or waiting for decision from a company you applied for. This is a Full  time/Part time long term contract.<br>
  <strong><u>2. Can Handle Work Alone</u></strong> <br>
    You  should be able to manage yourself and your workload without needing a manager  behind you, pushing you to do something all the time. Once a task is delegated  to you, you should be able to use your resources and talents to deliver result.<br>
  <strong><u>3. Highly Developed Organizational Skills</u></strong> <br>
    Since  no one will be there to check on you every second, you have to be able to check  yourself. Check and list down all the tasks to be done, identify priorities and  make note of task that has already been finished.<br>
  <strong><u>4. Ability to Multi-Task</u></strong> <br>
    Often  you may find your self doing a number of things, your ability to stop and start  where you left off is vital.<br>
    You  have to finish all your task depending on their priority level.<br>
  <strong><u>5. Very Good Knowledge and Experience in General Software Used</u></strong> <br>
    Being  knowledgeable about a software is one thing, but we are looking for quick  learners that are not afraid to try and learn to use different software.<br>
    Sometimes  a Remote Staff will be required by the client to learn to use a new software or  system they&rsquo;re using. This is a really good opportunity for growth as this is  an added skill to add to your skill set.<br>
  <strong><u>6. Can Quickly Adapt to Changing Scenarios</u></strong> <br>
    You  should be able to adjust to new things. You should be the person who&rsquo;s open and  willing to accept change. Be aware that we cannot avoid change or encountering  new things wherever we are.<br>
    This  is very important as there is a possibility that you will work for different  clients all throughout your contract with Remote Staff.<br>
  <strong><u>7. Self Discipline</u></strong> <br>
    Working  from home can be distracting with friends and family members coming in and out  of the home. You need to manage your family and home during work hours. You  have to inform your friends that you work from home and that you can&rsquo;t accept  visitors during working hours.<br>
    It  is unacceptable for you to entertain guests while you are working. You should  be able to apply office/work ethics on Remote Staff working hours.<br>
  <strong><u>8. Ability to Make Independent Decisions</u></strong> <br>
    You  should be confident enough to accept ownership of your tasks and results. If a  decision is to be made, and you&rsquo;re capable of making that decision, then make  it, if not then be proactive and decide to contact the person who can make the  decision. Don&rsquo;t sit around and wait.<br>
  <strong><u>9. Ability to Troubleshoot/Solve Basic Problems and Answer Basic  Questions</u></strong> <br>
    Your  ability to search online and resourcefulness in identifying problems will  benefit you when it comes to solving problems.<br>
    Before  you ask someone any question, go online and see what you could find out about  the problem.<br>
  <strong><u>10. Ability to Learn Quickly and Apply What you Have Learned</u></strong> <br>
    It&rsquo;s  not about what you know it&rsquo;s more about how quickly you can learn and adapt  that will make the biggest difference in your job.<br>
    You&rsquo;ll  need to be open in learning new skill sets, programs and willing to absorb new  information needed to perform in your position efficiently and effectively.<br>
  <strong><u>11. Meet Deadlines and Work Well Under Pressure</u></strong> <br>
    Pressure  is inevitable; keeping a cool head in these times helps you and the team to  keep moving forward.<br>
    Avoid  the Blame Game for as soon as you start blaming other people or things going  wrong around you, you will find yourself slipping and affecting your time  management ability.<br>
    Keep  focus on priorities and you will do well. Work proactively on any given task.<br>
  <strong><u>12. Flexibility</u></strong> <br>
    You  should be a very flexible person as at the end of your contract to one client,  you can be subcontracted to a new one. You should be able to adjust to this  quick changes and willing to do so.<br>
    We are fully aware  that working from home is very different from working in a traditional work set  up, i.e., the office environment. Since you are expected to take full  responsibility for accomplishment of tasks, time management is therefore  essential and we would like to suggest the following:<br>
  <strong><u>1. Get Up &amp; Get Dressed on a Schedule</u></strong> <br>
    If  you develop a mindset that you have come to work on time and perform tasks  everyday, you feel more professional.<br>
  <strong><u>2. Keep a Routine</u></strong> <br>
    There  is a work schedule that you must follow. In this case, you are expected to work  from 6AM to 4PM, with one hour lunch break at 12pm to 1pm your time zone being  the only official lunch break. Manage your time well so you don&rsquo;t end up  watching TV or doing non work related things and cramming to finish your task  toward the end of the day.<br>
  <strong><u>3. Avoid having visitors on working hours.</u></strong> <br>
    Some  may consider inviting a friend or family member over at home when you are on  working time to chat as not much of a big deal. Now, picture yourself working  in an office and you invite a friend to chat with you during working hours.  Your employer would not let you do that because it will distract your focus  away from work. This same principle applies when you are working as a  contractor at home. Just because you are at home doesn&rsquo;t mean you are available  to do personal things or have friends over during working hours.<br>
  <strong><u>4. Setup a Particular Workspace</u></strong> <br>
    Whether  it&rsquo;s in another room, or just a corner, make sure you have a place to call  &quot;your privet office&quot;. Call it your privet office and refer to it as  your office. Inform everyone in the household that it is YOUR OFFICE and is  therefore off limits for them during office hours.<br>
  <strong><u>5. Inform your friends and family that though you&rsquo;re working from home,  it is a regular, fulltime job and not just a hobby</u></strong> <br>
    Some  people think that working from home is not a serious business. It is, only  you&rsquo;re located in the home. It is very important that people living with you  take your job seriously the way you take it seriously. You need to educate the  people living with you that working hours must be spent on work and not for  personal stuffs.<br>
  <strong><u>6. When you work from home, you are cocooned in your space at home and  spend hours just in front of the computer.</u></strong> <br>
    To  rejuvenate your self, call some friends and catch up after working hours every  weekday. You could also just go out and walk, this will take care of the  muscles that have stayed still for the whole day!<br>
  <strong><u>7. Keep a Daily Schedule</u></strong> <br>
    Make  sure every hour of your working day is marked down in a calendar and keep it  where you can see it often. It will keep you focused on what you should be  doing and what you shouldn't.<br>
  <strong><u>8. Make a habit of creating a TO DO LIST at the beginning of each day</u></strong> <br>
    and  checking what you have and have not done at the end of the day (our Google Docs  Workflow sheet is perfect for this).<br>
  <strong><u>9. Make sure your working environment  is free of noises (Dogs, children, people, chicken and Tri-cycles) </u></strong><br>
    Working  form home is a privilege we have but this is NOT an excuse to be unprofessional.  Though we all work from home, we work for serious businesses who values  professionalism. Having a very noisy work area can affect how your client sees  you (and thus your relationship) as well as your output and concentration.&nbsp; </p>
  <p><strong>&nbsp;</strong></p>
  <p><strong>Company Guidelines</strong></p>
  <ol>
    <li>You are expected to  work 40 hours a week, 8 hours a day. Mon-Fri from 6:00AM to 3:00PM or from  7:00AM to 4:00PM after DST (last Sunday of March until last Sunday of October).  Working hours of course may vary depending on workload and deadlines.</li>
  </ol>
  <p>For part time staff  members, you work 4 hours a day 5 days a week totalling to 20 hours a week. </p>
  <ol>
    <li>You are expected to  be logged in on Skype and Engin (soft phone system) and be available for  chat/phone calls anytime during office hours. If contact has been made, you  need to reply within 3 minutes to prove you&rsquo;re online. If in case you are on  the phone and could not immediately take a call or start a chat conversation,  it would be best that you send back a short message that you will get back to  the person immediately because we need to apply our 3-minute response time.</li>
    <li>Every contractor is  entitled to 1 hour lunch break and this lunch break needs to be between 11am  and 12nn Manila time unless requested otherwise. Since most of the remote  staffs are working as teams, it will be difficult to organize a meeting when  everyone is off at different lunch times. There are no other official breaks  aside from lunch break. Since you are working from home, you would be able to  zip up a coffee and have it in front of your computer whenever you want.</li>
    <li>We are to follow  <?php echo $employers;?> holidays on the respective State you work for, unless stated  otherwise by your client or RemoteStaff. If you need an extra day off, please  advise at least 3 days before the date of absence.</li>
    <li>You can take a day  off during&nbsp;<strong>OFFICIAL NATIONAL Philippine Holidays</strong>&nbsp;listed below.  Notice needs to be given to the Staff and Clients Relations Officer. </li>
    <ol>
      <li>Christmas Day :  December 25</li>
      <li>New Years Day :  January 1</li>
      <li>All Souls/Saints Day  : November 1 and 2</li>
    </ol>
    <li>We follow a no work,  no pay policy. You only get paid on days you worked on. If you take a day off  during working days, it will not be paid.</li>
    <li>Salary is sent  through bank transfer</li>
    <li>Each contractor  should create a tax invoice every end of the month using the Subcontractor  System.</li>
    <li>Company  reimbursements, like local phone bills and equipment costs, are given only  after submitting a scanned image of the official receipt/bill. All  reimbursements are subject to approval.</li>
  </ol>
  <p><strong>Message from  the Director</strong><br>
    We are all contracted to Think  Innovations but sub contracted to Think Innovations&rsquo; clients. What this means  is that you will be working in different companies on different teams that may  be in totally different industries. All of this doesn&rsquo;t matter because we are  all working together on the same team under Think Innovations.<br>
    We can all keep in touch with Skype and  improve our skills and abilities by benchmarking each other from fellow Think  Innovations colleges.<br>
    Also, if in anyway something doesn&rsquo;t  work out between you and the clients, it&rsquo;s in Think Innovations interested to  work it out for you and to keep you employed as long as we possibly can. We do  this by keeping both you as the contractor and the client happy and working  efficiently together.<br>
    All the best regards<br>
  <br>
  <strong>Chris Jankulovski</strong><br>
    Director of<br>
    Think Innovations Pty Ltd &amp;&nbsp;<br>
    Remote Staff</p>
  <h3><br>
</h3>
</div>
  </td>
</tr>
</table>

  

</td>
</tr>
</table>

</body>
</html>
