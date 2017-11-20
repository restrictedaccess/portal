		var mouse_state = 'on';
		var curSubMenu = '';
		var field = 'update_subject_id';
		var date_selected = '';
		var hr_selected = '';
		var m_selected = '';
		var id_selected = '';
		var active_window = '';
		
		function get_existing_record()
		{
			http.open("GET", "ajax/get_schedule.php?id="+id_selected+"&field="+field, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}

		function appointment_cancel(type)
		{
			eval('document.all.'+type).style.visibility='hidden';
			hideSubMenu();
		}

		function appointment_new()
		{
			eval('document.all.new_appointment').style.visibility='visible';
			hideSubMenu();
		}		
		
		function appointment_update()
		{
			eval('document.all.update_appointment').style.visibility='visible';
			get_existing_record();
			hideSubMenu();
		}
		
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') hideSubMenu();
				eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
			document.getElementById('start_minute_id').value = m_selected;
			document.getElementById('start_hour_id').value = hr_selected;
			document.getElementById('end_hour_id').value = hr_selected;
			document.getElementById('end_minute_id').value = m_selected;
		}
		
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
			mouse_state='on';
		}
		
		function validate(form) 
		{
			if (form.start_year.value == '') { alert("You forgot to enter the 'start year field'."); form.start_year.focus(); return false; }	
			if (form.start_month.value == '') { alert("You forgot to enter the 'start month field'."); form.start_month.focus(); return false; }	
			if (form.start_day.value == '') { alert("You forgot to enter the 'start day field'."); form.start_day.focus(); return false; }	
			if (form.end_month.value == '') { alert("You forgot to enter the postal 'end month field'."); form.end_month.focus(); return false; }	
			if (form.end_day.value == '') { alert("You forgot to enter the postal 'end day field'."); form.end_day.focus(); return false; }	
			if (form.end_year.value == '') { alert("You forgot to enter the 'end year field'."); form.end_year.focus(); return false; }	
			if (form.subject.value == '') { alert("You forgot to enter the 'subject field'."); form.subject.focus(); return false; }	
			if (form.location.value == '') { alert("You forgot to enter the 'location field'."); form.location.focus(); return false; }	
			if (form.start_minute.value == '') { alert("You forgot to enter the 'start minute field'."); form.start_minute.focus(); return false; }	
			if (form.start_hour.value == '') { alert("You forgot to enter the 'start hour field'."); form.start_hour.focus(); return false; }	
			if (form.end_hour.value == '') { alert("You forgot to enter the 'end hour field'."); form.end_hour.focus(); return false; }	
			if (form.end_minute.value == '') { alert("You forgot to enter the 'end minute field'."); form.end_minute.focus(); return false; }	
			if (form.description.value == '') { alert("You forgot to enter the 'description field'."); form.description.focus(); return false; }	
			return true;
		}
		
		function ToggleInput(check, txtBox)
		{
			var txt = document.getElementById(txtBox);
			txt.disabled = !(check.checked);
		}
		
		function get_year_selectedIndex(num)
		{
				switch(num)
				{
					case "2005":
						r = 1;
						break;
					case "2006":
						r = 2;
						break;
					case "2007":
						r = 3;
						break;
					case "2008":
						r = 4;
						break;
					case "2009":
						r = 5;
						break;
					case "2010":
						r = 6;
						break;
				}
				return r;
		}
		
		function get_string_day(day)
		{
			var r = "";	
			switch(day)
			{
				case "01":
					r = "Jan";
					break;
				case "02":					
					r = "Feb";
					break;
				case "03":					
					r = "Mar";
					break;
				case "04":										
					r = "Apr";
					break;
				case "05":										
					r = "May";
					break;
				case "06":
					r = "Jun";
					break;
				case "07":										
					r = "Jul";
					break;
				case "08":										
					r = "Aug";
					break;
				case "09":										
					r = "Sep";
					break;
				case "10":										
					r = "Oct";
					break;
				case "11":										
					r = "Nov";
					break;
				case "12":										
					r = "Dec";
					break;
				default:
					r = "Month";	
					break;
			}
			return r;
		}		
		
		function get_time(t)
		{
			var r = "";
			switch(t)
			{
				case "13":
					r = "1";
					break;
				case "14":					
					r = "2";
					break;
				case "15":					
					r = "3";
					break;
				case "16":										
					r = "4";
					break;
				case "17":										
					r = "5";
					break;
				case "18":
					r = "6";
					break;
				case "19":										
					r = "7";
					break;
				case "20":										
					r = "8";
					break;
				case "21":										
					r = "9";
					break;
				case "22":										
					r = "10";
					break;
				case "23":										
					r = "11";
					break;
				case "24":										
					r = "12";
					break;
			}
			return r;
		}			