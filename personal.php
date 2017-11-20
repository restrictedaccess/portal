<?php
//  2010-06-17  Normaneil Macutay <normanm@remotestaff.com.au>
// - used Mochikit.js
// - toggle the code button
// - created div for sending out code to email applicants
// - created a timer to automatically toggle the code_div_form if the code was successfully sent

header('Location: /portal/application_form/registernow-step1-personal-details.php');
include('class.php');
$passGen = new passGen(5);

$mess="";
$mess=$_REQUEST['mess'];

$nationality="";
$countryoptions="";
$countrynames = array(
        "Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria",
        "Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia-Herzegovina","Botswana","Bouvet Island",
        "Brazil","British Indian O. Terr.","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Rep.","Chad","Chile","China",
        "Christmas Island","Cocos (Keeling) Isl.","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Diego Garcia","Djibouti","Dominica",
        "Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Isl. (Malvinas)","Faroe Islands","Fiji","Finland","France","France (European Ter.)",
        "French Southern Terr.","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Great Britain (UK)","Greece","Greenland","Grenada","Guadeloupe (Fr.)","Guam (US)","Guatemala","Guinea",
        "Guinea Bissau","Guyana","Guyana (Fr.)","Haiti","Heard &amp; McDonald Isl.","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel",
        "Italy","Ivory Coast","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea (North)","Korea (South)","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon",
        "Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia (former Yugo.)","Madagascar (Republic of)","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands",
        "Martinique (Fr.)","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru",
        "Nepal","Netherland Antilles","Netherlands","New Caledonia (Fr.)","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Isl.","Norway","Oman","Pakistan","Palau",
        "Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Polynesia (Fr.)","Portugal","Puerto Rico (US)","Qatar","Reunion (Fr.)","Romania","Russian Federation","Rwanda",
        "Saint Lucia","Samoa","San Marino","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia (Slovak Rep)","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia  and  South Sand","Spain",
        "Sri Lanka","St. Helena","St. Pierre &amp; Miquelon","St. Tome and Principe","St.Kitts Nevis Anguilla","St.Vincent &amp; Grenadines","Sudan","Suriname","Svalbard &amp; Jan Mayen Is","Swaziland","Sweden","Switzerland","Syria","Tadjikistan","Taiwan",
        "Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom",
        "United States","Uruguay","US Minor outlying Isl.","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands (British)","Virgin Islands (US)","Wallis &amp; Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zaire",
        "Zambia","Zimbabwe");
        
 for ($count = 0; $count < count($countrynames); $count++) {
      if($nationality == $countrynames[$count])
      {
     $countryoptions .= "<option selected value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
      }
      else
      {
     $countryoptions .= "<option value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
      }
   }    
//echo $countryoptions;

?>
<html>
<head>
<title>MyProfile &copy; RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language=javascript src="js/MochiKit.js"></script>
<script type="text/javascript">
<!--
//var milisec=0 
//var seconds=30 
//document.getElementById('t2').value='30' 
/*
function display(){ 
 if (milisec<=0){ 
    milisec=9 
    seconds-=1 
 } 
 if (seconds<=-1){ 
    milisec=0 
    seconds+=1 
 } 
 else 
    milisec-=1 
    document.getElementById('d2').value=seconds+"."+milisec 
    setTimeout("display()",100) 
} 
display()
*/
-->
</script>


</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- CONTENT -->
<script language=javascript src="js/validation.js"></script>
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">
var milisec=0 ;
var seconds=3 ;

function tmr(){
    if($('tmr')!=null){
        alert("Registration code has been successfully sent.\n Please check your email Inbox / Spam box . ");
        display()
    }    
}

function display(){
    if (milisec<=0){ 
        milisec=9 
        seconds-=1 
    } 
    if (seconds<=-1){ 
        milisec=0 
        seconds+=1 
    } 
    else {
        milisec-=1 
        $('tmr').value=seconds+"."+milisec 
        if($('tmr').value == "0.0"){
            toggle('code_div_form')
        }
        setTimeout("display()",100) 
    }
}
function handleHttpResponse() 
{
    if (rq.readyState == 4) 
    {
        var returned_data = rq.responseText;
        document.getElementById('responder_message').innerHTML = '<font color="#FF0000"><b>'+returned_data+'</b></font>' ;
        tmr();
    }
    else
        document.getElementById('responder_message').innerHTML = '<font color="#FF0000"><b>Loading...</b></font>';
        
}
    
function makeObject()
{
    var x 
    var browser = navigator.appName 
    if(browser == 'Microsoft Internet Explorer')
    {
        x = new ActiveXObject('Microsoft.XMLHTTP')
    }
    else
    {
        x = new XMLHttpRequest()
    }
    return x
}
var rq = makeObject()

function validate_email()
{
    emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
    var regex = new RegExp(emailReg);

    if(document.getElementById('email_id').value == "")
    {
        alert("Please enter your email address.");
    }
    else if(regex.test(document.getElementById('email_id').value) == false)
    {
        alert('Please enter a valid email address and try again!');
    }    
    else
    {
        document.getElementById('responder_message').innerHTML = "Processing Please wait...";
        var email = document.getElementById('email_id').value;
        rq.open('get', 'personal_validate_email.php?email='+email)
        rq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        rq.onreadystatechange = handleHttpResponse;
        rq.send(1);    
    }    
}

function update_value(v)
{
    document.getElementById('user_name_id').innerHTML="<b>"+v+"</b>" ;
}




 





