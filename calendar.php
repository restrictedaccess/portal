<?php
include("activecalendar.php");
$yearID=false;
$monthID=false;
$dayID=false;
$showcal=false;
$suiteurl="calendar.php";
extract($_GET);
$cal=new activeCalendar($yearID,$monthID,$dayID);
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head><title>Active Calendar Class Testsuite</title>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/activecalendar1.css\"></link>\n";
?>

</head>
<body>
<center>

<?php
$cal->enableMonthNav($suiteurl);
$cal->setEventContent(2008,5,11,"<a href='test.php'>bookme</a>");
$cal->setEventContent(2008,5,13,"<a href='test.php'>bookme</a>");
$cal->setEventContent(2008,5,16,"<a href='test.php'>bookme</a>");
$cal->setEventContent(2008,8,12,"<a href='test.php'>Birthday ko</a>");
$calendar =$cal->showMonth();
echo $calendar;
?>
</center>
</body>
</html>
