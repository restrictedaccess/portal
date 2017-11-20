		var mouse_state = 'on';
		var curNotes = '';
		var curSubMenu = '';
		//var field = 'update_subject_id';
		var field = '';
		var date_selected = '';
		var hr_selected = '';
		var m_selected = '';
		var id_selected = '';
		var active_window = '';
		var timer_stat = 0;
		var temp = 0;
		//var int=self.setInterval('get_current_time()',1000)	











		function view_schedule() 
		{
			previewPath = "get_schedule_admin.php?id="+id_selected;
			window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
			mouse_state = 'off';
			eval('document.all.temp').style.visibility='visible';
			get_existing_record();
			hideSubMenu();		
		}

		//notes box messages
		function showNotes(menuId)
		{
			if (curNotes!='') 
				hideNotes();
			
			eval('document.all.'+menuId).style.visibility='visible';
			curNotes=menuId;
		}
		function hideNotes()
		{
			eval('document.all.'+curNotes).style.visibility='hidden';
			curNotes='';
		}	
		//end
		
		function get_current_time()
		{
			//if(field == '')
			//{
				//timer_stat = 1;
				http_t.open("GET", "ajax/get_time.php?c="+temp, true);
				http_t.onreadystatechange = handleHttpResponse_t;
				http_t.send(null);
			//}
		}
		
		function get_existing_record()
		{
			http.open("GET", "ajax/get_schedule.php?id="+id_selected+"&field="+field, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}

		function appointment_cancel(type)
		{
			mouse_state='on';
			eval('document.all.'+type).style.visibility='hidden';
		}

		function appointment_new()
		{
			mouse_state = 'off';
			eval('document.all.new_appointment').style.visibility='visible';
			hideSubMenu();
		}		
		
		function appointment_update()
		{
			mouse_state = 'off';
			eval('document.all.update_appointment').style.visibility='visible';
			get_existing_record();
			hideSubMenu();
		}
		
		function showSubMenu(menuId)
		{
			mouse_state = 'off';
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
		function validateEmail(email) { 
		    var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		    return re.test(email);
		} 
		
		
		function validate(form) 
		{
			var temp = '';
			var temp2 = '';
			if (jQuery.trim(form.subject.value) == '') { alert("You forgot to enter the 'subject field'."); form.subject.focus(); return false; }
			
			if (jQuery(".no-require-check:checked").length==0){
				if (jQuery.trim(jQuery("#client_id_display").val())==""){
					alert("You forgot to select a client.");
					return false;
				}	
			}else{
				if (jQuery.trim(jQuery("#description2_id").val())==""){
					alert("Please enter a message.");
					return false;
				}
			}
			
			
			if (jQuery.trim(jQuery("#cc_client").val())!=""){
				var cc_client = jQuery("#cc_client").val();
				cc_client = cc_client.split(",");
				if (cc_client.length>0){
					var invalid = false;
					jQuery.each(cc_client, function(i, item){
						if (!validateEmail(jQuery.trim(item))){
							alert("One of the email in the client's cc/s is not valid");
							invalid = true;
							return false;
						} 
					});
					if (invalid){
						return false;
					}
				}
			}
			if(form.all_day.value == "all_day_id")
			{
				if(!document.getElementById('all_day_id').checked)
				{
					temp = "execute";	
				}
			}
			if(form.all_day.value == "update_all_day_id")
			{
				if(!document.getElementById('update_all_day_id').checked)
				{
					temp = "execute";	
				}
			}			

			if(form.any.value == "any_id")
			{
				if(!document.getElementById('any_id').checked)
				{
					temp2 = "execute";	
				}
			}
			if(form.any.value == "update_any_id")
			{
				if(!document.getElementById('update_any_id').checked)
				{
					temp2 = "execute";	
				}
			}	


			if(temp == "execute")
			{
					if (form.start_year.value == '') { alert("You forgot to enter the 'start year field'."); form.start_year.focus(); return false; }	
					if (form.start_month.value == '') { alert("You forgot to enter the 'start month field'."); form.start_month.focus(); return false; }	
					if (form.start_day.value == '') { alert("You forgot to enter the 'start day field'."); form.start_day.focus(); return false; }	
					//if (form.location.value == '') { alert("You forgot to enter the 'location field'."); form.location.focus(); return false; }	
					if (form.start_minute.value == '') { alert("You forgot to enter the 'start minute field'."); form.start_minute.focus(); return false; }	
					if (form.start_hour.value == '') { alert("You forgot to enter the 'start hour field'."); form.start_hour.focus(); return false; }	
					//if (form.description.value == '') { alert("You forgot to enter the 'description field'."); form.description.focus(); return false; }			
					
					if(temp2 == "execute")
					{
							if (form.end_month.value == '') { alert("You forgot to enter the postal 'end month field'."); form.end_month.focus(); return false; }	
							if (form.end_day.value == '') { alert("You forgot to enter the postal 'end day field'."); form.end_day.focus(); return false; }	
							if (form.end_year.value == '') { alert("You forgot to enter the 'end year field'."); form.end_year.focus(); return false; }	
							if (form.end_hour.value == '') { alert("You forgot to enter the 'end hour field'."); form.end_hour.focus(); return false; }	
							if (form.end_minute.value == '') { alert("You forgot to enter the 'end minute field'."); form.end_minute.focus(); return false; }	
											
							if(form.start_year.value > form.end_year.value)
							{
								alert("You have assigned the invalid year format.");
								form.start_year.focus();
								return false;
							}
							if(form.start_year.value == form.end_year.value)
							{
								if(form.start_month.value > form.end_month.value)
								{
									alert("You have assigned invalid day format.");
									form.start_month.focus();
									return false;
								}
							}	
							if(form.start_year.value == form.end_year.value)
							{
								if(form.start_month.value == form.end_month.value)
								{
									if(form.start_day.value > form.end_day.value)
									{
										alert("You have assigned invalid day format.");
										form.start_day.focus();
										return false;
									}
								}
							}
							var sh = Number(form.start_hour.value);	
							var eh = Number(form.end_hour.value);	
							if(form.start_year.value == form.end_year.value)
							{
								if(form.start_month.value == form.end_month.value)
								{
									if(form.start_day.value == form.end_day.value)
									{
										if(sh > eh)
										{						
											alert("You have assigned invalid hour format.");
											form.start_hour.focus();
											return false;
										}
									}
								}
							}
							if(form.start_year.value == form.end_year.value)
							{
								if(form.start_month.value == form.end_month.value)
								{
									if(form.start_day.value == form.end_day.value)
									{
										if(sh == eh)
										{						
											if(form.start_minute.value >= form.end_minute.value)
											{
												alert("You have assigned invalid minute format.");
												form.start_minute.focus();
												return false;
											}
										}
									}
								}
							}
					}									
			}
		}
		
		function ToggleInput(check, txtBox)
		{
			var txt = document.getElementById(txtBox);
			txt.disabled = !(check.checked);
		}
		
		function new_any(check)
		{
			var end_month_id = document.getElementById('end_month_id');
			var end_day_id = document.getElementById('end_day_id');
			var end_year_id = document.getElementById('end_year_id');
			var end_hour_id = document.getElementById('end_hour_id');
			var end_minute_id = document.getElementById('end_minute_id');
			
			end_month_id.disabled = (check.checked);
			end_day_id.disabled = (check.checked);
			end_year_id.disabled = (check.checked);
			end_hour_id.disabled = (check.checked);
			end_minute_id.disabled = (check.checked);
		}
		
		function update_any(check)
		{
			var update_end_month_id = document.getElementById('update_end_month_id');
			var update_end_day_id = document.getElementById('update_end_day_id');
			var update_end_year_id = document.getElementById('update_end_year_id');
			var update_end_hour_id = document.getElementById('update_end_hour_id');
			var update_end_minute_id = document.getElementById('update_end_minute_id');
			update_end_month_id.disabled = (check.checked);
			update_end_day_id.disabled = (check.checked);
			update_end_year_id.disabled = (check.checked);
			update_end_hour_id.disabled = (check.checked);
			update_end_minute_id.disabled = (check.checked);
		}		
		
		function allday(check)
		{
			//var start_month_id = document.getElementById('start_month_id');
			//var start_day_id = document.getElementById('start_day_id');
			//var start_year_id = document.getElementById('start_year_id');
			var start_hour_id = document.getElementById('start_hour_id');
			var start_minute_id = document.getElementById('start_minute_id');
			var any_id = document.getElementById('any_id');
			//start_month_id.disabled = (check.checked);
			//start_day_id.disabled = (check.checked);
			//start_year_id.disabled = (check.checked);
			start_hour_id.disabled = (check.checked);
			start_minute_id.disabled = (check.checked);			
			any_id.disabled = (check.checked);
			
			var end_month_id = document.getElementById('end_month_id');
			var end_day_id = document.getElementById('end_day_id');
			var end_year_id = document.getElementById('end_year_id');
			var end_hour_id = document.getElementById('end_hour_id');
			var end_minute_id = document.getElementById('end_minute_id');
			end_month_id.disabled = (check.checked);
			end_day_id.disabled = (check.checked);
			end_year_id.disabled = (check.checked);
			end_hour_id.disabled = (check.checked);
			end_minute_id.disabled = (check.checked);
		}		
		
		function update_allday(check)
		{
			//var update_start_month_id = document.getElementById('update_start_month_id');
			//var update_start_day_id = document.getElementById('update_start_day_id');
			//var update_start_year_id = document.getElementById('update_start_year_id');
			var update_start_hour_id = document.getElementById('update_start_hour_id');
			var update_start_minute_id = document.getElementById('update_start_minute_id');
			var update_any_id = document.getElementById('update_any_id');
			//update_start_month_id.disabled = (check.checked);
			//update_start_day_id.disabled = (check.checked);
			//update_start_year_id.disabled = (check.checked);
			update_start_hour_id.disabled = (check.checked);
			update_start_minute_id.disabled = (check.checked);			
			update_any_id.disabled = (check.checked);
			
			var update_end_month_id = document.getElementById('update_end_month_id');
			var update_end_day_id = document.getElementById('update_end_day_id');
			var update_end_year_id = document.getElementById('update_end_year_id');
			var update_end_hour_id = document.getElementById('update_end_hour_id');
			var update_end_minute_id = document.getElementById('update_end_minute_id');
			update_end_month_id.disabled = (check.checked);
			update_end_day_id.disabled = (check.checked);
			update_end_year_id.disabled = (check.checked);
			update_end_hour_id.disabled = (check.checked);
			update_end_minute_id.disabled = (check.checked);
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