<!--
function checkFields()
{
    
    var countryid =document.frmPersonal.country_id.value;
    missinginfo = "";

    //if (document.frmPersonal.img.value == "")
    //{
        //missinginfo += "\n     -  Please include your photo";
    //}
    //if (document.frmPersonal.sound_file.value == "")
    //{
        //missinginfo += "\n     -  Please include your voice file";
    //}
    //if (document.frmPersonal.resume_file.value == "")
    //{
        //missinginfo += "\n     -  Please include your resume file";
    //}
    if (document.frmPersonal.fname.value == "")
    {
        missinginfo += "\n     -  Please enter your First Name";
    }
    if (document.frmPersonal.lname.value == "")
    {
        missinginfo += "\n     -  Please enter your Last Name";
    }
    if (document.frmPersonal.gender[0].checked == false && document.frmPersonal.gender[1].checked == false)
    {    
            missinginfo += "\n     -  Please choose your gender";
        
    }
    if (document.frmPersonal.nationality.selectedIndex=="0")
    {
        missinginfo += "\n     -  Please choose your nationality";
    }
    if (document.frmPersonal.email.value == "")
    {
        missinginfo += "\n     -  Please site a email address"; 
    }
    if (document.frmPersonal.pass.value == "")
    {
        missinginfo += "\n     -  Please enter your Password"; 
    }
    if (document.frmPersonal.handphone_no.value == "")
    {
        missinginfo += "\n     -  Please enter your mobile number";
    }
    if (document.frmPersonal.tel_area_code.value == "")
    {
        missinginfo += "\n     -  Please enter your area code";
    }
    if (document.frmPersonal.tel_no.value == "")
    {
        missinginfo += "\n     -  Please enter your telephone number";
    }
    if (document.frmPersonal.address1.value == "")
    {
        missinginfo += "\n     -  Please enter your Address";
    }
    if (document.frmPersonal.postcode.value == "")
    {
        missinginfo += "\n     -  Please enter your Postal Code"; //
    }
    if (document.frmPersonal.country_id.selectedIndex=="0")
    {
        missinginfo += "\n     -  Please state your Country";
    }
    
    if (countryid=="AU"|| countryid=="BD"|| countryid=="HK"|| countryid=="ID"|| countryid=="IN"|| countryid=="MY"|| countryid=="PH"|| countryid=="SG"|| countryid=="TH"|| countryid=="VN")
    {
        if (document.frmPersonal.msia_state_id.selectedIndex=="0")
        {
            missinginfo += "\n     -  Please enter your State or Region";
        }
    }
    else
    {
        if (document.frmPersonal.state.value == "")
        {
            missinginfo += "\n     -  Please enter your State or Region";

        }
    }
    if(document.frmPersonal.city.value == "")
    {
        missinginfo += "\n     -  Please enter your City";
    }
    if (document.frmPersonal.byear.value == "")
    {
        missinginfo += "\n     -  Please enter your Birth Year";
    }
    ///////////////////////////////////////////////
    
    
    //companyturnover  AU BD HK ID IN MY PH SG TH VN
    
    
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
<script language="javascript">
var AU = new Array();
AU[0] = "('Select a State','00','')";
AU[1] = "('A.C.T','AT','')";
AU[2] = "('Northern Territory','NO','')";
AU[3] = "('New South Wales','NW','')";
AU[4] = "('Queensland','QL','')";
AU[5] = "('South Australia','SA','')";
AU[6] = "('Tasmania','TS','')";
AU[7] = "('Victoria','VI','')";
AU[8] = "('Western Australia','WA','')";
var BD = new Array();
BD[0] = "('Select a Division','00','')";
BD[1] = "('Barisal','BS','')";
BD[2] = "('Chittagong','CI','')";
BD[3] = "('Dhaka','DK','')";
BD[4] = "('Khulna','KN','')";
BD[5] = "('Rajshahi','RH','')";
BD[6] = "('Sylhet','YH','')";
var HK = new Array();
HK[0] = "('Hong Kong','HK','')";
var ID = new Array();
ID[0] = "('Select a State','00','')";
ID[1] = "('Aceh','AC','')";
ID[2] = "('Bali','BA','')";
ID[3] = "('Bangka Belitung','BB','')";
ID[4] = "('Banten','BN','')";
ID[5] = "('Bengkulu','BE','')";
ID[6] = "('Gorontalo','GR','')";
ID[7] = "('Jakarta Raya','JA','')";
ID[8] = "('Jambi','JB','')";
ID[9] = "('Jawa Barat','JR','')";
ID[10] = "('Jawa Tengah','JT','')";
ID[11] = "('Jawa Timur','JW','')";
ID[12] = "('Kalimantan Barat','KB','')";
ID[13] = "('Kalimantan Selatan','KS','')";
ID[14] = "('Kalimantan Tengah','KU','')";
ID[15] = "('Kalimantan Timur','KV','')";
ID[16] = "('Lampung','LP','')";
ID[17] = "('Maluku','ML','')";
ID[18] = "('Maluku Utara','MJ','')";
ID[19] = "('Nusa Tenggara Barat','NB','')";
ID[20] = "('Nusa Tenggara Timur','NT','')";
ID[21] = "('Papua','IJ','')";
ID[22] = "('Riau','RI','')";
ID[23] = "('Sulawesi Selatan','SE','')";
ID[24] = "('Sulawesi Tengah','SF','')";
ID[25] = "('Sulawesi Tenggara','SH','')";
ID[26] = "('Sulawesi Utara','SJ','')";
ID[27] = "('Sumatera Barat','SK','')";
ID[28] = "('Sumatera Selatan','SN','')";
ID[29] = "('Sumatera Utara','SP','')";
ID[30] = "('Yogyakarta','YG','')";
var IN = new Array();
IN[0] = "('Select a State','00','')";
IN[1] = "('Andaman & Nicobar','AN:40100:','')";
IN[2] = "('Andhra Pradesh - Hyderabad','AP:40210:Hyderabad:','')";
IN[3] = "('Andhra Pradesh - Secunderabad','AP:40210:Secunderabad:','')";
IN[4] = "('Andhra Pradesh - Vishakapatnam','AP:40220:Vishakapatnam:','')";
IN[5] = "('Andhra Pradesh - Vijaywada','AP:40230:Vijaywada:','')";
IN[6] = "('Andhra Pradesh - Other cities','AP:40299:','')";
IN[7] = "('Assam - Gauhati','AS:40310:Gauhati:','')";
IN[8] = "('Assam - Other cities','AS:40399:','')";
IN[9] = "('Arunachal Pradesh','AU:40400:','')";
IN[10] = "('Bihar - Patna','BI:40510:Patna:','')";
IN[11] = "('Bihar - Other cities','BI:40599:','')";
IN[12] = "('Chandigarh','CH:40600:','')";
IN[13] = "('Chhattisgarh','CT:43400:','')";
IN[14] = "('Daman & Diu','DD:40700:','')";
IN[15] = "('Delhi - Delhi','DE:40800:Delhi:','')";
IN[16] = "('Delhi - Faridabad','DE:40800:Faridabad:','')";
IN[17] = "('Delhi - Ghaziabad','DE:40800:Ghaziabad','')";
IN[18] = "('Delhi - Gurgoan','DE:40800:Gurgoan:','')";
IN[19] = "('Delhi - Noida','DE:40800:Noida:','')";
IN[20] = "('Dadra & Nagar Haveli','DN:40900:','')";
IN[21] = "('Goa','GO:41000:','')";
IN[22] = "('Gujarat - Ahmedabad','GU:41110:Ahmedabad:','')";
IN[23] = "('Gujarat - Vadodara','GU:41120:Vadodara:','')";
IN[24] = "('Gujarat - Other cities','GU:41199:','')";
IN[25] = "('Haryana - Panipat','HA:41210:Panipat:','')";
IN[26] = "('Haryana - Other cities','HA:41299:','')";
IN[27] = "('Himachal Pradesh','HP:41300:','')";
IN[28] = "('Jammu & Kashmir','JK:41400:','')";
IN[29] = "('Jharkhand - Jamshedpur','JN:43510:Jamshedpur:','')";
IN[30] = "('Jharkhand - Ranchi','JN:43520:Ranchi:','')";
IN[31] = "('Jharkhand - Other cities','JN:43599:','')";
IN[32] = "('Karnataka - Bangalore','KA:41510:Bangalore:','')";
IN[33] = "('Karnataka - Mysore','KA:41520:Mysore:','')";
IN[34] = "('Karnataka - Mangalore','KA:41530:Mangalore:','')";
IN[35] = "('Karnataka - Other cities','KA:41599:','')";
IN[36] = "('Kerala - Cochin','KE:41610:Cochin:','')";
IN[37] = "('Kerala - Trivandrum','KE:41620:Trivandrum:','')";
IN[38] = "('Kerala - Other cities','KE:41699:','')";
IN[39] = "('Lakshadweep','LA:41700:','')";
IN[40] = "('Maharashtra - Aurangabad','MA:41810:Aurangabad:','')";
IN[41] = "('Maharashtra - Mumbai','MA:41820:Mumbai:','')";
IN[42] = "('Maharashtra - Nagpur','MA:41830:Nagpur:','')";
IN[43] = "('Maharashtra - Nashik','MA:41840:Nashik:','')";
IN[44] = "('Maharashtra - Pune','MA:41850:Pune:','')";
IN[45] = "('Maharashtra - Other cities','MA:41899:','')";
IN[46] = "('Meghalaya','ME:41900:','')";
IN[47] = "('Mizoram','MI:42000:','')";
IN[48] = "('Manipur','MN:42100:','')";
IN[49] = "('Madhya Pradesh - Bhopal','MP:42210:Bhopal:','')";
IN[50] = "('Madhya Pradesh - Indore','MP:42220:Indore:','')";
IN[51] = "('Madhya Pradesh - Other cities','MP:42299:','')";
IN[52] = "('Nagaland','NA:42300:','')";
IN[53] = "('Orissa - Bhubaneshwar','OR:42410:Bhubaneshwar:','')";
IN[54] = "('Orissa - Other cities','OR:42499:','')";
IN[55] = "('Pondicherry','PO:42500:','')";
IN[56] = "('Punjab - Jalandhar','PU:42610:Jalandhar:','')";
IN[57] = "('Punjab - Ludhiana','PU:42620:Ludhiana:','')";
IN[58] = "('Punjab - Other cities','PU:42699:','')";
IN[59] = "('Rajasthan - Jaipur','RA:42710:Jaipur:','')";
IN[60] = "('Rajasthan - Kota','RA:42720:Kota:','')";
IN[61] = "('Rajasthan - Other cities','RA:42799:','')";
IN[62] = "('Sikkim','SI:42800:','')";
IN[63] = "('Tamil Nadu - Chennai','TN:42910:Chennai:','')";
IN[64] = "('Tamil Nadu - Coimbatore','TN:42920:Coimbatore:','')";
IN[65] = "('Tamil Nadu - Madurai','TN:42930:Madurai:','')";
IN[66] = "('Tamil Nadu - Trichy','TN:42940:Trichy:','')";
IN[67] = "('Tamil Nadu - Salem','TN:42950:Salem:','')";
IN[68] = "('Tamil Nadu - Hosur','TN:42960:Hosur:','')";
IN[69] = "('Tamil Nadu - Other cities','TN:42999:','')";
IN[70] = "('Tripura','TR:43000:','')";
IN[71] = "('Uttaranchal','UT:43600:','')";
IN[72] = "('Uttar Pradesh - Lucknow','UP:43110:Lucknow:','')";
IN[73] = "('Uttar Pradesh - Kanpur','UP:43120:Kanpur:','')";
IN[74] = "('Uttar Pradesh - Other cities','UP:43199:','')";
IN[75] = "('West Bengal - Kolkata','WB:43210:Kolkata:','')";
IN[76] = "('West Bengal - Other cities','WB:43299:','')";
var MY = new Array();
MY[0] = "('Select a State','00','')";
MY[1] = "('Johor','JH','')";
MY[2] = "('Kedah','KH','')";
MY[3] = "('Kuala Lumpur','KL','')";
MY[4] = "('Kelantan','KT','')";
MY[5] = "('Melaka','MK','')";
MY[6] = "('Negeri Sembilan','NS','')";
MY[7] = "('Penang','PG','')";
MY[8] = "('Pahang','PH','')";
MY[9] = "('Perak','PK','')";
MY[10] = "('Perlis','PS','')";
MY[11] = "('Sabah','SB','')";
MY[12] = "('Selangor','SL','')";
MY[13] = "('Sarawak','SW','')";
MY[14] = "('Terengganu','TG','')";
MY[15] = "('Labuan','LB','')";
var PH = new Array();
PH[0] = "('Select a State','00','')";
PH[1] = "('Armm','AR','')";
PH[2] = "('Bicol Region','BR','')";
PH[3] = "('C.A.R','CA','')";
PH[4] = "('Cagayan Valley','CG','')";
PH[5] = "('Central Luzon','CL','')";
PH[6] = "('Central Mindanao','CM','')";
PH[7] = "('Caraga','CR','')";
PH[8] = "('Central Visayas','CV','')";
PH[9] = "('Eastern Visayas','EV','')";
PH[10] = "('Ilocos Region','IL','')";
PH[11] = "('National Capital Reg','NC','')";
PH[12] = "('Northern Mindanao','NM','')";
PH[13] = "('Southern Mindanao','SM','')";
PH[14] = "('Southern Tagalog','ST','')";
PH[15] = "('Western Mindanao','WM','')";
PH[16] = "('Western Visayas','WV','')";
var SG = new Array();
SG[0] = "('Singapore','SG','')";
var TH = new Array();
TH[0] = "('Select a State','00','')";
TH[1] = "('North','TA','')";
TH[2] = "('North Eastern','TB','')";
TH[3] = "('Central','TC','')";
TH[4] = "('Eastern','TD','')";
TH[5] = "('South','TE','')";
var VN = new Array();
VN[0] = "('Select a City','00','')";
VN[1] = "('An Giang','VN:110101:An Giang:','')";
VN[2] = "('Ba Ria-Vung Tau','VN:110102:Ba Ria-Vung Tau:','')";
VN[3] = "('Bac Can','VN:110103:Bac Can:','')";
VN[4] = "('Bac Giang','VN:110104:Bac Giang:','')";
VN[5] = "('Bac Lieu','VN:110105:Bac Lieu:','')";
VN[6] = "('Bac Ninh','VN:110106:Bac Ninh:','')";
VN[7] = "('Ben Tre','VN:110107:Ben Tre:','')";
VN[8] = "('Binh Dinh','VN:110108:Binh Dinh:','')";
VN[9] = "('Binh Duong','VN:110109:Binh Duong:','')";
VN[10] = "('Binh Phuoc','VN:110110:Binh Phuoc:','')";
VN[11] = "('Binh Thuan','VN:110111:Binh Thuan:','')";
VN[12] = "('Ca Mau','VN:110112:Ca Mau:','')";
VN[13] = "('Can Tho','VN:110113:Can Tho:','')";
VN[14] = "('Cao Bang','VN:110114:Cao Bang:','')";
VN[15] = "('Da Nang','VN:110115:Da Nang:','')";
VN[16] = "('Dac Lac','VN:110116:Dac Lac:','')";
VN[17] = "('Dong Nai','VN:110117:Dong Nai:','')";
VN[18] = "('Dong Thap','VN:110118:Dong Thap:','')";
VN[19] = "('Gia Lai','VN:110119:Gia Lai:','')";
VN[20] = "('Ha Giang','VN:110120:Ha Giang:','')";
VN[21] = "('Ha Nam','VN:110121:Ha Nam:','')";
VN[22] = "('Ha Noi','VN:110122:Ha Noi:','')";
VN[23] = "('Ha Tay','VN:110123:Ha Tay:','')";
VN[24] = "('Ha Tinh','VN:110124:Ha Tinh:','')";
VN[25] = "('Hai Duong','VN:110125:Hai Duong:','')";
VN[26] = "('Haiphong','VN:110126:Haiphong:','')";
VN[27] = "('Ho Chi Minh','VN:110127:Ho Chi Minh:','')";
VN[28] = "('Hoa Binh','VN:110128:Hoa Binh:','')";
VN[29] = "('Hung Yen','VN:110129:Hung Yen:','')";
VN[30] = "('Khanh Hoa','VN:110130:Khanh Hoa:','')";
VN[31] = "('Kien Giang','VN:110131:Kien Giang:','')";
VN[32] = "('Kon Tum','VN:110132:Kon Tum:','')";
VN[33] = "('Lai Chau','VN:110133:Lai Chau:','')";
VN[34] = "('Lam Dong','VN:110134:Lam Dong:','')";
VN[35] = "('Lang Son','VN:110135:Lang Son:','')";
VN[36] = "('Lao Cai','VN:110136:Lao Cai:','')";
VN[37] = "('Long An','VN:110137:Long An:','')";
VN[38] = "('Nam Dinh','VN:110138:Nam Dinh:','')";
VN[39] = "('Nghe An','VN:110139:Nghe An:','')";
VN[40] = "('Ninh Binh','VN:110140:Ninh Binh:','')";
VN[41] = "('Ninh Thuan','VN:110141:Ninh Thuan:','')";
VN[42] = "('Phu Tho','VN:110142:Phu Tho:','')";
VN[43] = "('Phu Yen','VN:110143:Phu Yen:','')";
VN[44] = "('Quang Binh','VN:110144:Quang Binh:','')";
VN[45] = "('Quang Nam','VN:110145:Quang Nam:','')";
VN[46] = "('Quang Ngai','VN:110146:Quang Ngai:','')";
VN[47] = "('Quang Ninh','VN:110147:Quang Ninh:','')";
VN[48] = "('Quang Tri','VN:110148:Quang Tri:','')";
VN[49] = "('Soc Trang','VN:110149:Soc Trang:','')";
VN[50] = "('Son La','VN:110150:Son La:','')";
VN[51] = "('Tay Ninh','VN:110151:Tay Ninh:','')";
VN[52] = "('Thai Binh','VN:110152:Thai Binh:','')";
VN[53] = "('Thai Nguyen','VN:110153:Thai Nguyen:','')";
VN[54] = "('Thanh Hoa','VN:110154:Thanh Hoa:','')";
VN[55] = "('Thua Thien-Hue','VN:110155:Thua Thien-Hue:','')";
VN[56] = "('Tien Giang','VN:110156:Tien Giang:','')";
VN[57] = "('Tra Vinh','VN:110157:Tra Vinh:','')";
VN[58] = "('Tuyen Quang','VN:110158:Tuyen Quang:','')";
VN[59] = "('Vinh Long','VN:110159:Vinh Long:','')";
VN[60] = "('Vinh Phuc','VN:110160:Vinh Phuc:','')";
VN[61] = "('Yen Bai','VN:110161:Yen Bai:','')";
VN[62] = "('Others','VN:110199:','')";
var strArrayList = ",AU,BD,HK,ID,IN,MY,PH,SG,TH,VN";function emptyLocationSelect(objOtherState, strCountry, objStateSelect, objCitySelect, objLocationSelect){ 
var NS4 = (document.layers) ? true : false; 
var temp = "";  
        if(!NS4){     objStateSelect.style.visibility = 'hidden'; } 
        if(strArrayList.indexOf(strCountry) > 0){ 
            while(objStateSelect.options.length > eval(strCountry + ".length")){  
                objStateSelect.options[(objStateSelect.options.length-1)] = null;  
            }  
        objOtherState.disabled = true;  
        objOtherState.value = '';  
        for(i=0;i<eval(strCountry + ".length");i++){  
            temp = eval(strCountry + "[i]");     
                if(!NS4){  
                    objOtherState.size = 10  
                    objOtherState.style.visibility = 'hidden';  
                    objStateSelect.style.visibility = 'visible';  
                }  
                else{  
                    objOtherState.disabled = true;  
                }  
                eval("objStateSelect.options[i] = new Option" + temp);  
        }  
    }else{  
        while(objStateSelect.options.length > 1){  
            objStateSelect.options[(objStateSelect.options.length-1)] = null;  
        }  
        if(!NS4){  
            objStateSelect.options[0] = new Option("","00");  
            objStateSelect.style.visibility = 'hidden';  
            objOtherState.style.visibility = 'visible';  
            objOtherState.size = 20  
            objOtherState.disabled = false; 
        }else{      
            objStateSelect.options[0] = new Option(Others,"00");  
            objOtherState.disabled = false;  
        }  
    }  
    objStateSelect.selectedIndex = 0;  
    
}  
function enterCity(ld,  objCitySelect, objLocationSelect, cls){  
    var id = ld.split(":") ; 
    objLocationSelect.value = "";
    if(id[1] != null && id[1].length > 0){ 
        objLocationSelect.value = id[1]; 
            if(id[2] != null && id[2].length > 0 ){ 
                objCitySelect.value = ""; 
                objCitySelect.value = id[2]; 
        } else{  
            if(cls == true) { 
                objCitySelect.value = ""; 
            } 
        } 
    }else{ 
       if(cls == true) { 
        objCitySelect.value = ""; 
       } 
    } 
} 
 function repopulateLocation(objMsiaState, data, startindex, endindex) {  
    for(var i =0 ; i< objMsiaState.options.length; i++)  
    {        
        var tempVar =  data;  
        if(objMsiaState.options[i].value == tempVar 
        ||  (objMsiaState.options[i].value.substring(startindex, endindex) == tempVar.substring(startindex, endindex))) 
        { 
            objMsiaState.selectedIndex = i; 
            break; 
        } 
    } 
   return i;  
} 
function populateDuplicateLocation(objMsiaState, data, strmsia, strloc, strcity){   
    for(var i =0 ; i< objMsiaState.options.length; i++){  
         if(objMsiaState.options[i].value == data){  
            objMsiaState.selectedIndex = i;  
            break; 
        }else{ 
            var tmpst =  strmsia; 
            var tmplc =  strloc; 
            var tmpct =  strcity;     
                var d = objMsiaState.options[i].value.split(":"); 
            if(d[0] == tmpst && d[1] == tmplc){ 
                var c = d[2].toLowerCase(); 
                var tmpct = tmpct.toLowerCase(); 
                if ( c.indexOf(tmpct) >= 0 || tmpct.indexOf(c) >= 0 ){ 
                    objMsiaState.selectedIndex = i; 
                        break; 
                } 
            } 
        } 
   }  
   return i;  
}  
function populateOtherLocation(objMsiaState, objCity, objLocation, strmsia, strcity){ 
  for(var i =0 ; i< objMsiaState.options.length; i++){ 
    var tmpst = strmsia; 
    var tmpct =  strcity;     
                var d = objMsiaState.options[i].value.split(":"); 
            if(d[0] == tmpst){ 
               if(d[2] != null && d[2].length > 0 ){ 
                var c = d[2].toLowerCase();  
                var tmpct = tmpct.toLowerCase(); 
                if ( c.indexOf(tmpct) >= 0 || tmpct.indexOf(c) >= 0 ){ 
                    objMsiaState.selectedIndex = i; 
                    break; 
                } 
                } 
            }
        } 
    if(i <  objMsiaState.options.length){ 
        enterCity(objMsiaState.options[i].value, objCity, objLocation, false) 
   }  
   return i;  
  }  
</script>
<!-- header -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remote-staff-logo.jpg" alt="think" width="484" height="89"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<!-- header -->
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 >&nbsp;

</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<div style="border: #FFFFFF solid 1px; width:230px; margin-top:20px;">
<p><a href="index.php" class="link12b">Home</a></p>
<p>Applicants Registration Form</p>
<ul>-- Status --
<li style="margin-bottom:10px;"><b style="color:#0000FF">Personal Details</b> <img src="images/arrow.gif"></li>
<li style="margin-bottom:10px;">Educational Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Work Experinced Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Skills Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Languages Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Upload Photo <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Voice Recording <img src="images/cross.gif"></li>
</ul>
</div>
</td>
<td width=566 valign=top align=right>
<img src='images/space.gif' width='1' height='10'><br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<tr><td>
<table width=98% cellspacing=0 cellpadding=0 align=center><tr><td class=msg align="center"><b>Fill in this section to give employers a snapshot of your profile.</b> <br></td>
</tr></table>
<? if($mess!="") { ?><div style="background-color:#FFFFCC; text-align:center; margin-top:10px; height:90px; padding:5 5 5 5px; border:#000000 solid 1px; ">

<div align="left"><img src="images/problem2.gif" alt="Error"></div>
<b>
<?php 
    switch($mess)
    {
        case "6":
            echo "ERROR : There was a problem of uploading your photo";
            break;
        case "7":
            echo "ERROR : There was a problem of uploading your voice file";
            break;
        case "8":
            echo "ERROR : There was a problem of uploading your resume file.";
            break;
        case "5":
            echo "ERROR : Email Validation Code Number didn't matched";
            break;
        case "3":
            echo "ERROR : Please try again";
            break;
        case "6":
            echo "ERROR : Invalid Post";
            break;
        case "4":
            echo "
            The Email that you are trying to Register is already Exist. Please try to register a different Email Address or you can try to Retrieve your Login Details 
            <a href='#' class='link5' onClick= \"javascript:popup_win('./forgotpassword.php?user=APPLICANT',500,400);\">HERE</a>
            ";        
            break;
        default:
            echo "ERROR : ".$mess;
            break;
    }
?>

</b>
</div>
<? }?>

<br>
<form method="POST" name="frmPersonal" action="personalphp.php" onSubmit="return checkFields();" enctype="multipart/form-data">




<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100 bgcolor=#DEE5EB colspan=3><b>Email&nbsp;Validation</b></td></tr>
<tr valign=top><td align=right width=30% >Primary Email :</td>
<td>
    <INPUT size=30 style='width:270px' class="text" name="email" value="<?php echo @$_REQUEST["email"]; ?>" onChange="javascript: update_value(this.value); "><br>
    <span class="comment">Your Yahoo ID is not thesame as your email address</span>
</td>
</tr>
<tr><td colspan="2" align="center"><span class="comment">
Check your email to get the code and input the code below <br>
to continue the registration process.</span></td></tr>
<tr valign=top><td align=right width=30% >Code&nbsp;Number:</td>
<td>
<INPUT maxLength=100 size=30 style='width:270px' class="text" name="code" value="<?php echo @$_REQUEST["code"]; ?>" ></td></tr>

<tr><td colspan="2">
<div>Do not have yet the registration code ? Click <a href="javascript:toggle('code_div_form')"><b>HERE</b></a></div>
<div id="code_div_form" style="border:#000000 solid 3px; margin-top:5px; display:none;">

<div style="background:#FFFFCC; border-bottom:#666666 solid 1px; padding:5px;"><span style="float:right"><a href="javascript:toggle('code_div_form')" title="close" style="text-decoration:none;">[ x ]</a></span>Code verification is to ensure that your email address is <b>valid</b>. Valid email address is required to process your application as this will be your initial means of contact. </div>


<div style="padding:5px;">
<table width=100% border=0 cellpadding="1" cellspacing="0"  >
<tr>
<td width="22%">Primary Email</td>
<td width="78%">

<INPUT size=30 style='width:270px' class="text" id="email_id" value="<?php echo @$_REQUEST["email"]; ?>" onChange="javascript: update_value(this.value); "><br>
<span class="comment">Your Yahoo ID is not thesame as your email address</span>
</td>
</tr>

<tr>
<td>&nbsp;</td>
<td><INPUT type="button" style='width:270px' class="button" name="send_code" value="Send Code to Primary Email" onClick="javascript: validate_email();"></td>
</tr>

</table>
</div>

<div id="responder_message" style="margin:5px; padding:5px;"></div>
<span style="float:right"><a href="javascript:toggle('code_div_form')" title="close" style="text-decoration:none;">[ close ]</a></span><br style="clear:both;">
</div>
</td></tr>

</table>
<br clear=all><br>














<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=3><b>Personal Details</b></td></tr>
<tr><td width=30% align=right>First Name :</td><td colspan=2 >
<INPUT size='30' class='text' style="width:270px" name='fname' value="<?php echo @$_REQUEST["fname"]; ?>"></td></tr>
<tr><td width=30% align=right>Family/Last Name :</td>
<td colspan=2 ><INPUT size="30" class=text style="width:270px" name="lname" value="<?php echo @$_REQUEST["lname"]; ?>"></td></tr>
<tr valign=top><td align=right width=30% >Date of Birth :</td>
<td colspan=2><select name="bday" class="text">
<?php 
if(@isset($_REQUEST["bday"]))
{
    echo "<option value=".@$_REQUEST["bday"]." selected>".@$_REQUEST["bday"]."</option>";
}
?>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
<option value=10>10</option>
<option value=11>11</option>
<option value=12>12</option>
<option value=13>13</option>
<option value=14>14</option>
<option value=15>15</option>
<option value=16>16</option>
<option value=17>17</option>
<option value=18>18</option>
<option value=19>19</option>
<option value=20>20</option>
<option value=21>21</option>
<option value=22>22</option>
<option value=23>23</option>
<option value=24>24</option>
<option value=25>25</option>
<option value=26>26</option>
<option value=27>27</option>
<option value=28>28</option>
<option value=29>29</option>
<option value=30>30</option>
<option value=31>31</option>
</select>
 - <select name="bmonth" class="text">
<?php 
if(@isset($_REQUEST["bmonth"]))
{
    echo "<option value=".@$_REQUEST["bmonth"]." selected>".@$_REQUEST["bmonth"]."</option>";
}
?>
 <option value=1>January</option>
 <option value=2>February</option>
 <option value=3>March</option>
 <option value=4>April</option>
 <option value=5>May</option>
 <option value=6>June</option>
 <option value=7>July</option>
 <option value=8 >August</option>
 <option value=9>September</option>
 <option value=10>October</option>
 <option value=11>November</option>
 <option value=12>December</option>
 </select>
- <input type="text" name="byear" size="4" maxlength=4 style='width=50px' value="<?php echo @$_REQUEST["byear"]; ?>"  class=text> (YYYY)</td></tr>

<tr valign=top><td align=right width=30% >Identification :<br>(Optional) &nbsp;</td>
<td colspan=2>
<select name="auth_no_type_id" style="font:8pt, Verdana">
<?php 
if(@isset($_REQUEST["auth_no_type_id"]))
{
    echo "<option value=".@$_REQUEST["auth_no_type_id"]." selected>".@$_REQUEST["auth_no_type_id"]."</option>";
}
?>
<option value="0" selected>-</option>
<option value="IC No.">IC No.</option>
<option value="Social Card No.">Social Card No.</option>
<option value="Tax Card No.">Tax Card No.</option>
<option value="Driver's License No.">Driver's License No.</option>
<option value="Student Card No.">Student Card No.</option>
<option value="Passport No.">Passport No.</option>
<option value="Professional License No.">Professional License No.</option>
</select> 
- 
<INPUT maxLength=30 size=15 style='width=120px' class="text" name="msia_new_ic_no" value='<?php echo @$_REQUEST["msia_new_ic_no"]; ?>'><br>&nbsp;&nbsp;
<img src='images/arrow.gif'><a href="">which one should I use?</a></td></tr>
<tr valign=top><td align=right width=30% >Gender :</td>
<td colspan=2>
<INPUT type=radio value="Female" name="gender" <?php if(@$_REQUEST["gender"] == "Female") { echo "checked"; } ?>>Female &nbsp;&nbsp;
<INPUT type=radio value="Male" name="gender" <?php if(@$_REQUEST["gender"] == "Male") { echo "checked"; } ?> >Male</td></tr>
<tr valign=top><td align=right width=30% >Nationality :</td>
<td colspan=2>
<select name="nationality" style="width:270px; font:8pt, Verdana" >
<option value="0">-</option>
<?php 
if(@isset($_REQUEST["nationality"]))
{
    echo "<option value=".@$_REQUEST["nationality"]." selected>".@$_REQUEST["nationality"]."</option>";
}
?>
<? echo $countryoptions;?>
</select>
</td></tr>
<tr valign=top>
<td align=right width=30% >Permanent Resident&nbsp;&nbsp;<br>Status In :<br>(Optional)&nbsp;&nbsp;</td>
<td colspan=2>
<table cellspacing=1 width=100% border=0 cellpadding=1 align=center>
    <tr valign=top>
        <td><input type="radio" name="permanent_residence" value="AU" <?php if(@$_REQUEST["permanent_residence"] == "AU") { echo "checked"; } ?>>Australia</td>
        <td><input type="radio" name="permanent_residence" value="CA" <?php if(@$_REQUEST["permanent_residence"] == "CA") { echo "checked"; } ?>>Canada</font></td>
        <td><input type="radio" name="permanent_residence" value="CN" <?php if(@$_REQUEST["permanent_residence"] == "CN") { echo "checked"; } ?>>China</font></td>
    </tr>
    <tr>
        <td><input type="radio" name="permanent_residence" value="HK" <?php if(@$_REQUEST["permanent_residence"] == "HK") { echo "checked"; } ?>>Hong Kong</font></td>
        <td><input type="radio" name="permanent_residence" value="IN" <?php if(@$_REQUEST["permanent_residence"] == "IN") { echo "checked"; } ?>>India</font></td>
        <td><input type="radio" name="permanent_residence" value="ID" <?php if(@$_REQUEST["permanent_residence"] == "ID") { echo "checked"; } ?>>Indonesia</font></td>
    </tr>
    <tr>
        <td><input type="radio" name="permanent_residence" value="JP" <?php if(@$_REQUEST["permanent_residence"] == "JP") { echo "checked"; } ?>>Japan</font></td>
        <td><input type="radio" name="permanent_residence" value="MY" <?php if(@$_REQUEST["permanent_residence"] == "MY") { echo "checked"; } ?>>Malaysia</font></td>
        <td><input type="radio" name="permanent_residence" value="NZ" <?php if(@$_REQUEST["permanent_residence"] == "NZ") { echo "checked"; } ?>>New Zealand</font></td>
    </tr>
    <tr>
        <td><input type="radio" name="permanent_residence" value="PH" <?php if(@$_REQUEST["permanent_residence"] == "") { echo "checked"; } ?>>Philippines</font></td>
        <td><input type="radio" name="permanent_residence" value="SG" <?php if(@$_REQUEST["permanent_residence"] == "SG") { echo "checked"; } ?>>Singapore</font></td>
        <td><input type="radio" name="permanent_residence" value="TH" <?php if(@$_REQUEST["permanent_residence"] == "TH") { echo "checked"; } ?>>Thailand</font></td>
    </tr>
    <tr>
        <td><input type="radio" name="permanent_residence" value="GB" <?php if(@$_REQUEST["permanent_residence"] == "GB") { echo "checked"; } ?>>United Kingdom</font></td>
        <td><input type="radio" name="permanent_residence" value="US" <?php if(@$_REQUEST["permanent_residence"] == "US") { echo "checked"; } ?>>United States</font></td>
    </tr>
</table>
</td>
</tr>
<tr>
    <td width=30% align=right valign="top">Resume :</td>
    <td colspan=2 >
        <input type="file" name="resume_file" id="resume_file"><br /><strong><font color="#FF0000" size="1">Optional but highly recommended</font></strong>
    </td>
</tr>

</table>
<br clear=all><br>
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >

<tr><td width=100% bgcolor=#DEE5EB colspan=3><b>Login Details</b></td></tr>
<tr valign=top><td align=right width=30% >User Name<font size="1"><em>(primary&nbsp;email)</em></font>:</td>
<td><div id="user_name_id"><?php echo @$_REQUEST["email"]; ?></div></td></tr>
<tr valign=top><td align=right width=30% >Password :</td>
<td><INPUT maxLength=100 size=30 style='width:270px' class="text" type="password" name="pass" value="<?php echo @$_REQUEST["pass"]; ?>" ></td></tr>
<tr><td width=100% bgcolor=#DEE5EB colspan=3><b>Contact Info</b></td></tr>
<tr valign=top><td align=right width=30% >Alternative Email :<br>(Optional)&nbsp;&nbsp;</td>
<td><INPUT maxLength=100 size=30 style='width:270px' class="text" name="alt_email" value="<?php echo @$_REQUEST["alt_email"]; ?>" onChange="javascript: if (Trim(this.value) != '') {    if (Trim(this.value) == Trim(form.email.value)) { alert('Please enter your alternate email different from your Primary Email'); validated = false; return false; } else { return ValidateOneEmail(this); }}"><br>&nbsp;&nbsp;<img src='images/arrow.gif'><font class=tip>will be used if primary email is not reachable</font></td></tr><tr valign=top><td align=right width=30% >Mobile No. :</td>
<td>
<SELECT name="handphone_country_code" style='font:8pt, Verdana; width:120px'>
<option value=""></option>
<?php 
if(@isset($_REQUEST["handphone_country_code"]))
{
    echo "<option value=".@$_REQUEST["handphone_country_code"]." selected>".@$_REQUEST["handphone_country_code"]."</option>";
}
?>
<option value="880">88 (Bangladesh)</option>
<option value="91">91 (India)</option>
<option value="62">62 (Indonesia)</option>
<option value="60">60 (Malaysia)</option>
<option value="63" selected >63 (Philippines)</option>
<option value="65">65 (Singapore)</option>
<option value="0">Other</option></SELECT>
- <INPUT maxLength=15 size=15 style='width:136px' class="text" name="handphone_no" value="<?php echo @$_REQUEST["handphone_no"]; ?>">
</td></tr>
<tr valign=top><td align=right width=30% >Telephone No. :</td>
<td><INPUT maxLength=5 size=5 style='width:60px' class="text" name="tel_area_code" value="<?php echo @$_REQUEST["tel_area_code"]; ?>"> 
- <INPUT maxLength=20 size=22 style='width:196px' class=text name="tel_no" value="<?php echo @$_REQUEST["tel_no"]; ?>"><br>
<font class=tip>Area Code - Number</font></td></tr>
<tr valign=top><td align=right width=30% valign=top >Address 1:</td><td>
<textarea  rows="3"  style='width:270px' class="text" name="address1" id="address1"><?php echo @$_REQUEST["address1"]; ?></textarea></td></tr>

<tr valign=top><td align=right width=30% valign=top >Address 2:</td><td><textarea  rows="3"  style='width:270px' class="text" name="address2" id="address2"><?php echo @$_REQUEST["address2"]; ?></textarea></td></tr>
<tr valign=top><td align=right width=30% >Postal Code :</td>
<td><INPUT maxLength=20 size=30 style='width:270px' class="text" name="postcode" value="<?php echo @$_REQUEST["postcode"]; ?>"></td></tr>
<tr valign=top><td align=right width=30% >Country :</td><td><select name="country_id" onChange="javascript: emptyLocationSelect(this.form.state, this.options[this.selectedIndex].value,this.form.msia_state_id,this.form.city, this.form.location_code) ;" style="width:270px;font:8pt, Verdana"><option value="00">-</option>
<?php 
if(@isset($_REQUEST["country_id"]))
{
    echo "<option value=".@$_REQUEST["country_id"]." selected>".@$_REQUEST["country_id"]."</option>";
}
?>
<option value="AF">Afghanistan</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AU">Australia</option>
<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>
<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia</option>
<option value="BA">Bosnia Hercegovina</option>
<option value="BW">Botswana</option>
<option value="BV">Bouvet Island</option>
<option value="BR">Brazil</option>
<option value="IO">British Indian Ocean Territory</option>
<option value="BN">Brunei Darussalam</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="KH">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>
<option value="CF">Central African Republic</option>
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos (Keeling) Islands</option>
<option value="CO">Colombia</option>
<option value="KM">Comoros</option>
<option value="CG">Congo</option>
<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="CI">Cote D'ivoire</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>
<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>
<option value="TP">East Timor</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">EL Salvador</option>
<option value="GQ">Equatorial Guinea</option>
<option value="ER">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>
<option value="FK">Falkland Islands (Malvinas)</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="GF">French Guiana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="GA">Gabon</option>
<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GH">Ghana</option>
<option value="GI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>
<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-Bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard and Mc Donald Islands</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong</option>
<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN">India</option>
<option value="ID">Indonesia</option>
<option value="IR">Iran</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>
<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KP">Korea (North)</option>
<option value="KR">Korea (South)</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Laos</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libyan Arab Jamahiriya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>
<option value="LU">Luxembourg</option>
<option value="MO">Macau</option>
<option value="MK">Macedonia</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>
<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia</option>
<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar</option>
<option value="NA">Nambia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>
<option value="NL">Netherlands</option>
<option value="AN">Netherlands Antilles</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>
<option value="MP">Northern Mariana Islands</option>
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="OT">Others</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PS">Palestinian Territory, Occupied</option>
<option value="PA">Panama</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="PE">Peru</option>
<option value="PH" >Philippines</option>
<option value="PN">Pitcairn</option>
<option value="PL">Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="MD">Republic Of Moldova</option>
<option value="RE">Reunion</option>
<option value="RO">Romania</option>
<option value="RU">Russia</option>
<option value="RW">Rwanda</option>
<option value="KN">Saint Kitts And Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="VC">Saint Vincent and The Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="ST">Sao Tome and Principe</option>
<option value="SA">Saudi Arabia</option>
<option value="SN">Senegal</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="SK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>
<option value="GS">South Georgia And South Sandwich Islands</option>
<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SH">St. Helena</option>
<option value="PM">St. Pierre and Miquelon</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen Islands</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>
<option value="CH">Switzerland</option>
<option value="SY">Syrian Arab Republic</option>
<option value="TW">Taiwan</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania</option>
<option value="TH">Thailand</option>
<option value="TG">TOGO</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>
<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turks and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="AE">United Arab Emirates</option>
<option value="GB">United Kingdom</option>
<option value="US">United States</option>
<option value="UM">United States Minor Outlying Islands</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VA">Vatican City State (Holy See)</option>
<option value="VE">Venezuela</option>
<option value="VN">Vietnam</option>
<option value="VG">Virgin Islands (British)</option>
<option value="VI">Virgin Islands (U.S.)</option>
<option value="WF">Wallis and Futuna Islands</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="YU">Yugoslavia</option>
<option value="CD">Zaire</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>
</select></td></tr><tr><td align=right width=30% >State/Region :</td><td>
<select name="msia_state_id" value="NC" onChange="return enterCity(form.msia_state_id.options[form.msia_state_id.options.selectedIndex].value, this.form.city, this.form.location_code, true);" style="width:270px;font:8pt verdana">
<?php 
if(@isset($_REQUEST["msia_state_id"]))
{
    echo "<option value=".@$_REQUEST["msia_state_id"]." selected>".@$_REQUEST["msia_state_id"]."</option>";
}
?>
<OPTION value="00">Select State/Region &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>
<OPTION value="00">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>
</select> <br>

<INPUT maxLength=20 size=30 style='width:270px' class="text" name="state" value="<?php echo @$_REQUEST["state"]; ?>" ><input type=hidden name="state2" value="<?php echo @$_REQUEST["state2"]; ?>"></td></tr><tr valign=top><td align=right width=30% >City :</td>
<td><input type=hidden name=location_code value="<?php echo @$_REQUEST["location_code"]; ?>"><INPUT maxLength=20 size=30 style='width:270px' class="text" name="city" value="<?php echo @$_REQUEST["city"]; ?>"></td></tr>
<tr>
  <td width=100% bgcolor=#DEE5EB colspan=3><b>Working at Home Capabilities</b></td>
</tr>
<tr valign=top><td align=right width=30% >Home Working Environment :</td><td><input type="radio" name="home_working_environment" value="private room" <?php if(@$_REQUEST["home_working_environment"] == "private room") { echo "checked"; } ?>>Private Room&nbsp;<input type="radio" name="home_working_environment" value="shared room" <?php if(@$_REQUEST["home_working_environment"] == "shared room") { echo "checked"; } ?>>Shared Room&nbsp;<input type="radio" name="home_working_environment" value="living room" <?php if(@$_REQUEST["home_working_environment"] == "living room") { echo "checked"; } ?>>Living Room&nbsp;</td></tr>
<tr valign=top><td align=right width=30% >Internet Connection :</td><td><input type="radio" name="internet_connection" value="WI-FI" <?php if(@$_REQUEST["internet_connection"] == "WI-FI") { echo "checked"; } ?>>WI-FI&nbsp;<input type="radio" name="internet_connection" value="DIAL-UP" <?php if(@$_REQUEST["internet_connection"] == "DIAL-UP") { echo "checked"; } ?>>Dial-Up&nbsp;<input type="radio" name="internet_connection" value="DSL" <?php if(@$_REQUEST["internet_connection"] == "DSL") { echo "checked"; } ?>>DSL&nbsp;</td></tr>
<tr valign=top><td align=right width=30% >Internet Provider (ISP) :</td><td><INPUT size=30 style='width:270px' class="text" name="isp" value="<?php echo @$_REQUEST["isp"]; ?>"></td></tr>
<tr valign=top><td align=right width=30% >List of Computer Harwdare:</td><td><textarea name="computer_hardware" cols="30" rows="5"><?php echo @$_REQUEST["computer_hardware"]; ?></textarea></td></tr>
<tr valign=top><td align=right width=30% >Headset Quality :</td><td>
<select name="headset_quality" class="text">
<option value=0>No Headset</option>
<?php 
if(@isset($_REQUEST["headset_quality"]))
{
    echo "<option value=".@$_REQUEST["headset_quality"]." selected>".@$_REQUEST["headset_quality"]."</option>";
}
?>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
</select>&nbsp;1 LOW...5 High&nbsp;&nbsp;</td></tr>






</table><br clear=all><table width=100% cellspacing=8 cellpadding=2 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB colspan=3><b>&nbsp;Online Contact Info (OPTIONAL)</a></b></td></tr><tr><td><div id='internet_acc' class='toggleshow'><table width='100%' cellpadding=2 cellspacing=4 border=0><tr valign=top><td align=left colspan=2><a name='ia'>Fill in your Instant Messaging (IM) Usernames here to provide us with an alternative way to contact you. <font color=red><b>Note: This section is fully optional.</b></font></a><br><br></td></tr><tr valign=top><td align=right width=30% >MSN Messenger ID :</td><td><INPUT maxLength=80 size=30 style='width:200px' class=text name="msn_id" value="<?php echo @$_REQUEST["msn_id"]; ?>"></td></tr><tr valign=top><td align=right width=30% >Yahoo! Messenger ID :</td><td><INPUT maxLength=80 size=30 style='width:200px' class="text" name="yahoo_id" value="<?php echo @$_REQUEST["yahoo_id"]; ?>"></td></tr><tr valign=top><td align=right width=30% >ICQ Number :</td><td><INPUT maxLength=80 size=30 style='width:200px' class=text name="icq_id" value="<?php echo @$_REQUEST["icq_id"]; ?>"></td></tr><tr valign=top><td width=30% height="57" align=right >Skype ID :</td>
<td><INPUT maxLength=80 size=30 style='width:200px' class="text" name="skype_id" value="<?php echo @$_REQUEST["skype_id"]; ?>"></td></tr><tr><td colspan=2>
<p> <div align="center">
                                <input type="text" value="<?php if (!empty($pass)) { echo $pass; }?>" name="pass2"  size="5" maxlength="5">
                                <?php  $rv = $passGen->password(0, 1); ?>
                                <input type="hidden" value="<?php  echo $rv ?>" name="rv">
                                <?php  echo $passGen->images('font', 'gif', 'f_', '20', '20'); ?><br />
                              for validation, please type the numbers that you see <br />
<br />
<? if ($mess==2) { echo "<span class='style1' style='background-color:#FFFFCC'><b>Please type the Correct Code!</span></font>"; }?>
</div></p>



</td></tr></table></div></td></tr></table><br clear=all>
<br>
<table width=100% border=0 cellspacing=1 cellpadding=2><tr><td align=center><INPUT type=submit value='Save & Next' name="send" class="button" style='width:120px'></td></tr></table></form></td></tr></table></td></tr></table><script language="javascript">
    emptyLocationSelect(document.frmPersonal.state, document.frmPersonal.country_id.options[document.frmPersonal.country_id.selectedIndex].value,document.frmPersonal.msia_state_id, document.frmPersonal.city, document.frmPersonal.location_code);
    repopulateLocation(document.frmPersonal.msia_state_id, "NC", 0, 2);
</script>
</td></tr>
</table>
</td></tr>
</table>
<? include 'footer.php';?>
</body>
</html>
