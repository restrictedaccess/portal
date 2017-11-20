<?

include 'config.php';
include 'function.php';
include 'conf.php';
include('AgentCurlMailSender.php');


$agent_no = $_REQUEST['agent_no'];
$booking_code=$_REQUEST['tracking_no'];
$subject=$_REQUEST['subject'];
$emails=$_REQUEST['emails'];
//echo $emails;
$lead_email=split(",",$emails);
$mess =$_REQUEST['message'];
$mess =str_replace("\n","<br>",$mess);

$templates=$_REQUEST['templates'];
$address=$_REQUEST['address'];
$phone=$_REQUEST['phone'];
$abn=$_REQUEST['abn'];

if($subject=="")
{
	$subject="Message from RemoteStaff";
}

if($booking_code!="")
{
	$txt="<a href='http://www.remotestaff.com.au/$booking_code' target='_blank'>http://www.remotestaff.com.au/$booking_code</a>";
}

//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2
		$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
		//echo $query."<br>";
		$result=mysql_query($query);
		$ctr=@mysql_num_rows($result);
		if ($ctr >0 )
		{
			$row = mysql_fetch_array ($result); 
			$name = $row['fname']." ".$row['lname'];
			$agent_email=$row['email'];
			$agent_address =$row['agent_address'];
			$agent_contact =$row['agent_contact'];
			$agent_code =$row['agent_code'];
			$agent_abn =$row['agent_abn'];
			$email2 =$row['email2'];
			
			if($email2!="")
			{
				$agent_email = $email2;
			}
		}

if($booking_code=="")
{
	$txt="<a href='http://www.remotestaff.com.au/$agent_code' target='_blank'>http://www.remotestaff.com.au/$agent_code</a>";
}

for ($i=0; $i<count($lead_email);$i++)
{
	//echo $lead_email[$i]."<br>";
	//echo $message;
	$sqlGetLeadName="SELECT * FROM leads WHERE email ='". $lead_email[$i]."';";
	$res=mysql_query($sqlGetLeadName);
	$rows=mysql_fetch_array($res);
	$lead_fullname=$rows['fname']." ".$rows['lname'];
	$hi="<p>Hi ".$lead_fullname.",</p>";
	//echo $hi.$mess."<br>";
	if($templates=="promotional_small")
	{
	$message="<div style='margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px; '>
			  <p><img src='http://www.remotestaff.com.au/portal/images/banner/remoteStaff-small.jpg'></p>
			  ".$hi."
			  <p class='message' align='justify'>".$mess."<br></p>
			  <h5>".$txt."</h5>
			  </div>
			  <div style='background: url(http://www.remotestaff.com.au/portal/images/banner/remote.jpg);  margin-left:10px; margin-right:5px;'>&nbsp;</div>
			  <div style='margin-left:10px; margin-top:5px; font: 12px tahoma; color:#999999; width:800px;' >
				Address : ".$agent_address."<br>  
				Contact No : ".$agent_contact."<br>
				Email : ".$agent_email."<br />
				</div>";
	}
if($templates=="promotional")
{
	$message="<html>
<head>
	<title>Remote Staff - Outsourcing Online Staff From The Philippines</title>
<style>
<!--
body {
	
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 20px;
	color: #000000;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.left-margin-form {
	padding-left: 60px;
}
.right-margin-form {
	padding-right: 35px;
}
.left-right-margin {
	padding-right: 30px;
	padding-left: 28px;
}
.left-margin-tables {
	padding-left: 0px;
	padding-right: 35px;
}
.right-margin-tables {
	padding-left: 0px;
	padding-right: 35px;
}
.left-margin-bullets {
	padding-left: 2px;
}
.right-margin-bullets {
	padding-right: 2px;
}
.head1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	line-height: 20px;
	font-weight: bold;
	color: #0066cc;
	line-height: 24px;
}
.head2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	line-height: 20px;
	font-weight: bold;
	color: #0066cc; 
}
.title {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 30px;
	line-height: 36px;
	font-weight: bold;
	color: #0066cc; 
}
.speaker-name {
	font-size: 14px;
	font-weight: bold;
	color: #993516;
}
.speaker-lineup_txt {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 18px;
	color: #999999;
	padding-left: 7%;
	padding-right: 7%;
}
.copyright_txt {
	font-size: 11px;
	color: #999999;
}
.secure-your-seat-txts {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 20px;
}
.table-img {
	background-image: url(images/left_imgbg.jpg);
	background-repeat: repeat-y;
	height: 1534px;
}

