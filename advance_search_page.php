 <?



include './config.php';

include './conf.php';

include './time.php';

include './function.php';

putenv("TZ=Australia/Sydney");

//echo "here";







$agent_no = $_SESSION['agent_no'];



if($_SESSION['agent_no']=="")



{



	header("location:./index.php");



}







$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));



mysql_query('SET time_zone='.$timeZone);







$AusTime = date("H:i:s"); 



$AusDate = date("Y")."-".date("m")."-".date("d");



$AustodayDate = date ("jS \of F Y");



$ATZ = $AusDate." ".$AusTime;







/// Check the Business Partners TO DO's List and Calendar



$sqlCheckTodo="SELECT l.fname,l.lname ,t.id, t.date_created, t.subject, DATE_FORMAT(t.start_date,'%D %b %Y'), DATE_FORMAT(t.due_date,'%D %b %Y'), t.percentage, t.details



FROM todo t



LEFT OUTER JOIN leads l ON lead_id = l.id



WHERE agent_no = $agent_no AND due_date >= '$AusDate';";



$result_sql_1 =mysql_query($sqlCheckTodo);



$count1=@mysql_num_rows($result_sql_1);



//echo $count1;



$sqlCheckCalendar="SELECT l.fname,l.lname ,c.title,c.details,ctime,DATE_FORMAT(event_date,'%D %b %Y')



FROM calendar c



LEFT OUTER JOIN leads l ON lead_id = l.id WHERE agent_no = $agent_no AND event_date >='$AusDate';";



$result_sql_2 =mysql_query($sqlCheckCalendar);



$count2=@mysql_num_rows($result_sql_2);











$total_count=$count1+$count2;



///























$action=$_REQUEST['action'];







$month=$_REQUEST['month'];



$yesterday=$_REQUEST['yesterday'];



$this_day=$_REQUEST['this_day'];



$tomorrow=$_REQUEST['tomorrow'];



$day=$_REQUEST['day'];



$event_date =$_REQUEST['event_date'];



//$searchDate=$_REQUEST['searchDate'];



//echo $event_date;



//echo $month;



switch($month)



	{



		case '01':



		$bmonth= "January";



		break;



		case '02':



		$bmonth= "February";



		break;



		case '03':



		$bmonth= "March";



		break;



		case '04':



		$bmonth= "April";



		break;



		case '05':



		$bmonth= "May";



		break;



		case '06':



		$bmonth= "June";



		break;



		case '07':



		$bmonth= "July";



		break;



		case '08':



		$bmonth= "August";



		break;



		case '09':



		$bmonth= "September";



		break;



		case '10':



		$bmonth= "October";



		break;



		case '11':



		$bmonth= "November";



		break;



		case '12':



		$bmonth= "December";



		break;



		



	}







if($this_day=="" && $yesterday=="" && $tomorrow=="" && $event_date=="")



{



	$this_day="TRUE";



}







if ($this_day=="TRUE")



{



	$this_day="TRUE";



	$current ="Current";



	$day=0;



}







if($yesterday=="TRUE" && $this_day=="")



{



	$day=$day+1;



	$current ="Previous";



	if($day==0){



	$current ="Current";



	}



}







if($tomorrow=="TRUE" && $this_day=="")



{



	$day=$day-1;



	$current ="Next";



	if($day==0){



	$current ="Current";



	}



}















