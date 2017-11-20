
		//FROM POPUP_CALENDAR.PHP FUNCTIONS
		var client_full_name = '<?php echo $client_full_name; ?>';
		var applicant_full_name = '<?php echo $applicant_full_name; ?>';	
		var from_name = '<?php echo $from_name; ?>';
		var creator_name = '<?php echo $from_name; ?>';
		var sub_category_name = '<?php echo $sub_category_name; ?>';
		var admin_name_loading_counter = 1;
		
		
		function makeObject()
		{
			var x ; 
			var browser = navigator.appName ;
			if(browser == 'Microsoft Internet Explorer')
			{
				x = new ActiveXObject('Microsoft.XMLHTTP')
			}
			else
			{
				x = new XMLHttpRequest()
			}
			return x ;
		}
		
		
		//SEARCH LEADS
		//var curSubMenu = '';
		var keyword;	
		var SL_request = makeObject()
		function SL_query_lead()
		{
			keyword = document.getElementById('key_id').value;
			if(keyword == "" || keyword == "(fname/lname/email)")
			{
				alert("Please Enter Your Keyword!");
			}
			else
			{
				SL_request.open('get', 'search-leads.php?key='+keyword)
				SL_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				SL_request.onreadystatechange = SL_active_listings 
				SL_request.send(1)
			}
		}
		function SL_active_listings()
		{
			var data;
			data = SL_request.responseText
			if(SL_request.readyState == 4)
			{
				document.getElementById('search_div').innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center>"+data+"</td></tr></table>";
			}
			else
			{
				document.getElementById('search_div').innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='../images/ajax-loader.gif'></td></tr></table>";
			}
		}		
		function SL_search_lead()
		{
			//num_selected = num;
			//if (curSubMenu!='') 
			//SL_hideSubMenu();
			eval('search_div').style.visibility='visible';			
			//document.getElementById('search_div').innerHTML = document.getElementById('search_box').innerHTML;	
			//curSubMenu='search_div';
		}
		function SL_hideSubMenu()
		{
			eval('search_div').style.visibility='hidden';	
			//document.getElementById(curSubMenu).innerHTML = "";
			//curSubMenu='';
		}	
		function SL_assign(id,name)
		{
			document.getElementById('client_id').value = id;
			document.getElementById('client_id_display').value = name;		
		}	
		//ENDED - SEARCH LEADS	
		
		
		
		// s t a r t   a j a x
		var request = makeObject()
	
		//------>	
		function get_client_name(id) 
		{
			request.open('get', 'get_client_name.php?id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = client_name_update_values 
			request.send(1)
		}	
		function client_name_update_values()
		{
			var data = request.responseText
			if(request.readyState == 4)
			{
				client_full_name = data;
				client_full_name = client_full_name.replace("\n", "");
				client_full_name = client_full_name.replace("<br />", "");
				client_full_name = client_full_name.replace("   ", " ");
				document.getElementById("loading_div").innerHTML="";
				populate_autoresponder();
			}
			else
			{
				document.getElementById("loading_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}	
		// <------
		
		//------>	
		function get_applicant_name(id) 
		{
			request.open('get', 'get_applicant_name.php?id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = applicant_name_update_values 
			request.send(1)
		}	
		function applicant_name_update_values()
		{
			var data = request.responseText
			if(request.readyState == 4)
			{
				applicant_full_name = data;
				applicant_full_name = applicant_full_name.replace("\n", "");
				applicant_full_name = applicant_full_name.replace("<br />", "");
				applicant_full_name = applicant_full_name.replace("   ", " ");
				document.getElementById("loading_div").innerHTML="";
				populate_autoresponder();
			}
			else
			{
				document.getElementById("loading_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}	
		// <------	
		
		//------>
		function get_admin_name(id) 
		{
			admin_name_loading_counter++;
			request.open('get', 'get_admin_name.php?id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = admin_name_update_values 
			request.send(1)
		}	
		function admin_name_update_values()
		{
			var data = request.responseText
			if(request.readyState == 4)
			{
				from_name = data;
				from_name = from_name.replace("\n", "");
				from_name = from_name.replace("<br />", "");
				from_name = from_name.replace("   ", " ");			
				document.getElementById("loading_div").innerHTML="";
				populate_autoresponder();
			}
			else
			{
				document.getElementById("loading_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}
		// <------		
	
		// e n d e d
	
		
		//skype autoresponder
		function populate_autoresponder() 
		{
			var m = "";
			switch(document.getElementById('start_month_id').value)
			{
				case "1":
					m = "January";
					break;
				case "2":
					m = "February";
					break;
				case "3":
					m = "March";
					break;
				case "4":
					m = "April";
					break;
				case "5":
					m = "May";
					break;
				case "6":
					m = "June";
					break;
				case "7":
					m = "July";
					break;
				case "8":
					m = "August";
					break;
				case "9":
					m = "September";
					break;
				case "10":
					m = "October";
					break;
				case "11":
					m = "November";
					break;
				case "12":
					m = "December";
					break;
			}
			var date_start = m+" "+document.getElementById('start_day_id').value+", "+document.getElementById('start_year_id').value;
			var s_hour = document.getElementById('start_hour_id').value;
			var start_minute = document.getElementById('start_minute_id').value;
			var time_zone = document.getElementById('time_zone_id').value;
	
			var facilitator_temp_name = "I";
			if(admin_name_loading_counter > 1)
			{
				facilitator_temp_name = from_name;
			}		
			
			switch(time_zone)
			{
				case "PST8PDT":
					time_zone = "America/San Francisco";
					break;
				case "NZ":
					time_zone = "New Zealand/Wellington";
					break;
				case "NZ-CHAT":
					time_zone = "New Zealand/Chatham_Islands";
					break;
			}
			var clt_msg = "";
			var start_hour_type = 'AM';
			if(s_hour > 12)
			{
				start_hour_type = 'PM'; 
				s_hour = s_hour - 12;
			}
			if(start_minute == 0)
			{
				start_minute = "0"+start_minute;
			}
			
			if(document.getElementById('type_id').value == "skype")
			{
					//for client message setup
					clt_msg = "Hi "+client_full_name+",\n\n";
					clt_msg = clt_msg + "This is "+creator_name+" from Remote Staff.\n\n";
					clt_msg = clt_msg + "I am writing to confirm your interview with "+applicant_full_name+" on "+date_start+" "+s_hour+":"+start_minute+" "+start_hour_type+" "+time_zone+" time.\n\n";
					clt_msg = clt_msg + "Please note that the interview will happen online on Skype.\n\n";
					clt_msg = clt_msg + "Please use the following credentials to log in to Skype:\n\n\n";
			
					clt_msg = clt_msg + "Username: \n";
					clt_msg = clt_msg + "Password: \n\n\n";
	
					clt_msg = clt_msg + facilitator_temp_name+" will facilitate the interview.\n\n\n";
					
					clt_msg = clt_msg + "NOTE:\n\n\n";
					clt_msg = clt_msg + "You will need a working headset to have a voice chat with the candidate\n\n";
					clt_msg = clt_msg + "You will need to download or have <a href='http://www.tkqlhce.com/db111ar-xrzEILMHIJHEGFKMLLLI'>Skype(http://www.tkqlhce.com/db111ar-xrzEILMHIJHEGFKMLLLI)</a> on your computer\n\n";
					clt_msg = clt_msg + "If for any reason you cannot come to this meeting or running late please call me on my contact details below to cancel. Cancelled interview is none refundable.\n\n";
					clt_msg = clt_msg + "Should you have any questions about the interview please call me";
					
					document.getElementById('description_id').value = clt_msg;
					//ended message setup
					
					
					//for applicant message setup
					clt_msg = "Dear "+applicant_full_name+",\n\n";
					clt_msg = clt_msg + "Confirming your interview with our client as per our conversation earlier. This is for the  "+sub_category_name+" role.\n\n";
					clt_msg = clt_msg + "Please log in to Skype using the following credentials.\n\n\n";
			
					clt_msg = clt_msg + "User Name:\n";
					clt_msg = clt_msg + "Password:\n\n\n";
			
					clt_msg = clt_msg + "Be online at least 15 minutes ahead and make sure your headset is ready and working.\n\n\n";
			
					clt_msg = clt_msg + "TAKE NOTE:\n\n\n";
					clt_msg = clt_msg + "During the interview, pay (salary) and contract details and set up SHOULD NOT be discussed with the client. If you have any questions regarding this please ask me before or after the interview.\n\n";
					clt_msg = clt_msg + "Failure to show up on confirmed interview schedules will be subject for an evaluation before a reschedule may be granted.\n\n";
					clt_msg = clt_msg + "Remotestaff also has the right to consider your application as BLACKLISTED if you fail to attend succeeding interviews, rescheduled or otherwise, that you have confirmed to.\n\n";
					clt_msg = clt_msg + "If something comes up that will prevent you from attending the interview, please send an advise at least an 30 mins to an hour before the interview schedule and NOT AFTER the schedule has elapsed.\n\n";
					
					document.getElementById('description2_id').value = clt_msg;
					//ended message setup
			}
			else if(document.getElementById('type_id').value == "rschat")
			{
				
				//for client message setup
				var hostname = document.getElementById('hostname').innerHTML
				var now = "upid=" + new Date().getTime();
				
					clt_msg = "Hi "+client_full_name+",\n\n";
					clt_msg = clt_msg + "This is "+creator_name+" from Remote Staff.\n\n";
					clt_msg = clt_msg + "I am writing to confirm your interview with "+applicant_full_name+" on "+date_start+" "+s_hour+":"+start_minute+" "+start_hour_type+" "+time_zone+" time.\n\n";
					clt_msg = clt_msg + "Please note that the interview will happen online on our chat application.\n\n";
					clt_msg = clt_msg + "Please go to "+hostname +"/portal/livechat.php?login=leadrfi&"+now+ " and log in using your Remote Staff user name and password. \n\n\n";
					//clt_msg = clt_msg + "If you have forgotten your password please reset it <a href=" +hostname+ "/portal/forgotpass.php?user=applicantHERE\n\n\n";
			
	
					clt_msg = clt_msg + facilitator_temp_name+" will facilitate the interview.\n\n\n";
					
					clt_msg = clt_msg + "NOTE:\n\n";
					clt_msg = clt_msg + "You will need a working headset to have a voice chat with the candidate\n\n";
					clt_msg = clt_msg + "If for any reason you cannot come to this meeting or running late please call me on my contact details below to cancel. Cancelled interview is none refundable.\n\n";
					clt_msg = clt_msg + "Should you have any questions about the interview please call me";
					
					document.getElementById('description_id').value = clt_msg;
					//ended message setup
				
					//for applicant message setup
					clt_msg = "Dear "+applicant_full_name+",\n\n";
					clt_msg = clt_msg + "Confirming your interview with our client as per our conversation earlier. This is for the "+sub_category_name+" role.\n\n";
					clt_msg = clt_msg + "Please go to "+hostname +"/portal/livechat.php?login=jobseeker&"+now+ " and log in using your jobseeker user name and password.\n";
					clt_msg = clt_msg + "If you have forgotten your password please reset it <a href='" +hostname+ "/portal/forgotpass.php?user=applicant'>HERE</a>\n\n\n";
	
					clt_msg = clt_msg + "Be online at least 15 minutes ahead and make sure your headset is ready and working.\n\n\n";
			
					clt_msg = clt_msg + "TAKE NOTE:\n\n";
					clt_msg = clt_msg + "During the interview, pay (salary) and contract details and set up SHOULD NOT be discussed with the client. If you have any questions regarding this please ask me before or after the interview.\n\n";
					clt_msg = clt_msg + "Failure to show up on confirmed interview schedules will be subject for an evaluation before a reschedule may be granted.\n\n";
					clt_msg = clt_msg + "Remotestaff also has the right to consider your application as BLACKLISTED if you fail to attend succeeding interviews, rescheduled or otherwise, that you have confirmed to.\n\n";
					clt_msg = clt_msg + "If something comes up that will prevent you from attending the interview, please send an advise at least an 30 mins to an hour before the interview schedule and NOT AFTER the schedule has elapsed.\n\n";
					
					document.getElementById('description2_id').value = clt_msg;
					//ended message setup
			}
			else
			{
				document.getElementById('description_id').value = "";
				document.getElementById('description2_id').value = "";
			}
		}
		//ended - skype autoresponder
		
		
		function view_actions(id) 
		{
			previewPath = "action_details.php?id="+id;
			window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		function view_all_actions(id) 
		{
			previewPath = "actions_list.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			
		//ENDED