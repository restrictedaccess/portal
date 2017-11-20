<?php
include("activecalendar.php");
$yearID=false;
$monthID=false;
$dayID=false;
$showcal=false;
$suiteurl="cal2.php";
extract($_GET);
$cal=new activeCalendar($yearID,$monthID,$dayID);
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head><title>Active Calendar Class Testsuite</title>
<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"activecalendar.css\"></link>\n";
?>
<style type="text/css">
<!--
.code {font-family: "Courier New", Courier, Arial, mono; font-size: 12px; font-weight: bold; color: #000099; text-align: right}
.explain {font-family: Tahoma, Arial, mono; font-size: 12px; font-weight: bold; color: #000000; text-align: left}
.explain2 {font-family: "Courier New", Courier, Arial, mono; font-size: 12px; font-weight: bold; color: #000099; text-align: left}
.mtable {border-width: 2px; border-style:outset; border-color: #eeeeee;}
.small { font-family: Helvetica, Tahoma, Arial, sans-serif; font-size: 10px}
-->
</style>
</head>
<body>
<center>
<h2>Active Calendar Class Testsuite v1.0</h2>
<?php
$out="<a href=\"".$suiteurl."\">Check another function</a>";
$out.="<table><tr><td bgcolor=\"#ffff99\" class=\"code\">";
$out.="Functions <b>setEventContent(2008,5,11,\"some content\") + showMonth(2007,1)</b> generate the following calendar:";
$out.="</td></tr></table><br />";
$cal->enableMonthNav($suiteurl);
/*
$cal->setEventContent(2008,5,11,"<a href='test.php'>bookme</a>");
$cal->setEventContent(2008,5,13,"<a href='test.php'>bookme</a>");
$cal->setEventContent(2008,5,16,"<a href='test.php'>bookme</a>");
$cal->setEventContent(2008,8,12,"<a href='test.php'>Birthday ko</a>");
*/
$cal->setEventContent(2008,5,11,"some content");$cal->showMonth(2008,5);
$out.=$cal->showMonth();
$out.="<br /><a href=\"http://validator.w3.org/check?uri=referer\" target=\"_blank\">Validate this XHTML <span class=\"small\">(results in a new window)</span></a>";
echo $out;


?>
<hr></hr>
<table width="100%" border="0" bgcolor="#ffffff">
<tr>
<td class="small" align="center">
<a href="http://freshmeat.net/redir/activecalendar/53267/url_demo/index.html" class="small">Active Calendar Class Online (documentation, demo, contact, downloads)</a>
</td>
</tr>
<tr>
<td class="small" align="center">
&copy; Giorgos Tsiledakis, Greece Crete
</td>
</tr>
</table>
<hr></hr>
</center>
</body>
</html>
