		//2011-08-15  Roy Pepito <roy.pepito@remotestaff.com.au>

		var active_userid = "";
		var sending_status = "off";
		var staff_mass_email_obj = makeObject();
		var poststr = "";
		var server_response_status = "off";
		
		//START: sending email
			//start: send now
			function send_now(form_obj) 
			{
				document.getElementById('sending_icon').innerHTML = '<img src="images/sending.gif" />';
				poststr = get_form_values(form_obj);
				document.getElementById('action_div').innerHTML = '<INPUT type="button" value="stop" name="stop" style="width:120px" onclick="javascript: stop_sending(this.form); ">';
				setInterval ("sending()", 3000);  
				sending_status = "on";
			}		
			function stop_sending() 
			{
				document.getElementById('sending_icon').innerHTML = '<img src="images/stop.gif" />';
				document.getElementById('action_div').innerHTML = '<INPUT type="button" value="send" name="send" style="width:120px" onclick="javascript: send_now(this.form); ">';
				sending_status = "off";
			}	
			function sending() 
			{
				if(sending_status == "on")
				{
					if(server_response_status == "off")
					{
						server_response_status = "on";
						staff_mass_email_obj.open("POST", 'staff_mass_emailing_sending.php', true);
						staff_mass_email_obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						staff_mass_email_obj.setRequestHeader("Content-length", poststr.length);
						staff_mass_email_obj.setRequestHeader("Connection", "close");
						staff_mass_email_obj.send(poststr);		
						staff_mass_email_obj.onreadystatechange = active_sent_items_loader
					}
				}
			}
			function active_sent_items_loader()
			{
				var data;
				data = staff_mass_email_obj.responseText
				if(staff_mass_email_obj.readyState == 4)
				{
					server_response_status = "off";
					if(data == "COMPLETED")
					{
						document.getElementById('sending_icon').innerHTML = '<img src="images/completed.gif" />';
						document.getElementById('action_div').innerHTML = '<INPUT type="button" value="send" name="send" style="width:120px" onclick="javascript: send_now(this.form); ">';						
						sending_status = "off";						
					}
					else
					{
						//start: update active listings table
						if(data == '')
						{
							//do nothing
						}
						else
						{
							var tbl = document.getElementById('active_sent_items_report');
							var lastRow = tbl.rows.length - 1;
							var contents = lastRow+") ";
							var row = tbl.insertRow(lastRow);
							
								//cell counter
								var cellLeft = row.insertCell(0);
								var textNode = document.createTextNode(contents);
								cellLeft.appendChild(textNode);	
								
								//cell data
								var cellLeft = row.insertCell(1);
								var textNode = document.createTextNode(data);
								cellLeft.appendChild(textNode);	
						}
						//ended: update active listings table		
					}
				}
			}	
			//ended: send now
		//ENDED: sending email			
			
			
		//START: get all post values of ajax
		function get_form_values(fobj)
		{
			var str = "";
			var valueArr = null;
			var val = "";
			var cmd = "";
		
			for(var i = 0;i < fobj.elements.length;i++)
			{
				switch(fobj.elements[i].type)
				{
					case "text":
						str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
						break;
					case "textarea":
						str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
						break;
					case "select-one":
						str += fobj.elements[i].name + "=" + fobj.elements[i].options[fobj.elements[i].selectedIndex].value + "&";
						break;
				}
			}
		
			str = str.substr(0,(str.length - 1));
			return str;
		}		
		//ENDED: get all post values of ajax
		
		
		//START: sent items
		var sent_items_obj = makeObject()
		function search_sent_items(path) 
		{
			var status;
			sent_items_obj.open('get', 'staff_search_items.php?'+path)
			sent_items_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			sent_items_obj.onreadystatechange = sent_items_loader 
			sent_items_obj.send(1)
		}	
		function sent_items_loader()
		{
			var data;
			data = sent_items_obj.responseText
			if(sent_items_obj.readyState == 4)
			{
				document.getElementById('sent_items_div').innerHTML = data;
			}
			else
			{
				document.getElementById("sent_items_pages").innerHTML="<img src='../images/ajax-loader.gif' width=10>&nbsp;Loading...";
			}
		}		
		//ENDED: sent items
		
		
		//START: waiting items
		var waiting_items_obj = makeObject()
		function search_waiting_items(path) 
		{
			var status;
			waiting_items_obj.open('get', 'staff_search_items.php?'+path)
			waiting_items_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			waiting_items_obj.onreadystatechange = waiting_items_loader 
			waiting_items_obj.send(1)
		}	
		function waiting_items_loader()
		{
			var data;
			data = waiting_items_obj.responseText
			if(waiting_items_obj.readyState == 4)
			{
				document.getElementById('waiting_items_div').innerHTML = data;
			}
			else
			{
				document.getElementById("waiting_items_pages").innerHTML="<img src='../images/ajax-loader.gif' width=10>&nbsp;Loading...";
			}
		}		
		//ENDED: waiting items	

