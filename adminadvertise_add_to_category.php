<?
include 'conf.php';
include 'config.php';
include 'function.php';
$agent_no = $_SESSION['agent_no'];
$userid=$_REQUEST['userid'];
$action = $_REQUEST['action'];
//echo $userid;
if($action!="" && $action =="blacklist")
{
	$blacklist="UPDATE personal set status='BLACKLISTED' WHERE userid=$userid;";
	//echo $blacklist;
	mysql_query($blacklist)or trigger_error("Query: $blacklist\n<br />MySQL Error: " . mysql_error());
	echo("<html><head><script>function update(){top.location='resume2.php?userid=$userid';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
}

if (isset($_POST['Ok'])) { // Check if the form has been submitted.
	$userid=$_REQUEST['userid'];
	$star=$_REQUEST['star'];
	$note=$_REQUEST['note'];
	$note=filterfield($note);
	$insertQuery="INSERT INTO comments (agent_no,userid,rate,comments,date_created) VALUES ($agent_no,$userid,$star,'$note',NOW());";
	mysql_query($insertQuery)or trigger_error("Query: $insertQuery\n<br />MySQL Error: " . mysql_error());
	
	echo("<html><head><script>function update(){top.location='resume2.php?userid=$userid';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
	
}

$query="SELECT * FROM personal p  WHERE p.userid=$userid";
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysql_query($query2);
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$row2 = mysql_fetch_array ($result2); 
	$latest_job_title=$row2['latest_job_title'];
	$image= $row['image'];

	$name =$row['fname']."  ".$row['lname'];
	$dateapplied =$row['datecreated'];
	$dateupdated =$row['dateupdated'];
	$address=$row['address1']." ".$row['city']." ".$row['postcode']." <br>".$row['state']." ".$row['country_id'];
	$tel=$row['tel_area_code']." - ".$row['tel_no'];
	$cell =$row['handphone_country_code']."+".$row['handphone_no'];
	$email =$row['email'];
	$skype_id =$row['skype_id'];
	$byear = $row['byear'];
	$bmonth = $row['bmonth'];
	$bday = $row['bday'];
	$gender =$row['gender'];
	$nationality =$row['nationality'];
	$residence =$row['permanent_residence'];
	
	$home_working_environment=$row['home_working_environment'];
	$internet_connection=$row['internet_connection'];
	$isp=$row['isp'];
	$computer_hardware=$row['computer_hardware'];
	$headset_quality=$row['headset_quality'];
	
	$computer_hardware2=str_replace("\n","<b>",$computer_hardware);
	if($headset_quality=="0") {
		$headset_quality ="No Headset Available";
	}	
	$message="<p align =justify>Working Environment :".$home_working_environment."<br>";
	$message.="Internet Connection :".$internet_connection."<br>";
	$message."Internet Provider :".$isp."<br>";
	$message.="Computer Hardware/s :".$computer_hardware2."<br>";
	$message.="Headset Quality :".$headset_quality."<br></p>";
	
	$yr = date("Y");
	switch($bmonth)
	{
		case 1:
		$bmonth= "Jan";
		break;
		case 2:
		$bmonth= "Feb";
		break;
		case 3:
		$bmonth= "Mar";
		break;
		case 4:
		$bmonth= "Apr";
		break;
		case 5:
		$bmonth= "May";
		break;
		case 6:
		$bmonth= "Jun";
		break;
		case 7:
		$bmonth= "Jul";
		break;
		case 8:
		$bmonth= "Aug";
		break;
		case 9:
		$bmonth= "Sep";
		break;
		case 10:
		$bmonth= "Oct";
		break;
		case 11:
		$bmonth= "Nov";
		break;
		case 12:
		$month= "Dec";
		break;
		default:
		break;
	}
	
	
}

?>



<html>
<head>
<title>Online Resume ©ThinkInnovations.com</title>
<meta HTTP-EQUIV='Content-Type' charset='utf-8'>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="css/resume.css">

<script type="text/javascript" src="category/category.js"></script>
<link rel=stylesheet type=text/css href="category/category.css">
<!--
<script type="text/javascript">


function checkFields()
{
	if (document.form.star[0].checked==false && document.form.star[1].checked==false && document.form.star[2].checked==false && document.form.star[3].checked==false && document.form.star[4].checked==false )
	{
		alert("Please enter your rate !");
		return false;
	}
	if (document.form.note.value=="")
	{
		alert("Please enter your comments/notes !");
		return false;
	}
	return true;
}
function showhide(str)
{
	if(str=="Comment")
	{
		
		newitem1="<p><b>Rate :</script></b></p>";
		newitem1+="<p><b>";
		newitem1+="<input type=\"radio\" name=\"star\" value=\"1\">&nbsp;1&nbsp; <img src=\"images/star.png\" align=\"top\">&nbsp;&nbsp;";
		newitem1+="<input type=\"radio\" name=\"star\" value=\"2\">&nbsp;2&nbsp; <img src=\"images/star.png\" align=\"top\">&nbsp;&nbsp;";
		newitem1+="<input type=\"radio\" name=\"star\" value=\"3\">&nbsp;3&nbsp; <img src=\"images/star.png\" align=\"top\">&nbsp;&nbsp;";
		newitem1+="<input type=\"radio\" name=\"star\" value=\"4\">&nbsp;4&nbsp; <img src=\"images/star.png\" align=\"top\">&nbsp;&nbsp;";
		newitem1+="<input type=\"radio\" name=\"star\" value=\"5\">&nbsp;5&nbsp; <img src=\"images/star.png\" align=\"top\">&nbsp;&nbsp;";
		newitem1+="</b></p>";
		newitem1+="<p><b>Notes :</script></b></p>";
		newitem1+="<p>";
		newitem1+="<textarea name=\"note\" cols=\"40\" rows=\"7\"></textarea> ";
		newitem1+="</b>";
		newitem1+="<p><INPUT type=\"submit\" value=\"Save\" name=\"Ok\" class=\"button\" style=\"width:50px\"></p>";
		document.getElementById("comment").innerHTML=newitem1;



	}
}

</script>
-->
<style type="text/css"> 
    .cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
    .cName label{ font-style:italic; font-size:8pt}
    .cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
    .jobRESH {color:#000000; size:2; font-weight:bold}
</style>
<style>
<!--
div.scroll {
		height: 300px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
			
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
		margin-left:0px;
	}
	.scroll label
	{
	
		width:90px;
		float: left;
		text-align:right;
		
	}
	.spanner
	{
		width: 400px;
		overflow: auto;
		padding:5px 0 5px 10px;
		margin-left:20px;
		
	}
	
#l {
	float: left;
	width: 350px;
	text-align:left;
	padding:5px 0 5px 10px;
	}	
#l ul{
	   margin-bottom: 10px;
		margin-top: 10px;
		margin-left:20px;
	}	