.button {
    border: 1px solid  #006;
    background:#0066FF
	font-family:Tahoma, Verdana;
	font-size:18px;
	color:#FFFFFF;
	
	
}
.button:hover {
    border: 1px solid #f00;
    background: #eef;
	color:#000000;
}

.inquiry {
	border: 1px solid #444;
}

/**************************************/
#theform
{
line-height: 1.2em;
color: #444;
width: 600px;
margin: 0 0 0 30px;

}

#theform fieldset
{
background:#FFF;
border: 1px dashed #AAA;
}

#theform legend
{
background:#0099FF;
border: 2px solid #CCC;
padding-top: 2px;
padding-bottom: 2px;
padding-left: 15px;
padding-right: 15px;
margin-left: 25px;
font-weight: bold;
font-size: 16px;
color:#FFFFFF;

}

#theform p
{
margin-bottom: 4px;
margin-top: 4px;
}


#theform label
{
display: block;
width: 300px;
float: left;
text-align:right;
padding-right: 10px;
font-size:12px;

}

#theform p span em
{
display: block;
width: 120px;
float: left;
text-align: right;
padding-right: 10px;
font-style: normal;
}

#theform p span input
{
vertical-align: middle;
border: none;
background: none;
}

#theform strong
{
margin-left: 150px;
}

