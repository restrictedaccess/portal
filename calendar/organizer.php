<?

include '../../config.php';

include '../../function.php';

include '../../conf.php';

//include '../../time.php';

//include("../activecalendar.php");



$mess="";

$mess=$_REQUEST['mess'];



$i=$_REQUEST['i'];

$mode=$_REQUEST['mode'];

$agent_no = $_SESSION['agent_no'];

$leads_id=$_REQUEST['leads_id'];

$url=$_REQUEST['url'];



$monthview=$_REQUEST['monthview'];

$weekview=$_REQUEST['weekview'];



//$eventmonth = date("m");

//$eventmonth2 = date("M");

//$eventday = date("d");

//$eventyear = date("Y");

//$hour = date("h");





//id, agent_no, cmonth, cday, cyear, title, details, date_created

$query="SELECT * FROM calendar WHERE id = $i;";

$result=mysql_query($query);

$ctr=@mysql_num_rows($result);

if ($ctr >0 )

{

	$row = mysql_fetch_array($result);

	$month = $row['cmonth'];

	$day = $row['cday'];

	$year = $row['cyear'];

	$title2 = $row['title'];

	$details =$row['details'];

	$hour =$row['ctime'];



}	







$monthnamesArray=array("-","JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");

for ($i = 0; $i < count($monthnamesArray); $i++)

{

 if($month == $i)

  {

 $monthnameoptions .= "<option selected value=\"$i\">$monthnamesArray[$i]</option>\n";

  }

  else

  {

 $monthnameoptions .= "<option value=\"$i\">$monthnamesArray[$i]</option>\n";

  }

}  



for ($i = 1; $i <=31; $i++)

{

 if($day == $i)

  {

 $numoptions .= "<option selected value=\"$i\">$i</option>\n";

  }

  else

  {

 $numoptions .= "<option value=\"$i\">$i</option>\n";

  }

}  



$yearArray=array("2008","2009","2010","2011","2012");

for ($i = 0; $i < count($yearArray); $i++)

{

 if($year == $yearArray[$i])

  {

 $yearoptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";

  }

  else

  {

 $yearoptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";

  }

}  



$hourNames=array("1:00AM","2:00AM","3:00AM","4:00AM","5:00AM","6:00AM","7:00AM","8:00AM","9:00AM","10:00AM","11:00AM","12:00PM","1:00PM","2:00PM","3:00PM","4:00PM","5:00PM","6:00PM","7:00PM","8:00PM","9:00PM","10:00PM","11:00PM","12:00AM");

$hourArray=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");



for ($i = 0; $i < count($hourArray); $i++)

{

 if($hour == $hourArray[$i])

  {

 $houroptions .= "<option selected value=\"$hourArray[$i]\">$hourNames[$i]</option>\n";

  }

  else

  {

 $houroptions .= "<option value=\"$hourArray[$i]\">$hourNames[$i]</option>\n";

  }

}  









require_once("../../activecalendar.php");

require_once("../../activecalendarweek.php");

// for Week view configuration



$myurl=$_SERVER['PHP_SELF']; // the links url is this page

$yearID=false; // init false to display current year

$monthID=false; // init false to display current month

$dayID=false; // init false to display current day

extract($_GET); // get the new values (if any) of $yearID,$monthID,$dayID

$arrowBack="<img src=\"../images/back.png\" border=\"0\" alt=\"&lt;&lt;\" />"; // use png arrow back

$arrowForw="<img src=\"../images/forward.png\" border=\"0\" alt=\"&gt;&gt;\" />"; // use png arrow forward

$cal = new activeCalendar($yearID,$monthID,$dayID);

$cal->enableMonthNav($myurl,$arrowBack,$arrowForw); // enables navigation controls

$cal->enableDatePicker(2000,2010,$myurl); // enables date picker (year range 2000-2010)







?>



<html>

<head>

<title>Organizer</title>

<link rel=stylesheet type=text/css href="../../css/font.css">

<link rel="stylesheet" type="text/css" href="../../css/antique_wide.css" />

<link rel=stylesheet type=text/css href="../../css/style.css">

<link rel=stylesheet type=text/css href="../../menu.css">



<script type="text/javascript" src="../../js/calendar.js"></script> 

<script type="text/javascript" src="../../lang/calendar-en.js"></script> 

<script type="text/javascript" src="../../js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />



<script type="text/javascript">

<!--

function checkFields()

{

		missinginfo = "";

	if (document.form.title.value=="")

	{

		missinginfo += "\n     -  Please enter a subject title .";

	}

	if (document.form.event_date.value=="")

	{

		missinginfo += "\n     -  Please enter a date.";

	}

	if (document.form.time.selectedIndex==0)

	{

		missinginfo += "\n     -  Please enter event time .";

	}

	if (document.form.desc.value=="")

	{

		missinginfo += "\n     -  Please enter event details .";

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

	

	

	

</head>





<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">





<script language=javascript src="../../js/functions.js"></script>





<!-- HEADER -->

<? include '../header.php';?>

<table width="100%" >

<tr>



<td width="76%" height="100%" valign="top" align="left">

<!-- calendar here-->

sadfadsadfsafsaf



<!-- calendar ends here -->




</td>

</tr>

</table>

<? include '../footer.php';?>	

	

</body>

</html>

