<?
/*	File: timezone.php
 *	By: Tom Watts
 *	Email: wattst@uoguelph.ca or tomwatts@secondsite.biz
 *	GPL:
 *	This script is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU Lesser General Public License as published by
 *	the Free Software Foundation; either version 2.1 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Lesser General Public License for more details.
 *
 *	You can receive a copy of GNU Lesser General Public License at the
 *	World Wide Web address <http://www.gnu.org/licenses/lgpl.html>.
 *
 *	Description:
 *	This is a PHP script that calculates your local time via an HTML page.
 *	A drop-down menu, checkbox, and submit button allow you to choose a
 *	location and whether or not you would like to observe DST.
 *	
 *	There may be a few cases where some countries' DST change rules are off.
 *	This would only cause problems the night of the actual change to or from
 *	DST causing time to be off by an hour.  If you find an error with the
 *	DST rules as I just described, please email me with the actual
 *	rule for observation of DST so I can fix it.
 *
 *	Feel free to use/modify this script as you like.  What we ask in return
 *	is that you include a link to us (www.anicon.ca) on the webpage that
 *	you use it.  If you see something that could be improved upon, send an
 *	email to me explaining what you would like to see added/modified and
 *	I'll consider adding it.
 *	
 *	I would also like to see how this script is used, so if you do use it,
 *	email me a link to the page in which it's used.
 */

/*	Changes:
	Sept. 5, 2005
		- Changed the default time returned to be the server time
		instead of the UNIX epoch
		- Fixed the statement on database connect failure to use
		echo instead of old database error function
	Oct. 22, 2005
		- Added a current year parameter to the functions used in
		determining if daylight saving or not since some of the
		checks needed to be for the following year instead of the
		same year ie. cases 18, 68, 70, 73.
		- Some calls to the date function were lacking quotes around the
		formatting string; added those.
	Oct. 23, 2005
		- Added a year parameter for passing into functions used
		to determine if DST or not.  This year parameter is the year
		that the year that the daylight saving rule applies in
*/

/*	Database information to use for access */
	$db_host = "localhost";	// This is usually "localhost"
	$db_username="chrisdbuser";
	$db_password="pogi";
	$dbname = "chrisdb";
	
/*	Connect to the database with the above info */
	$db_connection = mysql_connect($db_host, $db_username, $db_password);
	if (!$db_connection)
	{
		echo ("Cannot connect to database.  Please try again.");
		exit();
	}
	
/*	Select database based on the DB name */
	$db_select = mysql_select_db($dbname);
	if (!$db_select)
	{
		echo ("Cannot connect to database.  Please try again.");
		exit();
	}

/*	Get the submitted values from the HTML form */
	$input_location_id = $HTTP_POST_VARS['LOCATION_ID'];
	$dst = $HTTP_POST_VARS['DST'];

/*	Function that returns the formatted time */

	function GetTime($input_location_id)
	{
	global $dst;
	
	/* Check for valid location ID, return 0 date if invalid */
		if ($input_location_id > 0)
		{
			$result = mysql_query("SELECT timezoneid, gmt_offset, dst_offset, timezone_code FROM timezone WHERE timezoneid = '$input_location_id'");
			list($timezoneid, $gmt_offset, $dst_offset, $timezone_code) = mysql_fetch_array($result);
		}
		else
		/*	This is the default date returned upon first accessing the page */
			return date('Y-m-d H:i');

		if ($dst_offset > 0)
		{
			if (!($dst))
			{
			/*	Set the DST offset to zero if the box is not checked
				and append the standard time acronym to the timezone code */
				$dst_offset = 0;
				$timezone_code = getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "ST");
			}
			else if (!isDaylightSaving($timezoneid, $gmt_offset))
			{
			/*	Set the DST offset to zero if the timezone is not currently
				in DST and append the standard time acronym to the timezone code */
				$dst_offset = 0;
				$timezone_code = getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "ST");
			}
			else if ($timezone_code != '')
			/*	Leave the DST offset and append the daylight saving time acronym
				to the timezone code */
				$timezone_code = getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "DT");
			else
			/*	Assign a timezone code */
				$timezone_code = getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "");
		}
	/*	Does not observe DST at all */
		else
			$timezone_code = getTimeZoneCode($timezone_code, $gmt_offset + $dst_offset, "ST");

	/* Get the DST offset in minutes */
		$dst_offset *= 60;
	/* Get the GMT offset in minutes */
		$gmt_offset *= 60;
		$gmt_hour = gmdate('H');
		$gmt_minute = gmdate('i');
	/* Calculate the time in the timezone */
		$time = $gmt_hour * 60 + $gmt_minute + $gmt_offset + $dst_offset;

	/* Convert time back into hours and minutes when returning */
		return date('Y-m-d H:i', mktime($time / 60, $time % 60, 0, gmdate('m'), gmdate('d'), gmdate('Y'))) . " $timezone_code";
	}

