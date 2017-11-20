<?
include 'config.php';
include 'conf.php';
include 'function.php';
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];



/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program
*/
$query ="SELECT * FROM leads WHERE id = $client_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);

	$tracking_no =$row['tracking_no'];
	$timestamp =$row['timestamp'];
	$status =$row['status'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
	$your_questions =$row['your_questions'];
		
	$lname =$row['lname'];
	$fname =$row['fname'];
	$company_position =$row['company_position'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$email =$row['email'];
	$website =$row['website'];
	$officenumber =$row['officenumber'];
	$mobile =$row['mobile'];
	$company_description =$row['company_description'];
	$company_industry =$row['company_industry'];
	$company_size =$row['company_size'];
	$outsourcing_experience =$row['outsourcing_experience'];
	$outsourcing_experience_description =$row['outsourcing_experience_description'];
	$company_turnover =$row['company_turnover'];
	$referal_program =$row['referal_program'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);
	$contacted_since=$row['contacted_since'];
	$client_since=$row['client_since'];
	$rate =$row['rating'];
	$personal_id =$row['personal_id'];
	
	if($rate=="1")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript">
<!--
function checkFields()
{
	if(document.form.star.selectedIndex==0)
	{
	
		missinginfo = "";
		if(document.form.txt.value=="")
		{
			missinginfo += "\n     -  There is no message or details to be save or send \t \n Please enter details.";
		}
		if (document.form.mode.value =="")
		{
			if (document.form.fill.value=="" )
			{
				missinginfo += "\n     -  Please choose actions.";
			}
			if (document.form.fill.value=="EMAIL" )
			{
				if (document.form.subject.value=="" )
				{
					missinginfo += "\n     -  Please enter a subject in your Email.";
				}
				if (document.form.templates[0].checked==false && document.form.templates[1].checked==false)
				{
					missinginfo += "\n     -  Please choose email templates.";
				}
			}
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

	
}

-->
</script>	
<style type="text/css">
<!--
	div.scroll {
		height: 100px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
	}
	
	#l {
	float: left;
	width: 350px;
	text-align:left;
	padding:5px 0 5px 10px;
	
	
	}	

#r{
	float: right;
	width: 120px;
	text-align: right;
	padding:5px 0 5px 10px;
	
	
	}
	
	#l2 {
	float: left;
	width: 200px;
	text-align:left;
	padding:5px 0 5px 10px;
	
	
	}	

#r2{
	float: right;
	width: 150px;
	text-align: right;
	padding:5px 0 5px 10px;
	
	
	}
#contentwrapper{
}

.billcontent{
width: 100%;
display:block;

}
.reminders{
font-weight:bold
}
-->
</style>		
<script type="text/javascript">
<!--

//-----
-->
</script>
	
    <script type="text/javascript" src="js/MochiKit.js"></script>
    <style type="text/css">@import url(scm_tab/scm_tab.css);</style>
    <script type="text/javascript" src="scm_tab/scm_tab_client.js"></script>
    <script type="text/javascript" src="scm_tab/invoice.js"></script>
    <style type="text/css">@import url(scm_tab/invoice.css);</style>


</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>


<div id="div_scm_tab"></div>

<?php include 'footer.php';?>

</body>
</html>