/*



agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/



$query="SELECT * FROM agent WHERE agent_no =$agent_no;";







$result=mysql_query($query);



$ctr=@mysql_num_rows($result);



if ($ctr >0 )



{



	$row = mysql_fetch_array ($result); 



	$name = $row['fname']." ".$row['lname'];



	$agent_code = $row['agent_code'];



	$length=strlen($agent_code);



	



}











$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");



$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");



 for ($i = 0; $i < count($monthArray); $i++)



  {



      if($month == $monthArray[$i])



      {



	 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";



      }



      else



      {



	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";



      }



   }







if(isset($_POST['save']))



{



	$action_record = $_REQUEST['action_record'];



	$quantity =$_REQUEST['quantity']; 



	$txt = $_REQUEST['txt'];



	$txt=filterfield($txt);



	



	$sqlCheck="SELECT id, quantity,history 



				FROM manual_history 



				WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' 



				AND actions = '$action_record' 



				AND agent_no =$agent_no;";



				



	$result1=mysql_query($sqlCheck);



	$ctr=@mysql_num_rows($result1);



	if ($ctr >0 )



	{



		list($id,$quantities,$history)=mysql_fetch_array($result1);	



		$total = $quantities + $quantity;



		$history.="<br>".$txt;



		$sql="UPDATE manual_history SET quantity = $total ,



					history = '$history'



					WHERE id = $id 



					AND DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' 



					AND actions = '$action_record' 



					AND agent_no =$agent_no;";



	}



	else {



		



		$sql="INSERT INTO manual_history SET agent_no = $agent_no, 



						actions = '$action_record', 



						history = '$txt', 



						date_created = '$ATZ', 



						quantity = $quantity ;";



	



	}



	$result = mysql_query($sql);						



	if(!$result)



	{



		echo ("Query: $queryInsert\n<br />MySQL Error: " . mysql_error());



	}



	else



	{



		echo("<html><head><script>function update(){top.location='agentHome.php';}var refresh=setInterval('update()',1200);



	</script></head><body onload=refresh><body></html>");



	}



	







						



}



//email_update  call_update notes_update meeting_update



// id, agent_no, actions, history, date_created, quantity, quantity2



if(isset($_POST['email_update']))



{



	$quantity2=$_REQUEST['quantity2'];



	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'EMAIL' AND agent_no =$agent_no;";



	$result =mysql_query($checkSql);



	$row = mysql_fetch_array($result);



	$counter = $row[0];



	if($counter >0 ){



		$sql="UPDATE manual_history SET quantity2 = $quantity2 WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'EMAIL' AND agent_no =$agent_no;";



	}else{



		$sql="INSERT INTO manual_history SET quantity2 = $quantity2 , date_created = '$ATZ' , actions = 'EMAIL' , agent_no = $agent_no;";



	}	



	//echo $sql;



	mysql_query($sql);



}



if(isset($_POST['call_update']))



{



	$quantity3=$_REQUEST['quantity3'];



	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'CALL' AND agent_no =$agent_no;";



	$result =mysql_query($checkSql);



	$row = mysql_fetch_array($result);



	$counter = $row[0];



	if($counter >0 ){



		$sql2="UPDATE manual_history SET quantity2 = $quantity3 WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'CALL' AND agent_no =$agent_no;";



	}else{



		$sql2="INSERT INTO manual_history SET quantity2 = $quantity3 , date_created = '$ATZ' , actions = 'CALL' , agent_no = $agent_no;";



	}



	//echo $sql2; 



	mysql_query($sql2);



}







if(isset($_POST['notes_update']))



{



	$quantity4=$_REQUEST['quantity4'];



	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MAIL' AND agent_no =$agent_no;";



	$result =mysql_query($checkSql);



	$row = mysql_fetch_array($result);



	$counter = $row[0];



	if($counter >0 ){



		$sql3="UPDATE manual_history SET quantity2 = $quantity4  WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MAIL' AND agent_no =$agent_no;";



	}else{



		$sql3="INSERT INTO manual_history SET quantity2 = $quantity4 , date_created = '$ATZ' , actions = 'MAIL' , agent_no = $agent_no;";



	}	



	mysql_query($sql3);



}







if(isset($_POST['meeting_update']))



{



	$quantity5=$_REQUEST['quantity5'];



	$checkSql="SELECT COUNT(id) FROM manual_history WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MEETING FACE TO FACE' AND agent_no =$agent_no;";



	$result =mysql_query($checkSql);



	$row = mysql_fetch_array($result);



	$counter = $row[0];



	if($counter >0 ){



		$sql4="UPDATE manual_history SET quantity2 = $quantity5 WHERE DATE_FORMAT(date_created,'%Y-%m-%d') = '$AusDate' AND actions = 'MEETING FACE TO FACE' AND agent_no =$agent_no;";



	}else{



		$sql4="INSERT INTO manual_history SET quantity2 = $quantity5 , date_created = '$ATZ' , actions = 'MEETING FACE TO FACE' , agent_no = $agent_no;";



	}	



	mysql_query($sql4);



}













if ($month=="") {



if ($event_date =="")

{

$sqlDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%W'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e'),

DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%D %M %Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%c'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e')";

//echo "<p>".$sqlDay."</p>";

$result=mysql_query($sqlDay);

list($dayname,$date,$date2,$cyear,$cmonth,$cday)=mysql_fetch_array($result);

$event_date=$cyear."-".$cmonth."-".$cday;

}

if ($event_date!="")

{

	$searchDate=$event_date;

	$sqlDay="SELECT DATE_FORMAT('$searchDate','%W %D %M %Y'),DATE_FORMAT('$searchDate','%Y'),DATE_FORMAT('$searchDate','%c'),DATE_FORMAT('$searchDate','%e')";

	//echo $sqlDay;

	$result=mysql_query($sqlDay);

	list($dayname,$cyear,$cmonth,$cday)=mysql_fetch_array($result);

}



$conditions ="AND YEAR(date_created) = '$cyear' AND  MONTH(date_created) = '$cmonth' AND DAY(date_created) ='$cday'";

$conditions2 ="AND YEAR(timestamp) = '$cyear' AND  MONTH(timestamp) = '$cmonth' AND DAY(timestamp) ='$cday'";



}

if($month!="")

{

	//echo $month;

	$conditions ="AND  MONTH(date_created) = '$month' ";

	$conditions2 ="AND MONTH(timestamp) = '$month'";

	$current ="Monthly (".$bmonth.")";





}





?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<title>Business Partner</title>

<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="menu.css">

<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>



<script type="text/javascript" src="js/calendar.js"></script> 

<script type="text/javascript" src="lang/calendar-en.js"></script> 

<script type="text/javascript" src="js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script src="select_addControl.js"></script>	

<script src="selectRecords.js"></script>







<!-- ROY'S CODE ------------------->

		<script language="javascript">

		var chck = 0;

		var temp = '';

		var int=self.setInterval('check_schedule(temp)',9000)	

		var curSubMenu = '';	

		function check_schedule(id)

		{

			chck = 0;

			http.open("GET", "return_schedule.php?id="+id, true);

			http.onreadystatechange = handleHttpResponse;

			http.send(null);

		}

		function hideAlarm(id)

		{

			chck = 0;

			document.getElementById('support_sound_alert').innerHTML='';

			document.getElementById('alarm').style.visibility='hidden';

			check_schedule(id);

		}

		//ajax



		function handleHttpResponse() 

		{

			if (http.readyState == 4) 

			{

				var temp = http.responseText;

				if(temp == "" || temp == '')

				{

					//do nothing

					//document.getElementById('support_sound_alert').innerHTML = "";

				}

				else

				{

					document.getElementById('alarm').innerHTML = http.responseText;			

					document.getElementById('alarm').style.visibility='visible';							

					//if(chck == 0)

					//{

						//document.getElementById('support_sound_alert').innerHTML = "<EMBED SRC='calendar/media/crawling.mid' hidden=true autostart=true loop=1>";

						//chck = 1;

					//}

				}	

			}

		}

		function getHTTPObject() 

		{

					var x 

					var browser = navigator.appName 

					if(browser == 'Microsoft Internet Explorer'){

						x = new ActiveXObject('Microsoft.XMLHTTP')

					}

					else

					{

						x = new XMLHttpRequest()

					}

					return x		

		}

		var http = getHTTPObject();		

		//ajax		

		

		//menu

		//var curSubMenu='';

		function showSubMenu(menuId){

				document.getElementById('id_two').style.visibility='visible';	

				if (curSubMenu!='') hideSubMenu();

				eval('document.all.id_two').style.visibility='visible';

				curSubMenu=menuId;

		}

		

		function hideSubMenu(){

				document.getElementById('id_two').style.visibility='hidden';

				eval('document.all.'+curSubMenu).style.visibility='hidden';

				curSubMenu='';

		}

		//menu		

		

		

		</script>		

<!-- ROY'S CODE ------------------->	

		















<style type="text/css">



<!--



div.scroll {



	height: 100%;



	width: 100%;



	overflow: auto;



	padding: 8px;



	



}



.tableContent tr:hover



{



	background:#FFFFCC;



	



}







.tablecontent tbody tr:hover {



  background: #FFFFCC;



  }



  



.remind_data{



font:9px tahoma;



padding:3px;



}  







.remind_label{



font:9px tahoma;



} 







.remind_tr{



border:#CCCCCC solid 1px;



}



-->



</style>



	



	



</head>











<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<form method="POST" name="form" action="agentHome.php">

<!-- HEADER -->

<? include 'header.php';?>







<? include 'BP_header.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>

<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>



</tr>



<tr>



<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>

<? include 'agentleftnav.php';?>

</td>

<td width=100% valign=top >

<!-- Contents Here -->

<div style="font:12px Arial; margin:3px;">

<div style="background:#CCCCCC; border:#CCCCCC outset 1px; padding:3px;">

Advance Search</b></div>





















<table width="100%">
	<tr>
		<td width="50%" valign="top">


										<table width="100%">							
											<tr >
												<td colspan=3 valign="top" >
														<iframe id="frame" name="frame" width="100%" height="500" src="advance_search.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
												</td>	
											</tr>
										</table>			


		</td>		
	</tr>	
</table>



















</td>

</tr>

</table>





<? include 'footer.php';?>



</form>	



<!-- ROY'S CODE -------------------><!-- ALARM BOX -->

<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>

<div id="support_sound_alert"></div>

<!-- ROY'S CODE -------------------><!-- ALARM BOX -->



</body>

</html>



