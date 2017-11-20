<?
include 'config.php';
$tracking_no = $_REQUEST['id'];
//echo "track =".$tracking_no;
$mess="";
$mess=$_REQUEST['mess'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel=stylesheet type=text/css href="css/font.css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<title>Online Inquiry</title>
<script type="text/javascript">
<!--
function checkFields()
{
	
	missinginfo = "";
	
	if (document.form.fname.value == "")
	{
		missinginfo += "\n     -  Please enter your First name";
	}
	if (document.form.lname.value == "")
	{
		missinginfo += "\n     -  Please enter your Last name";
	}
	
	if (document.form.email.value == "")
	{
		missinginfo += "\n     -  Please site a email address"; //
	}
	// officenumber  mobile
	if (document.form.officenumber.value == "" && document.form.mobile.value == "")
	{
		missinginfo += "\n     -  Please enter your contact number either in Office no. or Mobile No."; //
	}
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;
	
}

-->
</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {
	color: #FF0000;
	font-weight: bold;
	font-size: 18px;
}
-->
</style>

</head>

<body >
<? include 'header.php';?>
<div style="background-color:#CCCCCC; width:600px; float:left;">
<table width="566" border="0" align="center" cellpadding="10" cellspacing="0" style="background-color:#FFFFFF; border:#666666 solid 1px; margin-top:10px; margin-bottom:10px;">
                            <tbody>
                              <tr> 
                                <td> <form id="form" name="form" method="post" action="inquiryphp.php" onSubmit="return checkFields();">
								
                                    <table align="left" border="0" cellpadding="2" cellspacing="8" width="100%">
                                      <tbody>
                                        <tr> 
                                          <td colspan="3" bgcolor="#dee5eb" class="text01"><b>&nbsp;Quick 
                                            and Easy Online Quote</b></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td colspan="3" align="right"><div align="left">For 
                                              us to better serve your enquiry, 
                                              please complete as many of the questions 
                                              below and we will have a customer 
                                              support representative immediately 
                                              make contact with you after completing 
                                              the online enquiry</div></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right"><label>List 
                                            Remote Staff Responsibilities You 
                                            Need</label></td>
                                          <td width="49%" colspan="2"> <textarea cols="25" rows="5" class="select" name="jobresponsibilities"  id="jobresponsibilities" ></textarea></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right">How many 
                                            remote staff will you need?</td>
                                          <td colspan="2"><input type="text" id="rsnumber" name="rsnumber" class="select" /></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right" valign="top">When 
                                            will you need remote staff? </td>
                                          <td colspan="2" valign="top"><select name="needrs" class="select">
                                            <option value="">-</option>
                                            <option value="Within 1 month">Within 1 month</option>
                                            <option value="Over the next few Months" >Over the next few Months</option>
                                            <option value="ASAP">ASAP</option>
                                            <option value="Within 2 weeks">Within 2 weeks</option>
                                            <option value="Within 1 month">Within 1 month</option>
                                            <option value="Over the next few Months" >Over the next few Months</option>
                                          </select></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right" valign="top">Would 
                                            you need remote staff working from 
                                            a home office set up?</td>
                                          <td colspan="2"> <select name="rsinhome" class="select">
<option value="">-</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select> </td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right" valign="top">Or 
                                            from one of our Philippines office? 
                                          </td>
                                          <td colspan="2" valign="top"><select name="rsinoffice" class="select">
<option value="">-</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right" valign="top">Ask 
                                            a Questions?</td>
                                          <td colspan="2" valign="top"> <textarea name="questions" cols="25" rows="5" class="select" ></textarea> 
                                          </td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="51%" align="right" valign="top">&nbsp;</td>
                                          <td colspan="2" valign="top">&nbsp;</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <br clear="all">
                                    <br>
                                    <table align="left" border="0" cellpadding="2" cellspacing="8" width="100%">
                                      <tbody>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">First 
                                            name <span class="style2">*</span></td>
                                          <td width="250"><input id="fname" name="fname" class="select" type="text"> 
                                          </td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Last name 
                                            <span class="style2">*</span></td>
                                          <td><input id="lname" name="lname" class="select" type="text"> 
                                          </td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">What is 
                                            your position in the company?</td>
                                          <td><input type="text" id="companyposition" name="companyposition" class="select" /></td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right" valign="top">Business/company 
                                            name:</td>
                                          <td><input type="text" id="companyname" name="companyname" class="select"  /> 
                                          </td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Company 
                                            Address</td>
                                          <td><input type="text" id="companyaddress" name="companyaddress" class="select"  /></td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Email 
                                            <span class="style2">*</span></td>
                                          <td><input type="text" id="email" name="email" class="select"  /></td>
                                        </tr>
                                        <tr class="text01"> 
                                          <td width="264" align="right">Website</td>
                                          <td> <input type="text" id="website" name="website" class="select"  /></td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Office 
                                            number</td>
                                          <td><input type="text" id="officenumber" name="officenumber"  class="select" /> 
                                          </td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Mobile 
                                            <span class="style2">*</span></td>
                                          <td><input type="text" id="mobile" name="mobile"  class="select" /></td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Please 
                                            describe what your business does?</td>
                                          <td><textarea cols="25" rows="5" name="companydesc" id="companydesc" class="select" ></textarea></td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">How many 
                                            people are employed in your company?</td>
                                          <td><input type="text" id="noofemployee" name="noofemployee" class="select"  /></td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">Have you 
                                            use any outsourcing staff in the past?</td>
                                          <td><label> </label> <input id="used_rs" name="used_rs" value="Yes"  type="radio">
                                            Yes&nbsp;
                                            <input id="used_rs" name="used_rs" value="No" onClick="" type="radio">
                                            No</td>
                                        </tr>
                                        <tr valign="top" class="text01"> 
                                          <td width="264" align="right">If yes, 
                                            please explain how your experience 
                                            was?</td>
                                          <td><textarea cols="25" rows="5" name="usedoutsourcingstaffc" id="usedoutsourcingstaff" class="select"></textarea></td>
                                        </tr>
                                        <tr valign="top" class="text01">
                                          <td align="right">What turnover does your company do per year?</td>
                                          <td><select name="companyturnover" class="select">
                                              <option value="">-</option>
                                              <option value="$0 to $300,000">$0 
                                              to $300,000</option>
                                              <option value="$300,000 to $700,000">$300,000 
                                              to $700,000</option>
                                              <option value="$700,000 to $1.2m">$700,000 
                                              to $1.2m</option>
                                              <option value="$1.2m to $2m">$1.2m 
                                              to $2m</option>
                                              <option value="$2m to $3m">$2m to 
                                              $3m</option>
                                              <option value="$3 to $5m">$3 to 
                                              $5m</option>
                                              <option value="Above $5m">Above 
                                              $5m</option>
                                            </select></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <br clear="all">
                                    <br>
                                    <table border="0" cellpadding="2" cellspacing="1" width="100%">
                                      <tbody>
                                        <tr> 
                                          <td align="center">
										  <input type="HIDDEN" name="tracking_no" value="<? echo $booking_code;?>" />
										  <span class="text01"  ><b>Promotional Code : <? echo $booking_code;?></b></span><br />
										  <input value="Submit Form" name="send2" class="text01" style="width: 120px;" type="submit"></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </form></td>
                              </tr>
                            </tbody>
                          </table>
</div>
<div style="border:#999999 solid 1px; float:left; margin:0 5px; padding-left:10px; width:580px;">
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr> 
                              <td bgcolor="#FFFFFF"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr> 
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr> 
                                    <td class="title"><div align="center">Access 
                                        different labour markets and save up to 
                                        70% off labour cost!</div></td>
                                  </tr>
                                  <tr> 
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr> 
                                    <td class="text01"><p>Dear Employers,</p>
                                      <p>You may be new to the world of offshore 
                                        outsourcing; it&#8217;s definitely a hot 
                                        topic amongst business leaders in the 
                                        global community. At Remote Staff we help 
                                        you manage the changes, challenges and 
                                        opportunities with using offshore staff. 
                                        Our service is to always build trust between 
                                        you and the offshore staff. We do that 
                                        with our communication and wage billing 
                                        rules. We also focus at reducing your 
                                        risk thanks to our monitoring screen shot 
                                        tool as well as our HR service that will 
                                        monitor staff daily so you can feel confident 
                                        offshore staff are working, are online 
                                        and start work on-time.</p>
                                      <p>Remote Staff HR service is designed to 
                                        specifically find offshore talents on 
                                        your behalf to work directly with you 
                                        so your organisation can experience more 
                                        productivity, flexibility, increased capacity 
                                        and sometimes gain a savings of up to 
                                        70% on labour cost. </p>
                                      <p>Whether you would like to have one offshore 
                                        staff member or a team of fifty, we hope 
                                        to be your competitive secret weapon for 
                                        today&#8217;s global economy as your (BPO) 
                                        Business Process Outsourcing provider. 
                                        Position your business now to take advantage 
                                        of global trends so you don&#8217;t get 
                                        left behind. Develop your human capital 
                                        through Think Innovations Remote Staff 
                                        leasing service today. </p>
                                    <p></p></td>
                                  </tr>
                                  <tr> 
                                    <td bgcolor="#c79311" class="text01"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr> 
                                          <td class="title1"><div align="left"> 
                                              <p class="title2"><strong>Quick 
                                                review of the Remote Staff service:</strong></p>
                                            </div></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                  <tr> 
                                    <td bgcolor="#c79311"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                                        <tr> 
                                          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="10" cellpadding="0">
                                              <tr> 
                                                <td><p class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                    <strong>Acess 1.5 million 
                                                    english speaking job seekers;</strong> 
                                                  </p></td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>Save up to 70% of your 
                                                  recruitment budget</strong> 
                                                  with our $275 set up and recruitment 
                                                  fee. </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>Don&#8217;t wait months 
                                                  before you get your right staff 
                                                  member</strong>, we pre-screening 
                                                  up to 100 applicants and short 
                                                  list the right remote staff 
                                                  for you within a week or two; 
                                                </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>Using information and 
                                                  communication technologies, 
                                                  we make working with remote 
                                                  staff easy and risk free;</strong></td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>Our HR team successfully 
                                                  fill 85% of the remote staff 
                                                  you might need</strong>. If 
                                                  you&#8217;re not happy with 
                                                  the staff we offer you, we will 
                                                  replace them as much as you 
                                                  like; </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>1 year contact applies 
                                                  with every new remote staff 
                                                  person but you can cancel the 
                                                  agreement without any obligation 
                                                  after one month</strong>; </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"><strong>Remote 
                                                  Staff are dedicated to work 
                                                  directly with you</strong> between 
                                                  9am to 6pm Sydney Australia 
                                                  time zone or what ever time 
                                                  zone that would suit you;</td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"><strong>We 
                                                  specialize in 1 to 50 staff 
                                                  labour hire solutions</strong>. 
                                                  Remote Staff can work from home 
                                                  or for an extra $400 per month 
                                                  they could work from one of 
                                                  our overseas offices;</td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>You don&#8217;t pay 
                                                  for holiday or sick pay</strong>; 
                                                </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>We show you how to work 
                                                  more effectively with remote 
                                                  staff</strong> with screen share 
                                                  technologies, instant messaging 
                                                  services and document share 
                                                  technologies; </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>Screen snap shot are 
                                                  taken every 5 minutes</strong> 
                                                  of your remote staff so to make 
                                                  it easy to see what your remote 
                                                  staff are working on and to 
                                                  help improve your ability to 
                                                  manage them;</td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  <strong>HR activities like payrol</strong>l 
                                                  and compliance issues between 
                                                  Philippines and Australia are 
                                                  taken care of. With <strong>online 
                                                  time sheets and online status 
                                                  system</strong>, our service 
                                                  will confirm your remote staff 
                                                  are online and on-time working; 
                                                </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"><strong> 
                                                  Little paperwork</strong> and 
                                                  management procedures making 
                                                  life easy for everyone; </td>
                                              </tr>
                                              <tr> 
                                                <td class="text01"><img src="images/box.gif" width="11" height="11"> 
                                                  If needed we issue your remote 
                                                  staff with <strong>Australia 
                                                  numbers at fantastic call rates</strong>. 
                                                  E.g. local untimed calls at 
                                                  $0.10c and $0.18 to $0.29c per 
                                                  minute mobile call rates;</td>
                                              </tr>
                                            </table></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                  <tr> 
                                    <td>&nbsp;</td>
                                  </tr>
                                </table></td>
                            </tr>
  </table>
</div>

<? include 'footer.php';?>
</body>
</html>