#theform strong input
{
background: #0066FF;
border: 1px solid #444;
font-weight: bold;
color: #FFFFFF;
margin-top: 10px;
}
.message{margin-left:10px; margin-right:5px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;border:#FFFFFF solid 1px; background:#FFFFFF; width:100%;}

-->
</style>	
</head>
<body  >
".$hi."
<p class='message'>".$mess."<br></p><br />
<div style='margin-left:10px; margin-top:5px; color:#999999'>
Address : ".$agent_address."<br>  
Contact No : ".$agent_contact."<br>
Email : ".$agent_email."<br />
</div>
<div align='center' >
  <table width='776' border='0' cellpadding='0' cellspacing='0' bordercolor='#000000'  style='margin:0;padding:0; border:#33CC00 outset 3px; '>
<tr><td width='770'>
<table width='770' border='0' align='center' cellpadding='0' cellspacing='0'  style='margin:0;padding:0;' >
  <tr><td valign='top' align='center'>

  <table width='760' height='100' border='0' cellpadding='0' cellspacing='0'  bgcolor='#FFFFFF' style='margin-top:5px;' >
 
  <tr>
    <td><table width='760' border='0' align='center' cellpadding='0' cellspacing='0' >
      
        <tr><td ><img src='http://www.remotestaff.com.au/images/logoSM.jpg' alt='' width='761' height='68' hspace='0' vspace='0' border='0' align='top'></td>
      </tr>
	  <tr><td>
	  <a href='http://www.remotestaff.com.au/$booking_code' target='_blank'>
	  <img src='http://www.remotestaff.com.au/images/img_headaussie.jpg' alt='' width='761' height='246' hspace='0' vspace='0' border='0' align='top'>
	  </a>
	  </td></tr>
    </table></td>
  </tr>
 
</table>
        </td>
</tr></table>
<table width='760' height='244' border='0' align='center' cellpadding='10' cellspacing='2' bgcolor='#FFFFFF'>

  <tr>
  
   <td valign='top' class='left-right-margin' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><div align='center' class='title'>Try our affordable remote staff solutions, <br>full time from $800 to $1,400 per month <br>depending on skill levels.</div>
   <br><br>
Dear Australian Employers,
<br><br>
What a brave new world we operate in, thanks to Globalisation. We now live in a boundary-less marketplace where global competitors are not going to take over your business quite yet but you better start getting ready. Don’t think in terms of your business survival, think in terms of what globalisation advantages are now available to your business that were not available only a few years ago.
<br><br>
Remote staff is able to deliver skilled, English speaking staff, working Australian time zones in many employment areas at a cost of only 20% of normal Australian salaries.
<br><br>
<div align='left' class='title'>Why Outsourcing Is Good For You</div>
WE WILL HELP YOU IMPROVE WHAT YOU ALREADY SELL AND HOW YOU DO BUSINESS
<hr align='left' width='700' size='1' color='#B8CF5C'>
<br>
<div align='left' class='head1'>If you only see outsourcing staff as a cost cutting exercise, you’re missing the point in what your business can really gain from globalisation.</div>
<br>
What will you do with your business if you were able to add more staff without it being a cash flow burden? What type of improvements would you be able to see in the areas of cost, quality, production and service? Simply put, Remote Staff will help you improve what you already sell and how you do business.
<br><br>
<div align='left' class='head1'>Example:<br></div>
</td>
		  </tr>
			<tr>
			<td align='center'>
				<table align='center' cellspacing='2' cellpadding='2' border='0' width='700'>
<tr>
	<td valign='top' bgcolor='#F4FCD3' width='350'>
		<table cellspacing='0' cellpadding='0' border='0'>
		<tr >
			<td bgcolor='#F4FCD3' valign='top' width='31' class='left-margin-bullets'><br><img src='http://www.remotestaff.com.au/images/icon1.gif' alt='' width='31' height='31' hspace='10' vspace='0' border='0' align='left'></td>
			<td bgcolor='#F4FCD3' width='330' class='left-margin-tables' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><br>Your receptionist can’t answer all the incoming calls. You have implemented best receptionist practice and installed a phone system to save time but still, 30% of calls are left unanswered. You can’t justify adding another Australian receptionist at a cost of $800 a week, but adding a Remote Staff receptionist working 50 hours a week at a cost of only $800 per month makes it possible. Would your business’ ability to answer incoming calls improve?<br><br></td>
		</tr>
		</table>
	</td>
	<td valign='top' bgcolor='#F4FCD3' width='350'>
		<table cellspacing='0' cellpadding='0' border='0'>
		<tr bgcolor='#F4FCD3'>
			<td bgcolor='#F4FCD3' valign='top' width='31' class='right-margin-bullets'><br><img src='http://www.remotestaff.com.au/images/icon2.gif' alt='' width='31' height='31' hspace='10' vspace='0' border='0' align='left'></td>
			<td bgcolor='#F4FCD3' width='330' class='right-margin-tables' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><br>Maybe your sales staff are losing time dealing with leads that may not be qualified and because of that your staff are not getting through the leads fast enough. For $800 a month Remote Staff sales representative will be able to filter out and qualify leads so your in-house sales staff only deal with closing leads. Would that improve sales conversions?<br><br></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td valign='top' bgcolor='#F4FCD3' width='350'>
		<table cellspacing='0' cellpadding='0' border='0'>
		<tr bgcolor='#F4FCD3'>
			<td bgcolor='#F4FCD3' valign='top' width='31' class='left-margin-bullets'><br><img src='http://www.remotestaff.com.au/images/icon3.gif' alt='' width='31' height='31' hspace='10' vspace='0' border='0' align='left'></td>
			<td bgcolor='#F4FCD3' width='330' class='left-margin-tables' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><br>Your web developer/administrator might not be able to handle your business workload. Employing another Australian web developer at $80,000 per year might not be possible, so your business has to make do with what ever work can be done with just one web developer. Imagine adding another web developer at $15,000 for the year, can you see how new abilities and capacities open up for your business?<br></td>
		</tr>
		</table>
	</td>
	<td valign='top' bgcolor='#F4FCD3' width='350'>
		<table cellspacing='0' cellpadding='0' border='0'>
		<tr bgcolor='#F4FCD3'>
			<td bgcolor='#F4FCD3' valign='top' width='31' class='right-margin-bullets'><br><img src='http://www.remotestaff.com.au/images/icon4.gif' alt='' width='31' height='31' hspace='10' vspace='0' border='0' align='left'></td>
			<td bgcolor='#F4FCD3' width='330' class='right-margin-tables' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><br>You might be considering developing a new project like publishing your own magazine. You may have gotten quotes from advertising agencies and media agencies to put the magazine together at a cost of $250,000 per addition. You might not have the time to bother putting your own magazine team together, but what if a remote office with a team of 5 staff and all equipment is put together for you at a cost of only $10,000 per month. Would that magazine idea be a reality for you now to progress with?<br><br></td>
		</tr>
		</table>
	</td>
</tr>
</table>
			</td>
			</tr>
			<tr>
				<td valign='top' class='left-right-margin' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><br>These are just a few examples where new productivity in your business can be achieved. Remote Staff is not<br> an outsourcing service provider to take jobs away from Australia staff, it’s about adding new productivity and capabilities <br>for your business that may not have been possible to achieve by employing more staff in Australia. Remote Staff often establishes more new work opportunities rather then taking jobs away.
<br><br>
With Australian staff shortage, Remote Staff Outsourcing solutions offer to be a competitive and viable solution to most<br> Australian small to medium companies. Making it easy to get a return on your investment.
<br><br>
<div align='left' class='title'>Two major trends happening <br>within the employment industry</div>
<hr align='left' width='700' size='1' color='#B8CF5C'>
<br></td>
			</tr>
			<tr>
				<td><table border='0' width='680' align='center'>
				<tr><td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/icon1.gif' alt='' width='31' height='31' hspace='10' vspace='0' border='0' align='left'></td>
				<td width='332' class='left-margin-tables' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>12% of professional employees in Australia since 2001 have been leaving the office to work from home. Technology is only increasing this trend to work from home.</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/icon2.gif' alt='' width='31' height='31' hspace='10' vspace='0' border='0' align='left'></td>
				<td width='332' class='left-right-margin-bullets' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Outsourcing staff from overseas will reduce employment salary cost and help your business increase its capacities and productivity.</td>
				</tr></table>
			</td></tr>
			<tr>
			<td height='15'></td>
			</tr>
			<tr>
			<td valign='top' class='left-right-margin' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><div align='left' class='title'>Offshoring Staff From The Philippines</div>WILL FREE YOUR BUSINESS FROM TIME CONSUMING WORK LOADS AND HELP YOUR IN-HOUSE <br>STAFF FOCUS MORE IN CORE BUSINESS COMPETENCIES.
<hr align='left' width='700' size='1' color='#B8CF5C'>
<br><div align='left' class='head1'>Below is a list of advantages:</div>
</td>
			</tr>
			<tr>
			<td height='15'></td>
			</tr>
			<tr>
			<td class='left-right-margin'>
				<table border='0'>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>One of the most cost effective human capital countries in the world, the Philippines offers labour salaries reductions as low as 80% when comparing to Australian staff. 15% of Philippines job seekers are employed by foreign companies, many quality staff contracted are used to working with American and Australian large corporate employers such as Citibank and Optus. </td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>The Philippines has been influenced by the Spanish with their Catholic beliefs, ethics and values. After the Spanish influence, the Americans had over the Philippines for some time and implemented the American education system. You will find many Remote Staff from the Philippines well adjusted to western cultures, degree educated and eager to learn.</td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>English along with Filipino is co-official language used in the Philippines. English is used in trade, commerce and politics, even the laws are written in English. A Remote Staff from the Philippines is 200% more easily understood by an Australian then an Indian Remote worker.</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Time zone difference between the Philippines and Australia is only 2 to 3 hours.</td>
				</tr>
				</table>
			</td>
			</tr>
			<tr>
			<td height='15'></td>
			</tr>
			<tr>
			<td valign='top' class='left-right-margin' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><div align='left' class='title'>Manageable Disadvantages</div>YOUR BUSINESS IS NEVER PERFECT. NO MATTER WHAT WAY YOU LOOK AT YOUR <br>BUSINESS IT COMPRISES OF HUMAN BEINGS AND WITH HUMAN BEINGS COMES ERROR.
<hr align='left' width='700' size='1' color='#B8CF5C'>
<br><div align='left' class='head1'>Be aware, not scared of outsourcing challenges so you can identify and eliminate them</div>
<br>Below is a list of 7 challenges you may encounter:
</td>
			</tr>
			<tr>
			<td height='15'></td>

			</tr>
			<tr>
			<td class='left-right-margin'>
				<table border='0' width='100%'>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td width='332' class='left-right-margin-bullets' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Language barrier may be more to do with accent then English speaking abilities. If you encounter these challenges, try to communicate using instructions to eliminate accent problems to facilitate the working relationship. </td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Having staff working from home may in some way drop productivity levels because the staff may not be independent enough to take responsibility for the work. But in many ways it also increases productivity because remote staff are sub-contracted at 50 hours a week so as to secure productivity standards.</td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Filipinos can easily understand instructions. It is therefore suggested that you instruct them to deliver a specific result at a specific time frame. There should be a deadline in every project you ask them to do. Also, level each project or task according to their importance. This will eliminate micromanaging them.</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>You can manage a remote team as if they were locally in your office, but training sometimes can be more difficult when you need to have them experience your product or service. Often, if you use Camtasia to record your voice and laptop screen, you can eliminate this challenge in most cases. </td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>When it comes to quality of work, it’s difficult to generalize but we found it depends on the person we hire. Sometimes, even identifying the right applicant will not protect you from this until he or she starts working for you. To protect you from this concern Remote Staff offers a second candidate on standby.</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Infrastructure issues such as power or internet connections going down for a few hours, in some cases even days. This is the unfortunate bit about 3rd world countries.</td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>As much as the Philippines might be well adjusted to western cultures, cultural differences still show up in little ways with remote staff sometimes calling you Sir or Ma’am.</td>
				<td valign='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'></td>
				</tr>
				</table>
			</td>
			</tr>
			<tr>
			<td height='15'></td>
			</tr>
			<tr>
			<td valign='top' class='left-right-margin' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><div align='left' class='title'>Technology Is Increasing Demand</div>THANKS TO TECHNOLOGY AND EMPLOYMENT, WHERE YOUR STAFF WORK FROM <br>MAKES A LITTLE DIFFERENCE.
<hr align='left' width='700' size='1' color='#B8CF5C'>
<br>Most office responsibilities can be preformed remotely without staff presence needed, saving you office space and overhead costs. Voip (Voice Over Internet Protocol) offers overseas remote staff with an Australian phone number. With a $20 Voip plan your sub-contractors can make local and national Australia wide calls for free and only pay $0.22c per minute for mobile phone calls. At this rate, why would you have a call centre or customer support staff in Australia?  On top of the Voip Australian Phones we also use Skype, a free instant online communications tool to keep in touch with our remote staff.
<br><br>
The listed challenges above are minor and really are very manageable. The biggest challenge Australian employers face in employing remote staff is trust. Will these remote workers actually be working? Will they be capable of doing a good quality job? Will your Australian team accept working with them? These are the issues RemoteStaff.com.au has addressed for you. We understand trust is created through personal relationships and through systems that can bring about effective collaboration between remote staff and multiple Australian Clients. 
</td>
			</tr>
			<tr>
			<td height='15'></td>
			</tr>
			<tr>
			<td valign='top' class='left-right-margin' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'><div align='left' class='title'>What RemoteStaff.com.au has to offer</div>WE WILL HELP YOUR BUSINESS DEPLOY BETTER BUSINESS PROCESSES SO YOU ACHIEVE <br>A LEVEL OF COLLABORATION AND WORK EFFICIENCIES WITH YOUR REMOTE TEAM.
<hr align='left' width='700' size='1' color='#B8CF5C'><br>
<div align='left' class='head1'>We specialize in telemarketers, receptionist, personal assistants, marketing assistants, graphic designers, call centre teams, copy writers, customer support, telemarketers, data entry, IT staff such as web designers, web developers, web administrators, sales consultants, SEO specialists, technical support, link builders and many other job positions.</div>
<br>RemoteStaff.com.au has experience working with staff from the Philippines. Below is a list of what we can do for you:
<br>
</td>
			</tr>
			<tr>
			<td height='15'></td>
			</tr>
			<tr>
			<td class='left-right-margin'>
				<table border='0' width='100%'>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td width='332' class='left-right-margin-bullets' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Setting you and your remote staff with a free basic online management tool that will enable more individuals in your organisation to collaborate with your remote staff;</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td width='332' class='left-right-margin-bullets' valign='top' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Only the monthly phone bill will be your added cost;</td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Our remote staff are trained to understand the value of instant communication disciplines. All remote staff use instant massaging services from Skype and understand they need to be online during working hours at all times, allowing them to work faster and more efficiently with you;</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Don’t worry about Payroll, taxes, health benefits, supper and any other compliance issues between Philippines & Australia, all is taken care of for you;</td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>We recruit your remote staff within 2 weeks on average and for as little as $550 inc GST. This once off fee per staff member includes advertising the job position with the Philippines, prepare job position descriptions; develop recruitment strategy in consultation with you, pre-screen applicants, interview applicants over the phone and short list those that meet your skill level needs;</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'><br><br><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Soft Phone technology allocated per remote staff and Skype accounts set up and ready;<br><br>Unlike other outsourcing companies, Remote Staff has little paperwork and management procedures, making it easy to work with your subcontractors;</td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Applicants contracted are tested for their English speaking abilities, check if they have fast working internet connection, working hard wear equipment and suitable home working environment;</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>Only one month minimum sub-contract agreement needed to get things started;<!-- Unlike other outsourcing companies, Remote Staff has little paperwork and management procedures, making it easy to work with your subcontractors; --></td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>We appoint manager to overlook your sub contractor work punctuality, employer/employee relations issues and to monitor remote employer behaviour to assure quality;</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>No need to take care of any overhead cost unless we put a remote team working together from the one office we set up for you;<!-- Only one month minimum sub-contract agreement needed to get things started; --></td>
				</tr>
				<tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				<tr>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>We do monthly evaluation to measure performances against standards and key performance indicators you have may in place;</td>
				<td valign='top' width='31' class='left-margin-bullets'><img src='http://www.remotestaff.com.au/images/bullet.jpg' alt='' width='31' height='32' hspace='0' vspace='0' border='0' align='top'></td>
				<td valign='top' width='332' class='left-right-margin-bullets' style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>One month guarantee, no other recruitment company will ever offer you 30 days staff replacement and exit policy. If your not happy with the staff  member we gave you, you can have them replaced with a second candidate for free.<!--No need to take care of any overhead cost unless we put a remote team working together from the one office we set up for you; Only the monthly phone bill will be your added cost; --></td>
				</tr>
				<td height='15'></td>
				<td height='15'></td>
				</tr>
				</table>
				<div align='center' class='title'>Send us an email and a customer support representative will call you back within 4 hours<!-- Complete our Online Enquiry Form and have a customer support representative immediately respond within 15 minutes to your enquiry --></div>
				<br>
				<div style='font-family:Arial;font-size:12px;line-height:20px;color:#000000'>
Once you have adjusted to the setup, you will be surprised at how easy it is to work with a remote team. Our managing director and his fellow business-friends are Australians that have first hand experiecne in doing business in Australian and the Philippines.They manage 4 large IT and Call Center companies in the Philippines while running a 100-staff packing and assembly factory in Melbourne as well as a marketing agency in Sydney.
<br><br>
With such experience in dealing business in both countries, you can feel confident in furthering your business using a remote team. Try us now. 
 <h2>$txt</h2>
 </div>
			</td>
			</tr>
			<tr>
			<td colspan='3' valign='top'>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
		<tr>
		<td height='7'></td>
		</tr>
		
</tr></table>
</div>
</html>";
}
	//echo $message."<br>";		
	//$curl_mail_sender = new AgentCurlMailSender();
    //$curl_mail_sender->SendMail($lead_email[$i], $subject, $agent_email, $message);
	////////////////// FILE ATTACHEMENTS /////////////////
