<?php

include("activecalendar.php");
$myurl=$_SERVER['PHP_SELF']; // the links url is this page in this case
$yearID=false; // GET variable for the year (set in Active Calendar Class), init false to display current year
$monthID=false; // GET variable for the month (set in Active Calendar Class), init false to display current month
$dayID=false; // GET variable for the day (set in Active Calendar Class), init false to display current day
extract($_GET);
$cal=new activeCalendar($yearID,$monthID,$dayID);
?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<link rel="stylesheet" type="text/css" href="activecalendar.css" />
<center>
<?php 
$cal->enableYearNav(); // this enables the year's navigation controls
$cal->enableDatePicker(2002,2006,$myurl); // this enables the date picker controls
$cal->enableDayLinks($myurl); // this enables the day links
echo $cal->showYear(); // this displays the year's view
?>
</center>
