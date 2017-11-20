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
#paragraph h3 { text-align:center; margin-top:40px; margin-bottom:20px; color:#660000}
#paragraph h2 { color:#003366;}
#paragraph p{ text-align:justify; }
#paragraph ul{margin-bottom:10px; margin-top:10px; list-style:square;}
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
  <td  width="100%" valign="top" style="line-height:25px; padding:10px;">
  

  <h2 align="center">OPERATING MANUAL SYSTEMS</h2>
  <p align="center">
    <strong>Human Resource Policies and Guidelines</strong><br>
  <strong>I. RULES OF CONDUCT AND CODE OF  ETHICS</strong><br>
  </p>
  
    To assure uniformity  in the standards of conduct, RemoteStaff established the Rules of Conduct and  Code of Ethics. These rules shall govern all independent contractors of  RemoteStaff to avoid conflicts of interests, and to maintain the highest  standards of personal integrity among all contractors.<br>
    The Rules of Conduct  and Code of Ethics were developed to:</p>
  <ul type="square">
    <li>Strengthen, sustain and maintain the working relationship among       members of RemoteStaff and the clients they will be sub-contracted to;</li>
    <li>Maintain high standard of performance and productivity;</li>
    <li>Instil discipline among members;</li>
  </ul>
  <p><strong>A. BUSINESS  CONDUCT</strong></p>
  <ul type="square">
    <li>No contractor shall act for the RemoteStaff in any transaction       involving people or firms where he, his family or dependents have any       significant connection or financial interest</li>
    <li>No one shall take an opportunity that rightly belongs to       RemoteStaff or use the Company&rsquo;s name or his/her connection with the       Company for personal purposes.</li>
    <li>No one shall use any company asset, time, or property for personal       gain.</li>
    <li>No one shall disclose confidential information or any information       written on the contract to anyone outside the company and clients you are       sub contracted to. </li>
    <li>Staff member&rsquo;s working area MUST be quite and free from kids,       people , automobile and animal noises. </li>
  </ul>
  <p><strong>B. PERSONAL  CONDUCT</strong></p>
  <ul type="square">
    <li>Everybody shall conduct their personal finances in such a manner       that will avoid any unfavourable reflection on the Company because of his       behaviour. This applies particularly to the payment of debts and/or       settlement of obligations.</li>
    <li>Independent Contractors shall not borrow anything from the       company&rsquo;s customers or suppliers, except from banks or other institutions       that regularly lends money to individuals.</li>
    <li>No one shall become a director or official of a business neither       organized for profit nor accept other professional part time or freelance       jobs without the knowledge and written approval from the company.</li>
    <li>Employees are encouraged to participate in local civic and       charitable activities. Their participation, however, must not conflict       with their responsibilities to and the interest of the company.</li>
  </ul>
  <p align="center"><strong>II. TIMEKEEPING AND ATTENDANCE</strong><br>
      <strong>A. WORK HOURS  AND WORK SCHEDULE</strong></p>
  <ul type="square">
    <li>The regular work hour for all RemoteStaff members is eight (8)       hours a day and five (5) days a week for a total of 40 hours work week.       The shift is 9 hours with 1 hour lunch break. For part time staff members,       it&rsquo;s 4 hours either in the morning or afternoon. </li>
    <li>Everyone shall strictly observe their regular structured working       hours.</li>
    <li>Work schedule is from 9 AM to 6 PM US, AUS, CAN or UK time zone.       Wherever your client is. We follow the business hours of the client you       are working with. </li>
    <li>Changes in work schedule may be necessary and may be a result of       several causes such as: leave of absences, absenteeism, independent       contractors request, business requirements, and emergencies.</li>
    <li>During work hours, everyone is expected to be in their respective       work areas, and shall not spend an inconsiderable amount of time away from       their work areas unless otherwise it is for a valid reason. Since this is       work from home, a contractor must be able to respond to messages within       3-5 minutes. This is critical to maintain trust from RemoteStaff clients.       If a contractor loses internet connection, for whatever reason, he/she       must immediately call the Staff and Client&rsquo;s Relations Officer&nbsp; to inform of the matter.</li>
    <li>Independent Contractors must log into the screen shot system every       day and could only turn off the screen shot feature no more than two (2)       times per day and no more than ten (10) minutes at a time during his work       period. No need to turn off the screen shot system over lunch because when       you indicate your at lunch on the timesheet record, the system will       automatically stop any screen shot recordings from happening.</li>
  </ul>
  <p><strong>B. DAILY TIME  RECORD</strong></p>
  <ul type="square">
    <li>All Remote Staff contractors shall record their time entries. All       time entries are considered official and shall account for work       attendance. All staff members need to be logged in for the period of days       worked. Staff members shall record their lunch break periods and confirm       their presence online.</li>
    <li>If a contractor is unable to log in his time entry for any reason,       he must call the Staff and Client&rsquo;s Relations Officer&nbsp; immediately. </li>
  </ul>
  <ul type="square">
    <li>When a contractor fails to call the Staff and Client&rsquo;s Relations       Officer for whatever reason, he shall be considered&nbsp;<strong>&quot;AWOL&quot;</strong>&nbsp;for       the day. Three consecutive AWOL shall warrant a disciplinary action and       /or constitute grounds for termination of contract.</li>
  </ul>
  <p><strong>C.  MISDECLARATION OF TIME ENTRY</strong></p>
  <ul type="square">
    <li>Each staff must record his time entry through the RemoteStaff Daily       Time Record System and SKYPE when the system is not available. He must not       delegate anybody to do this for him nor shall he give in to anybody&rsquo;s       request to do the same.</li>
    <li>Unauthorized time entry of another contractor&rsquo;s attendance shall       constitute grounds for termination of contract.</li>
  </ul>
  <p><strong>D. ABSENCES</strong></p>
  <ul type="square">
    <li>An absentee contractor must inform or notify authorities of his       absence through email. If the absence is due to sickness, emergency, or       calamity, he must inform the Staff and Client&rsquo;s Relations Officer&nbsp; as soon as possible to avoid being AWOL.</li>
    <li>Vacation leaves must be filed at least two (2) days before the       actual date of leave.</li>
    <li>For emergency absence including but not limited to sickness,       natural disaster and death in the family, please inform the Staff and       Client&rsquo;s Relations Officer at least 2 hours before your start time. If       this cant be done, keep your communication line open. </li>
    <li>For absence due to sickness, a medical certificate is required if       staff member is absent for 3 consecutive days. </li>
  </ul>
  <p><strong>E. TARDINESS</strong></p>
  <ul type="square">
    <li>A contractor is considered tardy if he logs in for work past the       required starting time. If he reports for work past the required starting       time, he must inform the Staff and Client&rsquo;s Relations Officer the reason       of his tardiness as soon as possible.</li>
    <li>Tardiness is a minor offense. But a contractor is subject to       disciplinary action for habitual tardiness as this can affect your working       relationship with your client.</li>
  </ul>
  <p><strong>Disciplinary  measures shall apply for the following premises:</strong> </p>
  <ul type="square">
    <ul type="circle">
      <li>3 unexcused tardiness in a month </li>
      <li>6 excused tardiness in a month</li>
    </ul>
  </ul>
  <p>Moreover,  unreasonable tardiness of more than one (1) hour shall be subject to  disciplinary action unless it is for just cause.</p>
  <p><strong>F. OVERTIME</strong></p>
  <ul type="square">
    <li>Work performed in excess of the regular working hours, weekends,       holidays, and rest days shall be compensated accordingly.</li>
    <li>When an overtime work is required by a RemoteStaff client you may       be sub-contracted to, a contractor must file a written request for       overtime prior to overtime work and send the request through email to&nbsp;<a href="mailto:attendance@remotestaff.com.au">attendance@remotestaff.com.au</a> &nbsp;for approval of overtime work. Any unauthorized overtime shall not       be processed.</li>
    <li>The computation of overtime work is as follows:</li>
  </ul>
  <ul>
    <ul>
      <li>ORDINARY DAYS</li>
    </ul>
  </ul>
  <p><img src="images/arrow.gif">&nbsp;Your  base hourly rate</p>
  <ul>
    <ul>
      <li>Rest Day &amp;  Holidays</li>
    </ul>
  </ul>
  <p><img src="images/arrow.gif">&nbsp;Your  base hourly rate</p>
  <p><strong>G. UNDERTIME</strong></p>
  <ul type="square">
    <li>Nobody is allowed to log off prior to official quitting time. However,       should under time be unavoidable and necessary, it may be permitted upon       request of the contractor and approval of the Staff and Client&rsquo;s Relations       Officer . </li>
  </ul>
  <p align="center"><strong>III. COMPENSATION AND  PERFORMANCE MANAGEMENT</strong></p>
  <ul type="square">
    <li>Remote Staff shall pay all its contractors in a fair, just, and       equitable manner. Compensation is competitive in the industry, and is       based on established salary structure and sound salary administration       principle.</li>
    <li>Remote Staff compensates its independent contractors with a monthly       basic salary to be given every 1st day of the month. </li>
  </ul>
  <ul>
    <li>You will be paid for all the hours and days  worked for as long as you have worked at least 5 consecutive days on the first  month of your contract. </li>
  </ul>
  <ul type="square">
    <li>The computation for the monthly and daily rate is as follows:</li>
  </ul>
  <p>Monthly Rate * 12 Months = Annual Rate <br>
    Annual Rate/ 52 Weeks = Weekly Rate <br>
    Weekly Rate/5 Days = Daily Rate <br>
    Daily Rate/Number of regular hours in this AGREEMENT =  Hourly rate </p>
  <p>&nbsp;</p>
  <p><strong>PUBLIC  HOLIDAYS AND LONG WEEKENDS</strong><br>
    RemoteStaff is an  Australia-based company, which means that all RemoteStaff members shall observe  the following holidays:</p>
  <div align="center">

  
  	
    <table border="0" cellspacing="1" cellpadding="0" width="90%">
      <tr>
        <td width="17%"><br>
          1. New Year </td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>January 1</p></td>
      </tr>
      <tr>
        <td width="17%"><p>2. Australia Day</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>January 26</p></td>
      </tr>
      <tr>
        <td width="17%"><p>3. Christmas Day</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>December 25</p></td>
      </tr>
      <tr>
        <td width="17%"><p>4. Boxing Day</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>December 26</p></td>
      </tr>
      <tr>
        <td width="17%"><p>5. Anzac Day</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>April 25</p></td>
      </tr>
      <tr>
        <td width="17%"><p>6. Good Friday</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>&nbsp;</p></td>
      </tr>
      <tr>
        <td width="17%"><p>7. Easter Saturday</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>&nbsp;</p></td>
      </tr>
      <tr>
        <td width="17%"><p>8. Easter Sunday</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>&nbsp;</p></td>
      </tr>
      <tr>
        <td width="17%"><p>9. Queen&rsquo;s Birthday</p></td>
        <td width="1%"><p>-</p></td>
        <td width="82%"><p>1st &nbsp;Monday of June (in all States except in West    Australia where it is as proclaimed by the Governor)</p></td>
      </tr>
      <tr>
        <td width="17%" valign="top"><p>10. Labour Day</p></td>
        <td width="1%" valign="top"><p>-</p></td>
        <td width="82%" valign="top"><p>1st Monday of October (NSW/ACT/SA)<br>
          1st Monday of March (WA)&nbsp;<br>
          2nd Monday of March (TAS/VIC)&nbsp;<br>
          1st Monday of May (QLD/NT)</p></td>
      </tr>
    </table>
	</table>
  </div>
  <p><strong>LONG WEEKENDS</strong></p>
  <ul type="square">
    <li>When New Year, Australia Day, Christmas Day falls on a Saturday or       Sunday, the standard is for another day to be announced as a holiday in       substitution. This means that if a standard public holiday falls on a       weekend, a substitute public holiday will be observed on the first       non-weekend day of the following week, which is usually on a Monday.</li>
    <li>By common law, the Boxing Day is automatically observed on a Monday       or December 27 if December 26 falls on a Sunday. A substitute holiday is       only announced if Boxing Day falls on a Saturday.</li>
    <li>When Anzac Day falls on a Saturday, there is NO holiday on the       following Monday. But, if it falls on a Sunday, then there is a holiday on       a Monday.</li>
    <li>If a contractor is required to work on a public holiday, he should       be entitled to be paid.</li>
    <li>In addition, if a contractor is required to work on Easter Sunday,       which is also a rest day in itself, the contractor is still entitled to be       paid his or her regular day rate. </li>
  </ul>
  <p align="center"><strong>IV. COMPANY RULES AND  REGULATIONS</strong><br>
      <strong>A.  INTER-RELATIONS</strong></p>
  <ul type="square">
    <li>Disrespect, discourtesy, insult, or use of foul language (whether       verbal or written) towards any co-workers or officers shall not be       tolerated.</li>
    <li>Fighting, provoking fights, and inflicting or attempting to inflict       injuries to co-workers or other persons during work hours shall not be       tolerated.</li>
    <li>Any conduct that violates common decency and morality during work       hours shall not be tolerated.</li>
  </ul>
  <p><strong>B.  CONFIDENTIALITY OF RECORDS</strong></p>
  <ul type="square">
    <li>A contractor is prohibited from disclosing ANY information       regarding his salary or any information relating to his work or position       at RemoteStaff &nbsp;to anyone within       RemoteStaff or any of its clients or associates.</li>
  </ul>
  <p><strong>C.  MISCELLANEOUS</strong></p>
  <ul type="square">
    <li>Failure to carry out verbal or written work instruction or wilful       refusal to follow such instructions shall constitute grounds for       termination of contract.</li>
  </ul>
  <p><strong>D.  RESIGNATION </strong></p>
  <ul>
    <li>In case of resignation by the Contractor, a  written resignation letter should be submitted at least fifteen (15) business  days&nbsp;before the date of which this Agreement is to be terminated. If the  Contractor does not comply to this, a penalty of &#8369;50,000 is to be paid by the Contractor  to Remote Staff.</li>
  </ul>



  </td>
</tr>
</table>

  

</td>
</tr>
</table>

</body>
</html>
