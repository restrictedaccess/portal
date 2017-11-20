function handleHttpResponse() 
	{
		var temp = '';
		var type = '';
		var string_day = '';
		var temp2 = '';

		if (http.readyState == 4) 
		{
			if (http.responseText != '') 
			{
				switch(field)
				{
					case "update_subject_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_subject_id').value = http.responseText;
						else
							document.getElementById('update_subject_id').value = "";
						field = "update_location_id";
						get_existing_record();						
						break;
					case "update_location_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_location_id').value = http.responseText;
						else	
							document.getElementById('update_location_id').value = "";
						field = "update_description_id";
						get_existing_record();								
						break;
					case "update_description_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_description_id').value = http.responseText;
						else
							document.getElementById('update_description_id').value = "";
						field = "update_start_month_id";
						get_existing_record();									
						break;		
						
						
						
					case "update_start_month_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_start_month_id').selectedIndex  = http.responseText;
						else
							document.getElementById('update_start_month_id').selectedIndex = 0;
						field = "update_start_day_id";
						get_existing_record();
						break;
					case "update_start_day_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_start_day_id').selectedIndex  = http.responseText;
						else
							document.getElementById('update_start_day_id').selectedIndex = 0;
						field = "update_start_year_id";
						get_existing_record();
						break;					
					case "update_start_year_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_start_year_id').selectedIndex  = get_year_selectedIndex(http.responseText);
						else
							document.getElementById('update_start_year_id').selectedIndex = 0;
						field = "update_end_month_id";
						get_existing_record();								
						break;
						
						
						
						
					case "update_end_month_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_end_month_id').selectedIndex  = http.responseText;
						else
							document.getElementById('update_end_month_id').selectedIndex = 0;
						field = "update_end_day_id";
						get_existing_record();
						break;
					case "update_end_day_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_end_day_id').selectedIndex  = http.responseText;
						else
							document.getElementById('update_end_day_id').selectedIndex = 0;
						field = "update_end_year_id";
						get_existing_record();
						break;					
					case "update_end_year_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_end_year_id').selectedIndex  = get_year_selectedIndex(http.responseText);
						else
							document.getElementById('update_end_year_id').selectedIndex = 0;
						field = "update_start_hour_id";
						get_existing_record();								
						break;						
						
				
				
					case "update_start_hour_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_start_hour_id').selectedIndex = http.responseText;
						else
							document.getElementById('update_start_hour_id').selectedIndex = 0;
						field = "update_start_minute_id";
						get_existing_record();
						break;
					case "update_start_minute_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
						{
							var m = Number(http.responseText);
							document.getElementById('update_start_minute_id').selectedIndex = m + 1;
						}
						else
							document.getElementById('update_start_minute_id').selectedIndex = 0;
						field = "update_end_hour_id";
						get_existing_record();
						break;		
						
						
						
					case "update_end_hour_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_end_hour_id').selectedIndex = http.responseText;
						else
							document.getElementById('update_end_hour_id').selectedIndex = 0;
						field = "update_end_minute_id";
						get_existing_record();
						break;
					case "update_end_minute_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
						{
							var m = Number(http.responseText);							
							document.getElementById('update_end_minute_id').selectedIndex = m + 1;
						}
						else
							document.getElementById('update_end_minute_id').selectedIndex = 0;
						field = "update_type_id";
						get_existing_record();
						break;								
						


					case "update_type_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
						{
							document.getElementById('update_type_id').value = http.responseText;
							document.getElementById('update_type_option_id').checked = true;
						}
						else
						{
							document.getElementById('update_type_id').selectedIndex = 0;
							document.getElementById('update_type_option_id').checked = false;
						}
						field = "update_leads_id";
						get_existing_record();
						break;	


					case "update_leads_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_leads_id').innerHTML = "<br /><br /><strong>Applicant:</option> "+http.responseText+"<br /><br />";
						field = "update_client_id";
						get_existing_record();
						break;
						
					case "update_client_id":
						timer_stat = 0;
						if(http.responseText != "-none-") 
							document.getElementById('update_client_id').innerHTML = "<br /><br /><strong>Client:</option> "+http.responseText+"<br /><br />";
						field = "update_all_day_id";
						get_existing_record();
						break;						

					case "update_all_day_id":
						timer_stat = 0;
						if(http.responseText == "yes") 
							document.getElementById('update_all_day_id').checked = true;
						else
							document.getElementById('update_all_day_id').checked = false;
						field = "update_any_id";
						get_existing_record();			
						break;	
						
					case "update_any_id":
						timer_stat = 0;
						if(http.responseText == "yes") 
							document.getElementById('update_any_id').checked = true;
						else
							document.getElementById('update_any_id').checked = false;
						field = '';	
						break;	
					default:
						field = '';	
						break;
				}
			}
		}
	}
	
	function getHTTPObject() 
	{
		var x 
		var browser = navigator.appName 
		if(browser == 'Microsoft Internet Explorer')
		{
			x = new ActiveXObject('Microsoft.XMLHTTP')
		}
		else
		{
			x = new XMLHttpRequest()
		}
		return x		
	}
	var http = getHTTPObject();