#r{
	float: right;
	width: 120px;
	text-align: left;
	padding:5px 0 5px 10px;
	
	
	}
	
	
.ads{
	width:580px;
	
		}
.ads h2{
	color:#990000;
	font-size: 2.5em;
	}	
.ads p{	
		margin-bottom: 5px;
		margin-top: 5px;
		margin-left:30px;
	}
.ads h3
{
	color:#003366;
	font-size: 1.5em;
	margin-left:30px;
}	
#comment{
	float: right;
	width: 500px;
	padding:5px 0 5px 10px;
	margin-right:20px;
	margin-top:0px;
}
#comment p
{

margin-bottom: 4px;
margin-top: 4px;
}


#comment label
{
display: block;
width:100px;
float: left;
padding-right: 10px;
font-size:11px;
text-align:right;

}


-->
</style>
</head>
<body bgcolor='#FFFFFF'>
<form name="form" method="post" action="resume2.php" onSubmit="return checkFields();">
<input type="hidden" name="userid" id="userid" value="<? echo $userid;?>">

<div style="text-align:right;">
	<input type="button" value="Evaluate" onClick="showEvaluationForm();">&nbsp;
	<input type="button" value="Add this Applicant in Categories" onClick="showCategoriesAddForm();">
</div>
<div id="ctrl" ><img src="images/ajax-loader.gif"> Evaluation Form Loading...</div>
<!-- ends here -->
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<div align='center'>
  
</div>
</form>
</body>
</html>