/*	This function returns true if the specified timezone ID is in daylight
	saving time and false if it is not */

	function isDaylightSaving($timezoneid, $gmt_offset)
	{
	/*	Get the current year by geting GMT time and date and then adding
		offset */
		$gmt_minute = gmdate("i");
		$gmt_hour = gmdate("H");
		$gmt_month = gmdate("m");
		$gmt_day = gmdate("d");
		$gmt_year = gmdate("Y");
		$cur_year = date("Y", mktime($gmt_hour + $gmt_offset, $gmt_minute, 0, $gmt_month, $gmt_day, $gmt_year));

		switch ($timezoneid)
		{
	/*	North American cases: begins at 2 am on the first Sunday in April
		and ends on the last Sunday in October.  Note: Monterrey does not
		actually observe DST */
			case 4:		/*	Alaska */
			case 5:		/*	Pacific Time (US & Canada); Tijuana */
			case 8:		/*	Mountain Time (US & Canada) */
			case 10:	/*	Central Time (US & Canada) */
			case 11:	/*	Guadalajara, Mexico City, Monterrey */
			case 14:	/*	Eastern Time (US & Canada) */
			case 16:	/*	Atlantic Time (Canada) */
			case 19:	/*	Newfoundland */
				if (afterFirstDayInMonth($cur_year, $cur_year, 4, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 7:		/*	Chihuahua, La Paz, Mazatlan */
				if (afterFirstDayInMonth($cur_year, $cur_year, 5, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 18:	/*	Santiago, Chile */
				if (afterSecondDayInMonth($cur_year, 10, "Sat", $gmt_offset) &&
				beforeSecondDayInMonth($cur_year + 1, $cur_year, 3, "Sat", $gmt_offset))
					return true;

				else
					return false;
				break;

			case 20:	/*	Brasilia, Brazil */
				if (afterFirstDayInMonth($cur_year, $cur_year, 11, "Sun", $gmt_offset) &&
				beforeThirdDayInMonth($cur_year, $cur_year, 2, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 23:	/*	Mid-Atlantic */
				if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

	/*	EU, Russia, other cases: begins at 1 am GMT on the last Sunday
		in March and ends on the last Sunday in October */
			case 22:	/*	Greenland */
			case 24:	/*	Azores */
			case 27:	/*	Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London */
			case 28:	/*	Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna */
			case 29:	/*	Belgrade, Bratislava, Budapest, Ljubljana, Prague */
			case 30:	/*	Brussels, Copenhagen, Madrid, Paris */
			case 31:	/*	Sarajevo, Skopje, Warsaw, Zagreb */
			case 33:	/*	Athens, Istanbul, Minsk */
			case 34:	/*	Bucharest */
			case 37:	/*	Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius */
			case 41:	/*	Moscow, St. Petersburg, Volgograd */
			case 47:	/*	Ekaterinburg */
			case 45:	/*	Baku, Tbilisi, Yerevan */
			case 51:	/*	Almaty, Novosibirsk */
			case 56:	/*	Krasnoyarsk */
			case 58:	/*	Irkutsk, Ulaan Bataar */
			case 64:	/*	Yakutsk, Sibiria */
			case 71:	/*	Vladivostok */
				if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 35:	/*	Cairo, Egypt */
				if (afterLastDayInMonth($cur_year, $cur_year, 4, "Fri", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year, 9, "Thu", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 39:	/*	Baghdad, Iraq */
				if (afterFirstOfTheMonth($cur_year, $cur_year, 4, $gmt_offset) &&
				beforeFirstOfTheMonth($cur_year, $cur_year, 10, $gmt_offset))
					return true;
				else
					return false;
				break;

			case 43:	/*	Tehran, Iran - Note: This is an approximation to 
							the actual DST dates since Iran goes by the Persian
							calendar.  There are tools for converting between
							Gregorian and Persian calendars at www.farsiweb.info.
							This may be added at a later date for better accuracy */
				if (afterLastDayInMonth($cur_year, $cur_year, 3, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year, 9, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 65:	/*	Adelaide */
			case 68:	/*	Canberra, Melbourne, Sydney */
				if (afterLastDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 70:	/*	Hobart */
				if (afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
				beforeLastDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			case 73:	/*	Auckland, Wellington */
				if (afterFirstDayInMonth($cur_year, $cur_year, 10, "Sun", $gmt_offset) &&
				beforeThirdDayInMonth($cur_year, $cur_year + 1, 3, "Sun", $gmt_offset))
					return true;
				else
					return false;
				break;

			default:
				break;
		}
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is after the first specified day of the week in specified
	month and false if it is not */
	
	function afterFirstDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		for ($i = 1; $i < 8; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$first_day = $i;
				break;
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/* Time stamp for the first occurence for the specified day in the month */
		$first_day_stamp = mktime(2, 0, 0, $month, $first_day, $year);
				
		if ($cur_stamp >= $first_day_stamp)
			return true;
			
		return false;
	}
	
/*	This function returns true if the current date (at the specified GMT
	offset) is before the last specified day of the week in specified
	month and false if it is not */
	
	function beforeLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$days_in_month = getDaysInMonth($month);
		
		for ($i = $days_in_month; $i > ($days_in_month - 8); $i--)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$last_day = $i;
				break;
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/* Time stamp for the last occurrence of the day in the month at 2 am */
		$last_sun_stamp = mktime(2, 0, 0, $month, $last_day, $year);
				
		if ($cur_stamp < $last_sun_stamp)
			return true;
			
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is after the last specified day of the week in specified
	month and false if it is not */

	function afterLastDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$days_in_month = getDaysInMonth($month);

		for ($i = $days_in_month; $i > ($days_in_month - 8); $i--)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$last_day = $i;
				break;
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
	/* All EU countries observe the DST change at 1 am GMT */
		$curHour = gmdate("H");
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/* Time stamp for the first occurence for the specified day in the month */
		$last_day_stamp = mktime(1, 0, 0, $month, $last_day, $year);
				
		if ($cur_stamp >= $last_day_stamp)
			return true;
			
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is after the first day of the specified month and false if
	it is not */

	function afterFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
	{
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/* Time stamp for the first of the month */
		$last_day_stamp = mktime(3, 0, 0, $month, 1, $year);
				
		if ($cur_stamp >= $last_day_stamp)
			return true;
			
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is before the first day of the specified month and false if
	it is not */

	function beforeFirstOfTheMonth($curYear, $year, $month, $gmt_offset)
	{
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/* Time stamp for the first of the month */
		$first_day_stamp = mktime(3, 0, 0, $month, 1, $year);
				
		if ($cur_stamp < $first_day_stamp)
			return true;
			
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is before the third occurrence of the specified day of the
	week in the specified month and false if it is not */

	function beforeThirdDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$count = 0;
		
		for ($i = 1; $i < 22; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$count++;
				if ($count == 3)
				{
					$third_day = $i;
					break;
				}
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/* Time stamp for the third occurence for the specified day in the month */
		$third_day_stamp = mktime(2, 0, 0, $month, $third_day, $year);
				
		if ($cur_stamp < $third_day_stamp)
			return true;
			
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is before the second occurrence of the specified day of the
	week in the specified month and false if it is not */

	function beforeSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$count = 0;
		
		for ($i = 1; $i < 15; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$count++;
				if ($count == 2)
				{
					$second_day = $i;
					break;
				}
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/*	Time stamp for the second occurence of the specified day in the month;
		change in Chile occurs at midnight */
		$second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);

		if ($cur_stamp < $second_day_stamp)
			return true;
			
		return false;
	}

/*	This function returns true if the current date (at the specified GMT
	offset) is after the second occurrence of the specified day of the
	week in the specified month and false if it is not */

	function afterSecondDayInMonth($curYear, $year, $month, $day, $gmt_offset)
	{
		$count = 0;
		
		for ($i = 1; $i < 15; $i++)
		{
			if (date("D", mktime(0,0,0,$month,$i)) == $day)
			{
				$count++;
				if ($count == 2)
				{
					$second_day = $i;
					break;
				}
			}
		}
		
		$curDay = gmdate("d");
		$curMonth = gmdate("m");
		$curHour = gmdate("H") + $gmt_offset;
	/* The current time stamp */
		$cur_stamp = mktime($curHour, 0, 0, $curMonth, $curDay, $curYear);

	/*	Time stamp for the second occurence of the specified day in the month;
		change in Chile occurs at midnight */
		$second_day_stamp = mktime(0, 0, 0, $month, $second_day, $year);

		if ($cur_stamp >= $second_day_stamp)
			return true;
			
		return false;
	}

/*	A function that returns the number of days in the specified month */

	function getDaysInMonth($month)
	{
		switch ($month)
		{
		/*	The February case, check for leap year */
			case 2:
				return (date("L")?29:28);
				break;
		/* Months with 31 days */
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return 31;
				break;
			default:
				return 30;
				break;
		}
	}
	
/*	This function returns a formated time zone code based on the
	value of the input code, the offset, any suffix that might apply */
	
	function getTimeZoneCode($timezone_code, $total_offset, $suffix)
	{
		if ($timezone_code == '')
		{
		/* If the code is NULL, create one */
			if ($total_offset > 0)
				return ("GMT +$total_offset");
			else if ($total_offset == 0)
				return ("GMT");
			else
				return ("GMT $total_offset");
		}
		else
		/* If not, append the suffix */
			return $timezone_code . "$suffix";
	}
?>

<html>
<head>
<script type="text/javascript">

/*	This function is used on the user selecting a location
	from the drop-down menu named "LOCATION_ID".  It disables
	or enables and checks or unchecks the DST checkbox */

	function activateDSTBox(location_id)
	{
		switch (location_id)
		{
			case '0':
			case '1':
			case '2':
			case '3':
			case '6':
			case '9':
			case '12':
			case '13':
			case '15':
			case '17':
			case '21':
			case '25':
			case '26':
			case '32':
			case '36':
			case '38':
			case '40':
			case '42':
			case '44':
			case '46':
			case '48':
			case '49':
			case '50':
			case '52':
			case '53':
			case '54':
			case '55':
			case '57':
			case '59':
			case '60':
			case '61':
			case '62':
			case '63':
			case '66':
			case '67':
			case '69':
			case '72':
			case '74':
			case '75':
				document.form.DST.disabled = true;
				document.form.DST.checked = false;
				break;
			default:
				document.form.DST.disabled = false;
				document.form.DST.checked = true;
				break;
		}
		
		return true
	}
</script>
</head>
Hello,

<form name="form" ACTION="<?=$PHP_SELF ?>" METHOD="post">
<br>Location:
<select name="LOCATION_ID" onChange="activateDSTBox(document.form.LOCATION_ID.value)">
	<option value='0' selected> </option>
	<option value='1'>(GMT-12:00) International Date Line West</option>
	<option value='2'>(GMT-11:00) Midway Island Samoa</option>
	<option value='3'>(GMT-10:00) Hawaii</option>
	<option value='4'>(GMT-09:00) Alaska</option>
	<option value='5'>(GMT-08:00) Pacific Time (US & Canada); Tijuana</option>
	<option value='6'>(GMT-07:00) Arizona</option>
	<option value='7'>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
	<option value='8'>(GMT-07:00) Mountain Time (US & Canada)</option>
	<option value='9'>(GMT-06:00) Central America</option>
	<option value='10'>(GMT-06:00) Central Time (US & Canada)</option>
	<option value='11'>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
	<option value='12'>(GMT-06:00) Saskatchewan</option>
	<option value='13'>(GMT-05:00) Bogota, Lime, Quito</option>
	<option value='14'>(GMT-05:00) Eastern Time (US & Canada)</option>
	<option value='15'>(GMT-05:00) Indiana (East)</option>
	<option value='16'>(GMT-04:00) Atlantic Time (Canada)</option>
	<option value='17'>(GMT-04:00) Caracas, La Paz</option>
	<option value='18'>(GMT-04:00) Santiago</option>
	<option value='19'>(GMT-03:30) Newfoundland</option>
	<option value='20'>(GMT-03:00) Brasilia</option>
	<option value='21'>(GMT-03:00) Buenos Aires, Georgetown</option>
	<option value='22'>(GMT-03:00) Greenland</option>
	<option value='23'>(GMT-02:00) Mid-Atlantic</option>
	<option value='24'>(GMT-01:00) Azores</option>
	<option value='25'>(GMT-01:00) Cape Verde Is.</option>
	<option value='26'>(GMT) Casablanca, Monrovia</option>
	<option value='27'>(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
	<option value='28'>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
	<option value='29'>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
	<option value='30'>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
	<option value='31'>(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
	<option value='32'>(GMT+01:00) West Central Africa</option>
	<option value='33'>(GMT+02:00) Athens, Istanbul, Minsk</option>
	<option value='34'>(GMT+02:00) Bucharest</option>
	<option value='35'>(GMT+02:00) Cairo</option>
	<option value='36'>(GMT+02:00) Harare, Pretoria</option>
	<option value='37'>(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
	<option value='38'>(GMT+02:00) Jerusalem</option>
	<option value='39'>(GMT+03:00) Baghdad</option>
	<option value='40'>(GMT+03:00) Kuwait, Riyadh</option>
	<option value='41'>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
	<option value='42'>(GMT+03:00) Nairobi</option>
	<option value='43'>(GMT+03:30) Tehran</option>
	<option value='44'>(GMT+04:00) Abu Dhabi, Muscat</option>
	<option value='45'>(GMT+04:00) Baku, Tbilisi, Yerevan</option>
	<option value='46'>(GMT+04:30) Kabul</option>
	<option value='47'>(GMT+05:00) Ekaterinburg</option>
	<option value='48'>(GMT+05:00) Islamabad, Karachi, Tashkent</option>
	<option value='49'>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
	<option value='50'>(GMT+05.75) Kathmandu</option>
	<option value='51'>(GMT+06:00) Almaty, Novosibirsk</option>
	<option value='52'>(GMT+06:00) Astana, Dhaka</option>
	<option value='53'>(GMT+06:00) Sri Jayawardenepura</option>
	<option value='54'>(GMT+06:30) Rangoon</option>
	<option value='55'>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
	<option value='56'>(GMT+07:00) Krasnoyarsk</option>
	<option value='57'>(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi</option>
	<option value='58'>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
	<option value='59'>(GMT+08:00) Kuala Lumpur, Singapore</option>
	<option value='60'>(GMT+08:00) Perth</option>
	<option value='61'>(GMT+08:00) Taipei</option>
	<option value='62'>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
	<option value='63'>(GMT+09:00) Seoul</option>
	<option value='64'>(GMT+09:00) Yakutsk</option>
	<option value='65'>(GMT+09:30) Adelaide</option>
	<option value='66'>(GMT+09:30) Darwin</option>
	<option value='67'>(GMT+10:00) Brisbane</option>
	<option value='68'>(GMT+10:00) Canberra, Melbourne, Sydney</option>
	<option value='69'>(GMT+10:00) Guam, Port Moresby</option>
	<option value='70'>(GMT+10:00) Hobart</option>
	<option value='71'>(GMT+10:00) Vladivostok</option>
	<option value='72'>(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
	<option value='73'>(GMT+12:00) Auckland, Wellington</option>
	<option value='74'>(GMT+12:00) Figi, Kamchatka, Marshall Is.</option>
	<option value='75'>(GMT+13:00) Nuku'alofa</option>
</select>
 Time: <? echo GetTime($input_location_id); ?>
<br>
<br> <input type="checkbox" name="DST" unchecked disabled> Check box to automatically adjust clock for daylight saving time
<br>
<br>
<input type="submit" value="Submit" />
</form>
</html>