$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers = "From: ".$agent_email." \r\n"."Reply-To: ".$agent_email."\r\n";
$headers .= "MIME-Version: 1.0\r\n" ."Content-Type: multipart/mixed;\r\n" ." boundary=\"{$mime_boundary}\"";
$message = "This is a multi-part message in MIME format.\n\n" .
		  "--{$mime_boundary}\n" .
		  "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
		  "Content-Transfer-Encoding: 7bit\n\n" .
$message . "\n\n";

///////////////////////////////////////////////////////
		   foreach($_FILES as $userfile){
	      // store the file information to variables for easier access
      $tmp_name = $userfile['tmp_name'];
      $type = $userfile['type'];
      $name = $userfile['name'];
      $size = $userfile['size'];
      // if the upload succeded, the file will exist
      if (file_exists($tmp_name)){
         // check to make sure that it is an uploaded file and not a system file
         if(is_uploaded_file($tmp_name)){
            // open the file for a binary read
            $file = fopen($tmp_name,'rb');
            // read the file content into a variable
            $data = fread($file,filesize($tmp_name));
            // close the file
            fclose($file);
            // now we encode it and split it into acceptable length lines
            $data = chunk_split(base64_encode($data));
         }
        // now we'll insert a boundary to indicate we're starting the attachment
         // we have to specify the content type, file name, and disposition as
         // an attachment, then add the file content.
         // NOTE: we don't set another boundary to indicate that the end of the 
         // file has been reached here. we only want one boundary between each file
         // we'll add the final one after the loop finishes.
         $message .= "--{$mime_boundary}\n" .
            "Content-Type: {$type};\n" .
            " name=\"{$name}\"\n" .
            "Content-Disposition: attachment;\n" .
            " filename=\"{$fileatt_name}\"\n" .
            "Content-Transfer-Encoding: base64\n\n" .
         $data . "\n\n";
      }

   }

   // here's our closing mime boundary that indicates the last of the message
   $message.="--{$mime_boundary}--\n";
   // now we just send the message
/////////////////////////////////////////////////////		
        $curl_mail_sender = new AgentCurlMailSender();
        $result = $curl_mail_sender->SendMailWithHeaders($lead_email[$i], $subject, $message, $headers);
	//echo "Send to : ".$lead_email[$i]."<br>";
}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//echo $agent_no."<br>";
//echo $tracking_no."<br>";
//echo $emails."<br>";


//$curl_mail_sender = new AgentCurlMailSender();
//$curl_mail_sender->SendMail($emails, $subject, $agent_email, $message);
/*
for ($i=0; $i<count($lead_email);$i++)
{
	//echo $lead_email[$i]."<br>";
	//echo $message;
	$sqlGetLeadName="SELECT * FROM leads WHERE email ='". $lead_email[$i]."';";
	$res=mysql_query($sqlGetLeadName);
	$rows=mysql_fetch_array($res);
	$lead_fullname=$rows['fname']." ".$rows['lname'];
	$hi="<p>Hi ".$lead_fullname.",</p>";
	
}
//echo $message;
*/
header("location:sendAds.php?mess=2");


?>
