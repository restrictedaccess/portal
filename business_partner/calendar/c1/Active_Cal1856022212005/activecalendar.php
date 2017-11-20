<?php

class activeCalendar{
var $jan="January";
var $feb="February";
var $mar="March";
var $apr="April";
var $may="May";
var $jun="June";
var $jul="July";
var $aug="August";
var $sep="September";
var $oct="October";
var $nov="November";
var $dec="December";
var $sun="Sun";
var $mon="Mon";
var $tue="Tue";
var $wed="Wed";
var $thu="Thu";
var $fri="Fri";
var $sat="Sat";
/*
********************************************************************************
You can change below the default year's and month's view navigation controls
********************************************************************************
*/
var $yearNavBack=" &lt;&lt; "; // Previous year, this could be an image link
var $yearNavForw=" &gt;&gt; "; // Next year, this could be an image link
var $monthNavBack=" &lt;&lt; "; // Previous month, this could be an image link
var $monthNavForw=" &gt;&gt; "; // Next month, this could be an image link
var $selBtn="Go"; // value of the date picker button (if enabled)
var $monthYearDivider=" "; // the divider between month and year in the month`s title
/*
********************************************************************************
$startOnSun = false: first day of week is Monday
$startOnSun = true: first day of week is Sunday
********************************************************************************
*/
var $startOnSun=false;
/*
********************************************************************************
$rowCount : defines the number of months in a row in yearview ( can be also set by the method showYear() )
********************************************************************************
*/
var $rowCount=4;
/*
********************************************************************************
Names of the generated html classes. You may change them to avoid any conflicts with your existing CSS
********************************************************************************
*/
var $cssYearTable="year"; // table tag: calendar year
var $cssYearTitle="yearname"; // td tag: calendar year title
var $cssYearNav="yearnavigation"; // td tag: calendar year navigation
var $cssMonthTable="month"; // table tag: calendar month
var $cssMonthTitle="monthname"; // td tag: calendar month title
var $cssMonthNav="monthnavigation"; // td tag: calendar month navigation
var $cssWeekDay="dayname"; // tr tag: calendar weekdays
var $cssPicker="datepicker"; // td tag: date picker
var $cssPickerForm="datepickerform"; // form tag: date picker form
var $cssPickerMonth="monthpicker"; // select tag: month picker
var $cssPickerYear="yearpicker"; // select tag: year picker
var $cssPickerButton="pickerbutton"; // input (submit) tag: date picker button
var $cssMonthDay="monthday"; // td tag: days, that belong to the current month
var $cssNoMonthDay="nomonthday"; // td tag: days, that do not belong to the current month
var $cssToday="today"; // td tag: the current day
var $cssSelecDay="selectedday"; // td tag: the selected day
var $cssSunday="sunday"; // td tag: all Sundays (can be disabled, see below)
var $cssSaturday="saturday"; // td tag: all Saturdays (can be disabled, see below)
var $cssEvent="event"; // td tag: event day set by setEvent(). Multiple class names can be generated
var $cssPrefixSelecEvent="selected"; // prefix for the event class name if the event is selected
var $cssPrefixTodayEvent="today"; //  prefix for the event class name if the event is the current day
var $cssEventContent="eventcontent"; // table tag: calendar event content
var $crSunClass=true; // true: creates a td class on every Sunday (set above)
var $crSatClass=true; // true: creates a td class on every Saturday (set above)
/*
********************************************************************************
You can change below the GET VARS NAMES (navigation + day links)
You should modify the private method mkUrl(), if you want to change the structure of the generated links
********************************************************************************
*/
var $yearID="yearID";
var $monthID="monthID";
var $dayID="dayID";
/*
********************************************************************************
Default start and end year for the date picker (can be changed, if using the ADOdb Date Library)
********************************************************************************
*/
var $startYear=1971;
var $endYear=2037;
/*
----------------------
@START PUBLIC METHODS
----------------------
*/
/*
********************************************************************************
PUBLIC activeCalendar() -> class constructor, does the initial date calculation
********************************************************************************
*/
function activeCalendar($year=false,$month=false,$day=false){
$this->selectedday=-2;
$this->selectedyear=$year;
$this->selectedmonth=$month;
	if (!$month) $month=1;
	if (!$day) $day=1;
	else $this->selectedday=$day;
$this->unixtime=$this->mkActiveTime(0,0,1,$month,$day,$year);
	if ($this->unixtime==-1 || !$year) $this->unixtime=time();
$this->daytoday=$this->mkActiveDate("j");
$this->monthtoday=$this->mkActiveDate("n");
$this->yeartoday=$this->mkActiveDate("Y");
$this->actday=$this->mkActiveDate("j",$this->unixtime);
$this->actmonth=$this->mkActiveDate("n",$this->unixtime);
$this->actyear=$this->mkActiveDate("Y",$this->unixtime);
$this->has31days=checkdate($this->actmonth,31,$this->actyear);
$this->isSchalt=checkdate(2,29,$this->actyear);
	if ($this->isSchalt==1 && $this->actmonth==2) $this->maxdays=29;
	elseif ($this->isSchalt!=1 && $this->actmonth==2) $this->maxdays=28;
	elseif ($this->has31days==1) $this->maxdays=31;
	else $this->maxdays=30;
$this->firstday=$this->mkActiveDate("w", $this->mkActiveTime(0,0,1,$this->actmonth,1,$this->actyear));
}
/*
********************************************************************************
PUBLIC enableYearNav() -> enables the year's navigation controls
********************************************************************************
*/
function enableYearNav($link=false,$arrowBack=false,$arrowForw=false){
	if ($link) $this->urlNav=$link;
	else $this->urlNav=$_SERVER['PHP_SELF'];
	if ($arrowBack) $this->yearNavBack=$arrowBack;
	if ($arrowForw) $this->yearNavForw=$arrowForw;
$this->yearNav=true;
}
/*
********************************************************************************
PUBLIC enableMonthNav() -> enables the month's navigation controls
********************************************************************************
*/
function enableMonthNav($link=false,$arrowBack=false,$arrowForw=false){
	if ($link) $this->urlNav=$link;
	else $this->urlNav=$_SERVER['PHP_SELF'];
	if ($arrowBack) $this->monthNavBack=$arrowBack;
	if ($arrowForw) $this->monthNavForw=$arrowForw;
$this->monthNav=true;
}
/*
********************************************************************************
PUBLIC enableDayLinks() -> enables the day links
param javaScript: sets a Javascript function on each day link
********************************************************************************
*/
function enableDayLinks($link=false,$javaScript=false){
	if ($link) $this->url=$link;
	else $this->url=$_SERVER['PHP_SELF'];
	if ($javaScript) $this->javaScriptDay=$javaScript;
$this->dayLinks=true;
}
/*
********************************************************************************
PUBLIC enableDatePicker() -> enables the day picker control
********************************************************************************
*/
function enableDatePicker($startYear=false,$endYear=false,$link=false,$button=false){
	if ($link) $this->urlPicker=$link;
	else $this->urlPicker=$_SERVER['PHP_SELF'];
	if ($startYear && $endYear){
		if ($startYear>=$this->startYear && $startYear<$this->endYear) $this->startYear=$startYear;
		if ($endYear>$this->startYear && $endYear<=$this->endYear) $this->endYear=$endYear;
	}
	if ($button) $this->selBtn=$button;
$this->datePicker=true;
}
/*
********************************************************************************
PUBLIC setEvent() -> sets a calendar event, $id: the HTML class (css layout)
********************************************************************************
*/
function setEvent($year,$month,$day,$id=false,$url=false){
$eventTime=$this->mkActiveTime(0,0,1,$month,$day,$year);
	if (!$id) $id=$this->cssEvent;
$this->calEvents[$eventTime]=$id;
$this->calEventsUrl[$eventTime]=$url;
}
/*
********************************************************************************
PUBLIC setEventContent() -> sets a calendar event content, $content: can be a string or an array
********************************************************************************
*/
function setEventContent($year,$month,$day,$content,$url=false){
$eventTime=$this->mkActiveTime(0,0,1,$month,$day,$year);
$eventContent[$eventTime]=$content;
$eventUrl[$eventTime]=$url;
$this->calEventContent[]=$eventContent;
	if ($url) $this->calEventContentUrl[]=$url;
	else $this->calEventContentUrl[]=$this->calInit++;
}
/*
********************************************************************************
PUBLIC setMonthNames() -> sets the month names, $namesArray must be an array of 12 months starting with January
********************************************************************************
*/
function setMonthNames($namesArray){
	if (!is_array($namesArray) || count($namesArray)!=12) return false;
	else $this->monthNames=$namesArray;
}
/*
********************************************************************************
PUBLIC setDayNames() -> sets the week day names, $namesArray must be an array of 7 days starting with Sunday
********************************************************************************
*/
function setDayNames($namesArray){
	if (!is_array($namesArray) || count($namesArray)!=7) return false;
	else $this->dayNames=$namesArray;
}
/*
********************************************************************************
PUBLIC showYear() -> returns the year's view as html table string
Each private method returns a tr tag of the table as a string.
You can change the calendar structure by simply calling these private methods in another order
********************************************************************************
*/
function showYear($rowCount=false){
	if ($rowCount) $this->rowCount=$rowCount;
$this->monthNav=false; // disables month navigation in yearview
$out=$this->mkYearHead(); // this should remain first: opens table tag
$out.=$this->mkYearTitle(); // tr tag: year title and navigation
$out.=$this->mkDatePicker("yearonly"); // tr tag: year date picker (only year selection)
$this->datePicker=false; // disables month date picker in yearview
$out.=$this->mkYearBody(); // tr tag(s): year month (html tables)
$out.=$this->mkYearFoot(); // this should remain last: closes table tag
return $out;
}
/*
********************************************************************************
PUBLIC showMonth() -> returns the month's view as html table string
Each private method returns a tr tag of the table as a string.
You can change the calendar structure by simply calling these private methods in another order
********************************************************************************
*/
function showMonth(){
$out=$this->mkMonthHead(); // this should remain first: opens table tag
$out.=$this->mkMonthTitle(); // tr tag: month title and navigation
$out.=$this->mkDatePicker(); // tr tag: month date picker (month and year selection)
$out.=$this->mkWeekDays(); // tr tag: the weekday names
$out.=$this->mkMonthBody(); // tr tags: the days of the month
$out.=$this->mkMonthFoot(); // this should remain last: closes table tag
return $out;
}
/*
----------------------
@START PRIVATE METHODS
----------------------
*/
/*
********************************************************************************
THE FOLLOWING METHODS AND VARIABLES ARE PRIVATE. PLEASE DO NOT CALL OR MODIFY THEM
********************************************************************************
*/
var $yearNav=false;
var $monthNav=false;
var $dayLinks=false;
var $datePicker=false;
var $url=false;
var $urlNav=false;
var $urlPicker=false;
var $calEvents=false;
var $calEventsUrl=false;
var $eventUrl=false;
var $javaScriptDay=false;
var $monthNames=false;
var $dayNames=false;
var $calEventContent=false;
var $calEventContentUrl=false;
var $calInit=0;
/*
********************************************************************************
PRIVATE mkYearHead() -> creates the year table tag
********************************************************************************
*/
function mkYearHead(){
return "<table class=\"".$this->cssYearTable."\">\n";
}
/*
********************************************************************************
PRIVATE mkYearTitle() -> creates the tile and navigation tr tag of the year table
********************************************************************************
*/
function mkYearTitle(){
	if ($this->rowCount<1 || $this->rowCount>12) $this->rowCount=4;
	if (!$this->yearNav){
		$out="<tr><td colspan=\"".$this->rowCount."\" class=\"".$this->cssYearTitle."\">";
		$out.=$this->actyear;
		$out.="</td></tr>\n";
	}
	else{
		$out="<tr><td colspan=\"".$this->rowCount."\" align=\"center\">";
		$out.="<table><tr><td class=\"".$this->cssYearNav."\">";
		$out.=$this->mkUrl($this->actyear-1);
		$out.=$this->yearNavBack."</a></td>";
		$out.="<td class=\"".$this->cssYearTitle."\">".$this->actyear."</td>";
		$out.="<td class=\"".$this->cssYearNav."\">";
		$out.=$this->mkUrl($this->actyear+1);
		$out.=$this->yearNavForw."</a></td></tr></table></td></tr>\n";
	}
return $out;
}
/*
********************************************************************************
PRIVATE mkYearBody() -> creates the tr tags of the year table
********************************************************************************
*/
function mkYearBody(){
$TrMaker = $this->rowCount;
$out="<tr>\n";
	for ($x=1; $x<=12; $x++) {
		$this->activeCalendar($this->actyear,$x);
		$out.="<td valign=\"top\">\n".$this->showMonth()."</td>\n";
		//if ($x == $TrMaker && $x < 12) {
			$out.="</tr><tr>";
			//$TrMaker = ($TrMaker+$this->rowCount);
		//}
	}
$out.="</tr>\n";
return $out;
}
/*
********************************************************************************
PRIVATE mkYearFoot() -> closes the year table tag
********************************************************************************
*/
function mkYearFoot(){
return "</table>\n";
}
/*
********************************************************************************
PRIVATE mkMonthHead() -> creates the month table tag
********************************************************************************
*/
function mkMonthHead(){
return "<table class=\"".$this->cssMonthTable."\">\n";
}
/*
********************************************************************************
PRIVATE mkMonthTitle() -> creates the tile and navigation tr tag of the month table
********************************************************************************
*/
function mkMonthTitle(){
	if (!$this->monthNav){
		$out="<tr><td class=\"".$this->cssMonthTitle."\" colspan=\"7\">";
		$out.=$this->getMonthName().$this->monthYearDivider.$this->actyear;
		$out.="</td></tr>\n";
	}
	else{
		$out="<tr><td class=\"".$this->cssMonthNav."\" colspan=\"2\">";
		if ($this->actmonth==1) $out.=$this->mkUrl($this->actyear-1,"12");
		else $out.=$this->mkUrl($this->actyear,$this->actmonth-1);
		$out.=$this->monthNavBack."</a></td>";
		$out.="<td class=\"".$this->cssMonthTitle."\" colspan=\"3\">";
		$out.=$this->getMonthName().$this->monthYearDivider.$this->actyear."</td>";
		$out.="<td class=\"".$this->cssMonthNav."\" colspan=\"2\">";
		if ($this->actmonth==12) $out.=$this->mkUrl($this->actyear+1,"1");
		else $out.=$this->mkUrl($this->actyear,$this->actmonth+1);
		$out.=$this->monthNavForw."</a></td></tr>\n";
	}
return $out;
}
/*
********************************************************************************
PRIVATE mkDatePicker() -> creates the tr tag for the date picker
********************************************************************************
*/
function mkDatePicker($yearpicker=false){
	if ($yearpicker) $pickerSpan=$this->rowCount;
	else $pickerSpan=7;
	if ($this->datePicker){
		$out="<tr><td class=\"".$this->cssPicker."\" colspan=\"".$pickerSpan."\">\n";
		$out.="<form name=\"".$this->cssPickerForm."\" class=\"".$this->cssPickerForm."\" action=\"".$this->urlPicker."\" method=\"get\">\n";
		if (!$yearpicker){
			$out.="<select name=\"".$this->monthID."\" class=\"".$this->cssPickerMonth."\">\n";
			for ($z=1;$z<=12;$z++){
				if ($z==$this->actmonth) $out.="<option value=\"".$z."\" selected=\"selected\">".$this->getMonthName($z)."</option>\n";
				else $out.="<option value=\"".$z."\">".$this->getMonthName($z)."</option>\n";
			}
			$out.="</select>\n";
		}
		$out.="<select name=\"".$this->yearID."\" class=\"".$this->cssPickerYear."\">\n";
		for ($z=$this->startYear;$z<=$this->endYear;$z++){
			if ($z==$this->actyear) $out.="<option value=\"".$z."\" selected=\"selected\">".$z."</option>\n";
			else $out.="<option value=\"".$z."\">".$z."</option>\n";
		}
		$out.="</select>\n";
		$out.="<input type=\"submit\" value=\"".$this->selBtn."\" class=\"".$this->cssPickerButton."\"></input>\n";
		$out.="</form>\n";
		$out.="</td></tr>\n";
	}
	else $out="";
return $out;
}
/*
********************************************************************************
PRIVATE mkWeekDays() -> creates the tr tag of the month table for the weekdays
********************************************************************************
*/
function mkWeekDays(){
	if ($this->startOnSun){
		$out="<tr class=\"".$this->cssWeekDay."\"><td>".$this->getDayName(0)."</td>";
		$out.="<td>".$this->getDayName(1)."</td>";
		$out.="<td>".$this->getDayName(2)."</td>";
		$out.="<td>".$this->getDayName(3)."</td>";
		$out.="<td>".$this->getDayName(4)."</td>";
		$out.="<td>".$this->getDayName(5)."</td>";
		$out.="<td>".$this->getDayName(6)."</td></tr>\n";
	}
	else{
		$out="<tr class=\"".$this->cssWeekDay."\"><td>".$this->getDayName(1)."</td>";
		$out.="<td>".$this->getDayName(2)."</td>";
		$out.="<td>".$this->getDayName(3)."</td>";
		$out.="<td>".$this->getDayName(4)."</td>";
		$out.="<td>".$this->getDayName(5)."</td>";
		$out.="<td>".$this->getDayName(6)."</td>";
		$out.="<td>".$this->getDayName(0)."</td></tr>\n";
		$this->firstday=$this->firstday-1;
		if ($this->firstday<0) $this->firstday=6;
	}
return $out;
}
/*
********************************************************************************
PRIVATE mkMonthBody() -> creates the tr tags of the month table
********************************************************************************
*/
function mkMonthBody(){
$out="<tr>";
$monthday=0;
	for ($x=0; $x<=6; $x++){
		if ($x>=$this->firstday){
		$monthday++;
		$out.=$this->mkDay($monthday);
		}
		else $out.="<td class=\"".$this->cssNoMonthDay."\"></td>";
	}
$out.="</tr>\n";
$goon=$monthday+1;
$stop=0;
	for ($x=0; $x<=6; $x++){
		if ($goon>$this->maxdays) break;
		if ($stop==1) break;
		$out.="<tr>";
			for ($i=$goon; $i<=$goon+6; $i++){
				if ($i>$this->maxdays){
					$out.="<td class=\"".$this->cssNoMonthDay."\"></td>";
					$stop=1;
				}
				else $out.=$this->mkDay($i);
			}
		$goon=$goon+7;
		$out.="</tr>\n";
	}
$this->selectedday="-2";
return $out;
}
/*
********************************************************************************
PRIVATE mkDay() -> creates each td tag of the month body
********************************************************************************
*/
function mkDay($var){
$eventContent=$this->mkEventContent($var);
$linkstr=$this->mkUrl($this->actyear,$this->actmonth,$var);
	if ($this->javaScriptDay) $linkstr="<a href=\"javascript:".$this->javaScriptDay."(".$this->actyear.",".$this->actmonth.",".$var.")\">".$var."</a>";
	if ($this->isEvent($var)){
		if ($this->eventUrl){
			$out="<td class=\"".$this->eventID."\"><a href=\"".$this->eventUrl."\">".$var."</a>".$eventContent."</td>";
			$this->eventUrl=false;
		}
		elseif (!$this->dayLinks) $out="<td class=\"".$this->eventID."\">".$var.$eventContent."</td>";
		else $out="<td class=\"".$this->eventID."\">".$linkstr.$eventContent."</td>";
	}
	elseif ($var==$this->selectedday && $this->actmonth==$this->selectedmonth && $this->actyear==$this->selectedyear){
		if (!$this->dayLinks) $out="<td class=\"".$this->cssSelecDay."\">".$var.$eventContent."</td>";
		else $out="<td class=\"".$this->cssSelecDay."\">".$linkstr.$eventContent."</td>";
	}
	elseif ($var==$this->daytoday && $this->actmonth==$this->monthtoday && $this->actyear==$this->yeartoday){
		if (!$this->dayLinks) $out="<td class=\"".$this->cssToday."\">".$var.$eventContent."</td>";
		else $out="<td class=\"".$this->cssToday."\">".$linkstr.$eventContent."</td>";
	}
	elseif ($this->getWeekday($var)==0 && $this->crSunClass){
		if (!$this->dayLinks) $out="<td class=\"".$this->cssSunday."\">".$var.$eventContent."</td>";
		else $out="<td class=\"".$this->cssSunday."\">".$linkstr.$eventContent."</td>";
	}
	elseif ($this->getWeekday($var)==6 && $this->crSatClass){
		if (!$this->dayLinks) $out="<td class=\"".$this->cssSaturday."\">".$var.$eventContent."</td>";
		else $out="<td class=\"".$this->cssSaturday."\">".$linkstr.$eventContent."</td>";
	}
	else{
		if (!$this->dayLinks) $out="<td class=\"".$this->cssMonthDay."\">".$var.$eventContent."</td>";
		else $out="<td class=\"".$this->cssMonthDay."\">".$linkstr.$eventContent."</td>";
	}
return $out;
}
/*
********************************************************************************
PRIVATE mkMonthFoot() -> closes the month table
********************************************************************************
*/
function mkMonthFoot(){
return "</table>\n";
}
/*
********************************************************************************
PRIVATE mkUrl() -> creates the day and navigation link structure
********************************************************************************
*/
function mkUrl($year,$month=false,$day=false){
	if (strpos($this->url,"?")) $glue="&amp;";
	else $glue="?";
	if (strpos($this->urlNav,"?")) $glueNav="&amp;";
	else $glueNav="?";
$yearNavLink="<a href=\"".$this->urlNav.$glueNav.$this->yearID."=".$year."\">";
$monthNavLink="<a href=\"".$this->urlNav.$glueNav.$this->yearID."=".$year."&amp;".$this->monthID."=".$month."\">";
$dayLink="<a href=\"".$this->url.$glue.$this->yearID."=".$year."&amp;".$this->monthID."=".$month."&amp;".$this->dayID."=".$day."\">".$day."</a>";
	if ($year && $month && $day) return $dayLink;
	if ($year && !$month && !$day) return $yearNavLink;
	if ($year && $month && !$day) return $monthNavLink;
}
/*
********************************************************************************
PRIVATE mkEventContent() -> creates the table for the event content
********************************************************************************
*/
function mkEventContent($var){
$hasContent=$this->hasEventContent($var);
$out="";
	if ($hasContent){
		foreach($hasContent as $eventContentUrl => $eventContent){
			$out.="<table class=\"".$this->cssEventContent."\">";
			if (is_string($eventContent)){
				if (is_int($eventContentUrl)) $out.="<tr><td>".$eventContent."</td></tr></table>";
				else $out.="<tr><td><a href=\"".$eventContentUrl."\">".$eventContent."</a></td></tr></table>";
			}
			elseif (is_array($eventContent)){
				foreach($eventContent as $arrayContent){
					if (is_int($eventContentUrl)) $out.="<tr><td>".$arrayContent."</td></tr>";
					else $out.="<tr><td><a href=\"".$eventContentUrl."\">".$arrayContent."</a></td></tr>";
				}
				$out.="</table>";
			}
				else $out="";
			}
	}
return $out;
}
/*
********************************************************************************
PRIVATE getMonthName() -> returns the month's name, according to the configuration
********************************************************************************
*/
function getMonthName($var=false){
	if (!$var) $var=@$this->actmonth;
	if ($this->monthNames) return $this->monthNames[$var-1];
	switch($var){
		case 1: return $this->jan;
		case 2: return $this->feb;
		case 3: return $this->mar;
		case 4: return $this->apr;
		case 5: return $this->may;
		case 6: return $this->jun;
		case 7: return $this->jul;
		case 8: return $this->aug;
		case 9: return $this->sep;
		case 10: return $this->oct;
		case 11: return $this->nov;
		case 12: return $this->dec;
	}
}
/*
********************************************************************************
PRIVATE getDayName() -> returns the day's name, according to the configuration
********************************************************************************
*/
function getDayName($var=false){
	if ($this->dayNames) return $this->dayNames[$var];
	switch($var){
		case 0: return $this->sun;
		case 1: return $this->mon;
		case 2: return $this->tue;
		case 3: return $this->wed;
		case 4: return $this->thu;
		case 5: return $this->fri;
		case 6: return $this->sat;
	}
}
/*
********************************************************************************
PRIVATE getWeekday() -> returns the weekday's number, 0 = Sunday ... 6 = Saturday
********************************************************************************
*/
function getWeekday($var){
return $this->mkActiveDate("w", $this->mkActiveTime(0,0,1,$this->actmonth,$var,$this->actyear));
}
/*
********************************************************************************
PRIVATE isEvent() -> checks if a date was set as an event and creates the eventID (css layout) and eventUrl
********************************************************************************
*/
function isEvent($var){
	if ($this->calEvents){
		$checkTime=$this->mkActiveTime(0,0,1,$this->actmonth,$var,$this->actyear);
		$selectedTime=$this->mkActiveTime(0,0,1,$this->selectedmonth,$this->selectedday,$this->selectedyear);
		$todayTime=$this->mkActiveTime(0,0,1,$this->monthtoday,$this->daytoday,$this->yeartoday);
		foreach($this->calEvents as $eventTime => $eventID){
			if ($eventTime==$checkTime){
				if ($eventTime==$selectedTime) $this->eventID=$this->cssPrefixSelecEvent.$eventID;
				elseif ($eventTime==$todayTime) $this->eventID=$this->cssPrefixTodayEvent.$eventID;
				else $this->eventID=$eventID;
				if ($this->calEventsUrl[$eventTime]) $this->eventUrl=$this->calEventsUrl[$eventTime];
				return true;
			}
		}
	return false;
	}
}
/*
********************************************************************************
PRIVATE hasEventContent() -> checks if an event content was set
********************************************************************************
*/
function hasEventContent($var){
$hasContent=false;
	if ($this->calEventContent){
		$checkTime=$this->mkActiveTime(0,0,1,$this->actmonth,$var,$this->actyear);
		for ($x=0;$x<count($this->calEventContent);$x++){
			$eventContent=$this->calEventContent[$x];
			$eventContentUrl=$this->calEventContentUrl[$x];
			foreach($eventContent as $eventTime => $eventContent){
				if ($eventTime==$checkTime) $hasContent[$eventContentUrl]=$eventContent;
			}
		}
	}
return $hasContent;
}
/*
********************************************************************************
PRIVATE mkActiveDate() -> checks if ADOdb Date Library is loaded and calls the date function
********************************************************************************
*/
function mkActiveDate($param,$acttime=false){
	if (!$acttime) $acttime=time();
	if (function_exists("adodb_date")) return adodb_date($param,$acttime);
	else return date($param,$acttime);
}
/*
********************************************************************************
PRIVATE mkActiveTime() -> checks if ADOdb Date Library is loaded and calls the mktime function
********************************************************************************
*/
function mkActiveTime($hr,$min,$sec,$month=false,$day=false,$year=false){
	if (function_exists("adodb_mktime")) return adodb_mktime($hr,$min,$sec,$month,$day,$year);
	else return mktime($hr,$min,$sec,$month,$day,$year);
}
}
?>
